<?php
    $nro = 0;
    foreach ($items as $docp) {
    $nro ++;
    $estado_color="text-primary";
    switch ($docp->estado) {
        case 'VENCIDO':
            $estado_color="text-danger";
            break;
        case 'PAGADO':
            $estado_color="text-success";
            break;
        case 'PENDIENTE':
            $estado_color="text-info";
            break;
        case 'ANULADO':
            $estado_color="text-warning";
            break;
    }
    $vbaseurl=base_url();
    $datepubl =  new DateTime($docp->creado) ;
    $datemis =  new DateTime($docp->emision) ;
    $datvence =  new DateTime($docp->vence) ;
    $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
    $vpublica= $dias[$datepubl->format('w')].". ".$datepubl->format('d/m/Y h:i a');
    $emision = $datemis->format('d/m/Y');  
    $fvence = $datvence->format('d/m/Y');          
    $codigo_enc=base64url_encode($docp->codigo);
    $btneditar = "";
    $btndelete = "";
    $vdescargar=($docp->ruta=="")?"":"<a target='_blank' href='{$vbaseurl}documentos/pagos/archivos/$codigo_enc' title='Descargar'>
                                            <img class='mr-1' src='".base_url()."resources/img/icons/p_pdf.png' alt='PDF'> PDF
                                        </a>";
    if ($_SESSION['userActivo']->codnivel=="0") {
        $btneditar = "<a class='dropdown-item' href='{$vbaseurl}documentos/pagos/editar/$codigo_enc' title='Editar'>
                        <i class='fas fa-edit mr-3'></i> Editar
                    </a>";

        $btndelete = "<a class='dropdown-item text-danger' href='#' data-codigo='$codigo_enc' onclick='vw_pw_tp_pr_fn_delete_doc($(this));event.preventDefault();' title='Eliminar'>
                        <i class='fas fa-trash mr-3'></i> Eliminar
                    </a>";
        
    }
    echo 
    "<div class='row rowcolor cfila'>
                            <div class='col-12 col-md-6'>
                                <div class='row'>
                                    <div class='col-1 col-md-1 td'>$nro</div>
                                    <div class='col-3 col-md-2 td'>$emision</div>
                                    <div class='col-8 col-md-9 td'>
                                        
                                           $docp->titulo<br>
                                       
                                        <small><i class='far fa-calendar-alt'></i> $vpublica</small> 
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class='col-12 col-md-6 text-center'>
                                <div class='row'>
                                    <div class='col-sm-2 col-md-2 td'>
                                        <span>S/. $docp->importe</span>
                                    </div>
                                     <div class='col-sm-2 col-md-2 td'>
                                        <span>$fvence</span>
                                    </div>

                                    
                                    <div class='col-sm-3 col-md-3 td $estado_color'>
                                       $docp->estado
                                    </div>
                                    <div class='col-sm-2 col-md-2 td text-danger'>
                                       $vdescargar
                                    </div>
                                    <div class='col-sm-3 col-md-3 td'>

                                        <div class='col-12 pt-1 pr-3 text-center'>
                                    
                                            <div class='btn-group'>
                                                <a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    Acciones
                                                    <i class='fas fa-cog'></i>
                                                </a>
                                                <div class='dropdown-menu dropdown-menu-right'>
                                                    $btneditar
                                                    $btndelete
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>";
    }
?>