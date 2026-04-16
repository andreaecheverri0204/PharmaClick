<?php
include_once 'Conexion.php';

class Producto {
    var $objetos;
    private $acceso;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }
function buscar($consulta = null) {

    $sql_base = "SELECT p.id_producto as id, p.nombre as nombre, concentracion, adicional, precio, p.avatar as avatar, 
                l_lab.nombre as laboratorio, t.nombre as tipo, pre.nombre as presentacion,
                IFNULL(SUM(l.stock), 0) as stock
                FROM producto p
                LEFT JOIN laboratorio l_lab ON p.prod_lab = l_lab.id_laboratorio
                LEFT JOIN tipo_producto t ON p.prod_tip_prod = t.id_tip_prod
                LEFT JOIN presentacion pre ON p.prod_present = pre.id_presentacion
                LEFT JOIN lote l ON p.id_producto = l.lote_id_prod";

    if (!empty($consulta)) {
        $sql = $sql_base . " WHERE p.nombre LIKE :consulta GROUP BY p.id_producto ORDER BY p.nombre LIMIT 25";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':consulta' => "%$consulta%"));
    } else {
        $sql = $sql_base . " GROUP BY p.id_producto ORDER BY p.nombre LIMIT 25";
        $query = $this->acceso->prepare($sql);
        $query->execute();
    }
    $this->objetos = $query->fetchAll();
    return $this->objetos;
}

function crear($nombre, $concentracion, $adicional, $precio, $laboratorio, $tipo, $presentacion, $avatar) {
    // Validamos si el producto existe antes de insertar
    $sql = "SELECT id_producto FROM producto WHERE nombre=:nombre AND concentracion=:concentracion AND adicional=:adicional";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':nombre'=>$nombre, ':concentracion'=>$concentracion, ':adicional'=>$adicional));
    $prod_existente = $query->fetchAll();

    if(!empty($prod_existente)){
        echo 'noadd'; 
    } else {
        $sql="INSERT INTO producto(nombre, concentracion, adicional, precio, prod_lab, prod_tip_prod, prod_present, avatar) 
                VALUES (:nombre, :concentracion, :adicional, :precio, :laboratorio, :tipo, :presentacion, :avatar)";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':nombre'=>$nombre, ':concentracion'=>$concentracion, ':adicional'=>$adicional,
            ':precio'=>$precio, ':laboratorio'=>$laboratorio, ':tipo'=>$tipo, 
            ':presentacion'=>$presentacion, ':avatar'=>$avatar
        ));
        echo 'add';
    }
}

    function rellenar_laboratorios() {
        $sql = "SELECT * FROM laboratorio ORDER BY nombre ASC";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    function rellenar_tipos() {
        $sql = "SELECT * FROM tipo_producto ORDER BY nombre ASC";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    function rellenar_presentaciones() {
        $sql = "SELECT * FROM presentacion ORDER BY nombre ASC";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    function rellenar_proveedores() {
        $sql = "SELECT id_proveedor, nombre FROM proveedor ORDER BY nombre ASC";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    function borrar($id) {
        $sql = "DELETE FROM producto WHERE id_producto = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id));
        if ($query->rowCount() > 0) {
            echo 'borrado';
        } else {
            echo 'no-borrado';
        }
    }
    function crear_lote($id_prod, $id_prov, $stock, $vencimiento) {
    $sql = "INSERT INTO lote(stock, vencimiento, lote_id_prod, lote_id_prov) 
            VALUES (:stock, :vencimiento, :id_prod, :id_prov)";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(
        ':stock' => $stock,
        ':vencimiento' => $vencimiento,
        ':id_prod' => $id_prod,
        ':id_prov' => $id_prov
    ));
    echo 'add-lote';
}
}
?>