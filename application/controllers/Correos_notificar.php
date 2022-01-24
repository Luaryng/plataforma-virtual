<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'controllers/Sendmail.php';
class Correos_notificar  extends Sendmail
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mcorreos');
        $this->load->model('mmesa_partes');
        $this->load->model('minscrito');
    }
    //MESA DE PARTES
    public function pdf_ficha_tramite_mail($codmt)
    {
        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

            $codmt=base64url_decode($codmt);
            
            $this->load->model('miestp');
            $ie=$this->miestp->m_get_datos();
            
            $tmp=$this->mmesa_partes->m_solicitud_x_codigo(array($codmt));
            
            $dominio=str_replace(".", "_",getDominio());
            $html1=$this->load->view("tramites/mesa_partes/pdf_formato_externo", array('ies' => $ie,'tmps'=>$tmp),true);
           
            $pdfFilePath = "TRAMITE N°".$tmp['solicitud']->codseg.".pdf";

            $this->load->library('M_pdf');
            $formatoimp="A4";
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]);
            $mpdf->SetTitle( "TRAMITE N°".$tmp['solicitud']->codseg);
            $mpdf->WriteHTML($html1);
            
            return $mpdf->Output($pdfFilePath, "S");
    }
    //////////
    public function pdf_ficha_inscripcion($codperiodo,$codins){

        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

            $codperiodo=base64url_decode($codperiodo);
            $codins=base64url_decode($codins);
            //$carne=base64url_decode($carne);
            
            $this->load->model('miestp');
            $ie=$this->miestp->m_get_datos();
            //if (!is_null($rsfila)){
            //GET INSCRIPCIÓN Y SEDE
            $insc=$this->minscrito->m_get_inscripcion_pdf(array($codperiodo,$codins));

            $adjuntos=$this->minscrito->m_get_docsanexados_fichapdf(array($codins));
            $dominio=str_replace(".", "_",getDominio());
            $html1=$this->load->view("admision/rp_fichainscripcion_$dominio", array('ies' => $ie,'ins'=>$insc, 'adjuntos'=>$adjuntos ),true);
           
            $pdfFilePath = "$insc->paterno $insc->materno $insc->nombres FICHA $insc->carnet.pdf";

            $this->load->library('M_pdf');
            $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
            $mpdf->SetTitle( "$insc->paterno $insc->materno $insc->nombres FICHA $insc->carnet");
            $mpdf->WriteHTML($html1);
            //$mpdf->AddPage();
            //$mpdf->WriteHTML($html2);
            return $mpdf->Output($pdfFilePath, "S");
    }

    public function fn_send_correos_pendientes()
    {
        $dataex['status'] = false;
        $dataex['flat'] = "inicia";
        $dataex['destino']=array();
        $datacorreos = $this->mcorreos->mData_correos_notificaciones();
        // $pruebas_email = array();
        $nro=0;
        foreach ($datacorreos as $key => $tmail) {
            
            $nro++;
            $dataex['flat'] = $nro;
            $r_respondera=array();
            // $d_enviador = array();
            $d_destino = array();
            $d_copia = array();
            $d_oculto = array();
            $trestado = $tmail->trestado;
            $d_enviador = json_decode($tmail->cenvia);
            $destemail = json_decode($tmail->cdestino);
            $destcopia = json_decode($tmail->descopia);
            $destoculto = json_decode($tmail->desoculto);
            $d_asunto = $tmail->asunto;
            $e_mensaje = $tmail->mensaje;
            $codigo = $tmail->id;
            $enviar_mail=false;
            foreach ($destemail as $key => $vemail) {
                if (filter_var($vemail, FILTER_VALIDATE_EMAIL)) {
                    $d_destino[] = $vemail;
                    $enviar_mail=true;
                }
            }
            foreach ($destcopia as $key => $vemailc) {
                if (filter_var($vemailc, FILTER_VALIDATE_EMAIL)) {
                    $d_copia[] = $vemailc;
                }
            }
            foreach ($destoculto as $key => $vemailo) {
                if (filter_var($vemailo, FILTER_VALIDATE_EMAIL)) {
                    $d_oculto[] = $vemailo;
                }
            }
            $pruebas_email=array();
            $d_adjuntos =array();
            $pdfficha="";
            if ($enviar_mail==true){
                
                $rpenviado = "NO";
                $msgerror="";
                
                
               //$idceros = "";
                if ($tmail->tabla=="MESA"){
                    if ($trestado == "CREADO"){
                        //cuando es creado, $tmail->codruta  guarda el codigo de mesa de partes no de ruta
                        $tramite = $this->mmesa_partes->m_get_codseguimiento_x_codtramite(array($tmail->codruta));
                        if (isset($tramite->codseg)){
                            $idceros = $tramite->codseg;
                            $pdfficha = $this->pdf_ficha_tramite_mail(base64url_encode($tmail->codruta));
                            $pruebas_email[]=array($pdfficha, 'attachment',"TRÁMITE N° ".$idceros.".pdf","application/pdf");
                            $d_adjuntos = $this->mmesa_partes->m_get_adjuntos_x_codtramite(array($tmail->codruta));
                        }
                        else{
                            $enviar_mail=false;
                            $msgerror="CÓDIGO DE TRÁMITE NO EXISTE";
                        }
                    }
                    else{
                        $ruta = $this->mmesa_partes->m_get_codtramite_x_codruta(array($tmail->codruta));
                        if (isset($ruta->codmesa)){
                            $d_adjuntos = $this->mmesa_partes->m_get_adjuntos_x_codruta(array($tmail->codruta));
                            if ($trestado == "DERIVADO"){
                                $idceros = $ruta->codmesa;
                                $pdfficha = $this->pdf_ficha_tramite_mail(base64url_encode($ruta->codmesa));
                                $pruebas_email[]=array($pdfficha, 'attachment',"TRÁMITE N°".$idceros.".pdf","application/pdf");
                            }
                            elseif($trestado == "FINALIZADO"){

                            }
                        }
                        else{
                            $enviar_mail=false;
                            $msgerror="CÓDIGO DE RUTA NO EXISTE";
                        }
                    }
                }
                elseif($tmail->tabla=="DOCPAGO"){
                    
                }
                elseif($tmail->tabla=="INSCRIPCION"){
                    $rpta = $this->minscrito->m_get_inscrito_por_codigo(array($tmail->codruta));
                    $fichapdf = $this->pdf_ficha_inscripcion(base64url_encode($rpta->codperiodo),base64url_encode($tmail->codruta));
                    $pruebas_email[]=array($fichapdf, 'attachment',"$rpta->paterno $rpta->materno $rpta->nombres FICHA $rpta->carnet.pdf","application/pdf");
                }

                if($enviar_mail==true){
                    foreach ($d_adjuntos as $key => $flt) {
                        $pathtodir =  getcwd() ;          
                        $link = $flt->link;
                        $existefile=is_file($pathtodir."/upload/tramites/".$link);
                        if ($existefile==true){
                            $pruebas_email[]=array($pathtodir."/upload/tramites/".$link, 'attachment',$flt->archivo);
                        }
                    }
                    //f_sendmail_completo($array_enviador,$destinos,$destinos_copia,$asunto,$mensaje,$array_adjuntos,$array_responder_a=array()){
                    $rsp_iesap = $this->f_sendmail_completo($d_enviador,$d_destino,$d_copia,$d_oculto,$d_asunto,$e_mensaje,$pruebas_email,$r_respondera);
                    
                    if ($rsp_iesap['estado'] == true){
                        $rpenviado = "SI";
                        $msgerror=null;
                    }
                    else{
                        $msgerror = $rsp_iesap['mensaje'];
                    }

                }

                date_default_timezone_set('America/Lima');
                $fecenvio = date("Y-m-d H:i:s");
                $this->mcorreos->mUpdate_items_correos_notificaciones(array($rpenviado, $fecenvio, $msgerror, $codigo));
                sleep(5);
            }
            else{
                $this->mcorreos->mUpdate_items_correos_notificaciones(array("NO", null, "Sin correo de destino", $codigo));
            }

        }    
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

}
