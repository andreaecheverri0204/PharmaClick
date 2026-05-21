<?php
include_once 'Conexion.php';

class DetalleCompra {
    private $acceso;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    public function registrar_detalle($id_compra, $id_lote, $cantidad, $subtotal) {
        $sql = "INSERT INTO detalle_venta(id_venta, id_lote, cantidad, subtotal) VALUES(:id_compra, :id_lote, :cantidad, :subtotal)";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id_compra' => $id_compra,
            ':id_lote' => $id_lote,
            ':cantidad' => $cantidad,
            ':subtotal' => $subtotal
        ));
    }
}
?>