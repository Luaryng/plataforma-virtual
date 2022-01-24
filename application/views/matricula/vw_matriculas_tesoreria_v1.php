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

  .h7 {
    font-size: 0.8rem;
  }

  #div-filtro::-webkit-scrollbar, .divcardresult_data::-webkit-scrollbar {
    width: 4px;
    height: 4px;
  }

  #div-filtro::-webkit-scrollbar-track, .divcardresult_data::-webkit-scrollbar-track {
      /*box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.3);*/
      box-shadow: inset 0 0 2px rgb(0 0 0 / 12%);
      border-radius: 10px;
  }

  #div-filtro::-webkit-scrollbar-thumb, .divcardresult_data::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, .4);
      border-radius: 10px;
      box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.5);
  }

  @media screen and (max-width: 767px) {
      #div-filtro::-webkit-scrollbar, .divcardresult_data::-webkit-scrollbar {
          width: 4px;
          height: 6px;
      }
  }

  #div-filtro, .divcardresult_data {
      overflow-x: auto;
      overflow-y: auto;      
  }
  
</style>
<div class="content-wrapper">
  
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
        <div class="row-fluid">
          <form id="frmfiltro-matriculas" name="frmfiltro-matriculas" action="<?php echo $vbaseurl ?>matricula/fn_filtrar" method="post" accept-charset='utf-8'>
            <div class="row">
              <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                <select data-currentvalue='' class="form-control form-control-sm cbgrupo" id="fmt-cbperiodo" name="fmt-cbperiodo" placeholder="Periodo">
                  <option value="%"></option>
                  <?php foreach ($periodos as $periodo) {?>
                  <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                  <?php } ?>
                </select>
                <label for="fmt-cbperiodo"> Periodo</label>
              </div>
              
              <div class="form-group has-float-label col-12 col-sm-6 col-md-3">
                <select data-currentvalue='' class="form-control form-control-sm cbgrupo" id="fmt-cbcarrera" name="fmt-cbcarrera" placeholder="Programa Académico" >
                  <option value="%"></option>
                  <?php foreach ($carreras as $carrera) {?>
                  <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                  <?php } ?>
                </select>
                <label for="fmt-cbcarrera"> Prog. de Estudios</label>
              </div>

              <div class="form-group has-float-label col-12 col-sm-6 col-md-3">
                <select name="fmt-cbplan" id="fmt-cbplan"class="form-control form-control-sm cbgrupo">
                  <option data-carrera="0" value="%"></option>
                  <?php foreach ($planes as $pln) {
                    echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
                  } ?>
                </select>
                <label for="fmt-cbplan">Plan estudios</label>
              </div>

              <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                <select data-currentvalue='' class="form-control form-control-sm cbgrupo" id="fmt-cbciclo" name="fmt-cbciclo" placeholder="Ciclo" >
                  <option value="%"></option>
                  <?php foreach ($ciclos as $ciclo) {?>
                  <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                  <?php } ?>
                </select>
                <label for="fmt-cbciclo"> Ciclo</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                <select data-currentvalue='' class="form-control form-control-sm cbgrupo" id="fmt-cbturno" name="fmt-cbturno" placeholder="Turno" >
                  <option value="%"></option>
                  <?php foreach ($turnos as $turno) {?>
                  <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                  <?php } ?>
                </select>
                <label for="fmt-cbturno"> Turno</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                <select data-currentvalue='' class="form-control form-control-sm cbgrupo" id="fmt-cbseccion" name="fmt-cbseccion" placeholder="Sección" >
                  <option value="%"></option>
                  <?php foreach ($secciones as $seccion) {?>
                  <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                  <?php } ?>
                </select>
                <label for="fmt-cbseccion"> Sección</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-7 col-md-9">
                <input class="form-control form-control-sm text-uppercase" autocomplete="off" id="fmt-alumno" name="fmt-alumno" placeholder="Carné o Apellidos y nombres" >
                <label for="fmt-alumno"> Carné o Apellidos y nombres
                </label>
              </div>
              <div class="col-6 col-sm-2 col-md-1">
                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
              </div>

            </div>
          </form>
        </div>
        
        <div class="row">
          <div class="col-12 col-md-6 pl-2 pr-0" id="divcard_ltsmatriculas">
            
            <small id="fmt-conteo" class="form-text text-primary">
        
            </small>
            <div class="btable">
              <div class="thead col-12  d-none d-md-block">
                <div class="row">
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-3 td">N°</div>
                      <div class="col-md-9 td">CARNÉ</div>
                    </div>
                  </div>
                  <div class="col-md-2 td">GRUPO</div>
                  <div class="col-md-4 td">ALUMNO</div>
                  <div class="col-md-3 td"></div>
                </div>
              </div>
              <div id="div-filtro" class="tbody col-12">
                
              </div>
            </div>
          </div>
          <small id="fmt_conteo_data" class="form-text text-primary"></small>
          <div class="col-12 col-md-6 pr-2">
            <div class="border p-1 text-center" id="title_result">
              <h5 id="card_result_title"></h5>
            </div>
            
            <div id="divcard_resultmat"></div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12 col-md-6"></div>
          <div class="col-12 col-md-6 text-center border border-secondary p-1" id="content_alumno">
            <span class="font-weight-bold" id="divcard_alumno"></span>
          </div>
        </div>
      </div>
    <!-- /.card-body -->
    </div>
  </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>
<script>
var vpermiso127 = '<?php echo getPermitido("127"); ?>';
$(document).ready(function() {
    $('#content_alumno').hide();
    $('#divcard_ltsmatriculas').hide();
    $('#title_result').hide();
    $("#fmt-cbperiodo").val(getUrlParameter("cp", '%'));
    $("#fmt-cbcarrera").val(getUrlParameter("cc", '%'));
    
    $("#fmt-cbciclo").val(getUrlParameter("ccc", '%'));
    $("#fmt-cbturno").val(getUrlParameter("ct", '%'));
    $("#fmt-cbseccion").val(getUrlParameter("cs", '%'));
    $("#fmt-cbplan").val(getUrlParameter("cpl", '%'));
    
    if (getUrlParameter("at", 0) == 1) $("#frmfiltro-matriculas").submit();
});

$('.cbgrupo').change(function(event) {

    var cp=($("#fmt-cbperiodo").val()=="%")? "":"&cp=" + $("#fmt-cbperiodo").val();
    var cc=($("#fmt-cbcarrera").val()=="%")? "":"&cc=" + $("#fmt-cbcarrera").val();
    var ccc=($("#fmt-cbciclo").val()=="%")? "":"&ccc=" + $("#fmt-cbciclo").val();
    var ct=($("#fmt-cbturno").val()=="%")? "":"&ct=" + $("#fmt-cbturno").val();
    var cs=($("#fmt-cbseccion").val()=="%")? "":"&cs=" + $("#fmt-cbseccion").val();
    var cpl=($("#fmt-cbplan").val()=="%")? "":"&cpl=" + $("#fmt-cbplan").val();
    url_complemento="?at=0" + cp + cc + ccc + ct + cs + cpl;
    if (history.pushState) {
          var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + url_complemento;
          window.history.pushState({path:newurl},'',newurl);
    }
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
                if (e.vdata.length > 0) {

                  $.each(e.vdata, function(index, v) {
                      nro++;
                      var dataedit = "";
                      var icono = "";
                      var vcm = base64url_encode(v['codigo']);
                      var periodo = base64url_encode(v['codperiodo']);
                      var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
                      var bloquear = "";
                      
                      if (v['bloqueo'] == "SI") {
                        dataedit = "1";
                        icono = '<i class="far fa-times-circle fa-lg text-danger"></i>';
                      } else {
                        dataedit = "0";
                        icono = '<i class="far fa-check-circle fa-lg text-success"></i>';
                      }

                      if (vpermiso127 =='SI') {
                        bloquear = '<a onclick="fn_bloquea_notas($(this));return false;" class="h7" style="cursor:pointer" title="" data-edit="'+dataedit+'">'+icono+'</a>';
                      } else {
                        bloquear = "";
                      }

                      $("#div-filtro").append(
                          '<div data-idm="' + vcm + '" data-carne="'+v['carne']+'" data-periodo="'+periodo+'" class="cfila row ' + rowcolor + ' ">' +
                            '<div class="col-4 col-md-3">' +
                              '<div class="row">' +
                                '<div class="col-3 col-md-3 td">' + nro + '</div>' +
                                '<div class="ccarne col-9 col-md-9 td">' + v['carne'] + '</div>' +
                              '</div>' +
                            '</div>' +
                            '<div class="calumno col-8 col-md-2 td">' + 
                                v['periodo'] + ' ' + v['ciclo'] +
                            '</div>' +
                            '<div class="calumno col-8 col-md-4 td">' +
                                v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + 
                            '</div>' +
                            '<div class="col-12 col-md-3 text-center">'+
                              '<div class="row">' +
                                '<div class="col-3 col-md-3 td text-center">'+
                                  '<a onclick="fn_mostrar_notas($(this));return false;" class="text-primary h7" style="cursor:pointer" title="Notas"><i class="fas fa-lg fa-paste"></i></a>'+
                                '</div>' +
                                '<div class="col-3 col-md-3 td text-center">'+
                                  '<a onclick="fn_mostrar_asistencias($(this));return false;" class="text-primary h7" style="cursor:pointer" title="Asistencias"><i class="far fa-lg fa-calendar-alt"></i></a>'+
                                '</div>' +
                                '<div class="col-3 col-md-3 td text-center">'+
                                  '<a onclick="fn_pagos_alumnos($(this));return false;" class="text-primary h7" style="cursor:pointer" title="Pagos"><i class="far fa-lg fa-money-bill-alt"></i></a>'+
                                '</div>' +
                                '<div class="col-3 col-md-3 td text-center">'+
                                  bloquear+
                                '</div>' +
                              '</div>' +
                            '</div>' +
                          '</div>');
                  });

                  $('#div-filtro').css('height','300px');
                  
                } else {
                  $('#div-filtro').css('height','auto');
                }

                $('#divcard_ltsmatriculas').show();
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

function fn_mostrar_asistencias(boton) {
  var fila = boton.closest(".cfila");
  var carne = fila.data('carne');
  var periodo = fila.data('periodo');
  $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#divcard_resultmat').html("");
  $.ajax({
    url: base_url + 'tesoreria_matricula/fn_asistencias_alumno',
    type: 'post',
    dataType: 'json',
    data: {txtbusca_carne: carne,cbperiodo: periodo},

    success: function(e) {
      
      $('#divcard-matricular #divoverlay').remove();

      if (e.status == false) {
        $('#divcard_resultmat').html("");
      }else{
        var tabla = "";
        var tabody = "";
        var nro = 0;
        var asist = 0;
        var falta = 0;
        var tard = 0;
        var just = 0;
        tabla = tabla +
          '<div class="btable">'+
            '<div class="thead col-12  d-none d-md-block">'+
              '<div class="row">'+
                '<div class="col-md-3 td">DOCENTE</div>'+
                '<div class="col-md-4 td">UNIDAD DIDAC.</div>'+
                '<div class="col-md-5">'+
                  '<div class="row">'+
                    '<div class="col-md-3 td">ASIS</div>'+
                    '<div class="col-md-3 td">FALT</div>'+
                    '<div class="col-md-3 td">TARD</div>'+
                    '<div class="col-md-3 td">JUST</div>'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div id="divcard_asistencias" class="tbody col-12 divcardresult_data">'+
              
            '</div>'+
          '</div>';
          $('#divcard_resultmat').html(tabla);
          $('#title_result').show();
          $('#card_result_title').html("ASISTENCIAS");
          if (e.miscursos.length > 0) {
            $.each(e.miscursos, function(index, v) {
              nro++;
              var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
              
              tabody = tabody +
                '<div class="rowsfila row ' + rowcolor + ' " data-carga="'+v['idcarga']+'" data-miembro="'+v['idmiembro']+'">'+
                  '<div class="col-6 col-md-3 td">'+v['paterno'] + " " + v['materno'] + " " + v['nombres'] +'</div>'+
                  '<div class="col-6 col-md-4 td">'+v['curso'] +'</div>'+
                  '<div class="col-12 col-md-5">'+
                    '<div class="row">'+
                      '<div class=" col-3 col-md-3 td cellasis bg-success">'+asist+'</div>'+
                      '<div class=" col-3 col-md-3 td cellfalt bg-danger">'+falta+'</div>'+
                      '<div class=" col-3 col-md-3 td celltard bg-warning">'+tard+'</div>'+
                      '<div class=" col-3 col-md-3 td celljust bg-info">'+just+'</div>'+
                    '</div>'+
                  '</div>'+
                '</div>';
            })

            $('#divcard_asistencias').html(tabody);
            $('#divcard_asistencias').css('height','300px');
            $('#fmt_conteo_data').html(nro+" Unidades didácticas encontradas");
            $('#content_alumno').show();
            $('#divcard_alumno').html(e.carnet+" - <br class='d-inline-block d-md-none'>"+e.alumno);
            $('#divcard_asistencias .rowsfila').each(function() {
              fila=$(this);
              var carga = $(this).data('carga');
              var miembro = $(this).data('miembro');
              
              $.each(e.miscursosesta, function(index, val) {
                if ((carga==val['idcarga']) && (miembro==val['idmiembro'])) {
                  asist = val['asiste'];
                  falta = val['tarde'];
                  tard = val['falta'];
                  just = val['justif'];

                  fila.find('.cellasis').html(asist);
                  fila.find('.cellfalt').html(falta);
                  fila.find('.celltard').html(tard);
                  fila.find('.celljust').html(just);
                }
              })
            })
          }
      }
    },
    error: function (jqXHR, exception) {
      var msgf = errorAjax(jqXHR, exception, 'text');
      $('#divcard-matricular #divoverlay').remove();
      
    },  

  })
}

function fn_mostrar_notas(boton) {
  var fila = boton.closest(".cfila");
  var carne = fila.data('carne');
  var periodo = fila.data('periodo');
  $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#divcard_resultmat').html("");
  $.ajax({
    url: base_url + 'tesoreria_matricula/fn_notas_alumno',
    type: 'post',
    dataType: 'json',
    data: {txtbusca_carne: carne,cbperiodo: periodo},

    success: function(e) {
      
      $('#divcard-matricular #divoverlay').remove();
      if (e.status == false) {
        $('#divcard_resultmat').html("");
      }else{
        var tabla = "";
        var tabody = "";
        var nro = 0;
        var nt = 0;
        var nr = 0;
        var nf = 0;
        var colornt = "";
        var colornr = "";
        var colornf = "";
        tabla = tabla +
          '<div class="btable">'+
            '<div class="thead col-12  d-none d-md-block">'+
              '<div class="row">'+
                '<div class="col-md-4 td">DOCENTE</div>'+
                '<div class="col-md-4 td">UNIDAD DIDAC.</div>'+
                '<div class="col-md-4">'+
                  '<div class="row">'+
                    '<div class="col-md-4 td">NT</div>'+
                    '<div class="col-md-4 td">NR</div>'+
                    '<div class="col-md-4 td">NF</div>'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div id="divcard_notas" class="tbody col-12 divcardresult_data">'+
              
            '</div>'+
          '</div>';
          $('#divcard_resultmat').html(tabla);
          $('#title_result').show();
          $('#card_result_title').html("NOTAS");
        if (e.miscursos.length > 0) {
          $.each(e.miscursos, function(index, v) {
            nro++;
            var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
            if (v['nota'] !==null) {
              nt = v['nota'];
            } else {
              nt = 0;
            }

            if (v['recuperacion'] !==null) {
              nr = v['recuperacion'];
            } else {
              nr = 0;
            }

            if (v['final'] !==null) {
              nf = v['final'];
            } else {
              nf = 0;
            }

            if (nt < 13) {
              colornt = "text-danger";
            } else {
              colornt = "text-primary"
            }

            if (nr < 13) {
              colornr = "text-danger";
            } else {
              colornr = "text-primary"
            }

            if (nf < 13) {
              colornf = "text-danger";
            } else {
              colornf = "text-primary"
            }
            tabody = tabody +
              '<div class="rowsfila row ' + rowcolor + ' " data-carga="'+v['idcarga']+'" data-miembro="'+v['idmiembro']+'">'+
                '<div class="col-6 col-md-4 td">'+v['paterno'] + " " + v['materno'] + " " + v['nombres'] +'</div>'+
                '<div class="col-6 col-md-4 td">'+v['curso'] +'</div>'+
                '<div class="col-12 col-md-4">'+
                  '<div class="row">'+
                    '<div class=" col-4 col-md-4 td '+colornt+'">'+nt+'</div>'+
                    '<div class=" col-4 col-md-4 td '+colornr+'">'+nr+'</div>'+
                    '<div class=" col-4 col-md-4 td '+colornf+' font-weight-bold">'+nf+'</div>'+
                  '</div>'+
                '</div>'+
              '</div>';
          })

          $('#divcard_notas').html(tabody);
          $('#divcard_notas').css('height','300px');
          $('#fmt_conteo_data').html(nro+" Unidades didácticas encontradas");
          $('#content_alumno').show();
          $('#divcard_alumno').html(e.carnet+" - <br class='d-inline-block d-md-none'>"+e.alumno);
        }
      }
    }
  })
}

function fn_pagos_alumnos(boton) {
  var fila = boton.closest(".cfila");
  var carne = fila.data('carne');
  var periodo = fila.data('periodo');
  $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#divcard_resultmat').html("");
  $.ajax({
    url: base_url + 'tesoreria_matricula/fn_docpagos_alumno',
    type: 'post',
    dataType: 'json',
    data: {txtbusca_carne: carne,cbperiodo: periodo},

    success: function(e) {
      
      $('#divcard-matricular #divoverlay').remove();
      if (e.status == false) {
        $('#divcard_resultmat').html("");
      }else{
        var tabla = "";
        var tabody = "";
        var tadetail = "";
        var nro = 0;
        var gestion = "";
        var igv = 0;
        var unitario = 0;
        tabla = tabla +
          '<div class="btable">'+
            '<div class="thead col-12  d-none d-md-block">'+
              '<div class="row">'+
                '<div class="col-md-3 td">TIP/NRO</div>'+
                '<div class="col-md-9">'+
                  '<div class="row">'+
                    '<div class="col-md-6 td">PAGANTE</div>'+
                    '<div class="col-md-3 td">MONTO</div>'+
                    '<div class="col-md-3 td">IGV</div>'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div id="divcard_pagos" class="tbody col-12 divcardresult_data">'+
              
            '</div>'+
          '</div>';
        $('#divcard_resultmat').html(tabla);
        $('#title_result').show();
        $('#card_result_title').html("PAGOS");
        $('#divcard_pagos').html(e.pagos);
        $('#divcard_pagos').css('height',e.alto);
        $('#fmt_conteo_data').html(e.mensaje);
        $('#content_alumno').show();
        $('#divcard_alumno').html(e.carnet+" - <br class='d-inline-block d-md-none'>"+e.alumno);
      }
    }
  })
}

function fn_bloquea_notas(boton) {
  var fila = boton.closest(".cfila");
  var idmatricula = fila.data('idm');
  var isedit = boton.data("edit");
  if (isedit == "1") {
    valor = "NO";
    
  } else {
    valor = "SI";
  }
  $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
    url: base_url + 'tesoreria_matricula/fn_update_bloqueo',
    type: 'post',
    dataType: 'json',
    data: {
        idmatricula: idmatricula,
        estado: valor,
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

          if (valor == 'SI') {
            boton.data('edit','1');
            boton.html('<i class="far fa-times-circle text-danger"></i>');
          } else {
            boton.data('edit','0');
            boton.html('<i class="far fa-check-circle text-success"></i>');
          }

          // $("#frmfiltro-matriculas").submit();
          // $("#fispedit").html("");
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
}

</script>