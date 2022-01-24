<?php
	$vbaseurl=base_url();
	if (getPermitido("20")=='SI'){
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_modalidad" class="card text-dark">
			<div class="card-header">
                <ul class="nav nav-pills">
                	<li class="nav-item"><a class="nav-link active" href="#search-modalidad" data-toggle="tab"><b><i class="fas fa-list mr-1"></i>Datos</b></a></li>
                  	<li class="nav-item"><a class="nav-link" href="#registrar-modalidad" data-toggle="tab"><b><i class="fas fa-user-plus mr-1"></i>Registrar</b></a></li>
                </ul>
            </div>
		    <div class="card-body">
		    	<div class="tab-content">
			    	<div class="tab-pane" id="registrar-modalidad">
	      				<div class="alert alert-secondary alert-dismissible fade show bordered">
							<strong>Aviso:</strong> Antes de ingresar los datos, verifica si la MODALIDAD no ha sido registrada anteriormente
						</div>
                        <div class="border border-secondary rounded p-2">
    						<form id="frm_modalidad" action="<?php echo $vbaseurl ?>modalidad/fn_insert_modal" method="post" accept-charset='utf-8'>
    							<b class="text-danger"><i class="fas fa-globe"></i> Modalidad</b>
    							<div class="row mt-2">
    								<div class="form-group has-float-label col-12 col-xs-12 col-sm-9">
    									<input data-currentvalue='' class="form-control text-uppercase" id="fitxtmod" name="fitxtmod" type="text" placeholder="Nombre Campaña" />
    									<label for="fitxtmod">Nombre Modalidad</label>
    								</div>
                                    <div class="form-group col-sm-3">
                                        <label for="checkestado">Activo:</label>
                                        <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                    </div>
    							</div>
    							<div class="row mt-2">
    					        	<div class="col-6">
    					        		<div id="divmsgmod" class="float-left">

    									</div>
    					        	</div>
    								<div class="col-6">
    									<button type="submit" class="btn btn-primary btn-md float-right" id="btnregismod"><i class="fas fa-save"></i> Registrar</button>
    								</div>
    							</div>
    						</form>
                        </div>
					</div>
					<div class="active tab-pane" id="search-modalidad">
                        <small id="fmt_conteo" class="form-text text-primary">
            
                        </small>
                        <div class="col-12 py-1">
                            <div class="btable">
                                <div class="thead col-12  d-none d-md-block">
                                    <div class="row">
                                        <div class='col-12 col-md-8'>
                                            <div class='row'>
                                                <div class='col-2 col-md-2 td'>N°</div>
                                                <div class='col-10 col-md-10 td'>NOMBRE</div>
                                            </div>
                                        </div>
                                        <div class='col-12 col-md-4 text-center'>
                                            <div class='row'>
                                                <div class='col-6 col-md-6 td'>
                                                    <span>ACTIVO</span>
                                                </div>
                                                <div class='col-6 col-md-6 td'>
                                                    <span>ACCIONES</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="tbody col-12" id="divcard_data_modalidad">
                                    
                                </div>
                            </div>
                        </div>
					</div>
				</div>
		    </div>
	    </div>
	</section>
</div>

<div class="modal fade" id="modal-edit-mod" aria-modal="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="divmodalcamped">
            <div class="modal-header">
            	<h4 class="modal-title">Editar Modalidad</h4>
        	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            	    <span aria-hidden="true">×</span>
              	</button>
            </div>
            <div class="modal-body" id="msgcuerpo">
            	<form id="frm_edit_modalidad" action="<?php //echo $vbaseurl ?>modalidad/fn_update_modal" method="post" accept-charset='utf-8'>
					<b class="text-danger"><i class="fas fa-globe"></i> Modalidad</b>
					<div class="row mt-2">
						<div class="form-group has-float-label col-12 col-xs-12 col-sm-12">
							<input type="hidden" name="fictxtidmod" id="fictxtidmod" value="">
							<input data-currentvalue='' class="form-control text-uppercase" id="fitxtmoded" name="fitxtmoded" type="text" placeholder="Nombre Campaña" />
							<label for="fitxtmoded">Nombre Modalidad</label>
						</div>
					</div>
					<div class="row margin-top-20px">
			        	<div class="col-6">
			        		<div id="divmsgmoded" class="float-left">

							</div>
			        	</div>
					</div>
				</form>
            </div>
            <div class="modal-footer justify-content-between">
              	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              	<button type="button" class="btn btn-primary" id="btnactmod">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/modalidad.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<?php
}
else{
$this->load->view('errors/sin-resultados');
}
?>