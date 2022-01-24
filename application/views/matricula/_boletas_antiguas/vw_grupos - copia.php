<?php $vbaseurl=base_url() ?>
<!--<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">-->
<div class="content-wrapper">
  <div class="modal fade" id="modal-addalumno" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
       <div class="modal-content">
      
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Buscar Alumno</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        <div class="modal-body">
      
          <input id="vwg_md_periodo" type="hidden" class="form-control">
          <input id="vwg_md_carrera"  type="hidden" class="form-control">
          <input id="vwg_md_plan_nuevo"  type="hidden" class="form-control">
          <input id="vwg_md_ciclo"  type="hidden" class="form-control">
          <input id="vwg_md_seccion"  type="hidden" class="form-control">
          <input id="vwg_md_turno"  type="hidden" class="form-control">
          

          <label for="txtbus-alum">Apellidos y nombres</label>
          <div class="input-group">
            <input id="txt-buscaralumnos" name="txtbus-alum" type="text" class="form-control" value="">
            <span class="input-group-btn">
              <button class="btn btn-primary btn-md" type="button" id="btn-buscaralumnos">
              Ir <i class="fa fa-search" aria-hidden="true"></i></button>
            </span>
          </div>
          <br>
            <div id="divtabl-addamiembros" class="btable">
              <div class="thead col-12">
                <div class="row">
                  <div class="col-md-12">
                   ALUMNO
                  </div>
                  

                </div>
              </div>
              <div id="lista-alumnos" class="tbody col-12">
                  
              </div>
            </div>
     
          
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" class="btn pull-right" data-dismiss="modal">Terminar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>Grupos Matriculados</h1>
        </div>
      </div>
    </div>
  </section>
  <section id="s-cargado" class="content">
    <div id="divboxhistorial" class="card">
      <div class="card-body pb-1">
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
      </div>
      <div class="card-body pt-1">
        <div class="btable">
          <div class="thead col-12">
            <div class="row">
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-2 td">N°</div>
                  <div class="col-md-3 td">PERIODO</div>
                  <div class="col-md-7 td">PROG. ACAD.</div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="row">
                  <div class="col-md-3 td">PLAN</div>
                  <div class="col-md-9 td">GRUPO</div>
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
  </section>
</div>
<!--ript src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>-->
<script>
var per_vcxg='<?php echo getPermitido("41"); ?>'
var per_vmxg='<?php echo getPermitido("43"); ?>'
$("#frmfiltro-grupos").submit(function(event) {
    
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#div-filtro").html("");
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
          if (e.status==false){
          }
          else{
              var nro=0;
              var mt=0;
              var ac=0;
              var rt=0;
              var cl=0;
              $.each(e.vdata, function(index, v) {
                /* iterate through array or object */
                nro++;
                mt=mt + parseInt(v['mat']);
                ac=ac + parseInt(v['act']);
                rt=rt + parseInt(v['ret']);
                cl=cl + parseInt(v['cul']);
                var rowcolor=(nro % 2==0) ? 'bg-lightgray':'';
                var btn_carga='';
                var params='cp='+ v['codperiodo'] +'&cc='+ v['codcarrera'] + '&ccc='+ v['codciclo'] +'&ct='+ v['turno']+'&cs='+ v['seccion']+'&cpl='+ v['idplan'];
                 btnregeval='<a class="dropdown-item" href="' + base_url + 'academico/consulta/nomina-evaluaciones/excel?' + params + '&at=1'+'"><i class="fas fa-file-excel"></i> Evaluaciones</a>'; 
                 btnactaregmat='<a class="dropdown-item" href="' + base_url + 'academico/consulta/nomina-matricula/excel?' + params +'"><i class="fas fa-file-excel"></i> Matriculados</a>';

                 btnord_merito='<div class="td col-2 col-md-3 text-right text-primary"><a title="Orden de mérito" class="bg-primary text-white py-1 px-2 mt-2 rounded" target="_blank" href="' + base_url + 'academico/consulta/orden-merito/imprimir?' + params + '&at=1'+'"><i class="fas fa-user-graduate"></i><i class="fas fa-sort-numeric-up-alt"></i></a></div>' ;
                if (per_vcxg=='SI'){
                  
                  btn_carga='<div class="td col-2 col-md-3 text-right text-primary text-bold"><a title="Carga Académica" class="bg-primary text-white py-1 px-2 mt-2 rounded" target="_blank" href="' + base_url + 'gestion/academico/carga-academica/grupo?' + params +'"><i class="fas fa-book-open"></i></a></div>' ;
                }
                if (per_vmxg=='SI'){
                  //var params='cp='+ v['codperiodo'] +'&cc='+ v['codcarrera'] + '&ccc='+ v['codciclo'] +'&ct='+ v['turno']+'&cs='+ v['seccion']+'&cpl='+ v['idplan'];
                  btn_matriculas='<div class="td col-2 col-md-3 text-right text-primary text-bold"><a title="Listar matriculados" class="bg-primary text-white py-1 px-2 mt-2 rounded" target="_blank" href="' + base_url + 'gestion/academico/matriculas?' + params + '&at=1'+'"><i class="fas fa-user-graduate"></i></a></div>' ;
                }
                 btn_matricular='<div class="td col-2 col-md-3 text-right text-primary text-bold">' +
                 '<a data-periodo=' + v['codperiodo'] + ' data-carrera=' + v['codcarrera'] + ' data-ciclo=' + v['codciclo'] + ' data-turno=' + v['turno'] + ' data-seccion=' + v['seccion'] + ' data-plan=' + v['idplan'] + ' title="Agregar matrícula" class="bg-success text-white py-1 px-2 mt-2 rounded"  href="#" data-toggle="modal" data-target="#modal-addalumno"><i class="fas fa-user-plus"></i></i></a></div>' ;

                $("#div-filtro").append(
                '<div class="row ' + rowcolor + ' ">' + 
                  '<div class="col-12 col-md-3">' + 
                    '<div class="row">' + 
                      '<div class="col-3 col-md-2 td">' + nro + '</div>' +
                      '<div class="col-9 col-md-3 td">' + v['periodo'] + '</div>' + 
                      '<div class="col-8 col-md-7 td">' + v['carrera'] + '</div>' +
                    '</div>' + 
                  '</div>' + 
                  '<div class="col-6 col-md-2">' + 
                    '<div class="row">' + 
                      '<div class="col-2 col-md-3 td" title="' + v['plan']  +'">' + v['idplan'] + '</div>' + 
                      '<div class="col-2 col-md-9 td">' + v['ciclo'] + " - <b>" + v['turno'] + "</b> - " + v['seccion'] + '</div>' + 
                    '</div>' + 
                  '</div>' + 
                  '<div class="col-6 col-md-3">' + 
                    '<div class="row">' + 
                      '<div class="td col-2 col-md-3 text-right text-bold">' + v['mat'] + '</div>' + 
                      '<div class="td col-2 col-md-3 text-right text-primary text-bold">' + v['act'] + '</div>' + 
                      '<div class="td col-2 col-md-3 text-right text-danger text-bold">' + v['ret'] + '</div>' + 
                      '<div class="td col-2 col-md-3 text-right text-success text-bold">' + v['cul'] + '</div>' + 
                    '</div>' + 
                  '</div>' + 

                  '<div class="col-4 col-md-1 td p-0">' + 
                    '<div class="btn-group btn-sm p-0">' + 
                      '<button class="bg-success text-white rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                          'Actas' +
                      '</button>' +
                      '<div class="dropdown-menu">' +
                          btnactaregmat +
                          btnregeval +
                      ' </div>' +
                    '</div>' +
                  '</div>' +

                  '<div class="col-6 col-md-3">' + 
                    '<div class="row">' + 
                      
                      btn_carga +  btn_matriculas + btn_matricular +   btnord_merito + 
                    '</div>' + 
                  '</div>' + 
                '</div>');
                //btn btn-success btn-sm 
              });
                $("#div-filtro").append(
                '<div class="row text-bold">' + 
                  '<div class="col-4 col-md-5">' + 
                   
                  '</div>' + 
                  '<div class="col-6 col-md-3">' + 
                    '<div class="row">' + 
                      '<div class="td col-2 col-md-3 text-right text-bold">' + mt + '</div>' + 
                      '<div class="td col-2 col-md-3 text-right text-primary text-bold">' + ac + '</div>' + 
                      '<div class="td col-2 col-md-3 text-right text-danger text-bold">' + rt + '</div>' + 
                      '<div class="td col-2 col-md-3 text-right text-success text-bold">' + cl + '</div>' + 
                    '</div>' + 
                  '</div>' + 
                  '<div class="col-6 col-md-2">' + 
                    '<div class="row">' + 
                     
                    '</div>' + 
                  '</div>' + 
                '</div>');
              $('#divboxhistorial #divoverlay').remove();
          }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divboxhistorial #divoverlay').remove();
        }
    });
    return false;
});
$('#modal-addalumno').on('hide.bs.modal', function () {
    $("#frmfiltro-grupos").submit();
// do something…
})
$('#modal-addalumno').on('show.bs.modal', function (e) {
    var btn = $(e.relatedTarget)
    
    $("#vwg_md_periodo").val(btn.data('periodo'));
    $("#vwg_md_carrera").val(btn.data('carrera'));
    $("#vwg_md_plan_nuevo").val(btn.data('plan'));
    $("#vwg_md_ciclo").val(btn.data('ciclo'));
    $("#vwg_md_seccion").val(btn.data('seccion'));
    $("#vwg_md_turno").val(btn.data('turno'));
    $("#lista-alumnos").html("");
    
  });
$('#txt-buscaralumnos').keypress(function(event) {
      var keycode = event.keyCode || event.which;
    if(keycode == '13') {
      $('#btn-buscaralumnos').click();
    }
});

$("#btn-buscaralumnos").click(function(event) {
    $('#lista-alumnos').html('<center><h4 class="text-primary">Buscando</h4><br /><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span><center>');
    
    var vcarga=$("#vidcurso").val();
    var valumno=$("#txt-buscaralumnos").val();
    var vperiodo=$("#vwg_md_periodo").val();
    var vcarrera=$("#vwg_md_carrera").val();//$("#vidperiodo").val();
    //var vdivision=$("#vdivision").val();
    $.ajax({
              url: base_url + 'inscrito/fn_get_datos_matriculantes' ,
        type: 'post',
        dataType: 'json',
        data: {periodo:vperiodo,alumno:valumno,carrera:vcarrera},
        success: function(e) {
          var resultados="";
          if (e.status==true){
            
            $.each(e.vdata, function(index, val) {
               resultados=resultados + 
                          "<div class='row rowcolor'>"+
                            "<div class='col-10'>" +
                              "<div class='row'>" + 
                                "<div class='col-12 col-md-4 td'>" +
                                      "<span><b>" + val['carne'] + "</b></span>" +
                                "</div>" + 
                                "<div class='col-12 col-md-8 td'>" +
                                  "<span>" + val['paterno'] + " " + val['materno'] + " " + val['nombres'] + "</span>" +
                                "</div> " + 
                              "</div>" +
                            "</div>" +
                           
                            "<div class='col-2 text-center td'>" +
                             
                              "<a href='#' data-inscripcion='" + base64url_encode(val['idinscripcion']) + "' data-planold='" + val['codplan'] + "' onclick='vw_grupos_matricular($(this));event.preventDefault();' class='btn btn-primary btn-block btn-agregaralumno' title='Agregar'>" +
                                "<i class='fa fa-plus'></i><span class='d-none'> Agregar</span>" + 
                              "</a>" +

                            "</div>" +

                          "</div>";

            });
            if (resultados=="") resultados="<span class='text-danger'>No se encontraron resultados, comprueba que no este matriculado o que su inscripción sea ACTIVA</span>"
            $('#lista-alumnos').html(resultados);
          }
          else{
            $('#lista-alumnos').html(e.msg);
          }
          
        },
      error: function (jqXHR, exception) {
        var msgf=errorAjax(jqXHR, exception,'div');
      $('#lista-alumnos').html(msgf);
    },
      });
    return false;
  });
  
  function vw_grupos_matricular(boton){
    //var boton=$(this);/
    
    $(".btn-agregaralumno").addClass('disabled');

    var fmtxtid= boton.data('inscripcion');
    var fmcbtipo='O';
    var fmcbbeneficio="1";
    var fmcbperiodo=$("#vwg_md_periodo").val();
    var fmtxtcarrera=$("#vwg_md_carrera").val();
    var fmtxtplan=boton.data('planold');
    var fmcbplan=$("#vwg_md_plan_nuevo").val();
    var fmcbciclo=$("#vwg_md_ciclo").val();
    var fmcbturno=$("#vwg_md_turno").val();
    
    var fmcbseccion=$("#vwg_md_seccion").val();
    var fmtxtfecmatricula="0";
    var fmtxtcuota="0";
    var fmtxtobservaciones="";
    //codcarga codmatricula division idmiembro
    boton.html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
    $.ajax({
      url: base_url + 'matricula/fn_insert',
      type: 'post',
      dataType: 'json',
      data: {
    "fm-txtid": fmtxtid,
    "fm-cbtipo": fmcbtipo,
    "fm-cbbeneficio": fmcbbeneficio,
    "fm-cbperiodo": fmcbperiodo,
    "fm-txtcarrera": fmtxtcarrera,
    "fm-cbplan": fmcbplan,
    "fm-txtplan": fmtxtplan,
    "fm-cbciclo": fmcbciclo,
    "fm-cbturno": fmcbturno,
    "fm-cbseccion": fmcbseccion,
    "fm-txtfecmatricula": fmtxtfecmatricula,
    "fm-txtcuota": fmtxtcuota,
    "fm-txtobservaciones": fmtxtobservaciones},
      success: function(e) {
        $(".btn-agregaralumno").removeClass('disabled');
        if (e.status==true){
           boton.hide();
        }
        else{
            boton.html('<i class="fa fa-plus"></i><span class="d-none"> Agregar</span>');
        }
      },
      error: function (jqXHR, exception) {
        var msgf=errorAjax(jqXHR, exception,'div');
        boton.html('<i class="fa fa-plus"></i><span class="d-none"> Agregar</span>');
        return false;
      },
    });
    return false
  };



  </script>



