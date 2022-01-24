<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>MESA DE PARTES | ERP</title>
		<?php $vbaseurl=base_url() ?>
		<link rel="icon" type="image/png" href="<?php echo $vbaseurl.'resources/img/favicon.'.getDominio().'.png'?>" />
		<!-- Font Awesome Icons -->
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/fontawesome-free/css/all.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/adminlte.min.css">
		<!-- Google Font: Source Sans Pro -->
		
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/sweetalert2/sweetalert2.min.css">
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/private-v5.css">
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

	<body class="hold-transition layout-top-nav">
		<div class="wrapper">
			<div class="container">
				<nav class="main-d navbar navbar-expand navbar-white navbar-light">
				    <ul class="navbar-nav">
				      <li class="nav-item">
				        <img src="<?php echo $vbaseurl.'resources/img/logo_h80.'.getDominio().'.png'?>" alt="AdminLTE Logo" class="brand-image">
				      </li>
				    </ul>
				    
				</nav>
				<?php $vbaseurl=base_url(); ?>
				<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
				<div class="content-wrapper">
					<section class="content-header">
						<div class="container-fluid">
							<div class="row">
								<div class="col-sm-6">
									<h1>MESA DE PARTES
									<small></small></h1>
								</div>
							</div>
						</div>
					</section>
					<section class="content">
						<div id="divcard-general" class="card">
							<div class="card-header ">
								<h3 class="card-title">SEGUIMIENTO EXPEDIENTE</h3>
								
							</div>
							
							<div class="card-body">
								<form id="frm_search_expediente" action="<?php echo $vbaseurl ?>mesa_partes/vw_expediente_solicitud_ruta" method="post" accept-charset="utf-8">
									<div class="row">
										<div class="form-group has-float-label col-md-4">
											<input id="vw_mp_txt_codseguim" name="vw_mp_txt_codseguim" type="text" class="form-control form-control-sm col-md-10 " autocomplete="off" placeholder="Código seguimiento">
											<label for="vw_mp_txt_codseguim">Código seguimiento</label>
										</div>
										<div class="form-group has-float-label col-md-4">
											<input id="vw_mp_txt_anio" name="vw_mp_txt_anio" type="text" class="form-control form-control-sm col-md-10 " autocomplete="off" placeholder="Año">
											<label for="vw_mp_txt_anio">Año</label>
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>
										</div>
									</div>
								</form>
								<div id="divcard_historial">
									
								</div>
								<div class="row mt-2">
									<a type="button" href="<?php echo $vbaseurl ?>tramites/externo/mesa-de-partes/agregar" class="btn btn-danger btn-md float-left btn-sm" ><i class="fas fa-undo"></i> Regresar</a>
								</div>
							</div>
						</div>
					</section>
				</div>
				<footer class="main-footer">
					<!-- To the right -->
					<div class="float-right d-none d-sm-block">
						<b>Version</b> 1.0.0
					</div>
					<!-- Default to the left -->
					<strong>Copyright &copy; 2019 <a href="https://activaclic.com">activaclic.com</a>.</strong>
				</footer>
			</div>
		</div>
		<script src="<?php echo $vbaseurl ?>resources/plugins/jquery/jquery.min.js"></script>
		<!-- Bootstrap 4 -->
		<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- AdminLTE App -->
		<script src="<?php echo $vbaseurl ?>resources/dist/js/adminlte.min.js"></script>
		<script src="<?php echo $vbaseurl ?>resources/plugins/sweetalert2/sweetalert2.min.js"></script>
		<script>
			$(document).ready(function() {

		        const Toast = Swal.mixin({
		          toast: true,
		          position: 'top-end',
		          showConfirmButton: false,
		          timer: 5000,
		          timerProgressBar: true,
		        })

		        Toast.fire({
		          type: 'info',
		          icon: 'info',
		          title: 'Aviso: Para buscar el expediente debe completar los campos'
		        })
		        $("#vw_mp_txt_codseguim").focus();
		    });

			$('#frm_search_expediente').submit(function() {
				$('#frm_search_expediente input,select').removeClass('is-invalid');
				$('#frm_search_expediente .invalid-feedback').remove();
				$('#divcard-general').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
				$.ajax({
					url: $("#frm_search_expediente").attr("action"),
					type: 'post',
					dataType: 'json',
					data: $('#frm_search_expediente').serialize(),
					success: function(e) {
						$('#divcard-general #divoverlay').remove();
						if (e.status == false) {
							$.each(e.errors, function(key, val) {
								$('#' + key).addClass('is-invalid');
								$('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
							});

							
						} else {

							$("#divcard_historial").html(e.datos);
							
						}
					},
					error: function(jqXHR, exception) {
						var msgf = errorAjax(jqXHR, exception,'text');
						$('#divcard-general #divoverlay').remove();
						Swal.fire({
							title: msgf,
							// text: "",
							type: 'error',
							icon: 'error',
						})
					}
				});
				return false;
			});

		</script>
	</body>
</html>