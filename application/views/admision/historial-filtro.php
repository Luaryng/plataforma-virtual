<?php
if (isset($historial) && (count($historial)>0))
{ ?>
<div id="divtabl-addamiembros" class="col-12 col-md-12 btable">
	<div class="col-md-12 thead d-none d-md-block">
		<div class="row font-weight-bold">
			
			<div class="col-12 col-md-2">
				<div class="row">
					<div class="col-6 col-md-3 td d-none d-md-block">
						N°
					</div>
					<div class="col-12 col-md-9 td">
						DOC. IDENTIDAD
					</div>
				</div>
			</div>
			
			<div class="col-12 col-md-5 td">
				APELLIDOS Y NOMBRES
			</div>
			<div class="col-12 col-md-2 td">
				VISITA
			</div>
			<div class="col-2 col-md-3 td text-center">
				
			</div>
		</div>
	</div>
	<div class="col-md-12 tbody">
		<?php
		$nro=0;
		foreach ($historial as $usuario) {
			if ($usuario->idpersona!=1){
				$fn="";
				$nro++;
				$nombres=$usuario->paterno.' '.$usuario->materno.', '.$usuario->nombres;
				$calledit="get_ficha('".base64url_encode($usuario->idpersona)."')";
		?>
		<div class="row rowcolor" data-codigo="<?php echo base64url_encode($usuario->idpersona) ?>" data-tipodoc='<?php echo $usuario->tipodoc ?>' data-numero='<?php echo $usuario->numero ?>' data-paterno="<?php echo $usuario->paterno ?>" data-materno="<?php echo $usuario->materno ?>" data-nombres="<?php echo $usuario->nombres ?>">
			<div class="col-12 col-sm-4 col-md-2">
				<div class="row">
					<div class="col-4 col-sm-3 col-md-3 td text-center">
						<span data-toggle="tooltip" title="<?php echo $usuario->idpersona ?>" ><?php echo $nro ;?></span>
					</div>
					<div class="col-8 col-sm-9 col-md-9 td">
						<span class="cddni"><?php echo $usuario->tipodoc.': '.$usuario->numero ?></span>
						<?php if (getPermitido("60")=='SI'): ?>
							<a data-tipodoc="<?php echo $usuario->tipodoc ?>" data-nro="<?php echo $usuario->numero  ?>" data-persona="<?php echo base64url_encode($usuario->idpersona)  ?>" class="btn-cambiardni ml-2" data-toggle="tooltip" title="Corregir Nro DNI" href="#"><i class="fas fa-pen"></i></a>
						<?php endif ?>
					
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-8 col-md-5 td">
				<b class="mr-2"><?php echo ($usuario->sexo=='MASCULINO') ? '<i class="fas fa-male fa-lg text-primary"></i>':'<i class="fas fa-female  fa-lg text-danger"></i>' ?> </b>
				<span> <?php echo $nombres ?></span>
			</div>
			<div class="col-12 col-sm-5 col-md-2 td text-center">
				<span class="d-md-none">Visita:	</span>
				<span><?php 
				$oDate = new DateTime($usuario->visita);
				$sDate = $oDate->format("d-m-Y H:i a");

				echo $sDate ?></span>
			</div>
			<div class="col-12 col-sm-7 col-md-3">
				<div class="row">
					<div class="col-4 td text-center">
						<a class="bg-primary tboton" href="#" title="Actualizar datos" onclick="<?php echo $calledit ?>">
						<i class="fas fa-user-edit"></i> Datos
						</a>
					</div>
					<!--<div class="col-6 td text-center">
						<a href="<?php //echo base_url().'admision/inscripciones/'.$usuario->numero ?>" class="bg-success  tboton" title="Postular"><i class="fas fa-user-graduate"></i> Inscribir
						</a>
					</div>-->
					<?php  
						$funcionjs="cargar_historial_inscripciones('$usuario->numero','$usuario->tipodoc');return false;"
					?>
					<div class="col-4 td text-center">
						<a onclick="<?php echo $funcionjs ?>" href="#" class="bg-success tboton"  title="Inscribir"><i class="fas fa-user-graduate"></i> Inscribir
						</a>
					</div>

					<div class="col-4 td text-center">
						<div class=''>
							<a href="#" class='text-white bg-warning dropdown-toggle tboton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                        <i class='fas fa-cog'></i>
                                                 </a>
                                                 <div class='dropdown-menu dropdown-menu-right acc_dropdown'>
                                                 	<a class='dropdown-item vw_mod_reniec_search' href='#' title='Editar'>
                                                        	<i class='fas fa-users mr-1'></i> Reniec
                                                        </a>
                                                 </div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<?php }
		} ?>
	</div>
</div>
<?php
}
else
{
		echo "<h4 class='px-2'>No se encontro coincidencias</h4>";
}
?>

<script>
	$(document).ready(function(){
  		$('[data-toggle="tooltip"]').tooltip();
	});
	$(".btn-cambiardni").click(function(event) {
		var btn=$(this);
		//var jsdni=$(this).data('nro');
		var jscodpersona=$(this).data('persona');
		var jstipodoc=$(this).data('tipodoc');
	(async () => {const { value: vdocente } = await Swal.fire({
		title: 'Corregir DNI',
		input: 'text',
		inputPlaceholder: 'Ingresa el nuevo N° DNI',
		showCancelButton: true,
		confirmButtonText:
		'<i class="fa fa-thumbs-up"></i> Guardar!',
		 inputValidator: (value) => {
		    return new Promise((resolve) => {
		      if (!value) {
		        resolve('Para guardar, debes ingresar un N° DNI válido');
		      }
		      else{
		      	$.ajax({
			            url: base_url + 'persona/fn_update_dni',
			            type: 'POST',
			            data: {"jsdni": value ,"jscodpersona": jscodpersona ,"jstipodoc": jstipodoc},
			            dataType: 'json',
			            success: function(e) {
			            	//$('#divcard_grupo #divoverlay').remove();
			            	if (e.status==true){
			            		

			            		btn.parent().find('.cddni').html(jstipodoc + ": " + value);
			            		btn.data('nro',value);
		
			            		resolve();
			            		Swal.fire({
                                  type: 'success',
                                  title: 'Advertencia: se realizo el cambio de un DNI',
                                  text: "El usuario de acceso se mantiene igual, si deseas cambiarlo comunicate con soporte e informa del cambio",
                                  backdrop: false,
                              });

			            	}
			            	else{
			            		 resolve('Para guardar, debes ingresar un Número válido');
			            	}
			            },
			            error: function(jqXHR, exception) {
			            	var msgf = errorAjax(jqXHR, exception, 'text');
                           Swal.fire({
                                  type: 'error',
                                  title: 'Error, NO se pudo realizar el cambio',
                                  text: e.msgf,
                                  backdrop: false,
                              });
			            }
			        })
		      }
		    })
		  },

        allowOutsideClick: false
		})

		})()
	});

	$('.vw_mod_reniec_search').click(function(e) {
		var boton = $(this);
		var fila = boton.closest('.rowcolor');
		var codigo = fila.data('codigo');
		var paterno = fila.data('paterno');
		var materno = fila.data('materno');
		var nombres = fila.data('nombres');
		var tipodoc = fila.data('tipodoc');
		var numero = fila.data('numero');

		$('#fidpidup').val(codigo);
		$('#ficbtipodocup').val(tipodoc);
		$('#fitxtdniup').val(numero);
		$('#fitxtapelpaternoup').val(paterno);
		$('#fitxtapelmaternoup').val(materno);
		$('#fitxtnombresup').val(nombres);

		var activo = "disabled";
		
		get_data_matriculas(codigo, activo);
	});

	$('#vw_md_search_reniec #fibtnvalida-dniup').click(function(e) {
		var dni = $('#vw_md_search_reniec #fitxtdniup').val();
		$('#vw_dp_mc_reniec').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    	if ((dni.length!=8) || (!$.isNumeric(dni))){
	        	Swal.fire({
	            		type: 'error',
	            		title: "DNI incorrecto",
	            		text: "Un N° de DNI correcto presenta 8 números",
	            		backdrop:false,
	        	});
	        	$('#vw_dp_mc_reniec #divoverlay').remove();
	        	return;
	    	}
	    	$.ajax({
                    	data: {
                        	"dni": dni
                    	},
                    	type: "POST",
                    	dataType: "json",
                    	url: base_url +  "cnrnc/consulta_reniec.php",
                    	success: function(datos_dni) {
                        var datos = eval(datos_dni);
                        if (datos['status'] == true) {
                            $("#fitxtreniecup").val(datos['paterno'] + ' ' + datos['materno'] + ' ' + datos['nombres']);
                            $("#fibtnaplica-reniecup").attr('disabled', false);
                            txtrnc = $("#fitxtreniecup");
                            txtrnc.data('paterno', datos['paterno']);
                            txtrnc.data('materno', datos['materno']);
                            txtrnc.data('nombres', datos['nombres']);
                        } else {
                            $("#fitxtreniecup").val(datos['msg']);
                            $("#fibtnaplica-reniecup").attr('disabled', true);
                            txtrnc = $("#fitxtreniecup");
                            txtrnc.data('paterno', '');
                            txtrnc.data('materno', '');
                            txtrnc.data('nombres', '');
                            $('#vw_md_search_reniec #fitxtdniup').focus();
                        }
                        $('#vw_dp_mc_reniec #divoverlay').remove();
                    },
                    	error: function(jqXHR, exception) {
                        var msgf = errorAjax(jqXHR, exception, 'text');
                        Swal.fire({
                            type: 'error',
                            title: "No pudimos conectar a RENIEC, puedes registrar MANUALMENTE o comunícate con SOPORTE",
                            text: msgf,
                            backdrop:false,
                        });
                        $('#vw_dp_mc_reniec #divoverlay').remove();
                    }
              });
              return false;
	});

	$('#vw_md_search_reniec #fibtnaplica-reniecup').on('click', function() {
	    var txtrnc = $("#fitxtreniecup");
	    $('#vw_md_search_reniec #fitxtapelpaternoup').val(txtrnc.data('paterno'));
	    $('#vw_md_search_reniec #fitxtapelmaternoup').val(txtrnc.data('materno'));
	    $('#vw_md_search_reniec #fitxtnombresup').val(txtrnc.data('nombres'));
	    return false;
	});

	$("#vw_md_search_reniec").on('hidden.bs.modal', function () {
		$('#frm_update_datosper')[0].reset();
	})
</script>