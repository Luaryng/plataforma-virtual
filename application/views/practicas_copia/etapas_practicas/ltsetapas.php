<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">

	<div class="modal fade" id="modaddetapas" tabindex="-1" role="dialog" aria-labelledby="modaddetapas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleetapa">AGREGAR ETAPA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addetapa" action="<?php echo $vbaseurl ?>practicas_etapas/fn_insert_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-12">
                                <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="0">
                                <input type="text" name="fictxtnombre" id="fictxtnombre" placeholder="Nombre etapa" class="form-control form-control-sm">
                                <label for="fictxtnombre">Nombre etapa</label>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="checkestado">Habilitado:</label>
                                <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>Etapas Prácticas</h1>
        		</div>
      		</div>
    	</div>
  	</section>
  	<section id="s-cargado" class="content">
  		<div id="divcard_etapa" class="card">
  			<div class="card-header">
  				<h3 class="card-title"><i class="fas fa-list-ul"></i> Lista de etapas</h3>
  				<div class="card-tools">
  					<button class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modaddetapas"><i class="fas fa-plus"></i> Agregar</button>
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
			                    <div class="col-md-8 td">
			                      	ETAPA
			                    </div>
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

        filtrar_etapas('');
    });

    function filtrar_etapas(nometapa){
    	$('#divcard_etapa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    	$.ajax({
            url: base_url + 'practicas_etapas/fn_filtro_etapas',
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
                            codbase64 = 'viewupdatetapa("'+val['codigo_64']+'")';
                            if (val['habilitado']==="SI"){
                                activo = "<span class='badge bg-success p-2 small'> "+val['habilitado']+" </span>";
                            } else {
                                activo = "<span class='badge bg-danger p-2 small'> "+val['habilitado']+" </span>";
                            }

                            tabla=tabla + 
                                "<div class='row rowcolor cfila' data-etapa='"+val['nombre']+"'>"+
                                    "<div class='col-2 col-md-1 td'>"+nro+"</div>"+
                                    "<div class='col-10 col-md-8 td'>("+val['codigo'] + ") " + val['nombre'] + "</div>"+
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
                                                    "<a class='dropdown-item text-danger deletetapa' href='#' title='Eliminar' idetapa='"+val['codigo_64']+"'>"+
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
                    $('#modaddetapas').modal('hide');
                    
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {
                            filtrar_etapas('');
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

    $("#modaddetapas").on('hidden.bs.modal', function () {
        $('#frm_addetapa')[0].reset();
        $("#fictxtcodigo").val("0");
        $('#titleetapa').html("AGREGAR ETAPA");
        $("#checkestado").bootstrapToggle('off');
        $('#frm_addetapa input,select').removeClass('is-invalid');
        $('#frm_addetapa .invalid-feedback').remove();
    });

    function viewupdatetapa(codigo) {
    	$('#divcard_etapa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#divrstarea").html("");
        $.ajax({
            url: base_url + "practicas_etapas/vwmostrar_etapaxcodigo",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo},
            success: function(e) {
                $('#divcard_etapa #divoverlay').remove();
                
                $("#fictxtcodigo").val(base64url_encode(e.vdata['codigo']));
                $("#fictxtnombre").val(e.vdata['nombre']);
                $('#titleetapa').html("EDITAR ETAPA");

                if (e.vdata['habilitado'] == 'SI') {
                    $("#checkestado").bootstrapToggle('on');
                    
                } else {
                    $("#checkestado").bootstrapToggle('off');
                }

                $("#modaddetapas").modal("show");
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_etapa #divoverlay').remove();
                $("#modaddetapas modal-body").html(msgf);
            } 
        });
        return false;
    }

    $(document).on("click", ".deletetapa", function(){
		var idetapa = $(this).attr("idetapa");
		var etapa = $(this).closest('.rowcolor').data('etapa');  
  		
		Swal.fire({
			title: '¿Está seguro de eliminar la etapa '+etapa+'?',
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
                
                $.ajax({
                  	url: base_url + "practicas_etapas/fneliminar_etapa",
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
	                               filtrar_etapas('');
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