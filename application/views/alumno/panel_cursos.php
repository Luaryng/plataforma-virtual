<?php $vbaseurl=base_url() ?>
<div class="content-wrapper">
	<section class="content-header">
      	<div class="container-fluid">
        	<div class="row mb-2">
          		<div class="col-sm-6">
            		<h1><?php echo $curso->unidad ?>
            		<small> <?php echo $curso->codseccion.$curso->division; ?></small></h1>
          		</div>
          		<div class="col-sm-6">
		            <ol class="breadcrumb float-sm-right">
		                <li class="breadcrumb-item">
		                    <a href="<?php echo $vbaseurl ?>alumno/mis-cursos-panel"><i class="fas fa-compass"></i> Unidades Didacticas</a>
		                </li>
		                
		                
		              <li class="breadcrumb-item active">Panel</li>
		            </ol>
          		</div>
        	</div>
      	</div><!-- /.container-fluid -->
    </section>

    <section class="content">
    	<?php include 'vw_panel_encabezado.php'; ?>

    	<div id="divcard-panel" class="card">
    		<div class="card-body p-2">
    			<div class="row">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="neo-box elevation-2 box-min bg-gradient-blue">

                            <div class="backtext">
                                <?php echo $curso->avance ?>
                            </div>
                             <i class="icon-back far fa-calendar-alt"></i>
                            <div class="title">
                                <b>SESIONES DIARIAS</b>
                            </div>
                            <div class="boton">
                                <a href="<?php echo $vbaseurl.'alumno/curso/sesiones/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($miembro); ?>" class="btn btn-success borde-blanco "><b><i class="fa fa-arrow-circle-right"></i></b></a>
                            </div>
                            <div class="descripcion">
                                <p class="h6 font-weight-bold">Actividad de Aprendizaje por día</p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="neo-box elevation-2 box-min bg-gradient-gray">
                            <i class="icon-back fas fa-cubes"></i>
                            <div class="title">
                                <b>AULA VIRTUAL</b>
                            </div>
                            <div class="boton">
                            
                                <a href="<?php echo $vbaseurl.'alumno/curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($miembro); ?>" class="btn btn-success borde-blanco "><b><i class="fa fa-arrow-circle-right"></i></b></a>
                            
                            </div>
                            <div class="descripcion">
                                <p class="h6 font-weight-bold">Material de la Unidad Didáctica</p>
                            </div>
                            
                        </div>
                    </div>
    			</div>
    		</div>
    	</div>
    </section>
</div>