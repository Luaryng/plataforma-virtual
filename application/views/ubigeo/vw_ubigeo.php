<?php
	$vbaseurl=base_url();
	if (getPermitido("20")=='SI'){
?>
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_ubigeo" class="card text-dark">
			<div class="card-header">
                <ul class="nav nav-pills">
                	<li class="nav-item"><a class="nav-link active" href="#data-depart" data-toggle="tab"><b><i class="fas fa-map-marker-alt mr-1"></i>Departamento</b></a></li>
                  	<li class="nav-item"><a class="nav-link" href="#data-prov" data-toggle="tab"><b><i class="fas fa-map-marker-alt mr-1"></i>Provincia</b></a></li>
                  	<li class="nav-item"><a class="nav-link" href="#data-dist" data-toggle="tab"><b><i class="fas fa-map-marker-alt mr-1"></i>Distrito</b></a></li>
                </ul>
            </div>
            <div class="card-body">
            	<div class="border border-info p-2 rounded">
	            	<div class="tab-content">
				    	<div class="active tab-pane" id="data-depart">
							<ul class="nav nav-pills">
			                	<li class="nav-item"><a class="nav-link active" href="#datos-dep" data-toggle="tab"><b><i class="fas fa-list mr-1"></i>Datos</b></a></li>
			                  	<li class="nav-item"><a class="nav-link" href="#registrar-dep" data-toggle="tab"><b><i class="fas fa-map-marker-alt mr-1"></i>Registrar</b></a></li>
			                </ul>
			                <div class="card-body p-2">
			                	<div class="tab-content">
				    				<div class="active tab-pane" id="datos-dep">
										<div id="divdata_departamento">
											<small id="fmt_conteo" class="form-text text-primary">
	            
					                        </small>
							                <div class="col-12 py-1" id="divdata-campania">
							            	    <div class="btable">
					                                <div class="thead col-12 d-none d-md-block">
					                                    <div class="row">
					                                        <div class='col-12 col-md-9'>
					                                            <div class='row'>
					                                                <div class='col-2 col-md-2 td'>N°</div>
					                                                <div class='col-10 col-md-10 td'>NOMBRE</div>
					                                            </div>
					                                        </div>
					                                        <div class='col-12 col-md-3 text-center'>
					                                            <div class='row'>
					                                                <div class='col-sm-12 col-md-12 td'>
					                                                    <span>ACCIONES</span>
					                                                </div>
					                                            </div>
					                                        </div>
					                                    </div>
					                                    
					                                </div>
					                                <div class="tbody col-12" id="divcard_data_departam">
					                                    
					                                </div>
					                            </div>
							                </div>
										</div>
				    				</div>
				    				<div class="tab-pane" id="registrar-dep">
				    					<div class="alert alert-secondary alert-dismissible fade show bordered">
											<strong>Aviso:</strong> Antes de ingresar los datos, verifica si el DEPARTAMENTO no ha sido registrado anteriormente
										</div>
										<div class="border border-secondary rounded p-2">
											<form id="frm_departam" action="<?php echo $vbaseurl ?>ubigeo/fn_insert_depart" method="post" accept-charset="utf-8">
												<b class="mt-2 text-danger"><i class="fas fa-map-marker-alt"></i> Departamento</b>
						            			<div class="row mt-2">
										          	<div class="form-group has-float-label col-12 col-sm-8">
														<input data-currentvalue='' class="form-control text-uppercase" id="fitxtdepart" name="fitxtdepart" type="text" placeholder="Nombre Departamento" />
														<label for="fitxtdepart">Nombre Departamento</label>
													</div>
													<div class="form-group has-float-label col-12 col-sm-4">
														<button type="submit" class="btn btn-primary btn-md float-left" id="btnregisdep"><i class="fas fa-save"></i> Registrar</button>
													</div>
										        </div>
										        <div class="row mt-2">
										        	<div class="col-6">
										        		<div id="divmsgdepart" class="float-left">
															
														</div>
										        	</div>
										        </div>
						            		</form>
						            	</div>
				    				</div>
				    			</div>
			                </div>
				    	</div>
				    	<div class="tab-pane" id="data-prov">
				    		<ul class="nav nav-pills">
			                	<li class="nav-item"><a class="nav-link active" href="#datos-prov" data-toggle="tab"><b><i class="fas fa-list mr-1"></i>Datos</b></a></li>
			                  	<li class="nav-item"><a class="nav-link" href="#registrar-prov" data-toggle="tab"><b><i class="fas fa-map-marker-alt mr-1"></i>Registrar</b></a></li>
			                </ul>
			                <div class="card-body p-2">
			                	<div class="tab-content">
				    				<div class="active tab-pane" id="datos-prov">
				    					<div id="divfiltro_prov" class="row mt-2">
				    						<div class="col-8 col-md-8 form-group has-float-label">
				    							<select class="form-control" id="ficfiltprovin" name="ficfiltprovin" placeholder="Departamento">
								              		<option value="%">Todos</option>
								              		<?php foreach ($depart as $dep) { ?>
								              		<option value="<?php echo $dep->codigo ?>"><?php echo $dep->nombre ?></option>
								              		<?php } ?>
								            	</select>
								            	<label for="ficfiltprovin"> Departamento</label>
				    						</div>
				    						<div class="col-4 col-md-4">
				    							<button class="btn btn-info" id="btn_filprov">
				    								<i class="fas fa-search"></i> Buscar
				    							</button>
				    						</div>
				    					</div>
										<div id="divdata_provincia" class="mt-2">
											<small id="fmt_conteoprov" class="form-text text-primary">
	            
					                        </small>
							                <div class="col-12 py-1" id="divdata-provincia">
							            	    <div class="btable">
					                                <div class="thead col-12 d-none d-md-block">
					                                    <div class="row">
					                                        <div class='col-12 col-md-8'>
					                                            <div class='row'>
					                                                <div class='col-2 col-md-2 td'>N°</div>
					                                                <div class='col-10 col-md-10 td'>PROVINCIA</div>
					                                            </div>
					                                        </div>
					                                        <div class='col-12 col-md-4 text-center'>
					                                            <div class='row'>
					                                            	<div class='col-6 col-md-6 td'>DEPARTAMENTO</div>
					                                                <div class='col-6 col-md-6 td'>
					                                                    <span>ACCIONES</span>
					                                                </div>
					                                            </div>
					                                        </div>
					                                    </div>
					                                    
					                                </div>
					                                <div class="tbody col-12" id="divcard_data_provincia">
					                                    
					                                </div>
					                            </div>
							                </div>
										</div>
				    				</div>
				    				<div class="tab-pane" id="registrar-prov">
				    					<div class="alert alert-secondary alert-dismissible fade show bordered">
											<strong>Aviso:</strong> Antes de ingresar los datos, verifica si la PROVINCIA no ha sido registrada anteriormente
										</div>
										<div class="border border-secondary rounded p-2">
					    					<form id="frm_provinc" action="<?php echo $vbaseurl ?>ubigeo/fn_insert_provin" method="post" accept-charset="utf-8">
					    						<b class="p-2 text-danger"><i class="fas fa-map-marker-alt"></i> Provincia</b>
						            			<div class="row mt-2">
													<div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
										            	<select data-currentvalue='' class="form-control" id="ficdepart" name="ficdepart" placeholder="Departamento" required >
										              		<option value="0">Selecciona Departamento</option>
										              		<?php foreach ($depart as $dep) { ?>
										              		<option value="<?php echo $dep->codigo ?>"><?php echo $dep->nombre ?></option>
										              		<?php } ?>
										            	</select>
										            	<label for="ficdepart"> Departamento</label>
										          	</div>
													<div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
														<input data-currentvalue='' class="form-control text-uppercase" id="fitxtprovinc" name="fitxtprovinc" type="text" placeholder="Nombre Provincia" />
														<label for="fitxtprovinc">Nombre Provincia</label>
													</div>
										        </div>
										        <div class="row">
										        	<div class="col-6">
										        		<div id="divmsgprovinc" class="float-left">

														</div>
										        	</div>
										        	<div class="col-6">
										        		<button type="submit" class="btn btn-primary btn-md float-right" id="btnregispro"><i class="fas fa-save"></i> Registrar</button>
										        	</div>
										        </div>
						            		</form>
						            	</div>
				    				</div>
				    			</div>
				    		</div>
				    	</div>
				    	<div class="tab-pane" id="data-dist">
				    		<ul class="nav nav-pills">
			                	<li class="nav-item"><a class="nav-link active" href="#datos-dist" data-toggle="tab"><b><i class="fas fa-list mr-1"></i>Datos</b></a></li>
			                  	<li class="nav-item"><a class="nav-link" href="#registrar-dist" data-toggle="tab"><b><i class="fas fa-map-marker-alt mr-1"></i>Registrar</b></a></li>
			                </ul>
			                <div class="card-body p-2">
			                	<div class="tab-content">
				    				<div class="active tab-pane" id="datos-dist">
				    					<div id="divfiltro_distrito" class="row mt-2">
				    						<div class="col-8 col-md-8 form-group has-float-label">
				    							<select class="form-control" id="ficfiltdistrito" name="ficfiltdistrito" placeholder="Provincia" required >
								              		<option value="%">Todos</option>
								              		<?php foreach ($provinc as $prva) { ?>
								              		<option value="<?php echo $prva->codigo ?>"><?php echo $prva->nombre ?></option>
								              		<?php } ?>
								            	</select>
								            	<label for="ficfiltdistrito"> Provincia</label>
				    						</div>
				    						<div class="col-4 col-md-4">
				    							<button class="btn btn-info" id="btn_fildistrito">
				    								<i class="fas fa-search"></i> Buscar
				    							</button>
				    						</div>
				    					</div>
										<div id="divdata_distrito">
											<small id="fmt_conteodist" class="form-text text-primary">
	            
					                        </small>
							                <div class="col-12 py-1" id="divdata-distrito">
							            	    <div class="btable">
					                                <div class="thead col-12 d-none d-md-block">
					                                    <div class="row">
					                                        <div class='col-12 col-md-8'>
					                                            <div class='row'>
					                                                <div class='col-2 col-md-2 td'>N°</div>
					                                                <div class='col-10 col-md-5 td'>DISTRITO</div>
					                                                <div class='col-12 col-md-5 td'>PROVINCIA</div>
					                                            </div>
					                                        </div>
					                                        <div class='col-12 col-md-4 text-center'>
					                                            <div class='row'>
					                                            	<div class='col-6 col-md-6 td'>DEPARTAMENTO</div>
					                                                <div class='col-6 col-md-6 td'>
					                                                    <span>ACCIONES</span>
					                                                </div>
					                                            </div>
					                                        </div>
					                                    </div>
					                                    
					                                </div>
					                                <div class="tbody col-12" id="divcard_data_distrito">
					                                    
					                                </div>
					                            </div>
							                </div>
										</div>
				    				</div>
				    				<div class="tab-pane" id="registrar-dist">
				    					<div class="alert alert-secondary alert-dismissible fade show bordered">
											<strong>Aviso:</strong> Antes de ingresar los datos, verifica si el DISTRITO no ha sido registrado anteriormente
										</div>
										<div class="border border-secondary rounded p-2">
											<form id="frm_distr" action="<?php echo $vbaseurl ?>ubigeo/fn_insert_distrito" method="post" accept-charset="utf-8">
												<b class="p-2 text-danger"><i class="fas fa-map-marker-alt"></i> Distrito</b>
						            			<div class="row mt-2">
						            				<div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
										            	<select data-currentvalue='' class="form-control" id="ficdepartam" name="ficdepartam" placeholder="Departamento" required >
										              		<option value="0">Selecciona Departamento</option>
										              		<?php foreach ($depart as $dep) { ?>
										              		<option value="<?php echo $dep->codigo ?>"><?php echo $dep->nombre ?></option>
										              		<?php } ?>
										            	</select>
										            	<label for="ficdepartam"> Departamento</label>
										          	</div>
													<div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
										            	<select data-currentvalue='' class="form-control" id="ficprovinc" name="ficprovinc" placeholder="Provincia" required >
										              		<option value="0">Sin opciones</option>
										            	</select>
										            	<label for="ficprovinc"> Provincia</label>
										          	</div>
													<div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
														<input data-currentvalue='' class="form-control text-uppercase" id="fitxtdistr" name="fitxtdistr" type="text" placeholder="Nombre Distrito" />
														<label for="fitxtdistr">Nombre Distrito</label>
													</div>
										        </div>
										        <div class="row">
										        	<div class="col-6">
										        		<div id="divmsgdistr" class="float-left">

														</div>
										        	</div>
										        	<div class="col-6">
										        		<button type="submit" class="btn btn-primary btn-md float-right" id="btnregisdis"><i class="fas fa-save"></i> Registrar</button>
										        	</div>
										        </div>
						            		</form>
						            	</div>
				    				</div>
				    			</div>
				    		</div>
				    	</div>
				    </div>
			    </div>
            </div>
        </div>
	</section>
</div>

<div class="modal fade" id="modal-edita" aria-modal="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="divmodaldepa">
            <div class="modal-header">
            	<h4 class="modal-title">Editar Departamento</h4>
        	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            	    <span aria-hidden="true">×</span>
              	</button>
            </div>
            <div class="modal-body" id="msgcuerpo">
            	<form id="frm_edit_depar" action="" method="post" accept-charset="utf-8">
                    <div class="row">
                        <div class="form-group has-float-label col-12 col-sm-12">
                            <input type="hidden" name="fitxtidep" id="fitxtidep" value="">
                            <input data-currentvalue="" class="form-control text-uppercase" id="fitxtdeped" name="fitxtdeped" type="text" placeholder="Nombre Departamento" />
                            <label for="fitxtdeped">Nombre Departamento</label>
                        </div>
           
                    </div>
                    <div class="row margin-top-20px">
                        <div class="col-6">
                            <div id="divmsgdepedit" class="float-left">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
              	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              	<button type="button" class="btn btn-primary" id="btnactdep">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edita-prov" aria-modal="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="divmodalprov">
            <div class="modal-header">
            	<h4 class="modal-title">Editar Provincia</h4>
        	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            	    <span aria-hidden="true">×</span>
              	</button>
            </div>
            <div class="modal-body" id="msgcuerpo">
            	<form id="frm_edit_provinc" action="" method="post" accept-charset="utf-8">
        			<div class="row margin-top-20px">
						<div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
			            	<select data-currentvalue='' class="form-control" id="ficdeped" name="ficdeped" placeholder="Departamento" required >
			              		<option value="0">Selecciona Departamento</option>
			              		<?php foreach ($depart as $dep) { ?>
			              		<option value="<?php echo $dep->codigo ?>"><?php echo $dep->nombre ?></option>
			              		<?php } ?>
			            	</select>
			            	<label for="ficdeped"> Departamento</label>
			          	</div>
						<div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
							<input type="hidden" name="fitxtidpr" id="fitxtidpr" value="">
							<input data-currentvalue='' class="form-control text-uppercase" id="fitxtproved" name="fitxtproved" type="text" placeholder="Nombre Provincia" />
							<label for="fitxtproved">Nombre Provincia</label>
						</div>
			        </div>
			        <div class="row">
			        	<div class="col-6">
			        		<div id="divmsgprovedit" class="float-left">

							</div>
			        	</div>
			        </div>
        		</form>
            </div>
            <div class="modal-footer justify-content-between">
              	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              	<button type="button" class="btn btn-primary" id="btnactprov">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edita-dist" aria-modal="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="divmodaldist">
            <div class="modal-header">
            	<h4 class="modal-title">Editar Distrito</h4>
        	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            	    <span aria-hidden="true">×</span>
              	</button>
            </div>
            <div class="modal-body" id="msgcuerpo">
            	<form id="frm_edit_distrit" action="" method="post" accept-charset="utf-8">
        			<div class="row margin-top-20px">
        				<div class="form-group has-float-label col-12 col-sm-6">
			            	<select onchange='fn_combo_ubigeo_modal($(this),"modal-edita-dist");' data-tubigeo='departamento' data-cbprovincia='ficproved' data-cbdistrito='fitxtidist' data-dvcarga='divcard_datos' class="form-control" id="ficdepedist" name="ficdepedist" placeholder="Departamento" required >
			              		<option value="0">Selecciona Departamento</option>
			              		<?php foreach ($depart as $dep) { ?>
			              		<option value="<?php echo $dep->codigo ?>"><?php echo $dep->nombre ?></option>
			              		<?php } ?>
			            	</select>
			            	<label for="ficdepedist"> Departamento</label>
			          	</div>
						<div class="form-group has-float-label col-12 col-sm-6">
			            	<select data-currentvalue='' class="form-control" id="ficproved" name="ficproved" placeholder="Provincia" required >
			              		<option value="0">Selecciona Provincia</option>
			            	</select>
			            	<label for="ficproved"> Provincia</label>
			          	</div>
						<div class="form-group has-float-label col-12 col-sm-12">
							<input type="hidden" name="fitxtidist" id="fitxtidist" value="">
							<input data-currentvalue='' class="form-control text-uppercase" id="fitxtdisted" name="fitxtdisted" type="text" placeholder="Nombre Distrito" />
							<label for="fitxtdisted">Nombre Distrito</label>
						</div>
			        </div>
			        <div class="row">
			        	<div class="col-6">
			        		<div id="divmsgdistedit" class="float-left">

							</div>
			        	</div>
			        </div>
        		</form>
            </div>
            <div class="modal-footer justify-content-between">
              	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              	<button type="button" class="btn btn-primary" id="btnactdist">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/ubigeo.js"></script>

<?php
}
else{
$this->load->view('errors/sin-resultados');
}
?>