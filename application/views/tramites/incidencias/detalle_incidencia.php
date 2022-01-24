<?php
	$vbaseurl = base_url();
	$agrupar = "";
	foreach ($detalle as $deta) {
		if ($deta->nombres != $agrupar) {
	        if($agrupar!="") echo "</div>";
	        $agrupar = $deta->nombres;
    	}
    }
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.css">
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divboxhistorial" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list mr-1"></i> DETALLE</h3>
		    	<div class="col-6 col-sm-3 col-md-3 card-tools no-padding">
                  	<form id="form_status" action="<?php $vbaseurl ?>" method="post" accept-charset="utf-8">
                  		<input type="hidden" name="txtcodigoinc" id="txtcodigoinc" value="<?php echo $deta->id ?>">
                  		<div class="form-group has-float-label col-lg-12 col-md-12 col-sm-12">
				        	<select name="txtstatus" id="txtstatus" class="form-control">
				        		<option <?php echo ($deta->estado == 'ENVIADO') ? 'selected' : '' ?> value="ENVIADO">ENVIADO</option>
				        		<option <?php echo ($deta->estado == 'REVISION') ? 'selected' : '' ?> value="REVISION">REVISION</option>
				        		<option <?php echo ($deta->estado == 'CERRADO') ? 'selected' : '' ?> value="CERRADO">CERRADO</option>
				        	</select>
				        	<label for="txtstatus">Estado</label>
				      	</div>
                  	</form>
                </div>
		    </div>
	      	<div class="card-body">
	      		<?php
	      			$agrupar = "";
	      			foreach ($detalle as $value) {
	      				if ($value->nombres != $agrupar) {
					        if($agrupar!="") echo "</div>";
					        $agrupar = $value->nombres;
	      		?>
	      			<div class="row">
	      				<div class="col-6 col-lg-4">
	      					<div class="info-box">
	      						<div class="info-box-content">
	      							<h5>Denunciante</h5>
			                  		<p><?php echo $value->nombres ?></p>
	      						</div>
			                  	
			                </div>
	      				</div>
	      				<div class="col-6 col-lg-4">
	      					<div class="info-box">
	      						<div class="info-box-content">
			                  		<h5>Documento</h5>
			                  		<p><?php echo $value->documento ?></p>
			                  	</div>
			                </div>
	      				</div>
	      				<div class="col-6 col-lg-4">
	      					<div class="info-box">
	      						<div class="info-box-content">
			                  		<h5>Domicilio</h5>
			                  		<p><?php echo $value->domicilio ?></p>
			                  	</div>
			                </div>
	      				</div>
	      				<div class="col-6 col-lg-4">
	      					<div class="info-box">
	      						<div class="info-box-content">
			                  		<h5>Distrito</h5>
			                  		<p><?php echo $value->distrito ?></p>
			                  	</div>
			                </div>
	      				</div>
	      				<div class="col-6 col-lg-4">
	      					<div class="info-box">
	      						<div class="info-box-content">
			                  		<h5>Denunciado</h5>
			                  		<p><?php echo $value->asunto ?></p>
			                  	</div>
			                </div>
	      				</div>
	      				<div class="col-12 col-lg-12">
	      					<div class="callout callout-info p-2">
			                  	<h5>Detalle</h5>
			                  	<p><?php echo $value->detalle ?></p>
			                </div>
	      				</div>
	      			</div>
	      		<?php
	      				}
	      			}

	      			if ($value->titulo != "") {

	      		?>
	      		<div class="card-body">
	      			<b class="d-block pt-2 pb-4 text-danger"><i class="fas fa-list"></i> PRUEBAS INCIDENCIA</b>
		      		<div id="divtabl-pruebas" class="col-12 col-md-12 neo-table">
						<div class="col-md-12 header d-none d-md-block">
							<div class="row font-weight-bold">
								
								<div class="col-12 col-md-12 group">
									<div class="col-2 col-md-2 cell d-none d-md-block">
										N°
									</div>
									<div class="col-8 col-md-8 cell">
										TITULO
									</div>
									<div class="col-2 col-md-2 cell text-center">
										ARCHIVO
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 body">
						<?php
		      			$nro = 0;
		      				foreach ($detalle as $prb) {
		      					
		      					$nro++;
		      			?>
		      					<div  class="row cfila <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
									<div class="col-12 col-md-12 group">
										<div class="col-2 col-md-2 cell">
											<span><?php echo $nro ;?></span>
										</div>
										<div class="col-8 col-md-8 cell">
											<?php echo $prb->titulo ?>
										</div>
										<div class="col-2 col-md-2 cell text-center">
											<span>
												<a class="btn-delete bg-success py-1 px-3 rounded" target="_blank" href="<?php echo base_url()."upload/incidencias/".$prb->archivo ?>" title="Descargar">
													<i class="fas fa-download"></i> 
												</a>
											</span>
										</div>
									</div>
								</div>
		      			<?php	
		      						
		      				}
		      			?>
						</div>
					</div>
	      		</div>
	      		<?php
	      		 	} else {
	      		 		echo '<div class="callout callout-warning">
			                  	<h5>Esta incidencia no tiene pruebas disponibles</h5>
			                </div>';
	      		 	}
	      		 ?>
	      		<hr>
	      		<div class="row" id="divbtn_reply">
	      			<div class="col-lg-12">
	      				<a href="#" id="btn_reply" class="btn btn-info btn-flat float-right"><i class="fas fa-reply"></i> Responder</a>
	      			</div>
	      		</div>
	      		<div class="row d-none" id="divcontent_reply">
	      			<div class="col-lg-12">
		      			<form id="form_reply" action="<?php echo $vbaseurl ?>sendmail/f_enviar_respuesta" method="post" accept-charset="utf-8">
		      				<input type="hidden" name="txtiduser" id="txtiduser" value="<?php echo $value->usuario ?>">
		      				<input type="hidden" name="txtincidencia" id="txtincidencia" value="<?php echo $value->id ?>">
		      				<div class="row">
		      					<div class="col-lg-12">
		      						<textarea name="txtreply" id="txtreply" class="form-control"></textarea>
		      					</div>
		      				</div>
		      				<div class="row">
		      					<div class="col-lg-6" id="divcardmsg">
		      						
		      					</div>
		      					<div class="col-lg-6">
		      						<button type="button" class="btn btn-flat btn-danger float-right" id="btncancel"><i class="fas fa-times"></i> Cancelar</button>
		      						<button type="submit" class="btn btn-flat btn-info float-right mr-3"><i class="fas fa-reply"></i> Responder</button>
		      					</div>
		      				</div>
		      			</form>
		      		</div>
	      		</div>
	      	</div>
	    </div>
	</section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/summernote8/lang/summernote-es-ES.js"></script>

<script type="text/javascript">
	
	$('#txtreply').summernote({
	    height: 200,
	    minHeight: 200, // set minimum height of editor
	    maxHeight: 800, // set maximum height of editor
	    focus: true,
	    lang: 'es-ES',
	    toolbar: [
	        ['style', ['bold', 'italic', 'underline', 'clear', 'style']],
	        ['fontsize', ['fontsize']],
	        ['color', ['color']],
	        ['list', ['ul', 'ol']],
	        ['para', ['paragraph']],
	        // ['table', ['table']],
	        // ['insert', ['link', 'picture', 'video']],
	        // ['otros', ['help', 'codeview']],
	    ],
	    dialogsFade: true,
	    
	});

	$('#btn_reply').click(function(e){
		e.preventDefault();
		$('#divcontent_reply').removeClass('d-none');
		$('#divbtn_reply').addClass('d-none');
	})

	$('#btncancel').click(function(e){
		e.preventDefault();
		$('#divcontent_reply').addClass('d-none');
		$('#divbtn_reply').removeClass('d-none');
	})

	$('#form_reply').submit(function(){
		$('#form_reply input,select,textarea').removeClass('is-invalid');
	    $('#form_reply .invalid-feedback').remove();
	    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		$.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	        	$('#divboxhistorial #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	            	var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#divcardmsg').html(msgf);
	                Swal.fire({
	                    title: e.mensaje,
	                    // text: "",
	                    icon: 'success',
	                    allowOutsideClick: false,
	                }).then((result) => {
	                  if (result.value) {
	                    location.reload();
	                  }
	                })
	            }
	        	
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divboxhistorial #divoverlay').remove();
	            
	           Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msgf,
                    backdrop: false,
                })
	        }
	    })
	    return false;
	})

	$('#form_status input,select').change(function(event) {
		var codigo = $('#txtcodigoinc').val();
	    if ($(this).attr('id') == "txtstatus") {
	        $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fa fa-spinner fa-pulse fa-3x"></i></div>');
	        var estado = $(this).val();
	        $.ajax({
	            url: base_url + 'incidencia/fn_updatestatus',
	            type: 'post',
	            dataType: 'json',
	            data: {
	                txtstatus: estado,
	                txtcodigo: codigo
	            },
	            success: function(e) {
	                $('#divboxhistorial #divoverlay').remove();
	                // $('#form_status #ficprovinc').html(e.vdata);
	            },
	            error: function(jqXHR, exception) {
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                // $('#form_status #ficprovinc').html("<option value='0'>" + msgf + "</option>");
	            }
	        });
	    }
	    return false;
	});

</script>