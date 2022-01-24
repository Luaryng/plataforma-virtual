<div id="divtabl-seguimiento" class="col-12 col-md-12 btable">
	<div class="col-md-12 thead d-none d-md-block">
    	<div class="row ">
      		<div class="col-12 col-md-6 ">
        		<div class="row">
		          	<div class="col-4 col-md-1 td">
		            	<span>N°</span>
		          	</div>
		          	<div class="col-4 col-md-5 td">
		            	<span>FECHA</span>
		          	</div>
		          	<div class="col-4 col-md-6 td">
		            	<span>HORA</span>
		          	</div>
		        </div>
      		</div>
      		<div class="col-12 col-md-6 ">
        		<div class="row">
		          	<div class="col-8 col-md-8 td">
		            	<span>ESTADO</span>
		          	</div>
        
          			<div class="col-4 col-md-4 td">
            			<span></span>
          			</div>
          			       
        		</div>
      		</div>
    	</div>
  	</div>

  	<div class="col-md-12 tbody tb_seguim" style="max-height: 17vh;overflow-y: scroll; overflow-x: hidden;">
  		<?php
  			$nro = 0;
    		foreach ($seguimiento as $value) {
      			$nro++;
      	?>
      	<div  class="row rowcolor">
      		<div class="col-12 col-md-6 ">
        		<div class="row">
        			<div class="col-4 col-md-1 td">
		            	<span><?php echo $nro ;?></span>
		          	</div>
		          	<div class="col-4 col-md-5 td">
		            	<span><i class='far fa-calendar-alt'></i> <?php echo date("d/m/Y", strtotime($value->fecha)) ?></span>
		          	</div>
		          	<div class="col-4 col-md-6 td">
		            	<span><i class='far fa-clock'></i> <?php echo date("h:i a", strtotime($value->hora)) ?></span>
		          	</div>
        		</div>
        	</div>
        	<div class="col-12 col-md-6 ">
        		<div class="row">
        			<div class="col-8 col-md-8 td">
		            	<span><?php echo $value->estado ;?></span>
		          	</div>
		          	<div class="col-4 col-md-4 td text-center">
		            	<button type="button" class="btn btn-info btn-sm btn_verseg" data-estado="<?php echo $value->estado ?>" data-obser="<?php echo $value->observacion ?>" data-fecha="<?php echo $value->fecha ?>" data-hora="<?php echo $value->hora ?>">
		            		<i class="fa fa-eye"></i> Ver
		            	</button>
		          	</div>
        		</div>
        	</div>
      	</div>
      	<?php
      		}
  		?>
  	</div>
</div>

<script type="text/javascript">
	$('.btn_verseg').click(function() {
		var estado = $(this).data('estado');
		var observ = $(this).data('obser');
		var fecha = $(this).data('fecha');
		var hora = $(this).data('hora');

		$('#cboficestado').val(estado);
		$('#fictxtobserv').val(observ);
		$('#fictxtfecha').val(fecha);
		$('#fictxthora').val(hora);

		$('#frm_add_seguim').removeClass('d-none');
		$('#btn_addseguim').addClass('d-none');
		$('#btn_newseg').removeClass('d-none');
	});

</script>