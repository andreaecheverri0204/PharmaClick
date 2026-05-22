$(document).ready(function() {

    listar_ventas();

    function listar_ventas() {
        $.post('../controlador/VentaController.php', { funcion: 'listar_ventas' }, function(response) {
            let template = '';
            
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


    
    $(document).on('click', '.btn-borrar', function() {
        let id = $(this).attr('id_venta');
        if(confirm('¿Está seguro de eliminar esta venta permanentemente?')) {
        
            $.post('../controlador/VentaController.php', { funcion: 'borrar_venta', id_venta: id }, function(response) {
                console.log("Respuesta del servidor:", response);
                if(response.trim() === 'success') {
                    listar_ventas();
                } else {
                    alert("Error: " + response); 
                }
            });
        }
    });
});