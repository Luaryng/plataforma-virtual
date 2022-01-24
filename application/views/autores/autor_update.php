<form id="frm_autores_edit" action="<?php //echo $vbaseurl ?>autor/fn_insert_autor" method="post" accept-charset='utf-8'>
	<b class="margin-top-10px text-danger"><i class="fas fa-book"></i> Autor</b>
	<?php foreach ($dautores as $atr) { ?>
	<div class="row mt-2">
		<div class="form-group has-float-label col-12 col-sm-12">
			<input type="hidden" name="fictxtaccion" id="fictxtaccion" value="EDITAR">
			<input type="hidden" name="fictxtcodaut" id="fictxtcodaut" value="<?php echo base64url_encode($atr->id) ?>">
			<input data-currentvalue='' value="<?php echo $atr->nombre ?>" class="form-control text-uppercase" id="fictxtnomaut" name="fictxtnomaut" type="text" placeholder="Nombre Autor" />
			<label for="fictxtnomaut">Nombre Autor</label>
		</div>
	</div>
	<div class="row mt-1">
    	<div class="col-6">
    		<div id="divmsgautores" class="float-left">
				
			</div>
		</div>
	</div>
<?php } ?>
</form>