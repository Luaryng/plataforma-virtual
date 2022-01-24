<?php
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<h1>
			Registro Matrículas
			</h1>
		</div>
	</section>

	<section class="content">
		<div id="divcardmatriculas" class="card">
			<div class="card-body">
				<div class="table-responsive margin-top-10px no-padding">
					
					<div class="btable mt-3">
	                    <div class="thead col-12  d-none d-md-block">
	                        <div class="row">
	                            <div class='col-12 col-md-2'>
	                                <div class='row'>
	                                    <div class='col-2 col-md-2 td'>N°</div>
	                                    <div class='col-10 col-md-10 td'>CARNET</div>
	                                </div>
	                            </div>
	                            <div class='col-12 col-md-3'>
	                                <div class='row'>
	                                    <div class='col-8 col-md-8 td'>FECHA</div>
	                                    <div class='col-4 col-md-4 td'>ESTADO</div>
	                                </div>
	                            </div>
	                            <div class='col-12 col-md-6 text-center'>
	                                <div class='row'>
	                                    <div class='col-2 col-md-2 td'>
	                                        <span>PERIODO</span>
	                                    </div>
	                                    
	                                    <div class='col-6 col-md-6 td'>
	                                        <span>PROGRAMA</span>
	                                    </div>
	                                    <div class='col-2 col-md-2 td'>
	                                        <span>CICLO</span>
	                                    </div>
	                                    <div class='col-2 col-md-2 td'>
	                                        <span>TURNO</span>
	                                    </div>
	                                    
	                                </div>
	                            </div>
	                            <div class='col-12 col-md-1 text-center'>
	                            	<div class='col-12 col-md-12 td'>
                                        <span></span>
                                    </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="tbody col-12" id="divresult">
	                    	<?php
	                    		$nro = 0;
	                    		$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
	                    		foreach ($mismatriculas as $mtc) {
	                    			$nro ++;
	                    			$datemat =  new DateTime($mtc->fecha) ;
	                    			$vmatricula = $dias[$datemat->format('w')].". ".$datemat->format('d/m/Y h:i a');
	                    			$codigo = base64url_encode($mtc->codigo);
	                    			echo 
		                            "<div class='row cfila'>
		                                <div class='col-12 col-md-2'>
		                                    <div class='row'>
		                                        <div class='col-2 col-md-2 td'>$nro</div>
		                                        <div class='col-10 col-md-10 td'>
		                                            <span>$mtc->carnet</span>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class='col-12 col-md-3'>
		                                	<div class='row'>
		                                        <div class='col-8 col-md-8 td'>
		                                        	<small><i class='far fa-calendar-alt'></i> $vmatricula</small>
		                                        </div>
		                                        <div class='col-4 col-md-4 td'>
		                                            <span>$mtc->estado_matricula</span>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class='col-12 col-md-6'>
		                                	<div class='row'>
		                                        <div class='col-2 col-md-2 td'>
		                                        	<span>$mtc->periodo</span>
		                                        </div>
		                                        <div class='col-6 col-md-6 td'>
		                                            <span>$mtc->carrera</span>
		                                        </div>
		                                        <div class='col-2 col-md-2 td'>
		                                        	<span>$mtc->ciclo - $mtc->seccion</span>
		                                        </div>
		                                        <div class='col-2 col-md-2 td'>
		                                        	<span>$mtc->turno</span>
		                                        </div>
		                                        
		                                    </div>
		                                </div>
		                                <div class='col-12 col-md-1 text-center td'>
											<a href='{$vbaseurl}academico/matricula/imprimir/$codigo' class='btn btn-sm btn-primary' target='_blank'>
												Ficha
											</a>
			                            </div>
		                            </div>";
	                    		}
	                    	?>
	                    </div>
	                </div>
					
				</div>
			</div>
		</div>		
	</section>
</div>