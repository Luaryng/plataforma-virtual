<?php
	$vbaseurl=base_url();
	$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
?>

<?php echo "<script src='{$vbaseurl}resources/plugins/simpleUpload/simpleUpload.min.js'></script>"; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="modal fade" tabindex="-1" id="md_videoconferencia" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Generar Videoconferencia</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div id="md_vd_generar">
					<div class="modal-body">
						<input type="hidden" class="form-control" id="md_vc_idsesion">
						<input type="hidden" id="md_vc_division" value="<?php echo base64url_encode($curso->division) ?>">
						<input type="hidden" id="md_vc_carga" value="<?php echo base64url_encode($curso->codcarga) ?>">
						<input type="hidden" id="md_vc_fecha" value="">
						<input type="hidden" id="md_vc_fecha_final" value="">
						<span>Titulo</span>
						<input type="text" class="form-control" id="md_vc_titulo">
						<span>Descripción</span>
						<textarea class="form-control" rows="2" id="md_vc_descripcion"></textarea>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-primary btn_videoconferencia">Generar</button>
					</div>
				</div>
				<div id="md_vd_generando">
					<div class="modal-body text-center">
						<br>
						<br>
						<br>
						<i class="fas fa-spinner fa-pulse fa-3x"></i>
						<h4>GENERANDO</h4> 
					</div>
					
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
							<a href="<?php echo $vbaseurl ?>docente/mis-cursos"><i class="fas fa-compass"></i> Mis Unidades didácticas</a>
						</li>
						<li class="breadcrumb-item">
							
							<a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $curso->unidad ?>
							</a>
						</li>
						
						<li class="breadcrumb-item active">Sesiones</li>
					</ol>
				</div>
			</div>
			</div><!-- /.container-fluid -->
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-md-9">
					<?php include 'vw_curso_encabezado.php'; ?>
				</div>
				<div class="col-md-3">
					<a id="btncalladdsesion" href="#" class="btn btn-primary btn-block" data-ssc='<?php echo $curso->division ?>' data-carga='<?php echo $curso->codcarga ?>'><i class="fa fa-plus"></i><br> Agregar Sesión</a>
				</div>
			</div>
			
			<div id="divboxmissesiones" class="card">
				<div class="card-header">
					<h3 class="card-title">Clases diarias</h3>
				</div>
				<div class="card-body">
					<div class="card border border-success p-3" id="divsesionprocesos">
						
					</div>
					<div class="col-12" id="divsesioneditar">
						
					</div>
					
					
					
					
					
					<?php
					$item=0;
					$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
					foreach ($sesiones as $key => $ss) {
						$item++;
						$date = new DateTime($ss->fecha);
						$vfecha= $date->format('d/m/Y');
						$hini = new DateTime($ss->hini);
						$hfin = new DateTime($ss->hfin);
						
						$vfecha= $date->format('d/m/Y');
						$vnroses=str_pad($ss->nrosesion, 2, "0", STR_PAD_LEFT);
					?>
					
					<!-- DIRECT CHAT -->
					<div class="card border border-primary div-sesion" data-titulo='SESIÓN <?php echo $vnroses ?>' data-detalle=' <?php echo $ss->detalle ?>' data-sesion="<?php echo base64url_encode($ss->id) ?>" data-file="<?php echo $ss->linkf ?>" data-fecha='<?php echo $ss->fecha.' '.$hini->format('H:i') ?>' data-fefinal='<?php echo $ss->fecha.' '.$hfin->format('H:i') ?>'>
						<div class="card-header">
							<h3 class="card-title text-bold" data-toggle="tooltip" title="<?php echo $ss->id ?>">
							<i class="fa fa-angle-double-right text-success"></i>
							SESIÓN <?php echo $vnroses." - ".$ss->tipo ?>
							</h3>
							<div class="card-tools">
								<!--<button type="button" class="btn btn-tool bg-secondary linkduplicar" data-toggle="tooltip" title="Duplicar">
										<i class="far fa-clone"></i>
								</button>-->
								<span data-toggle="tooltip" title="Agregar archivo">
									<button id="vw_mpc_btn_selecionar" type="button" class="btn btn-tool bg-warning vw_mpc_btn_selecionar">
										<i class="fas fa-paperclip mr-1 text-white"></i><b class="text-white">+</b>
									</button>
								</span>
								
								<button type="button" class="btn btn-tool bg-info linkeditar" data-toggle="tooltip" title="Editar">
								<i class="fas fa-pen"></i>
								</button>
								
								<a data-toggle="tooltip" title="Asistencia" class="btn btn-tool bg-success" href="<?php echo base_url().'curso/asistencia-sesion/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($ss->id); ?>">
									<i class="far fa-calendar-alt"></i>
								</a>
								<button type="button" class="btn btn-tool bg-danger btn-delses" data-toggle="tooltip" title="Eliminar">
								<i class="fas fa-trash"></i>
								</button>
								<div class="btn-group">
								  <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <i class="fas fa-cog"></i>
								  </button>
								  <div class="dropdown-menu dropdown-menu-right">
								    <a class="dropdown-item linkduplicar" href="#"><i class="far fa-clone mr-1"></i> Duplicar</a>
								    <a class="dropdown-item linkeditar" href="#"><i class="fas fa-pen mr-1"></i> Editar</a>
								    <div class="dropdown-divider"></div>
								    <a class="dropdown-item" href="<?php echo base_url().'curso/asistencia-sesion/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($ss->id); ?>"><i class="far fa-calendar-alt mr-1"></i> Asistencia</a>
								    <a class="dropdown-item btn-delses" href="#"><i class="fas fa-trash mr-1"></i> Elimnar</a>
								  </div>
								</div>
							</div>
							<div class="divcard-file" id="divcard-<?php echo base64url_encode($ss->id) ?>">
								<input type="file" class="form-control vw_mpc_file" name="vw_mpc_file" id="vw_mpc_file" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx">
							</div>
							
						</div>
						<!-- /.card-header -->
						<div class="card-body p-3">
							<div class="row">
								<div class="col-md-12">
									<span><?php echo $ss->detalle ?></span><br>
									<u> <?php echo $dias[date("w", strtotime($ss->fecha))]."</u> ".$vfecha." ".$hini->format('h:i a')." - ".$hfin->format('h:i a'); ?>
								</div>
								<div class="col-12">
									
									
										<?php 
										if (trim($ss->hlink)==""){
											 if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
												echo "<a target='_blank' class='vd_link' href=''></a>";
												echo 
												"<button type='button' class='btn btn-tool bg-primary my-2 vd_btn_glink' data-toggle='modal' data-target='#md_videoconferencia'>
													<i class='fas fa-video'></i><b> Generar Videoconferencia</b>
												</button><br>";
												echo "<span class='text-success'>En caso de no poder generar la videoconferencia <a class='btn btn-sm btn-warning' href='".base_url()."gmail-cerrar-sesion'>Clic aquí</a> y vuelva  ingresar a la plataforma.<span>";

											 }
										}
										else{
											echo "<a target='_blank' data-carga='".base64url_encode($curso->codcarga)."' data-division='".base64url_encode($curso->division)."' data-unidad='".base64url_encode($curso->codunidad)."' class='vd_link mr-2 btn_ses_asist' href='$ss->hlink'>$ss->hlink</a>";
											echo "<a target='_blank' href='$ss->hlink' class='btn btn-tool bg-primary btn_ses_asist' data-carga='".base64url_encode($curso->codcarga)."' data-division='".base64url_encode($curso->division)."' data-unidad='".base64url_encode($curso->codunidad)."'><i class='fas fa-video'></i> Unirte</a>";
										}
										
									?>
									<!--<div class="input-group">
										
										<input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
										<div class="input-group-append">
											<button class="btn btn-outline-secondary" type="button"><i class="fas fa-edit"></i></button>
											<button class="btn btn-outline-secondary" type="button"><i class="fas fa-magic"></i></button>
										</div>
									</div>-->
								</div>
								<!-- <div class="row"> -->
									<div class="col-12">
										<small class="pt-2" id="vw_mpc_txt_filename-<?php echo base64url_encode($ss->id) ?>"></small>
										<div id="vw_mpc_txt_progress-<?php echo base64url_encode($ss->id) ?>"></div>
										<div id="vw_mpc_txt_size-<?php echo base64url_encode($ss->id) ?>"></div>
										<div id="vw_mpc_txt_type-<?php echo base64url_encode($ss->id) ?>"></div>
										<div id="vw_mpc_pgBar-<?php echo base64url_encode($ss->id) ?>"></div>
									</div>
								<!-- </div> -->
								<div class="col-12 mt-2">
									<a target="_blank" class="fl_link" href="<?php echo base_url().'upload/docweb/'. $ss->linkf ?>">
										<?php echo ($ss->archivo != "") ? getIcono('P',$ss->linkf).' '.$ss->archivo.' ('.formatBytes($ss->pesof).')' : ""?>
									</a>
								</div>
							</div>
						</div>
						<!-- /.card-body -->
						
					</div>
					<!--/.direct-chat -->
					
					
					<?php } ?>
					
					
					
				</div>
				
			</div>
		</section>
	</div>
	<script>
		var curso_nombre='<?php echo $curso->unidad ?>';
		$(document).ready(function() {

			$(".vw_mpc_file").hide();
		    $(".vw_mpc_txt_size").hide();
		    $(".vw_mpc_txt_type").hide();

			$('#divsesioneditar').hide();
			$('#divsesionprocesos').hide();
			$('#md_vd_generando').hide();
			$('#md_vd_generar').hide();
			
		});

		$('.btn-delses').click(function(event) {
			var fila=$(this).closest('.div-sesion');
			var vses=fila.data('sesion');
			Swal.fire({
				title: '¿Deseas eliminar el la sesión ?',
				text: "Al eliminar, tambien se perderan las asistencias registradas en esta sesión",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Si, eliminar!'
				}).then((result) => {
				if (result.value) {
					$.ajax({
					url:  base_url + 'sesion/feliminar',
					type: 'POST',
					data: {sesion: vses},
					dataType: 'json',
					success: function(e) {
						if (e.status==true){
										Swal.fire(
									'Eliminado!',
									'La SESIÓN fue eliminado correctamente.',
									'success'
									)
									fila.remove();
						}
						else{
							resolve(e.msg);
						}
					},
					error: function(jqXHR, exception) {
						//$('#divcard_grupo #divoverlay').remove();
					var msgf = errorAjax(jqXHR, exception, 'text');
					Swal.fire(
									'Error!',
									msgf,
									'success'
									)
					}
					})
				}
			})
			return false;
		});

		$('#btncalladdsesion').click(function(event) {
			$('#divboxmissesiones').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			$('#divsesioneditar').hide();
			$('#divsesionprocesos').show();
			$.ajax({
					url: base_url + 'sesion/vw_curso_sesiones_agregar',
					type: 'post',
					dataType: 'json',
					
					success: function(e) {
						$('#divboxmissesiones #divoverlay').remove();
						if (e.status == false) {
							
							var msgf='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg +'</div>';
							$('#divsesionprocesos').html(msgf);
						}
						else {
							$('#divsesionprocesos').html(e.vdata);
						
						}
					},
				error: function (jqXHR, exception) {
					var msgf=errorAjax(jqXHR, exception,'div');
				$('#divboxmissesiones #divoverlay').remove();
				$('#divsesionprocesos').html(msgf);
			},
				});
		});

		$('.linkeditar').click(function(event) {
			$('#divsesioneditar').show();
			$('#divsesionprocesos').hide();
			var div=$(this).closest('.div-sesion');
			var vses=div.data('sesion');
			div.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			div.append($('#divsesioneditar'));
			$.ajax({
							url: base_url + 'sesion/vw_curso_sesiones_editar'	,
					type: 'post',
					dataType: 'json',
					data: {sesion: vses},
					success: function(e) {
						div.find('#divoverlay').remove();
						if (e.status == false) {
							var msgf='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg +'</div>';
							$('#divsesioneditar').html(msgf);
						}
						else {
							$('#divsesioneditar').html(e.vdata);
							$('#fedittxtnrosesion').focus();

						    calculardiferencia('#frmsesionedit');
						}
					},
				error: function (jqXHR, exception) {
					var msgf=errorAjax(jqXHR, exception,'div');
					div.find('#divoverlay').remove();
					Swal.fire('Error!',msgf,'success')
				},
			});
			return false;
		});

		var div_sesion_activa;
		$('#md_videoconferencia').on('show.bs.modal', function (e) {
			$('#md_vd_generar').show();
			$('#md_vd_generando').hide();
			var btn=$(e.relatedTarget);
			div_sesion_activa=btn.closest('.div-sesion');
			var vses=div_sesion_activa.data('sesion');
			var vtitu=curso_nombre + ":" + div_sesion_activa.data('titulo');
			var vdesc=div_sesion_activa.data('detalle');
			var fecha = div_sesion_activa.data('fecha');
			console.log("fecha", fecha);
			var final = div_sesion_activa.data('fefinal');
			
			$('#md_vc_fecha').val(fecha);
			$('#md_vc_fecha_final').val(final);
			$('#md_vc_idsesion').val(vses);
			$('#md_vc_titulo').val(vtitu);
			$('#md_vc_descripcion').val(vdesc);

		})
		
		$('.btn_videoconferencia').click(function(event) {
			$('#divsesioneditar').hide();
			$('#divsesionprocesos').hide();

			$('#md_vd_generar').hide();
			$('#md_vd_generando').show();
			
			var hoy = new Date();
			var fecha = $('#md_vc_fecha').val();
			var final_se = $('#md_vc_fecha_final').val();
			var dia = hoy.getDate();
			var mes = hoy.getMonth()+1;
			var anio = hoy.getFullYear();
			var hora = hoy.getHours();
			var minuto = hoy.getMinutes();
			var fecha_hoy = anio+'-'+(mes < 10 ? '0' : '')+mes+'-'+(dia < 10 ? '0' : '')+dia+' '+(hora < 10 ? '0' : '')+hora+':'+(minuto < 10 ? '0' : '')+minuto;
			var fechaFormulario = Date.parse(fecha);
			var fechafin = Date.parse(final_se);
			var fechastring = Date.parse(fecha_hoy);


			//if (fechastring <= fechaFormulario) {

				var vses= $('#md_vc_idsesion').val();
				var vtitulo= $('#md_vc_titulo').val();
				var vdescripcion= $('#md_vc_descripcion').val();
				var vdivision = $('#md_vc_division').val();
				var vcarga = $('#md_vc_carga').val();
				$('#divboxmissesiones').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
				$.ajax({
					url: base_url + 'sesion/fn_crear_videoconferencia'	,
					type: 'post',
					dataType: 'json',
					data: {txtsesion: vses,txttitulo:vtitulo,txtdescripcion:vdescripcion,txtdivision:vdivision,txtcarga:vcarga,txtfuetiempo:'NO'},
					success: function(e) {
						$('#divboxmissesiones #divoverlay').remove();
						$('#md_vd_generar').show();
						$('#md_vd_generando').hide();
						if (e.status == false) {
							Swal.fire('Error Success!',e.msg,'error')
							
							
						}
						else {
							
							vlink=div_sesion_activa.find('.vd_link');
							vlink.html(e.link);
							vlink.attr('href', e.link);
							vlink.append("<a target='_blank' href='"+e.link+"' class='btn btn-tool bg-primary'><i class='fas fa-video mr-1'></i> Unirte</a>");
							vbtnlink=div_sesion_activa.find('.vd_btn_glink');
							vbtnlink.hide();
							div_sesion_activa=null;
							$('#md_videoconferencia').modal('hide');

						
						}
					},
					error: function (jqXHR, exception) {
						var msgf=errorAjax(jqXHR, exception,'div');
						$('#md_vd_generar').show();
						$('#md_vd_generando').hide();
						$('#divboxmissesiones #divoverlay').remove();
						Swal.fire('Error!',msgf,'error')
					},
				});
			/*} else {
				if (fechastring < fechafin) {
					fuetiempo = 'SI';
					msgfuetiempo = '<span class="text-success">¿Deseas generarlo de todas formas?</span>';
					confirmacion = true;
					textcancel = 'NO';
					icono = 'warning';
				} else {
					fuetiempo = 'NO';
					msgfuetiempo = '';
					confirmacion = false;
					textcancel = 'OK';
					icono = 'error';
				}

				Swal.fire({
	                title: '<span>La fecha y hora de inicio designada ya pasó</span>',
	                icon: icono,
	                type: icono,
	                html: msgfuetiempo,
	                backdrop: false,
	                showCancelButton: true,
	                showConfirmButton: confirmacion,
	                confirmButtonText: 'Si',
	                cancelButtonText: textcancel
	            }).then((result) => {
					if (result.value) {
						$('#md_vd_generar').hide();
						$('#md_vd_generando').show();
					    var vses= $('#md_vc_idsesion').val();
						var vtitulo= $('#md_vc_titulo').val();
						var vdescripcion= $('#md_vc_descripcion').val();
						var vdivision = $('#md_vc_division').val();
						var vcarga = $('#md_vc_carga').val();
						$('#divboxmissesiones').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
						$.ajax({
							url: base_url + 'sesion/fn_crear_videoconferencia'	,
							type: 'post',
							dataType: 'json',
							data: {txtsesion: vses,txttitulo:vtitulo,txtdescripcion:vdescripcion,txtdivision:vdivision,txtcarga:vcarga,txtfuetiempo:fuetiempo},
							success: function(e) {
								$('#divboxmissesiones #divoverlay').remove();
								$('#md_vd_generar').show();
								$('#md_vd_generando').hide();
								if (e.status == false) {
									Swal.fire('Error!',e.msg,'error')
									
									
								}
								else {
									
									vlink=div_sesion_activa.find('.vd_link');
									vlink.html(e.link);
									vlink.attr('href', e.link);
									vlink.append("<a target='_blank' href='"+e.link+"' class='btn btn-tool bg-primary'><i class='fas fa-video'></i> Unirte</a>");
									vbtnlink=div_sesion_activa.find('.vd_btn_glink');
									vbtnlink.hide();
									div_sesion_activa=null;
									$('#md_videoconferencia').modal('hide');

								
								}
							},
							error: function (jqXHR, exception) {
								var msgf=errorAjax(jqXHR, exception,'div');
								$('#md_vd_generar').show();
								$('#md_vd_generando').hide();
								$('#divboxmissesiones #divoverlay').remove();
								Swal.fire('Error!',msgf,'error')
							},
						});
					} 
					else if (result.dismiss === Swal.DismissReason.cancel) {
					    $('#md_videoconferencia').modal('hide');
					}
				});

	            $('#md_vd_generar').show();
				$('#md_vd_generando').hide();
			}*/
			
			return false;
		});

		$('.vw_mpc_btn_selecionar').click(function(e) {
		    event.preventDefault();
	        var btn=$(this);
	        var div_sesion_activa=btn.closest('.div-sesion');
		    var vses=div_sesion_activa.data('sesion');
		    
		    $("#divcard-"+vses+" .vw_mpc_file").trigger('click');
		    
		});

		var arrayarchivos = [];
		$('.vw_mpc_file').change(function(e) {
			var btn=$(this);
			div_sesion_activa=btn.closest('.div-sesion');
			var vses = div_sesion_activa.data('sesion');
			var vfile=div_sesion_activa.data('file');


		    $('#divboxmissesiones').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		    $(".vw_mpc_file").simpleUpload(base_url + "sesion/fn_upload_file_sesion?txtsesion="+vses+"&rutafile="+vfile, {
		        allowedExts: ["jpg", "jpeg", "png", "pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx"],
		        //allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
		        maxFileSize: 10485760, //10MB in bytes
		        start: function(file) {
		            //upload started
		            $('#vw_mpc_txt_filename-'+vses).html(file.name);
		            $('#vw_mpc_txt_size-'+vses).html(file.size);
		            $('#vw_mpc_txt_type-'+vses).html(file.type);
		            $('#vw_mpc_txt_progress-'+vses).html("");
		            $('#vw_mpc_pgBar-'+vses).width(0);
		            $('#vw_mpc_txt_progress-'+vses).show();
		            $('#vw_mpc_pgBar-'+vses).show();
		            $('#vw_mpc_txt_filename-'+vses).hide();
		            $('#vw_mpc_txt_size-'+vses).hide();
		            $('#vw_mpc_txt_type-'+vses).hide();

		            
		        },
		        progress: function(progress) {
		            //received progress
		            $('#vw_mpc_txt_progress-'+vses).html("Progress: " + Math.round(progress) + "%");
		            $('#vw_mpc_pgBar-'+vses).width(progress + "%");
		        },
		        success: function(data) {
		            //upload successful
		            //$('#progress').html("Success!<br>Data: " + JSON.stringify(data));
		            $('#vw_mpc_txt_progress-'+vses).hide();
		            $('#vw_mpc_pgBar-'+vses).hide();
		            //AGREGAR ARCHIVO A LA LISTA
		            //i.link,i.name,i.size,i.type,i.fileid
		            $('#divboxmissesiones #divoverlay').remove();
		            var newarchivo = [data.link, $('#vw_mpc_txt_filename-'+vses).html(), $('#vw_mpc_txt_size-'+vses).html(), $('#vw_mpc_txt_type-'+vses).html()];
		            arrayarchivos.push(newarchivo);

		            flink=div_sesion_activa.find('.fl_link');
					flink.html(data.filedata);
					flink.attr('href', data.rutafile);
					div_sesion_activa.data('file',data.namefile);
					div_sesion_activa=null;

		            arrayarchivos = [];
		        },
		        error: function(error) {
		            //upload failed
		            switch (error.name) {
		                case 'InvalidFileExtensionError':
		                    vmsg = "Este tipo de archivo no es admitido";
		                    break;
		                case 'MaxFileSizeError':
		                    vmsg = "El peso máximo permitido es de 10MB";
		                    break;
		                default:
		                    vmsg = error.message;
		            }
		            Swal.fire({
		                icon: 'error',
		                title: "Error! " + error.name,
		                text: vmsg,
		                backdrop: false,
		            });
		            $('#vw_mpc_txt_filename-'+vses).html("");
		            $('#vw_mpc_txt_size-'+vses).html("");
		            $('#vw_mpc_txt_type-'+vses).html("");
		            $('#divboxmissesiones #divoverlay').remove();
		        }
		    });
			
		});

		$('.linkduplicar').click(function(event) {
			$('#divsesioneditar').hide();
			$('#divsesionprocesos').show();
			var div=$(this).closest('.div-sesion');
			var vses=div.data('sesion');
			div.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			$.ajax({
					url: base_url + 'sesion/vw_curso_sesiones_duplicar',
					type: 'post',
					dataType: 'json',
					data: {sesion: vses},
					success: function(e) {
						$('#divboxmissesiones #divoverlay').remove();
						if (e.status == false) {
							
							var msgf='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg +'</div>';
							$('#divsesionprocesos').html(msgf);
						}
						else {
							$('#divsesionprocesos').html(e.vdata);

							$('#divcard_titleadd').html('DUPLICAR SESIÓN DE CLASE');
							$('#txtnrosesion').val(e.ses['nrosesion']);
							$('#txtdetalle').val(e.ses['detalle']);
							$('#txtfecha').val(e.ses['fecha']);
							$('#txthoraini').val(e.ses['horaini']);
							$('#txthorafin').val(e.ses['horafin']);
							$('#cbtiposesion').val(e.ses['tipo']);
							$('#txtnrosesion').focus();

							calculardiferencia('#frmsesionadd');
							
						}
					},
				error: function (jqXHR, exception) {
					var msgf=errorAjax(jqXHR, exception,'div');
					$('#divboxmissesiones #divoverlay').remove();
					$('#divsesionprocesos').html(msgf);
				},
			});
			return false;
		});

		function calculardiferencia(formulario){
			
		  	var hora_inicio = $(formulario + ' .fictxthoradfini').val();
		  	var hora_final = $(formulario + ' .fictxthoradffin').val();
		  
		  	// Expresión regular para comprobar formato
		  	var formatohora = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
		  
		  	// Si algún valor no tiene formato correcto sale
		  	if (!(hora_inicio.match(formatohora)
		        && hora_final.match(formatohora))){
		    	return;
		  	}

		  	// Calcula los minutos de cada hora
		  	var minutos_inicio = hora_inicio.split(':')
		    	.reduce((p, c) => parseInt(p) * 60 + parseInt(c));
		  	var minutos_final = hora_final.split(':')
		    	.reduce((p, c) => parseInt(p) * 60 + parseInt(c));

		  	// Si la hora final es anterior a la hora inicial sale
		  	if (minutos_final < minutos_inicio) {
		  		msg = 'La hora final no puede ser inferior que la hora inicial';

		  		Swal.fire({
	                icon: 'error',
	                type: 'error',
	                title: "Error!",
	                text: msg,
	                backdrop: false,
	            });

		  		$(formulario + ' .fictxthoradfini').val('');
		  		$(formulario + ' .fictxthoradffin').val('');
	            $(formulario + ' #horas_justificacion_real').html('');
		  		return;
		  	} 
		  
		  	// Diferencia de minutos
		  	var diferencia = minutos_final - minutos_inicio;
		  
		  	// Cálculo de horas y minutos de la diferencia
		  	var horas = Math.floor(diferencia / 60);
		  	var minutos = diferencia % 60;
		  	
		  	$(formulario + ' #horas_justificacion_real').html(horas + ':'
		    	+ (minutos < 10 ? '0' : '') + minutos + (horas == 0 ? ' Min' : ' Hrs'));  
		}

		$('.btn_ses_asist').click(function(e) {
			e.preventDefault();
			var btn = $(this);
			var enlace = btn.attr('href');
			div = btn.closest('.div-sesion');
			var sesion = div.data('sesion');
			var carga = btn.data('carga');
			var division = btn.data('division');
			var unidad = btn.data('unidad');

			div.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			$.ajax({
				url: base_url + 'sesion/fn_curso_sesiones_asistencias'	,
				type: 'post',
				dataType: 'json',
				data: {
					sesion: sesion,
					carga: carga,
					division: division,
					unidad: unidad
				},
				success: function(e) {
					div.find('#divoverlay').remove();
					if (e.status == false) {
						Swal.fire({
		                    title: "Error!",
		                    text: "existen errores",
		                    type: 'error',
		                    icon: 'error',
		                })
					}
					else {
						window.open(enlace);
					}
				},
				error: function (jqXHR, exception) {
					var msgf=errorAjax(jqXHR, exception,'div');
					div.find('#divoverlay').remove();
					Swal.fire('Error!',msgf,'error')
				},
			});
			return false;
		});
	</script>