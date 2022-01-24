<?php
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>CONVOCATORIAS
          <small>Panel</small></h1>
        </div>
        
        
      </div>
    </div>
  </section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_convocatorias" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de Convocatorias</h3>
                <?php if (getPermitido("78")=='SI'){ ?>
		    	<div class="no-padding card-tools">
                	<a type="button" class="btn btn-sm btn-default" href="<?php echo $vbaseurl ?>portal-web/convocatorias/agregar"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
              <?php } ?>
		    </div>
            <div class="card-body">
                <?php $meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"); ?>
                <div class="btable">
                    <div class="thead col-12  d-none d-md-block">
                        <div class="row">
                            <div class='col-12 col-md-4'>
                                <div class='row'>
                                    <div class='col-2 col-md-2 td'>N°</div>
                                    <div class='col-10 col-md-10 td'>TITULO</div>
                                </div>
                            </div>
                            <div class='col-12 col-md-4 td'>
                                DETALLE
                            </div>
                            <div class='col-12 col-md-4 text-center'>
                                <div class='row'>
                                    <div class='col-sm-6 col-md-6 td'>
                                        <span>TIPO</span>
                                    </div>
                                    
                                    <div class='col-sm-6 col-md-6 td'>
                                        <span>ACCIÓN</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tbody col-12">
                        <?php
                        $nro = 0;
                        foreach ($items as $cmd) {
                        $nro ++;
                       
                        $datepubl =  new DateTime($cmd->creado) ;
                        $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
                        $vpublica= $dias[$datepubl->format('w')].". ".$datepubl->format('d/m/Y h:i a');          
                        $codigo_enc=base64url_encode($cmd->codigo);
                        $lnkarchivo = "";
                        $btneditar = "";
                        $btneliminar = "";
                        if (getPermitido("79")=='SI'){
                            $btneditar = "<a href='{$vbaseurl}portal-web/convocatorias/editar/$codigo_enc'>
                                            <i class='fas fa-pen fa-2x text-primary'></i>
                                        </a>";
                        }
                        if (getPermitido("80")=='SI'){
                            $btneliminar = "<a href='#' data-codigo='$codigo_enc' onclick='vw_pw_cm_pr_fn_eliminar_conv($(this));event.preventDefault();'>
                                            <i class='fas fa-trash fa-2x text-danger'></i>
                                        </a>";
                        }

                        echo 
                        "<div class='row cfila'>
                            <div class='col-12 col-md-4'>
                                <div class='row'>
                                    <div class='col-2 col-md-2 td'>$nro</div>
                                    <div class='col-10 col-md-10 td'>
                                        <a  href='#'>
                                           $cmd->titulo
                                        </a> <br>
                                        <small><i class='far fa-calendar-alt'></i> $vpublica</small> <br>
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-12 col-md-4 td'>
                                <span>$cmd->resumen</span>
                            </div>
                            <div class='col-12 col-md-4 text-center'>
                                <div class='row'>
                                    <div class='col-sm-6 col-md-6 td'>
                                        $cmd->tipo
                                    </div>
                                    
                                    <div class='col-sm-3 col-md-3 td'>
                                        $btneditar
                                    </div>
                                    
                                    <div class='col-sm-3 col-md-3 td'>
                                        $btneliminar
                                    </div>

                                </div>
                            </div>
                        </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
		</div>
	</section>
</div>
<?php  
echo 
"<script src='{$vbaseurl}resources/plugins/summernote8/summernote-bs4.min.js'></script>
<script src='{$vbaseurl}resources/dist/js/pages/convocatorias.js'></script>";
?>