<?php 
  $vbaseurl = base_url();
  $arraypublic = array();
  $dtpublicidad = $ficha->publicidad;
  if ($dtpublicidad != "" OR $dtpublicidad != null) {
    $arraypublic = explode(",", $dtpublicidad);
  }

  function obtienecheck($array, $valor)
  {
    if (count($array)> 0) {
      for ($i = 0; $i < count($array); $i++) {
            if ($array[$i] == $valor) {
                return $array[$i];
            }
        }
    }
  }
?>

<section class="border mx-n2 p-3">
  <ul class="nav nav-pills">
    <li class="nav-item">
      <a class="nav-link active" href="#fichapreins" data-toggle="tab">
        <i class="fas fa-list"></i> Preinscripción
      </a>
    </li>
    <li id="tabli-aperturafile" class="nav-item">
      <a class="nav-link" href="#contactopreins" data-toggle="tab">
        <i class="fas fa-user"></i> Contacto
      </a>
    </li>
    <li id="tabli-aperturafile" class="nav-item">
      <a class="nav-link" href="#adjuntospreins" data-toggle="tab">
        <i class="fas fa-file-alt"></i> Adjuntos (<?php echo count($adjuntos) ?>)
      </a>
    </li>
  </ul>
  <div class="tab-content">
    <div class="active tab-pane pt-3" id="fichapreins">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="form-group col-md-4">
              <label class="m-0 font-weight-normal" for="txt_modalidad">Modalidad</label>
              <br><span class='text-bold'><?php echo $ficha->modalidad ?></span>
            </div>
            <div class="form-group col-md-5">
              <label class="m-0 font-weight-normal" for="cbocarrera">Programa de estudios</label>
              <br><span class='text-bold'><?php echo $ficha->carrera ?></span>
            </div>
          
            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="txt_turno">Turno</label>
              <br><span class='text-bold'><?php echo $ficha->turno ?></span>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-4">
              <label class="m-0 font-weight-normal" for="txtape_paterno">Apellido Paterno</label>
              <br><span class='text-bold'><?php echo $ficha->paterno ?></span>
            </div>
            <div class="form-group col-md-4">
              <label class="m-0 font-weight-normal" for="txtape_materno">Apellido Materno</label>
              <br><span class='text-bold'><?php echo $ficha->materno ?></span>
            </div>
            <div class="form-group col-md-4">
              <label class="m-0 font-weight-normal" for="txtnombres">Nombres</label>
              <br><span class='text-bold'><?php echo $ficha->nombres ?></span>
            </div>
          </div>
          <div class="row ">
            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="txt_tpdoc"><?php echo $ficha->tipodoc ?></label>
              <br><span class='text-bold'><?php echo $ficha->numero ?></span>
            </div>
            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="txt_genero">Estado civil</label>
              <br><span class='text-bold'><?php echo $ficha->estcivil ?></span>
            </div>
            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="txt_fecnac">Fecha Nacimiento</label>
              <br>
              <span class='text-bold'><?php echo date("d/m/Y", strtotime($ficha->fecnac));?></span>
            </div>
            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="txt_fecnac">Edad</label>
              <br><span class='text-bold'><?php
                $dia_actual = date("Y-m-d");
                $edad_diff = date_diff(date_create( $ficha->fecnac), date_create($dia_actual))->format('%y');
                $edad=($edad_diff>0)?"($edad_diff Años)":"--";
                echo "$edad";
              ?></span>
            </div>
            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" >Lugar de Nacimiento</label>
              <br><span class='text-bold'><?php echo $ficha->lugnac ?></span>
            </div>
            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" >Género</label>
              <br><span class='text-bold'><?php echo $ficha->sexo ?></span>
            </div>
            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" >Trabaja?</label>
              <br><span class='text-bold'><?php echo $ficha->trabaja ?></span>
            </div>
            <?php if ($ficha->trabaja == 'SI'): ?>
            <div class="form-group col-md-4">
              <label class="m-0 font-weight-normal" for="txt_lugtrabaja">Lugar trabaja</label>
              <br><span class='text-bold'><?php echo "$ficha->lugtrabaja" ?></span>
            </div>
            <?php endif ?>
            <div class="form-group col-md-4">
              <label class="m-0 font-weight-normal" for="txt_discap">Tiene alguna discapacidad?</label>
              <br><span class='text-bold'><?php echo "$ficha->discapacidad" ?></span>
            </div>
            <?php if ($ficha->discapacidad == 'SI'): ?>
            <div class="form-group col-md-8">
              <label class="m-0 font-weight-normal" for="txt_discapdet">Discapacidad</label>
              <br><span class='text-bold'><?php echo "$ficha->nomdiscapacidad" ?></span>
            </div>
            <?php endif ?>
            <div class="form-group col-md-6">
              <label class="m-0 font-weight-normal" for="txt_lenguaorig">Lengua originaria</label>
              <br><span class='text-bold'><?php echo "$ficha->lenguaorig" ?></span>
            </div>
            <div class="form-group col-md-12">
              <label class="m-0 font-weight-normal" for="txt_centroestud">Último Colegio o Instituto en el que estudiaste</label>
              <br><span class='text-bold'><?php echo $ficha->centro." - ".$ficha->aniosecundaria ?></span>
            </div>
          </div>
          <hr class="my-2">
          <div class="row">
            <?php if ($ficha->nompadre != ''): ?>
            <div class="form-group col-md-6">
              <label class="m-0 font-weight-normal" for="txt_nompadre">Apellidos y nombres padre</label>
              <br><span class='text-bold'><?php echo $ficha->nompadre ?></span>
            </div>
            <?php endif ?>
            <?php if ($ficha->ocuppadre != ''): ?>
            <div class="form-group col-md-6">
              <label class="m-0 font-weight-normal" for="txt_nompadreocup">Ocupación padre</label>
              <br><span class='text-bold'><?php echo $ficha->ocuppadre ?></span>
            </div>
            <?php endif ?>
            <?php if ($ficha->nommadre != ''): ?>
            <div class="form-group col-md-6">
              <label class="m-0 font-weight-normal" for="txt_nommadre">Apellidos y nombres madre</label>
              <br><span class='text-bold'><?php echo $ficha->nommadre ?></span>
            </div>
            <?php endif ?>
            <?php if ($ficha->ocupmadre != ''): ?>
            <div class="form-group col-md-6">
              <label class="m-0 font-weight-normal" for="txt_nommadreocup">Ocupación madre</label>
              <br><span class='text-bold'><?php echo $ficha->ocupmadre ?></span>
            </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane pt-3" id="contactopreins">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
             <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="txttelefono">Telefono/Celular</label>
              <br><span class='text-bold'><?php echo $ficha->telefono ?></span>
            </div>
            <div class="form-group col-md-4">
              <label class="m-0 font-weight-normal" for="txtcorreo">Correo electrónico</label>
              <br><span class='text-bold'><?php echo $ficha->correo ?></span>
            </div>
            <div class="form-group col-md-5">
              <label class="m-0 font-weight-normal" for="txt_direccion">Dirección</label>
              <br><span class='text-bold'><?php echo "$ficha->direccion <br> $ficha->coddistrito $ficha->distrito " ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane pt-3" id="adjuntospreins">
      <?php
      if (count($adjuntos)==0){
      echo
      "<div class='row border-bottom'>
        
        <h4 class='form-control-sm col-md-10'>
        No se encontraron archivos adjuntos
        </h4>
        
      </div>";
      }
      else{
        foreach ($adjuntos as $key => $ad) {
        if (trim($ad->titulo)=="") $ad->titulo=$ad->archivo;
        echo
        "<div class='row border-bottom'>
          
          <span class='form-control-sm col-md-10'>
            <i class='fas fa-paperclip mr-1'></i> $ad->titulo
          </span>
          <a target='_blank' href='{$vbaseurl}upload/tramites/$ad->link' class='col-md-2'>".getIcono("P",$ad->link)." Descargar</a>
        </div>";
        }
      }
      
      ?>
      <div class="row mt-4">
        <h6>¿Como se enteró de nuestros programas?</h6>
        <?php 
        $nro = 0;
        foreach ($publicidad as $key => $pb) { 
          $nro++;
        ?>
          <div class="col-12 my-1 ml-2">
            <div class="">
              <?php echo (obtienecheck($arraypublic, $pb->codigo) == $pb->codigo) ? '<i class="fas fa-check-square"></i>': '<i class="far fa-square"></i>' ?>
              <span class="font-weight-normal"><?php echo $pb->nombre ?></span>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div> 
  
</section>
