<?php
if (isset($historial) && (count($historial)>0))
{ ?>



    <div class="col-12 thead   d-none d-md-block">
        <div class="row font-weight-bold">
            <div class='col-12 col-md-6'>
                <div class="row">
                    <div class='col-1 col-md-1 td d-none d-md-block'>N°</div>
                    <div class='col-3 col-md-3 td d-none d-md-block'>COD.PAGANTE</div>
                    <div class='col-8 col-md-8 td d-none d-md-block'>RAZON SOCIAL</div>
                </div>
            </div>
            <div class='col-12 col-md-6'>
               <div class="row">
                    <div class='col-6 col-md-10 td d-none d-md-block'> DIRECCIÓN</div>
                    <div class='col-6 col-md-2 td d-none d-md-block'>ACCIÓN</div>
               </div>
            </div>
            
        </div>
    </div>
    <div class="tbody col-12">
    <?php
        $nro = 0;
        foreach ($historial as $pag) {
            $nro ++;
            
    ?>
    	<div class="row cfila" data-codpag="<?php echo $pag->codpagante ?>" data-docum="<?php echo $pag->nrodoc ?>" data-pagante="<?php echo $pag->razonsocial ?>" data-direccion="<?php echo $pag->direccion.' - '.$pag->distrito.' - '.$pag->provincia.' - '.$pag->departamento ;?>" data-email="<?php echo $pag->correo1 ?>" data-email2="<?php echo $pag->correo2 ?>" data-ecorp="<?php echo $pag->correo_corp ?>" data-tipdoc="<?php echo $pag->tipodoc ?>">
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-1 col-md-1 td">
                        <span><?php echo $nro ;?></span>
                    </div>
                    <div class="col-4 col-md-3 td">
                        <span class=" text-bold"><?php echo $pag->codpagante ?></span>
                    </div>
                    <div class="col-7 col-md-8 td">
                        <span ><?php echo $pag->tipodoc.' :'.$pag->nrodoc ?> / </span>
                        <span class=" text-bold"><?php echo $pag->razonsocial ;?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="row">
                	<div class='col-9 col-md-10 td text-center'>
                		<span class=""><?php echo $pag->direccion.' - '.$pag->distrito.' - '.$pag->provincia.' - '.$pag->departamento ;?></span>
                	</div>
                    <div class='col-3 col-md-2 td text-center'>
                        <a href="#" onclick='fn_select_pagante($(this));return false' type="button"  title="Seleccionar">
                            <i class="fas fa-check fa-lg"></i>
                            <span class="d-block d-md-none text-white">Seleccionar </span>
                        </a>
                    </div>
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