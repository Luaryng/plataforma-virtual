<?php
	$vbaseurl=base_url();
	
	if (getPermitido("20")=='SI'){
?>
<link href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">

		<div id="divcard_periodo" class="card text-dark">
			<div class="card-header">
                <ul class="nav nav-pills">
                	<li class="nav-item"><a class="nav-link active" href="#search-periodo" data-toggle="tab"><b><i class="fas fa-search mr-1"></i>Búsqueda</b></a></li>
                  	<li class="nav-item"><a class="nav-link" href="#registrar-periodo" data-toggle="tab"><b><i class="fas fa-user-plus mr-1"></i>Registrar</b></a></li>
                </ul>
            </div>
		    <div class="card-body">
		    	<div class="tab-content">
			    	<div class="tab-pane" id="registrar-periodo">
	      				<div class="alert alert-secondary alert-dismissible fade show bordered">
							<strong>Aviso:</strong> Antes de ingresar los datos, verifica si el PERIODO no ha sido registrado anteriormente
						</div>
						<div class="border border-secondary rounded p-2">
							<form class="" id="frm_periodos" action="<?php echo $vbaseurl ?>periodo/fn_insert_periodo" method="post" accept-charset='utf-8'>
								<b class="mt-2 text-danger"><i class="fas fa-globe"></i> Periodo Académico</b>
								<?php
									$mes = date('m');
									$anio = date('Y');
									$codper = "";
									$nomper = "";
									if ($mes > 5) {
										$codper = $anio . '2';
										$nomper = $anio . '-II';
									} else {
										$codper = $anio . '1';
										$nomper = $anio . '-I';
									}
								?>
								<div class="row mt-2">
									<div class="form-group has-float-label col-12 col-sm-3">
										<input data-currentvalue='' class="form-control text-uppercase" id="fictxtidper" name="fictxtidper" type="text" placeholder="Codigo Periodo" value="<?php echo $codper ?>" />
										<label for="fictxtidper">Codigo Periodo</label>
									</div>
						          	<div class="form-group has-float-label col-12 col-sm-3">
										<input data-currentvalue='' class="form-control text-uppercase" id="fictxtperiodo" name="fictxtperiodo" type="text" placeholder="Nombre Periodo" value="<?php echo $nomper ?>" />
										<label for="fictxtperiodo">Nombre Periodo</label>
									</div>
									
									<!-- <div class="form-group col-12 col-xs-3 col-sm-3">
					                    <div class="custom-control custom-switch" style="margin-top: 8px;">
					                    	<input type="checkbox" class="custom-control-input" id="activper" checked="">
					                    	<label class="custom-control-label" for="activper">Activo</label>
					                    </div>
					                </div> -->
					                <div class="form-group has-float-label col-12 col-sm-3">
										<input data-currentvalue='' class="form-control text-uppercase" id="fictxtperanio" name="fictxtperanio" type="text" placeholder="Periodo Año" value="<?php echo $anio ?>" />
										<label for="fictxtperanio">Periodo Año</label>
									</div>
									<div class="form-group has-float-label col-12 col-sm-3">
										<select name="fictxtestado" id="fictxtestado" class="form-control">
											<option value="ACTIVO">ACTIVO</option>
											<option value="CERRADO">CERRADO</option>
											<option value="RESERVA">RESERVA</option>
										</select>
										<label for="fictxtestado">Estado</label>
									</div>
						        </div>
						        <div class="row mt-2">
									<div class="col-12 col-md-6" id="divcardactive">
			                            <label for="checkactiva">
			                            	<i class="badge badge-pill badge-secondary">?</i> Habilitar periodo
			                            </label>
			                            <input value="SI" id="checkactiva" name="checkactiva" data-size="xs" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
			                        </div>
						        </div>
						        <div class="row mt-2">
						        	<div class="col-6">
						        		<div id="divmsgperiodo" class="float-left">

										</div>
						        	</div>
						        	<div class="col-6">
										<button type="submit" class="btn btn-primary btn-md float-right" id="btnregisper"><i class="fas fa-save"></i> Registrar</button>
						        	</div>
						        </div>
							</form>
						</div>
						
					</div>
					<div class="active tab-pane" id="search-periodo">
						<div class="row mt-2">
							<div class="form-group has-float-label col-8 col-md-6 col-sm-8">
								<input type="text" name="fictxtbuscar" id="fictxtbuscar" class="form-control" placeholder="2019-I">
								<label for="fictxtbuscar">Nombre Periodo</label>
							</div>
							<div class=" col-4 col-md-2 col-sm-4">
					        	<button class="btn btn-block btn-info" type="button" id="btn_busca_per">
					        		<i class="fas fa-search"></i>
					        	</button>
					      	</div>
						</div>
						
			            <div class="row mt-2">
			            	<small id="fmt_conteo" class="form-text text-primary">
            
            				</small>
			                <div class="col-12 py-1" id="divdata-periodo">
			                	<div class="btable">
				                    <div class="thead col-12  d-none d-md-block">
				                    	<div class="row">
				                            <div class='col-12 col-md-4'>
				                                <div class='row'>
				                                    <div class='col-1 col-md-2 td'>N°</div>
				                                    <div class='col-3 col-md-3 td'>CÓDIGO</div>
				                                    <div class='col-3 col-md-4 td'>NOMBRE</div>
				                                    <div class='col-3 col-md-3 td text-center'>AÑO</div>
				                                </div>
				                            </div>
				                            <div class='col-12 col-md-4'>
				                                <div class='row'>
				                                    <div class='col-9 col-md-9 td'>RESPONSABLE</div>
				                                </div>
				                            </div>
				                            <div class='col-12 col-md-4 text-center'>
				                                <div class='row'>
				                                    <div class='col-sm-3 col-md-4 td'>
				                                        <span>INSCRIPCIÓN</span>
				                                    </div>
				                                    <div class='col-sm-3 col-md-4 td'>
				                                        <span>ESTADO</span>
				                                    </div>
				                                    <div class='col-sm-4 col-md-4 td'>
				                                        <span>ACCIONES</span>
				                                    </div>

				                                </div>
				                            </div>
				                        </div>
				                        
				                    </div>
				                    <div class="tbody col-12" id="divcard_data_periodo">

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

<div class="modal fade" id="modal-edit-per" aria-modal="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="divmodalpered">
            <div class="modal-header">
            	<h4 class="modal-title">Editar Periodo</h4>
        	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            	    <span aria-hidden="true">×</span>
              	</button>
            </div>
            <div class="modal-body" id="msgcuerpo">
            	<form id="frm_edit_periodo" action="" method="post" accept-charset='utf-8'>
					<b class="text-danger"><i class="fas fa-globe"></i> Periodo</b>
					<div class="row mt-2">
						<div class="form-group has-float-label col-12 col-xs-3 col-sm-6">
							<input type="hidden" name="fictxtcodant" id="fictxtcodant" value="">
							<input data-currentvalue='' class="form-control text-uppercase" id="fictxtidpered" name="fictxtidpered" type="text" placeholder="Codigo Periodo" value="" />
							<label for="fictxtidpered">Codigo Periodo</label>
						</div>
			          	<div class="form-group has-float-label col-12 col-xs-3 col-sm-6">
							<input data-currentvalue='' class="form-control text-uppercase" id="fictxtperiodoed" name="fictxtperiodoed" type="text" placeholder="Nombre Periodo" value="" />
							<label for="fictxtperiodoed">Nombre Periodo</label>
						</div>
		                <div class="form-group has-float-label col-12 col-xs-3 col-sm-6">
							<input data-currentvalue='' class="form-control text-uppercase" id="fictxtperanioed" name="fictxtperanioed" type="text" placeholder="Periodo Año" value="" />
							<label for="fictxtperanioed">Periodo Año</label>
						</div>
			        	<div class="form-group has-float-label col-12 col-xs-3 col-sm-6">
							<select name="fictxtestadoed" id="fictxtestadoed" class="form-control">
								<option value="ACTIVO">ACTIVO</option>
								<option value="CERRADO">CERRADO</option>
								<option value="RESERVA">RESERVA</option>
							</select>
							<label for="fictxtestadoed">Estado</label>
						</div>
			        </div>
			        <div class="row mt-2">
			        	<div class="col-12">
			        		<div id="divmsgperiodoed" class="float-left">

							</div>
			        	</div>
			        </div>
				</form>
            </div>
            <div class="modal-footer justify-content-between">
              	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              	<button type="button" class="btn btn-primary" id="btnactper">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/admision.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<script type="text/javascript">
	var vdocentes = <?php echo json_encode($docentes, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) ?>;
	$(document).ready(function() {
		// $('#divcardactive .toggle').css('width', '43.8594px');
		$('#divcardactive .toggle').css({
			width: '43.8594px',
			height: '18.5938px'
		});

        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 5000,
          // timerProgressBar: true,
        })

        Toast.fire({
          type: 'info',
          icon: 'info',
          title: 'Aviso: Antes de agregar un periodo, verifica si no ha sido registrado anteriormente'
        })
        $("#fictxtbuscar").focus();
        search_periodo("");
    });

</script>
<?php
}
else{
$this->load->view('errors/sin-resultados');
}
?>