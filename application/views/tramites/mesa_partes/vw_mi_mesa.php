<?php $vbaseurl=base_url() ?>
<div class="content-wrapper">
  <div class="modal fade vw_mpa_lista_md_ver_datos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detalle</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>MESA DE PARTES
          <small></small></h1>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div id="divcard-general" class="card">
      <div class="card-header ">
        <h3 class="card-title">Mis Solicitudes</h3>
        <div class="card-tools">
          <a href='<?php echo "{$vbaseurl}tramites/mesa-de-partes/agregar"  ?>' class="btn btn-primary  btn-sms">
            <i class="fas fa-plus mr-1"></i> Nuevo Trámite
          </a>
          
        </div>
      </div>
      
      <div class="card-body">
        <div class="btable">
          <div class="thead col-12  d-none d-md-block">
            <div class="row">
              <div class='col-12 col-md-1'>
                <div class='row'>
                  <div class='col-2 col-md-4 td'>N°</div>
                  <div class='col-10 col-md-8 td text-center'>COD</div>
                </div>
              </div>
              <div class='col-12 col-md-4 td'>
                TRÁMITE
              </div>
              <div class='col-12 col-md-4 td '>
                RESPONDER A
               
              </div>
              <div class='col-12 col-md-2 td text-center'>
                
                SITUACIÓN
                
              </div>
               <div class='col-12 col-md-1 td text-center'>
                
                SEGUIMIENTO
                
              </div>
            </div>
          </div>
          <div class="tbody col-12">
             <?php
             $nro=0;
          foreach ($solicitudes as $key => $sol) {
            $cod64=base64url_encode($sol->codsolicitud);
            
            $nro++;
            if ($sol->situacion=="PENDIENTE") {
            $bgcolorsituacion="bg-warning";
            
            }
            else if ($sol->situacion=="RECHAZADO") {
            $bgcolorsituacion="bg-danger";
            
            }
            else if ($sol->situacion=="ATENDIDO") {
            $bgcolorsituacion="bg-success";
            
            }
            else if ($sol->situacion=="DERIVADO") {
              $bgcolorsituacion="bg-info";
              
            }
          echo
          "<div class='row rowcolor'>
              <div class='col-12 col-md-1'>
                <div class='row'>
                  <div class='col-2 col-md-4 td'>$nro</div>
                  <div class='col-10 col-md-8 td text-center'><a href='{$vbaseurl}tramites/mesa-de-partes/detalle?cmp=".base64url_encode($sol->codsolicitud)."' >".str_pad($sol->codsolicitud, 4, "0", STR_PAD_LEFT)."</a></div>
                </div>
              </div>
              <div class='col-12 col-md-4 td'>
                $sol->tramite <br>
                $sol->asunto
              </div>
              <div class='col-12 col-md-4 td '>
                <i class='fas fa-at mr-1'></i> $sol->email_personal <br>
                <i class='fas fa-at mr-1'></i> $sol->email_corporativo
              </div>
              <div class='col-12 col-md-2 td text-center'>
                <span class='tboton $bgcolorsituacion'>$sol->situacion<span>
              </div>
              <div class='col-12 col-md-1 td text-center'>
                <button type='button' data-seguimiento='$cod64'  class='btn btn-primary vw_mpa_lista_btn_ver_ruta'><i class='fas fa-search'></i></button>
              </div>
            </div>";
          }
          ?>
          </div>
          
        </div>
      </div>
    </div>
  </section>
</div>
<!-- /.content-wrapper -->
<!--<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>-->
<!--<script src="<?php echo base_url();?>resources/jquery/pages.js"></script>-->
<script type="text/javascript" charset="utf-8">
    $('.vw_mpa_lista_btn_ver_ruta').click(function(event) {
      $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      var seg = $(this).data('seguimiento');
      $.ajax({
          url: base_url + 'mesa_partes/vw_administrativo_ajax_solicitud_ruta',
          type: 'post',
          dataType: 'json',
          data: {
              seguimiento: seg
          },
          success: function(e) {
              $('#divcard-general #divoverlay').remove();
              
              $('.vw_mpa_lista_md_ver_datos .modal-title').html('SEGUIMIENTO');
              if (e.status == false) {
                  $('.vw_mpa_lista_md_ver_datos .modal-body').html(e.msg);
              } else {
                  $('.vw_mpa_lista_md_ver_datos .modal-body').html(e.datos);
              }
              $('.vw_mpa_lista_md_ver_datos').modal('show')
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'div');
              $('#divcard-general #divoverlay').remove();
              $('.vw_mpa_lista_md_ver_datos .modal-body').html(msgf);
              $('.vw_mpa_lista_md_ver_datos').modal('show')
          },
      });
  });




    //**********************************************************/
$('#busca_alumno').click(function() {
var tcarc=$('#txtbusca_carne').val();
searchc(tcarc);
return false;
});
$('#txtbusca_carne').keypress(function(event) {
var keycode = event.keyCode || event.which;
if(keycode == '13') {
searchc($('#txtbusca_carne').val());
}
});
$('#txtbusca_apellnom').keypress(function(event) {
var keycode = event.keyCode || event.which;
if(keycode == '13') {
$('#busca_apellnom').click();
}
});
function searchc(tcar){
$('#divmatriculados').html("");
$('#divdatosmat').html("");
var cbper=$('#vw_acad_cbperiodo').val();
$('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
$.ajax({
url: base_url + 'matricula/vwcurso_x_periodo_carne' ,
type: 'post',
dataType: 'json',
data: {txtbusca_carne: tcar,cbperiodo: cbper},
success: function(e) {
$('#divcard-general #divoverlay').remove();
if (e.status == false) {
var msgf='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg +'</div>';
$('#divmiscursos').html(msgf);
}
else {
$('#divdatosmat').html(e.alumno);
$('#divmiscursos').html(e.miscursos);
}
},
error: function (jqXHR, exception) {
var msgf=errorAjax(jqXHR, exception,'div');
$('#divcard-general #divoverlay').remove();
$('#divmiscursos').html(msgf);
},
});
return false;
}
$('#busca_apellnom').click(function() {
$('#divmiscursos').html("");
$('#divdatosmat').html("");
var tcar=$('#txtbusca_apellnom').val();
var cbper=$('#vw_acad_cbperiodo').val();
$('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
$.ajax({
url: base_url + 'matricula/vw_matriculados' ,
type: 'post',
dataType: 'json',
data: {txtbusca_apellnom: tcar,cbperiodo: cbper},
success: function(e) {
$('#divcard-general #divoverlay').remove();
if (e.status == false) {
var msgf='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg +'</div>';
$('#divmatriculados').html(msgf);
}
else {
$('#divmatriculados').html(e.matriculados);
}
},
error: function (jqXHR, exception) {
var msgf=errorAjax(jqXHR, exception,'div');
$('#divcard-general #divoverlay').remove();
$('#divmatriculados').html(msgf);
},
});
return false;
});
$(document).ready(function() {
var vtab = getUrlParameter('tb', "a");
if (vtab == "e") {
$('.nav-pills a[href="#tab-encuestas"]').tab('show');
} else {
$('.nav-pills a[href="#tab-academico"]').tab('show');
}
$('.nav-pills a').on('shown.bs.tab', function(event) {
if (history.pushState) {
var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?tb=' + $(event.target).data('vartab');
window.history.pushState({
path: newurl
}, '', newurl);
}
});
});
$("#busca_encuestas").click(function(event) {
$('input:text,select').removeClass('is-invalid');
$('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
$("#div-encucreadas").html("");
var codper=$("#vw_encu_cbperiodo").val();
$.ajax({
url: base_url + 'cuestionario_general/fn_get_cuestionarios_creador_observador'  ,
type: 'post',
dataType: 'json',
data: {"vw_encu_cbperiodo":codper} ,
success: function(e) {
if (e.status == false) {
$.each(e.errors, function(key, val) {
$('#' + key).addClass('is-invalid');
$('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
});
}
else {
var nro=0;
$.each(e.encucreadas, function(index, v) {
/* iterate through array or object */
nro++;
/*mt = mt + parseInt(v['mat']);
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
}*/
var btn_editar='<a class="dropdown-item" href="' + base_url + 'monitoreo/estudiantes/encuesta/editar/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="fas fa-edit"></i> Editar</a>';
var btn_poblacion='<a class="dropdown-item" href="' + base_url + 'monitoreo/estudiantes/encuesta/poblacion/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="fas fa-user-friends"></i> Población</a>';
var btn_preguntas='<a class="dropdown-item" href="' + base_url + 'monitoreo/estudiantes/encuesta/preguntas/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="far fa-question-circle"></i> Preguntas</a>';
//btnord_merito='<a  href="' + base_url + 'academico/consulta/orden-merito/imprimir?' + params + '&at=1'+'"><i class="fas fa-sort-numeric-up-alt mr-1"></i> Mérito</a>';
$("#div-encucreadas").append(
'<div class="cfila row">' +
  '<div class="col-12 col-md-3">' +
    '<div class="row">' +
      '<div class="col-2 col-md-2 td">' + nro + '</div>' +
      '<div class="col-4 col-md-4 td">' + v['periodo'] + '</div>' +
      '<div class="col-6 col-md-6 td">' + v['nombre'] + '</div>' +
    '</div>' +
  '</div>' +
  '<div class="col-12 col-md-3">' +
    '<div class="row">' +
      '<div class="col-4 col-md-4 td">' + v['objetivo'] + '</div>' +
      '<div class="col-8 col-md-8 td">' + v['descripcion'] + '</div>' +
    '</div>' +
  '</div>' +
  
  '<div class="col-12 col-md-3">' +
    '<div class="row">' +
      '<div class="col-4 col-md-4 td">' + v['creado'] + '</div>' +
      '<div class="col-4 col-md-4 td">' + v['inicia'] + '</div>' +
      '<div class="col-4 col-md-4 td">' + v['vence'] + '</div>' +
    '</div>' +
  '</div>' +
  '<div class="col-12 col-md-3">' +
    '<div class="row">' +
      '<div class="col-4 col-md-6 td">' +
        v['estado'] +
      '</div>' +
      '<div class="col-4 col-md-6 td text-right">' +
        '<div class="btn-group btn-group-sm" role="group">' +
          '<button class="bg-primary p-1 text-white rounded border-0 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
          ' Opciones' +
          '</button>' +
          '<div class="dropdown-menu dropdown-menu-right">' +
            btn_editar +
            '<div class="dropdown-divider"></div>' +
            btn_preguntas +
            btn_poblacion +
          ' </div>' +
        '</div>' +
      '</div>' +
    '</div>' +
  '</div>' +
  
  
'</div>');
});
}
$('#divcard-general #divoverlay').remove();
},
error: function(jqXHR, exception) {
var msgf = errorAjax(jqXHR, exception, 'text');
$('#divcard-general #divoverlay').remove();
//$('#divError').show();
//$('#msgError').html(msgf);
}
});
return false;
});
</script>