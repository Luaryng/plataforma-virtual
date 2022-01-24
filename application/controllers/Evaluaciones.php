<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';
class Evaluaciones extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper("url"); 
        $this->load->model('mmiembros');
        $this->load->model('mevaluaciones');
        $this->load->model('masistencias');
        
        //$this->load->library('pagination');
    }



    
}