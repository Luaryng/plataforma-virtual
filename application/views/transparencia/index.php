<?php
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>TRANSPARENCIA
          <small>Panel</small></h1>
        </div>
        
        
      </div>
    </div>
  </section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_bolsa" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de Documentos</h3>
		    	<div class="no-padding card-tools">
                	<a type="button" class="btn btn-sm btn-default" href="<?php echo $vbaseurl ?>portal-web/transparencia/agregar"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
		    </div>
            <div class="card-body">
                <form id="frm_search_transp" action="" method="post" accept-charset="utf-8">
                    <div class="row">
                        <div class="form-group has-float-label col-12 col-md-4">
                            <select name="cbocategoria" id="cbocategoria" class="form-control">
                                <option value="%">Seleccione item</option>
                                <?php
                                    foreach ($categorias as $key => $value) {
                                        $tipo = $this->input->get('tp');
                                        $sel = ($tipo == $value->codigo) ? "selected" : "";
                                        echo "<option $sel value='$value->codigo'>$value->nombre</option>";
                                    }
                                ?>
                            </select>
                            <label for="cbocategoria">Categoría</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4 col-sm-8">
                            <input type="text" name="fictxttitulo" id="fictxttitulo" placeholder="Titulo" class="form-control">
                            <label for="fictxttitulo">Titulo</label>
                        </div>
                        <div class="col-md-4 col-sm-4">
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
                            <div class='col-12 col-md-4'>
                                <div class='row'>
                                    <div class='col-2 col-md-2 td'>N°</div>
                                    <div class='col-10 col-md-10 td'>TITULO</div>
                                </div>
                            </div>
                            <div class='col-12 col-md-5 td'>
                                CATEGORÍA
                            </div>
                            <div class='col-12 col-md-3 text-center'>
                                <div class='row'>
                                    <div class='col-sm-4 col-md-4 td'>
                                        <span>ORDEN</span>
                                    </div>
                                    
                                    <div class='col-sm-8 col-md-8 td'>
                                        <span>ACCIÓN</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tbody col-12" id="divresult">
                        <?php
                            $nro = 0;
                            $area=base64url_encode('TP');
                            foreach ($items as $bls) {
                            $nro ++;
                           
                            $datepubl =  new DateTime($bls->creado) ;
                            $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
                            $vpublica= $dias[$datepubl->format('w')].". ".$datepubl->format('d/m/Y h:i a');          
                            $codigo_enc=base64url_encode($bls->codigo);
                            echo 
                            "<div class='row cfila'>
                                <div class='col-12 col-md-4'>
                                    <div class='row'>
                                        <div class='col-2 col-md-2 td'>$nro</div>
                                        <div class='col-10 col-md-10 td'>
                                            <a target='_blank' href='{$vbaseurl}portal-web/archivos/$area/$codigo_enc'>
                                               $bls->titulo
                                            </a> <br>
                                            <small><i class='far fa-calendar-alt'></i> $vpublica</small> <br>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-sm-4 col-md-5 td'>
                                            <span>$bls->nomcategoria</span>
                                        </div>
                                <div class='col-12 col-md-3 text-center'>
                                    <div class='row'>
                                        <div class='col-sm-4 col-md-4 td'>
                                            <span>$bls->orden</span>
                                        </div>
                                        
                                        <div class='col-sm-4 col-md-4 td'>
                                            <a href='{$vbaseurl}portal-web/transparencia/editar/$area/$codigo_enc'><i class='fas fa-pen fa-2x text-primary'></i></a>
                                        </div>
                                        
                                        <div class='col-sm-4 col-md-4 td'>
                                            <a href='#' data-area='$area' data-codigo='$codigo_enc' onclick='vw_pw_tp_pr_fn_eliminar($(this));event.preventDefault();'><i class='fas fa-trash fa-2x text-danger'></i></a>
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

<script type="text/javascript">
    $('#cbocategoria').change(function(event) {
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var codigo = $(this).val();
        $.ajax({
            url: base_url + 'transparencia/fn_search_data',
            type: 'post',
            dataType: 'json',
            data: {
                cbocategoria: codigo
            },
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
    });

    $('#frm_search_transp').submit(function() {
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'transparencia/fn_search_data',
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