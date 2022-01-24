<style type="text/css">
/*	.post span a:hover{
		text-decoration: underline;
	}*/
</style>
<?php
	$vbaseurl=base_url();
	$participantes=array();
	$docparticipantes=array();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.css">
<div class="content-wrapper">

	<div class="modal fade" id="md_rpta_documents" tabindex="-1" role="dialog" aria-modal="true" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="md_en_estudiante">
                <div class="modal-header">
                    <h5 class="modal-title px-1" id="mv_title_estudiante">Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="" class="col-12">
                        	<iframe id="divfile_view" src="" style="width:100%; height:450px;" frameborder="0"></iframe>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1><?php echo $curso->unidad ?>
					<small> <?php echo $curso->codseccion.$curso->division; ?></small></h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item">
							<a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><i class="fas fa-caret-right"></i> Panel</a>
						</li>
						<li class="breadcrumb-item">
							<a href="<?php echo $vbaseurl.'curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><i class="fas fa-caret-right"></i> Aula virtual
							</a>
						</li>
						
						<li class="breadcrumb-item active">Foro</li>
					</ol>
				</div>
			</div>
		</div>
	</section>
		<section id="s-cargado" class="content">
			<?php include 'vw_aula_encabezado.php'; ?>
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
												// echo "<div class='col-12'>
												// 			<span>
												// 					$icon<a class='text-danger' href='$ira' target='_blank'>$deta->nombre </a>
												// 			</span>
												// 	</div>";

												echo "<div class='col-12'>
														<span class='py-1 d-block'>
				                                            <div class='btn-group btn-group-sm'>
				                                                <a class='py-1 px-2 btn btn-tool btn-sm dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
				                                                    <span class='small'>$icon $deta->nombre </span>
				                                                </a>
				                                                <div class='dropdown-menu dropdown-menu-right' role='menu'>
				                                                    <a href='$ira' class='dropdown-item'>
				                                                        <i class='fas fa-download'></i> Descargar
				                                                    </a>
				                                                    <a href='#' data-file='$deta->link' class='vw_content_file dropdown-item'>
				                                                        <i class='fas fa-eye'></i> Ver
				                                                    </a>
				                                                </div>
				                                            </div>
				                                        </span>
				                                    </div>";
											}?>
											</div>
										<?php	
										} ?>
									
								</div>
								<div class="row">
									<div class="col-12">
										<form class="form_foro" method="post" accept-charset="utf-8">
											<input type="hidden" name="codigopadre" value="0">
											<input type="hidden" name="codigoforo" value="<?php echo $mat->codigo ?>">
											<input type="hidden" name="codigosubmi" value="<?php echo $miembro ?>">
											<div class="row">
												<div class="col-md-12 mb-1">
													<textarea name="txtrespuesta" class="txtrpta form-control" required ></textarea>
													<button type="submit" class="btn btn-sm btn-primary float-right">Publicar <i class="fas fa-paper-plane"></i></button>
												</div>
											</div>
										</form>
									</div>
								</div>
								
								<div class="row">
									<!--<div class="col-md-12">-->
										
										<?php
										$deco_miembro=base64url_decode($miembro);
										
										
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
										<div class="col-12 fila-comentario">
											<div class="user-block bg-lightgray rounded p-2 mb-2">
												<img class="img-circle" src="<?php echo $vbaseurl ?>resources/fotos/<?php echo $cmtr->foto ?>" alt="User Image">
												<span class="username text-primary"><?php echo $cmtr->comentador ?></span>
												<span class="comment"><?php echo $cmtr->comentario ?></span>
												<div class="clearfix"></div>
												<span class="comment pb-1">
													<?php if ($mat->opc2 == 'SI'){ ?>
													<a href="ancla<?php echo $padrenow ?>" class="btn-rpt link-primary text-sm mr-5">Responder</a>
													<?php } ?>
													<span class="text-muted text-sm"><?php echo $cmtr->fecha ?></span>
												</span>
												
											</div>
											<div class="cm-rpts col-12 pl-5 ">
												<?php
												unset($comment[$keyc]);
												foreach ($comment as $keyc2 => $cmtwo) {
													
												if ($cmtwo->idpadre == $padrenow) { ?>
												
												<div class="user-block mb-3 bg-lightgray rounded p-2">
													<!-- User image -->
													<img class="img-circle img-sm" src="<?php echo $vbaseurl ?>resources/fotos/<?php echo $cmtwo->foto ?>" alt="User Image">
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
														<span class="text-muted text-sm"><?php echo $cmtwo->fecha ?></span>
													</span>
													<!-- /.comment-text -->
												</div>
												<!-- /.card-comment -->
												<?php
													//unset($comment[$keyc2]);
													}
												}
												
												?>
												<a name="ancla<?php echo $padrenow ?>"  id="ancla<?php echo $padrenow ?>"></a>
												<div class="col-12 fresponder_general">
													<form class="form_foro" method="post" accept-charset="utf-8">
														<input type="hidden" name="codigopadre" value="<?php echo $padrenow  ?>">
														<input type="hidden" name="codigoforo" value="<?php echo $mat->codigo ?>">
														<input type="hidden" name="codigosubmi" value="<?php echo $miembro ?>">
														<div class="row">
															<div class="col-md-12 mb-1">
																<textarea name="txtrespuesta" class="txtrpta form-control"  required></textarea>
																<button class="btn btn-rpt-cancel btn-sm btn-secondary float-left">Cancelar <i class="fas fa-undo"></i></button>

																<button type="submit" class="btn btn-sm btn-primary float-right">Publicar <i class="fas fa-paper-plane"></i></button>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
										
										
										<?php
											}
										}
										?>
									<!--</div>-->
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
		$(".fresponder_general").hide();
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
		$(".fresponder_general").hide();
		var divrpta=$(this).closest('.cm-rpts');
		divrpta.find('.fresponder_general').show();
		var ir = jQuery(this).attr('href');
		var new_position = jQuery('#'+ir).offset();
		window.scrollTo(new_position.left,new_position.top-150);
		return false;
	});

	$(".btn-rpt-cancel").click(function(e) {
		e.preventDefault();		
		var divrpta=$(this).closest('.fresponder_general');
		divrpta.hide();
		return false;
	});

	$(document).ready(function() {
		$.summernote.dom.emptyPara = "<div><br></div>"
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

	$(document).on('click', '.vw_content_file', function(e) {
        e.preventDefault();
        var boton = $(this);
        var archivo = boton.data('file');

        $('#md_en_estudiante').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#md_rpta_documents').modal();
        // $('#md_rpta_documents #divfile_view').html('<iframe src="http://docs.google.com/gview?url='+base_url+'upload/'+archivo+'&embedded=true" style="width:100%; height:450px;" frameborder="0"></iframe>');
        $('#md_rpta_documents #divfile_view').attr('src', 'http://docs.google.com/gview?url='+base_url+'upload/'+archivo+'&embedded=true');
        setTimeout(function() {
            $('#md_en_estudiante #divoverlay').remove();
            
        },6000);
        
    });

    $("#md_rpta_documents").on('hidden.bs.modal', function () {
        // $('#md_rpta_documents #divfile_view').html('');
        $('#md_rpta_documents #divfile_view').removeAttr('src');
    })

</script>