<?php
	for ($i=1; $i <= $nrofiles; $i++) {
		$nrof = $i;
	}
?>
<div class="form-group col-lg-12">
	<div class="row">
		<div class="col-12 col-lg-5 col-md-5 col-sm-5 has-float-label mb-2">
			<input type="text" name="txttitulo<?php echo $nrof ?>" id="txttitulo<?php echo $nrof ?>" class="form-control" placeholder="titulo" >
			<label for="txttitulo<?php echo $nrof ?>">Titulo</label>
		</div>
		<div class="col-2 col-sm-2">
			<div class="form-group clearfix mt-2 text-center">
              	<div class="icheck-primary d-inline">
                	<input type="checkbox" nro="<?php echo $nrof ?>" id="checkfile<?php echo $nrof ?>" class="activefile" >
                	<label for="checkfile<?php echo $nrof ?>"></label>
              	</div>
          	</div>
		</div>
		<div class="col-10 col-lg-5 col-md-5 col-sm-5">
			<div class="form-group">
              	<div class="btn btn-info btn-file" id="divgroup<?php echo $nrof ?>">
                	<i class="fas fa-paperclip"></i> Adjuntar archivo
                	<input type="file" name="txtfile<?php echo $nrof ?>" id="txtfile<?php echo $nrof ?>" disabled="">
              	</div>
            </div>
		</div>
		
	</div>
</div>

<script type="text/javascript">
	$('.activefile').change(function(event){
		item = $(this).attr('nro');
		var habilita = $("#checkfile"+item).is(':checked');
		// $("#txttitulo"+item).prop("disabled", !habilita);
		$("#txtfile"+item).prop("disabled", !habilita);
		
	})
</script>