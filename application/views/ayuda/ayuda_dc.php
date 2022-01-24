<style>
    ol li{
        padding-left: 10px;
    }
    .enlace-img{
        float: left;
        margin-right: 20px;
    }
</style>
<?php $vbaseurl=base_url();
$tpuser=strtolower($_SESSION['userActivo']->tipo);
?>
<!--<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.css">-->
<div class="content-wrapper">
    
     <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manuales y Tutoriales
            <small>Docentes</small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                
                
                
              <li class="breadcrumb-item active"><i class="fas fa-compass mr-1"></i> Ayuda</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-bold">Manuales</h3>
            </div>
            <div class="card-body">
                <?php 
                $dominio=str_replace(".", "_",getDominio());

                if ()
                echo 
                "<a href='{$vbaseurl}resources/mpd_$dominio.pdf'>
                    <img class='mr-1' src='{$vbaseurl}resources/img/icons/p_pdf.png' alt='PDF'>Manual de Usuario para Docentes
                </a><br>
                <a href='{$vbaseurl}resources/mpa_$dominio.pdf'>
                    <img class='mr-1' src='{$vbaseurl}resources/img/icons/p_pdf.png' alt='PDF'>Manual de Usuario para Estudiantes
                </a>";?> 
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-bold">Contáctanos</h3>
            </div>
            <div class="card-body">
                <span class="d-block mb-2">Comunicate con Soporte Virtual usando:</span>
                <a class="btn btn-success" href="https://wa.link/p0s9ao" target="_blank">
                <i class="fab fa-whatsapp fa-1x mr-1"></i> WhatsApp
                </a>
                <a class="btn btn-primary" href="https://m.me/educaerp" target="_blank">
                    <i class="fab fa-facebook-messenger  mr-1"></i> Messenger
                </a>
                <a class="btn btn-warning" href='<?php echo "{$vbaseurl}ayuda/ticket" ?>' target="_blank">
                    <i class="fas fa-ticket-alt mr-1"></i> Ticket
                </a>
                
                <span class="d-block mt-3">Tambien puedes contactarnos al:</span>
                <span class="d-block mt-2 pl-1">Correo: soporte@<?php echo getDominio(); ?></b></span>
                <span class="d-block mt-2 pl-1">Celular: 998660621</b></span>
            </div>
        </div>
        
        

       <div class="card">
            <div class="card-header">
                <h3 class="card-title text-bold">Video Tutoriales</h3>
            </div>
            <div class="card-body px-2 px-md-3">
                <span class="text-bold">Configurar ERP</span>
                <div class="row px-2">
                    
                    <div class="col-12 col-sm-4 col-md-3 my-2">
                        <a class="d-block h-100 rounded border-gray p-2" target="_blank" href="https://youtu.be/UEWjwO6D4fw">
                        <img class="img-fluid enlace-img" src="<?php echo base_url()."resources/img/icons/p_ytb.png" ?>" alt="">
                        <b>Paso 01:</b> <br> Conocer el ERP y Aperturar curso
                        </a>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 my-2">
                        <a class="d-block h-100 rounded border-gray p-2" target="_blank" href="https://youtu.be/vkcPgXSdJxs">
                        <img class="img-fluid enlace-img" src="<?php echo base_url()."resources/img/icons/p_ytb.png" ?>" alt="">
                        <b>Paso 02:</b> <br> Configurar Indicadores
                        </a>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 my-2">
                        <a class="d-block h-100 rounded border-gray p-2" target="_blank" href="https://youtu.be/JGr2LE2VHUc">
                        <img class="img-fluid enlace-img" src="<?php echo base_url()."resources/img/icons/p_ytb.png" ?>" alt="">
                        <b>Paso 03:</b> <br> Enrolar Alumnos
                        </a>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 my-2">
                        <a class="d-block h-100 rounded border-gray p-2" target="_blank" href="https://youtu.be/tKPidBawwAE">
                        <img class="img-fluid enlace-img" src="<?php echo base_url()."resources/img/icons/p_ytb.png" ?>" alt="">
                        <b>Paso 04:</b> <br> Configuar sesiones y tomar asistencias
                        </a>
                    </div>
                    
                </div>
            </div>

            <div class="card-body px-2 px-md-3">
                <span class="text-bold">Aula Virtual</span>
                <div class="row px-2">
                    <div class="col-12 col-sm-4 col-md-3 my-2">
                        <a class="d-block h-100 rounded border-gray p-2" target="_blank" href="https://youtu.be/3V2sp9l8Z98">
                        <img class="img-fluid enlace-img" src="<?php echo base_url()."resources/img/icons/p_ytb.png" ?>" alt="">
                        <b>Paso 01:</b> <br> Subir primeros archivos (Silabo y programación)
                        </a>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 my-2">
                        <a class="d-block h-100 rounded border-gray p-2" target="_blank" href="https://youtu.be/WCFn--s3dmo">
                        <img class="img-fluid enlace-img" src="<?php echo base_url()."resources/img/icons/p_ytb.png" ?>" alt="">
                        <b>Paso 02:</b> <br> Agrupar y Agregar vídeo de Youtube
                        </a>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 my-2">
                        <a class="d-block h-100 rounded border-gray p-2" target="_blank" href="https://youtu.be/mUZolgeDsFQ">
                        <img class="img-fluid enlace-img" src="<?php echo base_url()."resources/img/icons/p_ytb.png" ?>" alt="">
                        <b>Paso 03:</b> <br> Eliminar y ordenar ítems
                        </a>
                    </div>
                     
                </div>

                 <div class="row px-2">
                     <div class="col-12 col-sm-4 col-md-3 my-2">
                        <a class="d-block h-100 rounded border-gray p-2" target="_blank" href="https://youtu.be/EV5aIwx3AyQ">
                        <img class="img-fluid enlace-img" src="<?php echo base_url()."resources/img/icons/p_ytb.png" ?>" alt="">
                        <b>TIP 01:</b> <br> Configurar cuenta Youtube y subir nuestro primer video
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>