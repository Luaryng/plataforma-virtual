<?php
$vbaseurl=base_url();
date_default_timezone_set('America/Lima');
$vuser=$_SESSION['userActivo'];
$fechahoy = date('Y-m-d');
?>
<!--<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.css"/>
<style>
  table.dataTable tbody tr.selected a {
    color: #007bff;
  }
</style>
<div class="content-wrapper">
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
var cd1 = '<?php echo base64url_encode("1") ?>';
var cd2 = '<?php echo base64url_encode("2") ?>';
var cd7 = '<?php echo base64url_encode("7") ?>';


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
                            default:
                                btnscolor = "btn-warning";
                        }

                        if (vpermiso172 == "SI" && v['estado'] == "DES" && v['condicional'] == "NO") {
                          var btnactcondi = '<a href="#" target="_blank" class="dropdown-item" onclick="fn_activa_matcondicional($(this));return false;" data-codigo="'+vcm+'" data-estado="SI"><i class="fas fa-check-circle mr-2"></i>Activa Condicional</a>';
                        }

                        dropdown_estado = '<div class="btn-group">' +
                            '<button class="btn ' + btnscolor + ' btn-sm text-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            v['estado'] +
                            '</button>' +
                            '<div class="dropdown-menu">' +
                            '<a href="#" onclick="fn_cambiarestado($(this))" class="dropdown-item" data-ie="' + cd1 + '">Activo</a>' +
                            '<a href="#" onclick="fn_cambiarestado($(this))" class="dropdown-item"  data-ie="' + cd2 + '">Retirado</a>' +
                            '<a href="#" onclick="fn_cambiarestado($(this))" class="dropdown-item"  data-ie="' + cd7 + '">Desaprobado</a>' +
                            '<div class="dropdown-divider"></div>' +
                            '<a href="#" onclick="fn_eliminar_matricula($(this))" class="btn-ematricula dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>' +
                            '</div>' +
                            '</div>';
                        sexo = (v['codsexo'] == "FEMENINO") ? "<i class='fas fa-female text-danger mr-1'></i>" : "<i class='fas fa-male text-primary mr-1'></i>";
                        estudiante = sexo + v['paterno'] + " " + v['materno'] + " " + v['nombres'] + " " + v['edad'];
                        fecharegistro = v['registro'] + " <a href='#' class='view_user_reg' tabindex='0' role='button' data-toggle='popover' data-trigger='hover' title='Matriculado por: ' data-content='"+v['usuario']+"'><i class='fas fa-info-circle fa-lg'></i></a>";
                        vcuota = v['vpension'] + " ("+v['beneficio']+")";
                        grupo = v['periodo'] + " " + v['sigla'] + " " + v['codturno'] + " " + v['ciclo'] + " " + v['codseccion'];
                        boleta = '<a class="bg-success text-white py-1 px-2 mr-1 rounded btncall-boleta" data-cm=' + vcm + ' data-prog=' + v['codcarrera'] + ' data-periodo=' + v['codperiodo'] + ' data-ciclo=' + v['codciclo'] + ' data-turno=' + v['codturno'] + ' data-seccion=' + v['codseccion'] + ' href="#" title="Carga académica" data-toggle="modal" data-target="#modmatriculacurso">' +
                            '<i class="fas fa-book"></i> Bol.' +
                            '</a>';
                        dropdown_imprimir = '<div class="btn-group dropleft">' +
                            '<button class="btn btn-info btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '<i class="fas fa-print"></i>' +
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
                              '<a class="btncall-carga dropdown-item" data-cm=' + vcm + '  href="#" title="Carga académica"><i class="fas fa-book"></i> Carga</a>'+
                              '<a href="#" data-cm=' + vcm + ' data-carne=' + v['carne'] + ' data-accion="EDITAR" class="dropdown-item text-success" data-toggle="modal" data-target="#modupmat"><i class="fas fa-edit mr-2"></i>Edita matricula</a>' +
                              '<a href="'+base_url+'academico/matricula/record-academico/excel/'+v['carne']+'" target="_blank" class="dropdown-item"><i class="fas fa-graduation-cap mr-2"></i>Récord académico</a>' +
                              '<a href="'+base_url+'academico/matricula/record-academico/pdf/'+v['carne']+'" target="_blank" class="dropdown-item text-info"><i class="fas fa-graduation-cap mr-2"></i>Récord académico (pdf)</a>' +
                              btnactcondi +
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
                        $(fila).attr('data-estudiante', estudiante);
                    });

                    tbmatriculados.draw();
                    $('#divcard-matricular #divoverlay').remove();

                    $('.view_user_reg').popover({
                      trigger: 'hover'
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
                title: 'Error, matrícula NO registrada',
                text: msgf,
                backdrop: false,
            })
        }
    });
    return false;
});

function comprobarcurso() {
    $("#div-cursosmat .cfila").each(function(index) {
        var cc = $(this).data('cc');
        var cs = $(this).data('ccs');
        //alert(cc + cs);
        $("#div-cursosdispo .cfila").each(function(index2) {
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
        if (agregar == 'si') {
            var codcurso = base64url_encode(v['codcurso']);
            jsbtnagregar = '<div class="td col-2 col-md-12"><button data-ccurso="' + codcurso + '" data-cc="' + mcidcarga + '"  data-cd="' + v['subseccion'] + '" data-cm="' + vcm + '" title="Enrolar" class="btn btn-enrolar btn-sm btn-primary"><i class="fas fa-book-medical"></i></button></div>';
        }
        jsbtnretirar = "";
        if (agregar == 'no') {
            var midmiembro = base64url_encode(v['idmiembro']);
            jsbtnretirar = '<div class="td col-2 col-md-12"><button   data-im="' + midmiembro + '"  title="Eliminar" class="btn btn-desenrolar btn-sm btn-danger"><i class="fas fa-minus-square"></i></button></div>';
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
            '<div class="col-4 col-md-3">' +
            '<div class="row">' +
            '<div class="tdnro col-3 col-md-2 td">' + nro + '</div>' +
            '<div class="col-9 col-md-10 td">(' + v['idcarga'] + 'G' + v['subseccion'] + ') ' + v['curso'] + ' <small class="text-primary">(' + v['carga_sede'] + ')</small></div>' +
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
            '<div class="col-6 col-md-2 td">' + v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + '</div>' +
            '<div class="col-6 col-md-1">' + jsbtnagregar + jsbtnretirar + '</div>' +
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
                                ordenarnro("div-cursosmat");
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
    var vcm = $("#vwtxtcodmat").val();
    $.ajax({
        url: base_url + 'cargasubseccion/fn_filtrar',
        type: 'post',
        dataType: 'json',
        data: fdata,
        success: function(e) {
            mostrarCursos('div-cursosdispo', vcm, e.vdata, 'si');
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
                $("#divmodalnewmatricula #divcard_title").html(e.vmatricula['paterno'] + " " + e.vmatricula['materno'] + " " + e.vmatricula['nombres'] + " / " + e.vmatricula['carne'] );
                $("#divbncorreo").html(e.vmatricula['ecorporativo']);

                
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
                            '<a href="#" class="btn-cborigen dropdown-item" data-origen="PLATAFORMA">PLATAFORMA</a>' +
                            '<a href="#" class="btn-cborigen dropdown-item" data-origen="MANUAL">MANUAL</a>' +
                            '<a href="#" class="btn-cborigen dropdown-item" data-origen="CONVALIDA">CONVALIDA</a>' +
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

// ===== SCRIPT NUEVOS ========
$("#modupmat").on('shown.bs.modal', function(e) {
    var rel = $(e.relatedTarget);
    var idmat = rel.data('cm');
    var carne = rel.data('carne');
    var accion = rel.data('accion');
    if (accion == "EDITAR") {
        $('#divsearch_ins').hide();
        $('#divalert_mat').hide();
        $('#btn_refresh_cond').hide();
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

                    fn_data_academico(carne);
                    fn_data_deudas(carne);
                    fn_historias_matriculas(carne);

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
        // $('#btn_refresh_cond').show();
        $('#modfiltroins').modal('show');
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
                        btnselect = "<a href='#' class='btn btn-info btn-sm btn_select' title='seleccionar'><i class='fas fa-share'></i></a>";
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
                $('.btn_select').click(function(e) {
                    e.preventDefault();
                    var boton = $(this);
                    var fila = boton.closest('.cfilains');
                    var carne = fila.data('carnet');
                    var alumno = fila.data('alumno');

                    $('#divmodalsearch').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                    $.ajax({
                        url: base_url + "inscrito/fn_get_datos_carne",
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

                                } else {
                                    $('#divalert_mat').hide();
                                    $('#titlemodal').html("<span class='text-danger'>"+carne+"</span> / "+alumno);
                                    $('#fm-txtcarreraup').val(e.vdata['codcarrera']);
                                    $('#fm-carreraup').html(e.vdata['carrera']);
                                    $('#fm-cbplanup').html(e.vplanes);
                                    $('#fm-cbplanup').val(e.vdata['codplan']);
                                    $('#fm-txtplanup').val(e.vdata['codplan']);
                                    $('#fm-txtmapepatup').val(e.vdata['paterno']);
                                    $('#fm-txtmapematup').val(e.vdata['materno']);
                                    $('#fm-txtmnombresup').val(e.vdata['nombres']);
                                    $('#fm-txtmsexoup').val(e.vdata['sexo']);

                                    fn_data_academico(carne);
                                    fn_data_deudas(carne);
                                    fn_historias_matriculas(carne);
                                    
                                    function fn_validaciones_mat(){
                                      if (creditos[0] >= 6 || deudasestud[0] > 0) {
                                          $('#lbtn_editamat').attr('disabled', true);
                                          $('#msgcursos_deudas').html('<div class="alert alert-danger alert-dismissible">'+
                                              '<h5><i class="icon fas fa-ban"></i> Advertencia!</h5>'+
                                              'El estudiante no puede ser matriculado por presentar unidades didácticas desaprobadas con 6 creditos a más o presentar deudas pendientes, favor de regularizar lo antes mencionado'+
                                            '</div>');
                                        } else {
                                          $('#lbtn_editamat').attr('disabled', false);
                                          $('#msgcursos_deudas').html('');
                                        }

                                        if (mat_condicional[0] == "DES" && mat_condicional[1] == "NO") {
                                          $('#btn_refresh_cond').show();
                                          $('#lbtn_condic_refresh').show();
                                          $('#lbtn_condic_refresh').data('carne', carne);
                                          $('#lbtn_editamat').attr('disabled', true);
                                        } else if (mat_condicional[0] == "DES" && mat_condicional[1] == "SI"){
                                          $('#btn_refresh_cond').hide();
                                          $('#lbtn_editamat').attr('disabled', false);
                                          $('#msgcursos_deudas').html('');
                                        } else {
                                          $('#btn_refresh_cond').hide();
                                        }
                                    }
                                    function fn_hide_overlay() {
                                      $('#divmodaddmatricula #divoverlay').remove();
                                    }
                                    setTimeout(function() {
                                      $('#divmodaddmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                                      
                                      setTimeout(fn_validaciones_mat,5000);
                                      setTimeout(fn_hide_overlay,6000);
                                    }, 400);
                                    // console.log('deudas',deudasestud);
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

});
//$("#fmt-conteo").html(nro + ' matriculas encontradas');
//$('#divcard-matricular #divoverlay').remove();
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

function fn_cambiarestado(btn) {
  tbmatriculados = $('#tbmt_dtMatriculados').DataTable();
  fila = tbmatriculados.$('tr.selected');
  im = fila.data('codmatricula64');
  // var im = btn.parents(".cfila").data('idm');
  var ie = btn.data('ie');
  var btdt = btn.parents(".btn-group").find('.dropdown-toggle');
  var texto = btn.html();
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
                  case "Desaprobado":
                      btdt.addClass('btn-danger');
                      btdt.html("DES");
                      break;
                  default:
                      btnscolor = "btn-warning";
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
  if (item == "nav-matricular-tab") {
    $('#lbtn_editamat').show();
  } else {
    $('#lbtn_editamat').hide();
  }
})

creditos = [];
deudasestud = [];
mat_condicional = [];
function fn_data_academico(carnet) {
  $('#divmodaddmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#divcard_data_academ').html("");
  tblacademico = "";
  tbldesaprobados = "";
  creditos = [];
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
                $.each(e.cursos, function(index, v) {
                  grupoint = v['codperiodo'];
                  vestado = v['estado'];
                  if (grupoac != grupoint) {
                      grupoac = grupoint;
                      nro = 0;
                      nrodsp = 0;
                      tblacademico = tblacademico + 
                          "<div class='row cfila'>"+
                              "<div class='col-12 td text-center p-1 bg-lightgray'><b>"+v['periodo']+"</b></div>"+
                          "</div>";

                      if (vestado == "DES" || vestado == "DPI" || vestado == "NSP") {
                        tbldesaprobados = tbldesaprobados+
                          "<div class='row cfila'>"+
                              "<div class='col-12 td text-center p-1 bg-lightgray'><b>"+v['periodo']+"</b></div>"+
                          "</div>";
                      }
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

                    // LISTAR UNIDADES DESAPROBADAS
                    if (vestado == "DES" || vestado == "DPI" || vestado == "NSP") {
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
                creditos.push(e.nrocreddes);
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
  deudasestud = [];
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
                $.each(e.vdata, function(index, v) {
                  nro++;
                  var bgsaldo = (v['saldo']>0) ? "text-danger":"text-success";
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
                        "<div class='col-9 col-md-9 td'><b>Deudas</b></div>"+
                        "<div class='col-3 col-md-3 td'>"+nro+"</div>"+
                      "</div>"+
                    "</div>"+
                  "</div>";
                $('#msgdeuda_estudiante').html(tbnrodeudas);
                
                $('#divcard_data_deudas').html(tbldeudas);
                deudasestud.push(nro);
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

function fn_historias_matriculas(carnet){
  $('#divmodaddmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#msghistorial_estudiante').html("");
  tblhistorial = "";
  mat_condicional = [];
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
                nro = 0;
                $.each(e.vdata, function(index, v) {
                  nro++;
                  var btnscolor = "";
                  estado = v['estado'];
                  condicional = v['condicional'];
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
                  fecharegistro = v['registro'] + " <a href='#' class='view_user_reg_hst' tabindex='0' role='button' data-toggle='popover' data-trigger='hover' title='Matriculado por: ' data-content='"+v['usuario']+"'><i class='fas fa-info-circle fa-lg'></i></a>";
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
                })
                
                $('#msghistorial_estudiante').html(tblhistorial);
                $('#divmodaddmatricula #divoverlay').remove();
                $('.view_user_reg_hst').popover({
                  trigger: 'hover'
                })
                mat_condicional.push(estado,condicional);
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
</script>