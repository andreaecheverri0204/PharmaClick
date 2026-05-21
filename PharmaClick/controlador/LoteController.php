<?php
include_once '../modelo/Lote.php';
$lote = new Lote();

if ($_POST['funcion'] == 'buscar') {
    $consulta = isset($_POST['consulta']) ? $_POST['consulta'] : '';
    $lote->buscar($consulta);
    $json = array();
    foreach ($lote->objetos as $objeto) {
        $json[] = array(
            'id_lote'       => $objeto->id_lote,
            'nombre'        => $objeto->nombre,
            'concentracion' => $objeto->concentracion,
            'adicional'     => $objeto->adicional,
            'avatar'        => '../img/' . $objeto->avatar,
            'laboratorio'   => $objeto->laboratorio,
            'tipo'          => $objeto->tipo,
            'presentacion'  => $objeto->presentacion,
            'vencimiento'   => $objeto->vencimiento,
            'proveedor'     => $objeto->proveedor,
            'stock'         => $objeto->stock
        );
    }
    echo json_encode($json);    
}

if ($_POST['funcion'] == 'editar') {
    $id_lote = $_POST['id_lote'];
    $stock = $_POST['stock'];
    
    $lote->editar($id_lote, $stock);
    echo 'editado';
}

if ($_POST['funcion'] == 'borrar') {
    $id_lote = $_POST['id_lote'];
    
    $lote->borrar($id_lote);
    echo 'borrado';
}

if ($_POST['funcion'] == 'lote_riesgo') {
    $lote->buscar(''); 
    $json = array();
    foreach ($lote->objetos as $objeto) {
        $json[] = array(
            'id_lote'       => $objeto->id_lote,
            'nombre'        => $objeto->nombre,
            'concentracion' => $objeto->concentracion,
            'adicional'     => $objeto->adicional,
            'avatar'        => '../img/' . $objeto->avatar,
            'laboratorio'   => $objeto->laboratorio,
            'tipo'          => $objeto->tipo,
            'presentacion'  => $objeto->presentacion,
            'vencimiento'   => $objeto->vencimiento,
            'proveedor'     => $objeto->proveedor,
            'stock'         => $objeto->stock
        );
    }
    echo json_encode($json);
}
?>