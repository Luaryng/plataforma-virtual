<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Virtualtarea extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->model('mcargasubseccion');
        $this->load->model('mvirtual');
        $this->load->model('mvirtualtarea');
	}

    public function vw_docente_virtual_tarea($codcarga,$division,$codmaterial)
    {
        $ahead= array('page_title' =>'Admisión | IESTWEB'  );
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $arraymc['vcarga']=$codcarga;
        $arraymc['vdivision']=$division;
        $division=base64url_decode($division);
        $codcarga=base64url_decode($codcarga);
        $codmaterial=base64url_decode($codmaterial);
        $tipo=$this->input->get('type');
       
        /*$arsb['menu_padre']='docconfiguracion';*/
        $this->load->model('mcargasubseccion');
        $arraymc['mat'] = $this->mvirtual->m_get_material(array($codmaterial));
        $arraymc['varchivos'] =$this->mvirtual->m_get_detalle_x_material(array($codmaterial));
        $arraymc['nroentregas'] =$this->mvirtual->m_get_count_entregas_x_material(array($codmaterial));
        
        $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
        $arraymc['nmiembros'] = $this->mcargasubseccion->m_get_nro_alumnos_carga_subseccion(array($codcarga,$division));
        $arsb['menu_padre']='docaulavirtual';
        $arsb['vcarga']=$codcarga;
        $arsb['vdivision']=$division;
        $this->load->view('docentes/sidebar_curso',$arsb);

        $this->load->view('virtual/vw_aula_tarea', $arraymc);
        $this->load->view('footer');
    }
    
    public function vw_alumno_virtual_tarea($codcarga,$division,$codmaterial,$codmiembro)
    {
        $ahead= array('page_title' =>'Admisión | IESTWEB'  );
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $arraymc['vcarga']=$codcarga;
        $arraymc['vdivision']=$division;
        $arraymc['vcodmiembro']=$codmiembro;
        
        $division=base64url_decode($division);
        $codcarga=base64url_decode($codcarga);
        $codmaterial=base64url_decode($codmaterial);
        $codmiembro=base64url_decode($codmiembro);
        $arraymc['mat'] = $this->mvirtual->m_get_material(array($codmaterial));
        $arraymc['varchivos'] =$this->mvirtual->m_get_detalle_x_material(array($codmaterial));

        $arraymc['tentregada'] = $this->mvirtualtarea->m_get_tarea_entregada(array($codmaterial,$codmiembro));
        if (isset($arraymc['tentregada']->codtarea)){
            $arraymc['varchivostarea'] =$this->mvirtualtarea->m_get_detalles_x_tarea(array($arraymc['tentregada']->codtarea)); 
       }
       else{
            $arraymc['tentregada']=array();
       }
               
        $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
        $arsb['menu_padre']='alaulavirtual';
         $this->load->view('sidebar',$arsb);

        $this->load->view('virtual/alumno/vw_aula_tarea', $arraymc);
        $this->load->view('footer');
    }

    public function vw_virtual_tarea_entregar($codcarga,$division,$codmaterial,$codmiembro)
    {
        $ahead= array('page_title' =>'Admisión | IESTWEB'  );
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $arraymc['vcarga']=$codcarga;
        $arraymc['vdivision']=$division;
        $arraymc['vcodmiembro']=$codmiembro;

        $division=base64url_decode($division);
        $codcarga=base64url_decode($codcarga);
        $codmaterial=base64url_decode($codmaterial);

        $arraymc['mat'] = $this->mvirtual->m_get_material(array($codmaterial));
        
        $arraymc['varchivos'] =$this->mvirtual->m_get_detalle_x_material(array($codmaterial));
        $arsb['menu_padre']='alaulavirtual';
        $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));

        $this->load->view('sidebar',$arsb);

        $this->load->view('virtual/alumno/vw_aula_tarea_entregar', $arraymc);
        $this->load->view('footer');
    }

    public function vw_virtual_tarea_editar($codcarga,$division,$codmaterial,$codmiembro)
    {
        $ahead= array('page_title' =>'Admisión | IESTWEB'  );
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $arraymc['vcarga']=$codcarga;
        $arraymc['vdivision']=$division;
        $arraymc['vcodmiembro']=$codmiembro;


        $division=base64url_decode($division);
        $codcarga=base64url_decode($codcarga);
        $codmaterial=base64url_decode($codmaterial);
        $codmiembro=base64url_decode($codmiembro);
        //$tipo=$this->input->get('type');
       
        /*$arsb['menu_padre']='docconfiguracion';*/
        
        $arraymc['mat'] = $this->mvirtual->m_get_material(array($codmaterial));
        //var_dump($arraymt);
        
        $arraymc['varchivos'] =$this->mvirtual->m_get_detalle_x_material(array($codmaterial));
        $arraymc['tentregada'] = $this->mvirtualtarea->m_get_tarea_entregada(array($codmaterial,$codmiembro));
        $arraymc['varchivostarea'] =array();
        if (isset($arraymc['tentregada']->codtarea))  $arraymc['varchivostarea'] =$this->mvirtualtarea->m_get_detalles_x_tarea(array($arraymc['tentregada']->codtarea));
        //$arraymc['agregar'] = $this->load->view('virtual/vw_aula_tarea',$arraymt,true);
        $arsb['menu_padre']='alaulavirtual';
        $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
        
        $this->load->view('sidebar',$arsb);

        $this->load->view('virtual/alumno/vw_aula_tarea_entregar', $arraymc);
        $this->load->view('footer');
    }

 	

    public function vw_virtual_tarea_entregas($codcarga,$division,$codmaterial)
    {
        
        $ahead= array('page_title' =>'Admisión | IESTWEB'  );
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $arraymc['vcarga']=$codcarga;
        $arraymc['vdivision']=$division;
        $division=base64url_decode($division);
        $codcarga=base64url_decode($codcarga);
        $codmaterial=base64url_decode($codmaterial);
        
        $arraymc['mat'] = $this->mvirtual->m_get_material(array($codmaterial));
        $this->load->model('mcargasubseccion');
        
        //$arraymc['varchivos'] =$this->mvirtual->m_get_detalle_x_material(array($codmaterial));
        //$arraymc['nroentregas'] =$this->mvirtual->m_get_count_entregas_x_material(array($codmaterial));
        
        
        $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
        $this->load->model('mmiembros');
        $arraymc['miembros'] = $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
        //$this->load->model('mvirtualalumno');
        $arraymc['entregas'] = $this->mvirtualtarea->m_get_tareas_entregadas($codmaterial);
        $arraymc['varchivosentrega'] = $this->mvirtualtarea->m_get_detalles_x_material($codmaterial);

        
        $arsb['menu_padre']='docaulavirtual';
        $arsb['vcarga']=$codcarga;
        $arsb['vdivision']=$division;
        $this->load->view('docentes/sidebar_curso',$arsb);

        $this->load->view('virtual/vw_aula_tarea_entregas', $arraymc);
        $this->load->view('footer');
    }

    public function fn_insert_update(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            //$urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('vdivision', 'División', 'trim|required');
            $this->form_validation->set_rules('vidcurso', 'Carga', 'trim|required');
            $this->form_validation->set_rules('vidmaterial', 'Material', 'trim|required');

            $errors = array();
            $dataex['errors']= array();
            if ($this->form_validation->run() == false) {
                //$dataex['msg'] = validation_errors();
                $dataex['msg'] = "Existe error en los campos";
                
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
            } 
            else {
                 //@vvirt_nombre, @vvirt_tipo, @vvirt_id_padre, @vvirt_link, @vvirt_vence, @vvirt_detalle, @vvirt_norden, @vcodigocarga, @vcodigosubseccion
                //$errors=array();
                $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";

                date_default_timezone_set('America/Lima');
                $ventrega=date("Y-m-d H:i:s");
                $vdetalle          = null;
                $vdivision=$this->input->post('vdivision');
                $vidcurso=$this->input->post('vidcurso');
                $vidcurso=base64url_decode($vidcurso);
                $vdivision=base64url_decode($vdivision);
                $vnrofiles= 1;
                $veditar="SI";
                $vidmaterial="";
                $vidmiembro=0;
                
                $vid = 0;

                $usuario = $_SESSION['userActivo']->idusuario;
                $sede = $_SESSION['userActivo']->idsede;

                if ($this->input->post('textdetalle')!==null){
                     $vdetalle          = $this->input->post('textdetalle');
                 }
                
                if ($this->input->post('vid')!==null){
                     $vid          = $this->input->post('vid');
                }
                if ($this->input->post('vidmaterial')!==null){
                     $vidmaterial          = $this->input->post('vidmaterial');
                }


                if ($this->input->post('cbnroarchivos')!==null){
                    $vnrofiles          = $this->input->post('cbnroarchivos');
                }
                if ($this->input->post('vidmiembro')!==null){
                    $vidmiembro          = base64url_decode($this->input->post('vidmiembro'));
                }

                //$vnomcurso= $this->input->post('vnomcurso');

                
                //$notificar=true;
                $rpta=0;
                $filesnoup=array();
                if ($vid<1){
                    //INSERT
                    //$vidmiembro = $this->mvirtual->m_codigo_miembro(array($_SESSION['userActivo']->usuario,$vidcurso,$vdivision));
                    $dataex['msg'] = "NO se PUDO insertar LA ENTREGA";
                    $data=array($ventrega,$vdetalle,$vidcurso,$vdivision,$vnrofiles,$vidmiembro,$vidmaterial);
                    $rpta = $this->mvirtualtarea->m_insert($data);

                    $fictxtaccion = 'INSERTAR';
                    $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está entregando tarea en la tabla TB_VIRTUAL_TAREA_ALUMNO COD.".$rpta->nid;
                    
                    $dataex['newid'] =$rpta->salida;
                    if ($rpta->salida=='1'){

                        $dataex['msg'] = "SI se PUDO INSERTAR LA ENTREGA";
                        $datafile= json_decode($_POST['afiles']);
                        foreach ($datafile as $value) {
                            if (trim($value[0])==""){
                                $filesnoup[]=$value[1];
                            }
                            else{
                                if (file_exists ("upload/".$value[0])){
                                    $rpta2 = $this->mvirtualtarea->m_insert_detalle(array($rpta->nid,$value[0],$value[1],$value[2],$value[3],$vidcurso,$vdivision));
                                }
                                else{
                                        $filesnoup[]=$value[1];
                                }
                            }
                        }

                        $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));

                        $dataex['status'] =true;
                        $dataex['newid'] =$rpta->nid;
                        
                        $dataex['redirect']=base_url()."alumno/curso/virtual/tarea/".$this->input->post('vidcurso').'/'.$this->input->post('vdivision').'/'.base64url_encode($vidmaterial).'/'.base64url_encode($vidmiembro);
                    }
                }
                else{
                    //update
                    $fictxtaccion = 'EDITAR';
                    $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando tarea en la tabla TB_VIRTUAL_TAREA_ALUMNO COD.".$vid;

                    $data=array($ventrega,$vdetalle,$vidcurso,$vdivision,$vnrofiles,$vid);
                    $rpta = $this->mvirtualtarea->m_update($data);
                    //if (($vtipo=="A") || ($vtipo=="T") || ($vtipo=="F")){
                        $datafile= json_decode($_POST['afiles']);
                        foreach ($datafile as $value) {
                            if ($value[3]==0){
                                if (trim($value[0])==""){
                                    $filesnoup[]=$value[1];
                                }
                                else{
                                    if (file_exists ("upload/".$value[0])){
                                        $rpta2 = $this->mvirtualtarea->m_insert_detalle(array($vid,$value[0],$value[1],$value[2],$value[3],$vidcurso,$vdivision));
                                    }else{
                                        $filesnoup[]=$value[1];
                                    }
                                    
                                }    
                            }
                            else{

                            }
                            
                            
                        }
                    //}
                    if ($rpta=='1'){
                        $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                        
                        $dataex['status'] =true;
                        $dataex['newid'] =$vid;
                         $dataex['redirect']=base_url()."alumno/curso/virtual/tarea/".$this->input->post('vidcurso').'/'.$this->input->post('vdivision').'/'.base64url_encode($vidmaterial).'/'.base64url_encode($vidmiembro);
                    }
                }
                $dataex['filesnoup'] = $filesnoup;
                if ((count($filesnoup)>0) && ($dataex['status']==true)){
                    //http://localhost/sisweb/curso/virtual/editar/NTc-/MQ--/NDA-?type=A
                    $dataex['redirect']=base_url()."alumno/curso/virtual/editar/".$this->input->post('vidcurso').'/'.$this->input->post('vdivision').'/'.base64url_encode($dataex['newid'])."/.".base64url_encode($vidmiembro);
                }

                
                //$dataex['destino'] = $urlRef;
                $dataex['errors'] = $errors;
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

	public function fn_calificar()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural', '* {field} requiere un nímero entero');
		
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('ajcodtarea','Tarea','trim|required');
            $this->form_validation->set_rules('ajcodcarga','Carga','trim|required');
            $this->form_validation->set_rules('ajcoddivision','División','trim|required');
			$this->form_validation->set_rules('ajnota','Nota','trim|is_natural');
			$this->form_validation->set_rules('ajcodmiembro','Miembro','trim|required');
            $this->form_validation->set_rules('ajcodentrega','Entrega','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
                $dataex['msg']=validation_errors();
			}
			else
			{
				$ajcodtarea=base64url_decode($this->input->post('ajcodtarea'));
                $ajcodcarga=base64url_decode($this->input->post('ajcodcarga'));
                $ajcoddivision=base64url_decode($this->input->post('ajcoddivision'));
                $ajnota=$this->input->post('ajnota');
                $ajobs=$this->input->post('ajobs');
                $ajcodmiembro=base64url_decode($this->input->post('ajcodmiembro'));
                $ajcodentrega=intval(base64url_decode($this->input->post('ajcodentrega')));
                if ($ajcodentrega==0) $ajcodentrega=null;
                if ($ajnota=="") $ajnota=null;
                //( @vid_material, @vcodigocarga, @vcodigosubseccion, @vvita_nota, @vmiembro_id, @vvita_id, @`s`, @nid);
				$filarp=$this->mvirtualtarea->m_calificar(array($ajcodtarea,$ajcodcarga,$ajcoddivision,$ajnota,$ajcodmiembro,$ajcodentrega,$ajobs));
				if ($filarp->salida=='1'){
					$dataex['status'] =TRUE;
					$dataex['newid'] =base64url_encode($filarp->nid);
				}
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

        public function fn_get_tarea_entregada()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural', '* {field} requiere un nímero entero');
        
    
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('ajcodtarea','Tarea','trim|required');
            $this->form_validation->set_rules('ajcodcarga','Carga','trim|required');
            $this->form_validation->set_rules('ajcoddivision','División','trim|required');
            $this->form_validation->set_rules('ajnota','Nota','trim|is_natural');
            $this->form_validation->set_rules('ajcodmiembro','Miembro','trim|required');
            $this->form_validation->set_rules('ajcodentrega','Entrega','trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
                $dataex['msg']=validation_errors();
            }
            else
            {
              
                
                $ajcodmiembro=base64url_decode($this->input->post('ajcodmiembro'));
                $ajcodentrega=intval(base64url_decode($this->input->post('ajcodentrega')));

                $fila=$this->mvirtualtarea->m_get_tarea_entregada(array($ajcodentrega,$ajcodmiembro));
                if (isset($fila->codtarea)){
                    $dataex['entrega'] = $fila; 
                    $dataex['status'] = true;   
                }
                //( @vid_material, @vcodigocarga, @vcodigosubseccion, @vvita_nota, @vmiembro_id, @vvita_id, @`s`, @nid);
                
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }


    public function fn_tarea_entregada_delete_detalle(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            $urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
          
                $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                $codindicador    = ($this->input->post('coddetalle') =="0")?"":$this->input->post('coddetalle');
                if ("" !==$codindicador ){
                    $codindicador    = $this->input->post('coddetalle');
                    $link    = $this->input->post('link');
                    $rpta=0;
                    $data=array($codindicador);
                    if ($codindicador>0){
                        $rpta = $this->mvirtualtarea->m_tarea_entregada_delete_detalle($data);
                        $pathtodir =  getcwd() ; 
                        unlink($pathtodir."/upload/".$link );
                        $dataex['status'] =true;
                    }
                }
                else{
                    if ("" !== $this->input->post('link')){
                        $link    = $this->input->post('link');
                        $pathtodir =  getcwd() ; 
                        unlink($pathtodir."/upload/".$link );
                        $dataex['status'] =true;
                    }
                    else{
                        $dataex['status'] =true;
                    }
                    
                }
            
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function vw_evaluacion_tarea_pdf($codcarga,$division,$codmaterial)
    {
        if (($_SESSION['userActivo']->codnivel == 0) || ($_SESSION['userActivo']->codnivel == 1) || ($_SESSION['userActivo']->codnivel == 2)) {
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $idmaterial=base64url_decode($codmaterial);
            $curso = $this->mcargasubseccion->m_get_carga_subseccion_todos(array($codcarga,$division));
            if (isset($curso)) {
                $this->load->model('mmiembros');

                $areg['curso'] =$curso;
                
                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                $material = $this->mvirtual->m_get_material(array($idmaterial));
                $tareas = $this->mvirtualtarea->m_get_tareas_entregadas(array($idmaterial));

                $nro=0;

                $areg['miembros']   =$miembros;
                $areg['material']=$material;
                $areg['tareas']=$tareas;

                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();
                $areg['iestp'] = $iestp;
                
                $dominio=str_replace(".", "_",getDominio());
                
                $html1=$this->load->view('virtual/docvirtual/evaluacion_tareapdf',$areg,true);

                $pdfFilePath = "EVALUACIÓN_TAREA_".$curso->periodo." ".$curso->unidad."_".$material->nombre.".pdf";
                $this->load->library('M_pdf');
                $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
                $mpdf->shrink_tables_to_fit = 1;
                $mpdf->SetTitle( "$curso->unidad $curso->codseccion $curso->division $material->nombre");
                $mpdf->WriteHTML($html1);

                $mpdf->Output($pdfFilePath,"D");  //TAMBIEN I para en linea*/
            }
        }
    }

}