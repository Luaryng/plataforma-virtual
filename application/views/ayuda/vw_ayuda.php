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
$tpuser=$_SESSION['userActivo']->tipo;
$tnivel = $_SESSION['userActivo']->codnivel;
?>
<!--<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.css">-->
<style>
    .divideo p:nth-child(even) {
        margin: 0px;
    }
</style>
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
        <div class="card" id="divcard_manuales">
            <div class="card-header">
                <h3 class="card-title text-bold">Manuales</h3>
            </div>
            <div class="card-body">
                <?php 

                $dominio=str_replace(".", "_",getDominio());
                
                    echo "<ul class='order-list'>";

                    $nro = 0;
                    $grupom = "";
                    foreach ($manuales as $key => $tut) {
                        
                        if ($tut->tipo == "MANUAL") {
                            $nro++;
                            $color = ($nro % 2==0) ? "bg-lightgray border border-left-0 border-right-0":"";
                            $codigo64 = base64url_encode($tut->codigo);
                            $arrayAccs = explode(",", $tut->accesos);
                            $grupointm = $tut->grupo;
                            for ($i = 0; $i < count($arrayAccs); $i++) {
                                if (($arrayAccs[$i] == $tpuser) || ($arrayAccs[$i] == $tnivel)) {
                                    if ($grupointm != $grupom) {
                                        $grupom = $grupointm;
                                        echo "<div class='row mt-2'>
                                                    <span class='text-bold'>$grupom</span>
                                                </div>
                                            ";
                                    }
                                echo "<li data-id='$tut->codigo' class='$color'>
                                    <div class='col-12 px-0 py-2'>
                                        <div class='row p-0'>
                                            <div class='col-md-12 col-12 pt-1 ml-2'>
                                                <a target='_blank' href='$tut->enlace'>
                                                    <img class='mr-1' src='{$vbaseurl}resources/img/icons/p_pdf.png' alt='PDF'>
                                                    $tut->nombre
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>";
                                }
                            }

                        }
                    }
                    echo "</ul>";
                ?> 

            </div>
        </div>

       <div class="card">
            <div class="card-header">
                <h3 class="card-title text-bold">Video Tutoriales</h3>
            </div>
            
            <div class="card-body">
            <?php
            $nro = 0;
            $grupo = "";
            foreach ($manuales as $key => $vid) {
                if ($vid->tipo == "VIDEO") {
                    $nro++;
                    
                    $arrayAccsv = explode(",", $vid->accesos);
                    $grupoint = $vid->grupo;
                    
                    for ($i = 0; $i < count($arrayAccsv); $i++) {
                        if (($arrayAccsv[$i] == $tpuser) || ($arrayAccsv[$i] == $tnivel)) {
                            if ($grupoint != $grupo) {
                                if ($grupo != "") echo "</div>";
                                $grupo = $grupoint;
                                echo "<div class='row'>
                                            <span class='text-bold'>$grupo</span>
                                        </div>
                                    <div class='row px-2'>";
                            }
                        echo "<div class='col-12 col-sm-4 col-md-3 my-2'>
                                <a class='d-block h-100 rounded border-gray p-2 divideo' target='_blank' href='$vid->enlace'>
                                    <img class='img-fluid enlace-img' src='{$vbaseurl}resources/img/icons/p_ytb.png' alt=''>
                                    $vid->nombre
                                </a>
                            </div>";
                        }
                    }
                } 
            }
            ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-bold">Contáctanos</h3>
            </div>
            <div class="card-body">
                <span class="d-block mb-2">Comunicate con Soporte Virtual usando:</span>
                <a class="btn btn-success" href="https://api.whatsapp.com/send?phone=51983136078&text=Hola%20soporte%20virtual%20ERP,%20pertenezco%20al%20instituto%20%20y%20tengo%20una%20consulta%20%C2%BFpodr%C3%ADas%20ayudarme%3F" target="_blank">
                    <i class="fab fa-whatsapp fa-1x mr-1"></i> WhatsApp
                </a>
               
                <a class="btn btn-warning" href='<?php echo "{$vbaseurl}ayuda/ticket" ?>' target="_blank">
                    <i class="fas fa-ticket-alt mr-1"></i> Ticket
                </a>
                
                <span class="d-block mt-3">Tambien puedes contactarnos al:</span>
                <span class="d-block mt-2 pl-1"><b>Correo:</b> soporte@<?php echo getDominio(); ?></span>
                <span class="d-block mt-2 pl-1"><b>Celular:</b>  983136078</span>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    
</script>