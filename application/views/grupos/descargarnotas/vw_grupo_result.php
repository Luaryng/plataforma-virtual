<div class="btable">
    <div class="thead col-12  d-none d-md-block">
      	<div class="row">
	        <div class="col-md-6">
	          	<div class="row">
	            	<div class="col-md-2 td">NRO</div>
	            	<div class="col-md-10 td">UNIDAD DID.</div>
	          	</div>
	        </div>
	        <div class="col-md-1 td">CIC</div>
	        <div class="col-md-2 td">HORAS</div>
	        <div class="col-md-1 td">HOR/CIC</div>
	        <div class="col-md-2 td">CRED.</div>
	        <!-- <div class="col-md-2 td"></div> -->
      	</div>
    </div>
    <div id="div-filtro" class="tbody col-12">
    	<?php
		$nro=0;
		$mod="";
		foreach ($cargas as $key => $carga) {
			if ($carga->activo=='SI'){
				$nro++;
		?>
        <div data-idm="<?php echo $carga->codcarga ?>" class="cfila row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?> pt-1">
        	<div class="col-12 col-md-6">
        		<div class="row">
        			<div class="col-2 col-md-2 td"><?php echo $nro ?></div>
        			<div class="col-10 col-md-10 td text-bold"><?php echo $carga->unidad ?></div>
        		</div>
        	</div>
        	<div class="col-3 col-md-1 td"><b>Cic: </b><?php echo $carga->codciclo ?></div>
        	<div class="col-3 col-md-2 td">
        		<b>Hrs: </b><?php echo  ($carga->hst + $carga->hsp ) ?>
        		<small><?php echo" (T: $carga->hst  / P:  $carga->hsp)"?></small> 
			</div>
        	<div class="col-3 col-md-1 td"><?php echo $carga->hc ?></div>
        	<div class="col-3 col-md-2 td">
        		<b>Crd: </b><?php echo  ($carga->ct + $carga->cp )?> 
				<small><?php echo"  ( T: $carga->ct  / P:  $carga->cp)"?></small>
        	</div>
        	
        </div>
        <?php 
			foreach ($divisiones as $key => $divi) {
				if ($carga->codcarga==$divi->codcarga){
					$codcarga = base64url_encode($divi->codcarga);
					$coddivision = base64url_encode($divi->division);
		?>
		<div class="fdivision row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
			<div class="col-2 col-md-3 td"><b>Grupo</b> <?php echo $divi->division ;?></div>
			<div class="col-4 col-md-5 td">
				<b>DOCENTE:</b> <?php echo (is_null($divi->coddocente)) ?"SIN DOCENTE":"$divi->paterno $divi->materno $divi->nombres" ?>
			</div>
			<div class="col-3 col-md-2 td"><b>Alum:</b> <?php echo $divi->nalum ;?></div>
			<div class="col-3 col-md-2 td">
        		<a href="#" id="btn_search_alumnos" onclick="fn_search_alumnos('<?php echo $codcarga ?>','<?php echo $coddivision ?>')">
        			<i class="fas fa-user-friends ml-2"></i> ver notas
        		</a>
        	</div>
		</div>
		<?php
				}
			}
		?>
    <?php }} ?>
    </div>
</div>
