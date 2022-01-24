<?php if (count($autores)>0) { ?>
<div id="divtabl-autor" class="col-xs-12 col-md-12 neo-table">
	<div class="col-md-12 header d-none d-md-block">
	    <div class="row">
	      	<div class="col-xs-1 col-md-1 cell hidden-xs"><b>Nro</b></div>
	      	<div class="col-xs-6 col-md-9 cell"><b>NOMBRE</b></div>
	      	<div class="col-xs-2 col-md-1 cell text-center"></div>
	      	<div class="col-xs-2 col-md-1 cell text-center"></div>
	    </div>
	</div>
	<div class="col-md-12 body">
		<?php
	    $nro=0;
	    foreach ($autores as $atr) {
	        $nro++;
	    ?>
	    <div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
	      	<div class="col-xs-12 col-md-10 group">
	        	<div class="col-sm-6 col-md-1 cell">
	          		<span><?php echo $nro ;?></span>
	        	</div>
		        <div class="col-sm-6 col-md-11 cell">
		          	<span><?php echo $atr->nombre ?></span>
		        </div>
	      	</div>
	      	<div class="col-xs-12 col-md-2 group">
	        	<div class="col-sm-6 col-md-6 cell text-center">
	          		<button class="btn btn-sm btn-info btn-block" href="#" onclick="viewupdataut('<?php echo base64url_encode($atr->id) ?>')" title="Editar Autor">
	            		<i class="fas fa-pencil-alt"></i> <span class="d-block d-md-none">Editar </span>
	          		</button>
	        	</div>
	        	<div class="col-sm-6 col-md-6 cell text-center">
	          		<a class="btn btn-sm btn-danger btn-block" href="#" data-toggle="modal" data-target="#modal-danger-autor" data-idaut="<?php echo base64url_encode($atr->id) ?>" title="Eliminar Autor">
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