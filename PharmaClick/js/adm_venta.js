$(document).ready(function() {
    // Carga inicial de la tabla
    listar_ventas();

    // 1. FUNCIÓN PARA LISTAR VENTAS
    function listar_ventas() {
        $.post('../controlador/VentaController.php', { funcion: 'listar_ventas' }, function(response) {
            let template = '';
            // Validamos que la respuesta sea un arreglo antes de iterar
            if(Array.isArray(response)) {
                response.forEach(v => {
                    template += `
                        <tr>
                            <td>${v.id_venta}</td>
                            <td>${v.fecha}</td>
                            <td>${v.cliente}</td>
                            <td>${v.dni}</td>
                            <td>${v.total}</td>
                            <td>${v.nombre_us}</td>
                            <td>
                                <button class="btn btn-danger btn-sm btn-borrar" id_venta="${v.id_venta}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                });
            }
            $('#lista-ventas').html(template);
        }, 'json').fail(function() {
            console.error("Error al conectar con el servidor para listar ventas.");
        });
    }


    // 3. FUNCIÓN PARA BORRAR VENTA
    $(document).on('click', '.btn-borrar', function() {
        let id = $(this).attr('id_venta');
        if(confirm('¿Está seguro de eliminar esta venta permanentemente?')) {
            // En tu .post de borrar_venta
            $.post('../controlador/VentaController.php', { funcion: 'borrar_venta', id_venta: id }, function(response) {
                console.log("Respuesta del servidor:", response); // <--- ESTO ES CLAVE
                if(response.trim() === 'success') {
                    listar_ventas();
                } else {
                    alert("Error: " + response); // Verás el error exacto aquí
                }
            });
        }
    });
});