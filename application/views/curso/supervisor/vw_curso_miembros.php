<?php $vbaseurl=base_url(); ?>
<!-- Content Wrapper. Contains page content -->
<link href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="content-wrapper">

 	
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<?php include 'vw_curso_encabezado.php'; ?>
			</div>
			
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
								ESTUDIANTE
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



<script>

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