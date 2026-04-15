$(document).ready(function(){
    buscar_datos(); // Carga inicial sin filtro

    function buscar_datos(consulta){
        let funcion = 'buscar_usuarios_adm';
        // Enviamos 'consulta' explícitamente
        $.post('../controlador/UsuarioController.php', {consulta: consulta, funcion: funcion}, (response) => {
            if(!response.startsWith('[')){
                console.error("Error del servidor:", response);
                return;
            }
            const usuarios = JSON.parse(response);
            let template = '';
            usuarios.forEach(usuario => {
                template += `
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
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
                
                if(usuario.tipo_sesion == 1) { 
                    template += `<button class="btn btn-sm btn-danger mr-1"><i class="fas fa-trash-alt mr-1"></i>Eliminar</button>`;
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

    // Buscador mejorado
    $(document).on('keyup', '#buscar', function(){
        let valor = $(this).val();
        // Si el buscador está vacío, buscar_datos() traerá todos por defecto
        buscar_datos(valor); 
    });

$('#form-crear').submit(e => {
    let nombre = $('#nombre').val();
    let apellido = $('#apellido').val();
    let edad = $('#edad').val();
    let dni = $('#dni').val();
    let pass = $('#pass').val();
    let tipo = 2; // O el valor que desees por defecto para nuevos usuarios
    let funcion = 'crear_usuario';

    $.post('../controlador/UsuarioController.php', {nombre, apellido, edad, dni, pass, tipo, funcion}, (response) => {
        // Esto imprimirá la respuesta en tu consola de Chrome/Brave
        console.log("Respuesta del servidor: " + response);

if(response.trim() == 'add'){
            // Mostramos la alerta de éxito
            $('#add').hide().show('slow'); // Asegura que se vea con animación
            $('#add').delay(3000).fadeOut(1000); // Se desvanece tras 3 segundos

            // Limpiamos y refrescamos
            $('#form-crear').trigger('reset');
            buscar_datos(); // Refresca las cards
            
            // Opcional: Cerrar el modal automáticamente después de mostrar la alerta
            // setTimeout(() => { $('#crearusuario').modal('hide'); }, 3000);
            
        } else if(response.trim() == 'noadd'){
            // Mostramos la alerta de error (DNI duplicado)
            $('#noadd').hide().show('slow');
            $('#noadd').delay(3000).fadeOut(1000);
            $('#form-crear').trigger('reset');
        } else {
            console.log("Error inesperado: " + response);
        }
    });
    e.preventDefault();
});
});