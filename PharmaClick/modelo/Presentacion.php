<?php
include_once 'Conexion.php';

class Presentacion {
    var $objetos;
    private $acceso;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    
    function crear($nombre) {
        
        $nombre = trim($nombre);

        
        if (empty($nombre)) {
            echo 'noadd';
            return;
        }

    
        $sql = "SELECT id_presentacion FROM presentacion WHERE nombre=:nombre";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nombre' => $nombre));
        

        if ($query->rowCount() > 0) {
            echo 'noadd';
        } else {
            $sql = "INSERT INTO presentacion(nombre) VALUES (:nombre)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':nombre' => $nombre));
            echo 'add';
        }
    }

    
    function buscar() {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT * FROM presentacion WHERE nombre LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
            $this->objetos = $query->fetchAll();
        } else {
            
            $sql = "SELECT * FROM presentacion WHERE nombre NOT LIKE '' ORDER BY id_presentacion LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchAll();
        }
        return $this->objetos;
    }

    
function borrar($id) {
        $sql = "DELETE FROM presentacion WHERE id_presentacion=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id));
        
        
        if ($query->rowCount() > 0) {
            echo 'borrado';
        } else {
            echo 'noborrado';
        }
    }
}
?>