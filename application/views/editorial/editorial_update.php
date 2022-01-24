<?php 
	$vbaseurl=base_url();
?>
<form id="frm_editorial_edit" action="<?php //echo $vbaseurl ?>editorial/fn_insert_editorial" method="post" accept-charset='utf-8'>
	<b class="margin-top-10px text-danger"><i class="fas fa-book"></i> Editorial</b>
	<?php foreach ($deditorial as $edt) { ?>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-12">
			<input type="hidden" name="fictxtaccion" id="fictxtaccion" value="EDITAR">
			<input type="hidden" name="fictxtcodedit" id="fictxtcodedit" value="<?php echo base64url_encode($edt->id) ?>">
			<input data-currentvalue='' value="<?php echo $edt->nombre ?>" class="form-control text-uppercase" id="fictxtnomedit" name="fictxtnomedit" type="text" placeholder="Nombre Editorial" />
			<label for="fictxtnomedit">Nombre Editorial</label>
		</div>
	</div>
	<div class="row mt-1">
    	<div class="col-6">
    		<div id="divmsgeditorialed" class="float-left">
				
			</div>
		</div>
	</div>
<?php } ?>
</form>