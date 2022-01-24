<?php $vbaseurl = base_url();
 ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
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
  <div class="modal fade vw_mpa_lista_md_rec-der-rec" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">ACCIÓN</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="vw_mpa_lista_form-ejecutar" action="<?php echo $vbaseurl ?>mesa_partes/fn_insert" method="post" accept-charset="utf-8">
            <input name="vw_mpae_txt_seguimiento" id="vw_mpae_txt_seguimiento" type="hidden" value="">
            <input name="vw_mpae_txt_ruta" id="vw_mpae_txt_ruta" type="hidden" value="">
            <div class="col-12">
            <div class="form-group row">
              <label class="col-md-2 col-form-label-sm ">Acción:</label>
              <select class="form-control col-md-5 form-control-sm" name="vw_mpae_cb_ejecutar" id="vw_mpae_cb_ejecutar">
                <option value="RECIBIDO">RECIBIR</option>
                <option value="RECHAZADO">RECHAZAR</option>
                <option value="DERIVADO">DERIVAR</option>
              </select>
            </div>
            
            <div id="vw_mpae_div_derivar" >
              <div class="row">
                <label class="col-md-2 col-form-label-sm ">Area:</label>
                <select class="form-control col-md-6 form-control-sm" name="vw_mp_cb_area" id="vw_mp_cb_area">
                  <option value="0">[--Seleccionar--]</option>
                  <?php
                  foreach ($areas as $area) {
                    echo '<option value="'.base64url_encode($area->codarea).'">'.$area->nombre.'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="row">
                <label class="col-md-2 col-form-label-sm ">Atención a:</label>
                <select class="form-control col-md-8 form-control-sm" name="vw_mp_cb_usuario" id="vw_mp_cb_usuario">
                  <option value="0">[--Seleccionar--]</option>
                  <?php
                  foreach ($administrativos as $administrativo) {
                    $iduser=base64url_encode($administrativo->idusuario);
                    echo "<option value='$iduser'>$administrativo->paterno $administrativo->materno $administrativo->nombres</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <div id="vw_mpae_div_descripcion">
              <textarea class="vw_mpae_txt_summernote" id="vw_mpae_txt_descripcion" name="vw_mpae_txt_descripcion">
              
              </textarea>
            </div>
            </div>
            
            
            
          </form>
        </div>
        <div class="modal-footer">
          <button id="vw_mpae_lista_md_btn-accionar" type="button" class="btn btn-primary" data-dismiss="modal">Guardar </button>
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
        <div class="row">
            <label class=" col-md-2 col-form-label-sm">Asunto de la solicitud:</label>
            <input id="vw_mp_txt_asunto" name="vw_mp_txt_asunto" type="text" class="form-control form-control-sm col-md-10 " maxlength="200" minlength="5">
            <small class="col-md-12 text-primary text-right">Caracteres restantes: <span id="vw_mp_sm_conteo" >200</span></small>
        </div>
        <div class="card-tools">
          <a href='<?php echo "{$vbaseurl}tramites/mesa-de-partes/agregar"  ?>' class="btn btn-primary  btn-sms">
            <i class="fas fa-plus mr-1">Agregar</i>
          </a>
          
        </div>
      </div>
      
      <div class="card-body">

        <div class="btable">
          <div class="thead col-12  d-none d-md-block">
            <div class="row">
              <div class='col-12 col-md-2'>
                <div class='row'>
                  <div class='col-2 col-md-2 td'>N°</div>
                  <div class='col-10 col-md-10 td text-center'>ORIGEN</div>
                </div>
              </div>
              <div class='col-12 col-md-2 td '>
                SOLICITANTE
                
              </div>
              <div class='col-12 col-md-4 td'>
                TRÁMITE
              </div>
              <div class='col-12 col-md-1 td text-center'>
                VER
              </div>
              <div class='col-12 col-md-1 td text-center'>
                
                SEGUIMIENTO
                
              </div>
              <div class='col-12 col-md-1 td text-center'>
                
                SITUACIÓN
                
              </div>
              <div class='col-12 col-md-1 td text-center'>
                
                ACCIÓN
                
              </div>
            </div>
          </div>
          <div class="tbody col-12">
            <?php
            $nro=0;
            date_default_timezone_set('America/Lima');
            foreach ($solicitudes as $key => $sol) {
            $cod64=base64url_encode($sol->codsolicitud);
            $rut64=base64url_encode($sol->codruta);
            $nro++;
            if ($sol->situacion_ruta=="PENDIENTE") {
            $bgcolorsituacion="bg-warning";
            $btn_accion="<button type='button' data-seguimiento='$cod64' data-ruta='$rut64'  class='btn btn-warning vw_mpa_lista_btn_recibir' data-toggle='tooltip' data-placement='top' title='Recibir o Rechazar'><i class='fas fa-hourglass-end'></i></button>";
            }
            else if ($sol->situacion_ruta=="RECHAZADO") {
            $bgcolorsituacion="bg-danger";
            $btn_accion="<button type='button' data-seguimiento='$cod64' data-ruta='$rut64'  class='btn btn-warning vw_mpa_lista_btn_recibir' data-toggle='tooltip' data-placement='top' title='Recibir'><i class='far fa-share-square'></i></button>";
            }
            else if ($sol->situacion_ruta=="RECIBIDO") {
            $bgcolorsituacion="bg-success";
            $btn_accion="<button type='button' data-seguimiento='$cod64' data-ruta='$rut64'  class='btn btn-primary vw_mpa_lista_btn_recibir' data-toggle='tooltip' data-placement='top' title='Derivar'><i class='far fa-share-square'></i></button>";
            }
            else if ($sol->situacion_ruta=="DERIVADO") {
              $bgcolorsituacion="bg-info";
              $btn_accion="";
            }
            
            
            echo
            "<div class='row rowcolor'>
              <div class='col-12 col-md-2'>
                <div class='row'>
                  <div class='col-2 col-md-2 td'>$nro</div>
                  <div class='col-10 col-md-10 td text-center'>
                    Seguimiento: <a href='{$vbaseurl}gestion/tramites/mesa-de-partes/detalle?cmp=$cod64' >
                    MV".str_pad($sol->codsolicitud, 4, "0", STR_PAD_LEFT)."</a><br>
                    $sol->area_origen<br>
                    Fecha:$sol->fecha
                  </div>
                </div>
              </div>
              <div class='col-12 col-md-2 td '>
                $sol->tipodoc - $sol->nrodoc <br>
                $sol->solicitante <br>
              </div>
              <div class='col-12 col-md-4 td'>
                <a href='{$vbaseurl}gestion/tramites/mesa-de-partes/detalle?cmp=$cod64'>$sol->tramite</a>
                <br>
                $sol->asunto
              </div>
              <div class='col-12 col-md-1 td text-center'>
                <button type='button' data-seguimiento='$cod64'  class='btn btn-primary vw_mpa_lista_btn_ver'><i class='fas fa-search'></i></button>
              </div>
              <div class='col-12 col-md-1 td text-center'>
                <button type='button' data-seguimiento='$cod64'  class='btn btn-primary vw_mpa_lista_btn_ver_ruta'><i class='fas fa-search'></i></button>
              </div>
              <div class='col-12 col-md-1 pt-2 td text-center'>
                <small class='tboton $bgcolorsituacion '>$sol->situacion_ruta</small>
                </div>
                <div class='col-12 col-md-1 td text-center'>
                  $btn_accion
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
  <?php
  echo
  "<script src='{$vbaseurl}resources/plugins/summernote8/summernote-bs4.min.js'></script>
  <script src='{$vbaseurl}resources/plugins/summernote8/lang/summernote-es-ES.js'></script>";
  //<script src='{$vbaseurl}resources/dist/js/pages/portalweb.js'></script>";
  ?>
  <!-- /.content-wrapper -->
  <!--<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>-->
  <!--<script src="<?php echo base_url();?>resources/jquery/pages.js"></script>-->
  <script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
      $("#vw_mpae_div_descripcion").hide();
      $("#vw_mpae_div_derivar").hide();
      $('.vw_mpae_txt_summernote').summernote({
          height: 150,
          placeholder: 'Escriba Aquí ...!',
          dialogsFade: true,
          lang: 'es-ES',
          toolbar: [
              ['font', ['bold', 'italic', 'underline', 'clear']],

              ['insert', ['link', 'hr']],
              ['view', ['codeview']],
          ],
      });
       $.summernote.dom.emptyPara = "<div><br></div>"
  });
  $("#vw_mpae_cb_ejecutar").change(function(event) {
      var cbval = $(this).val();
      $("#vw_mp_cb_area").val("0");
      $("#vw_mp_cb_usuario").val("0");
      if (cbval == "RECIBIDO") {
          $("#vw_mpae_div_descripcion").hide();
      } 
      else if (cbval == "RECHAZADO") {
          $("#vw_mpae_div_descripcion").show();
      }
      else if (cbval == "DERIVADO") {
          $("#vw_mpae_div_descripcion").show();
          $("#vw_mpae_div_derivar").show();
      }
  });
  //vw_mpa_lista_md_ver_datos
  $('.vw_mpa_lista_btn_ver').click(function(event) {
      $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      var seg = $(this).data('seguimiento');
      $.ajax({
          url: base_url + 'mesa_partes/vw_administrativo_ajax_solicitud_detalle',
          type: 'post',
          dataType: 'json',
          data: {
              seguimiento: seg
          },
          success: function(e) {
              $('#divcard-general #divoverlay').remove();
              $('.vw_mpa_lista_md_ver_datos .modal-title').html('DETALLE');
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


  $('.vw_mpa_lista_btn_recibir').click(function(event) {
      $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      var seg = $(this).data('seguimiento');
      var rut = $(this).data('ruta');
      $('#vw_mpae_txt_seguimiento').val(seg);
      $('#vw_mpae_txt_ruta').val(rut);
      $('.vw_mpa_lista_md_rec-der-rec').modal('show');
      $('#divcard-general #divoverlay').remove();
  });
  $('#vw_mpae_lista_md_btn-accionar').click(function(event) {
      $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      /*var seg = $(this).data('seguimiento');
      var seg = $(this).data('seguimiento');
      vw_mpa_cb_ejecutar*/
      var datos = $("#vw_mpa_lista_form-ejecutar").serialize();
      $.ajax({
          url: base_url + 'mesa_partes/fn_administrativo_ejecutar',
          type: 'post',
          dataType: 'json',
          data: datos,
          success: function(e) {
              $('#divcard-general #divoverlay').remove();
              if (e.status == false) {
                  
              } else {
                  
                  //location.reload();
              }
              
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'div');
              $('#divcard-general #divoverlay').remove();
              $('.vw_mpa_lista_md_ver_datos .modal-body').html(msgf);
              $('.vw_mpa_lista_md_ver_datos').modal('show')
          },
      });
  });

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