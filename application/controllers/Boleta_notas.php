<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Boleta_notas extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mmatricula');
    }

public function vw_boleta_notas()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
        $dataex['status'] = false;
        $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
        $rst="";
        $this->form_validation->set_rules('cbmatricula', 'Matrícula', 'trim|required');
        if ($this->form_validation->run() == false) {
            $dataex['msg'] = validation_errors();
        } 
        else {
            $cmat=$this->input->post('cbmatricula');
            $cmat64      = base64url_decode($cmat) ;
            $arraymc['miscursos'] = $this->mmatricula->m_miscursos_x_matricula(array($cmat));
            $arraymc['miscursosesta'] = $this->mmatricula->m_miscursos_x_mat_asist_estadistica(array($cmat));
            $arraymc['carnet'] = $_SESSION['userActivo']->usuario;
            $arraymc['alumno'] = $_SESSION['userActivo']->paterno;
            $rst = $this->load->view('alumno/miscursostabla', $arraymc,true);
            $dataex['mat64']=$cmat64;
            $dataex['status'] = true;
        }
        $dataex['miscursos'] = $rst;
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }
}
