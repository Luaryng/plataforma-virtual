<?php 
if (isset($historial) && (count($historial)>0))
{ ?>
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
			<div class="col-12 col-md-5 group">
				<div class="col-6 col-md-6 cell">
					DENUNCIANTE
				</div>
				<div class="col-6 col-md-6 cell">
					DENUNCIADO
				</div>
			</div>
			<div class="col-12 col-md-4 group">
				<div class="col-6 col-md-6 cell text-center">
					FICHA PDF
				</div>
				<div class="col-6 col-md-6 cell">
					
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12 body">
		<?php
			$nro = 0;
			foreach ($historial as $value) {
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
				<div class="col-12 col-md-5 group">
					<div class="col-3 col-md-6 cell">
						<span><?php echo $value->nombres ;?></span>
					</div>
					<div class="col-3 col-md-6 cell">
						<span><?php echo $value->asunto ;?></span>
					</div>
				</div>
				<div class="col-12 col-md-4 group">
					<div class="col-6 col-md-6 cell text-center">
						<span>
							<a class="btn-delete bg-success py-1 px-3 rounded" target="_blank" href="<?php echo base_url()."constancia-incidencia?cinc=".base64url_encode($value->id) ?>" title="Descargar">
								<i class="fas fa-download"></i> 
							</a>
						</span>
					</div>
					<div class="col-6 col-md-6 cell text-center">
						<span>
							<a class="btn-delete bg-info py-1 px-3 rounded" href="<?php echo base_url()."gestion/tramites/denuncias/detalle/".base64url_encode($value->id) ?>" title="ver detalle">
								<i class="fas fa-eye"></i> Ver
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
<?php  
}
else
{
	echo "<h4 class='px-2'>No se encontro coincidencias</h4>";
} 
?>
