<?php $vbaseurl = base_url();?>
<section class="border mx-n2 p-3">
  
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="form-group col-md-5">
          <label class="m-0 font-weight-normal" for="cbocarrera">Programa</label>
          <br><span class='text-bold'><?php echo $ficha->carrera ?></span>
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
          <label class="m-0 font-weight-normal" >Género</label>
          <br><span class='text-bold'><?php echo $ficha->sexo ?></span>
        </div>
       
      
        <div class="form-group col-md-3">
          <label class="m-0 font-weight-normal" for="txttelefono">Telefono/Celular</label>
          <br><span class='text-bold'><?php echo $ficha->telefono ?></span>
        </div>
        <div class="form-group col-md-4">
          <label class="m-0 font-weight-normal" for="txtcorreo">Correo electrónico</label>
          <br><span class='text-bold'><?php echo $ficha->correo ?></span>
        </div>
      </div>
    </div>
   
    <div class="col-12">
      
      <div class="row">
        <div class="form-group col-md-12">
          <label class="m-0 font-weight-normal" for="txt_direccion">Dirección</label>
          <br><span class='text-bold'><?php echo "$ficha->direccion <br> $ficha->coddistrito $ficha->distrito " ?></span>
        </div>
        
      </div>
      
      <div class="row">
        <div class="col-md-12 text-right">
          <a href="<?php echo "{$vbaseurl}formacion-continua/ficha-pre-inscripcion/editar/".base64url_encode($ficha->codpre) ?>" class="btn btn-primary btn-flat float-right btn-lg">
            <i class="fa fa-pen"></i> Modificar
          </a>
        </div>
      </div>
      
    </div>
    
    
  </div>
  
  
</section>
<section class="border mx-n2 p-3">
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
    
    <span class='form-control-sm col-md-10 col-8'>
      <i class='fas fa-paperclip mr-1'></i> $ad->titulo
    </span>
    <div class='col-md-2 col-4'>
      <a target='_blank' href='{$vbaseurl}upload/cursoweb/$ad->link' class='col-md-2'>".getIcono("P",$ad->link)." Descargar</a>
    </div>
  </div>";
  }
  }
  
  ?>
  
</section>