<?php $meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"); ?>
<div id="divtabl-notic" class="col-xs-12 col-md-12 neo-table">
	<div class="col-md-12 header d-none d-md-block">
		<div class="row">
	      	<div class="col-sm-1 col-md-1 cell hidden-xs"><b>N°</b></div>
	      	<div class="col-sm-2 col-md-2 cell"><b>Titulo</b></div>
	      	<div class="col-sm-2 col-md-3 cell"><b>Detalle</b></div>
	      	<div class="col-sm-2 col-md-2 cell"><b>Fecha</b></div>
	      	<div class="col-sm-2 col-md-1 cell"><b>Hora</b></div>
	      	<div class="col-sm-2 col-md-1 cell"><b>Portada</b></div>
	      	<div class="col-sm-1 col-md-1 cell text-center"></div>
	      	<div class="col-sm-1 col-md-1 cell text-center"></div>
	    </div>
	</div>
	<div class="col-md-12 body">
		<?php
		$nro = 0;
		foreach ($noticias as $nts) {
			$fecha_pnot = DateTime::createFromFormat('Y-m-d', $nts->fecha);
			$nro ++;
		?>
		<div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
			<div class="col-sm-12 col-md-3 group">
	        	<div class="col-sm-6 col-md-4 cell">
	          		<span><?php echo $nro ;?></span>
	        	</div>
		        <div class="col-sm-6 col-md-8 cell">
		          	<span><?php echo $nts->titulo ?></span>
		        </div>
	      	</div>
	      	<div class="col-sm-12 col-md-5 group">
	      		<div class="col-sm-6 col-md-7 cell">
	      			<span>
					<?php echo $nts->resumen ?>
	      			</span>
	      		</div>
	      		<div class="col-sm-6 col-md-5 cell">
	      			<span><?php echo date($fecha_pnot->format('d')).", ".$meses[date($fecha_pnot->format('n'))-1]. " ".date($fecha_pnot->format('Y'))?></span>
	      		</div>
	      	</div>
	      	<div class="col-sm-12 col-md-2 group">
	      		<div class="col-sm-6 col-md-6 cell">
	      			<span><?php ini_set('date.timezone','America/Lima'); echo date('h:i A', strtotime($nts->hora));?></span>
	      		</div>
	      		<div class="col-sm-6 col-md-6 cell">
	      			<span><img style="width: 100%;height: 50px" src="<?php echo base_url();?>resources/img/noticias/<?php echo $nts->imgp;?>"></span>
	      		</div>
	      	</div>
	      	<div class="col-sm-12 col-md-2 group">
	      		<div class="col-sm-6 col-md-6 cell">
	      			<a href="<?php echo base_url(); ?>portal-web/noticias/editar?idnot=<?php echo base64url_encode($nts->id) ?>" class="btn btn-sm btn-info btn-block" title="Editar Noticia">
	      				<i class="fas fa-pencil-alt"></i> <span class="d-block d-md-none">Editar </span>
	      			</a>
	      		</div>
	      		<div class="col-sm-6 col-md-6 cell">
	      			<a href="#" data-idnot="<?php echo base64url_encode($nts->id) ?>" data-toggle="modal" data-target="#modeletenot" class="btn btn-sm btn-block btn-danger" title="Eliminar Noticia">
	      				<i class="fas fa-trash-alt"></i> <span class="d-block d-md-none">Eliminar</span>
	      			</a>
	      		</div>
	      	</div>
		</div>
	<?php } ?>
	</div>
</div>