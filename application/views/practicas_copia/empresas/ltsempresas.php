<?php $vbaseurl=base_url() ?>
<div class="content-wrapper">
	<div class="modal fade" id="modaddempresa" tabindex="-1" role="dialog" aria-labelledby="modaddempresa" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleempresa">AGREGAR EMPRESA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addempresa" action="<?php echo $vbaseurl ?>empresas/fn_insert_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-12 col-md-8">
                                <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="0">
                                <input type="text" name="fictxtnombre" id="fictxtnombre" placeholder="Razón Social" class="form-control form-control-sm">
                                <label for="fictxtnombre">Razón Social</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-4">
                            	<input type="text" name="fictxtruc" id="fictxtruc" placeholder="Ruc" class="form-control form-control-sm">
                                <label for="fictxtruc">Ruc</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-8">
                            	<input type="text" name="fictxtdireccion" id="fictxtdireccion" placeholder="Dirección" class="form-control form-control-sm">
                                <label for="fictxtdireccion">Dirección</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-4">
                            	<input type="text" name="fictxttelefono" id="fictxttelefono" placeholder="Teléfono/Celular" class="form-control form-control-sm">
                                <label for="fictxttelefono">Teléfono/Celular</label>
                            </div>
                            <div class="form-group has-float-label col-12  col-sm-4">
                                <select onchange='fn_combo_ubigeo($(this));' data-currentvalue='' class="form-control form-control-sm" id="ficbdepartamento" name="ficbdepartamento" placeholder="Departamento" required data-tubigeo='departamento' data-cbprovincia='ficbprovincia' data-cbdistrito='ficbdistrito' data-dvcarga='divcard_data'>
                                    <option value="0">Selecciona Departamento</option>
                                    <?php foreach ($departamentos as $key => $depa) {?>
                                    <option value="<?php echo $depa->codigo ?>"><?php echo $depa->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="ficbdepartamento"> Departamento</label>
                            </div>
                            <div class="form-group has-float-label col-12  col-sm-4">
                                <select onchange='fn_combo_ubigeo($(this));' data-currentvalue='0' class="form-control form-control-sm" id="ficbprovincia" name="ficbprovincia" placeholder="Provincia" required data-tubigeo='provincia' data-cbdistrito='ficbdistrito' data-dvcarga='divcard_data'>
                                    <option value="0">Sin opciones</option>
                                </select>
                                <label for="ficbprovincia"> Provincia</label>
                            </div>
                            <div class="form-group has-float-label col-12  col-sm-4">
                                <select data-currentvalue='0'  class="form-control form-control-sm" id="ficbdistrito" name="ficbdistrito" placeholder="Distrito" required >
                                    <option value="0">Sin opciones</option>
                                </select>
                                <label for="ficbdistrito"> Distrito</label>
                            </div>

                            <div class="form-group has-float-label col-12 col-md-6">
                            	<input type="text" name="fictxtcontacapellidos" id="fictxtcontacapellidos" placeholder="Apellidos contacto" class="form-control form-control-sm">
                                <label for="fictxtcontacapellidos">Apellidos contacto</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                            	<input type="text" name="fictxtcontacnombres" id="fictxtcontacnombres" placeholder="Nombres contacto" class="form-control form-control-sm">
                                <label for="fictxtcontacnombres">Nombres contacto</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-4">
                            	<input type="text" name="fictxtcontactelefono" id="fictxtcontactelefono" placeholder="Teléfono/Celular contacto" class="form-control form-control-sm">
                                <label for="fictxtcontactelefono">Teléfono/Celular contacto</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>Empresas</h1>
        		</div>
      		</div>
    	</div>
  	</section>
  	<section id="s-cargado" class="content">
  		<div id="divcard_filtro" class="card">
  			<div class="card-header">
  				<h3 class="card-title"><i class="fas fa-list-ul"></i> Lista de empresas</h3>
  				<div class="card-tools">
  					<button class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modaddempresa"><i class="fas fa-plus"></i> Agregar</button>
  				</div>
  			</div>
  			<div class="card-body">
				<div class="row">
					<div class="form-group has-float-label col-12 col-sm-6 col-md-9">
	                	<input class="form-control text-uppercase" autocomplete="off" id="emp-nombre" name="emp-nombre" placeholder="Ruc o Razón Social" >
	                    <label for="emp-nombre"> Ruc o Razón Social
	                    </label>
	                </div>
	                <div class="col-6 col-sm-2 col-md-1">
	                	<button type="button" id="btn_filtrar" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
	              	</div>
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
			                        	<div class="col-md-9 td">RUC</div>
			                      	</div>
			                    </div>
		                    	<div class="col-md-3 td">RAZÓN SOCIAL</div>
		                    	<div class="col-md-3">
		                    		<div class="row">
			                        	<div class="col-md-6 td">DIRECCIÓN</div>
			                        	<div class="col-md-6 td">TELÉFONO</div>
			                      	</div>
		                    	</div>
			                    <div class="col-md-3 td">
			                      	CONTACTO
			                    </div>
			                    <div class="col-md-1">
			                      	<div class="row">
				                        <div class="col-md-12 td text-center">
				                          	
				                        </div>
			                      	</div>
			                    </div>
		                  	</div>
		                </div>
		                <div id="div_filtro_empresa" class="tbody col-12">
		                  
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
          title: 'Aviso: Antes de agregar una empresa, verifica si no ha sido registrado anteriormente'
        })

        filtrar_empresas('');
    });

    $('#emp-nombre').keyup(function(event) {
		var campo = $(this).val();

		var keycode = event.keyCode || event.which;
	    if(keycode == '13') {       
	         filtrar_empresas(campo);
	    }
	});

    $('#btn_filtrar').click(function() {
    	var campo = $('#emp-nombre').val();
    	filtrar_empresas(campo);
    });

    function filtrar_empresas(nomempresa){
    	$('#divcard_filtro').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    	$.ajax({
            url: base_url + 'empresas/fn_search_empresas',
            type: 'post',
            dataType: 'json',
            data: {nomempresa : nomempresa},
            success: function(e) {
                if (e.status == true) {
                    $('#div_filtro_empresa').html("");
                    var nro=0;
                    var tabla="";
                    var direccion = "";
                    var encargado = "";
                    var codbase64 = "";
                    if (e.datos.length !== 0) {
                        
                        $.each(e.datos, function(index, val) {
                            nro++;
                            codbase64 = 'viewupdatempresa("'+base64url_encode(val['codigo'])+'")';
                            direccion = val['direccion'] + " - " + val['distrito'];
                            if (val['cnombres'] !== null && val['cnombres'] !== "") {
                                encargado = val['capellidos'] + " " + val['cnombres'];
                            } else {
                                encargado = "SIN RESPONSABLE";
                            }

                            tabla=tabla + 
                                "<div class='row rowcolor cfila' data-empresa='"+val['nombre']+"'>"+
                                    "<div class='col-5 col-md-2'>"+
                                        "<div class='row'>"+
                                            "<div class='col-3 col-md-3 text-right td'>"+nro+"</div>"+
                                            "<div class='col-9 col-md-9 td'>"+val['ruc']+"</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-7 col-md-3 td'>"+val['nombre']+"</div>"+
                                    "<div class='col-12 col-md-3'>"+
                                        "<div class='row'>"+
                                            "<div class='col-6 col-md-6 td'>"+direccion+"</div>"+
                                            "<div class='col-6 col-md-6 td'>"+val['telefono']+"</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-9 col-md-3 td'>"+encargado+"<br>"+val['ctelefono']+"</div>"+
                                    "<div class='col-3 col-md-1 td text-center'>"+
                                        "<div class='btn-group'>"+
                                            "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                "<i class='fas fa-cog'></i>"+
                                            "</a>"+
                                            "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                "<a class='dropdown-item' href='#' title='Editar' onclick='"+codbase64+"'>"+
                                                    "<i class='fas fa-edit mr-1'></i> Editar"+
                                                "</a>"+
                                                    "<a class='dropdown-item text-danger deletempresa' href='#' title='Eliminar' idempresa='"+base64url_encode(val['codigo'])+"'>"+
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

                    $('#div_filtro_empresa').html(tabla);
                    
                } else {
                    
                    var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#div_filtro_empresa').html(msgf);
                }

                $('#divcard_filtro #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divcard_filtro #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    type: 'error',
                    icon: 'error',
                })
            },
        });
    }

    function fn_combo_ubigeo(combo){
	    if (combo.data('tubigeo') == "departamento") {
	        var nmprov=combo.data('cbprovincia');
	        var nmdist=combo.data('cbdistrito');
	        var nmdiv=combo.data('dvcarga');
	        $('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	        $('#' + nmprov).html("<option value='0'>Sin opciones</option>");
	        $('#frm_addempresa #' + nmdist).html("<option value='0'>Sin opciones</option>");
	        var coddepa = combo.val();
	        
	        if (coddepa == '0') return;
	        $.ajax({
	            url: base_url + 'ubigeo/fn_provincia_x_departamento',
	            type: 'post',
	            dataType: 'json',
	            data: {
	                txtcoddepa: coddepa
	            },
	            success: function(e) {
	                $('#' + nmdiv + ' #divoverlay').remove();
	                $('#frm_addempresa #' + nmprov).html(e.vdata);
	                
	            },
	            error: function(jqXHR, exception) {
	                $('#' + nmdiv + ' #divoverlay').remove();
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#frm_addempresa #' + nmprov).html("<option value='0'>" + msgf + "</option>");
	            }
	        });
	    } 
	    else if (combo.data('tubigeo') == "provincia") {
	        var nmdist=combo.data('cbdistrito');
	        var nmdiv=combo.data('dvcarga');
	        $('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	        $('#frm_addempresa #' + nmdist).html("<option value='0'>Sin opciones</option>");
	        var codprov = combo.val();
	        if (codprov == '0') return;
	        $.ajax({
	            url: base_url + 'ubigeo/fn_distrito_x_provincia',
	            type: 'post',
	            dataType: 'json',
	            data: {
	                txtcodprov: codprov
	            },
	            success: function(e) {
	                $('#' + nmdiv + ' #divoverlay').remove();
	                $('#frm_addempresa #' + nmdist).html(e.vdata);
	                
	            },
	            error: function(jqXHR, exception) {
	                $('#' + nmdiv + ' #divoverlay').remove();
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#frm_addempresa #ficbdistrito').html("<option value='0'>" + msgf + "</option>");
	            }
	        });
	    } 
	    // else if (combo.data('tubigeo') == "distrito") {
	        
	    // }
	    return false;
	}

	$('#lbtn_guardar').click(function() {
        $('#frm_addempresa input,select').removeClass('is-invalid');
        $('#frm_addempresa .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_addempresa').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_addempresa').serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modaddempresa').modal('hide');
                    var campo = "";
                    if (e.accion == "EDITAR") {
                    	campo = $('#emp-nombre').val();
                    } else {
                    	campo = "";
                    }
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {
                            filtrar_empresas(campo);
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

    $("#modaddempresa").on('hidden.bs.modal', function () {
        $('#frm_addempresa')[0].reset();
        $("#fictxtcodigo").val("0");
        $('#titleempresa').html("AGREGAR EMPRESA");
    });

    function viewupdatempresa(codigo) {
    	$('#divcard_filtro').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#divrstarea").html("");
        $.ajax({
            url: base_url + "empresas/vwmostrar_empresaxcodigo",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo},
            success: function(e) {
                $('#divcard_filtro #divoverlay').remove();
                
                $("#fictxtcodigo").val(base64url_encode(e.vdata['codigo']));
                $("#fictxtnombre").val(e.vdata['nombre']);
                $("#fictxtruc").val(e.vdata['ruc']);
                $("#fictxtdireccion").val(e.vdata['direccion']);
                $("#fictxttelefono").val(e.vdata['telefono']);
                // UBIGEO
                $('#frm_addempresa #ficbdepartamento').val(e.vdata['iddepartamento']);
			    $('#frm_addempresa #ficbprovincia').html(e.provincias);
			    $('#frm_addempresa #ficbprovincia').val(e.vdata['idprovincia']);
			    $('#frm_addempresa #ficbdistrito').html(e.distritos);
			    $('#frm_addempresa #ficbdistrito').val(e.vdata['iddistrito']);
			    // FIN UBIGEO

                $('#fictxtcontacapellidos').val(e.vdata['capellidos']);
                $("#fictxtcontacnombres").val(e.vdata['cnombres']);
                $("#fictxtcontactelefono").val(e.vdata['ctelefono']);
                $('#titleempresa').html("EDITAR EMPRESA");

                $("#modaddempresa").modal("show");
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_filtro #divoverlay').remove();
                $("#modaddempresa modal-body").html(msgf);
            } 
        });
        return false;
    }

    $(document).on("click", ".deletempresa", function(){
		var idempresa = $(this).attr("idempresa");
		var empresa = $(this).closest('.rowcolor').data('empresa');  
  		
		Swal.fire({
			title: '¿Está seguro de eliminar la empresa '+empresa+'?',
			text: "¡Si no lo está puede cancelar la acción!",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        allowOutsideClick: false,
	        cancelButtonText: 'Cancelar',
	        confirmButtonText: 'Si, eliminar!'
		}).then(function(result){
			if(result.value){
				$('#divcard_filtro').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
				var datos = new FormData();
                datos.append("idempresa", idempresa);
                
                $.ajax({
                  	url: base_url + "empresas/fneliminar_empresa",
                  	method: "POST",
                  	data: datos,
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	success:function(e){
                    	$('#divcard_filtro #divoverlay').remove();
                    	var campo = $('#emp-nombre').val();
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
	                               filtrar_empresas(campo);
	                            }
	                        })
                    	}
                    },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception,'text');
			            $('#divcard_filtro #divoverlay').remove();
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