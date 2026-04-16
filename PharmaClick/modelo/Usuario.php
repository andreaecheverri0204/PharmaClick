<?php
include_once 'Conexion.php';
class Usuario{
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }
    function Loguearse($dni, $pass){
        $sql ="SELECT * FROM usuario inner join tipo_us on us_tipo=id_tipo_us  where dni_us=:dni and contrasena_us=:pass";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':dni'=>$dni,':pass'=>$pass));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function obtener_datos($id){
        
        $sql ="SELECT * FROM usuario join tipo_us on us_tipo=id_tipo_us WHERE id_usuario=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }
    function editar($id_usuario,$telefono,$residencia,$correo,$adicional){
        $sql ="UPDATE usuario SET telefono_us=:telefono, residencia_us=:residencia, correo_us=:correo, adicional_us=:adicional where id_usuario=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_usuario, ':telefono'=>$telefono, ':residencia'=>$residencia, ':correo'=>$correo, ':adicional'=>$adicional));
    }

    function cambiar_contra($id_usuario,$oldpass, $newpass){
        $sql ="SELECT * FROM usuario where id_usuario=:id and contrasena_us=:oldpass";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_usuario, ':oldpass'=>$oldpass));
        $this->objetos = $query->fetchall();
        if(!empty($this->objetos)){
            $sql="UPDATE usuario SET contrasena_us=:newpass where id_usuario=:id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id_usuario, ':newpass'=>$newpass));
            echo 'update';
        }
        else{
            echo 'noupdate';
        }
    }

function buscar(){
    if(!empty($_POST['consulta'])){
        $consulta = $_POST['consulta'];
        $sql="SELECT id_usuario, nombre_us, apellidos_us, edad, dni_us, telefono_us, residencia_us, adicional_us, avatar, nombre_tipo, us_tipo 
                FROM usuario 
                JOIN tipo_us ON us_tipo = id_tipo_us 
                WHERE nombre_us LIKE :consulta";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':consulta' => "%$consulta%"));
        $this->objetos=$query->fetchAll();
        return $this->objetos;
    } else {
        
        $sql="SELECT id_usuario, nombre_us, apellidos_us, edad, dni_us, telefono_us, residencia_us, adicional_us, avatar, nombre_tipo, us_tipo 
                FROM usuario 
                JOIN tipo_us ON us_tipo = id_tipo_us 
                ORDER BY id_usuario LIMIT 25";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchAll();
        return $this->objetos;
    }
}

function crear($nombre, $apellido, $edad, $dni, $pass, $tipo, $avatar){
    $sql="SELECT id_usuario FROM usuario WHERE dni_us=:dni";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':dni'=>$dni));
    $this->objetos=$query->fetchAll();

    if(!empty($this->objetos)){
        echo 'noadd';
    }
    else{
        $sql="INSERT INTO usuario(nombre_us, apellidos_us, edad, dni_us, contrasena_us, us_tipo, avatar) 
                VALUES (:nombre, :apellido, :edad, :dni, :pass, :tipo, :avatar)";
        $query = $this->acceso->prepare($sql);
        
        $query->execute(array(
            ':nombre'   => $nombre,
            ':apellido' => $apellido,
            ':edad'     => $edad,
            ':dni'      => $dni,
            ':pass'     => $pass,
            ':tipo'     => $tipo,
            ':avatar'   => $avatar
        ));          
        echo 'add'; 
    }
}

function eliminar($id){
    $sql="DELETE FROM usuario WHERE id_usuario=:id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id'=>$id));
}

}
?>