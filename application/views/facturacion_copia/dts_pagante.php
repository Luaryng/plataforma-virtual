<?php
if (isset($historial) && (count($historial)>0))
{ ?>
<div class="neo-table">
    <div class="header col-12  d-none d-md-block">
        <div class="row font-weight-bold">
            <div class='col-12 col-md-6 group'>
                <div class='col-1 col-md-1 cell d-none d-md-block'>N°</div>
                <div class='col-3 col-md-4 cell d-none d-md-block'>COD.PAGANTE</div>
                <div class='col-8 col-md-7 cell d-none d-md-block'>RAZON SOCIAL</div>
            </div>
            
            <div class='col-12 col-md-6 group'>
                <div class='col-6 col-md-10 cell d-none d-md-block'>
                	DIRECCIÓN
                </div>
                <div class='col-6 col-md-2 cell d-none d-md-block'>
                    ACCIÓN
                </div>
            </div>
            
        </div>
    </div>
    <div class="body col-12">
    <?php
        $nro = 0;
        foreach ($historial as $pag) {
            $nro ++;
            
    ?>
    	<div class="row rowcolor" data-codpag="<?php echo $pag->codpagante ?>" data-docum="<?php echo $pag->nrodoc ?>" data-pagante="<?php echo $pag->razonsocial ?>" data-direccion="<?php echo $pag->direccion.' - '.$pag->distrito.' - '.$pag->provincia.' - '.$pag->departamento ;?>" data-email="<?php echo $pag->correo1 ?>" data-email2="<?php echo $pag->correo2 ?>" data-ecorp="<?php echo $pag->correo_corp ?>" data-tipdoc="<?php echo $pag->tipodoc ?>">
            <div class="col-12 col-md-6 group">
                <div class="col-1 col-md-1 cell">
                    <span><?php echo $nro ;?></span>
                </div>
                <div class="col-4 col-md-4 cell">
                    <span class="nametipo"><?php echo $pag->codpagante ?></span>
                </div>
                <div class="col-7 col-md-7 cell">
                    <span class="nametipo"><?php echo $pag->razonsocial ;?></span><br>
                    <span class="small"><?php echo $pag->tipodoc.' :'.$pag->nrodoc ?></span>
                </div>
            </div>
            <div class="col-12 col-md-6 group">
            	<div class='col-9 col-md-10 cell text-center'>
            		<span class="nametipo"><?php echo $pag->direccion.' - '.$pag->distrito.' - '.$pag->provincia.' - '.$pag->departamento ;?></span>
            	</div>
                <div class='col-3 col-md-2 cell text-center'>
                    <a onclick='fn_select_pagante($(this));return false' type="button" class='btn btn-info btn-sm px-3 add_pagantefrm' title="agregar">
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

<script type="text/javascript">

</script>

<?php
}
else
{
  echo "<h4 class='px-2'>No hay datos para mostrar</h4>";
}
?>