<?php
$vbaseurl=base_url();
date_default_timezone_set('America/Lima');
$vuser=$_SESSION['userActivo'];
$fechahoy = date('Y-m-d');

?>
<!--<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.css"/>
<style>
  .btn_search_bol {
    border-top-right-radius: 0.25rem!important;
    border-bottom-right-radius: 0.25rem!important;
  }

  table.dataTable tbody tr.selected a:not(.bg-danger,.bg-primary,.bg-info,.bg-success,.bg-warning,.bg-secondary, a.dropdown-item) {
    color: #007bff !important;
  }

  .dropdown-item:not(.text-danger,.text-primary,.text-info,.text-success,.text-warning) {
    color: #212529!important;
  }

  .bg-selection {
    background-color: #F9F4BC;
  }
</style>
<div class="content-wrapper">
  <?php include("vw_matriculas_modals_matricular.php") ?>
  <?php include("vw_matriculas_modals.php") ?>
  <section id="s-cargado" class="content pt-1">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-matriculas-tab" data-toggle="tab" href="#nav-matriculas" role="tab" aria-controls="nav-matriculas" aria-selected="true">Matrículas</a>
        <a class="nav-item nav-link" id="nav-grupos-tab" data-toggle="tab" href="#nav-grupos" role="tab" aria-controls="nav-grupos" aria-selected="false">Grupos</a>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-matriculas" role="tabpanel" aria-labelledby="nav-matriculas-tab">
        <div id="divcard-matricular" class="card">

          <div class="card-body">
            
                <form id="frmfiltro-matriculas" name="frmfiltro-matriculas" action="<?php echo $vbaseurl ?>matricula/fn_filtrar" method="post" accept-charset='utf-8'>
                  <div class="row">
                    <div class="form-group has-float-label col-12 col-sm-4 col-md-2">
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
                    <div class="form-group has-float-label col-12 col-sm-4 col-md-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbperiodo" name="fmt-cbperiodo" placeholder="Periodo">
                        <option value="%"></option>
                        <?php foreach ($periodos as $periodo) {?>
                        <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbperiodo"> Periodo</label>
                    </div>
                    
                    <div class="form-group has-float-label col-12 col-sm-6 col-md-3">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbcarrera" name="fmt-cbcarrera" placeholder="Programa Académico" >
                        <option value="%"></option>
                        <?php foreach ($carreras as $carrera) {?>
                        <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbcarrera"> Prog. de Estudios</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
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
                      <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbciclo" name="fmt-cbciclo" placeholder="Semestre" >
                        <option value="%"></option>
                        <?php foreach ($ciclos as $ciclo) {?>
                        <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbciclo">Semestre</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbturno" name="fmt-cbturno" placeholder="Turno" >
                        <option value="%"></option>
                        <?php foreach ($turnos as $turno) {?>
                        <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbturno"> Turno</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbseccion" name="fmt-cbseccion" placeholder="Sección" >
                        <option value="%"></option>
                        <?php foreach ($secciones as $seccion) {?>
                        <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbseccion"> Sección</label>
                    </div>
                    <div class="form-group has-float-label col-12  col-sm-2">
                      <select data-currentvalue="" class="form-control form-control-sm" id="fmt-cbestado" name="fmt-cbestado" required="">
                        <option value="%"></option>
                        <?php foreach ($estados as $estado) {?>
                        <option value="<?php echo $estado->codigo ?>"><?php echo $estado->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbestado"> Estado</label>
                    </div>
                    <div class="form-group has-float-label col-12  col-md-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbbeneficio" name="fmt-cbbeneficio" placeholder="Periodo" required >
                         <option value="%">Todos</option>
                        <?php foreach ($beneficios as $beneficio) {?>
                        <option value="<?php echo $beneficio->id ?>"><?php echo $beneficio->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbbeneficio"> Beneficio</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-5 col-md-5">
                      <input class="form-control text-uppercase form-control-sm" autocomplete="off" id="fmt-alumno" name="fmt-alumno" placeholder="Carné o Apellidos y nombres" >
                      <label for="fmt-alumno"> Carné o Apellidos y nombres
                      </label>
                    </div>
                    <div class="col-6 col-sm-2 col-md-1">
                      <button type="submit" class="btn btn-sm btn-primary btn-block"><i class="fas fa-search"></i></button>
                    </div>
                    <div class="col-6 col-sm-4 col-md-2">

                      <div class="btn-group">
                        <button class="btn-excel btn btn-outline-success btn-sm py-0" type="button">
                          Exportar <img height="20px"  src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt=""> 
                        </button>
                        <button type="button" class="btn btn-sm btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Split</span>
                        </button>
                        <div class="dropdown-menu">
                          <a href="#" class="btn_campos dropdown-item py-0">
                            <img height="20px" src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt=""> Otros Campos
                          </a>
                        </div>
                      </div>

                      <!--<a href="#" class="btn-excel btn btn-sm btn-outline-secondary"><img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt=""> Exportar</a>
                      <a href="#" class="btn_campos btn btn-sm btn-outline-secondary"><img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt=""> Campos</a>
                      
                      <button type="button" class="btn btn-success btn-sm float-right text-center" data-accion="INSERTAR" data-toggle="modal" data-target="#modupmat">
                        <i class="fas fa-plus mr-1"></i> Matricular</button>-->
                    </div>
                  </div>
                </form>
                <div class="col-12 px-0 pt-2 table-responsive">
                  <div class="alert alert-danger alert-dismissible fade show" id="vw_mt_divmensaje" role="alert">
                    <span id="vw_mt_spanmensaje"></span>
                   
                  </div>
                  <table id="tbmt_dtMatriculados" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                  <thead>
                      <tr class="bg-lightgray">
                          <th>N°</th>
                          <th>Filial</th>
                          <th>Carné</th>
                          
                          <th>Estudiante / Edad</th>
                          <th>Fec.Mat.</th>
                          <th>Cuota</th>
                          <th>Plan</th>
                          <th>Grupo</th>
                          <th>Est.</th>
                          <!--<th title="ABIERTO"><i class="far fa-folder-open"></i></th>
                          <th title="VISIBLE"><i class="far fa-eye"></i></th>
                          <th>Cd</th>
                          <th>Hr</th>
                          <th title="ENROLADOS"><i class="fas fa-user-friends"></i></th>-->
                          <th>Ficha</th>
                          <th>Acciones</th>
                      </tr>
                  </thead>
                  <tbody>
                      
                  </tbody>
                </table>
              </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="nav-grupos" role="tabpanel" aria-labelledby="nav-grupos-tab">
        <div id="divboxhistorial" class="card">
          <div class="card-body">
            <form id="frmfiltro-grupos" name="frmfiltro-grupos" action="<?php echo $vbaseurl ?>grupos/fn_filtrar" method="post" accept-charset='utf-8'>
              <div class="row">
                
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control" id="fm-cbperiodo" name="fm-cbperiodo" placeholder="Periodo" required >
                    <option value="%"></option>
                    <?php foreach ($periodos as $periodo) {?>
                    <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbperiodo"> Periodo</label>
                </div>
                
                <div class="form-group has-float-label col-12 col-sm-3">
                  <select data-currentvalue='' class="form-control" id="fm-cbcarrera" name="fm-cbcarrera" placeholder="Programa Académico" required >
                    <option value="%"></option>
                    <?php foreach ($carreras as $carrera) {?>
                    <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbcarrera"> Programa Académico</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control" id="fm-cbciclo" name="fm-cbciclo" placeholder="Ciclo" required >
                    <option value="%"></option>
                    <?php foreach ($ciclos as $ciclo) {?>
                    <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbciclo"> Ciclo</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control" id="fm-cbturno" name="fm-cbturno" placeholder="Turno" required >
                    <option value="%"></option>
                    <?php foreach ($turnos as $turno) {?>
                    <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbturno"> Turno</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control" id="fm-cbseccion" name="fm-cbseccion" placeholder="Sección" required >
                    <option value="%"></option>
                    <?php foreach ($secciones as $seccion) {?>
                    <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbseccion"> Sección</label>
                </div>
                <div class="col-12  col-sm-1">
                  <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </form>


            <hr>
            <div class="table-responsive">
              
            </div>


          </div>
          <div class="card-body pt-1">
            <div class="btable">
              <div class="thead col-12">
                <div class="row">
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-2 td">N°</div>
                      <div class="col-md-4 td">PERIODO</div>
                      <div class="col-md-6 td">PLAN</div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-8 td">PROG. ACAD.</div>
                      <div class="col-md-4 td">GRUPO</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-3 td">MAT.</div>
                      <div class="col-md-3 td">ACT.</div>
                      <div class="col-md-3 td">RET.</div>
                      <div class="col-md-3 td">CUL.</div>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="row">
                     
                      
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
    
  </section>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.js"></script>
<!--<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>-->
<script>
var vpermiso151 = '<?php echo getPermitido("151") ?>';
var vpermiso172 = '<?php echo getPermitido("172") ?>';
var vpermiso173 = '<?php echo getPermitido("173") ?>';
var cd1 = '<?php echo base64url_encode("1") ?>';
var cd2 = '<?php echo base64url_encode("2") ?>';
var cd7 = '<?php echo base64url_encode("7") ?>';

var cd2de = "<?php echo base64url_encode("ANULADO") ?>";

$('.tbdatatable tbody').on('click', 'tr', function() {
    tabla = $(this).closest("table").DataTable();
    if ($(this).hasClass('selected')) {
        //Deseleccionar
        //$(this).removeClass('selected');
    } else {
        //Seleccionar
        tabla.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        //alert(tabla.table().node().id);
        /*if (tabla.table().node().id=="tbmt_dtEstutiantesEnrolados"){
            tabla.button(1).enable( true);
        }*/
    }
});


$('#frmfiltro-matriculas #fmt-cbcarrera').change(function(event) {
    var codcar = $(this).val();
    if (codcar == "%") {
        $("#frmfiltro-matriculas #fmt-cbplan option").each(function(i) {
            if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
        });
    } else {
        $("#frmfiltro-matriculas #fmt-cbplan option").each(function(i) {
            if ($(this).data('carrera') == '0') {
                //if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
            } else if ($(this).data('carrera') == codcar) {
                $(this).removeClass('ocultar');
            } else {
                if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
            }
        });
    }
});

$(".btn-excel").click(function(e) {
    e.preventDefault();
    /*$('#frm-filtro-inscritos input,select').removeClass('is-invalid');
    $('#frm-filtro-inscritos .invalid-feedback').remove();*/
    var url = base_url + 'academico/matriculas/excel?cp=' + $("#fmt-cbperiodo").val() + '&cc=' + $("#fmt-cbcarrera").val() + '&ccc=' + $("#fmt-cbciclo").val() + '&ct=' + $("#fmt-cbturno").val() + '&cs=' + $("#fmt-cbseccion").val() + '&cpl=' + $("#fmt-cbplan").val() + '&ap=' + $("#fmt-alumno").val() + '&es=' + $("#fmt-cbestado").val() + '&sed=' + $("#fmt-cbsede").val() + '&benf=' + $("#fmt-cbbeneficio").val();
    var ejecuta = true;
    
    if (ejecuta == true) window.open(url, '_blank');
});

$("#frmfiltro-matriculas").submit(function(event) {
    filtrar = 0;
    if ($("#fmt-cbsede").val() != "%") filtrar++;
    if ($("#fmt-cbperiodo").val() != "%") filtrar++;
    if ($("#fmt-cbcarrera").val() != "%") filtrar++;
    if ($("#fmt-cbplan").val() != "%") filtrar++;
    if ($("#fmt-cbciclo").val() != "%") filtrar++;
    if ($("#fmt-cbturno").val() != "%") filtrar++;
    if ($("#fmt-cbseccion").val() != "%") filtrar++;
    if ($("#fmt-cbestado").val() != "%") filtrar++;
    if ($("#fmt-cbbeneficio").val() != "%") filtrar++;
    if ($.trim($("#fmt-alumno").val()).length > 3) filtrar++;
    tbmatriculados = $('#tbmt_dtMatriculados').DataTable();
    tbmatriculados.clear();
    $("#vw_mt_divmensaje").hide();
    if (filtrar > 1) {

        $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

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
                        nro++;
                        var vcm = v['codmatricula64'];
                        var url = base_url + "academico/matricula/imprimir/" + vcm;
                        var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
                        var btnscolor = "";
                        var btnactcondi = "";
                        var textobs = (v['observacion']!= "") ? v['observacion'] : "Ninguna";
                        var observacion = "<br><b>Observación:</b><br>"+textobs;
                        switch (v['estado']) {
                            case "ACT":
                                btnscolor = "btn-success";
                                break;
                            case "CUL":
                                btnscolor = "btn-secondary";
                                break;
                            case "DES":
                                btnscolor = "btn-danger";
                                break;
                            case "RET":
                                btnscolor = "btn-danger";
                                break;
                            default:
                                btnscolor = "btn-warning";
                        }

                        if (vpermiso172 == "SI" && v['estado'] == "DES" && v['condicional'] == "NO") {
                          var btnactcondi = '<a href="#" target="_blank" class="dropdown-item" onclick="fn_activa_matcondicional($(this));return false;" data-codigo="'+vcm+'" data-estado="SI"><i class="fas fa-check-circle mr-2"></i>Activa Condicional</a>';
                        }
                        
                        sexo = (v['codsexo'] == "FEMENINO") ? "<i class='fas fa-female text-danger mr-1'></i>" : "<i class='fas fa-male text-primary mr-1'></i>";
                        nomestudiante = v['paterno'] + " " + v['materno'] + " " + v['nombres'];
                        estudiante = sexo + nomestudiante + " " + v['edad'];
                        fecharegistro = v['registro'] + " <a href='#' class='view_user_reg' tabindex='0' role='button' data-toggle='popover' data-trigger='hover' title='Matriculado por: ' data-content='"+v['usuario']+observacion+"'><i class='fas fa-info-circle fa-lg'></i></a>";
                        vcuota = v['vpension'] + " ("+v['beneficio']+")";
                        grupo = v['periodo'] + " " + v['sigla'] + " " + v['codturno'] + " " + v['ciclo'] + " " + v['codseccion'];
                        boleta = '<a class="bg-success text-white py-1 px-2 mr-1 rounded btncall-boleta" data-cm=' + vcm + ' data-prog=' + v['codcarrera'] + ' data-periodo=' + v['codperiodo'] + ' data-ciclo=' + v['codciclo'] + ' data-turno=' + v['codturno'] + ' data-seccion=' + v['codseccion'] + ' href="#" title="Carga académica" data-toggle="modal" data-target="#modmatriculacurso">' +
                            '<i class="fas fa-book"></i> Bol.' +
                            '</a>';
                        dropdown_estado = '<div class="btn-group">' +
                            '<button class="btn ' + btnscolor + ' btn-sm text-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="estado'+vcm+'">' +
                            v['estado'] +
                            '</button>' +
                            '<div class="dropdown-menu">' +
                            '<a href="#" onclick="fn_cambiarestado($(this))" class="dropdown-item" data-campo="tabla" data-ie="' + cd1 + '">Activo</a>' +
                            '<a href="#" onclick="fn_cambiarestado($(this))" class="dropdown-item" data-campo="tabla" data-ie="' + cd2 + '" data-pagante="'+v['carne']+'" data-pagantenb="'+nomestudiante+'" data-programa="'+ v['carrera'] +'" data-periodo="' + v['periodo'] + '" data-ciclo="' + v['ciclo'] + '" data-turno="' + v['codturno'] + '" data-seccion="' + v['codseccion'] + '" data-plan="' + v['plan'] + '">Retirado</a>' +
                            '<a href="#" onclick="fn_cambiarestado($(this))" class="dropdown-item" data-campo="tabla" data-ie="' + cd7 + '">Desaprobado</a>' +
                            '<div class="dropdown-divider"></div>' +
                            '<a href="#" onclick="fn_eliminar_matricula($(this))" class="btn-ematricula dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>' +
                            '</div>' +
                            '</div>';

                        dropdown_imprimir = '<div class="btn-group dropleft">' +
                            '<button class="btn btn-info btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '<i class="fas fa-print fa-sm"></i>' +
                            '</button>' +
                            '<div class="dropdown-menu">' +
                            '<a target="_blank" href="' + url + '" class="dropdown-item"><i class="far fa-file-pdf text-danger mr-2"></i>PDF</a>' +
                            '<a href="' + base_url + 'academico/matricula/ficha/excel/' + vcm + '" class="dropdown-item" ><i class="far fa-file-excel text-success mr-2"></i>Excel</a>' +
                            ' </div>' +
                            '</div>';
                        dropdown_opciones='<div class="btn-group btn-group-sm p-0 dropleft">' +
                            '<button class="btn btn-info btn-sm dropdown-toggle py-0 rounded" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '<i class="fas fa-cog"></i>' +
                            '</button>' +
                            '<div class="dropdown-menu">' +

                              '<a class="dropdown-item" data-cm='+ vcm +' data-plan="'+v['plan']+'" data-stdnt="'+ v['carne'] +" / "+ v['paterno'] + " " + v['materno'] + " " + v['nombres'] +'" href="#" title="Carga académica" onclick="fn_carga_mat_estudiante($(this));return false;"><i class="fas fa-book"></i> Carga</a>'+

                              '<a href="#" data-cm=' + vcm + ' data-carne=' + v['carne'] + ' data-accion="EDITAR" class="dropdown-item text-success" data-toggle="modal" data-target="#modupmat"><i class="fas fa-edit mr-2"></i>Edita matricula</a>' +
                              '<a href="'+base_url+'academico/matricula/record-academico/excel/'+v['carne']+'" target="_blank" class="dropdown-item"><i class="fas fa-graduation-cap mr-2"></i>Récord académico</a>' +
                              '<a href="'+base_url+'academico/matricula/record-academico/pdf/'+v['carne']+'" target="_blank" class="dropdown-item text-info"><i class="fas fa-graduation-cap mr-2"></i>Récord académico (pdf)</a>' +
                              btnactcondi +
                              '<a href="#" onclick="fn_historial_vw_deudas($(this));return false;" class="dropdown-item text-success" data-programa="'+ v['carrera'] +'" data-periodo="' + v['periodo'] + '" data-ciclo="' + v['ciclo'] + '" data-turno="' + v['codturno'] + '" data-seccion="' + v['codseccion'] + '" data-plan="' + v['plan'] + '"><i class="fas fa-money-bill-alt mr-2"></i>Deudas</a>' +
                            '</div>' +
                          '</div>' ;
                        /*dropdown='<div class="btn-group">' + 
                                   '<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-cog"></i> </button>' + 
                                   '<div class="dropdown-menu">' +
                                     '<a onclick="vw_abrir_modal($(this))" class="dropdown-item" data-tabula="evaluaciones" href="#">Evaluaciones</a>' + 
                                   '</div>' +
                                 '</div>';*/

                        var fila = tbmatriculados.row.add([index + 1, v['sede_abrevia'], v['carne'], estudiante, fecharegistro, vcuota, v['plan'], grupo, dropdown_estado, dropdown_imprimir, boleta + dropdown_opciones]).node();
                        $(fila).attr('data-codmatricula64', v['codmatricula64']);
                        $(fila).attr('data-estudiante', nomestudiante);
                        $(fila).attr('data-carnet', v['carne']);

                        //$(fila).attr('data-carnet', v['carne']);

                        $(fila).attr('data-coperiodo', v['codperiodo']);
                        $(fila).attr('data-cocarrera', v['codcarrera']);
                        $(fila).attr('data-cociclo', v['codciclo']);
                        $(fila).attr('data-cturno', v['codturno']);
                        $(fila).attr('data-cseccion', v['codseccion']);
                        $(fila).attr('data-cperiodo', v['periodo']);
                        $(fila).attr('data-ccarrera', v['carrera']);
                        $(fila).attr('data-cciclo', v['ciclo']);
                        // $(fila).attr('data-cturno', v['turno']);
                        // $(fila).attr('data-cseccion', v['seccion']);
                        $(fila).addClass('cfila_mt');
                    });

                    tbmatriculados.draw();
                    $('#divcard-matricular #divoverlay').remove();

                    $('.view_user_reg').popover({
                      trigger: 'hover',
                      html: true
                    })

                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divcard-matricular #divoverlay').remove();
                //$('#divError').show();
                //$('#msgError').html(msgf);
            }
        });
    } else {
        $("#vw_mt_divmensaje").show();
        $("#vw_mt_spanmensaje").html("Se requiere como mínimo 3 parámetros de búsqueda");
    }

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
                        title: 'Matrícula DUPLICADA',
                        text: e.msg,
                        backdrop: false,
                    })
                } else {
                    Swal.fire({
                        type: 'error',
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
                    title: 'Felcicitaciones, matrícula registrada',
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
                $("#fud-cbperiodo").html($("#fm-cbperiodo option:selected").text());
                $("#fud-cbperiodo").data($("#fm-cbperiodo").val());
                mostrarCursos("divcard_data_carga", "", e.vdata);
                var url = base_url + "academico/matricula/imprimir/" + base64url_encode(e.newcod);
                $("#divcard_data_carga").append(
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
                title: 'Error, matrícula NO registrada',
                text: msgf,
                backdrop: false,
            })
        }
    });
    return false;
});

function comprobarcurso() {
    $("#divcard_data_carga .cfila").each(function(index) {
        var cc = $(this).data('cc');
        var cs = $(this).data('ccs');
        //alert(cc + cs);
        $("#divcard_data_cursos_disponibles .cfila").each(function(index2) {
            var ccd = $(this).data('cc');
            var csd = $(this).data('ccs');
            if ((cc == ccd) && (cs == csd)) {
                $(this).remove();
            }
        });
    });
}

function ordenarnro(div) {
    var nro = 0;
    $("#" + div + " .tdnro").each(function(index) {
        nro = nro + 1;
        $(this).html(nro);
    });
}

function mostrarCursos(div, vcm, vdata, agregar = 'no') {
    var vplan = "00";
    var nro = 0;
    $("#" + div).html("");
    $.each(vdata, function(index, v) {
        nro++;
        var mcidcarga = base64url_encode(v['idcarga']);
        jsbtnagregar = "";
        jsbtnretirar = "";
        if (vpermiso173 == "SI") {
          if (agregar == 'si') {
              var codcurso = base64url_encode(v['codcurso']);
              jsbtnagregar = '<button data-ccurso="' + codcurso + '" data-cc="' + mcidcarga + '"  data-cd="' + v['subseccion'] + '" data-cm="' + vcm + '" title="Enrolar" class="btn px-1 py-0 btn-enrolar btn-sm btn-primary"><i class="fas fa-book-medical"></i></button>';
          }
          
          if (agregar == 'no') {
              var midmiembro = base64url_encode(v['idmiembro']);
              jsbtnretirar = '<button   data-im="' + midmiembro + '"  title="Eliminar" class="btn px-1 py-0 btn-desenrolar btn-sm btn-danger"><i class="fas fa-minus-square"></i></button>';
          }
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
        '<div class="cfila row ' + rowcolor + ' " data-cc="' + mcidcarga + '" data-ccs="' + v['subseccion'] + '">' +
          '<div class="col-4 col-md-4">' +
            '<div class="row">' +
              '<div class="tdnro col-3 col-md-1 td">' + nro + '</div>' +
              '<div class="col-9 col-md-11 td">(' + v['idcarga'] + 'G' + v['subseccion'] + ') ' + v['curso'] + '</div>' +
            '</div>' +
          '</div>' +
          '<div class="col-6 col-md-2">' +
            '<div class="row">' +
              '<div class="td col-6 col-md-6 text-center ">' + v['sede_abrevia'] +'</div>' +
              '<div class="td col-6 col-md-6 text-center ">' + v['sigla'] + ' ' + v['ciclo'] + ' - ' + v['codturno'] +' - ' + v['codseccion'] + v['subseccion'] + '</div>' +
            '</div>' +
          '</div>' +
          '<div class="col-6 col-md-2">' +
            '<div class="row">' +
              '<div class="td col-2 col-md-4 text-center ">' + '1' + '</div>' +
              '<div class="td col-2 col-md-4 text-center ">' + (parseInt(v['hts']) + parseInt(v['hps'])) + '</div>' +
              '<div class="td col-2 col-md-4 text-center ">' + (parseInt(v['ct']) + parseInt(v['cp'])) + '</div>' +
            '</div>' +
          '</div>' +
          '<div class="col-8 col-md-3 td">' + v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + '</div>' +
          '<div class="col-4 col-md-1">' + 
            '<div class="row">' + 
              '<div class="td col-2 col-md-12 text-center">' + 
                jsbtnagregar + jsbtnretirar + 
              '</div>' + 
            '</div>' + 
          '</div>' +
        '</div>');
    });
    //******************************************
    if (agregar == 'si') {
        $(".btn-enrolar").on("click", function() {
            $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var codc = $(this).data('cc');
            var codm = $(this).data('cm');
            var codd = $(this).data('cd');
            var codcarne = $("#divcarne").find('H3').html();
            var codcurso = $(this).data('ccurso');
            var btnenr = $(this);
            var idm = "0";
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
                        btnenr.parents(".cfila").appendTo('#divcard_data_carga');
                        $(".cfilaprint").appendTo('#divcard_data_carga');
                        ordenarnro("divcard_data_carga");
                        ordenarnro("divcard_data_cursos_disponibles");
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
    } else {
        $(".btn-desenrolar").on("click", function() {
            $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var alumno = $("#divmiembro").html();
            var btndes = $(this);
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
                    var codc = $(this).data('im');
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
                                ordenarnro("divcard_data_carga");
                                $('#divcard-matricular #divoverlay').remove();
                                Swal.fire({
                                    type: 'success',
                                    title: 'Éxito,  realizado',
                                    text: e.msg,
                                    backdrop: false,
                                })
                            } else {
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
                } else {
                    $('#divcard-matricular #divoverlay').remove();
                }
            });
            //***************************************
        });
    }
}

$("#frmfiltro-unidades").submit(function(event) {
    $("#btn-vercurricula").show();
    $('#divcard_data_cursos_disponibles').html("");
    $('#divmodcarga').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
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
    var vcm = $("#vwtxtcodmatcrg").val();
    $.ajax({
        url: base_url + 'cargasubseccion/fn_filtrar',
        type: 'post',
        dataType: 'json',
        data: fdata,
        success: function(e) {
            $('#divmodcarga #divoverlay').remove();
            mostrarCursos('divcard_data_cursos_disponibles', vcm, e.vdata, 'si');
            comprobarcurso();
            ordenarnro('divcard_data_cursos_disponibles');
            //.html(e.vdata);
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            Toast.fire({
                type: 'warning',
                title: 'Aviso: ' + msgf
            })
            $('#divcard_data_cursos_disponibles').html("");
            $('#divmodcarga #divoverlay').remove();
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

$('#modmatriculacurso').on('show.bs.modal', function(e) {
    var rel = $(e.relatedTarget);
    var codigo = rel.data('cm');
    var programa = rel.data('prog');
    var periodo = rel.data('periodo');
    var ciclo = rel.data('ciclo');
    var turno = rel.data('turno');
    var seccion = rel.data('seccion');
    $('#fmt-cbncodmatricula').val(codigo);
    $('#vw_dp_em_btnimp_boleta').attr('href', base_url + "academico/matricula/independiente/boleta/imprimir/" + codigo);
    $('#fmt-cbncarrera').val(programa);
    $('#fmt-cbnperiodo').val(periodo);
    $('#fmt-cbnciclo').val(ciclo);
    $('#fmt-cbnturno').val(turno);
    $('#fmt-cbnseccion').val(seccion);
    $('#fmt-cbncarrera').change();
    get_matriculas_cursos(codigo);
    get_unidades('fmt-cbnciclo', 'fmt-cbnplan');
});

$('#modmatriculacurso').on('hidden.bs.modal', function(e) {
    $('#divcard_datamat').removeClass('d-none');
    $('#divcard_form_new').addClass('d-none');
    $('#btn_agregarnew').removeClass('d-none');
    $('#btncancelar').addClass('d-none');
    $('#fmt-cbncodmatcurso').val('0');
    $('#form_addmatricula')[0].reset();
    get_unidades('fmt-cbnciclo', 'fmt-cbnplan');
    //$('#vw_dp_em_btnguardar').show();
    $('#vw_dp_mdcarga_footer_boleta').show();
    $('#divcontent_convalida').addClass('d-none');
})

function get_matriculas_cursos(matricula) {
    $('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

    $('#divcard_data_matricula_curso').html("");
    $("#divbnperiodo").html("dd");
    $("#divbncarrera").html("");
    $("#divbnplan").html("");
    $("#divbnciclo").html("");
    $("#divbnturno").html("");
    $("#divbnseccion").html("");
    $("#divmodalnewmatricula #divcard_title").html("");
    $("#divbncorreo").html("");
    
    $.ajax({
        url: base_url + "matricula_independiente/fn_filtrar_matricula",
        type: 'post',
        dataType: 'json',
        data: {
            txtmatricula: matricula
        },
        success: function(e) {
            
            if (e.status == true) {

                $("#divbnperiodo").html(e.vmatricula['periodo']);
                $("#divbncarrera").html(e.vmatricula['carrera']);
                $("#divbnplan").html(e.vmatricula['plan']);
                $("#divbnciclo").html(e.vmatricula['ciclo']);
                $("#divbnturno").html(e.vmatricula['turno']);
                $("#divbnseccion").html(e.vmatricula['codseccion']);
                var estudianten = e.vmatricula['paterno'] + " " + e.vmatricula['materno'] + " " + e.vmatricula['nombres'];
                $("#divmodalnewmatricula #divcard_title").html(estudianten + " / " + e.vmatricula['carne'] );
                $("#divbncorreo").html(e.vmatricula['ecorporativo']);

                // DROPDOWN ESTADOS
                var btnstcolor = "";
                switch (e.vmatricula['estado']) {
                    case "ACTIVO":
                        btnstcolor = "btn-success";
                        break;
                    case "CULMINADO":
                        btnstcolor = "btn-secondary";
                        break;
                    case "DESAPROBADO":
                        btnstcolor = "btn-danger";
                        break;
                    case "RETIRADO":
                        btnstcolor = "btn-danger";
                        break;
                    default:
                        btnstcolor = "btn-warning";
                }
                dropdown_estado = '<div class="btn-group">' +
                    '<button class="btn ' + btnstcolor + ' text-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                    e.vmatricula['estado'] +
                    '</button>' +
                    '<div class="dropdown-menu">' +
                    '<a href="#" onclick="fn_cambiarestado($(this))" class="dropdown-item" data-campo="modal" data-ie="' + cd1 + '">Activo</a>' +
                    '<a href="#" onclick="fn_cambiarestado($(this))" data-pagante="'+e.vmatricula['carne']+'" data-pagantenb="'+estudianten+'" data-programa="'+ e.vmatricula['carrera'] +'" data-periodo="' + e.vmatricula['periodo'] + '" data-ciclo="' + e.vmatricula['ciclo'] + '" data-turno="' + e.vmatricula['turno'] + '" data-seccion="' + e.vmatricula['codseccion'] + '" data-plan="' + e.vmatricula['plan'] + '" class="dropdown-item" data-campo="modal" data-ie="' + cd2 + '">Retirado</a>' +
                    '<a href="#" onclick="fn_cambiarestado($(this))" class="dropdown-item" data-campo="modal" data-ie="' + cd7 + '">Desaprobado</a>' +
                    '</div>' +
                    '</div>';
                $('#divcard_drop_estado').html(dropdown_estado);
                
                var nro = 0;
                var tabla = "";
                if (e.vdata.length !== 0) {
                    $('#fmt_conteo_modal').html(e.vdata.length + ' datos encontrados');
                    $.each(e.vdata, function(index, val) {
                        nro++;
                        if (val['tipo'] == "MANUAL") {
                            colortipo = "btn-secondary";
                        } else if (val['tipo'] == "PLATAFORMA") {
                            colortipo = "btn-primary";
                        } else {
                            colortipo = "btn-info";
                        }
                        anota = val['nota'];
                        var jsest = val['estado'];
                        recuperacion = val['recuperacion'];
                        colorbtn = "text-danger";
                        if (anota >= 12.5) colorbtn = "text-primary";
                        colorbtnrc = "text-danger";
                        if (recuperacion >= 12.5) colorbtnrc = "text-primary";
                        colorfinal = "text-danger";
                        if (val['final'] >= 12.5) colorfinal = "text-primary";
                        tabla = tabla +
                            "<div class='row rowcolor cfila' data-idmatnf='" + val['codigo64'] + "' data-metodo='" + val['metodo'] + "' data-codmiembro='" + val['codmiembro64'] + "' data-final='" + anota + "' data-recupera='" + recuperacion + "'>" +
                            "<div class='col-6 col-md-2'>" +
                            "<div class='row'>" +
                            "<div class='col-2 col-md-2 td'>" + nro + "</div>" +
                            "<div class='col-10 col-md-10 td'>" +
                            val['periodo'] + " " + val['sigla'] + " <b>" + val['codturno'] + "</b>  " + val['ciclo'] + "-" + val['codseccion'] + "<br>" + "<small>" + val['codplan'] + " " + val['plan'] + "</small>" + "</div>" +
                            "</div>" +
                            "</div>" +
                            "<div class='col-6 col-md-4 td'>" +
                            "(" + val['idcarga'] + "G" + val['subseccion'] + ")" + val['codcurso'] + " " + val['curso'] + "<br>" +
                            "<small>" + "(" + val['sede_abrevia'] + ")" + val['paterno'] + " " + val['materno'] + " " + val['nombres'] + "</small>" +
                            "</div>" +
                            "<div class='col-6 col-md-1 td text-center'>" +
                            '<div class="btn-group">' +
                            '<button class="btn ' + colortipo + ' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            val['tipo'].substring(0, 2) +
                            '</button>' +
                            '<div class="dropdown-menu">' +
                            '<a href="#" onclick="fn_cambiar_origen($(this));return false;" class="btn-cborigen dropdown-item" data-origen="PLATAFORMA">PLATAFORMA</a>' +
                            '<a href="#" onclick="fn_cambiar_origen($(this));return false;" class="btn-cborigen dropdown-item" data-origen="MANUAL">MANUAL</a>' +
                            '<a href="#" onclick="fn_cambiar_origen($(this));return false;" class="btn-cborigen dropdown-item" data-origen="CONVALIDA">CONVALIDA</a>' +
                            '</div>' +
                            "</div>" +
                            "</div>" +
                            "<div class='col-6 col-md-4'>" +
                            "<div class='row'>" +

                            "<div class='col-6 col-md-3 td text-center'>" +
                            "<input onchange='fn_promediar($(this))' type='number' data-valor='" + anota + "' max='20' min='0' data-edit='0' class='nf_txt_final " + colorbtn + " form-control form-control-sm' value='" + anota + "' data-idmat=" + val['codigo64'] + " data-ntsaved='" + anota + "' data-stnota='NF'>" +
                            "</div>" +
                            "<div class='col-6 col-md-3 td text-center'>" +
                            "<input onchange='fn_promediar($(this))' type='number' data-valor='" + recuperacion + "' max='20' min='0' data-edit='0' class='nt_txt_recupera " + colorbtnrc + " form-control form-control-sm' value='" + recuperacion + "' data-idmat=" + val['codigo64'] + " data-ntsaved='" + recuperacion + "' data-stnota='NR'>" +
                            "</div>" +
                            "<div class='col-6 col-md-3 td text-center'>" +
                            "<span class='form-control form-control-sm nt_txt_pf " + colorfinal + "'>" + val['final'] + "</span>" +
                            "</div>" +
                            "<div class='col-6 col-md-3 td text-center'>" +
                            "<select class='nf_estado form-control form-control-sm'>" +
                            "<option  value='-'> -- </option> " +
                            "<option " + ((jsest == 'NSP') ? "selected" : "") + " value='NSP'>NSP</option> " +
                            "<option " + ((jsest == 'DPI') ? "selected" : "") + " value='DPI'>DPI</option> " +
                            "</select>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "<div class='col-6 col-md-1 text-center'>" +
                            "<div class='row'>" +
                            "<div class='col-12 col-sm-12 col-md-12 td'>" +
                            "<div class='col-12 pt-1 pr-3 text-center'>" +
                            "<div class='btn-group'>" +
                            "<a type='button' class='text-white bg-warning dropdown-toggle px-2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" +
                            "<i class='fas fa-cog'></i>" +
                            "</a>" +
                            "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>" +
                            "<a class='dropdown-item editmatcurso' href='#' title='Editar' data-idmatc='" + val['codigo64'] + "'>" +
                            "<i class='fas fa-edit mr-1'></i> Editar" +
                            "</a>" +
                            "<a class='dropdown-item text-danger delregistro' href='#' title='Eliminar' data-idmatc='" + val['codigo64'] + "'>" +
                            "<i class='fas fa-trash mr-1'></i> Eliminar" +
                            "</a>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>";
                    })
                } else {
                    $('#fmt_conteo_modal').html('No se encontraron resultados');
                }
                $('#divcard_data_matricula_curso').html(tabla);
                $('#divmodalnewmatricula #divoverlay').remove();
            } else {
                $('#divmodalnewmatricula #divoverlay').remove();
                var msgf = '<span class="text-danger">' + e.msg + '</span>';
                $('#divcard_data_matricula_curso').html(msgf);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodalnewmatricula #divoverlay').remove();
            //$('#divError').show();
            //$('#msgError').html(msgf);
        }
    });
}

function get_unidades(ciclo, plan) {
    if ($('#' + ciclo).val() != "0" && $('#' + plan).val() != "0") {
        $('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#fmt-cbnunididact').html("<option value='0'>Sin opciones</option>");
        var ciclo = $('#' + ciclo).val();
        var plan = $('#' + plan).val();
        if (ciclo == '0' && plan == '0') return;
        $.ajax({
            url: base_url + 'unidaddidactica/fn_get_unidades_combo',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodciclo: ciclo,
                txtcodplan: plan,
            },
            success: function(e) {
                $('#divmodalnewmatricula #divoverlay').remove();
                $('#fmt-cbnunididact').html(e.vdata);
                $("#fmt-cbnunididact").val(getUrlParameter("cpl", 0));
            },
            error: function(jqXHR, exception) {
                $('#divmodalnewmatricula #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#fmt-cbnunididact').html("<option value='0'>" + msgf + "</option>");
            }
        });
    } else {
        $('#fmt-cbnunididact').html("<option value='0'>Selecciona un plan curricular y ciclo<option>");
    }
}

$('#form_addmatricula').submit(function() {
    $('#form_addmatricula input,select').removeClass('is-invalid');
    $('#form_addmatricula .invalid-feedback').remove();
    $('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    // $("#div-filtro").html("");
    $.ajax({
        url: base_url + 'matricula_independiente/fn_insert_update',
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divmodalnewmatricula #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: 'Error!',
                    text: 'Existen errores en los campos',
                    backdrop: false,
                })
            } else {
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: 'Éxito!',
                    text: e.msg,
                    backdrop: false,
                }).then((result) => {
                    if (result.value) {
                        // $('#modmatriculacurso').modal('hide');
                        get_matriculas_cursos(e.idmatricula);
                        get_unidades('fmt-cbnciclo', 'fmt-cbnplan');
                        $('#divcard_datamat').removeClass('d-none');
                        $('#divcard_form_new').addClass('d-none');
                        $('#btn_agregarnew').removeClass('d-none');
                        $('#btncancelar').addClass('d-none');
                        //$('#vw_dp_em_btnguardar').show();
                        $('#vw_dp_mdcarga_footer_boleta').show();
                        $('#divcontent_convalida').addClass('d-none');
                    }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodalnewmatricula #divoverlay').remove();
            Swal.fire({
                type: 'error',
                icon: 'error',
                title: 'Error!',
                text: msgf,
                backdrop: false,
            })
        }
    });
    return false;
});

$(document).on("click", ".editmatcurso", function() {
    var codigo = $(this).data('idmatc');
    //$('#vw_dp_em_btnguardar').hide();
    $('#vw_dp_mdcarga_footer_boleta').hide();
    $('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'matricula_independiente/fn_get_matriculacurso_codigo',
        type: 'post',
        dataType: 'json',
        data: {
            txtcodigo: codigo,
        },
        success: function(e) {
            if (e.status == true) {
                $('#divcard_datamat').addClass('d-none');
                $('#divcard_form_new').removeClass('d-none');
                $('#btn_agregarnew').addClass('d-none');
                $('#btncancelar').removeClass('d-none');
                $('#fmt-cbncodmatricula').val(e.vdata['codmatric64']);
                $('#fmt-cbncargaacadem').val(e.vdata['idcarga']);
                $('#fmt-cbncargaacadsubsec').val(e.vdata['codsubsec']);
                $('#fmt-cbtipo').val(e.vdata['tipo']);
                $('#fmt-cbnperiodo').val(e.vdata['idperiodo']);
                $('#fmt-cbncarrera').val(e.vdata['idcarrera']);
                $('#fmt-cbnplan').val(e.vdata['codplan']);
                $('#fmt-cbnciclo').val(e.vdata['idciclo']);
                $('#fmt-cbnturno').val(e.vdata['idturno']);
                $('#fmt-cbnseccion').val(e.vdata['idseccion']);
                $('#fmt-cbnfecha').val(e.vdata['fechaf']);
                $('#fmt-cbndocente').val(e.vdata['codocente']);
                $('#fmt-cbnresolucion').val(e.vdata['valida']);
                $('#fmt-cbnobservacion').val(e.vdata['observacion']);
                $('#fmt-cbnnotafinal').val(e.vdata['notaf']);
                $('#fmt-cbncodmatcurso').val(e.vdata['codigo64']);
                if (e.vdata['vfecha'] !== null) {
                    $('#fmt-cbnfechaconv').val(e.vdata['vfecha']);
                }
                if (e.vdata['notar'] !== null) {
                    $('#fmt-cbnnotarecup').val(e.vdata['notar']);
                }
                setTimeout(function() {
                    get_unidades('fmt-cbnciclo', 'fmt-cbnplan');
                }, 500);
                setTimeout(function() {
                    $('#fmt-cbnunididact').val(e.vdata['idunidad']);
                    $('#divmodalnewmatricula #divoverlay').remove();
                }, 1000);
                $('#fmt-cbtipo').change();
            }
        },
        error: function(jqXHR, exception) {
            $('#divmodalnewmatricula #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
})

$(document).on('click', '.delregistro', function() {
    var codigo = $(this).data('idmatc');
    Swal.fire({
        title: '¿Está seguro de eliminar este registro?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        allowOutsideClick: false,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, eliminar!'
    }).then(function(result) {
        if (result.value) {
            $('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + 'matricula_independiente/fn_delete_matricula_curso',
                type: 'post',
                dataType: 'json',
                data: {
                    txtcodigo: codigo,
                },
                success: function(e) {
                    $('#divmodalnewmatricula #divoverlay').remove();
                    if (e.status == true) {
                        Swal.fire({
                            title: 'Éxito!',
                            text: e.msg,
                            type: 'success',
                            icon: 'success',
                            allowOutsideClick: false,
                        })
                        get_matriculas_cursos(codigo);
                        get_unidades('fmt-cbnciclo', 'fmt-cbnplan');
                    }
                },
                error: function(jqXHR, exception) {
                    $('#divmodalnewmatricula #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        title: msgf,
                        // text: "",
                        type: 'error',
                        icon: 'error',
                    })
                }
            });
        }
    })
    return false;
});

$(document).on("blur", ".cfila div input", function(event) {
    if ($(this).data('ntsaved') != $(this).val()) {
        $(this).data('edit', '1');
        if (($(this).val() < 0)||($(this).val() > 20)) {
            $(this).parent().addClass('cellerror');
        } else {
                
            $(this).parent().removeClass('cellerror');
            $(this).parent().addClass('celleditada');
        }

    } else {
        $(this).data('edit', '0');
        $(this).parent().removeClass('celleditada');
    }
    if ($(this).val() > 12) {
        $(this).removeClass('text-danger');
        $(this).addClass('text-primary');
    } else {
        $(this).removeClass('text-primary');
        $(this).addClass('text-danger');
    }
})

$('#vw_dp_em_btnguardar').click(function() {
    arrdata = [];
    var nerror = 0;
    var edits = 0;
    $('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('#divcard_data_matricula_curso .cfila').each(function() {
        var codmat = $(this).data("idmatnf");
        var codmiembro = $(this).data("codmiembro");
        var notfin = ($(this).data('final') == null) ? "" : $(this).data('final');
        var notrec = ($(this).data('recupera') == null) ? "" : $(this).data('recupera');
        var notfin_txt = $(this).find(".nf_txt_final").val();
        var notrec_txt = $(this).find(".nt_txt_recupera").val();
        var estado = $(this).find(".nf_estado").val();
        var metodo = $(this).data("metodo");

        var isedit = '0';

        if ((notfin != notfin_txt) || (notrec != notrec_txt)) {
            notfin = notfin_txt;
            notrec = notrec_txt;
            isedit = "1";

            //arrdata.push(myvals);
        }





        //if (isedit == "1") {
            if ((notfin_txt < 0) || (notfin_txt > 20)) {
                nerror++
            } else if ((notrec_txt < 0) || (notrec_txt > 20)) {
                nerror++
            } else {
                var myvals = [codmat, estado, notfin, notrec, codmiembro,metodo];
                arrdata.push(myvals);
            }
            edits++;
        //}
    });

    if (nerror == 0) {
        if (edits > 0) {
            $.ajax({
                url: base_url + 'matricula_independiente/fn_update_notas_final_recuperacion',
                type: 'post',
                dataType: 'json',
                data: {
                    filas: JSON.stringify(arrdata),
                },
                success: function(e) {
                    $('#divmodalnewmatricula #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            type: 'error',
                            icon: 'error',
                            title: 'ERROR, NO se guardó cambios',
                            text: e.msg,
                            backdrop: false,
                        });
                    } else {
                        /*$('.txtnota').each(function() {
                        if ($(this).data('edit')=='1'){
                        $(this).data('edit',  '0');
                        }

                        });*/

                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: 'ÉXITO, Se guardó cambios',
                            text: "Lo cambios fueron guardados correctamente",
                            backdrop: false,
                        });
                        var idmatricula = $('#fmt-cbncodmatricula').val();
                        get_matriculas_cursos(idmatricula);
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'ERROR, NO se guardó cambios',
                        text: msgf,
                        backdrop: false,
                    });
                },
            })
        } else {
            Swal.fire({
                type: 'success',
                icon: 'success',
                title: 'ÉXITO, Se guardó cambios (M)',
                text: "Lo cambios fueron guardados correctamente",
                backdrop: false,
            });
            $('#divmodalnewmatricula #divoverlay').remove();
        }
    } else {
        Swal.fire({
            type: 'error',
            icon: 'error',
            title: 'ERROR, Notas Invalidas',
            text: "Existen " + nerror + " error(es): NOTA NO VÁLIDA (Rojo)",
            backdrop: false,
        });
        $('#divmodalnewmatricula #divoverlay').remove();
    }
});

$('#fmt-cbtipo').change(function(event) {
    var item = $(this);
    var tipo = item.find(':selected').data('tipo');
    if (tipo === "CONVALIDA") {
        $('#divcontent_convalida').removeClass('d-none');
    } else {
        $('#divcontent_convalida').addClass('d-none');
    }
});




$('#btn_agregarnew').click(function() {
    $('#divcard_datamat').addClass('d-none');
    $('#divcard_form_new').removeClass('d-none');
    $('#btn_agregarnew').addClass('d-none');
    $('#btncancelar').removeClass('d-none');
    $('#vw_dp_mdcarga_footer_boleta').hide();
});

$('#btncancelar').click(function() {
    $('#divcard_datamat').removeClass('d-none');
    $('#divcard_form_new').addClass('d-none');
    $('#btn_agregarnew').removeClass('d-none');
    $('#btncancelar').addClass('d-none');
    $('#fmt-cbncodmatcurso').val('0');
    $('#vw_dp_mdcarga_footer_boleta').show();
    $('#divcontent_convalida').addClass('d-none');
    $('#form_addmatricula')[0].reset();
});

$('.btn_campos').click(function(e) {
    e.preventDefault();
    $('#modexport').modal('show');
});

$('#fmt-cbncarrera').change(function(event) {
    if ($(this).val() != "0") {
        $('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#fmt-cbnplan').html("<option value='0'>Sin opciones</option>");
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
                $('#divmodalnewmatricula #divoverlay').remove();
                $('#fmt-cbnplan').html(e.vdata);
                $("#fmt-cbnplan").val(getUrlParameter("cpl", 0));
            },
            error: function(jqXHR, exception) {
                $('#divmodalnewmatricula #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#fmt-cbnplan').html("<option value='0'>" + msgf + "</option>");
            }
        });
    } else {
        $('#fmt-cbnplan').html("<option value='0'>Selecciona un programa<option>");
    }
});

$('#lbtn_exportar').click(function(e) {
    var urlExcel = base_url + 'academico/matriculas/campos/excel?cp=' + $("#fmt-cbperiodo").val() + '&cc=' + $("#fmt-cbcarrera").val() + '&ccc=' + $("#fmt-cbciclo").val() + '&ct=' + $("#fmt-cbturno").val() + '&cs=' + $("#fmt-cbseccion").val() + '&cpl=' + $("#fmt-cbplan").val() + '&ap=' + $("#fmt-alumno").val() + '&es=' + $("#fmt-cbestado").val() + '&sed=' + $("#fmt-cbsede").val() + '&benf=' + $("#fmt-cbbeneficio").val();
    checkcarne = ($("#checkcarnet").prop('checked') == true ? "&checkcarnet=SI" : "&checkcarnet=NO");
    checkapellidos = ($("#checkape").prop('checked') == true ? "&checkape=SI" : "&checkape=NO");
    checknombres = ($("#checknombres").prop('checked') == true ? "&checknombres=SI" : "&checknombres=NO");
    checkcorpo = ($("#checkcorpo").prop('checked') == true ? "&checkcorpo=SI" : "&checkcorpo=NO");
    checkacelulares = ($("#checkcelul").prop('checked') == true ? "&checkcelul=SI" : "&checkcelul=NO");
    checkcarrera = ($("#checkcarr").prop('checked') == true ? "&checkcarr=SI" : "&checkcarr=NO");
    checkciclo = ($("#checkcic").prop('checked') == true ? "&checkcic=SI" : "&checkcic=NO");
    checkturno = ($("#checkturn").prop('checked') == true ? "&checkturn=SI" : "&checkturn=NO");
    checkseccion = ($("#checksecc").prop('checked') == true ? "&checksecc=SI" : "&checksecc=NO");
    checkperiodo = ($("#checkper").prop('checked') == true ? "&checkper=SI" : "&checkper=NO");
    checkestado = ($("#checkest").prop('checked') == true ? "&checkest=SI" : "&checkest=NO");
    checkfecmat = ($("#checkfecmat").prop('checked') == true ? "&checkfecmat=SI" : "&checkfecmat=NO");
    checksexo = ($("#checksex").prop('checked') == true ? "&checksex=SI" : "&checksex=NO");
    checkfecnac = ($("#checkfecnac").prop('checked') == true ? "&checkfecnac=SI" : "&checkfecnac=NO");
    checkcorreo = ($("#checkcorper").prop('checked') == true ? "&checkcorper=SI" : "&checkcorper=NO");
    checkdomicilio = ($("#checkdomic").prop('checked') == true ? "&checkdomic=SI" : "&checkdomic=NO");
    checklengua = ($("#checkleng").prop('checked') == true ? "&checkleng=SI" : "&checkleng=NO");
    checkdepart = ($("#checkdepart").prop('checked') == true ? "&checkdepart=SI" : "&checkdepart=NO");
    checkprovin = ($("#checkprovin").prop('checked') == true ? "&checkprovin=SI" : "&checkprovin=NO");
    checkdistrito = ($("#checkdistri").prop('checked') == true ? "&checkdistri=SI" : "&checkdistri=NO");
    checkdiscap = ($("#checkdiscap").prop('checked') == true ? "&checkdiscap=SI" : "&checkdiscap=NO");
    checkplan = ($("#checkplan").prop('checked') == true ? "&checkplan=SI" : "&checkplan=NO");
    checkbeneficio = ($("#checkbeneficio").prop('checked') == true ? "&checkbeneficio=SI" : "&checkbeneficio=NO");
    checkdni = ($("#checkdni").prop('checked') == true ? "&checkdni=SI" : "&checkdni=NO");
    checkidinscripcion = ($("#checkidinscripcion").prop('checked') == true ? "&checkidinscripcion=SI" : "&checkidinscripcion=NO");
    checkedad = ($("#checkedad").prop('checked') == true ? "&checkedad=SI" : "&checkedad=NO");

    var url = urlExcel + checkcarne + checkapellidos + checknombres + checkcorpo + checkacelulares + checkcarrera + checkciclo + checkturno + checkseccion + checkperiodo + checkestado + checkfecmat + checksexo + checkfecnac + checkcorreo + checkdomicilio + checklengua + checkdepart + checkprovin + checkdistrito + checkdiscap + checkplan + checkbeneficio + checkdni + checkidinscripcion + checkedad;
    var ejecuta = true;

    if (ejecuta == true) window.open(url, '_blank');
});

$(document).ready(function() {
    $("#vw_mt_divmensaje").hide();
    var table = $('#tbmt_dtMatriculados').DataTable({
        "autoWidth": false,
        "pageLength": 50,
        "lengthChange": false,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
        },
        'columnDefs': [{
            "targets": 0, // your case first column
            "className": "text-right rowhead",
            "width": "8px"
        }],
        dom: "<'row'<'col-sm-8'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: {
            buttons: [{
                    text: '<i class="fas fa-user-plus mr-1"></i> Matricular',
                    className: 'btn-sm btn-success',
                    attr: {
                        'title': 'Matricular',
                        'data-accion': 'INSERTAR',
                        'data-toggle': 'modal',
                        'data-target': '#modupmat'
                    },
                    action: function(e, dt, node, config) {

                    }
                },
                /*{
                    text: '<i class="fas fa-trash-alt"></i>',
                    className: 'btn-sm btn-danger',
                    action: function ( e, dt, node, config ) {
                        fn_eliminar_matricula();
                    },
                    enabled: false
                }*/
            ],
            dom: {
                button: {
                    className: 'btn'
                },
                buttonLiner: {
                    tag: null
                }
            }
        }

    });
    $("#fmt-cbperiodo").val(getUrlParameter("cp", '%'));
    $("#fmt-cbcarrera").val(getUrlParameter("cc", '%'));
    $("#fmt-cbciclo").val(getUrlParameter("ccc", '%'));
    $("#fmt-cbturno").val(getUrlParameter("ct", '%'));
    $("#fmt-cbseccion").val(getUrlParameter("cs", '%'));
    $("#fmt-cbplan").val(getUrlParameter("cpl", '%'));
    if (getUrlParameter("at", 0) == 1) $("#frmfiltro-matriculas").submit();

    var carne = getUrlParameter("fcarnet","");
    // var alumno = getUrlParameter("festudent","");
    // if (carne !=="" && alumno!== "") {}
    if (carne !=="") {
      $("#modupmat").modal();
      $('#modfiltroins').modal('hide');
      fn_select_inscrito(null,"inscrito");
    }

    $('#divcard_deudas_historial').hide();

    $('#lbtn_reportedeudas').hide();
    $('#lbtn_reportepagos').hide();

});
//$("#fmt-conteo").html(nro + ' matriculas encontradas');
//$('#divcard-matricular #divoverlay').remove();
//********************************************/
/*$(".btncall-carga").on("click", function() {
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('.nav-pills a[href="#fichacarga"]').tab('show');
    vcm = $(this).data('cm');
    $("#vwtxtcodmat").val(vcm);
    fila=$(this).parents(".cfila_mt");

    alert("aaa");
    $("#divcarne").html("<h3>" + fila.data('.carnet') + "</h3>");
    $("#divmiembro").html(fila.data('.estudiante'));
    $("#divperiodo").html(fila.data('.cperiodo'));
    $("#divcarrera").html(fila.data('.ccarrera'));
    $("#divciclo").html("Ciclo: " + fila.data('.cciclo'));
    $("#divturno").html("Turno: " + fila.data('.cturno'));
    $("#divseccion").html("Sección: " + fila.data('.cseccion'));
    $("#fud-cbperiodo").html(fila.data('.cperiodo'));
    $("#fud-cbperiodo").data('cp', fila.data('.cperiodo'));
    //$("#fud-cbcarrera").text();
    //alert(fila.find('.ccarrera').data('cod'));
    $("#fud-cbcarrera").val(fila.data('.ccarrera'));
    $("#fud-cbcarrera").change();
    $("#fud-cbciclo").val(fila.data('.cciclo'));
    //$("#fud-cbciclo").val(getUrlParameter("ccc",0));
    ;
    $("#fud-cbturno").val(fila.data('.cturno'));
    $("#fud-cbseccion").val(fila.data('.cseccion'));
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
                mostrarCursos("divcard_data_carga", vcm, e.vdata);
                $("#divcard_data_carga").append(
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
});*/

function fn_carga_mat_estudiante(btn){
  $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    fila=btn.closest(".cfila_mt");
    var codigo = btn.data('cm');
    var plan = btn.data('plan');
    var est = btn.data('stdnt');
    $('#vwtxtcodmatcrg').val(codigo);

    // alert(fila.data('cperiodo'));
    $('#divcargaperiodo').html(fila.data('cperiodo'));
    $('#divcargacarrera').html(fila.data('ccarrera'));
    $('#divcargaciclo').html(fila.data('cciclo'));
    $('#divcargaturno').html(fila.data('cturno'));
    $('#divcargaseccion').html(fila.data('cseccion'));

    $('#fud-cbperiodo').html(fila.data('cperiodo'));
    $("#fud-cbperiodo").data('cp',fila.data('coperiodo'));
    $('#fud-cbcarrera').val(fila.data('cocarrera'));
    $('#fud-cbcarrera').change();
    $('#fud-cbciclo').val(fila.data('cociclo'));
    $('#fud-cbturno').val(fila.data('cturno'));
    $('#fud-cbseccion').val(fila.data('cseccion'));
    $('#divcargaplan').html(plan);
    $('#divcard_title_carga').html(est);
    // alert("jajaaj");

    $.ajax({
        url: base_url + "matricula/fn_cursos_x_matricula",
        type: 'post',
        dataType: 'json',
        data: {
            codmatricula: codigo
        },
        success: function(e) {
            $('#divcard-matricular #divoverlay').remove();
            $('#modview_carga').modal('show');
            if (e.status == true) {
                grupocrg = "";
                 


                $.each(e.vdata, function(index, v) {
                  grupoint = v['codciclo']+v['codseccion']+v['codturno']+v['codperiodo']+v['codcarrera']+v['codplan'];
                  if (grupocrg != grupoint) {
                      grupocrg = grupoint;
                     

                      $('#divcard_data_academico').show();
                  }
                })
                

                var url = base_url + "academico/matricula/imprimir/" + codigo;
                mostrarCursos("divcard_data_carga", codigo, e.vdata);
                $("#divcard_data_carga").append(
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
}

$('#modview_carga').on('hidden.bs.modal', function(e){
  $('#divcard_data_academico').hide();
  $('#divcard_data_cursos_disponibles').html("");
})

function fn_cambiarestado(btn) {
  tbmatriculados = $('#tbmt_dtMatriculados').DataTable();
  fila = tbmatriculados.$('tr.selected');
  im = fila.data('codmatricula64');
  var ie = btn.data('ie');
  var btdt = btn.parents(".btn-group").find('.dropdown-toggle');
  var texto = btn.html();
  var contenedor = btn.data('campo');
  var div = "";
  if (contenedor == "tabla") {
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    div = "divcard-matricular";
  } else {
    $('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    div = "divmodalnewmatricula";
  }
  
  $.ajax({
      url: base_url + 'matricula/fn_cambiarestado',
      type: 'post',
      dataType: 'json',
      data: {
          'ce-idmat': im,
          'ce-nestado': ie
      },
      success: function(e) {
          $('#'+div+' #divoverlay').remove();
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
              
              btdt.removeClass('btn-danger');
              btdt.removeClass('btn-success');
              btdt.removeClass('btn-warning');
              btdt.removeClass('btn-secondary');
              if (contenedor == "tabla") {
                  switch (texto) {
                      case "Activo":
                          btdt.addClass('btn-success');
                          btdt.html("ACT");
                          break;
                      case "Retirado":
                          btdt.addClass('btn-danger');
                          btdt.html("RET");
                          break;
                      case "Desaprobado":
                          btdt.addClass('btn-danger');
                          btdt.html("DES");
                          break;
                      default:
                          btdt.addClass("btn-warning");
                  }
              } else {
                  switch (texto) {
                      case "Activo":
                          btdt.addClass('btn-success');
                          btdt.html("ACTIVO");
                          $('#estado'+im).addClass('btn-success');
                          $('#estado'+im).html("ACT");
                          break;
                      case "Retirado":
                          btdt.addClass('btn-danger');
                          btdt.html("RETIRADO");
                          $('#estado'+im).addClass('btn-danger');
                          $('#estado'+im).html("RET");
                          break;
                      case "Desaprobado":
                          btdt.addClass('btn-danger');
                          btdt.html("DESAPROBADO");
                          $('#estado'+im).addClass('btn-danger');
                          $('#estado'+im).html("DES");
                          break;
                      default:
                          btdt.addClass("btn-warning");
                  }
              }

              if (ie == cd2) {
                fn_view_data_deudas(btn);
              } else {
                Swal.fire({
                  type: 'success',
                  icon: 'success',
                  title: 'Felicitaciones, estado actualizado',
                  text: 'Se ha actualizado el estado',
                  backdrop: false,
                })
              }
              
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#'+div+' #divoverlay').remove();
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
}

$(".btn-cestado").click(function(event) {
    var im = $(this).parents(".cfila").data('idm');
    var ie = $(this).data('ie');
    var btdt = $(this).parents(".btn-group").find('.dropdown-toggle');
    //var btdt=$(this).parents(".dropdown-toggle");
    var texto = $(this).html();
    //alert(btdt.html());
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'matricula/fn_cambiarestado',
        type: 'post',
        dataType: 'json',
        data: {
            'ce-idmat': im,
            'ce-nestado': ie
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
                switch (texto) {
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
                        btnscolor = "btn-warning";
                }
                //btdt.addClass('class_name');
                //mostrarCursos("divcard_data_carga", "", e.vdata);
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

function fn_eliminar_matricula() {
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    tbmatriculados = $('#tbmt_dtMatriculados').DataTable();
    fila = tbmatriculados.$('tr.selected');
    im = fila.data('codmatricula64');

    alumno = fila.data('estudiante');
    // var fila = $(this).parents(".cfila");
    // var im = fila.data('idm');
    // var alumno = fila.find('.calumno').html();
    //************************************
    Swal.fire({
        title: "Precaución",
        text: "Se eliminarán las notas y asistencias del estudiante " + alumno + ", en este curso: ",
        type: 'warning',
        icon: 'warning',
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
                            icon: 'error',
                            title: 'Error!',
                            text: e.msg,
                            backdrop: false,
                        })
                    } else {
                        /*$("#fm-txtidmatricula").html(e.newcod);*/
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
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
                        icon: 'error',
                        title: 'Error',
                        text: msgf,
                        backdrop: false,
                    })
                }
            });
        } else {
            $('#divcard-matricular #divoverlay').remove();
        }
    });
}

function fn_promediar(input){
    var fila=input.closest(".cfila");
    jsmetodo=fila.data('metodo');
    promedio=fila.find('.nf_txt_final').val();
    recupera=fila.find('.nt_txt_recupera').val();
    spanpf=fila.find(".nt_txt_pf");
    
    pi=0;
    if (jsmetodo=="PFGN"){
        pi=promedio;
        rc=recupera;
        if (rc!=""){
            pi=Math.round((Number(pi) + Number(rc) )/2);
        }
    }
    else if (jsmetodo=="PFCP"){
        pi=promedio;
        rc=recupera;
        if (rc!=""){
          if (Number(rc) > Number(pi)) pi=rc;
        }
        
    }
    else if (jsmetodo=="PF22"){
        pi=promedio;
        rc=recupera;
        if (rc!=""){
            pi=Math.round((Number(pi) + Number(rc) )/2);
        }
        
    }
    spanpf.html(pi);
    colorfinal = "text-danger";
    if (pi>= 12.5) colorfinal = "text-primary";
    spanpf.removeClass('text-danger');
    spanpf.removeClass('text-primary');
    spanpf.addClass(colorfinal);
}

$('#modupmat #nav-tab a').on('click', function (e) {
  e.preventDefault()
  item = $(this).attr('id');
  // console.log("item", item);
  if (item == "nav-matricular-tab") {
    $('#lbtn_editamat').show();
  } else {
    $('#lbtn_editamat').hide();
  }
})





function fn_activa_matcondicional(boton) {
  var codigo = boton.data('codigo');
  var estado = boton.data('estado');
  $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
      url: base_url + 'matricula/fn_update_estadocondicional',
      type: 'post',
      dataType: 'json',
      data: {
          'ce-codigo': codigo,
          'ce-estado': estado
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
            
        } 
        else {
          Swal.fire({
              type: 'success',
              icon: 'success',
              title: 'Éxito!',
              text: "Datos actualizados correctamente",
              backdrop: false,
          })
          boton.remove();
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
}

function fn_refresca_condicional(boton) {
  var vcarne = boton.data('carne');
  $('#divmodaddmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
      url: base_url + 'matricula/fn_historial_matricula',
      type: 'post',
      dataType: 'json',
      data: {
          'ce-carne': vcarne
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
          if (e.vestado == "DES" && e.vcondic == "SI") {
            $('#lbtn_editamat').attr('disabled', false);
            boton.hide();

            $("#frm_updmatri #fm-cbcicloup option").each(function(i) {
              if (!$(this).hasClass("ocultar")){
                $(this).data('autorizado', 'SI');
              }
            })

            $("#frm_updmatri #fm-cbcicloup").change();
          } else if (e.vcondic == "SI") {
            $('#lbtn_editamat').attr('disabled', false);
            boton.hide();

            $("#frm_updmatri #fm-cbcicloup option").each(function(i) {
              if (!$(this).hasClass("ocultar")){
                $(this).data('autorizado', 'SI');
              }
            })
          }
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

$("#frm_updmatri #fm-cbcicloup").change(function(e) {
  var item = $(this);
  var autoriza = item.find(':selected').data('autorizado');
  if (autoriza == "SI") {
    $('#lbtn_editamat').attr('disabled', false);
    $('#msgcursos_deudas').html("");
  } else {
    $('#lbtn_editamat').attr('disabled', true);
    $('#msgcursos_deudas').html('<div class="alert alert-danger alert-dismissible">'+
                                          '<i class="icon fas fa-ban mr-1"></i>'+
                                          'El estudiante no puede ser matriculado por presentar unidades didácticas desaprobadas con 6 creditos a más o presentar deudas pendientes, favor de regularizar lo antes mencionado'+
                                        '</div>');
  }
});




function fn_cambiar_origen(btn) {
  var fila = btn.closest('.cfila');
  var codigo = fila.data('idmatnf');

  var origen = btn.data('origen');
  var btdt = btn.parents(".btn-group").find('.dropdown-toggle');
  var texto = btn.html();
  $('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  
  $.ajax({
      url: base_url + 'matricula/fn_cambiar_origen',
      type: 'post',
      dataType: 'json',
      data: {
          'ce-idmat': codigo,
          'ce-norigen': origen
      },
      success: function(e) {
          $('#divmodalnewmatricula #divoverlay').remove();
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
              Swal.fire({
                  type: 'success',
                  icon: 'success',
                  title: 'Felicitaciones, origen actualizado',
                  text: 'Se ha actualizado el origen',
                  backdrop: false,
              })
              btdt.removeClass('btn-primary');
              btdt.removeClass('btn-info');
              btdt.removeClass('btn-secondary');
              switch (texto) {
                  case "PLATAFORMA":
                      btdt.addClass('btn-primary');
                      btdt.html("PL");
                      break;
                  case "MANUAL":
                      btdt.addClass('btn-secondary');
                      btdt.html("MA");
                      break;
                  case "CONVALIDA":
                      btdt.addClass('btn-info');
                      btdt.html("CO");
                      break;
                  default:
                      btdt.addClass("btn-info");
              }
              
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#divmodalnewmatricula #divoverlay').remove();
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
}



function fn_view_data_deudas(btn) {
  $('#modDeudas_view_content').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#div_Deudas_view').html("");
  tbldeudas = "";
  var carnet = btn.data('pagante');
  var estudiante = btn.data('pagantenb');

  var programa = btn.data('programa');
  var periodo = btn.data('periodo');
  var ciclo = btn.data('ciclo');
  var turno = btn.data('turno');
  var seccion = btn.data('seccion');
  var plan = btn.data('plan');

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
              $('#modDeudas_view_content #divoverlay').remove();
          } 
          else {
                
                $('#divcard_title_Deuda').html("<span class='text-danger'>"+carnet+"</span> / "+estudiante);
                $("#divdaperiodo").html(periodo);
                $("#divdacarrera").html(programa);
                $("#divdaplan").html(plan);
                $("#divdaciclo").html(ciclo);
                $("#divdaturno").html(turno);
                $("#divdaseccion").html(seccion);

                nro = 0;
                totald = 0;
                var bgcolor = "";
                $.each(e.vdata, function(index, v) {
                  nro++;
                  totald = totald + parseFloat(v['saldo']);
                  var bgsaldo = (v['saldo']>0) ? "text-danger":"text-success";

                  switch (v['estado']) {
                      case "ACTIVO":
                          bgcolor = "btn-success";
                          break;
                      case "ANULADO":
                          bgcolor = "btn-danger";
                          break;
                      default:
                          bgcolor = "btn-success";
                  }

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
                                        "<div class='col-4 col-md-4 td text-center'>"+v['vence']+"</div>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+v['grupo']+"</div>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+
                                          '<div class="btn-group dropleft">' +
                                            '<button class="btn ' + bgcolor + ' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" ' +
                                            'aria-haspopup="true" aria-expanded="false">' +
                                            (v['estado'].toLowerCase()).charAt(0).toUpperCase() + (v['estado'].toLowerCase()).slice(1) +
                                            '</button> ' +
                                            '<div class="dropdown-menu">' +
                                              '<a href="#" class="dropdown-item" data-color="btn-danger" data-ie="' + cd2de + '" data-coddeuda="' + v['codigo64'] + '" id="btn_stanul' + v['codigo64'] + '" data-toggle="modal" data-target="#modanuladeuda">Anulado</a>' +
                                            '</div>' +
                                          '</div>' +
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>";
                })

                if (nro > 0) {
                  $("#modDeudas_view").modal('show');
                } else {
                  Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: 'Felicitaciones, estado actualizado',
                    text: 'Se ha actualizado el estado',
                    backdrop: false,
                  })
                }
                
                $('#div_Deudas_view').html(tbldeudas);
                $('#modDeudas_view_content #divoverlay').remove();
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#modDeudas_view_content #divoverlay').remove();
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
}

$("#modDeudas_view").on('hidden.bs.modal', function(e) {
  $('#divcard_title_Deuda').html("");
  $("#divdaperiodo").html("");
  $("#divdacarrera").html("");
  $("#divdaplan").html("");
  $("#divdaciclo").html("");
  $("#divdaturno").html("");
  $("#divdaseccion").html("");
  $('#div_Deudas_view').html("");
})

$("#modanuladeuda").on('show.bs.modal', function(e) {
    var rel = $(e.relatedTarget);
    var coddeuda = rel.data('coddeuda');
    var estado = rel.data('ie');
    var color = rel.data('color');

    $('#ficdeudacodigo').val(coddeuda);
    $('#ficdeudaestado').val(estado);
    $('#lbtn_anula_deuda').data('coloran', color);
});

$('#lbtn_anula_deuda').click(function() {
    var color = $(this).data('coloran');
    // alert("Mensaje");
    $('#form_anuladeuda input,select,textarea').removeClass('is-invalid');
    $('#form_anuladeuda .invalid-feedback').remove();
    $('#divmodalanulad').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $('#form_anuladeuda').attr("action"),
        type: 'post',
        dataType: 'json',
        data: $('#form_anuladeuda').serialize(),
        success: function(e) {
            $('#divmodalanulad #divoverlay').remove();
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
                $('#modanuladeuda').modal('hide');
                var btdtan = $('#btn_stanul' + e.iddeuda).parents(".btn-group").find('.dropdown-toggle');
                var textoan = $('#btn_stanul' + e.iddeuda).html();
                btdtan.removeClass('btn-danger');
                btdtan.removeClass('btn-success');
                btdtan.addClass(color);
                btdtan.html(textoan);

                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: 'Felicitaciones, deuda anulada',
                    text: 'Se ha anulado la deuda',
                    backdrop: false,
                })

            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodalanulad #divoverlay').remove();
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

/* ====================================
DEUDAS
======================================= */

function fn_historial_vw_deudas(btn) {
  $('#modDeudas_historial').modal();
  $('#modDeudas_historial .modDeudas_historial_content').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#div_Pagos_Historial').html("");
  tabla = "";
  tbdeudas = "";
  tbdeudash = "";
  var fila = btn.closest('.cfila_mt');
  var carnet = fila.data('carnet');
  var estudiante = fila.data('estudiante');
  var idmatricula = fila.data('codmatricula64');

  var programa = btn.data('programa');
  var periodo = btn.data('periodo');
  var ciclo = btn.data('ciclo');
  var turno = btn.data('turno');
  var seccion = btn.data('seccion');
  var plan = btn.data('plan');
  
  $.ajax({
      url: base_url + "matricula/fn_docemitidos_items_x_pagante",
      type: 'post',
      dataType: 'json',
      data: {
          codpagante: carnet,
          idmatricula: idmatricula
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
              $('#modDeudas_historial .modDeudas_historial_content #divoverlay').remove();
          } 
          else {
                
                $('#divcard_title_HDeuda').html("<span class='text-danger'>"+carnet+"</span> / "+estudiante);
                $("#divhtperiodo").html(periodo);
                $("#divhtcarrera").html(programa);
                $("#divhtplan").html(plan);
                $("#divhtciclo").html(ciclo);
                $("#divhtturno").html(turno);
                $("#divhtseccion").html(seccion);

                var nro = 0;
                var tabla = "";
                var boton = "";
                // LLENADO DE DATOS PAGOS
                $.each(e.vdata, function(index, p) {
                    nro++;
                    var estado = p['estadoc'];
                    // boton = "<a href='#' onclick='fn_vw_seleccionar_pago($(this));return false;' title='Seleccionar' class='badge badge-primary'>seleccione</a>";
                    
                    monto = Number.parseFloat(p['monto']).toFixed(2);
                    if (estado !== "ANULADO") {
                      tabla = tabla +
                          "<div class='row rowcolor' data-tipo='" + p['codtipo'] + "' data-serie='" + p['serie'] + "' data-numero='" + p['numero'] + "'>" +
                          "<div class='col-6 col-md-5'>" +
                          "<div class='row'>" +
                          "<div class='col-4 col-md-2 td text-center'><span><b>" + nro + "</b></span></div>" +
                          "<div class='col-8 col-md-5 td'><span>" + p['serie'] + "-" + p['numero'] + "</span>" +
                          "</div>" +
                          "<div class='col-8 col-md-5 td'><span>" + p['fecha_hora'] + "</span>" +
                          "</div>" +
                          "</div>" +
                          "</div>" +
                          "<div class='col-4 col-md-4 td'><span>" + p['gestion'] + "</span></div>" +
                          "<div class='col-6 col-md-3 text-center'>" +
                          "<div class='row'>" +
                          "<div class='col-6 col-md-4 td text-center'><span>" + monto + "</span></div>" +
                          "<div class='col-6 col-md-8 td'><span>" + p['estadoc'] + "</span></div>" +
                          "</div>" +
                          "</div>" +
                          "</div>";
                    }
                });

                var nrod = 0;
                var nrod2 = 0;
                var tbdeudas = "";
                var tbdeudash = "";
                var bgcolor = "";
                totald = 0;
                // LLENADO DE DATOS DEUDAS
                $.each(e.vdeudas, function(index, v) {
                  totald = totald + parseFloat(v['saldo']);
                  var bgsaldo = (v['saldo']>0) ? "text-danger":"text-success";
                  var codmatricula = v['idmatricula64'];
                  switch (v['estado']) {
                      case "ACTIVO":
                          bgcolor = "btn-success";
                          break;
                      case "ANULADO":
                          bgcolor = "btn-danger";
                          break;
                      default:
                          bgcolor = "btn-success";
                  }

                  if (codmatricula === idmatricula) {
                    nrod++;
                    tbdeudas = tbdeudas + 
                          "<div class='row cfila' onclick='fn_rowselection($(this))' data-cdeuda='" + v['codigo64'] + "'>"+
                                "<div class='col-12 col-md-4'>"+
                                    "<div class='row'>"+
                                        "<div class='col-2 col-md-1 td text-center bg-lightgray px-0'>"+nrod+"</div>"+
                                        "<div class='col-2 col-md-2 td text-center'><b>"+v['codigo']+"</b></div>"+
                                        "<div class='col-8 col-md-9 td'>"+v['persona'] +"</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-3 td'>"+
                                    "<span>"+v['gestion']+"</span>"+
                                "</div>"+
                                "<div class='col-12 col-md-2'>"+
                                    "<div class='row'>"+
                                        "<div class='col-5 col-md-5 td text-center'>"+parseFloat(v['monto']).toFixed(2)+"</div>"+
                                        "<div class='col-5 col-md-5 td text-center'>"+
                                          "<span class='"+bgsaldo+"'>"+parseFloat(v['saldo']).toFixed(2)+"<span>"+
                                        "</div>"+
                                        "<div class='col-2 col-md-2 td text-center'>"+
                                          '<a href="#" onclick="fn_vw_editar_deuda($(this));return false;" title="Editar Deuda" >' +
                                            '<i class="fas fa-pencil-alt fa-lg mx-1"></i>' +
                                          '</a>' +
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-3'>"+
                                    "<div class='row'>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+v['vence']+"</div>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+v['grupo']+"</div>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+
                                          '<div class="btn-group dropleft">' +
                                            '<button class="btn ' + bgcolor + ' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" ' +
                                            'aria-haspopup="true" aria-expanded="false">' +
                                            (v['estado'].toLowerCase()).charAt(0).toUpperCase() + (v['estado'].toLowerCase()).slice(1) +
                                            '</button> ' +
                                            '<div class="dropdown-menu">' +
                                              '<a href="#" class="dropdown-item" data-color="btn-danger" data-ie="' + cd2de + '" data-coddeuda="' + v['codigo64'] + '" id="btn_stanul' + v['codigo64'] + '" data-toggle="modal" data-target="#modanuladeuda">Anulado</a>' +
                                              '<div class="dropdown-divider"></div>' +
                                              '<a href="#" data-cdeudad="' + v['codigo64'] + '" onclick="fn_delete_deuda($(this))" class="dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>' +
                                            '</div>' +
                                          '</div>' +
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>";
                  } else {
                    nrod2++;
                    tbdeudash = tbdeudash + 
                          "<div class='row cfila'>"+
                                "<div class='col-12 col-md-4'>"+
                                    "<div class='row'>"+
                                        "<div class='col-2 col-md-1 td text-center bg-lightgray px-0'>"+nrod2+"</div>"+
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
                                        "<div class='col-4 col-md-4 td text-center'>"+v['vence']+"</div>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+v['grupo']+"</div>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+
                                          // '<div class="btn-group dropleft">' +
                                          //   '<button class="btn ' + bgcolor + ' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" ' +
                                          //   'aria-haspopup="true" aria-expanded="false">' +
                                          //   (v['estado'].toLowerCase()).charAt(0).toUpperCase() + (v['estado'].toLowerCase()).slice(1) +
                                          //   '</button> ' +
                                          //   '<div class="dropdown-menu">' +
                                          //     '<a href="#" class="dropdown-item" data-color="btn-danger" data-ie="' + cd2 + '" data-coddeuda="' + v['codigo64'] + '" id="btn_stanul' + v['codigo64'] + '" data-toggle="modal" data-target="#modanuladeuda">Anulado</a>' +
                                          //   '</div>' +
                                          // '</div>' +
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>";
                  }

                  
                })

                if (nrod2 > 0) {
                  $('#divdata_Deudas_Historial').html(tbdeudash);
                  $('#divcard_deudas_historial').show();
                }

                $('#div_Deudas_Historial').html(tbdeudas);
                $('#div_Pagos_Historial').html(tabla);

                if (e.conteo > 0) {
                  $('#lbtn_reportedeudas').data('carnet', carnet);
                  $('#lbtn_reportedeudas').show();
                }

                if (e.pagos > 0) {
                  $('#lbtn_reportepagos').data('carnet', carnet);
                  $('#lbtn_reportepagos').data('pagante', estudiante);
                  $('#lbtn_reportepagos').data('programa', programa);
                  $('#lbtn_reportepagos').show();
                }
                
                $('#modDeudas_historial .modDeudas_historial_content #divoverlay').remove();
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#modDeudas_historial .modDeudas_historial_content #divoverlay').remove();
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

$("#modDeudas_historial").on('hidden.bs.modal', function(e) {
  $('#nav-mdeudash-tab').addClass('active');$('#nav-mdeudash').addClass('show active');
  $('#nav-mpagos-tab').removeClass('active');$('#nav-mpagos').removeClass('show active');

  $('#div_Deudas_Historial').html("");
  $('#divdata_Deudas_Historial').html("");
  $('#div_Pagos_Historial').html("");
  $('#lbtn_reportedeudas').hide();
  $('#lbtn_reportepagos').hide();
})

function fn_rowselection(btn) {
    $("#div_Deudas_Historial .cfila").removeClass("bg-selection");
    btn.addClass("bg-selection");
};

function fn_vw_editar_deuda(btn) {
    var fila = btn.closest('.cfila');
    var codigo = fila.data('cdeuda');
    $('#modDeudas_historial .modDeudas_historial_content').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "deudas_individual/fn_get_deuda_codigo",
        type: 'post',
        dataType: 'json',
        data: {
            vw_fcb_txtcodigo : codigo,
        },
        success: function(e) {
            $('#modDeudas_historial .modDeudas_historial_content #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    title: "Error!",
                    text: "No se encontraron datos",
                    type: 'error',
                    icon: 'error',
                })
            } else {
                $('#ficcodpagante').attr('readonly', true);
                $('#ficapenomde').attr('readonly', true);
                $('#modadddeuda').modal();
                $('#divcard_button').hide();
                $('#ficcodmatricula').html(e.vmatriculas);
                $('#divcard_nompagante').removeClass('col-lg-5');
                $('#divcard_nompagante').addClass('col-lg-8');

                $('#ficcod_deuda').val(e.vdata['coddeuda64']);
                $('#ficcodpagante').val(e.vdata['pagante']);
                $('#ficcodmatricula').val(e.vdata['codmat64']);
                $('#ficapenomde').val(e.vdata['paterno'] + " " + e.vdata['materno'] + " " + e.vdata['nombres']);
                $('#ficbgestion').val(e.vdata['codgestion']);
                $('#ficmonto').val(parseFloat(e.vdata['monto']).toFixed(2));
                $('#ficmora').val(parseFloat(e.vdata['mora']).toFixed(2));
                $('#ficfechcreacion').val(e.vdata['fecha']);
                $('#ficfechvence').val(e.vdata['fvence']);
                $('#ficfechprorrog').val(e.vdata['fprorroga']);
                $('#ficvouchcodigo').val(e.vdata['voucher']);
                $('#ficcodigofecitem').val(e.vdata['fitem']);
                $('#ficrepitecic').val(e.vdata['repciclo']);
                $('#ficsaldo').val(parseFloat(e.vdata['saldo']).toFixed(2));
                $('#ficobservacion').val(e.vdata['observacion']);
                $('#divcardform_search_pagante').hide();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'div');
            $('#modDeudas_historial .modDeudas_historial_content #divoverlay').remove();
            $('#divres_paghistorial').html(msgf);
        }
    })
}

$('#lbtn_guardar_deuda').click(function() {
    $('#frm_addpagante input,select,textarea').removeClass('is-invalid');
    $('#frm_addpagante .invalid-feedback').remove();
    $('#divmodaladdmat').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $('#frm_addpagante').attr("action"),
        type: 'post',
        dataType: 'json',
        data: $('#frm_addpagante').serialize(),
        success: function(e) {
            $('#divmodaladdmat #divoverlay').remove();
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
                // $('#modadddeuda').modal('hide');
                if (e.estado == "INSERTAR") {
                    $('#ficcodpagante').val("");
                    $('#ficcodpagante').attr('readonly', false);
                    $('#ficapenomde').attr('readonly', false);
                    $('#ficcodmatricula').html('<option value="">Sin Asignar</option>');
                    $('#ficapenomde').val("");
                    $('#frm_addpagante')[0].reset();
                } else {
                    $('#modadddeuda').modal('hide');
                    // $('#tbdd_form_search_deudas').submit();
                }
                
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: e.msg,
                    // text: 'Se ha actualizado el estado',
                    backdrop: false,
                })

            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divmodaladdmat #divoverlay').remove();
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

function fn_delete_deuda(btn) {
    $('#divcard_deudas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var cdeuda = btn.data("cdeudad");
    var fila = btn.parents(".cfila");
    // var carne=fila.find('.cell-carne').html();
    //************************************
    Swal.fire({
        title: "Precaución",
        text: "Se eliminarán todos los datos con respecto a esta DEUDA ",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.value) {
            //var codc=$(this).data('im');
            $.ajax({
                url: base_url + 'deudas_individual/fn_eliminar',
                type: 'post',
                dataType: 'json',
                data: {
                    'id-deuda': cdeuda
                },
                success: function(e) {
                    $('#divcard_deudas #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            type: 'error',
                            icon: 'error',
                            title: 'Error!',
                            text: e.msg,
                            backdrop: false,
                        })
                    } else {

                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: 'Eliminación correcta',
                            text: 'Se ha eliminado la deuda',
                            backdrop: false,
                        })

                        fila.remove();
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divcard_deudas #divoverlay').remove();
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
            $('#divcard_deudas #divoverlay').remove();
        }
    });
    return false;
}

function fn_view_reporte_deudas(btn) {
  var carnet = btn.data('carnet');
  var url = base_url + "tesoreria/facturacion/reporte/deudas/estudiante/pdf?tp=CARNET&nro=" + carnet;
  window.open(url, '_blank');
}

function fn_view_reporte_pagos(btn) {
  var carnet = btn.data('carnet');
  var pagante = btn.data('pagante');
  var programa = btn.data('programa');
  var url = base_url + "tesoreria/facturacion/reporte/pagos/estudiante/pdf?ct=" + carnet + "&cpg=" + pagante + "&cpm=" + programa;
  window.open(url, '_blank');
}


</script>