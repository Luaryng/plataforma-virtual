<form id="frm_update" action="" method="post" accept-charset="utf-8">
	<?php foreach ($dtsies as $dts) { ?>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<input type="hidden" name="fictxtcodigo" id="fictxtcodigo" value="<?php echo base64url_encode($dts->id) ?>">
			<input data-currentvalue='' value="<?php echo $dts->nombre ?>" class="form-control text-uppercase" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre Institución" />
			<label for="fictxtnombre">Nombre Institución</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $dts->codmodular ?>" class="form-control text-uppercase" id="fictxtmodul" name="fictxtmodul" type="text" placeholder="Código modular" />
			<label for="fictxtmodul">Código modular</label>
		</div>
	</div>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $dts->gestion ?>" class="form-control text-uppercase" id="fictxtgestion" name="fictxtgestion" type="text" placeholder="Gestión" />
			<label for="fictxtgestion">Gestión</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $dts->dre ?>" class="form-control text-uppercase" id="fictxtdre" name="fictxtdre" type="text" placeholder="Drep" />
			<label for="fictxtdre">Drep</label>
		</div>
	</div>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $dts->resolucion ?>" class="form-control text-uppercase" id="fictxtresolu" name="fictxtresolu" type="text" placeholder="Resolución" />
			<label for="fictxtresolu">Resolución</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $dts->revalidacion ?>" class="form-control text-uppercase" id="fictxtrevali" name="fictxtrevali" type="text" placeholder="Revalidación" />
			<label for="fictxtrevali">Revalidación</label>
		</div>
	</div>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<select name="cbodistrito" id="cbodistrito" data-currentvalue='' class="form-control text-uppercase">
				<?php foreach ($distrit as $dist) {
					$dtst = ($dist->codigo == $dts->codist) ? 'selected' : '';
					echo "<option $dtst value='$dist->codigo'>$dist->nombre</option>";
				} ?>
				
			</select>
			<label for="cbodistrito">Distrito</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $dts->centropoblado ?>" class="form-control text-uppercase" id="fictxtcpob" name="fictxtcpob" type="text" placeholder="Centro Poblado" />
			<label for="fictxtcpob">Centro Poblado</label>
		</div>
	</div>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $dts->email ?>" class="form-control text-uppercase" id="fictxtemail" name="fictxtemail" type="text" placeholder="Email" />
			<label for="fictxtemail">Email</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $dts->web ?>" class="form-control text-uppercase" id="fictxtweb" name="fictxtweb" type="text" placeholder="Web" />
			<label for="fictxtweb">Web</label>
		</div>
	</div>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $dts->telefono ?>" class="form-control text-uppercase" id="fictxttelefono" name="fictxttelefono" type="text" placeholder="Teléfono" />
			<label for="fictxttelefono">Teléfono</label>
		</div>
		<div class="form-group has-float-label col-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $dts->direccion ?>" class="form-control text-uppercase" id="fictxtdirec" name="fictxtdirec" type="text" placeholder="Dirección" />
			<label for="fictxtdirec">Dirección</label>
		</div>
	</div>
	<div class="row mt-1">
    	<div class="col-12">
    		<div id="divmsgies" class="float-left">
				
			</div>
		</div>
	</div>
<?php } ?>
</form>