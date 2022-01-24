<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
		MIS PAGOS
		<small>Por Periodo</small>
		</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div id="divboxpagos" class="box box-success no-padding">
			<div class="box-header with-border">
				<div class="col-md-3 margin-top-10px no-padding">
					<h3 class="box-title"><i class="fa fa-tag"></i> Selecciona</h3>
					<select class="form-control" name="flcbmatriculaeco" id="flcbmatriculaeco">
						<option value="0">PERIODO</option>
						<?php foreach ($mismatriculas as $mat) { ?>
						<option data-periodo='<?php echo $mat->periodo ?>'
							data-carrera='<?php echo $mat->carrera ?>'
							data-ciclo='<?php echo $mat->ciclo ?>'
							data-seccion='<?php echo $mat->seccion ?>'
							data-turno='<?php echo $mat->turno ?>'
						value="<?php echo $mat->codigo ?>"><?php echo $mat->periodo." - ". $mat->ciclo ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="box-body no-padding">
				<div class="clearfix"></div>
				<div class="col-md-8 no-padding margin-top-10px">
					<div id="divperiodo" class="col-md-4"></div>
					<div id="divcarrera" class="col-md-8"></div>
					<div id="divciclo" class="col-md-4"></div>
					<div id="divturno" class="col-md-4"></div>
					<div id="divseccion" class="col-md-4 text-right"></div>
				</div>
				<div id="divmisdeudas" class="col-md-12 margin-top-10px">
					
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>-->
<script src="<?php echo base_url();?>resources/jquery/pages.js"></script>