<?php
include_once 'Conexion.php';

class Proveedor {
    var $objetos;
    private $acceso;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    //  GUARDAR un nuevo proveedor
    function crear($nombre, $telefono, $correo, $direccion, $avatar) {
        //  evitar duplicados por nombre
        $sql = "SELECT id_proveedor FROM proveedor WHERE nombre = :nombre";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nombre' => $nombre));
        $this->objetos = $query->fetchAll();

        if (empty($this->objetos)) {
            
            $sql = "INSERT INTO proveedor(nombre, telefono, correo, direccion, avatar) 
                    VALUES (:nombre, :telefono, :correo, :direccion, :avatar)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':nombre' => $nombre,
                ':telefono' => $telefono,
                ':correo' => $correo,
                ':direccion' => $direccion,
                ':avatar' => $avatar
            ));
            echo 'add'; 
        } else {
            echo 'noadd';
        }
    }

    //  BUSCAR proveedores 
    function buscar() {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            
            $sql = "SELECT * FROM proveedor WHERE nombre LIKE :consulta OR direccion LIKE :consulta LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
        } else {
            
            $sql = "SELECT * FROM proveedor ORDER BY nombre LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
        }
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    
    function borrar($id) {
        $sql = "DELETE FROM proveedor WHERE id_proveedor=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id));
        
        if ($query->rowCount() > 0) {
            echo 'borrado';
        } else {
            echo 'no-borrado';
        }
    }
}
?>