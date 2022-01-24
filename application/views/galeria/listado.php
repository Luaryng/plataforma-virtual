<?php 
	$vbaseurl = base_url();
	$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
	$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
?>
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_galeria" class="card">
			<div class="card-header">
				<h3 class="card-title text-bold"><i class="fas fa-image mr-1"></i> Galería institucional</h3>
                <?php if (getPermitido("116")=='SI'){ ?>
				<div class="card-tools">
					<a href="<?php echo $vbaseurl."portal-web/galeria/agregar" ?>" class="btn btn-outline-dark"><i class="fas fa-plus"></i> Agregar álbum</a>
				</div>
                <?php } ?>
			</div>
			<div class="card-body">
				<small id="fmt_conteo" class="form-text text-primary">
            
                </small>
                <div class="col-12 py-1">
                    <div class="btable">
                        <div class="thead col-12  d-none d-md-block">
                            <div class="row">
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-2 col-md-2 td'>N°</div>
                                        <div class='col-10 col-md-10 td'>ALBUM</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-8 col-md-8 td'>DESCRIPCIÓN</div>
                                        <div class='col-4 col-md-4 td'>REGISTRO</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-2 text-center'>
                                    <div class='row'>
                                        <div class='col-12 col-md-12 td'>
                                            <span>ACCIONES</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="tbody col-12" id="divcard_data_album">
                        	<?php
                        	$nro=0;
                        	foreach ($album as $key => $value) {
                        		$nro++;
                        		$datepubl =  new DateTime($value->fecha);
                        		$vpublica= $dias[$datepubl->format('w')].". ".$datepubl->format('d/m/Y h:i a');          
                            	$codigo_enc=base64url_encode($value->id);
                        	?>

                            <div class='row rowcolor cfila' data-album='<?php echo $codigo_enc ?>'>
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-2 col-md-2 text-right td'><?php echo $nro ?></div>
                                        <div class='col-10 col-md-10 td'><?php echo $value->nombre ?></div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                    	<div class='col-8 col-md-8 td'><?php echo $value->detalle ?></div>
                                        <div class='col-4 col-md-4 td'><?php echo $vpublica ?></div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-2 text-center'>
                                    <div class='row'>
                                        <div class='col-12 col-sm-12 col-md-12 td'>
                                            <div class='col-12 pt-1 pr-3 text-center'>
                                                <div class='btn-group'>
                                                    <a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                        <i class='fas fa-cog'></i>
                                                    </a>
                                                    <div class='dropdown-menu dropdown-menu-right acc_dropdown'>
                                                        <?php if (getPermitido("117")=='SI'){ ?>
                                                        <a class='dropdown-item' href='<?php echo "{$vbaseurl}portal-web/galeria/editar/$codigo_enc" ?>' title='Editar'>
                                                            <i class='fas fa-edit mr-1'></i> Editar
                                                        </a>
                                                        <?php } 
                                                            if (getPermitido("118")=='SI'){ ?>
                                                        <a class='dropdown-item text-danger' href='#' title='Eliminar' data-codigo='<?php echo $codigo_enc ?>' onclick="vw_pw_tp_pr_fn_delete_album($(this));event.preventDefault();">
                                                            <i class='fas fa-trash mr-1'></i> Eliminar
                                                        </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        	}
                        	?>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</section>
</div>

<?php echo "<script src='{$vbaseurl}resources/dist/js/pages/galeria.js'></script>"; ?>