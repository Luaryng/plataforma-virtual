<?php $vbaseurl = base_url()?>
<style>
  .adjuntos-description {
    color: #6c757d;
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
</style>
<div class="row">
  <div class="col-md-7 border-right">
    <div class="row">
      <div class="col-12">
        <h5 id="md_vd_titulo" class="border rounded bg-lightgray p-1">TRÁMITE N° <b><?php echo $solicitud->codseg ?></b></h5>
      </div>
      <div class="col-12">
        <h6 id="md_vd_solicitante" class="bg-lightgray border rounded p-1" >Solicitante: <b><?php echo "$solicitud->tipodoc - $solicitud->nrodoc <br> $solicitud->solicitante" ?></b></h6>
      </div>

    </div>

    <div class="row">
      <div class="col-6">
        Tipo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;
        <span class="text-bold"><?php echo $solicitud->tramite ?></span>
      </div>
      <div class="col-6">
        Ingresó&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;
        <span class="text-bold">
          <?php
          $datereg =  new DateTime($solicitud->fecha);
          echo $datereg->format('d/m/Y h:i a');
          ?>
          
        </span>
      </div>
      <div class="col-12">
        Asunto&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;
        <span class="text-bold text-primary"><u><?php echo $solicitud->asunto ?></u></span>
      </div>
      <div class="col-12">
        Domicilio:
        <span class="text-bold"> <?php echo $solicitud->domicilio ?></span>
      </div>
      <div class="col-12 col-md-6">
        Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
        <span class="text-bold"> <?php echo $solicitud->email_personal ?></span>
      </div>
      <div class="col-12 col-md-6">
        Tel. Cel.:&nbsp;&nbsp;
        <span class="text-bold"> <?php echo $solicitud->telefono ?></span>
      </div>
      <?php if (trim($solicitud->sitest)!="" || $solicitud->sitest != null): ?>
      <div class="col-12 col-md-6">
        Situación actual&nbsp;:&nbsp;
        <span class="text-bold"> <?php echo $solicitud->sitest ?></span>
      </div>
      <?php endif ?>

      <?php if (trim($solicitud->carnet)!="" || $solicitud->carnet != null): ?>
      <div class="col-12 col-md-6">
        Carné&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
        <span class="text-bold"> <?php echo $solicitud->carnet ?></span>
      </div>
      <?php endif ?>

      <?php if ($solicitud->periodo != null): ?>
      <div class="col-12 col-md-6">
        Periodo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
        <span class="text-bold"> <?php echo $solicitud->periodo ?></span>
      </div>
      <?php endif ?>

      <?php if ($solicitud->carrera != null): ?>
      <div class="col-12 col-md-6">
        Programa:
        <span class="text-bold"> <?php echo $solicitud->carrera ?></span>
      </div>
      <?php endif ?>

      <?php if ($solicitud->ciclo != null): ?>
      <div class="col-12 col-md-6">
        Semestre&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
        <span class="text-bold"> <?php echo $solicitud->ciclo ?></span>
      </div>
      <?php endif ?>

      <?php if ($solicitud->turno != null): ?>
      <div class="col-12 col-md-6">
        Turno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
        <span class="text-bold"> <?php echo $solicitud->turno ?></span>
      </div>
      <?php endif ?>

      <?php if ($solicitud->seccion != null): ?>
      <div class="col-12 col-md-6">
        Sección&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
        <span class="text-bold"> <?php echo $solicitud->seccion ?></span>
      </div>
      <?php endif ?>
    </div>
    <div class="form-group">
      <br>
      <div class=" col-md-12 border border-primary rounded py-2" style="min-height: 60px">
        <?php
        if (trim($solicitud->contenido)==""){
        echo "<Sin mensaje>";
        }
        else{
        echo "$solicitud->contenido";
        }
        
        ?>
        
      </div>
      <br>
      <div class="col-12">
        <h4 class="form-title mt-0 mb-1">Archivos adjuntos</h4>
        <?php
        foreach ($adjuntos as $key => $ad) {
        if (trim($ad->titulo)=="") $ad->titulo=$ad->archivo;
        echo
        "<div class='row border-bottom'>
          
          <span class='form-control-sm col-md-8 text-truncate'>
            <i class='fas fa-paperclip mr-1'></i> $ad->titulo
          </span>
          <a target='_blank' href='{$vbaseurl}upload/tramites/$ad->link' class='col-md-4'>".getIcono("X",$ad->link)." Descargar</a>
        </div>";
        }
        ?>
      </div>
    </div>
  </div>
  <div class="col-md-5">
    <h4 class="form-title mt-0 mb-1">Historial (Derivaciones)</h4>


      <div class=" col-12 p-0">
        <?php
        $nro=0;
        $bgcolorsituacion="bg-success";
        foreach ($rutas['ruta'] as $key => $rt) {
           $div_nuevo="";
           
          if ($nro>0){
            if ($solicitud->idruta_actual==$rt->codruta){
              $div_nuevo="<div class='float-right pt-1'><i class='fas fa-star fa-spin fa-lg text-success'></i></div>";
            }
            $cod64=base64url_encode($rt->codsolicitud);
            $rut64=base64url_encode($rt->codruta);
            
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
              <div class='col-12 col-md-12'>
                <div class='row mb-1'>
                  <div class='col-md-6'><b>De: </b>".
                    (($rt->codarea_origen=='3')?'':$rt->area_origen.'<br>').
                    (($rt->nom_origen=="")?"":"<small> $rt->nom_origen </small><br>").
                    date("d/m/Y h:i A", strtotime($rt->fecha )).
                  "</div>
                   <div class='col-md-6'>$div_nuevo
                    <b>Para: </b>
                    $rt->area_destino <br>".
                    (($rt->usuario_destino=='')?'':'<small>'.$rt->nom_destino.'</small><br>').
                    (($rt->fecha_p=='')?'':date("d/m/Y h:i A", strtotime($rt->fecha_p ))).
                  "</div>
                </div>
              </div>
             
              <div class='col-12 col-md-8'>
                $rt->descripcion
              </div>
              <div class='col-12 col-md-4 border-left'>
                <small class='tboton $bgcolorsituacion '>$rt->situacion_ruta</small><br>
                Adjuntos:<br>";
                //var_dump($adjuntos);
                foreach ($rutas['adjuntos'] as $kad => $adj) {
                $icon=getIcono("X",$adj->link);
                $titulo=(trim($adj->titulo)=="") ? $adj->archivo : $adj->titulo;
                if ($adj->codruta==$rt->codruta){
                echo "<a target='_blank' href='{$vbaseurl}upload/tramites/{$adj->link}'>$icon $titulo</a><br>";
                unset($rutas['adjuntos'][$kad]);
                }
                elseif (is_null($adj->codruta)){
                //echo "<a target='_blank' href='{$vbaseurl}upload/tramites/{$adj->link}'>$icon $titulo</a><br>";
                unset($rutas['adjuntos'][$kad]);
                }
                
                $icon="";
                $titulo="";
                }
                echo
              "</div>
            </div>";
          }
          
          $nro++;
        }
        ?>
      </div>
      

  </div>
</div>