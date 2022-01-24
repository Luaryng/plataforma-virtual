<?php $vbaseurl=base_url(); ?>
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $curso->unidad ?>
            <small> <?php echo $curso->codseccion.$curso->division; ?></small></h1>
          </div>
        <?php if ($curso->culminado=='NO'){ ?>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="btn btn-warning" href="<?php echo $vbaseurl.'curso/configuracion/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><i class="fas fa-cogs"></i> Configuración</a></li>
            </ol>
          </div>
        <?php } ?>
        </div>
      </div><!-- /.container-fluid -->
    </section>

            <section id="s-cargado" class="content">
                <div id="divcard-inscripcion" class="card card-success">
                    
                    <div class="col-12 col-md-12 p-3">
                        <div class="row">
                            <?php
                            $avc=$curso->avance /$curso->sesiones * 100
                            ?>
                            <div class="col-12 col-md-9">
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <div class="row">
                                            <span class="col-4">Periodo:</span>
                                            <span id="divperiodo" class="col-8"><b><?php echo $curso->periodo; ?></b></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-8">
                                        <div class="row">
                                            <span class="col-4 col-md-3">Programa:</span>
                                            <span id="divcarrera" class="col-8 col-md-9"><b><?php echo $curso->carrera; ?></b></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="row">
                                            <span class="col-4">Semestre:</span>
                                            <span id="divciclo" class="col-8"><b><?php echo $curso->ciclo; ?></b></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="row">
                                            <span class="col-4 col-md-6">Turno:</span>
                                            <span id="divturno" class="col-8 col-md-6"><b><?php echo $curso->codturno; ?></b></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="row">
                                            <span class="col-4">Sección:</span>
                                            <span id="divseccion" class="col-8"><b><?php echo $curso->codseccion.$curso->division; ?></b></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-10 col-md-8">
                                        <div class="row">
                                            <span class="col-4 col-sm-3 col-md-2">Docente:</span>
                                            <span id="divdocente" class="col-8 col-sm-9 col-md-10"><b><?php echo "$curso->docpaterno $curso->docmaterno $curso->docnombres"; ?></b></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        
                                             <h3 >ID: <b class="text-primary"><?php echo $curso->codcarga."G".$curso->division; ?></b></h3>
                                        
                                    </div>
                                    <!--<div class="col-sm-10 col-md-8">
                                        <div class="row">
                                            <span class="col-4 col-sm-3 col-md-2">Correo:</span>
                                            <span id="divdocente" class="col-8 col-sm-9 col-md-10"><b><?php echo "$curso->ecorporativo"; ?></b></span>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                            <div class="col-12 col-md-3 text-right">
                                <div class="callout callout-success no-margin padding-bottom-3px">
                                    
                                    <span style="font-size: 20px;">Sesiones: <?php echo "$curso->avance de $curso->sesiones" ?> </span>
                                    <div class="clearfix">
                                        <span class="float-left"></span>
                                        <small class="float-right"><?php echo round($avc,0) ?>%</small>
                                    </div>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-blue" style="width: <?php echo $avc ?>%"></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div id="divcard-inscripcion" class="card">
                    <div class="card-body p-2">
                        <div id="curdivmensaje" >
                            <?php
                            if ($curso->avance > $curso->sesiones){
                            echo "<div class='alert alert-danger alert-dismissible'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                <h4><i class='icon fa fa-ban'></i> Alerta!</h4>
                                <h4>Estimado docente, en <b>CONFIGURACIÓN</b> indicar correctamente la cantidad <b>TOTAL</b> de sesiones <b>DURANTE EL CICLO</b></h4>
                            </div>";
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="neo-box elevation-2 box-min bg-gradient-gray">
                                    <i class="icon-back fas fa-cubes"></i>
                                    <div class="title">
                                        <b>AULA VIRTUAL</b>
                                    </div>
                                    <div class="boton">
                                        <a href="<?php echo $vbaseurl.'curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-success borde-blanco "><b><i class="fa fa-arrow-circle-right"></i></b></a>
                                    </div>
                                    <div class="descripcion">
                                        <p>Material de la Unidad Didáctica</p>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="neo-box elevation-2 box-min bg-gradient-purple">
                                    <div class="backtext">
                                        <?php echo $curso->nalum ?>
                                    </div>
                                     <i class="icon-back fas fa-users"></i>
                                    <div class="title">
                                        <b>ESTUDIANTES</b>
                                    </div>
                                    <div class="boton">
                                        <a href="<?php echo $vbaseurl.'curso/miembros/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-success borde-blanco "><b><i class="fa fa-arrow-circle-right"></i></b></a>
                                    </div>
                                    <div class="descripcion">
                                        <p>Listado</p>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            
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
                                        <a href="<?php echo $vbaseurl.'curso/sesiones/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-success borde-blanco "><b><i class="fa fa-arrow-circle-right"></i></b></a>
                                    </div>
                                    <div class="descripcion">
                                        <p>Actividad de Aprendizaje por día</p>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="neo-box elevation-2 box-min bg-gradient-red">
                                    <i class="icon-back far fa-calendar-check"></i>
                                    <div class="title">
                                        <b>ASISTENCIA</b>
                                    </div>
                                    <div class="boton">
                                        <a href="<?php echo $vbaseurl.'curso/asistencias/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-success borde-blanco "><b><i class="fa fa-arrow-circle-right"></i></b></a>
                                    </div>
                                    <div class="descripcion">
                                        <p>Registro de Asistencia</p>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="neo-box elevation-2 box-min bg-gradient-olive">
                                    <i class="icon-back fas fa-calculator"></i>
                                    <div class="title">
                                        <b>EVALUACIONES</b>
                                    </div>
                                    <div class="boton">
                                        <a href="<?php echo $vbaseurl.'curso/evaluaciones/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-success borde-blanco "><b><i class="fa fa-arrow-circle-right"></i></b></a>
                                    </div>
                                    <div class="descripcion">
                                        <p>Registro de Notas</p>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <?php if ($curso->culminado=='NO'){ ?>
                                <?php if ((getDominio()=="charlesashbee.edu.pe")|| (getDominio()=="iesap.edu.pe")): ?>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="neo-box elevation-2 box-min bg-gradient-info">
                                            <i class="icon-back fas fa-sort-numeric-up"></i>
                                            <div class="title">
                                                <b>INDICADORES</b>
                                            </div>
                                            <div class="boton">
                                                <a href="<?php echo $vbaseurl.'curso/indicadores-only/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-success borde-blanco "><b><i class="fa fa-arrow-circle-right"></i></b></a>
                                            </div>
                                            <div class="descripcion">
                                                <p>Lista de Indicadores</p>
                                            </div>
                                        </div>
                                    </div>  
                                <?php else: ?>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="neo-box elevation-2 box-min bg-gradient-info">
                                            <i class="icon-back fas fa-sort-numeric-up"></i>
                                            <div class="title">
                                                <b>INDICADORES</b>
                                            </div>
                                            <div class="boton">
                                                <a href="<?php echo $vbaseurl.'curso/indicadores/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-success borde-blanco "><b><i class="fa fa-arrow-circle-right"></i></b></a>
                                            </div>
                                            <div class="descripcion">
                                                <p>Lista de Indicadores</p>
                                            </div>
                                        </div>
                                    </div>    
                                      
                                <?php endif ?>

                            
                            <?php }
                            if ($curso->culminado=='SI'){ ?>
                                    <?php if ($config->conf_doc_rec == "SI"): ?>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="neo-box elevation-2 box-min bg-gradient-orange">
                                            <i class="icon-back fas fa-sort-numeric-up"></i>
                                            <div class="title">
                                                <b>RECUPERACIÓN</b>
                                            </div>
                                            <div class="boton">
                                                <a href="<?php echo $vbaseurl.'curso/recuperacion/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-success borde-blanco "><b><i class="fa fa-arrow-circle-right"></i></b></a>
                                            </div>
                                            <div class="descripcion">
                                                <p>Recuperación Final</p>
                                            </div>
                                        </div>
                                    </div>    
                                    <?php endif ?>
                                <?php 
                            }
                            ?>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="neo-box elevation-2 box-min bg-gradient-yellow">
                                    <i class="icon-back fas fa-book"></i>
                                    <div class="title">
                                        <b>DOCUMENTOS</b>
                                    </div>
                                    <div class="boton">
                                        <a href="<?php echo $vbaseurl.'curso/documentos/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-success borde-blanco ">
                                            <b><i class="fa fa-arrow-circle-right"></i></b>
                                        </a>
                                    </div>
                                    <div class="descripcion">
                                        <p>Documentos del curso</p>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>