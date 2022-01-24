<?php if (count($periodos) > 0) { ?>
<div id="divtabl-periodo" class="neo-table form-neo">
	<div class="col-md-12 header d-none d-md-block">
	    <div class="row">
	      	<div class="col-sm-1 col-md-1 cell hidden-xs"><b>N°</b></div>
	      	<div class="col-sm-2 col-md-2 cell"><b>Código</b></div>
	      	<div class="col-sm-2 col-md-3 cell"><b>Nombre</b></div>
	      	<div class="col-sm-2 col-md-1 cell"><b>Año</b></div>
	      	<div class="col-sm-2 col-md-1 cell"><b>Activo</b></div>
	      	<div class="col-sm-2 col-md-2 cell"><b>Estado</b></div>
	      	<div class="col-sm-1 col-md-1 cell text-center"></div>
	      	<div class="col-sm-1 col-md-1 cell text-center"></div>
	    </div>
	</div>
	<div class="col-md-12 body">
		<?php
		$nro = 0;
		foreach ($periodos as $key => $per) {
			$nro ++;
		?>
		<div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
			<div class="col-sm-12 col-md-3 group">
	        	<div class="col-sm-6 col-md-4 cell">
	          		<span><?php echo $nro ;?></span>
	        	</div>
		        <div class="col-sm-6 col-md-8 cell">
		          	<span><?php echo $per->codigo ?></span>
		        </div>
	      	</div>
	      	<div class="col-sm-12 col-md-4 group">
	      		<div class="col-sm-6 col-md-9 cell">
	          		<span><?php echo $per->nombre ;?></span>
	        	</div>
		        <div class="col-sm-6 col-md-3 cell">
		          	<span><?php echo $per->anio ?></span>
		        </div>
	      	</div>
	      	<div class="col-sm-12 col-md-3 group">
	      		<div class="col-sm-4 col-md-4 cell">
	      			<?php $vflat="activarperiodo";
					$vtitle="Activar periodo";
					$vicon="fa fa-toggle-off";
					$btncolor="btn-danger btn-sm btn-block";
					$accion= "SI";
					$estado="Inhabilitado";
					if ($per->activ=="SI"){
						$vflat="desactivarperiodo";
						$vtitle="Desactivar periodo";
						$vicon="fa fa-toggle-on";
						$btncolor="btn-success btn-sm btn-block";
						$accion= "NO";
						$estado="Habilitado";
					} 
					echo "<span data-toggle='tooltip' title='$vtitle'>
						<a data-flat='$vflat' data-idpr='".$per->codigo."' data-act='$accion' data-toggle='modal' data-target='#modal-activ' class='btn $btncolor' href='#'>
							<i class='$vicon'></i><span class='d-block d-md-none'>$estado</span>
						</a>
					</span>";
					?>
	      		</div>
	      		<div class="col-sm-4 col-md-8 cell text-center">
	      			<?php 
	      			if ($per->estado == "ACTIVO") {
	      				$bgstatus = "btn-success btn-sm";
	      			}else if ($per->estado == "CERRADO") {
	      				$bgstatus = "btn-danger btn-sm";
	      			} else if ($per->estado == "RESERVA") {
	      				$bgstatus = "btn-danger btn-sm";
	      			}

	      			echo "<span title='$per->estado'>
						<button class='btn $bgstatus'>
							<span class='small'>$per->estado</span>
						</button>
					</span>";
	      			?>
	      		</div>
	      	</div>
	      	<div class="col-sm-12 col-md-2 group">
	      		
	      		<div class="col-sm-6 col-md-6 cell">
	      			<a href="#" class="btn btn-sm btn-info btn-block edita_per" data-toggle="modal" data-target="#modal-edit-per" title="Editar Periodo" onclick="viewupdaper('<?php echo $per->codigo ?>','<?php echo $per->nombre ?>','<?php echo $per->anio ?>','<?php echo $per->estado ?>')">
	      				<i class="fas fa-pencil-alt"></i> <span class="d-block d-md-none">Editar </span>
	      			</a>
	      		</div>
	      		<div class="col-sm-6 col-md-6 cell">
	      			<a href="#" data-idpr="<?php echo $per->codigo ?>" data-toggle="modal" data-target="#modal-danger-per" class="btn btn-sm btn-block btn-danger" title="Eliminar Periodo">
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