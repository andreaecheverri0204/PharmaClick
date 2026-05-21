<?php
session_start();
if($_SESSION['us_tipo']==1){
    include_once 'layouts/header.php';
?>
    <title>PharmaClick | Catálogo</title>
<?php
    include_once 'layouts/nav.php';
?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catálogo</h1>
                    </div>
                    <div class="col-sm-6">
                        <ul class="navbar-nav ml-auto" style="flex-direction: row; justify-content: flex-end;">
                            <li class="nav-item dropdown">
                                <a class="nav-link" data-toggle="dropdown" href="#" id="pestaña-carrito" style="position: relative; padding-right: 15px;">
                                    <i class="fas fa-shopping-cart" style="font-size: 22px; color: #333;"></i>
                                    <span id="contador-carrito" class="badge badge-danger navbar-badge" style="position: absolute; top: -5px; right: 2px; font-size: 11px; padding: 2px 6px; border-radius: 50%;">0</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 550px; padding: 0; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: none;">
                                    <div class="dropdown-header text-center font-weight-bold" style="background-color: #EFEAE4; color: #333;">
                                        PRODUCTOS EN CARRITO
                                    </div>
                                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                        <table class="table table-hover text-nowrap mb-0" style="font-size: 13px;">
                                            <thead style="background-color: #f4f6f9; color: #333;">
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Concentración</th>
                                                    <th>Adicional</th>
                                                    <th>Cantidad</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tbody id="lista-carrito">
                                                </tbody>
                                        </table>
                                    </div>
                                    <div class="p-2" style="background-color: #f8f9fa; border-top: 1px solid #eee;">
                                        <button id="procesar-compra" class="btn btn-danger btn-block btn-sm mb-1" style="background-color: #dc3545; border: none;">
                                            <i class="fas fa-check-circle mr-1"></i>Procesar Compra
                                        </button>
                                        <button id="vaciar-carrito" class="btn btn-primary btn-block btn-sm" style="background-color: #007bff; border: none;">
                                            <i class="fas fa-trash-alt mr-1"></i>Vaciar carrito
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                
                <div class="card card-info" style="border-top: 3px solid #D2C1B0;">
                    <div class="card-header" style="background-color: #D2C1B0; color: #333;">
                        <h3 class="card-title text-bold">Lotes en riesgo</h3>
                    </div>
                    <div class="card-body p-0 table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover text-nowrap mb-0">
                            <thead style="background-color: #EFEAE4; color: #333;">
                                <tr>
                                    <th>Cod</th>
                                    <th>Producto</th>
                                    <th>Stock</th>
                                    <th>Laboratorio</th>
                                    <th>Presentación</th>
                                    <th>Proveedor</th>
                                    <th>Días para Vencer</th>
                                </tr>
                            </thead>
                            <tbody id="lotes-riesgo">
                                </tbody>
                        </table>
                    </div>
                </div>

                <div class="card card-success mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Buscar producto</h3>
                        <div class="input-group">
                            <input id="buscar-producto" type="text" class="form-control float-left" placeholder="Ingrese nombre de producto">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="productos-catalogo" class="row d-flex align-items-stretch">
                            </div>
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
<script src="../js/catalogo.js"></script>