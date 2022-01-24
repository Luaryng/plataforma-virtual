<style type="text/css">
/*	.post span a:hover{
		text-decoration: underline;
	}*/
</style>
<?php
	$vbaseurl=base_url();
	$codcarga64=base64url_encode($curso->codcarga);
	$coddivision64=base64url_encode($curso->division);
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.css">
<div class="content-wrapper">

		<section id="s-cargado" class="content">
			<?php include 'vw_curso_encabezado_items_aula.php'; ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div id="divcard-inscripcion" class="card">
							
							<div class="card-header">
								<div class="card-tools">
                 				 	<!--<span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">3</span>-->

				                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#vw_md_fr_estadistica" title="Estadísticas">
				                    <i class="fas fa-comments"> Estadísticas</i>
				                  </button>
				                </div>
								<h3 class="card-title text-bold"><?php echo $mat->nombre ?></h3>
							</div>
							<div class="card-body">
								
								<!-- Post -->
								<div class="post">
									
									<!-- /.user-block -->
									<p>
										<?php echo $mat->detalle ?>
									</p>
									<div class="row mb-3">
										<?php
										if (count($varchivos) > 0) { ?>
											<div class="row mb-2">
											<?php foreach ($varchivos as $deta) {
												$ira = base_url()."upload/".$deta->link;
												$icon=getIcono('P',$deta->nombre);
												echo "<div class='col-12'>
															<span>
																	$icon<a class='text-danger' href='$ira' target='_blank'>$deta->nombre </a>
															</span>
													</div>";
											}?>
											</div>
										<?php	
										} ?>
									
								</div>
								
								
								<div class="row">
									<div class="col-md-12">
										
										<?php
										$partdocente="";
										$ndocentes=0;
										foreach ($comment as $keyc => $cmtr) {
											if ($cmtr->idmiem==0){
												if ($partdocente!=$cmtr->comentador){
													$ndocentes++;
													$partdocente=$cmtr->comentador;
													$docparticipantes["D".$ndocentes]["nombre"]=$cmtr->comentador;
													$docparticipantes["D".$ndocentes]["cm"]=0;
													$docparticipantes["D".$ndocentes]["rp"]=0;
												}
												if ($cmtr->idpadre==0){
													$docparticipantes["D".$ndocentes]["cm"]++;
												}
												else{
													$docparticipantes["D".$ndocentes]["rp"]++;	
												}
											}
											else{
												if (!isset($participantes[$cmtr->idmiem])) {
													$participantes[$cmtr->idmiem]=array();
													$participantes[$cmtr->idmiem]['cm']=0;
													$participantes[$cmtr->idmiem]['rp']=0;
												}
												
												if ($cmtr->idpadre==0){
													$participantes[$cmtr->idmiem]["cm"]++;
												}
												else{
													$participantes[$cmtr->idmiem]["rp"]++;	
												}
												
												
											}
											$padrenow=$cmtr->codigo;
											if ($cmtr->idpadre==0){
										?>
										<div class="fila-comentario">
											<div class="user-block bg-lightgray rounded p-2 mb-2">
												<img class="img-circle" src="<?php echo base_url() ?>resources/fotos/<?php echo $cmtr->foto ?>" alt="User Image">
												<span class="username text-primary"><?php echo $cmtr->comentador ?></span>
												<span class="comment"><?php echo $cmtr->comentario ?></span>
												<div class="clearfix"></div>
												<span class="comment pb-1">
													<!--$cmtr->fecha-->
													<small class="text-muted "><?php echo date("d/m/Y H:i: a", strtotime($cmtr->fecha)); ?></small>
												</span>
												
											</div>
											<div class="cm-rpts col-12 pl-5 ">
												<?php
												unset($comment[$keyc]);
												foreach ($comment as $keyc2 => $cmtwo) {
													
												if ($cmtwo->idpadre == $padrenow) { ?>
												
												<div class="user-block mb-3 bg-lightgray rounded p-2">
													<!-- User image -->
													<img class="img-circle img-sm" src="<?php echo base_url() ?>resources/fotos/<?php echo $cmtwo->foto ?>" alt="User Image">
													<span class="username">
														<?php echo $cmtwo->comentador ?>
													</span>
													<div class="comment">
														<?php echo $cmtwo->comentario ?>
													</div>
													<div class="clearfix"></div>
													
													<span class="comment pb-1">
														<?php if ($mat->opc2 == 'SI'){ ?>
														<a href="ancla<?php echo $padrenow ?>" class="btn-rpt-rpta link-primary text-sm mr-5">Responder</a>
														<?php } ?>
														<span class="text-muted text-sm"><?php echo date("d/m/Y H:i: a", strtotime($cmtwo->fecha)); ?></span>
													</span>
													<!-- /.comment-text -->
												</div>
												<!-- /.card-comment -->
												<?php
													//unset($comment[$keyc2]);
													}
												}
												
												?>
												
												
											</div>
										</div>
										
										
										<?php
											}
										}
										?>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</section>
		<div class="modal fade" id="vw_md_fr_estadistica" role="dialog" data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog modal-lg">
				 <div class="modal-content">
	      
			        <!-- Modal Header -->
			        <div class="modal-header">
			          <h4 class="modal-title">Foro Estadísticas</h4>
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			        </div>
					<div class="modal-body">
						
						<div class="col-12">
							<div class="row">
								<div class="col-8 border text-bold ">DOCENTE</div>
								<div class="col-2 border text-bold text-center">Coment.</div>
								<div class="col-2 border text-bold text-center">Rpts</div>
							</div>
							<?php foreach ($docparticipantes as $docp): ?>
								<div class="row">
								<div class="col-8 border "><?php echo $docp['nombre'] ?></div>
								<div class="col-2 border text-center"><?php echo $docp['cm'] ?></div>
								<div class="col-2 border text-center"><?php echo $docp['rp'] ?></div>
							</div>
							<?php endforeach ?>
						</div>
						<br>
						<div class="col-12">
							<div class="row">
								<div class="col-8 border text-bold ">PARTICIPANTE</div>
								<div class="col-2 border text-bold text-center">Coment.</div>
								<div class="col-2 border text-bold text-center">Rpts</div>
							</div>
							<?php 
							$nro=0;
							foreach ($miembros as $mb){ 
								$nro++;
								$cm=0;
								$rp=0;
								if (isset($participantes[$mb->idmiembro])){
									$pt=$participantes[$mb->idmiembro];
									$cm=$pt['cm'];
									$rp=$pt['rp'];
								}
								?>
							<div class="row rowcolor">
								<div class="col-8 border "><?php echo str_pad($nro, 2, "0", STR_PAD_LEFT).". $mb->paterno $mb->materno $mb->nombres" ?></div>
								<div class="col-2 border text-center"><?php echo $cm ?></div>
								<div class="col-2 border text-center"><?php echo $rp ?></div>
							</div>
							<?php } ?>
						</div>
						
						
					</div>
					<div class="modal-footer">
						<button class="btn btn-secondary" type="button" class="btn pull-right" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
	</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.js"></script>

<script type="text/javascript">
	$(".fresponder_general").hide();

	$(".btn-rpt").click(function(e) {
		e.preventDefault();		
		var divfila=$(this).closest('.fila-comentario');
		var divrpta=$(divfila.find('.cm-rpts'));
		divrpta.find('.fresponder_general').show();

		var ir = jQuery(this).attr('href');
		var new_position = jQuery('#'+ir).offset();
		window.scrollTo(new_position.left,new_position.top-150);
		return false;
	});
	$(".btn-rpt-rpta").click(function(e) {
		e.preventDefault();		
		var divrpta=$(this).closest('.cm-rpts');
		divrpta.find('.fresponder_general').show();
		var ir = jQuery(this).attr('href');
		var new_position = jQuery('#'+ir).offset();
		window.scrollTo(new_position.left,new_position.top-150);
		return false;
	});

	$(document).ready(function() {
    	$('.txtrpta').summernote({
		    height: 100,
		    minHeight: 100, // set minimum height of editor
		    maxHeight: 800, // set maximum height of editor
		    focus: true,
		    toolbar: [
		        // [groupName, [list of button]]
		        ['style', ['bold', 'italic', 'underline', 'clear']],
		        ['font', ['strikethrough', 'superscript', 'subscript']],
		        ['fontsize', ['fontsize']],
		        ['color', ['color']],
		        ['list', ['ul', 'ol']],
		        ['para', ['paragraph']],
		        ['insert', ['link', 'picture', 'video']],
		    ],
		    dialogsFade: true,
		    callbacks: {
		        onImageUpload: function(image) {
		            var txtrt = $(this);
		            uploadImage(image[0], txtrt);
		        },
		        onMediaDelete: function(target) {
		            deleteFile(target[0].src);
		        }
		    }
		});
    	$.summernote.dom.emptyPara = "<div><br></div>"
	    function uploadImage(image, tarea) {
	        var data = new FormData();
	        data.append("file", image);
	        $.ajax({
	            url: base_url + "virtualalumno/uploadimages",
	            cache: false,
	            contentType: false,
	            processData: false,
	            data: data,
	            type: "post",
	            success: function(url) {
	                var image = $('<img>').attr('src', base_url + url);
	                tarea.summernote("insertNode", image[0]);
	            },
	            error: function(data) {
	                console.log(data);
	            }
	        });
	    }

	    function deleteFile(src) { 
	    	$.ajax({ 
	    		data: {src : src}, 
	    		type: "POST", 
	    		url: base_url + "virtualalumno/delete_file", // replace with your url 
	    		cache: false, 
	    		success: function(resp) { 
	    			console.log(resp); 
	    		} 
	    	}); 
	    } 
    });

    $('.form_foro').submit(function() {
    	var form=$(this);
	    //form.find('input,select').removeClass('is-invalid');
	    //$('#form_foro .invalid-feedback').remove();
	    $('#divcard-inscripcion').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    var formData = form.serialize();
	    $.ajax({
	           url: base_url + 'virtual/fn_insert_comentario',
		       type: 'POST',
		        data: formData,
		        dataType: 'json',
	        success: function(e) {
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                if( $('#fictxtport').val() == 0){
	                	$('#fictxtport').addClass('is-invalid');
	                    $('#fictxtport').parent().append("<div class='invalid-feedback'>" + e.errimg + "</div>");
	                }
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                //$('#divmsgnotic').html(msgf);
	                Swal.fire({
	                    title: e.msg,
	                    type: 'success',
	                    allowOutsideClick: false,
                  		showConfirmButton: true,
	                }).then((result) => {
	                  if (result.value) {
	                    location.reload();
	                  }
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divcard-inscripcion #divoverlay').remove();
	            $('#divmsgnotic').show();
	            $('#divmsgnotic').html(msgf);
	        }
	    });
	    return false;
	});

</script>