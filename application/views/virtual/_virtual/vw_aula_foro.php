<style type="text/css">
/*	.post span a:hover{
		text-decoration: underline;
	}*/
</style>
<?php
	$vbaseurl=base_url();
	
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.css">
<div class="content-wrapper">
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
							<a href="<?php echo $vbaseurl ?>alumno/aula-virtual"><i class="fas fa-compass"></i> Mis cursos</a>
						</li>
						<li class="breadcrumb-item">
							
							<a href="<?php echo $vbaseurl.'alumno/curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $curso->unidad ?>
							</a>
						</li>
						
						<li class="breadcrumb-item active">Asistencias</li>
					</ol>
				</div>
			</div>
			</div><!-- /.container-fluid -->
		</section>
		<section id="s-cargado" class="content">
			<div id="divcard-evaluaciones" class="card card-success">
				<div class="card-header with-border">
					<div class="row">
						<div id="divperiodo" class="col-12 col-md-4">Periodo: <b><?php echo $curso->periodo; ?></b></div>
						<div id="divcarrera" class="col-12 col-md-8">Carrera: <b><?php echo $curso->carrera; ?></b></div>
						<div id="divciclo" class="col-6 col-md-4">Ciclo: <b><?php echo $curso->codciclo; ?></b></div>
						<div id="divturno" class="col-6 col-md-4">Turno: <b><?php echo $curso->codturno; ?></b></div>
						<div id="divseccion" class="col-6 col-md-4">Sección: <b><?php echo $curso->codseccion.$curso->division; ?></b></div>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div id="divcard-inscripcion" class="card">
							
							<div class="card-header">
								<h3><?php echo $mat->nombre ?></h3>
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
										if (count($varchivos) > 0) {
											foreach ($varchivos as $deta) {
												$ext          = explode(".", $deta->nombre);
												$exten    = $ext[1];
												$ira = base_url()."upload/".$deta->link;
												$icon="<img class='mr-1' style='vertical-align: middle;display: inline-block' src='".base_url()."resources/img/icons/p_file.png' alt='ARCHIVO'>";
												if ($exten=="pdf"){
													$icon="<img class='ml-1' style='vertical-align: middle;display: inline-block' src='".base_url()."resources/img/icons/p_pdf.png' alt='PDF'>";
												
												}
												else if(($exten=="mp4")||$exten=="mpg"){
													$icon="<img class='mr-1' style='vertical-align: middle;display: inline-block' src='".base_url()."resources/img/icons/p_vdo.png' alt='VÍDEO'>";
												}
												else if(($exten=="jpg")||$exten=="png"){
													$icon="<img class='mr-1' style='vertical-align: middle;display: inline-block' src='".base_url()."resources/img/icons/p_img.png' alt='IMAGEN'>";
												}
												else if(($exten=="doc")||$exten=="docx"){
													$icon="<img class='mr-1' style='vertical-align: middle;display: inline-block' src='".base_url()."resources/img/icons/p_word.png' alt='WORD'>";
												}
												else if(($exten=="xls")||$exten=="xlsx"){
													$icon="<img class='mr-1' style='vertical-align: middle;display: inline-block' src='".base_url()."resources/img/icons/p_excel.png' alt='WORD'>";
												}
												echo "<div class='col-12'>
															<span>
																	$icon<a class='text-danger' href='$ira' target='_blank'>$deta->nombre </a>
															</span>
													</div>";
											}
										}
										
										?>
									</div>
									
								</div>
								<div class="row">
									<div class="col-12">
										<form class="form_foro" method="post" accept-charset="utf-8">
											<input type="hidden" name="codigopadre" value="0">
											<input type="hidden" name="codigoforo" value="<?php echo $mat->codigo ?>">
											<input type="hidden" name="codigosubmi" value="<?php echo $miembro ?>">
											<div class="row">
												<div class="col-md-12 mb-1">
													<textarea name="txtrespuesta" class="txtrpta form-control" ></textarea>
													<button type="submit" class="btn btn-sm btn-primary float-right">Publicar <i class="fas fa-paper-plane"></i></button>
												</div>
											</div>
										</form>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-12">
										
										<?php
										$deco_miembro=base64url_decode($miembro);
										
										
										
										foreach ($comment as $keyc => $cmtr) {
											
											$padrenow=$cmtr->codigo;
											if ($cmtr->idpadre==0){
										?>
										<div class="fila-comentario">
											<div class="user-block bg-lightgray rounded p-2 mb-2">
												<img class="img-circle" src="<?php echo base_url() ?>resources/fotos/<?php echo $cmtr->foto ?>" alt="User Image">
												<span class="username text-primary"><?php echo $cmtr->comentador ?></span>
												<!--<span class="description">Publicado - <?php echo $cmtr->fecha ?></span>-->
												
												<span class="comment"><?php echo $cmtr->comentario ?></span>
												<div class="clearfix"></div>
												<span class="comment pb-1">
													<?php if ($mat->opc2 == 'SI'){ ?>
													<a href="ancla<?php echo $padrenow ?>" class="btn-rpt link-primary text-sm mr-5">Responder</a>
													<?php } ?>
													<span class="text-muted text-sm"><?php echo $cmtr->fecha ?></span>
												</span>
												
											</div>
											<!-- /.card-header -->
											<div class="cm-rpts col-12 pl-5">
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
														<span class="text-muted text-sm"><?php echo $cmtwo->fecha ?></span>
													</span>
													<!-- /.comment-text -->
												</div>
												<!-- /.card-comment -->
												<?php
													unset($comment[$keyc2]);
													}
												}
												
												?>
												<a name="ancla<?php echo $padrenow ?>"  id="ancla<?php echo $padrenow ?>"></a>
												<div class="row fresponder_general">
													
													<div class="col-12">
														<form class="form_foro" method="post" accept-charset="utf-8">
															<input type="hidden" name="codigopadre" value="<?php echo $padrenow  ?>">
															<input type="hidden" name="codigoforo" value="<?php echo $mat->codigo ?>">
															<input type="hidden" name="codigosubmi" value="<?php echo $miembro ?>">
															<div class="row">
																<div class="col-md-12 mb-1">
																	<textarea name="txtrespuesta" class="txtrpta form-control" ></textarea>
																	<button type="submit" class="btn btn-sm btn-primary float-right">Publicar <i class="fas fa-paper-plane"></i></button>
																</div>
															</div>
														</form>
													</div>
												</div>
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
    	$('.txtrpta').summernote(
    		{
        	height: 100,
        	placeholder: 'Escriba Aquí su Respuesta...!',
        	dialogsFade: true,
        	callbacks: {
	            onImageUpload: function(image) {
	            	var txtrt=$(this);
	                uploadImage(image[0],txtrt);
	            }, 
				onMediaDelete : function(target) {
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