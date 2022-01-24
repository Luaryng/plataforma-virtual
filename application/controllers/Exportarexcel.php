<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/phpexcel/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
//use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Exportarexcel extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	
    public function dp_inscripciones()
    {
        $periodo=$this->input->get("cp");
        $carrera=$this->input->get("cc");
        $busqueda=$this->input->get("ap");
        $turno=$this->input->get("tn");
        $campania=$this->input->get('ccp');
        $seccion=$this->input->get('cs');
        $ciclo=$this->input->get('cl');
        $this->load->model('minscrito');
        $vmatriculas=$this->minscrito->m_filtrar_basico_sd_activa(array($periodo,$campania,$carrera,$ciclo,$turno,$seccion,$_SESSION['userActivo']->idsede,'%'.$busqueda.'%'));

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp-lista-inscripciones.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        
        $fila=4;
        $nro=0;
        $strtimeact=strtotime("now");
        foreach ($vmatriculas as $mat) {
            $nro++;
            $fila++;
            
            $sheet->setCellValue("A".$fila, $nro);
            $sheet->setCellValue('B'.$fila, $mat->periodo);
            $sheet->setCellValue('C'.$fila, $mat->campania);

            $sheet->setCellValue('D'.$fila, $mat->carrera);
            $sheet->setCellValue('E'.$fila, $mat->tdoc);
            $sheet->setCellValue('F'.$fila, $mat->nro);
            $sheet->setCellValue('G'.$fila, $mat->carnet);
            $sheet->setCellValue('H'.$fila, $mat->paterno);
            $sheet->setCellValue('I'.$fila, $mat->materno);
            $sheet->setCellValue('J'.$fila, $mat->nombres);
            

            $edad=($strtimeact - strtotime($mat->fecnac))/31557600;
            $sheet->setCellValue('K'.$fila, $mat->fecnac);

            $sheet->setCellValue('L'.$fila, intval($edad));
            
            $sheet->setCellValue('M'.$fila, $mat->sexo);
            $sheet->setCellValue('N'.$fila, " ".$mat->celular);
            $sheet->setCellValue('O'.$fila, $mat->ecorporativo);
            $sheet->setCellValue('P'.$fila, $mat->epersonal);
            //AQUI HAY QUE ARREGLAR LO DE DISCAPACIDAD
            $sheet->setCellValue('Q'.$fila, date_format(date_create($mat->fecinsc),"d/m/Y"));
          

        }
        foreach(range('A','Q') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'Inscripciones';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

    public function dp_matriculas()
    {
        $fmcbperiodo=$this->input->get("cp");
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");
        $fmcbplan=$this->input->get("cpl");
        $fmcbestado=$this->input->get("es");
        $busqueda=$this->input->get("ap");
        $sede=$this->input->get("sed");
        $beneficio=$this->input->get("benf");
        $this->load->model('mmatricula');

        $busqueda=str_replace(" ","%",$busqueda);

        $vmatriculas=$this->mmatricula->m_filtrar(array($sede,$fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,$fmcbestado,$beneficio,'%'.$busqueda.'%'));

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp-lista-matriculas.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        
        $fila=0;
        $nro=0;
        $strtimeact=strtotime("now");
        $grupo="";
        foreach ($vmatriculas as $mat) {
            $grupoint=$mat->codperiodo.$mat->codcarrera.$mat->codplan.$mat->codciclo.$mat->codturno.$mat->codseccion;
            if ($grupo!=$grupoint){
                $grupo=$grupoint;
                $fila=$fila+4;
                $sheet->setCellValue("A".$fila, "PERIODO LECTIVO");
                $sheet->mergeCells("A$fila:B$fila");
                $sheet->setCellValue("C".$fila, $mat->periodo);
                $sheet->getStyle("C".$fila)->getFont()->setBold(true);
                $sheet->setCellValue("D".$fila, "PROGRAMA");
                $sheet->setCellValue("E".$fila, $mat->carrera);
                $sheet->getStyle("E".$fila)->getFont()->setBold(true);
                $sheet->mergeCells("E$fila:G$fila");
                $fila++;
                $sheet->setCellValue("A".$fila, "PERIODO ACADEM.");
                $sheet->mergeCells("A$fila:B$fila");
                $sheet->setCellValue("C".$fila, $mat->ciclo);
                $sheet->getStyle("C".$fila)->getFont()->setBold(true);
                $sheet->setCellValue("D".$fila, "TURNO");
                $sheet->setCellValue("E".$fila, $mat->codturno);
                $sheet->getStyle("E".$fila)->getFont()->setBold(true);
                $sheet->setCellValue("F".$fila, "SECCIÓN");
                $sheet->setCellValue("G".$fila, $mat->codseccion);
                $sheet->getStyle("G".$fila)->getFont()->setBold(true);
                $fila=$fila+2;
                $sheet->setCellValue("A".$fila, "N°");
                $sheet->setCellValue("B".$fila, "CARNÉ");
                $sheet->setCellValue("C".$fila, "APELLIDOS Y NOMBRES");
                $sheet->setCellValue("F".$fila, "CORREO INST.");
                $sheet->getStyle("A$fila:F$fila")->getFont()->setBold(true);
                $sheet->mergeCells("C$fila:E$fila");
                $sheet->mergeCells("F$fila:G$fila");
                $nro=0;
            }
            
            $nro++;
            $fila++;
            
            $sheet->setCellValue("A".$fila, $nro);
          
            //$sheet->setCellValue('D'.$fila, $mat->tdoc);
            //$sheet->setCellValue('E'.$fila, $mat->nro);
            $celulares=array(trim($mat->celular1),trim($mat->celular2),trim($mat->telefono));
            $celulares=array_filter($celulares);
            $txtcelulares=implode( ',', $celulares );
            $sheet->setCellValue('B'.$fila, $mat->carne);
            $sheet->setCellValue('C'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
            $sheet->mergeCells("C$fila:E$fila");
            $sheet->setCellValue('F'.$fila, strtolower($mat->carne)."@".getDominio());
            $sheet->setCellValue('G'.$fila, $txtcelulares);
            //$sheet->mergeCells("F$fila:G$fila");
            /*$edad=($strtimeact - strtotime($mat->fecnac))/31557600;
            $sheet->setCellValue('J'.$fila, $mat->fecnac);

            $sheet->setCellValue('K'.$fila, intval($edad));
            
            $sheet->setCellValue('L'.$fila, $mat->sexo);
            $sheet->setCellValue('M'.$fila, " ".$mat->celular);
            $sheet->setCellValue('N'.$fila, $mat->ecorporativo);
            //AQUI HAY QUE ARREGLAR LO DE DISCAPACIDAD
            $sheet->setCellValue('O'.$fila, date_format(date_create($mat->fecinsc),"d/m/Y"));*/
          

        }
        /*foreach(range('A','L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }*/
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'lista-matriculas';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

    public function dp_matriculas_deudas_xgrupo()
    {
        $fmcbperiodo=$this->input->get("cp");
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");
        $fmcbplan=$this->input->get("cpl");
        $busqueda=$this->input->get("ap");

        $cuota_1 = "";
        $cuota_2 = "";
        $cuota_3 = "";
        $cuota_4 = "";
        $cuota_5 = "";
        
        $vencido="NO";
        if (null !== $this->input->get("checkc1")) {
            $cuota_1=$this->input->get("checkc1");
        }
        if (null !== $this->input->get("checkc2")) {
            $cuota_2=$this->input->get("checkc2");
        }
        if (null !== $this->input->get("checkc3")) {
            $cuota_3=$this->input->get("checkc3");
        }
        if (null !== $this->input->get("checkc4")) {
            $cuota_4=$this->input->get("checkc4");
        }
        if (null !== $this->input->get("checkc5")) {
            $cuota_5=$this->input->get("checkc5");
        }
        if (null !== $this->input->get("checkcv")) {
            $vencido=$this->input->get("checkcv");
        }
        

        $this->load->model('mdeudas_individual');

        $vmatriculas=$this->mdeudas_individual->m_deudas_xgrupo_matriculado(array($fmcbperiodo,$fmcbcarrera,$fmcbciclo,$fmcbturno,$fmcbseccion),$vencido);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp-lista-matriculas.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        
        $fila=0;
        $nro=0;
        $strtimeact=strtotime("now");
        $grupo="";

        foreach ($vmatriculas as $mat) {
            //$grupoint=$mat->codperiodo.$mat->codcarrera.$mat->codplan.$mat->codciclo.$mat->codturno.$mat->codseccion;
            $grupoint=$mat->codperiodo.$mat->codcarrera.$mat->codciclo.$mat->codturno.$mat->codseccion;
            if ($grupo!=$grupoint){
                $grupo=$grupoint;
                $fila=$fila+4;
                $col = 6;
                $sheet->setCellValue("A".$fila, "PERIODO LECTIVO");
                $sheet->mergeCells("A$fila:B$fila");
                $sheet->setCellValue("C".$fila, $mat->periodo);
                $sheet->getStyle("C".$fila)->getFont()->setBold(true);
                $sheet->setCellValue("D".$fila, "PROGRAMA");
                $sheet->setCellValue("E".$fila, $mat->carrera);
                $sheet->getStyle("E".$fila)->getFont()->setBold(true);
                $sheet->mergeCells("E$fila:G$fila");
                $fila++;
                $sheet->setCellValue("A".$fila, "PERIODO ACADEM.");
                $sheet->mergeCells("A$fila:B$fila");
                $sheet->setCellValue("C".$fila, $mat->ciclo);
                $sheet->getStyle("C".$fila)->getFont()->setBold(true);
                $sheet->setCellValue("D".$fila, "TURNO");
                $sheet->setCellValue("E".$fila, $mat->codturno);
                $sheet->getStyle("E".$fila)->getFont()->setBold(true);
                $sheet->setCellValue("F".$fila, "SECCIÓN");
                $sheet->setCellValue("G".$fila, $mat->codseccion);
                $sheet->getStyle("G".$fila)->getFont()->setBold(true);
                $fila=$fila+2;
                $sheet->setCellValue("A".$fila, "N°");
                $sheet->setCellValue("B".$fila, "CARNÉ");
                $sheet->setCellValue("C".$fila, "APELLIDOS Y NOMBRES");

                
                if ($cuota_1 == "CUOTA1") {
                    $sheet->setCellValueByColumnAndRow($col,$fila, "CUOTA 1");
                    $col++;
                }

                if ($cuota_2 == "CUOTA2") {
                    $sheet->setCellValueByColumnAndRow($col,$fila, "CUOTA 2");
                    $col++;
                }

                if ($cuota_3 == "CUOTA3") {
                    $sheet->setCellValueByColumnAndRow($col,$fila, "CUOTA 3");
                    $col++;
                }

                if ($cuota_4 == "CUOTA4") {
                    $sheet->setCellValueByColumnAndRow($col,$fila, "CUOTA 4");
                    $col++;
                }

                if ($cuota_5 == "CUOTA5") {
                    $sheet->setCellValueByColumnAndRow($col,$fila, "CUOTA 5");
                    $col++;
                }

                // $sheet->setCellValue("F".$fila, "CUOTA 1");
                // $sheet->setCellValue("G".$fila, "CUOTA 2");
                // $sheet->setCellValue("H".$fila, "CUOTA 3");
                // $sheet->setCellValue("I".$fila, "CUOTA 4");
                // $sheet->setCellValue("J".$fila, "CUOTA 5");
                $sheet->getStyle("A$fila:J$fila")->getFont()->setBold(true);
                $sheet->mergeCells("C$fila:E$fila");
                
                $nro=0;
            }
            
            //COMPROBAR SI DEBE
            $debe=0;
            if ($cuota_1 == "CUOTA1") {
                    // $sheet->setCellValue('F'.$fila, $mat->cuota1);
                $debe= $debe + $mat->cuota1;
                
            }

            if ($cuota_2 == "CUOTA2") {
                $debe= $debe + $mat->cuota2;
            }
            
            if ($cuota_3 == "CUOTA3") {
                $debe= $debe + $mat->cuota3;
            }

            if ($cuota_4 == "CUOTA4") {
               $debe= $debe + $mat->cuota4;
            }

            if ($cuota_5 == "CUOTA5") {
               $debe= $debe + $mat->cuota5;
            }


            if ($debe>0){
                $nro++;
                $fila++;
                $colrow = 6;
                
                $sheet->setCellValue("A".$fila, $nro);
              
                //$sheet->setCellValue('D'.$fila, $mat->tdoc);
                //$sheet->setCellValue('E'.$fila, $mat->nro);
                //$c1=;
                
                
                $sheet->setCellValue('B'.$fila, $mat->carne);
                $sheet->setCellValue('C'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
                $sheet->mergeCells("C$fila:E$fila");

                
                if ($cuota_1 == "CUOTA1") {
                    // $sheet->setCellValue('F'.$fila, $mat->cuota1);
                    $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->cuota1);
                    $colrow++;
                }

                if ($cuota_2 == "CUOTA2") {
                    // $sheet->setCellValue('G'.$fila, $mat->cuota2);
                    $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->cuota2);
                    $colrow++;
                }
                
                if ($cuota_3 == "CUOTA3") {
                    // $sheet->setCellValue('H'.$fila, $mat->cuota3);
                    $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->cuota3);
                    $colrow++;
                }

                if ($cuota_4 == "CUOTA4") {
                    // $sheet->setCellValue('I'.$fila, $mat->cuota4);
                    $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->cuota4);
                    $colrow++;
                }

                if ($cuota_5 == "CUOTA5") {
                    // $sheet->setCellValue('J'.$fila, $mat->cuota5);
                    $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->cuota5);
                    $colrow++;
                }
            }
                

            //$sheet->mergeCells("F$fila:G$fila");
            /*$edad=($strtimeact - strtotime($mat->fecnac))/31557600;
            $sheet->setCellValue('J'.$fila, $mat->fecnac);

            $sheet->setCellValue('K'.$fila, intval($edad));
            
            $sheet->setCellValue('L'.$fila, $mat->sexo);
            $sheet->setCellValue('M'.$fila, " ".$mat->celular);
            $sheet->setCellValue('N'.$fila, $mat->ecorporativo);
            //AQUI HAY QUE ARREGLAR LO DE DISCAPACIDAD
            $sheet->setCellValue('O'.$fila, date_format(date_create($mat->fecinsc),"d/m/Y"));*/
          

        }
        /*foreach(range('A','L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }*/
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'lista-matriculas';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }


    //dp=Download de Plantilla
    public function dp_registro_matriculados()
    {
    	$fmcbperiodo=$this->input->get("cp");
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");
        $fmcbplan=$this->input->get("cpl");

        $this->load->model('miestp');
        $iestp=$this->miestp->m_get_datos();

        $this->load->model('mgrupos');
        $grupos=$this->mgrupos->m_filtrar(array($_SESSION['userActivo']->idsede,$fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));
        $grupo=array();
        foreach ($grupos as $gp) {
        	$grupo=$gp;
        }
        $this->load->model('mcargaacademica');

        $vcursos=$this->mcargaacademica->m_filtrar(array($_SESSION['userActivo']->idsede,$fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));

		$this->load->model('mmatricula');
		$vmatriculas=$this->mmatricula->m_matriculas_miembros_x_grupo(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));

        
        $this->load->model('mmiembros');
        /*foreach ($vcursos as $key => $vcurso) {
            $vmiembros[]=$this->mmiembros->m_get_miembros_por_carga_division(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));
        }*/
        
		$vnotas=$this->mmiembros->m_notas_x_grupo(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));

    	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet = $reader->load("plantillas/regmat.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue("A1", "REGISTRO DE MATRÍCULA \n EDUCACIÓN SUPERIOR TECNOLÓGICA \n PERIODO LECTIVO: ".$grupo->periodo);
        $sheet->setCellValue("R3", $grupo->carrera);
        $sheet->setCellValue("D3", $iestp->denoml);
        $sheet->setCellValue("D4", $iestp->gestion);
        $sheet->setCellValue("I4", $iestp->codmodular);
        $sheet->setCellValue("G5", $iestp->resolucion);
        $sheet->setCellValue("G6", $iestp->revalidacion);
        $sheet->setCellValue("G8", $iestp->dre);

        $sheet->setCellValue("C8", $iestp->departamento);
        $sheet->setCellValue("C9", $iestp->provincia);
        $sheet->setCellValue("C10", $iestp->distrito);
        $sheet->setCellValue("C11", $iestp->centropoblado);
        $sheet->setCellValue("G11", $iestp->direccion);

        $sheet->setCellValue("R5", $grupo->nformativo);
        $sheet->setCellValue("R6", $grupo->ciclo);
        $sheet->setCellValue("R7", $grupo->turno);
        $sheet->setCellValue("Y7", $grupo->seccion);
		date_default_timezone_set('America/Lima');
        $fecha = date('m/d/Y h:i:s a', time());
		$hora=date('h:i A');
        //$fecha=time();
        $fecha = substr($fecha, 0, 10);
        $numeroDia = date('d', strtotime($fecha));
        $dia = date('l', strtotime($fecha));
        $mes = date('F', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
			 
        $sheet->setCellValue("K85", ucfirst(strtolower($iestp->distrito)).", $nombredia $numeroDia de $nombreMes de $anio");
        


        $col=13;
        foreach ($vcursos as $curso) {
        	$col++;
        	$sheet->setCellValueByColumnAndRow($col,9, $curso->curso);
        }
        $fila=15;
        $nro=0;
        //$col=13;
        
		$fecha = getdate();
		$strtimeact=strtotime("now");
        foreach ($vmatriculas as $mat) {
        	$nro++;
        	$fila++;
        	if ($fila==45) $fila=48;
        	$sheet->setCellValue("A".$fila, $nro);
        	$sheet->setCellValue('B'.$fila, $mat->dni);
        	$sheet->setCellValue('C'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
        	$sheet->setCellValue('K'.$fila, substr($mat->sexo,0,1));
        	$edad=($strtimeact - strtotime($mat->fecnac))/31557600;
        	$sheet->setCellValue('L'.$fila, intval($edad));
        	//AQUI HAY QUE ARREGLAR LO DE DISCAPACIDAD
        	$sheet->setCellValue('M'.$fila, "NO");
        	//√
        	$col=13;
        	foreach ($vcursos as $curso) {
        		$col++;
        		//$sheet->setCellValueByColumnAndRow($col,9, $curso->curso);
        		foreach ($vnotas as $key => $nota) {
        			if (($mat->codmatricula==$nota->matricula) && ($curso->idcarga==$nota->idcarga)){
        				$sheet->setCellValueByColumnAndRow($col,$fila, "√");
        				unset($vnotas[$key]);
        			}
        		}

        	}

        }
        
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'Reg-Matriculados';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

    //dp=Download de plantillas
    public function dp_registro_evaluacion()
    {
        $fmcbperiodo=$this->input->get("cp");
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");
        $fmcbplan=$this->input->get("cpl");

        $this->load->model('miestp');
        $iestp=$this->miestp->m_get_datos();
        $this->load->model('mgrupos');
        $grupos=$this->mgrupos->m_filtrar(array($_SESSION['userActivo']->idsede,$fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));
        $grupo=array();
        foreach ($grupos as $gp) {
            $grupo=$gp;
        }
        $this->load->model('mcargaacademica');
        $vcursos=$this->mcargaacademica->m_filtrar(array($_SESSION['userActivo']->idsede,$fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));

        $this->load->model('mmatricula');
        //$vmatriculas=$this->mmatricula->m_matriculas_x_grupo(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));
        $vmatriculas=$this->mmatricula->m_matriculas_miembros_x_grupo(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));
        $this->load->model('mmiembros');
        $vnotas=$this->mmiembros->m_notas_x_grupo(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));
         $dominio=str_replace(".", "_",getDominio());

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/acta_eval_".$dominio.".xlsx");
        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        if (getDominio()=="iestphuarmaca.edu.pe"){
            //INICIO HUARMACA
            $sheet->setCellValue("K1", "REGISTRO DE ACTAS DE EVALUACIÓN \n EDUCACIÓN SUPERIOR  TECNOLÓGICA \n PERÍODO LECTIVO ".$grupo->periodo);
            //$sheet->getStyle("C".$fila)->getFont()->setBold(true);
            $sheet->setCellValue("U3", $grupo->carrera);
            $sheet->setCellValue("U5", strtoupper($grupo->ciclol));
            $sheet->setCellValue("U7", $grupo->seccion);
            $sheet->setCellValue("U9", $grupo->turno);

           

            date_default_timezone_set('America/Lima');
            $fecha = date('m/d/Y h:i:s a', time());
            $hora=date('h:i A');
            //$fecha=time();
            $fecha = substr($fecha, 0, 10);

            $dia = date('l', strtotime($fecha));
            $mes = date('F', strtotime($fecha));
            $anio = date('Y', strtotime($fecha));

            $numeroDia = date('d', strtotime($fecha));
            $nombredia = str_replace($dias_EN, $dias_ES, $dia);
            $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                 
            $sheet->setCellValue("O72", strtoupper($iestp->distrito).", $nombredia $numeroDia de $nombreMes de $anio");


            $col=7;
            foreach ($vcursos as $curso) {
                $col++;
                $sheet->setCellValueByColumnAndRow($col,3, $curso->curso);
                $sheet->setCellValueByColumnAndRow($col,12, $curso->ct + $curso->cp);
            }
            $fila=12;
            $nro=0;
            //$col=13;
            $fecha = getdate();
            $strtimeact=strtotime("now");
            foreach ($vmatriculas as $mat) {
                $nro++;
                $fila++;
                if ($fila==36) $fila=42;
                //$sheet->setCellValue("A".$fila, $nro);
                $sheet->setCellValue('B'.$fila, $mat->dni);
                $sheet->setCellValue('C'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
                if ($mat->codestado==2) $sheet->setCellValue("U".$fila, "RETIRADO");
                $col=7;
                foreach ($vcursos as $curso) {
                    $col++;
                    foreach ($vnotas as $key => $nota) {
                        if (($mat->codmatricula==$nota->matricula) && ($curso->idcarga==$nota->idcarga)){
                            $nf=$nota->final;
                            if ($nota->dpi=="DPI"){
                                $nf="0";
                            }
                            $sheet->setCellValueByColumnAndRow($col,$fila, $nf);
                            unset($vnotas[$key]);
                        }
                    }

                }
            }
            //FIN HUARMACA
        }
        else{
            $sheet->setCellValue("A2", "REGISTRO DE EVALUACIÓN Y NOTAS \n EDUCACIÓN SUPERIOR TECNOLÓGICA \n PERIODO LECTIVO: ".$grupo->periodo);
            $sheet->setCellValue("X4", "PROGRAMA DE ESTUDIOS: ".$grupo->carrera);
            $sheet->setCellValue("X9", "PERIODO ACADÉMICO: ".$grupo->ciclo);
            $sheet->setCellValue("X11", "TURNO: ".$grupo->turno);
            $sheet->setCellValue("X10", "SECCIÓN: ".$grupo->seccion);

            $sheet->setCellValue("D4", $iestp->denoml);
            $sheet->setCellValue("D5", $iestp->gestion);
            $sheet->setCellValue("I5", $iestp->codmodular);
            $sheet->setCellValue("D6", $iestp->resolucion);
            $sheet->setCellValue("I6", $iestp->revalidacion);
            $sheet->setCellValue("F8", $iestp->dre);

            $sheet->setCellValue("C8", $iestp->departamento);
            $sheet->setCellValue("C9", $iestp->provincia);
            $sheet->setCellValue("C10", $iestp->distrito);
            $sheet->setCellValue("C11", $iestp->centropoblado);
            $sheet->setCellValue("F11", $iestp->direccion);

            $sheet->setCellValue("R5", $grupo->nformativo);

            date_default_timezone_set('America/Lima');
                $fecha = date('m/d/Y h:i:s a', time());
                $hora=date('h:i A');
                  //$fecha=time();
                  $fecha = substr($fecha, 0, 10);
                  
                  $dia = date('l', strtotime($fecha));
                  $mes = date('F', strtotime($fecha));
                  $anio = date('Y', strtotime($fecha));
                 
                  $numeroDia = date('d', strtotime($fecha));
                  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                 
            $sheet->setCellValue("A81", strtolower($iestp->distrito).", $nombredia $numeroDia de $nombreMes de $anio");

            $col=10;
            foreach ($vcursos as $curso) {
                $col++;
                $sheet->setCellValueByColumnAndRow($col,5, $curso->curso);
                $sheet->setCellValueByColumnAndRow($col,13, $curso->ct + $curso->cp);
            }
            $fila=13;
            $nro=0;
            //$col=13;
            $fecha = getdate();
            $strtimeact=strtotime("now");
            foreach ($vmatriculas as $mat) {
                $nro++;
                $fila++;
                if ($fila==43) $fila=48;
                $sheet->setCellValue("A".$fila, $nro);
                $sheet->setCellValue('B'.$fila, $mat->dni);
                $sheet->setCellValue('C'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
                
                $col=10;
                foreach ($vcursos as $curso) {
                    $col++;
                    foreach ($vnotas as $key => $nota) {
                        if (($mat->codmatricula==$nota->matricula) && ($curso->idcarga==$nota->idcarga)){
                            $rc=$nota->recuperacion;
                            if (!is_numeric($rc)) $rc="";
                            $notapf=($rc!="") ? $rc : $nota->final;
                            $sheet->setCellValueByColumnAndRow($col,$fila, $notapf);
                            unset($vnotas[$key]);
                        }
                    }

                }
            }
        }




        $writer = new Xlsx($spreadsheet);
        $filename = 'REGISTRO-DE-ACTAS-DE-EVALUACION';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

   //dp=Download de plantillas
    public function dp_registro_padron_evaluacion()
    {
        $fmcbperiodo=$this->input->get("cp");
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");
        $fmcbplan=$this->input->get("cpl");

        $this->load->model('miestp');
        $iestp=$this->miestp->m_get_datos();
        $this->load->model('mgrupos');
        $grupos=$this->mgrupos->m_filtrar(array($_SESSION['userActivo']->idsede,$fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));
        $grupo=array();
        foreach ($grupos as $gp) {
            $grupo=$gp;
        }
        $this->load->model('mcargaacademica');
        $vcursos=$this->mcargaacademica->m_filtrar(array($_SESSION['userActivo']->idsede,$fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));

        $this->load->model('mmatricula');
        //$vmatriculas=$this->mmatricula->m_matriculas_x_grupo(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));
        $vmatriculas=$this->mmatricula->m_matriculas_miembros_x_grupo(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));
        $this->load->model('mmiembros');
        $vnotas=$this->mmiembros->m_notas_x_grupo(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));
         $dominio=str_replace(".", "_",getDominio());

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/padron_eval_".$dominio.".xlsx");
        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        
            //$sheet->setCellValue("A2", "REGISTRO DE EVALUACIÓN Y NOTAS \n EDUCACIÓN SUPERIOR TECNOLÓGICA \n PERIODO LECTIVO: ".$grupo->periodo);
            $sheet->setCellValue("C2", $grupo->periodo);
            $sheet->setCellValue("C3", $grupo->carrera);
            $sheet->setCellValue("C4", $grupo->ciclo);
            $sheet->setCellValue("E4", $grupo->turno);
            $sheet->setCellValue("C5", $grupo->seccion);

           

            $col=5;
            foreach ($vcursos as $curso) {
                $col++;
                $sheet->setCellValueByColumnAndRow($col,7, $curso->curso);
                //$sheet->setCellValueByColumnAndRow($col,13, $curso->ct + $curso->cp);
            }
            $fila=8;
            $nro=0;
            //$col=13;
            $fecha = getdate();
            $strtimeact=strtotime("now");
            foreach ($vmatriculas as $mat) {
                $nro++;
                $fila++;
                //if ($fila==43) $fila=48;
                $sheet->setCellValue("A".$fila, $nro);
                $sheet->setCellValue('B'.$fila, $mat->dni);
                $sheet->setCellValue('C'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
                
                $col=5;
                foreach ($vcursos as $curso) {
                    $col++;
                    foreach ($vnotas as $key => $nota) {
                        if (($mat->codmatricula==$nota->matricula) && ($curso->idcarga==$nota->idcarga)){
                            $rc=$nota->recuperacion;
                            if (!is_numeric($rc)) $rc="";
                            $notapf=($rc!="") ? $rc : $nota->final;
                            $sheet->setCellValueByColumnAndRow($col,$fila, $notapf);
                            unset($vnotas[$key]);
                        }
                    }

                }
            }
        




        $writer = new Xlsx($spreadsheet);
        $filename = 'PADRON-DE-EVALUACION';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

    public function dp_acta_final_evaluacion($codcarga,$division)
    {
        if (($_SESSION['userActivo']->codnivel != 3)) {
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $this->load->model('mcargasubseccion');
            $curso = $this->mcargasubseccion->m_get_carga_subseccion_todos(array($codcarga,$division));
            if (isset($curso)) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $dominio=str_replace(".", "_",getDominio());
                $spreadsheet = $reader->load("plantillas/reg_acta_final_".$dominio.".xlsx");

                //$spreadsheet = new Spreadsheet();
                $spreadsheet->setActiveSheetIndex(0);
                $sheet = $spreadsheet->getActiveSheet();

                $this->load->model('mmiembros');
                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();

                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('logo');
                $drawing->setDescription('logo');
                $drawing->setPath('resources/img/logo_h80.'.getDominio().'.png'); // put your path and image here
                $drawing->setCoordinates('F1');
                $colWidth = $sheet->getColumnDimension('E')->getWidth() + $sheet->getColumnDimension('F')->getWidth();
                if ($colWidth == -1) { //not defined which means we have the standard width
                    $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
                } else {                  //innner width is 8.43 char units
                    $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
                }
                $offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
                $drawing->setOffsetX($offsetX); //p
                $drawing->getShadow()->setVisible(true);
                $drawing->setWorksheet($sheet);

                $sheet->setCellValue("A6", $iestp->denoml);
                $sheet->setCellValue("C7", $curso->carrera);
                $sheet->setCellValue("C8", $curso->unidad);
                $sheet->setCellValue("C9", $curso->ciclol);
                $sheet->setCellValue("E9", $curso->turno);
                $sheet->setCellValue("G9", $curso->codseccion." ".$curso->division);
                $sheet->setCellValue("C10", $curso->cred_teo + $curso->cred_pra);
                $sheet->setCellValue("C11", $curso->paterno." ".$curso->materno." ".$curso->nombres );

                $nro=0;
                $fila=15;
                foreach ($miembros as $mat) {
                    $nro++;
                    $fila++;
                    //if ($fila==43) $fila=48;
                    $sheet->setCellValue("A".$fila, $nro);
                    $sheet->setCellValue('B'.$fila, $mat->dni);
                    $sheet->setCellValue('C'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
                    $nota=($mat->final>$mat->recuperacion)? $mat->final: $mat->recuperacion;
                    $sheet->setCellValue('E'.$fila, $nota);
                    
                }
                $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                date_default_timezone_set('America/Lima');
                $fecha = date('m/d/Y h:i:s a', time());
                $hora=date('h:i A');
                  //$fecha=time();
                $fecha = substr($fecha, 0, 10);

                $dia = date('l', strtotime($fecha));
                $mes = date('F', strtotime($fecha));
                $anio = date('Y', strtotime($fecha));

                $numeroDia = date('d', strtotime($fecha));
                $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                 
                $sheet->setCellValue("A58", strtoupper($iestp->distrito).", $nombredia $numeroDia de $nombreMes de $anio");

                $writer = new Xlsx($spreadsheet);
                $filename = 'ACTA-FINAL-DE-EVALUACION-'.$curso->periodo.'-'.$curso->carrera.'-'.$curso->ciclol.'-'.$curso->turno.'-'.$curso->codseccion.'-'.$curso->division;
                //$filename = 'ACTA';

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
             
                $writer->save('php://output'); // download file 
            }
        }
    }

    //dp=Download de Plantilla
    public function dp_ficha_matricula($codmatricula)
        {
        /*$fmcbperiodo=$this->input->get("cp");
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");*/
        $codmatricula=base64url_decode($codmatricula);
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $dominio=str_replace(".", "_",getDominio());
        $spreadsheet = $reader->load("plantillas/ficha-matricula_".$dominio.".xlsx");
        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();
        $this->load->model('mmatricula');
        $this->load->model('msede');
        $inscs=$this->mmatricula->m_get_matricula_pdf(array($codmatricula));
        foreach ($inscs as $insc) {
            $curs=$this->mmatricula->m_miscursos_x_matricula(array($codmatricula));
            $dsede = $this->msede->m_get_sedesxcodigo(array($insc->idsede));
            $spreadsheet->setActiveSheetIndex(0);
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue("G9", $ie->nombre);
            $sheet->setCellValue("G10", $ie->codmodular);
            $sheet->setCellValue("G11", $dsede->nomdep);
            $sheet->setCellValue("G12", $dsede->nomdist);
            $sheet->setCellValue("G13", $insc->carrera);
            $sheet->setCellValue("Q9", $ie->dre);
            $sheet->setCellValue("Q10", $ie->gestion);
            $sheet->setCellValue("Q11", $dsede->nomprov);
            $sheet->setCellValue("Q12", $insc->periodo);
            $sheet->setCellValue("Q13", $insc->ciclo);
            $sheet->setCellValue("Q14", $insc->nivel);
            $sheet->setCellValue("G16", $insc->dni);
            $sheet->setCellValue("G17", $insc->paterno." ".$insc->materno." ".$insc->nombres);

                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('logo');
                $drawing->setDescription('logo');
                $drawing->setPath('resources/img/logo_h80.'.getDominio().'.png'); // put your path and image here
                $drawing->setCoordinates('R1');
                $colWidth = $sheet->getColumnDimension('R')->getWidth();
                if ($colWidth == -1) { //not defined which means we have the standard width
                    $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
                } else {                  //innner width is 8.43 char units
                    $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
                }
                $offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
                $drawing->setOffsetX($offsetX-14); //p
                $drawing->getShadow()->setVisible(true);
                $drawing->setWorksheet($sheet);

            $nro=0;
            $isrepite=false;
            $vhoras=0;
            $vcre=0;
            $fila=20;
            foreach ($curs as $kc => $cur) {
                if ($cur->repite=='NO'){
                    $nro++;
                    $fila++;

                    $sheet->setCellValue("A".$fila, $nro);
                    $sheet->setCellValue("B".$fila, $cur->curso);
                    $sheet->setCellValue("O".$fila, $cur->nromodulo);  
                    $sheet->setCellValue("P".$fila, $cur->cp + $cur->ct);
                    $sheet->setCellValue("Q".$fila, $cur->hts + $cur->hps);
                    unset($curs[$kc]);
                }
                else{
                    $isrepite=true;
                }
            }
   
            $fila=34;
            $nro=0;
            foreach ($curs as $key => $cur) {
                $nro++;
                $fila++;

                $sheet->setCellValue("A".$fila, $nro);
                $sheet->setCellValue("B".$fila, $cur->curso);
                $sheet->setCellValue("O".$fila, $cur->nromodulo);  
                $sheet->setCellValue("P".$fila, $cur->cp + $cur->ct);
                $sheet->setCellValue("Q".$fila, $cur->hts + $cur->hps);
            }
            $fecha = substr($insc->fecha, 0, 10);
            $numeroDia = date('d', strtotime($fecha));
            $dia = date('j', strtotime($fecha));
            $mes = date('n', strtotime($fecha));
            $anio = date('Y', strtotime($fecha));
            $sheet->setCellValue("A41", $dia);
            $sheet->setCellValue("B41", $mes);
            $sheet->setCellValue("C41", $anio);  

            $writer = new Xlsx($spreadsheet);
            $filename = 'FM-'.$insc->carne;
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output'); // download file
        }
    }

    public function dp_pre_inscripciones()
    {
        
        $carrera=$this->input->get("cc");
        $busqueda=$this->input->get("ap");
        $periodo=$this->input->get("cp");
        $accion=$this->input->get("acc");
        $tipo=$this->input->get("tip");
        $estado=$this->input->get("status");
        $fechaini = $this->input->get("fec1");
        $fechafin = $this->input->get("fec2");
        $this->load->model('mprematricula');

        
        $databuscar=array('%'.$busqueda.'%', $carrera, $periodo, $tipo, $estado);
        
        if ($fechaini != "" && $fechafin != "") {
            $horaini = ' 00:00:01';
            $horafin = ' 23:59:59';
            $databuscar[]=$fechaini.$horaini;
            $databuscar[]=$fechafin.$horafin;
        }
        elseif ($fechaini == "" && $fechafin == "") {
            /*$fechaini='1990-01-01 00:00:01';
            $fechafin=date("Y-m-d").' 23:59:59';*/
        }
        elseif ($fechaini == "") {
            $fechaini='1990-01-01 00:00:01';
            $fechafin=$fechafin.' 23:59:59';
            $databuscar[]=$fechaini;
            $databuscar[]=$fechafin;
        }
        else{
            $fechaini=$fechaini.' 00:00:01';
            $fechafin=date("Y-m-d").' 23:59:59';
            $databuscar[]=$fechaini;
            $databuscar[]=$fechafin;
        }

        $vprematriculas=$this->mprematricula->m_dtsPreinscripcionxfechas( $databuscar );
        

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp-lista-pre-inscripciones.xlsx");

        
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        
        $fila=4;
        $nro=0;
        $strtimeact=strtotime("now");
        foreach ($vprematriculas as $rpdata) {
            $nro++;
            $fila++;
            
            $sheet->setCellValue("A".$fila, $nro);
            $sheet->setCellValue("B".$fila, $rpdata->estado);
            $sheet->setCellValue("C".$fila, $rpdata->tipo);
            $sheet->setCellValue("D".$fila, $rpdata->periodo);
            $sheet->setCellValue("E".$fila, $rpdata->carrera);
            $sheet->setCellValue("F".$fila, $rpdata->ape_paterno);
            $sheet->setCellValue('G'.$fila, $rpdata->ape_materno);
            $sheet->setCellValue('H'.$fila, $rpdata->nombres);
            $sheet->setCellValue('I'.$fila, date_format(date_create($rpdata->fechanac),"d/m/Y"));
            $sheet->setCellValue('J'.$fila, $rpdata->tipodoc.'-'.$rpdata->documento);
            $sheet->setCellValue('K'.$fila, $rpdata->telefono);
            $sheet->setCellValue('L'.$fila, $rpdata->correo);
            $sheet->setCellValue('M'.$fila, date_format(date_create($rpdata->fecha),"d/m/Y"));
            
          

        }
        foreach(range('A','H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'lista-pre-inscripciones';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

    public function dp_registro_auxiliar_curso($codcarga,$division)
    {
        if (($_SESSION['userActivo']->codnivel != 3)) {
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $this->load->model('mcargasubseccion');
            $curso = $this->mcargasubseccion->m_get_carga_subseccion_todos(array($codcarga,$division));
            if (isset($curso)) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $dominio=str_replace(".", "_",getDominio());
                $spreadsheet = $reader->load("plantillas/registro_auxiliar_".$dominio.".xlsx");

                $spreadsheet->setActiveSheetIndex(0);
                $sheet = $spreadsheet->getActiveSheet();

                $this->load->model('mmiembros');
                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();

                $sheet->setCellValue("C2", $curso->carrera);
                $sheet->setCellValue("AC2", $curso->ciclol.' '.$curso->codseccion.'-'.$curso->division);
                $sheet->setCellValue("AC3", $curso->turno);
                $sheet->setCellValue("C3", $curso->paterno." ".$curso->materno." ".$curso->nombres );

                $nro=0;
                $fila=5;
                foreach ($miembros as $mat) {
                    $nro++;
                    $fila++;
                    $sheet->setCellValue('B'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
                    
                }
                $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                date_default_timezone_set('America/Lima');
                $fecha = date('m/d/Y h:i:s a', time());
                $hora=date('h:i A');
                  //$fecha=time();
                $fecha = substr($fecha, 0, 10);

                $dia = date('l', strtotime($fecha));
                $mes = date('F', strtotime($fecha));
                $anio = date('Y', strtotime($fecha));

                $numeroDia = date('d', strtotime($fecha));
                $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                 
                $sheet->setCellValue("A68", strtoupper($iestp->distrito).", $nombredia $numeroDia de $nombreMes de $anio");

                $writer = new Xlsx($spreadsheet);
                $filename = 'REGISTRO-AUXILIAR-'.$curso->periodo.'-'.$curso->carrera.'-'.$curso->ciclol.'-'.$curso->turno.'-'.$curso->codseccion.'-'.$curso->division;
                

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
             
                $writer->save('php://output'); // download file 
            }
        }
    }

    public function dp_lista_simple_curso($codcarga,$division)
    {
        if (($_SESSION['userActivo']->codnivel != 3)) {
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $this->load->model('mcargasubseccion');
            $curso = $this->mcargasubseccion->m_get_carga_subseccion_todos(array($codcarga,$division));
            if (isset($curso)) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $dominio=str_replace(".", "_",getDominio());
                $spreadsheet = $reader->load("plantillas/rp_curso_miembros_".$dominio.".xlsx");

                $spreadsheet->setActiveSheetIndex(0);
                $sheet = $spreadsheet->getActiveSheet();

                $this->load->model('mmiembros');
                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();

                $sheet->setCellValue("C3", $curso->periodo);
                $sheet->setCellValue("F3", $curso->carrera);
                $sheet->setCellValue("C4", $curso->ciclo);
                $sheet->setCellValue("F4", $curso->turno);
                $sheet->setCellValue("H4", $curso->codseccion.'-'.$curso->division);
                $sheet->setCellValue("C5", $curso->paterno." ".$curso->materno." ".$curso->nombres );
                $sheet->setCellValue("D6", $curso->unidad);
                
                $nro=0;
                $fila=8;
                foreach ($miembros as $mat) {
                    $nro++;
                    $fila++;
                    $sheet->setCellValue('B'.$fila, $mat->dni);
                    $sheet->setCellValue('D'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
                    
                }
                $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                date_default_timezone_set('America/Lima');
                $fecha = date('m/d/Y h:i:s a', time());
                $hora=date('h:i A');
                  //$fecha=time();
                $fecha = substr($fecha, 0, 10);

                $dia = date('l', strtotime($fecha));
                $mes = date('F', strtotime($fecha));
                $anio = date('Y', strtotime($fecha));

                $numeroDia = date('d', strtotime($fecha));
                $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                 
                $sheet->setCellValue("G52", strtoupper($iestp->distrito).", $nombredia $numeroDia de $nombreMes de $anio");

                $writer = new Xlsx($spreadsheet);
                $filename = 'MATRIC. UNIDAD DIDAC_'.$curso->ciclo."_".slugs($curso->unidad)."_".$curso->periodo.'-'.$curso->carrera.'-'.$curso->ciclo.'-'.$curso->turno.'-'.$curso->codseccion.$curso->division;
                

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
             
                $writer->save('php://output'); // download file 
            }
        }
    }


    public function vir_evaluacion_excel($codcarga,$division,$codmaterial)
    {
        if (($_SESSION['userActivo']->codnivel != 3)) {
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $idmaterial=base64url_decode($codmaterial);
            $this->load->model('mcargasubseccion');
            $curso = $this->mcargasubseccion->m_get_carga_subseccion_todos(array($codcarga,$division));
            if (isset($curso)) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $dominio=str_replace(".", "_",getDominio());
                $spreadsheet = $reader->load("plantillas/rp_virtual_evaluaciones.xlsx");

                $spreadsheet->setActiveSheetIndex(0);
                $sheet = $spreadsheet->getActiveSheet();

                $this->load->model('mmiembros');
                $this->load->model('mvirtual');
                $this->load->model('mvirtualevaluacion');
                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                $material = $this->mvirtual->m_get_material(array($idmaterial));
                $evaluaciones = $this->mvirtualevaluacion->m_get_evaluaciones_entregadas($idmaterial);

                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();

                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('logo');
                $drawing->setDescription('logo');
                $drawing->setPath('resources/img/logo_h80.'.getDominio().'.png'); // put your path and image here
                $drawing->setCoordinates('E2');
                $colWidth = $sheet->getColumnDimension('A')->getWidth() + $sheet->getColumnDimension('E')->getWidth();
                if ($colWidth == -1) { //no definido, lo que significa que tenemos el ancho estándar
                    $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
                } else {                  //innner width is 8.43 char units
                    $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
                }
                $offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
                $drawing->setOffsetX($offsetX); //p
                $drawing->getShadow()->setVisible(true);
                $drawing->setWorksheet($sheet);

                $sheet->setCellValue("F3", $iestp->denoml);
                $sheet->setCellValue("F4", 'EVALUACIONES '.$iestp->nombre);
                $sheet->setCellValue("C6", $curso->periodo);
                $sheet->setCellValue("E6", $curso->carrera);
                $sheet->setCellValue("C7", $curso->ciclo);
                $sheet->setCellValue("E7", $curso->turno);
                $sheet->setCellValue("I7", $curso->codseccion.$curso->division);
                $sheet->setCellValue("C8", $curso->paterno." ".$curso->materno." ".$curso->nombres );
                $sheet->setCellValue("C9", $curso->unidad);
                $sheet->setCellValue("C10", $material->nombre);

                $nro=0;
                $fila=12;
                $dias_ES1 = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
                $meses_ES1 = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
                foreach ($miembros as $mat) {
                    $nro++;
                    $fila++;
                    
                    $sheet->setCellValue('A'.$fila, $nro);
                    if ($nro > 40) {
                        $sheet->mergeCells("B".$fila.":C".$fila);
                        $sheet->getStyle("B".$fila.":C".$fila)
                        ->getAlignment() 
                        ->setHorizontal('center');
                    }
                    $sheet->setCellValue('B'.$fila, $mat->dni);
                    if ($nro > 40) {
                        $sheet->mergeCells("D".$fila.":G".$fila);
                        $sheet->getStyle("D".$fila.":G".$fila)
                        ->getAlignment() 
                        ->setHorizontal('left');
                    }
                    $sheet->setCellValue('D'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
                    $entrega = "-Sin entregar";
                    $nota = "0";
                    foreach ($evaluaciones as $keyeva => $eva) {
                        if ($mat->idmiembro == $eva->codmiembro) {
                            $nota = ($eva->nota=="") ? "0" : str_pad($eva->nota, 2, "0", STR_PAD_LEFT);
                            if ($eva->fentrega!=""){
                                $entrega = fechaCastellano($eva->fentrega,$meses_ES1,$dias_ES1)." ".date("h:i a",strtotime($eva->fentrega));
                            }
                            unset($evaluaciones[$keyeva]);
                        }
                        
                    }
                    if ($nro > 40) {
                        $sheet->mergeCells("H".$fila.":I".$fila);
                        $sheet->getStyle("H".$fila.":I".$fila)
                        ->getAlignment() 
                        ->setHorizontal('center');
                    }
                    $sheet->setCellValue('H'.$fila, $entrega);
                    $sheet->setCellValue('J'.$fila, $nota);

                    if ($nro > 40) {
                        $sheet->getStyle("A".$fila.":J".$fila)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(Border::BORDER_THIN);
                    }
                    
                }
                $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                date_default_timezone_set('America/Lima');
                $fecha = date('m/d/Y h:i:s a', time());
                $hora=date('h:i A');
                  //$fecha=time();
                $fecha = substr($fecha, 0, 10);

                $dia = date('l', strtotime($fecha));
                $mes = date('F', strtotime($fecha));
                $anio = date('Y', strtotime($fecha));

                $numeroDia = date('d', strtotime($fecha));
                $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                
                if ($nro < 40) {
                    $fila = 52;
                }

                $sheet->mergeCells("A".($fila+2).":J".($fila+2));
                $sheet->getStyle("A".($fila+2).":J".($fila+2))->getFont()->setBold(true)->setSize(11);
                $sheet->getStyle("A".($fila+2).":J".($fila+2))
                        ->getAlignment() 
                        ->setHorizontal('right');
                $sheet->setCellValue("A".($fila+2), strtoupper($iestp->distrito).", $nombredia $numeroDia de $nombreMes de $anio");

                $writer = new Xlsx($spreadsheet);
                $filename = 'EVALUACIONES-'.$curso->periodo.'-'.$curso->carrera.'-'.$curso->ciclol.'-'.$curso->turno.'-'.$curso->codseccion.'-'.$curso->division.'-'.$material->nombre;

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
             
                $writer->save('php://output'); // download file 
            }
        }
    }
    public function vir_tareas_excel($codcarga,$division,$codmaterial)
    {
        if (($_SESSION['userActivo']->codnivel != 3)) {
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $idmaterial=base64url_decode($codmaterial);
            $this->load->model('mcargasubseccion');
            $curso = $this->mcargasubseccion->m_get_carga_subseccion_todos(array($codcarga,$division));
            if (isset($curso)) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $dominio=str_replace(".", "_",getDominio());
                $spreadsheet = $reader->load("plantillas/rp_virtual_tareas.xlsx");

                $spreadsheet->setActiveSheetIndex(0);
                $sheet = $spreadsheet->getActiveSheet();

                $this->load->model('mmiembros');
                $this->load->model('mvirtual');
                $this->load->model('mvirtualtarea');
                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                $material = $this->mvirtual->m_get_material(array($idmaterial));
                $tareas = $this->mvirtualtarea->m_get_tareas_entregadas($idmaterial);

                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();

                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('logo');
                $drawing->setDescription('logo');
                $drawing->setPath('resources/img/logo_h80.'.getDominio().'.png'); // put your path and image here
                $drawing->setCoordinates('A1');
                $colWidth = $sheet->getColumnDimension('B')->getWidth() + $sheet->getColumnDimension('C')->getWidth();
                if ($colWidth == -1) { //no definido, lo que significa que tenemos el ancho estándar
                    $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
                } else {                  //innner width is 8.43 char units
                    $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
                }
                $offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
                $drawing->setOffsetX($offsetX); //p
                $drawing->getShadow()->setVisible(true);
                $drawing->setWorksheet($sheet);

                $sheet->setCellValue("C2", $iestp->denoml);
                $sheet->setCellValue("C3", 'EVALUACIÓN TAREAS '.$iestp->nombre);
                $sheet->setCellValue("C5", $curso->periodo);
                $sheet->setCellValue("E5", $curso->carrera);
                $sheet->setCellValue("C6", $curso->ciclo);
                $sheet->setCellValue("E6", $curso->turno);
                $sheet->setCellValue("I6", $curso->codseccion.$curso->division);
                $sheet->setCellValue("C7", $curso->paterno." ".$curso->materno." ".$curso->nombres );
                $sheet->setCellValue("C8", $curso->unidad);
                $sheet->setCellValue("C9", $material->nombre);

                $nro=0;
                $fila=11;
                $dias_ES1 = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
                $meses_ES1 = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
                foreach ($miembros as $mat) {
                    $nro++;
                    $fila++;
                    $sheet->setCellValue('B'.$fila, $mat->dni);
                    $sheet->setCellValue('D'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
                    $entrega = "-Sin entregar";
                    $nota = "0";
                    foreach ($tareas as $keytar => $tar) {
                        if ($mat->idmiembro == $tar->codmiembro) {
                            $nota = ($tar->nota=="") ? "0" : str_pad($tar->nota, 2, "0", STR_PAD_LEFT);
                            if ($tar->fentrega!=""){
                                $entrega = fechaCastellano($tar->fentrega,$meses_ES1,$dias_ES1)." ".date("h:i a",strtotime($tar->fentrega));
                            }
                            unset($tareas[$keytar]);
                        }
                        
                    }
                    $sheet->setCellValue('H'.$fila, $entrega);
                    $sheet->setCellValue('J'.$fila, $nota);
                    
                }
                $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                date_default_timezone_set('America/Lima');
                $fecha = date('m/d/Y h:i:s a', time());
                $hora=date('h:i A');
                  //$fecha=time();
                $fecha = substr($fecha, 0, 10);

                $dia = date('l', strtotime($fecha));
                $mes = date('F', strtotime($fecha));
                $anio = date('Y', strtotime($fecha));

                $numeroDia = date('d', strtotime($fecha));
                $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                 
                $sheet->setCellValue("A53", strtoupper($iestp->distrito).", $nombredia $numeroDia de $nombreMes de $anio");

                $writer = new Xlsx($spreadsheet);
                $filename = 'EVALUACIÓN-TAREAS-'.$curso->periodo.'-'.$curso->carrera.'-'.$curso->ciclol.'-'.$curso->turno.'-'.$curso->codseccion.'-'.$curso->division.'-'.$material->nombre;

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
             
                $writer->save('php://output'); // download file 
            }
        }
    }



    public function vw_registro_final_clasico_excel($codcarga,$division)
    {
        //if (($_SESSION['userActivo']->codnivel != 3)) {
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $dias_ES1 = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
            $meses_ES1 = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");

            $this->load->model('mcargasubseccion');
            $curso = $this->mcargasubseccion->m_get_carga_subseccion_todos(array($codcarga,$division));
            if (isset($curso)) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $dominio=str_replace(".", "_",getDominio());
                $spreadsheet = $reader->load("plantillas/registro_final_".$dominio.".xlsx");

                $spreadsheet->setActiveSheetIndex(0);
                $sheet = $spreadsheet->getActiveSheet();

                $this->load->model('mevaluaciones');
                $this->load->model('masistencias');
                $this->load->model('mmiembros');
                $this->load->model('msesiones');
                
                $fechas=     $this->masistencias->m_fechas_x_curso(array($codcarga,$division));
                $fechas_total=$curso->sesiones;
                $asistencias= $this->masistencias->m_asistencias_x_curso(array($codcarga,$division));

                $sesiones= $this->msesiones->m_sesiones_x_curso_reg(array($codcarga,$division));
                $indicadores= $this->mevaluaciones->m_get_indicadores_por_carga_division(array($codcarga,$division));
                if (getDominio()=="charlesashbee.edu.pe"){
                    $subindicadores= $this->mcargasubseccion->m_get_carga_subseccion_indicadores(array($codcarga,$division));
                    $subindicadores=$subindicadores;
                }
                
                $evaluaciones = $this->mevaluaciones->m_eval_head_x_curso(array($codcarga,$division));
                $notas        = $this->mevaluaciones->m_notas_x_curso(array($codcarga,$division));
                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                $alumno= array();

                $nro=0;

                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();

                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('logo');
                $drawing->setDescription('logo');
                $drawing->setPath('resources/img/logo_h80.'.getDominio().'.png'); // put your path and image here
                $drawing->setCoordinates('AW3');
                $colWidth = $sheet->getColumnDimension('AW')->getWidth() + $sheet->getColumnDimension('AX')->getWidth();
                if ($colWidth == -1) { //no definido, lo que significa que tenemos el ancho estándar
                    $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
                } else {                  //innner width is 8.43 char units
                    $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
                }
                $offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
                $drawing->setOffsetX($offsetX); //p
                $drawing->getShadow()->setVisible(true);
                $drawing->setWorksheet($sheet);

                $sheet->setCellValue("AO20", $iestp->denoml);
                $sheet->setCellValue("AN11", "REGISTRO  DE EVALUACIÓN Y NOTAS ".$curso->periodo);
                $sheet->setCellValue("AO22", $iestp->resolucion);
                $sheet->setCellValue("AU38", $curso->periodo);
                $sheet->setCellValue("AO25", $curso->carrera);
                $sheet->setCellValue("AV28", $curso->modulonro);
                $sheet->setCellValue("AO31", $curso->modulo);
                $sheet->setCellValue("AO35", $curso->unidad);
                $sheet->setCellValue("AT38", $curso->periodo);
                $sheet->setCellValue("AU40", ($curso->cred_teo + $curso->cred_pra));
                $sheet->setCellValue("AU42", $curso->hsem_teo + $curso->hsem_pra);
                $sheet->setCellValue("AT44", $curso->paterno." ".$curso->materno." ".$curso->nombres );
                $sheet->setCellValue("AT47", $curso->codseccion.'-'.$curso->division);
                $sheet->setCellValue("AX47", $curso->turno);

                //$sheet->setCellValue("W59", $curso->unidad);
                
                
                
                foreach ($miembros as $miembro) {
                    //if ($miembro->eliminado=='NO'){
                        $alumno[$miembro->idmiembro]['eval'] = array();
                        $alumno[$miembro->idmiembro]['eval']['RC']['tipo'] = "M"; 
                        $alumno[$miembro->idmiembro]['eval']['RC']['nota']= $miembro->recuperacion;

                        $alumno[$miembro->idmiembro]['eval']['PI']['tipo'] = "C"; 
                        $alumno[$miembro->idmiembro]['eval']['PI']['nota']= $miembro->final;

                        foreach ($indicadores as $indicador) {
                            foreach ($evaluaciones as $evaluacion) {
                                if ($indicador->codigo==$evaluacion->indicador){
                                    $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->evaluacion]=array();
                                    
                                    $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->abrevia]['nota'] = "";
 
                                    foreach ($notas as $nota) {
                                        if (($miembro->idmiembro==$nota->idmiembro)&&($evaluacion->evaluacion==$nota->evaluacion)){
                                            $alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador][$evaluacion->abrevia]['nota'] = $nota->nota; 
                                            $alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador][$evaluacion->abrevia]['idnota'] = $nota->id;    
                                        }
                                    }
                                }
                            }
                        }

                        $alumno=getNotasAlumnos($miembro,$indicadores,$evaluaciones,$alumno);


                        //ASISTENCIAS
                        $alumno[$miembro->idmiembro]['asis'] = array();
                        $alumno[$miembro->idmiembro]['asis']['faltas'] = 0;  
                        $alumno[$miembro->idmiembro]['asis']['faltasp'] = 0;
                        //$n=0;
                        foreach ($fechas as $fecha) {
                            //$n--;
                            
                            $alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'] = "";  
                            foreach ($asistencias as $asistencia) {
                                if (($miembro->idmiembro==$asistencia->idmiembro)&&($asistencia->sesion==$fecha->sesion)){
                                    
                                    $alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'] = $asistencia->accion;  
                                    //if (($asistencia->accion=="F") || ($asistencia->accion=="")){
                                    if ($asistencia->accion=="F") {
                                        $alumno[$miembro->idmiembro]['asis']['faltas']++;  
                                    }
                                }
                            }
                        }
                        if ($fechas_total>0){
                          $alumno[$miembro->idmiembro]['asis']['faltasp']= round($alumno[$miembro->idmiembro]['asis']['faltas']/ $fechas_total * 100);  
                        } 
                    //}
                }

                //TITULOS DE FECHA
                $colAsistencia=2;
                for ($i=0; $i <16 ; $i++) {
                    if (isset($fechas[$i])){
                        $fecha=$fechas[$i];
                        $fechaslt=date("d-m", strtotime($fecha->fecha));
                        $colAsistencia++;
                        
                        $sheet->setCellValueByColumnAndRow($colAsistencia,8, $fechaslt);
                    }

                }
                $colAsistencia=2;
                for ($i=16; $i <55 ; $i++) {
                    if (isset($fechas[$i])){
                        $fecha=$fechas[$i];
                        $fechaslt=date("d-m", strtotime($fecha->fecha));
                        $colAsistencia++;
                        
                        $sheet->setCellValueByColumnAndRow($colAsistencia,123, $fechaslt);
                    }
                    
                }

                $colAsistencia=2;
                for ($i=55; $i <94 ; $i++) {
                    if (isset($fechas[$i])){
                        $fecha=$fechas[$i];
                        $fechaslt=date("d-m", strtotime($fecha->fecha));
                        $colAsistencia++;
                        
                        $sheet->setCellValueByColumnAndRow($colAsistencia,179, $fechaslt);
                    }
                    
                }



                //ASIST
                $nro=0;
                $fila=66;
                $filaAsistencia1=10;
                $filaAsistencia2=125;
                $filaAsistencia3=181;
                $filaindc=66;
                $nind=0;
                $nses=$curso->sesiones;
                $nindmax=14;
                
                foreach ($miembros as $mb) {
                    //var_dump($alumno[$mb->idmiembro]['asis']);
                    //echo "<br>";
                    //echo "<br>";
                    $nro++;
                    $fila++;//67
                    $sheet->setCellValue('C'.$fila, $mb->paterno." ".$mb->materno." ".$mb->nombres);
                    //$fechaEscritas=0;
                    
                    
                    $filaAsistencia1++;
                    $colAsistencia=2;
                    for ($i=0; $i <16 ; $i++) {

                        if (isset($fechas[$i])){
                            $fecha=$fechas[$i];
                            $colAsistencia++;
                            //$valor=$alumno[$mb->idmiembro]['asis'][$fecha->sesion]['accion'];
                            $sheet->setCellValueByColumnAndRow($colAsistencia,$filaAsistencia1, $alumno[$mb->idmiembro]['asis'][$fecha->sesion]['accion']);
                        }
                        else{
                            $i=16;
                        }

                    }
                    $sheet->setCellValue("S".$filaAsistencia1, $alumno[$mb->idmiembro]['asis']['faltas']);
                    $sheet->setCellValue("T".$filaAsistencia1, $alumno[$mb->idmiembro]['asis']['faltasp']);
                    
                    $filaAsistencia2++;
                    $colAsistencia=2;
                    for ($i=16; $i <55 ; $i++) {
                        if (isset($fechas[$i])){
                            $fecha=$fechas[$i];
                            $colAsistencia++;
                            //$valor=$alumno[$mb->idmiembro]['asis'][$fecha->sesion]['accion'];
                            $sheet->setCellValueByColumnAndRow($colAsistencia,$filaAsistencia2, $alumno[$mb->idmiembro]['asis'][$fecha->sesion]['accion']);
                        }
                        else{
                            $i=55;
                        }
                    }
                    if ($fechas_total>16){
                        $sheet->setCellValue("AP".$filaAsistencia2, $alumno[$mb->idmiembro]['asis']['faltas']);
                        $sheet->setCellValue("AQ".$filaAsistencia2, $alumno[$mb->idmiembro]['asis']['faltasp']);    
                    }
                    


                    $filaAsistencia3++;
                    $colAsistencia=2;
                    for ($i=55; $i <94 ; $i++) {
                    
                        if (isset($fechas[$i])){
                            $fecha=$fechas[$i];
                            $colAsistencia++;
                            $sheet->setCellValueByColumnAndRow($colAsistencia,$filaAsistencia3, $alumno[$mb->idmiembro]['asis'][$fecha->sesion]['accion']);
                        }
                        else{
                            $i=95;
                        }
                    }
                    if ($fechas_total>55){
                        $sheet->setCellValue("AP".$filaAsistencia3, $alumno[$mb->idmiembro]['asis']['faltas']);
                        $sheet->setCellValue("AQ".$filaAsistencia3, $alumno[$mb->idmiembro]['asis']['faltasp']);
                    }

                    //INDICADORES DE LOGRO
                    $filaind=3;
                    foreach ($indicadores as $ind) {

                        $filaind++;
                        
                        $sheet->setCellValueByColumnAndRow(24,$filaind, $ind->nombre);
                        $filaind = $filaind + 3;
                    }

                    //INDICADORES
                    $filaindc++;
                    $colindc=19;
                    for ($i=0; $i <$nindmax ; $i++) {
                                                
                            $nind++;
                            if (isset($indicadores[$i])){
                                $indicador=$indicadores[$i];
                                $colindc++;
                                $nota=0;
                                $notar=0;
                                /////////////
                                if (getDominio()=="iestphuarmaca.edu.pe"){
                                    
                                    $nota=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['PI']['nota'];
                                    $notar=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['RC']['nota'];
                                }
                                else if (getDominio()=="iestpcanchaque.edu.pe"){
                                    

                                    $nota=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['PI']['nota'];
                                    $notar=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['RI']['nota'];
                                }
                                else if (getDominio()=="iesap.edu.pe"){
                                    

                                    $nota=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['EU']['nota'];
                                    $notar=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['RC']['nota'];
                                }
                                else if (getDominio()=="iestbellavista.edu.pe"){
                                    

                                    $nota=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['PI']['nota'];
                                    $notar=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['RI']['nota'];
                                }
                                ///////////////////
                               
                                $notaid=($nota>$notar) ? $nota : $notar;
                                $sheet->setCellValueByColumnAndRow($colindc,$filaindc, str_pad(floatval($notaid), 2, "0", STR_PAD_LEFT));
                                $colindc++;
                            }

                    }
                    for ($i=$nind + 1; $i <= $nindmax; $i++) { 
                        $colindc++;
                        $sheet->setCellValueByColumnAndRow($colindc,$filaindc, "--");
                        $colindc++;
                    }

                    

                    //$pf=$alumno[$mb->idmiembro]['eval']['PF']['nota'];
                    $sheet->setCellValue("AV".$filaindc, str_pad(floatval($alumno[$mb->idmiembro]['eval']['PI']['nota']), 2, "0", STR_PAD_LEFT));

                    //COLUMNA DE RECUPERACIÓN
                    $sheet->setCellValue("AX".$filaindc, $alumno[$mb->idmiembro]['eval']['RC']['nota']);

                }

                $fini=0;
                $ffin=16;
                                               

                $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                date_default_timezone_set('America/Lima');
                $fecha = date('m/d/Y h:i:s a', time());
                $hora=date('h:i A');
                  //$fecha=time();
                $fecha = substr($fecha, 0, 10);

                $dia = date('l', strtotime($fecha));
                $mes = date('F', strtotime($fecha));
                $anio = date('Y', strtotime($fecha));

                $numeroDia = date('d', strtotime($fecha));
                $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                 
                $sheet->setCellValue("AO114", strtoupper($iestp->distrito).", $nombredia $numeroDia de $nombreMes de $anio");

                $writer = new Xlsx($spreadsheet);
                $filename = 'REGISTRO_FINAL-'.$curso->periodo.'-'.$curso->carrera.'-'.$curso->ciclol.'-'.$curso->turno.'-'.$curso->codseccion.'-'.$curso->division;

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
             
                $writer->save('php://output'); // download file 
            }
        //}
    }

    public function dp_reingresos()
    {
        $periodo=$this->input->get("cp");
        $carrera=$this->input->get("cc");
        $busqueda=$this->input->get("ap");
        $this->load->model('minscrito');
        $vmatriculas=$this->minscrito->m_filtrar_basico_sd_retirados(array($periodo,$carrera,$_SESSION['userActivo']->idsede,'%'.$busqueda.'%',));

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp-lista-retirados.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        
        $fila=4;
        $nro=0;
        $strtimeact=strtotime("now");
        foreach ($vmatriculas as $mat) {
            $nro++;
            $fila++;
            
            $sheet->setCellValue("A".$fila, $nro);
            $sheet->setCellValue('B'.$fila, $mat->periodo);
            $sheet->setCellValue('C'.$fila, $mat->carrera);
            $sheet->setCellValue('D'.$fila, $mat->tdoc);
            $sheet->setCellValue('E'.$fila, $mat->nro);
            $sheet->setCellValue('F'.$fila, $mat->carnet);
            $sheet->setCellValue('G'.$fila, $mat->paterno);
            $sheet->setCellValue('H'.$fila, $mat->materno);
            $sheet->setCellValue('I'.$fila, $mat->nombres);
            

            $edad=($strtimeact - strtotime($mat->fecnac))/31557600;
            $sheet->setCellValue('J'.$fila, $mat->fecnac);

            $sheet->setCellValue('K'.$fila, intval($edad));
            
            $sheet->setCellValue('L'.$fila, $mat->sexo);
            $sheet->setCellValue('M'.$fila, " ".$mat->celular);
            $sheet->setCellValue('N'.$fila, $mat->ecorporativo);
            //AQUI HAY QUE ARREGLAR LO DE DISCAPACIDAD
            $sheet->setCellValue('O'.$fila, date_format(date_create($mat->fecinsc),"d/m/Y"));
          

        }
        foreach(range('A','L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'lista-retirados';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }


  

    public function dp_registro_asistencias($codcarga,$division)
    {
        if (($_SESSION['userActivo']->tipo != 'AL')) {

            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);

            $this->load->model('mcargasubseccion');
            $curso= $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));

            if (isset($curso)) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                //$dominio=str_replace(".", "_",getDominio());
                $spreadsheet = $reader->load("plantillas/acta_asistencias_general.xlsx");

                //$spreadsheet = new Spreadsheet();
                $spreadsheet->setActiveSheetIndex(0);
                $sheet = $spreadsheet->getActiveSheet();

                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();

                $sheet->setCellValue("B6", $iestp->denoml);
                $sheet->setCellValue("C7", $curso->carrera);
                $sheet->setCellValue("C8", $curso->unidad);
                $sheet->setCellValue("C9", $curso->ciclo);
                $sheet->setCellValue("E9", $curso->turno);
                $sheet->setCellValue("K9", $curso->codseccion." ".$curso->division);
                $sheet->setCellValue("C10", $curso->paterno." ".$curso->materno." ".$curso->nombres );

                $arraymb['curso'] =$curso;
                
                $this->load->model('mevaluaciones');
                $this->load->model('masistencias');
                $this->load->model('mmiembros');

                $fechaasist= $this->masistencias->m_fechas_x_curso(array($codcarga,$division));
                $asistencias= $this->masistencias->m_asistencias_x_curso(array($codcarga,$division));

                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));

                $nro=0;
                

                $coladicionales=count($fechaasist) - 19;
                $colInsertadas=0;
                for ($i=0; $i < $coladicionales ; $i++) { 
                    $sheet->insertNewColumnBeforeByIndex(5,1); 
                    $sheet->getColumnDimension('E')->setWidth(2.7);
                    $colInsertadas++;
                    /*$sheet->duplicateStyle(
                        $sheet->getStyle('D13'),
                        'E13:D72'
                    );*/         
                }

                $endCol_letra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(26 + $colInsertadas);
                $nro=0;
                $n=0;
                $fila=12;
                $letra_final_fechas= \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(22 + $colInsertadas);
                $letra_final_a= \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(23 + $colInsertadas);
                $letra_final_f= \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(24 + $colInsertadas);
                $letra_final_t= \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(25 + $colInsertadas);
                $letra_final_j= $endCol_letra;
                foreach ($miembros as $miembro) {
                    $fila++;
                    $nro++;
                    $this->copyRows($sheet, 'A'.$fila.':'.$endCol_letra.$fila, 'A'.($fila + 1));

                    $sheet->setCellValue("A".$fila, $nro);
                    $sheet->setCellValue('B'.$fila, $miembro->carnet);
                    $sheet->setCellValue('C'.$fila, $miembro->paterno." ".$miembro->materno." ".$miembro->nombres);

                    $sheet->setCellValue($letra_final_a.$fila, '=COUNTIF(D'.$fila.':'.$letra_final_fechas.$fila.',$'.$letra_final_a.'$12)');
                    $sheet->setCellValue($letra_final_f.$fila, '=COUNTIF(D'.$fila.':'.$letra_final_fechas.$fila.',$'.$letra_final_f.'$12)');
                    $sheet->setCellValue($letra_final_t.$fila, '=COUNTIF(D'.$fila.':'.$letra_final_fechas.$fila.',$'.$letra_final_t.'$12)');
                    $sheet->setCellValue($letra_final_j.$fila, '=COUNTIF(D'.$fila.':'.$letra_final_fechas.$fila.',$'.$letra_final_j.'$12)');

                    //$activeSheet->setCellValue('D' . $i, '=SUM(' . $sumrange . ')');

                    //

                    //ASISTENCIAS
                    $alumno[$miembro->idmiembro]['asis'] = array();
                    $alumno[$miembro->idmiembro]['asis']['faltas'] = 0;  
                    //$n=0;
                    foreach ($fechaasist as $fecha) {
                                              
                        
                        $alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'] = "-";  
                        foreach ($asistencias as $asistencia) {
                            if (($miembro->idmiembro==$asistencia->idmiembro)&&($asistencia->sesion==$fecha->sesion)){
                                
                                $alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'] = $asistencia->accion;  
                                if (($asistencia->accion=="F") || ($asistencia->accion=="")){
                                    $alumno[$miembro->idmiembro]['asis']['faltas']++;  
                                }
                            }
                        }
                    }
                }


                //TITULOS DE FECHA
                $colum=3;
               
                foreach ($fechaasist as $key => $fecha) {

                        $colum++;
                        //$sheet->insertNewColumnBefore(5,1)
                        $fechaslt=date("d/m/Y", strtotime($fecha->fecha));
                        $sheet->setCellValueByColumnAndRow($colum,12, $fechaslt);

                }

                //ASIST
                $filaAsistencia1=12;
                
                foreach ($miembros as $mb) {
                    
                    $filaAsistencia1++;
                    $colAsistencia=3;

                    foreach ($fechaasist as $key => $fecha) {

                        
                            
                            $colAsistencia++;
                            $valor=$alumno[$mb->idmiembro]['asis'][$fecha->sesion]['accion'];
                            $sheet->setCellValueByColumnAndRow($colAsistencia,$filaAsistencia1, $valor);
                        

                    }
                
                    
                }



                $writer = new Xlsx($spreadsheet);
                $filename = 'REGISTRO-DE-ASISTENCIA-'.$curso->unidad;
                //$filename = 'ACTA';

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
             
                $writer->save('php://output'); // download file 

            }
            
        }
        
    }

    public function dp_registro_auxiliar_evaluaciones($codcarga,$division)
    {
        if (($_SESSION['userActivo']->tipo != 'AL')) {

            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);

            $this->load->model('mcargasubseccion');
            $curso= $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));

            if (isset($curso)) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                //$dominio=str_replace(".", "_",getDominio());
                $spreadsheet = $reader->load("plantillas/acta_evaluaciones_general.xlsx");

                //$spreadsheet = new Spreadsheet();
                $spreadsheet->setActiveSheetIndex(0);
                $sheet = $spreadsheet->getActiveSheet();

                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();

                $sheet->setCellValue("B6", $iestp->denoml);
                $sheet->setCellValue("C7", $curso->carrera);
                $sheet->setCellValue("C8", $curso->unidad);
                $sheet->setCellValue("C9", $curso->ciclo);
                $sheet->setCellValue("E9", $curso->turno);
                $sheet->setCellValue("K9", $curso->codseccion." ".$curso->division);
                $sheet->setCellValue("C10", $curso->paterno." ".$curso->materno." ".$curso->nombres );

                $arraymb['curso'] =$curso;
                
                $this->load->model('mevaluaciones');
                $this->load->model('masistencias');
                $this->load->model('mmiembros');

                $fechaasist= $this->masistencias->m_fechas_x_curso(array($codcarga,$division));
                $asistencias= $this->masistencias->m_asistencias_x_curso(array($codcarga,$division));

                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                

                $evaluaciones = $this->mevaluaciones->m_eval_head_x_curso(array($codcarga,$division));
                $notas        = $this->mevaluaciones->m_notas_x_curso(array($codcarga,$division));
                $indicadores= $this->mevaluaciones->m_get_indicadores_por_carga_division(array($codcarga,$division));
                $nro=0;
                

                $coladicionales=count($evaluaciones) - 19;
                $colInsertadas=0;
                for ($i=0; $i < $coladicionales ; $i++) { 
                    $sheet->insertNewColumnBeforeByIndex(5,1); 
                    $sheet->getColumnDimension('E')->setWidth(2.7);
                    $colInsertadas++;        
                }

                $endCol_letra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(26 + $colInsertadas);
                $nro=0;
                $n=0;
                $fila=12;
                $letra_final_fechas= \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(22 + $colInsertadas);
                $letra_final_a= \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(23 + $colInsertadas);
                $letra_final_f= \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(24 + $colInsertadas);
                $letra_final_t= \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(25 + $colInsertadas);
                $letra_final_j= $endCol_letra;
                foreach ($miembros as $miembro) {
                    $fila++;
                    $nro++;
                    $this->copyRows($sheet, 'A'.$fila.':'.$endCol_letra.$fila, 'A'.($fila + 1));

                    $sheet->setCellValue("A".$fila, $nro);
                    $sheet->setCellValue('B'.$fila, $miembro->carnet);
                    $sheet->setCellValue('C'.$fila, $miembro->paterno." ".$miembro->materno." ".$miembro->nombres);

                    $sheet->setCellValue($letra_final_a.$fila, '=COUNTIF(D'.$fila.':'.$letra_final_fechas.$fila.',$'.$letra_final_a.'$12)');
                    $sheet->setCellValue($letra_final_f.$fila, '=COUNTIF(D'.$fila.':'.$letra_final_fechas.$fila.',$'.$letra_final_f.'$12)');
                    $sheet->setCellValue($letra_final_t.$fila, '=COUNTIF(D'.$fila.':'.$letra_final_fechas.$fila.',$'.$letra_final_t.'$12)');
                    $sheet->setCellValue($letra_final_j.$fila, '=COUNTIF(D'.$fila.':'.$letra_final_fechas.$fila.',$'.$letra_final_j.'$12)');

                    //$activeSheet->setCellValue('D' . $i, '=SUM(' . $sumrange . ')');

                    //EVALUACIONES
                    $alumno[$miembro->idmiembro]['eval'] = array();
                    $alumno[$miembro->idmiembro]['eval']['RC']['tipo'] = "M"; 
                    $alumno[$miembro->idmiembro]['eval']['RC']['nota']= $miembro->recuperacion;

                    $alumno[$miembro->idmiembro]['eval']['PI']['tipo'] = "C"; 
                    $alumno[$miembro->idmiembro]['eval']['PI']['nota']= $miembro->final;
                    $np=0;
                    foreach ($indicadores as $indicador) {
                        foreach ($evaluaciones as $evaluacion) {
                            if ($indicador->codigo==$evaluacion->indicador){
                                $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->evaluacion]=array();
                                
                                $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->abrevia]['nota'] = "";

                                foreach ($notas as $keynotas => $nota) {
                                    if (($miembro->idmiembro==$nota->idmiembro)&&($evaluacion->evaluacion==$nota->evaluacion)){
                                        $np++;
                                        $alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador][$evaluacion->abrevia]['nota'] = $nota->nota; 
                                        $alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador][$evaluacion->abrevia]['idnota'] = $nota->id;    
                                        unset($notas[$keynotas]);
                                    }
                                }
                            }
                        }
                    }

                    //ASISTENCIAS
                    $alumno[$miembro->idmiembro]['asis'] = array();
                    $alumno[$miembro->idmiembro]['asis']['faltas'] = 0;  



                    $nco=0;
                    $eis=0;
                    $tais=0;
                    foreach ($indicadores as $indicador) {
                        $ep=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['PC']['nota'];
                        if (!is_numeric($ep)) $ep=0;

                        $ta=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['TA']['nota'];
                        if (!is_numeric($ta)) $ta=0;



                        

                        if ($nco<2){
                            $ei=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['EU']['nota'];
                            if (!is_numeric($ei)) $ei=0; 

                            //RECUPERACION POR INDICADOR
                            $recu_unidad=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['RC']['nota'];
                            if (!is_numeric($recu_unidad)) $recu_unidad=""; 
                            
                            if ($recu_unidad!=""){
                                if (($ep<$ta) && ($ep<$ei)){
                                    $ep=$recu_unidad;
                                }
                                else if (($ta<$ep) && ($ta<$ei)){
                                    $ta=$recu_unidad;
                                }
                                else if (($ei<$ep) && ($ei<$ta)){
                                    $ei=$recu_unidad;
                                }
                            }

                            
                            $eis= $eis + $ei;

                        }

                        $tai=round(($ep + $ta)/2,0);
                        $alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['TAI']['nota']=$tai;
                        
                        $tais=$tais + $tai;

                        
                       
                        $ultind=$indicador->codigo;
                        $nco++;

                    }
                    if ($nco==0) $nco=1;
                    
                    $tap=round($tais/$nco,0);
                    $alumno[$miembro->idmiembro]['eval']['PTA']['tipo'] = "C"; 
                    $alumno[$miembro->idmiembro]['eval']['PTA']['nota']=$tap;

                    $nco=$nco - 1;
                    if ($nco<=0) $nco=1;
                    $eip=round($eis/$nco,0);

                    $alumno[$miembro->idmiembro]['eval']['PEI']['tipo'] = "C"; 
                    $alumno[$miembro->idmiembro]['eval']['PEI']['nota']=$eip;

                    $ef=$alumno[$miembro->idmiembro]['eval'][$ultind]['EF']['nota']; 
                    if (!is_numeric($ef)) $ef=0; 


                    $pi=round(($tap * 0.3) + ($eip * 0.3) + ($ef * 0.4),0); 
                    $alumno[$miembro->idmiembro]['eval']['PI']['tipo'] = "C"; 
                    $alumno[$miembro->idmiembro]['eval']['PI']['nota']=$pi;
                    
                    $rc=$alumno[$miembro->idmiembro]['eval']['RC']['nota'];
                    if (!is_numeric($rc)) $rc=0;

                    $alumno[$miembro->idmiembro]['eval']['PF']['tipo'] = "C"; 
                    $alumno[$miembro->idmiembro]['eval']['PF']['nota']=($pi>$rc) ? $pi : $rc;
                }


                //TITULOS DE FECHA
                $colum=3;
                foreach ($indicadores as $indicador) {
                    foreach ($evaluaciones as $key => $evaluacion) {
                        if ($evaluacion->indicador==$indicador->codigo){
                            $colum++;
                        //$sheet->insertNewColumnBefore(5,1)
                        //$fechaslt=date("d/m/Y", strtotime($fecha->fecha));
                            $sheet->setCellValueByColumnAndRow($colum,12, $evaluacion->abrevia.$indicador->norden);
                        }
                    }
                }

                //ASIST
                $filaAsistencia1=12;


               


                
                foreach ($miembros as $mb) {
                    //var_dump($alumno[$miembro->idmiembro]);
                    //var_dump("********************************");
                    $filaAsistencia1++;
                    $colAsistencia=3;
                    $ni=0;
                    foreach ($indicadores as $indicador) {

                        $ni++;
                        foreach ($evaluaciones as $key => $evaluacion) {
                            if ($evaluacion->indicador==$indicador->codigo){

                                $colAsistencia++;
                                //$valor=$alumno[$mb->idmiembro]['asis'][$evaluacion->evaluacion]['nota'];
                                //$valor=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->abrevia]['nota'];
                                $valor=$alumno[$mb->idmiembro]['eval'][$evaluacion->indicador][$evaluacion->abrevia]['nota'];
                                $sheet->setCellValueByColumnAndRow($colAsistencia,$filaAsistencia1, $valor);
                            }
                            //if ($ni<3){
                               
                            /*}
                            else{
                                
                                $colAsistencia++;
                                //$valor=$alumno[$mb->idmiembro]['asis'][$evaluacion->evaluacion]['nota'];
                                $valor=$alumno[$miembro->idmiembro]['eval'][$ultind]['EF']['nota']; 
                                $sheet->setCellValueByColumnAndRow($colAsistencia,$filaAsistencia1, $valor);
                            }*/
                            
                                
                                
                            

                        }
                    }
                
                    
                }



                $writer = new Xlsx($spreadsheet);
                $filename = 'REGISTRO-DE-ASISTENCIA-'.$curso->unidad;
                //$filename = 'ACTA';

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
             
                $writer->save('php://output'); // download file 

            }
            
        }
        
    }

    public static function copyRows(  $sheet, $srcRange, $dstCell,  $destSheet = null) {

        if( !isset($destSheet)) {
            $destSheet = $sheet;
        }

        if( !preg_match('/^([A-Z]+)(\d+):([A-Z]+)(\d+)$/', $srcRange, $srcRangeMatch) ) {
            // Invalid src range
            return;
        }

        if( !preg_match('/^([A-Z]+)(\d+)$/', $dstCell, $destCellMatch) ) {
            // Invalid dest cell
            return;
        }

        $srcColumnStart = $srcRangeMatch[1];
        $srcRowStart = $srcRangeMatch[2];
        $srcColumnEnd = $srcRangeMatch[3];
        $srcRowEnd = $srcRangeMatch[4];

        $destColumnStart = $destCellMatch[1];
        $destRowStart = $destCellMatch[2];

        $srcColumnStart = Coordinate::columnIndexFromString($srcColumnStart);
        $srcColumnEnd = Coordinate::columnIndexFromString($srcColumnEnd);
        $destColumnStart = Coordinate::columnIndexFromString($destColumnStart);

        $rowCount = 0;
        for ($row = $srcRowStart; $row <= $srcRowEnd; $row++) {
            $colCount = 0;
            for ($col = $srcColumnStart; $col <= $srcColumnEnd; $col++) {
                $cell = $sheet->getCellByColumnAndRow($col, $row);
                $style = $sheet->getStyleByColumnAndRow($col, $row);
                $dstCell = Coordinate::stringFromColumnIndex($destColumnStart + $colCount) . (string)($destRowStart + $rowCount);
                $destSheet->setCellValue($dstCell, $cell->getValue());
                $destSheet->duplicateStyle($style, $dstCell);

                // Set width of column, but only once per column
                if ($rowCount === 0) {
                    $w = $sheet->getColumnDimensionByColumn($col)->getWidth();
                    $destSheet->getColumnDimensionByColumn ($destColumnStart + $colCount)->setAutoSize(false);
                    $destSheet->getColumnDimensionByColumn ($destColumnStart + $colCount)->setWidth($w);
                }

                $colCount++;
            }

            $h = $sheet->getRowDimension($row)->getRowHeight();
            $destSheet->getRowDimension($destRowStart + $rowCount)->setRowHeight($h);

            $rowCount++;
        }

        foreach ($sheet->getMergeCells() as $mergeCell) {
            $mc = explode(":", $mergeCell);
            $mergeColSrcStart = Coordinate::columnIndexFromString(preg_replace("/[0-9]*/", "", $mc[0]));
            $mergeColSrcEnd = Coordinate::columnIndexFromString(preg_replace("/[0-9]*/", "", $mc[1]));
            $mergeRowSrcStart = ((int)preg_replace("/[A-Z]*/", "", $mc[0]));
            $mergeRowSrcEnd = ((int)preg_replace("/[A-Z]*/", "", $mc[1]));

            $relativeColStart = $mergeColSrcStart - $srcColumnStart;
            $relativeColEnd = $mergeColSrcEnd - $srcColumnStart;
            $relativeRowStart = $mergeRowSrcStart - $srcRowStart;
            $relativeRowEnd = $mergeRowSrcEnd - $srcRowStart;

            if (0 <= $mergeRowSrcStart && $mergeRowSrcStart >= $srcRowStart && $mergeRowSrcEnd <= $srcRowEnd) {
                $targetColStart = Coordinate::stringFromColumnIndex($destColumnStart + $relativeColStart);
                $targetColEnd = Coordinate::stringFromColumnIndex($destColumnStart + $relativeColEnd);
                $targetRowStart = $destRowStart + $relativeRowStart;
                $targetRowEnd = $destRowStart + $relativeRowEnd;

                $merge = (string)$targetColStart . (string)($targetRowStart) . ":" . (string)$targetColEnd . (string)($targetRowEnd);
                //Merge target cells
                $destSheet->mergeCells($merge);
            }
        }
    }

    public static function copyStyleXFCollection(Spreadsheet $sourceSheet, Spreadsheet $destSheet) {
        $collection = $sourceSheet->getCellXfCollection();

        foreach ($collection as $key => $item) {
            $destSheet->addCellXf($item);
        }
    }


   public function dp_record_academico($carnet)
    {
        
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $dominio=str_replace(".", "_",getDominio());
        $spreadsheet = $reader->load("plantillas/record_academico_".$dominio.".xlsx");
        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();
        $this->load->model('mmatricula');
        $this->load->model('minscrito');
        $inscrito = $this->minscrito->m_get_inscrito_por_carne(array($carnet));
        
            $cursos = $this->mmatricula->m_filtrar_record_academico(array($carnet));
            $spreadsheet->setActiveSheetIndex(0);
            $sheet = $spreadsheet->getActiveSheet();
            
            $sheet->setCellValue("D9", $inscrito->carrera);
            $sheet->setCellValue("D10", $inscrito->paterno." ".$inscrito->materno." ".$inscrito->nombres);

            $fila=12;
            $final = 0;
            $grupo = "";
            $nro=0;
            $creAcumulada=0;
            $puntaje=0;
            foreach ($cursos as $key => $cur) {

                $grupoint=$cur->codperiodo;
                if ($grupo!=$grupoint) {
                    if ($creAcumulada > 0){
                        $fila++;

                        $sheet->mergeCells("A".($final+1).":J".($final+1));
                        $sheet->getStyle("A".($final+1).":K".($final+1))->getFont()->setBold(true)->setSize(11);
                        $sheet->getStyle("A".($final+1).":K".($final+1))
                                        ->getAlignment() 
                                        ->setHorizontal('right');
                        $sheet->getStyle("A".($final+1).":K".($final+1))
                                        ->getBorders()
                                        ->getAllBorders()
                                        ->setBorderStyle(Border::BORDER_THIN);
                        $sheet->setCellValue("A".($fila), 'PONDERADO:');
                        $sheet->setCellValue("K".($fila), round($puntaje/$creAcumulada,2));
                        $fila++;
                    }
                    $puntaje=0;
                    $creAcumulada=0;
                    $grupo=$grupoint;
                    $nro=0;
                    $fila++;

                    

                    $sheet->getStyle("A".$fila.":K".($fila))->getFont()->setBold(true)->setSize(11);
                    $sheet->getStyle("A".$fila.":K".$fila)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(Border::BORDER_THIN);
                    $sheet->getStyle("A".$fila.":K".$fila)
                            ->getAlignment() 
                            ->setHorizontal('center');
                    $sheet->mergeCells("A".$fila.":K".($fila));
                    $sheet->setCellValue("A".$fila, $cur->periodo);

                    /*if ($final > 0) {
                        
                    }*/
                }
                $creditos=$cur->ct + $cur->cp;
                $creAcumulada=$creAcumulada + $creditos; 
                $nff=(is_numeric($cur->notar))?$cur->notar:$cur->notaf;
                $puntaje =$puntaje + ($nff * $creditos);
                


                $nro++;
                $fila++;

                $sheet->getStyle("A".$fila.":K".$fila)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(Border::BORDER_THIN);

                $sheet->setCellValue("A".$fila, $nro);
                $sheet->mergeCells("B".$fila.":D".($fila));
                $sheet->setCellValue("B".$fila, $cur->idunidad.' '.$cur->curso);
                $sheet->setCellValue("E".$fila, $cur->ciclo); 
                $sheet->setCellValue("F".$fila, substr($cur->turno,0,3).' / '.$cur->codseccion);
                $sheet->setCellValue("G".$fila, $cur->hts + $cur->hps);
                $sheet->setCellValue("H".$fila, $creditos);
                $sheet->setCellValue("I".$fila, $cur->notaf);
                $sheet->setCellValue("J".$fila, $cur->notar);
                $sheet->setCellValue("K".$fila, '');

                //FILA PONDERADO
                $final = $fila;
            }


            //FILA FINAL PONDERADO
            if ($creAcumulada > 0){
                        $fila++;
                        $sheet->mergeCells("A".($final+1).":J".($final+1));
                        $sheet->getStyle("A".($final+1).":K".($final+1))->getFont()->setBold(true)->setSize(11);
                        $sheet->getStyle("A".($final+1).":K".($final+1))
                                        ->getAlignment() 
                                        ->setHorizontal('right');
                        $sheet->getStyle("A".($final+1).":K".($final+1))
                                        ->getBorders()
                                        ->getAllBorders()
                                        ->setBorderStyle(Border::BORDER_THIN);
                        $sheet->setCellValue("A".($fila), 'PONDERADO:');
                        $sheet->setCellValue("K".($fila), round($puntaje/$creAcumulada,2));
                        $fila++;
                    }
            


            date_default_timezone_set('America/Lima');
            $fecha = date('m/d/Y h:i:s a', time());
            $numeroDia = date('d', strtotime($fecha));
            $dia = date('j', strtotime($fecha));
            $mes = date('n', strtotime($fecha));
            $anio = date('Y', strtotime($fecha));
            // $sheet->setCellValue("A28", $dia);
            // $sheet->setCellValue("B28", $mes);
            // $sheet->setCellValue("C28", $anio);

            $writer = new Xlsx($spreadsheet);
            $filename = 'RCA-'.$inscrito->carnet;
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output'); // download file
        
    }

    public function dp_administrativos()
    {
        $idsede=$_SESSION['userActivo']->idsede;
        $sede = $_SESSION['userActivo']->sede;
        $busqueda=$this->input->get('ap');
        $estado=$this->input->get('est');
        $busqueda=str_replace(" ","%",$busqueda);
        $this->load->model('mdocentes');
        $vdocentes = $this->mdocentes->get_datos_completos_administrativos(array("%".$busqueda.'%',$idsede,$estado));
        
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp_administrativos_docentes.xlsx");

        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        
        $fila = 7;
        $nro = 0;
        $strtimeact=strtotime("now");

        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo');
        $drawing->setDescription('logo');
        $drawing->setPath('resources/img/logo_h80.'.getDominio().'.png'); // put your path and image here
        $drawing->setCoordinates('L1');
        $colWidth = $sheet->getColumnDimension('K')->getWidth() + $sheet->getColumnDimension('M')->getWidth();
        if ($colWidth == -1) { //no definido, lo que significa que tenemos el ancho estándar
            $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
        } else {                  //innner width is 8.43 char units
            $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
        }
        $offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
        $drawing->setOffsetX($offsetX); //p
        $drawing->getShadow()->setVisible(true);
        $drawing->setWorksheet($sheet);

        $sheet->setCellValue("C1", $ie->denoml);
        $sheet->setCellValue("C4", $sede);

        foreach ($vdocentes as $doc) {
            $nro++;
            $fila++;

            $sheet->getStyle("A".($fila).":N".($fila))
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
            
            $sheet->setCellValue("A".$fila, $nro);
            $sheet->setCellValue('B'.$fila, $doc->numero);
            $sheet->setCellValue('C'.$fila, $doc->paterno." ".$doc->materno." ".$doc->nombres);
            $sheet->setCellValue('D'.$fila, date_format(date_create($doc->fecnac),"d/m/Y"));
            $sheet->setCellValue('E'.$fila, $doc->celular);
            $sheet->setCellValue('F'.$fila, $doc->celular2);
            $sheet->setCellValue('G'.$fila, $doc->telefono);
            $sheet->setCellValue('H'.$fila, $doc->epersonal);
            $sheet->setCellValue('I'.$fila, $doc->ecorporativo);
            

            $edad=($strtimeact - strtotime($doc->fecnac))/31557600;

            $sheet->setCellValue('J'.$fila, $doc->domicilio);
            $sheet->setCellValue('K'.$fila, $doc->departamento." - ".$doc->provincia." - ".$doc->distrito);

            // $sheet->setCellValue('K'.$fila, intval($edad));
            
            $sheet->setCellValue('L'.$fila, $doc->tipo);
            $sheet->setCellValue('M'.$fila, " ".$doc->cargo);
            $sheet->setCellValue('N'.$fila, " ".$doc->area);
          

        }
        
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'lista_administrativos_'.$sede;
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }
    
    public function dp_matriculas_x_campos()
    {
        $fmcbperiodo=$this->input->get("cp");
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");
        $fmcbplan=$this->input->get("cpl");
        $busqueda=$this->input->get("ap");
        $busqueda=str_replace(" ","%",$busqueda);

        $fmcbestado=$this->input->get("es");
        $sede=$this->input->get("sed");
        $beneficio=$this->input->get("benf");

        $carnet=$this->input->get("checkcarnet");
        $apellidos=$this->input->get("checkape");
        $nombres=$this->input->get("checknombres");
        $correoinst=$this->input->get("checkcorpo");
        $celulares=$this->input->get("checkcelul");
        $carrera=$this->input->get("checkcarr");
        $ciclo=$this->input->get("checkcic");
        $turno=$this->input->get("checkturn");
        $seccion=$this->input->get("checksecc");
        $periodo=$this->input->get("checkper");
        $estado=$this->input->get("checkest");
        $fecmat=$this->input->get("checkfecmat");
        $sexo=$this->input->get("checksex");
        $fecnac=$this->input->get("checkfecnac");
        $correo=$this->input->get("checkcorper");
        $domicilio=$this->input->get("checkdomic");
        $lengua=$this->input->get("checkleng");
        $departamento=$this->input->get("checkdepart");
        $provincia=$this->input->get("checkprovin");
        $distrito=$this->input->get("checkdistri");
        $discapacidad = $this->input->get("checkdiscap");
        $checkplan = $this->input->get("checkplan");
        $checkbeneficio = $this->input->get("checkbeneficio");
        $checkdni = $this->input->get("checkdni");
        $checkidinscripcion = $this->input->get("checkidinscripcion");
        
        // $idsede=$_SESSION['userActivo']->idsede;

        $this->load->model('mmatricula');

        $vmatriculas=$this->mmatricula->m_matriculas_campos(array($sede,$fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,$fmcbestado,$beneficio,'%'.$busqueda.'%'));
        
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp-lista-matriculas_campos.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        
        $fila=4;
        $nro=0;
        $strtimeact=strtotime("now");
        $grupo="";
        $col = 2;
        
        $sheet->setCellValue("A4", "N°");
        
        if ($checkidinscripcion == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "ID INSCRIP.");
            $col++;
        }
        if ($carnet == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "CARNÉ");
            $col++;
        }
        if ($apellidos == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "APELLIDOS");
            $col++;
        }
        if ($nombres == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "NOMBRES");
            $col++;
        }
        if ($checkdni == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "DNI");
            $col++;
        }
        if ($sexo == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "SEXO");
            $col++;
        }
        if ($fecnac == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "FECHA NAC.");
            $col++;
        }
        if ($correo == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "CORREO PERS.");
            $col++;
        }
        if ($domicilio == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "DOMICILIO");
            $col++;
        }
        if ($departamento == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "DEPARTAMENTO");
            $col++;
        }
        if ($provincia == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "PROVINCIA");
            $col++;
        }
        if ($distrito == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "DISTRITO");
            $col++;
        }
        if ($lengua == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "LENGUA ORIG.");
            $col++;
        }
        if ($discapacidad == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "DISCAPACIDAD.");
            $col++;
        }
        if ($correoinst == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "CORREO INST.");
            $col++;
        }
        if ($celulares == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "CELULARES");
            $col++;
        }
        if ($carrera == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "PROGRAMA");
            $col++;
        }
        if ($ciclo == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "SEMESTRE");
            $col++;
        }
        if ($turno == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "TURNO");
            $col++;
        }
        if ($seccion == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "SECCIÓN");
            $col++;
        }
        if ($periodo == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "PERIODO");
            $col++;
        }
        if ($estado == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "ESTADO");
            $col++;
        }
        if ($fecmat == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "FECHA MAT.");
            $col++;
        }
        if ($checkplan == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "PLAN ESTUD.");
            $col++;
        }
        if ($checkbeneficio == "SI") {
            $sheet->setCellValueByColumnAndRow($col,4, "BENEFICIO");
            $col++;
        }
        

        $sheet->getStyle("A4:AZ4")->getFont()->setBold(true);
            
        foreach ($vmatriculas as $mat) {
            
            $nro++;
            $fila++;
            $colrow = 2;

            $ncelulares=array(trim($mat->celular1),trim($mat->celular2),trim($mat->telefono));
            $ncelulares=array_filter($ncelulares);
            $txtcelulares=implode( ',', $ncelulares );

            $sheet->setCellValue("A".$fila, $nro);
            
            if ($checkidinscripcion == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->codinscripcion);
                $colrow++;
            }
            if ($carnet == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->carne);
                $colrow++;
            }
            if ($apellidos == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->paterno." ".$mat->materno);
                $colrow++;
            }
            if ($nombres == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->nombres);
                $colrow++;
            }
            if ($checkdni == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->numero);
                $colrow++;
            }
            
            if ($sexo == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->sexo);
                $colrow++;
            }
            if ($fecnac == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, date_format(date_create($mat->fecnac),"d/m/Y"));
                $colrow++;
            }
            if ($correo == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->email);
                $colrow++;
            }
            if ($domicilio == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->domicilio);
                $colrow++;
            }
            if ($departamento == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->departamento);
                $colrow++;
            }
            if ($provincia == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->provincia);
                $colrow++;
            }
            if ($distrito == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->distrito);
                $colrow++;
            }
            if ($lengua == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->lengua);
                $colrow++;
            }
            if ($discapacidad == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->disgrupo." - ".$mat->disdetalle);
                $colrow++;
            }
            if ($correoinst == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, strtolower($mat->carne)."@".getDominio());
                $colrow++;
            }
            if ($celulares == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $txtcelulares);
                $colrow++;
            }
            if ($carrera == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->carrera);
                $colrow++;
            }
            if ($ciclo == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->ciclo);
                $colrow++;
            }
            if ($turno == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->codturno);
                $colrow++;
            }
            if ($seccion == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->codseccion);
                $colrow++;
            }
            if ($periodo == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->periodo);
                $colrow++;
            }
            if ($estado == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->estado);
                $colrow++;
            }
            if ($fecmat == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, date_format(date_create($mat->fechamat),"d/m/Y"));
                $colrow++;
            }
            
            if ($checkplan == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->plan);
                $colrow++;
            }
            if ($checkbeneficio == "SI") {
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->beneficio);
                $colrow++;
            }
            
            //$sheet->mergeCells("F$fila:G$fila");
            /*$edad=($strtimeact - strtotime($mat->fecnac))/31557600;
            $sheet->setCellValue('J'.$fila, $mat->fecnac);

            $sheet->setCellValue('K'.$fila, intval($edad));
            
            $sheet->setCellValue('L'.$fila, $mat->sexo);
            $sheet->setCellValue('M'.$fila, " ".$mat->celular);
            $sheet->setCellValue('N'.$fila, $mat->ecorporativo);
            //AQUI HAY QUE ARREGLAR LO DE DISCAPACIDAD
            $sheet->setCellValue('O'.$fila, date_format(date_create($mat->fecinsc),"d/m/Y"));*/
          

        }
        
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'lista_matriculas';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

    public function dp_virtual_notas_unidad()
    {
        $fmcarga = base64url_decode($this->input->get("vcarga"));
        $fmdivision = base64url_decode($this->input->get("vdivis"));

        $this->load->model('mcargasubseccion');
        $this->load->model('mmiembros');
        $this->load->model('mvirtual');

        $vcursos = $this->mcargasubseccion->m_get_carga_subseccion(array($fmcarga,$fmdivision));
        $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($fmcarga,$fmdivision));
        $vmaterial = $this->mvirtual->m_get_virtmateriales(array($fmcarga,$fmdivision));

        $vmaterialnotas = $this->mvirtual->m_get_notas_materiales(array($fmcarga,$fmdivision));

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp-virtual-notas.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        
        $fila=0;
        $nro=0;
        $strtimeact=strtotime("now");
        $grupo="";

        $sheet->setCellValue("A4", "PERIODO LECTIVO");
        $sheet->mergeCells("A4:B4");
        $sheet->setCellValue("C4", $vcursos->periodo);
        $sheet->getStyle("C4")->getFont()->setBold(true);
        $sheet->setCellValue("D4", "PROGRAMA");
        $sheet->setCellValue("E4", $vcursos->carrera);
        $sheet->getStyle("E4")->getFont()->setBold(true);
        $sheet->mergeCells("E4:G4");
        
        $sheet->setCellValue("A5", "SEMESTRE ACADEM.");
        $sheet->mergeCells("A5:B5");
        $sheet->setCellValue("C5", $vcursos->ciclo);
        $sheet->getStyle("C5")->getFont()->setBold(true);
        $sheet->setCellValue("D5", "TURNO");
        $sheet->setCellValue("E5", $vcursos->turno);
        $sheet->getStyle("E5")->getFont()->setBold(true);
        $sheet->setCellValue("F5", "SECCIÓN");
        $sheet->setCellValue("G5", $vcursos->codseccion);
        $sheet->getStyle("G5")->getFont()->setBold(true);

        $sheet->setCellValue("A6", "DOCENTE");
        $sheet->mergeCells("A6:B6");
        $sheet->setCellValue("C6", $vcursos->paterno." ".$vcursos->materno." ".$vcursos->nombres);
        $sheet->getStyle("C6")->getFont()->setBold(true);

        $sheet->setCellValue("A7", "UNIDAD DIDAC.");
        $sheet->mergeCells("A7:B7");
        $sheet->setCellValue("C7", $vcursos->unidad);
        $sheet->getStyle("C7")->getFont()->setBold(true);

        $sheet->setCellValue("A9", "N°");
        $sheet->getStyle("A9")->getFont()->setBold(true);

        $sheet->setCellValue("B9", "CARNÉ");
        $sheet->getStyle("B9")->getFont()->setBold(true);

        $sheet->setCellValue("C9", "APELLIDOS Y NOMBRES");
        $sheet->mergeCells("C9:F9");
        $sheet->getStyle("C9")->getFont()->setBold(true);

        $nro=0;
        $fila=9;

        $colInsertadas = count($vmaterial);

        $endCol_letra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(6 + $colInsertadas);

        $sheet->getStyle("A9:".$endCol_letra."9")
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
        
        foreach ($miembros as $miembro) {
            $nro++;
            $fila++;

            $sheet->getStyle("A".$fila.":".$endCol_letra.$fila)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $this->copyRows($sheet, 'A'.$fila.':'.$endCol_letra.$fila, 'A'.($fila + 1));
            
            $sheet->setCellValue('A'.$fila, $nro);
            $sheet->setCellValue('B'.$fila, $miembro->carnet);
            
            $sheet->setCellValue('C'.$fila, $miembro->paterno." ".$miembro->materno." ".$miembro->nombres);
            $sheet->mergeCells("C$fila:F$fila");
            
            //MATERIALES
            $alumno[$miembro->idmiembro]['virtual'] = array();
            //$n=0;
            foreach ($vmaterial as $mat) {
                                      
                
                $alumno[$miembro->idmiembro]['virtual'][$mat->codigo]['vnota'] = "0";
                
                foreach ($vmaterialnotas as $nmat) {
                    // NOTA EVALUACIÓN
                    if (($miembro->idmiembro==$nmat->miev)&&($nmat->evirtid==$mat->codigo)){
                        
                        $alumno[$miembro->idmiembro]['virtual'][$mat->codigo]['vnota'] = floatval($nmat->notev);  
                        
                    }

                    // NOTA TAREAS
                    if (($miembro->idmiembro==$nmat->mitar)&&($nmat->tvirtid==$mat->codigo)){
                        
                        $alumno[$miembro->idmiembro]['virtual'][$mat->codigo]['vnota'] = floatval($nmat->notar);  
                        
                    }
                }
            }


        }

        $sheet->mergeCells("C".($fila+1).":F".($fila+1));

        // TITULO MATERIALES

        $colum = 6;

        foreach ($vmaterial as $mat) {
            $colum++;
            $material = $mat->nombre;

            $endCol_mat = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colum);

            $sheet->setCellValueByColumnAndRow($colum,9, $material);

            $sheet->getColumnDimensionByColumn($colum)->setAutoSize(false);
            $sheet->getColumnDimensionByColumn($colum)->setWidth(9.14);

            $sheet->getRowDimension(9)->setRowHeight(39);

            $styletext = array(
                'font' => array(
                    'size' => 8,
                ),
                'alignment' => array(
                    'horizontal' => "center",
                    'vertical' => "center",
                    'wrapText' => "center"
                )
            );

            $sheet->getStyleByColumnAndRow($colum, 9)
                ->applyFromArray($styletext);
            
            
        }
        
        //NOTAS
        $filanotas = 9;
        
        foreach ($miembros as $mb) {
            
            $filanotas++;
            $colnotas = 6;

            foreach ($vmaterial as $key => $mat) {

                $colnotas++;
                $valor = $alumno[$mb->idmiembro]['virtual'][$mat->codigo]['vnota'];
                $sheet->setCellValueByColumnAndRow($colnotas,$filanotas, $valor);
                

            }
        
            
        }

        $writer = new Xlsx($spreadsheet);
 
        $filename = 'REPORTE-NOTAS-VIRTUAL-'.$vcursos->unidad;
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

    public function dp_registro_inscripcion_excel()
    {
        $sede = $_SESSION['userActivo']->sede;
        $busqueda=$this->input->get('bc');
        $carrera=$this->input->get('pg');
        $periodo=$this->input->get('per');
        $turno=$this->input->get('tn');
        $campania=$this->input->get('cp');
        $seccion=$this->input->get('sc');

        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();
        $this->load->model('minscrito_reporte');
        $cuentas = $this->minscrito_reporte->m_filtrar_basico_sd_activa_reportes(array($periodo,$campania,$carrera,$turno,$seccion,$_SESSION['userActivo']->idsede,'%'.$busqueda.'%',));

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp_documentos_anexados.xlsx");

        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        
        $strtimeact=strtotime("now");

        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo');
        $drawing->setDescription('logo');
        $drawing->setPath('resources/img/logo_h80.'.getDominio().'.png'); // put your path and image here
        $drawing->setCoordinates('H1');
        $colWidth = $sheet->getColumnDimension('G')->getWidth() + $sheet->getColumnDimension('I')->getWidth();
        if ($colWidth == -1) { //no definido, lo que significa que tenemos el ancho estándar
            $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
        } else {                  //innner width is 8.43 char units
            $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
        }
        $offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
        $drawing->setOffsetX($offsetX); //p
        $drawing->getShadow()->setVisible(true);
        $drawing->setWorksheet($sheet);

        $sheet->setCellValue("A1", $ie->denoml." - FILIAL : ".$sede);

        $nro = 0;
        $grupo = "";
        $fila = 2;
        foreach ($cuentas as $key => $value) {
            $codins = $value->codinscripcion;
            $grupoint=$value->codperiodo.$value->codcarrera.$value->codciclo.$value->codturno.$value->codseccion.$value->codcampania;
            if ($grupo!=$grupoint) {
                $grupo=$grupoint;
                $fila = $fila + 2;
                $sheet->getStyle("A".$fila.":D".$fila)
                    ->getAlignment() 
                    ->setHorizontal('left');
                $sheet->getStyle('A'.$fila)->getFont()->setBold(true);
                $sheet->setCellValue("A".$fila, "PERIODO:");
                $sheet->setCellValue("B".$fila, $value->periodo);

                $sheet->getStyle('C'.$fila)->getFont()->setBold(true);
                $sheet->setCellValue("C".$fila, "PROGRAMA PROFESIONAL:");
                $sheet->setCellValue("D".$fila, $value->carrera);
                $fila++;

                $sheet->getStyle("A".$fila.":H".$fila)
                    ->getAlignment() 
                    ->setHorizontal('left');
                $sheet->getStyle('A'.$fila)->getFont()->setBold(true);
                $sheet->setCellValue("A".$fila, "SEMESTRE:");
                $sheet->setCellValue("B".$fila, $value->ciclo);

                $sheet->getStyle('C'.$fila)->getFont()->setBold(true);
                $sheet->setCellValue("C".$fila, "TURNO:");
                $sheet->setCellValue("D".$fila, $value->turno);

                $sheet->getStyle('E'.$fila)->getFont()->setBold(true);
                $sheet->setCellValue("E".$fila, "SECCIÓN:");
                $sheet->setCellValue("F".$fila, $value->seccion);

                $sheet->getStyle('G'.$fila)->getFont()->setBold(true);
                $sheet->setCellValue("G".$fila, "CAMPAÑA:");
                $sheet->setCellValue("H".$fila, $value->campania);

                $fila = $fila + 2;

                $sheet->getStyle("A".($fila).":I".($fila))
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle("A".$fila.":I".$fila)->getFont()->setBold(true);

                $sheet->setCellValue("A".$fila, "N°");
                $sheet->mergeCells("B".$fila.":C".($fila));
                $sheet->getStyle("B".$fila.":C".$fila)
                    ->getAlignment() 
                    ->setHorizontal('left');
                $sheet->setCellValue("B".$fila, "ESTUDIANTE");

                $sheet->mergeCells("D".$fila.":F".($fila));
                $sheet->getStyle("D".$fila.":F".$fila)
                    ->getAlignment() 
                    ->setHorizontal('left');
                $sheet->setCellValue("D".$fila, "DOCUMENTOS ANEXADOS");

                $sheet->mergeCells("G".$fila.":I".($fila));
                $sheet->getStyle("G".$fila.":I".$fila)
                    ->getAlignment() 
                    ->setHorizontal('left');
                $sheet->setCellValue("G".$fila, "OBSERVACIONES");

                $nro=0;
            }

            $nro++;
            $fila++;

            $sheet->getStyle("A".($fila).":I".($fila))
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

            $sheet->setCellValue("A".$fila, $nro);
            $sheet->setCellValue("B".$fila, $value->carnet);
            $sheet->getStyle("C".$fila.":C".$fila)
                    ->getAlignment() 
                    ->setHorizontal('left');
            $sheet->setCellValue("C".$fila, $value->paterno." ".$value->materno." ".$value->nombres);

            $anexos = "";
            $anexos = $this->db->query("SELECT 
                tb_inscripcion_docanexados.doan_id as idanexa,
                tb_doc_anexar.doan_nombre as anexanombre
                FROM tb_inscripcion_docanexados
                INNER JOIN tb_doc_anexar ON (tb_inscripcion_docanexados.doan_id = tb_doc_anexar.doan_id)
                WHERE tb_inscripcion_docanexados.ins_identificador = $codins");
            $docadjunto = "";
            foreach ($anexos->result() as $key => $anx) {
                $docadjunto = $docadjunto."$anx->anexanombre, ";
            }

            if ($docadjunto != "") {
                $adjuntodt = substr($docadjunto,0,-2);
            } else {
                $adjuntodt = "";
            }

            $sheet->mergeCells("D".$fila.":F".($fila));
            $sheet->getStyle("D".$fila.":F".$fila)
                    ->getAlignment() 
                    ->setHorizontal('left');
            $sheet->setCellValue("D".$fila, $adjuntodt);
            $sheet->mergeCells("G".$fila.":I".($fila));
            $sheet->getStyle("G".$fila.":I".$fila)
                    ->getAlignment() 
                    ->setHorizontal('left');
            $sheet->setCellValue("G".$fila, $value->observacion);

        }
        // $fila++;
        
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'Reporte_inscritos_'.$sede;
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }



    public function vw_registro_final_nuevo_excel($codcarga,$division)
    {
        //if (($_SESSION['userActivo']->codnivel != 3)) {
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $dias_ES1 = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
            $meses_ES1 = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");

            $this->load->model('mcargasubseccion');
            $curso = $this->mcargasubseccion->m_get_carga_subseccion_todos(array($codcarga,$division));
            if (isset($curso)) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $dominio=str_replace(".", "_",getDominio());
                $spreadsheet = $reader->load("plantillas/rp_registro_final_".$dominio.".xlsx");

                $spreadsheet->setActiveSheetIndex(0);
                $sheet = $spreadsheet->getActiveSheet();

                $this->load->model('mevaluaciones');
                $this->load->model('masistencias');
                $this->load->model('mmiembros');
                $this->load->model('msesiones');
                
                $fechas=     $this->masistencias->m_fechas_x_curso(array($codcarga,$division));
                $fechas_total=$curso->sesiones;
                $asistencias= $this->masistencias->m_asistencias_x_curso(array($codcarga,$division));

                $sesiones= $this->msesiones->m_sesiones_x_curso_reg(array($codcarga,$division));
                $evaluaciones_head= $this->mevaluaciones->m_eval_head_x_curso(array($codcarga,$division));
                $indicadores= $this->mevaluaciones->m_get_indicadores_por_carga_division(array($codcarga,$division));
                if ((getDominio()=="iesap.edu.pe")|| (getDominio()=="charlesashbee.edu.pe")){
                    $subindicadores= $this->mcargasubseccion->m_get_carga_subseccion_indicadores(array($codcarga,$division));
                    $subindicadores=$subindicadores;
                }
                
                $evaluaciones = $this->mevaluaciones->m_eval_head_x_curso(array($codcarga,$division));
                $notas        = $this->mevaluaciones->m_notas_x_curso(array($codcarga,$division));
                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                $alumno= array();

                $nro=0;

                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();
                if (getDominio() != "iesap.edu.pe"){
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setName('logo');
                    $drawing->setDescription('logo');
                    $drawing->setPath('resources/img/logo_h80.'.getDominio().'.png'); // put your path and image here
                    $drawing->setCoordinates('AW3');
                    $colWidth = $sheet->getColumnDimension('AV')->getWidth() + $sheet->getColumnDimension('AW')->getWidth();
                    if ($colWidth == -1) { //no definido, lo que significa que tenemos el ancho estándar
                        $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
                    } else {                  //innner width is 8.43 char units
                        $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
                    }
                    $offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
                    $drawing->setOffsetX($offsetX); //p
                    $drawing->getShadow()->setVisible(true);
                    $drawing->setWorksheet($sheet);
                }
                

                // $sheet->setCellValue("AO20", $iestp->denoml);
                $sheet->setCellValue("AS15", "REGISTRO  DE EVALUACIÓN Y NOTAS");
                $sheet->setCellValue("AS19", $curso->periodo);
                // $sheet->setCellValue("AO22", $iestp->resolucion);
                // $sheet->setCellValue("AU38", $curso->periodo);
                $sheet->setCellValue("AQ26", $curso->carrera);
                $sheet->setCellValue("AV28", $curso->modulonro);
                $sheet->setCellValue("AU30", $curso->modulo);
                $sheet->setCellValue("AS35", $curso->unidad);
                // $sheet->setCellValue("AT38", $curso->periodo);
                $sheet->setCellValue("AU43", ($curso->cred_teo + $curso->cred_pra));
                $sheet->setCellValue("AU45", $curso->hsem_teo + $curso->hsem_pra);

                $sheet->setCellValue("AU49", $curso->codseccion.'-'.$curso->division);
                $sheet->setCellValue("AZ49", $curso->turno);

                $sheet->setCellValue("AT47", $curso->paterno." ".$curso->materno." ".$curso->nombres );
                
                $alumno=array();
                $idn=0;
                $n=0;

                if (count($evaluaciones_head)>0){
                    foreach ($miembros as $miembro) {
                            
                        $alumno[$miembro->idmiembro]['eval'] = array();
                        $alumno[$miembro->idmiembro]['eval']['RC']['tipo'] = "M"; 
                        $alumno[$miembro->idmiembro]['eval']['RC']['nota']= $miembro->recuperacion;

                        $alumno[$miembro->idmiembro]['eval']['PI']['tipo'] = "C"; 
                        $alumno[$miembro->idmiembro]['eval']['PI']['nota']= 0;

                        $alumno[$miembro->idmiembro]['eval']['PF']['tipo'] = "C"; 
                        $alumno[$miembro->idmiembro]['eval']['PF']['nota']= "--";

                        foreach ($indicadores as $indicador) {
                            foreach ($evaluaciones_head as $evaluacion) {
                                if ($indicador->codigo==$evaluacion->indicador){
                                    $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->evaluacion]=array();
                                    $idn--;
                                    $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->nombre_calculo]['nota'] = "";
                                    $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->nombre_calculo]['idnota'] = $idn;
                                    $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->nombre_calculo]['tipo'] = $evaluacion->tipo; 
                                    $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->nombre_calculo]['peso'] = $evaluacion->peso;
                                    foreach ($notas as $nota) {
                                        if (($miembro->idmiembro==$nota->idmiembro)&&($evaluacion->evaluacion==$nota->evaluacion)){
                                            $alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador][$evaluacion->nombre_calculo]['nota'] =($nota->nota=="")?"":floatval($nota->nota); 
                                            $alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador][$evaluacion->nombre_calculo]['idnota'] = $nota->id;    
                                        }
                                    }
                                }
                            }
                        }

                        $alumno[$miembro->idmiembro]['asis'] = array();
                        $alumno[$miembro->idmiembro]['asis']['faltas'] = 0;
                        $alumno[$miembro->idmiembro]['asis']['faltasp'] = 0;

                        foreach ($fechas as $fecha) {
                            $n--;
                            $alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['idaccion'] = $n;
                            $alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'] = "";

                            foreach ($asistencias as $asistencia) {
                                if (($miembro->idmiembro==$asistencia->idmiembro)&&($asistencia->sesion==$fecha->sesion)){
                                    $alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['idaccion'] = $asistencia->id;
                                    $alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'] = $asistencia->accion;  
                                    if ($asistencia->accion=="F"){
                                        $alumno[$miembro->idmiembro]['asis']['faltas']++;  
                                    }
                                }
                            }
                        }

                        if ($fechas_total>0){
                          $alumno[$miembro->idmiembro]['asis']['faltasp']= round($alumno[$miembro->idmiembro]['asis']['faltas']/ $fechas_total * 100);  
                        } 

                    }

                    $funcionhelp="getNotas_alumno_$dominio";
                    $alumno=$funcionhelp($curso->metodo,$alumno,$indicadores);
                    
                }
                

                //TITULOS DE FECHA
                $colAsistencia=3;
                for ($i=0; $i <17 ; $i++) {
                    if (isset($fechas[$i])){
                        $fecha=$fechas[$i];
                        $fechaslt=date("d-m", strtotime($fecha->fecha));
                        $colAsistencia++;
                        
                        $sheet->setCellValueByColumnAndRow($colAsistencia,10, $fechaslt);
                    }

                }
                $colAsistencia=3;
                for ($i=17; $i <57 ; $i++) {
                    if (isset($fechas[$i])){
                        $fecha=$fechas[$i];
                        $fechaslt=date("d-m", strtotime($fecha->fecha));
                        $colAsistencia++;
                        
                        $sheet->setCellValueByColumnAndRow($colAsistencia,128, $fechaslt);
                    }
                    
                }

                $colAsistencia=3;
                for ($i=57; $i <97 ; $i++) {
                    if (isset($fechas[$i])){
                        $fecha=$fechas[$i];
                        $fechaslt=date("d-m", strtotime($fecha->fecha));
                        $colAsistencia++;
                        
                        $sheet->setCellValueByColumnAndRow($colAsistencia,185, $fechaslt);
                    }
                    
                }



                //ASIST
                $nro=0;
                $fila=66;
                $filaAsistencia1=12;
                $filaAsistencia2=130;
                $filaAsistencia3=187;
                $filaindc=66;
                $nind=0;
                $nses=$curso->sesiones;
                $nindmax=14;
                
                foreach ($miembros as $mb) {
                    $nro++;
                    $fila++;//67
                    $sheet->setCellValue('D'.$fila, $mb->paterno." ".$mb->materno." ".$mb->nombres);
                    
                    $filaAsistencia1++;
                    $colAsistencia=3;
                    for ($i=0; $i <17 ; $i++) {

                        if (isset($fechas[$i])){
                            $fecha=$fechas[$i];
                            $colAsistencia++;
                            //$valor=$alumno[$mb->idmiembro]['asis'][$fecha->sesion]['accion'];
                            $sheet->setCellValueByColumnAndRow($colAsistencia,$filaAsistencia1, $alumno[$mb->idmiembro]['asis'][$fecha->sesion]['accion']);
                        }
                        else{
                            $i=17;
                        }

                    }
                    $sheet->setCellValue("U".$filaAsistencia1, $alumno[$mb->idmiembro]['asis']['faltas']);
                    $sheet->setCellValue("V".$filaAsistencia1, $alumno[$mb->idmiembro]['asis']['faltasp']);
                    
                    $filaAsistencia2++;
                    $colAsistencia=3;
                    for ($i=17; $i <57 ; $i++) {
                        if (isset($fechas[$i])){
                            $fecha=$fechas[$i];
                            $colAsistencia++;
                            //$valor=$alumno[$mb->idmiembro]['asis'][$fecha->sesion]['accion'];
                            $sheet->setCellValueByColumnAndRow($colAsistencia,$filaAsistencia2, $alumno[$mb->idmiembro]['asis'][$fecha->sesion]['accion']);
                        }
                        else{
                            $i=57;
                        }
                    }
                    if ($fechas_total>17){
                        $sheet->setCellValue("AR".$filaAsistencia2, $alumno[$mb->idmiembro]['asis']['faltas']);
                        $sheet->setCellValue("AS".$filaAsistencia2, $alumno[$mb->idmiembro]['asis']['faltasp']);    
                    }
                    


                    $filaAsistencia3++;
                    $colAsistencia=3;
                    for ($i=57; $i <97 ; $i++) {
                    
                        if (isset($fechas[$i])){
                            $fecha=$fechas[$i];
                            $colAsistencia++;
                            $sheet->setCellValueByColumnAndRow($colAsistencia,$filaAsistencia3, $alumno[$mb->idmiembro]['asis'][$fecha->sesion]['accion']);
                        }
                        else{
                            $i=97;
                        }
                    }
                    if ($fechas_total>57){
                        $sheet->setCellValue("AR".$filaAsistencia3, $alumno[$mb->idmiembro]['asis']['faltas']);
                        $sheet->setCellValue("AS".$filaAsistencia3, $alumno[$mb->idmiembro]['asis']['faltasp']);
                    }

                    //INDICADORES DE LOGRO
                    $filaind=3;
                    foreach ($indicadores as $ind) {

                        // $filaind++;
                        $codigoind = $ind->codigo;
                        // $sheet->setCellValueByColumnAndRow(26,$filaind, $ind->nombre);
                        foreach ($subindicadores as $sub) {
                            if ($codigoind == $sub->indicador) {
                                $filaind++;
                                $descripcion = $sub->descripción;
                                $sheet->setCellValueByColumnAndRow(26,$filaind, $descripcion);
                                $filaind = $filaind + 3;
                            }
                            
                        }
                        // $filaind = $filaind + 3;

                    }

                    // TITULO INDICADORES
                    $coltitind = 21;
                    $filtitind = 66;

                    foreach ($indicadores as $indicador) {
                        foreach ($evaluaciones as $evaluacion) {
                            if ($evaluacion->indicador==$indicador->codigo){
                                if ($evaluacion->abrevia!="RC"){
                                    $coltitind ++;
                                    $nameind = $evaluacion->abrevia.$indicador->norden;
                                    $sheet->setCellValueByColumnAndRow($coltitind,$filtitind, $nameind);
                                    $coltitind = $coltitind + 1;
                                }
                            }
                        }
                    }

                    // NOTAS MIEMBROS
                    $filanota = 66;
                    $columnanota = 21;
                    foreach ($miembros as $mb) {
                        $filanota ++;
                        $columnanota = 21;
                        foreach ($indicadores as $indicador) {
                            foreach ($evaluaciones as $evaluacion) {
                                if ($evaluacion->indicador==$indicador->codigo){
                                    if ($evaluacion->abrevia!="RC"){
                                        $columnanota ++;
                                        $aidmiembro=$mb->idmiembro;
                                        $anota="";
                                        $valor=0;

                                        $valor= $alumno[$aidmiembro]['eval'][$evaluacion->indicador][$evaluacion->nombre_calculo]['nota'] ;
                                        $tipo= $alumno[$aidmiembro]['eval'][$evaluacion->indicador][$evaluacion->nombre_calculo]['tipo'] ;
                                        $anota=$valor;
                                        $sheet->setCellValueByColumnAndRow($columnanota,$filanota, $anota);
                                        $columnanota = $columnanota + 1;
                                    }
                                }
                            }
                        }

                        // PROMEDIO
                        $nt=$alumno[$aidmiembro]['eval']['PI']['nota'];
                        $sheet->setCellValueByColumnAndRow(47,$filanota, $nt);

                        // RECUPERACIÓN
                        $anotarc=$alumno[$aidmiembro]['eval']['RC']['nota'];
                        $sheet->setCellValueByColumnAndRow(50,$filanota, $anotarc);

                        // PROMEDIO FINAL
                        $pf=$alumno[$aidmiembro]['eval']['PF']['nota'];
                        $pfaltas = round($alumno[$aidmiembro]['asis']['faltas']/$fechas_total*100,0);
                        $isdpi = ($pfaltas>=30) ? "DPI" : "";
                        if ($isdpi==""){
                            $sheet->setCellValueByColumnAndRow(53,$filanota, $pf);
                        } else {
                            $sheet->setCellValueByColumnAndRow(53,$filanota, $isdpi);
                        }

                    }


                    //INDICADORES
                    // $filaindc++;//67
                    // $colindc=21;
                    // for ($i=0; $i <$nindmax ; $i++) {
                                                
                    //     $nind++;
                    //     if (isset($indicadores[$i])){
                    //         $indicador=$indicadores[$i];
                    //         $colindc++;
                    //         $nota=0;
                    //         $notar=0;
                    //         /////////////
                    //         if (getDominio()=="iestphuarmaca.edu.pe"){
                                
                    //             $nota=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['PI']['nota'];
                    //             $notar=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['RC']['nota'];
                    //         }
                    //         else if (getDominio()=="iestpcanchaque.edu.pe"){
                                

                    //             $nota=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['PI']['nota'];
                    //             $notar=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['RI']['nota'];
                    //         }
                    //         else if (getDominio()=="iesap.edu.pe"){
                                

                    //             $nota=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['EU']['nota'];
                    //             $notar=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['RC']['nota'];
                    //         }
                    //         else if (getDominio()=="iestbellavista.edu.pe"){
                                

                    //             $nota=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['PI']['nota'];
                    //             $notar=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['RI']['nota'];
                    //         }
                    //         ///////////////////
                           
                    //         $notaid=($nota>$notar) ? $nota : $notar;
                    //         $sheet->setCellValueByColumnAndRow($colindc,$filaindc, str_pad(floatval($notaid), 2, "0", STR_PAD_LEFT));
                    //         $colindc++;
                    //     }

                    // }

                    // for ($i=$nind + 1; $i <= $nindmax; $i++) { 
                    //     $colindc++;
                    //     $sheet->setCellValueByColumnAndRow($colindc,$filaindc, "--");
                    //     $colindc++;
                    // }

                    

                    // //$pf=$alumno[$mb->idmiembro]['eval']['PF']['nota'];
                    // $sheet->setCellValue("AV".$filaindc, str_pad(floatval($alumno[$mb->idmiembro]['eval']['PI']['nota']), 2, "0", STR_PAD_LEFT));

                    // //COLUMNA DE RECUPERACIÓN
                    // $sheet->setCellValue("AX".$filaindc, $alumno[$mb->idmiembro]['eval']['RC']['nota']);

                }

                $fini=0;
                $ffin=17;
                                               

                $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                date_default_timezone_set('America/Lima');
                $fecha = date('m/d/Y h:i:s a', time());
                $hora=date('h:i A');
                  //$fecha=time();
                $fecha = substr($fecha, 0, 10);

                $dia = date('l', strtotime($fecha));
                $mes = date('F', strtotime($fecha));
                $anio = date('Y', strtotime($fecha));

                $numeroDia = date('d', strtotime($fecha));
                $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                 
                $sheet->setCellValue("AO116", strtoupper($iestp->distrito).", $nombredia $numeroDia de $nombreMes de $anio");

                $writer = new Xlsx($spreadsheet);
                $filename = 'REGISTRO_FINAL-'.$curso->periodo.'-'.$curso->carrera.'-'.$curso->ciclol.'-'.$curso->turno.'-'.$curso->codseccion.'-'.$curso->division;

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
             
                $writer->save('php://output'); // download file 
            }
        //}
    }


    
}