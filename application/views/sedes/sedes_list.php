<?php
	$vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_sede" class="card text-dark">
			<div class="card-header">
                <ul class="nav nav-pills">
                	<li class="nav-item"><a class="nav-link active" href="#search-sede" data-toggle="tab"><b><i class="fas fa-list mr-1"></i>Datos</b></a></li>
                  	<li class="nav-item"><a class="nav-link" href="#registrar-sede" data-toggle="tab"><b><i class="fas fa-user-plus mr-1"></i>Registrar</b></a></li>
                </ul>
            </div>
		    <div class="card-body">
		    	<div class="tab-content">
			    	<div class="tab-pane" id="registrar-sede">
	      				<div class="alert alert-secondary alert-dismissible fade show bordered">
							<strong>Aviso:</strong> Antes de ingresar los datos, verifica si la SEDE no ha sido registrada anteriormente
						</div>
                        <div class="border border-secondary rounded p-2">
                            <form class="form-neo" id="frm_addsede" action="<?php echo $vbaseurl ?>sede/fn_insert_update" method="post" accept-charset='utf-8'>
                                <b class="text-danger"><i class="fas fa-globe"></i> Sede</b>
                                <div class="row mt-2">
                                    <div class="form-group has-float-label col-12 col-sm-5">
                                        <input type="hidden" name="fictxtaccion" id="fictxtaccion" value="INSERTAR">
                                        <input class="form-control" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre Sede" />
                                        <label for="fictxtnombre">Nombre Sede</label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="checkestado">Activo:</label>
                                        <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                    </div>
                                    <div class="form-group has-float-label col-12 col-sm-5">
                                        <select name="fictxtcodper" id="fictxtcodper" class="form-control">
                                            <option value="">Seleccione Item</option>
                                            <?php
                                                foreach ($docentes as $key => $value) {
                                                    echo "<option value='$value->codpersona'>$value->nombres</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="fictxtcodper">Titular</label>
                                    </div>
                                </div>
                                
                                <div class="row mt-2">
                                    <div class="form-group has-float-label col-12  col-md-3">
                                        <select onchange='fn_combo_ubigeo_modal($(this),"frm_addsede");' data-tubigeo='departamento' data-cbprovincia='vw_ins_cbprovincia' data-cbdistrito='vw_ins_cbdistrito' data-dvcarga='divcard_datos' class="form-control form-control-sm" id="ficbdepartamento" name="ficbdepartamento" placeholder="Departamento" required >
                                            <option value="0">Selecciona Departamento</option>
                                            <?php foreach ($departamentos as $key => $depa) {?>
                                            <option value="<?php echo $depa->codigo ?>"><?php echo $depa->nombre ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="ficbdepartamento"> Departamento</label>
                                    </div>
                                    <div class="form-group has-float-label col-12  col-md-4">
                                        <select onchange='fn_combo_ubigeo_modal($(this),"frm_addsede");' data-tubigeo='provincia' data-cbdistrito='vw_ins_cbdistrito' data-dvcarga='divcard_datos' class="form-control form-control-sm" id="vw_ins_cbprovincia" name="vw_ins_cbprovincia" placeholder="Provincia" required >
                                            <option value="0">Sin opciones</option>
                                        </select>
                                        <label for="vw_ins_cbprovincia"> Provincia</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-md-5">
                                        <select name="vw_ins_cbdistrito" id="vw_ins_cbdistrito"  class="form-control form-control-sm text-uppercase">
                                                                                    
                                        </select>
                                        <label for="vw_ins_cbdistrito">Distrito</label>
                                    </div>
                                    
                                </div>
                                <div class="row mt-2">
                                    <div class="form-group has-float-label col-12 col-sm-12">
                                        <input class="form-control" id="fictxtlocal" name="fictxtlocal" type="text" placeholder="Tipo Local" />
                                        <label for="fictxtlocal">Tipo Local</label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div id="divmsgmod" class="float-left">

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary btn-md float-right" id="btnregismod"><i class="fas fa-save"></i> Registrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
						
					</div>
					<div class="active tab-pane" id="search-sede">
                        <small id="fmt_conteo" class="form-text text-primary">
            
                        </small>
                        <div class="col-12 py-1">
                            <div class="btable">
                                <div class="thead col-12  d-none d-md-block">
                                    <div class="row">
                                        <div class='col-12 col-md-4'>
                                            <div class='row'>
                                                <div class='col-1 col-md-2 td'>N°</div>
                                                <div class='col-3 col-md-5 td'>SEDE</div>
                                                <div class='col-3 col-md-5 td text-center'>DISTRITO</div>
                                            </div>
                                        </div>
                                        <div class='col-12 col-md-5'>
                                            <div class='row'>
                                                <div class='col-9 col-md-3 td'>ACTIVO</div>
                                                <div class='col-9 col-md-9 td'>TITULAR</div>
                                            </div>
                                        </div>
                                        <div class='col-12 col-md-3 text-center'>
                                            <div class='row'>
                                                <div class='col-sm-3 col-md-6 td'>
                                                    <span>LOCAL</span>
                                                </div>
                                                <div class='col-sm-4 col-md-6 td'>
                                                    <span>ACCIONES</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="tbody col-12" id="divcard_data_sedes">
                                    
                                </div>
                            </div>
                        </div>

					</div>
				</div>
		    </div>
	    </div>
	</section>
</div>

<div class="modal fade" id="modupsede" aria-modal="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="divmodsede">
            <div class="modal-header">
            	<h4 class="modal-title">Editar Sede</h4>
        	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            	    <span aria-hidden="true">×</span>
              	</button>
            </div>
            <div class="modal-body" id="msgcuerpo">
            	<form id="frm_updatesede" action="<?php echo $vbaseurl ?>sede/fn_insert_update" method="post" accept-charset='utf-8'>
					<b class="margin-top-10px text-danger"><i class="fas fa-globe"></i> Sede</b>
					<div class="row mt-2">
                        <div class="form-group has-float-label col-12 col-sm-8">
                            <input type="hidden" name="fictxtaccion" id="fictxtaccion" value="EDITAR">
                            <input type="hidden" name="fictxtcodigo" id="fictxtcodigo" value="">
                            <input class="form-control" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre Sede" />
                            <label for="fictxtnombre">Nombre Sede</label>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="checkestado">Activo:</label>
                            <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                        </div>
                        <div class="form-group has-float-label col-12 col-sm-12">
                            <select name="fictxtcodper" id="fictxtcodper" class="form-control">
                                <option value="">Seleccione Item</option>
                                <?php
                                    foreach ($docentes as $key => $value) {
                                        echo "<option value='$value->codpersona'>$value->nombres</option>";
                                    }
                                ?>
                            </select>
                            <label for="fictxtcodper">Titular</label>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="form-group has-float-label col-12  col-md-6">
                            <select onchange='fn_combo_ubigeo_modal($(this),"modupsede");' data-tubigeo='departamento' data-cbprovincia='vw_ins_cbprovincia' data-cbdistrito='vw_ins_cbdistrito' data-dvcarga='divcard_datos' class="form-control" id="ficbdepartamento" name="ficbdepartamento" placeholder="Departamento" required >
                                <option value="0">Selecciona Departamento</option>
                                <?php foreach ($departamentos as $key => $depa) {?>
                                <option value="<?php echo $depa->codigo ?>"><?php echo $depa->nombre ?></option>
                                <?php } ?>
                            </select>
                            <label for="ficbdepartamento"> Departamento</label>
                        </div>
                        <div class="form-group has-float-label col-12  col-md-6">
                            <select onchange='fn_combo_ubigeo_modal($(this),"modupsede");' data-tubigeo='provincia' data-cbdistrito='vw_ins_cbdistrito' data-dvcarga='divcard_datos' class="form-control" id="vw_ins_cbprovincia" name="vw_ins_cbprovincia" placeholder="Provincia" required >
                                <option value="0">Sin opciones</option>
                            </select>
                            <label for="vw_ins_cbprovincia"> Provincia</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-6">
                            <select name="vw_ins_cbdistrito" id="vw_ins_cbdistrito"  class="form-control text-uppercase">
                                                                        
                            </select>
                            <label for="vw_ins_cbdistrito">Distrito</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-sm-6">
                            <input class="form-control" id="fictxtlocal" name="fictxtlocal" type="text" placeholder="Tipo Local" />
                            <label for="fictxtlocal">Tipo Local</label>
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

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<!-- <script src="<?php echo base_url() ?>resources/dist/js/pages/ubigeo_uni.js"></script> -->
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
          title: 'Aviso: Antes de agregar una Sede, verifica si no ha sido registrado anteriormente'
        })

        filtro_sedes('');
    });

    $('#frm_addsede').submit(function() {
        $('#frm_addsede input,select').removeClass('is-invalid');
        $('#frm_addsede .invalid-feedback').remove();
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
                        $('#frm_addsede #' + key).addClass('is-invalid');
                        $('#frm_addsede #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modaddarea').modal('hide');
                    var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                    $('#divmsgarea').html(msgf);
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {
                            $('#frm_addsede')[0].reset();
                            $('.nav-pills a[href="#search-sede"]').tab('show');
                            filtro_sedes('');
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

    function viewupdatsede(codigo){
        $('#divcard_sede').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#divrstarea").html("");
        $.ajax({
            url: base_url + "sede/vwmostrar_sedexcodigo",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo},
            success: function(e) {
                $('#divcard_sede #divoverlay').remove();

                $("#modupsede").modal("show");

                $("#modupsede #divmodsede").append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                
                $("#modupsede #fictxtcodigo").val(e.sedeup['id']);

                $("#modupsede #fictxtnombre").val(e.sedeup['nombre']);

                if (e.sedeup['activo'] == 'SI') {
                    $("#modupsede #checkestado").bootstrapToggle('on');
                    
                } else {
                    $("#modupsede #checkestado").bootstrapToggle('off');
                }

                $('#modupsede #fictxtcodper').val(e.sedeup['percod']);

                $('#modupsede #ficbdepartamento').val(e.sedeup['codep']);

                fn_combo_ubigeo_modal($('#modupsede #ficbdepartamento'), "modupsede");
                setTimeout(function() {
                    $('#modupsede #vw_ins_cbprovincia').val(e.sedeup['codprov']);
                    fn_combo_ubigeo_modal($('#modupsede #vw_ins_cbprovincia'), "modupsede");

                },1000);

                setTimeout(function() {
                    $('#modupsede #vw_ins_cbdistrito').val(e.sedeup['codist']);
                    $("#modupsede #divmodsede #divoverlay").remove();
                },2000);

                $("#modupsede #fictxtlocal").val(e.sedeup['local']);

            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_sede #divoverlay').remove();
                $("#modupsede modal-body").html(msgf);
            } 
        });
        return false;
    }

    function fn_combo_ubigeo_modal(combo,contenedor){
        if (combo.data('tubigeo') == "departamento") {
            var nmprov=combo.data('cbprovincia');
            var nmdist=combo.data('cbdistrito');
            var nmdiv=combo.data('dvcarga');
            $('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $('#' + nmprov).html("<option value='0'>Sin opciones</option>");
            $('#'+contenedor+' #' + nmdist).html("<option value='0'>Sin opciones</option>");
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
                    $('#'+contenedor+' #' + nmprov).html(e.vdata);
                },
                error: function(jqXHR, exception) {
                    $('#' + nmdiv + ' #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#'+contenedor+' #' + nmprov).html("<option value='0'>" + msgf + "</option>");
                }
            });
        } 
        else if (combo.data('tubigeo') == "provincia") {
            var nmdist=combo.data('cbdistrito');
            var nmdiv=combo.data('dvcarga');
            $('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $('#'+contenedor+' #' + nmdist).html("<option value='0'>Sin opciones</option>");
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
                    $('#'+contenedor+' #' + nmdist).html(e.vdata);
                },
                error: function(jqXHR, exception) {
                    $('#' + nmdiv + ' #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#'+contenedor+' #ficbdistrito').html("<option value='0'>" + msgf + "</option>");
                }
            });
        }
        return false;
    }

    $('#btn_updsede').click(function(event) {
        $('#frm_updatesede input,select').removeClass('is-invalid');
        $('#frm_updatesede .invalid-feedback').remove();
        $('#divmodsede').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
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
                            filtro_sedes('');
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

    $(document).on("click", ".deletesede", function(){
        var idsede = $(this).attr("idsede");
        var sede=$(this).closest('.rowcolor').data('sede');
        Swal.fire({
            title: '¿Está seguro de eliminar la sede '+sede+'?',
            text: "¡Si no lo está puede cancelar la acción!",
            type: 'warning',
            icon: 'warning',
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar sede!'
        }).then(function(result){
            if(result.value){
                $('#divcard_sede').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                var datos = new FormData();
                datos.append("idsede", idsede);
                
                $.ajax({
                    url: base_url + "sede/fneliminar_sede",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
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

                                    filtro_sedes('');

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
    });

    function filtro_sedes(nomsede) {
        $('#divcard_sede').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'sede/search_sede',
            type: 'post',
            dataType: 'json',
            data: {nomsede : nomsede},
            success: function(e) {
                if (e.status == true) {
                    $('#divcard_data_sedes').html("");
                    var nro=0;
                    var tabla="";
                    var activo = "";
                    var codbase64 = "";
                    if (e.datos.length !== 0) {
                        $('#fmt_conteo').html('');
                        $.each(e.datos, function(index, val) {
                            nro++;
                            codbase64 = 'viewupdatsede("'+val['codigo64']+'")';

                            if (val['activo']==="SI"){
                                activo = "<span class='badge bg-success p-2'> ACTIVO </span>";
                            } else {
                                activo = "<span class='badge bg-danger p-2'> INACTIVO </span>";
                            }


                            tabla=tabla + 
                                "<div class='row rowcolor cfila' data-sede='"+val['nombre']+"'>"+
                                    "<div class='col-12 col-md-4'>"+
                                        "<div class='row'>"+
                                            "<div class='col-2 col-md-2 text-right td'>"+nro+"</div>"+
                                            "<div class='col-5 col-md-5 td'>"+val['nombre']+"</div>"+
                                            "<div class='col-5 col-md-5 td text-center '>"+val['nomdist']+"</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-12 col-md-5'>"+
                                        "<div class='row'>"+
                                            "<div class='col-4 col-md-3 td'>"+activo+"</div>"+
                                            "<div class='col-8 col-md-9 td'>"+val['nombres']+"</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-12 col-md-3 text-center'>"+
                                        "<div class='row'>"+
                                            "<div class='col-9 col-sm-6 col-md-6 td'>"+
                                                "<span>"+val['local']+"</span>"+
                                            "</div>"+
                                            "<div class='col-3 col-sm-6 col-md-6 td'>"+
                                                "<div class='col-12 pt-1 pr-3 text-center'>"+
                                                    "<div class='btn-group'>"+
                                                        "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                            "<i class='fas fa-cog'></i>"+
                                                        "</a>"+
                                                        "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                            "<a class='dropdown-item' href='#' title='Editar' onclick='"+codbase64+"'>"+
                                                                "<i class='fas fa-edit mr-2'></i> Editar"+
                                                            "</a>"+
                                                                "<a class='dropdown-item text-danger deletesede' href='#' title='Eliminar' idsede='"+val['codigo64']+"'>"+
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

                    $('#divcard_data_sedes').html(tabla);
                    
                } else {
                    
                    var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#divcard_data_sedes').html(msgf);
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