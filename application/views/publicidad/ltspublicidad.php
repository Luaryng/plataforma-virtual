<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">

	<div class="modal fade" id="modaddpublicidad" tabindex="-1" role="dialog" aria-labelledby="modaddpublicidad" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="titlediscapacidad">AGREGAR PUBLICIDAD</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addpublic" action="<?php echo $vbaseurl ?>publicidad/fn_insert_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="0">
                            <div class="form-group has-float-label col-12">
                                <input list="ltsgrupos" name="fictxtnombre" id="fictxtnombre" autocomplete="off" class="form-control form-control-sm" placeholder="Nombre">
                                <label for="fictxtnombre">Nombre:</label>
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
          			<h1>Publicidad</h1>
        		</div>
      		</div>
    	</div>
  	</section>
  	<section id="s-cargado" class="content">
  		<div id="divcard_publicidad" class="card">
  			<div class="card-header">
  				<h3 class="card-title"><i class="fas fa-list-ul"></i> Lista de publicidad</h3>
  				<div class="card-tools">
                    <?php if (getPermitido("130")=='SI') { ?>
  					<button class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modaddpublicidad"><i class="fas fa-plus"></i> Agregar</button>
                    <?php } ?>
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
			                      	NOMBRE
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
		                <div id="div_filtro_publicidad" class="tbody col-12">
                            <?php
                            $nro = 0;
                            $habilita = "";
                            $updatbtn = "";
                            $deletebtn = "";
                            foreach ($publicidad as $key => $pb) {
                            $nro++;
                            $codigo64 = base64url_encode($pb->codigo);
                                if ($pb->habilitado == "SI") {
                                    $habilita = "<span class='badge bg-success p-2 small pbestado'>$pb->habilitado</span>";
                                } else {
                                    $habilita = "<span class='badge bg-danger p-2 small pbestado'>$pb->habilitado</span>";
                                }

                                if (getPermitido("131")=='SI') {
                                    $updatbtn = "<a class='dropdown-item' href='#' title='Editar' onclick='viewupdatepublic(`$codigo64`)' id='updbtn_$codigo64'>
                                                    <i class='fas fa-edit mr-1'></i> Editar
                                                </a>";
                                }

                                if (getPermitido("132")=='SI') {
                                    $deletebtn = "<a class='dropdown-item text-danger deletepublic' href='#' title='Eliminar' idpublic='$codigo64'>
                                                    <i class='fas fa-trash mr-1'></i> Eliminar
                                                </a>";
                                }

                            echo "<div class='row rowcolor cfila' data-public='$pb->nombre'>
                                    <div class='col-2 col-md-1 td'>$nro</div>
                                    <div class='col-10 col-md-8 td pbnombre'>$pb->nombre</div>
                                    <div class='col-6 col-md-2 td text-center'>$habilita</div>
                                    <div class='col-6 col-md-1 td text-center'>
                                        <div class='btn-group'>
                                            <a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                <i class='fas fa-cog'></i>
                                            </a>
                                            <div class='dropdown-menu dropdown-menu-right acc_dropdown'>
                                                $updatbtn
                                                $deletebtn
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                            }
                            ?>
                            
		                </div>
	              	</div>
	            </div>
  			</div>
  		</div>
  	</section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<script type="text/javascript">
    
	$('#lbtn_guardar').click(function() {
        $('#frm_addpublic input,select').removeClass('is-invalid');
        $('#frm_addpublic .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_addpublic').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_addpublic').serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    var nombre = $('#fictxtnombre').val();
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {
                            if (e.accion == "INSERTAR") {
                                location.reload();
                            } else {
                                var item = $('#updbtn_'+e.newcod).closest('.rowcolor');
                                item.find('.pbnombre').html(nombre);
                                item.find('.pbestado').removeClass('bg-success');
                                item.find('.pbestado').removeClass('bg-danger');
                                if (e.estado == "SI") {
                                    item.find('.pbestado').addClass('bg-success');
                                } else {
                                    item.find('.pbestado').addClass('bg-danger');
                                }
                                item.find('.pbestado').html(e.estado);
                            }
                        }
                    })

                    $('#modaddpublicidad').modal('hide');
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

    $("#modaddpublicidad").on('hidden.bs.modal', function () {
        $('#frm_addpublic')[0].reset();
        $("#fictxtcodigo").val("0");
        $('#titlediscapacidad').html("AGREGAR PUBLICIDAD");
        $("#checkestado").bootstrapToggle('off');
        $('#frm_addpublic input,select').removeClass('is-invalid');
        $('#frm_addpublic .invalid-feedback').remove();
    });

    function viewupdatepublic(codigo) {
    	$('#divcard_publicidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#divrstarea").html("");
        $.ajax({
            url: base_url + "publicidad/vwmostrar_publicidadxcodigo",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo},
            success: function(e) {
                $('#divcard_publicidad #divoverlay').remove();
                
                $("#fictxtcodigo").val(base64url_encode(e.vdata['codigo']));
                $("#fictxtnombre").val(e.vdata['nombre']);
                $('#titlediscapacidad').html("EDITAR PUBLICIDAD");

                if (e.vdata['habilitado'] == 'SI') {
                    $("#checkestado").bootstrapToggle('on');
                    
                } else {
                    $("#checkestado").bootstrapToggle('off');
                }

                $("#modaddpublicidad").modal("show");
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_publicidad #divoverlay').remove();
                $("#modaddpublicidad modal-body").html(msgf);
            } 
        });
        return false;
    }

    $(document).on("click", ".deletepublic", function(){
		var idpublic = $(this).attr("idpublic");
        var div = $(this).closest('.rowcolor');
		var item = div.data('public');  
  		
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
				$('#divcard_publicidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
				var datos = new FormData();
                datos.append("idpublic", idpublic);
                
                $.ajax({
                  	url: base_url + "publicidad/fneliminar_publicidad",
                  	method: "POST",
                  	data: datos,
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	success:function(e){
                    	$('#divcard_publicidad #divoverlay').remove();
                    	
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
	                               div.remove();
	                            }
	                        })
                    	}
                    },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception,'text');
			            $('#divcard_publicidad #divoverlay').remove();
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