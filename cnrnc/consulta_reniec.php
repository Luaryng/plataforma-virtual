<?php
require 'simple_html_dom.php';
//error_reporting(E_ALL ^ E_NOTICE);

$status = FALSE;
$msg = 'Ingresa un número de DNI';
if (isset($_POST['dni'])){
	$dni = $_POST['dni'];
	$msg = 'Solo se debe ingresar caracteres numéricos';
	if (ctype_digit($dni)){
		$msg = 'El número debe tener 8 caracteres';
		
		if (strlen($dni)>7){
			try {
				$cn = json_decode(file_get_contents("https://dniruc.apisperu.com/api/v1/dni/$dni?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNvbXB1dGVyX21hc3Rlcl8yMDE5QGhvdG1haWwuY29tIn0.W3YXR2WIF4kVNGFRdlGEp6QKk-3FB2N2mnX881I0dPg"),true);
			} catch (Exception $e) {
			    $cn=FALSE;
			}
			$msg = 'Ocurrio un error, comunicate con el proveedor';
			//LA LOGICA DE LA PAGINAS ES APELLIDO PATERNO | APELLIDO MATERNO | NOMBRES
			if ($cn==FALSE){
				
			}
			else{
				//$consulta =$cn->plaintext;
				$msg = 'Número no encontrado en el Padron Electoral';
				$datosnombres = array();
				foreach($cn as $header) {
				 $datosnombres[] = $header;
				}
				
				$result = $cn;
				$datos['result'] = $cn;
				$datos['datos'] = $datosnombres[0];
				if ($datosnombres[0] != false) {
					$status = TRUE;
					$msg = 'Número encontrado';
					$datos['paterno'] = $cn['apellidoPaterno'];
					$datos['materno'] = $cn['apellidoMaterno'];
					$datos['nombres'] = $cn['nombres'];
				} else {
					$status = false;
					$msg = 'Pertenece a un menor de edad';
				}

			}
		
		}
	}
	//OBTENEMOS EL VALOR
}
$datos['status'] = $status;
$datos['msg'] = $msg;

echo json_encode($datos);
?>
