<?php
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
  	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>BANNER
          			<small>Panel</small></h1>
        		</div>
        
      		</div>
    	</div>
  	</section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_banner" class="card">
			<div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de banner</h3>
		    	<div class="no-padding card-tools">
                	<a type="button" class="btn btn-sm btn-default" href="<?php echo $vbaseurl ?>portal-web/banner/agregar"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
		    </div>
		    <div class="card-body">
		    	<div class="neo-table">
                    <div class="header col-12  d-none d-md-block">
                        <div class="row font-weight-bold">
                            <div class='col-12 col-md-7 group'>
                                <div class='col-2 col-md-1 cell d-none d-md-block'>N°</div>
                                <div class='col-10 col-md-11 cell d-none d-md-block'>TITULO</div>
                            </div>
                            
                            <div class='col-12 col-md-3 group'>
                                <div class='col-6 col-md-6 cell d-none d-md-block'>
                                    IMAGEN
                                </div>
                                <div class='col-6 col-md-6 cell d-none d-md-block'>
                                	ESTADO
                                </div>
                            </div>
                            <div class='col-12 col-md-2 group'>
                                <div class='col-12 col-md-12 cell text-center d-none d-md-block'>
                                    ACCIÓN
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="body col-12">
                    <?php
                        $nro = 0;
                        foreach ($banner as $bnr) {
                            $nro ++;
                            if ($bnr->estado == 'SI') {

								$estado = "<span class='badge bg-success p-2'> ACTIVO </span>";

							} else {

								$estado = "<span class='badge bg-danger p-2'> INACTIVO </span>";

							}
                    ?>
                    	<div class="row cfila <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
                            <div class="col-12 col-md-7 group">
                                <div class="col-2 col-md-1 cell">
                                    <span><?php echo $nro ;?></span>
                                </div>
                                <div class="col-10 col-md-11 cell">
                                    <span><?php echo $bnr->titulo ;?></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 group">
                            	<div class='col-6 col-md-6 cell'>
                            		<img src="<?php echo $vbaseurl."upload/banner/".$bnr->imagen ?>" alt="portada" class="d-block m-auto img-fluid">
                            	</div>
                            	<div class='col-6 col-md-6 cell text-center'>
                            		<?php echo $estado ?>
                            	</div>
                            </div>
                            <div class="col-12 col-md-2 group">
                            	<div class='col-6 col-md-6 cell text-center'>
                            		<a href="<?php echo $vbaseurl."portal-web/banner/editar/".base64url_encode($bnr->id) ?>" class='btn btn-info btn-sm px-3'>
                            			<i class='fas fa-pencil-alt text-white'></i>
                            			<span class="d-block d-md-none">Editar </span>
                            		</a>
                            	</div>
                            	<div class='col-6 col-md-6 cell text-center'>
                            		<button class='btn btn-danger btn-sm deletebanner px-3' idBanner="<?php echo base64url_encode($bnr->id) ?>" imageBanner="<?php echo base64url_encode($bnr->imagen) ?>">
                            			<i class='fas fa-trash-alt'></i>
                            			<span class="d-block d-md-none">Eliminar </span>
                            		</button>
                            	</div>
                            </div>
                        </div>
                    <?php    
                        }
                    ?>
                    </div>
                </div>
		    </div>
		</div>
	</section>
</div>

<script type="text/javascript">

	$(document).on("click", ".deletebanner", function(){
		var idBanner = $(this).attr("idBanner");
		var imageBanner = $(this).attr("imageBanner");
		var datos = new FormData();
  		
		Swal.fire({
			title: '¿Está seguro de eliminar este banner?',
			text: "¡Si no lo está puede cancelar la acción!",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        allowOutsideClick: false,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        cancelButtonText: 'Cancelar',
	        confirmButtonText: 'Si, eliminar banner!'
		}).then(function(result){
			if(result.value){
				$('#divboxdatos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
				var datos = new FormData();
                datos.append("idBanner", idBanner);
                datos.append("imgBanner", imageBanner);
                
                $.ajax({
                  	url: base_url + "banner/fneliminar_banner",
                  	method: "POST",
                  	data: datos,
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	success:function(e){
                    	$('#divboxdatos #divoverlay').remove();
                    	if (e.status == true) {
                    		Swal.fire({
	                          	type: "success",
	                          	icon: 'success',
	                          	title: "¡CORRECTO!",
	                          	text: e.msg,
	                          	showConfirmButton: true,
	                          	allowOutsideClick: false,
	                          	confirmButtonText: "Cerrar"
	                        }).then(function(result){

	                            if(result.value){

	                              location.reload();

	                            }
	                        })
                    	}
                    },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception,'text');
			            $('#divboxdatos #divoverlay').remove();
			            Swal.fire({
	              			title: "Error",
	              			text: e.msgf,
	              			type: "error",
	              			icon: "error",
	              			allowOutsideClick: false,
	              			confirmButtonText: "¡Cerrar!"
	            		});
			        }
            	})
			}
    	});  		
	        
	    return false;
	});
</script>