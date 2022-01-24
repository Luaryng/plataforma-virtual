<?php if(count($modulos) > 0) { ?>
<div id="divtabl_plan" class="col-xs-12 col-md-12 neo-table">
	<div class="col-md-12 header d-none d-md-block">
	    <div class="row">
	      	<div class="col-xs-1 col-md-1 cell hidden-xs"><b>Nro</b></div>
	      	<div class="col-xs-6 col-md-2 cell"><b>Nombre</b></div>
	      	<div class="col-xs-6 col-md-1 cell"><b>Mod.Num.</b></div>
	      	<div class="col-xs-6 col-md-2 cell"><b>Plan Educ.</b></div>
	      	<div class="col-xs-6 col-md-2 cell"><b>Horas</b></div>
	      	<div class="col-xs-6 col-md-2 cell"><b>Creditos</b></div>
	      	<div class="col-xs-2 col-md-1 cell text-center"></div>
	      	<div class="col-xs-2 col-md-1 cell text-center"></div>
	    </div>
	</div>
	<div class="col-md-12 body">
		<?php
		    $nro=0;
		    foreach ($modulos as $dts) {
		        $nro++;
		    ?>
		    <div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
		      	<div class="col-xs-12 col-md-3 group">
		        	<div class="col-sm-6 col-md-4 cell">
		          		<span><?php echo $nro ;?></span>
		        	</div>
			        <div class="col-sm-6 col-md-8 cell">
			          	<span><?php echo $dts->modnom ?></span>
			        </div>
		      	</div>
		      	<div class="col-xs-12 col-md-3 group">
		        	<div class="col-sm-6 col-md-4 cell">
		          		<span><?php echo $dts->modnum ;?></span>
		        	</div>
			        <div class="col-sm-6 col-md-8 cell">
			          	<span><?php echo $dts->nomplan ?></span>
			        </div>
		      	</div>
		      	<div class="col-xs-12 col-md-4 group">
		        	<div class="col-sm-6 col-md-6 cell">
		          		<span><?php echo $dts->modhoras ;?></span>
		        	</div>
			        <div class="col-sm-6 col-md-6 cell">
			          	<span><?php echo $dts->modcred ?></span>
			        </div>
		      	</div>
		      	<div class="col-xs-12 col-md-2 group">
		        	<div class="col-sm-6 col-md-6 cell text-center">
		          		<button class="btn btn-sm btn-info btn-block" href="#" onclick="viewupdamodulo('<?php echo base64url_encode($dts->id) ?>')" title="Editar Módulo">
		            		<i class="fas fa-pencil-alt"></i> <span class="d-block d-md-none">Editar Módulo</span>
		          		</button>
		        	</div>
		        	<div class="col-sm-6 col-md-6 cell text-center">
		          		<a class="btn btn-sm btn-danger btn-block" href="#" data-toggle="modal" data-target="#modal_danger_modulo" data-idmod="<?php echo base64url_encode($dts->id) ?>" title="Eliminar Módulo">
		            		<i class="fas fa-trash-alt"></i> <span class="d-block d-md-none">Eliminar Módulo</span>
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