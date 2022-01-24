<?php
	$vbaseurl = base_url();
?>
<div class="content-wrapper">
	<div class="modal fade" id="modviewreply" tabindex="-1" role="dialog" aria-labelledby="modviewreply" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-dialog-centered" role="document">
      		<div class="modal-content" id="divmodalupd">
        		<div class="modal-header">
		          	<h5 class="modal-title" id="exampleModalLongTitle">RESPUESTA INCIDENCIA</h5>
		          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          	<span aria-hidden="true">&times;</span>
		          	</button>
        		</div>
	       		<div class="modal-body">
	          		<div id="divrpta">
	            
	          		</div>
	        	</div>
		        <div class="modal-footer">
		          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		        </div>
      		</div>
    	</div>
  	</div>
	<section id="s-cargado" class="content pt-2">
		<div id="divboxhistorial" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list mr-1"></i> MIS INCIDENCIAS</h3>
		    	<div class="card-tools">
		          	<a href="<?php echo $vbaseurl ?>tramites/incidencia/agregar" class="btn btn-primary  btn-sms">
		            	<i class="fas fa-plus mr-1"> Nueva denuncia</i>
		          	</a>
		          
		        </div>
		    </div>
	      	<div class="card-body">
	      		<div id="divtabl-incidencias" class="col-12 col-md-12 neo-table">
					<div class="col-md-12 header d-none d-md-block">
						<div class="row font-weight-bold">
							
							<div class="col-12 col-md-3 group">
								<div class="col-4 col-md-3 cell d-none d-md-block">
									N°
								</div>
								<div class="col-12 col-md-9 cell">
									FECHA DENUNCIA
								</div>
							</div>
							<div class="col-12 col-md-4 group">
								<div class="col-6 col-md-6 cell">
									DENUNCIANTE
								</div>
								<div class="col-6 col-md-6 cell">
									DENUNCIADO
								</div>
							</div>
							<div class="col-12 col-md-5 group">
								<div class="col-4 col-md-5 cell text-center">
									FICHA PDF
								</div>
								<div class="col-12 col-md-4 cell text-center">
									RESPUESTA
								</div>
								<div class="col-12 col-md-3 cell">
									
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 body">
					<?php
						$nro = 0;
						foreach ($incidencias as $value) {
							$nro++;
							$vfecha = date('d-m-Y', strtotime($value->fecha));
					?>
						<div  class="row cfila <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
							<div class="col-12 col-md-3 group">
								<div class="col-3 col-md-3 cell">
									<span><?php echo $nro ;?></span>
								</div>
								<div class="col-9 col-md-9 cell">
									<?php echo $vfecha ?>
								</div>
							</div>
							<div class="col-12 col-md-4 group">
								<div class="col-6 col-md-6 cell">
									<span><?php echo $value->nombres ;?></span>
								</div>
								<div class="col-6 col-md-6 cell">
									<span><?php echo $value->asunto ;?></span>
								</div>
							</div>
							<div class="col-12 col-md-5 group">
								<div class="col-5 col-md-5 cell text-center">
									<span>
										<a class="bg-success py-1 px-3 rounded" target="_blank" href="<?php echo base_url()."tramites/incidencia/constancia-pdf?cinc=".base64url_encode($value->id) ?>" title="Descargar">
											<i class="fas fa-download"></i> 
										</a>
									</span>
								</div>
								<div class="col-4 col-md-4 cell text-center">
									<span>
										<a class="bg-info py-1 px-3 rounded btn_ver" data-id="<?php echo base64url_encode($value->id) ?>" id="btn_ver" href="#" title="Ver respuesta">
											<i class="fas fa-eye"></i> 
										</a>
									</span>
								</div>
								<div class="col-3 col-md-3 cell">
									<span><?php //echo $value->periodo; ?></span>
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
	</section>
</div>

<script type="text/javascript">

	$('.btn_ver').click(function(e){
		e.preventDefault();
		var codigo = $(this).data('id');
		$('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
 		$("#divrpta").html("");
	  	$.ajax({
	      	url: base_url + "incidencia/vwmostrar_respuesta",
	      	type: 'post',
	     	dataType: "json",
	      	data: {txtcodigo: codigo},
	      	success: function(e) {
	        	$('#divboxhistorial #divoverlay').remove();
	        	$("#divrpta").html(e.rptadts);
	        	$("#modviewreply").modal("show");
	      	},
	      	error: function(jqXHR, exception) {
	          	var msgf = errorAjax(jqXHR, exception,'div' );
	          	$('#divboxhistorial #divoverlay').remove();
	          	$("#modviewreply modal-body").html(msgf);
	      	} 
	  	});
  		return false;
	})
	
</script>