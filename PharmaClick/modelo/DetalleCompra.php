<?php
include_once 'Conexion.php';

class DetalleCompra {
    private $acceso;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    public function registrar_detalle($id_compra, $id_lote, $cantidad) {
        // Ajustado de forma estricta a tus tres columnas reales: id_det_lote y det_cantidad
        $sql = "INSERT INTO detalle_venta(id_det_lote, det_cantidad) VALUES(:id_lote, :cantidad)";
        $query = $this->acceso->prepare($sql);
        
        $query->execute(array(
            ':id_lote'   => $id_lote,
            ':cantidad' => $cantidad
        ));
    }
}
?>