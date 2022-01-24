<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mfacturacion_sendmail extends CI_Model {

	function __construct() {
           parent::__construct();
    }


    public function m_get_datos_sunat($data)
    {
      $qry = $this->db->query("SELECT 
            tb_docpago_sunat.dcps_aceptado as s_aceptado,
            tb_docpago_sunat.dcps_snt_descripcion as s_descripcion,
            tb_docpago_sunat.dcps_snt_note as s_note,
            tb_docpago_sunat.dcps_snt_responsecode as s_response,
            tb_docpago_sunat.dcps_snt_soap_error as s_soap,
            tb_docpago_sunat.dcps_snt_enlace_xml enl_xml,
            tb_docpago_sunat.dcps_snt_enlace_cdr enl_cdr,
            tb_docpago_sunat.dcps_snt_enlace_pdf enl_pdf,
            tb_docpago_sunat.dcps_error_cod as error_cod,
            tb_docpago_sunat.dcps_error_desc as error_desc
          FROM
            tb_docpago_sunat
          WHERE tb_docpago_sunat.dcps_id =? 
          LIMIT 1", $data);
        
        return $qry->row();
    }

    
}