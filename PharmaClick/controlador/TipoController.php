<?php
include_once '../modelo/Tipo.php';
$tipo = new Tipo();

// Capturamos la función enviada por AJAX
if ($_POST['funcion'] == 'crear') {
    $nombre = $_POST['nombre'];
    $tipo->crear($nombre);
}

if ($_POST['funcion'] == 'buscar') {
    $tipo->buscar();
    $json = array();
    foreach ($tipo->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id_tip_prod,
            'nombre' => $objeto->nombre
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'borrar') {
    $id = $_POST['id'];
    $tipo->borrar($id);
}
?>