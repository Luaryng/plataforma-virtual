<?php
if (isset($items) && (count($items)>0))
{ ?>
<div class="neo-table">
    <div class="header col-12  d-none d-md-block">
        <div class="row font-weight-bold">
            <div class='col-12 col-md-6 group'>
                <div class='col-1 col-md-1 cell d-none d-md-block'>N°</div>
                <div class='col-2 col-md-3 cell d-none d-md-block'>CODIGO</div>
                <div class='col-4 col-md-8 cell d-none d-md-block'>NOMBRE</div>
                
            </div>
            <div class='col-12 col-md-6 group'>
                <div class='col-4 col-md-4 cell d-none d-md-block'>UND</div>
                <div class='col-4 col-md-4 cell d-none d-md-block'>VALOR</div>
                <div class='col-2 col-md-4 cell d-none d-md-block'>
                    ACCIÓN
                </div>
            </div>
            
        </div>
    </div>
    <div class="body col-12">
    <?php
        $nro = 0;
        foreach ($items as $gst) {
            $nro ++;
            
    ?>
    	<div class="row cfila <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>" data-codigo="<?php echo $gst->codigo ?>" data-detalle="<?php echo $gst->nombre ?>" data-unidad="" data-valor="">
            <div class="col-12 col-md-6 group">
                <div class="col-1 col-md-1 cell">
                    <span><?php echo $nro ;?></span>
                </div>
                <div class="col-3 col-md-3 cell">
                    <span class="nametipo"><?php echo $gst->codigo ?></span>
                </div>
                <div class="col-8 col-md-8 cell">
                    <span class="nametipo"><?php echo $gst->nombre ;?></span>
                </div>
            </div>
            <div class="col-12 col-md-6 group">
                <div class="col-4 col-md-4 cell">
                    <input type="text" name="ficitemund" id="ficitemund" class="form-control form-control-sm text-sm unidad">
                </div>
                <div class="col-4 col-md-4 cell">
                    <input type="number" name="ficitemvalor" id="ficitemvalor" class="form-control form-control-sm text-sm valor">
                </div>
                <div class='col-4 col-md-4 cell text-center'>
                    <a type="button" class='btn btn-info btn-sm px-3 add_itemdeta' title="agregar">
                        <i class='fas fa-plus text-white'></i>
                        <span class="d-block d-md-none text-white">Agregar </span>
                    </a>
                </div>
            </div>
            
            
        </div>
    <?php    
        }
    ?>
    </div>
</div>



<?php
}
else
{
  echo "<h4 class='px-2'>No hay datos para mostrar</h4>";
}
?>