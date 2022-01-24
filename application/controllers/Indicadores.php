<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Indicadores extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mindicadores');
	}


 	public function f_ordenar()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            $urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('vcca', 'Carga académica', 'trim|required');
            $this->form_validation->set_rules('vssc', 'Subsección', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error al intentar generar la nueva fecha</a>";
                $vcca          = $this->input->post('vcca');
                $vssc          = $this->input->post('vssc');
                $data          = json_decode($_POST['filas']);
                $dataUpdate    = array();
                foreach ($data as $value) {
                    if ($value[1] > 0) {
                        $dataUpdate[] = array($value[0],$value[1]);
                    }
                }
                $rpta = $this->mindicadores->m_ordenar($dataUpdate);
                //var_dump($dataex['ids']);
                $dataex['status'] = true;

            }
            $dataex['destino'] = $urlRef;
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }

    public function fn_insert_update(){
    	if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            $urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
            $this->form_validation->set_rules('codindicador', 'Indicador', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                $nombre          = $this->input->post('nombre');
                $codindicador          = $this->input->post('codindicador');
                $vcca          = $this->input->post('vcca');
                $vssc          = $this->input->post('vssc');
                $norden          = $this->input->post('norden');
                $rpta=0;
                if ($codindicador<1){
                	//insert
                	$data=array($norden,$nombre,$vcca,$vssc);
                	$rpta = $this->mindicadores->m_insert($data);
                }
                else{

                	$data=array($codindicador,$nombre);
                	$rpta = $this->mindicadores->m_update($data);
                }
                if ($rpta>0){
                	$dataex['status'] =true;
                	$dataex['newid'] =$rpta;
                }
            }
            $dataex['destino'] = $urlRef;
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }

    public function fn_delete(){
    	if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            $urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('codindicador', 'Indicador', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                $codindicador    = $this->input->post('codindicador');
                $rpta=0;
                $data=array($codindicador);
                $rpta = $this->mindicadores->m_delete($data);

                if ($rpta>0){
                	$dataex['status'] =true;
                }
            }
            $dataex['destino'] = $urlRef;
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }
}