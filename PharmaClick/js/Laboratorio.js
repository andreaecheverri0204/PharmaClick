$(document).ready(function () {
    buscar_lab();

    function buscar_lab(consulta) {
    let funcion = 'buscar';
    $.post('../controlador/LaboratorioController.php', { consulta, funcion }, (response) => {
        const laboratorios = JSON.parse(response);
        let template = '';
        laboratorios.forEach(lab => {
            template += `
                <tr labId="${lab.id}">
                    <td>${lab.nombre}</td>
                    <td><img src="${lab.avatar}" class="img-circle" width="50" height="50"></td>
                    <td>
                        <button class="borrar-lab btn btn-danger"><i class="fas fa-trash-alt"></i> Eliminar</button>
                    </td>
                </tr>`;
        });
        $('#laboratorios').html(template); 
    });
}

    $(document).on('keyup', '#buscar-laboratorio', function () {
        let valor = $(this).val();
        if (valor != "") {
            buscar_lab(valor);
        } else {
            buscar_lab();
        }
    });

$(document).off('submit.crear', '#form-crear-laboratorio');
$(document).on('submit.crear', '#form-crear-laboratorio', function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    let btn = $(this).find('button[type="submit"]');
    if(btn.hasClass('disabled')) return false; 
    btn.addClass('disabled').prop('disabled', true);

    let nombre = $('#nombre-laboratorio').val();
    let funcion = 'crear';

    $.post('../controlador/LaboratorioController.php', { nombre_laboratorio: nombre, funcion }, (response) => {
        let respuesta = response.trim();
        
        if (respuesta.includes('add')) {
            $('#add-laboratorio').hide('slow').show('slow').delay(2000).hide('slow');
            $('#form-crear-laboratorio').trigger('reset');
            buscar_lab(); 
        } else {
            $('#noadd-laboratorio').hide('slow').show('slow').delay(2000).hide('slow');
        }
        
        btn.removeClass('disabled').prop('disabled', false);
    });
});
    $(document).off('click', '.borrar-lab').on('click', '.borrar-lab', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        const fila = $(this).closest('tr');
        const id = fila.attr('labId');
        const nombre = fila.find('td').eq(0).text();
        const funcion = 'borrar';

        if (!id) return;

        if (confirm("¿Está seguro de que desea eliminar el laboratorio: " + nombre + "?")) {
            $.post('../controlador/LaboratorioController.php', { id, funcion }, (response) => {
                const respuesta = response.trim();
                if (respuesta === 'borrado') {
                    fila.remove();
                } else {
                    alert("No se pudo borrar: " + respuesta);
                }
            }).fail(() => {
                alert("Error de conexión con el servidor.");
            });
        }
    });
});