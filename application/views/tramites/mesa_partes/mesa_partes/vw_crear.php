<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<div class="content-wrapper">
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
        <h3 class="card-title">Nueva Solicitud</h3>
        
      </div>
      
      <div class="card-body">
        <form id="frm-add-mesa" action="<?php echo $vbaseurl ?>mesa_partes/fn_insert" method="post" accept-charset="utf-8">
          <div class="row">
            <label class="col-md-2 col-form-label-sm ">Trámite:</label>
            <select class="form-control col-md-5 form-control-sm" name="vw_mp_cb_tramite" id="vw_mp_cb_tramite">
              <option value="">[--Seleccionar--]</option>
              <?php
                foreach ($tipos as $value) {
                  echo '<option value="'.$value->id.'">'.$value->nombre.'</option>';
                }
              ?>
            </select>
          </div>
          <div class="row">
            <label class=" col-md-2 col-form-label-sm">Asunto de la solicitud:</label>
            <input id="vw_mp_txt_asunto" name="vw_mp_txt_asunto" type="text" class="form-control form-control-sm col-md-10 " maxlength="200" minlength="5">
            <small class="col-md-12 text-primary text-right">Caracteres restantes: <span id="vw_mp_sm_conteo" >200</span></small>
          </div>
          <section class="border mx-n2 p-3">
            <h4 class="form-title">Datos del Solicitante</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <label class="col-md-4 col-form-label-sm">Tipo de Doc.:</label>
                  <select class="form-control col-md-6 form-control-sm" name="vw_mp_cb_tdoc" id="vw_mp_cb_tdoc">
                    <option value="DNI">DNI</option>
                    <option value="CEX">CARNÉ EXTRANJERIA</option>
                    <option value="PSP">PASAPORTE</option>
                    <option value="PTP">Permiso</option>
                    <option value="RUC">RUC</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <label class="col-md-4 col-form-label-sm">Número de Doc:</label>
                  <input id="vw_mp_txt_nro_doc" name="vw_mp_txt_nro_doc" type="text" class="form-control col-md-8 form-control-sm" maxlength="200" minlength="5">
                  
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-md-2 col-form-label-sm">Apellidos y Nombres</label>
              <input id="vw_mp_txt_apelnom" name="vw_mp_txt_apelnom" type="text" class="form-control col-md-10 " maxlength="200" minlength="5">
            </div>
            <div class="form-group ">
              <label class="col-form-label-sm ">Contenido</label>
              <textarea name="vw_mp_txt_contenido" id="vw_mp_txt_contenido" class="form-control form-control-sm"  rows="8" maxlength="2000"></textarea>
              <small class="text-primary">Caracteres restantes: <span id="vw_mp_sm_conteo_con" >2000</span></small>
            </div>
            <div class="row">
              <label class="col-md-2 col-form-label-sm">Domicilio:</label>
              <input id="vw_mp_txt_domicilio" name="vw_mp_txt_domicilio" type="text" class="form-control col-md-10 form-control-sm" maxlength="200" minlength="5">
            </div>
            <div class="row">
              <label class="col-md-2 col-form-label-sm">Correo Electrónico:</label>
              <input id="vw_mp_txt_email" name="vw_mp_txt_email" type="text" class="form-control col-md-5 form-control-sm" maxlength="200" minlength="5">
              <span class="col-12 col-md-5">Autorizo que las respuestas se remitan a esta dirección de correo (en caso no cuente con Cuenta en la Plataforma Virtual)</span>
            </div>
            <div class="row">
              <label class="col-md-2 col-form-label-sm">Telefono/ Celular:</label>
              <input id="vw_mp_txt_celular" name="vw_mp_txt_celular" type="text" class="form-control col-md-10 form-control-sm" maxlength="200" minlength="5">
            </div>
            
          </section>
          <section class="border mx-n2 p-3">
            <h4 class="form-title">Archivos a Adjuntar</h4>
            <div class="row">
              <div class="form-group col-lg-12">
                <div class="row">
                  <div class="col-12 col-lg-5 col-md-5 col-sm-5 has-float-label mb-2">
                    <input type="text" name="txttitulo1" id="txttitulo1" class="form-control" placeholder="titulo" >
                    <label for="txttitulo1">Titulo</label>
                  </div>
                  
                  <div class="col-2 col-sm-2">
                    <div class="form-group clearfix mt-2 text-center">
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" nro="1" id="checkfile1" class="activefile">
                        <label for="checkfile1"></label>
                      </div>
                    </div>
                  </div>
                  <div class="col-10 col-lg-5 col-md-5 col-sm-5">
                  
                    <div class="form-group">
                      <div class="btn btn-info btn-file" id="divgroup1">
                        <i class="fas fa-paperclip"></i> Adjuntar archivo
                        <input type="file" name="txtfile1" id="txtfile1" disabled="">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-12">
                <div class="row">
                  <div class="col-12 col-lg-5 col-md-5 col-sm-5 has-float-label mb-2">
                    <input type="text" name="txttitulo2" id="txttitulo2" class="form-control" placeholder="titulo" >
                    <label for="txttitulo2">Titulo</label>
                  </div>
                  <div class="col-2 col-sm-2">
                    <div class="form-group clearfix mt-2 text-center">
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" nro="2" id="checkfile2" class="activefile">
                        <label for="checkfile2"></label>
                      </div>
                    </div>
                  </div>
                  <div class="col-10 col-lg-5 col-md-5 col-sm-5">

                    <div class="form-group">
                      <div class="btn btn-info btn-file" id="divgroup2">
                        <i class="fas fa-paperclip"></i> Adjuntar archivo
                        <input type="file" name="txtfile2" id="txtfile2" disabled="">
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
              <div class="form-group col-lg-12">
                <div class="row">
                  <div class="col-12 col-lg-5 col-md-5 col-sm-5 has-float-label mb-2">
                    <input type="text" name="txttitulo3" id="txttitulo3" class="form-control" placeholder="titulo" >
                    <label for="txttitulo3">Titulo</label>
                  </div>
                  <div class="col-2 col-sm-2">
                    <div class="form-group clearfix mt-2 text-center">
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" nro="3" id="checkfile3" class="activefile" >
                        <label for="checkfile3"></label>
                      </div>
                    </div>
                  </div>
                  <div class="col-10 col-lg-5 col-md-5 col-sm-5">
                    <div class="form-group">
                      <div class="btn btn-info btn-file" id="divgroup3">
                        <i class="fas fa-paperclip"></i> Adjuntar archivo
                        <input type="file" name="txtfile3" id="txtfile3" disabled="">
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
              <div id="divcard_items" class="col-12"></div>
            </div>
            <div class="row">
              <div class="col-12">
                <a href="#" class="text-info" id="btn_additem"><i class="fa fa-plus"></i> Agregar más datos</a>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-12" id="divmsjinc">
                
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-12">
                <a type="button" href="<?php echo $vbaseurl ?>tramites/mesa-de-partes" class="btn btn-danger btn-md float-left" ><i class="fas fa-undo"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary btn-md float-right"><i class="far fa-paper-plane"></i> Enviar</button>
              </div>
            </div>
          </section>
        </form>
        <div id="divcard_msg" class="d-flex justify-content-center">
          
        </div>
      </div>
      
    </div>
  </section>
</div>
<!-- /.content-wrapper -->
<!--<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>-->
<!--<script src="<?php echo base_url();?>resources/jquery/pages.js"></script>-->
<script type="text/javascript" charset="utf-8">
$("#vw_mp_txt_asunto").keyup(function(event) {
$("#vw_mp_sm_conteo").html(200 - $(this).val().length);
});
$("#vw_mp_txt_contenido").keyup(function(event) {
$("#vw_mp_sm_conteo_con").html(2000 - $(this).val().length);
});
//****************************----


$('.activefile').change(function(event){
  item = $(this).attr('nro');
  var habilita = $("#checkfile"+item).is(':checked');
  $("#txtfile"+item).prop("disabled", !habilita);
 

});

$('#btn_additem').click(function(e){
  e.preventDefault();
  var items = $('.activefile').length;
  $('#divcard-general').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'mesa_partes/vwasignar_files',
        type: 'post',
        dataType: 'json',
        data: {txtnro: items+1},
        success: function(e) {
            if (e.status == true) {
                $('#divcard-general #divoverlay').remove();
                $('#divcard_items').before(e.vdata);
            } else {
                $('#divcard-general #divoverlay').remove();
                var msgf = '<span class="text-danger"><i class="fa fa-ban float-left"></i>'+ e.msg +'</span>';
                $('#divcard_items').html(msgf);
            }
            
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception);
            $('#divcard-general #divoverlay').remove();
            $('#divcard_items').html(msgf);
        },
    });
    return false;
  
});

$("#frm-add-mesa").submit(function(event) {
  var items = $('.activefile').length;
    $('#frm-add-mesa input,select,textarea').removeClass('is-invalid');
    $('#frm-add-mesa .invalid-feedback').remove();
    $('#divcard-general').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var formData = new FormData($("#frm-add-mesa")[0]);
    formData.append('nrofiles',items);
    $.ajax({
        url: $("#frm-add-mesa").attr("action"),//$(this).attr("action"),
        type: $("#frm-add-mesa").attr("method"),//'post',
        dataType: 'json',
        data: formData,
        cache:false,
        contentType:false,
        processData:false,
        success: function(e) {
            $('#divcard-general #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
              var msgf = e.msg;
              $("#frm-add-mesa").addClass('d-none');
              $("#divcard_msg").html(msgf);
              
            }
        },
        error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#divcard-general #divoverlay').remove();
            
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: msgf,
            backdrop: false,
          })
        }
    });
    return false;
});

</script>