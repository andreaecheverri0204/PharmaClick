$(document).ready(function () {
    // Inicializar el carrito desde LocalStorage si ya tiene datos guardados
    let carrito = JSON.parse(localStorage.getItem('carrito_pharmaclick')) || [];
    
    // Ejecutar funciones iniciales al cargar la página
    mostrar_lotes_riesgo();
    buscar_productos();
    actualizar_interfaz_carrito();

    // Evento del buscador de productos por teclado
    $(document).on('keyup', '#buscar-producto', function() {
        let valor = $(this).val();
        if (valor != "") {
            buscar_productos(valor);
        } else {
            buscar_productos();
        }
    });

    // 1. CARGAR TABLA SUPERIOR: LOTES EN RIESGO
    function mostrar_lotes_riesgo() {
        let funcion = 'lote_riesgo';
        $.post('../controlador/LoteController.php', { funcion }, (response) => {
            if(response.trim() == "") return;
            
            const lotes = JSON.parse(response);
            let template = '';
            
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

            lotes.forEach(lote => {
                const vencimiento = new Date(lote.vencimiento);
                vencimiento.setHours(0, 0, 0, 0);
                
                const diffTime = vencimiento.getTime() - hoy.getTime();
                const dias_faltantes = Math.floor(diffTime / (1000 * 60 * 60 * 24));

                if (dias_faltantes <= 120) {
                    let color_alerta = ''; 
                    let texto_dias = '';

                    if(dias_faltantes < 0) {
                        color_alerta = 'background-color: #F87C63 !important; color: white;'; 
                        texto_dias = `Vencido hace ${Math.abs(dias_faltantes)} días`;
                    } else {
                        texto_dias = `${dias_faltantes} días`;

                        if (dias_faltantes <= 15) {
                            color_alerta = 'background-color: #F87C63 !important; color: white;'; 
                        } else if (dias_faltantes <= 45) {
                            color_alerta = 'background-color: #FFE17D !important; color: #333;'; 
                        } else if (dias_faltantes <= 120) {
                            color_alerta = ''; 
                        }
                    }

                    template += `
                    <tr style="${color_alerta}">
                        <td>${lote.id_lote}</td>
                        <td>${lote.nombre} ${lote.concentracion}</td>
                        <td>${lote.stock}</td>
                        <td>${lote.laboratorio}</td>
                        <td>${lote.presentacion}</td>
                        <td>${lote.proveedor}</td>
                        <td><b>${texto_dias}</b></td>
                    </tr>`;
                }
            });
            $('#lotes-riesgo').html(template);
        });
    }

    // 2. CARGAR TARJETAS INFERIORES: BUSCAR PRODUCTOS
    function buscar_productos(consulta) {
        let funcion = 'buscar';
        $.post('../controlador/ProductoController.php', { funcion, consulta }, (response) => {
            const productos = JSON.parse(response);
            let template = '';
            
            productos.forEach(producto => {
                // Verificar si este producto ya está en el carrito guardado
                const en_carrito = carrito.find(p => p.id == producto.id);
                let stock_disponible = producto.stock;
                if (en_carrito) {
                    stock_disponible = producto.stock - en_carrito.cantidad;
                }

                template += `
                <div prodId="${producto.id}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                    <div class="card bg-light d-flex flex-fill">
                        <div class="card-header text-muted border-bottom-0">
                            <i class="fas fa-layer-group mr-1"></i>${producto.tipo}
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b class="prod-nombre">${producto.nombre}</b></h2>
                                    <h4 class="small text-muted"><b>Concentración: </b><span class="prod-concentracion">${producto.concentracion}</span></h4>
                                    <h4 class="small text-muted"><b>Adicional: </b><span class="prod-adicional">${producto.adicional}</span></h4>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i class="fas fa-flask"></i></span> Laboratorio: ${producto.laboratorio}</li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-copyright"></i></span> Presentación: ${producto.presentacion}</li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-dollar-sign"></i></span> Precio: <b class="text-success">${producto.precio}</b></li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-box"></i></span> Stock Total: <b class="prod-stock badge badge-info">${stock_disponible}</b></li>
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="${producto.avatar}" alt="" class="img-circle img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="agregar-carrito btn btn-sm btn-primary">
                                <i class="fas fa-plus mr-1"></i> Agregar al carrito
                            </button>
                        </div>
                    </div>
                </div>`;
            });
            $('#productos-catalogo').html(template);
        });
    }

    // 3. EVENTO: AGREGAR PRODUCTO AL CARRITO (Actualizado con Precio)
    $(document).on('click', '.agregar-carrito', (e) => {
        const elemento = $(e.target).closest('[prodId]');
        const id_producto = $(elemento).attr('prodId');
        const nombre = $(elemento).find('.prod-nombre').text();
        const concentracion = $(elemento).find('.prod-concentracion').text();
        const adicional = $(elemento).find('.prod-adicional').text();
        // CAPTURAMOS EL PRECIO (Limpiando espacios si los hay)
        const precio = parseFloat($(elemento).find('.text-success').text().trim());
        
        let stock_elemento = $(elemento).find('.prod-stock');
        let stock_actual = parseInt(stock_elemento.text());

        if (stock_actual > 0) {
            stock_elemento.text(stock_actual - 1);

            const producto_añadido = {
                id: id_producto,
                nombre: nombre,
                concentracion: concentracion,
                adicional: adicional,
                precio: precio, // <-- Guardado con éxito
                cantidad: 1
            };

            const existe = carrito.some(prod => prod.id === id_producto);
            if (existe) {
                carrito = carrito.map(prod => {
                    if (prod.id === id_producto) {
                        prod.cantidad++;
                        return prod;
                    } else {
                        return prod;
                    }
                });
            } else {
                carrito.push(producto_añadido);
            }

            guardar_carrito_storage();
            actualizar_interfaz_carrito();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Stock Agotado',
                text: 'No quedan más unidades disponibles de este producto.',
            });
        }
    });

    // NUEVO EVENTO: REDIRECCIÓN AL PROCESAR COMPRA
    $('#procesar-compra').click(() => {
        if (carrito.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Carrito Vacío',
                text: 'Agrega al menos un producto para procesar la compra.',
            });
            return;
        }
        // Nos redirige a la vista de pasarela de pago/solicitud
        location.href = 'adm_compra.php';
    });

    // 4. EVENTO: ELIMINAR UN ELEMENTO DEL CARRITO
    $(document).on('click', '.borrar-producto-carrito', (e) => {
        const id_eliminar = $(e.target).closest('tr').attr('prodId');
        const producto_encontrado = carrito.find(prod => prod.id == id_eliminar);

        if (producto_encontrado) {
            const tarjeta_producto = $(`[prodId="${id_eliminar}"]`);
            if (tarjeta_producto.length > 0) {
                let stock_elemento = tarjeta_producto.find('.prod-stock');
                let stock_actual = parseInt(stock_elemento.text());
                stock_elemento.text(stock_actual + producto_encontrado.cantidad);
            }

            carrito = carrito.filter(prod => prod.id != id_eliminar);
            guardar_carrito_storage();
            actualizar_interfaz_carrito();
        }
    });

    // 5. EVENTO: VACIAR TODO EL CARRITO
    $('#vaciar-carrito').click(() => {
        carrito.forEach(prod => {
            const tarjeta_producto = $(`[prodId="${prod.id}"]`);
            if (tarjeta_producto.length > 0) {
                let stock_elemento = tarjeta_producto.find('.prod-stock');
                let stock_actual = parseInt(stock_elemento.text());
                stock_elemento.text(stock_actual + prod.cantidad);
            }
        });

        carrito = [];
        guardar_carrito_storage();
        actualizar_interfaz_carrito();
    });

    function guardar_carrito_storage() {
        localStorage.setItem('carrito_pharmaclick', JSON.stringify(carrito));
    }

    function actualizar_interfaz_carrito() {
        let template = '';
        let total_productos = 0;

        carrito.forEach(prod => {
            total_productos += prod.cantidad;
            template += `
                <tr prodId="${prod.id}">
                    <td>${prod.id}</td>
                    <td>${prod.nombre}</td>
                    <td>${prod.concentracion}</td>
                    <td>${prod.adicional}</td>
                    <td><b>${prod.cantidad}</b></td>
                    <td>
                        <button class="btn btn-sm btn-danger borrar-producto-carrito">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        if (carrito.length === 0) {
            template = `
                <tr>
                    <td colspan="6" class="text-center p-3 text-muted">El carrito está vacío</td>
                </tr>
            `;
        }

        $('#lista-carrito').html(template);
        $('#contador-carrito').text(total_productos);
    }
});