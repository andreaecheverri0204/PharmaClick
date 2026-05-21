<?php
session_start();
// Validación de seguridad para asegurar que solo usuarios permitidos (ej. Administrador/Contador) ingresen
if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 3) {
    include_once 'layouts/header.php';
?>
    <title>PharmaClick | Solicitud de Compra</title>
<?php
    include_once 'layouts/nav.php';
?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Solicitud de Compra</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="adm_catalogo.php">Catálogo</a></li>
                            <li class="breadcrumb-item active">Pasarela de Compra</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    
                    <div class="col-md-9">
                        
                        <div class="card card-dark" style="border-top: 3px solid #D2C1B0;">
                            <div class="card-header" style="background-color: #D2C1B0; color: #333;">
                                <h3 class="card-title text-bold"><i class="fas fa-user-check mr-2"></i> Datos del Comprobante</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="nombre-cliente">Cliente</label>
                                        <input type="text" id="nombre-cliente" class="form-control" placeholder="Ingrese nombre del cliente" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="doc-cliente">Documento (DNI / CC)</label>
                                        <input type="text" id="doc-cliente" class="form-control" placeholder="Ingrese documento de identidad" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="vendedor-sesion">Vendedor</label>
                                        <input type="text" id="vendedor-sesion" class="form-control" value="<?php echo $_SESSION['nombre_us']; ?>" readonly style="background-color: #e9ecef; font-weight: bold; color: #495057;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-info mt-3">
                            <div class="card-header bg-info">
                                <h3 class="card-title text-bold"><i class="fas fa-shopping-basket mr-2"></i> Artículos Seleccionados</h3>
                            </div>
                            <div class="card-body p-0 table-responsive" style="max-height: 450px; overflow-y: auto;">
                                <table class="table table-hover text-nowrap mb-0" style="font-size: 14px;">
                                    <thead style="background-color: #f4f6f9; color: #333;">
                                        <tr>
                                            <th>Código</th>
                                            <th>Producto</th>
                                            <th>Concentración</th>
                                            <th>Adicional</th>
                                            <th>Precio Unitario</th>
                                            <th style="width: 100px;">Cantidad</th>
                                            <th>Subtotal</th>
                                            <th style="width: 50px;">Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lista-compra-pasarela">
                                        </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-3">
                        
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title text-bold"><i class="fas fa-calculator mr-2"></i> Resumen de Pago</h3>
                            </div>
                            <div class="card-body">
                                
                                <div class="info-box bg-light shadow-sm mb-2">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-muted small">SUBTOTAL</span>
                                        <span class="info-box-number text-secondary h5 mb-0">$ <span id="subtotal-compra">0.00</span></span>
                                    </div>
                                </div>

                                <div class="info-box bg-light shadow-sm mb-2">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-muted small">IGV / IVA (18%)</span>
                                        <span class="info-box-number text-secondary h5 mb-0">$ <span id="impuesto-compra">0.00</span></span>
                                    </div>
                                </div>

                                <div class="info-box shadow-sm mb-3" style="background-color: #EFEAE4;">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-dark text-bold small">TOTAL A PAGAR</span>
                                        <span class="info-box-number text-success h4 text-bold mb-0">$ <span id="total-compra">0.00</span></span>
                                    </div>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="pago-cliente" class="text-muted small mb-1">INGRESO EFECTIVO:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-weight-bold">$</span>
                                        </div>
                                        <input type="number" id="pago-cliente" class="form-control form-control-lg text-bold text-success" placeholder="0.00" min="0" step="0.01">
                                    </div>
                                </div>

                                <div class="p-2 mb-3 rounded text-center" style="background-color: #f8f9fa; border: 1px dashed #ced4da;">
                                    <span class="text-muted small d-block font-weight-bold">VUELTO:</span>
                                    <span class="h5 text-bold text-primary">$ <span id="vuelto-cliente">0.00</span></span>
                                </div>

                            </div>
                            
                            <div class="card-footer style-none">
                                <button id="realizar-compra" class="btn btn-success btn-block text-bold mb-2 shadow-sm">
                                    <i class="fas fa-check-circle mr-1"></i> Realizar Compra
                                </button>
                                <button id="seguir-comprando" class="btn btn-outline-secondary btn-block btn-sm text-bold">
                                    <i class="fas fa-arrow-left mr-1"></i> Seguir Comprando
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>
    </div>

<?php
    include_once 'layouts/footer.php';
} else {
    // Redirección forzada al login/index si intenta burlar la URL sin permisos correctos
    header('Location: ../index.php');
}
?>

<script src="../js/compra.js"></script>
<script src="../js/adm_compra.js"></script>
