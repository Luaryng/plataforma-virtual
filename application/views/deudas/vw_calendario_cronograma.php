<div class="card-body">
	<div class="row">
		<div id="vw_cmd_cronograma" class="col-md-3 border rounded" style="min-height: 200px">
			<span class="text-bold">Fechas de Pago</span>
			<div id="vw_cmd_cronograma_rdfechas">
			<?php foreach ($fechas as $key => $vfc){ 
				//echo "<button onclick='fn_vw_add_fecha($(this));' class='btn btn-sm btn-success mt-2 vw_cmd_add_fecha'>$vfc->fecha</button>";
				echo 
				"<div class='form-check'>
				  <input onchange='fn_vw_view_fecha($(this));' class='form-check-input vw_rbfecha_cobro' data-descripcion='$vfc->descripcion' data-fecha='$vfc->fecha' type='radio' name='rbfechas' id='rbfecha{$vfc->codigo}' value='$vfc->codigo64' >
				  <label class='form-check-label' for='rbfecha{$vfc->codigo}'>
				    <small>$vfc->descripcion ({$vfc->fecha})</small>
				  </label>
				</div>";
				//echo "<button onclick='fn_vw_add_fecha($(this));' class='btn btn-sm btn-success mt-2 vw_cmd_add_fecha'>$vfc->fecha</button>";
			} ?>
			</div>
			<button onclick='fn_vw_add_fecha($(this));' class="btn bt-sm btn-primary my-2">Agregar Fecha</button>
			<button onclick='fn_vw_upd_fecha($(this));' data-idfecha='' data-descripcion='' data-fecha='' class="btn bt-sm btn-info my-2" id="vwbtn_update_fecha">Editar Fecha</button>
			
		</div>
		<div  class="col-md-9">
			<nav>
			  	<div class="nav nav-tabs" id="nav-tab" role="tablist">
			    	<a class="nav-item nav-link active" id="nav-fechas-tab" data-toggle="tab" href="#nav-fechas" role="tab" aria-controls="nav-fechas" aria-selected="true">Conceptos</a>
			    	<a class="nav-item nav-link" id="nav-grupos-tab" data-toggle="tab" href="#nav-grupos" role="tab" aria-controls="nav-grupos" aria-selected="false">Grupos</a>
			  	</div>
			  	<div class="tab-content" id="nav-tabContent">
				  	<div class="tab-pane fade show active" id="nav-fechas" role="tabpanel" aria-labelledby="nav-fechas-tab">
					  	
						<div class="col-12" id="vw_cmd_crono_add">
							<form id="vw_cmda_frmcalendario" accept-charset="utf-8">
								<div class="col-12 ">
										<h5 class="text-bold">Nueva fecha de Pago</h5>
										<br>
								</div>
								<div class="row">
									
									<input type="hidden" id="vw_cmda_txtcalendario" name="vw_cmda_txtcalendario" value="<?php echo $idcalendario ?>">
									<input type="hidden" id="vw_cmda_txtcodigo" name="vw_cmda_txtcodigo" value="<?php echo $idfecha ?>">
									
		                                    
		                            <div class="form-group has-float-label col-6  col-md-12">
		                                <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_cmda_txtnombre" name="vw_cmda_txtnombre" type="text" placeholder="Descripción"  minlength="8" />
		                                <label for="vw_cmda_txtnombre">Descripción</label>
		                            </div>
		                            <div class="form-group has-float-label col-6  col-md-6">
		                                <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_cmda_txtinicia" name="vw_cmda_txtinicia" type="date" placeholder="Fecha"  minlength="8" />
		                                <label for="vw_cmda_txtinicia">Fecha</label>
		                            </div>
		                                    
								</div>
							</form>
							<button type="button" id="vw_cmda_btnguardar" onclick='fn_vw_save_fecha($(this));' class="btn btn-primary float-right">Guardar</button>
						</div>
						<div class="col-12" id="vw_cmd_crono_view">
							<span class="badge badge-dark" id="vw_cmdv_spnfecha">--</span>
							<span class="badge badge-secondary" id="vw_cmdv_spndescripcion"></span>
							<!--<button data-calendario='0' onclick='fn_vw_deuda_asignar_grupo($(this));' class='btn btn-sm btn-success mt-2 float-right' id="vw_cmd_crono_btnasignar">Asignar</button>-->
							<button onclick='fn_vw_add_itemfac($(this));' class='btn btn-sm btn-success mt-2 float-right vw_cmd_add_fecha'><i class="fas fa-plus mr-1"></i> Concepto</button>
							<hr class="my-1">
							
							<div class="col-12 p-0">
								
								<div class="col-12" id="vw_cmdv_item">
									<span class="text-bold">Conceptos de Cobro</span><br>
									
									
									<div class="col-12 btable" >
					                    <div class="col-md-12 thead d-none d-md-block">
					                        <div class="row">
					                            <div class="col-2 col-md-1 td">N°</div>
					                            <div class="col-2 col-md-7 td">CONCEPTO</div>
					                            <div class="col-2 col-md-2 td">MONTO</div>
					                            <div class="col-2 col-md-1 td">REP.</div>
					                            <div class="col-1 col-md-1 td text-center"></div>
					                        </div>
					                    </div>
					                    <div class="col-md-12 tbody" id="vw_cmdv_items">
					                        
					                    </div>
					                </div>
					                
								</div>


								<div class="col-12 border rounded" id="vw_cmdv_item_agregar">

									<span class="text-bold">Agregar Conceptos de Cobro</span><br><br>
									
									<input type="hidden" name="vw_cmdi_txtcodigo" id="vw_cmdi_txtcodigo" value="0">
									<input type="hidden" name="vw_cmdi_txtcalfecha" id="vw_cmdi_txtcalfecha" value="0">
									<select class="vw_select2 form-control" name="vw_cmdi_cbgestion" id="vw_cmdi_cbgestion">
										<?php 

											$cat_group=="";
											foreach ($gestion as $key => $gt) {
												if ($cat_group!=$gt->codcategoria){
													if ($cat_group!="") echo "</optgroup>";
													$cat_group=$gt->codcategoria;
													echo "<optgroup label='$gt->categoria'>";
												}
												echo "<option value='$gt->codigo'>$gt->nombre</option>";		
											}
										?>
									</select>
									<div class="row py-1">
										<div class="col-2 pt-1">
											Monto :
										</div>
										<div class="col-2">
												<input type="text" class="form-control form-control-sm" id="vw_cmdi_txtmonto">
										</div>
										<div class="col-6 pt-1 text-right">
											Cobro único durante el Semestre
										</div>
										<div class="col-2 ">
												<input checked class="vw_toogle" id="vw_cmdi_chkrepite" type="checkbox" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger" data-size="xs">
										</div>
										<div class="col-12">
											<hr class="mb-1">
											<button type="button" id="vw_cmdi_btnguardar" onclick='fn_vw_save_itemfac($(this));' class="btn btn-primary float-right btn-sm">Guardar</button>
										</div>
									</div>
								</div>
								

								
							</div>
						</div>
							<!--<div class="col-12" id="vw_cmd_crono_item_add">
								<span class="badge badge-dark" id="vw_cmdv_spnfecha">--</span>
								<span class="badge badge-secondary" id="vw_cmdv_spndescripcion"></span>
								<hr>

								<div class="col-12 p-0">
									<span class="text-bold">Items de Facturación</span><br>
									<button onclick='fn_vw_add_itemfac($(this));' class='btn btn-sm btn-success mt-2 vw_cmd_add_fecha'>Agregar</button>
								</div>
							</div>-->
						
				  	</div>
				  	<div class="tab-pane fade" id="nav-grupos" role="tabpanel" aria-labelledby="nav-grupos-tab">
				  		<div class="col-12">
				  			
				  			<button data-calendario='0' onclick="fn_vw_agregar_grupo($(this));return false;" class='btn btn-sm btn-success float-right' id="vw_cmd_crono_btnasignargp"><i class="fas fa-plus mr-1"></i> Grupo</button>
				  			<h5>Grupos Asignados</h5>
				  			<hr class="my-1">
				  		</div>
				  		<div class="col-12 btable">
	                        <div class="col-md-12 thead d-none d-md-block">
	                            <div class="row">
	                                <div class="col-sm-1 col-md-1 td hidden-xs">N°</div>
	                                <div class="col-sm-2 col-md-2 td">PERIODO</div>
	                                <div class="col-sm-2 col-md-4 td">CARRERA</div>
	                                <div class="col-sm-2 col-md-2 td">CIC./SECCIÓN</div>
	                                <div class="col-sm-2 col-md-2 td">TURNO</div>
	                                <div class="col-sm-1 col-md-1 td text-center"></div>
	                            </div>
	                        </div>
	                        <div class="col-md-12 tbody" id="div_fechas_GruposDeudas">
	                            
	                        </div>
	                    </div>
				  	</div>
				  
				</div>
			</nav>

			
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.vw_select2').select2({
			dropdownParent: $('#modCronogramas')
		});
		$('.vw_toogle').bootstrapToggle();
		$("#vw_cmd_crono_add").hide();
    	$("#vw_cmd_crono_view").hide();
    	$("#vw_cmdv_item_agregar").hide();
    	
	});
	
</script>
