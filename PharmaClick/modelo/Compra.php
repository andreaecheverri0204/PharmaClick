<?php
include_once 'Conexion.php';

class Compra {
    private $acceso;
    public $db;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
        $this->db = $db->pdo;
    }

    public function crear_compra($cliente, $dni, $total, $vendedor) {
        try {
            
            $sql = "INSERT INTO venta(cliente, dni, total, vendedor) VALUES(:cliente, :dni, :total, :vendedor)";
            $query = $this->acceso->prepare($sql);
            
            $resultado = $query->execute(array(
                ':cliente' => $cliente,
                ':dni'     => $dni,
                ':total'   => $total,
                ':vendedor'=> $vendedor
            ));

            if ($resultado) {
                return $this->acceso->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>