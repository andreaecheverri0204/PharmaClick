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
        $sql_base = "SELECT l.id_lote as id_lote, l.stock as stock, l.vencimiento as vencimiento, 
                    p.nombre as nombre, p.concentracion as concentracion, p.adicional as adicional, p.avatar as avatar, 
                    l_lab.nombre as laboratorio, t.nombre as tipo, pre.nombre as presentacion,
                    prov.nombre as proveedor
                    FROM lote l
                    JOIN producto p ON l.lote_id_prod = p.id_producto
                    JOIN laboratorio l_lab ON p.prod_lab = l_lab.id_laboratorio
                    JOIN tipo_producto t ON p.prod_tip_prod = t.id_tip_prod
                    JOIN presentacion pre ON p.prod_present = pre.id_presentacion
                    JOIN proveedor prov ON l.lote_id_prov = prov.id_proveedor";

        
        if (!empty($consulta)) {
            $sql = $sql_base . " WHERE p.nombre LIKE :consulta ORDER BY l.vencimiento ASC";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
        } else {
            $sql = $sql_base . " ORDER BY l.vencimiento ASC LIMIT 25"; 
            $query = $this->acceso->prepare($sql);
            $query->execute();
        }
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }
}
?>