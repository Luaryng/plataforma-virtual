<style>
	@import url('https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@1,500&display=swap');
	@page {
		margin-top: 0.5cm;
		margin-bottom: 0.5cm;
		margin-left: 1.5cm;
		margin-right: 1.5cm;
		
	}
	body { 
    	font-family: serif; 
    	font-size: 10pt; 
    	font-family: 'Ubuntu', sans-serif;
	}
	
	/*.instruc{
		border: 1px solid black;
		border-collapse: separate;
  		border-spacing: 10px;
  		overflow: wrap;
		width: 100%;
		margin-bottom: 10px;
	}*/

	.instruc{
  		border-spacing: 5px;
  		overflow: wrap;
		width: 100%;
		margin-bottom: 10px;
	}

	.instruc th,td{
		border: 0px ;
	}
	.instruc .titulo{
		font-size: 14px;
		font-weight: bold;
		/*height: 1cm;*/
		text-align: center;
		
	}
	.instruc .border-buttom {
		border-bottom: 1px solid black;
	}

	.instruc .subtitulo{
		font-size: 13px;
		font-weight: bold;
		/*height: 1cm;*/
		text-align: center;
	}

	.instruc .celda-texto{
		text-align: left;
		font-size: 10px;
	}

	.div_opcion {
		width: 10px;
		height: 10px;
		border: solid 1px gray;
		padding: 0px 2px;
	}

	.item-texto {
		font-size: 10px;
	}

	.divrptas {
		margin-top: -20px;
	}


	
	
</style>

<?php 
$vbaseurl=base_url();
$dias_ES = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
function echocard($vnum,$pgta){
    $colorcard=($pgta->codpregunta==0)?"card-danger":"card-primary";
    $codpregunta=base64url_encode($pgta->codpregunta);
    $pgvalor=floatval($pgta->valor);
    $pgpuntos=floatval($pgta->puntos);
    $venunciado=htmlspecialchars(stripslashes($pgta->enunciado));
    $venunciadox=htmlspecialchars(stripslashes($pgta->enunciadox));
    echo "<div name='ancla$codpregunta'  id='ancla$codpregunta' class='card-pregunta $colorcard' data-numero='$vnum' data-codpg='$codpregunta' data-tipopg='$pgta->codtipo' data-obligatoria='$pgta->vacio' >
            <table class='instruc' autosize='1'>
            	<tr><th colspan='2' class='celda-texto'>$vnum .- $venunciado</th></tr>
            	<tr><td colspan='2' class='celda-texto'><small>$venunciadox</small></td></tr>
            </table>

            <div class='divrptas' data-contador='0'>
            	<br>
            	<table class='divrptas'>";
                    $nro=0;
                    $tipocheck="radio";
                    if ($pgta->codtipo==4){
                        $tipocheck="checkbox";
                    }
                    if ($pgta->codtipo==7){
                        $rptexto=htmlspecialchars(stripslashes($pgta->texto));
                        echo "<tr>
                        		<td width='25px'></td>
                        		<td class='celda-texto'>$rptexto</td>
                        	</tr>";
                        
                    }
                    else
                    {
                    	
                        foreach ($pgta->rpts as $key => $rp) {
                            $nro++;
                            $codrp=base64url_encode($rp->codrpta);
                            $rpicon="";
                            if ($rp->marcada=="SI"){
                                $rpicon="x";
                               
                            }
                            $rpenunciadop=htmlspecialchars(stripslashes($rp->enunciado));
                            echo "<tr>
                            		<td width='25px'></td>
                            		<td class='div_opcion'>$rpicon</td>
                            		<td class='item-texto' >$rpenunciadop</td>
                            	</tr>";
				                
                            
                        }

                        

                    }
            echo "</table>
            </div>";
                
            echo "
        </div>";
}
?>

<div style="width: 100%; float: left;">
	<table class="instruc"  autosize="1">
		<tr>
			<td class="subtitulo" colspan="6">
				 <?php echo $iestp->denoml ?>
			</td>
		</tr>
		<tr>
			<td class="titulo" colspan="6"><?php echo $mat->nombre ?></td>
		</tr>
		<tr><td colspan="6" class="border-buttom"></td></tr>
		<tr>
			<th colspan="1" class="celda-texto">PROGRAMA:</th>
			<td colspan="3" class="celda-texto"><?php echo $curso->carrera. ' - ' . $curso->periodo ?></td>
			<th colspan="1" class="celda-texto">SEMESTRE:</th>
			<td colspan="1" class="celda-texto"><?php echo $curso->ciclo ?></td>
		</tr>
		<tr>
			<th colspan="1" class="celda-texto">TURNO/SECCIÓN:</th>
			<td colspan="1" class="celda-texto"><?php echo $curso->turno.' '.$curso->codseccion.$curso->division ?></td>
			<th colspan="1" class="celda-texto">DOCENTE:</th>
			<td colspan="3" class="celda-texto"><?php echo $curso->paterno." ".$curso->materno." ".$curso->nombres ?></td>
		</tr>
		<tr>
			<th colspan="1" class="celda-texto">UND.DIDÁCTICA:</th>
			<td colspan="5" class="celda-texto"><?php echo $curso->unidad ?></td>
		</tr>
		<tr>
			<th colspan="1" class="celda-texto">ESTUDIANTE:</th>
			<td colspan="5" class="celda-texto"><?php echo $datomiembro->paterno.' '.$datomiembro->materno.' '.$datomiembro->nombres ?></td>
		</tr>
	</table>
	<div class="container-fluid">
        <?php 
            $nropregunta=0;
            $ptotal=0;
            foreach ($preguntas as $key => $pregunta) {
                $nropregunta++;
                $rp=array();
                if (isset($respuestas[$pregunta->codpregunta])) $rp=$respuestas[$pregunta->codpregunta];
                
                //var_dump($rp);
                $ptotal=$ptotal + $pregunta->valor;
                
                echocard($nropregunta,$pregunta);
            }
        ?>
            
    </div>	
</div>
