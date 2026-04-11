<?php
include_once '../modelo/Usuario.php';
$usuario = new Usuario();

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
?>