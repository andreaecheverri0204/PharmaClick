<?php
include_once 'Conexion.php';
class Venta {
    public $acceso;
    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    public function listar_ventas() {
        try {
            // Asegúrate de que los campos 'vendedor' y 'id_usuario' sean correctos
            $sql = "SELECT v.id_venta, v.fecha, v.cliente, v.dni, v.total, u.nombre_us 
                    FROM venta v 
                    JOIN usuario u ON v.vendedor = u.id_usuario 
                    ORDER BY v.id_venta DESC";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return [];
        }
    }


public function borrar_venta($id_venta) {
    try {
        $sql = "DELETE FROM venta WHERE id_venta = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute([':id' => $id_venta]);
        return 'success';
    } catch (PDOException $e) {
        return 'error';
    }
}
}