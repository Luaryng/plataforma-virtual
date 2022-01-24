<style>
	@page {
		margin-top: 0.5cm;
		margin-bottom: 0.5cm;
		margin-left: 0.5cm;
		margin-right: 0.5cm;
		
	}
	body { 
    	font-family: serif; 
    	font-size: 10pt; 
	}
	
	.instruc{
		border: 1px solid black;
		border-collapse: separate;
  		border-spacing: 10px;
  		overflow: wrap;
		width: 100%;
		margin-bottom: 10px;
  		/*font-family: "Times New Roman", Times, serif;*/
	}
	.instruc th,td{
		border: 0px ;
	}
	.instruc .titulo{
		font-size: 17px;
		font-weight: bold;
		height: 1.3cm;
		text-align: center;
		
	}
	.instruc .border-buttom {
		border-bottom: 1px solid black;
	}

	.instruc .subtitulo{
		font-size: 13px;
		font-weight: bold;
		height: 1.3cm;
		text-align: center;
	}

	.instruc .celda-texto{
		text-align: left;
		font-size: 14px;
		/*width: 8.3cm;*/
	}

	.lstitem{
		border-collapse: collapse;
		width: 100%;
	}

	.lstitem .head-title {
		border: 1px solid black;
		border-collapse: separate;
  		border-spacing: 10px;
  		overflow: wrap;
  		font-size: 10px;
  		height: 1.3cm;
	}

	.lstitem .celdanro{
		font-size: 10px;
		padding-left: 2px;
		padding-right: 2px;
		text-align: center;
		height: 0.4cm;
		border: 1px solid black;
		border-collapse: collapse;
	}

	.lstitem .celda{
		border: 1px solid black;
		border-collapse: collapse;
	}

	.lstitem .celda{
		font-size: 10.5px;
		padding-left: 2px;
		padding-right: 2px;
		text-align: left;
		/*height: 0.4cm;*/
	}

	.lstitem .center-text {
		text-align: center;
	}
	
	
</style>
<div style="width: 100%; float: left;">
	<table class="instruc"  autosize="1">
		<tr>
			<td rowspan="2" colspan="1"><img src="<?php echo base_url().'resources/img/logo_h80.'.getDominio().'.png' ?>" alt=""></td>
			<td class="subtitulo" colspan="5"><?php echo $iestp->denoml ?></td>
		</tr>
		<tr>
			<td class="titulo" colspan="5"><?php echo "EVALUACIONES ".$iestp->nombre ?></td>
		</tr>
		<tr><td colspan="6" class="border-buttom"></td></tr>
		<tr>
			<th colspan="1" class="celda-texto">PERIODO:</th>
			<td colspan="1"><?php echo $curso->periodo ?></td>
			<th colspan="1" class="celda-texto">PROGRAMA:</th>
			<td colspan="3"><?php echo $curso->carrera ?></td>
		</tr>
		<tr>
			<th colspan="1" class="celda-texto">SEMESTRE:</th>
			<td colspan="1"><?php echo $curso->ciclo ?></td>
			<th colspan="1" class="celda-texto">TURNO:</th>
			<td colspan="1"><?php echo $curso->turno ?></td>
			<th colspan="1" class="celda-texto">SECCIÓN:</th>
			<td colspan="1"><?php echo $curso->codseccion.$curso->division ?></td>
		</tr>
		<tr>
			<th colspan="1" class="celda-texto">DOCENTE:</th>
			<td colspan="5"><?php echo $curso->paterno." ".$curso->materno." ".$curso->nombres ?></td>
		</tr>
		<tr>
			<th colspan="2" class="celda-texto">UND.DIDÁCTICA:</th>
			<td colspan="4"><?php echo $curso->unidad ?></td>
		</tr>
		<tr>
			<th colspan="1" class="celda-texto">TEMA:</th>
			<td colspan="5"><?php echo $material->nombre ?></td>
		</tr>
	</table>
	<table class="lstitem" autosize="1" cellpadding="0">
		<tr>
			<th class="head-title">N°</th>
			<th class="head-title">DNI</th>
			<th class="head-title">APELLIDOS Y NOMBRE</th>
			<th class="head-title">ENTREGA</th>
			<th class="head-title">NOTA</th>
		</tr>
		<?php
		$nro = 0;
		$dias_ES = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
        $meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
        
		foreach ($miembros as $mat) {
			$nro ++;
			$entrega = "-Sin entregar";
            $nota = 0;
			echo "<tr>
					<td class='celdanro'>$nro</td>
					<td class='celda'>$mat->dni</td>
					<td class='celda'>$mat->paterno $mat->materno $mat->nombres</td>";
				
	            foreach ($evaluaciones as $keyeva => $eva) {
	                if ($mat->idmiembro == $eva->codmiembro) {
	                    $nota = ($eva->nota=="") ? "0" : str_pad($eva->nota, 2, "0", STR_PAD_LEFT);
	                    if ($eva->fentrega!=""){
	                    	$entrega = fechaCastellano($eva->fentrega,$meses_ES,$dias_ES)." ".date("h:i a",strtotime($eva->fentrega));
	                    }
	                    unset($evaluaciones[$keyeva]);
	                }
	                
	            }
	            echo "<td class='celda'>$entrega</td>
	                	<td class='celda center-text'>$nota</td>";

			echo "</tr>";
		}
		?>
	</table>
</div>