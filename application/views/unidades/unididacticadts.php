<?php if(count($unidades) > 0) { ?>
<div id="divtabl_plan" class="col-12 btable">
	<div class="col-12 thead d-none d-md-block">
		<div class="row">
			<div class="col-12 col-md-3">
				<div class="row">
					<div class="col-sm-6 col-md-2 td text-right">
						<span>N°</span>
					</div>
					<div class="col-sm-6 col-md-8 td">
						<span>UNIDAD DID.</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-2">
				<div class="row">
					<div class="col-sm-6 col-md-9 td">
						<span>TIPO</span>
					</div>
					<div class="col-sm-6 col-md-3 td">
						<span>SEM.</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-3">
				<div class="row">
					<div class="col-sm-6 col-md-2 td">
						<span>HT</span>
					</div>
					<div class="col-sm-6 col-md-2 td">
						<span>HP</span>
					</div>
					<div class="col-sm-6 col-md-2 td">
						<span>Hrs</span>
					</div>
					
					<div class="col-sm-6 col-md-2 td">
						<span>CT</span>
					</div>
					<div class="col-sm-6 col-md-2 td">
						<span>CP</span>
					</div>
					<div class="col-sm-6 col-md-2 td">
						<span>Cdts</span>
					</div>
				</div>
			</div>
			
			<div class="col-12 col-md-3 td">
				
				<span>MÓDULO</span>
				
			</div>
			<div class="col-12 col-md-1">
				
			</div>
		</div>
	</div>
	<div class="col-md-12 tbody">
		<?php
		$nro=0;
		foreach ($unidades as $dts) {
		$nro++;
		if ($dts->unitip == 'C') {
			$nomtip = 'COMP. ESPECÍFICA';
		} else if ($dts->unitip == 'T') {
			$nomtip = 'TRANSVERSAL';
		} else {
			$nomtip = 'COMP. PARA LA EMPLEABILIDAD';
		}
		?>
		<div class="row rowcolor">
			<div class="col-12 col-md-3">
				<div class="row">
					<div class="col-sm-6 col-md-2 td text-right">
						<span><?php echo $nro ;?></span>
					</div>
					<div class="col-sm-6 col-md-10 td">
						<span><?php echo "$dts->id $dts->uninom" ?></span>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-2">
				<div class="row">
					<div class="col-sm-6 col-md-9 td">
						<span><?php echo $nomtip ;?></span>
					</div>
					<div class="col-sm-6 col-md-3 td">
						<span><?php echo $dts->cicnom ?></span>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-3 text-center">
				<div class="row">
					<div class="col-sm-6 col-md-2 td">
						<span><?php echo $dts->horter ;?></span>
					</div>
					<div class="col-sm-6 col-md-2 td">
						<span><?php echo $dts->horprac ?></span>
					</div>
					<div class="col-sm-6 col-md-2 td">
						<span class="text-primary"><?php echo $dts->horprac  + $dts->horter ?></span>
					</div>
					
					<div class="col-sm-6 col-md-2 td">
						<span><?php echo $dts->credter ;?></span>
					</div>
					<div class="col-sm-6 col-md-2 td">
						<span><?php echo $dts->credprac ?></span>
					</div>
					<div class="col-sm-6 col-md-2 td">
						<span class="text-primary"><?php echo $dts->credprac  + $dts->credter ?></span>
					</div>
				</div>
			</div>
			
			<div class="col-12 col-md-3 td">
				
				<span><?php echo "$dts->plan <br> $dts->modnom ";?></span>
				
			</div>
			<div class="col-12 col-md-1">
				<div class="row">
					<div class="col-sm-6 col-md-6 td text-center">
						<button class="btn btn-sm btn-info btn-block" href="#" onclick="viewupdaunidad('<?php echo base64url_encode($dts->id) ?>')" title="Editar unidad">
						<i class="fas fa-pencil-alt"></i> <span class="d-block d-md-none">Editar unidad</span>
						</button>
					</div>
					<div class="col-sm-6 col-md-6 td text-center">
						<a class="btn btn-sm btn-danger btn-block" href="#" data-toggle="modal" data-target="#modal_danger_unidad" data-idund="<?php echo base64url_encode($dts->id) ?>" title="Eliminar unidad">
							<i class="fas fa-trash-alt"></i> <span class="d-block d-md-none">Eliminar unidad</span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<?php } else {
	echo '<h5 class="text-danger"><i class="fa fa-ban"></i> NO SE ENCONTRARON DATOS...!</h5>';
} ?>