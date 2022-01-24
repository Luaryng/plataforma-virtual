<?php
    $nro=$inicio;
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
    if (($sol->codarea_actual==$_SESSION['userActivo']->idarea) && ($sol->codusuario_destino==$_SESSION['userActivo']->idusuario)){
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

    }
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
    }
    
    
    //$bfOrigen=($sol->area_origen=="SIN ÁREA")?'':$sol->area_origen."<br>".date("d/m/Y h:i A", strtotime($sol->fecha));
    echo
    "<div class='row rowcolor' data-codseguim='$sol->codseg' data-solicit='$sol->solicitante' data-fecha='".date("d/m/Y h:i A", strtotime($sol->fecha))."' data-asunto='$sol->asunto'>
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

<script>
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
            // $('.vw_mpa_lista_md_ver_datos .modal-title').html('DETALLE');
            $('.vw_mpa_lista_md_ver_datos .modal-title').html('DETALLE SOLICITUD N° '+ e.codseguim + "<div class='small'><b>Solicitante: </b>" + e.solicitante + "</div><span class='small'><b>Fecha tramite: </b>" + e.fecha + "</span>");

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
            // $('.vw_mpa_lista_md_ver_datos .modal-title').html('SEGUIMIENTO');
            $('.vw_mpa_lista_md_ver_datos .modal-title').html('SEGUIMIENTO N° '+ e.codseguim + "<br><div class='small'><b>Solicitante: </b>" + e.solicitante + "</div><span class='small'><b>Asunto: </b>" + e.asunto + "</span><br><span class='small'><b>Fecha tramite: </b>" + e.fecha + "</span>");
            
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

    var fila = $(this).closest('.rowcolor');
    var codseguim = fila.data('codseguim');
    var solicitante = fila.data('solicit');
    var asunto = fila.data('asunto');
    var fecha = fila.data('fecha');

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
    $('.vw_mpa_lista_md_rec-der-rec .modal-title').html('ACCIÓN DE TRAMITE N° '+ codseguim + "<br><div class='small'><b>Solicitante: </b>" + solicitante + "</div><span class='small'><b>Asunto: </b>" + asunto + "</span><br><span class='small'><b>Fecha tramite: </b>" + fecha + "</span>");
    $('.vw_mpa_lista_md_rec-der-rec').modal('show');
    $('#divcard-general #divoverlay').remove();
  });
</script>