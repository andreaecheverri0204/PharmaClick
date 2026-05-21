<?php
include_once '../modelo/Venta.php';
$venta = new Venta();
$funcion = $_POST['funcion'] ?? '';

switch ($funcion) {
    case 'listar_ventas':
        echo json_encode($venta->listar_ventas());
        break;
    case 'borrar_venta':
        echo $venta->borrar_venta($_POST['id_venta']);
        break;
}