<form id="frm_modulo_ed" action="" method="post" accept-charset="utf-8">
	<?php foreach ($dtsmodulo as $mod) { ?>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<input type="hidden" name="fictxtaccion" id="fictxtaccion" value="EDITAR">
			<input type="hidden" name="fictxtcodigo" id="fictxtcodigo" value="<?php echo base64url_encode($mod->id) ?>">
			<input data-currentvalue='' value="<?php echo $mod->modnom ?>" class="form-control text-uppercase" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre módulo" />
			<label for="fictxtnombre">Nombre módulo</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $mod->modnum ?>" class="form-control text-uppercase" id="fictxtmodnum" name="fictxtmodnum" type="number" placeholder="Número módulo" />
			<label for="fictxtmodnum">Número módulo</label>
		</div>
	</div>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<select name="cboplanestud" id="cboplanestud" data-currentvalue='' class="form-control text-uppercase">
				<option value="">Seleccione plan estudios</option>
				<?php foreach ($planes as $dts) {
					$mdls = ($dts->id == $mod->idplan) ? "selected" : "";
					echo "<option $mdls value='$dts->id'>$dts->nombre</option>";
				} ?>
			</select>
			<label for="cboplanestud">Plan estudios</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-3">
			<input data-currentvalue='' value="<?php echo $mod->modhoras ?>" class="form-control text-uppercase" id="fictxthoras" name="fictxthoras" type="number" placeholder="Horas" />
			<label for="fictxthoras">Horas</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-3">
			<input data-currentvalue='' value="<?php echo $mod->modcred ?>" class="form-control text-uppercase" id="fictxtcreditos" name="fictxtcreditos" type="number" placeholder="Créditos" />
			<label for="fictxtcreditos">Créditos</label>
		</div>
	</div>
	<div class="row mt-1">
    	<div class="col-12">
    		<div id="divmsgmoduloed" class="float-left">
				
			</div>
		</div>
	</div>
	<?php } ?>
</form>