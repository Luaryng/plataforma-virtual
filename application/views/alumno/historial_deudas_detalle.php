<?php
    $nro = (isset($inicio)?$inicio:0);
    //$nro =$inicio;
    foreach ($items as $mat) {
        $nro ++;
        
            $vbaseurl=base_url();
            $datemis =  new DateTime($mat->fvence) ;
            $vence = $datemis->format('d/m/Y h:i a');      
            $codigo_enc=base64url_encode($mat->codigo);
            
            $vmonto=number_format($mat->monto, 2);
            $vsaldo=number_format($mat->saldo, 2);
            echo 
            "<div class='row rowcolor cfila'>
                                    <div class='col-12 col-md-5'>
                                        <div class='row'>
                                            <div class='col-2 col-md-2 text-right td' >{$nro}</div>
                                            <div class='col-10 col-md-10 td' >
                                                $mat->dni - $mat->nombres
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-12 col-md-3 td'>
                                        $mat->gestion
                                    </div>
                                    <div class='col-12 col-md-4'>
                                        <div class='row'>
                                            <div class='col-md-4 col-4 td text-center'>
                                                <span class=''>$vence</span>
                                            </div>
                                            <div class='col-md-4 col-4 td text-right'>
                                                <span class=''>S/. $vmonto</span>
                                            </div>
                                           <div class='col-md-4 col-4 td text-right'>
                                                <span class=''>S/. $vsaldo</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>";
        //}
    }
?>
