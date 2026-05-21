$(document).ready(function () {
    const moduloCompra = new Compra();

    // Dibujar la tabla e importes al cargar la página
    renderizarTablaCompra();

    // 1. EVENTO: MODIFICAR CANTIDAD DENTRO DE LA TABLA (VALIDADO)
    $(document).on('keyup change', '.cantidad-producto', function () {
        const id = $(this).closest('tr').attr('prodId');
        let nuevaCantidad = parseInt($(this).val());
        const maxStock = parseInt($(this).attr('max'));

        // Si el usuario digita un número mayor al stock disponible en el input max
        if (nuevaCantidad > maxStock) {
            Swal.fire({
                icon: 'warning',
                title: 'Stock Excedido',
                text: `Solo quedan ${maxStock} unidades disponibles de este producto.`
            });
            nuevaCantidad = maxStock;
            $(this).val(maxStock); // Forzamos el valor al límite máximo en pantalla
        }

        if (nuevaCantidad > 0 && nuevaCantidad != "") {
            moduloCompra.actualizarCantidad(id, nuevaCantidad);
            
            const precio = parseFloat($(this).closest('tr').find('.precio-unitario').text());
            $(this).closest('tr').find('.subtotal-fila').text((precio * nuevaCantidad).toFixed(2));
            
            actualizarTotalesUI();
        }
    });

    // 2. EVENTO: ELIMINAR UN PRODUCTO DE LA TABLA
    $(document).on('click', '.quitar-producto', function () {
        const id = $(this).closest('tr').attr('prodId');
        moduloCompra.eliminarArticulo(id);
        renderizarTablaCompra(); 
    });

    // 3. EVENTO: CALCULAR VUELTO EN TIEMPO REAL
    $(document).on('keyup', '#pago-cliente', function () {
        const efectivo = parseFloat($(this).val());
        const vuelto = moduloCompra.calcularCambio(efectivo);
        $('#vuelto-cliente').text(vuelto.toFixed(2));
    });

    // 4. EVENTO: SEGUIR COMPRANDO (Regresa al catálogo manteniendo los productos)
    $('#seguir-comprando').click(function (e) {
        e.preventDefault();
        location.href = 'adm_catalogo.php'; 
    });

    // 5. EVENTO PRINCIPAL: REALIZAR / PROCESAR COMPRA (ENVÍO AJAX SINCRONIZADO)
    $('#realizar-compra').click(function (e) {
        e.preventDefault();

        const nombre_cliente = $('#nombre-cliente').val().trim();
        const dni_cliente = $('#doc-cliente').val().trim();
        const productos = moduloCompra.obtenerArticulos();

        if (nombre_cliente === "" || dni_cliente === "") {
            Swal.fire({ icon: 'error', title: 'Campos Vacíos', text: 'Por favor, ingrese el nombre y documento del cliente.' });
            return;
        }

        if (productos.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Carrito Vacío', text: 'No hay productos para procesar.' });
            return;
        }

        // Estructura de datos que viaja al backend
        let datos = {
            funcion: 'registrar_compra',
            cliente: nombre_cliente,
            dni: dni_cliente,
            total: moduloCompra.calcularTotal(),
            productos: JSON.stringify(productos)
        };

        $.ajax({
            url: '../controlador/CompraController.php',
            type: 'POST',
            data: datos,
            success: function (response) {
                try {
                    // Evaluamos dinámicamente si la respuesta ya se parseó automáticamente
                    let res = (typeof response === 'object') ? response : JSON.parse(response);

                    if (res.status === 'success') {
                        // SI LA COMPRA ES EXITOSA: Limpiamos todo de raíz
                        moduloCompra.vaciar(); 
                        
                        $('#nombre-cliente').val('');
                        $('#doc-cliente').val('');
                        $('#pago-cliente').val('');
                        $('#vuelto-cliente').text('0.00');

                        renderizarTablaCompra();

                        Swal.fire({
                            icon: 'success',
                            title: 'Compra Realizada',
                            text: 'La transacción se procesó y el stock fue actualizado.',
                        }).then(() => {
                            location.href = 'adm_catalogo.php'; 
                        });

                    } else {
                        // SI EL BACKEND BLOQUEA POR FALTA DE STOCK: Muestra el mensaje detallado sin limpiar el carrito
                        Swal.fire({
                            icon: 'error',
                            title: 'No se puede procesar la compra',
                            text: res.msg,
                            confirmButtonText: 'Corregir Cantidad'
                        });
                    }

                } catch (err) {
                    console.error("Error parseando respuesta JSON:", response, err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Respuesta Inesperada',
                        text: 'El servidor devolvió datos corruptos o un error interno.'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("Error en comunicación asíncrona:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Red / Servidor',
                    text: 'No se pudo conectar correctamente con el controlador de compras.'
                });
            }
        });
    });

    // --- FUNCIONES DE RENDERIZADO CON RESTRICCIÓN DE STOCK ---
    function renderizarTablaCompra() {
        const productos = moduloCompra.obtenerArticulos();
        let template = '';

        if (productos.length === 0) {
            template = `<tr><td colspan="8" class="text-center text-muted p-4">No hay productos en el carrito.</td></tr>`;
            $('#realizar-compra').prop('disabled', true);
        } else {
            $('#realizar-compra').prop('disabled', false);
            productos.forEach(prod => {
                const subtotalFila = prod.precio * prod.cantidad;
                const maxStock = prod.stock !== undefined ? prod.stock : 999; 

                template += `
                    <tr prodId="${prod.id}">
                        <td>${prod.id}</td>
                        <td>${prod.nombre}</td>
                        <td>${prod.concentracion}</td>
                        <td>${prod.adicional}</td>
                        <td class="precio-unitario">${prod.precio.toFixed(2)}</td>
                        <td>
                            <input type="number" class="form-control form-control-sm cantidad-producto" value="${prod.cantidad}" min="1" max="${maxStock}" style="width: 80px;">
                        </td>
                        <td class="subtotal-fila font-weight-bold">${subtotalFila.toFixed(2)}</td>
                        <td>
                            <button class="btn btn-sm btn-danger quitar-producto"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>`;
            });
        }
        $('#lista-compra-pasarela').html(template);
        actualizarTotalesUI();
    }

    function actualizarTotalesUI() {
        const total = moduloCompra.calcularTotal();
        const subtotal = moduloCompra.calcularSubtotal(0.18);
        const igv = moduloCompra.calcularImpuesto(0.18);

        $('#subtotal-compra').text(subtotal.toFixed(2));
        $('#impuesto-compra').text(igv.toFixed(2));
        $('#total-compra').text(total.toFixed(2));
        
        const efectivo = parseFloat($('#pago-cliente').val());
        if (!isNaN(efectivo)) {
            $('#vuelto-cliente').text(moduloCompra.calcularCambio(efectivo).toFixed(2));
        } else {
            $('#vuelto-cliente').text('0.00');
        }
    }
});