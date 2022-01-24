<?php $vbaseurl = base_url(); ?>
<style>
	.seccion-title{
		background-color: black;
		color: white;
		padding: 5px;
		font-size: 1.2em;
		margin:2px 0 20px -2px;
	}
</style>
<link href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="content-wrapper">

	<div class="modal fade" id="modupsede" aria-modal="true" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content" id="divmodsede">
	            <div class="modal-header">
	            	<h4 class="modal-title">Editar Sede</h4>
	        	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            	    <span aria-hidden="true">×</span>
	              	</button>
	            </div>
	            <div class="modal-body" id="msgcuerpo">
	            	<form id="frm_updatesede" action="<?php echo $vbaseurl ?>sede/fn_insert_update" method="post" accept-charset='utf-8'>
						<b class="margin-top-10px text-danger"><i class="fas fa-globe"></i> Sede</b>
						<div class="row mt-2">
	                        <div class="form-group has-float-label col-12 col-sm-8">
	                            <input type="hidden" name="fictxtaccion" id="fictxtaccion" value="EDITAR">
	                            <input type="hidden" name="fictxtcodigo" id="fictxtcodigo" value="">
	                            <input class="form-control" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre Sede" />
	                            <label for="fictxtnombre">Nombre Sede</label>
	                        </div>
	                        <div class="form-group col-md-4">
	                            <label for="checkestado">Activo:</label>
	                            <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
	                        </div>
	                        <div class="form-group has-float-label col-12 col-sm-12">
	                            <select name="fictxtcodper" id="fictxtcodper" class="form-control">
	                                <option value="">Seleccione Item</option>
	                                <?php
	                                    foreach ($docentes as $key => $value) {
	                                        echo "<option value='$value->codpersona'>$value->nombres</option>";
	                                    }
	                                ?>
	                            </select>
	                            <label for="fictxtcodper">Titular</label>
	                        </div>
	                    </div>
	                    
	                    <div class="row mt-2">
	                        <div class="form-group has-float-label col-12  col-md-6">
	                            <select onchange='fn_combo_ubigeo_modal($(this),"modupsede");' data-tubigeo='departamento' data-cbprovincia='vw_ins_cbprovincia' data-cbdistrito='vw_ins_cbdistrito' data-dvcarga='divcard_datos' class="form-control" id="ficbdepartamento" name="ficbdepartamento" placeholder="Departamento" required >
	                                <option value="0">Selecciona Departamento</option>
	                                <?php foreach ($departamentos as $key => $depa) {?>
	                                <option value="<?php echo $depa->codigo ?>"><?php echo $depa->nombre ?></option>
	                                <?php } ?>
	                            </select>
	                            <label for="ficbdepartamento"> Departamento</label>
	                        </div>
	                        <div class="form-group has-float-label col-12  col-md-6">
	                            <select onchange='fn_combo_ubigeo_modal($(this),"modupsede");' data-tubigeo='provincia' data-cbdistrito='vw_ins_cbdistrito' data-dvcarga='divcard_datos' class="form-control" id="vw_ins_cbprovincia" name="vw_ins_cbprovincia" placeholder="Provincia" required >
	                                <option value="0">Sin opciones</option>
	                            </select>
	                            <label for="vw_ins_cbprovincia"> Provincia</label>
	                        </div>
	                        <div class="form-group has-float-label col-12 col-md-6">
	                            <select name="vw_ins_cbdistrito" id="vw_ins_cbdistrito"  class="form-control text-uppercase">
	                                                                        
	                            </select>
	                            <label for="vw_ins_cbdistrito">Distrito</label>
	                        </div>
	                        <div class="form-group has-float-label col-12 col-sm-6">
	                            <input class="form-control" id="fictxtlocal" name="fictxtlocal" type="text" placeholder="Tipo Local" />
	                            <label for="fictxtlocal">Tipo Local</label>
	                        </div>
	                        <div class="form-group has-float-label col-12 col-sm-12">
	                            <input class="form-control" id="fictxtdireccion" name="fictxtdireccion" type="text" placeholder="Dirección" />
	                            <label for="fictxtdireccion">Dirección</label>
	                        </div>
	                    </div>

						<div class="row mt-2">
				        	<div class="col-12">
				        		<div id="divmsgsede" class="float-left">

								</div>
				        	</div>
						</div>
					</form>
	            </div>
	            <div class="modal-footer justify-content-between">
	              	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	              	<button type="button" class="btn btn-primary" id="btn_updsede">Guardar</button>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="modfacturacion" aria-modal="true" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content" id="divmodfacturacion">
	            <div class="modal-header">
	                <h4 class="modal-title" id="titlefact">Facturacion</h4>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">×</span>
	                </button>
	            </div>
	            <div class="modal-body" id="msgcuerpo">
	                <form id="frm_fatursede" action="<?php echo $vbaseurl ?>sede/fn_update_nfacturacion" method="post" accept-charset='utf-8'>
	                    <input type="hidden" name="fictxtcodigosed" id="fictxtcodigosed" value="">
	                    
	                    <div class="row mt-2">
	                        <div class="form-group has-float-label col-12  col-md-12">
	                            <textarea name="ficbrutanube" id="ficbrutanube" rows="3" class="form-control"></textarea>
	                            <label for="ficbrutanube"> Ruta</label>
	                        </div>
	                        <div class="form-group has-float-label col-12  col-md-12">
	                            <textarea name="ficbtokennube" id="ficbtokennube" rows="5" class="form-control"></textarea>
	                            <label for="ficbtokennube"> Token</label>
	                        </div>
	                    </div>

	                    <div class="row mt-2">
	                        <div class="col-12">
	                            <div id="divmsgfact" class="float-left">

	                            </div>
	                        </div>
	                    </div>
	                </form>
	            </div>
	            <div class="modal-footer justify-content-between">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	                <button type="button" class="btn btn-primary" id="btn_factsede">Guardar</button>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="modconfiguracion" aria-modal="true" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content" id="divmodconfiguracion">
	            <div class="modal-header">
	                <h4 class="modal-title" id="titleconf">Configuación</h4>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">×</span>
	                </button>
	            </div>
	            <div class="modal-body" id="msgcuerpo">
	                <form id="frm_configsede" action="<?php echo $vbaseurl ?>sede/fn_update_configuracion" method="post" accept-charset='utf-8'>
	                    <input type="hidden" name="fictxtcodigosedconf" id="fictxtcodigosedconf" value="">
	                    
	                    <div class="row mt-2 border-bottom">
	                        <div class="form-group col-9 col-md-10">
	                            <label for="checkdocaddestud">El docente puede agregar estudiantes? </label>
	                        </div>
	                        <div class="form-group col-3 col-md-2">
								<input  id="checkdocaddestud" name="checkdocaddestud" class="checkdocaddestud" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
	                        </div>
	                    </div>
	                    <div class="row mt-2 border-bottom">
	                        <div class="form-group col-9  col-md-10">
	                            <label for="checkestvernota">El estudiante puede ver sus evaluaciones? </label>
	                        </div>
	                        <div class="form-group col-3 col-md-2">
								<input  id="checkestvernota" name="checkestvernota" class="checkestvernota" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
	                        </div>
	                    </div>
	                    <div class="row mt-2 border-bottom">
	                        <div class="form-group col-9 col-md-10">
	                            <label for="checkdocentrecup">El docente puede actualizar notas de recuperación? </label>
	                        </div>
	                        <div class="form-group col-3 col-md-2">
	                        	<input  id="checkdocentrecup" name="checkdocentrecup" class="checkdocentrecup" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
	                        </div>
	                    </div>
	                    <div class="row mt-2 border-bottom">
	                        <div class="form-group col-9 col-md-10">
	                            <label for="checkestdescbol">El estudiante puede descargar su boleta de notas? </label>
	                        </div>
	                        <div class="form-group col-3 col-md-2">
	                        	<input  id="checkestdescbol" name="checkestdescbol" class="checkestdescbol" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
	                        </div>
	                    </div>
	                    <div class="row mt-2 border-bottom">
	                        <div class="form-group col-9 col-md-10">
	                            <label for="checkbloqautopag">Bloqueo automático de visualización de notas si tiene deudas? </label>
	                        </div>
	                        <div class="form-group col-3 col-md-2">
	                        	<input  id="checkbloqautopag" name="checkbloqautopag" class="checkbloqautopag" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
	                        </div>
	                    </div>
	                    <div class="row mt-2 border-bottom">
	                        <div class="form-group col-9 col-md-10">
	                            <label for="checkNsp">Permitir NSP (No se presento al examen final)? </label>
	                        </div>
	                        <div class="form-group col-3 col-md-2">
	                        	<input  id="checkNsp" name="checkNsp" class="checkNsp" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
	                        </div>
	                    </div>
	                    <div class="row mt-2 border-bottom">
	                        <div class="form-group col-9 col-md-10">
	                            <label for="checkmigranotas">Al culminar una unidad didáctica las notas deben migrar automaticamente al histório? </label>
	                        </div>
	                        <div class="form-group col-3 col-md-2">
	                        	<input  id="checkmigranotas" name="checkmigranotas" class="checkmigranotas" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
	                        </div>
	                    </div>

	                    <div class="row mt-2 border-bottom">
	                        <div class="form-group col-9 col-md-10">
	                            <label for="checkbloquedpi">Si el estudiante presenta DPI deshabilitar ingreso de notas?</label>
	                        </div>
	                        <div class="form-group col-3 col-md-2">
	                        	<input  id="checkbloquedpi" name="checkbloquedpi" class="checkbloquedpi" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
	                        </div>
	                    </div>
	                    
	                    <div class="row mt-2">
	                        <div class="col-12">
	                            <div id="divmsgfact" class="float-left">

	                            </div>
	                        </div>
	                    </div>
	                </form>
	            </div>
	            <div class="modal-footer justify-content-between">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	                <button type="button" class="btn btn-primary" id="btn_configsede">Guardar</button>
	            </div>
	        </div>
	    </div>
	</div>

	<section id="s-cargado" class="content pt-2">
		<!-- Custom Tabs -->
		<div class="card" id="divcard_datos" >
			<div class="card-header d-flex p-0">
				<ul class="nav nav-pills p-2">
					<li class="nav-item"><a class="nav-link active text-bold" href="#tab_1" data-toggle="tab"><i class="fas fa-university fa-fw"></i> Principal</a></li>
					<li class="nav-item"><a class="nav-link text-bold" href="#tab_2" data-toggle="tab"><i class="far fa-building fa-fw"></i> Filiales</a></li>
				</ul>
				</div><!-- /.card-header -->
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
							
							<form id="frm_update" action="" method="post" accept-charset="utf-8">
								<div class="row mt-2">
									<input type="hidden" name="fictxtcodigo" id="fictxtcodigo" value="<?php echo base64url_encode($dts->id) ?>">
									<div class="form-group has-float-label col-12 col-md-4">
										<input  value="<?php echo $dts->codmodular ?>" class="form-control form-control-sm text-uppercase" id="fictxtmodul" name="fictxtmodul" type="text" placeholder="Código modular" />
										<label for="fictxtmodul">Código modular</label>
									</div>
									<div class="form-group has-float-label col-12 col-md-4">
										<input  value="<?php echo $dts->gestion ?>" class="form-control form-control-sm text-uppercase" id="fictxtgestion" name="fictxtgestion" type="text" placeholder="Gestión" />
										<label for="fictxtgestion">Gestión</label>
										<small class="help-text">* PÚBLICO, PRIVADO, MIXTO </small>
									</div>
									<div class="form-group has-float-label col-12 col-md-4">
										<input  value="<?php echo $dts->dre ?>" class="form-control form-control-sm text-uppercase" id="fictxtdre" name="fictxtdre" type="text" placeholder="DRE" />
										<label for="fictxtdre">DRE</label>
										<small class="help-text">Solo colocar la Zona ej: PIURA</small>
									</div>
									<div class="form-group has-float-label col-12 col-md-6">
										<input  value="<?php echo $dts->nombre ?>" class="form-control form-control-sm text-uppercase" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre Institucional Abreviado" />
										<label for="fictxtnombre">Nombre Institucional Abreviado</label>
										<small class="help-text">Nombre corto con el que es conocida la Institución </small>
									</div>
									<div class="form-group has-float-label col-12 col-md-6">
										<input  value="<?php echo $dts->pnombre ?>" class="form-control form-control-sm text-uppercase" id="fictxtnombre_pre" name="fictxtnombre_pre" type="text" placeholder="Nombre Institucional" />
										<label for="fictxtnombre_pre">Nombre Institucional</label>
										<small class="help-text">Nombre Institucional con el que es conocida la Institución </small>
									</div>
									<div class="form-group has-float-label col-12">
										<input  value="<?php echo $dts->denoml ?>" class="form-control form-control-sm text-uppercase" id="fictxtnombre_largo" name="fictxtnombre_largo" type="text" placeholder="Nombre Institucional completa" />
										<label for="fictxtnombre_largo">Denominación Larga</label>
										<small class="help-text">Denominación larga con el que es conocida la Institución </small>
									</div>
									<div class="form-group has-float-label col-12 col-md-6">
										<input  value="<?php echo $dts->denomc ?>" class="form-control form-control-sm text-uppercase" id="fictxtnombre_corto" name="fictxtnombre_corto" type="text" placeholder="Nombre Institucional corta" />
										<label for="fictxtnombre_corto">Denominación Corta</label>
										<small class="help-text">Denominación corta con el que es conocida la Institución </small>
									</div>
									<div class="form-group has-float-label col-12 col-md-6">
										<input  value="<?php echo $dts->snombre ?>" class="form-control form-control-sm text-uppercase" id="fictxtnombre_solo" name="fictxtnombre_solo" type="text" placeholder="Nombre Institucional" />
										<label for="fictxtnombre_solo">Nombre Institucional</label>
										<small class="help-text">Solo nombre de la Institución </small>
									</div>
									<div class="col-12 col-md-6">
										<label for="checkactivains">
											<i class="badge badge-pill badge-secondary">?</i> Habilitar Institución
										</label>
										<input value="SI" id="checkactivains" <?php echo ($dts->activo=="SI")?"checked":"" ?> name="checkactivains" data-size="xs" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								
								<h3 class="seccion-title">Resoluciones</h3>
								<div class="row mt-2">
									<div class="form-group has-float-label col-12 col-md-4">
										<input  value="<?php echo $dts->creacion ?>" class="form-control form-control-sm text-uppercase" id="fictxtcreacion" name="fictxtcreacion" type="text" placeholder="Creación" />
										<label for="fictxtcreacion">Creación</label>
									</div>
									<div class="form-group has-float-label col-12 col-md-4">
										<input  value="<?php echo $dts->resolucion ?>" class="form-control form-control-sm text-uppercase" id="fictxtresolu" name="fictxtresolu" type="text" placeholder="Reconocimiento / Resolución" />
										<label for="fictxtresolu">Reconocimiento / Resolución</label>
									</div>
									<div class="form-group has-float-label col-12 col-md-4">
										<input  value="<?php echo $dts->revalidacion ?>" class="form-control form-control-sm text-uppercase" id="fictxtrevali" name="fictxtrevali" type="text" placeholder="Revalidación" />
										<label for="fictxtrevali">Revalidación</label>
									</div>
								</div>
								<h3 class="seccion-title">Ubicación</h3>
								<div class="row mt-2">
									<div class="form-group has-float-label col-12  col-md-3">
										<select onchange='fn_combo_ubigeo($(this));' data-tubigeo='departamento' data-cbprovincia='vw_ins_cbprovincia' data-cbdistrito='vw_ins_cbdistrito' data-dvcarga='divcard_datos' class="form-control form-control-sm" id="ficbdepartamento" name="ficbdepartamento" placeholder="Departamento" required >
											<option value="0">Selecciona Departamento</option>
											<?php foreach ($departamentos as $key => $depa) {?>
											<option value="<?php echo $depa->codigo ?>"><?php echo $depa->nombre ?></option>
											<?php } ?>
										</select>
										<label for="ficbdepartamento"> Departamento</label>
									</div>
									<div class="form-group has-float-label col-12  col-md-4">
										<select onchange='fn_combo_ubigeo($(this));' data-tubigeo='provincia' data-cbdistrito='vw_ins_cbdistrito' data-dvcarga='divcard_datos' class="form-control form-control-sm" id="vw_ins_cbprovincia" name="vw_ins_cbprovincia" placeholder="Provincia" required >
											<option value="0">Sin opciones</option>
										</select>
										<label for="vw_ins_cbprovincia"> Provincia</label>
									</div>
									<div class="form-group has-float-label col-12 col-md-5">
										<select name="vw_ins_cbdistrito" id="vw_ins_cbdistrito"  class="form-control form-control-sm text-uppercase">
											<option value="0">Sin opciones</option>
										</select>
										<label for="vw_ins_cbdistrito">Distrito</label>
									</div>
									<div class="form-group has-float-label col-12 col-md-5">
										<input  value="<?php echo $dts->centropoblado ?>" class="form-control form-control-sm text-uppercase" id="fictxtcpob" name="fictxtcpob" type="text" placeholder="Centro Poblado" />
										<label for="fictxtcpob">Centro Poblado</label>
									</div>
									<div class="form-group has-float-label col-12 col-md-7">
										<input  value="<?php echo $dts->direccion ?>" class="form-control form-control-sm" id="fictxtdirec" name="fictxtdirec" type="text" placeholder="Dirección" />
										<label for="fictxtdirec">Dirección</label>
									</div>
								</div>
								<h3 class="seccion-title">Contactar</h3>
								<div class="row mt-2">
									<div class="form-group has-float-label col-12 col-md-6">
										<input  value="<?php echo $dts->emailsoport ?>" class="form-control form-control-sm" id="fictxtemail_soporte" name="fictxtemail_soporte" type="text" placeholder="Email soporte" />
										<label for="fictxtemail_soporte"><i class="far fa-envelope"></i> Email Soporte</label>
									</div>
									<div class="form-group has-float-label col-12 col-md-6">
										<input  value="<?php echo $dts->whatsoporte ?>" class="form-control form-control-sm" id="fictxtwhatsoporte" name="fictxtwhatsoporte" type="text" placeholder="Whatsapp Soporte" />
										<label for="fictxtwhatsoporte"><i class="fab fa-whatsapp"></i> Whatsapp Soporte</label>
									</div>
									<div class="form-group has-float-label col-12 col-sm-6">
										<input  value="<?php echo $dts->web ?>" class="form-control form-control-sm" id="fictxtweb" name="fictxtweb" type="text" placeholder="Web" />
										<label for="fictxtweb"><i class="fas fa-globe"></i> Web</label>
									</div>
									<div class="form-group has-float-label col-12 col-md-6">
										<input  value="<?php echo $dts->email ?>" class="form-control form-control-sm" id="fictxtemail_inst" name="fictxtemail_inst" type="text" placeholder="Email Institución" />
										<label for="fictxtemail_inst"><i class="far fa-envelope"></i> Email Institución</label>
									</div>
									<div class="form-group has-float-label col-12 col-sm-6">
										<input  value="<?php echo $dts->telefono ?>" class="form-control form-control-sm" id="fictxttelefono" name="fictxttelefono" type="text" placeholder="Teléfono Institución" />
										<label for="fictxttelefono"><i class="fas fa-phone"></i> Teléfono Institución</label>
									</div>
								</div>
								<h3 class="seccion-title">Accesos</h3>
								<div class="row mt-2">
									<div class="col-12 col-md-6">
										<label for="checkopcion1">
											<i class="badge badge-pill badge-secondary">?</i> Habilitar acceso con usuario plataforma
										</label>
										<input value="SI" id="checkopcion1" <?php echo ($dts->accplataf=="SI")?"checked":"" ?> name="checkopcion1" data-size="xs" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
									</div>
									<div class="col-12 col-md-6">
										<label for="checkopcion2">
											<i class="badge badge-pill badge-secondary">?</i> Habilitar acceso con correo institucional
										</label>
										<input value="SI" id="checkopcion2" <?php echo ($dts->accgmail=="SI")?"checked":"" ?> name="checkopcion2" data-size="xs" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<div class="row mt-2">
									<div class="form-group has-float-label col-12">
										<textarea name="fictxtgsuiteid" id="fictxtgsuiteid" class="form-control form-control-sm" rows="3"><?php echo base64url_decode($dts->gsuite) ?></textarea>
										<label for="fictxtgsuiteid"> Codigo Gsuite</label>
									</div>
									<div class="form-group has-float-label col-12">
										<textarea name="fictxtgsuitekey" id="fictxtgsuitekey" class="form-control form-control-sm" rows="3"><?php echo base64url_decode($dts->gsuitekey) ?></textarea>
										<label for="fictxtgsuitekey"> Key Gsuite</label>
									</div>
									<div class="form-group has-float-label col-12">
										<textarea name="fictxtgsuitecsc" id="fictxtgsuitecsc" class="form-control form-control-sm" rows="3"><?php echo base64url_decode($dts->gsuitecsc) ?></textarea>
										<label for="fictxtgsuitecsc"> Csc Gsuite</label>
									</div>
								</div>
								
							</form>
							
							<div class="row">
								<button type="button" id="lbtn_guardar" class="btn btn-primary float-right">Guardar</button>
							</div>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="tab_2">
							<small id="fmt_conteo" class="form-text text-primary">
							
							</small>
							<div class="col-12 py-1">
								<div class="btable">
									<div class="thead col-12  d-none d-md-block">
										<div class="row">
											<div class='col-12 col-md-4'>
												<div class='row'>
													<div class='col-1 col-md-2 td'>N°</div>
													<div class='col-3 col-md-5 td'>SEDE</div>
													<div class='col-3 col-md-5 td text-center'>DISTRITO</div>
												</div>
											</div>
											<div class='col-12 col-md-5'>
												<div class='row'>
													<div class='col-9 col-md-3 td'>ACTIVO</div>
													<div class='col-9 col-md-9 td'>TITULAR</div>
												</div>
											</div>
											<div class='col-12 col-md-3 text-center'>
												<div class='row'>
													<div class='col-sm-3 col-md-6 td'>
														<span>LOCAL</span>
													</div>
													<div class='col-sm-4 col-md-6 td'>
														<span>ACCIONES</span>
													</div>
												</div>
											</div>
										</div>
										
									</div>
									<div class="tbody col-12" id="divcard_data_sedes">
										
									</div>
								</div>
							</div>
						</div>
						<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
					</div><!-- /.card-body -->
				</div>
				
			</section>
		</div>
		<script src="<?php echo base_url() ?>resources/dist/js/pages/ubigeo_uni.js"></script>
		<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function($) {
			    $('#frm_update #vw_ins_cbprovincia').html("<?php echo $provincias ?>");
			    $('#frm_update #vw_ins_cbdistrito').html("<?php echo $distritos ?>");
			    $('#frm_update #ficbdepartamento').val("<?php echo $dts->coddepartamento ?>");
			    $('#frm_update #vw_ins_cbprovincia').val("<?php echo $dts->codprovincia ?>");
			    $('#frm_update #vw_ins_cbdistrito').val("<?php echo $dts->idistrito ?>");
			    filtro_sedes("%");
			});

			$('#lbtn_guardar').click(function() {
			    $('#frm_update input,select').removeClass('is-invalid');
			    $('#frm_update .invalid-feedback').remove();
			    $('#divcard_datos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			    $.ajax({
			        url: base_url + "iestp/fn_update_datos",
			        type: 'post',
			        dataType: 'json',
			        data: $('#frm_update').serialize(),
			        success: function(e) {
			            $('#divcard_datos #divoverlay').remove();
			            if (e.status == false) {
			                $.each(e.errors, function(key, val) {
			                    $('#' + key).addClass('is-invalid');
			                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
			                });

			                Swal.fire({
			                    title: 'Existen errores en los campos',
			                    // text: "",
			                    type: 'error',
			                    icon: 'error',
			                })
			            } else {
			                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
			                $('#divmsgies').html(msgf);
			                Swal.fire({
			                    title: e.msg,
			                    // text: "",
			                    type: 'success',
			                    icon: 'success',
			                }).then((result) => {
			                    if (result.value) {
			                        location.reload();
			                    }
			                })
			            }
			        },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception, 'text');
			            $('#divcard_datos #divoverlay').remove();
			            Swal.fire({
			                title: msgf,
			                // text: "",
			                type: 'error',
			                icon: 'error',
			            })
			        }
			    });
			    return false;
			});

			function filtro_sedes(nomsede) {
			    $('#divcard_sede').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			    $.ajax({
			        url: base_url + 'sede/search_sede',
			        type: 'post',
			        dataType: 'json',
			        data: {
			            nomsede: nomsede
			        },
			        success: function(e) {
			            if (e.status == true) {
			                $('#divcard_data_sedes').html("");
			                var nro = 0;
			                var tabla = "";
			                var activo = "";
			                var codbase64 = "";
			                var facturacion = "";
                    		var configura = "";

			                if (e.datos.length !== 0) {
			                    $('#fmt_conteo').html('');
			                    $.each(e.datos, function(index, val) {
			                        nro++;
			                        codbase64 = 'viewupdatsede("' + val['codigo64'] + '")';
			                        facturacion = 'viewfacturacionsede("'+val['codigo64']+'")';
                            		configura = 'viewconfigurasede("'+val['codigo64']+'")';

			                        if (val['activo'] === "SI") {
			                            activo = "<span class='badge bg-success p-2'> ACTIVO </span>";
			                        } else {
			                            activo = "<span class='badge bg-danger p-2'> INACTIVO </span>";
			                        }


			                        tabla = tabla +
			                            "<div class='row rowcolor cfila' data-sede='" + val['nombre'] + "'>" +
			                            "<div class='col-12 col-md-4'>" +
			                            "<div class='row'>" +
			                            "<div class='col-2 col-md-2 text-right td'>" + nro + "</div>" +
			                            "<div class='col-5 col-md-5 td'>" + val['nombre'] + "</div>" +
			                            "<div class='col-5 col-md-5 td text-center '>" + val['nomdist'] + "</div>" +
			                            "</div>" +
			                            "</div>" +
			                            "<div class='col-12 col-md-5'>" +
			                            "<div class='row'>" +
			                            "<div class='col-4 col-md-3 td'>" + activo + "</div>" +
			                            "<div class='col-8 col-md-9 td'>" + val['nombres'] + "</div>" +
			                            "</div>" +
			                            "</div>" +
			                            "<div class='col-12 col-md-3 text-center'>" +
			                            "<div class='row'>" +
			                            "<div class='col-9 col-sm-6 col-md-6 td'>" +
			                            "<span>" + val['local'] + "</span>" +
			                            "</div>" +
			                            "<div class='col-3 col-sm-6 col-md-6 td'>" +
			                            "<div class='col-12 pt-1 pr-3 text-center'>" +
			                            "<div class='btn-group'>" +
			                            "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" +
			                            "<i class='fas fa-cog'></i>" +
			                            "</a>" +
			                            "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>" +
			                            "<a class='dropdown-item' href='#' title='Editar' onclick='" + codbase64 + "'>" +
			                            "<i class='fas fa-edit mr-2'></i> Editar" +
			                            "</a>" +
			                            "<a class='dropdown-item' href='#' title='Facturación' onclick='"+facturacion+"'>"+
                                            "<i class='fas fa-credit-card mr-2'></i> Facturación"+
                                        "</a>"+
                                        "<a class='dropdown-item' href='#' title='Configuración' onclick='"+configura+"'>"+
                                            "<i class='fas fa-cog mr-2'></i> Configuración"+
                                        "</a>"+
			                            "<a class='dropdown-item text-danger deletesede' href='#' title='Eliminar' idsede='" + val['codigo64'] + "'>" +
			                            "<i class='fas fa-trash mr-2'></i> Eliminar" +
			                            "</a>" +
			                            "</div>" +
			                            "</div>" +
			                            "</div>" +
			                            "</div>" +
			                            "</div>" +
			                            "</div>" +
			                            "</div>";

			                    })
			                } else {
			                    $('#fmt_conteo').html('No se encontraron resultados');
			                }

			                $('#divcard_data_sedes').html(tabla);

			            } else {

			                var msgf = '<span class="text-danger">' + e.msg + '</span>';
			                $('#divcard_data_sedes').html(msgf);
			            }

			            $('#divcard_sede #divoverlay').remove();
			        },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception, 'div');
			            $('#divcard_sede #divoverlay').remove();
			            Swal.fire({
			                title: msgf,
			                type: 'error',
			                icon: 'error',
			            })
			        },
			    });
			}

			$('#frm_addsede').submit(function() {
			    $('#frm_addsede input,select').removeClass('is-invalid');
			    $('#frm_addsede .invalid-feedback').remove();
			    $('#divcard_sede').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			    $.ajax({
			        url: $(this).attr("action"),
			        type: 'post',
			        dataType: 'json',
			        data: $(this).serialize(),
			        success: function(e) {
			            $('#divcard_sede #divoverlay').remove();
			            if (e.status == false) {
			                $.each(e.errors, function(key, val) {
			                    $('#frm_addsede #' + key).addClass('is-invalid');
			                    $('#frm_addsede #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
			                });

			            } else {
			                $('#modaddarea').modal('hide');
			                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
			                $('#divmsgarea').html(msgf);
			                Swal.fire({
			                    title: e.msg,
			                    type: 'success',
			                    icon: 'success',
			                }).then((result) => {
			                    if (result.value) {
			                        $('#frm_addsede')[0].reset();
			                        $('.nav-pills a[href="#search-sede"]').tab('show');
			                        filtro_sedes('');
			                    }
			                })
			            }
			        },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception, 'text');
			            $('#divcard_sede #divoverlay').remove();
			            Swal.fire({
			                title: msgf,
			                // text: "",
			                type: 'error',
			                icon: 'error',
			            })
			        }
			    });
			    return false;
			});

			function viewupdatsede(codigo) {
			    $('#divcard_sede').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			    $("#divrstarea").html("");
			    $.ajax({
			        url: base_url + "sede/vwmostrar_sedexcodigo",
			        type: 'post',
			        dataType: "json",
			        data: {
			            txtcodigo: codigo
			        },
			        success: function(e) {
			            $('#divcard_sede #divoverlay').remove();

			            $("#modupsede").modal("show");

			            $("#modupsede #divmodsede").append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

			            $("#modupsede #fictxtcodigo").val(e.sedeup['id']);

			            $("#modupsede #fictxtnombre").val(e.sedeup['nombre']);

			            if (e.sedeup['activo'] == 'SI') {
			                $("#modupsede #checkestado").bootstrapToggle('on');

			            } else {
			                $("#modupsede #checkestado").bootstrapToggle('off');
			            }

			            $('#modupsede #fictxtcodper').val(e.sedeup['percod']);

			            $('#modupsede #ficbdepartamento').val(e.sedeup['codep']);

			            $('#modupsede #vw_ins_cbprovincia').html(e.dprovincias);

			            $('#modupsede #vw_ins_cbprovincia').val(e.sedeup['codprov']);

			            $('#modupsede #vw_ins_cbdistrito').html(e.ddistritos);

                		$('#modupsede #vw_ins_cbdistrito').val(e.sedeup['codist']);

                		$("#modupsede #divmodsede #divoverlay").remove();

			            $("#modupsede #fictxtlocal").val(e.sedeup['local']);
			            $('#modupsede #fictxtdireccion').val(e.sedeup['direccion']);

			        },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception, 'div');
			            $('#divcard_sede #divoverlay').remove();
			            $("#modupsede modal-body").html(msgf);
			        }
			    });
			    return false;
			}

			function fn_combo_ubigeo_modal(combo, contenedor) {
			    if (combo.data('tubigeo') == "departamento") {
			        var nmprov = combo.data('cbprovincia');
			        var nmdist = combo.data('cbdistrito');
			        var nmdiv = combo.data('dvcarga');
			        $('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			        $('#' + nmprov).html("<option value='0'>Sin opciones</option>");
			        $('#' + contenedor + ' #' + nmdist).html("<option value='0'>Sin opciones</option>");
			        var coddepa = combo.val();
			        if (coddepa == '0') return;
			        $.ajax({
			            url: base_url + 'ubigeo/fn_provincia_x_departamento',
			            type: 'post',
			            dataType: 'json',
			            data: {
			                txtcoddepa: coddepa
			            },
			            success: function(e) {
			                $('#' + nmdiv + ' #divoverlay').remove();
			                $('#' + contenedor + ' #' + nmprov).html(e.vdata);
			            },
			            error: function(jqXHR, exception) {
			                $('#' + nmdiv + ' #divoverlay').remove();
			                var msgf = errorAjax(jqXHR, exception, 'text');
			                $('#' + contenedor + ' #' + nmprov).html("<option value='0'>" + msgf + "</option>");
			            }
			        });
			    } else if (combo.data('tubigeo') == "provincia") {
			        var nmdist = combo.data('cbdistrito');
			        var nmdiv = combo.data('dvcarga');
			        $('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			        $('#' + contenedor + ' #' + nmdist).html("<option value='0'>Sin opciones</option>");
			        var codprov = combo.val();
			        if (codprov == '0') return;
			        $.ajax({
			            url: base_url + 'ubigeo/fn_distrito_x_provincia',
			            type: 'post',
			            dataType: 'json',
			            data: {
			                txtcodprov: codprov
			            },
			            success: function(e) {
			                $('#' + nmdiv + ' #divoverlay').remove();
			                $('#' + contenedor + ' #' + nmdist).html(e.vdata);
			            },
			            error: function(jqXHR, exception) {
			                $('#' + nmdiv + ' #divoverlay').remove();
			                var msgf = errorAjax(jqXHR, exception, 'text');
			                $('#' + contenedor + ' #ficbdistrito').html("<option value='0'>" + msgf + "</option>");
			            }
			        });
			    }
			    return false;
			}

			$('#btn_updsede').click(function(event) {
			    $('#frm_updatesede input,select').removeClass('is-invalid');
			    $('#frm_updatesede .invalid-feedback').remove();
			    $('#divmodsede').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			    $.ajax({
			        url: $('#frm_updatesede').attr("action"),
			        type: 'post',
			        dataType: 'json',
			        data: $('#frm_updatesede').serialize(),
			        success: function(e) {
			            $('#divmodsede #divoverlay').remove();
			            if (e.status == false) {
			                $.each(e.errors, function(key, val) {
			                    $('#frm_updatesede #' + key).addClass('is-invalid');
			                    $('#frm_updatesede #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
			                });

			            } else {
			                $('#modupsede').modal('hide');

			                Swal.fire({
			                    title: e.msg,
			                    type: 'success',
			                    icon: 'success',
			                }).then((result) => {
			                    if (result.value) {
			                        filtro_sedes('');
			                    }
			                })
			            }
			        },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception, 'text');
			            $('#divmodsede #divoverlay').remove();
			            Swal.fire({
			                title: msgf,
			                // text: "",
			                type: 'error',
			                icon: 'error',
			            })
			        }
			    });
			    return false;
			});

			$(document).on("click", ".deletesede", function() {
			    var idsede = $(this).attr("idsede");
			    var sede = $(this).closest('.rowcolor').data('sede');
			    Swal.fire({
			        title: '¿Está seguro de eliminar la sede ' + sede + '?',
			        text: "¡Si no lo está puede cancelar la acción!",
			        type: 'warning',
			        icon: 'warning',
			        showCancelButton: true,
			        allowOutsideClick: false,
			        confirmButtonColor: '#3085d6',
			        cancelButtonColor: '#d33',
			        cancelButtonText: 'Cancelar',
			        confirmButtonText: 'Si, eliminar sede!'
			    }).then(function(result) {
			        if (result.value) {
			            $('#divcard_sede').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			            var datos = new FormData();
			            datos.append("idsede", idsede);

			            $.ajax({
			                url: base_url + "sede/fneliminar_sede",
			                method: "POST",
			                data: datos,
			                cache: false,
			                contentType: false,
			                processData: false,
			                success: function(e) {
			                    $('#divcard_sede #divoverlay').remove();
			                    if (e.status == true) {
			                        Swal.fire({
			                            type: "success",
			                            icon: 'success',
			                            title: "¡CORRECTO!",
			                            text: e.msg,
			                            showConfirmButton: true,
			                            allowOutsideClick: false,
			                            confirmButtonText: "Cerrar"
			                        }).then(function(result) {

			                            if (result.value) {

			                                filtro_sedes('');

			                            }
			                        })
			                    }
			                },
			                error: function(jqXHR, exception) {
			                    var msgf = errorAjax(jqXHR, exception, 'text');
			                    $('#divcard_sede #divoverlay').remove();
			                    Swal.fire({
			                        title: "Error",
			                        text: e.msgf,
			                        type: "error",
			                        icon: "error",
			                        allowOutsideClick: false,
			                        confirmButtonText: "¡Cerrar!"
			                    });
			                }
			            })
			        }
			    });

			    return false;
			});

			function viewfacturacionsede(codigo){
		        $('#divcard_sede').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		        $.ajax({
		            url: base_url + "sede/vwmostrar_sedexcodigo",
		            type: 'post',
		            dataType: "json",
		            data: {txtcodigo: codigo},
		            success: function(e) {
		                $('#divcard_sede #divoverlay').remove();

		                $("#modfacturacion").modal("show");

		                $('#modfacturacion #titlefact').html('Facturación Sede '+e.sedeup['nombre'])
		                $("#modfacturacion #divmodfacturacion").append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		                
		                $("#modfacturacion #fictxtcodigosed").val(e.sedeup['id']);

		                $("#modfacturacion #ficbrutanube").val(e.sedeup['ruta']);

		                $("#modfacturacion #ficbtokennube").val(e.sedeup['token']);

		                $("#modfacturacion #divmodfacturacion #divoverlay").remove();

		            },
		            error: function(jqXHR, exception) {
		                var msgf = errorAjax(jqXHR, exception,'div' );
		                $('#divcard_sede #divoverlay').remove();
		                $("#modfacturacion #divmodfacturacion #divoverlay").remove();
		                $("#modfacturacion modal-body").html(msgf);
		            } 
		        });
		        return false;
		    }

		    $('#btn_factsede').click(function(event) {
		        $('#frm_fatursede input,select').removeClass('is-invalid');
		        $('#frm_fatursede .invalid-feedback').remove();
		        $('#divmodfacturacion').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		        $.ajax({
		            url: $('#frm_fatursede').attr("action"),
		            type: 'post',
		            dataType: 'json',
		            data: $('#frm_fatursede').serialize(),
		            success: function(e) {
		                $('#divmodfacturacion #divoverlay').remove();
		                if (e.status == false) {
		                    $.each(e.errors, function(key, val) {
		                        $('#frm_fatursede #' + key).addClass('is-invalid');
		                        $('#frm_fatursede #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
		                    });
		                    
		                } else {
		                    $('#modfacturacion').modal('hide');
		                    
		                    Swal.fire({
		                        title: e.msg,
		                        type: 'success',
		                        icon: 'success',
		                    })
		                }
		            },
		            error: function(jqXHR, exception) {
		                var msgf = errorAjax(jqXHR, exception,'text');
		                $('#divmodfacturacion #divoverlay').remove();
		                Swal.fire({
		                    title: msgf,
		                    // text: "",
		                    type: 'error',
		                    icon: 'error',
		                })
		            }
		        });
		        return false;
		    });

		    $("#modfacturacion").on('hidden.bs.modal', function (e) {
		        $('#frm_fatursede input,select,textarea').removeClass('is-invalid');
		        $('#frm_fatursede .invalid-feedback').remove();
		    })

		    function viewconfigurasede(codigo){
		        $('#divcard_sede').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		        $.ajax({
		            url: base_url + "sede/vwmostrar_sedexcodigo",
		            type: 'post',
		            dataType: "json",
		            data: {txtcodigo: codigo},
		            success: function(e) {
		                $('#divcard_sede #divoverlay').remove();

		                $("#modconfiguracion").modal("show");

		                $('#modconfiguracion #titleconf').html('Configuración Sede '+e.sedeup['nombre'])
		                $("#modconfiguracion #divmodconfiguracion").append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		                
		                $("#modconfiguracion #fictxtcodigosedconf").val(e.sedeup['id']);

		                if (e.sedeup['docest'] == 'SI') {
		                    $("#modconfiguracion #checkdocaddestud").bootstrapToggle('on');
		                    
		                } else {
		                    $("#modconfiguracion #checkdocaddestud").bootstrapToggle('off');
		                }

		                if (e.sedeup['estnot'] == 'SI') {
		                    $("#modconfiguracion #checkestvernota").bootstrapToggle('on');
		                    
		                } else {
		                    $("#modconfiguracion #checkestvernota").bootstrapToggle('off');
		                }

		                if (e.sedeup['docrec'] == 'SI') {
		                    $("#modconfiguracion #checkdocentrecup").bootstrapToggle('on');
		                    
		                } else {
		                    $("#modconfiguracion #checkdocentrecup").bootstrapToggle('off');
		                }

		                if (e.sedeup['aludesnot'] == 'SI') {
		                    $("#modconfiguracion #checkestdescbol").bootstrapToggle('on');
		                    
		                } else {
		                    $("#modconfiguracion #checkestdescbol").bootstrapToggle('off');
		                }

		                if (e.sedeup['bloqueo'] == 'SI') {
		                    $("#modconfiguracion #checkbloqautopag").bootstrapToggle('on');
		                    
		                } else {
		                    $("#modconfiguracion #checkbloqautopag").bootstrapToggle('off');
		                }

		                if (e.sedeup['pernsp'] == 'SI') {
		                    $("#modconfiguracion #checkNsp").bootstrapToggle('on');
		                    
		                } else {
		                    $("#modconfiguracion #checkNsp").bootstrapToggle('off');
		                }

		                if (e.sedeup['conf_migrar_notas'] == 'SI') {
		                    $("#modconfiguracion #checkmigranotas").bootstrapToggle('on');
		                    
		                } else {
		                    $("#modconfiguracion #checkmigranotas").bootstrapToggle('off');
		                }

		                if (e.sedeup['conf_bloq_dpi'] == 'SI') {
		                    $("#modconfiguracion #checkbloquedpi").bootstrapToggle('on');
		                    
		                } else {
		                    $("#modconfiguracion #checkbloquedpi").bootstrapToggle('off');
		                }

		                $("#modconfiguracion #divmodconfiguracion #divoverlay").remove();

		            },
		            error: function(jqXHR, exception) {
		                var msgf = errorAjax(jqXHR, exception,'div' );
		                $('#divcard_sede #divoverlay').remove();
		                $("#modconfiguracion #divmodconfiguracion #divoverlay").remove();
		                $("#modconfiguracion modal-body").html(msgf);
		            } 
		        });
		        return false;
		    }

		    $('#btn_configsede').click(function(e) {
		    	$('#frm_configsede input,select').removeClass('is-invalid');
		        $('#frm_configsede .invalid-feedback').remove();
		        $('#divmodconfiguracion').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		        $.ajax({
		            url: $('#frm_configsede').attr("action"),
		            type: 'post',
		            dataType: 'json',
		            data: $('#frm_configsede').serialize(),
		            success: function(e) {
		                $('#divmodconfiguracion #divoverlay').remove();
		                if (e.status == false) {
		                    $.each(e.errors, function(key, val) {
		                        $('#frm_configsede #' + key).addClass('is-invalid');
		                        $('#frm_configsede #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
		                    });
		                    
		                } else {
		                    $('#modconfiguracion').modal('hide');
		                    
		                    Swal.fire({
		                        title: e.msg,
		                        type: 'success',
		                        icon: 'success',
		                    })
		                }
		            },
		            error: function(jqXHR, exception) {
		                var msgf = errorAjax(jqXHR, exception,'text');
		                $('#divmodconfiguracion #divoverlay').remove();
		                Swal.fire({
		                    title: msgf,
		                    // text: "",
		                    type: 'error',
		                    icon: 'error',
		                })
		            }
		        });
		        return false;
		    });
		</script>