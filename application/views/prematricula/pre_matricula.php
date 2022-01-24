<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>PRE-INSCRIPCIÓN | IESTWEB</title>
	<?php $vbaseurl=base_url(); ?>
	<link rel="icon" type="image/png" href="<?php echo $vbaseurl.'resources/img/favicon.'.getDominio().'.png'?>" />
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/fontawesome-free/css/all.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/adminlte.min.css">
	<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/private-v3.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/sweetalert2/sweetalert2.min.css">
	<script>
      	var base_url = '<?php echo $vbaseurl; ?>';
      	var getUrlParameter = function getUrlParameter(sParam,sDefault) {
          	var params = new window.URLSearchParams(window.location.search);
          	var param =params.get(sParam);
          	return (param===null) ? sDefault : param;
      	};

      	function errorAjax(jqXHR, exception,msgtype) {
          	var msg = '';
          	if (jqXHR.status === 0) {
              	msg = 'Conexión perdida.\n Verifica tu red y conexión al Servidor.';
          	} else if (jqXHR.status == 404) {
              	msg = 'Página no encontrada. [404]';
          	} else if (jqXHR.status == 500) {
              	msg = 'Internal Server Error [500].';
          	} else if (exception === 'parsererror') {
              	msg = 'Requested JSON parse failed1.';
          	} else if (exception === 'timeout') {
              	msg = 'Time out error.';
          	} else if (exception === 'abort') {
              	msg = 'Ajax request aborted.';
          	} else {
              	msg = 'Uncaught Error.\n' + jqXHR.responseText;
          	}
          	if (msgtype=='div'){
            	return '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + msg + '</div>';
          	}
          	else
          	{
            	return msg;
          	}
          
          
      	}

  </script>
</head>
<body class="hold-transition layout-top-nav layout-navbar-fixxed ">
	
	<div class="wrapper ">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand-md navbar-dark bg-white">

		    <div class="container">
		    	<img src="<?php echo $vbaseurl.'resources/img/logo_h80.'.getDominio().'.png'?>" alt="AdminLTE Logo" class="img-fluid">
		      	IESTP CHARLES ASHBEE
		      
		      	

		      	
		    </div>
		</nav>
		<!-- /.navbar -->
  		<div class="content-wrapper ">
  			<!-- Content Header (Page header) -->
		    <div class="content-header">
		      	<div class="container">
		        	<div class="row mb-2">
		          		<div class="col-sm-6">
		            		<h1 class="m-0 text-dark"> Proceso de Inscripción</h1>
		          		</div><!-- /.col -->
		          		<div class="col-sm-6">
		            		<ol class="breadcrumb float-sm-right">
		              			<!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
		              			<li class="breadcrumb-item active">Pre-Inscripción</li>
		            		</ol>
		          		</div><!-- /.col -->
		        	</div><!-- /.row -->
		      	</div><!-- /.container-fluid -->
		    </div>
		    <!-- /.content-header -->

		    <!-- Main content -->
		    <div class="content">
		      	<div class="container" style="background-image: url('<?php echo base_url() ?>resources/img/inscrip.jpg ');">
		        	<div class="row">
		        		<!--<div class="col-lg-6">
		        			<div class="card">
		        				<div class="card-header">
				                	<h5 class="card-title m-0">AQUI VA A IR LA PUBLICIDAD</h5>
				              	</div>
		        			</div>
		        		</div>-->
		        		<div class="col-md-9 offset-md-3  col-lg-6 offset-lg-6  p-3 p-md-5">
				            <div class="card" id="divcard_prematricula">
				              	<div class="card-header">
				                	<h5 class="card-title m-0">Ficha de Inscripción</h5>
				              	</div>
				              	<div class="card-body">
				              		<form id="form_prematricula" action="<?php echo $vbaseurl ?>prematricula/fn_insert" method="post" accept-charset="utf-8">
				              			<div class="border p-3">
					              			<div class="row">
					              				<div class="form-group has-float-label col-md-12">
					              					<input class="form-control" type="text" name="txtapellidos" id="txtapellidos" placeholder="Apellidos">
													<label for="txtapellidos"><i class="fa fa-user"></i> Apellidos</label>
					              				</div>
												
												<div class="form-group has-float-label col-md-12">
													<input type="text" name="txtnombres" id="txtnombres" placeholder="Nombres" class="form-control">
													<label for="txtnombres"><i class="fa fa-user"></i> Nombres</label>
												</div>
												
					              			</div>
					              			<div class="row">
					              				<div class="form-group has-float-label col-md-6">
					              					<input class="form-control" type="text" name="txtdni" id="txtdni" placeholder="N° Documento">
													<label for="txtdni"> N° Documento</label>
					              				</div>
												
												<div class="form-group has-float-label col-md-6">
													<input class="form-control" type="text" name="txttelefono" id="txttelefono" placeholder="Telefono/Celular">
													<label for="txttelefono"><i class="fa fa-phone"></i> Telefono/Celular</label>
												</div>
					              			</div>
					              			<div class="row">
					              				<div class="form-group has-float-label col-md-12">
					              					<input class="form-control" type="email" name="txtcorreo" id="txtcorreo" placeholder="Correo electrónico">
													<label for="txtcorreo"><i class="fa fa-at"></i> Correo electrónico</label>
					              				</div>
					              				<div class="form-group has-float-label col-md-12">
					              					<select name="cbocarrera" id="cbocarrera" class="form-control">
					              						<option value="">Seleccione programa</option>
					              						<?php
					              							foreach ($carrera as $carr) {
					              								echo '<option value="'.$carr->id.'">'.$carr->nombre.'</option>';
					              							}
					              						?>
					              					</select>
					              					<label for="cbocarrera"><i class="fa fa-graduation-cap"></i> Programa de estudios</label>
					              				</div>
					              			</div>
					              		</div>
					              		<div class="row mt-3">
					              			<div class="col-md-12">
					              				<button type="submit" class="btn btn-primary btn-flat float-right"><i class="fa fa-save"></i> Enviar</button>
					              			</div>
					              		</div>
				              		</form>
				              		
				              	</div>
				            </div>
				        </div>
		        	</div>
		        </div>
		    </div>
  		</div>
  		<!-- Main Footer -->
		<footer class="main-footer">
		    <!-- To the right -->
		    <div class="float-right d-none d-sm-block">
				<b>Version</b> 1.0.0
			</div>
		    <!-- Default to the left -->
		    <strong>Copyright &copy; 2019 <a href="https://activaclic.com">activaclic.com</a>.</strong>
		</footer>
	</div>

	<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo $vbaseurl ?>resources/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $vbaseurl ?>resources/dist/js/adminlte.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/sweetalert2/sweetalert2.min.js"></script>

<script type="text/javascript">
	$('#form_prematricula').submit(function() {
	    $('#form_prematricula input,select').removeClass('is-invalid');
	    $('#form_prematricula .invalid-feedback').remove();
	    $('#divcard_prematricula').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	            $('#divcard_prematricula #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });

	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#divmsgautores').html(msgf);
	                Swal.fire({
	                    title: e.msg,
	                    // text: "Por favor Agregue Ejemplares!",
	                    icon: 'success',
	                }).then((result) => {
	                  if (result.value) {
	                    location.reload();
	                  }
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divcard_prematricula #divoverlay').remove();
	            Swal.fire({
                    title: "Error",
                    text: msgf,
                    icon: 'error',
                })
	        }
	    });
	    return false;
	});
</script>
</body>
</html>