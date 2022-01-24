<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('getPermitido')){
	function getPermitido($idperm){
		if ($_SESSION['userActivo']->codnivel==0) return "SI";
  		$prms = $_SESSION['userPermisos'];
		if (array_key_exists($idperm,$prms)){
			return $prms[$idperm];
		}
		else{
			return "NO";
		}
	}
}

if(!function_exists('getUserOptions')){
	function getUserOptions($key){
  		$prms = $_SESSION['UserOptions'];
		if (array_key_exists($key,$prms)){
			return $prms[$key];
		}
		else{
			return null;
		}
	}
}

if(!function_exists('comprobarFoto')){
	function comprobarFoto($ruta){
		if (@getimagesize($ruta)){
			return true;
		} else {
			return false;
		}
	}
}

if(!function_exists('base64url_encode')){
	function base64url_encode($input) {
	 return strtr(base64_encode($input), '+/=', '._-');
	}
}

if(!function_exists('base64url_decode')){
	function base64url_decode($input) {
	 return base64_decode(strtr($input, '._-', '+/='));
	}
}

if(!function_exists('url_clear')){
	function url_clear($url) {
	 $url = strtolower($url);
	 //Reemplazamos caracteres especiales latinos
	 $find = array('á','é','í','ó','ú','â','ê','î','ô','û','ã','õ','ç','ñ');
	 $repl = array('a','e','i','o','u','a','e','i','o','u','a','o','c','n');
	 $url = str_replace($find, $repl, $url);
	 //Añadimos los guiones
	 $find = array(' ', '&', '\r\n', '\n','+');
	 $url = str_replace($find, '-', $url);
	 //Eliminamos y Reemplazamos los demas caracteres especiales
	 $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<{^>*>/');
	 $repl = array('', '-', '');
	 $url = preg_replace($find, $repl, $url);
	 return $url;
	}
}

if(!function_exists('fechaCastellano')){
	function fechaCastellano ($fecha,$meses_ES,$dias_ES) {
		$strfecha=strtotime($fecha);
		$numeroDia = date('w', $strfecha);
		$dia = date('d', $strfecha);
		$mes = date('n', $strfecha);
		$anio = date('Y', $strfecha);
		
		$nombredia =$dias_ES[$numeroDia];
		$nombreMes = $meses_ES[$mes -1];
		//return $nombredia.", ".$dia." de ".$nombreMes." de ".$anio;
		return $nombredia.", ".$dia."- ".$nombreMes."- ".$anio;
	}
}

if(!function_exists('getDominio')){
	function getDominio() {
		/*$domexp=explode(".",base_url());
		$ultexp=count($domexp);*/
		//$domimail=$domexp[$ultexp - 3].".".$domexp[$ultexp - 2].".".substr($domexp[$ultexp - 1],0,2);
		//$domimail="localhost";
		//$domimail="iestphuarmaca.edu.pe";
		$domimail="iestpcanchaque.edu.pe";
		//$domimail="charlesashbee.edu.pe";
		return $domimail;
	}
}


if(!function_exists('getIcono')){
	function getIcono ($tamanio,$nombre){
		$icon="<i class='fas fa-download mr-2'></i>";
		$ext          = explode(".", $nombre);
		$exten    = end($ext);
		if ($tamanio=='P'){
			if ($exten=="pdf"){
		        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_pdf.png' alt='PDF'>";
		    }
		    else if(($exten=="mp4")||$exten=="mpg"){
		        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_vdo.png' alt='VÍDEO'>";
		    }
		    else if(($exten=="jpg")||$exten=="png"){
		        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_img.png' alt='IMAGEN'>";
		    }
		    else if(($exten=="doc")||$exten=="docx"){
		        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_word.png' alt='WORD'>";
		    }
		    else if(($exten=="ppt")||$exten=="pptx"){
		        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_ppt.png' alt='POWERPOINT'>";
		    }
		    else if(($exten=="xls")||$exten=="xlsx"){
		        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_excel.png' alt='EXCEL'>";
		    }
		}elseif ($tamanio=='G') {
			# code...
		}
		return $icon;
	}
}



if(!function_exists('hms_restantes')){
	function hms_restantes($hora_alta,$hora_cierre=""){
		date_default_timezone_set('America/Lima');
		$fecha1 = new DateTime($hora_alta);//fecha inicial
		$fecha2 = ($hora_cierre=="") ? new DateTime() : new DateTime($hora_cierre)  ;
		$intervalo = $fecha1->diff($fecha2);
		$dias="";
		$horas="";
		$minutos="";
		switch ($intervalo->format("%a")) {
			case '0':
				break;
			case '1':
				$dias=$intervalo->format("%a día ");
				break;
			default:
				$dias=$intervalo->format("%a días ");
				break;
		}
		switch ($intervalo->format("%H")) {
			case '0':
				break;
			case '1':
				$horas=$intervalo->format("%H hora ");
				break;
			default:
				$horas=$intervalo->format("%H horas ");
				break;
		}
		switch ($intervalo->format("%i")) {
			case '0':
				break;
			case '1':
				$minutos=$intervalo->format("%i minuto ");
				break;
			default:
				$minutos=$intervalo->format("%i minutos ");
				break;
		}
		if ($fecha1<$fecha2){
        return "<span class='text-info'>Actividad retrasada por: $dias$horas$minutos</span>";
        }
        else{
        return "<span class='text-primary'>$dias$horas$minutos</span>";
        }
	}
}

if(!function_exists('optimiza_img')){
	function optimiza_img($filecontrol,$configimg,$configthumb=""){
		$dataex['link']="";
		$dataex['status']=false;
		if(isset($filecontrol)){
			//Funciones optimizar imagenes
			//Ruta de la carpeta donde se guardarán las imagenes
			//$patch='resources/fotos/tmp';
			//Parámetros optimización, resolución máxima permitida
			$patch=(isset($configimg['patch']))?$configimg['patch']:'resources/fotos/tmp';
			$max_ancho = (isset($configimg['ancho']))?$configimg['ancho']:900;
			$max_alto = (isset($configimg['alto']))?$configimg['alto']:350;
			if($filecontrol['type']=='image/png' || $filecontrol['type']=='image/jpeg' || $filecontrol['type']=='image/gif'){
				$dataex['msg'] = "Ocurrio un error al subir la imagen";
				$medidasimagen= getimagesize($filecontrol['tmp_name']);

				$fileNameExt  = $filecontrol["name"];
		        $ext          = explode(".", $fileNameExt);
		        $extension    = end($ext);
		        $nro_rand=rand(0,9);
				$nombrearchivo  = $_SESSION['userActivo']->codpersona.$nro_rand.date("d") . date("m") . date("Y") . date("H") . date("i").".".$extension;
				//Si las imagenes tienen una resolución y un peso aceptable se suben tal cual
				$copiado=false;
				if($medidasimagen[0] < $max_ancho && $filecontrol['size'] < 200000){
					if ($configthumb!=""){
						$patch_th=(isset($configthumb['patch']))?$configthumb['patch']:'resources/fotos/tmp';
						$max_ancho_th = (isset($configthumb['ancho']))?$configthumb['ancho']:900;
						$max_alto_th = (isset($configthumb['alto']))?$configthumb['alto']:350;
						$rtOriginal=$filecontrol['tmp_name'];
						if($filecontrol['type']=='image/jpeg'){
							$original = imagecreatefromjpeg($rtOriginal);
						}
						else if($filecontrol['type']=='image/png'){
							$original = imagecreatefrompng($rtOriginal);
						}
						else if($filecontrol['type']=='image/gif'){
							$original = imagecreatefromgif($rtOriginal);
						}
						list($ancho,$alto)=getimagesize($rtOriginal);
						$x_ratio = $max_ancho_th / $ancho;
						$y_ratio = $max_alto_th / $alto;

						

						if( ($ancho <= $max_ancho_th) && ($alto <= $max_alto_th) ){
							$ancho_final_th = $ancho;
							$alto_final_th = $alto;
						}
						elseif (($x_ratio * $alto) < $max_alto_th){
							$alto_final_th = ceil($x_ratio * $alto);
							$ancho_final_th = $max_ancho_th;
						}
						else{
							$ancho_final_th = ceil($y_ratio * $ancho);
							$alto_final_th = $max_alto_th;
						}

						$lienzo_th=imagecreatetruecolor($ancho_final_th,$alto_final_th);
						imagecopyresampled($lienzo_th,$original,0,0,0,0,$ancho_final_th, $alto_final_th,$ancho,$alto);
						//imagedestroy($original);
						$cal=8;
						
						if($filecontrol['type']=='image/jpeg'){
							$copiado=imagejpeg($lienzo_th,$patch_th."/".$nombrearchivo);
						}
						else if($filecontrol['type']=='image/png'){
							$copiado=imagepng($lienzo_th,$patch_th."/".$nombrearchivo);
						}
						else if($filecontrol['type']=='image/gif'){
							$copiado=imagegif($lienzo_th,$patch_th."/".$nombrearchivo);
						}
					}
					move_uploaded_file($filecontrol['tmp_name'], $patch.'/'.$nombrearchivo);
					$copiado=true;
				}
				//Si no, se generan nuevas imagenes optimizadas
				else {
					$dataex['msg'] = "Ocurrio un error al optimizar la imagen";
					//Redimensionar
					$rtOriginal=$filecontrol['tmp_name'];
					if($filecontrol['type']=='image/jpeg'){
						$original = imagecreatefromjpeg($rtOriginal);
					}
					else if($filecontrol['type']=='image/png'){
						$original = imagecreatefrompng($rtOriginal);
					}
					else if($filecontrol['type']=='image/gif'){
						$original = imagecreatefromgif($rtOriginal);
					}
					list($ancho,$alto)=getimagesize($rtOriginal);
					$x_ratio = $max_ancho / $ancho;
					$y_ratio = $max_alto / $alto;
					if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
						$ancho_final = $ancho;
						$alto_final = $alto;
					}
					elseif (($x_ratio * $alto) < $max_alto){
						$alto_final = ceil($x_ratio * $alto);
						$ancho_final = $max_ancho;
					}
					else{
						$ancho_final = ceil($y_ratio * $ancho);
						$alto_final = $max_alto;
					}
					$lienzo=imagecreatetruecolor($ancho_final,$alto_final);
					imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
					//imagedestroy($original);
					$cal=8;
					
					if($filecontrol['type']=='image/jpeg'){
						$copiado=imagejpeg($lienzo,$patch."/".$nombrearchivo);
					}
					else if($filecontrol['type']=='image/png'){
						$copiado=imagepng($lienzo,$patch."/".$nombrearchivo);
					}
					else if($filecontrol['type']=='image/gif'){
						$copiado=imagegif($lienzo,$patch."/".$nombrearchivo);
					}

					if ($configthumb!=""){
						$patch_th=(isset($configthumb['patch']))?$configthumb['patch']:'resources/fotos/tmp';
						$max_ancho_th = (isset($configthumb['ancho']))?$configthumb['ancho']:50;
						$max_alto_th = (isset($configthumb['alto']))?$configthumb['alto']:100;

						$x_ratio_th = $max_ancho_th / $ancho;
						$y_ratio_th = $max_alto_th / $alto;

						if( ($ancho <= $max_ancho_th) && ($alto <= $max_alto_th) ){
							$ancho_final_th = $ancho;
							$alto_final_th = $alto;
						}
						elseif (($x_ratio_th * $alto) < $max_alto_th){
							$alto_final_th = ceil($x_ratio_th * $alto);
							$ancho_final_th = $max_ancho_th;
						}
						else{
							$ancho_final_th = ceil($y_ratio_th * $ancho);
							$alto_final_th = $max_alto_th;
						}

						$lienzo_th=imagecreatetruecolor($ancho_final_th,$alto_final_th);
						imagecopyresampled($lienzo_th,$original,0,0,0,0,$ancho_final_th, $alto_final_th,$ancho,$alto);
						//imagedestroy($original);
						$cal=8;
						
						if($filecontrol['type']=='image/jpeg'){
							$copiado=imagejpeg($lienzo_th,$patch_th."/".$nombrearchivo);
						}
						else if($filecontrol['type']=='image/png'){
							$copiado=imagepng($lienzo_th,$patch_th."/".$nombrearchivo);
						}
						else if($filecontrol['type']=='image/gif'){
							$copiado=imagegif($lienzo_th,$patch_th."/".$nombrearchivo);
						}
					}

				}
		        $dataex['status']=$copiado;
		        if ($copiado) {
		        	$dataex['msg'] = "Imagen en servidor";
		            $dataex['link'] = $nombrearchivo;
		        }
			}
			else {
				$dataex['msg'] = "Solo se aceptan imágenes";
			}
		}
		//header('Content-Type: application/x-json; charset=utf-8');
        return $dataex;
	}
}

