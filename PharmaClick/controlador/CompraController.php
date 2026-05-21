<?php
include_once '../modelo/Compra.php';
include_once '../modelo/DetalleCompra.php';
include_once '../modelo/Lote.php';

session_start();

// Validamos que exista una sesión activa
if (!isset($_SESSION['us_tipo'])) {
    echo 'no_session';
    exit();
}

$funcion = $_POST['funcion'];

if ($funcion == 'registrar_compra') {
    $cliente = $_POST['cliente'];
    $dni = $_POST['dni'];
    $total = $_POST['total'];
    $id_usuario = $_SESSION['usuario']; // ID del vendedor en sesión
    $productos = json_decode($_POST['productos']);

    // Instanciamos los modelos correspondientes
    $modeloCompra = new Compra();
    $modeloDetalle = new DetalleCompra();
    $modeloLote = new Lote();

    try {
        // Iniciamos una transacción SQL para asegurar la calidad de los datos (QA)
        $modeloCompra->db->beginTransaction();

        // 1. Registrar la cabecera de la compra
        $id_compra = $modeloCompra->crear_compra($cliente, $dni, $total, $id_usuario);

        if (!$id_compra) {
            throw new Exception("Error al registrar la cabecera de la compra.");
        }

        // 2. Registrar el detalle y descontar stock de los lotes
        foreach ($productos as $prod) {
            $id_producto = $prod->id;
            $cantidad_a_vender = $prod->cantidad;
            $precio_prod = $prod->precio;

            // Buscamos los lotes disponibles para este producto ordenados por vencimiento (PEPS / FIFO)
            // Nota: Asumo que tienes un método similar en tu clase Lote para traer lotes de un producto
            $lotes = $modeloLote->obtener_lotes_por_producto($id_producto);

            foreach ($lotes as $lote) {
                if ($cantidad_a_vender <= 0) break;

                $stock_lote = $lote->stock;
                $id_lote = $lote->id_lote;

                if ($stock_lote > 0) {
                    if ($cantidad_a_vender <= $stock_lote) {
                        // El lote tiene suficiente para cubrir lo que queda de la venta
                        $cantidad_descontar = $cantidad_a_vender;
                        $cantidad_a_vender = 0;
                    } else {
                        // El lote no alcanza por completo, se lleva lo que queda y sigue al siguiente lote
                        $cantidad_descontar = $stock_lote;
                        $cantidad_a_vender -= $stock_lote;
                    }

                    // Reducimos el stock del lote en la Base de Datos
                    $modeloLote->actualizar_stock_lote($id_lote, $cantidad_descontar);

                    // Registramos en el detalle vinculando el lote que se gastó
                    $subtotal_detalle = $precio_prod * $cantidad_descontar;
                    $modeloDetalle->registrar_detalle($id_compra, $id_lote, $cantidad_descontar, $subtotal_detalle);
                }
            }

            // Si después de recorrer los lotes aún queda cantidad por vender, significa que hubo un descuadre de stock
            if ($cantidad_a_vender > 0) {
                throw new Exception("Stock insuficiente para el producto ID: " . $id_producto);
            }
        }

        // Si todo anduvo perfecto, guardamos los cambios definitivamente
        $modeloCompra->db->commit();
        echo 'success';

    } catch (Exception $e) {
        // Si algo falla, revertimos absolutamente todo para evitar registros huérfanos o errores
        $modeloCompra->db->rollBack();
        echo $e->getMessage();
    }
}
?>