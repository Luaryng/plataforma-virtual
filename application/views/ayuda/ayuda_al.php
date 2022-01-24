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
                echo 
                "
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
        
        

      
    </section>
</div>