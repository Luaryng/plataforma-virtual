<style>
.form-title{
background-color: black;
color: white;
padding: 5px 0px 5px 10px;
margin: 25px -10px 25px -10px;
font-size: 16px;
}
#vw_mpc_pgBar {
background-color: #3E6FAD;
width: 0px;
height: 10px;
margin-top: 10px;
margin-bottom: 10px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
-o-border-radius: 5px;
border-radius: 5px;
-moz-transition: .25s ease-out;
-webkit-transition: .25s ease-out;
-o-transition: .25s ease-out;
transition: .25s ease-out;
}

.select2-container--default .select2-selection--multiple {
    border: 1px solid #ced4da !important;
    min-height: calc(2.25rem + 2px) !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: transparent !important;
    /*border-color: #006fe6 !important;*/
    border: 1px solid #bdc6d0 !important;
    color: #343a40 !important;
    padding: 0 10px !important;
    margin-top: .31rem !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    /*color: rgba(255,255,255,.7) !important;*/
    color: #bdc6d0;
    float: right !important;
    margin-left: 5px !important;
    margin-right: -2px !important;
}

</style>

<?php $vbaseurl = base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/select2/css/select2.min.css">
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
                <select class="form-control col-md-5 form-control-sm" data-sitruta='' name="vw_mpae_cb_ejecutar" id="vw_mpae_cb_ejecutar">
                  <option value='RECIBIDO'>RECIBIR</option>
                  
                  <?php if (getPermitido("68")=="SI") echo "<option value='RECHAZADO'>RECHAZAR</option>" ?>
                  <option value="DERIVADO">DERIVAR</option>
                  <option value='FINALIZADO'>FINALIZAR</option>
                </select>
              </div>
              
              <div id="vw_mpae_div_derivar" >
                <div class="row">
                  <label class="col-md-2 col-form-label-sm ">Area:</label>
                  <select class="form-control col-md-6 form-control-sm" name="vw_mpa_lista_cb_area" id="vw_mpa_lista_cb_area">
                    <option value="0">[--Seleccionar--]</option>
                    <?php
                    foreach ($areas as $area) {
                      if (($area->nombre=="EXTERIOR") && (getPermitido("68")=="NO") ){
                        //echo '<option value="'.base64url_encode($area->codarea).'">'.$area->nombre.'</option>';  
                      }
                      else{
                        $codtrabajador=base64url_encode($area->codencargado);
                        echo '<option data-codencargado='.$codtrabajador.' value="'.base64url_encode($area->codarea).'">'.$area->nombre.'</option>';  
                      }
                      
                    }
                    ?>
                  </select>
                </div>
                <div class="row">
                  <label class="col-md-2 col-form-label-sm ">Atención a:</label>
                  <select class="form-control col-md-8 form-control-sm" name="vw_mpa_lista_cb_usuario" id="vw_mpa_lista_cb_usuario">
                    <option value="0">[--Seleccionar--]</option>
                    <?php
                    foreach ($administrativos as $administrativo) {
                    $iduser=base64url_encode($administrativo->idusuario);
                    $codtrabajador=base64url_encode($administrativo->codtrabajador);
                    echo "<option data-codtrabajador='$codtrabajador' value='$iduser'>$administrativo->paterno $administrativo->materno $administrativo->nombres</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="row mb-2" id="msgemail_cc">
                <label class="col-md-2 col-form-label-sm ">Copia a:</label>
                <div class="col-md-10 pl-0 pr-0">
                  <select class="form-control form-control-sm select2" multiple="multiple" data-placeholder="[--Seleccionar--]" style="width: 100%;" name="vw_mpa_email_cc" id="vw_mpa_email_cc">
                    <?php
                    foreach ($administrativos as $admin) {
                    $nomuser = explode(" ",$admin->nombres);
                    echo "<option value='$admin->ecorporativo'>$admin->paterno $admin->materno $nomuser[0]</option>";
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


          <section id="vw_mpae_sec_adjuntar">
            <h5 class="form-title">Archivos a Adjuntar</h5>
            <div class="row">
              <div class="form-group col-lg-12">
                <div class="row">
                  
                  <div class="col-md-7 has-float-label mb-2">
                    <input type="text" name="vw_mpc_txt_titulo" id="vw_mpc_txt_titulo" class="form-control" placeholder="Describe el archivo adjunto" maxlength="200" autocomplete="off" >
                    <label for="vw_mpc_txt_titulo">Describe el archivo adjunto</label>
                  </div>
                  <div class="col-md-3">
                    <button id="vw_mpc_btn_selecionar" role="button" class="btn btn-info"><i class="fas fa-paperclip mr-1"></i>
                    Seleccionar archivo
                    </button>
                    <small class="d-block pt-2" id="vw_mpc_txt_filename"></small>
                    <input type="file" class="form-control" name="vw_mpc_file" id="vw_mpc_file">
                  </div>
                  <!--<div class="col-md-2">
                    <div class="btn btn-success" id="vw_mpc_btn_adjuntar">
                      <i class="fas fa-upload"></i> Adjuntar Prueba
                    </div>
                  </div>-->
                </div>
                <div class="row">
                  <div id="vw_mpc_txt_progress"></div>
                  <div id="vw_mpc_txt_size"></div>
                  <div id="vw_mpc_txt_type"></div>
                  <div id="vw_mpc_pgBar"></div>
                </div>
                <div class="row">
                  <b>(Se permite adjuntar hasta 10 archivos, de 1 en 1, con un máximo de 10 Mb por cada uno) <br>
                  * Solo se permiten los siguientes tipos de archivo: pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,txt.</b>
                </div>
              </div>
              
              <div id="divcard_items" class="col-12"></div>
            </div>
            <div class="row text-bold border-bottom">
              <div class="col-5">
                Archivo
              </div>
              <div class="col-2">
                Tamaño
              </div>
              <div class="col-5">
                Descripción
              </div>
            </div>
            <div class="clearfix"></div>
            <div id="vw_mpc_lista">
              
            </div>
            <div class="row mt-3">
              <div class="col-12" id="divmsjinc">
                
              </div>
            </div>
            
          </section>


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
        <div class="card-tools">
          <a href='<?php echo "{$vbaseurl}tramites/mesa-de-partes/agregar"  ?>' class="btn btn-primary  btn-sms">
            <i class="fas fa-plus mr-1">Agregar</i>
          </a>
          
        </div>
        <label class="form-check-label text-bold" for="rbpendiente">Situación: </label>
        <div class="row">
          
            
          
          <div class="form-check form-check-inline ">
            <input class="form-check-input" type="radio" checked id="rbpendiente" name="rbsituacion" value="PENDIENTE">
            <label class="form-check-label" for="rbpendiente">Pendiente</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="rbrecibido" name="rbsituacion" value="RECIBIDO">
            <label class="form-check-label" for="rbrecibido">Recibido</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="rbderivado" name="rbsituacion" value="DERIVADO">
            <label class="form-check-label" for="rbderivado">Derivado</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="rbrechazado" name="rbsituacion" value="RECHAZADO">
            <label class="form-check-label" for="rbrechazado">Rechazado</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="rbfinalizado" name="rbsituacion" value="ATENDIDO">
            <label class="form-check-label" for="rbfinalizado">Atendido</label>
          </div>
        </div>
        <div class="row mt-3">
          
          <div class="form-group has-float-label col-12 col-md-5">
            <select class="form-control form-control-sm" name="vw_mpa_lista_cb_tramite" id="vw_mpa_lista_cb_tramite" placeholder="Trámite" >
              <option value="%">Todos</option>
              <?php
              foreach ($tipos as $value) {
              echo '<option value="'.base64url_encode($value->id).'">'.$value->nombre.'</option>';
              }
              ?>
            </select>
            <label for="vw_mpa_lista_cb_tramite"> Trámite</label>
          </div>
          <div class="form-group has-float-label col-12  col-md-6">
            <input id="vw_mpa_lista_txt_busqueda" name="vw_mpa_lista_txt_busqueda" type="text" class="form-control form-control-sm " maxlength="200" minlength="5" placeholder="DNI o Apellidos y nombres" >
            <label for="vw_mpa_lista_txt_busqueda"> DNI o Apellidos y nombres</label>
          </div>
           <div class="col-12  col-md-1">
            <button id="vw_mpa_lista_btn_buscar" role="button" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
          </div>
          
        </div>
        
      </div>
      
      <div class="card-body">
        <div class="btable">
          <div class="thead col-12  d-none d-md-block">
            <div class="row">
              <div class='col-12 col-md-5'>
                <div class='row'>
                  <div class='col-md-1 td'>N°</div>
                  <div class='col-md-4 td text-center'>INGRESÓ</div>
                  <div class='col-md-7 td text-center'>SOLICITANTE</div>
                </div>
              </div>
              <div class='col-12 col-md-3 td text-center'>
                
                ASUNTO
              </div>
              
              <div class='col-12 col-md-1 td text-center'>
                RUTA
              </div>
              <div class='col-12 col-md-1 td text-center'>
                
                ESTADO
                
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
            $bgcolorsituacion = "bg-info";
            foreach ($solicitudes as $key => $sol) {
            $cod64=base64url_encode($sol->codsolicitud);
            $rut64=base64url_encode($sol->codruta);
            $nro++;
            if ($sol->situacion_actual=="") $sol->situacion_actual=$sol->situacion;
            if ($sol->area_actual=="") $sol->area_actual="MESA DE PARTES";
            
            if ($sol->situacion=="PENDIENTE") {
            $bgcolorsituacion="bg-warning";
            /*$btn_accion="<button type='button' data-seguimiento='$cod64' data-ruta='$rut64'  class='btn btn-warning vw_mpa_lista_btn_recitboton' gta-toggle='tooltip' data-placement='top' title='Recibir o Rechazar'><i class='fas fa-hourglass-end'></i></button>";*/
            }
            else if ($sol->situacion=="RECHAZADO") {
            $bgcolorsituacion="bg-danger";
            /*$btn_accion="<button type='button' data-seguimiento='$cod64' data-ruta='$rut64'  class='btn btn-warning vw_mpa_lista_btn_recitboton' gta-toggle='tooltip' data-placement='top' title='Recibir'><i class='far fa-share-square'></i></button>";*/
            }
            else if ($sol->situacion=="ATENDIDO") {
            $bgcolorsituacion="bg-success";
            /*$btn_accion="<button type='button' data-seguimiento='$cod64' data-ruta='$rut64'  class='btn btn-primary vw_mpa_lista_btn_recitboton' gta-toggle='tooltip' data-placement='top' title='Derivar'><i class='far fa-share-square'></i></button>";*/
            }

            $btn_accion="0";
            //if (($sol->codarea_actual==$_SESSION['userActivo']->idarea) && ($sol->codus==$_SESSION['userActivo']->idusuario)){
              $btn_accion=1;
              if ($sol->situacion_actual=="PENDIENTE") {
              //$bgcolorsituacion="bg-warning";
              $btn_accion="<button type='button' data-sitruta='$sol->situacion_actual' data-seguimiento='$cod64' data-ruta='$rut64'  class='tboton bg-warning vw_mpa_lista_btn_recibir' data-toggle='tooltip' data-placement='top' title='Recibir o Rechazar'><i class='fas fa-hourglass-end'></i></button>";
              }
              else if ($sol->situacion_actual=="RECHAZADO") {
              //$bgcolorsituacion="bg-danger";
              $btn_accion="<button type='button' data-sitruta='$sol->situacion_actual' data-seguimiento='$cod64' data-ruta='$rut64'  class='tboton bg-warning vw_mpa_lista_btn_recibir' data-toggle='tooltip' data-placement='top' title='Recibir'><i class='far fa-share-square'></i></button>";
              }
              else if ($sol->situacion_actual=="RECIBIDO") {
              //$bgcolorsituacion="bg-success";
              $btn_accion="<button type='button' data-sitruta='$sol->situacion_actual' data-seguimiento='$cod64' data-ruta='$rut64'  class='tboton bg-primary vw_mpa_lista_btn_recibir' data-toggle='tooltip' data-placement='top' title='Derivar'><i class='far fa-share-square'></i></button>";
              }
              else if ($sol->situacion_actual=="DERIVADO") {
              //$bgcolorsituacion="bg-info";
              $btn_accion="";
              }

            /*}
            elseif ((trim($sol->codarea_actual)=="1") && (getPermitido("68")=="SI")){
              $btn_accion=$sol->situacion_actual;
              if ($sol->situacion_actual=="PENDIENTE") {
                //$bgcolorsituacion="bg-warning";
                $btn_accion="<button type='button' data-sitruta='$sol->situacion_actual' data-seguimiento='$cod64' data-ruta='$rut64'  class='tboton bg-warning vw_mpa_lista_btn_recibir' data-toggle='tooltip' data-placement='top' title='Recibir o Rechazar'><i class='fas fa-hourglass-end'></i></button>";
                }
                else if ($sol->situacion_actual=="RECHAZADO") {
                //$bgcolorsituacion="bg-danger";
                $btn_accion="<button type='button' data-sitruta='$sol->situacion_actual' data-seguimiento='$cod64' data-ruta='$rut64'  class='tboton bg-warning vw_mpa_lista_btn_recibir' data-toggle='tooltip' data-placement='top' title='Recibir'><i class='far fa-share-square'></i></button>";
                }
                else if ($sol->situacion_actual=="RECIBIDO") {
                //$bgcolorsituacion="bg-success";
                $btn_accion="<button type='button' data-sitruta='$sol->situacion_actual' data-seguimiento='$cod64' data-ruta='$rut64'  class='tboton bg-primary vw_mpa_lista_btn_recibir' data-toggle='tooltip' data-placement='top' title='Derivar'><i class='far fa-share-square'></i></button>";
                }
                else if ($sol->situacion_actual=="DERIVADO") {
                //$bgcolorsituacion="bg-info";
                $btn_accion="";
                }
            }*/
            
            
            //$bfOrigen=($sol->area_origen=="SIN ÁREA")?'':$sol->area_origen."<br>".date("d/m/Y h:i A", strtotime($sol->fecha));
            echo
            "<div class='row rowcolor'>
              <div class='col-12 col-md-5'>
                <div class='row'>
                  <div class='col-2 col-md-1 td'>$nro</div>
                  <div class='col-10 col-md-4 td'>
                  ".date("d/m/Y h:i A", strtotime($sol->fecha))."
                    <br>
                    <button href='#' data-seguimiento='$cod64'  class='tboton bg-primary vw_mpa_lista_btn_ver'>
                    Cód: 
                    <b>$sol->codseg</b> </button>
                  </div>
                  <div class='col-12 col-md-7 td '>
                    $sol->tipodoc - $sol->nrodoc <br>
                    $sol->solicitante <br>
                  </div>

                </div>
              </div>
              
              <div class='col-12 col-md-3 td'>
                <b>$sol->tramite</b>
                <br>
                $sol->asunto
              </div>
              
              <div class='col-6 col-md-1 td text-center'>
                <button type='button' data-seguimiento='$cod64'  class='tboton bg-warning vw_mpa_lista_btn_ver_ruta'>
                  <span class='d-inline-block d-md-none'>Ruta</span>   <i class='fas fa-search'></i>
                </button>
              </div>
              <div class='col-6 col-sm-4 col-md-1 pt-md-2 td text-center'>
                <span class='d-block d-md-none'>Estado:</span> 
                <small class='tboton $bgcolorsituacion'>$sol->situacion</small>
              </div>
              <div class='col-6 col-sm-4 col-md-1 td text-center'>
                $sol->area_actual <br>
                <small class='tboton'>$sol->situacion_actual</small> 
              </div>
              <div class='col-12 col-sm-4 col-md-1 td text-center'>
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
<script src='{$vbaseurl}resources/plugins/summernote8/lang/summernote-es-ES.js'></script>
<script src='{$vbaseurl}resources/plugins/simpleUpload/simpleUpload.min.js'></script>
<script src='{$vbaseurl}resources/plugins/select2/js/select2.full.min.js'></script>"; 
//<script src='{$vbaseurl}resources/dist/js/pages/portalweb.js'></script>";
?>
<!-- /.content-wrapper -->
<!--<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>-->
<!--<script src="<?php echo base_url();?>resources/jquery/pages.js"></script>-->
<script type="text/javascript" charset="utf-8">
  $('.select2').select2();
  /*$("#vw_mpa_lista_cb_tramite").change(function(event) {
    
  });*/
  $("#vw_mpa_lista_btn_buscar").click(function(event) {
   if (history.pushState) {
      var st=$("input[name='rbsituacion']:checked").val();
      var stt="?stt=" + st;
      var tpt=($("#vw_mpa_lista_cb_tramite").val()=="%")?"":"&tpt=" + $("#vw_mpa_lista_cb_tramite").val();
      var qry=($.trim($("#vw_mpa_lista_txt_busqueda").val())=="")?"":"&qry=" + $("#vw_mpa_lista_txt_busqueda").val();
          var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + stt + tpt + qry ;
          window.history.pushState({path: newurl}, '', newurl);
      }
      location.reload();

  });
  /*rbsituacion
vw_mpa_lista_cb_tramite
vw_mpa_lista_txt_busqueda*/

$(document).ready(function() {
  //ADJUNTAR ARCHIVO
    $('#vw_mpc_txt_progress').hide();
    $('#vw_mpc_txt_size').hide();
    $('#vw_mpc_txt_type').hide();
    $('#vw_mpc_pgBar').hide();
    $("#vw_mpc_file").hide();
    $("#vw_mpae_sec_adjuntar").hide();
    $('#msgemail_cc').hide();
    //FIN ADJUNTAR ARCHIVO

    $("#vw_mpae_div_descripcion").hide();
    $("#vw_mpae_div_derivar").hide();
    $.summernote.dom.emptyPara = "<div><br></div>"
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

    var stt=getUrlParameter("stt",0);
    var tpt=getUrlParameter("tpt","%");
    var qry=getUrlParameter("qry","");
    $("#vw_mpa_lista_cb_tramite").val(tpt);
    $("#vw_mpa_lista_txt_busqueda").val(qry);
    $("input[name=rbsituacion][value=" + stt + "]").prop('checked', true);
    //$("input[name='rbsituacion']").val(stt);
});
var arrayarchivos=[];
$('#vw_mpc_file').change(function(){
  if (arrayarchivos.length>=10){
    Swal.fire({
                  icon: 'error',
                  title: 'Límite de 10 archivos',
                  text: 'Solo se puede adjuntar como máximo 6 archivos',
                  backdrop: false,
              });
    return;
  }
  $('#vw_mpc_txt_titulo').removeClass('is-invalid');
  $('.invalid-feedback').remove();
    /*if ($.trim($('#vw_mpc_txt_titulo').val())==""){
        alert("Ingresa la descripción o nombre del archivo");
    $('#vw_mpc_txt_titulo').addClass('is-invalid');
      $('#vw_mpc_txt_titulo').parent().append("<div class='invalid-feedback'>Ingresa una descripción del archivo</div>");
      $('#vw_mpc_txt_titulo').focus();
    }
    /*else if ($.trim($('#vw_mpc_file').val())==""){
      alert("Seleciona un archivo");
    }*/
   // else{*/
       $('#divcard-general').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $("#vw_mpc_file").simpleUpload(base_url+"/mesa_partes/fn_upload_file_logeado", {
          allowedExts: ["jpg", "jpeg", "png", "txt","pdf","doc","docx","xls","xlsx","xlsm","ppt","pptx"],
      //allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
      maxFileSize: 10485760, //10MB in bytes

        start: function(file){
          //upload started
          $('#vw_mpc_txt_filename').html(file.name);
          $('#vw_mpc_txt_size').html(file.size);
          $('#vw_mpc_txt_type').html(file.type);

          $('#vw_mpc_txt_progress').html("");
          $('#vw_mpc_pgBar').width(0);
          $('#vw_mpc_txt_progress').show();
          $('#vw_mpc_pgBar').show();
        },

        progress: function(progress){
          //received progress
          $('#vw_mpc_txt_progress').html("Progress: " + Math.round(progress) + "%");
          $('#vw_mpc_pgBar').width(progress + "%");
        },

        success: function(data){
          //upload successful
          //$('#progress').html("Success!<br>Data: " + JSON.stringify(data));
          $('#vw_mpc_txt_progress').hide();
          $('#vw_mpc_pgBar').hide();

          //AGREGAR ARCVO A LA LISTA
          //i.link,i.name,i.size,i.type,i.fileid
           $('#divcard-general #divoverlay').remove();
          var newarchivo=[data.link,$('#vw_mpc_txt_filename').html(),$('#vw_mpc_txt_size').html(),$('#vw_mpc_txt_type').html(),$('#vw_mpc_txt_titulo').val()];
          arrayarchivos.push(newarchivo);
          " "
          $('#vw_mpc_lista').append("<div class='row border-bottom rowcolor p-2'>"+
              "<div class='col-5'> " + $('#vw_mpc_txt_filename').html() +"</div>" + 
              "<div class='col-2'> " + $('#vw_mpc_txt_size').html() +" kb</div>" + 
              "<div class='col-5'> " + $('#vw_mpc_txt_titulo').val() +"<a href='#' class='float-right' data-link='" + data.link + "' onclick='vw_mpa_fn_delfile($(this));event.preventDefault();' ><i class='far fa-trash-alt'></i></a></div>");
          $('#vw_mpc_txt_titulo').val("");
          $('#vw_mpc_txt_filename').html("");
          $('#vw_mpc_txt_titulo').focus();
        },

        error: function(error){
          //upload failed
          
          switch (error.name) {
        case 'InvalidFileExtensionError':
          vmsg="Este tipo de archivo no es admitido";
          break;
        case 'MaxFileSizeError':
          vmsg="El peso máximo permitido es de 10MB";
          break;
        default:
          vmsg=error.message;

          //$('#vw_mpc_txt_progress').html("Error!<br>" + error.name + ": " + error.message);
      }
      Swal.fire({
                  icon: 'error',
                  title: "Error! " + error.name,
                  text: vmsg,
                  backdrop: false,
              });
            $('#vw_mpc_txt_filename').html("");
          $('#vw_mpc_txt_size').html("");
          $('#vw_mpc_txt_type').html("");
           $('#divcard-general #divoverlay').remove();
        }

        });
      //}


});
function vw_mpa_fn_delfile(btn) {
    var link = btn.data('link');


    var n = 0;
    arrayarchivos.forEach(function(afile) {
        if (afile[0] === link) {
            arrayarchivos.splice(n, 1);
            btn.closest('.rowcolor').remove();
        }
        n++;
    });

}

$("#vw_mpa_lista_cb_area").change(function(event) {
  /* Act on the event */
    var codencargado=$('#vw_mpa_lista_cb_area option:selected').data('codencargado');
    
    var atencion_a="0";
    $("#vw_mpa_lista_cb_usuario option").each(function(i){
        if ($(this).data('codtrabajador')==codencargado){
          atencion_a=$(this).val();
        }
    });
    
    $("#vw_mpa_lista_cb_usuario").val(atencion_a);
  

});

$('#vw_mpc_btn_selecionar').click(function(event) {
    event.preventDefault();
    $("#vw_mpc_file").trigger('click');
});
$("#vw_mpae_cb_ejecutar").change(function(event) {
    var cbval = $(this).val();
    $("#vw_mpa_lista_cb_area").val("0");
    $("#vw_mpa_lista_cb_usuario").val("0");
    if (cbval == "RECIBIDO") {
      $("#vw_mpae_div_derivar").hide();
      $("#vw_mpae_div_descripcion").hide();
      $("#vw_mpae_sec_adjuntar").hide();
      $('#msgemail_cc').hide();
    } 
    else if (cbval == "RECHAZADO") {
      $("#vw_mpae_div_derivar").hide();
      $("#vw_mpae_div_descripcion").show();
      $("#vw_mpae_sec_adjuntar").show();
      $('#msgemail_cc').hide();
    } 
    else if (cbval == "DERIVADO") {
      $("#vw_mpae_div_descripcion").show();
      $("#vw_mpae_div_derivar").show();
      $("#vw_mpae_sec_adjuntar").show();
      $('#msgemail_cc').show();
    } 
    else if (cbval == "FINALIZADO") {
      $("#vw_mpae_div_descripcion").show();
      $("#vw_mpae_div_derivar").hide();
      $("#vw_mpae_sec_adjuntar").show();
      $('#msgemail_cc').show();
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
    var sitruta = $(this).data('sitruta');
    $('#vw_mpae_cb_ejecutar').val("");
    if (sitruta=="PENDIENTE"){
      $('#vw_mpae_cb_ejecutar option').each(function(index, el) {
          $(this).addClass('ocultar');
          if (($(this).attr('value')=='RECIBIDO') || ($(this).attr('value')=='RECHAZADO') ) $(this).removeClass('ocultar');
      });
    }
    else if (sitruta=="RECIBIDO") {
      $('#vw_mpae_cb_ejecutar option').each(function(index, el) {
          $(this).addClass('ocultar');
          if ($(this).attr('value')!='RECIBIDO') $(this).removeClass('ocultar');
      });
    } 
    else if (sitruta=="RECHAZADO") {
      $('#vw_mpae_cb_ejecutar option').each(function(index, el) {
          $(this).addClass('ocultar');
          if ($(this).attr('value')=='RECIBIDO') $(this).removeClass('ocultar');
      });
    } 
    

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
    //var datos = $("#vw_mpa_lista_form-ejecutar").serialize();
    
    arremailcc = [];
    $.each($("#vw_mpa_email_cc option:selected"), function() {
      arremailcc.push($(this).val());
    });

    var formData = new FormData($("#vw_mpa_lista_form-ejecutar")[0]);
    formData.append('vw_mpc_email_cc', JSON.stringify(arremailcc));
    formData.append('vw_mpc_archivos', JSON.stringify(arrayarchivos));


    $.ajax({
        url: base_url + 'mesa_partes/fn_administrativo_ejecutar',
        type: 'post',
        dataType: 'json',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(e) {
            $('#divcard-general #divoverlay').remove();
            if (e.status == false) {

            } 
            else {
              $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                location.reload();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'div');
            $('#divcard-general #divoverlay').remove();
            $('.vw_mpa_lista_md_rec-der-rec .modal-body').html(msgf);
            $('.vw_mpa_lista_md_rec-der-rec').modal('show')
        },
    });
});

$('.vw_mpa_lista_md_rec-der-rec').on('hidden.bs.modal', function (e) {
  $("#vw_mpae_div_derivar").hide();
  $("#vw_mpae_div_descripcion").hide();
  $("#vw_mpae_sec_adjuntar").hide();
  $('#msgemail_cc').hide();
})



/*function searchc(tcar) {
    $('#divmatriculados').html("");
    $('#divdatosmat').html("");
    var cbper = $('#vw_acad_cbperiodo').val();
    $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'matricula/vwcurso_x_periodo_carne',
        type: 'post',
        dataType: 'json',
        data: {
            txtbusca_carne: tcar,
            cbperiodo: cbper
        },
        success: function(e) {
            $('#divcard-general #divoverlay').remove();
            if (e.status == false) {
                var msgf = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg + '</div>';
                $('#divmiscursos').html(msgf);
            } else {
                $('#divdatosmat').html(e.alumno);
                $('#divmiscursos').html(e.miscursos);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'div');
            $('#divcard-general #divoverlay').remove();
            $('#divmiscursos').html(msgf);
        },
    });
    return false;
}*/
/*$('#busca_apellnom').click(function() {
    $('#divmiscursos').html("");
    $('#divdatosmat').html("");
    var tcar = $('#txtbusca_apellnom').val();
    var cbper = $('#vw_acad_cbperiodo').val();
    $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'matricula/vw_matriculados',
        type: 'post',
        dataType: 'json',
        data: {
            txtbusca_apellnom: tcar,
            cbperiodo: cbper
        },
        success: function(e) {
            $('#divcard-general #divoverlay').remove();
            if (e.status == false) {
                var msgf = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg + '</div>';
                $('#divmatriculados').html(msgf);
            } else {
                $('#divmatriculados').html(e.matriculados);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'div');
            $('#divcard-general #divoverlay').remove();
            $('#divmatriculados').html(msgf);
        },
    });
    return false;
});*/
/*$(document).ready(function() {
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
});*/
/*$("#busca_encuestas").click(function(event) {
    $('input:text,select').removeClass('is-invalid');
    $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#div-encucreadas").html("");
    var codper = $("#vw_encu_cbperiodo").val();
    $.ajax({
        url: base_url + 'cuestionario_general/fn_get_cuestionarios_creador_observador',
        type: 'post',
        dataType: 'json',
        data: {
            "vw_encu_cbperiodo": codper
        },
        success: function(e) {
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                var nro = 0;
                $.each(e.encucreadas, function(index, v) {

                    nro++;
                    var btn_editar = '<a class="dropdown-item" href="' + base_url + 'monitoreo/estudiantes/encuesta/editar/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="fas fa-edit"></i> Editar</a>';
                    var btn_poblacion = '<a class="dropdown-item" href="' + base_url + 'monitoreo/estudiantes/encuesta/poblacion/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="fas fa-user-friends"></i> Población</a>';
                    var btn_preguntas = '<a class="dropdown-item" href="' + base_url + 'monitoreo/estudiantes/encuesta/preguntas/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="far fa-question-circle"></i> Preguntas</a>';
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
});*/
</script>