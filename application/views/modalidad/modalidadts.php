<div id="divtabl-modalidad" class="form-neo neo-table">
	<div class="col-md-12 header d-none d-md-block">
	    <div class="row">
	      	<div class="col-sm-1 col-md-1 cell hidden-xs"><b>N°</b></div>
	      	<div class="col-sm-2 col-md-8 cell"><b>Nombre</b></div>
	      	<div class="col-sm-2 col-md-1 cell"><b>Activo</b></div>
	      	<div class="col-sm-1 col-md-1 cell text-center"></div>
	      	<div class="col-sm-1 col-md-1 cell text-center"></div>
	    </div>
	</div>
	<div class="col-md-12 body">
		<?php
		$nro = 0;
		foreach ($modalidades as $key => $mod) {
			$nro ++;
		?>
		<div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
			<div class="col-sm-12 col-md-9 group">
	        	<div class="col-sm-6 col-md-1 cell">
	          		<span><?php echo $nro ;?></span>
	        	</div>
		        <div class="col-sm-6 col-md-11 cell">
		          	<span><?php echo $mod->nombre ?></span>
		        </div>
	      	</div>
	      	<div class="col-sm-12 col-md-3 group">
	      		<div class="col-sm-4 col-md-4 cell">
	      			<?php $vflat="activarmodalidad";
					$vtitle="Activar Modalidad";
					$vicon="fa fa-toggle-off";
					$btncolor="btn-danger btn-sm btn-block";
					$accion= "SI";
					$estado="Inhabilitado";
					if ($mod->actv=="SI"){
						$vflat="desactivarmodalidad";
						$vtitle="Desactivar Modalidad";
						$vicon="fa fa-toggle-on";
						$btncolor="btn-success btn-sm btn-block";
						$accion= "NO";
						$estado="Habilitado";
					} 
					echo "<span data-toggle='tooltip' title='$vtitle'>
						<a data-flat='$vflat' data-idmod='".$mod->codigo."' data-act='$accion' data-toggle='modal' data-target='#modal-activ' class='btn $btncolor' href='#'>
							<i class='$vicon'></i><span class='d-block d-md-none'>$estado</span>
						</a>
					</span>";
					?>
	      		</div>
	      		<div class="col-sm-4 col-md-4 cell">
	      			<a href="#" class="btn btn-sm btn-info btn-block edita_mod" data-idmod="<?php echo $mod->codigo ?>" data-nom="<?php echo $mod->nombre ?>" data-toggle="modal" data-target="#modal-edit-mod" title="Editar Modalidad">
	      				<i class="fas fa-pencil-alt"></i> <span class="d-block d-md-none">Editar </span>
	      			</a>
	      		</div>
	      		<div class="col-sm-4 col-md-4 cell">
	      			<a href="#" data-idmod="<?php echo $mod->codigo ?>" data-toggle="modal" data-target="#modal-danger-mod" class="btn btn-sm btn-block btn-danger" title="Eliminar Modalidad">
	      				<i class="fas fa-trash-alt"></i> <span class="d-block d-md-none">Eliminar</span>
	      			</a>
	      		</div>
	      	</div>
		</div>
	<?php } ?>
	</div>
</div>