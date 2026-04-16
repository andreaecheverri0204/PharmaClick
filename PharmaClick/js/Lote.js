$(document).ready(function () {
    buscar_lote();

    $(document).on('keyup', '#buscar-lote', function() {
        let valor = $(this).val();
        if (valor != "") {
            buscar_lote(valor);
        } else {
            buscar_lote();
        }
    });

    function buscar_lote(consulta) {
        let funcion = 'buscar';
        $.post('../controlador/LoteController.php', { funcion, consulta }, (response) => {
            const lotes = JSON.parse(response);
            let template = '';
            
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

            lotes.forEach(lote => {
                const vencimiento = new Date(lote.vencimiento);
                vencimiento.setHours(0, 0, 0, 0);
                
                const diffTime = vencimiento.getTime() - hoy.getTime();
                const dias_faltantes = Math.floor(diffTime / (1000 * 60 * 60 * 24));

                let color_alerta = ''; 
                
                if (dias_faltantes <= 15) {
                    color_alerta = 'background-color: #F87C63 !important; color: white;';
                } 
                else if (dias_faltantes <= 45) {
                    color_alerta = 'background-color: #FFE17D !important; color: #333;';
                } 
                else if (dias_faltantes <= 120) {
                    color_alerta = 'background-color: #7BC76D !important; color: white;';
                }

                template += `
                <div loteId="${lote.id_lote}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                    <div class="card bg-light">
                        <div class="card-header border-bottom-0" style="${color_alerta}">
                            <i class="fas fa-box mr-1"></i>Stock: <span class="badge badge-light">${lote.stock}</span>
                            <div class="float-right">
                                <small><b>${dias_faltantes < 0 ? 'VENCIDO' : 'Vence en ' + dias_faltantes + ' días'}</b></small>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b>${lote.nombre}</b></h2>
                                    <h4 class="small"><b>Concentración: </b>${lote.concentracion}</h4>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i class="fas fa-flask"></i></span> Lab: ${lote.laboratorio}</li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-calendar-times"></i></span> Vence: ${lote.vencimiento}</li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-truck-moving"></i></span> Prov: ${lote.proveedor}</li>
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="${lote.avatar}" class="img-circle img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="editar btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></button>
                            <button class="borrar btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                </div>`;
            });
            $('#lotes').html(template);
        });
    }
}); 