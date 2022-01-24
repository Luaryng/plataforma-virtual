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
				$pcodunidad_enc=base64url_encode($carga->codunidad);
				$pcodsede_enc=base64url_encode($carga->codunidad);
		?>
		<div class="row fcarga pt-3 bg-lightgray" data-codcarga='<?php echo $pcodcarga_enc ?>' data-codsede='<?php echo $pcodsede_enc ?>' data-codunidad='<?php echo $pcodunidad_enc ?>'>
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
					<div class="row fdivision bg-white" data-coddivision='<?php echo $pcoddivision_enc ?>'  data-coddocente='<?php echo $pcoddocente_enc ?>' data-coddoc='<?php echo $divi->coddocente ?>'>
						<div class="col-4 col-md-2 cell text-center">
							<div class="row border-top-0 border-bottom-0">
								<div class="col-12 col-md-12">
									<a class="fd-eliminardivision text-danger" href="#" title="Eliminar División" data-grupo="<?php echo $divi->division ;?> " data-carga="<?php echo $divi->codcarga ;?> "><i class="fas fa-minus-square mr-1 "></i></a> 
								
									<small class="text-bold" title="Carga Académica">(<?php echo $carga->codcarga."G".$divi->division ?>)</small>
									<span> Grupo </i><?php echo $divi->division ;?> </span>
									<a class="fd-editvivsion" href="#" title="Cambiar división" data-grupo="<?php echo $divi->division ;?> " data-carga="<?php echo $divi->codcarga ;?> " ><i class="fas fa-pen ml-2"></i></a>
								</div>
							</div>
						</div>
						
						<div class="col-8 col-md-4 cell celleditar_docente">
							<span>
								<?php echo (is_null($divi->coddocente)) ?"SIN DOCENTE":"$divi->paterno $divi->materno $divi->nombres" ?>
							</span>
							<a class="fd-editdocente" data-unidad='<?php echo $carga->unidad ?>' href="#" title="Cambiar docente" data-grupo="<?php echo $divi->division ;?> " data-carga="<?php echo $divi->codcarga ;?> ">
								<i class="fas fa-pen ml-2"></i>
							</a> 
						</div>

						
						<div class="col-4 col-md-4 cell">
							<div class="row border-top-0 border-bottom-0">
								<div class="col-4 col-md-4">
							
									<span>Alum: </i><?php echo $divi->nalum ;?> </span>
									<a target="_blank"  href="<?php echo base_url().'gestion/academico/carga-academica/miembros/enrolar/'.$pcodcarga_enc.'/'.$pcoddivision_enc ?>" title="Enrolar miembros"><i class="fas fa-user-friends ml-2"></i></a>
							
								</div>
								<div class="col-6 col-md-4 mt-0">
									<?php 
										if ($divi->culminado=='SI'){
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
										<span class="d-inline-block text-bold">Abierto: </span> 
										<?php if ($p66=="NO"){
											echo 
											"<span title='Abierto' class='d-inline-block text-white tboton $cbgcolor '>$culminotext</span>";
										}
										else{
											echo 
											"<span class='d-inline-block'>
												<input $checked  class='checktoggle checkOpen' data-size='xs' type='checkbox' data-toggle='toggle' data-on='SI' data-off='NO' data-onstyle='success' data-offstyle='danger'>
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
										<span class="d-inline-block text-bold">Mostrar: </span> 
										<?php if ($p67=="NO"){
											echo 
											"<span title='Mostrar' class='d-inline-block text-white tboton $cbgcolor '>$divi->activo</span>";
										}
										else{
											echo 
											"<span class='d-inline-block'>
												<input $checked  class='checkOcultar' data-size='xs' type='checkbox' data-toggle='toggle' data-on='SI' data-off='NO' data-onstyle='success' data-offstyle='danger' value='$divi->activo'>
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
	
	$(".fd-editdocente").click(function(event) {
		btn_editdocente=$(this);
		var vgrupo=$(this).data('grupo');
		var vcarga=$(this).data('carga');
		var vunidad=$(this).data('unidad');
		$("#vw_md_doc_txtcarga").val(vcarga);
		$("#vw_md_doc_txtdivision").val(vgrupo);
		$("#vw_md_doc_div_unidad").html(vunidad);
		$("#md_docentes").modal("show");
		docactual=btn_editdocente.closest(".fdivision").data('coddoc');
		if (docactual=="") docactual="00000";
		$("#vw_md_doc_docentes").val(docactual);
		

	});

	$('#md_docentes').on('shown.bs.modal', function (e) {
  		$("#vw_md_doc_docentes").focus();

	})

	$('#md_docentes').on('hidden.bs.modal', function (e) {
  		btn_editdocente=null;

	})

	$("#vw_md_doc_guardar").click(function(event) {
		$('#divcontent_docentes').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		var docsel=$("#vw_md_doc_docentes").val();
		vcarga=$("#vw_md_doc_txtcarga").val();
		vgrupo=$("#vw_md_doc_txtdivision").val();
		
		$.ajax({
            url: base_url + 'cargasubseccion/fn_cambiardocente',
            type: 'POST',
            data: {"fca-txtcoddocente": docsel ,"fca-txtsubseccion": vgrupo ,"fca-txtcodcarga": vcarga},
            dataType: 'json',
            success: function(e) {
            	$('#divcontent_docentes #divoverlay').remove();
            	if (e.status==true){
            		
            		if (docsel=='00000'){
            			btn_editdocente.closest(".celleditar_docente").find('span').html("SIN DOCENTE");
            		}
            		else{
            			btn_editdocente.closest(".celleditar_docente").find('span').html(docsel + " " + vdocentes[docsel]);
            			/*setInterval(function(){ 
					        btn.parent().css("border", "0px solid #f37736").animate({'borderWidth': '1px',  'borderColor': 'red'},500);
					    }, 2000);*/
            		}
            		$("#md_docentes").modal("hide");
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
            	$('#divcontent_docentes #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
            }
        })

	});

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

	<?php if ($p66 == "SI"): ?>
		$('.checkOpen').bootstrapToggle();
		$(".checkOpen").change(function(event) {
			btn=$(this);
		    var fila_carga=btn.closest(".fcarga");
	  		var fila_division=btn.closest(".fdivision");

	  		var vcarga=fila_carga.data("codcarga");
	  		var vdivision=fila_division.data("coddivision");
		    
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
		$('.checkOcultar').bootstrapToggle();
		$(".checkOcultar").change(function(event) {
			btn=$(this);
		    var fila_carga=btn.closest(".fcarga");
	  		var fila_division=btn.closest(".fdivision");

	  		var vcarga=fila_carga.data("codcarga");
	  		var vdivision=fila_division.data("coddivision");
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