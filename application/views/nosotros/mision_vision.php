<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
        	<div class="row mb-2">
          		<div class="col-sm-6">
            		<h1 class="m-0 text-dark">Datos de la Institución</h1>
          		</div>
          		<div class="col-sm-6">
            		<ol class="breadcrumb float-sm-right">
              			<li class="breadcrumb-item"><a href="<?php echo base_url() ?>administrador">Inicio</a></li>
              			<li class="breadcrumb-item active">Institución</li>
            		</ol>
          		</div>
        	</div>
      	</div>
	</div>
	<section id="s-cargado" class="content pt-2">
		<div class="container-fluid">
  			<div class="row">
          		<div class="col-lg-3 col-6">
	          		<a href="#" data-toggle="modal" data-target="#modal-mision">           
	            		<div class="small-box bg-info">
	              			<div class="inner">
	                			<h3>Misión</h3>
	                			<p>Institución</p>
	              			</div>
	              			<div class="icon">
	                			<i class="ion ion-ios-navigate"></i>
	              			</div>
	              			<span class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></span>
	            		</div>
	            	</a>
          		</div>
          		<div class="col-lg-3 col-6">
          			<a href="#" data-toggle="modal" data-target="#modal-vision">
          				<div class="small-box bg-success">
			              	<div class="inner">
			                	<h3>Visión</h3>
			                	<p>Institución</p>
			              	</div>
			              	<div class="icon">
			                	<i class="ion ion-eye"></i>
			              	</div>
			              	<span class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></span>
			            </div>
          			</a>
          		</div>
		        <div class="col-lg-3 col-6">
		        	<a href="#" data-toggle="modal" data-target="#modal-objGeneral">
		        		<div class="small-box bg-warning">
		              		<div class="inner">
		                		<h3 class="text-white">Objetivos</h3>
		                		<p class="text-white">Institución</p>
		              		</div>
		              		<div class="icon">
		                		<i class="ion ion-ios-pulse"></i>
		              		</div>
		              		<span class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></span>
		            	</div>
		        	</a>
		        </div>
		        <div class="col-lg-3 col-6">
		        	<a href="#" data-toggle="modal" data-target="#modal-organigrama">
			            <div class="small-box bg-danger">
			              	<div class="inner">
			                	<h3>Organigrama</h3>
			                	<p>Institución</p>
			              	</div>
			              	<div class="icon">
			                	<i class="ion ion-image"></i>
			              	</div>
			              	<span class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></span>
			            </div>
			        </a>
		        </div>
        	</div>
        	<div class="row">
        		<div class="col-12 col-sm-6 col-md-4">
        			<a href="#" data-toggle="modal" data-target="#modal-fines">
			            <div class="info-box">
			              	<span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
			              	<div class="info-box-content">
			                	<span class="info-box-text text-dark">Nuestros Fines</span>
			                	<span class="info-box-number text-dark">
			                  		Institución
			                	</span>
			              	</div>
			            </div>
			        </a>
		        </div>
		    </div>	
  		</div>

	</section>
</div>

<script type="text/javascript">

	$('#btn_addMision').click(function(){
		$('#frm_addMision input,select').removeClass('is-invalid');
	    $('#frm_addMision .invalid-feedback').remove();
	    $('#divcard_mision').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: base_url + 'nosotros/fn_insert_mision',
	        type: 'post',
	        dataType: 'json',
	        data: $('#frm_addMision').serialize(),
	        success: function(e) {
	            $('#divcard_mision #divoverlay').remove();
	            
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#modal-mision').modal('hide');
	                Swal.fire({
	                    title: e.msg,
	                    // text: "",
	                    type: 'success',
	                    allowOutsideClick: false,
                      	showConfirmButton: true,
	                }).then((result) => {
	                  if (result.value) {
	                    location.reload();
	                  }
	                })
	                
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divcard_mision #divoverlay').remove();
	            $('#divmsgMision').show();
	            $('#divmsgMision').html(msgf);
	        }
	    });
	    return false;
	})

	$('#btn_addVision').click(function(){
		$('#frm_addVision input,select').removeClass('is-invalid');
	    $('#frm_addVision .invalid-feedback').remove();
	    $('#divcard_vision').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: base_url + 'nosotros/fn_insert_vision',
	        type: 'post',
	        dataType: 'json',
	        data: $('#frm_addVision').serialize(),
	        success: function(e) {
	            $('#divcard_vision #divoverlay').remove();
	            
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#modal-vision').modal('hide');
	                Swal.fire({
	                    title: e.msg,
	                    // text: "",
	                    type: 'success',
	                    allowOutsideClick: false,
                      	showConfirmButton: true,
	                }).then((result) => {
	                  if (result.value) {
	                    location.reload();
	                  }
	                })
	                
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divcard_vision #divoverlay').remove();
	            $('#divmsgVision').show();
	            $('#divmsgVision').html(msgf);
	        }
	    });
	    return false;
	})


	$('#fictxtorganigrama').change(function(){
		var imagen = this.files[0];
		var datosImagen = new FileReader;
    	datosImagen.readAsDataURL(imagen);

    	$(datosImagen).on("load", function(event){

      		var rutaImagen = event.target.result;

      		$(".previsualizarOrganigrama").attr("src", rutaImagen);

    	})
	})

	$('#btn_addOrgani').click(function(){
		$('#frm_addOrgani input,select').removeClass('is-invalid');
	    $('#frm_addOrgani .invalid-feedback').remove();
	    $('#divcard_organi').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    var formData = new FormData($("#frm_addOrgani")[0]);
	    var imgn = $('#fictxtorganigrama').val();
	    var extension = imgn.split('.').pop();
	    formData.append('extimg',extension);
	    $.ajax({
	        url:$("#frm_addOrgani").attr("action"),
	        type:$("#frm_addOrgani").attr("method"),
	        dataType: 'json',
	        data: formData,
	        cache:false,
	        contentType:false,
	        processData:false,
	        success: function(e) {
	            $('#divcard_organi #divoverlay').remove();
	            
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });

	                // if( $('#fictxtorganigrama').val() == 0){
	                // 	$('#fictxtorganigrama').addClass('is-invalid');
	                //     $('#fictxtorganigrama').parent().append("<div class='invalid-feedback'>" + e.errimg + "</div>");
	                // }
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#modal-organigrama').modal('hide');
	                Swal.fire({
	                    title: e.msg,
	                    // text: "",
	                    type: 'success',
	                    allowOutsideClick: false,
                      	showConfirmButton: true,
	                }).then((result) => {
	                  if (result.value) {
	                    location.reload();
	                  }
	                })
	                
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divcard_organi #divoverlay').remove();
	            $('#divmsgorgani').show();
	            $('#divmsgorgani').html(msgf);
	        }
	    });
	    return false;
	})

	$('#btn_addGeneral').click(function(){
		$('#frm_addObjGen input,select').removeClass('is-invalid');
	    $('#frm_addObjGen .invalid-feedback').remove();
	    $('#divcard_general').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: base_url + 'nosotros/fn_insert_general',
	        type: 'post',
	        dataType: 'json',
	        data: $('#frm_addObjGen').serialize(),
	        success: function(e) {
	            $('#divcard_general #divoverlay').remove();
	            
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#modal-objGeneral').modal('hide');
	                Swal.fire({
	                    title: e.msg,
	                    // text: "",
	                    type: 'success',
	                    allowOutsideClick: false,
                      	showConfirmButton: true,
	                }).then((result) => {
	                  if (result.value) {
	                    location.reload();
	                  }
	                })
	                
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divcard_general #divoverlay').remove();
	            $('#divmsgGeneral').show();
	            $('#divmsgGeneral').html(msgf);
	        }
	    });
	    return false;
	})

	var datosf = $('.panel-collapse');

	/*=============================================
	CAMBIAR TITULO FINES
	=============================================*/
	$(".cambiaTitulo").change(function(){

		var cambiaTitulo = $(".cambiaTitulo");

		for(var i = 0; i < cambiaTitulo.length; i++){

			$(datosf[i]).attr("titulo", $(cambiaTitulo[i]).val());

		}

		crearDatosJsonFines();

	})

	/*=============================================
	CAMBIAR DESCRIPCIÓN FINES
	=============================================*/
	$(".cambiaDetalle").change(function(){

		var cambiaDetalle = $(".cambiaDetalle");

		for(var i = 0; i < cambiaDetalle.length; i++){

			$(datosf[i]).attr("detalle", $(cambiaDetalle[i]).val());

		}

		crearDatosJsonFines();

	})

	/*=============================================
	CREAR DATOS JSON PARA ALMACENAR EN BD
	=============================================*/
	function crearDatosJsonFines(){

		var finesEmpresa = [];

		for(var i = 0; i < datosf.length; i++){


			finesEmpresa.push({"titulo": $(datosf[i]).attr("titulo"),
								"detalle": $(datosf[i]).attr("detalle"),
								"icono": $(datosf[i]).attr("icono")})


			$("#valorFines").val(JSON.stringify(finesEmpresa));

		}

	}

	$('#btn_addfines').click(function(){
		$('#frm_addFines input,select,textarea').removeClass('is-invalid');
	    $('#frm_addFines .invalid-feedback').remove();
	    $('#divcard_fines').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: base_url + 'nosotros/fn_insert_fines',
	        type: 'post',
	        dataType: 'json',
	        data: $('#frm_addFines').serialize(),
	        success: function(e) {
	            $('#divcard_fines #divoverlay').remove();
	            
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#modal-fines').modal('hide');
	                Swal.fire({
	                    title: e.msg,
	                    // text: "",
	                    type: 'success',
	                    allowOutsideClick: false,
                      	showConfirmButton: true,
	                }).then((result) => {
	                  if (result.value) {
	                    location.reload();
	                  }
	                })
	                
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divcard_fines #divoverlay').remove();
	            $('#divmsgFines').show();
	            $('#divmsgFines').html(msgf);
	        }
	    });
	    return false;
	})

</script>