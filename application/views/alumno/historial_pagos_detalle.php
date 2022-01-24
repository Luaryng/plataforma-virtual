<?php
    $nro = (isset($inicio)?$inicio:0);
    //$nro =$inicio;
    foreach ($items as $docp) {
        $nro ++;
        $estado_color="text-warning";
        $icon_sunat="<i class='fas fa-check-circle fa-lg mr-1'></i>";
        $s_msj=$docp->s_descripcion;
        $text_strike="";
        $icon_sunat="<i class='fas fa-check-circle fa-lg mr-1'></i>";
                $estado_color="text-success";
                $btnenlxml="<a target='_blank' class='dropdown-item' href='$docp->enl_xml' title='Descargar XML'>
                                <i class='far fa-file-code mr-1'></i> Descargar XML
                            </a>";
        
        /*$mostrar=false;
        switch ($docp->estado) {
            case 'ACEPTADO':
                
                $mostrar=true;
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
        }*/
        //if ($mostrar==true){
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
            $btneliminar="";
            $btnsunat="";
            $btnconsultar="";
            


                
            $btnmail = "<a class='dropdown-item' href='#' title='Editar' data-toggle='modal' data-codigo='$codigo_enc' data-target='#modenviarmail'>
                            <i class='far fa-file-alt mr-1'></i> Enviar a email
                        </a>";
            /*$btnprint = "<a target='_blank' class='dropdown-item' href='{$vbaseurl}tesoreria/facturacion/generar/rpgrafica/$codigo_enc' title='Imprimir'>
                            <i class='far fa-file-alt mr-1'></i> Impresión
                        </a>";*/
            $btnpdf = "<a target='_blank' class='dropdown-item' href='{$vbaseurl}tesoreria/facturacion/generar/pdf/$codigo_enc' title='PDF'>
                           <i class='far fa-file-pdf mr-1'></i> Descargar
                        </a>";

            $btnaddcobros = "<a data-codigo='$codigo_enc' class='dropdown-item text-success' href='#' title='Cobros' data-toggle='modal' data-target='#modaddcobros' data-pgmonto='$docp->total'>
                            <i class='far fa-credit-card mr-1'></i> Cobros
                        </a>";
                //$btndelete = "<a class='dropdown-item text-danger' href='#' data-codigo='$codigo_enc' onclick='vw_pw_tp_pr_fn_delete_doc($(this));event.preventDefault();' title='Eliminar'>
                                //<i class='far fa-file-pdf mr-1'></i> PDF
                            //</a>";
                
            

            
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
                                            $docp->codpagante 
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
                                            
                                            
                                            <div class='col-sm-4 col-md-3 td text-right'>
                                                
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
        //}
    }
?>
