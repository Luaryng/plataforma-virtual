<div id="card-modal-plan" class="card card-primary card-outline">
<div id="divtabl-modalcursos" class="col-12 col-md-12 neo-table">
	<div class="col-md-12 header d-none d-md-block">
		<div class="row">
			
			<div class="col-1 col-md-1 cell hidden-xs">
				NRO
			</div>
			<div class="col-12 col-md-8 cell">
				CURSO
			</div>
			<div class="col-2 col-md-1 cell text-center">
				CIC
			</div>
			<div class="col-2 col-md-2 cell text-center">
				CHK
			</div>
		</div>
	</div>
	<div class="col-md-12 body">
		<?php
		$nro=0;
		$mod="";
		foreach ($unds as $key => $und) {
				$fn="";
				$nro++;
				$vcarga="0";
				$vactivar="";
				foreach ($cargas as $carga) {
					if ($und->codunidad==$carga->codunidad){
						if (($und->codunidad==$carga->codunidad) && ($carga->activo=='SI') )
						$vactivar="checked";
						
						$vcarga=$carga->codcarga;
					} 
				}
				if ($mod!=$und->codmodulo){
					$mod=$und->codmodulo;
					echo "<div class='row bg-lightgray'>
					<div class='col-12 cell'>
					<i class='fas fa-book-open mr-2'></i>Módulo: <b>$und->modulo</b>
					</div>
					</div>";
				}
		?>
		<div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
			<div class="col-12 col-md-9 group">
				<div class="col-6 col-md-1 cell">
					<span><?php echo $nro ;?></span>
				</div>
				<div class="col-12 col-md-11 cell">
					<span><?php echo $und->unidaddid ?></span>
				</div>
			</div>
			<div class="col-12 col-md-1 cell">
					<span><?php echo $und->codciclo ?></span>
				</div>
			<!---->
			<div class="col-2 col-md-2 cell">
				<input <?php echo $vactivar ?> class="fca-checkcursoc" data-codcarga='<?php echo $vcarga ?>' data-codunidad='<?php echo $und->codunidad ?>' data-size="xs" type="checkbox" data-toggle="toggle" 
						data-on="<i class='fa fa-check'></i>" data-off="<i class='fas fa-arrow-alt-circle-right'></i>" 
						data-onstyle="success" data-offstyle="danger">
			</div>
		</div>
		<?php } ?>
	</div>
</div>
</div>
<script>
	$('.fca-checkcursoc').bootstrapToggle();

  $("#md-plan").on('hidden.bs.modal', function(){
    $("#fca-checkgrupo").change();
  });
	$(".fca-checkcursoc").change(function(event) {
		
		if ($(this).prop('checked')==true){
			
			$("#divcard_grupo select").prop('disabled', false);
			$('#card-modal-plan').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			
			var vund=$(this).data('codunidad');
			var codcarga=$(this).data('codcarga');
			var fn="fn_activar";
			var fdata=new Array();
			if (codcarga=="0") {
				fn="fn_insert";
				fdata=$("#frm-grupo").serializeArray();
				fdata.push({name: 'fca-txtunidad', value: vund});
			}
			else{
				fdata.push({name: 'fca-txtcarga', value: codcarga});
				fdata.push({name: 'fca-txtactivar', value: 'SI'});
			}
			
			$.ajax({
		            url: base_url + 'cargaacademica/' + fn,
		            type: 'post',
		            dataType: 'json',
		            data: fdata,
		            success: function(e) {
		            	$("#divcard_grupo select").prop('disabled', true);
		            	$('#card-modal-plan #divoverlay').remove();
		            	if (e.status==true){
		            		$(this).data('codcarga', e.newcod);
		            	}
		            	else{
		            		$(this).bootstrapToggle('off');
		            		Toast.fire({
						      type: 'danger',
						      title: 'Error: ' + e.msg
						    });
		            	}
		            },
		            error: function(jqXHR, exception) {
		            	$(this).bootstrapToggle('off');
		            	$("#divcard_grupo select").prop('disabled', true);
		            	$('#card-modal-plan #divoverlay').remove();
		                var msgf = errorAjax(jqXHR, exception, 'text');
		                $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
		            }
	        });
		}
		else{
			$("#divcard_grupo select").prop('disabled', false);
			$('#card-modal-plan').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			var codcarga=$(this).data('codcarga');
			$.ajax({
	            url: base_url + 'cargaacademica/fn_activar',
	            type: 'post',
	            dataType: 'json',
	            data: {"fca-txtcarga":codcarga,"fca-txtactivar":'NO'},
	            success: function(e) {
	            	$("#divcard_grupo select").prop('disabled', true);
	            	$('#card-modal-plan #divoverlay').remove();
	            	if (e.status==true){
	            		
	            	}
	            	else{
	            		$(this).bootstrapToggle('on');
	            		Toast.fire({
					      type: 'danger',
					      title: 'Error: ' + e.msg
					    });

	            	}
	            },
	            error: function(jqXHR, exception) {
	            	$(this).bootstrapToggle('off');
	            	$("#divcard_grupo select").prop('disabled', true);
	            	$('#card-modal-plan #divoverlay').remove();
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
	            }
	        });
		}	
	});

</script>