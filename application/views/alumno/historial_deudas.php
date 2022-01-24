<style> 
.text-strike{
    text-decoration: line-through;
}

.not-active { 
    pointer-events: none; 
    cursor: default;
}


</style>
<?php
	$vbaseurl=base_url();
    $vuser=$_SESSION['userActivo'];
?>
<link rel="stylesheet" type="text/css" href="<?php echo $vbaseurl ?>resources/dist/css/paginador.css">

<div class="content-wrapper">

	<section id="s-cargado" class="content pt-1">
		<div id="divcard_bolsa" class="card">
		    <div class="card-header">
		    	<h3 class="card-title text-bold"><i class="fas fa-list-ul mr-1"></i> Mis Deudas</h3>
                <div class="card-tools">
                    <div class="btn-group dropleft">
                        <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Exportar
                        </button> 
                        <div class="dropdown-menu">
                            <a id='vw_exp_pdf' class='dropdown-item' href='#'><i class="fas fa-file-pdf text-danger"></i> PDF</a>
                            <!-- <a id='vw_exp_excel' class='dropdown-item' href='#'>Excel</a> -->
                        </div>
                    </div>
                </div>
		    </div>
            <div class="card-body">
                
                <?php $meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"); ?>
                <div class="btable mt-0">
                    <div class="thead col-12  d-none d-md-block">
                        <div class="row">
                            <div class='col-12 col-md-5'>
                                <div class='row'>
                                    <div class='col-2 col-md-2 td'>N°</div>
                                    <div class='col-10 col-md-10 td'>ESTUDIANTE</div>
                                </div>
                            </div>
                            <div class='col-12 col-md-3 td'>
                                CONCEPTO
                            </div>
                            <div class='col-12 col-md-4 text-center'>
                                <div class='row'>
                                    <div class='col-md-4 col-4 td'>
                                        <span>VENCE</span>
                                    </div>
                                    <div class='col-md-4 col-4 td'>
                                        <span>MONTO</span>
                                    </div>
                                    <div class='col-md-4 col-4 td'>
                                        <span>SALDO</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tbody col-12" id="divresult">
                        <?php
                            include "historial_deudas_detalle.php";
                        ?>
                    </div>
                </div>
                
            </div>
		</div>
	</section>
</div>

<script>
    $('#vw_exp_pdf').click(function(e) {
        e.preventDefault();
        
        var url_pdf = "alumno/historial/reporte/deudas/pdf";

        var url = base_url + url_pdf;
        var ejecuta = true;
        
        if (ejecuta == true) {
            window.open(url, '_blank');
        }
    });
</script>