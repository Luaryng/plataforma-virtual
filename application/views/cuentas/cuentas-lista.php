<?php 
if (isset($usuarios))
{ ?>
	<div class="table-responsive">
		<table id="tbmt_dtusuarios" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
			<thead>
	      <tr class="bg-lightgray">
	      	<th>N°</th>
	      	<th>USER</th>
	      	<th>APELLIDOS Y NOMBRES</th>
	      	<th>CORREO CORPORATIVO</th>
	      	<th>ACCIONES</th>
	      </tr>
	    </thead>
	    <tbody>
         <?php
         		$nro=0;
						foreach ($usuarios as $usuario) {
							if (($usuario->codnivel!=0) || ($_SESSION['userActivo']->codnivel==0)){
								$fn="";
								$nro++;
								$nombres=$usuario->paterno.' '.$usuario->materno.' '.$usuario->nombres;
								echo 
								"<tr>
									<td>$nro</td>
									<td>$usuario->usuario</td>
									<td>$nombres</td>
									<td>$usuario->ecorporativo</td>
									<td></td>
								</tr>";
							}
						}
         ?>      
      </tbody>
		</table>
	</div>
	

	<div id="divtabl-addamiembros" class="col-12 col-md-12 neo-table">
	<div class="col-md-12 header d-none d-md-block">
		<div class="row text-bold">
			
			<div class="col-12 col-md-2 group">
				<div class="col-6 col-md-3 cell">
					N°
				</div>
				<div class="col-12 col-md-9 cell">
					USER
				</div>
			</div>
			
			<div class="col-12 col-md-4 cell">
				APELLIDOS Y NOMBRES
			</div>
			<div class="col-2 col-md-3 cell text-center">
				CORREO CORPORATIVO
			</div>
			<div class="col-2 col-md-1 cell text-center">
				
			</div>
			<div class="col-2 col-md-1 cell text-center">
				
			</div>
		</div>
	</div>
	<div class="col-md-12 body">
		<?php
		$nro=0;
		foreach ($usuarios as $usuario) {
			if (($usuario->codnivel!=0) || ($_SESSION['userActivo']->codnivel==0)){
				$fn="";
				$nro++;
				$nombres=$usuario->paterno.' '.$usuario->materno.' '.$usuario->nombres;
		?>
		<div class="cfila row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
			<div class="col-12 col-md-2 group">
				<div class="col-6 col-md-3 cell">
					<span><?php echo $nro ;?></span>
				</div>
				<div class="col-12 col-md-9 cell">
					<span><?php echo $usuario->usuario ?></span>
				</div>
			</div>
			<!---->
			<div class="col-2 col-md-4 cell">
				<span><?php echo $nombres ?></span>
			</div>
			
			<div class="col-2 col-md-3 cell">
				<span><?php echo $usuario->ecorporativo ?></span>
			</div>
			<div class="col-12 col-md-2 group">
				<div class="col-12 col-md-3 cell text-center">
					<a class="py-1 px-2 mr-2 rounded bg-success " href="#" onclick="viewsedes('<?php echo base64url_encode($usuario->idusuario) ?>')" title="Sedes">
						<i class="far fa-building"></i> <span class="d-block d-md-none">Sedes </span>
					</a> 
				</div>
				<div class="col-6 col-md-3 cell text-center">
					<a class="py-1 px-2 mr-2 rounded bg-info " href="#" data-toggle="modal" data-target="#modalAcceso" 
					data-iduser="<?php echo base64url_encode($usuario->idusuario) ?>')" data-user="<?php echo $usuario->usuario ?>" data-ecorpo="<?php echo $usuario->ecorporativo ?>" title="Cambiar Acceso">
						<i class="fas fa-key"></i> <span class="d-block d-md-none">Cambiar</span>
					</a>
				</div>
				<div class="col-6 col-md-3 cell text-center">
					<a class="py-1 px-2 mr-2 rounded bg-warning" href="#" onclick="viewpermisos('<?php echo base64url_encode($usuario->idusuario) ?>')" title="Permisos">
						<i class="fas fa-shield-alt"></i> <span class="d-block d-md-none">Permisos </span>
					</a>
				</div>
				<div class="col-12 col-md-3 cell text-center">
					<?php 
					//'SI'
					$vicon="fa-user-check";
					$vtitle="Desactivar";
					$cambio='NO';
					$btncolor="btn-success";
					if ($usuario->activo=='NO'){ 
						$vicon="fa-user-times";
						$vtitle="Activar";
						$cambio='SI';
						$btncolor="btn-danger";
					}
					?>
					<a class="py-1 px-2 mr-2 rounded <?php echo $btncolor ?>  btn-desactivar" href="#" data-toggle="modal" data-target="#modalDesactivar" data-activo='<?php echo $cambio ?>' data-user='<?php echo $nombres ?>' data-id="<?php echo base64url_encode($usuario->idusuario) ?>" title="<?php echo $vtitle ?>">
						<i class="fas <?php echo $vicon ?>"></i> <span class="d-block d-md-none"> <?php echo $vtitle ?> </span>
					</a>
					
				</div>
			</div>
			<div class="col-4 col-md-1 cell text-center">
				<a class="btn-delete bg-danger py-1 px-2 mr-2 rounded" target="_blank" href="#" data-cu="<?php echo base64url_encode($usuario->idusuario) ?>" title="Eliminar Usuario">
					<i class="fas fa-user-times"></i> 
				</a>
			</div>
		</div>
		<?php } 
	} ?>
	</div>
</div>
<script>
$(".btn-desactivar").click(function(event) {
 	desactivar($(this));
});
	$(".btn-delete").click(function(event) {
		event.preventDefault();
        $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var cins=$(this).data("cu");
        var fila=$(this).parents(".cfila");
        
        //************************************
        Swal.fire({
          title: "Precaución",
          text: "Se eliminarán todos los datos con respecto a este INSCRIPCIÓN ",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
          	if (result.value) {
                  //var codc=$(this).data('im');
                $.ajax({
                  url: base_url + 'usuario/fn_eliminar',
                  type: 'post',
                  dataType: 'json',
                  data: {
                          'ce-iduser': cins
                      },
                  success: function(e) {
                      $('#divboxhistorial #divoverlay').remove();
                      if (e.status == false) {
                          Swal.fire({
                              type: 'error',
                              title: 'Error!',
                              text: e.msg,
                              backdrop: false,
                          })
                      } else {
                          /*$("#fm-txtidmatricula").html(e.newcod);*/
                          Swal.fire({
                              type: 'success',
                              title: 'Eliminación correcta',
                              text: 'Se ha eliminado el Usuario',
                              backdrop: false,
                          })
                          
                          fila.remove();
                      }
                  },
                  error: function(jqXHR, exception) {
                      var msgf = errorAjax(jqXHR, exception, 'text');
                      $('#divboxhistorial #divoverlay').remove();
                      Swal.fire({
                          type: 'error',
                          title: 'Error',
                          text: msgf,
                          backdrop: false,
                      })
                  }
          		});
          	}
          	else{
             	$('#divboxhistorial #divoverlay').remove();
          	}
        });
                //***************************************
	});
</script>
<?php  
}
else
{
		echo "<h4>Sin resultados</h4>";
} 
?>
