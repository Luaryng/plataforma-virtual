<?php $vbaseurl = base_url();
//date_default_timezone_set ('America/Lima');
?>

<section >
  <div class="btable">
    <div class="thead col-12  d-none d-md-block">
      <div class="row">
        <div class='col-2 col-md-1'>
          N°
        </div>
        <div class='col-12 col-md-2 td '>
          ORIGEN
        </div>
        <div class='col-12 col-md-2 td '>
          DESTINO
        </div>
        <div class='col-12 col-md-4 td text-center'>
          DESCRIPCIÓN
        </div>
        <div class='col-12 col-md-3 td text-center'>
          SITUACIÓN
        </div>
      </div>
    </div>
    <div class="tbody col-12">
      <?php
      $nro=0;
      foreach ($ruta as $key => $rt) {
      $cod64=base64url_encode($rt->codsolicitud);
      $rut64=base64url_encode($rt->codruta);
      $nro++;
      if ($rt->situacion_ruta=="PENDIENTE") {
        $bgcolorsituacion="bg-warning";
      }
      else if ($rt->situacion_ruta=="RECHAZADO") {
        $bgcolorsituacion="bg-danger";
      }
      else if ($rt->situacion_ruta=="RECIBIDO") {
        $bgcolorsituacion="bg-success";
      }
      else if ($rt->situacion_ruta=="DERIVADO") {
        $bgcolorsituacion="bg-info";
      }

      $mensaje = "";
      if ($rt->situacion_ruta == "ENVIADO") $mensaje = $rt->descripcion."<hr class='my-2'><b>Email:</b> ".$rt->emailcorporativo_origen;
      
      echo
      "<div class='row rowcolor'>
        <div class='col-12 col-md-3'>
          <div class='row'>
            <div class='col-3 col-md-2 td'>
              $nro
            </div>
            <div class='col-9 col-md-10 td'>".
              (($rt->codarea_origen=='3')?'':$rt->area_origen.'<br>').
              "<small> $rt->nom_origen </small><br>".date("d/m/Y h:i A", strtotime($rt->fecha )).
            "</div>
          </div>
        </div>
        <div class='col-12 col-md-2 td'>
          $rt->area_destino <br>".
          (($rt->usuario_destino=='')?'':'<small>'.$rt->nom_destino.'</small><br>').
          (($rt->fecha_p=='')?'':date("d/m/Y h:i A", strtotime($rt->fecha_p ))).
        "</div>
        <div class='col-12 col-md-4 td'>
          $mensaje
        </div>
        <div class='col-12 col-md-3 td '>  
          <small class='tboton $bgcolorsituacion '>$rt->situacion_ruta</small>
          <br>Adjuntos:<br>";
          
          foreach ($adjuntos as $kad => $adj) {
            $icon=getIcono("X",$adj->link);
            $titulo=(trim($adj->titulo)=="") ? $adj->archivo : $adj->titulo;
            if ($adj->codruta==$rt->codruta){
              echo "<a target='_blank' href='{$vbaseurl}upload/tramites/{$adj->link}'>$icon $titulo<a>";
              unset($adjuntos[$kad]);
            }
            
          }
          echo 
        "</div>
      </div>";
        }
        ?>
      </div>
      
    </div>
    
  </section>