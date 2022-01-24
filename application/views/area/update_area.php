<?php
    $vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<form id="frm_updatearea" action="<?php echo $vbaseurl ?>area/fn_insert_update" method="post" accept-charset="utf-8">
    
    <div class="row">
        <div class="form-group has-float-label col-8">
            <input type="hidden" id="fictxtaccion" name="fictxtaccion" value="EDITAR">
            <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="<?php echo base64url_encode($darea->codigo) ?>">
            <input type="text" name="fictxtnombre" id="fictxtnombre" value="<?php echo $darea->nombre ?>" placeholder="Nombre Área" class="form-control">
            <label for="fictxtnombre">Nombre Área</label>
        </div>
        <div class="form-group col-md-4">
            <label for="checkestado">Activo:</label>
            <input  id="checkestado" <?php echo ($darea->estado=="SI")?"checked":"" ?> name="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
        </div>
    </div> 
    <div class="row">
        <div class="form-group has-float-label col-12">
            <select name="fictxtencarg" id="fictxtencarg" class="form-control">
                <option value="">Seleccione item</option>
                <?php
                    foreach ($docentes as $key => $value) {
                        $activ = ($darea->encargado == $value->coddocente) ? "selected" : "";
                        echo "<option $activ value='$value->coddocente'>$value->nombres</option>";
                    }
                ?>
            </select>
            <label for="fictxtencarg">Encargado</label>
        </div>
    </div> 
    <div class="row">
        <div class="form-group has-float-label col-12">
            <input type="text" name="fictxtemail" id="fictxtemail" value="<?php echo $darea->correo ?>" placeholder="Email" class="form-control">
            <label for="fictxtemail">Email</label>
        </div>
    </div> 
    
</form>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>