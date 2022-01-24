<small id="fmt_conteo" class="form-text text-primary">
            
</small>
<div class="col-12 py-1" id="divdata-periodo">
	<div class="btable">
        <div class="thead col-12  d-none d-md-block">
        	<div class="row">
                <div class='col-12 col-md-3'>
                    <div class='row'>
                        <div class='col-1 col-md-2 td'>N°</div>
                        <div class='col-5 col-md-5 td'>CARNE</div>
                        <div class='col-5 col-md-5 td'>PERIODO</div>
                    </div>
                </div>
                <div class='col-12 col-md-6'>
                    <div class='row'>
                    	<div class='col-3 col-md-3 td text-center'>PROGRAMA</div>
                        <div class='col-6 col-md-6 td'>ALUMNO</div>
                        <div class='col-3 col-md-3 td'>FEC. INSC.</div>
                    </div>
                </div>
                <div class='col-12 col-md-3 text-center'>
                    <div class='row'>
                        <div class='col-6 col-md-6 td'>
                            <span>ESTADO</span>
                        </div>
                        <div class='col-6 col-md-6 td'>
                            <span></span>
                        </div>

                    </div>
                </div>
            </div>
            
        </div>
        <div class="tbody col-12" id="divcard_data_reingresos">
        	<?php
			$nro=0;
			foreach ($historial as $usuario) {
				$fn="";
				$nro++;
				$nombres=$usuario->paterno.' '.$usuario->materno.', '.$usuario->nombres;
				$idins=base64url_encode($usuario->codinscripcion);
				$codperiodo=base64url_encode($usuario->codperiodo);

	        	$ciclo = $usuario->codciclo;
                $turno = $usuario->turno;
                $carne = $usuario->carnet;
	                

			?>
        
			<div class='row rowcolor cfila' data-codcarrera='<?php echo $usuario->codcarrera ?>' data-carrera='<?php echo $usuario->carrera ?>' data-paterno='<?php echo $usuario->paterno ?>' data-materno='<?php echo $usuario->materno ?>' data-nombres='<?php echo $usuario->nombres ?>' data-sexo='<?php echo $usuario->sexo ?>' data-campania='<?php echo $usuario->idcampania ?>' data-ci="<?php echo $idins ?>" data-cp='<?php echo $usuario->codperiodo ?>' data-cic='<?php echo $ciclo ?>' data-turno="<?php echo $turno ?>" data-carne="<?php echo $carne ?>">
                <div class='col-12 col-md-3'>
                    <div class='row'>
                        <div class='col-2 col-md-2 td'><?php echo $nro ?></div>
                        <div class='col-5 col-md-5 td'><?php echo $usuario->carnet ?></div>
                        <div class='col-5 col-md-5 td'><?php echo $usuario->periodo ?></div>
                    </div>
                </div>
                <div class='col-12 col-md-6'>
                    <div class='row'>
                    	<div class='col-2 col-md-3 td text-center'><?php echo $usuario->carsigla ?></div>
                        <div class='col-7 col-md-6 td'>
                        	<b class="mr-2"><?php echo ($usuario->sexo=='MASCULINO') ? '<i class="fas fa-male fa-lg text-primary"></i>':'<i class="fas fa-female  fa-lg text-danger"></i>' ?> </b>
                        	<span class="cell-alumno"><?php echo $nombres ?></span>
                        </div>
                        <div class='col-3 col-md-3 td'><?php echo date("d-m-Y", strtotime($usuario->fecinsc)); ?></div>
                    </div>
                </div>
                <div class='col-12 col-md-3 text-center'>
                    <div class='row'>
                        <div class='col-6 col-md-6 td'>
                            <span class="badge bg-danger p-2"><?php echo $usuario->estado ?></span>
                        </div>
                        <div class='col-6 col-md-6 td'>
                            <a class="d-block bg-warning py-1 rounded btn_reingresar" href="#" title="Reingreso" data-toggle="modal" data-target="#modaddreingreso" data-color='btn-warning'>
					            <i class="fas fa-share text-dark"></i> Reingresar
					        </a>
                        </div>
                    </div>
                </div>
			</div>
		<?php } ?>
        </div>
    </div>

</div>
