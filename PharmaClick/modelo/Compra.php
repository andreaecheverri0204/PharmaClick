<?php
include_once 'Conexion.php';

class Compra {
    private $acceso;
    public $db;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
        $this->db = $this->acceso; // Compartimos la conexión para manejar la transacción desde el controlador
    }

    public function crear_compra($cliente, $dni, $total, $id_usuario) {
        // Ajusta los nombres de tus campos si difieren en tu tabla de Base de Datos
        $sql = "INSERT INTO venta(fecha, cliente, dni, total, id_vendedor) VALUES(NOW(), :cliente, :dni, :total, :id_usuario)";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':cliente' => $cliente,
            ':dni' => $dni,
            ':total' => $total,
            ':id_usuario' => $id_usuario
        ));
        // Retornamos el ID autogenerado de esta venta para usarlo en el detalle
        return $this->acceso->lastInsertId();
    }
}
?>