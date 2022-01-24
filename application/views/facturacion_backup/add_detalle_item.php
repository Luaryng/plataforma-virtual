<?php
	$vbaseurl=base_url();
	for ($i=1; $i <= $nro; $i++) {
		$nmro = $i;
	}
?>
<div class="row cfila">
    <span type="text" name="" id="fictxtnro" class="form-control form-control-sm text-sm col-1"><?php echo $nmro ?></span>
    <input type="text" name="fictxtcodigo<?php echo $nmro ?>" id="fictxtcodigo<?php echo $nmro ?>" class="form-control form-control-sm text-sm col-1" value="<?php echo $codigo ?>">
    <input type="text" name="fictxtcantidad<?php echo $nmro ?>" id="fictxtcantidad<?php echo $nmro ?>" class="form-control form-control-sm text-sm col-1" value="1">
    <input type="text" name="fictxtunidad<?php echo $nmro ?>" id="fictxtunidad<?php echo $nmro ?>" class="form-control form-control-sm text-sm col-1" value="<?php echo $unidad ?>">
    <input type="text" name="fictxtdescrip<?php echo $nmro ?>" id="fictxtdescrip<?php echo $nmro ?>" class="form-control form-control-sm text-sm col-4" value="<?php echo $detalle ?>">
    <input type="number" name="fictxtvalor<?php echo $nmro ?>" id="fictxtvalor<?php echo $nmro ?>" class="form-control form-control-sm text-sm col-2 importe" value="<?php echo $valor ?>">
    <span class="col-2">
        <button class="remove_detitem<?php echo $nmro ?> btn btn-outline-danger btn-circle" type="button" onclick="removeitem($(this));" disabled="">
            <i class="fas fa-minus"></i>
        </button>
        
    </span>
</div>

<script type="text/javascript">
	$("#divdata_detalle input").keyup(function() {
	    var form = $(this).parents("#divdata_detalle");
	    var check = checkCampos(form);
	    if(check) {
	        $(".add_detitem").attr('disabled', false);
	        $(".remove_detitem"+cnt).attr('disabled', true);
	    }
	    else {
	        $(".add_detitem").attr('disabled', true);
	        $(".remove_detitem"+cnt).attr('disabled', false);
	    }
	});
</script>