<?php
// Limpieza de buffer inicial
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

include_once '../modelo/Compra.php';
include_once '../modelo/Lote.php'; 

session_start();

if (!isset($_SESSION['us_tipo'])) {
    while (ob_get_level() > 0) ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'msg' => 'Sesión no válida.']);
    exit();
}

$funcion = $_POST['funcion'] ?? '';

if ($funcion == 'registrar_compra') {
    $cliente = $_POST['cliente'];
    $dni = $_POST['dni'];
    $total = $_POST['total'];
    $id_usuario = $_SESSION['usuario'] ?? ($_SESSION['us_id'] ?? 1); 
    $productos = json_decode($_POST['productos']);

    $modeloCompra = new Compra();
    $modeloLote = new Lote();

    try {
        $modeloCompra->db->beginTransaction();

        foreach ($productos as $prod) {
            $lotes = $modeloLote->obtener_lotes_por_producto($prod->id);
            $stock_total = 0;
            foreach ($lotes as $l) $stock_total += $l->stock;

            if ($prod->cantidad > $stock_total) {
                throw new Exception("El producto '" . $prod->nombre . "' solo tiene " . $stock_total . " unidades disponibles.");
            }

            // Descuento de stock
            $cantidad_a_descontar = $prod->cantidad;
            foreach ($lotes as $l) {
                if ($cantidad_a_descontar <= 0) break;
                $restar = min($cantidad_a_descontar, $l->stock);
                $modeloLote->actualizar_stock_lote($l->id_lote, $restar);
                $cantidad_a_descontar -= $restar;
            }
        }

        $modeloCompra->crear_compra($cliente, $dni, $total, $id_usuario);
        $modeloCompra->db->commit();

        while (ob_get_level() > 0) ob_end_clean();
        echo json_encode(['status' => 'success']);

    } catch (Exception $e) {
        if ($modeloCompra->db->inTransaction()) $modeloCompra->db->rollBack();
        while (ob_get_level() > 0) ob_end_clean();
        echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
    }
}