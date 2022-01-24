<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 //include_once APPPATH.'libraries/mpdf/Mpdf.php';
 require_once('mpdf/vendor/autoload.php');
class M_pdf {
 
    public $param;
    public $pdf;
 
    public function __construct($param = array('"en-GB-x","A4","","",10,10,10,10,6,3'))
    {
        $this->param =$param;
        //$this->pdf = new mPDF($this->param);
        $this->pdf = new \Mpdf\Mpdf($this->param);
    }
}