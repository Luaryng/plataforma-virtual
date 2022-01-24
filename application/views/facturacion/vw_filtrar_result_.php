<?php
    $nro = (isset($inicio)?$inicio:0);
    //$nro =$inicio;
    foreach ($items as $docp) {
    $nro ++;
    $estado_color="text-warning";
    $icon_sunat="<i class='fas fa-check-circle fa-lg mr-1'></i>";
    $s_msj=$docp->s_descripcion;
    $text_strike="";
    $btnenlxml="";
    
    switch ($docp->estado) {
        case 'ACEPTADO':
            $icon_sunat="<i class='fas fa-check-circle fa-lg mr-1'></i>";
            $estado_color="text-success";
            $btnenlxml="<a target='_blank' class='dropdown-item' href='$docp->enl_xml' title='Descargar XML'>
                            <i class='far fa-file-code mr-1'></i> Descargar XML
                        </a>";
            break;
        case 'ANULADO':
            $s_msj="$docp->anul_fecha: $docp->anul_motivo";
            $icon_sunat="<i class='fas fa-times fa-lg mr-1'></i>";
            $estado_color="text-danger";
            $text_strike="text-strike";
            break;
        case 'ENVIADO':
            $icon_sunat="<i class='fas fa-check-circle fa-lg mr-1'></i>";
            $estado_color="text-primary";
            break;
        case 'RECHAZADO':
            $icon_sunat="<i class='fas fa-exclamation-circle fa-lg mr-1'></i>";
            $estado_color="text-danger";
            break;
        case 'ERROR':
            $s_msj="$docp->error_cod - $docp->error_desc";
            $icon_sunat="<i class='fas fa-ban fa-lg mr-1'></i>";
            $estado_color="text-danger";
            break;
    }

    $vbaseurl=base_url();
    //$datepubl =  new DateTime($docp->fecha_hora) ;
    $datemis =  new DateTime($docp->fecha_hora) ;
    //$datvence =  new DateTime($docp->fecha_hora) ;
    //$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
    //$vpublica= $dias[$datepubl->format('w')].". ".$datepubl->format('d/m/Y h:i a');
    $emision = $datemis->format('d/m/Y h:i a');  
    //$fvence = $datvence->format('d/m/Y');          
    $codigo_enc=base64url_encode($docp->codigo);
    $btneditar = "";
    $btndelete = "";
    /*$vdescargar=($docp->ruta=="")?"":"<a target='_blank' href='{$vbaseurl}documentos/pagos/archivos/$codigo_enc' title='Descargar'>
                                            <img class='mr-1' src='".base_url()."resources/img/icons/p_pdf.png' alt='PDF'> PDF
                                  </a>";*/
    $btnprint="";
    $btnpdf="";
    $btnmail="";
    $btnanular="";
    $btnaddcobros = "";
    $btneliminar="";
    $btnsunat="";
    $btnconsultar="";
    
    if (getPermitido("97") == "SI") {

        
        $btnmail = "<a class='dropdown-item' href='#' title='Editar' data-toggle='modal' data-codigo='$codigo_enc' data-target='#modenviarmail'>
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

    if ((getPermitido("102") == "SI") && ($docp->estado == "ACEPTADO")) {
        $btnanular = "<a data-codigo='$codigo_enc' class='dropdown-item text-danger' href='#' title='Anular' data-toggle='modal' data-target='#modanuladoc'>
                        <i class='far fa-file-alt mr-1'></i> Anular o Comunicar Baja
                    </a>";
    }

    if ((getPermitido("109") == "SI") && ($docp->estado == "PENDIENTE")) {

        $btneliminar = "<a data-codigo='$codigo_enc' class='dropdown-item text-danger' href='#' title='Eliminar' onclick='fn_eliminar_documento($(this));return false' >
                <i class='fas fa-trash mr-1'></i> Eliminar
            </a>";
    }
    if ((getPermitido("110") == "SI") && (($docp->estado == "PENDIENTE") || ($docp->estado == "ERROR"))) {

        $btnsunat = "<a data-codigo='$codigo_enc' class='dropdown-item text-primary' href='#' title='Enviar a SUNAT' onclick='fn_enviar_documento_ose($(this));return false' >
                <i class='far fa-paper-plane mr-1'></i> Enviar a SUNAT
            </a>";
    }
    if ((getPermitido("111") == "SI") && ($docp->estado == "ENVIADO")) {

        $btnconsultar = "<a data-codigo='$codigo_enc' class='dropdown-item text-info' href='#' title='Consultar a SUNAT' onclick='fn_consultar_documento_ose($(this));return false' >
                <i class='fas fa-binoculars mr-1'></i> Consultar a SUNAT
            </a>";
    }
    $vrtotal=number_format($docp->total, 2);
    $vrigv=number_format($docp->migv, 2);
    echo 
    "<div class='row rowcolor cfila' data-docsn='{$docp->serie}-{$docp->numero}' data-coddoc='$codigo_enc'>
                            <div class='col-12 col-md-5'>
                                <div class='row'>
                                    <div class='col-2 col-md-2 text-right td' >{$nro}. $docp->tipodoc</div>
                                    <div class='col-3 col-md-2 td' >
                                        <a href='#'  onclick='fn_showdetail(`$codigo_enc`);return false;'>
                                            {$docp->serie}-{$docp->numero} 
                                        </a>
                                    </div>
                                    <div class='col-5 col-md-4 td' >$emision</div>
                                    <div class='col-2 col-md-4 td text-center ' >
                                        <a class='vw_btn_msjsunat $estado_color' tabindex='0' role='button' data-toggle='popover' data-trigger='focus' title='$docp->estado' data-content='$s_msj'>$icon_sunat $docp->estado</a>
                                        </div>


                                </div>
                            </div>
                             <div class='col-12 col-md-4 td'>
                                <a href='#'  onclick='fn_showdetail(`$codigo_enc`);return false;'>
                                    $docp->codpagante - $docp->pagante
                                </a>
                            </div>
                            <div class='col-12 col-md-3'>
                                <div class='row'>
                                    <div class='col-md-4 td text-right'>
                                        <span class='$text_strike'>S/. $vrtotal</span>
                                    </div>
                                   <div class='col-md-4 td text-right'>
                                        <span class='$text_strike'>S/. $vrigv</span>
                                    </div>
                                    
                                    
                                    <div class='col-sm-4 col-md-3 td'>
                                        
                                            <div class='btn-group dropleft'>
                                                <button class='btn btn-warning btn-sm btn-xs dropdown-toggle py-0' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    <i class='fas fa-print'></i>
                                                </button> 
                                                
                                               

                                                <div class='dropdown-menu dropdown-menu-right'>
                                                    $btnmail
                                                    $btnprint
                                                    $btnpdf
                                                    $btnenlxml
                                                    $btnaddcobros
                                                    $btnanular 
                                                    $btneliminar
                                                    $btnsunat
                                                    $btnconsultar
                                                </div>
                                            </div>
                                        
                                    </div>

                                </div>
                            </div>
                        </div>";
    }
?>
