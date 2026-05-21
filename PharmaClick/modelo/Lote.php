<?php
include_once 'Conexion.php';

class Lote {
    var $objetos;
    private $acceso;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    function buscar($consulta = null) {
        // Usamos LEFT JOIN para que si algún campo está vacío, la consulta no se rompa y devuelva los datos de igual forma
        $sql_base = "SELECT l.id_lote as id_lote, l.stock as stock, l.vencimiento as vencimiento, 
                    p.nombre as nombre, p.concentracion as concentracion, p.adicional as adicional, p.avatar as avatar, 
                    l_lab.nombre as laboratorio, t.nombre as tipo, pre.nombre as presentacion,
                    prov.nombre as proveedor
                    FROM lote l
                    JOIN producto p ON l.lote_id_prod = p.id_producto
                    LEFT JOIN laboratorio l_lab ON p.prod_lab = l_lab.id_laboratorio
                    LEFT JOIN tipo_producto t ON p.prod_tip_prod = t.id_tip_prod
                    LEFT JOIN presentacion pre ON p.prod_present = pre.id_presentacion
                    LEFT JOIN proveedor prov ON l.lote_id_prov = prov.id_proveedor";

        if (!empty($consulta)) {
            $sql = $sql_base . " WHERE p.nombre LIKE :consulta ORDER BY l.vencimiento ASC";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
        } else {
            // Quitamos el LIMIT 25 para asegurarnos de que en el catálogo se listen todos los lotes en riesgo correctamente
            $sql = $sql_base . " ORDER BY l.vencimiento ASC"; 
            $query = $this->acceso->prepare($sql);
            $query->execute();
        }
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    function editar($id_lote, $stock) {
        $sql = "UPDATE lote SET stock = :stock WHERE id_lote = :id_lote";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':stock' => $stock,
            ':id_lote' => $id_lote
        ));
    }

    function borrar($id_lote) {
        $sql = "DELETE FROM lote WHERE id_lote = :id_lote";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_lote' => $id_lote));
    }
    public function obtener_lotes_por_producto($id_producto) {
    // Buscamos los lotes que pertenezcan al producto y tengan stock, ordenando para vencer primero (PEPS)
    $sql = "SELECT id_lote, stock FROM lote WHERE id_producto = :id_producto AND stock > 0 ORDER BY vencimiento ASC";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id_producto' => $id_producto));
    return $query->fetchAll(PDO::FETCH_OBJ);
}

public function actualizar_stock_lote($id_lote, $cantidad) {
    $sql = "UPDATE lote SET stock = stock - :cantidad WHERE id_lote = :id_lote";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(
        ':cantidad' => $cantidad,
        ':id_lote' => $id_lote
    ));
}
} 
?>