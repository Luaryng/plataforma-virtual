<?php
    $vbaseurl=base_url();
    $nro = 0;
    $area = base64url_encode('LR');
    foreach ($items as $bls) {
    $nro ++;
   
    $datepubl =  new DateTime($bls->creado) ;
    $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
    $vpublica= $dias[$datepubl->format('w')].". ".$datepubl->format('d/m/Y h:i a');          
    $codigo_enc=base64url_encode($bls->codigo);
    $btneditar = "";
    $btneliminar = "";
    if (getPermitido("88")=='SI'){
        $btneditar = "<a href='{$vbaseurl}portal-web/lecturas-recomendadas/editar/$area/$codigo_enc'><i class='fas fa-pen fa-2x text-primary'></i></a>";
    }
    if (getPermitido("89")=='SI'){
        $btneliminar = "<a href='#' data-area='$area' data-codigo='$codigo_enc' onclick='vw_pw_tp_lr_fn_eliminar_rg($(this));event.preventDefault();'><i class='fas fa-trash fa-2x text-danger'></i></a>";
    }
    echo 
    "<div class='row cfila'>
        <div class='col-12 col-md-4'>
            <div class='row'>
                <div class='col-2 col-md-2 td'>$nro</div>
                <div class='col-10 col-md-10 td'>
                    <a target='_blank' href='{$vbaseurl}portal-web/lecturas/archivos/$area/$codigo_enc'>
                       $bls->titulo
                    </a> <br>
                    <small><i class='far fa-calendar-alt'></i> $vpublica</small> <br>
                </div>
            </div>
        </div>
        <div class='col-sm-4 col-md-5 td'>
                    <span>$bls->nomcategoria</span>
                </div>
        <div class='col-12 col-md-3 text-center'>
            <div class='row'>
                <div class='col-sm-4 col-md-4 td'>
                    <span>$bls->orden</span>
                </div>
                
                <div class='col-sm-4 col-md-4 td'>
                    $btneditar
                </div>
                
                <div class='col-sm-4 col-md-4 td'>
                    $btneliminar
                </div>

            </div>
        </div>
    </div>";
    }
    ?>