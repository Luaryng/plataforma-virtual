<?php
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>TIPO CONVOCATORIAS
          			<small>Panel</small></h1>
        		</div>
        
        
      		</div>
    	</div>
  	</section>
  	<section id="s-cargado" class="content pt-2">
		<div id="divcard_convocatorias" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de Tipos Convocatorias</h3>
		    	<?php if (getPermitido("82")=='SI'){ ?>
		    	<div class="no-padding card-tools">
                	<a type="button" class="btn btn-sm btn-default" href="<?php echo $vbaseurl ?>portal-web/convocatorias-tipo/agregar"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
              	<?php } ?>
		    </div>
            <div class="card-body">
            	<div class="btable">
                    <div class="thead col-12  d-none d-md-block">
                        <div class="row">
                            <div class='col-12 col-md-8'>
                                <div class='row'>
                                    <div class='col-2 col-md-1 td'>N°</div>
                                    <div class='col-10 col-md-11 td'>NOMBRE</div>
                                </div>
                            </div>

                            <div class='col-12 col-md-4 text-center'>
                                <div class='row'>
                                    <div class='col-sm-6 col-md-6 td'>
                                        <span>ESTADO</span>
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

                        if ($cmd->activo == 'SI') {

							$estado = "<span class='badge bg-success p-2'> ACTIVO </span>";

						} else {

							$estado = "<span class='badge bg-danger p-2'> INACTIVO </span>";

						}

						$btneditar = "";
                        $btneliminar = "";

                        if (getPermitido("83")=='SI'){
                            $btneditar = "<a href='{$vbaseurl}portal-web/convocatorias-tipo/editar/$codigo_enc'>
                                        	<i class='fas fa-pen fa-2x text-primary'></i>
                                        </a>";
                        }
                        if (getPermitido("84")=='SI'){
                            $btneliminar = "<a href='#' data-codigo='$codigo_enc' onclick='vw_pw_cm_pr_fn_eliminar_conv_tip($(this));event.preventDefault();'>
                                        	<i class='fas fa-trash fa-2x text-danger'></i>
                                        </a>";
                        }
                        echo 
                        "<div class='row cfila'>
                            <div class='col-12 col-md-8'>
                                <div class='row'>
                                    <div class='col-2 col-md-1 td'>$nro</div>
                                    <div class='col-10 col-md-11 td'>
                                        <b class='text-primary'>$cmd->nombre</b>
                                        <br>
                                        <small><i class='far fa-calendar-alt'></i> $vpublica</small> <br>
                                    </div>
                                </div>
                            </div>
                           
                            <div class='col-12 col-md-4 text-center'>
                                <div class='row'>
                                    <div class='col-sm-6 col-md-6 td'>
                                        $estado
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

<script type="text/javascript">
	function vw_pw_cm_pr_fn_eliminar_conv_tip(btn) {
	    vinid = btn.data('codigo');
	    fila=btn.closest('.cfila');

	    Swal.fire({
	        title: "Precaución",
	        text: "¿Deseas eliminar este registro ?",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Si, eliminar!'
	    }).then((result) => {
	        if (result.value) {
	            $('#divcard_convocatorias').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	            $.ajax({
	                url: base_url + 'convocatorias_tipo/fn_delete',
	                type: 'POST',
	                data: {
	                    "codigo": vinid
	                },
	                dataType: 'json',
	                success: function(e) {
	                    $('#divcard_convocatorias #divoverlay').remove();
	                    if (e.status == true) {
	                        Swal.fire(
	                            'Eliminado!',
	                            'El archivo fue eliminado correctamente.',
	                            'success'
	                        )
	                        fila.remove();
	                    } else {
	                        Swal.fire(
	                            'Error!',
	                            e.msg,
	                            'error'
	                        )
	                    }
	                },
	                error: function(jqXHR, exception) {
	                    var msgf = errorAjax(jqXHR, exception, 'text');
	                    Swal.fire(
	                        'Error!',
	                        msgf,
	                        'error'
	                    );
	                    $('#divcard_convocatorias #divoverlay').remove();
	                }
	            });
	        } else {
	            $('#divcard_convocatorias #divoverlay').remove();
	        }
	    });

	    
	}


</script>