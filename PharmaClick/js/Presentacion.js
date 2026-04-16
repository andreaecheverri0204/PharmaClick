$(document).ready(function () {
    buscar_pre();

// REEMPLAZA TU FUNCIÓN ACTUAL POR ESTA
function buscar_pre(consulta) {
    let funcion = 'buscar';
    $.post('../controlador/PresentacionController.php', { consulta, funcion }, (response) => {
        console.log("Respuesta del servidor:", response); // ESTO DEBE APARECER EN F12

        try {
            const presentaciones = JSON.parse(response);
            let template = '';
            
            if (presentaciones.length === 0) {
                template = '<tr><td colspan="2" class="text-center">No hay resultados</td></tr>';
            } else {
                presentaciones.forEach(pre => {
                    // IMPORTANTE: Verifica que el nombre sea 'id' o 'id_presentacion' según tu controlador
                    template += `
                        <tr preId="${pre.id}"> 
                            <td>${pre.nombre}</td>
                            <td>
                                <button class="eliminar-presentacion-btn btn btn-danger" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }
            $('#presentaciones').html(template);
        } catch (e) {
            console.error("Error crítico en JSON:", e);
            console.log("El servidor mandó esto que no es JSON:", response);
        }
    });
}

    $('#form-crear-presentacion').submit(e => {
    let nombre = $('#nombre-presentacion').val();
    let funcion = 'crear';
    $.post('../controlador/PresentacionController.php', { nombre, funcion }, (response) => {
        if (response.trim() == 'add') {
            $('#add-pre').hide('slow');
            $('#add-pre').show('slow');
            $('#add-pre').hide('slow');
            $('#form-crear-presentacion').trigger('reset');
            // Llama a la función que lista las presentaciones
            buscar_pre(); 
        } else {
            $('#noadd-pre').show('slow');
            $('#noadd-pre').hide('slow');
        }
    });
    e.preventDefault();
});

$(document).on('click', '.eliminar-presentacion-btn', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    const fila = $(this).closest('tr');
    
    // SOLUCIÓN: Extraer el ID del atributo 'preId' que definimos en el template
    const id = fila.attr('preId'); 
    
    // Extraer el nombre de la primera columna
    const nombre = fila.find('td:first').text();
    const funcion = 'borrar';

    // Verificamos que el ID exista antes de preguntar
    if (id) {
        if (confirm("¿Seguro que deseas eliminar la presentación: " + nombre + "?")) {
            $.post('../controlador/PresentacionController.php', {id, funcion}, (response) => {
                if (response.trim() === 'borrado') {
                    fila.remove();
                    // Opcional: mostrar un mensaje de éxito
                } else {
                    alert("No se pudo eliminar: " + response);
                }
            });
        }
    } else {
        console.error("No se encontró el ID de la presentación en la fila.");
    }
});
});