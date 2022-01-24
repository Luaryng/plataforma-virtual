<form id="frm_unidad_ed" action="" method="post" accept-charset="utf-8">
	<?php foreach ($dtsunidad as $undc) { ?>	
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<input type="hidden" name="fictxtaccion" id="fictxtaccion" value="EDITAR">
			<input type="hidden" name="fictxtcodigo" id="fictxtcodigo" value="<?php echo base64url_encode($undc->id) ?>">
			<input data-currentvalue='' value="<?php echo $undc->uninom ?>" class="form-control text-uppercase" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre unidad" />
			<label for="fictxtnombre">Nombre unidad</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-6">
			<select name="cbotipound" id="cbotipound" data-currentvalue='' class="form-control text-uppercase">
				<option value="">Seleccione tipo unidad</option>
				<option <?php echo ($undc->unitip == 'C') ? "selected" : ""; ?> value="C">COMP. ESPECÍFICA</option>
				
				<option <?php echo ($undc->unitip == 'E') ? "selected" : ""; ?> value="E">COMP. EMPLEABILIDAD</option>
			</select>
			<label for="cbotipound">Tipo</label>
		</div>
	</div>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<select name="cbociclo" id="cbociclo" data-currentvalue='' class="form-control text-uppercase">
				<option value="">Seleccione ciclo</option>
				<?php foreach ($ciclo as $dts) {
					$ciclo = ($dts->id == $undc->idcic) ? "selected" : "";
					echo "<option $ciclo value='$dts->id'>$dts->nomcic</option>";
				} ?>
			</select>
			<label for="cbociclo">ciclo</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-6">
			<select name="cbomodulo" id="cbomodulo" data-currentvalue='' class="form-control text-uppercase">
				<option value="">Seleccione módulo</option>
				<?php foreach ($modulos as $mdl) {
					$modul = ($mdl->id == $undc->idmod) ? "selected" : "";
					echo "<option $modul value='$mdl->id'>$mdl->modnom</option>";
				} ?>
			</select>
			<label for="cbomodulo">Módulo</label>
		</div>
	</div>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-4">
			<input data-currentvalue='' value="<?php echo $undc->horter ?>" class="form-control text-uppercase" id="fictxthorter" name="fictxthorter" type="number" placeholder="Horas teoria" />
			<label for="fictxthorter">Horas teoria</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-4">
			<input data-currentvalue='' value="<?php echo $undc->horprac ?>" class="form-control text-uppercase" id="fictxthorprac" name="fictxthorprac" type="number" placeholder="Horas práctica" />
			<label for="fictxthorprac">Horas práctica</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-4">
			<input data-currentvalue='' value="<?php echo $undc->horcic ?>" class="form-control text-uppercase" id="fictxthorcic" name="fictxthorcic" type="number" placeholder="Horas ciclo" />
			<label for="fictxthorcic">Horas ciclo</label>
		</div>
	</div>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-4">
			<input data-currentvalue='' value="<?php echo $undc->credter ?>" class="form-control text-uppercase" id="fictxtcredter" name="fictxtcredter" type="number" placeholder="Créditos teoria" />
			<label for="fictxtcredter">Créditos teoria</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-4">
			<input data-currentvalue='' value="<?php echo $undc->credprac ?>" class="form-control text-uppercase" id="fictxtcredprac" name="fictxtcredprac" type="number" placeholder="Créditos práctica" />
			<label for="fictxtcredprac">Créditos práctica</label>
		</div>
	</div>
	<div class="row mt-1">
    	<div class="col-12">
    		<div id="divmsgunidaded" class="float-left">
				
			</div>
		</div>
	</div>
	<?php } ?>
</form>