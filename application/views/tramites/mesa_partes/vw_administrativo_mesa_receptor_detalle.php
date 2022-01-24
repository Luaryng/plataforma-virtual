<?php
    $nro=$inicio;
    $bgcolorsituacion = "bg-info";
    foreach ($solicitudes as $key => $sol) {
    $cod64=base64url_encode($sol->codsolicitud);
    $rut64=base64url_encode($sol->codruta);
    $nro++;
    if ($sol->situacion_actual=="") $sol->situacion_actual=$sol->situacion;

    if ($sol->area_actual=="") $sol->area_actual="--------";
    
    if ($sol->situacion=="PENDIENTE") {
      $bgcolorsituacion="bg-warning"; 
    }
    else if ($sol->situacion=="RECHAZADO") {
      $bgcolorsituacion="bg-danger";
    }
    else if ($sol->situacion=="ATENDIDO") {
      $bgcolorsituacion="bg-success";
    }

    $btn_accion="Derivado";
    /*if (($sol->codarea_actual==$_SESSION['userActivo']->idarea) || ($sol->codusuario_destino==$_SESSION['userActivo']->idusuario)){
      //$btn_accion=1;
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
        if ($sol->codusuario_origen==$_SESSION['userActivo']->idusuario){
          $btn_accion="Revertir";
        }
        
      }

    }
    else*/ 
    if ((trim($sol->codarea_actual)=="1") && (getPermitido("68")=="SI")){
      //$btn_accion=$sol->situacion_actual;
      if ($sol->situacion_actual=="PENDIENTE") {
        //$bgcolorsituacion="bg-warning";
        $btn_accion="<a type='button' data-sitruta='$sol->situacion_actual' data-seguimiento='$cod64' data-ruta='$rut64'  class='tboton bg-warning' onclick='vw_mpa_lista_btn_recibir($(this))' data-toggle='tooltip' data-placement='top' title='Recibir o Rechazar'><i class='fas fa-hourglass-end'></i></a>";
        }
        else if ($sol->situacion_actual=="RECHAZADO") {
        //$bgcolorsituacion="bg-danger";
        $btn_accion="<a type='button' data-sitruta='$sol->situacion_actual' data-seguimiento='$cod64' data-ruta='$rut64'  class='tboton bg-warning' onclick='vw_mpa_lista_btn_recibir($(this))' data-toggle='tooltip' data-placement='top' title='Recibir'><i class='far fa-share-square'></i></a>";
        }
        else if ($sol->situacion_actual=="RECIBIDO") {
        //$bgcolorsituacion="bg-success";
        $btn_accion="<a type='button' data-sitruta='$sol->situacion_actual' data-seguimiento='$cod64' data-ruta='$rut64'  class='tboton bg-primary' onclick='vw_mpa_lista_btn_recibir($(this))' data-toggle='tooltip' data-placement='top' title='Derivar'><i class='far fa-share-square'></i></a>";
        }
        else if ($sol->situacion_actual=="DERIVADO") {
          if ($sol->codusuario_origen==$_SESSION['userActivo']->idusuario){
            $btn_accion="Revertir";
          }
        }
    }
    elseif (trim($sol->codarea_actual)!="1"){
      if ($sol->codusuario_destino==$_SESSION['userActivo']->idusuario){
        if ($sol->situacion_actual=="PENDIENTE") {
            if ($sol->codusuario_destino==$_SESSION['userActivo']->idusuario){
               $btn_accion="<a type='button' data-sitruta='$sol->situacion_actual' data-seguimiento='$cod64' data-ruta='$rut64'  class='tboton bg-warning' onclick='vw_mpa_lista_btn_recibir($(this))' data-toggle='tooltip' data-placement='top' title='Recibir o Rechazar'><i class='fas fa-hourglass-end'></i></a>";
            }
        }
        elseif ($sol->situacion_actual=="RECIBIDO") {
            if ($sol->codusuario_destino==$_SESSION['userActivo']->idusuario){
               $btn_accion="<a type='button' data-sitruta='$sol->situacion_actual' data-seguimiento='$cod64' data-ruta='$rut64'  class='tboton bg-primary' onclick='vw_mpa_lista_btn_recibir($(this))' data-toggle='tooltip' data-placement='top' title='Derivar'><i class='far fa-share-square'></i></a>";
            }
        }
      }
      elseif ($sol->situacion_actual=="PENDIENTE") {
          if ($sol->codusuario_origen==$_SESSION['userActivo']->idusuario){
            $btn_accion="<a type='button' data-sitruta='$sol->situacion_actual' data-seguimiento='$cod64' data-ruta='$rut64'  class='tboton bg-danger' data-toggle='tooltip' data-placement='top' title='Revertir'><i class='far fa-share-square fa-flip-horizontal'></i></a>";
          }
      }
    }
    
    
    //$bfOrigen=($sol->area_origen=="SIN ÁREA")?'':$sol->area_origen."<br>".date("d/m/Y h:i A", strtotime($sol->fecha));
    $nombres=explode(" ",$sol->des_nombres); 
    $des_persona=$nombres[0]." $sol->des_paterno $sol->des_materno <br>";
    $correo="";
    if (trim($sol->email_personal)=="") {
      $correo=trim($sol->email_corporativo);
    }
    else{
      $correo=$sol->email_personal;
      if (trim($sol->email_corporativo)!=""){
        $correo=$correo.",".trim($sol->email_corporativo);
      }
    } 
    if ($correo=="") $correo="Sin correo electrónico";
    echo
   "<div class='row rowcolor' data-email='$correo' data-telefono='$sol->telefono' data-codseguim='$sol->codseg' data-solicit='$sol->solicitante' data-fecha='".date("d/m/Y h:i A", strtotime($sol->fecha))."' data-asunto='$sol->asunto'>
      <div class='col-12 col-md-5'>
        <div class='row'>
          <div class='col-2 col-md-1 td'>$nro</div>
          <div class='col-10 col-md-4 td'>
          ".date("d/m/Y h:i A", strtotime($sol->fecha))."
            <br>
            <a type='button' data-seguimiento='$cod64' onclick='vw_mpa_lista_btn_ver($(this))'  class='tboton btn-block bg-primary'>
            Cód: 
            <b>$sol->codseg</b> </a>
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


      <div class='col-6 col-sm-4 col-md-1 pt-md-2 td text-center'>
        <a type='button' data-seguimiento='$cod64'  onclick='vw_mpa_lista_btn_ver_ruta($(this))' class='tboton bg-warning '>
          <span class='d-inline-block d-md-none'>Ruta</span>   <i class='fas fa-search'></i>
        </a>
        <span class='d-block d-md-none'>Estado:</span> 
        <small class='p-1 border rounded $bgcolorsituacion'>$sol->situacion</small>
      </div>
      <div class='col-6 col-sm-4 col-md-2 td text-center'>
        $des_persona
        $sol->area_actual <br>
        <small class='tboton'>$sol->situacion_actual</small> 
      </div>
      <div class='col-12 col-sm-4 col-md-1 td text-center'>
        $btn_accion
      </div>
    </div>";
    }
    ?>

