<?php
session_start();
include_once 'layouts/header.php';
include_once 'layouts/nav.php';
?>

<div class="modal fade" id="editarlote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-editar-lote">
                <div class="card card-success mb-0">
                    <div class="card-header">
                        <h3 class="card-title">Editar Lote</h3>
                        <button type="button" data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success text-center" id="edit-lote" style="display:none;">
                            <span><i class="fas fa-check m-1"></i>Stock modificado con éxito</span>
                        </div>
                        <div class="form-group">
                            <label>Producto: </label>
                            <span id="nombre_producto_lote" class="text-bold"></span>
                        </div>
                        <div class="form-group">
                            <label>Stock actual: </label>
                            <span id="stock_actual" class="badge badge-success"></span>
                        </div>
                        <div class="form-group">
                            <label for="nuevo_stock">Nuevo Stock</label>
                            <input type="number" class="form-control" id="nuevo_stock" placeholder="Ingrese nuevo stock" required min="0">
                        </div>
                        <input type="hidden" id="id_lote_prod">
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-secondary float-left" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-success float-right">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión Lotes</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Buscar Lotes</h3>
                    <div class="input-group">
                        <input id="buscar-lote" type="text" class="form-control float-left" placeholder="Ingrese Nombre del Producto">
                        <div class="input-group-append">
                            <button class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="lotes" class="row d-flex align-items-stretch"></div>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </section>
</div>

<?php
include_once 'layouts/footer.php';
?>
<script src="../js/lote.js"></script>