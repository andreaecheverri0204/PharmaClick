<?php
include_once '../modelo/Producto.php';
$producto = new Producto();

if ($_POST['funcion'] == 'buscar') {
    $consulta = isset($_POST['consulta']) ? $_POST['consulta'] : '';
    $producto->buscar($consulta);
    $json = array();
    foreach ($producto->objetos as $objeto) {
        $json[] = array(
            'id'            => $objeto->id,
            'nombre'        => $objeto->nombre,
            'concentracion' => $objeto->concentracion,
            'adicional'     => $objeto->adicional,
            'precio'        => $objeto->precio,
            'avatar'        => '../img/' . $objeto->avatar,
            'laboratorio'   => $objeto->laboratorio,
            'tipo'          => $objeto->tipo,
            'presentacion'  => $objeto->presentacion,
            'stock'         => $objeto->stock
        );
    }
    echo json_encode($json);
}

if ($_POST['funcion'] == 'rellenar_proveedores') {
    $producto->rellenar_proveedores();
    $json = array();
    foreach ($producto->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id_proveedor, // Verifica que sea id_proveedor en tu DB
            'nombre' => $objeto->nombre
        );
    }
    echo json_encode($json);
}


if ($_POST['funcion'] == 'crear_lote') {
    $id_prod = $_POST['id_prod'];
    $id_prov = $_POST['id_prov'];
    $stock = $_POST['stock'];
    $vencimiento = $_POST['vencimiento'];
    
    $producto->crear_lote($id_prod, $id_prov, $stock, $vencimiento);
}

if ($_POST['funcion'] == 'borrar') {
    // 1. Recibimos el ID desde el JavaScript
    $id = $_POST['id'];
    
    // 2. Ejecutamos la función del modelo
    $producto->borrar($id);
}
// Al final de tu archivo ProductoController.php
if ($_POST['funcion'] == 'rellenar_laboratorios') {
    $producto->rellenar_laboratorios();
    $json = array();
    foreach ($producto->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id_laboratorio,
            'nombre' => $objeto->nombre
        );
    }
    echo json_encode($json);
}

if ($_POST['funcion'] == 'rellenar_tipos') {
    $producto->rellenar_tipos();
    $json = array();
    foreach ($producto->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id_tip_prod,
            'nombre' => $objeto->nombre
        );
    }
    echo json_encode($json);
}

if ($_POST['funcion'] == 'rellenar_presentaciones') {
    $producto->rellenar_presentaciones();
    $json = array();
    foreach ($producto->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id_presentacion,
            'nombre' => $objeto->nombre
        );
    }
    echo json_encode($json);
}
if ($_POST['funcion'] == 'crear') {
    $nombre = $_POST['nombre'];
    $concentracion = $_POST['concentracion'];
    $adicional = $_POST['adicional'];
    $precio = $_POST['precio'];
    $laboratorio = $_POST['laboratorio'];
    $tipo = $_POST['tipo'];
    $presentacion = $_POST['presentacion'];
    $avatar = 'Productos.png'; 
    $producto->crear($nombre, $concentracion, $adicional, $precio, $laboratorio, $tipo, $presentacion, $avatar);
}
?>