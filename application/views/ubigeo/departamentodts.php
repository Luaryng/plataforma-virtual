<div id="divtabl-departamento" class="form-neo neo-table">
	<b class="p-2 text-danger"><i class="fas fa-globe"></i> Lista de Departamentos</b>
	<div class="col-md-12 header d-none d-md-block">
	    <div class="row">
	      	<div class="col-sm-1 col-md-1 cell hidden-xs"><b>N°</b></div>
	      	<div class="col-sm-2 col-md-7 cell"><b>Nombre</b></div>
	      	<div class="col-sm-1 col-md-2 cell text-center"></div>
	      	<div class="col-sm-1 col-md-2 cell text-center"></div>
	    </div>
	</div>
	<div class="col-md-12 body">
		<?php
		$nro = 0;
		foreach ($depart as $dep) {
			$nro ++;
		?>
		<div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
			<div class="col-sm-12 col-md-8 group">
	        	<div class="col-sm-6 col-md-2 cell">
	          		<span><?php echo $nro ;?></span>
	        	</div>
		        <div class="col-sm-6 col-md-10 cell">
		          	<span><?php echo $dep->nombre ?></span>
		        </div>
	      	</div>
	      	<div class="col-sm-12 col-md-4 group">
	      		<div class="col-sm-6 col-md-6 cell">
	      			<a href="#" class="btn btn-sm btn-info btn-block edita_depart" data-id="<?php echo $dep->codigo ?>" data-nom="<?php echo $dep->nombre ?>" data-acc="depart" data-toggle="modal" data-target="#modal-edita" title="Editar Departamento">
	      				<i class="fas fa-pencil-alt"></i> <span class="d-block d-md-none">Editar </span>
	      			</a>
	      		</div>
	      		<div class="col-sm-6 col-md-6 cell">
	      			<a href="#" data-idep="<?php echo $dep->codigo ?>" data-toggle="modal" data-target="#modal-danger" class="btn btn-sm btn-block btn-danger" title="Eliminar Departamento">
	      				<i class="fas fa-trash-alt"></i> <span class="d-block d-md-none">Eliminar</span>
	      			</a>
	      		</div>
	      	</div>
		</div>
	<?php } ?>
	</div>
</div>