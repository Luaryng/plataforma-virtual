<?php
	$vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">

    <div class="modal fade" id="modupsede" aria-modal="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="divmodsede">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Carrera por Sede</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="msgcuerpo">
                    <form id="frm_updatesede" action="<?php echo $vbaseurl ?>carrera_sede/fn_insert_update" method="post" accept-charset='utf-8'>
                        <b class="text-danger"><i class="fas fa-graduation-cap"></i> Carrera Sede</b>
                        <div class="row mt-2">
                            <input type="hidden" name="fictxtaccion" id="fictxtaccion" value="EDITAR">
                            <input type="hidden" name="fictxtcodsedantg" id="fictxtcodsedantg" value="">
                            <input type="hidden" name="fictxtcodcarantg" id="fictxtcodcarantg" value="">
                                <div class="form-group has-float-label col-12 col-sm-6">
                                    <select name="fictxtnomsed" id="fictxtnomsed" class="form-control">
                                        <option value="">Seleccione item</option>
                                        <?php
                                        foreach ($activos as $key => $sed) {
                                            echo "<option value='$sed->id'>$sed->nombre</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="fictxtnomsed">Sede</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-sm-6">
                                    <select name="fictxtnomcarr" id="fictxtnomcarr" class="form-control">
                                        <option value="">Seleccione item</option>
                                        <?php
                                        foreach ($carreras as $key => $carr) {
                                            echo "<option value='$carr->id'>$carr->nombre</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="fictxtnomcarr">Carrera</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-lg-4 col-md-6">
                                    <input type="number" name="fictxtcostins" id="fictxtcostins" value="0.00" step="0.01" class="form-control">
                                    <label for="fictxtcostins">Costo Inscripción</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-lg-4 col-md-6">
                                    <input type="number" name="fictxtcostmat" id="fictxtcostmat" value="0.00" step="0.01" class="form-control">
                                    <label for="fictxtcostmat">Costo Matrícula</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-lg-4 col-md-6">
                                    <input type="number" name="fictxtcostotal" id="fictxtcostotal" value="0.00" step="0.01" class="form-control">
                                    <label for="fictxtcostotal">Costo Total</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-lg-4 col-md-6">
                                    <input type="number" name="fictxtcostcont" id="fictxtcostcont" value="0.00" step="0.01" class="form-control">
                                    <label for="fictxtcostcont">Costo Contado</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-lg-2 col-md-4">
                                    <input type="number" name="fictxtnrocuotas" id="fictxtnrocuotas" value="0" step="1" class="form-control">
                                    <label for="fictxtnrocuotas">N° cuotas</label>
                                </div>
                                <div class="form-group col-6 col-lg-3 col-md-4">
                                    <label for="checkabierta">Abierta:</label>
                                    <input  id="checkabierta" name="checkabierta" class="checkabierta" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                </div>
                                <div class="form-group col-6 col-lg-3 col-md-4">
                                    <label for="checkestado">Activo:</label>
                                    <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-12">
                                <div id="divmsgsede" class="float-left">

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn_updsede">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

	<section id="s-cargado" class="content pt-2">
		<div id="divcard_sede" class="card text-dark">
			<div class="card-header">
                <ul class="nav nav-pills">
                	<li class="nav-item"><a class="nav-link active" href="#search-carrera-sede" data-toggle="tab"><b><i class="fas fa-list mr-1"></i>Datos</b></a></li>
                  	<li class="nav-item"><a class="nav-link" href="#registrar-carrera-sede" data-toggle="tab"><b><i class="fas fa-user-plus mr-1"></i>Registrar</b></a></li>
                </ul>
            </div>
		    <div class="card-body">
		    	<div class="tab-content">
			    	<div class="tab-pane" id="registrar-carrera-sede">
	      				<div class="alert alert-secondary alert-dismissible fade show bordered">
							<strong>Aviso:</strong> Antes de ingresar los datos, verifica si el registro no ha sido registrada anteriormente
						</div>
                        <div class="border border-secondary rounded p-2">
                            <form id="frm_add_carsed" action="<?php echo $vbaseurl ?>carrera_sede/fn_insert_update" method="post" accept-charset="utf-8">
                                <b class="text-danger"><i class="fas fa-graduation-cap"></i> Carrera Sede</b>
                                <input type="hidden" name="fictxtaccion" id="fictxtaccion" value="INSERTAR">
                                <div class="row mt-2">
                                    <div class="form-group has-float-label col-12 col-sm-6">
                                        <select name="fictxtnomsed" id="fictxtnomsed" class="form-control">
                                            <option value="">Seleccione item</option>
                                            <?php
                                            foreach ($activos as $key => $sed) {
                                                echo "<option value='$sed->id'>$sed->nombre</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="fictxtnomsed">Sede</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-sm-6">
                                        <select name="fictxtnomcarr" id="fictxtnomcarr" class="form-control">
                                            <option value="">Seleccione item</option>
                                            <?php
                                            foreach ($carreras as $key => $carr) {
                                                echo "<option value='$carr->id'>$carr->nombre</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="fictxtnomcarr">Carrera</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-lg-4 col-md-6">
                                        <input type="number" name="fictxtcostins" id="fictxtcostins" value="0.00" step="0.01" class="form-control">
                                        <label for="fictxtcostins">Costo Inscripción</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-lg-4 col-md-6">
                                        <input type="number" name="fictxtcostmat" id="fictxtcostmat" value="0.00" step="0.01" class="form-control">
                                        <label for="fictxtcostmat">Costo Matrícula</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-lg-4 col-md-6">
                                        <input type="number" name="fictxtcostotal" id="fictxtcostotal" value="0.00" step="0.01" class="form-control">
                                        <label for="fictxtcostotal">Costo Total</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-lg-4 col-md-6">
                                        <input type="number" name="fictxtcostcont" id="fictxtcostcont" value="0.00" step="0.01" class="form-control">
                                        <label for="fictxtcostcont">Costo Contado</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-lg-2 col-md-4">
                                        <input type="number" name="fictxtnrocuotas" id="fictxtnrocuotas" value="0" step="1" class="form-control">
                                        <label for="fictxtnrocuotas">N° cuotas</label>
                                    </div>
                                    <div class="form-group col-6 col-lg-3 col-md-4">
                                        <label for="checkabierta">Abierta:</label>
                                        <input  id="checkabierta" name="checkabierta" class="checkabierta" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                    </div>
                                    <div class="form-group col-6 col-lg-3 col-md-4">
                                        <label for="checkestado">Activo:</label>
                                        <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div id="divmsgcarrsed" class="float-left">

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary btn-md float-right" id="btn_add_carrs"><i class="fas fa-save"></i> Registrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>

                    <div class="active tab-pane" id="search-carrera-sede">
                        <small id="fmt_conteo" class="form-text text-primary">
            
                        </small>
                        <div class="col-12 py-1">
                            <div class="btable">
                                <div class="thead col-12  d-none d-md-block">
                                    <div class="row">
                                        <div class='col-12 col-md-4'>
                                            <div class='row'>
                                                <div class='col-1 col-md-2 td'>N°</div>
                                                <div class='col-3 col-md-4 td'>SEDE</div>
                                                <div class='col-3 col-md-6 td text-center'>CARRERA</div>
                                            </div>
                                        </div>
                                        <div class='col-12 col-md-4'>
                                            <div class='row'>
                                                <div class='col-9 col-md-4 td'>MATRICULA</div>
                                                <div class='col-9 col-md-4 td'>TOTAL</div>
                                                <div class='col-9 col-md-4 td'>N° CUOTAS</div>
                                            </div>
                                        </div>
                                        <div class='col-12 col-md-4 text-center'>
                                            <div class='row'>
                                                <div class='col-sm-3 col-md-4 td'>
                                                    <span>ABIERTA</span>
                                                </div>
                                                <div class='col-sm-3 col-md-4 td'>
                                                    <span>ACTIVA</span>
                                                </div>
                                                <div class='col-sm-4 col-md-4 td'>
                                                    <span>ACCIONES</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="tbody col-12" id="divcard_data_carsedes">
                                    
                                </div>
                            </div>
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
          title: 'Aviso: Antes de asignar una carrera a una sede, verifica si no ha sido registrado anteriormente'
        })

        filtro_carrera_sedes('');
    });

    $('#frm_add_carsed').submit(function() {
        $('#frm_add_carsed input,select').removeClass('is-invalid');
        $('#frm_add_carsed .invalid-feedback').remove();
        $('#divcard_sede').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $(this).attr("action"),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(e) {
                $('#divcard_sede #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#frm_add_carsed #' + key).addClass('is-invalid');
                        $('#frm_add_carsed #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {
                            $('#frm_add_carsed')[0].reset();
                            $('.nav-pills a[href="#search-carrera-sede"]').tab('show');
                            filtro_carrera_sedes('');
                        }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divcard_sede #divoverlay').remove();
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

    function viewupdatcarsed(idsede, idcarrera) {
        $('#divcard_sede').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#divrstarea").html("");
        $.ajax({
            url: base_url + "carrera_sede/vwmostrar_datoxcodigo",
            type: 'post',
            dataType: "json",
            data: {txtidsede: idsede, txtidcarrera: idcarrera},
            success: function(e) {
                $('#divcard_sede #divoverlay').remove();

                $("#modupsede").modal("show");
                
                $("#modupsede #fictxtcodsedantg").val(e.sedeup['idsede']);

                $("#modupsede #fictxtcodcarantg").val(e.sedeup['idcarrera']);

                $("#modupsede #fictxtnomsed").val(e.sedeup['idsede']);

                $("#modupsede #fictxtnomcarr").val(e.sedeup['idcarrera']);

                if (e.sedeup['abierto'] == 'SI') {
                    $("#modupsede #checkabierta").bootstrapToggle('on');
                    
                } else {
                    $("#modupsede #checkabierta").bootstrapToggle('off');
                }

                if (e.sedeup['activo'] == 'SI') {
                    $("#modupsede #checkestado").bootstrapToggle('on');
                    
                } else {
                    $("#modupsede #checkestado").bootstrapToggle('off');
                }

                $('#modupsede #fictxtcostins').val(e.sedeup['inscripcion']);

                $('#modupsede #fictxtcostmat').val(e.sedeup['matricula']);

                $("#modupsede #fictxtcostotal").val(e.sedeup['total']);

                $("#modupsede #fictxtcostcont").val(e.sedeup['contado']);

                $("#modupsede #fictxtnrocuotas").val(e.sedeup['cuotas']);

            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_sede #divoverlay').remove();
                $("#modupsede modal-body").html(msgf);
            } 
        });
        return false;
    }

    $('#btn_updsede').click(function(event) {
        $('#frm_updatesede input,select').removeClass('is-invalid');
        $('#frm_updatesede .invalid-feedback').remove();
        $('#divmodsede').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_updatesede').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_updatesede').serialize(),
            success: function(e) {
                $('#divmodsede #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#frm_updatesede #' + key).addClass('is-invalid');
                        $('#frm_updatesede #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modupsede').modal('hide');
                    
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {
                            filtro_carrera_sedes('');
                        }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodsede #divoverlay').remove();
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

    function vw_sede_carrera_fn_eliminar(btn){
        idsede = btn.data("sede");
        idcarrera = btn.data("carrera");
                
        Swal.fire({
            title: "Precaución",
            text: "¿Deseas eliminar este registro ?",
            type: 'warning',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if(result.value){
                $('#divcard_sede').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                
                $.ajax({
                    url: base_url + 'carrera_sede/fneliminar_registro',
                    type: 'POST',
                    data: {
                        "idsede": idsede,
                        "idcarrera": idcarrera
                    },
                    dataType: 'json',
                    success:function(e){
                        $('#divcard_sede #divoverlay').remove();
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

                                    filtro_carrera_sedes('');

                                }
                            })
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msgf = errorAjax(jqXHR, exception,'text');
                        $('#divcard_sede #divoverlay').remove();
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
    };

    function filtro_carrera_sedes(nomsede) {
        $('#divcard_sede').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'carrera_sede/search_carrerasede',
            type: 'post',
            dataType: 'json',
            data: {nomsede : nomsede},
            success: function(e) {
                if (e.status == true) {
                    $('#divcard_data_carsedes').html("");
                    var nro=0;
                    var tabla="";
                    var activo = "";
                    var abierta = "";
                    var codbase64 = "";
                    var coddelete = "";
                    if (e.datos.length !== 0) {
                        $('#fmt_conteo').html('');
                        $.each(e.datos, function(index, val) {
                            nro++;
                            codbase64 = 'viewupdatcarsed("'+val['codigo64']+'","'+val['codcarre64']+'")';
                            coddelete = 'vw_sede_carrera_fn_eliminar($(this));event.preventDefault();';

                            if (val['activo']==="SI"){
                                activo = "<span class='badge bg-success p-2'> ACTIVO </span>";
                            } else {
                                activo = "<span class='badge bg-danger p-2'> INACTIVO </span>";
                            }

                            if (val['abierto'] === "SI") {
                                abierta = "<span class='badge bg-success p-2'> ACTIVA </span>";
                            } else {
                                abierta = "<span class='badge bg-danger p-2'> INACTIVA </span>";
                            }

                            tabla=tabla + 
                                "<div class='row rowcolor cfila' data-sede='"+val['nombre']+"'>"+
                                    "<div class='col-12 col-md-4'>"+
                                        "<div class='row'>"+
                                            "<div class='col-2 col-md-2 text-right td'>"+nro+"</div>"+
                                            "<div class='col-4 col-md-4 td'>"+val['nomsede']+"</div>"+
                                            "<div class='col-6 col-md-6 td'>"+val['nomcarr']+"</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-12 col-md-4'>"+
                                        "<div class='row'>"+
                                            "<div class='col-4 col-md-4 td'>"+val['matricula']+"</div>"+
                                            "<div class='col-4 col-md-4 td'>"+val['total']+"</div>"+
                                            "<div class='col-4 col-md-4 td'>"+val['cuotas']+"</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-12 col-md-4 text-center'>"+
                                        "<div class='row'>"+
                                            "<div class='col-4 col-sm-4 col-md-4 td'>"+
                                                "<span>"+abierta+"</span>"+
                                            "</div>"+
                                            "<div class='col-4 col-sm-4 col-md-4 td'>"+
                                                "<span>"+activo+"</span>"+
                                            "</div>"+
                                            "<div class='col-4 col-sm-4 col-md-4 td'>"+
                                                "<div class='col-12 pt-1 pr-3 text-center'>"+
                                                    "<div class='btn-group'>"+
                                                        "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                            "<i class='fas fa-cog'></i>"+
                                                        "</a>"+
                                                        "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                            "<a class='dropdown-item' href='#' title='Editar' onclick='"+codbase64+"'>"+
                                                                "<i class='fas fa-edit mr-2'></i> Editar"+
                                                            "</a>"+
                                                                "<a class='dropdown-item text-danger deletesede' href='#' title='Eliminar' data-sede='"+val['codigo64']+"' data-carrera='"+val['codcarre64']+"' onclick='"+coddelete+"'>"+
                                                                    "<i class='fas fa-trash mr-2'></i> Eliminar"+
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

                    $('#divcard_data_carsedes').html(tabla);
                    
                } else {
                    
                    var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#divcard_data_carsedes').html(msgf);
                }

                $('#divcard_sede #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divcard_sede #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    type: 'error',
                    icon: 'error',
                })
            },
        });
    }

</script>
