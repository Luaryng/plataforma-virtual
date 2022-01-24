<?php 
	$vbaseurl=base_url();
?>
<form id="frm_libro" action="<?php //echo $vbaseurl ?>biblioteca/fn_insert_libro" method="post" accept-charset='utf-8'>
	<b class="margin-top-10px text-danger"><i class="fas fa-book"></i> Libro</b>
	<?php foreach ($dlibros as $lbr) { ?>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
			<input type="hidden" name="fictxtaccion" id="fictxtaccion" value="EDITAR">
			<input type="hidden" name="fictxtidlib" id="fictxtidlib" value="<?php echo base64url_encode($lbr->codigo) ?>">
			<input data-currentvalue='' value="<?php echo $lbr->nombre ?>" class="form-control text-uppercase" id="fictxtnomlib" name="fictxtnomlib" type="text" placeholder="Nombre Libro" />
			<label for="fictxtnomlib">Nombre Libro</label>
		</div>
		<div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
        	<select data-currentvalue='' class="form-control" id="ficautor" name="ficautor" placeholder="autor" required >
          		<option value="0">Selecciona autor</option>
          		<?php foreach ($autores as $atrs) { 
          			$ausel=($lbr->idaut==$atrs->id) ? "selected": "";
          			echo "<option $ausel value='$atrs->id'>$atrs->nombre</option>";
          		} ?>
        	</select>
        	<label for="ficautor"> autor</label>
      	</div>
	</div>
	<div class="row mt-1">
		<div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
        	<select data-currentvalue='' class="form-control" id="ficeditorial" name="ficeditorial" placeholder="editorial" required >
          		<option value="0">Selecciona editorial</option>
          		<?php foreach ($editor as $edtr) { 
          			$edsel=($lbr->idedi==$edtr->id) ? "selected": "";
          			echo "<option $edsel value='$edtr->id'>$edtr->nombre</option>";
          		} ?>
        	</select>
        	<label for="ficeditorial"> editorial</label>
      	</div>
		<div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
			<input data-currentvalue='' value="<?php echo $lbr->anio ?>" class="form-control text-uppercase" id="fictxtlibanio" name="fictxtlibanio" type="text" placeholder="Año Libro" />
			<label for="fictxtlibanio">Año Libro</label>
		</div>
	</div>
	<div class="row mt-1">
    	<div class="col-12">
    		<div id="divmsglibup" class="float-left">

			</div>
    	</div>
	</div>
<?php } ?>
</form>