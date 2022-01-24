<form id="frm_devolucion" action="#" method="post" accept-charset='utf-8'>
	<b class="margin-top-10px text-danger"><i class="fas fa-user"></i> Datos</b>
	<?php foreach ($dprest as $prst) { ?>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<input type="hidden" name="fictxtcodejm" id="fictxtcodejm" value="<?php echo base64url_encode($prst->idejm) ?>">
			<input type="hidden" name="fictxtcodpres" id="fictxtcodpres" value="<?php echo base64url_encode($prst->idpre) ?>">
			<?php date_default_timezone_set ('America/Lima'); $fecha = date('Y-m-d'); $hora = date('H:i'); ?>
			<input data-currentvalue='' value="<?php echo $fecha ?>" class="form-control text-uppercase" id="ficfecfin" name="ficfecfin" type="date" placeholder="Fecha Entrega" />
			<label for="ficfecfin">Fecha Entrega</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $hora ?>" class="form-control text-uppercase" id="fichorfin" name="fichorfin" type="time" placeholder="Hora Entrega" />
			<label for="fichorfin">Hora Entrega</label>
		</div>
	</div>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<select data-currentvalue='' class="form-control" id="ficestado" name="ficestado" placeholder="Estado" required >
	      		<option value="0">Selecciona Estado</option>
	      		<option <?php echo ($prst->estado == 'BUENO') ? "selected" : ""; ?> value="BUENO">BUENO</option>
	      		<option <?php echo ($prst->estado == 'MALO') ? "selected" : ""; ?> value="MALO">MALO</option>
	      		<option <?php echo ($prst->estado == 'REGULAR') ? "selected" : ""; ?> value="REGULAR">REGULAR</option>
	    	</select>
	    	<label for="ficestado"> Estado</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-6">
        	<select data-currentvalue='' class="form-control" id="ficsituacion" name="ficsituacion" placeholder="Situación" required >
          		<option value="0">Selecciona Situación</option>
          		<option value="PERDIDO">PERDIDO</option>
          		<!-- <option value="PRESTADO">PRESTADO</option> -->
          		<option value="DISPONIBLE">DISPONIBLE</option>
          		<!-- <option value="MANTENIMIENTO">MANTENIMIENTO</option> -->
        	</select>
        	<label for="ficsituacion"> Situación</label>
      	</div>
	</div>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-xs-12 col-sm-12">
            <textarea class="form-control" id="fitxtobserfinal" name="fitxtobserfinal" placeholder="Observaciones" rows="3"></textarea>
            <label for="fitxtobserfinal"> Observaciones</label>
        </div>
	</div>
	<div class="row mt-2">
		<div id="divmsgdevolver">
			
		</div>
	</div>
	<?php } ?>
</form>