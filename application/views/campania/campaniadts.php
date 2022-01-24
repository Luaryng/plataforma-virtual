<?php 
$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"); 
if (count($datoscmp) > 0) {
?>
<div id="divtabl-campania" class="neo-table form-neo">
	<div class="col-md-12 header d-none d-md-block">
	    <div class="row">
	      	<div class="col-sm-1 col-md-1 cell hidden-xs"><b>Nro</b></div>
	      	<div class="col-sm-1 col-md-1 cell"><b>Periodo</b></div>
	      	<div class="col-sm-2 col-md-2 cell"><b>Nombre</b></div>
	      	<div class="col-sm-3 col-md-3 cell"><b>Descripción</b></div>
	      	<div class="col-sm-1 col-md-1 cell"><b>Inicia</b></div>
	      	<div class="col-sm-1 col-md-1 cell"><b>Finaliza</b></div>
	      	<div class="col-sm-1 col-md-1 cell"><b>Activo</b></div>
	      	<div class="col-sm-1 col-md-1 cell text-center"></div>
	      	<div class="col-sm-1 col-md-1 cell text-center"></div>
	    </div>
	</div>
	<div class="col-md-12 body">
		<?php
    		$nro = 0;
			foreach ($datoscmp as $cmp) {
				$fecha_ini = DateTime::createFromFormat('Y-m-d', $cmp->fini);
				$fecha_fin = DateTime::createFromFormat('Y-m-d', $cmp->fculm);
				$nro ++;
			?>
		<div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
	      	<div class="col-sm-12 col-md-2 group">
	        	<div class="col-sm-6 col-md-6 cell">
	          		<span><?php echo $nro ;?></span>
	        	</div>
		        <div class="col-sm-6 col-md-6 cell">
		          	<span><?php echo $cmp->codperiodo ?></span>
		        </div>
	      	</div>
	      	<div class="col-sm-12 col-md-5 group">
	      		<div class="col-sm-5 col-md-5 cell">
	          		<span><?php echo "($cmp->id) $cmp->nombre" ?></span><br>
	          		<span class="small">(<?php echo $cmp->sede ?>)</span>
	        	</div>
	        	<div class="col-sm-7 col-md-7 cell">
	          		<span><?php echo $cmp->descripcion ?></span>
	        	</div>
	      	</div>
	      	<div class="col-sm-12 col-md-3 group">
	      		<div class="col-sm-4 col-md-4 cell">
	          		<span><?php echo date($fecha_ini->format('d')).", ".$meses[date($fecha_ini->format('n'))-1]. " ".date($fecha_ini->format('Y'))?></span>
	        	</div>
	        	<div class="col-sm-4 col-md-4 cell">
	        		<span><?php echo date($fecha_fin->format('d')).", ".$meses[date($fecha_fin->format('n'))-1]. " ".date($fecha_fin->format('Y'))?></span>
	        	</div>
	        	<div class="col-sm-4 col-md-4 cell">
	        		<?php $vflat="activarcampaña";
						$vtitle="Activar Campaña";
						$vicon="fa fa-toggle-off";
						$btncolor="btn-danger btn-sm";
						$accion= "SI";
						$estado="Inhabilitado";
						if ($cmp->activ=="SI"){
							$vflat="desactivarcampaña";
							$vtitle="Desactivar Campaña";
							$vicon="fa fa-toggle-on";
							$btncolor="btn-success btn-sm";
							$accion= "NO";
							$estado="Habilitado";
						} 
						echo "<span data-toggle='tooltip' title='$vtitle'>
							<a data-flat='$vflat' data-idc='".$cmp->id."' data-act='$accion' data-toggle='modal' data-target='#modal-activ' class='btn $btncolor btn-block' href='#'>
								<i class='$vicon'></i><span class='d-block d-md-none'>$estado</span>
							</a>
						</span>";
						?>
	        	</div>
	      	</div>
	      	<div class="col-sm-12 col-md-2 group">
	      		<div class="col-sm-6 col-md-6 cell">
	      			<a href="#" class="btn btn-sm btn-info btn-block edita_camp" onclick="viewupdate('<?php echo base64url_encode($cmp->id) ?>');" data-idc="" title="editar campaña">
	      				<i class="fas fa-pencil-alt"></i> <span class="d-block d-md-none">Editar </span>
	      			</a>
	      		</div>
	      		<div class="col-sm-6 col-md-6 cell">
	      			<a href="#" data-idc="<?php echo $cmp->id ?>" data-toggle="modal" data-target="#modal-danger-cam" class="btn btn-sm btn-block btn-danger" title="eliminar campaña">
	      				<i class="fas fa-trash-alt"></i> <span class="d-block d-md-none">Eliminar</span>
	      			</a>
	      		</div>
	      	</div>
	    </div>
	<?php } ?>
	</div>
</div>
<?php } else {
	echo '<h5 class="text-danger"><i class="fa fa-ban"></i> NO SE ENCONTRARON DATOS...!</h5>';
} ?>