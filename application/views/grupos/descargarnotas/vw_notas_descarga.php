<?php $vbaseurl=base_url() ?>
<style> 
#div_filtro_alumno::-webkit-scrollbar {
    width: 6px;
    height: 4px;
}

#div_filtro_alumno::-webkit-scrollbar-track {
    box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.3);
    border-radius: 10px;
}

#div_filtro_alumno::-webkit-scrollbar-thumb {
    background: rgba(229, 231, 233, 1);
    border-radius: 10px;
    box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.5);
}

@media screen and (max-width: 767px) {
    #div_filtro_alumno::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
}

#div_filtro_alumno {
    overflow-x: auto;
    overflow-y: auto;
    
}
</style>
<div class="content-wrapper">
  <div class="modal fade" id="modviewnotas" tabindex="-1" role="dialog" aria-labelledby="modviewnotas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="divmodaladd">
            <div class="modal-header">
                <h5 class="modal-title">Notas grupo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <small id="fmt-conteo" class="form-text text-primary">
            
              </small>
              <div class="btable" id="div_filtro_head">
                <div class="thead col-12  d-none d-md-block">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="row">
                        <div class="col-md-3 td small text-bold">NRO</div>
                        <div class="col-md-9 td small text-bold">CARNÉ.</div>
                      </div>
                    </div>
                    <div class="col-md-5 td small text-bold">ALUMNO</div>
                    <div class="col-md-1 td small text-bold">NOTA FIN</div>
                    <div class="col-md-1 td small text-bold">NOTA REC.</div>
                    <div class="col-md-2 td small text-bold"></div>
                  </div>
                </div>
                <div id="div_filtro_alumno" class="tbody col-12">

                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <?php if (getPermitido("128")=='SI'){ ?>
                <button type="button" id="vw_mpc_btn_subirnotas" class="btn btn-primary">Subir Notas</button>
                <?php } ?>
            </div>
        </div>
    </div>
  </div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1>Grupos</h1>
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
              <form id="frmfiltro-unidades_grupo" name="frmfiltro-unidades_grupo" action="<?php echo $vbaseurl ?>grupos_descargar_notas/fn_get_carga_por_grupo_notas" method="post" accept-charset='utf-8'>
                <div class="row">
                  <div class="form-group has-float-label col-12  col-md-2">
                    <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbperiodo" name="fmt-cbperiodo" placeholder="Periodo">
                      <option value="0"></option>
                      <?php foreach ($periodos as $periodo) {?>
                      <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fmt-cbperiodo"> Periodo</label>
                  </div>
                  
                  <div class="form-group has-float-label col-12  col-md-3">
                    <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbcarrera" name="fmt-cbcarrera" placeholder="Programa Académico" >
                      <option value="0"></option>
                      <?php foreach ($carreras as $carrera) {?>
                      <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fmt-cbcarrera"> Programa Académico</label>
                  </div>

                  <div class="form-group has-float-label col-12  col-md-2">
                    <select name="fmt-cbplan" id="fmt-cbplan"class="form-control form-control-sm">
                      <option data-carrera="0" value="0"></option>
                      <?php foreach ($planes as $pln) {
                        echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
                      } ?>
                    </select>
                    <label for="fmt-cbplan">Plan estudios</label>
                  </div>

                  <div class="form-group has-float-label col-12  col-md-1">
                    <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbciclo" name="fmt-cbciclo" placeholder="Ciclo" >
                      <option value="0"></option>
                      <?php foreach ($ciclos as $ciclo) {?>
                      <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fmt-cbciclo"> Ciclo</label>
                  </div>
                  <div class="form-group has-float-label col-12  col-md-2">
                    <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbturno" name="fmt-cbturno" placeholder="Turno" >
                      <option value="0"></option>
                      <?php foreach ($turnos as $turno) {?>
                      <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fmt-cbturno"> Turno</label>
                  </div>
                  <div class="form-group has-float-label col-12  col-md-1">
                    <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbseccion" name="fmt-cbseccion" placeholder="Sección" >
                      <option value="0"></option>
                      <?php foreach ($secciones as $seccion) {?>
                      <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fmt-cbseccion"> Sección</label>
                  </div>
                  <div class="col-6  col-md-1">
                    <button type="submit" class="btn btn-primary btn-block btn-sm"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
            
            <div class="col-12 mt-3" id="divgrupos_result"></div>
          </div>
        </div>
        <!-- /.tab-content -->
      </div>
    <!-- /.card-body -->
    </div>
  </section>
</div>

<script>
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000
  })

  $(document).ready(function() {
      $("#fca-cbperiodo").val(getUrlParameter("cp",0))
      $("#fca-carrera").val(getUrlParameter("cc",0))
      $("#fca-carrera").change();
      
      $("#fca-cbciclo").val(getUrlParameter("ccc",0))
      $("#fca-cbturno").val(getUrlParameter("ct",0))
      $("#fca-cbseccion").val(getUrlParameter("cs",0))
  });

  $("#fca-carrera").change(function(event) {
    /* Act on the event */
    if ($(this).val()!="0"){
      $('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

      $('#fca-plan').html("<option value='0'>Sin opciones</option>");
          var codcar = $(this).val();
          if (codcar == '0') return;
          $.ajax({
              url: base_url + 'plancurricular/fn_get_planes_activos_combo',
              type: 'post',
              dataType: 'json',
              data: {
                  txtcodcarrera: codcar
              },
              success: function(e) {
                $('#divcard_grupo #divoverlay').remove();
                  $('#fca-plan').html(e.vdata);
                  $("#fca-plan").val(getUrlParameter("cpl",0));
              },
              error: function(jqXHR, exception) {
                $('#divcard_grupo #divoverlay').remove();
                  var msgf = errorAjax(jqXHR, exception, 'text');
                  $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
              }
          });
    }
    else{
      $('#fca-plan').html("<option value='0'>Seleciona un carrera<option>");
    }
  });





$('#frmfiltro-unidades_grupo #fmt-cbcarrera').change(function(event) {
    var codcar = $(this).val();
    if (codcar=="%"){
      $("#frmfiltro-unidades_grupo #fmt-cbplan option").each(function(i){
          if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');           
      });
    }
    else{
      $("#frmfiltro-unidades_grupo #fmt-cbplan option").each(function(i){
    
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


/*$("#frmfiltro-unidades_grupo").submit(function(event) {
  /*var vacio=0;
  $("#frmfiltro-unidades_grupo select").each(function(index, el) {
    if ($(el).val()=="0") vacio++;
  });

  if (vacio>0){
    Toast.fire({
      type: 'warning',
      icon: 'warning',
      title: 'Aviso: Selecciona todos los Items disponibles: Periodo, Programa, Plan, Ciclo, Turno, Sección'
    })
  }
  else{*/
    /*$('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#div-filtro").html("");
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            if (e.status == false) {

            } else {
                $('#divgrupos_result').html(e.vdata);
                
                $('#divcard-matricular #divoverlay').remove();
                
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard-matricular #divoverlay').remove();
            //$('#divError').show();
            //$('#msgError').html(msgf);
        }
    });
  //}
    return false;
});*/


$("#frmfiltro-unidades_grupo").submit(function(event) {
  /*var vacio=0;
  $("#frmfiltro-unidades_grupo select").each(function(index, el) {
    if ($(el).val()=="0") vacio++;
  });

  if (vacio>0){
    Toast.fire({
      type: 'warning',
      icon: 'warning',
      title: 'Aviso: Selecciona todos los Items disponibles: Periodo, Programa, Plan, Ciclo, Turno, Sección'
    })
  }
  else{*/
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#div-filtro").html("");
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            if (e.status == false) {

            } else {
                $('#divgrupos_result').html(e.vdata);
                
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
  //}
    return false;
});

function fn_search_alumnos(carga,division) {
  $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $("#div_filtro_alumno").html("");
  $.ajax({
      url: base_url + "grupos_descargar_notas/fn_get_alumnos_notas",
      type: 'post',
      dataType: 'json',
      data: {
        codcarga: carga,
        coddivision: division,
      },
      success: function(e) {
          if (e.status == false) {

          } else {
            $('#modviewnotas').modal('show');
            var nro = 0;
            var tabla = "";
            var notafin = "";
            var notarec = "";
            var btndwl = "";
            if (e.vdata.length > 0) {
              if ('<?php echo getPermitido("128") ?>' =='SI') {
                btndwl = '<button class="btn btn-info btn-sm btndownload_notas" title="Descargar nota"><i class="fas fa-download"></i> </button>';
              } else {
                btndwl = "";
              }
              $.each(e.vdata, function(index, v) {
                nro++;
                var vcm = base64url_encode(v['idmat']);
                var vcarga = base64url_encode(v['idcarga']);
                var vdivision = base64url_encode(v['iddivision']);
                var vdocente = base64url_encode(v['coddocente']);
                var vcarrera = base64url_encode(v['idcarrera']);
                var vciclo = base64url_encode(v['idciclo']);
                var vperiodo = base64url_encode(v['idperiodo']);
                var vplan = base64url_encode(v['idplan']);
                var vseccion = base64url_encode(v['idseccion']);
                var vturno = base64url_encode(v['idturno']);
                var vunidad = base64url_encode(v['idunidad']);
                var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
                if (v['notafin'] !== null) {
                  var notafin = v['notafin'];
                } else {
                  var notafin = 0;
                }

                if (v['notarec'] !== null) {
                  var notarec = v['notarec'];
                } else {
                  var notarec = 0;
                }

                tabla = tabla +
                  '<div data-idm="'+vcm+'" data-carga="'+vcarga+'" data-division="'+vdivision+'" data-docente="'+vdocente+'" data-carrera="'+vcarrera+'" data-ciclo="'+vciclo+'" data-periodo="'+vperiodo+'" data-plan="'+vplan+'" data-seccion="'+vseccion+'" data-turno="'+vturno+'" data-unidad="'+vunidad+'" data-estado="'+v['estado']+'" data-repitencia="'+v['repitencia']+'" data-notf="'+v['notafin']+'" data-notrec="'+v['notarec']+'" class="cfila row ' + rowcolor + ' rowcolor">' +
                    '<div class="col-4 col-md-3">' +
                      '<div class="row">' +
                        '<div class="col-3 col-md-3 td">' + nro + '</div>' +
                        '<div class="col-9 col-md-9 td">' + v['carne'] + '</div>' +
                      '</div>' +
                    '</div>' +
                    '<div class="col-8 col-md-5 td">' + v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + '</div>' +
                    '<div class="col-4 col-md-1 td text-center">' + notafin + '</div>' +
                    '<div class="col-4 col-md-1 td text-center">' + notarec + '</div>' +
                    '<div class="col-4 col-md-2 td text-center">'+
                      btndwl+
                    '</div>' +
                  '</div>';
              })
              $("#div_filtro_alumno").html(tabla);              
              $("#fmt-conteo").html(nro + ' Alumnos encontrados');
              $('#div_filtro_alumno').css('height', '359px');
              $('#vw_mpc_btn_subirnotas').show();
            } else {
              $("#div_filtro_alumno").html("<div class='text-danger h5'>Esta unidad didáctica aún no se ha culminado</div>");
              $("#fmt-conteo").html('');
              $('#div_filtro_alumno').css('height', 'auto');
              $('#vw_mpc_btn_subirnotas').hide();
            }
            
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
}
fn_migrar_notas
$(document).on('click', '.btndownload_notas', function() {
  var btn = $(this);
  var fila=btn.closest('.rowcolor');
  var idmat = fila.data('idm');
  var carga = fila.data('carga');
  var division = fila.data('division');
  var docente = fila.data('docente');
  var carrera = fila.data('carrera');
  var ciclo = fila.data('ciclo');
  var periodo = fila.data('periodo');
  var plan = fila.data('plan');
  var seccion = fila.data('seccion');
  var turno = fila.data('turno');
  var unidad = fila.data('unidad');
  var estado = fila.data('estado');
  var repitencia = fila.data('repitencia');
  var notfin = fila.data('notf');
  var notrec = fila.data('notrec');
  $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
    url: base_url + 'grupos_descargar_notas/fn_insert_update',
    type: 'post',
    dataType: 'json',
    data: {
        'fmt-codmatricula': idmat,
        'fmt-cbnperiodo': periodo,
        'fmt-cbncarrera': carrera,
        'fmt-cbnplan': plan,
        'fmt-cbnciclo': ciclo,
        'fmt-cbnturno': turno,
        'fmt-cbnseccion': seccion,
        'fmt-cbnunididact': unidad,
        'fmt-cbncargaacadem': carga,
        'fmt-cbncargaacadsubsec': division,
        'fmt-cbndocente': docente,
        'fmt-estado': estado,
        'fmt-repitencia': repitencia,
        'fmt-cbnnotafinal': notfin,
        'fmt-cbnnotarecup': notrec,
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
  return false;
});

$('#vw_mpc_btn_subirnotas').click(function() {
  arrdata = [];
  $('#div_filtro_alumno .rowcolor').each(function() {
    var idmat = $(this).data('idm');
    var carga = $(this).data('carga');
    var division = $(this).data('division');
    var docente = $(this).data('docente');
    var carrera = $(this).data('carrera');
    var ciclo = $(this).data('ciclo');
    var periodo = $(this).data('periodo');
    var plan = $(this).data('plan');
    var seccion = $(this).data('seccion');
    var turno = $(this).data('turno');
    var unidad = $(this).data('unidad');
    var estado = $(this).data('estado');
    var repitencia = $(this).data('repitencia');
    var notfin = $(this).data('notf');
    var notrec = $(this).data('notrec');
    
    var myvals = [idmat, carga, division, docente, carrera, ciclo, periodo, plan, seccion, turno, unidad, estado, repitencia, notfin, notrec];
    arrdata.push(myvals);
  });
  // console.log(arrdata);
  $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
    url: base_url + 'grupos_descargar_notas/fn_insert_update_global',
    type: 'post',
    dataType: 'json',
    data: {
        filas: JSON.stringify(arrdata),
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
  return false;
});

</script>