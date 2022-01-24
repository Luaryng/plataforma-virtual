
<?php $vbaseurl=base_url(); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 			<?php include 'vw_curso_encabezado.php'; ?>

			<div class="card-body ">
				<div id="divsesionprocesos">
					
				</div>
				<div class="panel panel-primary">
					
					<div class="panel-body">
						<ul class="tree-sesiones">
							<?php
							$item=0;
							$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
							foreach ($sesiones as $key => $ss) {
								$item++;
								$date = new DateTime($ss->fecha);
								$vfecha= $date->format('d/m/Y');
								$hinia = new DateTime($ss->hini);
								$hfina = new DateTime($ss->hfin);
								$hini=$hinia->format('h:i a');
								$hfin=$hfina->format('h:i a');
								$vnroses=str_pad($ss->nrosesion, 2, "0", STR_PAD_LEFT);
							?>
							<div class="card border border-primary div-sesion">
								<div class="card-header">
									<h3 class="card-title text-bold" data-toggle="tooltip" title="<?php echo $ss->id ?>">
									<i class="fa fa-angle-double-right text-success"></i>
									SESIÓN <?php echo $vnroses." - ".$ss->tipo ?>
									</h3>
								</div>
								<div class="card-body px-3 pb-3 pt-1">
									<div class="row">
										<div class="col-md-12">
											<span class="text-bold"><?php echo $ss->detalle ?></span><br>
											<u> <?php echo $dias[date("w", strtotime($ss->fecha))]."</u> ".$vfecha." ".$hini." - ".$hfin; ?>
										</div>
										<div class="col-12">
											
											
												<?php 
												if (trim($ss->hlink)!=""){
													 
													echo "<a target='_blank' class='vd_link mr-2' href='$ss->hlink'>$ss->hlink</a>";
													echo "<a target='_blank' href='$ss->hlink' class='btn btn-tool bg-primary'><i class='fas fa-video'></i> Unirte</a>";
												}
												
											?>
										</div>
										<div class="col-12 mt-2">
											<a target="_blank" class="fl_link" href="<?php echo base_url().'upload/docweb/'. $ss->linkf ?>">
												<?php echo ($ss->archivo != "") ? getIcono('P',$ss->linkf).' '.$ss->archivo.' ('.formatBytes($ss->pesof).')' : ""?>
											</a>
										</div>
										
									</div>
								</div>
								<!-- /.card-body -->
								
							</div>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
	