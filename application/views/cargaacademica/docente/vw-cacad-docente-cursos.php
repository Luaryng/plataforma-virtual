<?php
	$p66=getPermitido("66");
	$p67=getPermitido("67");
?>
<div id="divtabl-addamiembros" class="col-12 col-md-12 neo-table">
	<div class="col-md-12 header d-none d-md-block">
		<div class="row text-bold">
			<div class="col-12 col-md-4 group">
				<div class="col-6 col-md-2 cell">
					N°
				</div>
				<div class="col-12 col-md-10 cell">
					UNIDAD DID.
				</div>
			</div>
			<div class="col-2 col-md-2 cell text-center">
				GRUPO
			</div>
			<div class="col-2 col-md-1 cell text-center">
				SES.
			</div>
			<div class="col-2 col-md-1 cell text-center">
				ALUM.
			</div>
			<div class="col-1 col-md- cell text-center">
				ABIERTO
			</div>
			<div class="col-1 col-md-1 cell text-center">
				MOSTRAR
			</div>
			<div class="col-1 col-md-2 cell text-center">
				<i class="fas fa-cogs"></i>
			</div>
			
		</div>
	</div>
	<div class="col-md-12 body">
		<?php
		$nro=0;
		$mod="";
		foreach ($cargas as $key => $carga) {
			if ($carga->activo=='SI'){
				$nro++;
				$vmostrar=($carga->mostrar=='SI')?"checked":"";
				$vculminar=($carga->culminado=='NO')?"checked":"";
				$division64 = base64url_encode($carga->division);
				$idcarga64 = base64url_encode($carga->codcarga);
		?>
		<div class="row rowcolor <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?> pt-3" data-division="<?php echo $division64 ?>" data-idcarga="<?php echo $idcarga64 ?>">
			<div class="col-12 col-md-4 group">
				<div class="col-2 col-md-2 cell">
					<span><?php echo $nro ;?></span>
				</div>
				<div class="col-10 col-md-10 cell">
					<span><?php echo "<b>". $carga->codcarga."G".$carga->division." ". $carga->unidad."<br></b><small>".$carga->modulo."</small>" ?></span>
				</div>
			</div>
			<div class="col-4 col-md-2 cell text-center">
					<span><?php echo $carga->codperiodo." ".$carga->sigla."-".$carga->ciclo." ".$carga->codturno." ".$carga->codseccion.$carga->division ?></span>
			</div>
			<div class="col-4 col-md-1 cell text-center">
					<span><?php echo $carga->avance."/".$carga->sesiones?></span>
			</div>
			<div class="col-4 col-md-1 cell text-center">
					<span><?php echo $carga->nalum ?></span>
			</div>
			<div class="col-4 col-md-1 cell text-center">
				<?php 
					$iconoff = '<i class="far fa-calendar-times"></i>';
					$icononn = '<i class="fa fa-check"></i>';
					if ($carga->culminado=='SI'){
						$cbgcolor="bg-danger";
						$checked="";
						$culminotext="NO";
					}
					else{
						$cbgcolor="bg-success";
						$checked="checked";
						$culminotext="SI";
					}
					?>
					<span class="d-inline-block d-md-none text-bold">Abierto: </span> 
					<?php if ($p66=="NO"){
						echo 
						"<span title='Abierto' class='d-inline-block text-white tboton $cbgcolor '>$culminotext</span>";
					}
					else{
						echo 
						"<span class='mt-1 d-block'>
							<input $checked  class='fca-checkculminar' data-size='xs' type='checkbox' data-toggle='toggle' data-on='".$icononn."' data-off='".$iconoff."' data-onstyle='success' data-offstyle='danger'>
						</span>";
					}
				?>
			</div>
			<div class="col-4 col-md-1 cell text-center">
				<?php 
					$iconoff2 = '<i class="far fa-eye-slash"></i>';
					$icononn2 = '<i class="far fa-eye"></i>';
					if ($carga->mostrar=='NO'){
						$cbgcolor="bg-danger";
						$checked="";
						
					}
					else{
						$cbgcolor="bg-success";
						$checked="checked";
						
					}
					?>
					<span class="d-inline-block d-md-none text-bold">Mostrar: </span> 
					<?php if ($p67=="NO"){
						echo 
						"<span title='Mostrar' class='d-inline-block text-white tboton $cbgcolor '>$carga->activo</span>";
					}
					else{
						echo 
						"<span class='mt-1 d-block'>
							<input $checked  class='fca-checkmostrar' data-size='xs' type='checkbox' data-toggle='toggle' data-on='".$icononn2."' data-off='".$iconoff2."' data-onstyle='success' data-offstyle='danger' value='$carga->activo'>
						</span>";
					}
				?>
				
			</div>

				
			<!---->
			<div class="col-4 col-md-2 cell text-center">
				<!--<input checked class="fca-checkcursovw"  data-codcarga='<?php echo $carga->codcarga  ?>' 
						data-codunidad='<?php echo $carga->codunidad ?>' data-size="xs"  type="checkbox" data-toggle="toggle" 
						data-on="<i class='fa fa-check'></i>" data-off="<i class='fas fa-arrow-alt-circle-right'></i>" 
						data-onstyle="success" data-offstyle="danger">
				<button title="Dividir" data-codcarga='<?php echo $carga->codcarga  ?>' class="btn btn-primary btn-xs fca-btndividir"><i class="far fa-plus-square"></i> <i class="fas fa-layer-group"></i></button>-->

				<a class="fd-editdocente btn btn-warning btn-xs" href="#" title="Cambiar docente" data-grupo="<?php echo $carga->division ;?> " data-carga="<?php echo $carga->codcarga ;?> "><i class="fas fa-user-edit "></i></a> 
				<a class="btn btn-primary btn-xs" target="_blank"  href="<?php echo base_url().'gestion/academico/carga-academica/miembros/enrolar/'.base64url_encode($carga->codcarga).'/'.base64url_encode($carga->division) ?>" title="Enrolar miembros"><i class="fas fa-user-friends "></i></a>
			</div>
		</div>
	

		<?php }} ?>
	</div>
</div>
<script>


	$(".fca-checkcursovw").change(function(event) {
		
		if ($(this).prop('checked')==true){
			
			$("#divcard_grupo select").prop('disabled', false);
			$('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			
			var vcarga=$(this).data('codunidad');
			var codcarga=$(this).data('codcarga');
			var fn="fn_activar";
			var fdata=new Array();
			if (codcarga=="0") {
				fn="fn_insert";
				fdata=$("#frm-grupo").serializeArray();
				fdata.push({name: 'fca-txtunidad', value: vcarga});
			}
			else{
				fdata.push({name: 'fca-txtcarga', value: codcarga});
				fdata.push({name: 'fca-txtactivar', value: 'SI'});
			}
			
			$.ajax({
		            url: base_url + 'cargaacademica/' + fn,
		            type: 'post',
		            dataType: 'json',
		            data: fdata,
		            success: function(e) {
		            	$("#divcard_grupo select").prop('disabled', true);
		            	$('#divcard_grupo #divoverlay').remove();
		            	if (e.status==true){
		            		$(this).data('codcarga', e.newcod);
		            	}
		            	else{
		            		$(this).bootstrapToggle('off');
		            		Toast.fire({
						      type: 'danger',
						      title: 'Error: ' + e.msg
						    });
		            	}
		            },
		            error: function(jqXHR, exception) {
		            	$(this).bootstrapToggle('off');
		            	$("#divcard_grupo select").prop('disabled', true);
		            	$('#divcard_grupo #divoverlay').remove();
		                var msgf = errorAjax(jqXHR, exception, 'text');
		                $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
		            }
	        });
		}
		else{
			$("#divcard_grupo select").prop('disabled', false);
			$('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			var codcarga=$(this).data('codcarga');
			$.ajax({
	            url: base_url + 'cargaacademica/fn_activar',
	            type: 'post',
	            dataType: 'json',
	            data: {"fca-txtcarga":codcarga,"fca-txtactivar":'NO'},
	            success: function(e) {
	            	$("#divcard_grupo select").prop('disabled', true);
	            	$('#divcard_grupo #divoverlay').remove();
	            	if (e.status==true){
	            		
	            	}
	            	else{
	            		$(this).bootstrapToggle('on');
	            		Toast.fire({
					      type: 'danger',
					      title: 'Error: ' + e.msg
					    });

	            	}
	            },
	            error: function(jqXHR, exception) {
	            	$(this).bootstrapToggle('off');
	            	$("#divcard_grupo select").prop('disabled', true);
	            	$('#divcard_grupo #divoverlay').remove();
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
	            }
	        });
		}	
	});

	$(".fd-editdocente").click(function(event) {
		var btn=$(this);
		var vgrupo=$(this).data('grupo');
		var vcarga=$(this).data('carga');
	  (async () => {const { value: vdocente } = await Swal.fire({
		title: 'Asignar Docente',
		input: 'select',
		inputOptions:vdocentes,
		inputPlaceholder: 'Selecciona un docente',
		showCancelButton: true,
		confirmButtonText:
		'<i class="fa fa-thumbs-up"></i> Guardar!',
		 inputValidator: (value) => {
		    return new Promise((resolve) => {
		      if (!value) {
		        resolve('Para guardar, debes seleccionar un item de la lista');
		      }
		      else{
		      	$.ajax({
			            url: base_url + 'cargasubseccion/fn_cambiardocente',
			            type: 'POST',
			            data: {"fca-txtcoddocente": value ,"fca-txtsubseccion": vgrupo ,"fca-txtcodcarga": vcarga},
			            dataType: 'json',
			            success: function(e) {
			            	//$('#divcard_grupo #divoverlay').remove();
			            	if (e.status==true){
			            		
			            		if (value=='00000'){
			            			btn.parent().find('span').html("SIN DOCENTE");
			            		}
			            		else{
			            			btn.parent().find('span').html(value + " " + vdocentes[value]);
			            			/*setInterval(function(){ 
								        btn.parent().css("border", "0px solid #f37736").animate({'borderWidth': '1px',  'borderColor': 'red'},500);
								    }, 2000);*/
			            		}
			            		resolve();
			            	}
			            	else{
			            		Toast.fire({
							      type: 'danger',
							      title: 'Error: ' + e.msg
							    });

			            	}
			            },
			            error: function(jqXHR, exception) {
			            	$(this).bootstrapToggle('off');
			            	//$('#divcard_grupo #divoverlay').remove();
			                var msgf = errorAjax(jqXHR, exception, 'text');
			                $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
			            }
			        })
		      }
		    })
		  },

        allowOutsideClick: false
		})

		})()
	});

	$(".fd-editvivsion").click(function(event) {
	    var btn = $(this);
	    var vgrupo = $(this).data('grupo');
	    var vcarga = $(this).data('carga');
	    (async() => {
	        const {
	            value: vdocente
	        } = await Swal.fire({
	            title: 'Grupo Nro',
	            input: 'text',
	            inputPlaceholder: 'Ingresa un Número',
	            showCancelButton: true,
	            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Guardar!',
	            inputValidator: (value) => {
	                return new Promise((resolve) => {
	                    if ((!value) || (value <= 0)) {
	                        resolve('Para guardar, debes ingresar un Número válido');
	                    } else {
	                        $.ajax({
	                            url: base_url + 'cargasubseccion/fn_cambiardivision',
	                            type: 'POST',
	                            data: {
	                                "fca-txtsubseccionnew": value,
	                                "fca-txtsubseccion": vgrupo,
	                                "fca-txtcodcarga": vcarga
	                            },
	                            dataType: 'json',
	                            success: function(e) {
	                                //$('#divcard_grupo #divoverlay').remove();
	                                if (e.status == true) {

	                                    btn.parent().find('span').html("Grupo " + value);
	                                    btn.data('grupo', value);
	                                    /*setInterval(function(){
	                                    btn.parent().css("border", "0px solid #f37736").animate({'borderWidth': '1px',  'borderColor': 'red'},500);
	                                    }, 2000);*/

	                                    resolve();
	                                } else {
	                                    resolve('Para guardar, debes ingresar un Número válido');
	                                }
	                            },
	                            error: function(jqXHR, exception) {
	                                $(this).bootstrapToggle('off');
	                                //$('#divcard_grupo #divoverlay').remove();
	                                var msgf = errorAjax(jqXHR, exception, 'text');
	                                $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
	                            }
	                        })
	                    }
	                })
	            },
	            allowOutsideClick: false
	        })
	    })()
	});

	$(".fca-btndividir").click(function(event) {
		var btn=$(this);
		var vcarga=$(this).data('codcarga');
		(async () => {const { value: vdocente } = await Swal.fire({
		title: 'Grupo Nro',
		input: 'text',
		inputPlaceholder: 'Ingresa un Número',
		showCancelButton: true,
		confirmButtonText:
		'<i class="fa fa-thumbs-up"></i> Guardar!',
		 inputValidator: (value) => {
		    return new Promise((resolve) => {
		      if ((!value) || (value<=0)) {
		        resolve('Para guardar, debes ingresar un Número válido');
		      }
		      else{
		      	$.ajax({

			            url: base_url + 'cargasubseccion/fn_agregardivision',
			            type: 'POST',
			            data: {"fca-txtsubseccion": value ,"fca-txtcodcarga": vcarga},
			            dataType: 'json',
			            success: function(e) {
			            	//$('#divcard_grupo #divoverlay').remove();
			            	if (e.status==true){
			            		
			            		$("#fca-checkgrupo").change();
			            		resolve();
			            	}
			            	else{
			            		 resolve('Para guardar, debes ingresar un Número válido');
			            	}
			            },
			            error: function(jqXHR, exception) {
			            	$(this).bootstrapToggle('off');
			            	//$('#divcard_grupo #divoverlay').remove();
			                var msgf = errorAjax(jqXHR, exception, 'text');
			                $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
			            }
			        })
		      }
		    })
		  },

        allowOutsideClick: false
		})

		})()
	});


	$(".fd-eliminardivision").click(function(event) {
		var btn=$(this);
		var vcarga=$(this).data('carga');
		var vgrupo=$(this).data('grupo');
		Swal.fire({
		  title: '¿Deseas eliminar el grupo ' + vgrupo + '?',
		  text: "Al eliminar, los alumnos registrados no serán eliminados, permaneceran inactivos hasta asignar un nuevo grupo",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Si, eliminar!'
		}).then((result) => {
		  if (result.value) {
		      	$.ajax({
			            url: base_url + 'cargasubseccion/fn_eliminardivision',
			            type: 'POST',
			            data: {"fca-txtsubseccion": vgrupo ,"fca-txtcodcarga": vcarga},
			            dataType: 'json',
			            success: function(e) {
			            	if (e.status==true){
			            		//btn.parent().find('span').html("Grupo " + value);
			            		//btn.data('grupo',value);
			            			/*setInterval(function(){ 
								        btn.parent().css("border", "0px solid #f37736").animate({'borderWidth': '1px',  'borderColor': 'red'},500);
								    }, 2000);*/
								Swal.fire(
							      'Eliminado!',
							      'La división '+ vgrupo + ' fue eliminado correctamente.',
							      'success'
							    )
			            	}
			            	else{
			            		 resolve(e.msg);
			            	}
			            },
			            error: function(jqXHR, exception) {
			            	//$('#divcard_grupo #divoverlay').remove();
			                var msgf = errorAjax(jqXHR, exception, 'text');
			                Swal.fire(
							      'Error!',
							      msgf,
							      'success'
							    )
			            }
			        })
		      
		    
		  }
		})
	});

	<?php if ($p66 == "SI"): ?>
		$('.fca-checkculminar').bootstrapToggle();
		$(".fca-checkculminar").change(function(event) {
		btn=$(this);
	    fila=btn.closest('.rowcolor');
	    var vdivision =fila.data('division');
	    var vcarga = fila.data('idcarga');
	    if ($(this).prop('checked') == false) {

	        $('#divcard_cursos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  			$('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	        $.ajax({
	            url: base_url + 'curso/fn_curso_culminar',
	            type: 'post',
	            dataType: 'json',
	            data: {"idcarga": vcarga,"division":vdivision},
	            success: function(e) {
	                $('#divcard_cursos #divoverlay').remove();
	                $('#divcard_grupo #divoverlay').remove();
	                if (e.status == true) {
	                    
	                } else {
	                    btn.bootstrapToggle('destroy');
		                btn.prop('checked', true);
		                btn.bootstrapToggle();
	                    Toast.fire({
	                        type: 'danger',
	                        title: 'Error: ' + e.msg
	                    });
	                }
	            },
	            error: function(jqXHR, exception) {
	            	//alert("dd");
	                btn.bootstrapToggle('destroy');
	                btn.prop('checked', true);
	                btn.bootstrapToggle();
	                $('#divcard_cursos #divoverlay').remove();
	                $('#divcard_grupo #divoverlay').remove();
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                Swal.fire({
	                    type: 'error',
	                    title: 'ERROR, NO se pudo culminar',
	                    text: msgf,
	                    backdrop:false,
	                });
	            }
	        });
	    } else {
	        $('#divcard_cursos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  			$('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	        $.ajax({
	            url: base_url + 'curso/fn_curso_reabrir',
	            type: 'post',
	            dataType: 'json',
	            data: {"idcarga": vcarga,"division":vdivision},
	            success: function(e) {
	                $('#divcard_cursos #divoverlay').remove();
	                $('#divcard_grupo #divoverlay').remove();
	                if (e.status == true) {

	                } else {
	                    btn.bootstrapToggle('destroy');
		                btn.prop('checked', false);
		                btn.bootstrapToggle();
	                    Toast.fire({
	                        type: 'danger',
	                        title: 'Error: ' + e.msg
	                    });
	                }
	            },
	            error: function(jqXHR, exception) {
	                 btn.bootstrapToggle('destroy');
	                btn.prop('checked', false);
	                btn.bootstrapToggle();
	                $('#divcard_cursos #divoverlay').remove();
	                $('#divcard_grupo #divoverlay').remove();
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                Swal.fire({
	                    type: 'error',
	                    title: 'ERROR, NO se pudo culminar',
	                    text: msgf,
	                    backdrop:false,
	                });
	            }
	        });
	    }
	});
	<?php endif ?>


	<?php if ($p67 == "SI"): ?>
		$('.fca-checkmostrar').bootstrapToggle();
		$(".fca-checkmostrar").change(function(event) {
		btn=$(this);
	    fila=btn.closest('.rowcolor');
	    var vdivision =fila.data('division');
	    var vcarga = fila.data('idcarga');
	    var chekear=btn.prop('checked') 
	    

	        $('#divcard_cursos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  			$('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	        $.ajax({
	            url: base_url + 'curso/fn_curso_ocultar',
	            type: 'post',
	            dataType: 'json',
	            data: {"idcarga": vcarga,"division":vdivision,"accion":!chekear},
	            success: function(e) {
	                $('#divcard_cursos #divoverlay').remove();
	                $('#divcard_grupo #divoverlay').remove();
	                if (e.status == true) {
	                    
	                } else {
	                    btn.bootstrapToggle('destroy');
		                btn.prop('checked', !chekear);
		                btn.bootstrapToggle();
	                    Toast.fire({
	                        type: 'danger',
	                        title: 'Error: ' + e.msg
	                    });
	                }
	            },
	            error: function(jqXHR, exception) {
	            	//alert("dd");
	                btn.bootstrapToggle('destroy');
	                btn.prop('checked', !chekear);
	                btn.bootstrapToggle();
	                $('#divcard_cursos #divoverlay').remove();
	                $('#divcard_grupo #divoverlay').remove();
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                Swal.fire({
	                    type: 'error',
	                    title: 'ERROR, NO se pudo culminar',
	                    text: msgf,
	                    backdrop:false,
	                });
	            }
	        });
	  
	});
	<?php endif ?>
</script>