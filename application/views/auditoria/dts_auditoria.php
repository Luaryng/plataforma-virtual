<?php 
if (isset($items) && (count($items)>0))
{ ?>

<small id="fmt_conteo" class="form-text text-primary">
            
</small>
<div class="col-12 py-1">
    <div class="btable">
        <div class="thead col-12  d-none d-md-block">
            <div class="row">
                <div class='col-12 col-md-2'>
                    <div class='row'>
                        <div class='col-4 col-md-3 td'>N°</div>
                        <div class='col-8 col-md-9 td'>USUARIO</div>
                    </div>
                </div>
                <div class='col-12 col-md-7'>
                    <div class='row'>
                        <div class='col-6 col-md-3 td'>FECHA</div>
                        <div class='col-6 col-md-9 td'>DETALLE</div>
                    </div>
                </div>
                <div class='col-12 col-md-3'>
                    <div class='row'>
                        <div class='col-6 col-md-6 td text-center'>SEDE</div>
                        <div class='col-6 col-md-6 td'></div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="tbody col-12" id="divcard_data">
        <?php
			// $nro = 0;
			$nro = (isset($inicio)?$inicio:0);
			foreach ($items as $value) {
				$nro++;
				$vfecha = date('d/m/Y', strtotime($value->fecha));
				$hora = date('h:i A',strtotime($value->fecha));
		?>
            <div class='row rowcolor cfila' data-codigo=''>
            	<div class='col-12 col-md-2'>
                    <div class='row'>
                        <div class='col-4 col-md-3 td'><?php echo $nro ?></div>
                        <div class='col-8 col-md-9 td'><?php echo $value->nick ?></div>
                    </div>
                </div>
                <div class='col-12 col-md-7'>
                    <div class='row'>
                        <div class='col-6 col-md-3 td'>
                        	<?php echo $vfecha ." - ". $hora ?>
                        	<br><small><?php echo $value->accion ?></small>	
                        </div>
                        <div class='col-6 col-md-9 td'><?php echo $value->descripcion ?></div>
                    </div>
                </div>
                <div class='col-12 col-md-3'>
                    <div class='row'>
                        <div class='col-6 col-md-6 td text-center'><?php echo $value->nomsede ?></div>
                        <div class='col-6 col-md-6 td text-center'>
                        	<div class='btn-group'>
                        		<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                    <i class='fas fa-cog'></i>
                                </a>
                                <div class='dropdown-menu dropdown-menu-right acc_dropdown'>
                                	<a class='dropdown-item' href='#' onclick='' data-detalle="<?php echo $value->descripcion ?>" data-fecha="<?php echo $vfecha ?>" data-hora="<?php echo $hora ?>" title="ver detalle" data-toggle="modal" data-target="#modetalle_aud">
                                        <i class='fas fa-eye mr-1'></i> Ver
                                    </a>
                                    <a class='dropdown-item text-danger btn-delete' href='#' data-id="<?php echo base64url_encode($value->id) ?>" title="Eliminar registro">
                                        <i class='fas fa-trash mr-1'></i> Eliminar
                                    </a>
                                </div>
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</div>


<script type="text/javascript">
	$(document).on("click", ".btn-delete", function(){
		var fila = $(this).closest('.cfila');
		var codigo = $(this).data("id");
		var datos = new FormData();
  		Swal.fire({
  			title: '¿Está seguro de eliminar este registro?',
  			text: "¡Si no lo está puede cancelar la acción!",
            type: 'warning',
            icon: "warning",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar!'

		}).then(function(result){
			if(result.value){
				$('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                datos.append("txtcodigo", codigo);

                $.ajax({
                  	url: base_url + "auditoria/fneliminar_registro",
                  	method: "POST",
                  	data: datos,
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	success:function(e){
                    	$('#divboxhistorial #divoverlay').remove();
                    	if (e.status == true) {
                    		Swal.fire({
	                          	type: "success",
	                          	icon: "success",
	                          	title: "¡CORRECTO!",
	                          	text: e.msg,
	                          	showConfirmButton: true,
	                          	allowOutsideClick: false,
	                          	confirmButtonText: "Cerrar"
	                        }).then(function(result){

	                            if(result.value){
	                              fila.remove();
	                            }
	                        })
                    	}
                    },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception,'text');
			            $('#divboxhistorial #divoverlay').remove();
			            Swal.fire({
	              			title: "Error",
	              			text: msgf,
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
<?php  
}
else
{
	echo "<h4 class='px-2'>No se encontro coincidencias</h4>";
} 
?>
