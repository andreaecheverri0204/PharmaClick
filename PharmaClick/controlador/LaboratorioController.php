<?php
include_once '../modelo/Laboratorio.php';
$laboratorio = new Laboratorio();

if (!empty($_POST['funcion']) && $_POST['funcion'] == 'crear') {
    $nombre = $_POST['nombre_laboratorio'];
    $avatar = 'Laboratorios.png';
    

    $laboratorio->buscar(); 
    $existe = false;
    
    foreach ($laboratorio->objetos as $objeto) {
        if ($objeto->nombre == $nombre) {
            $existe = true;
            break;
        }
    }

    if (!$existe) {
        $laboratorio->crear($nombre, $avatar);
        echo 'add'; 
    } else {
        echo 'noadd'; 
    }
}


if (!empty($_POST['funcion']) && $_POST['funcion'] == 'buscar') {
    $laboratorio->buscar();
    $json = array();
    foreach ($laboratorio->objetos as $objeto) {
        $json[] = array(
            'id'     => $objeto->id_laboratorio,
            'nombre' => $objeto->nombre,
            'avatar' => '../img/Laboratorios.png' 
        );
    }
    echo json_encode($json);
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'borrar') {
    $id = $_POST['id'];
    $laboratorio->borrar($id);
}
?>