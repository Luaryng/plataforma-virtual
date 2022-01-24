<?php $vbaseurl = base_url();
//date_default_timezone_set ('America/Lima');

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

                            <h3 class='timeline-header'>  MESA DE PARTES</h3>

                            <div class='timeline-body'>
                                Su trámite ha sido INGRESADO por <b>MESA DE PARTES</b>.
                            </div>
                            
                        </div>
                    </div>";
                  $nro =0;
                  $bgcolorsituacion="bg-success";
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
                                  Su trámite ha sido ".(($rt->situacion_ruta=="DERIVADO")?"RECIBIDO":$rt->situacion_ruta)." en <b>$rt->area_destino</b>.
                              </div>
                              
                          </div>
                      </div>";
                    }
                    else {
                      
                      if ($solicitud->situacion=="ATENDIDO"){
                        echo "<div>
                            <i class='fas fa-university $bgcolorsituacion'></i>

                            <div class='timeline-item'>
                                

                                <h3 class='timeline-header'>  $rt->area_destino</h3>

                                <div class='timeline-body'>
                                    Su trámite fue Respondido</b>.
                                </div>
                                
                            </div>
                        </div>";
                      }
                      else{
                        echo "<div>
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

                  }



               ?>

                  
                    
                    
            </div>
            <?php 
            if (($solicitud->situacion=="ATENDIDO")||($solicitud->situacion=="RECHAZADO")){

                echo " <b>Respuesta </b>: <br> $rt->descripcion";
            }
            else{
              echo "<div class='callout callout-danger'>
                  <h5>Su trámite aún se encuentra en proceso</h5>

                  <p>Usted será notificado cuando su trámite haya sido completado</p>
                </div>";
            }
             
             ?>
          </div>
        </div>
  </section>
