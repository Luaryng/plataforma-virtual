<?php
	$p66=getPermitido("66");
	$p67=getPermitido("67");
	$p128 = getPermitido("128");
?>
<div id="divtabl-addamiembros" class="col-12 col-md-12 neo-table">
	<div class="col-md-12 header d-none d-md-block">
		<div class="row">
			
			<div class="col-12 col-md-4 group">
				<div class="col-6 col-md-2 cell">
					NRO
				</div>
				<div class="col-12 col-md-10 cell">
					UNIDAD DID.
				</div>
			</div>
			<div class="col-2 col-md-1 cell text-center">
				CIC
			</div>
			<div class="col-2 col-md-2 cell text-center">
				HORAS
			</div>
			<div class="col-2 col-md-1 cell text-center">
				HOR/CIC
			</div>
			<div class="col-2 col-md-2 cell text-center">
				CRED.
			</div>
			<!----><div class="col-2 col-md-2 cell text-center">
				CHK
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
				$pcodcarga_enc=base64url_encode($carga->codcarga);
				$codunidad64=base64url_encode($carga->codunidad);
				//$pcodsede_enc=base64url_encode($carga->idsede);
		?>
		<div class="row fcarga pt-3 bg-lightgray" data-codcarga='<?php echo $pcodcarga_enc ?>' data-codunidad='<?php echo $codunidad64 ?>' data-unidad='<?php echo $carga->unidad ?>'>
			<div class="col-12 col-md-4 group">
				<div class="col-2 col-md-1 cell">
					<span><?php echo $nro ;?></span>
				</div>
				<div class="unidad col-10 col-md-11 cell text-bold">

					<?php echo "<span title='Unidad Didáctica'>($carga->codunidad) </span> $carga->unidad" ?>

				</div>
			</div>
			<div class="col-4 col-md-1 cell text-center">
					<span><b>Cic: </b><?php echo $carga->codciclo ?></span>
			</div>

			<div class="col-4 col-md-2 cell text-center">
					<span><b>Hrs: </b>
						<?php echo  ($carga->hst + $carga->hsp ) ?> 
					</span>
			</div>
			<div class="col-4 col-md-1 cell text-center">
					<span><?php echo $carga->hc ?></span>
			</div>
			<div class="col-6 col-md-2 cell text-center">
					<span><b>Crd: </b>
						<?php 
						echo  ($carga->ct + $carga->cp )?> 
					</span>
			</div>
				
			<!---->
			<div class="col-6 col-md-2 cell text-center">
				<input checked class="fca-checkcursovw"  data-codcarga='<?php echo $carga->codcarga  ?>' 
						data-codunidad='<?php echo $carga->codunidad ?>' data-size="xs"  type="checkbox" data-toggle="toggle" 
						data-on="<i class='fa fa-check'></i>" data-off="<i class='fas fa-arrow-alt-circle-right'></i>" 
						data-onstyle="success" data-offstyle="danger">
				<button title="Dividir" data-codcarga='<?php echo $carga->codcarga  ?>' class="btn btn-primary btn-xs fca-btndividir"><i class="far fa-plus-square"></i> <i class="fas fa-layer-group"></i></button>
			</div>
			
			<div class="col-12">
		
		<?php 
			foreach ($divisiones as $key => $divi) {
				if ($carga->codcarga==$divi->codcarga){
					$pcoddivision_enc=base64url_encode($divi->division);
					$pcoddocente_enc=base64url_encode($divi->coddocente);

					?>
					<div class="row fdivision bg-white" data-codcarga64='<?php echo $pcodcarga_enc ?>' data-division64='<?php echo $pcoddivision_enc ?>' data-coddivision='<?php echo $pcoddivision_enc ?>' data-codunidad64='<?php echo $codunidad64 ?>'  data-coddocente='<?php echo $pcoddocente_enc ?>'  data-coddoc='<?php echo $divi->coddocente ?>'>
						<div class="col-4 col-md-2 cell text-center">
							<div class="row border-top-0 border-bottom-0">
								<div class="col-12 col-md-12">
									<a class="fd-eliminardivision text-danger" href="#" title="Eliminar División" data-grupo="<?php echo $divi->division ;?> " data-carga="<?php echo $divi->codcarga ;?> "><i class="fas fa-minus-square mr-1 "></i></a> 
								
									<span class="text-bold" title="Carga Académica">(<?php echo $carga->codcarga."G".$divi->division ?>)</span>
									<span> Grupo </i><?php echo $divi->division ;?> </span>
									<a class="fd-editvivsion" href="#" title="Cambiar división" data-grupo="<?php echo $divi->division ;?> " data-carga="<?php echo $divi->codcarga ;?> " ><i class="fas fa-pen ml-2"></i></a>
								</div>
							</div>
						</div>
						
						<div class="col-8 col-md-4 cell ">
							<span class="spandocente">
								<?php echo (is_null($divi->coddocente)) ?"SIN DOCENTE":"$divi->paterno $divi->materno $divi->nombres" ?>
							</span>
							<a onclick='vw_abrir_modal_cambiarDocente($(this));return false;' href="#" title="Cambiar docente">
								<i class="fas fa-pen ml-2"></i>
							</a> 
						</div>

						
						<div class="col- col-md-3 cell">
							<div class="row border-top-0 border-bottom-0">
								<div class="col-3 col-md-3">
							
									<span></i><?php echo $divi->nalum ;?> </span>
									<a target="_blank"  href="<?php echo base_url().'gestion/academico/carga-academica/miembros/enrolar/'.$pcodcarga_enc.'/'.$pcoddivision_enc ?>" title="Enrolar miembros"><i class="fas fa-user-friends ml-2"></i></a>
							
								</div>
								<div class="col-6 col-md-5 mt-0">
									<?php 
										if ($divi->culminado=='SI'){
											$cbgcolor="bg-danger";
											$checked="";
											$culminotext="Culminado";
										}
										else{
											$cbgcolor="bg-success";
											$checked="checked";
											$culminotext="Abierto";
										}
										?>
										<!--<span class="d-inline-block text-bold">Abierto: </span> -->
										<?php if ($p66=="NO"){
											echo 
											"<span title='Abierto' class='d-inline-block text-white tboton $cbgcolor '>$culminotext</span>";
										}
										else{
											echo 
											"<span class='d-inline-block'>
												<input $checked  class='checktoggle checkOpen' data-size='xs' type='checkbox' data-toggle='toggle' data-on='Abierto' data-off='Culminado' data-onstyle='success' data-offstyle='danger'>
											</span>";
										}
									?>
								</div>
								<div class="col-6 col-md-4">
									<?php 
										if ($divi->activo=='NO'){
											$cbgcolor="bg-danger";
											$checked="";
											
										}
										else{
											$cbgcolor="bg-success";
											$checked="checked";
											
										}
										?>
										<!--<span class="d-inline-block text-bold">Mostrar: </span> -->
										<?php if ($p67=="NO"){
											echo 
											"<span title='Mostrar' class='d-inline-block text-white tboton $cbgcolor '>$divi->activo</span>";
										}
										else{
											echo 
											"<span class='d-inline-block'>
												<input $checked  class='checkOcultar' data-size='xs' type='checkbox' data-toggle='toggle' data-on='Visible' data-off='Oculto' data-onstyle='success' data-offstyle='danger' value='$divi->activo'>
											</span>";
										}
									?>
								</div>

							</div>
						</div>
						<div class="col-4 col-md-2 cell text-center">
							<div class="btn-group dropleft">
		                      <button class="btn btn-secondary btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                        <i class="fas fa-sort-numeric-down-alt"></i> Notas
		                      </button> 
		                      <div class="dropdown-menu">
		                        <?php 
		                            if ($p128 == "SI")  {
		                                echo "<a class='dropdown-item' href='#'  onclick='fn_search_alumnos($(this));return false;'>Migrar</a>";
		                            }
		                            if ($p128 == "SI")  {
		                                echo "<a class='dropdown-item' href='#'  onclick='fn_modGuardarNotas($(this));return false;'>Modificar Notas</a>";
		                            }
		                            
		                         ?>
		                        

		                      </div>
		                    </div>

							
							
						</div>
						<div class="col-md-1 cell">
							<a class="btn btn-info btn-sm py-0" href="#" onclick="vw_abrir_modal_fusion($(this));return false">
								<?php echo $divi->codcarga_aula."G".$divi->division_aula ?>
							</a>
							
						</div>
					</div>
					<?php
				}
			}
		 ?>
		 	</div>
		 </div>
		<?php }} ?>
	</div>
</div>
<script>
		
	$('.fca-checkcursovw').bootstrapToggle();
	$(".fca-checkcursovw").change(function(event) {
		
		if ($(this).prop('checked')==true){

			Swal.fire({
			  title: '¿Deseas Activar el Curso?',
			  text: "Al activar, los grupos o divisiones seran tambien activados",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, Activar!'
			}).then((result) => {
			  if (result.value) {
					$("#divcard_grupo select").prop('disabled', false);
					$('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
					$('#divcard_cursos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
					
					
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
				            	$('#divcard_cursos #divoverlay').remove();
				            	
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
				            	$('#divcard_cursos #divoverlay').remove();
				                var msgf = errorAjax(jqXHR, exception, 'text');
				                $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
				            }
			        });
			    }
			})
		}
		else{
			Swal.fire({
			  title: '¿Deseas eliminar el Curso?',
			  text: "Al eliminar, los grupos o divisiones seran tambien eliminados, esto incluye notas y asitencias",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, eliminar!'
			}).then((result) => {
			  if (result.value) {

					$("#divcard_grupo select").prop('disabled', false);
					$('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
					$('#divcard_cursos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
					var codcarga=$(this).data('codcarga');
					$.ajax({
			            url: base_url + 'cargaacademica/fn_activar',
			            type: 'post',
			            dataType: 'json',
			            data: {"fca-txtcarga":codcarga,"fca-txtactivar":'NO'},
			            success: function(e) {
			            	$("#divcard_grupo select").prop('disabled', true);
			            	$('#divcard_cursos #divoverlay').remove();
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
			            	$('#divcard_cursos #divoverlay').remove();
			                var msgf = errorAjax(jqXHR, exception, 'text');
			                $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
			            }
			        });
	        	}
			})
		}	
	});

	/*$(".fd-editdocente").click(function(event) {
		var btn=$(this);
		var vgrupo=$(this).data('grupo');
		var vcarga=$(this).data('carga');
		var vunidad=$(this).data('unidad');

		(async () => {const { value: vdocente } = await Swal.fire({
		title: vunidad,
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
	});*/
	

	$('#md_docentes').on('shown.bs.modal', function (e) {
  		$("#vw_md_doc_docentes").focus();

	})

	$('#md_docentes').on('hidden.bs.modal', function (e) {
  		btn_editdocente=null;
	})

	

	$(".fd-editvivsion").click(function(event) {
		var btn=$(this);
		var vgrupo=$(this).data('grupo');
		var vcarga=$(this).data('carga');
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
			            url: base_url + 'cargasubseccion/fn_cambiardivision',
			            type: 'POST',
			            data: {"fca-txtsubseccionnew": value ,"fca-txtsubseccion": vgrupo ,"fca-txtcodcarga": vcarga},
			            dataType: 'json',
			            success: function(e) {
			            	//$('#divcard_grupo #divoverlay').remove();
			            	if (e.status==true){
			            		

			            			btn.parent().find('span').html("Grupo " + value);
			            			btn.data('grupo',value);
			            			/*setInterval(function(){ 
								        btn.parent().css("border", "0px solid #f37736").animate({'borderWidth': '1px',  'borderColor': 'red'},500);
								    }, 2000);*/
		
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
								Swal.fire(
							      'Eliminado!',
							      'La división '+ vgrupo + ' fue eliminado correctamente.',
							      'success'
							    )
							    btn.closest('.fdivision').remove();
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

	

</script>