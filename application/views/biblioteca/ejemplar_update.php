<?php foreach ($dejempl as $ejmd) { 
  $precio = number_format($ejmd->prec, 2, '.', '');
  ?>
	
<form id="frm_ejemplupd" action="#" method="post" accept-charset='utf-8'>
	<b class="margin-top-10px text-danger"><i class="fas fa-book"></i> Editar Ejemplares</b>
	<input type="hidden" name="fictxtcodejm" id="fictxtcodejm" value="<?php echo base64url_encode($ejmd->codigo) ?>">

	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
        	<select data-currentvalue='' data-cnt="" class="form-control" id="fictipo" name="fictipo" placeholder="Tipo" required >
          		<option value="0">Selecciona Tipo</option>
          		<option <?php echo ($ejmd->link != "") ? "selected" : ""; ?> value="Virtual">Virtual</option>
          		<option <?php echo ($ejmd->link == NULL) ? "selected" : ""; ?> value="Fisico">Físico</option>
        	</select>
        	<label for="fictipo"> Tipo</label>
      	</div>
      	
      	<div class="form-group has-float-label col-12 col-xs-12 col-sm-6 d-none" id="divcar_virtual">
			<input data-currentvalue='' value="<?php echo $ejmd->link ?>" class="form-control text-uppercase" id="fictxtlink" name="fictxtlink" type="text" placeholder="Link" />
			<label for="fictxtlink">Link</label>
		</div>
	</div>
	<div class="row mt-1 d-none" id="divcar_fisico">
		<div class="form-group has-float-label col-12 col-xs-12 col-sm-3">
			<input data-currentvalue='' value="<?php echo $ejmd->pag ?>" class="form-control text-uppercase" id="fictxtnpag" name="fictxtnpag" type="text" placeholder="N° Páginas" />
			<label for="fictxtnpag">N° Páginas</label>
		</div>
		<div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
        	<select data-currentvalue='' class="form-control" id="ficestado" name="ficestado" placeholder="Estado" required >
          		<option value="0">Selecciona Estado</option>
          		<option <?php echo ($ejmd->est == 'BUENO') ? "selected" : ""; ?> value="BUENO">BUENO</option>
          		<option <?php echo ($ejmd->est == 'MALO') ? "selected" : ""; ?> value="MALO">MALO</option>
          		<option <?php echo ($ejmd->est == 'REGULAR') ? "selected" : ""; ?> value="REGULAR">REGULAR</option>
        	</select>
        	<label for="ficestado"> Estado</label>
      	</div>
      	<div class="form-group has-float-label col-12 col-xs-12 col-sm-5">
			<input data-currentvalue='' value="<?php echo $ejmd->ubic ?>" class="form-control text-uppercase" id="fictxtubica" name="fictxtubica" type="text" placeholder="Ubicación" />
			<label for="fictxtubica">Ubicación</label>
		</div>
	</div>
	<div class="row mt-1 d-none" id="divcar_fisico2">
		<div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
        	<select data-currentvalue='' class="form-control" id="ficsituacion" name="ficsituacion" placeholder="Situación" required >
          		<option value="0">Selecciona Situación</option>
          		<option <?php echo ($ejmd->situa == 'PERDIDO') ? "selected" : ""; ?> value="PERDIDO">PERDIDO</option>
          		<option <?php echo ($ejmd->situa == 'PRESTADO') ? "selected" : ""; ?> value="PRESTADO">PRESTADO</option>
          		<option <?php echo ($ejmd->situa == 'DISPONIBLE') ? "selected" : ""; ?> value="DISPONIBLE">DISPONIBLE</option>
          		<option <?php echo ($ejmd->situa == 'MANTENIMIENTO') ? "selected" : ""; ?> value="MANTENIMIENTO">MANTENIMIENTO</option>
        	</select>
        	<label for="ficsituacion"> Situación</label>
      	</div>
      	<!-- <div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
        	<select data-currentvalue='' class="form-control" id="ficfisico" name="ficfisico" placeholder="Físico" required >
          		<option value="0">Selecciona Físico</option>
          		<option <?php //echo ($ejmd->fisc == "SI") ? "selected" : ""; ?> value="SI">SI</option>
          		<option <?php //echo ($ejmd->fisc == "NO") ? "selected" : ""; ?> value="NO">NO</option>
        	</select>
        	<label for="ficfisico"> Fisico</label>
      	</div> -->
        <div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
          <select data-currentvalue='' class="form-control" id="ficproced" name="ficproced" placeholder="Procedencia" required >
              <option value="0">Selecciona Procedencia</option>
              <option <?php echo ($ejmd->proc == "RECURSOS PROPIOS") ? "selected" : ""; ?> value="RECURSOS PROPIOS">RECURSOS PROPIOS</option>
              <option <?php echo ($ejmd->proc == "CANON") ? "selected" : ""; ?> value="CANON">CANON</option>
              <option <?php echo ($ejmd->proc == "DONACIÓN") ? "selected" : ""; ?> value="DONACIÓN">DONACIÓN</option>
          </select>
          <label for="ficproced"> Procedencia</label>
        </div>
        <div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
          <input data-currentvalue='' value="<?php echo $ejmd->fecom ?>" class="form-control text-uppercase" id="fictxtfecha" name="fictxtfecha" type="date" placeholder="Fecha Compra" />
          <label for="fictxtfecha">Fecha Compra</label>
        </div>
	</div>
  <div class="row mt-1 d-none" id="divcar_fisico3">
    <div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
            <input data-currentvalue='' value="<?php echo $ejmd->ndoc ?>" class="form-control text-uppercase" id="fictxtndoc" name="fictxtndoc" type="text" placeholder="Nro Documento" />
      <label for="fictxtndoc">Nro Documento</label>
          </div>
          <div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
            <input data-currentvalue='' value="<?php echo $precio ?>" class="form-control text-uppercase" id="fictxtprecio" name="fictxtprecio" type="number" step="0.01" value="0.00" placeholder="Precio Unit" />
      <label for="fictxtprecio">Precio Unit</label>
          </div>
          <div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
            <input data-currentvalue='' value="<?php echo $ejmd->comp ?>" class="form-control text-uppercase" id="fictxtordcom" name="fictxtordcom" type="text" placeholder="Orden Compra" />
      <label for="fictxtordcom">Orden Compra</label>
          </div>
  </div>
	<div class="row mt-1">
    	<div class="col-12">
    		<div id="divmsgejmp" class="float-left">
				
			</div>
    	</div>
	</div>
</form>
<?php } ?>


<script type="text/javascript">
	$('#frm_ejemplupd input,select').change(function(event) {
  	if ($(this).attr('id') == 'fictipo') {
    	$('#divmodalupd').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');        
    	var tip = $(this).val();
    	if (tip == 'Virtual') {
        	$('#divmodalupd #divoverlay').remove();
        	$('#divcar_virtual').removeClass('d-none');
        	$('#divcar_fisico').addClass('d-none');
        	$('#divcar_fisico2').addClass('d-none');
          $('#divcar_fisico3').addClass('d-none');
    	} else if (tip == 'Fisico') {
        	$('#divmodalupd #divoverlay').remove();
        	$('#divcar_virtual').addClass('d-none');
        	$('#divcar_fisico').removeClass('d-none');
        	$('#divcar_fisico2').removeClass('d-none');
          $('#divcar_fisico3').removeClass('d-none');
    	}
  	}
  });
</script>