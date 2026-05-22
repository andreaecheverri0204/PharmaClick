<?php
include_once '../modelo/Presentacion.php';
$presentacion = new Presentacion();

if ($_POST['funcion'] == 'crear') {
    $nombre = $_POST['nombre']; 
    $presentacion->crear($nombre);
}

if ($_POST['funcion'] == 'buscar') {
    $consulta = isset($_POST['consulta']) ? $_POST['consulta'] : '';
    $presentacion->buscar($consulta);
    $json = array();
    foreach ($presentacion->objetos as $objeto) {
        $json[] = array(
            'id'     => $objeto->id_presentacion, 
            'nombre' => $objeto->nombre
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring; 
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'borrar') {
    $id = $_POST['id'];
    $presentacion->borrar($id);
   
}



?>