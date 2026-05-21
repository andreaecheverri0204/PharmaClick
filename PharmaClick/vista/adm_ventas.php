    <?php
    session_start();
    if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 2) {
        include_once 'layouts/header.php';
    ?>
    <title>Historial de Ventas | PharmaClick</title>
    <?php include_once 'layouts/nav.php'; ?>

    <div class="modal fade" id="modal-detalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detalle de Productos Vendidos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <ul id="contenido-detalle" class="list-group">
                </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Historial de Ventas</h1></div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ventas Registradas</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID Venta</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>DNI</th>
                                    <th>Total</th>
                                    <th>Vendedor</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="lista-ventas">
                                </tbody>
                        </table>
                    </div>
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
    <script src="../js/adm_venta.js"></script>