<?php if (count($editor)>0) { ?>
<div id="divtabl-editor" class="col-12 col-md-12 btable">
	<div class="col-md-12 thead d-none d-md-block">
	    <div class="row">
	      	<div class="col-12 col-md-10">
	      		<div class="row">
		        	<div class="col-sm-6 col-md-1 td">
		          		N°
		        	</div>
			        <div class="col-sm-6 col-md-11 td">
			          	COD / NOMBRE
			        </div>
		        </div>
	      	</div>
	      	<div class="col-2 col-md-1 td text-center"></div>
	      	<div class="col-2 col-md-1 td text-center"></div>
	    </div>
	</div>
	<div class="col-md-12 tbody">
		<?php
	    $nro=0;
	    foreach ($editor as $edt) {
	        $nro++;
	    ?>
	    <div class="row rowcolor">
	      	<div class="col-12 col-md-10">
	      		<div class="row">
		        	<div class="col-2 col-md-1 td">
		          		<span><?php echo "$nro" ;?></span>
		        	</div>
			        <div class="col-10 col-md-11 td">
			          	<span><?php echo "$edt->id / $edt->nombre" ?></span>
			        </div>
		        </div>
	      	</div>
	      	<div class="col-12 col-md-2">
	      		<div class="row">
		        	<div class="col-6 col-md-6 td text-center">
		          		<a class="tboton btn-info" href="#" onclick="viewupdatedit('<?php echo base64url_encode($edt->id) ?>')" title="Editar Editorial">
		            		<i class="fas fa-pencil-alt"></i> <span class="d-md-none">Editar </span>
		          		</a>
		        	</div>
		        	<div class="col-6 col-md-6 td text-center">
		          		<a class="tboton btn-danger" href="#" data-toggle="modal" data-target="#modal-danger-editor" data-idedit="<?php echo base64url_encode($edt->id) ?>" title="Eliminar Editorial">
		            		<i class="fas fa-trash-alt"></i> <span class="d-md-none">Eliminar</span>
		          		</a>
		        	</div>
	        	</div>
	      	</div>
	    </div>
	<?php } ?>
	</div>
</div>
<?php } else {
	echo '<h5 class="text-danger"><i class="fa fa-ban"></i> NO SE ENCONTRARON DATOS...!</h5>';
} ?>