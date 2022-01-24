<?php
    $nro = 0;
    foreach ($items as $docp) {
    $nro ++;
    $estado_color="text-warning";
    $icon_sunat="<i class='fas fa-check-circle'></i>";
    $s_msj=$docp->s_descripcion;
    switch ($docp->estado) {
        case 'ACEPTADO':
            $icon_sunat="<i class='fas fa-check-circle fa-lg'></i>";
            $estado_color="text-success";
            break;
        case 'ANULADO':
            $s_msj="$docp->anul_fecha: $docp->anul_motivo";
            $icon_sunat="<i class='fas fa-times fa-lg'></i>";
            $estado_color="text-danger";
            break;
        case 'ENVIADO':
            $icon_sunat="<i class='fas fa-check-circle fa-lg'></i>";
            $estado_color="text-primary";
            break;
        case 'RECHAZADO':
            $icon_sunat="<i class='fas fa-exclamation-circle fa-lg'></i>";
            $estado_color="text-danger";
            break;
        case 'ERROR':
            $s_msj="$docp->error_cod - $docp->error_desc";
            $icon_sunat="<i class='fas fa-ban fa-lg'></i>";
            $estado_color="text-danger";
            break;
    }

    $vbaseurl=base_url();
    
    $datemis =  new DateTime($docp->fecha_hora) ;
    
    $emision = $datemis->format('d/m/Y h:i a');  
            
    $codigo_enc=base64url_encode($docp->codigo);
    $btneditar = "";
    $btndelete = "";
    
    $btnprint="";
    $btnpdf="";
    $btnmail="";
    $btnanular="";
    $btnaddcobros = "";
    if (getPermitido("97") == "SI") {

        
        $btnmail = "<a class='dropdown-item' href='#' title='Editar' data-toggle='modal' data-target='#modenviarmail' data-codigo='$codigo_enc'>
                        <i class='far fa-file-alt mr-1'></i> Enviar a email
                    </a>";
        $btnprint = "<a target='_blank' class='dropdown-item' href='{$vbaseurl}tesoreria/facturacion/generar/rpgrafica/$codigo_enc' title='Imprimir'>
                        <i class='far fa-file-alt mr-1'></i> Impresión
                    </a>";
        $btnpdf = "<a target='_blank' class='dropdown-item' href='{$vbaseurl}tesoreria/facturacion/generar/pdf/$codigo_enc' title='PDF'>
                       <i class='far fa-file-pdf mr-1'></i> PDF
                    </a>";
        /*$btnpdf = "<a target='_blank' class='dropdown-item' href='$docp->enl_pdf' title='PDF'>
                       <i class='far fa-file-pdf mr-1'></i> PDF
                    </a>";    */
        $btnaddcobros = "<a data-codigo='$codigo_enc' class='dropdown-item text-success' href='#' title='Cobros' data-toggle='modal' data-target='#modaddcobros' data-pgmonto='$docp->total'>
                        <i class='far fa-credit-card mr-1'></i> Cobros
                    </a>";
        //$btndelete = "<a class='dropdown-item text-danger' href='#' data-codigo='$codigo_enc' onclick='vw_pw_tp_pr_fn_delete_doc($(this));event.preventDefault();' title='Eliminar'>
                        //<i class='far fa-file-pdf mr-1'></i> PDF
                    //</a>";
        
    }

    if (getPermitido("102") == "SI") {

        $btnanular = "<a data-codigo='$codigo_enc' class='dropdown-item text-danger' href='#' title='Editar' data-toggle='modal' data-target='#modanuladoc'>
                        <i class='far fa-file-alt mr-1'></i> Anular o Comunicar Baja
                    </a>";
    }
    echo 
    "<div class='row rowcolor cfila'>
                            <div class='col-12 col-md-4 border'>
                                <div class='row'>
                                    <div class='col-2 col-md-2 text-right td'>{$nro}. $docp->tipodoc</div>
                                    <div class='col-3 col-md-3 td'>{$docp->serie}-{$docp->numero} </div>
                                    <div class='col-5 col-md-5 td'>$emision</div>
                                    <div class='col-2 col-md-2 td text-center '>
                                        <a class='vw_btn_msjsunat $estado_color' tabindex='0' role='button' data-toggle='popover' data-trigger='focus' title='$docp->estado' data-content='$s_msj'>$icon_sunat</a>
                                        </div>


                                </div>
                            </div>
                             <div class='col-12 col-md-4 td'>
                                $docp->codpagante - $docp->pagante
                            </div>
                            <div class='col-12 col-md-4 text-center'>
                                <div class='row'>
                                    <div class='col-md-3 td'>
                                        <span>S/. $docp->total</span>
                                    </div>
                                   
                                    
                                    <div class='col-sm-3 col-md-3 td $estado_color'>
                                       $docp->estado
                                    </div>
                                    <div class='col-sm-2 col-md-2 td text-danger'>
                                       
                                    </div>
                                    <div class='col-sm-3 col-md-3 td'>
                                        <div class='col-12 pt-1 pr-3 text-center'>
                                            <div class='btn-group'>
                                                <a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    <i class='fas fa-print'></i>
                                                </a>
                                               

                                                <div class='dropdown-menu dropdown-menu-right'>
                                                    $btnmail
                                                    $btnprint
                                                    $btnpdf
                                                    $btnaddcobros
                                                    $btnanular 
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>";
    }
?>