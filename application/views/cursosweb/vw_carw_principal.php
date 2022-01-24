
<?php
	$vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">

	<section id="s-cargado" class="content pt-2">
		<div id="divcard_curso" class="card text-dark">
			<div class="card-header">
                <h1 class="card-title">Formación Continua</h1>
                <!-- <div class="no-padding card-tools">
                    <a type="button" class="btn btn-sm btn-outline-dark" href=""><i class="fa fa-plus"></i> Agregar</a>
                </div> -->
                <div class="card-tools">
                    <div class="btn-group dropleft">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opciones
                        </button> 
                        <div class="dropdown-menu" x-placement="left-start">
                            <a class="dropdown-item" href="<?php echo "{$vbaseurl}formacion-continua/cursos/agregar" ?>"><i class="fa fa-plus"></i> Agregar curso</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo "{$vbaseurl}formacion-continua/cursos/inscripciones" ?>"><i class="fa fa-file"></i> Inscripciones</a>
                        </div>
                    </div>
                </div>
            </div>
		    <div class="card-body p-2">
                <small id="fmt_conteo" class="form-text text-primary">
            
                </small>
                <div class="col-12 py-1">
                    <div class="btable">
                        <div class="thead col-12  d-none d-md-block">
                            <div class="row">
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-2 col-md-2 td'>N°</div>
                                        <div class='col-10 col-md-10 td'>NOMBRE</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-3 col-md-3 td'>ESTADO</div>
                                        <div class='col-9 col-md-9 td'>DURACIÓN</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-2 text-center'>
                                    <div class='row'>
                                        <div class='col-12 col-md-12 td'>
                                            <span>ACCIONES</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="tbody col-12" id="divcard_data_curso">
                            <?php
                                $nro = 0;
                                foreach ($cursos as $cur) {
                                    $nro ++;
                                    $codigo64 = base64url_encode($cur->codcurso);
                                    $codsede = base64url_encode($cur->codsede);
                                    if ($cur->activo == 'SI') {
                                        $abierta = "<span class='badge bg-success p-s2'> ABIERTO </span>";
                                    } else {
                                        $abierta = "<span class='badge bg-danger p-s2'> CERRADO </span>";
                                    }
                            ?>
                            <div class="row rowcolor cfila" data-curso='<?php echo $cur->titulo ?>'>
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-2 col-md-2 td'><?php echo $nro ?></div>
                                        <div class='col-10 col-md-10 td'><?php echo $cur->titulo ?></div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-3 col-md-3 td'><?php echo $abierta ?></div>
                                        <div class='col-9 col-md-9 td'><?php echo $cur->duracion ?></div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-2 text-center'>
                                    <div class='row'>
                                        <div class='col-12 col-sm-12 col-md-12 td'>
                                            <div class='col-12 pt-1 pr-3 text-center'>
                                                <div class='btn-group'>
                                                    <a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                        <i class='fas fa-cog'></i>
                                                    </a>
                                                    <div class='dropdown-menu dropdown-menu-right acc_dropdown'>
                                                        <a class='dropdown-item' href='<?php echo "{$vbaseurl}formacion-continua/cursos/editar/$codigo64" ?>' title='Editar'>
                                                            <i class='fas fa-edit mr-1'></i> Editar
                                                        </a>
                                                        <a class='dropdown-item text-danger deletecurso' href='#' title='Eliminar' idcurso='<?php echo $codigo64 ?>' data-galeria='<?php echo $cur->galeria ?>'>
                                                            <i class='fas fa-trash mr-1'></i> Eliminar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>              
            </div>
        </div>
    </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>

<script type="text/javascript">
    $('.deletecurso').click(function() {
        var idcurso = $(this).attr("idcurso");
        var galeria = $(this).data("galeria");
        var fila = $(this).closest('.rowcolor');
        var curso = fila.data('curso');
        
        Swal.fire({
            title: '¿Está seguro de eliminar el curso '+curso+'?',
            text: "¡Si no lo está puede cancelar la acción!",
            type: 'warning',
            icon: 'warning',
            showCancelButton: true,
            allowOutsideClick: false,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar!'
        }).then(function(result){
            if(result.value){
                $('#divcard_curso').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                var datos = new FormData();
                datos.append("idcurso", idcurso);
                datos.append("galeria", JSON.stringify(galeria));
                
                $.ajax({
                    url: base_url + "curso_web/fneliminar_curso",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(e){
                        $('#divcard_curso #divoverlay').remove();
                        if (e.status == true) {
                            Swal.fire({
                                type: "success",
                                icon: 'success',
                                title: "¡CORRECTO!",
                                text: e.msg,
                                showConfirmButton: true,
                                allowOutsideClick: false,
                                confirmButtonText: "Cerrar"
                            }).then(function(result){
                                if(result.value){
                                   fila.remove();
                                }
                            })
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msgf = errorAjax(jqXHR, exception,'text');
                        $('#divcard_curso #divoverlay').remove();
                        Swal.fire({
                            title: "Error",
                            text: e.msgf,
                            type: "error",
                            icon: "error",
                            allowOutsideClick: false,
                            confirmButtonText: "¡Cerrar!"
                        });
                    }
                })
            }
        });         
            
        return false;
    });
   

</script>