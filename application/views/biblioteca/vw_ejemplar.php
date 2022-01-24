<?php
	$vbaseurl=base_url();
	for ($i=1; $i <= $cntfrm; $i++) {
		$ctnj = $i;
	}
?>
<div class="list-group margin-top-10px" id="divcar_frmejmpr">
	<div class="list-group-item">
		<form id="frm_ejempl<?php echo $ctnj ?>" action="<?php //echo $vbaseurl ?>biblioteca/fn_insert_ejemplares" method="post" accept-charset='utf-8'>
			<b class="margin-top-10px text-danger"><i class="fas fa-book"></i> Agregar Ejemplares</b>
			<input type="hidden" name="txtcontreg" id="txtcontreg" value="<?php echo $ctnj ?>">
			<div class="row mt-2">
				<div class="form-group has-float-label col-12 col-xs-12 col-sm-6" id="divspantip<?php echo $ctnj ?>">
	            	<select data-currentvalue='' data-cnt="<?php echo $ctnj ?>" class="form-control" id="fictipo<?php echo $ctnj ?>" name="fictipo" placeholder="Tipo" required >
	              		<option value="0">Selecciona Tipo</option>
	              		<option value="Virtual">Virtual</option>
	              		<option value="Fisico">Físico</option>
	            	</select>
	            	<label for="fictipo<?php echo $ctnj ?>"> Tipo</label>
	          	</div>
	          	<div class="form-group has-float-label col-12 col-xs-12 col-sm-6 d-none" id="divcar_virtual<?php echo $ctnj ?>">
					<input data-currentvalue='' class="form-control text-uppercase" id="fictxtlink<?php echo $ctnj ?>" name="fictxtlink<?php echo $ctnj ?>" type="text" placeholder="Link" />
					<label for="fictxtlink<?php echo $ctnj ?>">Link</label>
				</div>
				
			</div>
			<div class="row mt-1 d-none" id="divcar_fisico<?php echo $ctnj ?>">
				<div class="form-group has-float-label col-12 col-xs-12 col-sm-3" id="divspanpgn<?php echo $ctnj ?>">
					<input data-currentvalue='' class="form-control text-uppercase" id="fictxtnpag<?php echo $ctnj ?>" name="fictxtnpag<?php echo $ctnj ?>" type="text" placeholder="N° Páginas" />
					<label for="fictxtnpag<?php echo $ctnj ?>">N° Páginas</label>
				</div>
				<div class="form-group has-float-label col-12 col-xs-12 col-sm-4" id="divspanest<?php echo $ctnj ?>">
	            	<select data-currentvalue='' class="form-control" id="ficestado<?php echo $ctnj ?>" name="ficestado<?php echo $ctnj ?>" placeholder="Estado" required >
	              		<option value="0">Selecciona Estado</option>
	              		<option value="BUENO">BUENO</option>
	              		<option value="MALO">MALO</option>
	              		<option value="REGULAR">REGULAR</option>
	            	</select>
	            	<label for="ficestado<?php echo $ctnj ?>"> Estado</label>
	          	</div>
	          	<div class="form-group has-float-label col-12 col-xs-12 col-sm-5" id="divspanubic<?php echo $ctnj ?>">
					<input data-currentvalue='' class="form-control text-uppercase" id="fictxtubica<?php echo $ctnj ?>" name="fictxtubica<?php echo $ctnj ?>" type="text" placeholder="Ubicación" />
					<label for="fictxtubica<?php echo $ctnj ?>">Ubicación</label>
				</div>
			</div>
			<div class="row mt-1 d-none" id="divcar_fisico2-<?php echo $ctnj ?>">
				<div class="form-group has-float-label col-12 col-xs-12 col-sm-4" id="divspanstcn<?php echo $ctnj ?>">
	            	<select data-currentvalue='' class="form-control" id="ficsituacion<?php echo $ctnj ?>" name="ficsituacion<?php echo $ctnj ?>" placeholder="Situación" required >
	              		<option value="0">Selecciona Situación</option>
	              		<option value="PERDIDO">PERDIDO</option>
	              		<option value="PRESTADO">PRESTADO</option>
	              		<option value="DISPONIBLE">DISPONIBLE</option>
	              		<option value="MANTENIMIENTO">MANTENIMIENTO</option>
	            	</select>
	            	<label for="ficsituacion<?php echo $ctnj ?>"> Situación</label>
	          	</div>
	          	<div class="form-group has-float-label col-12 col-xs-12 col-sm-4" id="divspanproc<?php echo $ctnj ?>">
	            	<select data-currentvalue='' class="form-control" id="ficproced<?php echo $ctnj ?>" name="ficproced<?php echo $ctnj ?>" placeholder="Procedencia" required >
	              		<option value="0">Selecciona Procedencia</option>
	              		<option value="RECURSOS PROPIOS">RECURSOS PROPIOS</option>
	              		<option value="CANON">CANON</option>
	              		<option value="DONACIÓN">DONACIÓN</option>
	            	</select>
	            	<label for="ficproced<?php echo $ctnj ?>"> Procedencia</label>
	          	</div>
	          	<div class="form-group has-float-label col-12 col-xs-12 col-sm-4" id="divspanfecha<?php echo $ctnj ?>">
	          		<input data-currentvalue='' class="form-control text-uppercase" id="fictxtfecha<?php echo $ctnj ?>" name="fictxtfecha<?php echo $ctnj ?>" type="date" placeholder="Fecha Compra" />
					<label for="fictxtfecha<?php echo $ctnj ?>">Fecha Compra</label>
	          	</div>
			</div>
			<div class="row mt-1 d-none" id="divcar_fisico3-<?php echo $ctnj ?>">
				<div class="form-group has-float-label col-12 col-xs-12 col-sm-4" id="divspandoc<?php echo $ctnj ?>">
	          		<input data-currentvalue='' class="form-control text-uppercase" id="fictxtndoc<?php echo $ctnj ?>" name="fictxtndoc<?php echo $ctnj ?>" type="text" placeholder="Nro Documento" />
					<label for="fictxtndoc<?php echo $ctnj ?>">Nro Documento</label>
	          	</div>
	          	<div class="form-group has-float-label col-12 col-xs-12 col-sm-4" id="divspanprec<?php echo $ctnj ?>">
	          		<input data-currentvalue='' class="form-control text-uppercase" id="fictxtprecio<?php echo $ctnj ?>" name="fictxtprecio<?php echo $ctnj ?>" type="number" step="0.01" value="0.00" placeholder="Precio Unit" />
					<label for="fictxtprecio<?php echo $ctnj ?>">Precio Unit</label>
	          	</div>
	          	<div class="form-group has-float-label col-12 col-xs-12 col-sm-4" id="divspancomp<?php echo $ctnj ?>">
	          		<input data-currentvalue='' class="form-control text-uppercase" id="fictxtordcom<?php echo $ctnj ?>" name="fictxtordcom<?php echo $ctnj ?>" type="text" placeholder="Orden Compra" />
					<label for="fictxtordcom<?php echo $ctnj ?>">Orden Compra</label>
	          	</div>
			</div>
			<div class="row mt-1">
	        	<div class="col-6">
	        		<div id="divmsgejmp<?php echo $ctnj ?>" class="float-left">
						
					</div>
	        	</div>
				<div class="col-6">
					<button type="button" class="btn btn-primary float-right btnregisejm<?php echo $ctnj ?>" id="btnregisejm<?php echo $ctnj ?>"><i class="fas fa-save"></i> Registrar</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/ejemplares.js"></script>
