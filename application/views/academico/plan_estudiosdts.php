<?php if (count($planes) > 0) { ?>
<div id="divtabl_plan" class="col-xs-12 col-md-12 neo-table">
	<div class="col-md-12 header d-none d-md-block">
	    <div class="row">
	      	<div class="col-xs-1 col-md-1 cell hidden-xs"><b>COD</b></div>
	      	<div class="col-xs-6 col-md-2 cell"><b>NOMBRE</b></div>
	      	<div class="col-xs-6 col-md-1 cell"><b>INICIA</b></div>
	      	<div class="col-xs-6 col-md-2 cell"><b>PROG. ACAD.</b></div>
	      	<div class="col-xs-6 col-md-2 cell"><b>DRECRETO</b></div>
	      	<div class="col-xs-6 col-md-2 cell"><b>RESOLUCIÓN</b></div>
	      	<div class="col-xs-2 col-md-1 cell text-center"></div>
	      	<div class="col-xs-2 col-md-1 cell text-center"></div>
	    </div>
	</div>
	<div class="col-md-12 body">
		<?php
		    $nro=0;
		    foreach ($planes as $dts) {
		        $nro++;
		    ?>
		    <div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
		      	<div class="col-xs-12 col-md-3 group">
		        	<div class="col-sm-6 col-md-4 cell">
		          		<span><?php echo $dts->id ;?></span>
		        	</div>
			        <div class="col-sm-6 col-md-8 cell">
			          	<span><?php echo $dts->nombre ?></span>
			        </div>
		      	</div>
		      	<div class="col-xs-12 col-md-3 group">
		        	<div class="col-sm-6 col-md-4 cell">
		          		<span><?php echo $dts->periodo ;?></span>
		        	</div>
			        <div class="col-sm-6 col-md-8 cell">
			          	<span><?php echo $dts->carrera ?></span>
			        </div>
		      	</div>
		      	<div class="col-xs-12 col-md-4 group">
		        	<div class="col-sm-6 col-md-6 cell">
		          		<span><?php echo $dts->decreto ;?></span>
		        	</div>
			        <div class="col-sm-6 col-md-6 cell">
			          	<span><?php echo $dts->resolu ?></span>
			        </div>
		      	</div>
		      	<div class="col-xs-12 col-md-2 group">
		        	<div class="col-sm-12 col-md-6 cell text-center">
		          		<button class="btn btn-sm btn-info btn-block" href="#" onclick="viewupdaplan('<?php echo base64url_encode($dts->id) ?>')" title="Editar plan">
		            		<i class="fas fa-pencil-alt"></i> <span class="d-block d-md-none">Editar Plan</span>
		          		</button>
		        	</div>
		        	<div class="col-sm-6 col-md-6 cell text-center">
		          		<a class="btn btn-sm btn-danger btn-block" href="#" data-toggle="modal" data-target="#modal_danger_plan" data-idplan="<?php echo base64url_encode($dts->id) ?>" title="Eliminar plan">
		            		<i class="fas fa-trash-alt"></i> <span class="d-block d-md-none">Eliminar Plan</span>
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