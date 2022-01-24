<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">

	<div class="modal fade" id="modaddiscapacidad" tabindex="-1" role="dialog" aria-labelledby="modaddiscapacidad" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="titlediscapacidad">AGREGAR DISCAPACIDAD</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addiscap" action="<?php echo $vbaseurl ?>discapacidad/fn_insert_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="0">
                            <div class="form-group has-float-label col-12">
                                <label for="fictxtnombre">Grupo:</label>
                                <input list="ltsgrupos" name="fictxtnombre" id="fictxtnombre" class="form-control form-control-sm">
                                <datalist id="ltsgrupos">
                                    <?php foreach ($grupos as $key => $grp) {
                                        echo "<option value='$grp->grupo'>";
                                    } ?>
                                </datalist>
                            </div>
                            <div class="form-group has-float-label col-12">
                                <input type="text" name="fictxtdetalle" id="fictxtdetalle" placeholder="Detalle" class="form-control form-control-sm">
                                <label for="fictxtdetalle">Detalle</label>
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
          			<h1>Discapacidades</h1>
        		</div>
      		</div>
    	</div>
  	</section>
  	<section id="s-cargado" class="content">
  		<div id="divcard_discapacidad" class="card">
  			<div class="card-header">
  				<h3 class="card-title"><i class="fas fa-list-ul"></i> Lista de discapacidades</h3>
  				<div class="card-tools">
  					<button class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modaddiscapacidad"><i class="fas fa-plus"></i> Agregar</button>
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
			                      	GRUPO
			                    </div>
                                <div class="col-md-4 td">
                                    DETALLE
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
		                <div id="div_filtro_discapacidad" class="tbody col-12">
		                  
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

        filtrar_discapacidades('');
    });

    function filtrar_discapacidades(nomdiscap){
    	$('#divcard_discapacidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    	$.ajax({
            url: base_url + 'discapacidad/fn_filtro_discapacidades',
            type: 'post',
            dataType: 'json',
            data: {nomdiscap : nomdiscap},
            success: function(e) {
                if (e.status == true) {
                    $('#div_filtro_discapacidad').html("");
                    var nro=0;
                    var tabla="";
                    var codbase64 = "";
                    if (e.datos.length !== 0) {
                        
                        $.each(e.datos, function(index, val) {
                            nro++;
                            codbase64 = 'viewupdatdiscap("'+base64url_encode(val['codigo'])+'")';
                            if (val['habilitado']==="SI"){
                                activo = "<span class='badge bg-success p-2 small'> "+val['habilitado']+" </span>";
                            } else {
                                activo = "<span class='badge bg-danger p-2 small'> "+val['habilitado']+" </span>";
                            }

                            tabla=tabla + 
                                "<div class='row rowcolor cfila' data-discap='"+val['detalle']+"'>"+
                                    "<div class='col-2 col-md-1 td'>"+nro+"</div>"+
                                    "<div class='col-10 col-md-4 td'>"+val['grupo']+"</div>"+
                                    "<div class='col-12 col-md-4 td'>"+val['detalle']+"</div>"+
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
                                                    "<a class='dropdown-item text-danger deletediscap' href='#' title='Eliminar' iddiscap='"+base64url_encode(val['codigo'])+"'>"+
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

                    $('#div_filtro_discapacidad').html(tabla);
                    
                } else {
                    
                    var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#div_filtro_discapacidad').html(msgf);
                }

                $('#divcard_discapacidad #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divcard_discapacidad #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    type: 'error',
                    icon: 'error',
                })
            },
        });
    }

	$('#lbtn_guardar').click(function() {
        $('#frm_addiscap input,select').removeClass('is-invalid');
        $('#frm_addiscap .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_addiscap').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_addiscap').serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modaddiscapacidad').modal('hide');
                    
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {
                            filtrar_discapacidades('');
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

    $("#modaddiscapacidad").on('show.bs.modal', function () {
        $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var grupo = "";
        $.ajax({
            url: base_url + "discapacidad/vwmostrar_discapacidadxgrupo",
            type: 'post',
            dataType: "json",
            data: {grupo: grupo},
            success: function(e) {
                $('#ltsgrupos').html("");
                var lista="";
                if (e.vdata.length !== 0) {
                    
                    $.each(e.vdata, function(index, v) {
                        lista = lista +
                            "<option value='"+v['grupo']+"'>"
                    })
                }else {
                    lista="";
                }

                $('#divmodaladd #divoverlay').remove();
                $('#ltsgrupos').html(lista);
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divmodaladd #divoverlay').remove();
                $("#modaddiscapacidad modal-body").html(msgf);
            }
        })
    })

    $("#modaddiscapacidad").on('hidden.bs.modal', function () {
        $('#frm_addiscap')[0].reset();
        $("#fictxtcodigo").val("0");
        $('#titlediscapacidad').html("AGREGAR DISCAPACIDAD");
        $("#checkestado").bootstrapToggle('off');
        $('#frm_addiscap input,select').removeClass('is-invalid');
        $('#frm_addiscap .invalid-feedback').remove();
    });

    function viewupdatdiscap(codigo) {
    	$('#divcard_discapacidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#divrstarea").html("");
        $.ajax({
            url: base_url + "discapacidad/vwmostrar_discapacidadxcodigo",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo},
            success: function(e) {
                $('#divcard_discapacidad #divoverlay').remove();
                
                $("#fictxtcodigo").val(base64url_encode(e.vdata['codigo']));
                $("#fictxtnombre").val(e.vdata['grupo']);
                $("#fictxtdetalle").val(e.vdata['detalle']);
                $('#titlediscapacidad').html("EDITAR DISCAPACIDAD");

                if (e.vdata['habilitado'] == 'SI') {
                    $("#checkestado").bootstrapToggle('on');
                    
                } else {
                    $("#checkestado").bootstrapToggle('off');
                }

                $("#modaddiscapacidad").modal("show");
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_discapacidad #divoverlay').remove();
                $("#modaddiscapacidad modal-body").html(msgf);
            } 
        });
        return false;
    }

    $(document).on("click", ".deletediscap", function(){
		var iddiscap = $(this).attr("iddiscap");
		var item = $(this).closest('.rowcolor').data('discap');  
  		
		Swal.fire({
			title: '¿Está seguro de eliminar el item '+item+'?',
			text: "¡Si no lo está puede cancelar la acción!",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        allowOutsideClick: false,
	        cancelButtonText: 'Cancelar',
	        confirmButtonText: 'Si, eliminar!'
		}).then(function(result){
			if(result.value){
				$('#divcard_discapacidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
				var datos = new FormData();
                datos.append("iddiscap", iddiscap);
                
                $.ajax({
                  	url: base_url + "discapacidad/fneliminar_discapacidad",
                  	method: "POST",
                  	data: datos,
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	success:function(e){
                    	$('#divcard_discapacidad #divoverlay').remove();
                    	
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
	                               filtrar_discapacidades('');
	                            }
	                        })
                    	}
                    },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception,'text');
			            $('#divcard_discapacidad #divoverlay').remove();
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