<?php
$conexion = mysqli_connect('localhost','root','','iappiu5y_erp');

$consulta = mysqli_query($conexion, "SELECT 
                  tb_prog_multimedia.prog_id id,
                  tbusuario.usu_apel_paterno usupat,
                  tbusuario.usu_apel_materno usumat,
                  tbusuario.usu_nombres usunom,
                  tb_prog_multimedia.tur_codigo idturno,
                  tb_prog_multimedia.prog_horaini horini,
                  tb_prog_multimedia.prog_horafin horfin,
                  tb_prog_multimedia.prog_aula idaula,
                  tbaula.aul_nombre aular,
                  tb_prog_multimedia.prog_cnthoras horas,
                  tb_prog_multimedia.prog_equipos equipos,
                  tb_prog_multimedia.prog_dia dia,
                  tb_prog_multimedia.prog_fecha fecha,
                  tb_prog_multimedia.estado estado,
                  tb_prog_multimedia.prog_fecha_reg fecreg
                FROM
                  tbaula
                  INNER JOIN tb_prog_multimedia ON (tbaula.aul_id = tb_prog_multimedia.prog_aula)
                  INNER JOIN tbusuario ON (tb_prog_multimedia.usu_codigo = tbusuario.usu_codigo)");
$array=mysqli_fetch_array($consulta);
$fila=8;

//Fecha actual
date_default_timezone_set('GMT');
$fecha= date("d-M-Y");

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;

//Crear un nuevo archivo
$spreadsheet = new Spreadsheet();

//Propiedades del archivo
$spreadsheet->getProperties()->setCreator('Sistemas')
    ->setTitle('Reporte de pedidos erp')
    ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.');

//Informacion de los pedidos
$spreadsheet->setActiveSheetIndex(0);
$spreadsheet->getActiveSheet()
    ->setTitle('Resumen')
    ->setCellValue('A1', 'Reporte de pedidos erp')
    ->setCellValue('A2', $fecha)
    ->setCellValue('A3', 'Soporte');

$spreadsheet->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold(true)->setSize(18);

//Encabezados del resumen
$spreadsheet->getActiveSheet()
    ->mergeCells('C5:L5')
    ->mergeCells('C6:D6')
    ->mergeCells('E6:J6')
    ->mergeCells('K6:L6')
    ->setCellValue('C5', 'RESUMEN DE PEDIDOS MULTIMEDIA')
    ->setCellValue('C6', 'DOCENTES')
    ->setCellValue('E6', 'DETALLE PEDIDO')
    ->setCellValue('J6', 'FECHAS')
    ->setCellValue('C7', 'APELLIDOS')
    ->setCellValue('D7', 'NOMBRES')
    ->setCellValue('E7', 'Hora de Inicio')
    ->setCellValue('F7', 'Hora Fin')
    ->setCellValue('G7', 'AULA')
    ->setCellValue('H7', 'EQUIPOS')
    ->setCellValue('I7', 'ESTADO')
    ->setCellValue('J7', 'TURNO')
    ->setCellValue('K7', 'FECHA DE PEDIDO')
    ->setCellValue('L7', 'FECHA REGISTRO');

$spreadsheet->getActiveSheet()->getStyle('C5:L5')->getFont()->setBold(true)->setSize(20);
$spreadsheet->getActiveSheet()->getStyle('C6:L6')->getFont()->setBold(true)->setSize(12);
$spreadsheet->getActiveSheet()->getStyle('C5:L5')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('C6:D6')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('E6:I6')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('J6:L6')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('E7')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('I7')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('J7')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('K7')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('L7')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('C5:L7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
$spreadsheet->getActiveSheet()->getStyle('C5:L7')->getFont()->getColor()->setRGB('FFFFFF');

//Datos de la base
while ($row=mysqli_fetch_array($consulta)) {
$spreadsheet->getActiveSheet()
    ->setCellValue('C'.$fila, $row['usupat'])
    ->setCellValue('D'.$fila, $row['usunom'])
    ->setCellValue('E'.$fila, $row['horini'])
    ->setCellValue('F'.$fila, $row['horfin'])
    ->setCellValue('G'.$fila, $row['aular'])
    ->setCellValue('H'.$fila, $row['equipos'])
    ->setCellValue('I'.$fila, $row['estado'])
    ->setCellValue('J'.$fila, $row['idturno'])
    ->setCellValue('K'.$fila, $row['fecha'])
    ->setCellValue('L'.$fila, $row['fecreg']);
$spreadsheet->getActiveSheet()->getStyle('C'.$fila.'')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('D'.$fila.'')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('E'.$fila.'')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('F'.$fila.'')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('G'.$fila.'')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('H'.$fila.'')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('I'.$fila.'')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('J'.$fila.'')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('K'.$fila.'')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('L'.$fila.'')->getAlignment()->setHorizontal('center');
$fila++;
}



//Generar archivo Excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte Pedidos.xlsx"');
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');



/*Congelar fila1
$spreadsheet->getActiveSheet()->freezePane('A2');
*/

// Redireccionamos para que descargue el archivo generado
// header("Location: hola_mundo.xlsx");
?>