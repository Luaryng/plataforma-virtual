<?php
	$vbaseurl=base_url();
	$vuser=$_SESSION['userActivo'];
?>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<!-- Main content -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6">
					<h1>Panel de Control</h1>
				</div>
				
			</div>
			</div><!-- /.container-fluid -->
		</section>
		<section id="s-cargado" class="content">
			<div class="row">
				<!------------->
				<!--SISTEMA---->
				<!------------->
				<?php if (getPermitido("33")=='SI') { ?>
				<div class="col-6 col-sm-3">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title text-bold">Sistema</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body p-0">
							<ul class="nav nav-pills flex-column">
								<?php if (getPermitido("28")=='SI') {?>
								<li class="nav-item active">
									<a href="<?php echo $vbaseurl ?>administrador/cuentas" class="nav-link">
										<i class="fas fa-inbox mx-2"></i> Usuarios
										<!--<span class="badge bg-primary float-right">12</span>-->
									</a>
								</li>
								 <?php }
								if ($vuser->codnivel=="0") {?>
								<li class="nav-item">
									<a href="<?php echo $vbaseurl ?>administrador/acciones" class="nav-link">
										<i class="far fa-envelope mx-2"></i> Acciones
									</a>
								</li>							
								<?php } ?>
							</ul>
						</div>
						<!-- /.card-body -->
					</div>
				</div>
				<?php } ?>
				<!------------->
				<!--ADMISIÓN--->
				<!------------->
				<div class="col-6 col-sm-3">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title text-bold">Admisión</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body p-0">
							<ul class="nav nav-pills flex-column">
								<li class="nav-item active">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="fas fa-inbox mx-2"></i> Datos personales
										<!--<span class="badge bg-primary float-right">12</span>-->
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="far fa-envelope mx-2"></i> Postulantes
									</a>
								</li>
								<li class="nav-item text-bold">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="far fa-file-alt"></i> Otros
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="fas fa-filter mx-2"></i> Periodos
										<!--<span class="badge bg-warning float-right">65</span>-->
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="far fa-trash-alt mx-2"></i> Campañas
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="far fa-file-alt mx-2"></i> Ubigeo
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="fas fa-filter mx-2"></i> Modalidad
										<span class="badge bg-warning float-right">65</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="far fa-trash-alt mx-2"></i> Carreras
									</a>
								</li>
							</ul>
						</div>
						<!-- /.card-body -->
					</div>
				</div>
				<!------------->
				<!--ACADÉMICO-->
				<!------------->
				<div class="col-6 col-sm-3">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title text-bold">Académico</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body p-0">
							<ul class="nav nav-pills flex-column">
								<li class="nav-item active">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="fas fa-inbox mx-2"></i> Datos personales
										<!--<span class="badge bg-primary float-right">12</span>-->
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="far fa-envelope mx-2"></i> Postulantes
									</a>
								</li>
								<li class="nav-item text-bold">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="far fa-file-alt"></i> Otros
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="fas fa-filter mx-2"></i> Plan de estudios
										<!--<span class="badge bg-warning float-right">65</span>-->
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="far fa-trash-alt mx-2"></i> Modulo Educativo
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="far fa-file-alt mx-2"></i> Unidad Didactica
									</a>
								</li>
								
							</ul>
						</div>
						<!-- /.card-body -->
					</div>
				</div>
				<!------------->
				<!--BIBLIOTECA-->
				<!------------->
				<div class="col-6 col-sm-3">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title text-bold">Biblioteca</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body p-0">
							<ul class="nav nav-pills flex-column">
								<li class="nav-item active">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="fas fa-inbox mx-2"></i> Editoriales
										<!--<span class="badge bg-primary float-right">12</span>-->
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="far fa-envelope mx-2"></i> Autores
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo $vbaseurl ?>/" class="nav-link">
										<i class="far fa-file-alt mx-2"></i> Libros
									</a>
								</li>
								
								
							</ul>
						</div>
						<!-- /.card-body -->
					</div>
				</div>

			</div>
		</section>
	</div>
	<!--content-wrapper -->
	<!--<script src="<?php echo $vbaseurl ?>resources/plugins/form-multi-steps/form-ms.js"></script>-->
