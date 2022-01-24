<div class="card-body">
	<div class="row">
		<div id="vw_cmd_cronograma" class="col-md-3 border rounded" style="min-height: 200px">
			<span class="text-bold">Fechas de Pago</span>
			<?php foreach ($fechas as $key => $vfc){ 
				//echo "<button onclick='fn_vw_add_fecha($(this));' class='btn btn-sm btn-success mt-2 vw_cmd_add_fecha'>$vfc->fecha</button>";
				echo 
				"<div class='form-check'>
				  <input onchange='fn_vw_view_fecha($(this));' class='form-check-input' data-descripcion='$vfc->descripcion' data-fecha='$vfc->fecha' type='radio' name='rbfechas' id='rbfecha{$vfc->codigo}' value='$vfc->codigo64' >
				  <label class='form-check-label' for='rbfecha{$vfc->codigo}'>
				    <small>$vfc->descripcion ({$vfc->fecha})</small>
				  </label>
				</div>";
				//echo "<button onclick='fn_vw_add_fecha($(this));' class='btn btn-sm btn-success mt-2 vw_cmd_add_fecha'>$vfc->fecha</button>";
			} ?>

			<button onclick='fn_vw_add_fecha($(this));' class="btn bt-sm btn-primary my-2">Agregar Fecha</button>

		</div>
		<div  class="col-md-9">
			<div class="row">
				<div class="col-12" id="vw_cmd_crono_add">
					<form id="vw_cmda_frmcalendario" accept-charset="utf-8">
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
					<hr>

					<div class="col-12 p-0">
						<span class="text-bold">Items de Facturación</span><br>
						<button onclick='fn_vw_add_itemfac($(this));' class='btn btn-sm btn-success mt-2 vw_cmd_add_fecha'>Agregar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#vw_cmd_crono_add").hide();
    	$("#vw_cmd_crono_view").hide();
	});
</script>
