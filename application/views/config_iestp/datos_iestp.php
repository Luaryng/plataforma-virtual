<div class="content-wrapper">
	<div class="modal fade" id="modupdaiestp" tabindex="-1" role="dialog" aria-labelledby="modupdaiestp" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-dialog-centered" role="document">
      		<div class="modal-content" id="divmodalupd">
        		<div class="modal-header">
		          	<h5 class="modal-title" id="exampleModalLongTitle">ACTUALIZAR DATOS</h5>
		          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          	<span aria-hidden="true">&times;</span>
		          	</button>
        		</div>
	       		<div class="modal-body">
	          		<div id="divdatosiestp">
	            
	          		</div>
	        	</div>
		        <div class="modal-footer">
		          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		          	<button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
		        </div>
      		</div>
    	</div>
  	</div>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_datos" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-user mr-1"></i> Datos de la Institución</h3>
		    </div>
	      	<div class="card-body">
				<div id="divtabl-autor" class="col-xs-12 col-md-12 neo-table">
					<div class="col-md-12 header d-none d-md-block">
					    <div class="row">
					      	<div class="col-xs-1 col-md-1 cell hidden-xs"><b>Nro</b></div>
					      	<div class="col-xs-6 col-md-2 cell"><b>Nombre</b></div>
					      	<div class="col-xs-6 col-md-2 cell"><b>Resolución</b></div>
					      	<div class="col-xs-6 col-md-2 cell"><b>Revalidación</b></div>
					      	<div class="col-xs-6 col-md-2 cell"><b>Email</b></div>
					      	<div class="col-xs-6 col-md-2 cell"><b>Distrito</b></div>
					      	<div class="col-xs-2 col-md-1 cell text-center"></div>
					    </div>
					</div>
					<div class="col-md-12 body">
						<?php
					    $nro=0;
					    foreach ($datos as $dts) {
					        $nro++;
					    ?>
					    <div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
					      	<div class="col-xs-12 col-md-3 group">
					        	<div class="col-sm-6 col-md-4 cell">
					          		<span><?php echo $nro ;?></span>
					        	</div>
						        <div class="col-sm-6 col-md-8 cell">
						          	<span><?php echo $dts->nombre ?></span>
						        </div>
					      	</div>
					      	<div class="col-xs-12 col-md-4 group">
					        	<div class="col-sm-6 col-md-6 cell">
					          		<span><?php echo $dts->resolucion ;?></span>
					        	</div>
						        <div class="col-sm-6 col-md-6 cell">
						          	<span><?php echo $dts->revalidacion ?></span>
						        </div>
					      	</div>
					      	<div class="col-xs-12 col-md-4 group">
					        	<div class="col-sm-6 col-md-6 cell">
					          		<span><?php echo $dts->email ;?></span>
					        	</div>
						        <div class="col-sm-6 col-md-6 cell">
						          	<span><?php echo $dts->distrito ?></span>
						        </div>
					      	</div>
					      	<div class="col-xs-12 col-md-1 group">
					        	<div class="col-sm-12 col-md-12 cell text-center">
					          		<button class="btn btn-sm btn-info btn-block" href="#" onclick="viewupdaiestp('<?php echo base64url_encode($dts->id) ?>')" title="Editar datos">
					            		<i class="fas fa-pencil-alt"></i> <span class="d-block d-md-none">Editar </span>
					          		</button>
					        	</div>
					      	</div>
					    </div>
					<?php } ?>
					</div>
				</div>
	      	</div>
	    </div>
	</section>
</div>

<script type="text/javascript">
	function viewupdaiestp(codigo) {
		$('#divcard_datos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
 		$("#divdatosiestp").html("");
	  	$.ajax({
	      	url: base_url + "iestp/vwmostrar_datosxcodigo",
	      	type: 'post',
	     	dataType: "json",
	      	data: {txtcodigo: codigo},
	      	success: function(e) {
	        	$('#divcard_datos #divoverlay').remove();
	        	$("#divdatosiestp").html(e.iesup);
	        	$("#modupdaiestp").modal("show");
	      	},
	      	error: function(jqXHR, exception) {
	          	var msgf = errorAjax(jqXHR, exception, 'div');
	          	$('#divcard_datos #divoverlay').remove();
	          	$("#modupdaiestp modal-body").html(msgf);
	      	} 
	  	});
  		return false;
	}

	$('#lbtn_guardar').click(function() {
	    $('#frm_update input,select').removeClass('is-invalid');
	    $('#frm_update .invalid-feedback').remove();
	    $('#divmodalupd').append('<div id="divoverlay" class="overlay" style="background: #fff;"><i class="fas fa-spinner fa-pulse fa-3x" style="margin-left: 46%;margin-top: 46%;"></i></div>');
	    $.ajax({
	        url: base_url + "iestp/fn_update_datos",
	        type: 'post',
	        dataType: 'json',
	        data: $('#frm_update').serialize(),
	        success: function(e) {
	            $('#divmodalupd #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#divmsgies').html(msgf);
	                Swal.fire({
	                    title: e.msg,
	                    // text: "",
	                    type: 'success',
	                }).then((result) => {
	                  if (result.value) {
	                    location.reload();
	                  }
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divmodalupd #divoverlay').remove();
	            $('#divmsgies').show();
	            $('#divmsgies').html(msgf);
	        }
	    });
	    return false;
	});
</script>