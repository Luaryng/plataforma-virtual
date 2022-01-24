<?php 
  $vbaseurl=base_url();
  date_default_timezone_set ('America/Lima');
  $fecha = date("Y-m-d");
?>
<style type="text/css">
  .not-active { 
      pointer-events: none; 
      cursor: default; 
  }
</style>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">

  <!-- MODAL REINGRESO -->
  <div class="modal fade" id="modaddreingreso" tabindex="-1" role="dialog" aria-labelledby="modaddreingreso" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content" id="divmodaladdreing">
              <div class="modal-header">
                  <h5 class="modal-title" id="divcard_title">REINGRESO</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form id="form_addreingreso" action="<?php echo $vbaseurl ?>reingresos/fn_insert_reingreso" method="post" accept-charset="utf-8">
                      <input type="hidden" name="vw_fcb_codinscripcion" id="vw_fcb_codinscripcion" value="">
                      <input type="hidden" name="ficbcarrera" id="ficbcarrera" value="">
                      <input type="hidden" name="cbcarrera" id="cbcarrera" value="">
                      <input  id="fimcpaterno" name="fimcpaterno" type="hidden" />
                      <input  id="fimcmaterno" name="fimcmaterno" type="hidden" />
                      <input  id="fimcnombres" name="fimcnombres" type="hidden" />
                      <input type="hidden" name="vw_fcb_carnet" id="vw_fcb_carnet" value="">
                      <?php
                        foreach ($modalidades as $key => $mod) {
                          $modreing = ($mod->id == 3) ? $mod->id : "";
                        }
                      ?>
                      <input type="hidden" name="vw_fcb_codmodalidad" id="vw_fcb_codmodalidad" value="<?php echo $modreing ?>">
                      <div class="row mb-2">
                         <div class="col-12 col-md-12">
                            <span id="spn_carne"></span> <span id="fimccarrera" class="text-primary text-bold"></span><br> 
                              <!-- <p class="h5"  id="fimcestudiante" name="fimcestudiante" ></p> -->
                          </div>
                         <div class="col-12 col-md-12 text-bold">
                             <!--  <span id="fimccarrera" name="fimccarrera" >
                              </span> -->
                              <b><span id="fimcestudiante"></span></b>
                          </div>
                      </div>
                      <hr>
                      <div class="row">
                         
                          <div class="form-group has-float-label col-12 col-md-2">
                              <select name="vw_fcb_cbperiodo" id="vw_fcb_cbperiodo" class="form-control control form-control-sm text-sm">
                                  <?php
                                  foreach ($periodos as $key => $perd) {
                                      echo "<option value='$perd->codigo'>$perd->nombre</option>";
                                  }
                                  ?>
                                  
                              </select>
                              <label for="vw_fcb_cbperiodo">Periodo</label>
                          </div>
                          <div class="form-group has-float-label col-12 col-md-4">
                              <select name="vw_fcb_campania" id="vw_fcb_campania" class="form-control control form-control-sm text-sm">
                                <option value="">--</option>}
                              </select>
                              <label for="vw_fcb_campania">Campaña</label>
                          </div>
                          <div class="form-group has-float-label col-6 col-md-2">
                              <select name="vw_fcb_cbciclo" id="vw_fcb_cbciclo" class="form-control control form-control-sm text-sm">
                                  <?php
                                  foreach ($ciclos as $key => $cic) {
                                  echo "<option value='$cic->codigo'>$cic->nombre</option>";
                                  }
                                  ?>
                                  
                              </select>
                              <label for="vw_fcb_cbciclo">Ciclo</label>
                          </div>
                          
                          <div class="form-group has-float-label col-12 col-md-2">
                            <select data-currentvalue='' class="form-control form-control-sm text-sm" id="ficbturno" name="ficbturno" placeholder="Turno" required >
                              <option value="0">Selecciona</option>
                              <?php foreach ($turnos as $turno) {?>
                              <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                              <?php } ?>
                            </select>
                            <label for="ficbturno"> Turno</label>
                          </div>
                          <div class="form-group has-float-label col-12 col-md-2">
                            <select data-currentvalue='' class="form-control form-control-sm text-sm" id="ficbseccion" name="ficbseccion" placeholder="Sección" required >
                              <option value="0">Selecciona</option>
                              <?php foreach ($secciones as $sec) {?>
                              <option value="<?php echo $sec->codigo ?>"><?php echo $sec->nombre ?></option>
                              <?php } ?>
                            </select>
                            <label for="ficbseccion"> Sección</label>
                          </div>
                          <div class="form-group col-12 col-sm-12">
                            <div id="lista-okreing" class="row ocultar mt-2">
                              <div class="col-12">
                                <div class="d-none d-md-block">
                                  <div class="row mt-3">
                                    <div class="col-6">
                                      <span class="h6"><b>Documentos anexados</b></span>
                                    </div>
                                    <div class="col-2">
                                      <span class="h6"><b>Periodo</b></span>
                                    </div>
                                    <div class="col-4">
                                      <span class="h6"><b>Fecha de entrega / Observaciones</b></span>
                                    </div>
                                  </div>
                                  <hr>
                                </div>
                              <?php foreach ($docs_anexar as $doc_anexar) {?>
                                <div class="row mb-2">
                                  <div class="col-12 col-md-6">
                                    <div class="brcheck">
                                        <input class="check" type="checkbox" name="it<?php echo $doc_anexar->coddocumento ?>" id="it<?php echo $doc_anexar->coddocumento ?>" value="<?php echo $doc_anexar->coddocumento ?>" />
                                        <label class="check__label" for="it<?php echo $doc_anexar->coddocumento ?>">
                                            <i class="fas fa-check"></i>
                                            <span class="texto"><?php echo $doc_anexar->nombre ?></span>
                                        </label>
                                    </div>
                                  </div>
                                  <div class="col-6 col-md-2">
                                    <select class="form-control form-control-sm" id="period_it<?php echo $doc_anexar->coddocumento ?>" name="period_it<?php echo $doc_anexar->coddocumento ?>" disabled="">
                                        <option value=""></option>
                                        <?php foreach ($periodos as $perd) {?>
                                        <option value="<?php echo $perd->codigo ?>"><?php echo $perd->nombre ?></option>
                                        <?php } ?>
                                    </select>
                                  </div>
                                  <div class="col-6 col-md-4">
                                    <input type="text" name="txt_it<?php echo $doc_anexar->coddocumento ?>" id="txt_it<?php echo $doc_anexar->coddocumento ?>" class="form-control form-control-sm" disabled="">
                                  </div>
                                </div>
                                <?php } ?> 
                              </div>
                            </div>
                          </div>
                          <div class="form-group has-float-label col-6 col-md-3">
                              <input type="date" name="vw_fcb_fecha" id="vw_fcb_fecha" placeholder="Fecha" class="form-control control form-control-sm text-sm" value="<?php echo $fecha ?>">
                              <label for="vw_fcb_fecha">Fecha</label>
                          </div>
                          <div class="form-group has-float-label col-12">
                            <textarea name="vw_fcb_cbobservacion" id="vw_fcb_cbobservacion" class="form-control control form-control-sm text-sm" placeholder="Observación" rows="3"></textarea>
                            <label for="vw_fcb_cbobservacion">Observación</label>
                          </div>                       
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                  <button type="button" id="lbtn_guardar_reingreso" data-coloran="" class="btn btn-primary">Guardar</button>
              </div>
          </div>
      </div>
  </div>
  <!-- FIN MODAL REINGRESO -->

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reingresos</h1>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  <section id="s-cargado" class="content pt-2">

    <div id="divboxhistorial" class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-search"></i> Búsqueda</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <form id="frm-filtro-inscritos" name="frm-filtro-inscritos" action="<?php echo $vbaseurl ?>reingresos/get_filtrar_basico_sd_retirados" method="post" accept-charset='utf-8'>
          
          <div class="row my-2">
            <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
              <select class="form-control" id="fbus-periodo" name="fbus-periodo" placeholder="Periodo lectivo">
                <option value="%">Todos</option>
                <?php foreach ($periodos as $periodo) {?>
                <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                <?php } ?>
              </select>
              <label for="fbus-carrera">Periodo lectivo</label>
            </div>
            <div class="form-group has-float-label col-12 col-sm-3 col-md-3">
              <select class="form-control" id="fbus-carrera" name="fbus-carrera" placeholder="Programa">
                <option value="%">Todos</option>
                <?php foreach ($carreras as $carrera) {?>
                <option value="<?php echo $carrera->codcarrera ?>" data-sigla="<?php echo $carrera->sigla ?>"><?php echo $carrera->nombre ?></option>
                <?php } ?>
              </select>
              <label for="fbus-carrera"> Programa</label>
            </div>
            <div class="form-group has-float-label col-12 col-sm-6 col-md-4">
              <input  class="form-control text-uppercase" id="fbus-txtbuscar" name="fbus-txtbuscar" type="text" placeholder="Carné o Apellidos y nombres"   />
              <label for="fbus-txtbuscar">Carné o Apellidos y nombres</label>
            </div>
            
            <div class="col-4 col-sm-3 col-md-1">
              <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
            </div>

            <div class="col-6 col-sm-3 col-md-2">
              <a href="#" class="btn-excel btn btn-outline-secondary"><img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt=""> Exportar</a>
            </div>


          </div>
          
        </form>
          <div class="card-body no-padding">
            <div class="row">
              <div class="col-12 py-1" id="divres-historial">
                <div class="card">
                  <div class="card-body">
                    
                    <span class='text-danger'>Utiliza los cuadros de búsqueda ubicados arriba para encontrar el historial existente de los estudiantes registrados</span>
                    
                    
                  </div>
                </div>
              </div>
              
              
            </div>
          </div>
      </div>
      <!-- /.card-body -->
    </div>
    
  </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>
<script>

  // var vdnipostulante='<?php //echo $dnipostula; ?>';
  $('.selectpicker').selectpicker({
      iconBase: 'fa',
      tickIcon: 'fa-check',
  });

  $("#frm-filtro-inscritos").submit(function(event) {
    $('#frm-filtro-inscritos input,select').removeClass('is-invalid');
    $('#frm-filtro-inscritos .invalid-feedback').remove();
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
      url: $(this).attr("action"),
      type: 'post',
      dataType: 'json',
      data: $(this).serialize(),
      success: function(e) {
        $('#divboxhistorial #divoverlay').remove();
        if (e.status == false) {
            $.each(e.errors, function(key, val) {
                $('#' + key).addClass('is-invalid');
                $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
            });
            $("#divres-historial").html("");
        } else {
              $("#divres-historial").html(e.vdata);
        }
      },
      error: function(jqXHR, exception) {
        var msgf = errorAjax(jqXHR, exception, 'text');
        $('#divboxhistorial #divoverlay').remove();
        $("#divres-historial").html("");
        Swal.fire({
          type: 'error',
          title: 'Error, no se pudo mostrar los resultados',
          text: msgf,
          backdrop: false,
        })
      }
    });
    return false;
  });

  $(".btn-excel").click(function(e) {
    e.preventDefault();
    
    $('#frm-filtro-inscritos input,select').removeClass('is-invalid');
    $('#frm-filtro-inscritos .invalid-feedback').remove();

    var url=base_url + 'admision/reingresos/excel?cp=' + $("#fbus-periodo").val() + '&cc=' + $("#fbus-carrera").val() + '&ap=' + $("#fbus-txtbuscar").val();
    var ejecuta=false;
    if ($.trim($("#fbus-txtbuscar").val())=='%%%%'){
      if (($("#fbus-periodo").val()!="%") || ($("#fbus-carrera").val()!="%")){
        ejecuta=true;
      }
      else{
        $('#fbus-carrera').addClass('is-invalid');
        $('#fbus-carrera').parent().append("<div class='invalid-feedback'> Seleccionar</div>");
        $('#fbus-periodo').addClass('is-invalid');
        $('#fbus-periodo').parent().append("<div class='invalid-feedback'> Seleccionar</div>");
      }
    }else if($.trim($("#fbus-txtbuscar").val()).length>3){
      ejecuta=true;
    }
    else{
        $('#fbus-txtbuscar').addClass('is-invalid');
        $('#fbus-txtbuscar').parent().append("<div class='invalid-feedback'> Ingrese mínimo 4 caracteres o %%%%</div>");
    }
    if (ejecuta==true) window.open(url, '_blank');
  });


  $(document).ready(function() {
    /*if (vdnipostulante!==""){
      $('.nav-pills a[href="#ficha-personal"]').tab('show');
      $("#frmins-postulante #ficodpostulante").val(vdnipostulante);
      $("#frmins-postulante").submit();
    }*/
    //else{
      var jscarnet=getUrlParameter("fcarnet","");
      $("#fbus-txtbuscar").val(jscarnet);
      $("#frm-filtro-inscritos").submit();
      
    //}
  });

  $('#modaddreingreso').on('show.bs.modal', function (e) {
      var rel = $(e.relatedTarget);
      var div = rel.parents('.cfila');
      var codigo = div.data('ci');
      var periodo = div.data('cp');
      var ciclo = div.data('cic');
      var turno = div.data('turno');
      var color = rel.data('color');
      var campania = div.data('campania');
      var carne = div.data('carne');
      var codcarrera=div.data('codcarrera');
      var carrera=div.data('carrera');
      var paterno=div.data('paterno');
      var materno=div.data('materno');
      var nombres=div.data('nombres');
      var sexo=div.data('sexo');
      
      $('#vw_fcb_codinscripcion').val(codigo);
      //$('#vw_fcb_cbperiodo').val(periodo);
      $('#vw_fcb_cbciclo').val(ciclo);
      $('#ficbturno').val(turno);
      $('#vw_fcb_carnet').val(carne);

      $('#spn_carne').html(carne);
      $('#fimccarrera').html(carrera);
      $('#fimcestudiante').html(paterno + " " + materno + " " + nombres);


      $('#ficbcarrera').val(codcarrera);
      $('#cbcarrera').val(carrera);
      $('#fimcpaterno').val(paterno);
      $('#fimcmaterno').val(materno);
      $('#fimcnombres').val(nombres);
      $('#fimcsexo').val(sexo);



      $('#lbtn_guardar_reingreso').data('coloran', color);

      $("#lista-okreing").addClass('ocultar');
      $("#lista-no").removeClass('ocultar');
      btn= $(e.relatedTarget);
      
      var fila=btn.parents(".cfila");
      
      $('#form_addreingreso input[type=checkbox]').prop('checked', false);
      $.ajax({
            url: base_url + 'reingresos/fn_getdocanexados',
            type: 'post',
            dataType: 'json',
            data: {
                    'ce-idins': codigo
                },
            success: function(e) {
                //$('#divboxhistorial #divoverlay').remove();
                $("#lista-okreing").removeClass('ocultar');
                if (e.status == false) {
                    Swal.fire({
                        type: 'error',
                        title: 'Error!',
                        text: e.msg,
                        backdrop: false,
                    })
                } else {

                  //$('#vw_fcb_cbperiodo').change();
                  $('#form_addreingreso input[type=checkbox]').each(function () {
                      //if (this.checked) {
                      var check=$(this);
                      var valor=check.attr('id').substring(2);
                      $('#period_'+check.attr('id')).val('');
                      $('#period_'+check.attr('id')).attr('disabled', true);
                      $('#txt_'+check.attr('id')).val('');
                      $('#txt_'+check.attr('id')).prop('disabled', true);
                      $.each(e.vdata, function(index, v) {
                        if (v['coddoc']==valor){
                          check.prop('checked', true);
                          $('#period_'+check.attr('id')).val(v['periodo']);
                          $('#period_'+check.attr('id')).attr('disabled', false);
                          $('#txt_'+check.attr('id')).val(v['detalle']);
                          $('#txt_'+check.attr('id')).prop('disabled', false);
                        }
                      });

                  });

                  setTimeout(function() {
                      $('#vw_fcb_campania').val(campania);

                  },1000);
                  
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                //$('#divboxhistorial #divoverlay').remove();
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    text: msgf,
                    backdrop: false,
                })
            }
        });

  });

  $('#vw_fcb_cbperiodo').change(function(e) {
    var combo = $(this);
    $('#divmodaladdreing').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('#vw_fcb_campania').html("<option value='0'>Sin opciones</option>");
    var periodo = combo.val();
    
    $.ajax({
        url: base_url + 'campania/fn_campania_por_periodo',
        type: 'post',
        dataType: 'json',
        data: {
            txtcodperiodo: periodo
        },
        success: function(e) {
            $('#divmodaladdreing #divoverlay').remove();
            $('#vw_fcb_campania').html(e.vdata);
            
        },
        error: function(jqXHR, exception) {
            $('#divmodaladdreing #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_fcb_campania').html("<option value='0'>" + msgf + "</option>");
        }
    });
    return false;
  })

  $('.check').change(function(e) {
    $('#form_addreingreso input[type=checkbox]').each(function () {
          if (this.checked) {
            var check=$(this);
            var valor=check.attr('id').substring(2);
            $('#period_'+check.attr('id')).attr('disabled', false);
            $('#txt_'+check.attr('id')).attr('disabled', false);
            $('#txt_'+check.attr('id')).focus();
            
          } else {
            var check=$(this);
            $('#period_'+check.attr('id')).val('');
            $('#period_'+check.attr('id')).attr('disabled', true);
            $('#txt_'+check.attr('id')).attr('disabled', true);
            $('#txt_'+check.attr('id')).val("");
          }
    });
  });

  $('#lbtn_guardar_reingreso').click(function() {
    var arrdata = [];
    var color = $(this).data('coloran');
    var carne = $('#vw_fcb_carnet').val();
    $('#form_addreingreso input,select,textarea').removeClass('is-invalid');
    $('#form_addreingreso .invalid-feedback').remove();
    $('#divmodaladdreing').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('#form_addreingreso input[type=checkbox]').each(function () {
      if (this.checked) {
        var check=$(this);
        var valor=check.attr('id').substring(2);
        var detalle = $('#txt_'+check.attr('id')).val();
        var periodo = $('#period_'+check.attr('id')).val();

        var myvals = [valor, detalle, periodo];
        arrdata.push(myvals);
      }
    });
    $.ajax({
      url: $('#form_addreingreso').attr("action"),
      type: 'post',
      dataType: 'json',
      data: $('#form_addreingreso').serialize() + "&filas="+JSON.stringify(arrdata),
      success: function(e) {
        $('#divmodaladdreing #divoverlay').remove();
        if (e.status == false) {
            $.each(e.errors, function(key, val) {
                $('#' + key).addClass('is-invalid');
                $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
            });

            Swal.fire({
                title: e.msg,
                // text: "",
                type: 'error',
                icon: 'error',
            })
            
        } else {
            $('#modaddreingreso').modal('hide');

            Swal.fire({
                title: e.msg,
                // text: "",
                type: 'success',
                icon: 'success',
            })

            location.href = base_url + "admision/inscripciones?fcarnet=" + carne;

        }
      },
      error: function(jqXHR, exception) {
        var msgf = errorAjax(jqXHR, exception,'text');
        $('#divmodaladdreing #divoverlay').remove();
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

</script>