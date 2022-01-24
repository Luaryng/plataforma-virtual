<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">

	<div class="modal fade" id="modaddetapas_plan" tabindex="-1" role="dialog" aria-labelledby="modaddetapas_plan" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleetapa">AGREGAR PLAN ETAPA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addetapa" action="<?php echo $vbaseurl ?>practicas_etapas_plan/fn_insert_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <input type="hidden" name="fictxtetapaant" id="fictxtetapaant" value="0">
                            <input type="hidden" name="fictxtplan_estudiosant" id="fictxtplan_estudiosant" value="0">
                            
                            <div class="form-group has-float-label col-12 col-md-6">
                                <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbcarrera" name="fmt-cbcarrera" >
                                  <option value="0">Seleccione programa</option>
                                  <?php foreach ($carreras as $carrera) {?>
                                  <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                                  <?php } ?>
                                </select>
                                <label for="fmt-cbcarrera"> Prog. de Estudios</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <select name="fictxtplan_estudios" id="fictxtplan_estudios" class="form-control form-control-sm">
                                    <option value="0">Seleccione plan de estudios</option>
                                    
                                </select>
                                <label for="fictxtplan_estudios">Plan de estudios</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <select name="fictxtetapa" id="fictxtetapa" class="form-control form-control-sm">
                                    <option value="0">Seleccione etapa</option>
                                    <?php
                                        foreach ($etapas as $key => $et) {
                                            echo "<option value='$et->codigo'>$et->nombre</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtetapa">Etapa</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-3">
                                <input type="number" name="fictxthoras" id="fictxthoras" class="form-control form-control-sm" placeholder="Horas">
                                <label for="fictxthoras">Horas</label>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="checkestado">Habilitado:</label>
                                <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>Plan Etapas Prácticas</h1>
        		</div>
      		</div>
    	</div>
  	</section>
  	<section id="s-cargado" class="content">
  		<div id="divcard_etapa" class="card">
  			<div class="card-header">
  				<h3 class="card-title"><i class="fas fa-list-ul"></i> Lista de Plan etapas</h3>
  				<div class="card-tools">
  					<button class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modaddetapas_plan"><i class="fas fa-plus"></i> Agregar</button>
  				</div>
  			</div>
  			<div class="card-body">

	  			<small id="fmt-conteo" class="form-text text-primary">
            
            	</small>
  				<div class="col-12 px-0 pt-2">
	              	<div class="btable">
		                <div class="thead col-12  d-none d-md-block">
		                  	<div class="row">
			                    
		                    	<div class="col-md-1 td">NRO</div>
			                    <div class="col-md-4 td">
			                      	ETAPA
			                    </div>
                                <div class="col-md-3 td">PLAN</div>
                                <div class="col-md-1 td text-center">HORAS</div>
                                <div class="col-md-2 td text-center">HABILITADO</div>
			                    <div class="col-md-1">
			                      	<div class="row">
				                        <div class="col-md-12 td text-center">
				                          	
				                        </div>
			                      	</div>
			                    </div>
		                  	</div>
		                </div>
		                <div id="div_filtro_etapa" class="tbody col-12">
		                  
		                </div>
	              	</div>
	            </div>
  			</div>
  		</div>
  	</section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        filtrar_etapas_plan('');
    });

    function filtrar_etapas_plan(nometapa){
    	$('#divcard_etapa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    	$.ajax({
            url: base_url + 'practicas_etapas_plan/fn_filtro_etapas_plan',
            type: 'post',
            dataType: 'json',
            data: {nometapa : nometapa},
            success: function(e) {
                if (e.status == true) {
                    $('#div_filtro_etapa').html("");
                    var nro=0;
                    var tabla="";
                    var codbase64 = "";
                    if (e.datos.length !== 0) {
                        
                        $.each(e.datos, function(index, val) {
                            nro++;
                            codbase64 = 'viewupdatetapa_plan("'+base64url_encode(val['codigo'])+'","'+base64url_encode(val['idplan'])+'")';
                            if (val['habilitado']==="SI"){
                                activo = "<span class='badge bg-success p-2 small'> "+val['habilitado']+" </span>";
                            } else {
                                activo = "<span class='badge bg-danger p-2 small'> "+val['habilitado']+" </span>";
                            }

                            tabla=tabla + 
                                "<div class='row rowcolor cfila' data-etapa='"+val['etapa']+"'>"+
                                    "<div class='col-2 col-md-1 td'>"+nro+"</div>"+
                                    "<div class='col-10 col-md-4 td'>"+val['etapa']+"</div>"+
                                    "<div class='col-9 col-md-3 td'>"+val['plan']+"</div>"+
                                    "<div class='col-3 col-md-1 td text-center'>"+val['fhoras']+"</div>"+
                                    "<div class='col-6 col-md-2 td text-center'>"+activo+"</div>"+
                                    "<div class='col-6 col-md-1 td text-center'>"+
                                        "<div class='btn-group'>"+
                                            "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                "<i class='fas fa-cog'></i>"+
                                            "</a>"+
                                            "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                "<a class='dropdown-item' href='#' title='Editar' onclick='"+codbase64+"'>"+
                                                    "<i class='fas fa-edit mr-1'></i> Editar"+
                                                "</a>"+
                                                    "<a class='dropdown-item text-danger deletetapaplan' href='#' title='Eliminar' idetapa='"+base64url_encode(val['codigo'])+"' idplan='"+base64url_encode(val['idplan'])+"'>"+
                                                        "<i class='fas fa-trash mr-1'></i> Eliminar"+
                                                    "</a>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>";
                                    
                        })
                        $('#fmt-conteo').html(nro + ' Datos encontrados');
                    } else {
                        $('#fmt-conteo').html('No se encontraron resultados');
                    }

                    $('#div_filtro_etapa').html(tabla);
                    
                } else {
                    
                    var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#div_filtro_etapa').html(msgf);
                }

                $('#divcard_etapa #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divcard_etapa #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    type: 'error',
                    icon: 'error',
                })
            },
        });
    }

    $('#fmt-cbcarrera').change(function(event) {
        if ($(this).val()!="0"){
            $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

            $('#fictxtplan_estudios').html("<option value='0'>Sin opciones</option>");
            var codcar = $(this).val();
            if (codcar == '0') return;
            $.ajax({
                url: base_url + 'plancurricular/fn_get_planes_activos_combo',
                type: 'post',
                dataType: 'json',
                data: {
                    txtcodcarrera: codcar
                },
                success: function(e) {
                    $('#divmodaladd #divoverlay').remove();
                    $('#fictxtplan_estudios').html(e.vdata);
                    $("#fictxtplan_estudios").val(getUrlParameter("cpl",0));
                },
                error: function(jqXHR, exception) {
                    $('#divmodaladd #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#fictxtplan_estudios').html("<option value='0'>" + msgf + "</option>");
                }
            });
        }
        else{
            $('#fictxtplan_estudios').html("<option value='0'>Selecciona un programa<option>");
        }
    });

	$('#lbtn_guardar').click(function() {
        $('#frm_addetapa input,select').removeClass('is-invalid');
        $('#frm_addetapa .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_addetapa').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_addetapa').serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    //$('#modaddetapas_plan').modal('hide');
                    $("#checkestado").bootstrapToggle('off');
                    $("#fictxtetapa").val("0");
                    $("#fictxthoras").val("");

                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    });
                    
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

    $("#modaddetapas_plan").on('hidden.bs.modal', function () {
        filtrar_etapas_plan('');
        $('#frm_addetapa')[0].reset();
        $('#fictxtetapaant').val('0');
        $('#fictxtplan_estudiosant').val('0');
        $('#titleetapa').html("AGREGAR PLAN ETAPA");
        $("#checkestado").bootstrapToggle('off');
        $('#frm_addetapa input,select').removeClass('is-invalid');
        $('#frm_addetapa .invalid-feedback').remove();
    });

    function viewupdatetapa_plan(codigo,plan) {
    	$('#divcard_etapa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#divrstarea").html("");
        $.ajax({
            url: base_url + "practicas_etapas_plan/vwmostrar_etapa_planxcodigo",
            type: 'post',
            dataType: "json",
            data: {
                txtcodigo: codigo,
                txtplan: plan
            },
            success: function(e) {
                $('#divcard_etapa #divoverlay').remove();
                
                $("#fictxtetapa").val(e.vdata['codigo']);
                $('#titleetapa').html("EDITAR PLAN ETAPA");
                $('#fmt-cbcarrera').val(e.vdata['idcarrera']);
                $('#fictxtplan_estudios').html(e.planes);
                $('#fictxtplan_estudios').val(e.vdata['idplan']);
                $('#fictxthoras').val(e.vdata['horas']);

                $('#fictxtetapaant').val(base64url_encode(e.vdata['codigo']));
                $('#fictxtplan_estudiosant').val(base64url_encode(e.vdata['idplan']));

                if (e.vdata['habilitado'] == 'SI') {
                    $("#checkestado").bootstrapToggle('on');
                    
                } else {
                    $("#checkestado").bootstrapToggle('off');
                }

                $("#modaddetapas_plan").modal("show");
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_etapa #divoverlay').remove();
                $("#modaddetapas_plan modal-body").html(msgf);
            } 
        });
        return false;
    }

    $(document).on("click", ".deletetapaplan", function(){
		var idetapa = $(this).attr("idetapa");
        var idplan = $(this).attr("idplan");
  		
		Swal.fire({
			title: '¿Está seguro de eliminar el item seleccionado?',
			text: "¡Si no lo está puede cancelar la acción!",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        allowOutsideClick: false,
	        cancelButtonText: 'Cancelar',
	        confirmButtonText: 'Si, eliminar!'
		}).then(function(result){
			if(result.value){
				$('#divcard_etapa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
				var datos = new FormData();
                datos.append("idetapa", idetapa);
                datos.append("idplan", idplan);
                $.ajax({
                  	url: base_url + "practicas_etapas_plan/fneliminar_etapa_plan",
                  	method: "POST",
                  	data: datos,
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	success:function(e){
                    	$('#divcard_etapa #divoverlay').remove();
                    	
                    	if (e.status == true) {
                    		Swal.fire({
	                          	type: "success",
	                          	icon: 'success',
	                          	title: "¡CORRECTO!",
	                          	text: e.msg,
	                          	showConfirmButton: true,
	                          	allowOutsideClick: false,
	                          	confirmButtonText: "Cerrar"
	                        }).then(function(result){
	                            if(result.value){
	                               filtrar_etapas_plan('');
	                            }
	                        })
                    	}
                    },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception,'text');
			            $('#divcard_etapa #divoverlay').remove();
			            Swal.fire({
	              			title: "Error",
	              			text: e.msgf,
	              			type: "error",
	              			icon: "error",
	              			allowOutsideClick: false,
	              			confirmButtonText: "¡Cerrar!"
	            		});
			        }
            	})
			}
    	});  		
	        
	    return false;
	});

</script>