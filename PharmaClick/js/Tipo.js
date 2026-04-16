$(document).ready(function() {
    buscar_tipo();
    var funcion;

    // --- BUSCADOR DINÁMICO ---
    function buscar_tipo(consulta) {
        funcion = 'buscar';
        $.post('../controlador/TipoController.php', {consulta, funcion}, (response) => {
            const tipos = JSON.parse(response);
            let template = '';
            tipos.forEach(tipo => {
                template += `
                    <tr tipoId="${tipo.id}">
                        <td>${tipo.nombre}</td>
                        <td>
                            <button class="borrar-tipo btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#tipos').html(template);
        });
    }

    $(document).on('keyup', '#buscar-tipo', function() {
        let valor = $(this).val();
        if (valor != "") {
            buscar_tipo(valor);
        } else {
            buscar_tipo();
        }
    });

    // --- CREAR TIPO ---
    $('#form-crear-tipo').submit(e => {
        let nombre = $('#nombre-tipo').val();
        funcion = 'crear';
        $.post('../controlador/TipoController.php', {nombre, funcion}, (response) => {
            if (response == 'add') {
                $('#add-tipo').hide('slow').show('slow').delay(2000).hide('slow');
                $('#form-crear-tipo').trigger('reset');
                buscar_tipo(); // Recarga la tabla
            } else {
                $('#noadd-tipo').hide('slow').show('slow').delay(2000).hide('slow');
            }
        });
        e.preventDefault();
    });

    // --- ELIMINAR TIPO (SIN DOBLE CLIC) ---
    $(document).off('click', '.borrar-tipo').on('click', '.borrar-tipo', (e) => {
        const elemento = $(e.currentTarget).closest('tr');
        const id = $(elemento).attr('tipoId');
        const nombre = $(elemento).find('td').eq(0).text();
        funcion = 'borrar';

        if (confirm("¿Realmente desea eliminar el tipo: " + nombre + "?")) {
            $.post('../controlador/TipoController.php', {id, funcion}, (response) => {
                if (response.trim() === 'borrado') {
                    $(elemento).remove();
                    alert("Eliminado con éxito.");
                } else {
                    alert("No se pudo eliminar: " + response);
                }
            });
        }
    });
});