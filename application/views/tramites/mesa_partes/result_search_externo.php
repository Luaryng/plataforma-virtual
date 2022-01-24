
<?php 
	$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
	$mesescmp = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
<div class="col-md-12">
	<div class="card">
  
  	<div class="card-body">
  		<?php 
  		$agrupar = "";
  		foreach ($historial as $value) {

  			$fecha_reg = date_create($value->fecha);
  			
  			if ($value->nombres != $agrupar) {
		        if($agrupar!="") echo "</div>";
		        $agrupar = $value->nombres;
  		?>

  		<div id="divtabl-seguimiento" class="col-12 col-md-12 neo-table mb-3">
			<div class="col-md-12 header d-none d-md-block">
				<div class="row font-weight-bold">
					
					<div class="col-12 col-md-5 group">
						<div class="col-4 col-md-6 cell d-none d-md-block">
							SOLICITUD
						</div>
						<div class="col-12 col-md-6 cell">
							ASUNTO
						</div>
					</div>
					<div class="col-12 col-md-3 group">
						<div class="col-6 col-md-4 cell">
							<?php echo $value->tipdoc ;?>
						</div>
						<div class="col-6 col-md-8 cell">
							APELLIDOS Y NOMBRES
						</div>
					</div>
					<div class="col-12 col-md-4 group">
						<div class="col-6 col-md-8 cell text-center">
							DIRECCIÓN
						</div>
						<div class="col-6 col-md-4 cell text-center">
							FICHA
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 body">
				<div  class="row cfila">
					<div class="col-12 col-md-5 group">
						<div class="col-6 col-md-6 cell">
							<span><?php echo $value->tiptram ;?></span>
						</div>
						<div class="col-6 col-md-6 cell">
							<?php echo $value->asunto ;?>
						</div>
					</div>
					<div class="col-12 col-md-3 group">
						<div class="col-4 col-md-4 cell">
							<span><?php echo $value->documento ;?></span>
						</div>
						<div class="col-8 col-md-8 cell">
							<span><?php echo $value->nombres ;?></span>
						</div>
					</div>
					<div class="col-12 col-md-4 group">
						<div class="col-8 col-md-8 cell text-center">
							<span><?php echo $value->domicilio ;?></span>
						</div>
						<div class="col-4 col-md-4 cell text-center">
							<span>
								<a class="btn-delete bg-success py-1 px-3 rounded" target="_blank" href="<?php echo base_url()."tramites/externo/mesa-de-partes/pdf?cmspt=".base64url_encode($value->id) ?>" title="Descargar">
									<i class="fas fa-download"></i> 
								</a>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card card-primary">
		  	<div class="card-header">
		    	<h3 class="card-title">Seguimiento Trámite</h3>
		  	</div>
		  	<div class="row">
		  		<div class="col-md-12 p-3">
		  			<div class="timeline timeline-inverse">
			            <div class="time-label">
			                <span class="bg-danger">
			                  <?php echo date($fecha_reg->format('d')).", ".$meses[date($fecha_reg->format('n'))-1]. " ".date($fecha_reg->format('Y')) ?>
			                </span>
			            </div>
			              
			            <div>
			                <i class="fas fa-university bg-primary"></i>

			                <div class="timeline-item">
			                  	<span class="time"><i class="far fa-clock"></i> <?php echo date_format($fecha_reg, 'g:i A'); ?></span>

			                  	<h3 class="timeline-header"><?php echo date($fecha_reg->format('d')).", ".$mesescmp[date($fecha_reg->format('n'))-1]. " de ".date($fecha_reg->format('Y')) ?></h3>

			                  	<div class="timeline-body">
			                        Su trámite ha sido recibido en <b>MESA DE PARTES</b> será atendido o derivado a la oficina correspondiente en un plazo máximo de 2 día(s).
			                  	</div>
			                  	
			                </div>
			            </div>
			              
			              
			            <!-- <div class="time-label">
			                <span class="bg-success">
			                  3 Jan. 2014
			                </span>
			            </div> -->
			              
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