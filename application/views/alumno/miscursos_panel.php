<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">
<div class="content-wrapper">
 	<section class="content-header">
  		<div class="container-fluid">
    		<div class="row mb-2">
      			<div class="col-sm-6">
        			<h1>Mis Unidades Didácticas</h1>
      			</div>
      			<div class="col-sm-6">
       
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
		          			/*echo "<div class='card-header no-padding'>
		              				<span class='card-title text-primary'>
		              					<h2><b>".$curso->periodo.' '.$curso->carrera."</b></h2>
		             				</span>
		              				<hr class='no-margin'>
		            			</div>
		            			<div class='row margin-top-10px'>";*/
		            		echo "<div class='card-header no-padding'>
		              				<span class='card-title text-primary'>
		              					
		             				</span>
		              				<hr class='no-margin'>
		            			</div>
		            			<div class='row margin-top-10px'>";
		          		}
		          		$avc=$curso->avance /$curso->sesiones * 100;
		          		$colorbox= ($curso->culminado=='SI') ? "bg-gradient-gray" : "bg-gradient-green";
		    ?>
        		<div class="col-md-4 col-sm-6 col-12 mb-3">
          			<div class="col-12 py-2 elevation-2 border <?php echo $colorbox ?>">

          				<div class="row">
          					<div class="col-9">
          						<h6> <?php echo $curso->unidad; ?></h6>
          					</div>
          					<div class="col-3 text-right">
          						<h6> <?php echo $curso->codcarga."G".$curso->division; ?></h6>
          						<a href="<?php echo base_url().'alumno/curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($curso->codmiembro); ?>" class="btn btn-primary border elevation-2"><b><i class="fa fa-arrow-circle-right"></i></b></a>
          					</div>

          				</div>


			            
            			<span style="font-size: 15px;"><b>Sesiones: <?php echo "$curso->avance de $curso->sesiones" ?></b></span>
			            <div class="progress progress-xs no-padding no-margin">
			              	<div class="progress-bar bg-warning progress-bar-striped" style="width: <?php echo $avc ?>%"></div>
			            </div>
			            <div class="clearfix">
			              	<small class="float-left"><?php echo "$curso->docpaterno $curso->docmaterno $curso->docnombres"; ?> 
			              		<!--<br><span class="text-dark text-bold"><?php //echo $curso->carga_sede ?></span>-->
			              	</small>
			              	<span class="float-right"><b><?php echo round($avc,0) ?>%</b></span>

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
