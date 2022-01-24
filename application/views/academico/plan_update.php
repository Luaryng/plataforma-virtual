<form id="frm_plan_update" action="" method="post" accept-charset="utf-8">
	<?php foreach ($dtsplan as $dtsp) { ?>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<input type="hidden" name="fictxtaccion" id="fictxtaccion" value="EDITAR">
			<input type="hidden" name="fictxtid" id="fictxtid" value="<?php echo base64url_encode($dtsp->id) ?>">
			<input data-currentvalue='' value="<?php echo $dtsp->nombre ?>" class="form-control text-uppercase" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre" />
			<label for="fictxtnombre">Nombre</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-6">
			<select name="cboperiodo" id="cboperiodo" data-currentvalue='' class="form-control text-uppercase">
				<option value="">Seleccione periodo</option>
				<?php foreach ($periodo as $prd) {
					$perd = ($prd->codigo == $dtsp->codper) ? "selected" : "";
					echo "<option $perd value='$prd->codigo'>$prd->nombre</option>";
				} ?>
			</select>
			<label for="cboperiodo">Periodo</label>
		</div>
	</div>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<select name="cbocarrera" id="cbocarrera" data-currentvalue='' class="form-control text-uppercase">
				<option value="">Seleccione carrera</option>
				<?php foreach ($carrera as $cra) {
					$car = ($cra->id == $dtsp->codcar) ? "selected" : "";
					echo "<option $car value='$cra->id'>$cra->nombre</option>";
				} ?>
			</select>
			<label for="cbocarrera">Carrera</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $dtsp->decreto ?>" class="form-control text-uppercase" id="fictxtdecreto" name="fictxtdecreto" type="text" placeholder="Decreto supremo" />
			<label for="fictxtdecreto">Decreto supremo</label>
		</div>
	</div>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $dtsp->resolu ?>" class="form-control text-uppercase" id="fictxtresolu" name="fictxtresolu" type="text" placeholder="Resolución" />
			<label for="fictxtresolu">Resolución</label>
		</div>
	</div>
	<div class="row mt-1">
    	<div class="col-12">
    		<div id="divmsgplanupd" class="float-left">
				
			</div>
		</div>
	</div>
	<?php } ?>
</form>