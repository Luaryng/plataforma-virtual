<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	
	<section class="content-header">
		<h1>
		MIS DEUDAS
		<small>Por Periodo</small>
		</h1>
		<!--<ol class="breadcrumb">
			<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
			<li >Mis Cursos</li>
			<li class="active">Carrera</li>
		</ol>-->
	</section>
	<!-- Main content -->
	<section class="content">
		<div id="divboxpagos" class="box box-success no-padding">
			<div class="box-body ">
				<div class="clearfix"></div>
				<div class="col-md-8 no-padding margin-top-10px">
					<div id="divperiodo" class="col-md-4"></div>
					<div id="divcarrera" class="col-md-8"></div>
					<div id="divciclo" class="col-md-4"></div>
					<div id="divturno" class="col-md-4"></div>
					<div id="divseccion" class="col-md-4 text-right"></div>
				</div>
				<div class="clearfix"></div>
				<div id="divmisdeudas" class="table-responsive margin-top-10px">
					<table class="table table-bordered table-striped table-hover table-condensed" id="tr-cursos" role="table">
						<thead role="rowgroup">
							<tr role="row">
								<th role="columnheader">CÓDIGO</th>
								<th role="columnheader">DEUDA</th>
								<th role="columnheader">STATUS</th>
								
								<th role="columnheader">CICLO</th>
								<th role="columnheader">MONTO</th>
								<th role="columnheader">DEBE</th>
								<th role="columnheader">VENCE</th>
								<th role="columnheader">PRORROGA</th>
								<th role="columnheader">VOUCHER</th>
								<th role="columnheader">OBSER.</th>
							</tr>
						</thead>
						<tbody role="rowgroup">

							<?php 
							
							foreach ($deudas as $deuda) {
								$stdeuda="PAGADA";
								$capr= "text-success";
								$bgfila="";
								$fvence = new DateTime($deuda->vence);
								$fhoy = new DateTime();
								if ($deuda->saldo>0){
									$capr="text-danger";
									$stdeuda="VENCIDA";
									$bgfila="danger";
									if ($fvence>$fhoy){
										$stdeuda="POR PAGAR";
										$capr="text-primary";
										$bgfila="";
									}
								}
							
								$fvence = $fvence->format("d-m-Y");
								?>
								<tr role="row" class="<?php echo $bgfila ?>">
									<td role="cell">
										<span class="hidden-print"><i class="fa fa-circle <?php echo $capr ?>"> </i> 
										</span> 
										<?php  echo $deuda->id  ?>
									</td>
									<td role="cell"><b><?php  echo $deuda->codgestion." / ".$deuda->gestion ?> </b></td>
									<td role="cell" class="<?php echo $capr ?>"><b><?php  echo $stdeuda ?> </b></td>
									
									<td role="cell"><?php  echo $deuda->periodo." / ".$deuda->ciclo  ?></td>
									<td role="cell" class="text-right"><?php  echo number_format($deuda->monto, 2)  ?></td>
									<td role="cell" class="text-right"><b><?php  echo number_format($deuda->saldo, 2)  ?></b></td>

									<td role="cell"><?php  echo $fvence ?></td>
									<td role="cell"><?php  echo $deuda->prorroga  ?></td>
									<td role="cell"><?php  echo $deuda->voucher  ?></td>
									<td role="cell"><?php  echo $deuda->obs  ?></td>
								</tr>
								<?php } ;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>-->
<!--<script src="<?php echo base_url();?>resources/jquery/pages.js"></script>-->