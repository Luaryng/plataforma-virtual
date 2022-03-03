    <div class="modal fade" id="md_docentes" tabindex="-1" role="dialog" aria-labelledby="md_docentes" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divcontent_docentes">
                <div class="modal-header">
                    <h5 class="modal-title">Docentes Activos</h5>
                    
                </div>
                <div class="modal-body">
                    <!--<div class="col-12" id="divcard_docentes">-->
                    <input type="hidden" name="vw_md_doc_txtcarga" id="vw_md_doc_txtcarga">
                    <input type="hidden" name="vw_md_doc_txtdivision" id="vw_md_doc_txtdivision">
                    <div class="col-12 border bg-lightgray p-1 mb-3" >
                        <h5 id="vw_md_doc_div_unidad"></h5>
                    </div>
                    <div class="form-group has-float-label col-12 col-md-12">
                        <select class="form-control form-control-sm" id="vw_md_doc_docentes" name="vw_md_doc_docentes" placeholder="Periodo">
                            <option value="00000">SIN DOCENTE</option>
                            <?php foreach ($docentes as $coddoc => $doc) {?>
                            <option value="<?php echo $doc->coddocente64 ?>"><?php echo $doc->paterno." ".$doc->materno." ".$doc->nombres ?></option>
                            <?php } ?>
                        </select>
                        <label for="vw_md_doc_docentes"> Docente</label>
                    </div>
                    <!--</div>-->
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-secondary float-left" data-dismiss="modal">Cerrar</button>
                    
                    <button type="button" id="vw_md_doc_guardar" data-codigo='' class="btn btn-primary float-right">
                    <i class="fas fa-save mr-1"></i>Guardar
                    </button>
                </div>
                
            </div>
        </div>
    </div>

<div class="modal fade" id="md-plan" tabindex="-1" role="dialog" aria-labelledby="md-plan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Terminar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modEnrolados" tabindex="-1" role="dialog" aria-labelledby="modEnrolados" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modEnrolados_content">
            <div class="modal-header">
                <h5 class="modal-title" >Estudiantes Enrolados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" value="0" id="vw_cme_txtcodcarga">
                <input type="hidden" value="0" id="vw_cme_txtcoddivision">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        Docente: <span id="vw_cme_spnDocente"></span>
                    </div>
                    <div class="col-md-2">
                        Periodo: <span id="vw_cme_spnPeriodo"></span>
                    </div>
                    <div class="col-md-10">
                        Programa: <span id="vw_cme_spnPrograma"></span>
                    </div>
                    <div class="col-md-2">
                        Semestre: <span id="vw_cme_spnSemestre"></span>
                    </div>
                    <div class="col-md-2">
                        Turno: <span id="vw_cme_spnTurno"></span>
                    </div>
                    <div class="col-md-2">
                        Sección: <span id="vw_cme_spnSeccion"></span>
                    </div>
                    <div class="col-md-2">
                        División: <span id="vw_cme_spnDivision"></span>
                    </div>
                    <div class="col-md-2">
                        Cálculo: <span id="vw_cme_spnMetodo"></span>
                        <a  href="#" data-toggle="modal" data-target="#modCambiarCalculo" title="Cambiar Cálculo">
                            <i class="fas fa-pencil-alt ml-1"></i>
                        </a>
                        <a href="#" title="Editar Estructura de Registro"><i class="fas fa-calculator ml-1"></i></a>
                    </div>
                    
                </div>
                <div class="col-12 border rounded p-1 bg-lightgray" >
                    <h4 id="vw_md_pagos_estudiante"></h4>
                </div>
                <div class="col-12 border rounded p-1 bg-lightgray" >
                    <h4 id="vw_md_pagos_gestion"></h4>
                </div>
                <hr>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="md_enrolados-tab" data-toggle="tab" href="#md_enrolados" role="tab" aria-controls="md_enrolados" aria-selected="true">Enrolados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="md_reuniones-tab" data-toggle="tab" href="#md_reuniones" role="tab" aria-controls="md_reuniones" aria-selected="false">Reuniones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="asistencia-tab" data-toggle="tab" href="#asistencia" role="tab" aria-controls="asistencia" aria-selected="false">Asistencia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="md_evaluaciones-tab" data-toggle="tab" href="#md_evaluaciones" role="tab" aria-controls="md_evaluaciones" aria-selected="false">Evaluaciones</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="md_enrolados" role="tabpanel" aria-labelledby="md_enrolados-tab">
                        <div class="table-responsive">
                            <table id="tbce_dtEstutiantesEnrolados" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                                <thead>
                                    <tr class="bg-lightgray">
                                        <th>N°</th>
                                        <th>Filial</th>
                                        <th>Carné</th>
                                        
                                        <th>Estudiante</th>
                                        <th>Grupo</th>
                                        <th><i class="fas fa-cogs"></i></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="md_reuniones" role="tabpanel" aria-labelledby="md_reuniones-tab">...</div>
                    <div class="tab-pane fade" id="md_asistencia" role="tabpanel" aria-labelledby="md_asistencia-tab">...</div>
                    <div class="tab-pane fade" id="md_evaluaciones" role="tabpanel" aria-labelledby="md_evaluaciones-tab">
                        <div class="table-responsive">
                            <table id="tbce_dtEstutiantesEvaluaciones" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                                <thead>
                                    
                                    
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modCambiarCalculo" tabindex="-1" role="dialog" aria-labelledby="modCambiarCalculo" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modcambiarCalculo_content">
            <div class="modal-header">
                <h5 class="modal-title" >Cambiar metodo de cálculo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="btable">
                    <div class="thead col-12  d-none d-md-block bg-lightgray">
                        <div class="row">
                            <div class='col-12 col-md-2'>
                                <div class='row'>
                                    <div class='col-2 col-md-2 td'>N°</div>
                                    <div class='col-10 col-md-10 td'>Abrevia</div>
                                    
                                </div>
                            </div>
                            <div class='col-12 col-md-10 td'>
                                Descripción
                            </div>
                        </div>
                        
                    </div>
                    <div class="tbody col-12">
                        <?php
                        $nro=0;
                        foreach ($metodos as $key => $metodo) {
                        $nro++;
                        echo
                        "<div class='row cfila' data-codmetodo64='".base64url_encode($metodo->codigo)."' data-metodo='$metodo->codigo'>
                            <div class='col-12 col-md-4'>
                                <div class='row'>
                                    <div class='col-2 col-md-1 td bg-lightgray'>$nro</div>
                                    <div class='col-10 col-md-2 td'>$metodo->codigo</div>
                                    <div class='col-10 col-md-9 td'>$metodo->nombre</div>
                                </div>
                            </div>
                            <div class='col-12 col-md-7 td'>
                                $metodo->descripcion
                            </div>
                            <div class='col-12 col-md-1 td text-center'>
                                <a onclick='fn_asignar_metodo($(this));return false' href='#'><i class='fas fa-check-square fa-2x'></i></a>
                            </div>
                        </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>

<!--MODAL CAMBIAR CARGA Y SUBSECCION DE ESTUDIANTE-->
<div class="modal fade" id="modCambiarCargaDivision" tabindex="-1" role="dialog" aria-labelledby="modCambiarCargaDivision" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modCambiarCargaDivision_content">
            <div class="modal-header">
                <h5 class="modal-title" >Cambiar metodo de cálculo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <h4 class="bg-lightgray border px-2" id="vw_md_ccd_spnestudiante"></h4>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="vw_md_ccd_txtcarga" name="vw_md_ccd_txtcarga" aria-label="Código de Carga Académica">
                  <div class="input-group-prepend">
                    <span class="input-group-text">G</span>
                  </div>
                  <input type="text" class="form-control" id="vw_md_ccd_txtdivision" name="vw_md_ccd_txtdivision" aria-label="Código de la Subsección">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="vw_md_ccd_btguardar" onclick="fn_miembro_update_CargaDivision($(this));return false;" data-idmiembro64='' class="btn btn-primary float-right">
                    <i class="fas fa-save mr-1"></i>Guardar
                    </button>
            </div>
        </div>
    </div>
</div>
<!--MODAL FUSIONAR-->
<div class="modal fade" id="modFusionar" tabindex="-1" role="dialog" aria-labelledby="modFusionar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modFusionar_content">
            <div class="modal-header">
                <h5 class="modal-title" >Fusión de Unidades Didacticas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <input type="text" id="vw_mdfs_txtcodcarga">
                    <input type="text" id="vw_mdfs_txtdivision">
                    <form id="frmfiltro-carga_academica_fusion" name="frmfiltro-carga_academica_fusion" method="post" accept-charset='utf-8'>
                        <div class="row">
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                                <select  class="form-control form-control-sm" id="fmt-cbsede" name="fmt-cbsede" placeholder="Filial">
                                    <option value="%"></option>
                                    <?php
                                    foreach ($sedes as $filial) {
                                    $select=($vuser->idsede==$filial->id) ? "selected":"";
                                    echo "<option $select value='$filial->id'>$filial->nombre</option>";
                                    }
                                    ?>
                                </select>
                                <label for="fmt-cbsede"> Filial</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                                <select  class="form-control form-control-sm" id="fmt-cbperiodo" name="fmt-cbperiodo" placeholder="Periodo">
                                    <option value="%"></option>
                                    <?php foreach ($periodos as $periodo) {?>
                                    <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="fmt-cbperiodo"> Periodo</label>
                            </div>
                            
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-3">
                                <select  class="form-control form-control-sm" id="fmt-cbcarrera" name="fmt-cbcarrera" placeholder="Programa Académico" >
                                    <option value="%"></option>
                                    <?php foreach ($carreras as $carrera) {?>
                                    <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="fmt-cbcarrera"> Prog. de Estudios</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                                <select name="fmt-cbplan" id="fmt-cbplan"class="form-control form-control-sm">
                                    <option data-carrera="0" value="%">Todos</option>
                                    <option data-carrera="0" value="0">Sin Plan</option>
                                    <?php foreach ($planes as $pln) {
                                    echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
                                    } ?>
                                </select>
                                <label for="fmt-cbplan">Plan estudios</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                                <select  class="form-control form-control-sm" id="fmt-cbciclo" name="fmt-cbciclo" placeholder="Semestre" >
                                    <option value="%"></option>
                                    <?php foreach ($ciclos as $ciclo) {?>
                                    <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="fmt-cbciclo">Semestre</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                                <select  class="form-control form-control-sm" id="fmt-cbturno" name="fmt-cbturno" placeholder="Turno" >
                                    <option value="%"></option>
                                    <?php foreach ($turnos as $turno) {?>
                                    <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="fmt-cbturno"> Turno</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                                <select  class="form-control form-control-sm" id="fmt-cbseccion" name="fmt-cbseccion" placeholder="Sección" >
                                    <option value="%"></option>
                                    <?php foreach ($secciones as $seccion) {?>
                                    <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="fmt-cbseccion"> Sección</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-5 col-md-5">
                                <input class="form-control text-uppercase form-control-sm" autocomplete="off" id="fmt-txtbusqueda" name="fmt-txtbusqueda" placeholder="Unidad Didáctica" >
                                <label for="fmt-txtbusqueda"> Unidad Didáctica
                                </label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-5">
                                <select  class="form-control form-control-sm" id="fmt-cbdocente" name="fmt-cbdocente" placeholder="Sección" >
                                  <option value="%"></option>
                                  <option value="00000">SIN DOCENTE</option>
                                        <?php foreach ($docentes as $coddoc => $doc) {?>
                                        <option value="<?php echo $doc->coddocente ?>"><?php echo $doc->paterno." ".$doc->materno." ".$doc->nombres ?></option>
                                        <?php } ?>
                                </select>
                                <label for="fmt-cbdocente"> Docente</label>
                              </div>
                            <div class="col-6 col-sm-2 col-md-1">
                                <button type="submit" class="btn btn-sm btn-primary btn-block"><i class="fas fa-search"></i></button>
                            </div>
                            
                        </div>
                    </form>
                </div>
                <div class="col-12 px-0 pt-2">
              <div class="table-responsive">
                <table id="tbc_dtCargaAcademica_fusion" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                  <thead>
                    <tr class="bg-lightgray">
                      <th>N°</th>
                      <th>Filial</th>
                      <th>Carga</th>
                      
                      <th>Plan</th>
                      <th>Grupo</th>
                      <th>Unidad Didáctica</th>
                      <th title="ABIERTO"><i class="far fa-folder-open"></i></th>
                      <th title="VISIBLE"><i class="far fa-eye"></i></th>
                      <th>Cd</th>
                      <th>Hr</th>
                      <th title="ENROLADOS"><i class="fas fa-user-friends"></i></th>
                      <th>Docente</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </div>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>
<!--<div class="modal fade" id="modEnrolados" tabindex="-1" role="dialog" aria-labelledby="modEnrolados" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modEnrolados_content">
            <div class="modal-header">
                <h5 class="modal-title" >Estudiantes Enrolados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" value="0" id="vw_cme_txtcodcarga">
                <input type="hidden" value="0" id="vw_cme_txtcoddivision">
            </div>
            <div class="modal-body">
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>-->