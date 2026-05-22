<?php
session_start();
if($_SESSION['us_tipo']==1||$_SESSION['us_tipo']==3){
    include_once 'layouts/header.php';
?>
<!-- SI ES ADMIN MUESTRA LA PAGINA -->
    
    <title>Modficiar Informacion</title>
    <!-- Tell the browser to be responsive to screen width -->
    <?php
    include_once 'layouts/nav.php';

    ?>

    <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="cambiocontra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambiar Contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
        </div>
        <div class="modal-body">
            <!-- Aqui vamos a mostrar la imagen de perfil, despues de darle click al boton de Cambiar Password-->
            <div class="text-center">
                <img src="../img/usuario.png" class="profile-user-img img-fluid img-circle">
            </div>
            <!-- Aqui vamos a mostrar el nombre, en la pestaña que se despliega despues de darle click al boton de Cambiar Password-->
            <div class="text-center">
                <b>
                    <?php
                        echo $_SESSION['nombre_us'];
                    ?>
                </b>
            </div>
                <div class="alert alert-success text-center" id="update" style="display:none;">
                    <span><i class="fas fa-check m-1"></i>Se ha cambiado la contraseña correctamente</span>
                </div>
                <div class="alert alert-danger text-center" id="noupdate" style="display:none;">
                    <span><i class="fas fa-times m-1"></i>No se ha podido cambiar la contraseña</span>
                </div>
            <form id="form-pass" >
                <dib class="input-group mb-3 ">
                <div class="input-group-prepend">
                    <!-- Aqui vamos a mostrar un candado con el boton de Cambiar Password-->
                    <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                </div>
                <input id="oldpass" type="password" class="form-control" placeholder="Ingrese su contraseña actual">
                </dib>
                <dib class="input-group mb-3">
                <div class="input-group-prepend">
                    <!-- Aqui vamos a mostrar un candado con el boton de Cambiar Password-->
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                <input id="newpass" type="text" class="form-control" placeholder="Ingrese su contraseña nueva">
                </dib>
                
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn bg-gradient-primary">Guardar Cambios</button>
            </form>
        </div>
    </div>
    </div>
</div>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Datos Personales</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Home</a></li>
                <li class="breadcrumb-item active">Datos Personales</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <section>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!--QUIERE DECIR QUE VA OCUPAR 3 COLUMNAS-->
                        <div class="col-md-3">
                            <!--Success color verde, una linea debajo del titulo datos personales-->
                            <div class=" card card-success card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img src="../img/usuario.png" class="profile-user-img img-fluid img-circle">
                                    </div>
                                    <!--<div class="mt-1 text-center">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cambiophoto"> Cambiar Avatar</button>
                                    </div>-->

                                    <!-- hidden osea que va estar oculto este es para llamar la informacion de la base de datos
                                    y la pueda mostrar en el front-->
                                    <input id ="id_usuario"type="hidden" value="<?php echo $_SESSION['usuario']?>">


                                    <h3 id="nombre_us" class="profile-username text-center text-success"> Nombre </h3>
                                        <!-- que se vea como gris-->
                                        <p  id="apellido_us" class="text-muted text-center">Apellidos</p>
                                        <ul class="list-group list-group-unbordered mb-3"> <!--Quitamos el contorno de B, con unbordered-->
                                            <li class="list-group-item">
                                                <!-- etiqueta B para que el texto sea negrito-->
                                                    <b style="color:#0B7300">Edad</b> <a id="edad" class="float-right">19</a>
                                            </li>
                                            <li class="list-group-item">
                                                <!-- etiqueta B para que el texto sea negrito-->
                                                    <b style="color:#0B7300">Dni</b> <a id="dni_us" class="float-right">19</a>
                                            </li>
                                            <li class="list-group-item">
                                                <!-- etiqueta B para que el texto sea negrito-->
                                                    <b style="color:#0B7300">Tipo de Usuario</b> 
                                                    <!--Que tenga como un color azul, es como una insignia-->
                                                    <span id="us_tipo" class="float-right badge badge-primary">Administrador</span>
                                            </li>
                                            <button  data-toggle="modal" data-target="#cambiocontra" type="button" class="col-sm-10 btn btn-block btn bg-gradient-primary btn-sm">Cambiar Password</button>
                                        </ul>
                                </div>
                            </div>
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Sobre Mi</h3>
                                </div>
                                <div class="card-body">
                                    <strong>
                                        <i class="fas fa-phone mr-1"></i>Telefono
                                    </strong>
                                    <p id="telefono_us" class="text-muted">3234839297</p>
                                    <strong>
                                    <i class="fas fa-map-marker-alt mr-1"></i>Residencia
                                    </strong>
                                    <p id="residencia_us" class="text-muted">Calle 96 # 46-16</p>
                                    <strong>
                                        <i class="fas fa-at mr-1"></i>Correo
                                    </strong>
                                    <p id="correo_us" class="text-muted">paoecheverri1973@gmail.com</p>
                                    <strong>
                                    <i class="fas fa-smile mr-1"></i>Sexo
                                    </strong>
                                    <p id="sexo_us" class="text-muted">Femenino</p>
                                    <strong>
                                        <i class="fas fa-pencil mr-1"></i>Agregar Informacion
                                    </strong>
                                    <p id="adicional_us" class="text-muted">Hi</p>
                                    <button type="button" class="edit btn btn-block bg-gradient-danger">Editar Informacion</button>
                                </div>
                                
                                <div class="card-footer">
                                    <p class="text-muted">Si desea modificar su Informacion por favor haga click en el boton de editar  </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Editar Mis Datos Personales</h3>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-success text-center" id="editado" style="display:none;">
                                        <span><i class="fas fa-check m-1"></i>Se ha editado con exito la informacion</span>
                                    </div>
                                    <div class="alert alert-danger text-center" id="noeditado" style="display:none;">
                                        <span><i class="fas fa-times m-1"></i>No se ha podido editar la informacion</span>
                                    </div>
                                    <form id="form-usuario" class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
                                            <div class="col-sm-10">
                                                <input type="number" id="telefono" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="residencia" class="col-sm-2 col-form-label">Residencia</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="residencia" class="form-control">
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label for="correo" class="col-sm-2 col-form-label">Correo</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="correo" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="adicional" class="col-sm-2 col-form-label">Informacion Adicional</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="adicional" cols="30" rows ="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10 float-right">
                                                <button type="submit" class="btn btn-block btn-outline-success">Guardar Informacion</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <p class="text-muted">Por favor no ingrese datos erroneos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->



<?php
    include_once 'layouts/footer.php'; 
?>
<script src="../js/Usuario.js"></script>
<?php
}
else{
    header('Location: ../index.php');
}
?>



