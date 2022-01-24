<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>PRE-INSCRIPCIÓN | ERP</title>
		<?php $vbaseurl=base_url(); ?>
		<link rel="icon" type="image/png" href="<?php echo $vbaseurl.'resources/img/favicon.'.getDominio().'.png'?>" />
		<!-- Font Awesome Icons -->
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/fontawesome-free/css/all.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/adminlte.min.css">
		<!-- Google Font: Source Sans Pro -->

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
		<script src="<?php echo $vbaseurl ?>resources/plugins/jquery/jquery.min.js"></script>
		<!-- <script src="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.js"></script> -->
		<!-- Bootstrap 4 -->
		<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- AdminLTE App -->
		<script src="<?php echo $vbaseurl ?>resources/dist/js/adminlte.min.js"></script>
		<script src="<?php echo $vbaseurl ?>resources/plugins/sweetalert2/sweetalert2.min.js"></script>
		
		
		<body class="hold-transition layout-top-nav layout-navbar-fixxed ">
			
			<div class="wrapper ">
				<!-- Navbar -->
				
				<div class="container text-center text-lg-left">
					<img src="<?php echo $vbaseurl.'resources/img/logo_h80.'.getDominio().'.png'?>" alt="AdminLTE Logo" class="img-fluid mr-3">
					<h3 class="d-inline-block"><?php echo $ies->denoml ?></h3>
					
				</div>
				<?php
				$dominio=str_replace(".", "_",getDominio());
				include 'vw_ficha_pre_matricula_'.$dominio.".php";
				?>
				<footer class="main-footer">
					<!-- To the right -->
					<div class="float-right d-none d-sm-block">
						<b>Version</b> 1.0.0
					</div>
					<!-- Default to the left -->
					<strong>Copyright &copy; 2019 <a href="https://activaclic.com">activaclic.com</a>.</strong>
				</footer>
			</div>
		</body>
	</html>