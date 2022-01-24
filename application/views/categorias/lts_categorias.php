<style>
  .form-neo{
    padding: 25px 15px 15px 15px;
    margin: 5px 5px 15px 5px;
    border-radius: 5px;
    background-color:white;
    -webkit-box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.5);
    -moz-box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.5);
    box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.5);
  }
</style>
<?php
	$vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">
    <div class="modal fade" id="modupcategoria" aria-modal="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" id="divmodcategoria">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Categoría</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="msgcuerpo">
                    <form id="frm_updacategoria" action="<?php echo $vbaseurl ?>categoria_transparencia/fn_insert_update" method="post" accept-charset='utf-8'>
                            <b class="text-danger"><i class="fas fa-globe"></i> Categoría</b>
                            <div class="row mt-3">
                                <input id="fictxtcodigo" name="fictxtcodigo" type="hidden" value="" />
                                <input type="hidden" name="fictxtaccion" id="fictxtaccion" value="EDITAR">
                                <div class="form-group has-float-label col-12 col-sm-12">
                                    <input data-currentvalue='' class="form-control" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre Categoría" />
                                    <label for="fictxtnombre">Nombre Categoría</label>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="form-group col-6 col-md-6">
                                    <label for="checkestado">Activo:</label>
                                    <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                </div>
                                <div class="form-group has-float-label col-6 col-sm-6">
                                    <input data-currentvalue='' class="form-control" id="fictxtorden" name="fictxtorden" type="text" placeholder="Orden" value="" />
                                    <label for="fictxtorden">Orden</label>
                                </div>
                                <div class="form-group has-float-label col-12">
                                    <select name="cbofictipo" id="cbofictipo" class="form-control">
                                        <option value="TP">TRANSPARENCIA</option>
                                        <option value="PI">PROYECTOS DE INVESTIGACIÓN</option>
                                        <option value="LR">LECTURAS RECOMENDADAS</option>
                                    </select>
                                    <label for="cbofictipo">Area</label>
                                </div>
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div id="divmsgcategup" class="float-left">

                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn_updcategoria">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <section id="s-cargado" class="content pt-2">
        <div id="divcard_categoria" class="card bg-light text-dark">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#search-categoria" data-toggle="tab"><b><i class="fas fa-list mr-1"></i>Datos</b></a></li>
                    <li class="nav-item"><a class="nav-link" href="#registrar-categoria" data-toggle="tab"><b><i class="fas fa-user-plus mr-1"></i>Registrar</b></a></li>
                </ul>
            </div>
            <div class="card-body p-2">
                <div class="tab-content">
                    <div class="tab-pane" id="registrar-categoria">
                        <div class="alert alert-dark alert-dismissible fade show bordered">
                            <strong>Aviso:</strong> Antes de ingresar los datos, verifica si la CATEGORÍA no ha sido registrada anteriormente
                            <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
                        </div>
                        <form class="form-neo" id="frm_addcategoria" action="<?php echo $vbaseurl ?>categoria_transparencia/fn_insert_update" method="post" accept-charset='utf-8'>
                            <b class="text-danger"><i class="fas fa-globe"></i> Categoría</b>
                            <div class="row mt-3">
                                <input type="hidden" name="fictxtaccion" id="fictxtaccion" value="INSERTAR">
                                <div class="form-group has-float-label col-12 col-sm-12">
                                    <input data-currentvalue='' class="form-control" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre Categoría" />
                                    <label for="fictxtnombre">Nombre Categoría</label>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="form-group col-6 col-md-3">
                                    <label for="checkestado" class="mr-3">Activo:</label>
                                    <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                </div>
                                <div class="form-group has-float-label col-6 col-sm-4">
                                    <input data-currentvalue='' class="form-control" id="fictxtorden" name="fictxtorden" type="text" placeholder="Orden" value="" />
                                    <label for="fictxtorden">Orden</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-sm-5">
                                    <select name="cbofictipo" id="cbofictipo" class="form-control">
                                        <option value="TP">TRANSPARENCIA</option>
                                        <option value="PI">PROYECTOS DE INVESTIGACIÓN</option>
                                        <option value="LR">LECTURAS RECOMENDADAS</option>
                                    </select>
                                    <label for="cbofictipo">Area</label>
                                </div>
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-6">
                                    <div id="divmsgcateg" class="float-left">

                                    </div>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-md float-right" id="btn_add_categ"><i class="fas fa-save"></i> Registrar</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="active tab-pane" id="search-categoria">
                        <div id="divtabl-categoria" class="form-neo neo-table">
                            <div class="col-md-12 header d-none d-md-block">
                                <div class="row">
                                    <div class="col-sm-1 col-md-1 cell hidden-xs"><b>N°</b></div>
                                    <div class="col-sm-7 col-md-5 cell"><b>NOMBRE</b></div>
                                    <div class="col-sm-7 col-md-2 cell"><b>AREA</b></div>
                                    <div class="col-sm-1 col-md-1 cell"><b>ACTIVO</b></div>
                                    <div class="col-sm-1 col-md-1 cell"><b>ORDEN</b></div>
                                    <div class="col-sm-2 col-md-2 cell text-center"></div>
                                </div>
                            </div>
                            <div class="col-md-12 body">
                            <?php
                                $nro = 0;
                                foreach ($categorias as $cat) {
                                    $nro ++;
                                    if ($cat->activo == 'SI') {

                                        $activo = "<span class='badge bg-success p-2'> ACTIVO </span>";

                                    } else {

                                        $activo = "<span class='badge bg-danger p-2'> INACTIVO </span>";

                                    }

                                    if ($cat->area == 'TP') {
                                        $areas = "TRANSPARENCIA";
                                    } else if ($cat->area == 'PI') {
                                        $areas = "PROYECTOS DE INVESTIGACIÓN";
                                    } else {
                                        $areas = "LECTURAS RECOMENDADAS";
                                    }

                            ?>
                                <div class="row cfila <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
                                    <div class="col-12 col-md-6 group">
                                        <div class="col-2 col-md-2 cell">
                                            <span><?php echo $nro ;?></span>
                                        </div>
                                        <div class="col-10 col-md-10 cell">
                                            <span><?php echo $cat->nombre ;?></span>
                                        </div>
                                        
                                    </div>
                                    <div class="col-12 col-md-2 group">
                                        <div class="col-12 col-md-12 cell">
                                            <span><?php echo $areas ;?></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 group">
                                        <div class='col-6 col-md-6 cell text-center'>
                                            <?php echo $activo ?>
                                        </div>
                                        <div class='col-6 col-md-6 cell text-center'>
                                            <span><?php echo $cat->orden ;?></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 group">
                                        <div class='col-6 col-md-6 cell text-center'>
                                            <a type="button" onclick="viewupdatcateg('<?php echo base64url_encode($cat->codigo) ?>')" class='btn btn-info btn-sm px-3'>
                                                <i class='fas fa-pencil-alt text-white'></i>
                                                <span class="d-block d-md-none text-white">Editar </span>
                                            </a>
                                        </div>
                                        <div class='col-6 col-md-6 cell text-center'>
                                            <button class='btn btn-danger btn-sm deletecategoria px-3' idcategoria="<?php echo base64url_encode($cat->codigo) ?>">
                                                <i class='fas fa-trash-alt'></i>
                                                <span class="d-block d-md-none">Eliminar </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                } 
                            ?>
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
    $('#frm_addcategoria').submit(function(event) {
        $('#frm_addcategoria input,select').removeClass('is-invalid');
        $('#frm_addcategoria .invalid-feedback').remove();
        $('#divcard_categoria').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $(this).attr("action"),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(e) {
                $('#divcard_categoria #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#frm_addcategoria #' + key).addClass('is-invalid');
                        $('#frm_addcategoria #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {

                    var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                    $('#divmsgcateg').html(msgf);
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                      if (result.value) {
                        location.reload();
                      }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divcard_categoria #divoverlay').remove();
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

    function viewupdatcateg(codigo) {
        $('#divcard_categoria').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#divrstcategoria").html("");
        $.ajax({
            url: base_url + "categoria_transparencia/vwmostrar_categoriaxcodigo",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo},
            success: function(e) {
                $('#divcard_categoria #divoverlay').remove();

                $("#modupcategoria").modal("show");

                $("#modupcategoria #fictxtcodigo").val(e.categup['codigo']);

                $("#modupcategoria #fictxtnombre").val(e.categup['nombre']);

                if (e.categup['activo'] == 'SI') {
                    $("#modupcategoria #checkestado").bootstrapToggle('on');
                    
                } else {
                    $("#modupcategoria #checkestado").bootstrapToggle('off');
                }

                $('#modupcategoria #fictxtorden').val(e.categup['orden']);

                $('#modupcategoria #cbofictipo').val(e.categup['area']);

            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_categoria #divoverlay').remove();
                $("#modupcategoria modal-body").html(msgf);
            } 
        });
        return false;
    }

    $('#btn_updcategoria').click(function(event) {
        $('#frm_updacategoria input,select').removeClass('is-invalid');
        $('#frm_updacategoria .invalid-feedback').remove();
        $('#divmodcategoria').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_updacategoria').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_updacategoria').serialize(),
            success: function(e) {
                $('#divmodcategoria #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#modupcategoria #' + key).addClass('is-invalid');
                        $('#modupcategoria #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modupcategoria').modal('hide');
                    var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                    $('#divmsgcategup').html(msgf);
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                      if (result.value) {
                        location.reload();
                      }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodcategoria #divoverlay').remove();
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

    $(document).on("click", ".deletecategoria", function(){
        var idcategoria = $(this).attr("idcategoria");
                
        Swal.fire({
            title: '¿Está seguro de eliminar esta Categoría?',
            text: "¡Si no lo está puede cancelar la acción!",
            type: 'warning',
            icon: 'warning',
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar Categoría!'
        }).then(function(result){
            if(result.value){
                $('#divcard_categoria').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                var datos = new FormData();
                datos.append("idcategoria", idcategoria);
                
                $.ajax({
                    url: base_url + "categoria_transparencia/fneliminar_categoria",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(e){
                        $('#divcard_categoria #divoverlay').remove();
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

                                  location.reload();

                                }
                            })
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msgf = errorAjax(jqXHR, exception,'text');
                        $('#divcard_categoria #divoverlay').remove();
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