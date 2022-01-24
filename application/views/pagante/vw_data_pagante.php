<?php
if (isset($historial) && (count($historial)>0))
{ ?>
<div class="neo-table">
    <div class="header col-12  d-none d-md-block">
        <div class="row font-weight-bold">
            <div class='col-12 col-md-6 group'>
                <div class='col-1 col-md-1 cell d-none d-md-block'>N°</div>
                <div class='col-3 col-md-3 cell d-none d-md-block'>TIPO/NRO</div>
                <div class='col-8 col-md-8 cell d-none d-md-block'>RAZON SOCIAL</div>
            </div>
            
            <div class='col-12 col-md-4 group'>
                <div class='col-6 col-md-6 cell d-none d-md-block'>
                	DIRECCIÓN
                </div>
                <div class='col-6 col-md-6 cell d-none d-md-block'>
                    TELÉFONO
                </div>
            </div>
            <div class='col-12 col-md-2 group'>
                <div class='col-12 col-md-12 cell text-center d-none d-md-block'>
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
    	<div class="row cfila <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>" data-cliente="<?php echo $pag->razonsocial ?>">
            <div class="col-12 col-md-6 group">
                <div class="col-1 col-md-1 cell">
                    <span><?php echo $nro ;?></span>
                </div>
                <div class="col-3 col-md-3 cell">
                    <span class="nametipo"><?php echo $pag->codpagante ?></span><br>
                    <span class="small">(<?php echo $pag->tipo ?>)</span>
                </div>
                <div class="col-8 col-md-8 cell">
                    <span class="nametipo"><?php echo $pag->razonsocial ;?></span><br>
                    <span class="small"><?php echo $pag->tipodoc.' :'.$pag->nrodoc.' - ('.$pag->personeria.')' ?></span>
                </div>
            </div>
            <div class="col-12 col-md-4 group">
            	<div class='col-6 col-md-6 cell text-center'>
            		<span class="nametipo"><i class="fas fa-map-marker-alt text-danger"></i> <?php echo $pag->direccion ;?></span><br>
                    <span class="small">(<?php echo $pag->distrito ;?>)</span>
            	</div>
                <div class='col-6 col-md-6 cell text-center'>
                    <span class="nametipo"><?php echo $pag->telefono ;?></span><?php echo ($pag->telefono != "") ? '<br>' : ''; ?>
                    <span class="small"><?php echo ($pag->celular !="") ? '('.$pag->celular.')' : "" ;?></span>
                </div>
                
            </div>
            <div class="col-12 col-md-2 group">
            	<div class='col-12 col-md-12 cell text-center'>
                    <div class='btn-group'>
                        <a type='button' class='text-white bg-success dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <i class='fas fa-cog'></i> Acciones
                        </a>
                        <div class='dropdown-menu dropdown-menu-right'>
                            <a type="button" onclick="viewupdpagante('<?php echo base64url_encode($pag->id) ?>')" class='dropdown-item btn btn-info btn-sm px-3' id="<?php echo $pag->id ?>" title="Editar">
                                <i class='fas fa-pencil-alt mr-1'></i> Editar
                            </a>
                            <a type="button" class='dropdown-item btn btn-info btn-sm px-3 text-danger deletepgt' data-id="<?php echo base64url_encode($pag->id) ?>" title="Eliminar">
                                <i class='fas fa-trash mr-1'></i> Eliminar
                            </a>
                        </div>
                    </div>
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