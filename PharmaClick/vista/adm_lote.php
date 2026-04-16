<?php
session_start();
include_once 'layouts/header.php';
include_once 'layouts/nav.php';
?>

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
<script src="../js/Lote.js"></script>