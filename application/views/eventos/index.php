<?php
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>EVENTOS
          <small>Panel</small></h1>
        </div>
        
        
      </div>
    </div>
  </section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_evento" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de eventos</h3>
		    	<div class="no-padding card-tools">
                	<a type="button" class="btn btn-sm btn-default" href="<?php echo $vbaseurl ?>portal-web/eventos/agregar"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
		    </div>
            <div class="card-body">
                <?php $meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"); ?>
                <div class="neo-table">
                    <div class="header col-12  d-none d-md-block">
                        <div class="row font-weight-bold">
                            <div class='col-12 col-md-4 group'>
                                <!-- <div class='row'> -->
                                    <div class='col-2 col-md-2 cell d-none d-md-block'>N°</div>
                                    <div class='col-10 col-md-10 cell d-none d-md-block'>TITULO</div>
                                <!-- </div> -->
                            </div>
                            <div class='col-12 col-md-3 group'>
                                <!-- <div class='row'> -->
                                    <div class='col-6 col-md-6 cell d-none d-md-block'>FECHA</div>
                                    <div class='col-6 col-md-6 cell d-none d-md-block'>HORA</div>
                                <!-- </div> -->
                            </div>
                            <div class='col-12 col-md-3 group'>
                                <div class='col-6 col-md-6 cell d-none d-md-block'>LUGAR</div>
                                <div class='col-6 col-md-6 cell d-none d-md-block'>
                                    IMAGEN
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
                        foreach ($eventos as $evt) {
                            $nro ++;
                            $hora = date('h:i A',strtotime($evt->hora));
                    ?>
                            <div class="row cfila <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
                                <div class="col-12 col-md-4 group">
                                    <div class="col-2 col-md-2 cell">
                                        <span><?php echo $nro ;?></span>
                                    </div>
                                    <div class="col-10 col-md-10 cell">
                                        <span><?php echo $evt->titulo ;?></span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 group">
                                    <div class="col-6 col-md-6 cell">
                                        <span><?php echo $evt->fecha ;?></span>
                                    </div>
                                    <div class="col-6 col-md-6 cell">
                                        <span><?php echo $hora ;?></span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 group">
                                    <div class="col-6 col-md-6 cell">
                                        <span><?php echo $evt->lugar ;?></span>
                                    </div>
                                    <div class="col-6 col-md-6 cell">
                                        <img src="<?php echo $vbaseurl."upload/eventos/thumb/".$evt->imagen ?>" alt="portada" class="d-block m-auto">
                                    </div>
                                </div>
                                <div class="col-12 col-md-2 group">
                                    <div class="col-6 col-md-6 cell">
                                        <a href="<?php echo $vbaseurl."portal-web/eventos/editar?idevt=".base64url_encode($evt->id) ?>"  class='btn btn-sm btn-info' title='Editar Evento'>
                                            <i class='fas fa-pencil-alt'></i> <span class='d-block d-md-none'>Editar </span>
                                        </a>
                                    </div>
                                    <div class="col-6 col-md-6 cell">
                                        <a href='#' data-codigo='<?php echo base64url_encode($evt->id) ?>' data-image='<?php echo base64url_encode($evt->imagen) ?>' class='btn btn-danger btn-sm vw_pw_bt_btn_delete' title='Eliminar Evento'>
                                            <i class='fas fa-trash-alt'></i> <span class='d-block d-md-none'>Eliminar</span>
                                        </a>
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
    $(document).ready(function() {
        $(".vw_pw_bt_btn_delete").click(function(event) {
            event.preventDefault();
            $('#divcard_evento').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var fila = $(this).closest('.cfila');
            var idevt = $(this).data("codigo");
            var image = $(this).data("image");
            //************************************
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
                    //var codc=$(this).data('im');
                    $.ajax({
                        url: base_url + 'eventos/fneliminar_evento',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            idEvento: idevt,
                            ficimage: image
                        },
                        success: function(e) {
                            $('#divcard_evento #divoverlay').remove();
                            if (e.status == false) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Error!',
                                    icon: 'error',
                                    text: e.msg,
                                    backdrop: false,
                                })
                            } else {
                                /*$("#fm-txtidmatricula").html(e.newcod);*/
                                Swal.fire({
                                    type: 'success',
                                    icon: 'success',
                                    title: 'Eliminación correcta',
                                    text: 'Se ha eliminado el registro',
                                    backdrop: false,
                                })

                                fila.remove();
                            }
                        },
                        error: function(jqXHR, exception) {
                            var msgf = errorAjax(jqXHR, exception, 'text');
                            $('#divcard_evento #divoverlay').remove();
                            Swal.fire({
                                type: 'error',
                                title: 'Error',
                                icon: 'error',
                                text: msgf,
                                backdrop: false,
                            })
                        }
                    });
                } else {
                    $('#divcard_evento #divoverlay').remove();
                }
            });
        });

        
    });
</script>