<?php
$vbaseurl=base_url();
date_default_timezone_set('America/Lima');
$fechahoy = date('Y-m-d');
$vuser=$_SESSION['userActivo'];
$p66=getPermitido("66");
$p67=getPermitido("67");
$p128 = getPermitido("128");
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.css"/>
<link href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.bootstrap4.min.css"/>-->

<div class="content-wrapper">
  <?php include 'vw_carga_academica_modals.php'; ?>
  <section id="s-cargado" class="content pt-1">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-carga_academica-tab" data-toggle="tab" href="#nav-carga_academica" role="tab" aria-controls="nav-carga_academica" aria-selected="true">Cargas Académicas</a>
        <a class="nav-item nav-link" id="nav-grupos-tab" data-toggle="tab" href="#nav-grupos" role="tab" aria-controls="nav-grupos" aria-selected="false">Carga Grupal</a>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-carga_academica" role="tabpanel" aria-labelledby="nav-carga_academica-tab">
        <div id="divcard-cargaAcademica" class="card">
          
          <div class="card-body">
            <div class="row-fluid">
              <form id="frmfiltro-carga_academica" name="frmfiltro-carga_academica" method="post" accept-charset='utf-8'>
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
                  <!--<div class="col-6 col-sm-4 col-md-4">
                    <a href="#" class="btn-excel btn btn-sm btn-outline-secondary"><img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt=""> Exportar</a>
                    <a href="#" class="btn_campos btn btn-sm btn-outline-secondary"><img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt=""> Campos</a>
                  </div>-->
                </div>
              </form>
            </div>
            
            <div class="col-12 px-0 pt-2">
              <div class="table-responsive">
                <table id="tbc_dtCargaAcademica" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                  <thead>
                    <tr class="bg-lightgray">
                      <th>N°</th>
                      <th>Filial</th>
                      <th>Carga</th>
                      
                      <th>Plan</th>
                      <th>Grupo</th>
                      <th>Unidad Didáctica</th>
                      <th class="text-center" title="ABIERTO"><i class="far fa-folder-open"></i></th>
                      <th class="text-center" title="VISIBLE"><i class="far fa-eye"></i></th>
                      <th>Cd</th>
                      <th>Hr</th>
                      <th title="ENROLADOS"><i class="fas fa-user-friends"></i></th>
                      <th>Docente</th>
                      <th>Fusión</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="nav-grupos" role="tabpanel" aria-labelledby="nav-grupos-tab">
        <div id="divcard-cargaAcademica" class="card">
           <div class="card-header">
                <h3 class="card-title">Selecciona un gupo para generar su carga académica</h3>
              </div>
          <div class="card-body">
            <div id="divcard_grupo" class="cardg">
             
              <div class="card-bodyg">
                
                <form id="frm-grupo" name="frm-grupo" action="#" method="post" accept-charset='utf-8'>
                  <div class="row mt-2">
                    <div class="form-group has-float-label col-12  col-sm-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fca-cbperiodo" name="fca-cbperiodo" placeholder="Periodo" required >
                        <option value="0">Periodo</option>
                        <?php foreach ($periodos as $periodo) {?>
                        <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fca-cbperiodo"> Periodo</label>
                    </div>
                    <div class="form-group has-float-label col-12  col-sm-4">
                      <select class="form-control form-control-sm" id="fca-carrera" name="fca-carrera" placeholder="Programa">
                        <option value="0">Selecciona un Programa Acad.</option>
                        <?php foreach ($carreras as $carrera) {?>
                        <option value="<?php echo $carrera->codcarrera ?>" data-sigla="<?php echo $carrera->sigla ?>"><?php echo $carrera->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fca-carrera"> Programa</label>
                    </div>
                    <div class="form-group has-float-label col-12  col-md-4">
                      <select class="form-control form-control-sm" id="fca-plan" name="fca-plan" placeholder="Plan curricular">
                        <option value="0">Selecciona Plan curricular</option>
                        <?php foreach ($planes as $plan) {?>
                        <option value="<?php echo $plan->codigo ?>"><?php echo $plan->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fca-plan"> Plan curricular</label>
                    </div>
                    
                    <div class="form-group has-float-label col-12  col-md-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fca-cbciclo" name="fca-cbciclo" placeholder="Ciclo" required >
                        <option value="0">Ciclo</option>
                        <?php foreach ($ciclos as $ciclo) {?>
                        <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fca-cbciclo"> Ciclo</label>
                    </div>
                    <div class="form-group has-float-label col-12  col-md-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fca-cbturno" name="fca-cbturno" placeholder="Turno" required >
                        <option value="0">Turno</option>
                        <?php foreach ($turnos as $turno) {?>
                        <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fca-cbturno"> Turno</label>
                    </div>
                    <div class="form-group has-float-label col-12  col-md-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fca-cbseccion" name="fca-cbseccion" placeholder="Sección" required >
                        <option value="0">Sección</option>
                        <?php foreach ($secciones as $seccion) {?>
                        <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fca-cbseccion"> Sección</label>
                    </div>
                    <div class="col-md-1 mb-2">
                      <input id="fca-checkgrupo" type="checkbox" data-toggle="toggle"
                      data-on="<i class='fa fa-check'></i>" data-off="<i class='fas fa-arrow-alt-circle-right'></i>"
                      data-onstyle="success" data-offstyle="danger">
                    </div>
                    <div class="col-12 col-md-3">
                      <button type="button" id="btn-vercurricula" class="btn btn-primary">
                      <i class="fas fa-eye"></i> Currícula
                      </button>
                    </div>
                    <div class="col-12 col-md-3">
                      Matrículas : <span id="vw_cg_spn_nmatriculas"></span>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div id="divcard_cursos" class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-plus mr-1"></i> Registro de carga académica por grupo</h3>
              </div>
              <div class="card-body">
                <b class="text-danger"></i> Selecciona el grupo</b>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    
  </section>
</div>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/grupo_carga_academica.js"></script>
<!--<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.bootstrap4.min.js"></script>-->
<script>
var vpermiso151 = '<?php echo getPermitido("151") ?>';
//var tb;
var btn_editdocente=null;
var vdocentes = <?php echo json_encode($docentes, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) ?>;
var vpermiso128 = '<?php echo getPermitido("128"); ?>';
var vpermiso66 = '<?php echo getPermitido("66"); ?>';
var vpermiso67 = '<?php echo getPermitido("67"); ?>';

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000
})
$("#btn-vercurricula").hide();


$(document).ready(function() {
    $('#tbc_dtCargaAcademica').DataTable({
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
        }, {
            "targets": 6,
            "className": "text-center",
        }, {
            "targets": 7,
            "className": "text-center",
        }, {
            "targets": 8,
            "className": "text-center",
        }, {
            "targets": 9,
            "className": "text-center",
        }, {
            "targets": 10,
            "className": "text-center",
        }],

    });
    $('#tbc_dtCargaAcademica_fusion').DataTable({
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
        }, {
            "targets": 6,
            "className": "text-center",
        }, {
            "targets": 7,
            "className": "text-center",
        }, {
            "targets": 8,
            "className": "text-center",
        }, {
            "targets": 9,
            "className": "text-center",
        }, {
            "targets": 10,
            "className": "text-center",
        }],

    });
    var table = $('#tbce_dtEstutiantesEnrolados').DataTable({
        "autoWidth": false,
        "lengthChange": false,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
        },
        'columnDefs': [{
            "targets": 0, // your case first column
            "className": "text-right rowhead",
            "width": "8px"
        }],
        dom: "<'row'<'col-sm-9'B><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: {
            buttons: [{
                text: '<i class="fas fa-user-plus"></i>',
                className: 'btn-sm btn-primary',
                action: function(e, dt, node, config) {
                    alert('Button activated');
                }
            }, {
                text: '<i class="fas fa-trash-alt"></i>',
                className: 'btn-sm btn-danger',
                action: function(e, dt, node, config) {
                    fn_desenrolar();
                },
                enabled: false
            }],
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
});
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
        if (tabla.table().node().id == "tbce_dtEstutiantesEnrolados") {
            tabla.button(1).enable(true);
        }
    }
});
$("#frmfiltro-carga_academica").submit(function(event) {
    //event.preventDefault()
    tbcarga = $('#tbc_dtCargaAcademica').DataTable();
    tbcarga.clear();
    $('#divcard-cargaAcademica').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'cargasubseccion/fn_get_carga_subseccion_filtro',
        type: 'post',
        dataType: 'json',
        data: $("#frmfiltro-carga_academica").serialize(),
        success: function(e) {

            $.each(e.vdata, function(index, carga) {
                grupo = carga['periodo'] + " " + carga['sigla'] + " " + carga['turno'] + " " + carga['ciclo'] + " " + carga['codseccion'];
                docente = "<span class='spandocente'>" + carga['paterno'] + " " + carga['materno'] + " " + String(carga['nombres']).replace(/ .*/, '')  + "</span>";
                docente = docente + "<a onclick='vw_abrir_modal_cambiarDocente($(this));return false;' href='#' title='Cambiar docente'>" +
                          "<i class='fas fa-pen ml-2'></i>" +
                          "</a> "
                unidad = carga['unidad'] + " (" + carga['codunidad'] + ")";
                creditos = Number(carga['cred_teo']) + Number(carga['cred_pra']);
                horas = Number(carga['hsem_teo']) + Number(carga['hsem_pra']);
                codigo = (carga['carga_activo'] == "NO") ? "<del>" + carga['codcarga'] + "G" + carga['division'] + "</del>" : carga['codcarga'] + "G" + carga['division'];


                if (vpermiso67=="NO"){
                  visible = (carga['activo'] == "NO") ? "<span class='badge badge-danger'>" + "NO" + "</span>" : "<span class='badge badge-success'>" + "SI" + "</span>";
                }
                else{
                  checked= (carga['activo'] == "NO") ? "":"checked";
                  visible ="<span>" + 
                      "<input " + checked + " class='checkOcultar' data-size='xs' type='checkbox' data-toggle='toggle'" +
                      " data-on='<i class=\"far fa-eye\"></i>' data-off='<i class=\"far fa-eye-slash\"></i>' data-onstyle='success' data-offstyle='danger' >"  + 
                    "</span>";
                }

                if (vpermiso66=="NO"){
                   abierto = (carga['culminado'] == "SI") ? "<span class='badge badge-danger'>" + "NO" + "</span>" : "<span class='badge badge-success'>" + "SI" + "</span>";
                }
                else{
                  checked= (carga['culminado'] == "SI") ? "":"checked";
                  abierto ="<span>" + 
                      "<input " + checked + " onchange='fn_abrir_cerrar_curso($(this));return false;' class='checkOpen' data-size='xs' type='checkbox' data-toggle='toggle'" +
                      " data-on='<i class=\"far fa-folder-open\"></i>' data-off='<i class=\"far fa-folder\"></i>' data-onstyle='success' data-offstyle='danger' >"  + 
                    "</span>";
                }


                //abierto = (carga['culminado'] == "SI") ? "<span class='badge badge-danger'>" + "NO" + "</span>" : "<span class='badge badge-success'>" + "SI" + "</span>";
                
                enrolados = "<a href='#' onclick='vw_abrir_modal($(this));return false' data-tabula='evaluaciones'>" + carga['enrolados'] + "</a>";
                /*dropdown = '<div class="btn-group">' +
                    '<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-cog"></i> </button>' +
                    '<div class="dropdown-menu">' +
                    '<a onclick="vw_abrir_modal($(this));return false" class="dropdown-item" data-tabula="evaluaciones" href="#">Evaluaciones</a>' +
                    '</div>' +
                    '</div>';*/
                fusion=(carga['codcarga'] + "G" + carga['division']==carga['codcarga_fusion'] + "G" + carga['division_fusion'] ) ? "": carga['codcarga_fusion'] + "G" + carga['division_fusion'];
                fusion='<a class="btn btn-info btn-sm py-0" href="#" onclick="vw_abrir_modal_fusion($(this));return false"><i class="fas fa-fist-raised mr-1"></i>' + fusion + '</a>';
                var fila = tbcarga.row.add([index + 1, carga['sede_abrevia'], codigo, carga['plan'], grupo, unidad, abierto, visible, creditos, horas, "<b>" + enrolados + "</b>", docente, fusion]).node();
                $(fila).attr('data-codcarga64', carga['codcarga64']);
                $(fila).attr('data-division64', carga['division64']);
                $(fila).attr('data-coddocente', carga['coddocente64']);
                $(fila).attr('data-unidad', unidad);
                $(fila).addClass("fdivision");



            });

            tbcarga.draw();
            $('.checkOcultar').bootstrapToggle();
            $('.checkOpen').bootstrapToggle();
            $('#divcard-cargaAcademica #divoverlay').remove();
        },
        error: function(jqXHR, exception) {
            $('#divcard-cargaAcademica #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                type: 'error',
                title: 'ERROR, NO se guardó cambios',
                text: msgf,
                backdrop: false,
            });
        },
    });
    return false;
});

$("#frmfiltro-carga_academica_fusion").submit(function(event) {
    //event.preventDefault()
    tbcarga = $('#tbc_dtCargaAcademica_fusion').DataTable();
    tbcarga.clear();
    $('#divcard-cargaAcademica').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'cargasubseccion/fn_get_carga_subseccion_filtro',
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {

            $.each(e.vdata, function(index, carga) {
                grupo = carga['periodo'] + " " + carga['sigla'] + " " + carga['turno'] + " " + carga['ciclo'] + " " + carga['codseccion'];
                docente = carga['paterno'] + " " + carga['materno'] + " " + String(carga['nombres']).replace(/ .*/, '');
                unidad = carga['unidad'] + " (" + carga['codunidad'] + ")";
                creditos = Number(carga['cred_teo']) + Number(carga['cred_pra']);
                horas = Number(carga['hsem_teo']) + Number(carga['hsem_pra']);
                codigo = (carga['carga_activo'] == "NO") ? "<del>" + carga['codcarga'] + "G" + carga['division'] + "</del>" : carga['codcarga'] + "G" + carga['division'];
                codigo ='<button class="btn btn-info btn-sm py-0" onclick="fn_fusionar($(this));return false"><i class="fas fa-fist-raised mr-1"></i>' + codigo +'</button>';
                abierto = (carga['culminado'] == "SI") ? "<span class='badge badge-danger'>" + "NO" + "</span>" : "<span class='badge badge-success'>" + "SI" + "</span>";
                visible = (carga['ACTIVO'] == "NO") ? "<span class='badge badge-danger'>" + "NO" + "</span>" : "<span class='badge badge-success'>" + "SI" + "</span>";;
                enrolados =  carga['enrolados'];
                
                var fila = tbcarga.row.add([index + 1, carga['sede_abrevia'], codigo, carga['plan'], grupo,"<b>" + unidad + "</b>" , abierto, visible, creditos, horas, "<b>" + enrolados + "</b>", docente]).node();
                $(fila).attr('data-codcarga64', carga['codcarga64']);
                $(fila).attr('data-division64', carga['division64']);
                $(fila).addClass('cfila_f');

            });
            tbcarga.draw();
            $('#divcard-cargaAcademica #divoverlay').remove();
        },
        error: function(jqXHR, exception) {
            $('#divcard-cargaAcademica #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                type: 'error',
                title: 'ERROR, NO se guardó cambios',
                text: msgf,
                backdrop: false,
            });
        },
    });
    return false;
});
/*function vw_md_enrolar(boton){
fila=boton.closest('tr');
codcarga64=fila.data('codcarga64');
division64=fila.data('division64');
$("#vw_cme_txtcodcarga").val(codcarga64);
$("#vw_cme_txtcoddivision").val(division64);

$("#modEnrolados").modal("show");
tbmiembros=$('#tbce_dtEstutiantesEnrolados').DataTable();
tbmiembros.clear();
tbmiembros.button(1).enable(false);
$('#modEnrolados .modEnrolados_content').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
$.ajax({
url: base_url + 'miembros/fn_get_miembros_x_carga_division',
type: 'post',
dataType: 'json',
data: {
codcarga: codcarga64,
division: division64
} ,
success: function(e) {

$.each(e.vmiembros, function(index, miembro) {
grupo=miembro['sigla'] + " " + miembro['codturno'] + " " + miembro['ciclo'] + " " + miembro['codseccion'] ;
sexo=(miembro['sexo']=="FEMENINO") ? "<i class='fas fa-female text-danger mr-1'></i>" : "<i class='fas fa-male text-primary mr-1'></i>";
estudiante= miembro['paterno'] + " " + miembro['materno'] + " " + miembro['nombres'];


//visible=(miembro['ACTIVO']=="NO") ? "<span class='badge badge-danger'>" + "NO" + "</span>":"<span class='badge badge-success'>" + "SI" + "</span>";;
eliminar="<a href='#' onclick='fn_desenrolar($(this))'><i class='fas fa-trash-alt text-danger'></i></a>";
var fila=tbmiembros.row.add([index + 1,miembro['sede_abrevia'],miembro['carnet'],sexo + estudiante,grupo,eliminar]).node();
$(fila).attr('data-idmiembro64',miembro['idmiembro64'] );
$(fila).attr('data-estudiante',estudiante);
//$(fila).attr('data-division64',miembro['division64'] );
});
tbmiembros.draw();
$('#modEnrolados .modEnrolados_content #divoverlay').remove();
},
error: function(jqXHR, exception) {
$('#modEnrolados .modEnrolados_content #divoverlay').remove();
var msgf = errorAjax(jqXHR, exception,'text');
Swal.fire({
type: 'error',
title: 'ERROR, NO se guardó cambios',
text: msgf,
backdrop:false,
});
},
});
return false;
}*/
function vw_abrir_modal(boton) {
    fila = boton.closest('tr');
    codcarga64 = fila.data('codcarga64');
    division64 = fila.data('division64');
    $("#vw_cme_txtcodcarga").val(codcarga64);
    $("#vw_cme_txtcoddivision").val(division64);

    $("#modEnrolados").modal("show");
    //if (boton.data('tabula')=="evaluaciones"){
    vw_md_evaluaciones();
    //}
    return false;
}
function vw_abrir_modal_fusion(boton) {
  
    fila = boton.closest('.fdivision');
    codcarga64 = fila.data('codcarga64');
    division64 = fila.data('division64');
    $("#vw_mdfs_txtcodcarga").val(codcarga64);
    $("#vw_mdfs_txtdivision").val(division64);

    $("#modFusionar").modal("show");
    //if (boton.data('tabula')=="evaluaciones"){
    //vw_md_evaluaciones();
    //}
    return false;
}

function vw_abrir_modal_cambiarCargaDivision(boton) {
  
    fila = boton.closest('.fdivision');
    estudiante = fila.data('estudiante');
    /*codcarga64 = fila.data('codcarga64');
    division64 = fila.data('coddivision');
    $("#vw_mdfs_txtcodcarga").val(codcarga64);
    $("#vw_mdfs_txtdivision").val(division64);*/
    $("#vw_md_ccd_spnestudiante").html(estudiante);
    $("#modCambiarCargaDivision").modal("show");
    //if (boton.data('tabula')=="evaluaciones"){
    //vw_md_evaluaciones();
    //}
    return false;
}

function vw_abrir_modal_cambiarDocente(boton) {
    fila=boton.closest(".fdivision");
    btn_editdocente=boton;
    var vgrupo=fila.data('division64');
    var vcarga=fila.data('codcarga64');
    var vunidad=fila.data('unidad');

    $("#vw_md_doc_txtcarga").val(vcarga);
    $("#vw_md_doc_txtdivision").val(vgrupo);
    $("#vw_md_doc_div_unidad").html(vunidad);
    $("#md_docentes").modal("show");
    docactual=fila.data('coddocente');
    if (docactual=="") docactual="00000";
    $("#vw_md_doc_docentes").val(docactual);
    
};


function vw_md_evaluaciones() {

    codcarga64 = $("#vw_cme_txtcodcarga").val();
    division64 = $("#vw_cme_txtcoddivision").val();

    tbenrolados = $('#tbce_dtEstutiantesEnrolados').DataTable();
    tbenrolados.clear();
    tbenrolados.button(1).enable(false);
    //tbevaluaciones.button(1).enable(false);
    $('#modEnrolados .modEnrolados_content').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'cargasubseccion/fn_get_carga_subseccion_datos_completos',
        type: 'post',
        dataType: 'json',
        data: {
            codcarga: codcarga64,
            division: division64
        },
        success: function(e) {
            $('#modEnrolados .modEnrolados_content #divoverlay').remove();
            $("#modEnrolados .modal-title").html(e.vcurso['unidad']);
            $("#vw_cme_spnDocente").html(e.vcurso['paterno'] + " " + e.vcurso['materno'] + " " + e.vcurso['nombres']);
            $("#vw_cme_spnPeriodo").html(e.vcurso['periodo']);
            $("#vw_cme_spnPrograma").html(e.vcurso['carrera']);
            $("#vw_cme_spnSemestre").html(e.vcurso['ciclo']);
            $("#vw_cme_spnTurno").html(e.vcurso['turno']);
            $("#vw_cme_spnSeccion").html(e.vcurso['codseccion']);
            $("#vw_cme_spnDivision").html(e.vcurso['division']);
            $("#vw_cme_spnMetodo").html(e.vcurso['metodo']);

            var thindicadores = "";
            var thhead = "";
            $.each(e.vindicadores, function(index, indicador) {
                colspan = 0;

                $.each(e.vhead, function(index, head) {
                    if (head['indicador'] == indicador['codigo']) {
                        colspan++;
                        thhead = thhead + "<th>" + head['abrevia'] + "</th>"
                    }
                });
                if (colspan == 0) colspan = 1;
                thindicadores = thindicadores + "<th colspan='" + colspan + "'>" + indicador['nombre'] + "</th>";
            });
            var head = '<tr class="bg-lightgray ">' +
                '<th rowspan="2">N°</th>' +
                '<th rowspan="2">Filial</th>' +
                '<th rowspan="2">Carné</th>' +
                '<th rowspan="2">Estudiante</th>' +
                thindicadores +
                '</tr>' +
                '<tr class="bg-lightgray">' +
                thhead +
                '</tr>';
            $('#tbce_dtEstutiantesEvaluaciones thead').html(head);
            tbevaluaciones = $('#tbce_dtEstutiantesEvaluaciones').DataTable();
            tbevaluaciones.clear();
            $.each(e.vmiembros, function(index, miembro) {
                //////////////
                //TBEVALUACIONES
                //////////////
                sexo = (miembro['sexo'] == "FEMENINO") ? "<i class='fas fa-female text-danger mr-1'></i>" : "<i class='fas fa-male text-primary mr-1'></i>";
                estudiante = miembro['paterno'] + " " + miembro['materno'] + " " + miembro['nombres'] + " " + miembro['idmiembro'];
                notas_miembro = e.vnotas[miembro['idmiembro']];
                //alert(e.vnotas);
                //var fila_new=[index + 1,miembro['sede_abrevia'],miembro['carnet'],sexo + estudiante];
                var fila_new = [{
                    "nro": index + 1,
                    "filial": miembro['sede_abrevia'],
                    "carnet": miembro['carnet'],
                    "estudiante": sexo + estudiante
                }];
                $.each(e.vindicadores, function(index, indicador) {
                    $.each(e.vhead, function(index, head) {
                        if (head['indicador'] == indicador['codigo']) {
                            calc = head['nombre_calculo'];
                            fila_new[calc] = notas_miembro['eval'][indicador['codigo']][head['nombre_calculo']]['nota'];
                        }
                    });
                    //fila_new.push(index);
                });
                var fila_eval = tbevaluaciones.row.add(fila_new).node();
                $(fila_eval).attr('data-idmiembro64', miembro['idmiembro64']);
                $(fila_eval).attr('data-estudiante', estudiante);
                //$(fila).attr('data-division64',miembro['division64'] );
                //////////////
                //TBENROLADOS
                //////////////
                grupo = miembro['sigla'] + "-" + miembro['codturno'] + "-" + miembro['ciclo'] + "-" + miembro['codseccion'];
                //visible=(miembro['ACTIVO']=="NO") ? "<span class='badge badge-danger'>" + "NO" + "</span>":"<span class='badge badge-success'>" + "SI" + "</span>";;
                cambiarCarga = "<a href='#' class='mx-1' onclick='vw_abrir_modal_cambiarCargaDivision($(this));return false;'><i class='fas fa-cog'></i></a>";
                eliminar = "<a href='#' onclick='fn_desenrolar($(this))'><i class='fas fa-trash-alt text-danger'></i></a>";
                var fila_enr = tbenrolados.row.add([index + 1, miembro['sede_abrevia'], miembro['carnet'], sexo + estudiante, grupo, cambiarCarga + eliminar]).node();
                $(fila_enr).attr('data-idmiembro64', miembro['idmiembro64']);
                $(fila_enr).attr('data-estudiante', estudiante);
            });
            tbenrolados.draw();
            tbevaluaciones.draw();

        },
        error: function(jqXHR, exception) {
            $('#modEnrolados .modEnrolados_content #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                type: 'error',
                title: 'ERROR, NO se guardó cambios',
                text: msgf,
                backdrop: false,
            });
        },
    });
    return false;
}

function fn_desenrolar() {
    $('#modEnrolados .modEnrolados_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    tbmiembros = $('#tbce_dtEstutiantesEnrolados').DataTable();
    fila = tbmiembros.$('tr.selected');
    //fila=boton.closest('tr');
    idmiembro64 = fila.data('idmiembro64');

    alumno = fila.data('estudiante');
    //************************************
    Swal.fire({
        title: "Precaución",
        text: "Se eliminarán las notas y asistencias del estudiante " + alumno + ", registradas en esta unidad didáctica ",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + "miembros/fn_eliminar",
                type: 'post',
                dataType: 'json',
                data: {
                    "fm-idmiembro": idmiembro64
                },
                success: function(e) {
                    $('#modEnrolados .modEnrolados_content #divoverlay').remove();
                    if (e.status == true) {
                        fila.remove();
                        //tbmiembros.draw
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
                    $('#modEnrolados .modEnrolados_content #divoverlay').remove();
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
            $('#modEnrolados .modEnrolados_content #divoverlay').remove();
        }
    });
};

function fn_fusionar(btn) {
   $('#modFusionar .modFusionar_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

    tbmiembros = $('#tbc_dtCargaAcademica_fusion').DataTable();
    // fila = tbmiembros.$('tr.selected');
    fila = btn.closest('.cfila_f');
    //fila=boton.closest('tr');
    codcarga64_fusion=fila.data('codcarga64');
    division64_fusion=fila.data('division64');
    codcarga64_original=$('#vw_mdfs_txtcodcarga').val();
    division64_original=$('#vw_mdfs_txtdivision').val();



    carga = fila.data('estudiante');
    //************************************
    Swal.fire({
        title: "Precaución",
        text: "Estas seguro de fusionar las aulas? ",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, fusionar!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + "cargasubseccion/fn_fusionar",
                type: 'post',
                dataType: 'json',
                data: {
                    "fs-codcarga64_fusion" : codcarga64_fusion,
                    "fs-division64_fusion" : division64_fusion,
                    "fs-codcarga64_original" : codcarga64_original,
                    "fs-division64_original" : division64_original,
                },
                success: function(e) {
                    $('#modFusionar .modFusionar_content #divoverlay').remove();
                    if (e.status == true) {
                        fila.remove();
                        //tbmiembros.draw
                        $('#divcard-matricular #divoverlay').remove();
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: 'Éxito,  realizado',
                            text: e.msg,
                            backdrop: false,
                        })
                    } else {
                        $('#modFusionar .modFusionar_content #divoverlay').remove();
                        Swal.fire({
                            type: 'error',
                            icon: 'error',
                            title: 'Error, NO se pudo realizar la eliminación',
                            text: e.msg,
                            backdrop: false,
                        })
                    }
                },
                error: function(jqXHR, exception) {
                    $('#modFusionar .modFusionar_content #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Error, NO se pudo realizar la eliminación',
                        text: e.msgf,
                        backdrop: false,
                    })
                }
            })
        } else {
            $('#modFusionar .modFusionar_content #divoverlay').remove();
        }
    });
};
/*$('#myModal').on('hidden.bs.modal', function (e) {

})*/
function fn_asignar_metodo(boton) {
    fila = boton.closest('.cfila');
    codmetodo64 = fila.data('codmetodo64');
    metodo = fila.data('metodo');
    codcarga64 = $("#vw_cme_txtcodcarga").val();
    division64 = $("#vw_cme_txtcoddivision").val();
    $('#modCambiarCalculo .modcambiarCalculo_content').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'cargasubseccion/fn_cambiar_metodo_calculo',
        type: 'post',
        dataType: 'json',
        data: {
            "codcarga": codcarga64,
            "division": division64,
            "metodo": codmetodo64,
        },
        success: function(e) {
            $('#modCambiarCalculo .modcambiarCalculo_content #divoverlay').remove();
            if (e.status == true) {
                $("#modCambiarCalculo").modal("hide");
                $("#vw_cme_spnMetodo").html(metodo);
            }
        },
        error: function(jqXHR, exception) {
            $('#modCambiarCalculo .modcambiarCalculo_content #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                type: 'error',
                title: 'ERROR, NO se guardó cambios',
                text: msgf,
                backdrop: false,
            });
        },
    });
    return false;
}


function fn_miembro_update_CargaDivision(btn) {

  tbmiembros = $('#tbce_dtEstutiantesEnrolados').DataTable();
  fila = tbmiembros.$('tr.selected');
    //fila=boton.closest('tr');
  idmiembro64 = fila.data('idmiembro64');

  alumno = fila.data('estudiante');



  //vw_md_ccd_btguardar

    codcarga = $("#vw_md_ccd_txtcarga").val();
    division = $("#vw_md_ccd_txtdivision").val();
    $('#modCambiarCargaDivision .modCambiarCargaDivision_content').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'miembros/fn_update_carga_division',
        type: 'post',
        dataType: 'json',
        data: {
            "fm-codcarga": codcarga,
            "fm-division": division,
            "fm-idmiembro": idmiembro64,
        },
        success: function(e) {
            $('#modCambiarCargaDivision .modCambiarCargaDivision_content #divoverlay').remove();
            if (e.status == true) {
                 fila.remove();
                  $("#modCambiarCargaDivision").modal("hide");
            }
        },
        error: function(jqXHR, exception) {
            $('#modCambiarCargaDivision .modCambiarCargaDivision_content #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                type: 'error',
                title: 'ERROR, NO se guardó cambios',
                text: msgf,
                backdrop: false,
            });
        },
    });
    return false;
}


$("#vw_md_doc_guardar").click(function(event) {
    $('#divcontent_docentes').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var docsel=$("#vw_md_doc_docentes").val();
    vcarga=$("#vw_md_doc_txtcarga").val();
    jsnombreDocente=$( "#vw_md_doc_docentes option:selected" ).text();
    vgrupo=$("#vw_md_doc_txtdivision").val();
    
    $.ajax({
            url: base_url + 'cargasubseccion/fn_cambiardocente',
            type: 'POST',
            data: {"fca-txtcoddocente": docsel ,"fca-txtsubseccion": vgrupo ,"fca-txtcodcarga": vcarga},
            dataType: 'json',
            success: function(e) {
              $('#divcontent_docentes #divoverlay').remove();
              if (e.status==true){
                
                if (docsel=='00000'){
                  btn_editdocente.closest(".fdivision").find('.spandocente').html("SIN DOCENTE");
                }
                else{
                  btn_editdocente.closest(".fdivision").find('.spandocente').html(jsnombreDocente);
                  /*setInterval(function(){ 
                  btn.parent().css("border", "0px solid #f37736").animate({'borderWidth': '1px',  'borderColor': 'red'},500);
              }, 2000);*/
                }
                $("#md_docentes").modal("hide");
              }
              else{
                Toast.fire({
              type: 'danger',
              title: 'Error: ' + e.msg
            });

              }
            },
            error: function(jqXHR, exception) {
              $(this).bootstrapToggle('off');
              $('#divcontent_docentes #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
            }
        })

  });

<?php if ($p66 == "SI"): ?>
    $('.checkOpen').bootstrapToggle();
    function fn_abrir_cerrar_curso(btn){

        //var fila_carga=btn.closest(".fcarga");
        var fila_division=btn.closest(".fdivision");

        var vcarga=fila_division.data("codcarga64");
        var vdivision=fila_division.data("division64");
        alert(btn.prop('checked'));
        if (btn.prop('checked') == false) {

          $('#divcard_cursos','#divcard-cargaAcademica').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
          $('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + 'cargasubseccion/fn_culminar_carga_subseccion',
                type: 'post',
                dataType: 'json',
                data: {"idcarga": vcarga,"division":vdivision},
                success: function(e) {
                    $('#divcard_cursos #divoverlay','#divcard-cargaAcademica #divoverlay').remove();
                    $('#divcard_grupo #divoverlay').remove();
                    if (e.status == true) {
                        
                    } else {
                        btn.bootstrapToggle('destroy');
                        btn.prop('checked', true);
                        btn.bootstrapToggle();
                        Toast.fire({
                            type: 'danger',
                            title: 'Error: ' + e.msg
                        });
                    }
                },
                error: function(jqXHR, exception) {
                  //alert("dd");
                    btn.bootstrapToggle('destroy');
                    btn.prop('checked', true);
                    btn.bootstrapToggle();
                    $('#divcard_cursos #divoverlay','#divcard-cargaAcademica #divoverlay').remove();
                    $('#divcard_grupo #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se pudo culminar',
                        text: msgf,
                        backdrop:false,
                    });
                }
            });
        } else {
          $('#divcard_cursos','#divcard-cargaAcademica').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
          $('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + 'curso/fn_curso_reabrir',
                type: 'post',
                dataType: 'json',
                data: {"idcarga": vcarga,"division":vdivision},
                success: function(e) {
                    $('#divcard_cursos #divoverlay').remove();
                    $('#divcard_grupo #divoverlay').remove();
                    if (e.status == true) {

                    } else {
                      btn.bootstrapToggle('destroy');
                      btn.prop('checked', false);
                      btn.bootstrapToggle();
                        Toast.fire({
                            type: 'danger',
                            title: 'Error: ' + e.msg
                        });
                    }
                },
                error: function(jqXHR, exception) {
                     btn.bootstrapToggle('destroy');
                    btn.prop('checked', false);
                    btn.bootstrapToggle();
                    $('#divcard_cursos #divoverlay','#divcard-cargaAcademica #divoverlay').remove();
                    $('#divcard_grupo #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se pudo culminar',
                        text: msgf,
                        backdrop:false,
                    });
                }
            });
        }
    };
  <?php endif ?>

  <?php if ($p67 == "SI"): ?>
    $('.checkOcultar').bootstrapToggle();
    $(".checkOcultar").change(function(event) {
      btn=$(this);
        //var fila_carga=btn.closest(".fcarga");
        var fila_division=btn.closest(".fdivision");

        var vcarga=fila_division.data("codcarga64");
        var vdivision=fila_division.data("division64");
        var chekear=btn.prop('checked') 
        

        $('#divcard_cursos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
          $.ajax({
              url: base_url + 'curso/fn_curso_ocultar',
              type: 'post',
              dataType: 'json',
              data: {"idcarga": vcarga,"division":vdivision,"accion":!chekear},
              success: function(e) {
                  $('#divcard_cursos #divoverlay').remove();
                  $('#divcard_grupo #divoverlay').remove();
                  if (e.status == true) {
                      
                  } else {
                      btn.bootstrapToggle('destroy');
                    btn.prop('checked', !chekear);
                    btn.bootstrapToggle();
                      Toast.fire({
                          type: 'danger',
                          title: 'Error: ' + e.msg
                      });
                  }
              },
              error: function(jqXHR, exception) {
                //alert("dd");
                  btn.bootstrapToggle('destroy');
                  btn.prop('checked', !chekear);
                  btn.bootstrapToggle();
                  $('#divcard_cursos #divoverlay').remove();
                  $('#divcard_grupo #divoverlay').remove();
                  var msgf = errorAjax(jqXHR, exception, 'text');
                  Swal.fire({
                      type: 'error',
                      title: 'ERROR, NO se pudo culminar',
                      text: msgf,
                      backdrop:false,
                  });
              }
          });
      
    });
  <?php endif ?>


</script>