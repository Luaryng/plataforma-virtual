<form id="frm_edit_campania" action="<?php //echo $vbaseurl ?>campania/fn_update_campania" method="post" accept-charset='utf-8'>
	<b class="text-danger"><i class="fas fa-globe"></i> Campaña</b>
	<?php foreach ($dcampania as $cmp) { ?>
		
	<div class="row mt-2">
  	<div class="form-group has-float-label col-12 col-sm-3">
  		<input type="hidden" name="ficxtidcamped" id="ficxtidcamped" value="<?php echo base64url_encode($cmp->id) ?>">
    	<select data-currentvalue='' class="form-control" id="ficperiodoed" name="ficperiodoed" placeholder="periodo" required >
      	<option value="0">Selecciona periodo</option>
    		<?php foreach ($datosp as $per) { 
    			$slt=($cmp->codperiodo == $per->codigo) ? "selected" : ""; 
    			echo "<option $slt value='$per->codigo'> $per->nombre </option>";
    		}
    		?>
    	</select>
    	<label for="ficperiodoed"> periodo</label>
    </div>
    <div class="form-group has-float-label col-12 col-sm-9">
			<input data-currentvalue='' value="<?php echo $cmp->nombre ?>" class="form-control text-uppercase" id="fitxtnomcampaniaed" name="fitxtnomcampaniaed" type="text" placeholder="Nombre Campaña" />
			<label for="fitxtnomcampaniaed">Nombre Campaña</label>
		</div>
  </div>
  <div class="row margin-top-20px">
    <div class="form-group has-float-label col-12 col-sm-12">
			<input data-currentvalue='' value="<?php echo $cmp->descripcion ?>" class="form-control text-uppercase" id="fitxtdescampaniaed" name="fitxtdescampaniaed" type="text" placeholder="Descripción Campaña" />
			<label for="fitxtdescampaniaed">Descripción Campaña</label>
		</div>
  </div>
  <div class="row margin-top-20px">
		<div class="form-group has-float-label col-6 col-sm-4">
			<input data-currentvalue='' value="<?php echo $cmp->fini ?>" type="date" class="form-control text-uppercase" id="datiniciaed" name="datiniciaed">
			<label for="datiniciaed">Fecha Inicia:</label>
		</div>
		<div class="form-group has-float-label col-6 col-sm-4">
			<input data-currentvalue='' value="<?php echo $cmp->fculm ?>" type="date" class="form-control text-uppercase" id="datculminaed" name="datculminaed">
			<label for="datculminaed">Fecha Finaliza:</label>
		</div>
    <div class="form-group has-float-label col-12 col-sm-4">
      <select name="cbosedeupd" id="cbosedeupd" class="form-control">
        <option value="">Seleccione sede</option>
        <?php
          foreach ($sedes as $sed) {
            $persel=($cmp->codsede==$sed->id)?"selected":"";
          echo "<option $persel value='$sed->id'>$sed->nombre</option>";
          }
        ?>
      </select>
      <label for="cbosedeupd">Sede</label>
    </div>
  </div>
  
  <div class="row margin-top-20px">
    <div class="col-6">
    	<div id="divmsgcamped" class="float-left">

			</div>
    </div>
	</div>
	<?php } ?>
</form>