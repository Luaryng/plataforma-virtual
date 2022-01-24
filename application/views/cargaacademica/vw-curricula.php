<?php 
if (isset($usuarios))
{ ?>
	<div id="divtabl-addamiembros" class="col-xs-12 col-md-12 neo-table">
	<div class="col-md-12 header d-none d-md-block">
		<div class="row">
			
			<div class="col-xs-1 col-md-1 cell hidden-xs">
				NRO
			</div>
			<div class="col-xs-12 col-md-2 cell">
				NICK
			</div>
			
			<div class="col-xs-12 col-md-4 cell">
				APELLIDOS Y NOMBRES
			</div>
			<div class="col-xs-2 col-md-3 cell text-center">
				CORREO CORPORATIVO
			</div>
			<div class="col-xs-2 col-md-1 cell text-center">
				
			</div>
			<div class="col-xs-2 col-md-1 cell text-center">
				
			</div>
		</div>
	</div>
	<div class="col-md-12 body">
		<?php
		$nro=0;
		foreach ($cursos as $curso) {
				$nro++;
				$nombres=$usuario->paterno.' '.$usuario->materno.' '.$usuario->nombres;
		?>
		<div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
			<div class="col-xs-12 col-md-2 group">
				<div class="col-xs-6 col-md-3 cell">
					<span><?php echo $nro ;?></span>
				</div>
				<div class="col-xs-12 col-md-9 cell">
					<span><?php echo $usuario->usuario ?></span>
				</div>
			</div>
			<!---->
			<div class="col-xs-2 col-md-4 cell">
				<span><?php echo $nombres ?></span>
			</div>
			
			<div class="col-xs-2 col-md-4 cell">
				<span><?php echo $usuario->ecorporativo ?></span>
			</div>
			<div class="col-xs-12 col-md-2 group">
				<div class="col-xs-12 col-md-3 cell text-center">
					<button class="btn btn-sm btn-success btn-block" href="#" onclick="viewsedes('<?php echo base64url_encode($usuario->idusuario) ?>')" title="Sedes">
						<i class="far fa-building"></i> <span class="d-block d-md-none">Sedes </span>
					</button> 
				</div>
				<div class="col-xs-6 col-md-3 cell text-center">
					<a class="btn btn-sm btn-info btn-block" href="#" data-toggle="modal" data-target="#modalEditar" data-iduser="" data-cor="'.$usuario->ecorporativo.'" title="Cambiar contraseña">
						<i class="fas fa-key"></i> <span class="d-block d-md-none">Cambiar</span>
					</a>
				</div>
				<div class="col-xs-6 col-md-3 cell text-center">
					<button class="btn btn-sm btn-warning btn-block" href="#" onclick="viewpermisos('<?php echo base64url_encode($usuario->idusuario) ?>')" title="Permisos">
						<i class="fas fa-shield-alt"></i> <span class="d-block d-md-none">Permisos </span>
					</button>
				</div>
				<div class="col-xs-12 col-md-3 cell text-center">
					<a class="btn btn-sm btn-danger btn-block" href="#" data-toggle="modal" data-target="#modalDesactivar" data-id="'.base64url_encode($usuario->idusuario).'" title="Desactivar">
						<i class="fas fa-user-times"></i> <span class="d-block d-md-none">Desactivar </span>
					</a>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<?php  
}
else
{
		echo "<h4>Sin resultados</h4>";
} 
?>
