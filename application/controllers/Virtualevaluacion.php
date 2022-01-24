<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Sendmail.php';
class Virtualevaluacion extends Sendmail{
    function __construct(){
        parent::__construct();
        $this->load->helper("url");
        $this->load->model('mcargasubseccion');
        $this->load->model('mvirtual');
        $this->load->model('mvirtualevaluacion');
        $this->load->model('mauditoria');
    }

    public function vw_virtual_evaluacion_preguntas($codcarga,$division,$codmaterial)
    {
        $usertipo = $_SESSION['userActivo']->tipo;
        if (($usertipo == 'DC') || ($usertipo == 'DA') || ($usertipo == "AD")) {
            $ahead= array('page_title' =>'Preguntas | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $arraymc['vcarga']=$codcarga;
            $arraymc['vdivision']=$division;
            $division=base64url_decode($division);
            $codcarga=base64url_decode($codcarga);
            $codmaterial=base64url_decode($codmaterial);
            
            $arraymc['mat'] = $this->mvirtual->m_get_material(array($codmaterial));
            $this->load->model('mcargasubseccion');
            
            $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            $this->load->model('mmiembros');
            $arraymc['tppreguntas'] = $this->mvirtualevaluacion->m_get_tipo_pregunta();
            
            $arraymc['preguntas'] = $this->mvirtualevaluacion->m_get_preguntas_x_evaluacion(array($codmaterial));
            $rps= $this->mvirtualevaluacion->m_get_respuestas_x_evaluacion(array($codmaterial));
            $respuestas=array();
            foreach ($rps as $key => $rp) {
                $respuestas[$rp->codpregunta][] =$rp;
            }
            $arraymc['respuestas']=$respuestas;
            $arsb['menu_padre']='docaulavirtual';
            $arsb['vcarga']=$codcarga;
            $arsb['vdivision']=$division;
            $this->load->view('docentes/sidebar_curso',$arsb);

            $this->load->view('virtual/vw_aula_evaluacion_preguntas', $arraymc);
        } else {
            $ahead= array('page_title' =>'SIN AUTORIZACIÓN | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
            $this->load->view($vsidebar);
            $this->load->view('errors/vwh_nopermitido');
        }

        $this->load->view('footer');
    }


    public function vw_alumno_virtual_evaluacion($codcarga,$division,$codmaterial,$codmiembro)
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
        //$arraymc['varchivos'] =$this->mvirtual->m_get_detalle_x_material(array($codmaterial));

        $arraymc['tentregada'] = $this->mvirtualevaluacion->m_get_evaluacion_entregada(array($codmaterial,$codmiembro));
        //if (isset($arraymc['tentregada']->codevaluacion))  $arraymc['varchivosevaluacion'] =$this->mvirtualevaluacion->m_get_detalles_x_evaluacion(array($arraymc['tentregada']->codevaluacion));
               
        $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
        $arsb['menu_padre']='alaulavirtual';
         $this->load->view('sidebar_alumno',$arsb);

        $this->load->view('virtual/alumno/vw_aula_evaluacion', $arraymc);
        $this->load->view('footer');
    }

    public function vw_virtual_evaluacion_entregar($codcarga,$division,$codmaterial,$codmiembro)
    {
        $ahead= array('page_title' =>'Evaluación | Plataforma Virtual'  );
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $arraymc['vcarga']=$codcarga;
        $arraymc['vdivision']=$division;
        $arraymc['vcodmiembro']=$codmiembro;
        $codmaterialb64=$codmaterial;
        $division=base64url_decode($division);
        $codcarga=base64url_decode($codcarga);
        $codmaterial=base64url_decode($codmaterial);
        $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
        $arrayrpta = $this->mvirtualevaluacion->m_get_respuestas_entregadas_x_evaluacion(array($codmaterial,base64url_decode($codmiembro)));
        if (isset($arraymc['curso']->codcarga)){
            $mat = $this->mvirtual->m_get_material(array($codmaterial));
            if (isset($mat->codigo)){
                $arraymc['mat']=$mat;
                $arsb['menu_padre']='alaulavirtual';
                $fvence=$mat->vence;
                $finicia=$mat->inicia;
                date_default_timezone_set('America/Lima');
                $timelocal=time();
                $tvencio="NO";
                if ($fvence!=""){
                    $tvencio=(strtotime($fvence)>$timelocal) ? "NO":"SI";
                }
                $tinicio="SI";
                if ($finicia!=""){
                    $tinicio=(strtotime($finicia)<$timelocal) ?"SI":"NO";
                }

                if ($tinicio=="NO"){
                    $urlref=base_url()."alumno/curso/virtual/evaluacion/".$arraymc['vcarga'].'/'.$arraymc['vdivision'].'/'.$codmaterialb64.'/'.$arraymc['vcodmiembro'];
                    var_dump($urlref);
                    header("Location: $urlref", FILTER_SANITIZE_URL);
                } 
                elseif ($tvencio=="SI") {
                    $urlref=base_url()."alumno/curso/virtual/evaluacion/".$arraymc['vcarga'].'/'.$arraymc['vdivision'].'/'.$codmaterialb64.'/'.$arraymc['vcodmiembro'];
                    header("Location: $urlref", FILTER_SANITIZE_URL);
                }
                elseif (count($arrayrpta) > 0) {
                    $urlref=base_url()."alumno/curso/virtual/evaluacion/".$arraymc['vcarga'].'/'.$arraymc['vdivision'].'/'.$codmaterialb64.'/'.$arraymc['vcodmiembro'];
                    header("Location: $urlref", FILTER_SANITIZE_URL);
                }
                else{
                    $arraymc['preguntas'] = $this->mvirtualevaluacion->m_get_preguntas_x_evaluacion(array($codmaterial));
                    $rps= $this->mvirtualevaluacion->m_get_respuestas_x_evaluacion_a_ciegas(array($codmaterial));
                    $respuestas=array();
                    foreach ($rps as $key => $rp) {
                        $respuestas[$rp->codpregunta][] =$rp;
                    }
                    $arraymc['respuestas']=$respuestas;

                    $this->load->view('sidebar',$arsb);

                    $this->load->view('virtual/alumno/vw_aula_evaluacion_entregar', $arraymc);
                    $this->load->view('footer');
                }

            }
        }
    }

    public function vw_virtual_evaluacion_entregada($codcarga,$division,$codmaterial,$codmiembro)
    {
        $ahead= array('page_title' =>'Admisión | IESTWEB'  );
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $arraymc['vcarga']=$codcarga;
        $arraymc['vdivision']=$division;
        $arraymc['vcodmiembro']=$codmiembro;
        $codmaterialb64=$codmaterial;
        $division=base64url_decode($division);
        $codcarga=base64url_decode($codcarga);
        $codmaterial=base64url_decode($codmaterial);
        $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
        if (isset($arraymc['curso']->codcarga)){
            $mat = $this->mvirtual->m_get_material(array($codmaterial));
            if (isset($mat->codigo)){
                $arraymc['mat']=$mat;
                $arsb['menu_padre']='alaulavirtual';
                $fvence=$mat->vence;
                $finicia=$mat->inicia;
                date_default_timezone_set('America/Lima');
                $timelocal=time();
                $tvencio="NO";
                if ($fvence!=""){
                    $tvencio=(strtotime($fvence)>$timelocal) ? "NO":"SI";
                }
                $tinicio="SI";
                if ($finicia!=""){
                    $tinicio=(strtotime($finicia)<$timelocal) ?"SI":"NO";
                }

                if ($tinicio=="NO"){
                    $urlref=base_url()."alumno/curso/virtual/evaluacion/".$arraymc['vcarga'].'/'.$arraymc['vdivision'].'/'.$codmaterialb64.'/'.$arraymc['vcodmiembro'];
                    var_dump($urlref);
                    header("Location: $urlref", FILTER_SANITIZE_URL);
                } 
                elseif ($tvencio=="SI") {
                    //$urlref=base_url()."alumno/curso/virtual/evaluacion/".$arraymc['vcarga'].'/'.$arraymc['vdivision'].'/'.$codmaterialb64.'/'.$arraymc['vcodmiembro'];
                    //header("Location: $urlref", FILTER_SANITIZE_URL);
                }
                else{
                    $arraymc['preguntas'] = $this->mvirtualevaluacion->m_get_preguntas_x_evaluacion(array($codmaterial));
                    $rps= $this->mvirtualevaluacion->m_get_respuestas_x_evaluacion_a_ciegas(array($codmaterial));
                    $respuestas=array();
                    foreach ($rps as $key => $rp) {
                        $respuestas[$rp->codpregunta][] =$rp;
                    }
                    $arraymc['respuestas']=$respuestas;

                    $this->load->view('sidebar',$arsb);

                    $this->load->view('virtual/alumno/vw_aula_evaluacion_entregar', $arraymc);
                    $this->load->view('footer');
                }

            }
        }
    }

    public function vw_virtual_evaluacion_revisado($codcarga,$division,$codmaterial,$codmiembro)
    {
        $ahead= array('page_title' =>'Admisión | IESTWEB'  );
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $arraymc['vcarga']=$codcarga;
        $arraymc['vdivision']=$division;
        $arraymc['vcodmiembro']=$codmiembro;
        if (($_SESSION['userActivo']->tipo == 'AD') || ($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'DC')) {
            $codmaterialb64=$codmaterial;
            $division=base64url_decode($division);
            $codcarga=base64url_decode($codcarga);
            $codmaterial=base64url_decode($codmaterial);
            $dcodmiembro=base64url_decode($codmiembro);
            $this->load->model('mmiembros');
            $miembro = $this->mmiembros->m_get_miembros_codigo_carga_division(array($codcarga,$division,$dcodmiembro));
            if (isset($miembro->codmatricula)){
                $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
                if (isset($arraymc['curso']->codcarga)){
                    $arraymc['miembro']=$miembro;
                    $mat = $this->mvirtual->m_get_material(array($codmaterial));
                    if (isset($mat->codigo)){
                        $arraymc['mat']=$mat;
                        $arsb['menu_padre']='alaulavirtual';
                        $fvence=$mat->vence;
                        $finicia=$mat->inicia;
                        date_default_timezone_set('America/Lima');
                        $pgts= $this->mvirtualevaluacion->m_get_preguntas_x_evaluacion(array($codmaterial));
                        $rps= $this->mvirtualevaluacion->m_get_respuestas_x_evaluacion(array($codmaterial));
                        $rpse= $this->mvirtualevaluacion->m_get_respuestas_entregadas_x_evaluacion(array($codmaterial,$dcodmiembro));
                        $respuestas=array();
                        $ntotal=0;
                        foreach ($pgts as $kpg => $pgt) {
                            $pgt->rpts=array();
                            $pgt->puntos=0;
                            $pgt->correcta="NO";
                            $pgt->codrptaentregada=0;

                            if ($pgt->codtipo==7){
                                $pgt->correcta="--";
                                $pgt->texto="-Sin Respuesta-";
                                foreach ($rpse as $krpse => $rpe) {
                                    if (($pgt->codpregunta==$rpe->codpregunta)){
                                        $pgt->codrptaentregada=$rpe->codrptaentregada;
                                        $pgt->texto=$rpe->texto;
                                        $pgt->puntos=$rpe->puntos;
                                        unset($rpse[$krpse]);
                                    }
                                }
                            }
                            elseif ($pgt->codtipo==4) {
                                # code...
                            }
                            else{
                                foreach ($rps as $krp => $rp) {
                                    if ($rp->codpregunta==$pgt->codpregunta){
                                        $rp->marcada="NO";
                                        foreach ($rpse as $krpse => $rpe) {
                                            if (($rp->codpregunta==$rpe->codpregunta) && ($rp->codrpta==$rpe->codrpta)){
                                                $rp->marcada="SI";
                                                if ($rp->correcta=="SI"){
                                                    $pgt->correcta="SI";
                                                }
                                                $pgt->puntos=$rpe->puntos;
                                                
                                                unset($rpse[$krpse]);
                                            }
                                        }
                                        $pgt->rpts[]=$rp;
                                    }
                                } 
                            }
                            $ntotal= $ntotal + $pgt->puntos;
                        }
                        $arraymc['preguntas']=$pgts;
                        $arraymc['ntotal']=$ntotal;
                        $arsb['menu_padre']='docaulavirtual';
                        $arsb['vcarga']=$codcarga;
                        $arsb['vdivision']=$division;
                        $this->load->view('docentes/sidebar_curso',$arsb);

                        $this->load->view('virtual/vw_aula_evaluacion_revisado', $arraymc);
                        $this->load->view('footer');
            

                    }
                }
            }
            else{
                $this->load->view('sidebar_alumno');
                $this->load->view('errors/vwh_nopermitido');
                $this->load->view('footer');
            }
        }
        else{
            $this->load->view('sidebar_alumno');
            $this->load->view('errors/vwh_nopermitido');
            $this->load->view('footer');
        }
    }

    public function vw_virtual_evaluacion_alumno_revisado($codcarga,$division,$codmaterial,$codmiembro)
    {
        $ahead= array('page_title' =>'Admisión | IESTWEB'  );
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $arraymc['vcarga']=$codcarga;
        $arraymc['vdivision']=$division;
        $arraymc['vcodmiembro']=$codmiembro;
        //if (($_SESSION['userActivo']->tipo == 'AD') || ($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'DC')) {
            $codmaterialb64=$codmaterial;
            $division=base64url_decode($division);
            $codcarga=base64url_decode($codcarga);
            $codmaterial=base64url_decode($codmaterial);
            $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            if (isset($arraymc['curso']->codcarga)){
                $mat = $this->mvirtual->m_get_material(array($codmaterial));
                if (isset($mat->codigo)){
                    $arraymc['mat']=$mat;
                    $arsb['menu_padre']='alaulavirtual';
                    $fvence=$mat->vence;
                    $finicia=$mat->inicia;
                    date_default_timezone_set('America/Lima');
                    $timelocal=time();
                    $tvencio="NO";
                    if ($fvence!=""){
                        $tvencio=(strtotime($fvence)>$timelocal) ? "NO":"SI";
                    }
                    $tinicio="SI";
                    if ($finicia!=""){
                        $tinicio=(strtotime($finicia)<$timelocal) ?"SI":"NO";
                    }

                    if ($tinicio=="NO"){
                        $urlref=base_url()."alumno/curso/virtual/evaluacion/".$arraymc['vcarga'].'/'.$arraymc['vdivision'].'/'.$codmaterialb64.'/'.$arraymc['vcodmiembro'];
                        var_dump($urlref);
                        header("Location: $urlref", FILTER_SANITIZE_URL);
                    } 
                    elseif ($tvencio=="SI") {
                        $pgts= $this->mvirtualevaluacion->m_get_preguntas_x_evaluacion(array($codmaterial));
                        $rps= $this->mvirtualevaluacion->m_get_respuestas_x_evaluacion(array($codmaterial));
                        $rpse= $this->mvirtualevaluacion->m_get_respuestas_entregadas_x_evaluacion(array($codmaterial,base64url_decode($codmiembro)));
                        $respuestas=array();
                        $ntotal=0;
                        foreach ($pgts as $kpg => $pgt) {
                            $pgt->rpts=array();
                            $pgt->puntos=0;
                            $pgt->correcta="NO";

                            if ($pgt->codtipo==7){
                                $pgt->correcta="--";
                                $pgt->texto="-Sin Respuesta-";
                                foreach ($rpse as $krpse => $rpe) {
                                    if (($pgt->codpregunta==$rpe->codpregunta)){
                                        $pgt->texto=$rpe->texto;
                                        $pgt->puntos=$rpe->puntos;
                                        unset($rpse[$krpse]);
                                    }
                                }
                            }
                            elseif ($pgt->codtipo==4) {
                                # code...
                            }
                            else{
                                foreach ($rps as $krp => $rp) {
                                    if ($rp->codpregunta==$pgt->codpregunta){
                                        $rp->marcada="NO";
                                        foreach ($rpse as $krpse => $rpe) {
                                            if (($rp->codpregunta==$rpe->codpregunta) && ($rp->codrpta==$rpe->codrpta)){
                                                $rp->marcada="SI";
                                                if ($rp->correcta=="SI"){
                                                    $pgt->correcta="SI";
                                                }
                                                $pgt->puntos=$rpe->puntos;
                                                
                                                unset($rpse[$krpse]);
                                            }
                                        }
                                        $pgt->rpts[]=$rp;
                                    }
                                } 
                            }
                            $ntotal= $ntotal + $pgt->puntos;
                        }
                        $arraymc['preguntas']=$pgts;
                        $arraymc['ntotal']=$ntotal;
                        $arsb['menu_padre']='docaulavirtual';
                        $arsb['vcarga']=$codcarga;
                        $arsb['vdivision']=$division;
                        $this->load->view('sidebar_alumno',$arsb);

                        $this->load->view('virtual/alumno/vw_aula_evaluacion_revisado', $arraymc);
                        $this->load->view('footer');

                       
                    }
                    else{
                        $pgts= $this->mvirtualevaluacion->m_get_preguntas_x_evaluacion(array($codmaterial));
                        $rps= $this->mvirtualevaluacion->m_get_respuestas_x_evaluacion(array($codmaterial));
                        $rpse= $this->mvirtualevaluacion->m_get_respuestas_entregadas_x_evaluacion(array($codmaterial,base64url_decode($codmiembro)));
                        $respuestas=array();
                        $ntotal=0;
                        foreach ($pgts as $kpg => $pgt) {
                            $pgt->rpts=array();
                            $pgt->puntos=0;
                            $pgt->correcta="NO";

                            if ($pgt->codtipo==7){
                                $pgt->correcta="--";
                                $pgt->texto="-Sin Respuesta-";
                                foreach ($rpse as $krpse => $rpe) {
                                    if (($pgt->codpregunta==$rpe->codpregunta)){
                                        $pgt->texto=$rpe->texto;
                                        $pgt->puntos=$rpe->puntos;
                                        unset($rpse[$krpse]);
                                    }
                                }
                            }
                            elseif ($pgt->codtipo==4) {
                                # code...
                            }
                            else{
                                foreach ($rps as $krp => $rp) {
                                    if ($rp->codpregunta==$pgt->codpregunta){
                                        $rp->marcada="NO";
                                        foreach ($rpse as $krpse => $rpe) {
                                            if (($rp->codpregunta==$rpe->codpregunta) && ($rp->codrpta==$rpe->codrpta)){
                                                $rp->marcada="SI";
                                                $pgt->puntos=$rpe->puntos;
                                                unset($rpse[$krpse]);
                                            }
                                        }
                                        $pgt->rpts[]=$rp;
                                    }
                                } 
                            }
                            $ntotal= $ntotal + $pgt->puntos;
                        }
                        $arraymc['preguntas']=$pgts;
                        $arraymc['ntotal']=$ntotal;
                        $arsb['menu_padre']='docaulavirtual';
                        $arsb['vcarga']=$codcarga;
                        $arsb['vdivision']=$division;
                        $this->load->view('sidebar_alumno',$arsb);

                        $this->load->view('virtual/alumno/vw_aula_evaluacion_entregado', $arraymc);
                        $this->load->view('footer');
                    }

                }
            }
        /*}
        else{
            $this->load->view('sidebar_alumno');
            $this->load->view('errors/vwh_nopermitido');
            $this->load->view('footer');
        }*/
    }


    public function vw_virtual_evaluacion_entregas($codcarga,$division,$codmaterial)
    {
        
        $ahead= array('page_title' =>'Admisión | IESTWEB'  );
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $arraymc['vcarga']=$codcarga;
        $arraymc['vdivision']=$division;
        if (($_SESSION['userActivo']->tipo == 'AD') || ($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'DC')) {
            $division=base64url_decode($division);
            $codcarga=base64url_decode($codcarga);
            $codmaterial=base64url_decode($codmaterial);
            
            $arraymc['mat'] = $this->mvirtual->m_get_material(array($codmaterial));
            $this->load->model('mcargasubseccion');
            
            
            $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            $this->load->model('mmiembros');
            $arraymc['miembros'] = $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
            $this->load->model('mvirtualalumno');
            $arraymc['entregas'] = $this->mvirtualevaluacion->m_get_evaluaciones_entregadas($codmaterial);
            $arraymc['rptxrev'] = $this->mvirtualevaluacion->m_get_respuestas_x_revisar_x_evaluacion($codmaterial);
            
            
            $arsb['menu_padre']='docaulavirtual';
            $arsb['vcarga']=$codcarga;
            $arsb['vdivision']=$division;
            $this->load->view('docentes/sidebar_curso',$arsb);

            $this->load->view('virtual/vw_aula_evaluacion_entregas', $arraymc);
        }
        else{
            $this->load->view('sidebar_alumno');
            $this->load->view('errors/vwh_nopermitido');
        }
        
        $this->load->view('footer');
    }

    public function vw_virtual_evaluacion_editar($codcarga,$division,$codmaterial,$codmiembro)
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
        $arraymc['tentregada'] = $this->mvirtualevaluacion->m_get_evaluacion_entregada(array($codmaterial,$codmiembro));
        $arraymc['varchivosevaluacion'] =array();
        if (isset($arraymc['tentregada']->codevaluacion))  $arraymc['varchivosevaluacion'] =$this->mvirtualevaluacion->m_get_detalles_x_evaluacion(array($arraymc['tentregada']->codevaluacion));
        //$arraymc['agregar'] = $this->load->view('virtual/vw_aula_evaluacion',$arraymt,true);
        $arsb['menu_padre']='alaulavirtual';
        $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
        $this->load->view('sidebar',$arsb);

        $this->load->view('virtual/alumno/vw_aula_evaluacion_entregar', $arraymc);
        $this->load->view('footer');
    }

    public function vw_docente_virtual_evaluacion($codcarga,$division,$codmaterial)
    {
        
        if (($_SESSION['userActivo']->tipo == 'AD') || ($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'DC')) {

           
            $arraymc['vcarga']=$codcarga;
            $arraymc['vdivision']=$division;
            $division=base64url_decode($division);
            $codcarga=base64url_decode($codcarga);
            $codmaterial=base64url_decode($codmaterial);
            $arsb['menu_padre']='docaulavirtual';
            $arsb['vcarga']=$codcarga;
            $arsb['vdivision']=$division;
           
            $material= $this->mvirtual->m_get_material(array($codmaterial));
            if (isset($material->codigo)){
                $this->load->model('mcargasubseccion');
                $arraymc['varchivos'] =$this->mvirtual->m_get_detalle_x_material(array($codmaterial));
                $arraymc['conteos'] =$this->mvirtualevaluacion->m_get_count_entregas_x_evaluacion(array($codmaterial));
                
                $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
                $arraymc['nmiembros'] = $this->mcargasubseccion->m_get_nro_alumnos_carga_subseccion(array($codcarga,$division));
                $arraymc['mat'] = $material;
                $ahead= array('page_title' =>$material->nombre.' - Aula Virtual | ERP'  );
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                $this->load->view('docentes/sidebar_curso',$arsb);
                $this->load->view('virtual/vw_aula_evaluacion', $arraymc);
            }
            else{

                $this->load->view('errors/vwh_nopermitido');
            }
            
        } else {
            $ahead= array('page_title' =>'Aula Virtual | ERP'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $this->load->view('sidebar_alumno');
            $this->load->view('errors/vwh_nopermitido');
        }
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
                
                $vid          = 0;
                

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
                    $data=array($ventrega,$vdetalle,$vidcurso,$vdivision,$vnrofiles,$vidmiembro,$vidmaterial);
                    $rpta = $this->mvirtualevaluacion->m_insert($data);
                    //if (($vtipo=="A") || ($vtipo=="T")|| ($vtipo=="F")){
                        $datafile= json_decode($_POST['afiles']);
                        foreach ($datafile as $value) {
                            if (trim($value[0])==""){
                                $filesnoup[]=$value[1];
                            }
                            else{
                                if (file_exists ("upload/".$value[0])){
                                    $rpta2 = $this->mvirtualevaluacion->m_insert_detalle(array($rpta->nid,$value[0],$value[1],$value[2],$value[3],$vidcurso,$vdivision));
                                }
                                else{
                                        $filesnoup[]=$value[1];
                                }
                            }
                        }
                    //}

                    if ($rpta->salida=='1'){
                        $dataex['status'] =true;
                        $dataex['newid'] =$rpta->nid;
                        
                        $dataex['redirect']=base_url()."alumno/curso/virtual/evaluacion/".$this->input->post('vidcurso').'/'.$this->input->post('vdivision').'/'.base64url_encode($vidmaterial).'/'.base64url_encode($vidmiembro);
                    }
                }
                else{
                    //update
                    $data=array($ventrega,$vdetalle,$vidcurso,$vdivision,$vnrofiles,$vid);
                    $rpta = $this->mvirtualevaluacion->m_update($data);
                    //if (($vtipo=="A") || ($vtipo=="T") || ($vtipo=="F")){
                        $datafile= json_decode($_POST['afiles']);
                        foreach ($datafile as $value) {
                            if ($value[3]==0){
                                if (trim($value[0])==""){
                                    $filesnoup[]=$value[1];
                                }
                                else{
                                    if (file_exists ("upload/".$value[0])){
                                        $rpta2 = $this->mvirtualevaluacion->m_insert_detalle(array($vid,$value[0],$value[1],$value[2],$value[3],$vidcurso,$vdivision));
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
                        $dataex['status'] =true;
                        $dataex['newid'] =$vid;
                         $dataex['redirect']=base_url()."alumno/curso/virtual/evaluacion/".$this->input->post('vidcurso').'/'.$this->input->post('vdivision').'/'.base64url_encode($vidmaterial).'/'.base64url_encode($vidmiembro);
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

    public function fn_calificar_respuesta()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural', '* {field} requiere un nímero entero');
        
    
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('crcodrpalum','Respuesta Alumno','trim|required');
            $this->form_validation->set_rules('crcodpg','Pregunta','trim|required');
            $this->form_validation->set_rules('crcodevalalum','Examen Alumno','trim|required');
            $this->form_validation->set_rules('crpuntos','Puntos','trim|numeric');
            
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
                $crcodrpalum=base64url_decode($this->input->post('crcodrpalum'));
                $crcodpg=base64url_decode($this->input->post('crcodpg'));
                $crcodevalalum=base64url_decode($this->input->post('crcodevalalum'));
                $crpuntos=$this->input->post('crpuntos');

                //CALL ``( @codrpalum, @codpg, @codevalum, @vpuntos, @s, @nid);
                $dataex['msg']="Ocurrio un error";
                $filarp=$this->mvirtualevaluacion->m_calificar_respuesta(array($crcodrpalum,$crcodpg,$crcodevalalum,$crpuntos));
                if ($filarp->salida=='1'){
                    $dataex['status'] =TRUE;
                    $dataex['msg']=$filarp;
                }elseif ($filarp->salida=='0') {
                    $dataex['msg']="Puntuación excedida";
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_recalificar_respuesta()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural', '* {field} requiere un nímero entero');
        
    
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('codrptalum','Respuesta Alumno','trim|required');
            $this->form_validation->set_rules('codpg','Pregunta','trim|required');
            //$this->form_validation->set_rules('codmaterial','Examen','trim|required');
            $this->form_validation->set_rules('crpuntos','Puntos','trim|numeric');
            $this->form_validation->set_rules('codmiembro','Miembro','trim|required');
            
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
                $codmiembro=base64url_decode($this->input->post('codmiembro'));
                $codpg=base64url_decode($this->input->post('codpg'));
                $crcodrpalum=base64url_decode($this->input->post('codrptalum'));
                
                $codevalalum=base64url_decode($this->input->post('codevalalum'));
                $crpuntos=$this->input->post('crpuntos');

                //CALL ``( @codrpalum, @codpg, @codevalum, @vpuntos, @s, @nid);
                $dataex['msg']="Ocurrio un error";
                $filarp=$this->mvirtualevaluacion->m_recalificar_respuesta(array($codmiembro,$codpg,$crcodrpalum,$crpuntos));
                if ($filarp->salida=='1'){
                    $dataex['status'] =TRUE;
                    $dataex['nota'] =floatval($filarp->nota);
                    
                }elseif ($filarp->salida=='0') {
                    $dataex['status'] =TRUE;
                    $dataex['msg']="Puntuación excedida";
                    $dataex['nota']=-1;
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }


    //CALL `sp_tb_virtual_pregunta_insert`( @vcodmaterial, @vcodagrupador, @vcodtipopreg, @vevpg_posicion, @vevpg_enunciado, @vevpg_enunciado_extra, @vevpg_imagen, @vevpg_rpta, @vevpg_valor_max, @vevpg_permite_vacio, @vevpg_penalidad_vacio_pts, @vevpg_penalidad_error_pts, @`s`, @`nid`);

    public function fn_guarda_pegunta()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural', '* {field} requiere un nímero entero');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            if (($_SESSION['userActivo']->tipo == 'AD') || ($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'DC')) {
                $this->form_validation->set_rules('pg-enunciado','Enunciado','trim|required');
                $this->form_validation->set_rules('pg-tipo','Tipo','trim|required');
                $this->form_validation->set_rules('pg-codpg','Pregunta','trim|required');
                if ($this->form_validation->run() == FALSE)
                {
                    $dataex['msg']="Existen errores en los campos";
                    $errors = array();
                    foreach ($this->input->post() as $key => $value){
                        $errors[$key] = form_error($key);
                    }
                    $dataex['errors'] = array_filter($errors);
                    $dataex['msgv']=validation_errors();
                }
                else
                {
                    $palmgactual="";
                    $dataex['msg']    = 'Error al Guardar';
                   
                    $pgpos=$this->input->post('pg-pos');
                    
                    $pgtipo=$this->input->post('pg-tipo');



                    $pgenunciado=addslashes($this->input->post('pg-enunciado'));
                    $pgdescripcion=addslashes($this->input->post('pg-descripcion'));


                    $pgvalor=$this->input->post('pg-valor');
                    $pgcodpg=$this->input->post('pg-codpg');
                    $pgobligatoria="NO";
                    if ($this->input->post('pg-obligatoria')!==null){
                         $pgobligatoria=$this->input->post('pg-obligatoria');
                    }
                    $pgvalvacia=$this->input->post('pg-valvacia');
                    $pgvalerror=$this->input->post('pg-valerror');
                    $pgmaterial=base64url_decode($this->input->post('pg-material'));
                    $pgagrupador=$this->input->post('pg-agrupador');
                    $pgimgactual=$this->input->post('pg-imgactual');
                    $sin_imagen=$this->input->post('pg-imgeliminar');
                    $respuestas= json_decode($_POST['rptas']);

                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;
                    
                    $imagen_a_guardar = $pgimgactual;
                    if ($sin_imagen=="SI"){
                        $imagen_a_guardar="";
                    }

                    $filarp="-1";
                    $pgmaterialConCeros="m".str_pad($pgmaterial, 11, "0", STR_PAD_LEFT);
                    $pgcarpeta = "./upload/aulavirtual/evaluaciones/$pgmaterialConCeros/";
                    if (!file_exists($pgcarpeta)) {
                        mkdir($pgcarpeta, 0777, true);
                        mkdir($pgcarpeta.'thumb/', 0777, true);
                        
                    }
                    date_default_timezone_set ('America/Lima');
                    $subio_imagen=FALSE;
                    if ($_FILES['pg-image']['name']!="") {
                        $dataex['msgimagen'] ="se recibio imagen";
                        
                        $aleatorio = mt_rand(100,999);
                        $path = $_FILES['pg-image']['name'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        //COMPROBAR CARPETA
                        
                        
                        $pgimgnombre=  "p".$pgmaterialConCeros.$aleatorio.date("d") . date("m") . date("Y") . date("H") . date("i") .".".$ext;
                        
                        $config = [
                            "upload_path"   => $pgcarpeta,
                            'allowed_types' => "png|jpg|JPG|jpeg|JPEG",
                            'file_name' => $pgimgnombre,
                        ];

                        $this->load->library("upload", $config);

                        if ($this->upload->do_upload('pg-image')) {
                            $sizes=getimagesize($pgcarpeta.$pgimgnombre);
                            $anchot=$sizes[0];
                            $altot=$sizes[1];
                            if ($sizes[1]>600){
                                $anchot=600;
                                $altot=600;
                            }

                            $data  = array("upload_data" => $this->upload->data());
                            $config2['image_library'] = 'gd2';
                            $config2['source_image'] =  $pgcarpeta.$pgimgnombre;
                            $config2['new_image'] = $pgcarpeta.'thumb/'.$pgimgnombre;
                            $config2['create_thumb'] = FALSE;
                            $config2['maintain_ratio'] = TRUE;
                            $config2['quality'] = '85%';
                            $config2['width'] = $anchot;
                            $config2['height'] = $altot;
                            //$config2['thumb_marker'] = 600;
                            
                            $this->load->library('image_lib', $config2);
                            $this->image_lib->resize();
                            $subio_imagen=TRUE;
                            $imagen_a_guardar=$pgimgnombre;
                        }
                        
                    }

                    foreach ($respuestas as $key => $rpta) {

                        if (($rpta[7]!="")){
                            //COPIA ORIGINAL
                            $rporigen="./upload/aulavirtual/evaluaciones/temp/".$rpta[7];
                            $rpdestino="./upload/aulavirtual/evaluaciones/$pgmaterialConCeros/".$rpta[7];
                            copy($rporigen, $rpdestino);
                            //COPIAR THUMB
                            $rporigen="./upload/aulavirtual/evaluaciones/temp/th".$rpta[7];
                            $rpdestino="./upload/aulavirtual/evaluaciones/$pgmaterialConCeros/thumb/".$rpta[7];
                            copy($rporigen, $rpdestino);
                        }
                        elseif(($rpta[4]!="") && ($rpta[6]=="NO")){
                            $respuestas[$key][7]=$rpta[4];
                        }
                    }
                    

                    if ($pgcodpg=="0"){
                        $filarp=$this->mvirtualevaluacion->m_insert_pregunta(array( $pgmaterial, $pgagrupador, $pgtipo, $pgpos, $pgenunciado, $pgdescripcion, $imagen_a_guardar, null, $pgvalor, $pgobligatoria, $pgvalvacia, $pgvalerror),$respuestas);
                        if ($filarp->salida=='1'){
                            $fictxtaccion = 'INSERTAR';
                            $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una pregunta en la tabla TB_VIRTUAL_EVALUACION_PREGUNTA COD.".$filarp->nid;
                            $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));

                            //ELIMINAR IMAGENES ANTERIORES
                            $pathtodir =  getcwd() ; 
                            foreach ($respuestas as $key => $rpta) {

                                if (($rpta[4]!="") && ($rpta[6]=="SI")){
                                    if (file_exists("./upload/aulavirtual/evaluaciones/$pgmaterialConCeros/".$$rpta[4])) {
                                        unlink($pathtodir."/upload/aulavirtual/evaluaciones/$pgmaterialConCeros/".$$rpta[4]);
                                    }
                                    if (file_exists("./upload/aulavirtual/evaluaciones/$pgmaterialConCeros/thumb/".$$rpta[4])) {
                                        unlink($pathtodir."/upload/aulavirtual/evaluaciones/$pgmaterialConCeros/thumb/".$$rpta[4]);
                                    }
                                }
                                
                            }


                            $dataex['status'] =TRUE;
                            $dataex['newid'] =base64url_encode($filarp->nid);
                            $dataex['newrp']=$filarp->rpts;
                            $dataex['newimg'] = $imagen_a_guardar;
                        }
                    }
                    else{
                        //ELIMINAR IMGEN ANTERIOR
                        if ((($palmgactual!="") && ($subio_imagen==TRUE))|| (($pgimgactual!="") && ($sin_imagen=="SI"))){
                            $pathtodir =  getcwd() ; 
                            if (file_exists("./upload/aulavirtual/evaluaciones/$pgmaterialConCeros/".$pgimgactual)) {
                                unlink($pathtodir."/upload/aulavirtual/evaluaciones/$pgmaterialConCeros/".$pgimgactual);
                            }
                            if (file_exists("./upload/aulavirtual/evaluaciones/$pgmaterialConCeros/thumb/".$pgimgactual)) {
                                unlink($pathtodir."/upload/aulavirtual/evaluaciones/$pgmaterialConCeros/thumb/".$pgimgactual);
                            }
                        }
                        $delrpta=array();
                        $delrespuestas= json_decode($_POST['delrptas']);
                        foreach ($delrespuestas as $key => $value) {
                            $delrpta[]=base64url_decode($value);
                        }
                        $pgcodpg=base64url_decode($pgcodpg);
                        $filarp=$this->mvirtualevaluacion->m_update_pregunta(array( $pgcodpg,$pgpos, $pgtipo, $pgenunciado, $pgdescripcion, $imagen_a_guardar, null, $pgvalor, $pgobligatoria, $pgvalvacia, $pgvalerror),$respuestas,$pgmaterial,$delrpta);
                        if ($filarp->salida=='1'){
                            //ELIMINAR IMAGENES ANTERIORES
                            $pathtodir =  getcwd() ; 
                            foreach ($respuestas as $key => $rpta) {

                                if ((($rpta[4]!="") && ($rpta[6]=="SI")) ||(($rpta[4]!="") && ($rpta[4]!=$rpta[7]))){
                                    if (file_exists("./upload/aulavirtual/evaluaciones/$pgmaterialConCeros/".$rpta[4])) {
                                        unlink($pathtodir."/upload/aulavirtual/evaluaciones/$pgmaterialConCeros/".$rpta[4]);
                                    }
                                    if (file_exists("./upload/aulavirtual/evaluaciones/$pgmaterialConCeros/thumb/".$rpta[4])) {
                                        unlink($pathtodir."/upload/aulavirtual/evaluaciones/$pgmaterialConCeros/thumb/".$rpta[4]);
                                    }
                                }
                                
                            }
                            $fictxtaccion = 'EDITAR';
                            $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando una pregunta en la tabla TB_VIRTUAL_EVALUACION_PREGUNTA COD.".$pgcodpg;
                            $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                            $dataex['status'] =TRUE;
                            $dataex['newid'] ="--";
                            $dataex['newrp']=$filarp->rpts;
                            $dataex['newimg'] = $imagen_a_guardar;
                        }
                    }
                    
                    
                }
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }


    public function fn_guarda_examen_alumno()
    {
        date_default_timezone_set('America/Lima');
        $timelocal=time();
        $exfecentrega=date("Y-m-d H:i:s");
        $dataex['tiempo'] = 1;
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural', '* {field} requiere un nímero entero');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('ex-cod','Examen','trim|required');
            $this->form_validation->set_rules('ex-miembro','Miembro','trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
                $dataex['msgv']=validation_errors();
            }
            else
            {
                $dataex['msg']    = 'Error al Guardar';
                $codmaterial=$this->input->post('ex-cod');
                $codmiembro=$this->input->post('ex-miembro');
                $excod=base64url_decode($this->input->post('ex-cod'));
                $exmiembro=base64url_decode($this->input->post('ex-miembro'));
                $excarga=$this->input->post('ex-carga');
                $exdivision=$this->input->post('ex-division');
                $excodentrega=$this->input->post('ex-codentrega');
                
                
                $rptaajax= json_decode($_POST['rptas']);

                $usuario = $_SESSION['userActivo']->idusuario;
                $sede = $_SESSION['userActivo']->idsede;
                $fictxtaccion = 'INSERTAR';

                $mat = $this->mvirtual->m_get_material(array($excod));
                if (isset($mat->codigo)){
                    $arraymc['mat']=$mat;
                    $arsb['menu_padre']='alaulavirtual';
                    $fvence=$mat->vence;
                    $finicia=$mat->inicia;
                    
                    $tvencio="NO";
                    if ($fvence!=""){
                        $tvencio=((strtotime($fvence) + 60 )>$timelocal) ? "NO":"SI";
                    }
                    $tinicio="SI";
                    if ($finicia!=""){
                        $tinicio=(strtotime($finicia)<=$timelocal) ?"SI":"NO";
                    }

                    if ($tinicio=="NO"){
                        $dataex['status'] = false;
                        $dataex['tiempo'] = 0;
                        $fecha_inicia = date('d/m/Y h:i a', strtotime($finicia));
                        $dataex['msg']="Podrás enviar tu examen despues de:  ".$fecha_inicia;
                    } 
                    elseif ($tvencio=="SI") {
                        $dataex['status'] = false;
                        $dataex['tiempo'] = 0;
                        $fecha_vence = date('d/m/Y h:i a', strtotime($fvence));
                        $dataex['msg']="No se envió la evaluación, la fecha y hora de recepción se ha completado: ".$fecha_vence;
                    }
                    else{
                        $preguntas = $this->mvirtualevaluacion->m_get_preguntas_x_evaluacion_revisar(array($excod));
                        $respuestas= $this->mvirtualevaluacion->m_get_respuestas_x_evaluacion_revisar(array($excod));
                        $pgconrp=array();
                        foreach ($preguntas as $key => $pg ){
                            $pgconrp[$pg->codpregunta]['codtipo'] =$pg->codtipo;
                            $pgconrp[$pg->codpregunta]['valor'] =$pg->valor;
                            $pgconrp[$pg->codpregunta]['vacio'] =$pg->vacio;
                            $pgconrp[$pg->codpregunta]['valorv'] =$pg->valorv;
                            $pgconrp[$pg->codpregunta]['valore'] =$pg->valore;
                           
                        } 
                        foreach ($respuestas as $key => $rp) {
                            $pgconrp[$rp->codpregunta]['rpta'][$rp->codrpta]=$rp;
                            unset($respuestas[$key]);
                        }
                        $rpajax=array();
                        $exnota=0;
                        $excompletado="SI";
                        $rpenviar=array();
                        $arraypgcheck=array();
                        $errorspg=array();
                        $pgrespondidas=array();
                        foreach ($rptaajax as $key => $rj) {
                            $codpg=base64url_decode($rj[0]);
                            $pgrespondidas[$codpg]=true;
                            
                            if (isset($pgconrp[$codpg])){
                                $pregunta=$pgconrp[$codpg];
                                if ($pregunta['codtipo']=="7"){
                                    if (($pregunta['vacio']=="SI") && (trim($rj[2])=="")){
                                        $errorspg[$rj[0]]="* Respuesta obligatoria";
                                    }
                                    else{
                                        $valinter=$pregunta['valor'];
                                        if ($pregunta['valor']>0){
                                            $excompletado="NO";
                                            $valinter=null;
                                        }
                                        $rpenviar[]=array($codpg,null,$rj[2],$valinter);
                                        unset($pgconrp[$codpg]);
                                    }
                                }elseif ($pregunta['codtipo']=="4"){
                                    $idrp=base64url_decode($rj[1]);
                                    $arraypgcheck[$codpg]['rpta'][$idrp]=$rj;
                                }
                                else{
                                    $idrp=base64url_decode($rj[1]);
                                    if (isset($pregunta['rpta'][$idrp])){
                                        $rpenviar[]=array($codpg,$idrp,null,$pregunta['valor']);
                                        $exnota=$exnota + $pregunta['valor'];
                                        unset($pgconrp[$codpg]);
                                    }
                                    else{
                                        $rpenviar[]= array($codpg,$idrp,null,$pregunta['valore']);
                                        $exnota=$exnota + $pregunta['valore'];
                                        unset($pgconrp[$codpg]);
                                    }
                                }
                            }
                        }

                        foreach ($pgconrp as $keyprp => $rp) {
                            if (!isset($pgrespondidas[$keyprp])){
                                if ($rp['vacio']=="SI"){
                                    $errorspg[base64url_encode($keyprp)]="* Respuesta obligatoria";
                                }
                            }
                        }


                        if ($excodentrega=="0"){
                            //NUEVA ENTREGA
                            $filarp=$this->mvirtualevaluacion->m_alumno_guardar_examen_respuesta(array($excod,$exfecentrega, $exmiembro,$exnota,$excompletado),$rpenviar);
                            if ($filarp->salida=='1'){

                                // AUDITORIA
                                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está guardando su examen en la tabla TB_VIRTUAL_EVALUACION_ALUMNO COD.".$filarp->nid;
                                $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                                // FIN AUDITORIA

                                // ENVIO DE EVALUACIÓN AL CORREO
                                /*$this->load->model('miestp');
                                $iestp=$this->miestp->m_get_datos();*/
                                $material = $this->mvirtual->m_get_material(array($excod));
                                $d_destino = $_SESSION['userActivo']->ecorporativo;
                                $d_asunto = $material->nombre;
                                $pdfexam = $this->vw_evaluaciones_pdf_individual($excarga,$exdivision,$codmaterial,$codmiembro);
                                $d_mensaje = "<p>Se le ha enviado su exámen con Éxito</p>";
                                $adjunto_email[]=array($pdfexam, 'attachment',$material->nombre.".pdf","application/pdf");
                                $d_enviador=array('notificaciones@'.getDominio(),"Plataforma Virtual");
                                $r_respondera = $d_enviador;
                                $rsp=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$adjunto_email,$r_respondera);
                                $dataex['statusmail'] = $rsp['estado'];
                                // FIN DE ENVIO CORREO
                                    
                                $dataex['status'] = TRUE;
                                $dataex['newid'] =base64url_encode($filarp->nid);
                                $urlref=base_url()."alumno/curso/virtual/evaluacion/".$excarga.'/'.$exdivision.'/'.$codmaterial.'/'.$codmiembro;
                                $urlpdfdw = base_url()."curso/virtual/evaluaciones/individual/pdf-descargar/".$excarga.'/'.$exdivision.'/'.$codmaterial.'/'.$codmiembro;
                                $dataex['redirect']=$urlref;
                                $dataex['download'] = $urlpdfdw;
                                //header("Location: $urlref", FILTER_SANITIZE_URL);
                                
                            }
                        }
                        else{
                            //ACTUALIZAR ENTREGA
                            
                        }
                    }

                }







                





            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

     public function fn_revaluar_examen_alumno()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural', '* {field} requiere un nímero entero');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('codentrega','Entrega','trim|required');
            $this->form_validation->set_rules('codmiembro','Miembro','trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
                $dataex['msgv']=validation_errors();
            }
            else
            {
                $dataex['msg']    = 'Error al Guardar';
                
                $vcodentrega=base64url_decode($this->input->post('codentrega'));
                $vcodmiembro=base64url_decode($this->input->post('codmiembro'));
                $vcodevaluacion=base64url_decode($this->input->post('codevaluacion'));
                $valumno=base64url_decode($this->input->post('alumno'));

                $usuario = $_SESSION['userActivo']->idusuario;
                $sede = $_SESSION['userActivo']->idsede;
                $fictxtaccion = 'INSERTAR';

                $preguntas = $this->mvirtualevaluacion->m_get_preguntas_x_evaluacion_revisar(array($vcodevaluacion));
                $respuestas= $this->mvirtualevaluacion->m_get_respuestas_x_evaluacion_revisar(array($vcodevaluacion));
                $pgconrp=array();
                foreach ($preguntas as $key => $pg ){
                    $pgconrp[$pg->codpregunta]['codtipo'] =$pg->codtipo;
                    $pgconrp[$pg->codpregunta]['valor'] =$pg->valor;
                    $pgconrp[$pg->codpregunta]['vacio'] =$pg->vacio;
                    $pgconrp[$pg->codpregunta]['valorv'] =$pg->valorv;
                    $pgconrp[$pg->codpregunta]['valore'] =$pg->valore;
                   
                } 
                foreach ($respuestas as $key => $rp) {
                    $pgconrp[$rp->codpregunta]['rpta'][$rp->codrpta]=$rp;
                    unset($respuestas[$key]);
                }
                $rpajax=array();
                $exnota=0;
                $excompletado="SI";
                $rpenviar=array();
                $arraypgcheck=array();
                $errorspg=array();
                $pgrespondidas=array();

                $respuestas_entregadas= $this->mvirtualevaluacion->m_get_respuestas_entregadas_x_evaluacion(array($vcodevaluacion,$vcodmiembro));

                foreach ($respuestas_entregadas as $key => $rj) {
                    //[codpg,idrp,texto,tipopg];************
                    $codpg=$rj->codpregunta;
                    $pgrespondidas[$codpg]=true;
                    
                    if (isset($pgconrp[$codpg])){
                        $pregunta=$pgconrp[$codpg];
                        if ($pregunta['codtipo']=="7"){

                           
                        }elseif ($pregunta['codtipo']=="4"){
                            //$idrp=base64url_decode($rj[1]);
                            //$arraypgcheck[$codpg]['rpta'][$idrp]=$rj;
                        }
                        else{
                            $idrp=$rj->codrpta;
                            if (isset($pregunta['rpta'][$idrp])){
                                $rpenviar[]=array($codpg,$idrp,null,$pregunta['valor'],$rj->codrptaentregada);
                                //$exnota=$exnota + $pregunta['valor'];
                                unset($pgconrp[$codpg]);
                            }
                            else{
                                $rpenviar[]= array($codpg,$idrp,null,$pregunta['valore'],$rj->codrptaentregada);
                                //$exnota=$exnota + $pregunta['valore'];
                                unset($pgconrp[$codpg]);
                            }
                        }
                    }
                }

                foreach ($pgconrp as $keyprp => $rp) {
                    if (!isset($pgrespondidas[$keyprp])){
                        if ($rp['vacio']=="SI"){
                            $errorspg[base64url_encode($keyprp)]="* Respuesta obligatoria";
                        }
                    }
                }


                $nota=$this->mvirtualevaluacion->m_alumno_revaluar_examen_respuesta(array($vcodentrega,$vcodmiembro,$vcodevaluacion),$rpenviar);
                if ($nota>=0){
                    $dataex['status']    = TRUE;
                    $dataex['nota']    = $nota;
                }
                else{
                    $dataex['msg']    = 'Error al revaluar';
                }
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_enviar_evaluacion_correo()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural', '* {field} requiere un nímero entero');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('ex-cod','Examen','trim|required');
            $this->form_validation->set_rules('ex-miembro','Miembro','trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
                $dataex['msgv']=validation_errors();
            }
            else
            {
                $dataex['msg']    = 'Error al enviar';

                $codmaterial=$this->input->post('ex-cod');
                $codmiembro=$this->input->post('ex-miembro');
                $excod=base64url_decode($this->input->post('ex-cod'));
                $excarga=$this->input->post('ex-carga');
                $exdivision=$this->input->post('ex-division');

                // ENVIO DE EVALUACIÓN AL CORREO
                $material = $this->mvirtual->m_get_material(array($excod));
                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();
                $d_destino = $_SESSION['userActivo']->ecorporativo;
                $d_asunto = $material->nombre;
                $pdfexam = $this->vw_evaluaciones_pdf_individual($excarga,$exdivision,$codmaterial,$codmiembro);
                $d_mensaje = "<p>Se le ha enviado su exámen con Éxito</p>";
                $adjunto_email[]=array($pdfexam, 'attachment',$material->nombre.".pdf","application/pdf");
                $d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);
                $r_respondera = $d_enviador;
                $rsp=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$adjunto_email,$r_respondera);
                $dataex['statusmail'] = $rsp['estado'];
                // FIN DE ENVIO CORREO
                
                if ($rsp['estado'] == true) {
                    $dataex['status'] = TRUE;
                    $dataex['msg'] = "Evaluación enviado correctamente";
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_delete_respuesta(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $this->form_validation->set_rules('codrpta','Respuesta','trim|required');
            
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
            $codrpta    = base64url_decode($this->input->post('codrpta'));
            $imagen    = $this->input->post('imgrpta');

            $usuario = $_SESSION['userActivo']->idusuario;
            $sede = $_SESSION['userActivo']->idsede;
            $fictxtaccion = 'ELIMINAR';
            $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una respuesta en la tabla TB_VIRTUAL_EVALUACION_RESPUESTA COD.".$codrpta;

            if ("0" !==$codrpta ){
                //$link    = $this->input->post('link');
                $data=array($codrpta);
                $rpta = $this->mvirtualevaluacion->m_delete_respuesta($data);
                $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                /*PARA ELIMINAR LA IMAGEN*/
                if ("0" !== $imagen) {
                    $pathtodir =  getcwd(); 
                    unlink($pathtodir."/upload/evaluaciones/".$imagen );
                    unlink($pathtodir."/upload/evaluaciones/thumb/".$imagen );
                }
                if ($rpta>0){
                    $dataex['msg'] = "Eliminado";
                }
                else{
                    $dataex['msg'] = "$rpta";
                }
                $dataex['status'] =true;
            } else {
                if ("0" !== $imagen) {
                    $pathtodir =  getcwd(); 
                    unlink($pathtodir."/upload/evaluaciones/".$imagen );
                    unlink($pathtodir."/upload/evaluaciones/thumb/".$imagen );
                }
                $dataex['msg'] = "Eliminado";
                $dataex['status'] =true;
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_delete_pregunta(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            if (($_SESSION['userActivo']->tipo == 'AD') || ($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'DC')) {
                $this->form_validation->set_message('required', '%s Requerido');
                $this->form_validation->set_rules('codrpta','Respuesta','trim|required');
                
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
                $codrpta    = base64url_decode($this->input->post('codpgta'));

                $usuario = $_SESSION['userActivo']->idusuario;
                $sede = $_SESSION['userActivo']->idsede;
                $fictxtaccion = 'ELIMINAR';
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una pregunta en la tabla TB_VIRTUAL_EVALUACION_PREGUNTA COD.".$codrpta;

                if ("0" !==$codrpta ){
                    //$link    = $this->input->post('link');
                    $data=array($codrpta);
                    $rpta = $this->mvirtualevaluacion->m_delete_pregunta($data);
                    $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    /*PARA ELIMINAR LA IMAGEN
                    $pathtodir =  getcwd() ; 
                    unlink($pathtodir."/upload/".$link );*/
                    if ($rpta>0){
                        $dataex['msg'] = "Eliminado";
                    }
                    else{
                        $dataex['msg'] = "$rpta";
                    }
                    $dataex['status'] =true;
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function f_ordenar()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            /*$urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {*/
                $dataex['msg'] = "Ocurrio un error al intentar generar la nueva fecha</a>";
                $data          = json_decode($_POST['filas']);
                $dataUpdate    = array();
                foreach ($data as $value) {
                    if ($value[1] != '0') {
                        $dataUpdate[] = array($value[0],base64url_decode($value[1]));
                    }
                }
                $rpta = $this->mvirtualevaluacion->m_ordenar($dataUpdate);
                if ($rpta>0)  $dataex['status'] = true;
                 $dataex['nm'] = $rpta;

            //}
            //$dataex['destino'] = $urlRef;
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }

    public function vw_evaluaciones_pdf($codcarga,$division,$codmaterial)
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
                $evaluaciones = $this->mvirtualevaluacion->m_get_evaluaciones_entregadas($idmaterial);

                $nro=0;

                $areg['miembros']   =$miembros;
                $areg['material']=$material;
                $areg['evaluaciones']=$evaluaciones;

                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();
                $areg['iestp'] = $iestp;
                
                $dominio=str_replace(".", "_",getDominio());
                
                $html1=$this->load->view('virtual/docvirtual/evaluacionespdf',$areg,true);

                $pdfFilePath = "EVALUACIÓN_".$curso->periodo." ".$curso->unidad."_".$material->nombre.".pdf";
                $this->load->library('M_pdf');
                $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
                $mpdf->shrink_tables_to_fit = 1;
                $mpdf->SetTitle( "$curso->unidad $curso->codseccion $curso->division $material->nombre");
                $mpdf->WriteHTML($html1);

                $mpdf->Output($pdfFilePath,"D");  //TAMBIEN I para en linea*/
            }
        }
    }

    public function fn_delete_evaluacion_alumno()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural', '* {field} requiere un nímero entero');
        
    
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('codentrega','Entrega','trim|required');
            $this->form_validation->set_rules('codmiembro','Miembro','trim|required');
            $this->form_validation->set_rules('codevaluacion','Evaluación','trim|required');
            
            
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
                $vcodentrega=base64url_decode($this->input->post('codentrega'));
                $vcodmiembro=base64url_decode($this->input->post('codmiembro'));
                $vcodevaluacion=base64url_decode($this->input->post('codevaluacion'));
                $valumno=base64url_decode($this->input->post('alumno'));
                

                //CALL ``( @codrpalum, @codpg, @codevalum, @vpuntos, @s, @nid);
                $dataex['msg']="No se pudo resetear la evaluación";
                $filarp=$this->mvirtualevaluacion->m_delete_evaluacion_alumno(array($vcodevaluacion,$vcodentrega,$vcodmiembro));
                if ($filarp->salida=='1'){
                    $ses_usuario = $_SESSION['userActivo'];
                    $contenido = "$ses_usuario->usuario - $ses_usuario->paterno $ses_usuario->materno $ses_usuario->nombres, está reseteando el examen de  $vcodmiembro - $valumno  Autor en la tabla tb_virtual_evaluacion_alumno ENTREGA: $vcodentrega EVALUACIÓN: $vcodevaluacion";
                    $this->mauditoria->insert_datos_auditoria(array($ses_usuario->idusuario, "ELIMINAR", $contenido, $ses_usuario->idsede));
                    $dataex['status'] =TRUE;
                    unset($dataex['msg']);
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function vw_evaluaciones_pdf_individual($codcarga,$division,$codmaterial,$codmiembro)
    {
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';

        $this->load->model('miestp');
        $iestp=$this->miestp->m_get_datos();

        $arraymc['vcarga']=$codcarga;
        $arraymc['vdivision']=$division;
        $arraymc['vcodmiembro']=$codmiembro;
        $arraymc['iestp'] = $iestp;
        
        $division=base64url_decode($division);
        $codcarga=base64url_decode($codcarga);
        $codmaterial=base64url_decode($codmaterial);
        $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
        if (isset($arraymc['curso']->codcarga)){
            $mat = $this->mvirtual->m_get_material(array($codmaterial));
            if (isset($mat->codigo)){
                $arraymc['mat']=$mat;
                $fvence=$mat->vence;
                $finicia=$mat->inicia;
                date_default_timezone_set('America/Lima');
                $timelocal=time();
                $tvencio="NO";
                if ($fvence!=""){
                    $tvencio=((strtotime($fvence) + 60 )>$timelocal) ? "NO":"SI";
                }
                $tinicio="SI";
                if ($finicia!=""){
                    $tinicio=(strtotime($finicia)<$timelocal) ?"SI":"NO";
                }

                $pgts= $this->mvirtualevaluacion->m_get_preguntas_x_evaluacion(array($codmaterial));
                $rps= $this->mvirtualevaluacion->m_get_respuestas_x_evaluacion(array($codmaterial));
                $rpse= $this->mvirtualevaluacion->m_get_respuestas_entregadas_x_evaluacion(array($codmaterial,base64url_decode($codmiembro)));
                $respuestas=array();
                $ntotal=0;
                foreach ($pgts as $kpg => $pgt) {
                    $pgt->rpts=array();
                    $pgt->puntos=0;
                    $pgt->correcta="NO";

                    if ($pgt->codtipo==7){
                        $pgt->correcta="--";
                        $pgt->texto="-Sin Respuesta-";
                        foreach ($rpse as $krpse => $rpe) {
                            if (($pgt->codpregunta==$rpe->codpregunta)){
                                $pgt->texto=$rpe->texto;
                                $pgt->puntos=$rpe->puntos;
                                unset($rpse[$krpse]);
                            }
                        }
                    }
                    elseif ($pgt->codtipo==4) {
                        # code...
                    }
                    else{
                        foreach ($rps as $krp => $rp) {
                            if ($rp->codpregunta==$pgt->codpregunta){
                                $rp->marcada="NO";
                                foreach ($rpse as $krpse => $rpe) {
                                    if (($rp->codpregunta==$rpe->codpregunta) && ($rp->codrpta==$rpe->codrpta)){
                                        $rp->marcada="SI";
                                        $pgt->puntos=$rpe->puntos;
                                        unset($rpse[$krpse]);
                                    }
                                }
                                $pgt->rpts[]=$rp;
                            }
                        } 
                    }
                    $ntotal= $ntotal + $pgt->puntos;
                    
                }
                $arraymc['preguntas']=$pgts;
                $arraymc['ntotal']=$ntotal;

                $this->load->model('mmiembros');
                $datamiembro = $this->mmiembros->m_miembrosxcodigo(array(base64url_decode($codmiembro)));
                $arraymc['datomiembro'] = $datamiembro;

                $html1=$this->load->view('virtual/docvirtual/evaluaciones_individualpdf', $arraymc,true);
     
                $pdfFilePath = $mat->nombre.'_'.$datamiembro->paterno.' '.$datamiembro->materno.' '.$datamiembro->nombres.".pdf";

                $this->load->library('M_pdf');
                
                $formatoimp="A4";
                
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 

                $mpdf->SetTitle( $mat->nombre.'_'.$datamiembro->paterno.' '.$datamiembro->materno.' '.$datamiembro->nombres);
               
                $mpdf->WriteHTML($html1);

                return $mpdf->Output($pdfFilePath, "S");

            }
        }
    }

    public function vw_evaluaciones_pdf_individual_download($codcarga,$division,$codmaterial,$codmiembro)
    {
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';

        $this->load->model('miestp');
        $iestp=$this->miestp->m_get_datos();

        $arraymc['vcarga']=$codcarga;
        $arraymc['vdivision']=$division;
        $arraymc['vcodmiembro']=$codmiembro;
        $arraymc['iestp'] = $iestp;
        
        $division=base64url_decode($division);
        $codcarga=base64url_decode($codcarga);
        $codmaterial=base64url_decode($codmaterial);
        $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
        if (isset($arraymc['curso']->codcarga)){
            $mat = $this->mvirtual->m_get_material(array($codmaterial));
            if (isset($mat->codigo)){
                $arraymc['mat']=$mat;
                $fvence=$mat->vence;
                $finicia=$mat->inicia;
                date_default_timezone_set('America/Lima');
                $timelocal=time();
                $tvencio="NO";
                if ($fvence!=""){
                    $tvencio=((strtotime($fvence) + 60 )>$timelocal) ? "NO":"SI";
                }
                $tinicio="SI";
                if ($finicia!=""){
                    $tinicio=(strtotime($finicia)<$timelocal) ?"SI":"NO";
                }

                $pgts= $this->mvirtualevaluacion->m_get_preguntas_x_evaluacion(array($codmaterial));
                $rps= $this->mvirtualevaluacion->m_get_respuestas_x_evaluacion(array($codmaterial));
                $rpse= $this->mvirtualevaluacion->m_get_respuestas_entregadas_x_evaluacion(array($codmaterial,base64url_decode($codmiembro)));
                $respuestas=array();
                $ntotal=0;
                foreach ($pgts as $kpg => $pgt) {
                    $pgt->rpts=array();
                    $pgt->puntos=0;
                    $pgt->correcta="NO";

                    if ($pgt->codtipo==7){
                        $pgt->correcta="--";
                        $pgt->texto="-Sin Respuesta-";
                        foreach ($rpse as $krpse => $rpe) {
                            if (($pgt->codpregunta==$rpe->codpregunta)){
                                $pgt->texto=$rpe->texto;
                                $pgt->puntos=$rpe->puntos;
                                unset($rpse[$krpse]);
                            }
                        }
                    }
                    elseif ($pgt->codtipo==4) {
                        # code...
                    }
                    else{
                        foreach ($rps as $krp => $rp) {
                            if ($rp->codpregunta==$pgt->codpregunta){
                                $rp->marcada="NO";
                                foreach ($rpse as $krpse => $rpe) {
                                    if (($rp->codpregunta==$rpe->codpregunta) && ($rp->codrpta==$rpe->codrpta)){
                                        $rp->marcada="SI";
                                        $pgt->puntos=$rpe->puntos;
                                        unset($rpse[$krpse]);
                                    }
                                }
                                $pgt->rpts[]=$rp;
                            }
                        } 
                    }
                    $ntotal= $ntotal + $pgt->puntos;
                    
                }
                $arraymc['preguntas']=$pgts;
                $arraymc['ntotal']=$ntotal;

                $this->load->model('mmiembros');
                $datamiembro = $this->mmiembros->m_miembrosxcodigo(array(base64url_decode($codmiembro)));
                $arraymc['datomiembro'] = $datamiembro;

                $html1=$this->load->view('virtual/docvirtual/evaluaciones_individualpdf', $arraymc,true);
     
                $pdfFilePath = $mat->nombre.'_'.$datamiembro->paterno.' '.$datamiembro->materno.' '.$datamiembro->nombres.".pdf";

                $this->load->library('M_pdf');
                
                $formatoimp="A4";
                
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 

                $mpdf->SetTitle( $mat->nombre.'_'.$datamiembro->paterno.' '.$datamiembro->materno.' '.$datamiembro->nombres);
               
                $mpdf->WriteHTML($html1);

                return $mpdf->Output($pdfFilePath, "D");

            }
        }
    }

    /*public function fn_delete_image_pregunta()
    {
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            if (($_SESSION['userActivo']->tipo == 'AD') || ($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'DC')) {
                $this->form_validation->set_message('required', '%s Requerido');
                $this->form_validation->set_rules('codrpta','Respuesta','trim|required');
                
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
                $codpgta    = base64url_decode($this->input->post('codpgta'));
                $carpeta    = $this->input->post('pgta-carpeta');
               
                $imagen    = $this->input->post('pgta-image');

                $usuario = $_SESSION['userActivo']->idusuario;
                $sede = $_SESSION['userActivo']->idsede;
                $fictxtaccion = 'ELIMINAR';
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una imagen en la tabla TB_VIRTUAL_EVALUACION_PREGUNTA COD.".$codpgta;

                if ("0" !==$codpgta ){
                    $data=array(null, $codpgta);
                    $rpta = $this->mvirtualevaluacion->m_eliminar_imagen_pregunta($data);
                    $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    // PARA ELIMINAR LA IMAGEN
                    if ("" !== $imagen) {
                        $pathtodir =  getcwd(); 
                        if (file_exists("./upload/aulavirtual/evaluaciones/$carpeta/".$imagen)) {
                            unlink($pathtodir."/upload/aulavirtual/evaluaciones/$carpeta/".$imagen);
                        }
                        if (file_exists("./upload/aulavirtual/evaluaciones/$carpeta/thumb/".$imagen)) {
                            unlink($pathtodir."/upload/aulavirtual/evaluaciones/$carpeta/thumb/".$imagen);
                        }
                    }
                    
                    if ($rpta>0){
                        $dataex['msg'] = "Eliminado";
                    }
                    else{
                        $dataex['msg'] = "$rpta";
                    }
                    $dataex['status'] =true;
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }*/
    
    /*public function fn_delete_image_respuesta()
    {
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            if (($_SESSION['userActivo']->tipo == 'AD') || ($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'DC')) {
                $this->form_validation->set_message('required', '%s Requerido');
                $this->form_validation->set_rules('codrpta','Respuesta','trim|required');
                
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
                $codrpta    = base64url_decode($this->input->post('codrpta'));
                $imagen    = $this->input->post('rpta-image');
                $pgmaterialConCeros = $this->input->post('rpta-carpeta');

                $usuario = $_SESSION['userActivo']->idusuario;
                $sede = $_SESSION['userActivo']->idsede;
                $fictxtaccion = 'ELIMINAR';
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una imagen en la tabla TB_VIRTUAL_EVALUACION_RESPUESTA COD.".$codrpta;

                if ("0" !==$codrpta ){
                    $data=array("", $codrpta);
                    $rpta = $this->mvirtualevaluacion->m_eliminar_imagen_respuesta($data);
                    $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    // PARA ELIMINAR LA IMAGEN
                    if ("" !== $imagen) {
                        $pathtodir =  getcwd(); 
                        if (file_exists("./upload/aulavirtual/evaluaciones/$pgmaterialConCeros/".$imagen)) {
                            unlink($pathtodir."/upload/aulavirtual/evaluaciones/$pgmaterialConCeros/".$imagen);
                        }
                        if (file_exists("./upload/aulavirtual/evaluaciones/$pgmaterialConCeros/thumb/".$imagen)) {
                            unlink($pathtodir."/upload/aulavirtual/evaluaciones/$pgmaterialConCeros/thumb/".$imagen);
                        }
                            
                      

                    }
                    
                    if ($rpta>0){
                        $dataex['msg'] = "Eliminado";
                    }
                    else{
                        $dataex['msg'] = "$rpta";
                    }
                    $dataex['status'] =true;
                } else {
                    if ("" !== $imagen) {
                        $pathtodir =  getcwd(); 
                        unlink($pathtodir."/upload/evaluaciones/".$imagen );
                        unlink($pathtodir."/upload/evaluaciones/thumb/".$imagen );
                    }
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }*/

    public function fn_upload_file_image()
    {
        $dataex['status'] = false;
        $dataex['msg'] = 'Sin Archivo';
        if ($_FILES['rpta-image']['name']) {
            if (!$_FILES['rpta-image']['error']) {
                $name = $_FILES['rpta-image']['name'];//md5(Rand(100, 200));
                //$ext = explode('.', $_FILES['rpta-image']['name']);

                //$path = $_FILES['rpta-image']['name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);


                //$ult=count($ext);
                $nro_rand=rand(0,9);
                $nro_rand2=rand(0,100);
                $NewfileName  = "evrpta".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") ."-".$nro_rand.$nro_rand2;
                $filename = $NewfileName.".".$ext;//. '.' . $ext[1];
                
                $destination = './upload/aulavirtual/evaluaciones/temp/' .$filename ; //change this directory
                $location = $_FILES["rpta-image"]["tmp_name"];
                move_uploaded_file($location, $destination);

                // CREAR UN THUMB
                $sizes=getimagesize($destination);
                $anchot=$sizes[0];
                $altot=$sizes[1];
                if ($sizes[1]>380){
                    $anchot=380;
                    $altot=380;
                }
                $config2['image_library'] = 'gd2';
                $config2['source_image'] =  $destination;
                $config2['new_image'] = './upload/aulavirtual/evaluaciones/temp/th'.$filename ;
                $config2['create_thumb'] = FALSE;
                $config2['maintain_ratio'] = TRUE;
                $config2['quality'] = '85%';
                $config2['width'] = $anchot;
                $config2['height'] = $altot;
                //$config2['thumb_marker'] = 600;
                
                $this->load->library('image_lib', $config2);
                $this->image_lib->resize();


                
                $dataex['msg'] = 'Archivo subido correctamente';
                $dataex['link'] = $filename;
                $dataex['status'] = true;

                
            }
            else {
                $dataex['msg'] = 'Se ha producido el siguiente error:  '.$_FILES['rpta-image']['error'];
            }
        }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

}