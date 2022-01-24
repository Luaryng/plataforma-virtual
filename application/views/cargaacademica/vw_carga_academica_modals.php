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
                



                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>