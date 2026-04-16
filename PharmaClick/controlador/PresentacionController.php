<?php
include_once '../modelo/Presentacion.php';
$presentacion = new Presentacion();

if ($_POST['funcion'] == 'crear') {
    $nombre = $_POST['nombre']; // Asegúrate que el JS envíe 'nombre'
    $presentacion->crear($nombre);
}

if ($_POST['funcion'] == 'buscar') {
    $consulta = isset($_POST['consulta']) ? $_POST['consulta'] : '';
    $presentacion->buscar($consulta);
    $json = array();
    foreach ($presentacion->objetos as $objeto) {
        $json[] = array(
            'id'     => $objeto->id_presentacion, // <-- ESTO ES "id" PARA EL JS
            'nombre' => $objeto->nombre
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring; // UN SOLO ECHO EN TODO EL ARCHIVO
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'borrar') {
    $id = $_POST['id'];
    $presentacion->borrar($id);
    // El modelo ya hace el echo 'borrado', no pongas nada más aquí.
}



?>