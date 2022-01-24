<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">
<div class="content-wrapper">
     <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mis Unidades didácticas</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

  <section id="s-cargado" class="content">
   <div id="divcard-inscripcion" class="card">
      <div class="card-body">
        <?php
        $agrupar="";
        foreach ($miscursos as $key => $curso) {
          if (($curso->mostrar=="SI") && ($curso->activo=="SI")){
            if ($curso->periodo.'g'.$curso->sigla!=$agrupar){
              if($agrupar!="") echo "</div><br>";
              $agrupar=$curso->periodo.'g'.$curso->sigla;
              echo 
              "<div class='row'>
                  <span class='card-title text-primary'>
                    <h4>
                      <b><i class='fa fa-caret-square-o-right' aria-hidden='true'></i> ".$curso->periodo.' '.$curso->carrera."</b>
                    </h4>
                  </span>
              </div>
              <hr class='my-2'>
              <div class='row'>";
            }
            $avc=$curso->avance /$curso->sesiones * 100;
            $colorbox= ($curso->culminado=='SI') ? "bg-gradient-gray" : "bg-gradient-green";
          ?>
          <div class="col-md-4 col-sm-6 col-12">
            <div class="neo-box elevation-2 box-reg <?php echo $colorbox ?>">
              <div class="backtext">
                <?php echo $curso->codcarga."G".$curso->division ?>
              </div>

              <div class="title">
                <?php echo $curso->sigla.' '.$curso->ciclo.' '.$curso->codturno.' '.$curso->codseccion.$curso->division; ?>
              </div>
              <span style="font-size: 15px;"><b>Sesiones: <?php echo "$curso->avance de $curso->sesiones" ?></b></span>
              <div class="progress progress-xs no-padding no-margin">
                <div class="progress-bar bg-warning progress-bar-striped" style="width: <?php echo $avc ?>%"></div>
              </div>
              <div class="clearfix">
                <span class="pull-left"></span>
                <span class="pull-right"><b><?php echo round($avc,0) ?>%</b></span>
              </div>
              <div class="boton">
                <a href="<?php echo base_url().'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-primary borde-blanco "><b><i class="fa fa-arrow-circle-right"></i></b></a>
              </div>
              <div class="descripcion">
                <p> <?php echo $curso->unidad; ?></p>
                <span class="text-dark">SEDE: <?php echo $curso->sede ?></span>
              </div>
              
              
            </div>
            
            

          </div>
          <?php  } ?>
        <?php  } ?>
        
      </div>

    </div>
    
    
  </section>
</div>
