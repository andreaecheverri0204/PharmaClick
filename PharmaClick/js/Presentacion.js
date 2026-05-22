$(document).ready(function () {
    buscar_pre();

function buscar_pre(consulta) {
    let funcion = 'buscar';
    $.post('../controlador/PresentacionController.php', { consulta, funcion }, (response) => {
        console.log("Respuesta del servidor:", response); 

        try {
            const presentaciones = JSON.parse(response);
            let template = '';
            
            if (presentaciones.length === 0) {
                template = '<tr><td colspan="2" class="text-center">No hay resultados</td></tr>';
            } else {
                presentaciones.forEach(pre => {
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
    
    const id = fila.attr('preId'); 
    
    const nombre = fila.find('td:first').text();
    const funcion = 'borrar';

    if (id) {
        if (confirm("¿Seguro que deseas eliminar la presentación: " + nombre + "?")) {
            $.post('../controlador/PresentacionController.php', {id, funcion}, (response) => {
                if (response.trim() === 'borrado') {
                    fila.remove();
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