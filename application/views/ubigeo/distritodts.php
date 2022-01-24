<div id="divtabl-distrito" class="form-neo neo-table">
	<b class="p-2 text-danger"><i class="fas fa-globe"></i> Lista de Distritos</b>
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
		foreach ($distrit as $dist) {
			$nro ++;
		?>
		<div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
			<div class="col-sm-12 col-md-8 group">
	        	<div class="col-sm-6 col-md-2 cell">
	          		<span><?php echo $nro ;?></span>
	        	</div>
		        <div class="col-sm-6 col-md-10 cell">
		          	<span><?php echo $dist->nombre ?></span>
		        </div>
	      	</div>
	      	<div class="col-sm-12 col-md-4 group">
	      		<div class="col-sm-6 col-md-6 cell">
	      			<a href="#" class="btn btn-sm btn-info btn-block edita_dist" data-id="<?php echo $dist->codigo ?>" data-nom="<?php echo $dist->nombre ?>" data-prvc="<?php echo $dist->provc ?>" data-toggle="modal" data-target="#modal-edita-dist" title="Editar Distrito">
	      				<i class="fas fa-pencil-alt"></i> <span class="d-block d-md-none">Editar </span>
	      			</a>
	      		</div>
	      		<div class="col-sm-6 col-md-6 cell">
	      			<a href="#" data-idistr="<?php echo $dist->codigo ?>" data-toggle="modal" data-target="#modal-danger-dist" class="btn btn-sm btn-block btn-danger" title="Eliminar Distrito">
	      				<i class="fas fa-trash-alt"></i> <span class="d-block d-md-none">Eliminar</span>
	      			</a>
	      		</div>
	      	</div>
		</div>
	<?php } ?>
	</div>
</div>