<?php $fechahoy = date('Y-m-d'); ?>
<!-- MODAL INSERTAR Y EDITAR MATRICULA -->
<div class="modal fade" id="modupmat" tabindex="-1" role="dialog" aria-labelledby="modupmat" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content" id="divmodaddmatricula">
      <div class="modal-header d-inline pb-0">
        <div class="row">
          <div class="col-10">
            <h5 id="titlemodal" class="modal-title text-bold px-1" >MATRICULAR</h5>
          </div>
          <div class="col-2 text-right" id="divsearch_ins" style="display: none;">
            <button class="btn btn-success" data-toggle="modal" data-target="#modfiltroins">
              <i class="fas fa-search"></i> Buscar alumno
            </button>
          </div>
          <div class="col-12">
            <h6 id="fm-carreraup" class="border rounded px-1 py-1 bg-light">PROGRAMA ACADÉMICO</h6>
          </div>
        </div>
      </div>
      <div class="modal-body pt-1">


        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-matricular-tab" data-toggle="tab" href="#nav-matricular" role="tab" aria-controls="nav-matricular" aria-selected="true">Matrícular</a>
            <a class="nav-item nav-link" id="nav-macadem-tab" data-toggle="tab" href="#nav-macadem" role="tab" aria-controls="nav-macadem" aria-selected="false">Académico <span id="nrodesap"></span></a>
            <a class="nav-item nav-link" id="nav-mdeudas-tab" data-toggle="tab" href="#nav-mdeudas" role="tab" aria-controls="nav-mdeudas" aria-selected="false">Deudas <span id="nrodeudas"></span></a>
            <!--<div class="col-1 col-sm-1 text-center mt-2" id="btn_refresh_cond" style="display: none;" >-->
            <a class="nav-item nav-link ml-auto"  role="tab" style="display: none;" href="#" onclick="fn_refresca_condicional($(this));return false;" data-carne="" id="lbtn_condic_refresh">
              <i class="fas fa-sync-alt fa-lg"></i>
            </a>


          </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active mt-2" id="nav-matricular" role="tabpanel" aria-labelledby="nav-matricular-tab">
            <div class="row">
              <div class="col-12 col-md-8 border-right">
                <div class="alert alert-warning alert-dismissible fade show" id="divalert_mat" style="display: none;">
                  <strong>Aviso:</strong> Antes de realizar una matricula debe de buscar y seleccionar al estudiante
                </div>

                <form id="frm_updmatri" action="<?php echo base_url() ?>matricula/fn_insert_update_matricula" method="post" accept-charset="utf-8">
                  <b class="text-danger pt-3"><i class="fas fa-user-graduate mr-1"></i> PROCESO DE MATRÍCULA</b>
                  <input data-currentvalue="" id="fm-txtidmatriculaup" name="fm-txtidmatriculaup" type="hidden" value="0">
                  <input data-currentvalue="" id="fm-txtidup" name="fm-txtidup" type="hidden">
                  <input data-currentvalue="" id="fm-txtcarreraup" name="fm-txtcarreraup" type="hidden">
                  <input data-currentvalue="" id="fm-txtperiodoup" name="fm-txtperiodoup" type="hidden">
                  <input id="fm-txtplanup" name="fm-txtplanup" type="hidden">
                  <input id="fm-txtmapepatup" name="fm-txtmapepatup" type="hidden">
                  <input id="fm-txtmapematup" name="fm-txtmapematup" type="hidden">
                  <input id="fm-txtmnombresup" name="fm-txtmnombresup" type="hidden">
                  <input id="fm-txtmsexoup" name="fm-txtmsexoup" type="hidden">
                  
                  <div class="row mt-3">
                    <?php if (getPermitido("151")=='SI'): ?>
                    <!--SOLO APARECE SI TIENE PERMISO DE EDITAR SEDE DE MATRICULA-->
                    <div class="form-group has-float-label col-12 col-sm-6 col-md-3">
                      <select name="fm-cbsedeup" id="fm-cbsedeup" class="form-control form-control-sm">
                        
                        <?php
                        $codsede=$_SESSION['userActivo']->idsede;
                        foreach ($sedes as $sede) {
                        $selsede=($codsede==$sede->id)?"selected":"";
                        echo "<option $selsede value='$sede->id'>$sede->nombre </option>";
                        } ?>
                      </select>
                      <label for="fm-cbsedeup">Filial</label>
                    </div>
                    <?php endif ?>
                    <div class="form-group has-float-label col-12 col-sm-6 col-md-4">
                      <select data-currentvalue="" class="form-control form-control-sm" id="fm-cbtipoup" name="fm-cbtipoup" required="">
                        <option value="0"></option>
                        <option data-nromat="1" value="O">Matricula Ordinaria</option>
                        <option data-nromat="1" value="E">Matricula Extraordinaria</option>
                        <option data-nromat="2" value="RO">Ratificación Ordinaria</option>
                        <option data-nromat="2" value="RE">Ratificación Extraordinaria</option>
                      </select>
                      <label for="fm-cbtipoup">Tipo</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-12 col-md-5">
                      <input data-currentvalue="" class="form-control form-control-sm text-uppercase" value="<?php echo $fechahoy ?>" id="fm-txtfecmatriculaup" name="fm-txtfecmatriculaup" type="date" placeholder="Fec. Matrícula">
                      <label for="fm-txtfecmatriculaup">Fec. Matrícula</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group has-float-label col-12 col-sm-3">
                      <select data-currentvalue="" class="form-control form-control-sm" id="fm-cbperiodoup" name="fm-cbperiodoup" required="">
                        <option value="0"></option>
                        <?php foreach ($periodos as $periodo) {?>
                        <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fm-cbperiodoup"> Periodo</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-4">
                      <select data-currentvalue="" class="form-control form-control-sm" id="fm-cbcicloup" name="fm-cbcicloup" required="">
                        <option value="0"></option>
                        <?php foreach ($ciclos as $ciclo) {?>
                        <option data-autorizado='SI' data-codigo='<?php echo $ciclo->codigo ?>' value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fm-cbcicloup"> Semestre</label>
                    </div>

                    <div class="form-group has-float-label col-12 col-sm-3">
                      <select data-currentvalue="" class="form-control form-control-sm" id="fm-cbturnoup" name="fm-cbturnoup" required="">
                        <option value="0"></option>
                        <?php foreach ($turnos as $turno) {?>
                        <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fm-cbturnoup"> Turno</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-2">
                      <select data-currentvalue="" class="form-control form-control-sm" id="fm-cbseccionup" name="fm-cbseccionup" required="">
                        <option value="0"></option>
                        <?php foreach ($secciones as $seccion) {?>
                        <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fm-cbseccionup"> Sección</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group has-float-label col-12 col-sm-3 col-md-3">
                      <select data-currentvalue="" class="form-control form-control-sm" id="fm-cbplanup" name="fm-cbplanup" required="">
                        
                      </select>
                      <label for="fm-cbplanup"> Plan de Estudio</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-4 col-md-4">
                      <select data-currentvalue="" class="form-control form-control-sm" id="fm-cbestadoup" name="fm-cbestadoup" required="">
                        <option value="0">Selecciona un estado</option>
                        <?php foreach ($estados as $est) {?>
                        <option value="<?php echo $est->codigo ?>"><?php echo $est->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fm-cbestadoup"> Estado</label>
                    </div>

                  </div>

                  <div class="row">
                    <div class="form-group col-12">
                      <b class="text-danger pt-3"><i class="far fa-money-bill-alt mr-1"></i> DATOS ECONÓMICOS</b>
                    </div>
                    
                    <div class="form-group has-float-label col-12 col-sm-3">
                      <select data-currentvalue="" class="form-control form-control-sm" id="fm-cbbeneficioup" name="fm-cbbeneficioup" required="">
                        <?php foreach ($beneficios as $beneficio) {?>
                        <option value="<?php echo $beneficio->id ?>"><?php echo $beneficio->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fm-cbbeneficioup"> Beneficio</label>
                    </div>
                    
                    <div class="form-group has-float-label col-12 col-sm-4">
                      <input data-currentvalue="" class="form-control form-control-sm" type="number" step="0.01" value="0.00" id="fm-txtcuotaup" name="fm-txtcuotaup" placeholder="Cuota">
                      <label for="fm-txtcuotaup">Cuota Dscto</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-3">
                      <input data-currentvalue="" class="form-control form-control-sm" type="number" step="0.01" value="0.00" id="fm-txtcuotaupreal" name="fm-txtcuotaupreal" placeholder="Cuota">
                      <label for="fm-txtcuotaupreal">Cuota Real</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group has-float-label col-12 col-sm-3">
                      <select data-currentvalue="" class="form-control form-control-sm checkdocumento" id="fm-tipdocuf" name="fm-tipdocuf">
                        <?php
                          foreach ($tipdoc as $key => $tdocf) {
                            echo "<option value='$tdocf->codigo'>$tdocf->nombre</option>";
                          }
                        ?>
                        
                      </select>
                      <label for="fm-tipdocuf"> Tipo Doc.</label>
                    </div>

                    <div class="form-group has-float-label col-12 col-sm-4">
                      <input type="text" name="fm-serie" id="fm-serie" placeholder="Serie" class="form-control form-control-sm checkdocumento">
                      <label for="fm-serie"> Serie</label>
                    </div>

                    <div class="form-group col-12 col-sm-3">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-sm checkdocumento" name="fm-numdocum" id="fm-numdocum" placeholder="N° Documento">
                        <div class="input-group-prepend">
                          <button type="button" id="btn_doc_search" class="btn btn-sm btn-info btn_search_bol">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-12 col-sm-2 border">
                      <button class="btn btn-sm btn-outline-secondary" title="visualizar pagos" onclick="fn_view_data_pagos($(this));return false;" data-pagante="" data-pagantenb="" id="btn_view_pagos">
                        <i class="fas fa-money-bill-alt"></i>
                      </button>
                    </div>
                    <div class="col-12 form-groupx border my-0">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkdocumen" name="checkdocumen">
                        <label for="checkdocumen">Sin Documento de Pago</label>
                      </div>
                    </div>
                    <div class="col-12" id="msg_rpta_documento"></div>
                  </div>
                  <div class="row">
                    <div class="form-group has-float-label col-12 col-xs-12 col-sm-12">
                      <textarea class="form-control text-uppercase" id="fm-txtobservacionesup" name="fm-txtobservacionesup" rows="3" placeholder="Observaciones"></textarea>
                      <label for="fm-txtobservacionesup"> Observaciones</label>
                    </div>
                  </div>
                </form>

              </div>
              <div class="col-12 col-md-4">
                <div class="row">
                  <div class="col-12">
                    <div id="msgdeuda_estudiante"></div>
                  </div>

                  <div class="col-12">
                    <div id="msgdesaprobados_estudiante"></div>
                  </div>
                  <div class="col-12 mt-3">
                    <div class='btable'>
                      <div class='thead col-12 bg-lightgray'>
                        <div class='row'>
                          <div class='col-12 col-md-12 td text-center'>
                            <span>Historial de Matriculas</span>
                          </div>
                        </div>
                      </div>
                      <div class='thead col-12 bg-lightgray'>
                        <div class='row'>
                          <div class='col-4 col-md-4 td'>
                            <span>Fec.Mat</span>
                          </div>
                          <div class='col-4 col-md-4 td'>
                            <span>Grupo</span>
                          </div>
                          <div class='col-4 col-md-4 td'>
                            <span>Estado</span>
                          </div>
                        </div>
                      </div>
                      <div class='tbody col-12' id="msghistorial_estudiante">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>

          <div class="tab-pane fade" id="nav-macadem" role="tabpanel" aria-labelledby="nav-macadem-tab">
            <div class="row">
              <div class="col-12 col-md-6">
                <div id="divcard_academico">
                  <div class='col-12 py-1 mt-2'>
                      <div class='btable'>
                          <div class='thead col-12  d-none d-md-block bg-lightgray'>
                              <div class='row'>
                                  <div class='col-12 col-md-5'>
                                      <div class='row'>
                                          <div class='col-2 col-md-2 td'>N°</div>
                                          <div class='col-10 col-md-10 td'>UNID.DIDACTICA</div>
                                      </div>
                                  </div>
                                  <div class='col-12 col-md-7'>
                                      <div class='row'>
                                          <div class='col-6 col-md-3 td text-center'>SEMESTRE</div>
                                          <div class='col-6 col-md-3 td text-center'>TUR/SEC</div>
                                          <div class='col-4 col-md-2 td text-center'>NF</div>
                                          <div class='col-4 col-md-2 td text-center'>NR</div>
                                          <div class='col-4 col-md-2 td text-center'>PF</div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class='tbody col-12' id='divcard_data_academ'>

                          </div>
                      </div>
                  </div>
                </div>

              </div>
              <div class="col-12 col-md-6">
                <div class='col-12 py-1 mt-2'>
                    <div class='btable'>
                        <div class='thead col-12 bg-lightgray'>
                          <div class='row'>
                              <div class='col-12 col-md-12 td text-center'>
                                UNIDADES DIDÁCTICAS DESAPROBADAS
                              </div>
                          </div>
                        </div>
                        <div class='thead col-12  d-none d-md-block bg-lightgray'>
                            <div class='row'>
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-2 col-md-2 td'>N°</div>
                                        <div class='col-10 col-md-10 td'>UNID.DIDACTICA</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-7'>
                                    <div class='row'>
                                        <div class='col-6 col-md-3 td text-center'>SEMESTRE</div>
                                        <div class='col-6 col-md-3 td text-center'>TUR/SEC</div>
                                        <div class='col-4 col-md-2 td text-center'>NF</div>
                                        <div class='col-4 col-md-2 td text-center'>NR</div>
                                        <div class='col-4 col-md-2 td text-center'>PF</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='tbody col-12' id='divcard_data_desaprobados'>

                        </div>
                    </div>
                </div>
              </div>
            </div>
            
          </div>

          <div class="tab-pane fade" id="nav-mdeudas" role="tabpanel" aria-labelledby="nav-mdeudas-tab">
            <div id="divcard_deudas">
              <div class='col-12 py-1 mt-2'>
                  <div class='btable'>
                      <div class="col-md-12 thead d-none d-md-block bg-lightgray">
                          <div class="row">
                              <div class="col-sm-1 col-md-1 td">COD</div>
                              <div class="col-sm-2 col-md-3 td">DEUDOR</div>
                              <div class="col-sm-2 col-md-3 td">CONCEPTO</div>
                              <div class="col-sm-2 col-md-2 td">SALDO</div>
                              <div class="col-sm-2 col-md-3 td">GRUPO</div>
                          </div>
                      </div>
                      <div class='tbody col-12' id='divcard_data_deudas'>

                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
      <div class="modal-footer d-inline">
        <div class="row">
          <div id="msgcursos_deudas" class="col-10 p-0">
            
          </div>
          <div class="col-2 p-0 text-right">
            <?php if (getPermitido("175")=="SI"): ?>
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="switch_forzar_matricula">
              <label class="custom-control-label" for="switch_forzar_matricula">Forzar Matrícula</label>
            </div>
            <?php endif ?>
            
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" id="lbtn_editamat" class="btn btn-primary">Guardar</button>
          </div>
       </div>
        
      </div>
    </div>
  </div>
</div>

<!-- MODAL BUSCAR ALUMNO -->
<div class="modal fade" id="modfiltroins" tabindex="-1" role="dialog" aria-labelledby="modfiltroins" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content" id="divmodalsearch">
      <div class="modal-header">
        <h5 class="modal-title" >Buscar Inscritos Activos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm-getinscritonew" action="<?php echo base_url() ?>matricula/fn_filtrar_inscritos" method="post" accept-charset="utf-8">
          
          
          <div class="row pt-1">
            <div class="col-12">
              <small>Ingresa Apellidos y nombres</small>
            </div>
            <div class="input-group mb-3 col-12 col-xs-12 col-sm-12">
              <input autocomplete="off" placeholder="Apellidos y nombres" type="text" class="form-control text-uppercase" id="fbus-txtbuscar" name="fbus-txtbuscar">
              <div class="input-group-append">
                <button data-paterno="" data-materno="" data-nombres="" class="btn btn-info" type="submit">
                <i class="fas fa-arrow-alt-circle-right"></i>
                </button>
              </div>
            </div>
          </div>
        </form>
        <div id="divcard_result"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" id="lbtn_editamat" class="btn btn-primary">Guardar</button> -->
      </div>
    </div>
  </div>
</div>
<!-- MODAL PAGOS REALIZADOS -->
<div class="modal fade" id="modPagos_asignar" tabindex="-1" role="dialog" aria-labelledby="modPagos_asignar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modPagos_asignar_content">
            <div class="modal-header">
                <h5 class="modal-title" >Pagos Realizados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 border rounded p-1 bg-lightgray" >
                    <h4 id="vw_md_pagos_estudiante"></h4>
                </div>
                <hr>
                <!-- <input type="text" value="0" id="vw_mdp_txtcoddeuda"> -->
                <div class="col-12 btable">
                    <div class="col-md-12 thead d-none d-md-block">
                        <div class="row">
                            <div class="col-sm-1 col-md-1 td hidden-xs">N°</div>
                            <div class="col-sm-2 col-md-2 td">TIPO / NRO</div>
                            <div class="col-sm-2 col-md-2 td">EMISIÓN</div>
                            <div class="col-sm-2 col-md-4 td">CONCEPTOS</div>
                            <div class="col-sm-2 col-md-2 td">SALDO</div>
                            <div class="col-sm-1 col-md-1 td text-center"></div>
                        </div>
                    </div>
                    <div class="col-md-12 tbody" id="div_Pagos_Asignar">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>

<script>

// ===== SCRIPT NUEVOS ========
$("#modupmat").on('shown.bs.modal', function(e) {
    var rel = $(e.relatedTarget);
    var idmat = rel.data('cm');
    var carne = rel.data('carne');
    var accion = rel.data('accion');
    if (accion == "EDITAR") {
        $('#divsearch_ins').hide();
        $('#divalert_mat').hide();
        $('#lbtn_condic_refresh').hide();
        $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#divmodaddmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'matricula/fn_matricula_x_codigo',
            type: 'post',
            dataType: 'json',
            data: {
                'ce-idmat': idmat,
            },
            success: function(e) {
                $('#divcard-matricular #divoverlay').remove();
                $('#divmodaddmatricula #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Error!',
                        text: e.msg,
                        backdrop: false,
                    })
                } else {
                    $('#titlemodal').html("<span class='text-danger'>"+carne+"</span> / "+e.matdata['nomalu']);
                    $('#fm-txtidmatriculaup').val(e.matdata['id64']);
                    $('#fm-txtidup').val(e.matdata['idins64']);
                    $('#fm-txtcarreraup').val(e.matdata['codcarrera']);
                    $('#fm-txtperiodoup').val(e.matdata['codperiodo'])
                    $('#fm-txtplanup').val(e.matdata['codplan']);
                    $('#fm-cbplanup').html(e.vplanes);
                    $('#fm-cbplanup').val(e.matdata['codplan']);
                    $('#fm-cbestadoup').html(e.vestados);
                    $('#fm-cbestadoup').val(e.matdata['estado']);
                    $('#fm-cbtipoup').val(e.matdata['tipo']);
                    $('#fm-cbbeneficioup').val(e.matdata['beneficio']);
                    $('#fm-txtfecmatriculaup').val(e.matdata['fecha']);
                    $('#fm-txtcuotaup').val(e.matdata['pension']);
                    $('#fm-cbperiodoup').attr('disabled', true);
                    $('#fm-cbperiodoup').val(e.matdata['codperiodo']);
                    $('#fm-carreraup').html(e.matdata['carrera']);
                    $('#fm-cbcicloup').val(e.matdata['codciclo']);
                    $('#fm-cbturnoup').val(e.matdata['codturno']);
                    $('#fm-cbseccionup').val(e.matdata['codseccion']);
                    $('#fm-txtcuotaupreal').val(e.matdata['pension_real']);
                    if (vpermiso151 == "SI") {
                        $('#fm-cbsedeup').val(e.matdata['codsede']);
                    }
                    $('#fm-txtobservacionesup').val(e.matdata['observacion']);
                    $("#frm_updmatri #fm-cbcicloup").change();
                    fn_data_academico(carne);
                    fn_data_deudas(carne);
                    fn_historias_matriculas(carne,0);

                    check = false;
                    if (e.matdata['fsindoc'] == "SI") {
                      check = true;
                      
                    }
                    $("#checkdocumen").prop('checked', check);
                    $("#checkdocumen").change();

                    $('#fm-tipdocuf').val(e.matdata['ftipodoc']);
                    $('#fm-serie').val(e.matdata['fserie']);
                    $("#fm-numdocum").val(e.matdata['fnumero']);

                    $('#btn_view_pagos').data('pagante', carne);
                    $('#btn_view_pagos').data('pagantenb', e.matdata['nomalu']);

                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divcard-matricular #divoverlay').remove();
                $('#divmodaddmatricula #divoverlay').remove();
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: 'Error',
                    text: msgf,
                    backdrop: false,
                })
            }
        });

    } else {
        $('#divsearch_ins').show();
        $('#fm-cbperiodoup').attr('disabled', false);
        $('#divalert_mat').show();
        // $('#lbtn_condic_refresh').show();
        var carne = getUrlParameter("fcarnet","");
        if (carne!=="") {

        } else {
          $('#modfiltroins').modal('show');
        }
        
    }
});

$("#modupmat").on('hidden.bs.modal', function(e) {
    $("#frm_updmatri")[0].reset();
    $('#fm-txtidmatriculaup').val('0');
    $('#titlemodal').html("MATRICULAR");
    $('#fm-txtidup').val('');
    $('#fm-txtcarreraup').val('');
    $('#fm-txtperiodoup').val('')
    $('#fm-txtplanup').val('');
    $('#fm-cbplanup').html('');
    $('#divcard_data_academ').html('');
    $('#divcard_data_deudas').html('');
    $('#nav-matricular-tab').addClass('active');$('#nav-matricular').addClass('show active');
    $('#nav-macadem-tab').removeClass('active');$('#nav-macadem').removeClass('show active');
    $('#nav-mdeudas-tab').removeClass('active');$('#nav-mdeudas').removeClass('show active');
    $('#nrodeudas').html("");
    $('#nrodeudas').removeClass("badge bg-danger");
    $('#msgdeuda_estudiante').html("");
    $('#nrodesap').removeClass("badge bg-danger");
    $('#nrodesap').html("");
    $('#msgdesaprobados_estudiante').html("");
    $('#msghistorial_estudiante').html("");
    $('#msgcursos_deudas').html('');

    $("#frm_updmatri #fm-cbcicloup option").each(function(i) {
      $(this).removeClass('ocultar');
      $(this).data('autorizado', 'SI');
    })

    $("#frm_updmatri #fm-cbtipoup option").each(function(i) {
      $(this).removeClass('ocultar');
    })

    $('#msg_rpta_documento').html('');

    $('#btn_view_pagos').data('pagante', "");
    $('#btn_view_pagos').data('pagantenb', "");
    $('#lbtn_editamat').show();
    $("#checkdocumen").change();

    $('#switch_forzar_matricula').prop('checked', false);
})

$('#modfiltroins').on('hidden.bs.modal', function(e) {
    $('#frm-getinscritonew')[0].reset();
    $('#fgi-apellidosnew').html('');
    $('#fgi-nombresnew').html('');
    $('#divcard_result').html('');
})

$('#modfiltroins').on('shown.bs.modal', function(e) {
    $('#fbus-txtbuscar').focus();
})

$('#lbtn_editamat').click(function(e) {
    $('#frm_updmatri input,select').removeClass('is-invalid');
    $('#frm_updmatri .invalid-feedback').remove();
    $('#divmodaddmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $("#frm_updmatri").attr("action"),
        type: 'post',
        dataType: 'json',
        data: $('#frm_updmatri').serialize(),
        success: function(e) {
            $('#divmodaddmatricula #divoverlay').remove();
            if (e.status == false) {
                if (e.newcod == 0) {
                    Swal.fire({
                        type: 'warning',
                        icon: 'warning',
                        title: 'Matrícula DUPLICADA',
                        text: e.msg,
                        backdrop: false,
                    })
                } else {
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Error, matrícula NO actualizada',
                        text: e.msg,
                        backdrop: false,
                    })
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                }
            } else {
                $("#modupmat").modal('hide');
                if (e.matstatus == "INSERTAR") {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'Felicitaciones, matrícula registrada',
                        text: 'Se han registrado cursos',
                        backdrop: false,
                    })

                } else {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'Felicitaciones, Matrícula actualizada correctamente',
                        text: 'verificar sus unidades didácticas de ser necesario',
                        backdrop: false,
                    })
                    $("#frmfiltro-matriculas").submit();
                }


            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodaddmatricula #divoverlay').remove();
            Swal.fire({
                type: 'error',
                icon: 'error',
                title: 'Error, matrícula NO actualizada',
                text: msgf,
                backdrop: false,
            })
        }
    });
    return false;
});

$("#frm-getinscritonew").submit(function(event) {
    $('#frm-getinscritonew input').removeClass('is-invalid');
    $('#frm-getinscritonew .invalid-feedback').remove();
    $('#divmodalsearch').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divmodalsearch #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire({
                    type: 'warning',
                    icon: 'warning',
                    title: 'ADVERTENCIA',
                    text: e.msg,
                    backdrop: false,
                })
            } else {
                $('#divcard_result').html('');
                var tabla = '';
                var tbody = '';
                var estado = '';
                // var viewmat = matricula;
                var btnselect = '';
                tabla = '<div class="col-12 py-1">' +
                    '<div class="btable">' +
                    '<div class="thead col-12  d-none d-md-block">' +
                    '<div class="row">' +
                    '<div class="col-12 col-md-5">' +
                    '<div class="row">' +
                    '<div class="col-2 col-md-2 td">N°</div>' +
                    '<div class="col-10 col-md-10 td">ESTUDIANTE</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-12 col-md-6">' +
                    '<div class="row">' +
                    '<div class="col-3 col-md-3 td">ESTADO</div>' +
                    '<div class="col-9 col-md-4 td">PROG.</div>' +
                    '<div class="col-9 col-md-5 td">PERIODO</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-12 col-md-1 text-center">' +
                    '<div class="row">' +
                    '<div class="col-12 col-md-12 td">' +
                    '<span></span>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +

                    '</div>' +
                    '<div class="tbody col-12" id="divcard_data_alumnos">' +

                    '</div>' +
                    '</div>' +
                    '</div>';
                var nro = 0;
                $.each(e.vdata, function(index, val) {
                    nro++;
                    if (val['estado'] == "ACTIVO") {
                        estado = "<span class='badge bg-success p-2'> " + val['estado'] + " </span>";
                        btnselect = "<a href='#' onclick='fn_select_inscrito($(this),null);return false;' class='btn btn-info btn-sm btn_select' title='seleccionar'><i class='fas fa-share'></i></a>";
                    } else if (val['estado'] == "POSTULA") {
                        estado = "<span class='badge bg-warning p-2'> " + val['estado'] + " </span>";
                        btnselect = '';
                    } else if (val['estado'] == "EGRESADO") {
                        estado = "<span class='badge bg-secondary p-2'> " + val['estado'] + " </span>";
                        btnselect = '';
                    } else if (val['estado'] == "RETIRADO") {
                        estado = "<span class='badge bg-danger p-2'> " + val['estado'] + " </span>";
                        btnselect = '';
                    } else if (val['estado'] == "TITULADO") {
                        estado = "<span class='badge bg-info p-2'> " + val['estado'] + " </span>";
                        btnselect = '';
                    } else {
                        estado = "<span class='badge bg-warning p-2'> " + val['estado'] + " </span>";
                        btnselect = '';
                    }
                    if (val['estado'] !== "RETIRADO") {
                        tbody = tbody +
                            "<div class='row rowcolor cfilains' data-carnet='" + val['carnet'] + "' data-alumno='" + val['paterno'] + " " + val['materno'] + " " + val['nombres'] + "'>" +
                            "<div class='col-12 col-md-5'>" +
                            "<div class='row'>" +
                            "<div class='col-2 col-md-2 text-right td'>" + nro + "</div>" +
                            "<div class='col-2 col-md-3  td'>" + val['carnet'] + "</div>" +
                            "<div class='col-10 col-md-7 td' title='" + val['codinscripcion'] + "'>" + val['paterno'] + " " + val['materno'] + " " + val['nombres'] + "</div>" +
                            "</div>" +
                            "</div>" +
                            "<div class='col-12 col-md-6'>" +
                            "<div class='row'>" +
                            "<div class='col-3 col-md-3 td'>" + estado + "</div>" +
                            "<div class='col-9 col-md-4 td' title='" + val['carrera'] + "'>" + val['carsigla'] + " / " + val['codturno'] + " - " + val['ciclo'] + " - " + val['codseccion'] + "</div>" +
                            "<div class='col-9 col-md-5 td'>" + val['periodo'] + " / " + val['campania'] + "</div>" +
                            "</div>" +
                            "</div>" +
                            "<div class='col-12 col-md-1 text-center td'>" +
                            btnselect +
                            "</div>" +
                            "</div>";
                    }

                })
                $('#divcard_result').html(tabla);
                $('#divcard_data_alumnos').html(tbody);
                

            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodalsearch #divoverlay').remove();
            $('#divError').show();
            $('#msgError').html(msgf);
        }
    });
    return false;
});

function fn_select_inscrito(btn,view) {
  // var boton = $(this);
  if (view == null) {
    var fila = btn.closest('.cfilains');
    var carne = fila.data('carnet');
    var alumno = fila.data('alumno');
  } 
  else if (view=='pagos'){
    var carne = btn['carnet'];
    var iddoc = btn['iddocpago'];
    // var alumno = getUrlParameter("festudent","");
  }
  else{
    var carne = getUrlParameter("fcarnet","");
  }
  

  $('#divmodalsearch').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
      url: base_url + "matricula/fn_get_datos_hmatricula_carne",
      type: 'post',
      dataType: 'json',
      data: {
          'fgi-txtcarne': carne,
      },
      success: function(e) {
          $('#divmodalsearch #divoverlay').remove();
          if (e.status == false) {
              $.each(e.errors, function(key, val) {
                  $('#' + key).addClass('is-invalid');
                  $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
              });
              Swal.fire({
                  type: 'warning',
                  icon: 'warning',
                  title: 'ADVERTENCIA',
                  text: e.msg,
                  backdrop: false,
              })
          } else {
              $('#modfiltroins').modal('hide');
              $('#fm-txtidup').val(e.vdata['idinscripcion']);
              $('#fm-txtidmatriculaup').val('0');
              $("#frm_updmatri")[0].reset();
              $('#frm_updmatri input,select').removeClass('is-invalid');
              $('#frm_updmatri .invalid-feedback').remove();
              if (e.vdata['idinscripcion'] == '0') {
                  $('#fm-txtcarreraup').val("");
                  $('#fm-carreraup').val("PROGRAMA ACADÉMICO");
                  $('#fm-cbplanup').html("<option value='0'>Plán curricular NO DISPONIBLE</option>");
                  $('#btn_view_pagos').data('pagante', "");
                  $('#btn_view_pagos').data('pagantenb', "");

              } else {
                  $('#divalert_mat').hide();
                  var estudiante = e.vdata['paterno'] + " " + e.vdata['materno'] + " " + e.vdata['nombres'];
                  $('#titlemodal').html("<span class='text-danger'>"+carne+"</span> / "+estudiante);
                  $('#fm-txtcarreraup').val(e.vdata['codcarrera']);
                  $('#fm-carreraup').html(e.vdata['carrera']);
                  $('#fm-cbplanup').html(e.vplanes);
                  $('#fm-cbplanup').val(e.vdata['codplan']);
                  $('#fm-txtplanup').val(e.vdata['codplan']);
                  $('#fm-txtmapepatup').val(e.vdata['paterno']);
                  $('#fm-txtmapematup').val(e.vdata['materno']);
                  $('#fm-txtmnombresup').val(e.vdata['nombres']);
                  $('#fm-txtmsexoup').val(e.vdata['sexo']);
                  $('#btn_view_pagos').data('pagante', carne);
                  $('#btn_view_pagos').data('pagantenb', estudiante);

                  fn_data_academico(carne);
                  fn_data_deudas(carne);
                  fn_historias_matriculas(carne,e.vcreditosmat);
                  
                  if (e.vestadomat == "DES" && (e.vcreditosmat >= 6 || e.vdeudasmat > 0)) {
                    $('#lbtn_editamat').attr('disabled', true);
                    //$('#msgcursos_deudas').show();
                    $('#msgcursos_deudas').html('<div class="alert alert-danger alert-dismissible">'+
                        '<i class="icon fas fa-ban mr-1"></i>'+
                        'El estudiante no puede ser matriculado por presentar unidades didácticas desaprobadas con 6 creditos a más o presentar deudas pendientes, favor de regularizar lo antes mencionado'+
                      '</div>');
                  } else if (e.vcreditosmat >= 6 || e.vdeudasmat > 0){
                    $('#lbtn_editamat').attr('disabled', true);
                    //$('#msgcursos_deudas').show();
                    $('#msgcursos_deudas').html('<div class="alert alert-danger alert-dismissible">'+
                        '<i class="icon fas fa-ban mr-1"></i>'+
                        'El estudiante no puede ser matriculado por presentar unidades didácticas desaprobadas con 6 creditos a más o presentar deudas pendientes, favor de regularizar lo antes mencionado'+
                      '</div>');
                  }
                  else {
                    $('#lbtn_editamat').attr('disabled', false);
                    $('#msgcursos_deudas').html('');
                  }

                  if ((e.vestadomat == "DES" || e.vcondicionalmat == "NO")) {
                    $('#lbtn_condic_refresh').show();
                    $('#lbtn_condic_refresh').show();
                    $('#lbtn_condic_refresh').data('carne', carne);
                    $('#lbtn_editamat').attr('disabled', true);
                  } else if (e.vestadomat == "DES" || e.vcondicionalmat == "SI"){
                    $('#lbtn_condic_refresh').hide();
                    $('#lbtn_editamat').attr('disabled', false);
                    $('#msgcursos_deudas').html('');
                  } else {
                    $('#lbtn_condic_refresh').hide();
                  }

                  if (e.vnromat > 1) {
                    $("#frm_updmatri #fm-cbtipoup option").each(function(i) {
                      if ($(this).data('nromat') == '0') {
          
                      } else if ($(this).data('nromat') == "2") {
                          $(this).removeClass('ocultar');
                      } else {
                          if (!$(this).hasClass("ocultar")){
                           $(this).addClass('ocultar');
                           $(this).data('autorizado', 'NO');
                          }
                      }

                    });
                  } else {
                    $("#frm_updmatri #fm-cbtipoup option").each(function(i) {
                      if ($(this).data('nromat') == "1") {
                          $(this).removeClass('ocultar');
                      } else {
                          if (!$(this).hasClass("ocultar")){
                           $(this).addClass('ocultar');
                           $(this).data('autorizado', 'NO');
                          }
                      }

                    });
                  }
              }
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#divmodalsearch #divoverlay').remove();
          $('#divError').show();
          $('#msgError').html(msgf);
      }
  })
}

function fn_data_academico(carnet) {
  $('#divmodaddmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#divcard_data_academ').html("");
  tblacademico = "";
  tbldesaprobados = "";
  
  $.ajax({
      url: base_url + 'matricula/fn_datos_academicos',
      type: 'post',
      dataType: 'json',
      data: {
          'ce-carne': carnet
      },
      success: function(e) {
          
          if (e.status == false) {
              Swal.fire({
                  type: 'error',
                  icon: 'error',
                  title: 'Error!',
                  text: e.msg,
                  backdrop: false,
              })
              $('#divmodaddmatricula #divoverlay').remove();
          } else {
              
                nro = 0;
                nrodsp = 0;
                grupoac = "";
                grupodes = "";
                $.each(e.cursos, function(index, v) {
                  grupoint = v['codperiodo']+v['ciclo'];
                  vestado = v['estado'];
                  if (v['nomestado'] !== "RETIRADO") {
                    if (grupoac != grupoint) {
                        grupoac = grupoint;
                        nro = 0;
                        tblacademico = tblacademico + 
                            "<div class='row cfila'>"+
                                "<div class='col-12 td text-center p-1 bg-lightgray'><b>"+v['periodo']+"</b></div>"+
                            "</div>";
                    }
                    nro++;
                    tblacademico = tblacademico + 
                            "<div class='row cfila'>"+
                                  "<div class='col-12 col-md-5'>"+
                                      "<div class='row'>"+
                                          "<div class='col-2 col-md-2 text-center td bg-lightgray'>"+nro+"</div>"+
                                          "<div class='col-10 col-md-10 td'>"+v['idunidad'] + " " + v['curso']+"</div>"+
                                      "</div>"+
                                  "</div>"+
                                  "<div class='col-12 col-md-7'>"+
                                      "<div class='row'>"+
                                          "<div class='col-3 col-md-3 td text-center'>"+v['ciclo']+"</div>"+
                                          "<div class='col-3 col-md-3 td text-center'>"+v['turno'].substr(0, 3)+" / "+v['codseccion']+"</div>"+
                                          "<div class='col-2 col-md-2 td text-center'>"+v['nota']+"</div>"+
                                          "<div class='col-2 col-md-2 td text-center'>"+v['recuperacion']+"</div>"+
                                          "<div class='col-2 col-md-2 td text-center'>"+v['final']+"</div>"+
                                      "</div>"+
                                  "</div>"+
                              "</div>";
                  }

                  // LISTAR UNIDADES DESAPROBADAS
                  if (v['nomestado'] !== "RETIRADO") {
                    if (vestado == "DES" || vestado == "DPI" || vestado == "NSP") {
                      if (grupodes != grupoint) {
                        nrodsp = 0;
                        grupodes = grupoint;
                        tbldesaprobados = tbldesaprobados+
                          "<div class='row cfila'>"+
                              "<div class='col-12 td text-center p-1 bg-lightgray'><b>"+v['periodo']+"</b></div>"+
                          "</div>";
                      }
                      nrodsp ++;
                      tbldesaprobados = tbldesaprobados+
                              "<div class='row cfila'>"+
                                  "<div class='col-12 col-md-5'>"+
                                      "<div class='row'>"+
                                          "<div class='col-2 col-md-2 text-center td bg-lightgray'>"+nrodsp+"</div>"+
                                          "<div class='col-10 col-md-10 td'>"+v['idunidad'] + " " + v['curso']+"</div>"+
                                      "</div>"+
                                  "</div>"+
                                  "<div class='col-12 col-md-7'>"+
                                      "<div class='row'>"+
                                          "<div class='col-3 col-md-3 td text-center'>"+v['ciclo']+"</div>"+
                                          "<div class='col-3 col-md-3 td text-center'>"+v['turno'].substr(0, 3)+" / "+v['codseccion']+"</div>"+
                                          "<div class='col-2 col-md-2 td text-center'>"+v['nota']+"</div>"+
                                          "<div class='col-2 col-md-2 td text-center'>"+v['recuperacion']+"</div>"+
                                          "<div class='col-2 col-md-2 td text-center'>"+v['final']+"</div>"+
                                      "</div>"+
                                  "</div>"+
                              "</div>";
                    }
                  }
                    
                })
                
                if (e.nrodesaprobados>0) {
                  $('#nrodesap').addClass("badge bg-danger");
                  $('#nrodesap').html(e.nrodesaprobados);
                } else {
                  $('#nrodesap').removeClass("badge bg-danger");
                  $('#nrodesap').html("");
                }
                
                tbnrodesaprob = "";
                tbnrodesaprob = tbnrodesaprob +
                  "<div class='btable'>"+
                    "<div class='thead col-12 bg-lightgray'>"+
                      "<div class='row'>"+
                        "<div class='col-12 col-md-12 td'>"+
                          "<span>Resultado Und. Desaprobadas</span>"+
                        "</div>"+
                      "</div>"+
                    "</div>"+
                    "<div class='tbody col-12'>"+
                      "<div class='row cfila'>"+
                        "<div class='col-6 col-md-6 td'><b>Und.didácticas</b></div>"+
                        "<div class='col-3 col-md-3 td'>"+e.nrodesaprobados+"</div>"+
                        "<div class='col-3 col-md-3 td'>"+e.nrocreddes+" cred.</div>"+
                      "</div>"+
                    "</div>"+
                  "</div>";
                $('#msgdesaprobados_estudiante').html(tbnrodesaprob);
                $('#divcard_data_academ').html(tblacademico);
                $('#divcard_data_desaprobados').html(tbldesaprobados);
                // creditos.push(e.nrocreddes);
                $('#divmodaddmatricula #divoverlay').remove();
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#divmodaddmatricula #divoverlay').remove();
          Swal.fire({
              type: 'error',
              icon: 'error',
              title: 'Error',
              text: msgf,
              backdrop: false,
          })
      }
  });
}

function fn_data_deudas(carnet) {
  $('#divmodaddmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#divcard_data_deudas').html("");
  tbldeudas = "";
  // deudasestud = [];
  $.ajax({
      url: base_url + 'inscrito/fn_datos_deudas',
      type: 'post',
      dataType: 'json',
      data: {
          'ce-carne': carnet
      },
      success: function(e) {
          
          if (e.status == false) {
              Swal.fire({
                  type: 'error',
                  icon: 'error',
                  title: 'Error!',
                  text: e.msg,
                  backdrop: false,
              })
              $('#divmodaddmatricula #divoverlay').remove();
          } 
          else {
              
                nro = 0;
                totald = 0;
                $.each(e.vdata, function(index, v) {
                  
                  var bgsaldo = (v['saldo']>0) ? "text-danger":"text-success";
                  if (v['estado'] == "ACTIVO") {
                    nro++;
                    totald = totald + parseFloat(v['saldo']);
                    tbldeudas = tbldeudas + 
                          "<div class='row cfila'>"+
                                "<div class='col-12 col-md-4'>"+
                                    "<div class='row'>"+
                                        "<div class='col-2 col-md-1 td text-center bg-lightgray px-0'>"+nro+"</div>"+
                                        "<div class='col-2 col-md-2 td text-center'><b>"+v['codigo']+"</b></div>"+
                                        "<div class='col-8 col-md-9 td'>"+v['persona'] +"</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-3 td'>"+
                                    "<span>"+v['gestion']+"</span>"+
                                "</div>"+
                                "<div class='col-12 col-md-2'>"+
                                    "<div class='row'>"+
                                        "<div class='col-6 col-md-6 td text-center'>"+parseFloat(v['monto']).toFixed(2)+"</div>"+
                                        "<div class='col-6 col-md-6 td text-center'>"+
                                          "<span class='"+bgsaldo+"'>"+parseFloat(v['saldo']).toFixed(2)+"<span>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-3'>"+
                                    "<div class='row'>"+
                                        "<div class='col-6 col-md-6 td text-center'>"+v['vence']+"</div>"+
                                        "<div class='col-6 col-md-6 td text-center'>"+v['grupo']+"</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>";
                   
                  }
                })  
                if (nro>0) {
                  $('#nrodeudas').addClass("badge bg-danger")
                  $('#nrodeudas').html(nro);
                  
                } else {
                  $('#nrodeudas').removeClass("badge bg-danger")
                  $('#nrodeudas').html("");
                  
                }
                
                tbnrodeudas = "";
                tbnrodeudas = tbnrodeudas +
                  "<div class='btable'>"+
                    "<div class='thead col-12 bg-lightgray'>"+
                      "<div class='row'>"+
                        "<div class='col-12 col-md-12 td'>"+
                          "<span>Resultado deudas</span>"+
                        "</div>"+
                      "</div>"+
                    "</div>"+
                    "<div class='tbody col-12'>"+
                      "<div class='row cfila'>"+
                        "<div class='col-6 col-md-6 td'><b>Deudas</b></div>"+
                        "<div class='col-3 col-md-3 td'>"+nro+"</div>"+
                        "<div class='col-3 col-md-3 td'><b>Total: </b>"+parseFloat(totald).toFixed(2)+"</div>"+
                      "</div>"+
                    "</div>"+
                  "</div>";
                $('#msgdeuda_estudiante').html(tbnrodeudas);
                
                $('#divcard_data_deudas').html(tbldeudas);
                // deudasestud.push(nro);
                $('#divmodaddmatricula #divoverlay').remove();
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#divmodaddmatricula #divoverlay').remove();
          Swal.fire({
              type: 'error',
              icon: 'error',
              title: 'Error',
              text: msgf,
              backdrop: false,
          })
      }
  });
}

function fn_historias_matriculas(carnet,creditos){
  $('#divmodaddmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#msghistorial_estudiante').html("");
  tblhistorial = "";
  // mat_condicional = [];
  $.ajax({
      url: base_url + 'matricula/fn_historial_matricula',
      type: 'post',
      dataType: 'json',
      data: {
          'ce-carne': carnet
      },
      success: function(e) {
          
          if (e.status == false) {
              Swal.fire({
                  type: 'error',
                  icon: 'error',
                  title: 'Error!',
                  text: e.msg,
                  backdrop: false,
              })
              $('#divmodaddmatricula #divoverlay').remove();
          } 
          else {
                var estado = "";
                var condicional = "";
                codciclo = "";
                nro = 0;
                $.each(e.vdata, function(index, v) {
                  nro++;
                  var btnscolor = "";
                  var textobs = (v['observacion']!= "") ? v['observacion'] : "Ninguna";
                  var observacion = "<br><b>Observación:</b><br>"+textobs;
                  if (v['estado'] != "RES") {
                    estado = v['estado'];
                  }
                  
                  condicional = v['condicional'];
                  codciclo = v['codciclo'];
                  switch (v['estado']) {
                      case "ACT":
                          btnscolor = "bg-success";
                          break;
                      case "CUL":
                          btnscolor = "bg-secondary";
                          break;
                      case "DES":
                          btnscolor = "bg-danger";
                          break;
                      default:
                          btnscolor = "bg-warning";
                  }
                  fecharegistro = v['registro'] + " <a href='#' class='view_user_reg_hst' tabindex='0' role='button' data-toggle='popover' data-trigger='hover' title='Matriculado por: ' data-content='"+v['usuario']+observacion+"'><i class='fas fa-info-circle fa-lg'></i></a>";
                  grupo = v['periodo'] + " " + v['sigla'] + " " + v['codturno'] + " " + v['ciclo'] + " " + v['codseccion'];
                  tblhistorial = tblhistorial + 
                          "<div class='row cfila'>"+
                                "<div class='col-4 col-md-4 td'>"+
                                    fecharegistro +
                                "</div>"+
                                "<div class='col-4 col-md-4 td'>"+
                                    grupo +
                                "</div>"+
                                "<div class='col-4 col-md-4 td'>"+
                                    "<span class='badge "+btnscolor+"'>"+v['estado']+"</span>"+
                                "</div>"+
                            "</div>";

                    if (estado == "DES" || creditos >= 6) {
                      $("#frm_updmatri #fm-cbcicloup option").each(function(i) {
                        if ($(this).data('codigo') == '0') {
                            
                        } else if ($(this).data('codigo') == codciclo) {
                            $(this).removeClass('ocultar');
                        } else {
                            if (!$(this).hasClass("ocultar")){
                             $(this).addClass('ocultar');
                             $(this).data('autorizado', 'NO');
                            }
                        }

                      });
                    } else {
                      $("#frm_updmatri #fm-cbcicloup option").each(function(i) {
                        $(this).removeClass('ocultar');
                        $(this).data('autorizado', 'SI');
                      })
                    }
                    
                })

                if (estado == "DES" || creditos >= 6) {
                  rpdtid = parseInt(codciclo)+1;
                  dataid = (rpdtid < 10 ? '0' : '')+rpdtid;
                  $("#frm_updmatri #fm-cbcicloup option").each(function(i) {
                    if ($(this).data('codigo') == dataid) {
                      $(this).removeClass('ocultar');
                    }
                  })
                  
                  for (i = parseInt(codciclo) - 1; i >= 1; i--) {
                    iddata = (i < 10 ? '0' : '')+i;
                    $("#frm_updmatri #fm-cbcicloup option").each(function(i) {
                      if ($(this).data('codigo') == iddata) {
                        $(this).removeClass('ocultar');
                        $(this).data('autorizado', 'SI');
                      }
                    })
                  }
                }
                
                $('#msghistorial_estudiante').html(tblhistorial);
                $('#divmodaddmatricula #divoverlay').remove();
                $('.view_user_reg_hst').popover({
                  trigger: 'hover',
                  html: true
                })
                // mat_condicional.push(estado,condicional);
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#divmodaddmatricula #divoverlay').remove();
          Swal.fire({
              type: 'error',
              icon: 'error',
              title: 'Error',
              text: msgf,
              backdrop: false,
          })
      }
  });
}

function fn_view_data_pagos(btn) {
  var pagante = btn.data('pagante');
  var estudiante = btn.data('pagantenb');
  var cgestion = "02.02";

  if (pagante !== "") {
    $("#vw_md_pagos_estudiante").html("(" + pagante + ") " + estudiante);
    $("#modPagos_asignar").modal('show');
    $('#modPagos_asignar .modPagos_asignar_content').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "facturacion_reportes/fn_emitidositems_x_pagante",
        type: 'post',
        dataType: 'json',
        data: {
            codpagante: pagante,
            codgestion: cgestion
        },
        success: function(e) {
            $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                var nro = 0;
                var tabla = "";
                var boton = "";
                $.each(e.vdata, function(index, v) {
                    nro++;
                    boton = "<a href='#' onclick='fn_vw_seleccionar_pago($(this));return false;' title='Seleccionar' class='badge badge-primary'>seleccione</a>";
                    
                    monto = Number.parseFloat(v['monto']).toFixed(2);
                    tabla = tabla +
                        "<div class='row rowcolor' data-tipo='" + v['codtipo'] + "' data-serie='" + v['serie'] + "' data-numero='" + v['numero'] + "'>" +
                        "<div class='col-6 col-md-5 text-right'>" +
                        "<div class='row'>" +
                        "<div class='col-4 col-md-2 td'><span><b>" + nro + "</b></span></div>" +
                        "<div class='col-8 col-md-5 td'><span>" + v['serie'] + "-" + v['numero'] + "</span>" +
                        "</div>" +
                        "<div class='col-8 col-md-5 td'><span>" + v['fecha_hora'] + "</span>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "<div class='col-4 col-md-4 td'><span>" + v['gestion'] + "</span></div>" +
                        "<div class='col-6 col-md-3 text-right'>" +
                        "<div class='row'>" +
                        "<div class='col-6 col-md-4 td text-right'><span>" + monto + "</span></div>" +
                        "<div class='col-6 col-md-4 td'><span class='vw_mdp_spcoddeuda'>" + v['coddeuda'] + "</span></div>" +
                        "<div class='col-6 col-md-4 td text-right'>" +
                        boton +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>";
                });
                $("#div_Pagos_Asignar").html(tabla);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
  }
}

function fn_vw_seleccionar_pago(btn) {
  var fila = btn.closest('.rowcolor');
  var tipo = fila.data('tipo');
  var serie = fila.data('serie');
  var numero = fila.data('numero');
  $('#fm-tipdocuf').val(tipo);
  $('#fm-serie').val(serie);
  $('#fm-numdocum').val(numero);
  $("#checkdocumen").prop('checked', false);
  $(".checkdocumento").prop('disabled', false);
  $("#modPagos_asignar").modal('hide');
}

$('#btn_doc_search').click(function(e) {
  var tipodoc = $("#fm-tipdocuf").val();
  var serie = $("#fm-serie").val();
  var nrodoc = $("#fm-numdocum").val();

  var llenos=0;
  if ($("#fm-tipdocuf").val()!=="") llenos++;
  if ($("#fm-serie").val()!=="") llenos++;
  if ($("#fm-numdocum").val()!=="") llenos++;
  
  if (llenos > 2) {
    $('#divmodaddmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'matricula/fn_search_documentopago',
        type: 'post',
        dataType: 'json',
        data: {
            'fm-tipdocuf': tipodoc,
            'fm-serie': serie,
            'fm-numdocum': nrodoc
        },
        success: function(e) {
          $('#divmodaddmatricula #divoverlay').remove();
          if (e.status == false) {
              Swal.fire({
                  type: 'error',
                  icon: 'error',
                  title: 'Error!',
                  text: e.msg,
                  backdrop: false,
              })
              
          } 
          else {
            if (e.rpta == false) {
              mensaje = '<div class="alert alert-danger alert-dismissible">'+
                          '<i class="icon fas fa-info mr-1"></i>'+
                          e.msg +
                        '</div>';
            } else {
              mensaje = '<div class="alert alert-success alert-dismissible">'+
                          '<i class="icon fas fa-check-circle mr-1"></i>'+
                          e.rptitle +", "+ e.msg +
                        '</div>';
            }
            $('#msg_rpta_documento').html(mensaje);
          }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodaddmatricula #divoverlay').remove();
            Swal.fire({
                type: 'error',
                icon: 'error',
                title: 'Error',
                text: msgf,
                backdrop: false,
            })
        }
    });
  }
  
});


$("#checkdocumen").change(function(e) {
  var check = true;
  var btn = $(this);
  
  if (btn.prop('checked') == false) {
      var check = false;
  }
  $(".checkdocumento").prop('disabled', check);
  $(".checkdocumento").val('');
  
});
$("#switch_forzar_matricula").change(function(event) {
  /* Act on the event */
  if ($(this).is(':checked')){
    $('#lbtn_editamat').attr('disabled', false);
  }
  else{
    // $('#lbtn_editamat').attr('disabled', true);
  }
});
</script>