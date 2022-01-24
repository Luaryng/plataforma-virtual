<div id="divtabl-nivel" class="col-xs-12 col-md-12 neo-table">
	<div class="col-md-12 header d-none d-md-block">
	    <div class="row">
	      	<div class="col-sm-1 col-md-1 cell hidden-xs"><b>N°</b></div>
	      	<div class="col-sm-2 col-md-7 cell"><b>Nombre</b></div>
	      	<div class="col-sm-1 col-md-2 cell text-center"></div>
	      	<div class="col-sm-1 col-md-2 cell text-center"></div>
	    </div>
	</div>
	<div class="col-md-12 body" style="max-height: 30vh;overflow-y: scroll; overflow-x: hidden;">
		<?php
		$nro = 0;
		foreach ($niveles as $key => $nvl) {
			$nro ++;
		?>
		<div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
			<div class="col-sm-12 col-md-8 group">
	        	<div class="col-sm-6 col-md-2 cell">
	          		<span><?php echo $nro ;?></span>
	        	</div>
		        <div class="col-sm-6 col-md-10 cell">
		          	<span><?php echo $nvl->nombre ?></span>
		        </div>
	      	</div>
	      	<div class="col-sm-12 col-md-4 group">
	      		<div class="col-sm-6 col-md-6 cell">
	      			<a href="#" class="btn btn-sm btn-info btn-block edita_niv" data-idniv="<?php echo $nvl->codigo ?>" data-nom="<?php echo $nvl->nombre ?>" data-toggle="modal" data-target="#modal-edit-niv" title="Editar Nivel">
	      				<i class="fas fa-pencil-alt"></i> <span class="d-block d-md-none">Editar </span>
	      			</a>
	      		</div>
	      		<div class="col-sm-6 col-md-6 cell">
	      			<a href="#" data-idniv="<?php echo $nvl->codigo ?>" data-toggle="modal" data-target="#modal-danger-niv" class="btn btn-sm btn-block btn-danger" title="Eliminar Nivel">
	      				<i class="fas fa-trash-alt"></i> <span class="d-block d-md-none">Eliminar</span>
	      			</a>
	      		</div>
	      	</div>
		</div>
	<?php } ?>
	</div>
</div>