<?php
	$vbaseurl=base_url();
	if (getPermitido("20")=='SI'){
?>
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_niveles" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-user-plus mr-1"></i> Registro de Niveles</h3>
		    </div>
		    <div class="card-body">
		    	<div class="border border-secondary rounded p-2">
					<form id="frm_niveles" action="<?php echo $vbaseurl ?>nivel/fn_insert_niveles" method="post" accept-charset='utf-8'>
						<b class="text-danger"><i class="fas fa-users-cog"></i> Niveles</b>
						<div class="row mt-2">
							<div class="form-group has-float-label col-12 col-xs-12 col-sm-3">
								<input data-currentvalue='' class="form-control text-uppercase" id="fictxtidnivel" name="fictxtidnivel" type="text" placeholder="Codigo Nivel" />
								<label for="fictxtidnivel">Codigo Nivel</label>
							</div>
				          	<div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
								<input data-currentvalue='' class="form-control text-uppercase" id="fictxtnivel" name="fictxtnivel" type="text" placeholder="Nombre Nivel" />
								<label for="fictxtnivel">Nombre Nivel</label>
							</div>
							<div class="form-group has-float-label col-12 col-xs-12 col-sm-3">
								<button type="submit" class="btn btn-primary btn-md float-left" id="btnregisniv"><i class="fas fa-save"></i> Registrar</button>
							</div>
				        </div>
					</form>
				</div>
		    </div>
		    <div class="card-body">
		    	<small id="fmt_conteo" class="form-text text-primary">
            
                </small>
                <div class="col-12 py-1">
                    <div class="btable">
                        <div class="thead col-12  d-none d-md-block">
                            <div class="row">
                                <div class='col-12 col-md-9'>
                                    <div class='row'>
                                        <div class='col-2 col-md-2 td'>N°</div>
                                        <div class='col-10 col-md-10 td'>NOMBRE</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-3 text-center'>
                                    <div class='row'>
                                        <div class='col-12 col-md-12 td'>
                                            <span>ACCIONES</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="tbody col-12" id="divcard_data_nivel">
                            
                        </div>
                    </div>
                </div>
		    </div>
		</div>
	</section>
</div>

<div class="modal fade" id="modal-edit-niv" aria-modal="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="divmodalnived">
            <div class="modal-header">
            	<h4 class="modal-title">Editar Nivel</h4>
        	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            	    <span aria-hidden="true">×</span>
              	</button>
            </div>
            <div class="modal-body" id="msgcuerpo">
            	<form id="frm_edit_niveles" action="" method="post" accept-charset='utf-8'>
					<b class="text-danger"><i class="fas fa-globe"></i> Niveles</b>
					<div class="row mt-2">
						<div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
							<input data-currentvalue='' class="form-control text-uppercase" id="fictxtidniveled" name="fictxtidniveled" type="text" placeholder="Codigo Nivel" readonly="" />
							<label for="fictxtidniveled">Codigo Nivel</label>
						</div>
			          	<div class="form-group has-float-label col-12 col-xs-12 col-sm-8">
							<input data-currentvalue='' class="form-control text-uppercase" id="fictxtniveled" name="fictxtniveled" type="text" placeholder="Nombre Nivel" />
							<label for="fictxtniveled">Nombre Nivel</label>
						</div>
			        </div>
			        <div class="row mt-2">
			        	<div class="col-12">
			        		<div id="divmsgniveled" class="float-left">

							</div>
			        	</div>
			        </div>
				</form>
            </div>
            <div class="modal-footer justify-content-between">
              	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              	<button type="button" class="btn btn-primary" id="btnactniv">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/niveles.js"></script>

<?php
}
else{
$this->load->view('errors/sin-resultados');
}
?>