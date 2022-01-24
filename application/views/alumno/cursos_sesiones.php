<?php
	$vbaseurl=base_url();
	$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
?>
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
						<a href="<?php echo $vbaseurl ?>alumno/mis-cursos-panel"><i class="fas fa-compass"></i> Mis Unidades didácticas</a>
					</li>
					<li class="breadcrumb-item">
						
						<a href="<?php echo $vbaseurl.'alumno/curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($miembro); ?>"><?php echo $curso->unidad ?>
						</a>
					</li>
					
					<li class="breadcrumb-item active">Sesiones</li>
				</ol>
			</div>
		</div>
		</div><!-- /.container-fluid -->
	</section>
	<section class="content">
		<?php include 'vw_panel_encabezado.php'; ?>

		<div id="divboxmissesiones" class="card">
			<div class="card-header">
				<h3 class="card-title">Clases diarias</h3>
			</div>
			<div class="card-body">
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
					<div class="card border border-primary div-sesion" data-titulo='SESIÓN <?php echo $vnroses ?>' data-detalle=' <?php echo $ss->detalle ?>' data-sesion="<?php echo base64url_encode($ss->id) ?>" data-file="<?php echo $ss->linkf ?>">
						<div class="card-header">
							<h3 class="card-title text-bold" data-toggle="tooltip" title="<?php echo $ss->id ?>">
							<i class="fa fa-angle-double-right text-success"></i>
							SESIÓN <?php echo $vnroses." - ".$ss->tipo ?>
							</h3>
							
						</div>
						<!-- /.card-header -->
						<div class="card-body p-3">
							<div class="row">
								<div class="col-md-12">
									<span><?php echo $ss->detalle ?></span><br>
									<u> <?php echo $dias[date("w", strtotime($ss->fecha))]."</u> ".$vfecha." ".$hini->format('h:i a')." - ".$hfin->format('h:i a'); ?>
								</div>
								<div class="col-12">
									<!-- <span>Videconferencia: </span>  -->
								<?php
									if (trim($ss->hlink)!=""){
										echo "<a target='_blank' data-carga='".base64url_encode($curso->codcarga)."' data-division='".base64url_encode($curso->division)."' data-unidad='".base64url_encode($curso->codunidad)."' class='vd_link mr-2 btn_ses_asist' href='$ss->hlink'>
												$ss->hlink
											</a>";
										echo "<a target='_blank' data-carga='".base64url_encode($curso->codcarga)."' data-division='".base64url_encode($curso->division)."' data-unidad='".base64url_encode($curso->codunidad)."' href='$ss->hlink' class='btn btn-tool bg-primary btn_ses_asist'><i class='fas fa-video'></i> Unirte</a>";
									}
								?>
									
								</div>

								<div class="col-12 mt-2">
									<a target="_blank" class="fl_link" href="<?php echo base_url().'alumno/sesion/descargar-file/'. base64url_encode($ss->archivo) .'/'. base64url_encode($ss->linkf) .'/'. base64url_encode($ss->tipof) ?>">
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