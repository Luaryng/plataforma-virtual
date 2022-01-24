<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">
<div class="content-wrapper">

  <div class="modal fade" id="modupmat" tabindex="-1" role="dialog" aria-labelledby="modupmat" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content" id="divmodaladd">
              <div class="modal-header">
                  <h5 class="modal-title" id="titlemodal">MATRICULAR</h5>
                  <div id="divsearch_ins" style="display: none;">
                    <button class="btn btn-outline-info" data-toggle="modal" data-target="#modfiltroins">
                      <i class="fas fa-search"></i> Buscar alumno
                    </button>
                  </div>
              </div>
              <div class="modal-body">
                  
                  <form id="frm_updmatri" action="<?php echo $vbaseurl ?>matricula/fn_insert_update_matricula" method="post" accept-charset="utf-8">
                    <b class="text-danger pt-3"><i class="fas fa-user-graduate mr-1"></i> PROCESO DE MATRÍCULA</b>
                    <input data-currentvalue="" id="fm-txtidmatriculaup" name="fm-txtidmatriculaup" type="hidden">
                    <input data-currentvalue="" id="fm-txtidup" name="fm-txtidup" type="hidden">
                    <input data-currentvalue="" id="fm-txtcarreraup" name="fm-txtcarreraup" type="hidden">
                    <input data-currentvalue="" id="fm-txtperiodoup" name="fm-txtperiodoup" type="hidden">
                    <input id="fm-txtplanup" name="fm-txtplanup" type="hidden">
                    <input id="fm-txtmapepatup" name="fm-txtmapepatup" type="hidden">
                    <input id="fm-txtmapematup" name="fm-txtmapematup" type="hidden">
                    <input id="fm-txtmnombresup" name="fm-txtmnombresup" type="hidden">
                    <input id="fm-txtmsexoup" name="fm-txtmsexoup" type="hidden">
                    
                    <div class="row mt-3">
                      <div class="form-group has-float-label col-12 col-xs-4 col-sm-5">
                        <select data-currentvalue="" class="form-control" id="fm-cbplanup" name="fm-cbplanup" required="">
                          
                        </select>
                        <label for="fm-cbplanup"> Plan de Estudio</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-xs-12 col-sm-2">
                        <select data-currentvalue="" class="form-control" id="fm-cbtipoup" name="fm-cbtipoup" required="">
                          <option value="O">Ordinaria</option>
                          <option value="E">Extraordinaria</option>
                        </select>
                        <label for="fm-cbtipoup"> Matrícula</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-xs-4 col-sm-5">
                        <select data-currentvalue="" class="form-control" id="fm-cbbeneficioup" name="fm-cbbeneficioup" required="">
                          <?php foreach ($beneficios as $beneficio) {?>
                          <option value="<?php echo $beneficio->id ?>"><?php echo $beneficio->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="fm-cbbeneficioup"> Beneficio</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-xs-4 col-sm-3">
                        <input data-currentvalue="" class="form-control text-uppercase" value="<?php echo date("Y-m-d"); ?>" id="fm-txtfecmatriculaup" name="fm-txtfecmatriculaup" type="date" placeholder="Fec. Matrícula">
                        <label for="fm-txtfecmatriculaup">Fec. Matrícula</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-xs-4 col-sm-2">
                        <input data-currentvalue="" class="form-control" type="number" step="0.01" value="0.00" id="fm-txtcuotaup" name="fm-txtcuotaup" placeholder="Cuota">
                        <label for="fm-txtcuotaup">Cuota</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-xs-4 col-sm-4">
                        <select data-currentvalue="" class="form-control" id="fm-cbestadoup" name="fm-cbestadoup" required="">
                          <option value="0">Selecciona un estado</option>
                          <?php foreach ($estados as $est) {?>
                          <option value="<?php echo $est->codigo ?>"><?php echo $est->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="fm-cbestadoup"> Estado</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group has-float-label col-12 col-xs-4 col-sm-2">
                        <select data-currentvalue="" class="form-control" id="fm-cbperiodoup" name="fm-cbperiodoup" required="">
                          <option value="0"></option>
                          <?php foreach ($periodos as $periodo) {?>
                          <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="fm-cbperiodoup"> Periodo</label>
                      </div>
                      
                      <div class="col-12 col-sm-4">
                        <span id="fm-carreraup" class=" form-control bg-light">PROGRAMA ACADÉMICO</span>
                      </div>
                      <div class="form-group has-float-label col-12 col-xs-12 col-sm-2">
                        <select data-currentvalue="" class="form-control" id="fm-cbcicloup" name="fm-cbcicloup" required="">
                          <option value="0"></option>
                          <?php foreach ($ciclos as $ciclo) {?>
                          <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="fm-cbcicloup"> Ciclo</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-xs-12 col-sm-2">
                        <select data-currentvalue="" class="form-control" id="fm-cbturnoup" name="fm-cbturnoup" required="">
                          <option value="0"></option>
                          <?php foreach ($turnos as $turno) {?>
                          <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="fm-cbturnoup"> Turno</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-xs-12 col-sm-2">
                        <select data-currentvalue="" class="form-control" id="fm-cbseccionup" name="fm-cbseccionup" required="">
                          <option value="0"></option>
                          <?php foreach ($secciones as $seccion) {?>
                          <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="fm-cbseccionup"> Sección</label>
                      </div>
                      
                      <div class="form-group has-float-label col-12 col-xs-12 col-sm-12">
                        <textarea class="form-control text-uppercase" id="fm-txtobservacionesup" name="fm-txtobservacionesup" rows="3" placeholder="Observaciones"></textarea>
                        <label for="fm-txtobservacionesup"> Observaciones</label>
                      </div>
                      
                    </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button type="button" id="lbtn_editamat" class="btn btn-primary">Guardar</button>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="modfiltroins" tabindex="-1" role="dialog" aria-labelledby="modfiltroins" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content" id="divmodalsearch">
              <div class="modal-header">
                  <h5 class="modal-title" id="titlemodal">MATRICULAR</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <form id="frm-getinscritonew" action="<?php echo $vbaseurl ?>matricula/fn_filtrar_inscritos" method="post" accept-charset="utf-8">
                  <b class="text-danger"><i class="fas fa-user-circle mr-1"></i> INSCRITO</b>
                  <span class="text-help"> (Ingresa apellidos y nombres)</span>
                  
                  <div class="row pt-3">
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
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link active" href="#busqueda" data-toggle="tab">
              <b><i class="fas fa-usermr-1"></i> Búsqueda</b>
            </a>
          </li>
          <li id="tabli-aperturafile" class="nav-item">
            <a class="nav-link" href="#ficha-matricula" data-toggle="tab">
              <b><i class="fas fa-user-plus mr-1"></i> Matricular</b>
            </a>
          </li>
          <li id="tabli-cargaacademica" class="nav-item">
            <a class="nav-link" href="#fichacarga" data-toggle="tab">
              <b><i class="fas fa-book mr-1"></i> Carga académica</b>
            </a>
          </li>
        </ul>
        
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="busqueda">
            <div class="row-fluid">
              <form id="frmfiltro-matriculas" name="frmfiltro-matriculas" action="<?php echo $vbaseurl ?>matricula/fn_filtrar" method="post" accept-charset='utf-8'>
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
                  <div class="form-group has-float-label col-12 col-sm-7 col-md-7">
                    <input class="form-control text-uppercase" autocomplete="off" id="fmt-alumno" name="fmt-alumno" placeholder="Carné o Apellidos y nombres" >
                    <label for="fmt-alumno"> Carné o Apellidos y nombres
                    </label>
                  </div>
                  <div class="col-6 col-sm-2 col-md-1">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                  </div>
                  <div class="col-6 col-sm-3 col-md-2 text-center">
                    <a href="#" class="btn-excel btn btn-outline-secondary"><img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt=""> Exportar</a>
                  </div>
                  <div class="col-6 col-sm-4 col-md-2 offset-md-12">
                    <button type="button" class="btn btn-success btn-block btn-flat btn-sm text-center" data-accion="INSERTAR" data-toggle="modal" data-target="#modupmat"><i class="fas fa-plus"></i> <br class="d-none d-md-block">Matricular</button>
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
                        <div class="col-md-7 td">FICHA</div>
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="row">
                        <div class="col-md-12 td">CARGA</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="div-filtro" class="tbody col-12">
                  
                </div>
              </div>
            </div>
            <!--</div>-->
          </div>
          <div class="tab-pane" id="ficha-matricula">
            <form id="frm-getinscrito" action="<?php echo $vbaseurl ?>inscrito/fn_get_datos_carne" method="post" accept-charset='utf-8'>
              <b class="text-danger"><i class="fas fa-user-circle mr-1"></i> INSCRITO</b>
              <span class="text-help"> (Ingresa el código de carné)</span>
              
              <!--<label for="ficodpostulante">Nro Postulante:</label>-->
              <div class="row pt-3">
                <div class="input-group mb-3 col-12 col-xs-12 col-sm-3">
                  <input autocomplete="off" placeholder="Carné" type="text" class="form-control text-uppercase" id="fgi-txtcarne" name="fgi-txtcarne">
                  <div class="input-group-append">
                    <button data-paterno='' data-materno='' data-nombres='' class="btn btn-info" type="submit" >
                    <i class="fas fa-arrow-alt-circle-right"></i>
                    </button>
                  </div>
                </div>
                <div class="col-12 col-sm-5">
                  <span id="fgi-apellidos" class=" form-control bg-light"></span>
                </div>
                <div class="col-12 col-sm-4">
                  <span id="fgi-nombres" class=" form-control bg-light"></span>
                </div>
              </div>
            </form>
            <form id="frm-matricular" action="<?php echo $vbaseurl ?>matricula/fn_insert" method="post" accept-charset='utf-8'>
              <b class="text-danger pt-3"><i class="fas fa-user-graduate mr-1"></i> PROCESO DE MATRÍCULA</b>
              <input data-currentvalue='' id="fm-txtidmatricula" name="fm-txtidmatricula" type="hidden" />
              <input data-currentvalue='' id="fm-txtid" name="fm-txtid" type="hidden" />
              <input data-currentvalue='' id="fm-txtcarrera" name="fm-txtcarrera" type="hidden" />
              <input id="fm-txtplan" name="fm-txtplan" type="hidden" />

              <input id="fm-txtmapepat" name="fm-txtmapepat" type="hidden" />
              <input id="fm-txtmapemat" name="fm-txtmapemat" type="hidden" />
              <input id="fm-txtmnombres" name="fm-txtmnombres" type="hidden" />
              <input id="fm-txtmsexo" name="fm-txtmsexo" type="hidden" />
              
              <div class="row mt-3">
                <div class="form-group has-float-label col-12 col-xs-4 col-sm-5">
                  <select data-currentvalue='' class="form-control" id="fm-cbplan" name="fm-cbplan" placeholder="Plan de Estudio" required>
                    
                  </select>
                  <label for="fm-cbplan"> Plan de Estudio</label>
                </div>
                <div class="form-group has-float-label col-12 col-xs-12 col-sm-2">
                  <select data-currentvalue='' class="form-control" id="fm-cbtipo" name="fm-cbtipo" placeholder="Condición" required >
                    <option value="O">Ordinaria</option>
                    <option value="E">Extraordinaria</option>
                  </select>
                  <label for="fm-cbtipo"> Matrícula</label>
                </div>
                <div class="form-group has-float-label col-12 col-xs-4 col-sm-5">
                  <select data-currentvalue='' class="form-control" id="fm-cbbeneficio" name="fm-cbbeneficio" placeholder="Periodo" required >
                    <?php foreach ($beneficios as $beneficio) {?>
                    <option value="<?php echo $beneficio->id ?>"><?php echo $beneficio->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbbeneficio"> Beneficio</label>
                </div>
                <div class="form-group has-float-label col-12 col-xs-4 col-sm-3">
                  <input data-currentvalue='' class="form-control text-uppercase" value="<?php echo date("Y-m-d"); ?>" id="fm-txtfecmatricula" name="fm-txtfecmatricula" type="date" placeholder="Fec. Matrícula"   />
                  <label for="fm-txtfecmatricula">Fec. Matrícula</label>
                </div>
                <div class="form-group has-float-label col-12 col-xs-4 col-sm-2">
                  <input data-currentvalue='' class="form-control" type="number" step="0.01"  value='0.00' id="fm-txtcuota" name="fm-txtcuota" placeholder="Cuota"   />
                  <label for="fm-txtcuota">Cuota</label>
                </div>
              </div>
              
              <div class="row">
                
                <div class="form-group has-float-label col-12 col-xs-4 col-sm-2">
                  <select data-currentvalue='' class="form-control" id="fm-cbperiodo" name="fm-cbperiodo" placeholder="Periodo" required >
                    <option value="0"></option>
                    <?php foreach ($periodos as $periodo) {?>
                    <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbperiodo"> Periodo</label>
                </div>
                
                <div class="col-12 col-sm-4">
                  <span id="fm-carrera" class=" form-control bg-light">PROGRAMA ACADÉMICO</span>
                </div>
                <div class="form-group has-float-label col-12 col-xs-12 col-sm-2">
                  <select data-currentvalue='' class="form-control" id="fm-cbciclo" name="fm-cbciclo" placeholder="Ciclo" required >
                    <option value="0"></option>
                    <?php foreach ($ciclos as $ciclo) {?>
                    <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbciclo"> Ciclo</label>
                </div>
                <div class="form-group has-float-label col-12 col-xs-12 col-sm-2">
                  <select data-currentvalue='' class="form-control" id="fm-cbturno" name="fm-cbturno" placeholder="Turno" required >
                    <option value="0"></option>
                    <?php foreach ($turnos as $turno) {?>
                    <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbturno"> Turno</label>
                </div>
                <div class="form-group has-float-label col-12 col-xs-12 col-sm-2">
                  <select data-currentvalue='' class="form-control" id="fm-cbseccion" name="fm-cbseccion" placeholder="Sección" required >
                    <option value="0"></option>
                    <?php foreach ($secciones as $seccion) {?>
                    <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbseccion"> Sección</label>
                </div>
                
                
                <div class="form-group has-float-label col-12 col-xs-12 col-sm-12">
                  <textarea class="form-control text-uppercase" id="fm-txtobservaciones" name="fm-txtobservaciones" placeholder="Observaciones"  rows="3"></textarea>
                  <label for="fm-txtobservaciones"> Observaciones</label>
                </div>
                
              </div>
              <div class="row">
                <div class="col-12">
                  <span id="fispedit" class="text-danger"></span>
                  
                  <button type="button" id="btn-cancelar" class="btn btn-danger btn-lg mr-3"><i class="fas fa-undo"></i> Cancelar</button>
                  <button id="btn-matricular" data-step='ins' type="submit" class="btn btn-primary btn-lg float-right"><i class="fas fa-save"></i> Matricular</button>
                </div>
              </div>
            </form>
            
            
            
            
            <!--</div>-->
            <div class="card-body px-2 pt-2">
            </div>
              <!--</div>
            </div>-->
            <!-- /.MultiStep Form -->
          </div>
          <div class="tab-pane" id="fichacarga">

            <div class="row-fluid">
              <div class="row">
                <div class="col-12 bg-primary p-2 pb-2 rounded">
                  <b class=""><i class="fas fa-user-graduate mr-1"></i> MATRICULADO</b>
                </div>
              </div>
              
              <div class="row mb-2">
                <div class="col-12 col-md-2 ">
                  <img src="<?php echo $vbaseurl ?>resources/fotos/user.png" class="rounded  mx-auto img-fluid" alt="Alumno">
                </div>
                <div class="col-10 mb-2 pt-2">
                  <div class="row">
                    <!--<input type="hidden" name="txtcarne" value="" id="fmc-txtcarne">-->
                    <div id="divcarne" class="col-md-4 text-bold">Carné: </div>
                    <div  class="col-md-8 text-bold"><h3 id="divmiembro"></h3></div>
                    <div id="divperiodo" class="col-md-4 text-bold">Periodo:</div>
                    <div id="divcarrera" class="col-md-8 ">Carrera:</div>
                    <div id="divciclo" class="col-md-4 ">Ciclo:</div>
                    <div id="divturno" class="col-md-4 ">Turno:</div>
                    <div id="divseccion" class="col-md-4 ">Sección: </div>
                    <input type="hidden" value="" id="vwtxtcodmat">
                    
                  </div>
                </div>
              </div>
              
              <div class="col-12 px-0 pt-2  ">
                <div class="row">
                  <div class="col-12 bg-success p-2 rounded">
                    <b><i class="fas fa-book mr-1"></i> UNIDADES DIDACTICAS MATRICULADAS</b>
                  </div>
                </div>
                
                  <div class="btable">
                    <div class="thead col-12">
                      <div class="row">
                        <div class="col-4 col-md-3">
                          <div class="row">
                            <div class="tdnro col-3 col-md-2 td">N°</div>
                            <div class="col-9 col-md-10 td">UNIDAD DIDÁCTICA</div>
                          </div>
                        </div>
                        <div class="col-6 col-md-3">
                          <div class="row">
                            <div class="td col-2 col-md-4 text-center ">GRUPO</div>
                            <div class="td col-2 col-md-4 text-center ">TURNO</div>
                          </div>
                        </div>
                        <div class="col-6 col-md-3">
                          <div class="row">
                            <div class="td col-2 col-md-4 text-center ">VEZ</div>
                            <div class="td col-2 col-md-4 text-center ">HOR.</div>
                            <div class="td col-2 col-md-4 text-center ">CRED.</div>
                          </div>
                        </div>
                        <div class="col-6 col-md-2 td">DOCENTE</div>
                      </div>
                    </div>
                    <div id="div-cursosmat" class="tbody col-12">
                      <b>Ninguna</b>
                      <br>
                    </div>
                  </div>
                  


              </div>
              
              <div class="row mt-3">
                <div class="col-12 bg-danger p-2 rounded">
                  <b><i class="fas fa-book-medical mr-1"></i> ENROLAR UNIDADES DIDACTICAS</b>
                </div>
              </div>
              <form class="pt-3" id="frmfiltro-unidades" name="frmfiltro-unidades" action="#" method="post" accept-charset='utf-8'>
                
                <div class="row">
                  <div class="form-group col-12 col-sm-2">
                    <span data-currentvalue='' class="form-control" data-cp='0' id="fud-cbperiodo">
                      
                    </span>
                  </div>
                  
                  <div class="form-group has-float-label col-12 col-sm-3">
                    <select data-currentvalue='' class="form-control" id="fud-cbcarrera" name="fud-cbcarrera" placeholder="Programa Académico" required >
                      <option value="%"></option>
                      <?php foreach ($carreras as $carrera) {?>
                      <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fud-cbcarrera"> Programa Académico</label>
                  </div>
                  <div class="form-group has-float-label col-12 col-sm-2">
                    <select class="form-control" id="fud-cbplan" name="fud-cbplan" placeholder="Plan curricular">
                      <option value="%"></option>
                    </select>
                    <label for="fud-cbplan"> Plan curricular</label>
                  </div>
                  <div class="form-group has-float-label col-12 col-sm-2">
                    <select data-currentvalue='' class="form-control" id="fud-cbciclo" name="fud-cbciclo" placeholder="Ciclo" required >
                      <option value="%"></option>
                      <?php foreach ($ciclos as $ciclo) {?>
                      <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fud-cbciclo"> Ciclo</label>
                  </div>
                  <div class="form-group has-float-label col-12 col-sm-1">
                    <select data-currentvalue='' class="form-control" id="fud-cbturno" name="fud-cbturno" placeholder="Turno" required >
                      <option value="%"></option>
                      <?php foreach ($turnos as $turno) {?>
                      <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fud-cbturno"> Turno</label>
                  </div>
                  <div class="form-group has-float-label col-12 col-sm-1">
                    <select data-currentvalue='' class="form-control" id="fud-cbseccion" name="fud-cbseccion" placeholder="Sección" required >
                      <option value="%"></option>
                      <?php foreach ($secciones as $seccion) {?>
                      <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                      <?php } ?>
                    </select>
                    <label for="fud-cbseccion"> Sección</label>
                  </div>
                  <!--<div class="form-group has-float-label col-12 col-xs-12 col-sm-11">
                    <input class="form-control text-uppercase" id="fud-alumno" name="fud-alumno" placeholder="Carné o Apellidos y nombres" >
                    <label for="fud-alumno"> Carné o Apellidos y nombres
                    </label>
                  </div>-->
                  <div class="col-12  col-sm-1">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                  </div>
                </div>
                
              </form>
            </div>
            <small id="fud-conteo" class="form-text text-primary">
            
            </small>
            
            <div class="col-12 px-0 pt-2">
              <div class="btable">
                <div class="thead col-12">
                  <div class="row">
                    <div class="col-4 col-md-3">
                      <div class="row">
                        <div class="tdnro col-3 col-md-2 td">N°</div>
                        <div class="col-9 col-md-10 td">UNIDAD DIDÁCTICA</div>
                      </div>
                    </div>
                    <div class="col-6 col-md-3">
                      <div class="row">
                        <div class="td col-2 col-md-4 text-center ">GRUPO</div>
                        <div class="td col-2 col-md-4 text-center ">TURNO</div>
                      </div>
                    </div>
                    <div class="col-6 col-md-3">
                      <div class="row">
                        <div class="td col-2 col-md-4 text-center ">VEZ</div>
                        <div class="td col-2 col-md-4 text-center ">HOR.</div>
                        <div class="td col-2 col-md-4 text-center ">CRED.</div>
                      </div>
                    </div>
                    <div class="col-6 col-md-2 td">DOCENTE</div>
                  </div>
                </div>
                
                <div id="div-cursosdispo" class="tbody col-12">
                  
                </div>
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
$(".btn-excel").click(function(e) {
  e.preventDefault();
  
  /*$('#frm-filtro-inscritos input,select').removeClass('is-invalid');
  $('#frm-filtro-inscritos .invalid-feedback').remove();*/
  var url=base_url + 'academico/matriculas/excel?cp=' + $("#fmt-cbperiodo").val() + '&cc=' + $("#fmt-cbcarrera").val() + '&ccc=' + $("#fmt-cbciclo").val() + '&ct=' + $("#fmt-cbturno").val() + '&cs=' + $("#fmt-cbseccion").val() + '&cpl=' + $("#fmt-cbplan").val() + '&ap=' + $("#fmt-alumno").val();
  var ejecuta=true;
  /*if ($.trim($("#fbus-txtbuscar").val())=='%%%%'){
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
  }*/
  if (ejecuta==true) window.open(url, '_blank');
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
                var mt = 0;
                var ac = 0;
                var rt = 0;
                var cl = 0;
                var cd1=base64url_encode("1");
                var cd2=base64url_encode("2");
                $.each(e.vdata, function(index, v) {
                    /* iterate through array or object */
                    nro++;
                    mt = mt + parseInt(v['mat']);
                    ac = ac + parseInt(v['act']);
                    rt = rt + parseInt(v['ret']);
                    cl = cl + parseInt(v['cul']);
                    var vcm = base64url_encode(v['codigo']);
                    var url = base_url + "academico/matricula/imprimir/" + vcm;
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
                                '<div class="btn-group">' + 
                                  '<button class="btn ' + btnscolor + ' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                    v['estado'] +
                                  '</button>' +
                                  '<div class="dropdown-menu">' +
                                    '<a href="#" class="btn-cestado dropdown-item" data-ie="' + cd1 + '">Activo</a>' +
                                    '<a href="#" class="btn-cestado dropdown-item"  data-ie="' + cd2 + '">Retirado</a>' +
                                    '<div class="dropdown-divider"></div>' +
                                    '<a href="#" class="btn-ematricula dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>' +
                                  ' </div>' +
                                '</div>' +
                              '</div>' +

                              '<div class="td col-2 col-md-7 text-bold">' + 
                                '<div class="btn-group dropleft">' + 
                                  '<button class="btn btn-info btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                    '<i class="fas fa-file-invoice"></i> Ficha' +
                                  '</button>' +
                                  '<div class="dropdown-menu">' +
                                    '<a target="_blank" href="' + url + '" class="dropdown-item"><i class="far fa-file-pdf text-danger mr-2"></i>PDF</a>' +
                                    '<a href="' + base_url +  'academico/matricula/ficha/excel/' + vcm + '" class="dropdown-item" ><i class="far fa-file-excel text-success mr-2"></i>Excel</a>' +
                                    
                                  ' </div>' +
                                '</div>' +
                              '</div>' +
                            '</div>' +
                            '</div>' +

                            '<div class="td col-2 col-md-1 p-2">'+
                              '<div class="btn-group btn-group-sm p-0 dropleft">' + 
                                '<button class="btn btn-info btn-sm dropdown-toggle py-0 rounded" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                    '<i class="fas fa-cog"></i>' +
                                  '</button>' +
                                  '<div class="dropdown-menu">' +
                                    '<a class="btncall-carga dropdown-item" data-cm=' + vcm + '  href="#" title="Carga académica"><i class="fas fa-book"></i> Carga</a>'+
                                    '<a href="#" data-cm=' + vcm + ' data-accion="EDITAR" class="dropdown-item text-success" data-toggle="modal" data-target="#modupmat"><i class="fas fa-edit mr-2"></i>Edita matricula</a>' +
                                  '</div>' +
                              ' </div>' +
                              '</div>' +
                            '</div>' +
                           
                          '</div>' +
                        '</div>');
                });
                /*'<div class="td col-2 col-md-1 p-2"><a class="bg-primary text-white py-1 px-2 mt-2 rounded btn-editar" data-cm=' + vcm + '  href="#" title="Carga académica"><i class="fas fa-book"></i> Editar</a></div>' +
                            '</div>' +*/
                //academico/matricula/ficha/excel/
                
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
                $(".btn-cestado").click(function(event) {
                  
                  var im=$(this).parents(".cfila").data('idm');
                  var ie=$(this).data('ie');
                  
                  var btdt=$(this).parents(".btn-group").find('.dropdown-toggle');
                  //var btdt=$(this).parents(".dropdown-toggle");
                  var texto=$(this).html();
                  //alert(btdt.html());
                  $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                  $.ajax({
                      url: base_url + 'matricula/fn_cambiarestado',
                      type: 'post',
                      dataType: 'json',
                      data: {
                              'ce-idmat': im,
                              'ce-nestado':ie
                          },
                      success: function(e) {
                          $('#divcard-matricular #divoverlay').remove();
                          if (e.status == false) {
                              Swal.fire({
                                  type: 'error',
                                  title: 'Error!',
                                  text: e.msg,
                                  backdrop: false,
                              })
                          } else {
                              /*$("#fm-txtidmatricula").html(e.newcod);*/
                              Swal.fire({
                                  type: 'success',
                                  title: 'Felicitaciones, estado actualizado',
                                  text: 'Se ha actualizado el estado',
                                  backdrop: false,
                              })
                              
                              btdt.removeClass('btn-danger');
                              btdt.removeClass('btn-success');
                              btdt.removeClass('btn-warning');
                              btdt.removeClass('btn-secondary');
                              switch(texto) {
                                case "Activo":
                                    btdt.addClass('btn-success');
                                    btdt.html("ACT");
                                  break;
                                /*case "CUL":
                                  btnscolor="btn-secondary";
                                  break;*/
                                case "Retirado":
                                  btdt.addClass('btn-danger');
                                  btdt.html("RET");
                                  break;
                                default:
                                  btnscolor="btn-warning";
                              }
                              //btdt.addClass('class_name');
                              //mostrarCursos("div-cursosmat", "", e.vdata);
                          }
                      },
                      error: function(jqXHR, exception) {
                          var msgf = errorAjax(jqXHR, exception, 'text');
                          $('#divcard-matricular #divoverlay').remove();
                          Swal.fire({
                              type: 'error',
                              title: 'Error',
                              text: msgf,
                              backdrop: false,
                          })
                      }
                  });
                  return false;
              });

              $(".btn-ematricula").on("click", function() {
                $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                var fila=$(this).parents(".cfila");
                var im=fila.data('idm');
                var alumno = fila.find('.calumno').html();
              
                //************************************
                Swal.fire({
                  title: "Precaución",
                  text: "Se eliminarán las notas y asistencias del alumno " + alumno + ", en este curso: ",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                  if (result.value) {
                      //var codc=$(this).data('im');
                      $.ajax({
                      url: base_url + 'matricula/fn_eliminar',
                      type: 'post',
                      dataType: 'json',
                      data: {
                              'ce-idmat': im
                          },
                      success: function(e) {
                          $('#divcard-matricular #divoverlay').remove();
                          if (e.status == false) {
                              Swal.fire({
                                  type: 'error',
                                  title: 'Error!',
                                  text: e.msg,
                                  backdrop: false,
                              })
                          } else {
                              /*$("#fm-txtidmatricula").html(e.newcod);*/
                              Swal.fire({
                                  type: 'success',
                                  title: 'Eliminación correcta',
                                  text: 'Se ha eliminado la matrícula',
                                  backdrop: false,
                              })
                              
                              fila.remove();
                          }
                      },
                      error: function(jqXHR, exception) {
                          var msgf = errorAjax(jqXHR, exception, 'text');
                          $('#divcard-matricular #divoverlay').remove();
                          Swal.fire({
                              type: 'error',
                              title: 'Error',
                              text: msgf,
                              backdrop: false,
                          })
                      }
                  });
                  }
                  else{
                     $('#divcard-matricular #divoverlay').remove();
                  }
                });
                //***************************************
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

$("#modupmat").on('show.bs.modal', function (e) {
    var rel=$(e.relatedTarget);
    var idmat = rel.data('cm');
    var accion = rel.data('accion');
    if (accion == "EDITAR") {
      $('#divsearch_ins').hide();
      $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: base_url + 'matricula/fn_matricula_x_codigo',
          type: 'post',
          dataType: 'json',
          data: {
                  'ce-idmat': idmat,
              },
          success: function(e) {
              $('#divcard-matricular #divoverlay').remove();
              if (e.status == false) {
                  Swal.fire({
                      type: 'error',
                      icon: 'error',
                      title: 'Error!',
                      text: e.msg,
                      backdrop: false,
                  })
              } else {
                  $('#titlemodal').html(e.matdata['nomalu']);

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

                  $('#fm-txtobservacionesup').val(e.matdata['observacion']);
                  
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#divcard-matricular #divoverlay').remove();
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
    }

});

$("#modupmat").on('hidden.bs.modal', function (e) {
  $("#frm_updmatri")[0].reset();
  $('#fm-txtidmatriculaup').val('0');
  $('#titlemodal').html("MATRICULAR");

  $('#fm-txtidup').val('');
  $('#fm-txtcarreraup').val('');
  $('#fm-txtperiodoup').val('')
  $('#fm-txtplanup').val('');
  $('#fm-cbplanup').html('');
})

$('#modfiltroins').on('hidden.bs.modal', function (e) {
  $('#frm-getinscritonew')[0].reset();
  $('#fgi-apellidosnew').html('');
  $('#fgi-nombresnew').html('');
  $('#divcard_result').html('');
})

$('#lbtn_editamat').click(function(e) {
  $('#frm_updmatri input,select').removeClass('is-invalid');
  $('#frm_updmatri .invalid-feedback').remove();
  $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
      url: $("#frm_updmatri").attr("action"),
      type: 'post',
      dataType: 'json',
      data: $('#frm_updmatri').serialize(),
      success: function(e) {
          $('#divmodaladd #divoverlay').remove();
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
          $('#divmodaladd #divoverlay').remove();
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
                var btnselect = '';
                tabla = '<div class="col-12 py-1">'+
                    '<div class="btable">'+
                        '<div class="thead col-12  d-none d-md-block">'+
                            '<div class="row">'+
                                '<div class="col-12 col-md-5">'+
                                    '<div class="row">'+
                                        '<div class="col-2 col-md-2 td">N°</div>'+
                                        '<div class="col-10 col-md-10 td">ESTUDIANTE</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-12 col-md-6">'+
                                    '<div class="row">'+
                                        '<div class="col-3 col-md-3 td">ESTADO</div>'+
                                        '<div class="col-9 col-md-4 td">PROG</div>'+
                                        '<div class="col-9 col-md-5 td">PERIODO</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-12 col-md-1 text-center">'+
                                    '<div class="row">'+
                                        '<div class="col-12 col-md-12 td">'+
                                            '<span></span>'+
                                        '</div>'+

                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            
                        '</div>'+
                        '<div class="tbody col-12" id="divcard_data_alumnos">'+
                            
                        '</div>'+
                    '</div>'+
                '</div>';
                var nro = 0;
                $.each(e.vdata, function(index, val) {
                  nro++;
                  if (val['estado'] == "ACTIVO") {
                    estado = "<span class='badge bg-success p-2'> "+val['estado']+" </span>";
                    btnselect = "<a href='#' class='btn btn-info btn-sm btn_select' title='seleccionar'><i class='fas fa-share'></i></a>";
                  } else if (val['estado'] == "POSTULA") {
                    estado = "<span class='badge bg-warning p-2'> "+val['estado']+" </span>";
                    btnselect = '';
                  } else if (val['estado'] == "EGRESADO") {
                    estado = "<span class='badge bg-secondary p-2'> "+val['estado']+" </span>";
                    btnselect = '';
                  } else if (val['estado'] == "RETIRADO") {
                    estado = "<span class='badge bg-danger p-2'> "+val['estado']+" </span>";
                    btnselect = '';
                  } else if (val['estado'] == "TITULADO") {
                    estado = "<span class='badge bg-info p-2'> "+val['estado']+" </span>";
                    btnselect = '';
                  } else {
                    estado = "<span class='badge bg-warning p-2'> "+val['estado']+" </span>";
                    btnselect = '';
                  }

                  if (val['estado'] !== "RETIRADO") {
                    tbody=tbody + 
                    "<div class='row rowcolor cfilains' data-carnet='"+val['carnet']+"'>"+
                        "<div class='col-12 col-md-5'>"+
                            "<div class='row'>"+
                                "<div class='col-2 col-md-2 text-right td'>"+nro+"</div>"+
                                "<div class='col-10 col-md-10 td'>"+val['codinscripcion']+"-"+val['paterno']+" "+val['materno']+" "+val['nombres']+"</div>"+
                            "</div>"+
                        "</div>"+
                        "<div class='col-12 col-md-6'>"+
                            "<div class='row'>"+
                                "<div class='col-3 col-md-3 td'>"+estado+"</div>"+
                                "<div class='col-9 col-md-4 td'>"+val['carsigla']+" / "+val['codturno']+" - "+val['ciclo']+" - "+val['codseccion']+"</div>"+
                                "<div class='col-9 col-md-5 td'>"+val['periodo']+" / "+val['campania']+"</div>"+
                            "</div>"+
                        "</div>"+
                        "<div class='col-12 col-md-1 text-center td'>"+
                            btnselect +
                        "</div>"+
                    "</div>";
                  }
                  
                })

                $('#divcard_result').html(tabla);
                $('#divcard_data_alumnos').html(tbody);

                $('.btn_select').click(function(e) {
                  e.preventDefault();
                  var boton = $(this);
                  var fila = boton.closest('.cfilains');
                  var carne = fila.data('carnet');
                  $('#divmodalsearch').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                  $.ajax({
                      url: base_url + "inscrito/fn_get_datos_carne",
                      type: 'post',
                      dataType: 'json',
                      data: {
                        'fgi-txtcarne':carne,
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
                            if (e.vdata['idinscripcion'] == '0') {
                                $('#fm-txtcarreraup').val("");
                                $('#fm-carreraup').val("PROGRAMA ACADÉMICO");
                                $('#fm-cbplanup').html("<option value='0'>Plán curricular NO DISPONIBLE</option>");
                                
                            } else {
                                
                                // $('#fgi-apellidosnew').html(e.vdata['paterno'] + ' ' + e.vdata['materno']);
                                // $('#fgi-nombresnew').html(e.vdata['nombres']);
                                $('#fm-txtcarreraup').val(e.vdata['codcarrera']);
                                $('#fm-carreraup').html(e.vdata['carrera']);
                                $('#fm-cbplanup').html(e.vplanes);
                                $('#fm-cbplanup').val(e.vdata['codplan']);
                                $('#fm-txtplanup').val(e.vdata['codplan']);

                                $('#fm-txtmapepatup').val(e.vdata['paterno']);
                                $('#fm-txtmapematup').val(e.vdata['materno']);
                                $('#fm-txtmnombresup').val(e.vdata['nombres']);
                                $('#fm-txtmsexoup').val(e.vdata['sexo']);
                                
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

                });
                
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
                Swal.fire({
                        type: 'warning',
                        title: 'ADVERTENCIA',
                        text: e.msg,
                        backdrop: false,
                    })
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

                    $('#fm-txtmapepat').val(e.vdata['paterno']);
                    $('#fm-txtmapemat').val(e.vdata['materno']);
                    $('#fm-txtmnombres').val(e.vdata['nombres']);
                    $('#fm-txtmsexo').val(e.vdata['sexo']);
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
$("#btn-cancelar").click(function(event) {
    $("#frm-matricular")[0].reset();
});



$("#frm-matricular").submit(function(event) {
    /* Act on the event */
    $('#frm-matricular input,select').removeClass('is-invalid');
    $('#frm-matricular .invalid-feedback').remove();
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divcard-matricular #divoverlay').remove();
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
                        title: 'Error, matrícula NO registrada',
                        text: e.msg,
                        backdrop: false,
                    })
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                }
            } else {
                //$("#fm-txtidmatricula").html(e.newcod);
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: 'Felicitaciones, matrícula registrada',
                    text: 'Se han registrado cursos',
                    backdrop: false,
                })
                $("#vwtxtcodmat").val(base64url_encode(e.newcod));
                    $("#divcarne").html("<h3>" + $("#fgi-txtcarne").val().toLowerCase() + "</h3>");
                    $("#divmiembro").html($("#fgi-apellidos").html() + " " + $("#fgi-nombres").html());

                    $("#divperiodo").html($("#fm-cbperiodo").val());
                    $("#divcarrera").html($("#fm-carrera").html());
                    $("#divciclo").html("Ciclo: " + $("#fm-cbciclo").val());
                    $("#divturno").html("Turno: " + $("#fm-cbturno").val());
                    $("#divseccion").html("Sección: " + $("#fm-cbseccion").val());

                    $("#fud-cbperiodo").html($("#fm-cbperiodo option:selected" ).text());
                    $("#fud-cbperiodo").data($("#fm-cbperiodo").val());



                mostrarCursos("div-cursosmat", "", e.vdata);
                var url = base_url + "academico/matricula/imprimir/" + base64url_encode(e.newcod);
                $("#div-cursosmat").append(
                    '<div class="cfilaprint row">' +
                    '<div class="col-12 col-md-12 text-right td"><a class="btn btn-info" target="_blank" href="' + url + '" title="Imprimir matrícula"><i class="fas fa-print mr-1"></i> Imprimir Matrícula</a></div>' +
                    '</div></div>');


                $('.nav-pills a[href="#fichacarga"]').tab('show');
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard-matricular #divoverlay').remove();
            Swal.fire({
                type: 'error',
                icon: 'error',
                title: 'Error, matrícula NO registrada',
                text: msgf,
                backdrop: false,
            })
        }
    });
    return false;
});

function comprobarcurso(){
  $( "#div-cursosmat .cfila").each(function( index ) {
    var cc=$(this).data('cc');
    var cs=$(this).data('ccs');
    //alert(cc + cs);
      $( "#div-cursosdispo .cfila").each(function( index2 ) {
        var ccd=$(this).data('cc');
        var csd=$(this).data('ccs');

        if ((cc==ccd) && (cs==csd)){
          $(this).remove();
        }
      });
  });
}
function ordenarnro(div){
  var nro=0;
  $( "#" + div + " .tdnro").each(function( index ) {
    nro=nro + 1;
    $(this).html(nro);
  });
}

function mostrarCursos(div, vcm, vdata,agregar='no') {
    var vplan = "00";
    var nro = 0;
    $("#" + div).html("");
    $.each(vdata, function(index, v) {
        nro++;
        var mcidcarga=base64url_encode(v['idcarga']);
        jsbtnagregar="";
        if (agregar=='si'){
          var codcurso=base64url_encode(v['codcurso']);
          jsbtnagregar='<div class="td col-2 col-md-12"><button data-ccurso="'+ codcurso + '" data-cc="'+ mcidcarga + '"  data-cd="'+ v['subseccion'] + '" data-cm="'+ vcm + '" title="Enrolar" class="btn btn-enrolar btn-sm btn-primary"><i class="fas fa-book-medical"></i></button></div>' ;
        }
        jsbtnretirar="";
        if (agregar=='no'){
          var midmiembro=base64url_encode(v['idmiembro']);
          
          jsbtnretirar='<div class="td col-2 col-md-12"><button   data-im="'+ midmiembro + '"  title="Eliminar" class="btn btn-desenrolar btn-sm btn-danger"><i class="fas fa-minus-square"></i></button></div>' ;
        }
        if (vplan != v['codplan'] + v['codmodulo']) {
            vplan = v['codplan'] + v['codmodulo'];
            $("#" + div).append(
                '<div class="row text-bold ">' +
                '<div class="col-12 col-md-12 td"> Plan: ' +
                v['codplan'] + " : Módulo N° " + v['nromodulo'] + " / " + v['modulo'] + " / " + v['carrera'] +
                '</div>' +
                '</div>');
        }
        if (v['paterno'] == null) v['paterno'] = "SIN";
        if (v['materno'] == null) v['materno'] = "DOCENTE";
        if (v['nombres'] == null) v['nombres'] = "";
        var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
        $("#" + div).append(
            '<div class="cfila row ' + rowcolor + ' " data-cc="' + mcidcarga + '" data-ccs="' + v['subseccion']  + '">' +
              '<div class="col-4 col-md-3">' +
                '<div class="row">' +
                  '<div class="tdnro col-3 col-md-2 td">' + nro + '</div>' +
                  '<div class="col-9 col-md-10 td">' + v['curso'] + '</div>' +
                '</div>' +
              '</div>' +
              '<div class="col-6 col-md-3">' +
                '<div class="row">' +
                  '<div class="td col-2 col-md-4 text-center ">' + v['ciclo'] + ' - ' + v['codseccion'] + v['subseccion'] + '</div>' +
                  '<div class="td col-2 col-md-4 text-center ">' + v['codturno'] + '</div>' +
                '</div>' +
              '</div>' +
              '<div class="col-6 col-md-3">' +
                '<div class="row">' +
                  '<div class="td col-2 col-md-4 text-center ">' + '1' + '</div>' +
                  '<div class="td col-2 col-md-4 text-center ">' + (parseInt(v['hts']) + parseInt(v['hps'])) + '</div>' +
                  '<div class="td col-2 col-md-4 text-center ">' + (parseInt(v['ct']) + parseInt(v['cp'])) + '</div>' +
                '</div>' +
              '</div>' +
              '<div class="col-6 col-md-2 td">' + v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres']  + '</div>' +
              '<div class="col-6 col-md-1">' + jsbtnagregar + jsbtnretirar + '</div>' +
            '</div>');


    });
                //******************************************
          if (agregar=='si'){
            $(".btn-enrolar").on("click", function() {
              $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
              

              var codc=$(this).data('cc');
              var codm=$(this).data('cm');
              var codd=$(this).data('cd');
              var codcarne=$("#divcarne").find('H3').html();
              var codcurso=$(this).data('ccurso');
              var btnenr=$(this);
              var idm="0";
              $.ajax({
                url: base_url + "miembros/fn_insert/SI",
                type: 'post',
                dataType: 'json',
                data: {
                    "fm-codcarga": codc,
                    "fm-codmatricula": codm,
                    "fm-division": codd,
                    "fm-carne": codcarne,
                    "fm-codcurso": codcurso,
                    "fm-idmiembro": idm
                },
                success: function(e) {
                    $('#divcard-matricular #divoverlay').remove();
                    if (e.status == true) {


                        btnenr.parents(".cfila").appendTo('#div-cursosmat');
                        $(".cfilaprint").appendTo('#div-cursosmat');
                        ordenarnro("div-cursosmat");
                        ordenarnro("div-cursosdispo");
                        $('#divcard-matricular #divoverlay').remove();
                        Swal.fire({
                            type: 'success',
                            title: 'Éxito, enrolamiento realizado',
                            text: e.msg,
                            backdrop: false,
                        })
                       
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
          else{
            $(".btn-desenrolar").on("click", function() {
              $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
              var alumno=$("#divmiembro").html();
              var btndes=$(this);
              //************************************
              Swal.fire({
                title: "Precaución",
                text: "Se eliminarán las notas y asistencias del alumno " + alumno + ", en este curso: ",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!'
              }).then((result) => {
                if (result.value) {
                    var codc=$(this).data('im');
                        $.ajax({
                          url: base_url + "miembros/fn_eliminar",
                          type: 'post',
                          dataType: 'json',
                          data: {
                              "fm-idmiembro": codc
                          },
                          success: function(e) {
                              $('#divcard-matricular #divoverlay').remove();
                              if (e.status == true) {
                                  btndes.parents(".cfila").remove();
                                  ordenarnro("div-cursosmat");
                                  $('#divcard-matricular #divoverlay').remove();
                                  Swal.fire({
                                      type: 'success',
                                      title: 'Éxito,  realizado',
                                      text: e.msg,
                                      backdrop: false,
                                  })
                                 
                              }
                              else{
                                Swal.fire({
                                    type: 'error',
                                    title: 'Error, NO se pudo realizar la eliminación',
                                    text: e.msg,
                                    backdrop: false,
                                })
                              }
                          },
                        error: function(jqXHR, exception) {
                          //$('#divcard_grupo #divoverlay').remove();
                           var msgf = errorAjax(jqXHR, exception, 'text');
                           Swal.fire({
                                  type: 'error',
                                  title: 'Error, NO se pudo realizar la eliminación',
                                  text: e.msgf,
                                  backdrop: false,
                              })
                        }
                    })
                }
                else{
                   $('#divcard-matricular #divoverlay').remove();
                }
              });
              //***************************************
            });
          }
}     
$("#frmfiltro-unidades").submit(function(event) {
    $("#btn-vercurricula").show();
    $('#div-cursosdispo').html("");
    //$("#divcard_grupo select").prop('disabled', false);
    var fdata = new Array();
    fdata.push({
        name: 'periodo',
        value: $("#fud-cbperiodo").data('cp')
    });
    fdata.push({
        name: 'carrera',
        value: $("#fud-cbcarrera").val()
    });
    fdata.push({
        name: 'plan',
        value: $("#fud-cbplan").val()
    });
    fdata.push({
        name: 'ciclo',
        value: $("#fud-cbciclo").val()
    });
    fdata.push({
        name: 'turno',
        value: $("#fud-cbturno").val()
    });
    fdata.push({
        name: 'seccion',
        value: $("#fud-cbseccion").val()
    });
    var vcm=$("#vwtxtcodmat").val();
    $.ajax({
        url: base_url + 'cargasubseccion/fn_filtrar',
        type: 'post',
        dataType: 'json',
        data: fdata,
        success: function(e) {
            mostrarCursos('div-cursosdispo',vcm , e.vdata,'si');
            comprobarcurso();
            ordenarnro('div-cursosdispo');
            //.html(e.vdata);
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            Toast.fire({
                type: 'warning',
                title: 'Aviso: ' + msgf
            })
            $('#div-cursosdispo').html("");
        }
    });
    return false;
});
$("#fud-cbcarrera").change(function(event) {
    /* Act on the event */
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
});
$(document).ready(function() {
    $("#fmt-cbperiodo").val(getUrlParameter("cp", '%'));
    $("#fmt-cbcarrera").val(getUrlParameter("cc", '%'));
    
    $("#fmt-cbciclo").val(getUrlParameter("ccc", '%'));
    $("#fmt-cbturno").val(getUrlParameter("ct", '%'));
    $("#fmt-cbseccion").val(getUrlParameter("cs", '%'));
    $("#fmt-cbplan").val(getUrlParameter("cpl", '%'));
    
    if (getUrlParameter("at", 0) == 1) $("#frmfiltro-matriculas").submit();
});
</script>