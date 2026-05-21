<?php
include_once '../modelo/Laboratorio.php';
$laboratorio = new Laboratorio();

if (!empty($_POST['funcion']) && $_POST['funcion'] == 'crear') {
    $nombre = $_POST['nombre_laboratorio'];
    $avatar = 'Laboratorios.png';
    
    // 1. Verificamos si el nombre ya existe antes de crear
    $laboratorio->buscar(); // Esto llena $laboratorio->objetos
    $existe = false;
    
    foreach ($laboratorio->objetos as $objeto) {
        if ($objeto->nombre == $nombre) {
            $existe = true;
            break;
        }
    }

    if (!$existe) {
        $laboratorio->crear($nombre, $avatar);
        echo 'add'; // IMPORTANTE: Respondemos al JS que todo salió bien
    } else {
        echo 'noadd'; // Respondemos que ya existe para que el JS muestre la alerta roja
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