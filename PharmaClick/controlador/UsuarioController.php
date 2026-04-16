<?php
include_once '../modelo/Usuario.php';
$usuario = new Usuario();
session_start();

/* comparar que funcion esta realizando*/
if($_POST['funcion']=='buscar_usuario'){
    $json=array();
    $usuario->obtener_datos($_POST['dato']);

    /* for each para recorrer todos los datos*/
    foreach($usuario->objetos as $objeto){
        /*vamos asignarle datos al json*/
        $json[]=array(
            'nombre'=>$objeto->nombre_us,
            'apellidos'=>$objeto->apellidos_us,
            'edad'=>$objeto->edad,
            'dni'=>$objeto->dni_us,
            'tipo'=>$objeto->nombre_tipo,
            'telefono'=>$objeto->telefono_us,
            'residencia'=>$objeto->residencia_us,
            'correo'=>$objeto->correo_us,
            'sexo'=>$objeto->sexo_us,
            'adicional'=>$objeto->adicional_us

            /*contiene todos los datos de la tabla que queremos obtener, despues lo pasamos al js*/
        );
    }
    $jsonString = json_encode($json[0]); 
    echo $jsonString;


}
/* comparar que funcion esta realizando*/
if($_POST['funcion']=='capturar_datos'){
    $json=array();
    $id_usuario=$_POST['id_usuario'];
    $usuario->obtener_datos($id_usuario);
    foreach($usuario->objetos as $objeto){
        $json[]=array(
            'telefono'=>$objeto->telefono_us,
            'residencia'=>$objeto->residencia_us,
            'correo'=>$objeto->correo_us,
            'sexo'=>$objeto->sexo_us,
            'adicional'=>$objeto->adicional_us
        );
    }
    $jsonString = json_encode($json[0]); 
    echo $jsonString; 


}

/* comparar que funcion esta realizando*/
if($_POST['funcion']=='editar_usuario'){
    $id_usuario=$_POST['id_usuario'];
    $telefono=$_POST['telefono'];
    $residencia=$_POST['residencia'];
    $correo=$_POST['correo'];
    $adicional=$_POST['adicional'];
    $usuario->editar($id_usuario,$telefono,$residencia,$correo,$adicional);
    echo 'editado';


}
if($_POST['funcion']=='cambiar_contra'){
    $id_usuario=$_POST['id_usuario'];
    $oldpass=$_POST['oldpass'];
    $newpass=$_POST['newpass'];
    $usuario->cambiar_contra($id_usuario, $oldpass, $newpass);

}

if($_POST['funcion'] == 'buscar_usuarios_adm'){
    $json = array();
    $usuario->buscar(); 
    foreach ($usuario->objetos as $objeto) {
        $json[] = array(
            'id'          => $objeto->id_usuario,
            'nombre'      => $objeto->nombre_us,
            'apellidos'   => $objeto->apellidos_us,
            'dni'         => $objeto->dni_us,
            'tipo'        => $objeto->nombre_tipo, // Cambiado aquí también
            'telefono'    => $objeto->telefono_us,
            'residencia'  => $objeto->residencia_us,
            'adicional'   => $objeto->adicional_us,
            'avatar'      => $objeto->avatar,
            'tipo_sesion' => $_SESSION['us_tipo'] 
        );
    }
    echo json_encode($json);
}

if($_POST['funcion']=='crear_usuario'){
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $edad = $_POST['edad'];
    $dni = $_POST['dni'];
    $pass = $_POST['pass'];
    $tipo = $_POST['tipo'];
    $avatar='avatar-usuarios.png';
    $usuario->crear($nombre, $apellido, $edad, $dni, $pass, $tipo, $avatar);
}


if($_POST['funcion'] == 'eliminar_usuario'){
    session_start();
    $id = $_POST['id'];
    if($_SESSION['us_tipo'] == 1){
        $usuario->eliminar($id);
        echo 'borrado'; // Solo esta palabra
    } else {
        echo 'no_permitido';
    }
}

?>