$(document).ready(function () {
    buscar_proveedor();

    $('#form-crear-proveedor').submit(e => {
        let nombre = $('#nombre_prov').val();
        let telefono = $('#telefono_prov').val();
        let correo = $('#correo_prov').val();
        let direccion = $('#direccion_prov').val();
        let funcion = 'crear';

        $.post('../controlador/ProveedorController.php', { funcion, nombre, telefono, correo, direccion }, (response) => {
            let respuesta = response.trim();
            
            if (respuesta == 'add') {
                $('#add-prov').hide('slow').show('slow').delay(2000).hide('slow');
                $('#form-crear-proveedor').trigger('reset');
                $('#crear_proveedor').modal('hide');
                buscar_proveedor(); 
            } else if (respuesta == 'noadd') {
                $('#noadd-prov').hide('slow').show('slow').delay(2000).hide('slow');
                $('#form-crear-proveedor').trigger('reset');
            } else {
                console.log("Respuesta inesperada del servidor:", respuesta);
            }
        });
        e.preventDefault();
    });

    function buscar_proveedor(consulta) {
    let funcion = 'buscar';
    $.post('../controlador/ProveedorController.php', { funcion, consulta }, (response) => {
        let proveedores;
        
        if (typeof response === 'object') {
            proveedores = response;
        } else {
            if (response.trim() === 'add') return;
            try {
                proveedores = JSON.parse(response);
            } catch (e) {
                console.error("Error al parsear JSON:", response);
                return;
            }
        }

        // Dibujar las cards
        let template = '';
        proveedores.forEach(prov => {
            template += `
            <div provId="${prov.id}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                        <i class="fas fa-id-card mr-2"></i>Proveedor
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-7">
                                <h2 class="lead"><b>${prov.nombre}</b></h2>
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> Tel: ${prov.telefono}</li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-envelope"></i></span> Correo: ${prov.correo}</li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-map-marker-alt"></i></span> Dir: ${prov.direccion}</li>
                                </ul>
                            </div>
                            <div class="col-5 text-center">
                                <img src="${prov.avatar}" alt="Imagen Proveedor" class="img-circle img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="borrar btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt mr-1"></i>Eliminar Proveedor
                        </button>
                    </div>
                </div>
            </div>`;
        });
        $('#proveedores').html(template);
    });
}

    $(document).on('keyup', '#buscar-proveedor', function() {
        let valor = $(this).val();
        buscar_proveedor(valor);
    });

    $(document).on('click', '.borrar', (e) => {
        const elemento = $(e.currentTarget).closest('.d-flex');
        const id = $(elemento).attr('provId');
        
        if (confirm('¿Está seguro de que desea eliminar este proveedor definitivamente?')) {
            let funcion = 'borrar';
            $.post('../controlador/ProveedorController.php', { id, funcion }, (response) => {
                if (response.trim() == 'borrado') {
                    buscar_proveedor(); 
                }
            });
        }
    });
});