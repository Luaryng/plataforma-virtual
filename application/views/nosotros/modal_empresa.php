<div class="modal fade" id="modal-mision" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="divcard_mision">
            <div class="modal-header">
              	<h4 class="modal-title">Misión</h4>
              	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
              	</button>
            </div>
            <div class="modal-body">
            	<form id="frm_addMision" action="" method="post" accept-charset="utf-8">
            		<input type="hidden" name="fictxtcodigo" id="fictxtcodigo" value="<?php echo base64url_encode($mision->id) ?>">
              		<textarea name="fictxtmision" id="fictxtmision" class="form-control" rows="5"><?php echo $mision->descripcion ?></textarea>
            	</form>
            	<div class="row">
            		<div class="col-md-12" id="divmsgMision"></div>
            	</div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              	
              <button type="button" class="btn btn-primary" id="btn_addMision">Guardar</button>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-vision" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="divcard_vision">
            <div class="modal-header">
              	<h4 class="modal-title">Visión</h4>
              	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
              	</button>
            </div>
            <div class="modal-body">
            	<form id="frm_addVision" action="" method="post" accept-charset="utf-8">
            		<input type="hidden" name="fictxtcodigo" id="fictxtcodigo" value="<?php echo base64url_encode($vision->id) ?>">
              		<textarea name="fictxtvision" id="fictxtvision" class="form-control" rows="5"><?php echo $vision->descripcion ?></textarea>
            	</form>
            	<div class="row">
            		<div class="col-md-12" id="divmsgVision"></div>
            	</div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            	
             	<button type="button" class="btn btn-primary" id="btn_addVision">Guardar</button>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-organigrama" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="divcard_organi">
            <div class="modal-header">
              	<h4 class="modal-title">Organigrama</h4>
              	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
              	</button>
            </div>
            <div class="modal-body">
            	<form id="frm_addOrgani" action="<?php echo base_url() ?>nosotros/fn_insert_organigrama" method="post" accept-charset="utf-8">
            		<input type="hidden" name="fictxtcodigo" id="fictxtcodigo" value="<?php echo base64url_encode('Organigrama') ?>">
            		<div class="row mt-0">
      						<div class="col-md-12 mb-3">
      							<div class="mt-3">
      								<img class="previsualizarOrganigrama bg-light" src="<?php echo base_url() ?>resources/img/<?php echo ($organi->imagen=="") ? "Imagen_no_disponible.png" : $organi->imagen; ?>" style="width: 100%;height: 250px;">
      							</div>
      						</div>
      					</div>
                
            		<div class="row">
            			<div class="col-12 has-float-label">
            				<input type="file" name="fictxtorganigrama" id="fictxtorganigrama" class="form-control" accept="image/png, .jpeg, .jpg, image/gif">
            				<input type="hidden" name="fictxtimageexist" id="fictxtimageexist" value="<?php echo $organi->imagen ?>">
            				<label for="fictxtorganigrama">Imagen</label>
            			</div>
            		</div>
              	
            	</form>
            	<div class="row">
            		<div class="col-md-12" id="divmsgorgani"></div>
            	</div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              	
              <button type="button" class="btn btn-primary" id="btn_addOrgani">Guardar</button>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-objGeneral" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="divcard_general">
            <div class="modal-header">
              	<h4 class="modal-title">Objetivo General</h4>
              	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
              	</button>
            </div>
            <div class="modal-body">
            	<form id="frm_addObjGen" action="" method="post" accept-charset="utf-8">
            		<input type="hidden" name="fictxtcodigo" id="fictxtcodigo" value="<?php echo base64url_encode($ObjGeneral->id) ?>">
              		<textarea name="fictxtobjgen" id="fictxtobjgen" class="form-control" rows="5"><?php echo $ObjGeneral->descripcion ?></textarea>
            	</form>
            	<div class="row">
            		<div class="col-md-12" id="divmsgGeneral"></div>
            	</div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              	
              <button type="button" class="btn btn-primary" id="btn_addGeneral">Guardar</button>
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-fines" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content" id="divcard_fines">
      <div class="modal-header">
        <h4 class="modal-title">Nuestros fines</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_addFines" action="" method="post" accept-charset="utf-8">
          <input type="hidden" name="fictxtcodigo" id="fictxtcodigo" value="<?php echo base64url_encode($fines->id) ?>">
          <div id="accordion">
            <?php
              $nro = 0;
              $dtfines = json_decode($fines->descripcion, true);
              foreach ($dtfines as $key => $valor) {
                $nro ++;
                $titulo = $valor["titulo"];
                $detalle = $valor["detalle"];
                $icono = $valor["icono"];
                echo "<div class='card card-primary'>
                        <div class='card-header'>
                          <h4 class='card-title'>
                            <a data-toggle='collapse' data-parent='#accordion' href='#collapse$nro' class='collapsed' aria-expanded='false'>
                              $titulo
                            </a>
                          </h4>
                        </div>
                        <div id='collapse$nro' class='panel-collapse in collapse' titulo='$titulo' detalle='$detalle' icono='$icono'>
                          <div class='card-body'>
                            <div class='row'>
                              <div class='form-group has-float-label col-12'>
                                <input type='text' name='fictxttitulo$nro' id='fictxttitulo$nro' value='$titulo' placeholder='Titulo' class='form-control cambiaTitulo' >
                                <label for='fictxttitulo$nro'>Titulo</label>
                              </div>
                              <div class='form-group has-float-label col-12'>
                                <textarea name='fictxtdescripcion$nro' id='fictxtdescripcion$nro' class='form-control cambiaDetalle' rows='3' placeholder='Descripción' >$detalle</textarea>
                                <label for='fictxtdescripcion$nro'>Descripción</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>";
              }
            ?>
            
          </div>
          
          <input type="hidden" id="valorFines" name="valorFines" value='<?php echo $fines->descripcion ?>'>
        </form>
        <div class="row">
          <div class="col-md-12" id="divmsgFines"></div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                
        <button type="button" class="btn btn-primary" id="btn_addfines">Guardar</button>
      </div>
    </div>
  </div>
</div>

