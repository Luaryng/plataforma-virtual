<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>Consultar boleta de notas</h1>
        </div>
      </div>
    </div>
  </section>
  <section id="s-cargado" class="content">
    <div id="divcard-matricular" class="card">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link active" href="#busqueda" data-toggle="tab">
              <b><i class="fas fa-usermr-1"></i> Búsqueda</b>
            </a>
          </li>
        </ul>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="busqueda">
            <div class="row-fluid">
              <form id="frmfiltro-matriculas" name="frmfiltro-matriculas" action="<?php echo $vbaseurl ?>matricula/fn_filtrar_cur_ad" method="post" accept-charset='utf-8'>
                <div class="row">
                  <div class="form-group has-float-label col-12 col-sm-2">
                    <select data-currentvalue='' class="form-control" id="fmt-cbperiodo" name="fmt-cbperiodo" placeholder="Periodo">
                      <option value="%"></option>
                      <?php foreach ($periodos as $periodo) {?>
                      <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fmt-cbperiodo"> Periodo</label>
                  </div>
                  
                  <div class="form-group has-float-label col-12 col-sm-3">
                    <select data-currentvalue='' class="form-control" id="fmt-cbcarrera" name="fmt-cbcarrera" placeholder="Programa Académico" >
                      <option value="%"></option>
                      <?php foreach ($carreras as $carrera) {?>
                      <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fmt-cbcarrera"> Programa Académico</label>
                  </div>
                  <div class="form-group has-float-label col-12 col-sm-3">
                    <select data-currentvalue='' class="form-control" id="fmt-cbciclo" name="fmt-cbciclo" placeholder="Ciclo" >
                      <option value="%"></option>
                      <?php foreach ($ciclos as $ciclo) {?>
                      <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fmt-cbciclo"> Ciclo</label>
                  </div>
                  <div class="form-group has-float-label col-12 col-sm-2">
                    <select data-currentvalue='' class="form-control" id="fmt-cbturno" name="fmt-cbturno" placeholder="Turno" >
                      <option value="%"></option>
                      <?php foreach ($turnos as $turno) {?>
                      <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fmt-cbturno"> Turno</label>
                  </div>
                  <div class="form-group has-float-label col-12 col-sm-2">
                    <select data-currentvalue='' class="form-control" id="fmt-cbseccion" name="fmt-cbseccion" placeholder="Sección" >
                      <option value="%"></option>
                      <?php foreach ($secciones as $seccion) {?>
                      <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fmt-cbseccion"> Sección</label>
                  </div>
                  <div class="form-group has-float-label col-12 col-xs-12 col-sm-11">
                    <input class="form-control text-uppercase" autocomplete="off" id="fmt-alumno" name="fmt-alumno" placeholder="Carné o Apellidos y nombres" >
                    <label for="fmt-alumno"> Carné o Apellidos y nombres
                    </label>
                  </div>
                  <div class="col-12  col-sm-1">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-122 col-md-12 text-primary text-right">
              <form target="_blank" id="frmimprimirsel" method="POST" action="<?php echo base_url()?>academico/matricula/independiente/boletas/imprimir">
                <input type="hidden" name="txtmatris" id="txtmatris" value=''>
              </form>
              <button type="button" id="btn-imprimir-sel" class="btn btn-sm btn-info" href=" ?>" title="Imprimir boleta"><i class="fas fa-list-ol"></i> Imprimir seleccionadas</button>
            </div>
            <small id="fmt-conteo" class="form-text text-primary">
            
            </small>
            
            <div class="col-12 px-0 pt-2">
              <div class="btable">
                <div class="thead col-12">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="row">
                        <div class="col-md-4 td">
                          <div class="form-check">
                            <input type="checkbox" id="check-sel-all" class="form-check-input" >
                            <label class="form-check-label" > N°</label>
                          </div>
                        </div>
                        <div class="col-md-8 td">CARNÉ</div>
                        
                      </div>
                    </div>
                    <div class="col-md-3 td">ALUMNO</div>
                    <div class="col-md-3">
                      <div class="row">
                        <div class="col-md-3 td">PLAN</div>
                        <div class="col-md-3 td">PER.</div>
                        <div class="col-md-6 td">PROG. ACAD.</div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="row">
                        <div class="col-md-3 td">CUR.</div>
                        <div class="col-md-3 td">APR.</div>
                        <div class="col-md-3 td">DSP.</div>
                        <div class="col-md-3 td">DPI.</div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="row">
                        <div class="col-md-4 td">EST.</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="div-filtro" class="tbody col-12">
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>
<script>
$("#frmfiltro-matriculas").submit(function(event) {
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#div-filtro").html("");
    $('#check-sel-all').prop('checked', false);
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            if (e.status == false) {} else {
                var nro = 0;
                var mt = 0;
                var ac = 0;
                var rt = 0;
                var cl = 0;
                $.each(e.vdata, function(index, v) {
                    /* iterate through array or object */
                    nro++;
                    mt = mt + parseInt(v['mat']);
                    ac = ac + parseInt(v['act']);
                    rt = rt + parseInt(v['ret']);
                    cl = cl + parseInt(v['cul']);
                    var vcm = base64url_encode(v['codigo']);
                    var url = base_url + "academico/matricula/imprimir/" + vcm;
                    var urlbol = base_url + "academico/matricula/independiente/boleta/imprimir/" + vcm;
                    var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
                    $("#div-filtro").append(
                        '<div class="cfila row ' + rowcolor + ' ">' +
                        '<div class="col-4 col-md-2">' +
                        '<div class="row">' +
                        '<div class="col-3 col-md-3 td">' +
                          '<div class="form-check">' +
                            '<input type="checkbox" class="form-check-input check-sel" value="' + v['codigo'] + '">'+
                            '<label class="form-check-label" >' + nro + '</label>' +
                          '</div>'+
                         '</div>' +
                        '<div class="ccarne col-9 col-md-9 td">' + v['carne'] + '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="calumno col-8 col-md-3 td">' + v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + '</div>' +
                        '<div class="col-6 col-md-3">' +
                        '<div class="row">' +
                          '<div class="col-2 col-md-3 td text-center">' + v['codplan'] + '</div>' +
                          '<div data-cp="' + v['codperiodo'] + '" class="cperiodo col-2 col-md-3 td">' + v['periodo'] + '</div>' +
                          '<div class="ccarrera col-2 col-md-6 td" data-cod="' + v['codcarrera'] + '">' + v['sigla'] + ' - <b>' + v['ciclo'] + '</b> -' + v['codturno'] + ' - ' + v['codseccion']  + '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-6 col-md-2">' +
                        '<div class="row">' +
                        '<div class="td col-2 col-md-3 text-center text-primary">' + v['cursos'] + '</div>' +
                        '<div class="td col-2 col-md-3 text-center text-success">' + v['APR'] + '</div>' +
                        '<div class="td col-2 col-md-3 text-center text-warning">' + v['DES'] + '</div>' +
                        '<div class="td col-2 col-md-3 text-center text-danger">' + v['DPI'] + '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-6 col-md-2">' +
                          '<div class="row">' +
                            '<div class="td col-2 col-md-4 text-bold">' + v['estado'] + '.</div>' +
                            '<div class="td col-2 col-md-4 text-primary text-bold"><a class="bg-info text-white py-1 px-2 mt-2 rounded" target="_blank" href="' + url + '" title="Imprimir ficha"><i class="fas fa-address-card"></i></a></div>' +
                            '<div class="td col-2 col-md-4 text-primary text-bold"><a class="bg-info text-white py-1 px-2 mt-2 rounded" target="_blank" href="' + urlbol + '" title="Imprimir boleta"><i class="fas fa-list-ol"></i></a></div>' +
                          '</div>' +
                        '</div>' +
                        '</div>');
                });
                //onclick="' + "llamarCursos('" + vcm + "')" + '"
                $("#fmt-conteo").html(nro + ' matriculas encontradas');
                $('#divcard-matricular #divoverlay').remove();
                //********************************************/
                $(".btncall-carga").on("click", function() {
                    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                    $('.nav-pills a[href="#fichacarga"]').tab('show');
                    vcm = $(this).data('cm');
                    $("#vwtxtcodmat").val(vcm);
                    $("#divcarne").html("<h3>" + $(this).parents(".cfila").find('.ccarne').html() + "</h3>");
                    $("#divmiembro").html($(this).parents(".cfila").find('.calumno').html());

                    $("#divperiodo").html($(this).parents(".cfila").find('.cperiodo').html());
                    $("#divcarrera").html($(this).parents(".cfila").find('.ccarrera').html());
                    $("#divciclo").html("Ciclo: " + $(this).parents(".cfila").find('.cciclo').html());
                    $("#divturno").html("Turno: " + $(this).parents(".cfila").find('.cturno').html());
                    $("#divseccion").html("Sección: " + $(this).parents(".cfila").find('.cseccion').html());
                    $("#fud-cbperiodo").html($(this).parents(".cfila").find('.cperiodo').html());
                    $("#fud-cbperiodo").data('cp', $(this).parents(".cfila").find('.cperiodo').data('cp'));
                    //$("#fud-cbcarrera").text();
                    //alert($(this).parents(".cfila").find('.ccarrera').data('cod'));
                    $("#fud-cbcarrera").val($(this).parents(".cfila").find('.ccarrera').data('cod'));
                    $("#fud-cbcarrera").change();
                    $("#fud-cbciclo").val($(this).parents(".cfila").find('.cciclo').data('cod'));
                    //$("#fud-cbciclo").val(getUrlParameter("ccc",0));
                    ;
                    $("#fud-cbturno").val($(this).parents(".cfila").find('.cturno').html());
                    $("#fud-cbseccion").val($(this).parents(".cfila").find('.cseccion').html());
                    $.ajax({
                        url: base_url + "matricula/fn_cursos_x_matricula",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            codmatricula: vcm
                        },
                        success: function(e) {
                            $('#divcard-matricular #divoverlay').remove();
                            if (e.status == true) {
                                var url = base_url + "academico/matricula/imprimir/" + vcm;
                                mostrarCursos("div-cursosmat", vcm, e.vdata);
                                $("#div-cursosmat").append(
                                    '<div class="cfilaprint row">' +
                                    '<div class="col-12 col-md-12 text-right td"><a class="btn btn-info" target="_blank" href="' + url + '" title="Imprimir matrícula"><i class="fas fa-print mr-1"></i> Imprimir Matrícula</a></div>' +
                                    '</div></div>');
                            }
                        },
                        error: function(jqXHR, exception) {
                            var msgf = errorAjax(jqXHR, exception, 'text');
                            $('#divcard-matricular #divoverlay').remove();
                            Swal.fire({
                                type: 'error',
                                title: 'Error, no se pudo mostrar los curso Matriculados',
                                text: msgf,
                                backdrop: false,
                            })
                        }
                    });
                });
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
//$("#frm-matricular").hide();
$("#frm-getinscrito").submit(function(event) {
    $('#frm-getinscrito input').removeClass('is-invalid');
    $('#frm-getinscrito .invalid-feedback').remove();
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divcard-matricular #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                $('#fm-txtid').val(e.vdata['idinscripcion']);
                $("#frm-matricular")[0].reset();
                if (e.vdata['idinscripcion'] == '0') {
                    $('#fgi-apellidos').html('NO ENCONTRADO');
                    $('#fgi-nombres').html('NO ENCONTRADO');
                    $('#fm-txtcarrera').val("");
                    $('#fm-carrera').val("PROGRAMA ACADÉMICO");
                    $('#fm-cbplan').html("<option value='0'>Plán curricular NO DISPONIBLE</option>");
                    //$("#frm-matricular").hide();
                } else {
                    //$('#fitxtdni').val(e.vdata['dni']);
                    $('#fgi-apellidos').html(e.vdata['paterno'] + ' ' + e.vdata['materno']);
                    $('#fgi-nombres').html(e.vdata['nombres']);
                    $('#fm-txtcarrera').val(e.vdata['codcarrera']);
                    $('#fm-carrera').html(e.vdata['carrera']);
                    $('#fm-cbplan').html(e.vplanes);
                    $('#fm-cbplan').val(e.vdata['codplan']);
                    $('#fm-txtplan').val(e.vdata['codplan']);
                    //$("#frm-matricular").show();
                }
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard-matricular #divoverlay').remove();
            $('#divError').show();
            $('#msgError').html(msgf);
        }
    });
    return false;
});
/*$("#btn-cancelar").click(function(event) {
   
    $("#frm-matricular")[0].reset();
});*/

/*$("#fud-cbcarrera").change(function(event) {
    
    if ($(this).val() != "%") {
        $('#fud-cbplan').html("<option value='%'>Sin opciones</option>");
        var codcar = $(this).val();
        if (codcar == '%') return;
        $.ajax({
            url: base_url + 'plancurricular/fn_get_planes_activos_combo',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodcarrera: codcar
            },
            success: function(e) {
                $('#fud-cbplan').html(e.vdata);
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#fud-cbplan').html("<option value='%'>" + msgf + "</option>");
            }
        });
    } else {
        $('#fud-cbplan').html("<option value='%'>Seleciona un carrera<option>");
    }
});*/
$("#check-sel-all").change(function(event) {
  $('.check-sel').prop('checked', $("#check-sel-all").prop('checked'));
});
$("#btn-imprimir-sel").click(function(event) {
  /* Act on the event */
  var ids = [];
  $("#txtmatris").val('');
  $('.check-sel:checked').each(function() {
     ids.push(this.value); 
  });
  $("#txtmatris").val(ids.join());
  if($("#txtmatris").val()==""){
    Swal.fire({
        type: 'warning',
        title: 'Aviso: Debes seleccionar las boletas a imprimir'
    });
  }
  else{
    $("#frmimprimirsel").submit();
  }
  return false;
});

$(document).ready(function() {
    $("#fmt-cbperiodo").val(getUrlParameter("cp", '%'));
    $("#fmt-cbcarrera").val(getUrlParameter("cc", '%'));
    $("#fmt-cbcarrera").change();
    $("#fmt-cbciclo").val(getUrlParameter("ccc", '%'));
    $("#fmt-cbturno").val(getUrlParameter("ct", '%'));
    $("#fmt-cbseccion").val(getUrlParameter("cs", '%'));
    if (getUrlParameter("at", 0) == 1) $("#frmfiltro-matriculas").submit();
});
</script>