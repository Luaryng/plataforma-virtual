<?php
	$vbaseurl=base_url();
    $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
?>
<div class="content-wrapper">
  	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>SLIDER
          			<small>Mantenimiento</small></h1>
        		</div>
        
      		</div>
    	</div>
  	</section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_slider" class="card">
			<div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de slider</h3>
		    	<div class="no-padding card-tools">
                    <?php if (getPermitido("120")=='SI'){ ?>
                	<a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo $vbaseurl ?>portal-web/slider/agregar">
                        <i class="fa fa-plus"></i> Agregar
                    </a>
                    <?php
                        } 

                        if (getPermitido("123")=='SI'){
                    ?>
                    <button id="btn-a-order" data-status='f' type="button" class="btn btn-outline-secondary py-0"><i class="fas fa-sort"></i></button>
                    <button id="btn-d-order" data-status='f' type="button" class="btn btn-secondary py-0"><i class="fas fa-sort"></i></button>
                    <?php } ?>
              	</div>
		    </div>
		    <div class="card-body p-2">
                <ul class="order-list" >
                    <?php
                        $nro=0;
                        foreach ($slider as $key => $sld) {
                            $nro++;
                            $datepubl =  new DateTime($sld->fecha);
                            $vpublica= $dias[$datepubl->format('w')].". ".$datepubl->format('d/m/Y h:i a');

                            if ($sld->activo == 'SI') {

                                $estado = "<span class='badge bg-success p-2 ml-2'> ACTIVO </span>";

                            } else {

                                $estado = "<span class='badge bg-danger p-2 ml-2'> INACTIVO </span>";

                            }
                    ?>
                        <li data-id="<?php echo $sld->id ?>" class="<?php echo ($nro % 2==0) ? 'bg-lightgray border border-left-0 border-right-0':'' ?>">
                            <div class="col-12 px-0 py-2">
                                <div class="row p-0">
                                    <div class="col-md-6 col-6 pt-1">
                                        <i class="icon-move fas fa-arrows-alt move mr-2 text-dark"></i>
                                        <img src="<?php echo $vbaseurl."upload/slider/".$sld->imagen ?>" alt="portada" class="rounded ml-2 img-fluid" style="width: 80px; height: 80px;">
                                    </div>
                                    <div class="col-md-2 col-6 pt-1">
                                        <?php echo $estado ?>
                                    </div>
                                    <div class="col-md-2 col-6 pt-1">
                                        <span><b>Registrado: </b><?php echo $vpublica ?></span>
                                    </div>
                                    <div class="col-md-2 col-6 pt-1 pr-3 text-center">
                                        <div class='row'>
                                            <div class='col-12 col-sm-12 col-md-12 td'>
                                                <div class='col-12 pt-1 pr-3 text-center'>
                                                    <div class='btn-group'>
                                                        <a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                            <i class='fas fa-cog'></i> Acción
                                                        </a>
                                                        <div class='dropdown-menu dropdown-menu-right acc_dropdown'>
                                                            <?php if (getPermitido("121")=='SI'){ ?>
                                                            <a class='dropdown-item' href='<?php echo $vbaseurl."portal-web/slider/editar/".base64url_encode($sld->id) ?>' title='Editar'>
                                                                <i class='fas fa-edit mr-1'></i> Editar
                                                            </a>
                                                            <?php } 
                                                                if (getPermitido("122")=='SI'){ ?>
                                                            <a class='dropdown-item text-danger deleteslider' href='#' title='Eliminar' idSlider="<?php echo base64url_encode($sld->id) ?>" imageSlider="<?php echo base64url_encode($sld->imagen) ?>">
                                                                <i class='fas fa-trash mr-1'></i> Eliminar
                                                            </a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                        </li>

                    <?php
                        }
                    ?>
                </ul>
		    	
		    </div>
		</div>
	</section>
</div>

<script type="text/javascript">
    var accion = "ordenar";
    $(".order-list").sortable({
        placeholder: "sortable-select",
        cursor: 'crosshair',
        items: "> li",
        cursorAt: { left: 5 },
        delay: 150,
        //containment: "parent",
        start: function(event, ui) {
            ui.item.startPos = ui.item.index();
        },
        stop: function(event, ui) {
            //console.log("Start position: " + ui.item.startPos);
            //console.log("New position: " + ui.item.index());
        },
        update: function(event, ui) {
            arrdata = [];
            $(".order-list li").each(function(index, el) {
                var codind = $(this).data("id");
                var norden = index + 1;
                var myvals = [norden, codind];
                arrdata.push(myvals);
            });
            $('#divcard_slider').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + 'slider/f_ordenar',
                type: 'post',
                dataType: 'json',
                data: {
                    vaccion: accion,
                    filas: JSON.stringify(arrdata),
                },
                success: function(e) {
                    $('#divcard_slider #divoverlay').remove();
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se guardó cambios',
                        text: msgf,
                        backdrop: false,
                    });
                },
            });
        },
    });

    $(".order-list" ).sortable( "disable" );
    $(".icon-move").hide();
    $("#btn-d-order").hide();

    $("#btn-a-order").click(function(event) {
        /* Act on the event */
        $('#divcard_slider').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        setTimeout(function(){
            var btno=$(this);
            $(".order-list" ).sortable( "enable");
            $("#btn-a-order").hide();
            $("#btn-d-order").show();
            $(".icon-move").show();
            $('#divcard_slider #divoverlay').remove();
            }, 300);
        
        return false;
    });

    $("#btn-d-order").click(function(event) {
        /* Act on the event */
        $('#divcard_slider').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        setTimeout(function(){
            $( ".order-list" ).sortable( "disable" );
            $("#btn-d-order").hide();
            $("#btn-a-order").show();
            $(".icon-move").hide();
            $('#divcard_slider #divoverlay').remove();
        }, 300);
        return false;
    });

	$(document).on("click", ".deleteslider", function(){
		var idSlider = $(this).attr("idSlider");
		var imageSlider = $(this).attr("imageSlider");
		var datos = new FormData();
  		
		Swal.fire({
			title: '¿Está seguro de eliminar este slider?',
			text: "¡Si no lo está puede cancelar la acción!",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        allowOutsideClick: false,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        cancelButtonText: 'Cancelar',
	        confirmButtonText: 'Si, eliminar slider!'
		}).then(function(result){
			if(result.value){
				$('#divboxdatos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
				var datos = new FormData();
                datos.append("idSlider", idSlider);
                datos.append("imgSlider", imageSlider);
                
                $.ajax({
                  	url: base_url + "slider/fneliminar_slider",
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