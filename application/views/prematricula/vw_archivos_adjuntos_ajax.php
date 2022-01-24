<?php $vbaseurl = base_url();?>
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
        
        <span class='form-control-sm col-md-10'>
          <i class='fas fa-paperclip mr-1'></i> $ad->titulo
        </span>
        <a target='_blank' href='{$vbaseurl}upload/tramites/$ad->link' class='col-md-2'>".getIcono("P",$ad->link)." Descargar</a>
      </div>";
    }
  }
  
  ?>
  
</section>