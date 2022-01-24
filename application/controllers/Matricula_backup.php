<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Matricula extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mmatricula');
	}

	public function vw_matricula()
    {
		$ahead= array('page_title' =>'Matricular | IESTWEB'  );
		$asidebar= array('menu_padre' =>'academico','menu_hijo' =>'matriculas','menu_nieto' =>'alumnos');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		
        $this->load->model('mcarrera'); 
        $a_ins['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);
		$this->load->model('mbeneficio');		
		$a_ins['beneficios']=$this->mbeneficio->m_get_beneficios();

        $this->load->model('mperiodo');
		$a_ins['periodos']=$this->mperiodo->m_get_periodos();
		$this->load->model('mtemporal');
		$a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
		//$this->load->model('mcarrera');
		$a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
		//$this->load->model('mcarrera');
		$a_ins['secciones']=$this->mtemporal->m_get_secciones();
        $this->load->model('mplancurricular');
        $a_ins['planes']=$this->mplancurricular->m_get_planes_activos();
        $a_ins['estados'] = $this->mmatricula->m_filtrar_estadoalumno();
		//$modl=$this->mmodalidad->m_modalidad();
		$this->load->view('matricula/vw_matriculas',$a_ins);
		$this->load->view('footer');
	}
  //√
    public function vw_matricula_boleta_notas()
    {
        $ahead= array('page_title' =>'Matricular | IESTWEB'  );
        $asidebar= array('menu_padre' =>'academico','menu_hijo' =>'acadconsulta','menu_nieto' =>'bolnotas');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $this->load->view('sidebar',$asidebar);
        
        $this->load->model('mcarrera'); 
        $a_ins['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);
        $this->load->model('mbeneficio');   
        $a_ins['beneficios']=$this->mbeneficio->m_get_beneficios();

        $this->load->model('mperiodo');
        $a_ins['periodos']=$this->mperiodo->m_get_periodos();
        $this->load->model('mtemporal');
        $a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
        //$this->load->model('mcarrera');
        $a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
        //$this->load->model('mcarrera');
        $a_ins['secciones']=$this->mtemporal->m_get_secciones();
        //$modl=$this->mmodalidad->m_modalidad();
        $this->load->view('matricula/vw_matriculas_boleta-notas',$a_ins);
        $this->load->view('footer');
    }

	public function vw_matriculados()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
        $dataex['status'] = false;
        $urlRef           = base_url();
        $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
        $rst              = "";
        $mien             = "";
        $this->form_validation->set_rules('cbperiodo', 'Periodo', 'trim|required');
        $this->form_validation->set_rules('txtbusca_apellnom', 'Apellidos y nombres', 'trim|required|min_length[4]|max_length[50]');
        $salida="<h4>SIN RESULTADOS</h4>";
        if ($this->form_validation->run() == false) {
            $dataex['msg'] = validation_errors();
        } 
        else {
            $cbper     = $this->input->post('cbperiodo');
            $tcar      = $this->input->post('txtbusca_apellnom')."%";
            $matriculas = $this->mmatricula->m_matricula_x_periodo_alumno(array($tcar,$cbper));
            
            $tabla="";
            
            

              $tabla = '<table class="table table-bordered table-striped table-hover table-condensed" id="tr-cursos" role="table">
                <thead role="rowgroup">
                  <tr role="row">
                    <th role="columnheader">COD</th>
                    <th role="columnheader">ALUMNO</th>
                    <th role="columnheader"> </th>
                    <th role="columnheader">PROG. DE ESTUDIOS</th>
                    <th role="columnheader">SEM.</th>
                    <th role="columnheader">TUR.</th>
                    <th role="columnheader">SEC.</th>
                    
                  </tr>
                </thead>
                <tbody role="rowgroup">';
                foreach ($matriculas as $matricula) {
                  $fn="searchc('".$matricula->carne."')";
                    $tabla  = $tabla . '<tr role="row">
                      <td role="cell">' . $matricula->carne . '</td>
                      <td role="cell">' . $matricula->alumno . '</td>
                      <td role="cell"><a onclick="'.$fn.';return false" class="bg-primary py-1 px-2 rounded" title="Ver detalles" href="#"><i class="fa fa-eye"></i> Ver Cursos</a></td>
                      <td role="cell">' . $matricula->carrera . '</td>
                      <td role="cell">' . $matricula->ciclo . '</td>
                      <td role="cell">' . $matricula->codturno . '</td>
                      <td role="cell">' . $matricula->codseccion. '</td>
                    </tr>';
                  }
                
              $tabla= $tabla . "</tbody></table>";
              $salida=(count($matriculas)>0) ? $tabla : "<h4>SIN RESULTADOS</h4>" ;
             
            $dataex['status'] = true;
        }
        $dataex['matriculados'] = $salida;
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
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

	public function fn_insert()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('alpha', '* {field} requiere un valor de la lista.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
        $this->form_validation->set_message('exact_length', '* {field} requiere un valor de la lista.');
        
    
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('fm-txtid','Identificador','trim|required');
            
            $this->form_validation->set_rules('fm-cbtipo','Modalidad','trim|required');
            $this->form_validation->set_rules('fm-cbbeneficio','Beneficio','trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('fm-cbplan','Plan nuevo','trim|required|is_natural_no_zero');

            $this->form_validation->set_rules('fm-cbperiodo','Periodo','trim|required|exact_length[5]');
            $this->form_validation->set_rules('fm-txtcarrera','Carrera','trim|required|is_natural_no_zero');

            $this->form_validation->set_rules('fm-cbciclo','Ciclo','trim|required|exact_length[2]');
            $this->form_validation->set_rules('fm-cbturno','Turno','trim|required|alpha');
            $this->form_validation->set_rules('fm-cbseccion','Sección','trim|required|alpha');
            $this->form_validation->set_rules('fm-txtcuota','Cuota','trim|required');

            $this->form_validation->set_rules('fm-txtfecmatricula','Fec. Nac.','trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $dataex['msgc'] = validation_errors();
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
            }
            else
            {
                $dataex['msg'] ="Matrícula NO registrada";
                $dataex['status'] =FALSE;
                $fmtxtid=base64url_decode($this->input->post('fm-txtid'));
                $fmcbtipo=$this->input->post('fm-cbtipo');
                $fmcbbeneficio=$this->input->post('fm-cbbeneficio');
                $fmcbperiodo=$this->input->post('fm-cbperiodo');
                $fmtxtcarrera=$this->input->post('fm-txtcarrera');
                $fmcbplan=$this->input->post('fm-cbplan');
                $fmtxtplan=$this->input->post('fm-txtplan');
                $fmcbciclo=$this->input->post('fm-cbciclo');
                $fmcbturno=$this->input->post('fm-cbturno');
                $fmcbseccion=$this->input->post('fm-cbseccion');
                $fmtxtfecmatricula=$this->input->post('fm-txtfecmatricula');
                $fmtxtcuota=$this->input->post('fm-txtcuota');
                $fmtxtobservaciones=strtoupper($this->input->post('fm-txtobservaciones'));

                $fmtapepaterno=$this->input->post('fm-txtmapepat');
                $fmtapematerno=$this->input->post('fm-txtmapemat');
                $fmtnombres=$this->input->post('fm-txtmnombres');
                $fmtsexo=$this->input->post('fm-txtmsexo');
                
                    //@vcodigoinscripcion, @vmt_tipo, @vcodigobeneficio, @vcodigoperiodo, @vcodigocarrera, @vcodigociclo, @vcodigoturno, @vcodigoseccion, @vmtr_cuotapension, @vcodigoestado, @vmtr_fecha
                //if($fmtxtplan=="0"){
                    $this->load->model('minscrito');
                    $newcod=$this->minscrito->m_update_asignarplan(array($fmtxtid,$fmcbperiodo,$fmcbplan));
                //}
                if ($fmtxtfecmatricula=="0") $fmtxtfecmatricula= date("Y-m-d H:i:s");   
                $rsrow=$this->mmatricula->m_insert(array($fmtxtid,$fmcbtipo,$fmcbbeneficio,$fmcbperiodo,$fmtxtcarrera,$fmcbciclo,$fmcbturno,$fmcbseccion,$fmtxtcuota,1,$fmtxtfecmatricula,$fmtxtobservaciones,$fmcbplan,$fmtapepaterno,$fmtapematerno,$fmtnombres,$fmtsexo));
                $newcod=$rsrow->newcod;
                $rs=$rsrow->rs;
                $dataex['newcod'] =$rs;
                if ($rs==0){
                    
                    $dataex['msg'] ="El Alumno ya se encuentra matriculado";
                }
                elseif ($rs==-1) {
                    
                    $dataex['msg'] ="El Alumno no pudo ser matriculado consulte el sw_log";
                }
                else{
                    $dataex['status'] =TRUE;
                    $dataex['msg'] ="Matrícula registrada correctamente";
                    $dataex['newcod'] =$newcod;
                    $this->load->model('mcargaacademica');
                    $idsede = $_SESSION['userActivo']->idsede;
                    $cargas=$this->mcargaacademica->m_get_carga_por_grupo(array($fmcbperiodo,$fmtxtcarrera,$fmcbciclo,$fmcbturno,$fmcbseccion,$idsede));
                    $this->load->model('mmiembros');
                    $this->mmiembros->m_auto_insert($cargas,$newcod);
                    $cursos=$this->mmatricula->m_miscursos_x_matricula(array($newcod));
                    $dataex['vdata'] =$cursos;
                }
            }

        }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_cambiarestado()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('ce-idmat','Id Matrícula','trim|required');
            
            $this->form_validation->set_rules('ce-nestado','Estado','trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
            }
            else
            {
                $dataex['msg'] ="Cambio NO realizado";
                $dataex['status'] =FALSE;
                $ceidmat=base64url_decode($this->input->post('ce-idmat'));
                $cenestado=base64url_decode($this->input->post('ce-nestado'));
                    
                $newcod=$this->mmatricula->m_cambiar_estado(array($ceidmat,$cenestado));
                if ($newcod==1){
                    $dataex['status'] =TRUE;
                    $dataex['msg'] ="Cambio registrado correctamente";
                    
                }
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_eliminar()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('ce-idmat','Id Matrícula','trim|required');
            

            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
            }
            else
            {
                $dataex['msg'] ="No se elimino la matrícula, primero compruebe que el alumno no tenga cursos asignados o notas registradas";
                $dataex['status'] =FALSE;
                $ceidmat=base64url_decode($this->input->post('ce-idmat'));
                    
                $newcod=$this->mmatricula->m_eliminar(array($ceidmat));
                if ($newcod==1){
                    $dataex['status'] =TRUE;
                    $dataex['msg'] ="Cambio registrado correctamente";
                    
                }
            }

        }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_filtrar()
    {
        $this->form_validation->set_message('required', '%s Requerido');
    
        $dataex['status'] =FALSE;
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['status'] = false;
        if ($this->input->is_ajax_request())
        {
            $dataex['vdata'] =array();
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $dataex['msg']="jajaajj";
            $fmcbperiodo=$this->input->post('fmt-cbperiodo');
            $fmcbcarrera=$this->input->post('fmt-cbcarrera');
            $fmcbciclo=$this->input->post('fmt-cbciclo');
            $fmcbturno=$this->input->post('fmt-cbturno');
            $fmcbseccion=$this->input->post('fmt-cbseccion');
            $fmcbplan=$this->input->post('fmt-cbplan');
            $fmalumno=$this->input->post('fmt-alumno');

            $cuentas=$this->mmatricula->m_filtrar(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,'%'.$fmalumno.'%'));
            $dataex['vdata'] =$cuentas;
            $dataex['status'] = true;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_filtrar_cur_ad()
    {
        $this->form_validation->set_message('required', '%s Requerido');
    
        $dataex['status'] =FALSE;
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['status'] = false;
        if ($this->input->is_ajax_request())
        {
            $dataex['vdata'] =array();
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

               $dataex['msg']="jajaajj";
                $fmcbperiodo=$this->input->post('fmt-cbperiodo');
                $fmcbcarrera=$this->input->post('fmt-cbcarrera');
                $fmcbciclo=$this->input->post('fmt-cbciclo');
                $fmcbturno=$this->input->post('fmt-cbturno');
                $fmcbseccion=$this->input->post('fmt-cbseccion');
                $fmalumno=$this->input->post('fmt-alumno');
                
                $cuentas=$this->mmatricula->m_filtrar_cur_ad(array($fmcbperiodo,$fmcbcarrera,$fmcbciclo,$fmcbturno,$fmcbseccion,'%'.$fmalumno.'%'));
                $dataex['vdata'] =$cuentas;
                $dataex['status'] = true;
            
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function pdf_ficha_matricula($codmatricula)
    {

        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        $codmatricula=base64url_decode($codmatricula);
        //$carne=base64url_decode($carne);

        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();

        $inscs=$this->mmatricula->m_get_matricula_pdf(array($codmatricula));
        foreach ($inscs as $insc) {

            $cursos=$this->mmatricula->m_miscursos_x_matricula(array($codmatricula));
            $dominio=str_replace(".", "_",getDominio());
            $html1=$this->load->view('matricula/rp_fichamatricula_'.$dominio, array('ies' => $ie,'mat' => $insc,'curs'=>$cursos ),true);
             
            $pdfFilePath = "FICHA MATRÍCULA ".$insc->carne.".pdf";

            $this->load->library('M_pdf');
            $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
            $mpdf->SetTitle( "FICHA MATRÍCULA ".$insc->carne);
            
            $mpdf->SetWatermarkImage(base_url().'resources/img/matriculado_'.$dominio.'.png',0.6,"D",array(70,35));

            $mpdf->showWatermarkImage  = true;
            

            //$mpdf->AddPage();
            $mpdf->WriteHTML($html1);
            $mpdf->Output($pdfFilePath, "I");
        }
    }

    public function pdf_boleta_notas($codmatricula)
    {

        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

      $codmatricula=base64url_decode($codmatricula);
      //$carne=base64url_decode($carne);
      
      $this->load->model('miestp');
      $ie=$this->miestp->m_get_datos();

      $insc=$this->mmatricula->m_get_matricula_pdf(array($codmatricula));
      if (!is_null($insc)){
        
          $cursos=$this->mmatricula->m_miscursos_x_matricula(array($codmatricula));
          //$this->load->view('matricula/rp_boleta-notas', array('ies' => $ie,'mats' => $insc,'curs'=>$cursos ));
          $insc1=$insc[0];
          $dominio=str_replace(".", "_",getDominio());
          $html1=$this->load->view('matricula/rp_boleta-notas_'.$dominio, array('ies' => $ie,'mats' => $insc,'curs'=>$cursos ),true);
             
          $pdfFilePath = "BN-".$insc1->paterno." ".$insc1->materno." ".$insc1->nombres." - ".$insc1->ciclol.".pdf";

          $this->load->library('M_pdf');
          //p=normal
          $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [200,200],'orientation' => 'L']); 
          $mpdf->SetTitle( "BN- $insc1->paterno $insc1->materno $insc1->nombres - $insc1->ciclol");
          $mpdf->SetWatermarkImage(base_url().'resources/img/logo_h110.'.getDominio().'.png',0.1,array(50,70),array(80,40));
          $mpdf->showWatermarkImage  = true;
          $mpdf->shrink_tables_to_fit = 1;
          $mpdf->WriteHTML($html1);
          $mpdf->Output($pdfFilePath, "I");
      }
    }

    public function pdf_boletas_notas()
    {
        $matris = stripslashes($_POST['txtmatris']);
        $amatris = explode(",", $matris);
        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        //$codmatricula=base64url_decode($codmatricula);
        //$carne=base64url_decode($carne);
      
        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();

        $insc=$this->mmatricula->m_get_matriculas_pdf($amatris);
        if (!is_null($insc)){
          $cursos=$this->mmatricula->m_miscursos_x_matriculas($amatris);
          //$this->load->view('matricula/rp_boleta-notas', array('ies' => $ie,'mats' => $insc,'curs'=>$cursos ));
          $dominio=str_replace(".", "_",getDominio());
          $html1=$this->load->view('matricula/rp_boleta-notas_'.$dominio, array('ies' => $ie,'mats' => $insc,'curs'=>$cursos ),true);
             
          $pdfFilePath = "BOLETA DE NOTAS GRUPO.pdf";

          $this->load->library('M_pdf');
          //p=normal
          $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [200,200],'orientation' => 'L']); 
          $mpdf->SetTitle( "BOLETA DE NOTAS ");
          $mpdf->SetWatermarkImage(base_url().'resources/img/logo_h110.'.getDominio().'.png',0.1,array(50,70),array(80,40));
          $mpdf->showWatermarkImage  = true;
          $mpdf->WriteHTML($html1);
          //$mpdf->AddPage();
          //$mpdf->WriteHTML($html2);
          $mpdf->Output($pdfFilePath, "D");
      }
     
    }

    public function fn_cursos_x_matricula()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
        $dataex['status'] = false;
        $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
        $cursos=array();
        $matriculado=array();
        $this->form_validation->set_rules('codmatricula', 'Matrícula', 'trim|required');
        if ($this->form_validation->run() == false) {
            $dataex['msg'] = validation_errors();
        } else {
            $codmatricula = base64url_decode($this->input->post('codmatricula'));
            //$matriculado=$this->mmatricula->m_get_matricula_pdf(array($codmatricula));
            $cursos=$this->mmatricula->m_miscursos_x_matricula(array($codmatricula));
            //$cursos=$this->mmatricula->m_cursos_x_matricula(array($codmatricula));
            
            $dataex['status'] = true;
        }
        $dataex['vdata'] = $cursos;
        $dataex['vmatriculado'] = $matriculado;
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_matricula_x_codigo()
    {
        $dataex['status']=false;
        $dataex['msg']="No se ha podido establecer el origen de esta solicitud";
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
            
        $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
        $msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
        $this->form_validation->set_rules('ce-idmat', 'codigo matricula', 'trim|required');

        if ($this->form_validation->run() == FALSE){
            $dataex['msg'] = validation_errors();
        }
        else{

            $planes="<option value='0'>Plan curricular NO DISPONIBLE</option>";

            $estados="<option value='0'>Estados NO DISPONIBLES</option>";

            $codigo = base64url_decode($this->input->post('ce-idmat'));
            $dataex['status'] =true;
            
            $msgrpta = $this->mmatricula->m_filtrar_matriculaxcodigo(array($codigo));
            $msgrpta->id64 = base64url_encode($msgrpta->codigo);
            $msgrpta->idins64 = base64url_encode($msgrpta->codinscripcion);
            $datemat =  new DateTime($msgrpta->fecha);
            $msgrpta->fecha = $datemat->format('Y-m-d');
            $msgrpta->nomalu = $msgrpta->paterno.' '.$msgrpta->materno.' '.$msgrpta->nombres;

            $this->load->model('mplancurricular');
            $rsplanes=$this->mplancurricular->m_get_planes_activos_carrera(array($msgrpta->codcarrera));

            if (count($rsplanes)>0) $planes="<option value='0'>Selecciona el Plan curricular</option>";
            foreach ($rsplanes as $plan) {
                
                $planes=$planes."<option value='$plan->codigo'>$plan->nombre</option>";
          
            }
            $dataex['vplanes'] =$planes;

            $rsestados = $this->mmatricula->m_filtrar_estadoalumno();

            if (count($rsestados)>0) $estados="<option value='0'>Selecciona un estado</option>";
            foreach ($rsestados as $est) {
                
                $estados=$estados."<option value='$est->codigo'>$est->nombre</option>";
          
            }
            $dataex['vestados'] =$estados;
        }
        
        $dataex['matdata'] = $msgrpta;

        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_insert_update_matricula()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('alpha', '* {field} requiere un valor de la lista.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
        $this->form_validation->set_message('exact_length', '* {field} requiere un valor de la lista.');
        
    
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('fm-txtidup','Identificador','trim|required');
            
            $this->form_validation->set_rules('fm-cbtipoup','Modalidad','trim|required');
            $this->form_validation->set_rules('fm-cbbeneficioup','Beneficio','trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('fm-cbplanup','Plan nuevo','trim|required|is_natural_no_zero');
            // $this->form_validation->set_rules('fm-cbperiodoup','Periodo','trim|required|exact_length[5]');
            $this->form_validation->set_rules('fm-txtcarreraup','Carrera','trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('fm-cbcicloup','Ciclo','trim|required|exact_length[2]');
            $this->form_validation->set_rules('fm-cbturnoup','Turno','trim|required|alpha');
            $this->form_validation->set_rules('fm-cbseccionup','Sección','trim|required|alpha');
            $this->form_validation->set_rules('fm-txtcuotaup','Cuota','trim|required');

            $this->form_validation->set_rules('fm-txtfecmatriculaup','Fec. Matricula.','trim|required');
            $this->form_validation->set_rules('fm-cbestadoup','Estado','trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $dataex['msgc'] = validation_errors();
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
            }
            else
            {
                $matstatus = "";
                $dataex['msg'] ="Matrícula NO registrada";
                $dataex['status'] =FALSE;
                $fmtxtidmat64 = $this->input->post('fm-txtidmatriculaup');
                $fmtxtidmat=base64url_decode($fmtxtidmat64);
                $fmtxtid=base64url_decode($this->input->post('fm-txtidup'));
                $fmcbtipo=$this->input->post('fm-cbtipoup');
                $fmcbbeneficio=$this->input->post('fm-cbbeneficioup');
                $fmtxtperiodo = $this->input->post('fm-txtperiodoup');
                $fmcbperiodo=$this->input->post('fm-cbperiodoup');
                $fmtxtcarrera=$this->input->post('fm-txtcarreraup');
                $fmcbplan=$this->input->post('fm-cbplanup');
                $fmtxtplan=$this->input->post('fm-txtplanup');
                $fmcbciclo=$this->input->post('fm-cbcicloup');
                $fmcbturno=$this->input->post('fm-cbturnoup');
                $fmcbseccion=$this->input->post('fm-cbseccionup');
                $fmtxtfecmatricula=$this->input->post('fm-txtfecmatriculaup');
                $fmtxtcuota=$this->input->post('fm-txtcuotaup');
                $fmtxtobservaciones=mb_strtoupper($this->input->post('fm-txtobservacionesup'));

                $fmtxtestado=$this->input->post('fm-cbestadoup');

                $fmtapepaterno=$this->input->post('fm-txtmapepatup');
                $fmtapematerno=$this->input->post('fm-txtmapematup');
                $fmtnombres=$this->input->post('fm-txtmnombresup');
                $fmtsexo=$this->input->post('fm-txtmsexoup');
                
                $this->load->model('minscrito');
                $newcod=$this->minscrito->m_update_asignarplan(array($fmtxtid,$fmtxtperiodo,$fmcbplan));
                
                if ($fmtxtfecmatricula=="0") $fmtxtfecmatricula= date("Y-m-d H:i:s");

                if ($fmtxtidmat64 == "0") {
                    $rsrow=$this->mmatricula->m_insert(array($fmtxtid,$fmcbtipo,$fmcbbeneficio,$fmcbperiodo,$fmtxtcarrera,$fmcbciclo,$fmcbturno,$fmcbseccion,$fmtxtcuota,$fmtxtestado,$fmtxtfecmatricula,$fmtxtobservaciones,$fmcbplan,$fmtapepaterno,$fmtapematerno,$fmtnombres,$fmtsexo));
                    $matstatus = "INSERTAR";
                } else {
                    $rsrow=$this->mmatricula->m_update_matricula_manual(array($fmtxtidmat,$fmtxtid,$fmcbtipo,$fmcbbeneficio,$fmtxtperiodo,$fmtxtcarrera,$fmcbciclo,$fmcbturno,$fmcbseccion,$fmtxtcuota,$fmtxtestado,$fmtxtfecmatricula,$fmtxtobservaciones,$fmcbplan));
                    $matstatus = "EDITAR";
                }
                $newcod=$rsrow->newcod;
                $rs=$rsrow->rs;
                $dataex['newcod'] =$rs;
                if ($rs==0){
                    
                    $dataex['msg'] ="El Alumno ya se encuentra matriculado";
                }
                elseif ($rs==-1) {
                    
                    $dataex['msg'] ="El Alumno no pudo ser matriculado consulte el sw_log";
                }
                else{
                    $dataex['status'] =TRUE;
                    $dataex['msg'] ="Matrícula actualizada correctamente, verificar sus unidades didácticas de ser necesario";
                    $dataex['newcod'] =$newcod;
                    $dataex['matstatus'] = $matstatus;
                    $this->load->model('mcargaacademica');
                    $idsede = $_SESSION['userActivo']->idsede;
                    $cargas=$this->mcargaacademica->m_get_carga_por_grupo(array($fmcbperiodo,$fmtxtcarrera,$fmcbciclo,$fmcbturno,$fmcbseccion,$idsede));
                    if ($fmtxtidmat64 == "0") {
                        $this->load->model('mmiembros');
                        $this->mmiembros->m_auto_insert($cargas,$newcod);
                    }
                    
                    $cursos=$this->mmatricula->m_miscursos_x_matricula(array($newcod));
                    $dataex['vdata'] =$cursos;
                }
            }

        }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_filtrar_inscritos()
    {
        $this->form_validation->set_message('required', '%s Requerido o digite %%%%%%%%');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
        $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
    
        $dataex['status'] =FALSE;
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $rscuentas="";
        $dataex['conteo'] =0;
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('fbus-txtbuscar','búsqueda','trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
            }
            else
            {
                $this->load->model('minscrito');
                $busqueda=$this->input->post('fbus-txtbuscar');
                $carrera="%";
                $periodo="%";
                $turno="%";
                $campania="%";
                $seccion="%";
                $busqueda=str_replace(" ","%",$busqueda);
            
                $cuentas = $this->minscrito->m_filtrar_basico_sd_activa(array($periodo,$campania,$carrera,$turno,$seccion,$_SESSION['userActivo']->idsede,'%'.$busqueda.'%',));
                $dataex['status'] =true;
            }
        }
        $dataex['vdata'] = $cuentas;
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

}
