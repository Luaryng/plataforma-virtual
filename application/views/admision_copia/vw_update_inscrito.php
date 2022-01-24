<?php
	function obtienecheck($array, $valor)
  	{
    	if (count($array)> 0) {
    		foreach ($array as $key => $value) {
    			if ($value->public == $valor) {
                	return $value->public;
            	}
    		}
      		
    	}
  	}

?>
<b class="pt-2 pb-4 text-danger d-block"><i class="fas fa-user-circle"></i> DISCAPACIDAD</b>
<div class="row mt-2">
    <div class="form-group has-float-label col-12 col-sm-3">
        <select name="cbodispacacidadup" id="cbodispacacidadup" class="form-control">
          <option <?php echo ($inscrito->discapacidad == "NO") ? "selected" : ""; ?> value="NO">NO</option>
          <option <?php echo ($inscrito->discapacidad == "SI") ? "selected" : ""; ?> value="SI">SI</option>
        </select>
        <label for="cbodispacacidadup">¿Tiene alguna discap.?</label>
    </div>
    <div class="form-group has-float-label col-12 col-sm-4 d-none divcard_detdiscapup">
        <select data-currentvalue='' class="form-control" id="ficbdiscapacidadup" name="ficbdiscapacidadup" >
          <option value="0">Selecciona discapacidad</option>
          <?php 
          $seldisc = '';
          foreach ($discapacidades as $disc) {
            $grupod = "";
            if ($disc->detalle != "" || $disc->detalle != null) {
              $grupod = $disc->grupo." - ".$disc->detalle;
            } else {
              $grupod = $disc->grupo;
            }

            if (!is_null($discapacidad)) {
            	$coddisacap = $discapacidad->coddiscap;
            	$seldisc = ($disc->codigo == $coddisacap) ? 'selected' : '';
            }
          ?>
          <option <?php echo $seldisc ?> value="<?php echo $disc->codigo ?>"><?php echo $grupod ?></option>
          <?php } ?>
        </select>
        <label for="ficbdiscapacidadup"> Discapacidad</label>
    </div>
    <div class="form-group has-float-label col-12 col-sm-5 d-none divcard_detdiscapup" id="">
        <input class="form-control" type="text" name="txtdetadiscapacup" id="txtdetadiscapacup" placeholder="Especificar ¿Cúal es su discapacidad?" value="<?php echo $inscrito->detalle ?>">
        <label for="txtdetadiscapacup">Especificar ¿Cúal es su discapacidad?</label>
    </div>
          
</div>
<b class="pt-2 pb-4 text-danger d-block"><i class="fas fa-user-circle"></i> PROCESO DE ADMISIÓN</b>
<input data-currentvalue='' id="fimidins" name="fimidins" type="hidden" value="<?php echo base64url_encode($inscrito->codinscripcion) ?>" />
<input data-currentvalue='' id="fitxtdniup" name="fitxtdniup" type="hidden" value="<?php echo $inscrito->nro ?>" />
<input data-currentvalue='' id="ficbcarsiglaup" name="ficbcarsiglaup" type="hidden" />
<input type="hidden" name="fictxtperiodoant" id="fictxtperiodoant" value="<?php echo $inscrito->codperiodo ?>">
<input type="hidden" name="fictxtcicloant" id="fictxtcicloant" value="<?php echo $inscrito->codciclo ?>">
    
<div class="row margin-top-20px">
  	<div class="form-group has-float-label col-12 col-sm-5">
	    <select data-currentvalue='' class="form-control" id="ficbmodalidadup" name="ficbmodalidadup" placeholder="Modalidad" required >
	      	<option value="0">Selecciona modalidad</option>
	      	<?php 
	      	foreach ($modalidades as $modalidad) {
	      		$modsel = ($modalidad->id == $inscrito->codmodalidad) ? "selected" : "";
	      	?>
	      	<option <?php echo $modsel ?> value="<?php echo $modalidad->id ?>"><?php echo $modalidad->nombre ?></option>
	      	<?php } ?>
	    </select>
	    <label for="ficbmodalidadup"> Modalidad</label>
  	</div>
  	<div class="form-group has-float-label col-12 col-sm-3">
	    <select data-currentvalue='' class="form-control" id="ficbperiodoup" name="ficbperiodoup" placeholder="Periodo lectivo" required >
	      	<option value="0">Selecciona periodo</option>
	      	<?php 
	      	foreach ($periodos as $periodo) {
	      		$persel = ($periodo->codigo == $inscrito->codperiodo) ? "selected" : "";
	      	?>
	      	<option <?php echo $persel ?> value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
	      	<?php } ?>
	    </select>
	    <label for="ficbperiodoup"> Periodo lectivo</label>
  	</div>
  	<div class="form-group has-float-label col-12 col-sm-4">
	    <select data-currentvalue='' class="form-control" id="ficbcampaniaup" name="ficbcampaniaup" placeholder="Campaña" required >
	      	<option value="0">Selecciona</option>
	      	<?php 
	      	foreach ($campanias as $campania) {
	      		$camsel = ($campania->id == $inscrito->codcampania) ? "selected" : "";
	      	?>
	      	<option <?php echo $camsel ?> value="<?php echo $campania->id ?>"><?php echo $campania->nombre ?></option>
	      	<?php } ?>
	    </select>
	    <label for="ficbcampaniaup"> Campaña</label>
  	</div>
  	<div class="form-group has-float-label col-12 col-sm-12 d-none" id="divcard_trasladoup">
	    <input type="text" name="fictxtinstprocedenup" id="fictxtinstprocedenup" placeholder="Instituto de Traslado" class="form-control">
	    <label for="fictxtinstprocedenup">Instituto de Traslado</label>
  	</div>

  	<div class="form-group col-12 col-sm-12">
    	<span id="fiins-spcampaniaup" class=" form-control bg-light"></span>
  	</div>
</div>
<b class="pt-2 pb-4 text-danger d-block"><i class="fas fa-user-circle"></i> DATOS ACADÉMICOS</b>
<div class="row margin-top-20px">
  	<div class="form-group has-float-label col-12 col-sm-5">
	    <select data-currentvalue='' class="form-control" id="ficbcarreraup" name="ficbcarreraup" placeholder="Programa de estudios" required >
	      	<option value="0">Selecciona</option>
	      	<?php 
	      	foreach ($carreras as $carrera) {
	      		$carsel = ($carrera->codcarrera == $inscrito->codcarrera) ? "selected" : "";
	      	?>
	      	<option <?php echo $carsel ?> value="<?php echo $carrera->codcarrera ?>" data-sigla="<?php echo $carrera->sigla ?>"><?php echo $carrera->nombre ?></option>
	      	<?php } ?>
	    </select>
	    <label for="ficbcarreraup"> Programa de estudios</label>
  	</div>
  	<div class="form-group has-float-label col-12 col-sm-2">
	    <select data-currentvalue='' class="form-control" id="ficbcicloup" name="ficbcicloup" placeholder="Semestre Acad." required >
	      	<option value="0">Selecciona</option>
	      	<?php 
	      	foreach ($ciclos as $ciclo) {
	      		$cicsel = ($ciclo->codigo == $inscrito->codciclo) ? "selected" : "";
	      	?>
	      	<option <?php echo $cicsel ?> value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
	      	<?php } ?>
	    </select>
	    <label for="ficbcicloup"> Semestre Acad.</label>
  	</div>
  	<div class="form-group has-float-label col-12 col-sm-3">
	    <select data-currentvalue='' class="form-control" id="ficbturnoup" name="ficbturnoup" placeholder="Turno" required >
	      	<option value="0">Selecciona</option>
	      	<?php 
	      	foreach ($turnos as $turno) {
	      		$tursel = ($turno->codigo == $inscrito->codturno) ? "selected" : "";
	      	?>
	      	<option <?php echo $tursel ?> value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
	      	<?php } ?>
	    </select>
	    <label for="ficbturnoup"> Turno</label>
  	</div>
  	<div class="form-group has-float-label col-12 col-sm-2">
	    <select data-currentvalue='' class="form-control" id="ficbseccionup" name="ficbseccionup" placeholder="Sección" required >
	      	<option value="0">Selecciona</option>
	      	<?php 
	      	foreach ($secciones as $seccion) {
	      		// $secsel = ($seccion->codigo == $inscrito->codturno) ? "selected" : "";
	      	?>
	      	<option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
	      	<?php } ?>
	    </select>
	    <label for="ficbseccionup"> Sección</label>
  	</div>
  	
  	<div class="form-group has-float-label col-12 col-sm-12">
    	<textarea class="form-control" id="fitxtobservacionesup" name="fitxtobservacionesup" placeholder="Observaciones"  rows="3"><?php echo $inscrito->observacion ?></textarea>
    	<label for="fitxtobservacionesup"> Observaciones</label>
  	</div>
  	<div class="col-12 mb-3" id="divcard_publicidadup">
    	<h4 class="title-seccion text-danger">¿Como se enteró de nuestros programas?</h4>
	    <div class="row ml-3">
	      <?php
	        $nro = 0;
	        foreach ($publicidad as $key => $pb) {
	          $nro ++;
	      ?>
	      <div class="col-12 divcheckup">
	        <div class="custom-control custom-switch">
	            <input type="checkbox" <?php echo (obtienecheck($dpublicidad, $pb->codigo) == $pb->codigo) ? 'checked': '' ?> class="custom-control-input checkpublicidadup" id="checkpub<?php echo $nro ?>" data-codigo="<?php echo $pb->codigo ?>">
	            <label class="custom-control-label" for="checkpub<?php echo $nro ?>"><?php echo $pb->nombre ?></label>
	        </div>
	      </div>
	      <?php
	        }
	      ?>
	      
	    </div>
  	</div>
  	<?php
  		$dateins =  new DateTime($inscrito->fecinsc);
		$fechains = $dateins->format('Y-m-d');
  	?>
  	<div class="form-group has-float-label col-12 col-sm-3">
    	<input data-currentvalue='' class="form-control text-uppercase" value="<?php echo $fechains ?>" id="fitxtfecinscripcionup" name="fitxtfecinscripcionup" type="date" placeholder="Fec. Inscripción"   />
    	<label for="fitxtfecinscripcionup">Fec. Inscripción</label>
  	</div>
</div>
<script>
	$(document).ready(function() {
		$('#cbodispacacidadup').change();
		$("#form_update_insc #ficbperiodoup").change();
		$("#form_update_insc #ficbcarreraup").change();
		setTimeout(function() {
			$("#form_update_insc #ficbcampaniaup").change();
		},1000)
		
	});

	$('#ficbmodalidadup').change(function(){
	    var combo = $(this);
	    var item = combo.val();
	    if (item == "0" || item == 1) {
	      	$('#divcard_trasladoup').addClass('d-none');
	      	$("#fictxtinstprocedenup").prop("required",false);
	    } else if (item == 2) {
	      	$('#divcard_trasladoup').removeClass('d-none');
	      	$("#fictxtinstprocedenup").prop("required",true);
	      
	    } else if (item == 3) {
	      	$('#divcard_trasladoup').addClass('d-none');
	      	$("#fictxtinstprocedenup").prop("required",false);
	    }
    
  	});

	$('#cbodispacacidadup').change(function() {
    	var combo = $(this);
    	var item = combo.val();
    	if (item =='SI') {
      		$('.divcard_detdiscapup').removeClass('d-none');
    	} else {
      		$('.divcard_detdiscapup').addClass('d-none');
      		$('#ficbdiscapacidadup').val('0');
      		$('#txtdetadiscapacup').val('');
    	}
  	});

  	$("#form_update_insc #ficbperiodoup").change(function(event) {
      	var cbcmp = $('#form_update_insc #ficbcampaniaup');
      	$('#form_update_insc #fiins-spcampaniaup').html("");
      	cbcmp.html("<option value='0'>Sin opciones</option>");
      	var codperiodo = $(this).val();
      	if (codperiodo == '0') return;
      	$.ajax({
          	url: base_url + 'campania/fn_campania_por_periodo',
          	type: 'post',
          	dataType: 'json',
          	data: {
              txtcodperiodo: codperiodo
          	},
          	success: function(e) {
              cbcmp.html(e.vdata);
              $('#ficbcampaniaup').val('<?php echo $inscrito->codcampania ?>');
          	},
          	error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              cbcmp.html("<option value='0'>" + msgf + "</option>");
          	}
      	});
  	});

  	$("#form_update_insc #ficbcampaniaup").change(function(event) {
      	var cbcmp = $('#form_update_insc #fiins-spcampaniaup');
      	cbcmp.html("");
      	if ($(this).val !== "0") cbcmp.html($('option:selected', this).data('descripcion'))
  	});
  	$("#form_update_insc #ficbcarreraup").change(function(event) {
      	var cbcmp = $('#form_update_insc #ficbcarsiglaup');
      	cbcmp.html("");
      	if ($(this).val !== "0") cbcmp.val($('option:selected', this).data('sigla'))
  	});

</script>