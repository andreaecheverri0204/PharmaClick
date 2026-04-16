$(document).ready(function () {
    // 1. Cargar datos iniciales
    rellenar_laboratorios();
    rellenar_tipos();
    rellenar_presentaciones();
    buscar_producto();

    // --- SECCIÓN: CARGA DE SELECTORES (MODAL CREAR PRODUCTO) ---

// Dentro de $(document).ready(function () {...})

function rellenar_laboratorios() {
    let funcion = 'rellenar_laboratorios';
    $.post('../controlador/ProductoController.php', { funcion }, (response) => {
        try {
            const laboratorios = JSON.parse(response);
            let template = '<option value="" selected disabled>Seleccione Laboratorio</option>';
            laboratorios.forEach(lab => {
                template += `<option value="${lab.id}">${lab.nombre}</option>`;
            });
            $('#id_lab').html(template).trigger('change'); // El trigger es vital para Select2
        } catch (e) {
            console.error("Error en laboratorios: ", response);
        }
    });
}

// Repite el .trigger('change') para tipos e id_pre
function rellenar_tipos() {
    let funcion = 'rellenar_tipos';
    $.post('../controlador/ProductoController.php', { funcion }, (response) => {
        const tipos = JSON.parse(response);
        let template = '';
        tipos.forEach(tipo => {
            template += `<option value="${tipo.id}">${tipo.nombre}</option>`;
        });
        $('#id_tip').html(template);
    });
}

function rellenar_presentaciones() {
    let funcion = 'rellenar_presentaciones';
    $.post('../controlador/ProductoController.php', { funcion }, (response) => {
        const presentaciones = JSON.parse(response);
        let template = '';
        presentaciones.forEach(pre => {
            template += `<option value="${pre.id}">${pre.nombre}</option>`;
        });
        $('#id_pre').html(template);
    });
}

    // --- SECCIÓN: BÚSQUEDA Y LISTADO ---

function buscar_producto(consulta) {
    let funcion = 'buscar';
    $.post('../controlador/ProductoController.php', { funcion, consulta }, (response) => {
        const productos = JSON.parse(response);
        let template = '';
        productos.forEach(prod => {
            template += `
            <div prodId="${prod.id}" prodNombre="${prod.nombre}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                        <i class="fas fa-warehouse mr-1"></i>Stock: <span class="badge badge-success">${prod.stock}</span>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-7">
                                <h2 class="lead"><b>${prod.nombre}</b></h2>
                                <p class="text-muted text-sm"><b>Concentración: </b>${prod.concentracion}</p>
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li class="small"><span class="fa-li"><i class="fas fa-flask"></i></span> Lab: ${prod.laboratorio}</li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-copyright"></i></span> Tipo: ${prod.tipo}</li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-pills"></i></span> Presentación: ${prod.presentacion}</li>
                                </ul>
                            </div>
                            <div class="col-5 text-center">
                                <img src="${prod.avatar}" alt="" class="img-circle img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="lote btn btn-sm btn-primary" title="Editar Stock/Agregar Lote" data-toggle="modal" data-target="#crearlote">
                            <i class="fas fa-plus-square"></i>
                        </button>
                        <button class="borrar btn btn-sm btn-danger" title="Eliminar Producto">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>`;
        });
        $('#productos').html(template);
    });
}

    $(document).on('keyup', '#buscar-producto', function() {
        let valor = $(this).val();
        if (valor != "") {
            buscar_producto(valor);
        } else {
            buscar_producto();
        }
    });

    // --- SECCIÓN: CREACIÓN DE PRODUCTO ---

    $('#form-crear-producto').submit(e => {
        let nombre = $('#nombre_prod').val();
        let concentracion = $('#concentracion').val();
        let adicional = $('#adicional').val();
        let precio = $('#precio').val();
        let laboratorio = $('#id_lab').val();
        let tipo = $('#id_tip').val();
        let presentacion = $('#id_pre').val();
        let funcion = 'crear';

        $.post('../controlador/ProductoController.php', {
            funcion, nombre, concentracion, adicional, precio, laboratorio, tipo, presentacion
        }, (response) => {
            if (response.trim() == 'add') {
                $('#add-prod').hide('slow').show('slow').delay(2000).hide('slow');
                $('#form-crear-producto').trigger('reset');
                buscar_producto();
            } else {
                $('#noadd-prod').hide('slow').show('slow').delay(2000).hide('slow');
            }
        });
        e.preventDefault();
    });

    // --- SECCIÓN: GESTIÓN DE LOTES ---

// --- CARGAR PROVEEDORES EN EL MODAL ---
function rellenar_proveedores() {
    let funcion = 'rellenar_proveedores';
    $.post('../controlador/ProductoController.php', { funcion }, (response) => {
        const proveedores = JSON.parse(response);
        let template = '<option value="" selected disabled>Seleccione un proveedor</option>';
        proveedores.forEach(prov => {
            template += `<option value="${prov.id}">${prov.nombre}</option>`;
        });
        // IMPORTANTE: El ID debe coincidir con el del SELECT en el HTML
        $('#id_prov').html(template); 
    });
}

// --- CARGAR PROVEEDORES EN EL MODAL ---
function rellenar_proveedores() {
    let funcion = 'rellenar_proveedores';
    $.post('../controlador/ProductoController.php', { funcion }, (response) => {
        const proveedores = JSON.parse(response);
        let template = '<option value="" selected disabled>Seleccione un proveedor</option>';
        proveedores.forEach(prov => {
            template += `<option value="${prov.id}">${prov.nombre}</option>`;
        });
        // IMPORTANTE: El ID debe coincidir con el del SELECT en el HTML
        $('#id_prov').html(template); 
    });
}

// --- EVENTO PARA ABRIR EL MODAL Y CARGAR DATOS ---
$(document).on('click', '.lote', (e) => {
    const elemento = $(e.currentTarget).closest('.col-12');
    const id = $(elemento).attr('prodId');
    const nombre = $(elemento).attr('prodNombre');
    
    $('#id_lote_prod').val(id);
    $('#nombre_producto_lote').text(nombre);
    
    // Llamamos a la función de proveedores cada vez que se abre el modal
    rellenar_proveedores();
});

// --- CERRAR Y LIMPIAR MODAL ---
// Esto asegura que si el usuario cierra el modal, los datos no se queden ahí
$('[data-dismiss="modal"]').click(function() {
    $('#form-crear-lote').trigger('reset');
});

// --- CERRAR Y LIMPIAR MODAL ---
// Esto asegura que si el usuario cierra el modal, los datos no se queden ahí
$('[data-dismiss="modal"]').click(function() {
    $('#form-crear-lote').trigger('reset');
});
// A. Al hacer clic en el botón '+' de la card, pasamos el ID al modal
$(document).on('click', '.lote', (e) => {
    const elemento = $(e.currentTarget).closest('.col-12');
    const id = $(elemento).attr('prodId');
    const nombre = $(elemento).attr('prodNombre');
    
    $('#id_lote_prod').val(id); // Input oculto en tu modal
    $('#nombre_producto_lote').text(nombre); // Título para saber qué editas
    rellenar_proveedores(); // Carga la lista de proveedores
});

// B. Envío del formulario del modal
$('#form-crear-lote').submit(e => {
    let id_prod = $('#id_lote_prod').val();
    let id_prov = $('#id_prov').val();
    let stock = $('#stock_lote').val();
    let vencimiento = $('#vencimiento').val();
    let funcion = 'crear_lote';

    $.post('../controlador/ProductoController.php', {
        funcion, id_prod, id_prov, stock, vencimiento
    }, (response) => {
        if (response.trim() == 'add-lote') {
            $('#add-lote-success').hide('slow').show('slow').delay(2000).hide('slow');
            $('#form-crear-lote').trigger('reset');
            buscar_producto(); // Esto refresca el stock en la card automáticamente
        }
    });
    e.preventDefault();
});

    // --- SECCIÓN: ELIMINAR (CONFIRMACIÓN NATIVA) ---

    $(document).on('click', '.borrar', (e) => {
        const elemento = $(e.currentTarget).closest('.col-12');
        const id = $(elemento).attr('prodId');
        const nombre = $(elemento).find('h2 b').text();
        const funcion = 'borrar';

        if (confirm('¿Desea eliminar el producto ' + nombre + '?')) {
            $.post('../controlador/ProductoController.php', { id, funcion }, (response) => {
                let respuesta = response.trim();
                if (respuesta === 'borrado') {
                    alert('El producto ha sido eliminado correctamente.');
                    buscar_producto(); 
                } else {
                    alert('No se pudo eliminar: ' + respuesta);
                }
            });
        }
    });
});