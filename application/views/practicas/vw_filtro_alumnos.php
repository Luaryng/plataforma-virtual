<?php $vbaseurl=base_url() ?>
<style type="text/css">
  	.not-active { 
    	pointer-events: none; 
    	cursor: default;
    	opacity: .65;
   		box-shadow: none;
  	}
</style>
<div class="content-wrapper">

	<div class="modal fade" id="modupdateplan" tabindex="-1" role="dialog" aria-labelledby="modupdateplan" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="titlemodal">EDITAR PLAN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_updplan" action="<?php echo $vbaseurl ?>practicas/fn_update_plan" method="post" accept-charset="utf-8">
                    	<input type="hidden" id="fictxtcodigoins" name="fictxtcodigoins" value="">
                    	<input type="hidden" id="fictxtcodigoper" name="fictxtcodigoper" value="">
                        <div class="row">
                            <div class="form-group has-float-label col-12 col-md-4">
                                <select name="fictxtcicloup" id="fictxtcicloup" class="form-control">
                                    <option value="">Seleccione item</option>
                                    <?php
                                        foreach ($ciclos as $key => $value) {
                                            echo "<option value='$value->codigo'>$value->nombre</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtcicloup">Ciclo</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-8">
                                <select name="fictxtplanup" id="fictxtplanup" class="form-control">
                                    <option value="">Seleccione item</option>
                                    <?php
                                        foreach ($planes as $key => $pln) {
                                            echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtplanup">Plan Estudios</label>
                            </div>
                        </div> 
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="lbtn_guardar_plan" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>Buscar</h1>
        		</div>
      		</div>
    	</div>
  	</section>
  	<section id="s-cargado" class="content">
  		<div id="divcard_filtro" class="card">
  			<div class="card-body">
  				<div class="row-fluid">
  					<form id="frmfiltro_alumnos" name="frmfiltro_alumnos" action="<?php echo $vbaseurl ?>practicas/fn_get_filtrar_alumnos" method="post" accept-charset='utf-8'>
	  					<div class="row">
		                  	<div class="form-group has-float-label col-12 col-sm-6 col-md-2">
		                    	<select data-currentvalue='' class="form-control" id="fmt-cbperiodo" name="fmt-cbperiodo" placeholder="Periodo">
		                      		<option value="%"></option>
		                      		<?php foreach ($periodos as $periodo) {?>
		                      		<option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
		                      		<?php } ?>
		                    	</select>
		                    	<label for="fmt-cbperiodo"> Periodo</label>
		                  	</div>
		                  
		                  	<div class="form-group has-float-label col-12 col-sm-6 col-md-5">
		                    	<select data-currentvalue='' class="form-control" id="fmt-cbcarrera" name="fmt-cbcarrera" placeholder="Programa Académico" >
		                      		<option value="%"></option>
		                      		<?php foreach ($carreras as $carrera) {?>
		                      		<option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
		                      		<?php } ?>
		                    	</select>
		                    	<label for="fmt-cbcarrera"> Programa Académico</label>
		                  	</div>

		                  	<div class="form-group has-float-label col-12 col-sm-6 col-md-5">
			                    <select name="fmt-cbplan" id="fmt-cbplan"class="form-control">
			                      	<option data-carrera="0" value="%"></option>
			                      	<?php foreach ($planes as $pln) {
			                        	echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
			                      	} ?>
			                    </select>
			                    <label for="fmt-cbplan">Plan estudios</label>
		                  	</div>
		                  	<div class="form-group has-float-label col-12 col-sm-6 col-md-7">
			                    <input class="form-control text-uppercase" autocomplete="off" id="fmt-alumno" name="fmt-alumno" placeholder="Carné o Apellidos y nombres" >
			                    <label for="fmt-alumno"> Carné o Apellidos y nombres
			                    </label>
			                 </div>
		                  	<div class="col-6 col-sm-2 col-md-1">
		                    	<button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
		                  	</div>
		                </div>
	  				</form>
  				</div>
  				<small id="fmt-conteo" class="form-text text-primary">
            
            	</small>
  				<div class="col-12 px-0 pt-2">
	              	<div class="btable">
		                <div class="thead col-12  d-none d-md-block">
		                  	<div class="row">
			                    <div class="col-md-2">
			                      	<div class="row">
			                        	<div class="col-md-3 td">N°</div>
			                        	<div class="col-md-9 td">CARNÉ</div>
			                      	</div>
			                    </div>
		                    	<div class="col-md-3 td">ALUMNO</div>
			                    <div class="col-md-6">
			                      	<div class="row">
			                        	<div class="col-md-6 td">PER./PLAN</div>
			                        	<div class="col-md-6 td">PROG.</div>
			                      	</div>
			                    </div>
			                    <div class="col-md-1">
			                      	<div class="row">
				                        <div class="col-md-12 td text-center">
				                          	
				                        </div>
			                      	</div>
			                    </div>
		                  	</div>
		                </div>
		                <div id="div_filtro" class="tbody col-12">
		                  
		                </div>
	              	</div>
	            </div>
  			</div>
  		</div>
  	</section>
</div>

<script>
	$(document).ready(function() {

	    $("#fmt-cbperiodo").val(getUrlParameter("cp", '%'));
	    $("#fmt-cbcarrera").val(getUrlParameter("cc", '%'));
	    
	    $("#fmt-cbplan").val(getUrlParameter("cpl", '%'));
	    
	    if (getUrlParameter("at", 0) == 1) $("#frmfiltro_alumnos").submit();
	});

	$('#frmfiltro_alumnos #fmt-cbcarrera').change(function(event) {
	    var codcar = $(this).val();
	    if (codcar=="%"){
	      	$("#frmfiltro_alumnos #fmt-cbplan option").each(function(i){
	          	if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');           
	      	});
	    }
	    else{
	      	$("#frmfiltro_alumnos #fmt-cbplan option").each(function(i){
		        if ($(this).data('carrera')=='0'){
		            //if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
		        }
		        else if ($(this).data('carrera')==codcar){
		            $(this).removeClass('ocultar');
		        }
		        else{
		            if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
		        }
	      	});
	    }
	});

	$('#frmfiltro_alumnos').submit(function(event) {
		$('#divcard_filtro').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $("#div_filtro").html("");
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	            if (e.status == false) {} else {
	            	var nro = 0;
	            	var tabla = "";
	                $.each(e.vdata, function(index, v) {
	                    nro++;
	                    var codinscripcion = v['idins_64'];
	                    var periodo = v['idperiodo_64'];
	                    var idplan = v['idplan_64'];
	                    
	                    var disabled = "";
	                    var plan = "";
	                    var btnupd = "";
	                    if (v['idplan'] != 0) {
	                    	disabled = "";
	                    	plan = ' / ' + v['plan'];
	                    	btnupd = "";
	                    } else {
	                    	disabled = "not-active";
	                    	plan = "";
	                    	btnupd = '<a href="#" class="ml-2 vw_updateplan"><i class="fas fa-pencil-alt"></i></a>';
	                    }
	                    tabla = tabla + 
	                    '<div data-periodo="'+periodo+'" data-idm="' + codinscripcion + '" data-idciclo="'+v['idciclo']+'" data-carrera="'+v['idcarrera']+'" class="cfila row rowcolor">'+
	                    	'<div class="col-4 col-md-2">' +
                            	'<div class="row">' +
                              		'<div class="col-3 col-md-3 td">' + nro + '</div>' +
                              		'<div class="ccarne col-9 col-md-9 td">' + v['carne'] + '</div>' +
                            	'</div>' +
                          	'</div>' +
                          	'<div class="calumno col-8 col-md-3 td">' + v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + '</div>' +
                          	'<div class="col-6 col-md-6">' +
                            	'<div class="row">' +
                              		'<div data-cp="' + v['idperiodo'] + '" class="cperiodo col-4 col-md-6 td text-center">' + 
                              			v['periodo']+ ' / ' +v['ciclo'] + ' SEM.' + plan + btnupd +
                              		'</div>' +
                              		'<div class="ccarrera col-4 col-md-6 td text-center" data-cod="' + v['idcarrera'] + '" title="'+v['carrera']+'">' + 
                              			v['carrera'] + 
                              		'</div>' +
                            	'</div>' +
                          	'</div>' +
                          	'<div class="td col-6 col-md-1 text-center">'+
                          		'<a href="'+base_url+'academico/practicas/detalle-practica/'+codinscripcion+'/'+idplan+'/'+periodo+'?sb=academico" class="btn btn-info btn-sm '+disabled+'" title="Prácticas">'+
                          			'<i class="fas fa-chalkboard-teacher"></i> '+
                          		'</a>'+
                          	'</div>' +
	                    '</div>';
                    })

                    $("#div_filtro").html(tabla);
                    $("#fmt-conteo").html(nro + ' datos encontrados');
                	$('#divcard_filtro #divoverlay').remove();
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divcard_filtro #divoverlay').remove();
	            //$('#divError').show();
	            //$('#msgError').html(msgf);
	        }
	    })
	    return false;
	});


	$(document).on('click', '.vw_updateplan', function(e) {
		e.preventDefault();
		var boton = $(this);
		var fila = boton.closest('.cfila');
		var codins = fila.data('idm');
		var ciclo = fila.data('idciclo');
		var carrera = fila.data('carrera');
		var periodo = fila.data('periodo');

		$("#frm_updplan #fictxtplanup option").each(function(i){
    
        	if ($(this).data('carrera')=='0'){
            	//if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
          	}
          	else if ($(this).data('carrera')==carrera){
            	$(this).removeClass('ocultar');
          	}
          	else{
            	if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
          	}
      	});

		$('#fictxtcodigoins').val(codins);
		$('#fictxtcodigoper').val(periodo);
		$('#fictxtcicloup').val(ciclo);
		$('#modupdateplan').modal('show');
	});

	$("#modupdateplan").on('hidden.bs.modal', function () {
        $('#frm_updplan')[0].reset();
    });

	$('#lbtn_guardar_plan').click(function() {
		$('#frm_updplan input,select').removeClass('is-invalid');
        $('#frm_updplan .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_updplan').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_updplan').serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modupdateplan').modal('hide');
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {
                            $('#frmfiltro_alumnos').submit();
                        }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodaladd #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
	});
</script>