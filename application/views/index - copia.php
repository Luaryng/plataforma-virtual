 <?php 
 $vuser=$_SESSION['userActivo'];
 $vbaseurl=base_url();
  ?>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">

        <div class="row mb-2">
          


          <div class="col-sm-9">
            
             <br>
             
              <?php if ($vuser->tipo == 'AL'): ?>
              <div class="callout callout-info">
                <h5><?php
                 $nombres=explode(" ",$vuser->nombres);

                 echo $nombres[0] ?>, USA TU CORREO INSTITUCIONAL</h5>
                <p>Hemos puesto a disposición de nuestros estudiantes su propio correo institucional. <br><br>

                  Correo: <b><?php echo $vuser->ecorporativo ?></b><br>
                  Clave: <b><?php echo $vuser->usuario.((getDominio()=="iestpcanchaque.edu.pe") ? "2019":"") ?></b> <br>
                  (Recuerda que tu clave es en mayúsculas) <br>
                  Al ingresar te pedirá que ingreses 2 veces una nueva clave que solo tu conocerás <br><br>
                  Para ingresar debes acceder al link de nuestra pagina <a class=" text-primary text-decoration-none" href="https://<?php echo getDominio() ?>"><?php echo getDominio()  ?></a> luego en INTRANET / CORREO. <br>
                  Tambien puedes ingresar en el icono de  <a class=" text-primary text-decoration-none" href="https://mail.google.com/a/<?php echo getDominio() ?>"><i class="far fa-envelope text-bold"></i></a> ubicado en la parte superior <br><br>
                  Si tienes algún problema para ingresar puedes comunicarte al 998660621 a través de SMS o Whatsapp
                </p>
              </div>
              <?php endif ?>
            <!-- <div class="callout callout-info">
              <h5>EXAMEN DE ADMISIÓN PARA INGRESANTES 2020</h5>
              <p>En las horas de la tarde se publicaran los resultados, en facebook puede buscarlo como<br>
                <b>iestp Huarmaca</b>
                <br>
              </p>
            </div>
            
            <br>
            <div class="callout callout-info">
              <h5>EXAMEN DE ADMISIÓN PARA INGRESANTES 2020-I</h5>
              <p>El EXAMEN DE ADMSIÓN se realizará el sabado 16 de mayo de 10:00 am hasta a 12:00 del día <br>
                NOTA: El enlace lo encontrarás aquí mismo<br>
              </p>
              
             
            </div> 
            -->
            <?php if (getDominio()=="charlesashbee.edu.pe"): ?>
              <div class="callout callout-info">
                <h5><span class="text-danger">NUEVO</span> CRONOGRAMA DEL PERIODO ACADEMICO 2020-II</h5>
                <p>Programación del Cronograma del Periodo Académico 2020-II <br>  
                  
                  <br>
                <a class="text-primary text-decoration-none" target="_blank" href="<?php echo base_url() ?>upload/REPROGRAMACION-DEL-CRONOGRAMA-DE-EVALUACIONES-II-2020.pdf"><?php echo getIcono("P","des.pdf") ?> Descargar Cronograma</a></p>
              </div>

              <?php if ($vuser->tipo != 'AL'): ?>
              <div class="callout callout-info">
                <h5><span class="text-danger">NUEVO</span> NORMAS DE INICIO DEL PERIODO ACADEMICO 2020-II</h5>
                <p>Normas de inicio del Periodo Académico 2020-II <br>  
                  
                  <br>
                <a class="text-primary text-decoration-none" target="_blank" href="<?php echo base_url() ?>upload/NORMAS20202.pdf"><?php echo getIcono("P","des.pdf") ?> Descargar Normas</a></p>
              </div>


              <div class="callout callout-info">
                <h5><span class="text-danger">NUEVO</span> PLAN DE CAPACITACIÓN A DOCENTES Y ALUMNOS EN EL MANEJO DE ENTORNOS VIRTUALES 2020</h5>
                <p>Plan de Capacitación en el Uso de Plataforma Virtual <br>  
                  
                  <br>
                <a class="text-primary text-decoration-none" target="_blank" href="<?php echo base_url() ?>upload/plandecapacitacion.pdf"><?php echo getIcono("P","des.pdf") ?> Descargar Plan</a></p>
              </div>


              <?php endif ?>
            <?php endif ?>

          </div>
         
        </div>
      </div>
    </div>
    

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-md-3 text-sm-center">
            <?php if ($vuser->tipo=="AL"){
              echo 
              "
                <div class='card'>
                  <div class='card-body'>
                  <a href='{$vbaseurl}alumno/aula-virtual  '>
                  <i class='fas fa-cubes fa-4x d-none d-sm-block'></i>
                  <i class='fas fa-cubes fa-1x d-sm-none d-inline-block mr-1'></i>
                  Mis Unidades Didácticas
                  </a>
                  </div>
                </div>
              ";
            }
            elseif ($vuser->tipo=="AD"){
              # code...
            }
            else{
              echo 
              "
                <div class='card'>
                  <div class='card-body'>
                  <a href='{$vbaseurl}docente/mis-cursos  '>
                  <i class='fas fa-cubes fa-4x d-none d-sm-block'></i>
                  <i class='fas fa-cubes fa-1x d-sm-none d-inline-block mr-1'></i>
                  Mis Unidades Didácticas
                  </a>
                  </div>
                </div>
              ";
            }
            ?>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>