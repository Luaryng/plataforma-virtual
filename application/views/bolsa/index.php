<?php
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>BOLSA DE TRABAJO
          <small>Panel</small></h1>
        </div>
        
        
      </div>
    </div>
  </section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_bolsa" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de Ofertas</h3>
		    	<div class="no-padding card-tools">
                	<a type="button" class="btn btn-sm btn-default" href="<?php echo $vbaseurl ?>portal-web/bolsa-de-trabajo/agregar"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
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
                            <div class='col-12 col-md-5 td'>
                                DETALLE
                            </div>
                            <div class='col-12 col-md-2 td text-center'>
                                
                                ACCIÓN
                                
                            </div>
                        </div>
                    </div>
                    <div class="tbody col-12">
                        <?php
                        $nro = 0;
                        foreach ($bolsa as $bls) {
                        $nro ++;
                       
                        $colortipo=($bls->tip=="TRABAJO")?"bg-info":"bg-warning";
                        $datepubl =  new DateTime($bls->fecha) ;
                        $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
                        $vpublica= $dias[$datepubl->format('w')].". ".$datepubl->format('d/m/Y h:i a');             
                        echo 
                        "<div class='row cfila'>
                            <div class='col-12 col-md-4'>
                                <div class='row'>
                                    <div class='col-2 col-md-2 td'>$nro</div>
                                    <div class='col-10 col-md-10 td'>
                                        $bls->titulo <br>
                                        <small><i class='far fa-calendar-alt'></i> $vpublica</small> <br>
                                        <small class='tboton $colortipo'>$bls->tip </small>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class='col-12 col-md-5 td'>
                                $bls->detalle"."...
                            </div>
                            <div class='col-12 col-md-3 text-center'>
                                <div class='row'>
                                    <div class='col-sm-4 col-md-4 td'>
                                        <span><img style='width: 100%;height: 50px' src='$vbaseurl"."resources/img/bolsa_trabajo/thumb/$bls->imagen'></span>
                                    </div>
                                    <div class='col-sm-4 col-md-4 td'>
                                        <a href='$vbaseurl"."portal-web/bolsa-de-trabajo/editar?idBols=".base64url_encode($bls->id)."'  class='btn btn-sm btn-info' title='Editar Bolsa Trabajo'>
                                            <i class='fas fa-pencil-alt'></i> <span class='d-block d-md-none'>Editar </span>
                                        </a>
                                    </div>
                                    <div class='col-sm-4 col-md-4 td'>
                                        <a href='#' data-codigo='".base64url_encode($bls->id)."' data-image='".base64url_encode($bls->imagen)."' class='btn btn-danger btn-sm vw_pw_bt_btn_delete' title='Eliminar Bolsa Trabajo'>
                                            <i class='fas fa-trash-alt'></i> <span class='d-block d-md-none'>Eliminar</span>
                                        </a>
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
<script src='{$vbaseurl}resources/dist/js/pages/portalweb.js'></script>";
?>