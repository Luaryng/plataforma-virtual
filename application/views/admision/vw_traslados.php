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

<!-- <div class="modal fade" id="modal-docporanexar" role="dialog" tabindex="-1" data-keyboard="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">DOCUMENTOS ANEXADOS</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='frm-docanexar' name='frm-docanexar' method='post' accept-charset='utf-8'>
                <div class="modal-body">
                  <span id="spn-carne"></span><br>  
                  <b><span id="spn-alumno"></span></b>
                  <hr>
                  <input id="fdacodins" name="fdacodins" type="hidden" class="form-control" value="">
                  <div id="lista-no" class="col-12 text-center ocultar">
                    <div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>
                  </div>
                  <div id="lista-ok" class="row ocultar">
                    <div class="col-12">
                    <?php foreach ($docs_anexar as $doc_anexar) {?>

                      <div class="brcheck">
                          <input class="check" type="checkbox" name="it<?php echo $doc_anexar->coddocumento ?>" id="it<?php echo $doc_anexar->coddocumento ?>" value="<?php echo $doc_anexar->coddocumento ?>" />
                          <label class="check__label" for="it<?php echo $doc_anexar->coddocumento ?>">
                              <i class="fas fa-check"></i>
                              <span class="texto"><?php echo $doc_anexar->nombre ?></span>
                          </label>
                      </div>
                      <?php } ?> 
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary float-left" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary float-right" type="submit" > Guardar</button>
                </div>
            </form>
        </div>
        
    </div>
    
</div> -->
<div class="modal fade" id="modal-docporanexar" role="dialog" tabindex="-1" data-keyboard="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">DOCUMENTOS ANEXADOS</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='frm-docanexar' name='frm-docanexar' method='post' accept-charset='utf-8'>
                <div class="modal-body">
                  <span id="spn-carne"></span> <span id="spn_carrera" class="text-primary text-bold"></span><br>  
                  <b><span id="spn-alumno"></span></b>
                  <hr>
                  <input id="fdacodins" name="fdacodins" type="hidden" class="form-control" value="">
                  <div id="lista-no" class="col-12 text-center ocultar">
                    <div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>
                  </div>
                  <div id="lista-ok" class="row ocultar">
                    <div class="col-12">
                      <div class="d-none d-md-block">
                        <div class="row mt-3">
                          <div class="col-6">
                            <span class="h6"><b>Documentos</b></span>
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
                              <?php foreach ($periodos as $periodo) {?>
                              <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary float-left" data-dismiss="modal">Cerrar</button>
                    <?php if (getPermitido("143")=='SI') { ?>
                    <button class="btn btn-primary float-right" type="submit" > Guardar</button>
                    <?php } ?>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modanexadocs" tabindex="-1" role="dialog" aria-labelledby="modanexadocs" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="divmodanexar">
      <div class="modal-header">
        <h4 class="modal-title">Documentos anexados</h4>
        <button type="button" class="close anexclose" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="">
        <div class="col-12">
          <div class="row">
            <span class="text-primary text-bold" id="msgcarrera"></span>
          </div>
          <hr>
          <div class="d-none d-md-block">
            <div class="row mt-3">
              <div class="col-6">
                  <span class="h6"><b>Documentos</b></span>
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
                    <input class="check checkman" type="checkbox" name="itm<?php echo $doc_anexar->coddocumento ?>" id="itm<?php echo $doc_anexar->coddocumento ?>" value="<?php echo $doc_anexar->coddocumento ?>" data-abrev="<?php echo $doc_anexar->abrevia ?>" />
                    <label class="check__label" for="itm<?php echo $doc_anexar->coddocumento ?>">
                        <i class="fas fa-check"></i>
                        <span class="texto"><?php echo $doc_anexar->nombre ?></span>
                    </label>
                  </div>
              </div>
              <div class="col-6 col-md-2">
                <select class="form-control form-control-sm" id="period_itm<?php echo $doc_anexar->coddocumento ?>" name="period_itm<?php echo $doc_anexar->coddocumento ?>" disabled="">
                    <option value=""></option>
                    <?php foreach ($periodos as $periodo) {?>
                    <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                    <?php } ?>
                  </select>
              </div>
              <div class="col-6 col-md-4">
                  <input type="text" name="txt_itm<?php echo $doc_anexar->coddocumento ?>" id="txt_itm<?php echo $doc_anexar->coddocumento ?>" class="form-control form-control-sm" disabled="">
              </div>
            </div>
            
            <?php } ?> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary anexclose" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary anexclose" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Traslados</h1>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  <section id="s-cargado" class="content pt-2">

    <div id="divboxhistorial" class="card">
      <div class="card-header">
        <!-- <h3 class="card-title"><i class="fas fa-search"></i> Búsqueda</h3> -->
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link active" href="#busqueda" data-toggle="tab">
              <i class="fas fa-search"></i> Búsqueda
            </a>
          </li>
          <li id="tabli-aperturafile" class="nav-item">
            <a class="nav-link" href="#ficha-personal" data-toggle="tab">
              <i class="fas fa-user-plus"></i> Inscripciones
            </a>
          </li>
        </ul>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <div class="active tab-pane pt-3" id="busqueda">
            <form id="frm-filtro-inscritos" name="frm-filtro-inscritos" action="<?php echo $vbaseurl ?>traslados/get_filtrar_basico_sd_traslados" method="post" accept-charset='utf-8'>
              
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
          <div class="tab-pane" id="ficha-personal">
            <form id="frmins-postulante" action="<?php echo $vbaseurl ?>persona/fn_getdatosminimos_x_dni" method="post" accept-charset='utf-8'>
              <b class="d-block pt-2 pb-4 text-danger"><i class="fas fa-user-circle"></i> POSTULANTE</b>
              <!--<label for="ficodpostulante">Nro Postulante:</label>-->

              <div class="row margin-top-20px">
                <div class="input-group mb-3 col-12 col-sm-3">
                  <input placeholder="DNI" type="text" class="form-control" id="ficodpostulante" name="ficodpostulante">
                  <div class="input-group-append">
                    <button data-paterno='' data-materno='' data-nombres='' class="btn btn-info" type="submit" >
                    <i class="fas fa-arrow-alt-circle-right"></i>
                    </button>
                  </div>
                </div>
                <div class="form-group col-12 col-sm-5">
                  <span id="fipos-apellidos" class="form-control bg-light"></span>
                </div>
                <div class="form-group col-12 col-sm-4">
                  <span id="fipos-nombres" class="form-control bg-light"></span>
                </div>
              </div>
            </form>

            <form id="frmins-inscripcion" action="<?php echo $vbaseurl ?>inscrito/fn_insert" method="post" accept-charset='utf-8'>
              <div class="row mt-2">
                <div class="form-group has-float-label col-12 col-sm-3">
                  <select name="cbodispacacidad" id="cbodispacacidad" class="form-control">
                    <option value="NO">NO</option>
                    <option value="SI">SI</option>
                  </select>
                  <label for="cbodispacacidad">¿Tiene alguna discapacidad?</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-4 d-none divcard_detdiscap">
                  <select data-currentvalue='' class="form-control" id="ficbdiscapacidad" name="ficbdiscapacidad" >
                    <option value="0">Selecciona discapacidad</option>
                    <?php 
                    foreach ($discapacidades as $disc) {
                      $grupod = "";
                      if ($disc->detalle != "" || $disc->detalle != null) {
                        $grupod = $disc->grupo." - ".$disc->detalle;
                      } else {
                        $grupod = $disc->grupo;
                      }
                    ?>
                    <option value="<?php echo $disc->codigo ?>"><?php echo $grupod ?></option>
                    <?php } ?>
                  </select>
                  <label for="ficbdiscapacidad"> Discapacidad</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-5 d-none divcard_detdiscap" id="">
                  <input class="form-control" type="text" name="txtdetadiscapac" id="txtdetadiscapac" placeholder="Especificar ¿Cúal es su discapacidad?">
                  <label for="txtdetadiscapac">Especificar ¿Cúal es su discapacidad?</label>
                </div>
              </div>
              <b class="pt-2 pb-4 text-danger d-block"><i class="fas fa-user-circle"></i> PROCESO DE ADMISIÓN</b>
              <input data-currentvalue='' id="fimcid" name="fimcid" type="hidden" />
              <input data-currentvalue='' id="fitxtdni" name="fitxtdni" type="hidden" />
              <input data-currentvalue='' id="ficbcarsigla" name="ficbcarsigla" type="hidden" />
              
              <div class="row margin-top-20px">
                <div class="form-group has-float-label col-12 col-sm-5">
                  <select data-currentvalue='' class="form-control" id="ficbmodalidad" name="ficbmodalidad" placeholder="Modalidad" required >
                    <?php 
                    $nomodalidad = "";
                    foreach ($modalidades as $modalidad) {
                      if ($modalidad->id == 2) {
                        $nomodalidad = $modalidad->nombre;
                      
                    ?>
                    <option value="<?php echo $modalidad->id ?>"><?php echo $nomodalidad ?></option>
                    <?php 
                      }
                    } 
                    ?>
                  </select>
                  <label for="ficbmodalidad"> Modalidad</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-3">
                  <select data-currentvalue='' class="form-control" id="ficbperiodo" name="ficbperiodo" placeholder="Periodo lectivo" required >
                    <option value="0">Selecciona periodo</option>
                    <?php foreach ($periodos as $periodo) {?>
                    <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="ficbperiodo"> Periodo lectivo</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-4">
                  <select data-currentvalue='' class="form-control" id="ficbcampania" name="ficbcampania" placeholder="Campaña" required >
                    <option value="0">Selecciona</option>
                    <?php foreach ($campanias as $campania) {?>
                    <option value="<?php echo $campania->id ?>"><?php echo $campania->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="ficbcampania"> Campaña</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-12 d-none" id="divcard_traslado">
                  <input type="text" name="fictxtinstproceden" id="fictxtinstproceden" placeholder="Instituto de Traslado" class="form-control">
                  <label for="fictxtinstproceden">Instituto de Traslado</label>
                </div>

                <div class="form-group col-12 col-sm-12">
                  <span id="fiins-spcampania" class=" form-control bg-light"></span>
                </div>
              </div>
              <b class="pt-2 pb-4 text-danger d-block"><i class="fas fa-user-circle"></i> DATOS ACADÉMICOS</b>
              <div class="row margin-top-20px">
                <div class="form-group has-float-label col-12 col-sm-5">
                  <select data-currentvalue='' class="form-control" id="ficbcarrera" name="ficbcarrera" placeholder="Programa de estudios" required >
                    <option value="0">Selecciona</option>
                    <?php foreach ($carreras as $carrera) {?>
                    <option value="<?php echo $carrera->codcarrera ?>" data-sigla="<?php echo $carrera->sigla ?>" data-nombre="<?php echo $carrera->nombre ?>"><?php echo $carrera->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="ficbcarrera"> Programa de estudios</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control" id="ficbciclo" name="ficbciclo" placeholder="Semestre Acad." required >
                    <option value="0">Selecciona</option>
                    <?php foreach ($ciclos as $ciclo) {?>
                    <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="ficbciclo"> Semestre Acad.</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-3">
                  <select data-currentvalue='' class="form-control" id="ficbturno" name="ficbturno" placeholder="Turno" required >
                    <option value="0">Selecciona</option>
                    <?php foreach ($turnos as $turno) {?>
                    <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="ficbturno"> Turno</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control" id="ficbseccion" name="ficbseccion" placeholder="Sección" required >
                    <option value="0">Selecciona</option>
                    <?php foreach ($secciones as $seccion) {?>
                    <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="ficbseccion"> Sección</label>
                </div>
                <div class="form-group col-12 col-sm-12">
                  <button type="button" class="btn btn-outline-secondary btn-block text-left" id="btn_docanex" data-toggle="modal" data-target="#modanexadocs">Documentos anexados</button>
                </div>
                <div class="form-group has-float-label col-12 col-sm-12">
                  <textarea class="form-control" id="fitxtobservaciones" name="fitxtobservaciones" placeholder="Observaciones"  rows="3"></textarea>
                  <label for="fitxtobservaciones"> Observaciones</label>
                </div>

                <div class="col-12 mb-3" id="divcard_publicidad">
                  <h4 class="title-seccion text-danger">¿Como se enteró de nuestros programas?</h4>
                  <div class="row ml-3">
                    <?php
                      $nro = 0;
                      foreach ($publicidad as $key => $pb) {
                        $nro ++;
                    ?>
                    <div class="col-12 divcheck">
                      <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input checkpublicidad" id="checkpub<?php echo $nro ?>" data-codigo="<?php echo $pb->codigo ?>">
                          <label class="custom-control-label" for="checkpub<?php echo $nro ?>"><?php echo $pb->nombre ?></label>
                      </div>
                    </div>
                    <?php
                      }
                    ?>
                    
                  </div>
                </div>

                <div class="form-group has-float-label col-12 col-sm-3">
                  <input data-currentvalue='' class="form-control text-uppercase" value="<?php echo date("Y-m-d"); ?>" id="fitxtfecinscripcion" name="fitxtfecinscripcion" type="date" placeholder="Fec. Inscripción"   />
                  <label for="fitxtfecinscripcion">Fec. Inscripción</label>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <span id="fispedit" class="text-danger"></span>
                  <button id="btn-inscribir" data-step='ins' type="submit" class="btn btn-primary btn-lg float-right"><i class="fas fa-arrow-circle-right"></i> Inscribir</button>
                  <button type="button" id="btn-cancelar" class="btn btn-danger btn-lg float-right mr-3"><i class="fas fa-undo"></i> Cancelar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
          
      </div>
      <!-- /.card-body -->
    </div>
    
  </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>
<script>

  $(document).ready(function() {
    // $("#frm-filtro-inscritos").submit();
    if (vdnipostulante!==""){
      $('.nav-pills a[href="#ficha-personal"]').tab('show');
      $("#frmins-postulante #ficodpostulante").val(vdnipostulante);
      $("#frmins-postulante").submit();
    }
    else{
      var jscarnet=getUrlParameter("fcarnet","");
      $("#fbus-txtbuscar").val(jscarnet);
      $("#frm-filtro-inscritos").submit();
      
    }
    $('#ficbmodalidad').change();
  });

  $('#ficbmodalidad').change(function(){
    var combo = $(this);
    var item = combo.val();
    if (item == "0" || item == 1) {
      $('#divcard_traslado').addClass('d-none');
      $("#fictxtinstproceden").prop("required",false);
    } else if (item == 2) {
      $('#divcard_traslado').removeClass('d-none');
      $("#fictxtinstproceden").prop("required",true);
      
    } else if (item == 3) {
      $('#divcard_traslado').addClass('d-none');
      $("#fictxtinstproceden").prop("required",false);
    }
    
  });

  $('#cbodispacacidad').change(function() {
    var combo = $(this);
    var item = combo.val();
    if (item =='SI') {
      $('.divcard_detdiscap').removeClass('d-none');
    } else {
      $('.divcard_detdiscap').addClass('d-none');
    }
  });

  var vdnipostulante='<?php echo $dnipostula; ?>';

  $("#frmins-inscripcion").hide();

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

  $("#frmins-postulante").submit(function(event) {
      $('#frmins-postulante input,select').removeClass('is-invalid');
      $('#frmins-postulante .invalid-feedback').remove();
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
              } else {
                  $('#fimcid').val(e.vdata['idpersona']);
                  $("#frmins-inscripcion")[0].reset();
                  if (e.vdata['idpersona'] == '0') {
                      $('#fipos-apellidos').html('NO ENCONTRADO');
                      $('#fipos-nombres').html('NO ENCONTRADO');
                      $("#frmins-inscripcion").hide();
                      
                  } else {
                      $('#fitxtdni').val(e.vdata['dni']);
                      $('#fipos-apellidos').html(e.vdata['paterno'] + ' ' + e.vdata['materno']);
                      $('#fipos-nombres').html(e.vdata['nombres']);
                      $("#frmins-inscripcion").show();

                  }
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#divboxhistorial #divoverlay').remove();
              $('#divError').show();
              $('#msgError').html(msgf);
          }
      });
      return false;
  });

  $("#btn-cancelar").click(function(event) {
    $("#frmins-inscripcion").hide();
    $("#frmins-inscripcion")[0].reset();
  });

  $("#frmins-inscripcion").submit(function(event) {
      /* Act on the event */
      $('#frmins-inscripcion input,select').removeClass('is-invalid');
      $('#frmins-inscripcion .invalid-feedback').remove();
      $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      var carrera=$("#ficbcarrera option:selected").text();
     

      Arrdocs = [];
      arraypublic = [];
      arraydocs = [];
      
      $('#divcard_publicidad .divcheck .checkpublicidad').each(function() {
        var check = $(this);
        var idpub = "";
        if (check.prop('checked') == true) {
          var idpub = check.data('codigo');
        }

        if (idpub !== "") {
          // var myvals = [idpub];
          arraypublic.push(idpub);
        }
        
      })

      $('#modanexadocs input[type=checkbox]').each(function () {
        if (this.checked) {
            var check=$(this);
            var valor=check.attr('id').substring(3);
            var detalle = $('#txt_'+check.attr('id')).val();
            var periodo = $('#period_'+check.attr('id')).val();

            var myvals = [valor,detalle, periodo];
            arraydocs.push(myvals);
        }
      });

      adocs= JSON.stringify(arraydocs);
      apublic = JSON.stringify(arraypublic);

      fdata=$(this).serializeArray();
      fdata.push({name: 'doc-anexados', value: adocs});
      fdata.push({name: 'inspublicidad', value: apublic});


      $.ajax({
          url: $(this).attr("action"),
          type: 'post',
          dataType: 'json',
          data: fdata,
          success: function(e) {
              $('#divboxhistorial #divoverlay').remove();
              if (e.status == false) {
                 if (e.newcod==0){
                  Swal.fire({
                      type: 'warning',
                      title: 'INSCRIPCIÓN DUPLICADA: ' + carrera,
                      text: e.msg,
                      backdrop:false,
                  })
                }else{
                   $.each(e.errors, function(key, val) {
                      $('#' + key).addClass('is-invalid');
                      $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                  });
                  Swal.fire({
                      type: 'error',
                      title: 'Error, INSCRIPCIÓN NO registrada',
                      text: e.msg,
                      backdrop:false,
                  })
                }
              } else {
                var sb=(getUrlParameter("sb","")=="") ? "":"&sb=admision";
                location.href = base_url + "admision/traslados?fcarnet=" + e.newcarnet + sb;

                  Swal.fire({
                    type: 'success',
                    title: 'Felcicitaciones, inscripción registrada',
                    text: e.newcarnet,
                    backdrop:false,
                  })
                  $("#frmins-inscripcion").hide();
                  $("#frmins-inscripcion")[0].reset();
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#divboxhistorial #divoverlay').remove();
              $('#divError').show();
              $('#msgError').html(msgf);
          }
      });
      return false;
  });

  $("#frmins-inscripcion #ficbperiodo").change(function(event) {
      var cbcmp = $('#frmins-inscripcion #ficbcampania');
      $('#frmins-inscripcion #fiins-spcampania').html("");
      cbcmp.html("<option value='0'>Sin opciones</option>");
      var codperiodo = $(this).val();
      if (codperiodo == '0') return;
      $.ajax({
          url: base_url + 'campania/fn_campania_por_periodo',
          type: 'post',
          dataType: 'json',
          data: {
              txtcodperiodo: codperiodo
          },
          success: function(e) {
              cbcmp.html(e.vdata);
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              cbcmp.html("<option value='0'>" + msgf + "</option>");
          }
      });
  });

  $("#frmins-inscripcion #ficbcampania").change(function(event) {
      var cbcmp = $('#frmins-inscripcion #fiins-spcampania');
      cbcmp.html("");
      if ($(this).val !== "0") cbcmp.html($('option:selected', this).data('descripcion'))
  });

  $("#frmins-inscripcion #ficbcarrera").change(function(event) {
      var cbcmp = $('#frmins-inscripcion #ficbcarsigla');
      cbcmp.html("");
      if ($(this).val !== "0") cbcmp.val($('option:selected', this).data('sigla'))
  });

  $('.check').change(function(e) {
    $('#frm-docanexar input[type=checkbox]').each(function () {
          if (this.checked) {
            var check=$(this);
            var codigo = check.attr('id');
            var valor=check.attr('id').substring(2);
            $('#frm-docanexar #period_'+check.attr('id')).attr('disabled', false);
            $('#frm-docanexar #txt_'+check.attr('id')).attr('disabled', false);
            $('#frm-docanexar #txt_'+check.attr('id')).focus();
            
          } else {
            var check=$(this);
            $('#frm-docanexar #period_'+check.attr('id')).val('');
            $('#frm-docanexar #period_'+check.attr('id')).attr('disabled', true);
            $('#frm-docanexar #txt_'+check.attr('id')).attr('disabled', true);
            $('#frm-docanexar #txt_'+check.attr('id')).val("");
          }
    });
  });

  $("#frm-docanexar").submit(function(event) {
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var cins=$("#fdacodins").val();
    var arrdata = [];

    $('#frm-docanexar input[type=checkbox]').each(function () {
          if (this.checked) {
            var check=$(this);
            var valor=check.attr('id').substring(2);
            var detalle = $('#frm-docanexar #txt_'+check.attr('id')).val();
            var periodo = $('#frm-docanexar #period_'+check.attr('id')).val();

            var myvals = [valor, detalle, periodo];
            arrdata.push(myvals);
          }
    });
    //************************************
    $.ajax({
      url: base_url + 'inscrito/fn_insertdocs',
      type: 'post',
      dataType: 'json',
      data: {
              'ce-idins': cins,
              'filas': JSON.stringify(arrdata),
          },
      success: function(e) {
          $('#divboxhistorial #divoverlay').remove();
          if (e.status == false) {
              Swal.fire({
                  type: 'error',
                  icon: 'error',
                  title: 'Error!',
                  text: e.msg,
                  backdrop: false,
              })
          } else {
              /*$("#fm-txtidmatricula").html(e.newcod);*/
              $('#modal-docporanexar').modal('hide')
              Swal.fire({
                  type: 'success',
                  icon: 'success',
                  title: 'Actualización correcta',
                  text: 'Se ha actualizaron los datos de la inscripción',
                  backdrop: false,
              })

              
              
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#divboxhistorial #divoverlay').remove();
          Swal.fire({
              type: 'error',
              icon: 'error',
              title: 'Error',
              text: msgf,
              backdrop: false,
          })
      }
    });
    return false;
    //***************************************
  });

  $('.checkman').change(function(e) {
    docarray = [];
    $('#modanexadocs input[type=checkbox]').each(function () {
        if (this.checked) {
            var check=$(this);
            var valor=check.attr('id').substring(3);
            var abrev = check.data('abrev');
            $('#period_'+check.attr('id')).attr('disabled', false);
            $('#txt_'+check.attr('id')).attr('disabled', false);
            $('#txt_'+check.attr('id')).focus();

            docarray.push(abrev);
            
        } else {
            var check=$(this);
            $('#period_'+check.attr('id')).val('');
            $('#period_'+check.attr('id')).attr('disabled', true);
            $('#txt_'+check.attr('id')).attr('disabled', true);
            $('#txt_'+check.attr('id')).val("");
        }
    });
    docsanex = JSON.stringify(docarray);
    if (docarray.length > 0) {
      $('#btn_docanex').html("Documentos anexados: "+docsanex);
    } else {
      $('#btn_docanex').html("Documentos anexados");
    }
    
  });

  $('#modanexadocs').on('show.bs.modal', function (e) {
    $('#msgcarrera').html('');
    if ($('#ficbcarrera').val !== "0") $('#msgcarrera').html($('option:selected', $('#ficbcarrera')).data('nombre'));
  })

</script>