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
        $this->load->model('minscrito');
        $vmatriculas=$this->minscrito->m_filtrar_basico_sd_activa(array($periodo,$campania,$carrera,$turno,$seccion,$_SESSION['userActivo']->idsede,'%'.$busqueda.'%',));

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
        $busqueda=$this->input->get("ap");
        $this->load->model('mmatricula');

        $vmatriculas=$this->mmatricula->m_filtrar(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,'%'.$busqueda.'%'));

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
    
    public function dp_matriculas_x_campos()
    {
        $fmcbperiodo=$this->input->get("cp");
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");
        $fmcbplan=$this->input->get("cpl");
        $busqueda=$this->input->get("ap");

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


        
        $idsede=$_SESSION['userActivo']->idsede;

        $this->load->model('mmatricula');

        $vmatriculas=$this->mmatricula->m_matriculas_campos(array($idsede,$fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,'%'.$busqueda.'%'));

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
                $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->plan);
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

    // public function dp_matriculas_x_campos()
    // {
    //     $fmcbperiodo=$this->input->get("cp");
    //     $fmcbcarrera=$this->input->get("cc");
    //     $fmcbciclo=$this->input->get("ccc");
    //     $fmcbturno=$this->input->get("ct");
    //     $fmcbseccion=$this->input->get("cs");
    //     $fmcbplan=$this->input->get("cpl");
    //     $busqueda=$this->input->get("ap");

    //     $carnet=$this->input->get("checkcarnet");
    //     $apellidos=$this->input->get("checkape");
    //     $nombres=$this->input->get("checknombres");
    //     $correoinst=$this->input->get("checkcorpo");
    //     $celulares=$this->input->get("checkcelul");
    //     $carrera=$this->input->get("checkcarr");
    //     $ciclo=$this->input->get("checkcic");
    //     $turno=$this->input->get("checkturn");
    //     $seccion=$this->input->get("checksecc");
    //     $periodo=$this->input->get("checkper");
    //     $estado=$this->input->get("checkest");
    //     $fecmat=$this->input->get("checkfecmat");
    //     $sexo=$this->input->get("checksex");
    //     $fecnac=$this->input->get("checkfecnac");
    //     $correo=$this->input->get("checkcorper");
    //     $domicilio=$this->input->get("checkdomic");
    //     $lengua=$this->input->get("checkleng");
    //     $departamento=$this->input->get("checkdepart");
    //     $provincia=$this->input->get("checkprovin");
    //     $distrito=$this->input->get("checkdistri");
    //     $discapacidad = $this->input->get("checkdiscap");
    //     $checkplan = $this->input->get("checkplan");

    //     $this->load->model('mmatricula');

    //     $vmatriculas=$this->mmatricula->m_matriculas_campos(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,'%'.$busqueda.'%'));

    //     $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    //     $spreadsheet = $reader->load("plantillas/rp-lista-matriculas_campos.xlsx");

    //     //$spreadsheet = new Spreadsheet();
    //     $spreadsheet->setActiveSheetIndex(0);
    //     $sheet = $spreadsheet->getActiveSheet();
        
    //     $fila=4;
    //     $nro=0;
    //     $strtimeact=strtotime("now");
    //     $grupo="";
    //     $col = 2;
        
    //     $sheet->setCellValue("A4", "N°");
    //     if ($carnet == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "CARNÉ");
    //         $col++;
    //     }
    //     if ($apellidos == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "APELLIDOS");
    //         $col++;
    //     }
    //     if ($nombres == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "NOMBRES");
    //         $col++;
    //     }
    //     if ($sexo == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "SEXO");
    //         $col++;
    //     }
    //     if ($fecnac == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "FECHA NAC.");
    //         $col++;
    //     }
    //     if ($correo == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "CORREO PERS.");
    //         $col++;
    //     }
    //     if ($domicilio == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "DOMICILIO");
    //         $col++;
    //     }
    //     if ($departamento == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "DEPARTAMENTO");
    //         $col++;
    //     }
    //     if ($provincia == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "PROVINCIA");
    //         $col++;
    //     }
    //     if ($distrito == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "DISTRITO");
    //         $col++;
    //     }
    //     if ($lengua == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "LENGUA ORIG.");
    //         $col++;
    //     }
    //     if ($discapacidad == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "DISCAPACIDAD.");
    //         $col++;
    //     }
    //     if ($correoinst == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "CORREO INST.");
    //         $col++;
    //     }
    //     if ($celulares == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "CELULARES");
    //         $col++;
    //     }
    //     if ($carrera == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "PROGRAMA");
    //         $col++;
    //     }
    //     if ($ciclo == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "CICLO");
    //         $col++;
    //     }
    //     if ($turno == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "TURNO");
    //         $col++;
    //     }
    //     if ($seccion == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "SECCIÓN");
    //         $col++;
    //     }
    //     if ($periodo == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "PERIODO");
    //         $col++;
    //     }
    //     if ($estado == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "ESTADO");
    //         $col++;
    //     }
    //     if ($fecmat == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "FECHA MAT.");
    //         $col++;
    //     }
    //     if ($checkplan == "SI") {
    //         $sheet->setCellValueByColumnAndRow($col,4, "PLAN ESTUD.");
    //         $col++;
    //     }
        

    //     $sheet->getStyle("A4:AZ4")->getFont()->setBold(true);
            
    //     foreach ($vmatriculas as $mat) {
            
    //         $nro++;
    //         $fila++;
    //         $colrow = 2;

    //         $ncelulares=array(trim($mat->celular1),trim($mat->celular2),trim($mat->telefono));
    //         $ncelulares=array_filter($ncelulares);
    //         $txtcelulares=implode( ',', $ncelulares );

    //         $sheet->setCellValue("A".$fila, $nro);
    //         if ($carnet == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->carne);
    //             $colrow++;
    //         }
    //         if ($apellidos == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->paterno." ".$mat->materno);
    //             $colrow++;
    //         }
    //         if ($nombres == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->nombres);
    //             $colrow++;
    //         }
    //         if ($sexo == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->sexo);
    //             $colrow++;
    //         }
    //         if ($fecnac == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, date_format(date_create($mat->fecnac),"d/m/Y"));
    //             $colrow++;
    //         }
    //         if ($correo == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->email);
    //             $colrow++;
    //         }
    //         if ($domicilio == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->domicilio);
    //             $colrow++;
    //         }
    //         if ($departamento == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->departamento);
    //             $colrow++;
    //         }
    //         if ($provincia == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->provincia);
    //             $colrow++;
    //         }
    //         if ($distrito == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->distrito);
    //             $colrow++;
    //         }
    //         if ($lengua == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->lengua);
    //             $colrow++;
    //         }
    //         if ($discapacidad == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->disgrupo." - ".$mat->disdetalle);
    //             $colrow++;
    //         }
    //         if ($correoinst == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, strtolower($mat->carne)."@".getDominio());
    //             $colrow++;
    //         }
    //         if ($celulares == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $txtcelulares);
    //             $colrow++;
    //         }
    //         if ($carrera == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->carrera);
    //             $colrow++;
    //         }
    //         if ($ciclo == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->ciclo);
    //             $colrow++;
    //         }
    //         if ($turno == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->codturno);
    //             $colrow++;
    //         }
    //         if ($seccion == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->codseccion);
    //             $colrow++;
    //         }
    //         if ($periodo == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->periodo);
    //             $colrow++;
    //         }
    //         if ($estado == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->estado);
    //             $colrow++;
    //         }
    //         if ($fecmat == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, date_format(date_create($mat->fechamat),"d/m/Y"));
    //             $colrow++;
    //         }
            
    //         if ($checkplan == "SI") {
    //             $sheet->setCellValueByColumnAndRow($colrow,$fila, $mat->plan);
    //             $colrow++;
    //         }
            
    //         //$sheet->mergeCells("F$fila:G$fila");
    //         /*$edad=($strtimeact - strtotime($mat->fecnac))/31557600;
    //         $sheet->setCellValue('J'.$fila, $mat->fecnac);

    //         $sheet->setCellValue('K'.$fila, intval($edad));
            
    //         $sheet->setCellValue('L'.$fila, $mat->sexo);
    //         $sheet->setCellValue('M'.$fila, " ".$mat->celular);
    //         $sheet->setCellValue('N'.$fila, $mat->ecorporativo);
    //         //AQUI HAY QUE ARREGLAR LO DE DISCAPACIDAD
    //         $sheet->setCellValue('O'.$fila, date_format(date_create($mat->fecinsc),"d/m/Y"));*/
          

    //     }
        
    //     $writer = new Xlsx($spreadsheet);
 
    //     $filename = 'lista_matriculas';
 
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
    //     header('Cache-Control: max-age=0');
     
    //     $writer->save('php://output'); // download file 
    // }

    public function dp_matriculas_deudas_xgrupo()
    {
        $fmcbperiodo=$this->input->get("cp");
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");
        $fmcbplan=$this->input->get("cpl");
        $busqueda=$this->input->get("ap");
        $this->load->model('mdeudas_individual');

        $vmatriculas=$this->mdeudas_individual->m_deudas_xgrupo_matriculado(array($fmcbperiodo,$fmcbcarrera,$fmcbciclo,$fmcbturno,$fmcbseccion));

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
                $sheet->setCellValue("F".$fila, "CUOTA 1");
                $sheet->setCellValue("G".$fila, "CUOTA 2");
                $sheet->setCellValue("H".$fila, "CUOTA 3");
                $sheet->setCellValue("I".$fila, "CUOTA 4");
                $sheet->setCellValue("J".$fila, "CUOTA 5");
                $sheet->getStyle("A$fila:J$fila")->getFont()->setBold(true);
                $sheet->mergeCells("C$fila:E$fila");
                
                $nro=0;
            }
            
            $nro++;
            $fila++;
            
            $sheet->setCellValue("A".$fila, $nro);
          
            //$sheet->setCellValue('D'.$fila, $mat->tdoc);
            //$sheet->setCellValue('E'.$fila, $mat->nro);
            //$c1=;
            
            
            $sheet->setCellValue('B'.$fila, $mat->carne);
            $sheet->setCellValue('C'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
            $sheet->mergeCells("C$fila:E$fila");
            $sheet->setCellValue('F'.$fila, $mat->cuota1);
            $sheet->setCellValue('G'.$fila, $mat->cuota2);
            $sheet->setCellValue('H'.$fila, $mat->cuota3);
            $sheet->setCellValue('I'.$fila, $mat->cuota4);
            $sheet->setCellValue('J'.$fila, $mat->cuota5);


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
        $grupos=$this->mgrupos->m_filtrar(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));
        $grupo=array();
        foreach ($grupos as $gp) {
        	$grupo=$gp;
        }
        $this->load->model('mcargaacademica');
        $vcursos=$this->mcargaacademica->m_filtrar(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));

		$this->load->model('mmatricula');
		$vmatriculas=$this->mmatricula->m_matriculas_x_grupo(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));

		$this->load->model('mmiembros');
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
			 
        $sheet->setCellValue("K85", strtolower($iestp->distrito).", $nombredia $numeroDia de $nombreMes de $anio");
        


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
        $grupos=$this->mgrupos->m_filtrar(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));
        $grupo=array();
        foreach ($grupos as $gp) {
            $grupo=$gp;
        }
        $this->load->model('mcargaacademica');
        $vcursos=$this->mcargaacademica->m_filtrar(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));

        $this->load->model('mmatricula');
        $vmatriculas=$this->mmatricula->m_matriculas_x_grupo(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));

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
                 
            $sheet->setCellValue("O63", strtoupper($iestp->distrito).", $nombredia $numeroDia de $nombreMes de $anio");


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
                if ($fila==33) $fila=38;
                $sheet->setCellValue("A".$fila, $nro);
                $sheet->setCellValue('B'.$fila, $mat->dni);
                $sheet->setCellValue('C'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
                if ($mat->codestado==2) $sheet->setCellValue("U".$fila, "RETIRADO");
                $col=7;
                foreach ($vcursos as $curso) {
                    $col++;
                    foreach ($vnotas as $key => $nota) {
                        if (($mat->codmatricula==$nota->matricula) && ($curso->idcarga==$nota->idcarga)){
                            $sheet->setCellValueByColumnAndRow($col,$fila, $nota->final);
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
                
                if (getDominio() == "iesap.edu.pe") {
                    $drawing->setCoordinates('C2');
                    $drawing->setHeight(45); //pixels
                } else {
                    $drawing->setCoordinates('A1');
                }
                
                $colWidth = $sheet->getColumnDimension('A')->getWidth() + $sheet->getColumnDimension('D')->getWidth();
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
                $sheet->setCellValue("C3", 'EVALUACIONES '.$iestp->nombre);
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
                $sheet->setCellValue("AO22", $iestp->resolucion);
                $sheet->setCellValue("AT15", $curso->periodo);
                $sheet->setCellValue("AO25", $curso->carrera);
                $sheet->setCellValue("AU28", $curso->modulonro);
                $sheet->setCellValue("AS30", $curso->modulo);
                $sheet->setCellValue("AO35", $curso->unidad);
                $sheet->setCellValue("AT38", $curso->periodo);
                $sheet->setCellValue("AT40", ($curso->cred_teo + $curso->cred_pra));
                $sheet->setCellValue("AT42", $curso->horas_ciclo);
                $sheet->setCellValue("AT44", $curso->paterno." ".$curso->materno." ".$curso->nombres );
                $sheet->setCellValue("AT47", $curso->codseccion.'-'.$curso->division);
                $sheet->setCellValue("AW47", $curso->turno);

                $sheet->setCellValue("W59", $curso->unidad);
                
                
                
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
                        //$n=0;
                        foreach ($fechas as $fecha) {
                            //$n--;
                            
                            $alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'] = "F";  
                            foreach ($asistencias as $asistencia) {
                                if (($miembro->idmiembro==$asistencia->idmiembro)&&($asistencia->sesion==$fecha->sesion)){
                                    
                                    $alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'] = $asistencia->accion;  
                                    if (($asistencia->accion=="F") || ($asistencia->accion=="")){
                                        $alumno[$miembro->idmiembro]['asis']['faltas']++;  
                                    }
                                }
                            }
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
                for ($i=16; $i <39 ; $i++) {
                    if (isset($fechas[$i])){
                        $fecha=$fechas[$i];
                        $fechaslt=date("d-m", strtotime($fecha->fecha));
                        $colAsistencia++;
                        
                        $sheet->setCellValueByColumnAndRow($colAsistencia,123, $fechaslt);
                    }
                    
                }



                //ASIST
                $nro=0;
                $fila=66;
                $filaAsistencia1=10;
                $filaAsistencia2=125;
                $filaindc=66;
                $nind=0;
                $nses=$curso->sesiones;
                $nindmax=12;
                
                foreach ($miembros as $mb) {
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
                            $valor=$alumno[$mb->idmiembro]['asis'][$fecha->sesion]['accion'];
                            $sheet->setCellValueByColumnAndRow($colAsistencia,$filaAsistencia1, $valor);
                        }

                    }
                    $filaAsistencia2++;
                    $colAsistencia=2;
                    for ($i=16; $i <39 ; $i++) {
                        if (isset($fechas[$i])){
                            $fecha=$fechas[$i];
                            $colAsistencia++;
                            $valor=$alumno[$mb->idmiembro]['asis'][$fecha->sesion]['accion'];
                            $sheet->setCellValueByColumnAndRow($colAsistencia,$filaAsistencia2, $valor);
                        }
                        
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
                                /////////////
                                if (getDominio()=="iestphuarmaca.edu.pe"){
                                    

                                    $nota=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['PI']['nota'];
                                    $notar=$alumno[$mb->idmiembro]['eval'][$indicador->codigo]['RC']['nota'];
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

                    

                    $pf=$alumno[$mb->idmiembro]['eval']['PF']['nota'];
                    $sheet->setCellValueByColumnAndRow(44,$filaindc, str_pad(floatval($pf), 2, "0", STR_PAD_LEFT));

                    //COLUMNA DE RECUPERACIÓN
                    $sheet->setCellValueByColumnAndRow(47,$filaindc, "--");

                    $fal=$alumno[$mb->idmiembro]['asis']['faltas'];                        
                        
                    $falp=$fal/$nses * 100;

                    if ($falp>=30){
                        $sheet->setCellValueByColumnAndRow(50,$filaindc, 00);
                    }
                    else{

                        $sheet->setCellValueByColumnAndRow(50,$filaindc, str_pad($pf, 2, "0", STR_PAD_LEFT));
                        
                    }
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
                $dominio=str_replace(".", "_",getDominio());
                $spreadsheet = $reader->load("plantillas/acta_asistencias_".$dominio.".xlsx");

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
                
                /*foreach ($miembros as $mat) {
                    if (($mat->eliminado=='NO') && ($mat->ocultar=='NO')){
                        $nro++;
                        $fila++;
                        
                        $sheet->setCellValue("A".$fila, $nro);
                        $sheet->setCellValue('B'.$fila, $mat->carnet);
                        $sheet->setCellValue('C'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
                        
                    }
                }*/
                $coladicionales=count($fechaasist) - 19;
                for ($i=0; $i < $coladicionales ; $i++) { 
                    $sheet->insertNewColumnBeforeByIndex(5,1); 
                    $sheet->getColumnDimension('E')->setWidth(2.7);
                    $sheet->duplicateStyle(
                        $sheet->getStyle('D13'),
                        'E13:D72'
                    );               
                }

                $endCol_letra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($ncol);
                $nro=0;
                $n=0;
                $fila=12;
                foreach ($miembros as $miembro) {
                    $fila++;
                    $sheet->setCellValue("A".$fila, $nro);
                    $sheet->setCellValue('B'.$fila, $miembro->carnet);
                    $sheet->setCellValue('C'.$fila, $miembro->paterno." ".$miembro->materno." ".$miembro->nombres);

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
                        // code...
                        //$fecha=$fechaasist[$i];
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
                 
                $sheet->setCellValue("A76", strtoupper($iestp->distrito).", $nombredia $numeroDia de $nombreMes de $anio");

                $writer = new Xlsx($spreadsheet);
                $filename = 'REGISTRO-DE-ACTAS-DE-ASISTENCIA-'.$curso->unidad;
                //$filename = 'ACTA';

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
             
                $writer->save('php://output'); // download file 

            }
            
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


}