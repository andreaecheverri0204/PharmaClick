<?php
session_start();
// Solo permitimos el acceso si el usuario está logueado (Admin o Técnico)
if($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 2){
    include_once 'layouts/header.php';
?>
    <title>Gestión de Usuarios - PharmaClick</title>
<?php
    include_once 'layouts/nav.php';
?>

<div class="modal fade" id="crearusuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Crear Usuario</h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="alert alert-success text-center" id="add" style="display:none;">
                        <span><i class="fas fa-check m-1"></i>Se ha creado el usuario correctamente!</span>
                    </div>
                    <div class="alert alert-danger text-center" id="noadd" style="display:none;">
                        <span><i class="fas fa-times m-1"></i>El DNI ya existe!</span>
                    </div>

                    <form id="form-crear">
                        <div class="form-group">
                            <label for="nombre">Nombres</label>
                            <input id="nombre" type="text" class="form-control" placeholder="Ingrese nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellidos</label>
                            <input id="apellido" type="text" class="form-control" placeholder="Ingrese apellido" required>
                        </div>
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input id="edad" type="text" class="form-control" placeholder="Ingrese edad" required>
                        </div>
                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input id="dni" type="text" class="form-control" placeholder="Ingrese DNI" required>
                        </div>
                        <div class="form-group">
                            <label for="pass">Contraseña</label>
                            <input id="pass" type="password" class="form-control" placeholder="Ingrese contraseña" required>
                        </div>
                </div>
                <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right m-1">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <input type="hidden" id="tipo_usuario" value="<?php echo $_SESSION['us_tipo']; ?>">

                <div class="alert alert-success text-center" id="borrado" style="display:none;">
                    <span><i class="fas fa-check m-1"></i>El usuario ha sido eliminado correctamente de la base de datos.</span>
                </div>

                <div class="alert alert-danger text-center" id="eliminar-error" style="display:none;">
                    <span><i class="fas fa-times m-1"></i>Error: No tienes permisos o el usuario no pudo ser borrado.</span>
                </div>

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión Usuarios 
                        <?php if($_SESSION['us_tipo'] == 1): ?>
                            <button type="button" data-toggle="modal" data-target="#crearusuario" class="btn bg-gradient-primary ml-3">Crear Nuevo Usuario</button>
                        <?php endif; ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
                        <li class="breadcrumb-item active">Gestión Usuarios</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Buscar Usuario</h3>
                    <div class="input-group">
                        <input type="text" id="buscar" class="form-control float-left" placeholder="Ingrese Nombre del Usuario">
                        <div class="input-group-append">
                            <button class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="usuarios" class="row d-flex align-items-stretch">
                        </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
    include_once 'layouts/footer.php';
?>
<script src="../js/Gestion_usuario.js"></script>
<?php
} else {
    header('Location: ../index.php');
}
?>