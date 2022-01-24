<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">
<div class="content-wrapper">
     <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mis Cursos</h1>
          </div>
          <div class="col-sm-6">
          <?php 
            /*$domimail=getDominio();
            if ($domimail=="charlesashbee.edu.pe"){
              if ($matriculas->ciclo=="01"){

               echo "<a target='_blank' class='btn btn-info' href='".base_url()."upload/HORARIO-2020-I-CICLO-1.pdf'>Descargar Mi Horario</a>";
              }
              elseif ($matriculas->ciclo=="03") {
                echo "<a target='_blank' class='btn btn-info' href='".base_url()."upload/HORARIO-2020-I-CICLO-3.pdf'>Descargar Mi Horario</a>";
              }
            }*/
           ?>
           
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

  <section id="s-cargado" class="content">
   <div id="divcard-inscripcion" class="card">
      <div class="card-body p-2">
        <?php
        $agrupar="";
        $ncursos=0;
        foreach ($miscursos as $key => $curso) {
          if (($curso->mostrar=="SI") && ($curso->eliminado=="NO")){
            $ncursos++;
          if ($curso->periodo.'g'.$curso->sigla!=$agrupar){
          if($agrupar!="") echo "</div><br>";
          $agrupar=$curso->periodo.'g'.$curso->sigla;
          echo "<div class='card-header no-padding'>
              <span class='card-title text-primary'>
              <h2><b>".$curso->periodo.' '.$curso->carrera."</b></h2>
              </span>
              <hr class='no-margin'>
            </div>

            <div class='row margin-top-10px'>";
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
              <small class="float-left"><?php echo "$curso->docpaterno $curso->docmaterno $curso->docnombres"; ?></small>
              <span class="float-right"><b><?php echo round($avc,0) ?>%</b></span>

            </div>
            <div class="boton">
              <a href="<?php echo base_url().'alumno/curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($curso->codmiembro); ?>" class="btn btn-primary borde-blanco "><b><i class="fa fa-arrow-circle-right"></i></b></a>
            </div>
            <div class="descripcion">
              <p> <?php echo $curso->unidad; ?></p>
            </div>
          </div>
          

        </div>
        <?php  } ?>
        <?php  } 
          
           

          if ($ncursos==0){ ?>
          <div class="callout callout-info">
            <h4>Bienvenido!</h4>
             
              A los alumnos ingresantes se les comunica que en el transcurso de la semana se estará actualizando su plataforma y tendrán acceso a su Unidades didácticas virtuales.
              <br>
              Gracias por la espera

          </div>
        <?php  } ?>
        
      </div>

    </div>
    
    
  </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>
