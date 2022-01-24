<?php
	$vbaseurl=base_url();
?>

<div class="content-wrapper">

    <div class="modal fade" id="modaddtipos" tabindex="-1" role="dialog" aria-labelledby="modaddtipos" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">AGREGAR NUEVO REGISTRO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addtipos" action="<?php echo $vbaseurl ?>tramitestipos/fn_insert_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-12">
                                <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="0">
                                <input type="text" name="fictxtnombre" id="fictxtnombre" value="" placeholder="Nombre Tipo Trámite" class="form-control">
                                <label for="fictxtnombre">Nombre Tipo Trámite</label>
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
          			<h1>Trámites
          			<small>Tipos</small></h1>
        		</div>
        
      		</div>
    	</div>
  	</section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_tipos" class="card">
			<div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de trámites tipos</h3>
		    	<div class="no-padding card-tools">
                	<a type="button" class="btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#modaddtipos"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
		    </div>
		    <div class="card-body">
                <small id="fmt_conteo" class="form-text text-primary">
            
                </small>
                <div class="col-12 py-1">
                    <div class="btable">
                        <div class="thead col-12  d-none d-md-block">
                            <div class="row">
                                <div class='col-12 col-md-9'>
                                    <div class='row'>
                                        <div class='col-2 col-md-2 td text-center'>N°</div>
                                        <div class='col-10 col-md-10 td'>NOMBRE</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-3 text-center'>
                                    <div class='row'>
                                        <div class='col-6 col-md-6 td'>
                                            <span>ESTADO</span>
                                        </div>
                                        <div class='col-6 col-md-6 td'>
                                            <span>ACCIONES</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="tbody col-12" id="divcard_data_tipos">
                            
                        </div>
                    </div>
                </div>

		    	
		    </div>
		</div>
	</section>
</div>


<script type="text/javascript">
    $(document).ready(function() {

        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 5000,
          // timerProgressBar: true,
        })

        Toast.fire({
          type: 'info',
          icon: 'info',
          title: 'Aviso: Antes de agregar un tipo de tramite, verifica si no ha sido registrado anteriormente'
        })

        filtro_tipos_tram('');
    });

    $("#modaddtipos").on('hidden.bs.modal', function () {
        $('#frm_addtipos')[0].reset();
        $("#fictxtcodigo").val("0");
        $('#divcard_title').html('AGREGAR NUEVO REGISTRO');
    });

    $('#lbtn_guardar').click(function() {
        $('#frm_addtipos input,select').removeClass('is-invalid');
        $('#frm_addtipos .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_addtipos').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_addtipos').serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modaddtipos').modal('hide');
                    var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                    
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {

                            if (e.ficaccion == "INSERTAR") {
                                filtro_tipos_tram("");
                            } else if (e.ficaccion == "EDITAR") {
                                var btno = $('#'+e.idtipo);
                                var div = btno.parents('.cfila');
                                div.data("tipo",e.tiponame);
                                div.find('.nametipo').html(e.tiponame);
                            }
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

    function viewupdatipos(codigo){
        $('#divcard_tipos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#divrstarea").html("");
        $.ajax({
            url: base_url + "tramitestipos/vwmostrar_registroxcodigo",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo},
            success: function(e) {
                $('#divcard_tipos #divoverlay').remove();
                $('#divcard_title').html('ACTUALIZAR REGISTRO');
                $("#fictxtcodigo").val(e.tiposup['codigo']);
                $("#fictxtnombre").val(e.tiposup['nombre']);

                $("#modaddtipos").modal("show");
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_tipos #divoverlay').remove();
                $("#modaddtipos modal-body").html(msgf);
            } 
        });
        return false;
    }

	$(document).on("click", ".deleteitem", function(){
		  		
        var btno=$(this);
        var div=btno.parents('.cfila');
        var codigo = div.data("codigo");
        var nombre = div.data("tipo");
        var accion = btno.data("accion");

		Swal.fire({
			title: '¿Está seguro de '+accion+' el item '+ nombre +'?',
			text: "¡Si no lo está puede cancelar la acción!",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        allowOutsideClick: false,
	        cancelButtonText: 'Cancelar',
	        confirmButtonText: 'Si, '+accion+'!'
		}).then(function(result){
			if(result.value){
				$('#divcard_tipos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
				var datos = new FormData();
                datos.append("idtipo", codigo);
                datos.append("accion", accion);
                
                $.ajax({
                  	url: base_url + "tramitestipos/fneliminar_item",
                  	method: "POST",
                  	data: datos,
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	success:function(e){
                    	$('#divcard_tipos #divoverlay').remove();
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

	                            // div.remove();
                                var icono = btno.find('.iconstatus');
                                var textstatus = btno.find('.textstatus');
                                var badge = div.find('.bg-status');
                                if(e.estado == "SI"){

                                    btno.removeClass('text-danger');
                                    btno.addClass('text-success');
                                    btno.data('accion','Habilitar')
                                    btno.attr('title','Habilitar')
                                    
                                    icono.removeClass('fa-ban');
                                    icono.addClass('fa-check');
                                    badge.removeClass('bg-success');
                                    badge.addClass('bg-danger');
                                    badge.html('INACTIVO');
                                    textstatus.html('Habilitar');

                                } else if (e.estado == "NO") {
                                    btno.removeClass('text-success');
                                    btno.addClass('text-danger');
                                    btno.data('accion','Deshabilitar')
                                    btno.attr('title','Deshabilitar')
                                    
                                    icono.removeClass('fa-check');
                                    icono.addClass('fa-ban');
                                    badge.removeClass('bg-danger');
                                    badge.addClass('bg-success');
                                    badge.html('ACTIVO');
                                    textstatus.html('Deshabilitar');
                                }
	                        })
                    	}
                    },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception,'text');
			            $('#divcard_tipos #divoverlay').remove();
			            Swal.fire({
	              			title: "Error",
	              			text: msgf,
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

    function filtro_tipos_tram(nomtipo) {
        $('#divcard_tipos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'tramitestipos/search_tipostram',
            type: 'post',
            dataType: 'json',
            data: {nomtipo : nomtipo},
            success: function(e) {
                if (e.status == true) {
                    $('#divcard_data_tipos').html("");
                    var nro=0;
                    var tabla="";
                    var estado = "";
                    var bgestado = "";
                    var iconstatus = "";
                    var accion = "";
                    var codbase64 = "";
                    if (e.datos.length !== 0) {
                        $('#fmt_conteo').html('');
                        $.each(e.datos, function(index, val) {
                            nro++;
                            codbase64 = 'viewupdatipos("'+val['codigo64']+'")';

                            if (val['eliminado']==="SI"){
                                estado = "<span class='badge bg-danger p-2 bg-status'> INACTIVO </span>";
                                bgestado = "text-success";
                                iconstatus = "fa-check";
                                accion = "Habilitar";
                            } else {
                                estado = "<span class='badge bg-success p-2 bg-status'> ACTIVO </span>";
                                bgestado = "text-danger";
                                iconstatus = "fa-ban";
                                accion = "Deshabilitar";
                            }

                            tabla=tabla + 
                                "<div class='row rowcolor cfila' data-tipo='"+val['nombre']+"' data-codigo='"+val['codigo64']+"'>"+
                                    "<div class='col-12 col-md-9'>"+
                                        "<div class='row'>"+
                                            "<div class='col-2 col-md-2 text-center td'>"+nro+"</div>"+
                                            "<div class='col-10 col-md-10 td'>"+
                                                "<span class='nametipo'>"+val['nombre']+"</span>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-12 col-md-3 text-center'>"+
                                        "<div class='row'>"+
                                            "<div class='col-6 col-md-6 td'>"+
                                                "<span>"+estado+"</span>"+
                                            "</div>"+
                                            "<div class='col-6 col-sm-6 col-md-6 td'>"+
                                                "<div class='col-12 pt-1 pr-3 text-center'>"+
                                                    "<div class='btn-group'>"+
                                                        "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                            "<i class='fas fa-cog'></i>"+
                                                        "</a>"+
                                                        "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                            "<a class='dropdown-item' href='#' title='Editar' onclick='"+codbase64+"' id='"+val['codigo']+"'>"+
                                                                "<i class='fas fa-edit mr-2'></i> Editar"+
                                                            "</a>"+
                                                                "<a class='dropdown-item "+bgestado+" deleteitem' href='#' idarea='"+val['codigo64']+"' title='"+accion+"' data-accion='"+accion+"'>"+
                                                                    "<i class='fas "+iconstatus+" mr-2 iconstatus'></i> <span class='textstatus'>"+accion+"</span>"+
                                                                "</a>"+
                                                        "</div>"+
                                                    "</div>"+
                                                "</div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>";
                                    
                        })
                    } else {
                        $('#fmt_conteo').html('No se encontraron resultados');
                    }

                    $('#divcard_data_tipos').html(tabla);
                    
                } else {
                    
                    var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#divcard_data_tipos').html(msgf);
                }

                $('#divcard_tipos #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divcard_tipos #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    type: 'error',
                    icon: 'error',
                })
            },
        });
    }
</script>