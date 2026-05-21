<?php
session_start();
// Filtro de seguridad: solo Admins (tipo 1 y 3) pueden entrar
if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 2) {
    include_once 'layouts/header.php';
?>

<title>Adm | Gestión Proveedores</title>

<?php
    include_once 'layouts/nav.php';
?>

<div class="modal fade" id="crear_proveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Crear Nuevo Proveedor</h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="alert alert-success text-center" id="add-prov" style="display:none;">
                        <span><i class="fas fa-check m-1"></i>Se agregó correctamente</span>
                    </div>
                    <div class="alert alert-danger text-center" id="noadd-prov" style="display:none;">
                        <span><i class="fas fa-times m-1"></i>El proveedor ya existe</span>
                    </div>

                    <form id="form-crear-proveedor">
                        <div class="form-group">
                            <label for="nombre_prov">Nombre</label>
                            <input type="text" id="nombre_prov" class="form-control" placeholder="Ingrese nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono_prov">Teléfono</label>
                            <input type="number" id="telefono_prov" class="form-control" placeholder="Ingrese teléfono" required>
                        </div>
                        <div class="form-group">
                            <label for="correo_prov">Correo Electrónico</label>
                            <input type="email" id="correo_prov" class="form-control" placeholder="Ingrese correo" required>
                        </div>
                        <div class="form-group">
                            <label for="direccion_prov">Dirección</label>
                            <input type="text" id="direccion_prov" class="form-control" placeholder="Ingrese dirección" required>
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn bg-gradient-primary float-right m-1">Crear Proveedor</button>
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
                    <h1 class="display-5 font-weight-bold">
                        
                        Gestión Proveedores
                        <button type="button" data-toggle="modal" data-target="#crear_proveedor" class="btn bg-gradient-primary ml-2">Crear Nuevo Proveedor</button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
                        <li class="breadcrumb-item active">Gestión Proveedores</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Buscar Proveedor</h3>
                    <div class="input-group">
                        <input id="buscar-proveedor" type="text" class="form-control float-left" placeholder="Ingrese Nombre del Proveedor">
                        <div class="input-group-append">
                            <button class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="proveedores" class="row d-flex align-items-stretch"></div>
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

<script src="../js/Proveedor.js"></script>