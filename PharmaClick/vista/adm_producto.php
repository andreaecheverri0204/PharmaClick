<?php
session_start();

if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 2) {
    include_once 'layouts/header.php';
?>

<title>Adm | Gestión Producto</title>
<?php
    include_once 'layouts/nav.php';
?>
<div class="modal fade" id="crearlote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Gestionar Stock: <span id="nombre_producto_lote" class="badge badge-light"></span></h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <form id="form-crear-lote">
                        <input type="hidden" id="id_lote_prod">
                        <div class="form-group">
                            <label for="id_prov">Proveedor</label>
                            <select id="id_prov" class="form-control select2" style="width: 100%"></select>
                        </div>
                        <div class="form-group">
                            <label for="stock_lote">Cantidad de Unidades</label>
                            <input type="number" id="stock_lote" class="form-control" placeholder="Ej: 50" required>
                        </div>
                        <div class="form-group">
                            <label for="vencimiento">Fecha de Vencimiento</label>
                            <input type="date" id="vencimiento" class="form-control" required>
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary">Cancelar</button>
                    <button type="submit" class="btn bg-gradient-success">Guardar Stock</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="crearproducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Crear Producto</h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="alert alert-success text-center" id="add-prod" style="display:none;">
                        <span><i class="fas fa-check m-1"></i>Se agregó correctamente</span>
                    </div>
                    <div class="alert alert-danger text-center" id="noadd-prod" style="display:none;">
                        <span><i class="fas fa-times m-1"></i>El producto ya existe</span>
                    </div>

                    <form id="form-crear-producto">
                        <div class="form-group">
                            <label for="nombre_prod">Nombre</label>
                            <input type="text" id="nombre_prod" class="form-control" placeholder="Ingrese nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="concentracion">Concentración</label>
                            <input type="text" id="concentracion" class="form-control" placeholder="Ingrese concentración">
                        </div>
                        <div class="form-group">
                            <label for="adicional">Adicional</label>
                            <input type="text" id="adicional" class="form-control" placeholder="Ingrese información adicional">
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="number" step="any" id="precio" class="form-control" placeholder="Ingrese precio" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="id_lab">Laboratorio</label>
                            <select id="id_lab" class="form-control select2" style="width: 100%"></select>
                        </div>
                        <div class="form-group">
                            <label for="id_tip">Tipo de Producto</label>
                            <select id="id_tip" class="form-control select2" style="width: 100%"></select>
                        </div>
                        <div class="form-group">
                            <label for="id_pre">Presentación</label>
                            <select id="id_pre" class="form-control select2" style="width: 100%"></select>
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right m-1">Cerrar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión Productos <button type="button" data-toggle="modal" data-target="#crearproducto" class="btn bg-gradient-primary ml-2">Crear Nuevo Producto</button></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
                        <li class="breadcrumb-item active">Gestión Productos</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Buscar Producto</h3>
                    <div class="input-group">
                        <input id="buscar-producto" type="text" class="form-control float-left" placeholder="Ingrese Nombre del Producto">
                        <div class="input-group-append">
                            <button class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="productos" class="row d-flex align-items-stretch"></div>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </section>
</div>

<?php
    include_once 'layouts/footer.php';
} else {
    header('Location: ../index.php');
}
?>

<script src="../js/Producto.js"></script>