<?php
	$vbaseurl=base_url();
    $vuser=$_SESSION['userActivo'];
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>DOCUMENTOS
          <small>Panel</small></h1>
        </div>
        
        
      </div>
    </div>
  </section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_bolsa" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de Documentos</h3>
                <?php if ($vuser->codnivel=="0") {?>
		    	<div class="no-padding card-tools">
                	<a type="button" class="btn btn-sm btn-default" href="<?php echo $vbaseurl ?>documentos/pagos/agregar"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
                <?php } ?>
		    </div>
            <div class="card-body">
                <form id="frm_search_docpago" action="" method="post" accept-charset="utf-8">
                    <div class="row">
                        <div class="form-group has-float-label col-6 col-md-3 col-sm-6">
                            <input type="date" name="fictxtfecha_emision" id="fictxtfecha_emision" class="form-control">
                            <label for="fictxtfecha_emision">Fecha Inicio</label>
                        </div>
                        <div class="form-group has-float-label col-6 col-md-3 col-sm-6">
                            <input type="date" name="fictxtfecha_emisionf" id="fictxtfecha_emisionf" class="form-control">
                            <label for="fictxtfecha_emisionf">Fecha Final</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4 col-sm-6">
                            <input type="text" autocomplete="off" name="fictxtdescripcion" id="fictxtdescripcion" class="form-control" placeholder="Descripción">
                            <label for="fictxtdescripcion">Descripción</label>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </form>
                <?php $meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"); ?>
                <div class="btable mt-3">
                    <div class="thead col-12  d-none d-md-block">
                        <div class="row">
                            <div class='col-12 col-md-6'>
                                <div class='row'>
                                    <div class='col-1 col-md-1 td'>N°</div>
                                    <div class='col-2 col-md-2 td'>EMISIÓN</div>
                                    <div class='col-9 col-md-9 td'>TITULO</div>
                                </div>
                            </div>
                            <div class='col-12 col-md-6 text-center'>
                                <div class='row'>
                                    <div class='col-sm-2 col-md-2 td'>
                                        <span>MONTO</span>
                                    </div>
                                    <div class='col-sm-2 col-md-2 td'>
                                        <span>VENCE</span>
                                    </div>
                                    <div class='col-sm-3 col-md-3 td'>
                                        <span>ESTADO</span>
                                    </div>
                                    <div class='col-sm-2 col-md-2 td'>
                                        <i class='fas fa-download'></i>
                                    </div>
                                    <div class='col-sm-3 col-md-3 td'>
                                        <span>ACCIONES</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tbody col-12" id="divresult">
                        <?php
                        //$this->load->view("documentopagos/result_data",array('items' => $docpago ));
                        include "result_data.php";
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
<script src='{$vbaseurl}resources/dist/js/pages/documentospago.js'></script>";
?>

<script type="text/javascript">

    $('#frm_search_docpago').submit(function() {
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'documentos_pago/fn_search_data',
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(e) {
                $('#divcard_bolsa #divoverlay').remove();
                if (e.status== true) {
                    $('#divresult').html(e.vdata);
                } else {
                    $('#divresult').html(e.vdata);
                }
                
            },
            error: function(jqXHR, exception) {
                $('#divcard_bolsa #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divresult').html(msgf);
            }
        });
        return false;
    })

</script>