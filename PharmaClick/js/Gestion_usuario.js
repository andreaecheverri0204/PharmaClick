$(document).ready(function() {
    // 1. Obtener el tipo de usuario desde el input hidden de tu PHP
    var tipo_usuario = $('#tipo_usuario').val();
    buscar_datos();

    function buscar_datos(consulta) {
        let funcion = 'buscar_usuarios_adm';
        $.post('../controlador/UsuarioController.php', { consulta: consulta, funcion: funcion }, (response) => {
            if (!response.startsWith('[')) {
                console.error("Error del servidor:", response);
                return;
            }

            const usuarios = JSON.parse(response);
            let template = '';
            usuarios.forEach(usuario => {
                // CORRECCIÓN: Se eliminó el div duplicado y se estructuró correctamente usuarioId
                template += `
                <div usuarioId="${usuario.id}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                    <div class="card bg-light">
                        <div class="card-header text-muted border-bottom-0">${usuario.tipo}</div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b>${usuario.nombre} ${usuario.apellidos}</b></h2>
                                    <p class="text-muted text-sm"><b>Sobre mí: </b>${usuario.adicional}</p>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Dirección: ${usuario.residencia}</li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-id-card"></i></span> DNI: ${usuario.dni}</li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Teléfono: ${usuario.telefono}</li>
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="../img/usuario.png" class="img-circle img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">`;

                // CORRECCIÓN: Solo el Admin (1) ve el botón y DEBE tener la clase 'eliminar'
                if (tipo_usuario == 1) {
                    template += `<button class="eliminar btn btn-sm btn-danger mr-1"><i class="fas fa-trash-alt mr-1"></i>Eliminar</button>`;
                }

                template += `
                            <button class="btn btn-sm btn-primary"><i class="fas fa-user mr-1"></i>Perfil</button>
                        </div>
                    </div>
                </div>`;
            });
            $('#usuarios').html(template);
        });
    }

    // Buscador
    $(document).on('keyup', '#buscar', function() {
        let valor = $(this).val();
        buscar_datos(valor);
    });

$(document).on('click', '.eliminar', (e) => {
    // 1. Extraer el ID de la tarjeta (card)
    const elemento = $(e.currentTarget).closest('[usuarioId]');
    const id = $(elemento).attr('usuarioId'); 
    const funcion = 'eliminar_usuario';

    // 2. Únicamente confirmar la acción
    if (confirm('¿Realmente desea eliminar este usuario?')) {
        
        $.post('../controlador/UsuarioController.php', {id, funcion}, (response) => {
            
            // Si el controlador confirma el borrado, refrescamos la vista
            if (response.trim() === 'borrado') {
                // 3. Recargar datos para actualizar la interfaz
                buscar_datos(); 
            } else {
                // En caso de error técnico, se registra en la consola para depuración
                console.error("Error en la eliminación: " + response);
            }
        });
    }
});

    // FUNCIÓN CREAR
    $('#form-crear').submit(e => {
        let nombre = $('#nombre').val();
        let apellido = $('#apellido').val();
        let edad = $('#edad').val();
        let dni = $('#dni').val();
        let pass = $('#pass').val();
        let tipo = 2;
        let funcion = 'crear_usuario';

        $.post('../controlador/UsuarioController.php', { nombre, apellido, edad, dni, pass, tipo, funcion }, (response) => {
            if (response.trim() == 'add') {
                $('#add').hide().show('slow').delay(3000).fadeOut(1000);
                $('#form-crear').trigger('reset');
                buscar_datos();
            } else if (response.trim() == 'noadd') {
                $('#noadd').hide().show('slow').delay(3000).fadeOut(1000);
            }
        });
        e.preventDefault();
    });
});