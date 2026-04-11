$(document).ready(function() {
    var edit = false;
    var id_usuario = $('#id_usuario').val(); 

    // Inicializar datos al cargar la página
    buscar_usuario(id_usuario);

    function buscar_usuario(dato) {
        let funcion = 'buscar_usuario';
        $.post('../controlador/UsuarioController.php', { dato, funcion }, (response) => {
            const usuario = JSON.parse(response);
            // Esto actualiza la información estática de la izquierda
            $('#nombre_us').html(usuario.nombre);
            $('#telefono_us').html(usuario.telefono);
            $('#residencia_us').html(usuario.residencia);
            $('#correo_us').html(usuario.correo);
            $('#adicional_us').html(usuario.adicional);
        });
    }

    // A. EVENTO PARA CARGAR DATOS (Botón de la izquierda con clase .edit)
    $(document).on('click', '.edit', function(e) {
        e.preventDefault();
        console.log("Modo edición activado: Cargando datos...");
        edit = true; 
        const funcion_capturar = 'capturar_datos';
        
        $.post('../controlador/UsuarioController.php', { funcion: funcion_capturar, id_usuario }, (response) => {
            const data = JSON.parse(response);
            // Llenamos los cuadros de texto de la derecha
            $('#telefono').val(data.telefono);
            $('#residencia').val(data.residencia);
            $('#correo').val(data.correo);
            $('#adicional').val(data.adicional);
        });
    });

    // B. EVENTO PARA GUARDAR (Formulario completo)
    $('#form-usuario').submit(e => {
        e.preventDefault(); 
        
        if (edit == true) {
            console.log("Enviando cambios a la base de datos...");
            
            let telefono = $('#telefono').val();
            let residencia = $('#residencia').val();
            let correo = $('#correo').val();
            let adicional = $('#adicional').val();
            let funcion = 'editar_usuario';

            $.post('../controlador/UsuarioController.php', { id_usuario, funcion, telefono, residencia, correo, adicional }, (response) => {
                console.log("Respuesta del servidor:", response);
                
                if (response.trim() == 'editado') {
                    // Animación de éxito
                    $('#editado').hide('slow').show('1000').hide('4000');
                    // Actualizamos la info de la izquierda con los nuevos datos
                    $('form-usuario').trigger('reset');
                    buscar_usuario(id_usuario);
                    edit = false; 
                }
            });
        } else {
            $('#noeditado').hide('slow');
            $('#noeditado').show('1000');
            $('#noeditado').hide('2000');
            $('form-usuario').trigger('reset');
        }
        e.preventDefault();
    });
});