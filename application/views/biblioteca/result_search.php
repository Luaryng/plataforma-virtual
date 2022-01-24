<?php
  $vbaseurl=base_url();
if (count($dlibros)>0){
  
?>
	<div id="divtabl-libros" class="col-12 col-md-12">
		<p class="text-secondary ">Cerca de <?php echo count($dlibros) ?> Resultados encontrados</p>
		<?php
		    $nro=0;
		    foreach ($dlibros as $lbr) {
		        $nro++;
		?>
		<div class="col-sm-12 my-2 py-2 bg-lightgray border-gray ">
			<div class="row">
				<div class="col-sm-12 mt-2">
					<i class="fa fa-book mr-1"></i>
					<?php 
					if ($lbr->link == "") { 
						echo '<small class="badge badge-success mr-1">
						<i class="far fa-clock"></i> Físico	</small><b>'.$lbr->nombre.'</b>';
					} else {
						echo '<small class="badge badge-primary mr-1">
						<i class="far fa-clock"></i> Virtual</small><b><a target="_blank" href="'.$lbr->link.'">'.$lbr->nombre.'</a></b>';
					} ?>
					
				</div>
				<?php
				if ($lbr->link == "") { 
					echo '<div class="col-12 col-md-4 mt-2"><b>Autor: </b>'.$lbr->autor .'</div>
						<div class="col-md-4 col-6 mt-2"><b>Editorial: </b>'.$lbr->editorial .'</div>
						<div class="col-md-4 col-6 mt-2"><b>Año: </b>'.$lbr->anio .'</div>
						<div class="col-md-4 col-6 mt-2"><b>N° Pag.</b> '.$lbr->npag .' </div>
						<div class="col-md-4 col-6 mt-2"><b>Estado:</b> '.$lbr->estado .' </div>
						<div class="col-md-4 col-6 mt-2"><b>Situación:</b> <small class="badge bg-success"> '.$lbr->situa .' </small></div>
						<div class="col-md-4 col-6 mt-2"><b>Ubicación:</b> '.$lbr->ubic .' </div>
						<div class="col-12 col-md-8 text-success mt-2">
							<strong>Disponible de manera presencial en nuestra biblioteca Institucional</strong>
						</div>';
				} else {
					echo '<div class="col-12 col-md-4 mt-2"><b>Autor: </b>'.$lbr->autor .'</div>
						<div class="col-md-4 col-6 mt-2"><b>Editorial: </b>'.$lbr->editorial .'</div>
						<div class="col-md-4 col-6 mt-2"><b>Año: </b>'.$lbr->anio .'</div>
						<div class="col-md-4 col-6 mt-2"><b>N° Pag.</b> '.$lbr->npag .' </div>';
				} ?>
				
			</div>
		</div>
	<?php } ?>
	</div>
<?php } else {
echo "<h5 class='ml-3 text-danger'><i class='fa fa-ban'></i> NO SE ENCONTRARON RESULTADOS</h5>";
} ?>
