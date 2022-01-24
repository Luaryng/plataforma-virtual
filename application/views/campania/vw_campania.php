<?php 
	$vbaseurl=base_url();

	if (getPermitido("20")=='SI'){
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">

	<div class="modal fade" id="modal-lg" aria-modal="true" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content" id="divmodalcamp">
	            <div class="modal-header">
	            	<h4 class="modal-title">Editar Campaña</h4>
	        	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            	    <span aria-hidden="true">×</span>
	              	</button>
	            </div>
	            <div class="modal-body" id="msgcuerpo">
	            	
	            </div>
	            <div class="modal-footer justify-content-between">
	              	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	              	<button type="button" class="btn btn-primary" id="btnactcam">Actualizar</button>
	            </div>
	        </div>
	    </div>
	</div>

	<section id="s-cargado" class="content pt-2">
		<div id="divcard-campania" class="card text-dark">
			<div class="card-header">
                <ul class="nav nav-pills">
                	<li class="nav-item"><a class="nav-link active" href="#search-campania" data-toggle="tab"><b><i class="fas fa-search mr-1"></i>Búsqueda</b></a></li>
                  	<li class="nav-item"><a class="nav-link" href="#registrar-campania" data-toggle="tab"><b><i class="fas fa-user-plus mr-1"></i>Registrar</b></a></li>
                </ul>
            </div>
	      	<div class="card-body">
	      		<div class="tab-content">

			    	<div class="tab-pane" id="registrar-campania">
	      				<div class="alert alert-secondary alert-dismissible fade show bordered">
							<strong>Aviso:</strong> Antes de ingresar los datos, verifica si la CAMPAÑA no ha sido registrada anteriormente
						</div>
						<div class="border border-secondary rounded p-2">
							<form id="frm_campania" action="<?php echo $vbaseurl ?>campania/fn_insert_campania" method="post" accept-charset='utf-8'>
								<b class="text-danger"><i class="fas fa-globe"></i> Campaña</b>
								<div class="row mt-3">
						        	<div class="form-group has-float-label col-12 col-xs-12 col-sm-3">
						            	<select data-currentvalue='' class="form-control" id="ficperiodo" name="ficperiodo" placeholder="periodo" required >
						              		<option value="0">Selecciona periodo</option>
						              		<?php foreach ($datosp as $per) { ?>
						              		<option value="<?php echo $per->codigo ?>"><?php echo $per->nombre ?></option>
						              		<?php } ?>
						            	</select>
						            	<label for="ficperiodo"> periodo</label>
						          	</div>
						          	<div class="form-group has-float-label col-12 col-xs-12 col-sm-9">
										<input data-currentvalue='' class="form-control text-uppercase" id="fitxtnomcampania" name="fitxtnomcampania" type="text" placeholder="Nombre Campaña" />
										<label for="fitxtnomcampania">Nombre Campaña</label>
									</div>
						        </div>
						        <div class="row mt-2">
						        	<div class="form-group has-float-label col-12 col-xs-4 col-sm-6">
										<input data-currentvalue='' class="form-control text-uppercase" id="fitxtdescampania" name="fitxtdescampania" type="text" placeholder="Descripción Campaña" />
										<label for="fitxtdescampania">Descripción Campaña</label>
									</div>
									<div class="form-group has-float-label col-12 col-xs-4 col-sm-3">
		                    			<input data-currentvalue='' type="date" class="form-control" id="datinicia" name="datinicia">
		                    			<label for="datinicia">Fecha Inicia:</label>
			                		</div>
			                		<div class="form-group has-float-label col-12 col-xs-4 col-sm-3">
		                    			<input data-currentvalue='' type="date" class="form-control" id="datculmina" name="datculmina">
		                    			<label for="datculmina">Fecha Finaliza:</label>
			                		</div>
						        </div>
						        <div class="row mt-2">
						        	<div class="form-group has-float-label col-12 col-xs-4 col-sm-5">
		                    			<select name="cbosede" id="cbosede" class="form-control">
		                    				<option value="">Seleccione sede</option>
		                    				<?php
												foreach ($sedes as $sed) {
												echo '<option value="'.$sed->id.'">'.$sed->nombre.'</option>';
												}
											?>
		                    			</select>
		                    			<label for="cbosede">Sede</label>
			                		</div>
			                		<div class="form-group col-md-2">
                                        <label for="checkestado">Activo:</label>
                                        <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                    </div>
						        </div>
						        <div class="row mt-2">
						        	<div class="col-6">
						        		<div id="divmsgcamp" class="float-left">

										</div>
						        	</div>
									<div class="col-6">
										<button type="submit" class="btn btn-primary btn-md float-right" id="btnregis"><i class="fas fa-save"></i> Registrar</button>
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="active tab-pane" id="search-campania">
						<div class="row mt-2">
							<div class="form-group has-float-label col-md-4">
								<select name="fictxtbuscar" id="fictxtbuscar" class="form-control" placeholder="2019">
									<option value="%">Todos</option>
						              		<?php foreach ($datosp as $per) { ?>
						              		<option value="<?php echo $per->codigo ?>"><?php echo $per->nombre ?></option>
						              		<?php } ?>
								</select>
								<label for="fictxtbuscar"> Periodo</label>
							</div>
							
						</div>
				        
				        <small id="fmt_conteo" class="form-text text-primary">
            
                        </small>
		                <div class="col-12 py-1 d-none" id="divdata-campania">
		            	    <div class="btable">
                                <div class="thead col-12  d-none d-md-block">
                                    <div class="row">
                                        <div class='col-12 col-md-4'>
                                            <div class='row'>
                                                <div class='col-1 col-md-2 td'>N°</div>
                                                <div class='col-3 col-md-4 td'>PERIODO</div>
                                                <div class='col-3 col-md-6 td text-center'>NOMBRE</div>
                                            </div>
                                        </div>
                                        <div class='col-12 col-md-4'>
                                            <div class='row'>
                                                <div class='col-9 col-md-8 td'>DESCRIPCIÓN</div>
                                                <div class='col-9 col-md-4 td'>INICIA</div>
                                            </div>
                                        </div>
                                        <div class='col-12 col-md-4 text-center'>
                                            <div class='row'>
                                                <div class='col-sm-3 col-md-4 td'>
                                                    <span>FINALIZA</span>
                                                </div>
                                                <div class='col-sm-3 col-md-4 td'>
                                                    <span>ACTIVO</span>
                                                </div>
                                                <div class='col-sm-4 col-md-4 td'>
                                                    <span>ACCIONES</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="tbody col-12" id="divcard_data_campania">

                                </div>
                            </div>
		                </div>
					</div>
				</div>
	      	</div>
	    </div>
	</section>
</div>

<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/campania.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js">



</script>

<?php
}
else{
	$this->load->view('errors/sin-resultados');
}
?>