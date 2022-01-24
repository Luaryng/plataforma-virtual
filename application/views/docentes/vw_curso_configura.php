<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">
<div class="content-wrapper">
    <div id="modalPregunta" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Confirmación requerida</h4>
                </div>
                <div id="divCulminar">
                    <div id="divmsgpregunta" class="modal-body">
                        <h4><?php echo $curso->unidad ?></h4>
                        <h3>¿Deseas Culminar el curso Seleccionado?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn pull-left btn-danger" data-dismiss="modal">NO</button>
                        <a id="btnculminar" data-flat="culminarcurso"  data-idcarga="<?php echo base64url_encode($curso->codcarga) ?>" data-division="<?php echo base64url_encode($curso->division) ?>" type="button" class="btn btn-flat btn-primary">Culminar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $curso->unidad ?>
            <small> <?php echo $curso->codseccion.$curso->division; ?></small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="<?php echo $vbaseurl ?>docente/mis-cursos"><i class="fas fa-compass"></i> Mis Unidades didácticas</a>
                </li>
                <li class="breadcrumb-item">
                    
                    <a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $curso->unidad ?>
                    </a>
                </li>
                
              <li class="breadcrumb-item active">Configuración</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <?php include 'vw_curso_encabezado.php'; ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Días de clase </h3>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="form-group">
                                <input type="number" class="form-control" id="nrosesiones" value="<?php echo $curso->sesiones ?>">
                                <span class="form-text ">Ingrese el total de días de clase durante el semestre</span>
                            </div>
                            <div class="form-group text-right">
                                <button id="btnguardarsesiones" data-idcarga="<?php echo base64url_encode($curso->codcarga) ?>" data-division="<?php echo base64url_encode($curso->division) ?>" class=" btn btn-primary"><i class='fa fa-save'> </i> Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
             
            <!--<div class="col-sm-4">
                <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Nro de Indicadores</h3>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="form-group">
                                <input type="number" class="form-control" id="nrosesiones" value="<?php echo $curso->sesiones ?>">
                                <span class="form-text ">Ingrese el Nro de Indicadores programados en su SÍLABO</span>
                            </div>
                            <div class="form-group text-right">
                                <button id="btnguardarsesiones" data-idcarga="<?php echo base64url_encode($curso->codcarga) ?>" class="btn btn-primary"><i class='fa fa-save'> </i> Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>-->
            <div class="col-sm-6">
                <div class="card card-danger">
                    <div class="card-header">
                      <h3 class="card-title">Culminar Unid. didác.</h3>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="form-group">
                                
                                <span class="form-text  text-justify">
                                    Verifique que SESIONES,EVALUACIONES Y ASISTENCIAS estén COMPLETAS. <br> 
                                    <span class="text-danger text-bold">Una vez culminado,no se podrá realizar modificaciones </span>
                                </span>
                            </div>
                            <div class="form-group text-right">
                                <span data-toggle='tooltip' title='Finaliza Unid. didác.'>
                                    <a data-toggle='modal' data-target='#modalPregunta' class='btn btn-danger' href='#'>
                                        <i class='fa fa-toggle-on'> </i> Culminar
                                    </a>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>    
    $("#btnguardarsesiones").click(function(event) {
    //$('#modalPregunta').modal('hide');
    var idcurso=$(this).data('idcarga');
    var vdivision=$(this).data('division');
    var nrses=$("#nrosesiones").val();
    $('#divboxevaluaciones').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var acto=  base_url + 'curso/f_updatenrosesiones';
    $.ajax({
        url: acto,
        type: 'post',
        dataType: 'json',
        data: {
            idcarga: idcurso,nrosesiones: nrses, division:vdivision
        },
        success: function(e) {
            $('#divboxevaluaciones #divoverlay').remove();
            if (e.status == false) {
                
                 Swal.fire({
                    type: 'error',
                    title: 'ERROR, NO se pudo guardar los cambios',
                    text: e.msg,
                    backdrop:false,
                });
            } else {
                 Swal.fire({
                    type: 'success',
                    title: 'ÉXITO, Se guardó cambios',
                    text: "Lo cambios fueron guardados correctamente",
                    backdrop:false,
                });
                setTimeout(function(){ window.location.href = e.redirect; }, 2000);

            }
        },
        error: function(jqXHR, exception) {
            $('#divboxevaluaciones #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception,'text');
            Swal.fire({
                    type: 'error',
                    title: 'ERROR, NO se pudo guardar los cambios',
                    text: msgf,
                    backdrop:false,
            });
        },
    });
    return false;
});

    var btntoggle;


$("#btnculminar").click(function(event) {
    $('#modalPregunta').modal('hide');
    var idcurso=$(this).data('idcarga');
    var vdivision=$(this).data('division');
    $('#divboxevaluaciones').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var acto=  base_url + 'curso/fn_curso_culminar';
    $.ajax({
        url: acto,
        type: 'post',
        dataType: 'json',
        data: {
            idcarga: idcurso, division:vdivision
        },
        success: function(e) {
            $('#divboxevaluaciones #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    type: 'error',
                    title: 'ERROR, NO se pudo culminar',
                    text: e.msg,
                    backdrop:false,
                });
            } else {
                Swal.fire({
                    type: 'success',
                    title: 'ÉXITO, Se guardó cambios',
                    text: "Lo cambios fueron guardados correctamente",
                    backdrop:false,
                });
                setTimeout(function(){ window.location.href = e.redirect; }, 2000);
            }
        },
        error: function(jqXHR, exception) {
            $('#divboxevaluaciones #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception,'text');
            Swal.fire({
                    type: 'error',
                    title: 'ERROR, NO se pudo guardar los cambios',
                    text: msgf,
                    backdrop:false,
            });
        },
    });
    return false;
});

</script>