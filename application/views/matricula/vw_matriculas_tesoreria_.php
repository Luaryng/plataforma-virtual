<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">
<?php echo
    "<script src='{$vbaseurl}resources/plugins/simpleUpload/simpleUpload.min.js'></script>"; ?>
<style type="text/css">
  #vw_mpc_pgBar {
    background-color: #3E6FAD;
    width: 0px;
    height: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    -o-border-radius: 5px;
    border-radius: 5px;
    -moz-transition: .25s ease-out;
    -webkit-transition: .25s ease-out;
    -o-transition: .25s ease-out;
    transition: .25s ease-out;
  }
  
</style>
<div class="content-wrapper">
  <div class="modal fade" id="modupfilebloq" tabindex="-1" role="dialog" aria-labelledby="modupfilebloq" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="divmodaladd">
            <div class="modal-header">
                <h5 class="modal-title" id="titlearea"><i class="far fa-check-circle text-success"></i> Se ha subido con éxito el archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>¿ESTA SEGURO DE SUBIR Y BLOQUEAR LAS EVALUACIONES QUE ESTAN EN EL ARCHIVO SUBIDO?</h5>
                <input type="hidden" name="vw_mpc_link" id="vw_mpc_link" value="">
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> -->
                <button type="button" id="vw_mpc_btn_validar" class="btn btn-primary">Subir</button>
            </div>
        </div>
    </div>
  </div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>Matriculados</h1>
        </div>
      </div>
    </div>
  </section>
  <section id="s-cargado" class="content">
    <div id="divcard-matricular" class="card">
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="busqueda">
            <div class="row-fluid">
              <form id="frmfiltro-matriculas" name="frmfiltro-matriculas" action="<?php echo $vbaseurl ?>tesoreria_matricula/fn_filtrar" method="post" accept-charset='utf-8'>
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
                  
                  <div class="form-group has-float-label col-12 col-sm-6 col-md-3">
                    <select data-currentvalue='' class="form-control" id="fmt-cbcarrera" name="fmt-cbcarrera" placeholder="Programa Académico" >
                      <option value="%"></option>
                      <?php foreach ($carreras as $carrera) {?>
                      <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fmt-cbcarrera"> Prog. de Estudios</label>
                  </div>

                  <div class="form-group has-float-label col-12 col-sm-6 col-md-3">
                    <select name="fmt-cbplan" id="fmt-cbplan"class="form-control">
                      <option data-carrera="0" value="%"></option>
                      <?php foreach ($planes as $pln) {
                        echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
                      } ?>
                    </select>
                    <label for="fmt-cbplan">Plan estudios</label>
                  </div>

                  <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                    <select data-currentvalue='' class="form-control" id="fmt-cbciclo" name="fmt-cbciclo" placeholder="Ciclo" >
                      <option value="%"></option>
                      <?php foreach ($ciclos as $ciclo) {?>
                      <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fmt-cbciclo"> Ciclo</label>
                  </div>
                  <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                    <select data-currentvalue='' class="form-control" id="fmt-cbturno" name="fmt-cbturno" placeholder="Turno" >
                      <option value="%"></option>
                      <?php foreach ($turnos as $turno) {?>
                      <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fmt-cbturno"> Turno</label>
                  </div>
                  <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                    <select data-currentvalue='' class="form-control" id="fmt-cbseccion" name="fmt-cbseccion" placeholder="Sección" >
                      <option value="%"></option>
                      <?php foreach ($secciones as $seccion) {?>
                      <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fmt-cbseccion"> Sección</label>
                  </div>
                  <div class="form-group has-float-label col-12 col-sm-7 col-md-9">
                    <input class="form-control text-uppercase" autocomplete="off" id="fmt-alumno" name="fmt-alumno" placeholder="Carné o Apellidos y nombres" >
                    <label for="fmt-alumno"> Carné o Apellidos y nombres
                    </label>
                  </div>
                  <div class="col-6 col-sm-2 col-md-1">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                  </div>
                  <div class="col-6 col-sm-3 col-md-2">
                    <?php if (getPermitido("127")=='SI'){ ?>
                    <a href="#" class="btn btn-outline-secondary" id="vw_mpc_btn_selecionar"><img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt=""> Cargar</a>
                    <input type="file" class="form-control" name="vw_mpc_file" id="vw_mpc_file">
                    <?php } ?>
                  </div>

                </div>
                <div class="row">
                  <div class="col-12">
                    <div id="vw_mpc_txt_progress"></div>
                    <div id="vw_mpc_txt_size"></div>
                    <div id="vw_mpc_txt_type"></div>
                    <div id="vw_mpc_pgBar"></div>
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
                    <div class="col-md-2">
                      <div class="row">
                        <div class="col-md-4 td">PER.</div>
                        <div class="col-md-4 td">PLAN</div>
                        <div class="col-md-4 td">PROG.</div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="row">
                        <div class="col-md-4 td">CIC.</div>
                        <div class="col-md-4 td">TUR.</div>
                        <div class="col-md-4 td">SEC.</div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="row">
                        <div class="col-md-5 td">EST.</div>
                        <div class="col-md-7 td text-center">DEUDA</div>
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="row">
                        <div class="col-md-12 td text-center">
                          <div class="form-check">
                            <input class="form-check-input allcheck" type="checkbox">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="div-filtro" class="tbody col-12">
                  
                </div>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-12">
                <span id="fispedit" class="text-danger"></span>
              </div>
              <div class="col-12" id="divbtn_bloquear">
                <?php if (getPermitido("127")=='SI'){ ?>
                  <button type="button" class="btn btn-primary float-right" id="btn_bloqueanotas"> Bloquear</button>
                <?php } ?>
              </div>
            </div>
            <!--</div>-->
          </div>
        </div>
        <!-- /.tab-content -->
      </div>
    <!-- /.card-body -->
    </div>
  </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>
<script>

$(document).ready(function() {

    $('.allcheck').prop('disabled',true);

    $("#vw_mpc_file").hide();
    $("#vw_mpc_txt_size").hide();
    $("#vw_mpc_txt_type").hide();
    $('#divbtn_bloquear').hide();
    // $('#vw_mpc_btn_validar').hide();

    $("#fmt-cbperiodo").val(getUrlParameter("cp", '%'));
    $("#fmt-cbcarrera").val(getUrlParameter("cc", '%'));
    
    $("#fmt-cbciclo").val(getUrlParameter("ccc", '%'));
    $("#fmt-cbturno").val(getUrlParameter("ct", '%'));
    $("#fmt-cbseccion").val(getUrlParameter("cs", '%'));
    $("#fmt-cbplan").val(getUrlParameter("cpl", '%'));
    
    if (getUrlParameter("at", 0) == 1) $("#frmfiltro-matriculas").submit();
});

$('#frmfiltro-matriculas #fmt-cbcarrera').change(function(event) {
    var codcar = $(this).val();
    if (codcar=="%"){
      $("#frmfiltro-matriculas #fmt-cbplan option").each(function(i){
          if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');           
      });
    }
    else{
      $("#frmfiltro-matriculas #fmt-cbplan option").each(function(i){
    
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


$("#frmfiltro-matriculas").submit(function(event) {
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#div-filtro").html("");
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            if (e.status == false) {} else {
                var nro = 0;
                $.each(e.vdata, function(index, v) {
                    /* iterate through array or object */
                    nro++;
                    var bloqueo = "";
                    var dataedit = "";
                    var vcm = base64url_encode(v['codigo']);
                    var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
                    var btnscolor="";
                    switch(v['estado']) {
                      case "ACT":
                          btnscolor="btn-success";
                        break;
                      case "CUL":
                        btnscolor="btn-secondary";
                        break;
                      case "RET":
                        btnscolor="btn-danger";
                        break;
                      default:
                        btnscolor="btn-warning";
                    }

                    if (v['bloqueo'] == "SI") {
                      bloqueo = "checked";
                      dataedit = "1";
                    } else {
                      bloqueo = "";
                      dataedit = "0";
                    }

                    $("#div-filtro").append(
                        '<div data-idm="' + vcm + '" class="cfila row ' + rowcolor + ' ">' +
                          '<div class="col-4 col-md-2">' +
                            '<div class="row">' +
                              '<div class="col-3 col-md-3 td">' + nro + '</div>' +
                              '<div class="ccarne col-9 col-md-9 td">' + v['carne'] + '</div>' +
                            '</div>' +
                          '</div>' +
                          '<div class="calumno col-8 col-md-3 td">' + v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + '</div>' +
                          '<div class="col-6 col-md-2">' +
                            '<div class="row">' +
                              '<div data-cp="' + v['codperiodo'] + '" class="cperiodo col-2 col-md-4 td">' + v['periodo'] + '</div>' +
                              '<div class="col-2 col-md-4 td text-center">' + v['codplan'] + '</div>' +
                              '<div class="ccarrera col-2 col-md-4 td" data-cod="' + v['codcarrera'] + '">' + v['sigla'] + '</div>' +
                            '</div>' +
                          '</div>' +
                          '<div class="col-6 col-md-2">' +
                            '<div class="row">' +
                              '<div class="cciclo td col-2 col-md-4 text-center " data-cod="' + v['codciclo'] + '">' + v['ciclo'] + '</div>' +
                              '<div class="cturno td col-2 col-md-4 text-center ">' + v['codturno'] + '</div>' +
                              '<div class="cseccion td col-2 col-md-4 text-center ">' + v['codseccion'] + '</div>' +
                            '</div>' +
                          '</div>' +
                          '<div class="col-6 col-md-2">' +
                            '<div class="row">' +
                              '<div class="td col-2 col-md-5 text-bold">' + 
                                '<button class="btn ' + btnscolor + ' btn-sm py-0" type="button">' +
                                  v['estado'] +
                                '</button>' +
                              '</div>' +

                              '<div class="td col-2 col-md-7 text-bold">' + 
                                
                              '</div>' +
                            '</div>' +
                          '</div>' +

                            '<div class="td col-2 col-md-1 text-center">'+
                              '<div class="form-check">'+
                                '<input '+bloqueo+' class="form-check-input blqcheckbox" type="checkbox" data-mat="'+vcm+'" data-edit="'+dataedit+'" data-ant="'+dataedit+'">'+
                              '</div>'+
                            '</div>' +
                          '</div>' +
                           
                        '</div>' +
                      '</div>');
                });
                $('.allcheck').prop('disabled',false);

                $('#divbtn_bloquear').show();
                
                $("#fmt-conteo").html(nro + ' matriculas encontradas');
                $('#divcard-matricular #divoverlay').remove();
                //********************************************/
                
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard-matricular #divoverlay').remove();
            //$('#divError').show();
            //$('#msgError').html(msgf);
        }
    });
    return false;
});

$('.allcheck').change(function(event) {
  if ($('.allcheck').prop('checked')) {
    $(".blqcheckbox").prop("checked", true);
    $(".blqcheckbox").data('edit', "1");
    $("#fispedit").html("* modificado");
  } else {
    $(".blqcheckbox").prop("checked", false);
    $(".blqcheckbox").data('edit', "0");
    $("#fispedit").html("");
  }
  
})

$(document).on('change', '.cfila div .blqcheckbox', function() {
  if ($(this).prop('checked')) {
    $(this).data('edit', "1");
  } else {
    $(this).data('edit', "0");
  }

  // if ($(this).data('edit') == $(this).data('ant')) {
  //   $("#fispedit").html("");
  // } else {
  //   $("#fispedit").html("* modificado");
  // }
  
})

$(document).on('click', '#btn_bloqueanotas', function() {
  arrdata = [];
  
  $('#div-filtro .cfila div .blqcheckbox').each(function() {
    var isedit = $(this).data("edit");
    var idmat = $(this).data("mat");
    var valor = "";

    if (isedit == "1") {
      valor = "SI";
      
    } else {
      valor = "NO";
    }

    var myvals = [idmat, valor];
    arrdata.push(myvals);
    
  })
  
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
      url: base_url + 'tesoreria_matricula/fn_update_bloqueo',
      type: 'post',
      dataType: 'json',
      data: {
          filas: JSON.stringify(arrdata),
      },
      success: function(e) {
          $('#divcard-matricular #divoverlay').remove();
          if (e.status == false) {
              Swal.fire({
                  type: 'error',
                  icon: 'error',
                  title: 'ERROR, NO se guardó cambios',
                  text: e.msg,
                  backdrop:false,
              });
          } else {
              
            Swal.fire({
                type: 'success',
                icon: 'success',
                title: 'ÉXITO, Se guardó cambios',
                text: "Lo cambios fueron guardados correctamente",
                backdrop:false,
            });

            $("#frmfiltro-matriculas").submit();
            $("#fispedit").html("");
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception,'text');
          $('#divcard-matricular #divoverlay').remove();
          Swal.fire({
              type: 'error',
              icon: 'error',
              title: 'ERROR, NO se guardó cambios',
              text: msgf,
              backdrop:false,
          });
      },
    })
  
});

$('#vw_mpc_btn_selecionar').click(function(event) {
  event.preventDefault();
  $("#vw_mpc_file").trigger('click');
});

var arrayarchivos = [];
$('#vw_mpc_file').change(function() {
    if (arrayarchivos.length >= 1) {
        Swal.fire({
            icon: 'error',
            title: 'Límite de 1 archivos',
            text: 'Solo se puede adjuntar como máximo 1 archivo',
            backdrop: false,
        });
        return;
    }
    $('#vw_mpc_txt_titulo').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#vw_mpc_file").simpleUpload(base_url + "tesoreria_matricula/uploadExcel", {
        allowedExts: ["xls", "xlsx"],
        maxFileSize: 10485760, //10MB in bytes
        start: function(file) {
            //upload started
            // $('#vw_mpc_txt_filename').html(file.name);
            $('#vw_mpc_txt_size').html(file.size);
            $('#vw_mpc_txt_type').html(file.type);
            $('#vw_mpc_txt_progress').html("");
            $('#vw_mpc_pgBar').width(0);
            $('#vw_mpc_txt_progress').show();
            $('#vw_mpc_pgBar').show();
        },
        progress: function(progress) {
            //received progress
            $('#vw_mpc_txt_progress').html("Progress: " + Math.round(progress) + "%");
            $('#vw_mpc_pgBar').width(progress + "%");
        },
        success: function(data) {
            //upload successful
            $('#vw_mpc_txt_progress').hide();
            $('#vw_mpc_pgBar').hide();
            //AGREGAR ARCVO A LA LISTA
            
            $('#divcard-matricular #divoverlay').remove();
            $('#modupfilebloq').modal('show');
            $('#vw_mpc_link').val(data.link);
            // $('#vw_mpc_btn_selecionar').hide();
            // $('#vw_mpc_btn_validar').show();
        },
        error: function(error) {
            //upload failed
            switch (error.name) {
                case 'InvalidFileExtensionError':
                    vmsg = "Este tipo de archivo no es admitido";
                    break;
                case 'MaxFileSizeError':
                    vmsg = "El peso máximo permitido es de 10MB";
                    break;
                default:
                    vmsg = error.message;
            }
            Swal.fire({
                icon: 'error',
                title: "Error! " + error.name,
                text: vmsg,
                backdrop: false,
            });

            $('#vw_mpc_txt_size').html("");
            $('#vw_mpc_txt_type').html("");
            $('#divcard-matricular #divoverlay').remove();
        }
    });
});

$('#vw_mpc_btn_validar').click(function() {
  var file = $('#vw_mpc_link').val();
  $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
      url: base_url + 'tesoreria_matricula/fn_update_datos_personales',
      type: 'post',
      dataType: 'json',
      data: {
          file: file,
      },
      success: function(e) {
          $('#divmodaladd #divoverlay').remove();
          if (e.status == false) {
              Swal.fire({
                  type: 'error',
                  icon: 'error',
                  title: 'ERROR, NO se guardó cambios',
                  text: e.msg,
                  backdrop:false,
              });
          } else {
              
            Swal.fire({
                type: 'success',
                icon: 'success',
                title: 'ÉXITO, Se guardó cambios',
                text: "Lo cambios fueron guardados correctamente",
                backdrop:false,
            });
            $('#modupfilebloq').modal('hide');
            // $("#frmfiltro-matriculas").submit();
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception,'text');
          $('#divmodaladd #divoverlay').remove();
          Swal.fire({
              type: 'error',
              icon: 'error',
              title: 'ERROR, NO se guardó cambios',
              text: msgf,
              backdrop:false,
          });
      },
    })
});

</script>