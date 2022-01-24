<?php 
	$vbaseurl=base_url(); 
	$md=($config->conf_doc_add_est=="SI") ? "col-md-9":"col-md-12" ;
?>
<!-- Content Wrapper. Contains page content -->
<link href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="content-wrapper">
	<div class="modal fade" id="modal-addalumno" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog">
			 <div class="modal-content">
      
		        <!-- Modal Header -->
		        <div class="modal-header">
		          <h4 class="modal-title">Buscar Alumno</h4>
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		        </div>
				<div class="modal-body">
					
					<input id="vidperiodo" name="vidperiodo" type="hidden" class="form-control" value="<?php echo  $curso->codperiodo ?>">
					<input id="vdivision" name="vdivision" type="hidden" class="form-control" value="<?php echo  $curso->division ?>">
					<input id="vidcurso" name="vidcurso" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->codcarga) ?>">
					<label for="txtbus-alum">Apellidos y nombres</label>
					<div class="input-group">
						<input id="txt-buscaralumnos" name="txtbus-alum" type="text" class="form-control" value="">
						<span class="input-group-btn">
							<button class="btn btn-primary btn-md" type="button" id="btn-buscaralumnos">
							Ir <i class="fa fa-search" aria-hidden="true"></i></button>
						</span>
					</div>
					<div class="" id="lista-alumnos">
						
					</div>
					
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" type="button" class="btn pull-right" data-dismiss="modal">Terminar</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
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
                
              <li class="breadcrumb-item active">Miembros</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="<?php echo $md ?>">
				<?php include 'vw_curso_encabezado.php'; ?>
			</div>
			<?php if ($config->conf_doc_add_est=="SI") { ?>
			<div class="col-md-3">
				<a href="#" class="btn btn-primary btn-block" data-carga='<?php echo $curso->codcarga ?>' data-toggle="modal" data-target="#modal-addalumno">
					<i class="fas fa-user-plus"></i> <br> Agregar Alumno
				</a>
			</div>
			<?php } ?>
		</div>
		

		<div id="divboxmiembros" class="card">
            <div class="card-header">
                <h3 class="card-title">Miembros</h3>
                <div class="card-tools">
                  <a href="#" onclick="copyToClipboard();event.preventDefault();"  class="btn btn-primary" data-carga='<?php echo $curso->codcarga ?>' data-toggle="modal" data-target="#modal-correos">
					<i class="fas fa-user-plus"></i> Copiar Correos
				</a>
                </div>


                
            </div>
			<div class="card-body p-2 p-sm-3">
				<div id="divtablamiembros" class="col-12 btable">
					<div class="col-md-12 thead">
						<div class="row">
							<div class="col-5 col-md-2">
								<div class="row">
									<div class="col-3 col-md-3 td">
										N°
									</div>
									<div class="col-9 col-md-9 td">
										CARNÉ
									</div>
								</div>
							</div>
							<div class="col-7 col-md-4 td">
								ALUMNO
							</div>
							<div class="col-7 col-md-4 td">
								EMAIL INSTITUCIONAL
							</div>
							
							<div class="col-3 col-md-2 td text-center d-none d-md-block">
								LISTAR
							</div>
						</div>
					</div>
					<div class="col-md-12 tbody">
						<?php
						$numero=0;
						$ttact=0;
						$vcorreos="";
						$vcorreo=array();
						foreach ($miembros as $miembro) {
							
							$numero++;
							$vcorreo[]= $miembro->einstitucional;
						?>
						<div class="row rowcolor">
							<div class="col-5 col-md-2">
								<div class="row">
									<div class="col-3 col-md-3 td">
										<?php echo str_pad($numero, 2, "0", STR_PAD_LEFT);?>
									</div>
									<div class="col-9 col-md-9 td">
										<?php echo "<span>$miembro->carnet</span>";?>
									</div>
								</div>
							</div>
							
							<div class="col-12 col-md-4 td">
								<b class="mr-2"><?php echo ($miembro->sexo=='MASCULINO') ? '<i class="fas fa-male fa-lg text-primary"></i>':'<i class="fas fa-female  fa-lg text-danger"></i>' ?> </b>
								<?php 
								if ($miembro->codestadomat==2){
									echo "<del>$miembro->paterno $miembro->materno $miembro->nombres</del>
									<span class='text-danger'> (RETIRADO)</span>";
								}
								else{
									echo "<span>$miembro->paterno $miembro->materno $miembro->nombres</span>";
								}
								?>
							</div>
							<div class="col-12 col-md-4 td">
								<?php 
								echo $miembro->einstitucional
								?>
							</div>
							<div class="col-12 col-md-2 td text-center">
								<?php
								if ($miembro->codestadomat!=2){
									if ($miembro->ocultar=="SI"){
										$oblcheck="";
										$datadel="NO";
									}
									else{
										$oblcheck="checked";
										$datadel="SI";
										$ttact++;
									}
									echo "<input data-idmiembro='".base64url_encode($miembro->idmiembro)."' $oblcheck class='vw_cm_btn_retirarmiembro' data-ocultar='$datadel'  name='pg-obligatoria' type='checkbox' data-on='Mostrar' data-off='Ocultar' data-size='mini' data-onstyle='success' data-offstyle='danger'>";
								} ?>
							</div>
						</div>
						<?php }
						$vcorreos=implode(",", $vcorreo);
						//$vcorreos=$vcorreos."ncalderon@charlesashbee.edu.pe"
						//} ?>
						<div class="row text-bold">
							<div  class="col-6 text-center td">
								Habilitados: <span id="vw_cm_sp_hab"><?php echo $ttact ?></span>
							</div>
							<div  class="col-6 text-center td">
								Deshabilitados: <span id="vw_cm_sp_nohab"><?php echo count($miembros) - $ttact ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<script>
	//var vmiembros = <?php echo json_encode($miembros, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) ?>;

	$(document).ready(function() {
		$('.vw_cm_btn_retirarmiembro').bootstrapToggle();
	});
	$('#modal-addalumno').on('hide.bs.modal', function () {
		location.reload();
// do something…
	})
	$('#txt-buscaralumnos').keypress(function(event) {
			var keycode = event.keyCode || event.which;
		if(keycode == '13') {
		$('#btn-buscaralumnos').click();
		}
		});
	$("#btn-buscaralumnos").click(function(event) {
		$('#lista-alumnos').html('<center><h4 class="text-primary">Buscando</h4><br /><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span><center>');
		
		var vcarga=$("#vidcurso").val();
		var valumno=$("#txt-buscaralumnos").val();
		var vperiodo=$("#vidperiodo").val();
		var vdivision=$("#vdivision").val();
		$.ajax({
							url: base_url + 'miembros/vw_lista_posibles_miembros'	,
				type: 'post',
				dataType: 'json',
				data: {carga: vcarga,periodo:vperiodo,alumno:valumno,division:vdivision},
				success: function(e) {
					if (e.status==true){
						$('#lista-alumnos').html(e.vdata);
					}
					else{
						$('#lista-alumnos').html(e.msg);
					}
					
				},
			error: function (jqXHR, exception) {
				var msgf=errorAjax(jqXHR, exception,'div');
			$('#lista-alumnos').html(msgf);
		},
			});
		return false;
	});

	$(".vw_cm_btn_retirarmiembro").change(function(event) {
		event.preventDefault();
		btn=$(this);
		prev_val = !$(this).prop( "checked");
        $('#divboxmiembros').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        //var option=$(this);
		var vid=btn.data('idmiembro');
		var ocu=btn.data('ocultar');
        //************************************
        $.ajax({
			url: base_url + 'miembros/fn_ocultar',
			type: 'post',
			dataType: 'json',
			data: {"fm-idmiembro":vid,"fm-ocultar":ocu},
			success: function(e) {
				$('#divboxmiembros #divoverlay').remove();
				if (e.status==true){
					if (ocu=="SI"){
						btn.data('ocultar',"NO");
						$("#vw_cm_sp_nohab").html(Number($("#vw_cm_sp_nohab").html()) + 1);
						$("#vw_cm_sp_hab").html(Number($("#vw_cm_sp_hab").html()) - 1);
					}
					else{
						btn.data('ocultar',"SI");
						$("#vw_cm_sp_nohab").html(Number($("#vw_cm_sp_nohab").html()) - 1);
						$("#vw_cm_sp_hab").html(Number($("#vw_cm_sp_hab").html()) + 1);
					}
					
					//option.parent().parent().hide();
			    }
			    else{
			    	Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se actualizó',
                        text: e.msg,
                        backdrop:false,
                    });
                    btn.bootstrapToggle('destroy');
                    btn.prop( "checked",prev_val);
                    btn.bootstrapToggle();
			    }
			    return false;
			},
			error: function (jqXHR, exception) {
				var msgf=errorAjax(jqXHR, exception,'text');
				$('#divboxmiembros #divoverlay').remove();
				Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se Ocultó',
                        text: msgf,
                        backdrop:false,
                    });
				btn.bootstrapToggle('destroy');
                btn.prop("checked",prev_val);
                btn.bootstrapToggle();
				return false;
			},
		});
       
		
		});
function copyToClipboard() {
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val("<?php echo $vcorreos ?>").select();
	document.execCommand("copy");
	$temp.remove();
	Swal.fire({
        type: 'success',
        title: 'Correos copiados',
        text: "Los correos institucionales fueron copiados, puede pegarlos usando CTRL + V",
        backdrop:false,
    });
}
		
</script>