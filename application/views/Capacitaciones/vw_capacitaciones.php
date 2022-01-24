<?php
	$vbaseurl=base_url();
?>
<div class="content-wrapper">

	<div class="modal fade" id="modviewdetalle" tabindex="-1" role="dialog" aria-labelledby="modviewdetalle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="div_title">DETALLE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-md-2 col-4">
                                    <span><b>Titulo:</b></span>
                                </div>
                                <div class="col-md-10 col-8" id="titlecapacita"></div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-md-2 col-4">
                                    <span><b>Expositor:</b></span>
                                </div>
                                <div class="col-md-10 col-8" id="div_expositor"></div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-md-2 col-4">
                                    <span><b>Fecha:</b></span>
                                </div>
                                <div class="col-md-10 col-8" id="div_fecha"></div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-md-2 col-4">
                                    <span><b>Grabación:</b></span>
                                </div>
                                <div class="col-md-10 col-8" id="div_grabacion"></div>
                            </div>
                        </div>
                         <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-md-2 col-4">
                                    <span><b>Dirigido a:</b></span>
                                </div>
                                <div class="col-md-10 col-8" id="div_tipo"></div>
                            </div>
                        </div>
                    	<div class="col-12 mt-2" id="view_detalle">
                    		
                    	</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <!-- <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button> -->
                </div>
            </div>
        </div>
    </div>

	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>Capacitaciones
          			<small>Panel</small></h1>
        		</div>
      		</div>
    	</div>
  	</section>
  	<section id="s-cargado" class="content pt-2">
		<div id="divcard_capacitacion" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de capacitaciones</h3>
                <?php if (getPermitido("152")=='SI'){ ?>
		    	<div class="no-padding card-tools">
                	<a type="button" class="btn btn-sm btn-outline-dark" href="<?php echo $vbaseurl ?>capacitaciones/agregar"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
                <?php } ?>
		    </div>
            <div class="card-body">
            	<small id="fmt_conteo" class="form-text text-primary">
            
                </small>
                <div class="col-12 py-1">
                    <div class="btable">
                        <div class="thead col-12  d-none d-md-block">
                            <div class="row">
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-2 col-md-1 td'>N°</div>
                                        <div class='col-10 col-md-5 td'>NOMBRE</div>
                                        <div class='col-12 col-md-6 td'>EXPOSITOR</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-4 col-md-4 td'>FECHA/HORA</div>
                                        <div class='col-8 col-md-8 td'>GRABACIÓN</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-2 td text-center'>
                                    
                                </div>
                            </div>
                            
                        </div>
                        <div class="tbody col-12" id="divcard_data">
                        	<?php
                        		$nro = 0;
                        		foreach ($capacita as $key => $cap) {
                        			$nro++;
                        			$codigo64 = base64url_encode($cap->id);
                        			$datecap =  new DateTime($cap->fecha);
                        			$fcapa = $datecap->format('d/m/Y h:i a');
                        	?>

                            <div class='row rowcolor cfila' data-nombre='<?php echo $cap->nombre ?>' data-codigo='<?php echo $codigo64 ?>'>
                            	<div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-2 col-md-1 td'><?php echo $nro ?></div>
                                        <div class='col-10 col-md-5 td'><?php echo $cap->nombre ?></div>
                                        <div class='col-12 col-md-6 td'><?php echo $cap->expositor ?></div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-4 col-md-4 td'><?php echo $fcapa ?></div>
                                        <div class='col-8 col-md-8 td'><?php echo $cap->grabacion ?></div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-2 text-center'>
                                	<div class="row">
                                		<div class='col-6 col-md-6 td'>
                                			<a type='button' href="#" class="bg-primary px-2 py-1 btn_view_detalle">Ver</a>
                                		</div>
                                		<div class='col-6 col-md-6 td'>
                                			<div class='btn-group'>
                                				<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    <i class='fas fa-cog'></i>
                                                </a>
                                                <div class='dropdown-menu dropdown-menu-right acc_dropdown'>
                                                    <?php if (getPermitido("153")=='SI'){ ?>
                                                	<a class='dropdown-item' href='<?php echo $vbaseurl."capacitaciones/editar/".$codigo64 ?>' title='Editar'>
                                                        <i class='fas fa-edit mr-1'></i> Editar
                                                    </a>
                                                    <?php } 
                                                    if (getPermitido("154")=='SI'){ ?>
                                                    <a class='dropdown-item text-danger deletecapacit' href='#' title='Eliminar'>
                                                        <i class='fas fa-trash mr-1'></i> Eliminar
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                			</div>
                                		</div>
                                	</div>
                                </div>
                            </div>
                            <?php
                        		}
                        	?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">

	$('.btn_view_detalle').click(function(e) {
		e.preventDefault();
		var boton = $(this);
		var fila = boton.closest('.cfila');
		var codigo = fila.data('codigo');
		$('#divcard_capacitacion').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		$.ajax({
            url: base_url + 'capacitaciones/fn_view_detalle',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodigo: codigo
            },
            success: function(e) {
                $('#divcard_capacitacion #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        type: 'error',
                        title: 'Error!',
                        icon: 'error',
                        text: e.msg,
                        backdrop: false,
                    })
                } else {
                    var dirigido = "";
                    $('#modviewdetalle').modal('show');
                    $('#titlecapacita').html(e.vdata['nombre']);
                    $('#div_expositor').html(e.vdata['expositor']);
                    $('#div_fecha').html(e.vdata['fechacap']);
                    // $('#div_grabacion').attr('href',e.vdata['grabacion']);
                    $('#div_grabacion').html(e.vdata['grabacion']);
                    $('#view_detalle').html(e.vdata['detalle']);

                    if (e.vdata['tipo'] == "AL") {
                        dirigido = "Estudiantes";
                    } else if (e.vdata['tipo'] == "DC") {
                        dirigido = "Docentes";
                    } else if (e.vdata['tipo'] == "DA") {
                        dirigido = "Docentes Administrativos";
                    } else if (e.vdata['tipo'] == "AD") {
                        dirigido = "Administrativos";
                    }
                    $('#div_tipo').html(dirigido);

                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divcard_capacitacion #divoverlay').remove();
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    icon: 'error',
                    text: msgf,
                    backdrop: false,
                })
            }
        });
		
	});

    $(".deletecapacit").click(function(e) {
        e.preventDefault();
        $('#divcard_capacitacion').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var fila = $(this).closest('.cfila');
        var codigo = fila.data("codigo");
        var nombre = fila.data('nombre');
        //************************************
        Swal.fire({
            title: "Precaución",
            text: "¿Deseas eliminar la capacitación "+nombre+" ?",
            type: 'warning',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: base_url + 'capacitaciones/fneliminar_capacitacion',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        txtcodigo: codigo,
                    },
                    success: function(e) {
                        $('#divcard_capacitacion #divoverlay').remove();
                        if (e.status == false) {
                            Swal.fire({
                                type: 'error',
                                title: 'Error!',
                                icon: 'error',
                                text: e.msg,
                                backdrop: false,
                            })
                        } else {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: 'Eliminación correcta',
                                text: 'Se ha eliminado el registro',
                                backdrop: false,
                            })

                            fila.remove();
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msgf = errorAjax(jqXHR, exception, 'text');
                        $('#divcard_capacitacion #divoverlay').remove();
                        Swal.fire({
                            type: 'error',
                            title: 'Error',
                            icon: 'error',
                            text: msgf,
                            backdrop: false,
                        })
                    }
                });
            } else {
                $('#divcard_capacitacion #divoverlay').remove();
            }
        });
    });

       
</script>