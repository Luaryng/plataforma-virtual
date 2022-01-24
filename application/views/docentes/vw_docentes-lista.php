<?php 
if (isset($trabajadores))
{ ?>
	<div id="divtabl-addamiembros" class="col-12 col-md-12 btable">
	<div class="col-md-12 thead d-none d-md-block">
		<div class="row text-bold">
			
			<div class="col-12 col-md-2">
				<div class="row">
				<div class="col-6 col-md-3 td">
					N°
				</div>
				<div class="col-12 col-md-9 td">
					COD
				</div>
				</div>
			</div>
			
			<div class="col-12 col-md-4 td">
				APELLIDOS Y NOMBRES
			</div>
			<div class="col-2 col-md-3 td text-center">
				CORREO CORPORATIVO
			</div>
			<div class="col-2 col-md-1 td text-center">
				TIPO
			</div>
			<div class="col-2 col-md-1 td text-center">
				EST
			</div>
			<div class="col-2 col-md-1 td text-center">
				
			</div>
		</div>
	</div>
	<div class="col-md-12 tbody" id="divcard_adminis">
		<?php
		$nro=0;
		$vflat="";
        $vtitle="";
        $vicon="";
        $btncolor="";
        $accion= "";
        $estado="";
		foreach ($trabajadores as $usuario) {
				$fn="";
				$nro++;
				$nombres=$usuario->paterno.' '.$usuario->materno.' '.$usuario->nombres;
				$call_editar="call_editar('".base64url_encode($usuario->codtrabajador)."')";

				if ($usuario->activo == "SI") {
					$vflat="desactivardocente";
                    $vtitle="Desactivar";
                    $vicon="fa fa-toggle-on";
                    $btncolor="btn-success btn-sm";
                    $accion= "NO";
                    $estado="Habilitado";
				} else {
					$vflat="activardocente";
                    $vtitle="Activar";
                    $vicon="fa fa-toggle-off";
                    $btncolor="btn-danger btn-sm";
                    $accion= "SI";
                    $estado="Inhabilitado";
				}
		?>
		<div class="row rowcolor">
			<div class="col-12 col-sm-2 col-md-2 ">
				<div class="row">
					<div class="col-6 col-sm-3 col-md-3 td">
						<span><?php echo $nro ;?></span>
					</div>
					<div class="col-6 col-sm-9 col-md-9 td">
						<b><?php echo $usuario->codtrabajador ?></b>
					</div>
				</div>
			</div>
			<div class="col-3 col-sm-2 col-md-1 td">
				<span><?php echo $usuario->dni ?></span>
			</div>
			<div class="col-9 col-sm-4 col-md-3 td">
				<span><?php echo $nombres ?></span>
			</div>
			
			<div class="col-12 col-sm-4 col-md-3 td">
				<span><?php echo $usuario->ecorporativo ?></span>
			</div>
			<div class="col-4 col-sm-4 col-md-1 td text-center">
				<span><?php echo ($usuario->tipo) ?></span>
			</div>
			<div class="col-4 col-sm-4 col-md-1 td text-center">
				<span  title='<?php echo $vtitle ?>' class='msgtooltip'>
                    <a data-flat='<?php echo $vflat ?>' data-codigo='<?php echo base64url_encode($usuario->codtrabajador) ?>' data-act='<?php echo $accion ?>' class='btn <?php echo $btncolor ?> updateactiv' href='#'>
                        <i class='<?php echo $vicon ?>'></i>
                    </a>
                </span>
			</div>
			<div class="col-4 col-sm-4 col-md-1 td">
				<div class="btn-group ">  
					<button class="btn btn-warning btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
					<i class="fas fa-cog mr-1"></i>
					</button> 
					<div class="dropdown-menu  dropdown-menu-right"> 
						<a  href="#" class="dropdown-item" onclick="<?php echo $call_editar ?>" data-coddocente="<?php echo $usuario->codtrabajador ?>" data-cor="'.$usuario->ecorporativo.'" title="Modificar datos">
							<i class="fas fa-user-edit mr-1"></i> Editar
						</a> 
						
						
						<div class="dropdown-divider"></div> 
					</div> 
				</div> 

			</div>
		</div>
		<?php } ?>
	</div>
</div>
<script>
	$(".btn-editar").click(function(event) {
		cargaDatosDocente($(this));
	});
	// $('.msgtooltip').tooltip();
</script>
<?php  
}
else
{
		echo "<h4>Sin resultados</h4>";
} 
?>
