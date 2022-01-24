<?php $vbaseurl = base_url()?>
<div class="row">
  <label class="col-md-2 col-form-label-sm ">Trámite:</label>
  <span class="form-control form-control-sm col-md-5"><?php echo $solicitud->tramite ?></span>
</div>
<div class="row">
  <label class=" col-md-2 col-form-label-sm">Asunto de la solicitud:</label>
  <div class="col-md-10 border rounded"><?php echo $solicitud->asunto ?></div>
</div>
<section class="border mx-n2 mt-3 p-3">
  <h4 class="form-title">Datos del Solicitante</h4>
  <div class="row">
    <label class="col-md-2 col-form-label-sm">Solicitante:
    </label>
    <span class="form-control form-control-sm col-md-10">
      <?php echo "$solicitud->tipodoc - $solicitud->nrodoc" ?>
    </span>
    <label class="col-md-2 col-form-label-sm">
    </label>
    <span class="form-control form-control-sm col-md-10">
      <?php echo $solicitud->solicitante ?>
    </span>
  </div>
  
  
  <div class="form-group">
    <label class="col-form-label-sm ">Contenido</label>
    <div class=" col-md-12 border rounded py-2" style="min-height: 60px">
      <?php echo "$solicitud->contenido" ?>
    </div>
  </div>
  <div class="row">
    <label class="col-md-2 col-form-label-sm">Domicilio:</label>
    <span class="form-control form-control-sm col-md-10">
      <?php echo $solicitud->domicilio ?>
    </span>
  </div>
  <div class="row">
    <label class="col-md-2 col-form-label-sm">Email:</label>
    <span class="form-control form-control-sm col-md-5">
      <?php echo $solicitud->email_personal ?>
    </span>
   
  </div>
  <div class="row">
    <label class="col-md-2 col-form-label-sm">Telefono/ Celular:</label>
    <span class="form-control form-control-sm col-md-5">
      <?php echo $solicitud->telefono ?>
    </span>
  </div>
</section>
<section class="border mx-n2 p-3">
  <h4 class="form-title">Archivos adjuntados</h4>
  <?php
  foreach ($adjuntos as $key => $ad) {
  echo
  "<div class='row border-bottom'>
    
    <span class='form-control-sm col-md-5'>
      <i class='fas fa-paperclip mr-1'></i> $ad->titulo
    </span>
    <span class='col-md-2 col-form-label-sm'>".getIcono("P",$ad->archivo)." Descargar</span>
  </div>";
  }
  ?>
  
</section>
<section class="border mx-n2 p-3">
  <h4 class="form-title">HISTORIAL</h4>
  <div class="btable">
    <div class="thead col-12  d-none d-md-block">
      <div class="row">
        <div class='col-2 col-md-1'>
          N°
        </div>
        <div class='col-12 col-md-2 td '>
          ORIGEN
        </div>
        <div class='col-12 col-md-2 td'>
          FECHA
        </div>
        <div class='col-12 col-md-2 td '>
          DESTINO
        </div>
        <div class='col-12 col-md-2 td text-center'>
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
      
      
      echo
      "<div class='row rowcolor'>
        <div class='col-12 col-md-3'>
          <div class='row'>
            <div class='col-3 col-md-2 td'>
              $nro
            </div>
            <div class='col-9 col-md-10 td'>
              $rt->area_origen <br>
              $rt->usuario_origen
            </div>
          </div>
        </div>
        <div class='col-12 col-md-2 td '>
          $rt->fecha 
        </div>
        <div class='col-12 col-md-2 td'>
          
          $rt->area_destino <br>
          $rt->usuario_destino
          
        </div>
        
        <div class='col-12 col-md-5 td'>
          <small class='tboton $bgcolorsituacion '>$rt->situacion_ruta</small>
          $rt->descripcion
           
        
          
          
           
        </div>
        </div>";
        }
        ?>
      </div>
      
    </div>
    
  </section>
<?php 
  $meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
  $dias = array("Lun","Mar","Mie","Jue","Vie","Sab","Dom");
?>

  <section>
    <div class="row">
          <div class="col-md-12 p-3">
            <div class="timeline timeline-inverse">
              <?php 
                $fecha_ing = date_create($solicitud->fecha);
                $fecha_agrupar=fechaCastellano($solicitud->fecha,$meses,$dias);
                   echo 
                    "<div class='time-label'>
                      <span class='bg-danger'>".
                      $fecha_agrupar.
                      "</span>
                    </div>
                    <div>
                        <i class='fas fa-university bg-primary'></i>

                        <div class='timeline-item'>
                            <span class='time'><i class='far fa-clock'></i>".date_format($fecha_ing, 'g:i A')."</span>

                            <h3 class='timeline-header'>  $rt->area_destino</h3>

                            <div class='timeline-body'>
                                Su trámite ha sido INGRESADO por <b>MESA DE PARTES</b>.
                            </div>
                            
                        </div>
                    </div>";
                  $nro =0;
                  foreach ($ruta as $key => $rt) {
                    $nro++;
                    $cod64=base64url_encode($rt->codsolicitud);
                    $rut64=base64url_encode($rt->codruta);
                    $fecha_reg = date_create($rt->fecha);
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



                    if ($nro>1){
                      $fecha_agrupar_sg=fechaCastellano($rt->fecha,$meses,$dias);
                      if ($fecha_agrupar!=$fecha_agrupar_sg){
                        $fecha_agrupar=$fecha_agrupar_sg;
                        echo 
                        "<div class='time-label'>
                          <span class='bg-danger'>".$fecha_agrupar
                          .
                          "</span>
                        </div>";
                      }
                      
                      echo 
                      "<div>
                          <i class='fas fa-university $bgcolorsituacion'></i>

                          <div class='timeline-item'>
                              <span class='time'><i class='far fa-clock'></i>".date_format($fecha_reg, 'g:i A')."</span>

                              <h3 class='timeline-header'>  $rt->area_origen</h3>

                              <div class='timeline-body'>
                                  Su trámite ha sido DERIVADO a <b>$rt->area_destino</b>.
                              </div>
                              
                          </div>
                      </div>";
                    }

                    if ($rt->fecha_p!=""){
                      $fecha_reg = date_create($rt->fecha_p);
                      $fecha_agrupar_sg=fechaCastellano($rt->fecha_p,$meses,$dias);
                      if ($fecha_agrupar!=$fecha_agrupar_sg){
                        $fecha_agrupar=$fecha_agrupar_sg;
                        echo 
                        "<div class='time-label'>
                          <span class='bg-danger'>".$fecha_agrupar
                          .
                          "</span>
                        </div>";
                      }
                      
                      echo 
                      "<div>
                          <i class='fas fa-university $bgcolorsituacion'></i>

                          <div class='timeline-item'>
                              <span class='time'><i class='far fa-clock'></i>".date_format($fecha_reg, 'g:i A')."</span>

                              <h3 class='timeline-header'>  $rt->area_destino</h3>

                              <div class='timeline-body'>
                                  Su trámite ha sido $rt->situacion_ruta en <b>$rt->area_destino</b>.
                              </div>
                              
                          </div>
                      </div>";
                    }
                    else {
                      
                      
                      echo 
                      "<div>
                          <i class='fas fa-university $bgcolorsituacion'></i>

                          <div class='timeline-item'>
                              

                              <h3 class='timeline-header'>  $rt->area_destino</h3>

                              <div class='timeline-body'>
                                  Su trámite se encuentra PENDIENTE en <b>$rt->area_destino</b>.
                              </div>
                              
                          </div>
                      </div>";
                    }

                  }



               ?>

                  
                    
                    
            </div>
            <div class="callout callout-danger">
              <h5>Su trámite aún se encuentra en proceso</h5>

              <p>Usted será notificado cuando su trámite haya sido completado</p>
            </div>

          </div>
        </div>
  </section>
