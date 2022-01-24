<?php 
$vbaseurl=base_url();
$raxexcel = "<i class='fas fa-download fa-lg'></i><img class='mr-1' src='".base_url()."resources/img/icons/p_excel.png' alt='EXCEL'>";
?>
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
                    
                    <a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>">Panel Unid. Did.
                    </a>
                </li>
                
              <li class="breadcrumb-item active">Documentos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <?php include 'vw_curso_encabezado.php'; 
        $iexcel="<i class='fas fa-download fa-lg'></i><img class='mr-1' src='".base_url()."resources/img/icons/p_excel.png' alt='EXCEL'>";
        $ipdf="<i class='fas fa-download fa-lg'></i><img class='mr-1' src='".base_url()."resources/img/icons/p_pdf.png' alt='PDF'>";
        ?>
        <div class="card">
            <div class="card-body">
                <div class="col-12 btable">
                    <div class="col-12 thead">
                        <div class="row ">
                            <div class="col-6 td">
                                DOCUMENTO
                            </div>
                            <div class="col-6 td text-center">
                                DESCARGA
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-12 tbody">
                        <div class="row">
                            <div class="col-6 td">
                                Acta de Evaluación Final
                            </div>
                            <div class="col-3 td text-center">
                                <?php if ($curso->culminado=='SI'){ ?>
                                <a class="btn btn-outline-success"  target="_blank" href="<?php echo $vbaseurl.'curso/documentos/acta-final-evaluacion-pdf/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $ipdf; ?></a>
                                <?php }
                                else{
                                    echo "Debes culminar la Unid. Did.";
                                }?>
                            </div>
                             <div class="col-3 td text-center">
                                <?php //if ($curso->culminado=='SI'){ ?>
                                <!--<a class="btn btn-outline-success"  target="_blank" href="<?php //echo $vbaseurl.'curso/documentos/acta-final-evaluacion-excel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php //echo $iexcel; ?></a>-->
                                <?php //}
                                //else{
                                    //echo "Debes culminar la Unid. Did.";
                                //} ?>
                            </div>
                        </div>
                        <?php if ((getDominio()=="iesap.edu.pe") || (getDominio()=="charlesashbee.edu.pe")){ ?>
                        <div class="row">
                            <div class="col-6 td">
                                Registro Final de Evaluaciones
                            </div>
                            <div class="col-3 td text-center">
                                <?php if ($curso->culminado=='SI'){ ?>
                                <a class="btn btn-outline-success" target="_blank" href="<?php echo $vbaseurl.'curso/registro-final-pdf/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $ipdf; ?></a>
                                <?php }
                                else{
                                    echo "Debes culminar la Unid. Did.";
                                }?>
                            </div>
                             <div class="col-3 td text-center">
                                
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-6 td">
                                Registro Final de Evaluaciones (CLÁSICO)
                            </div>
                            <div class="col-3 td text-center">
                                
                            </div>
                            <div class="col-3 td text-center">
                                <?php if ($curso->culminado=='SI'){ ?>
                                <a class="btn btn-outline-success" target="_blank" href="<?php echo $vbaseurl.'curso/registro-final-clasico-excel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $iexcel; ?></a>
                                <?php }
                                else{
                                    echo "Debes culminar la Unid. Did.";
                                }?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 td">
                                Registro Auxiliar
                            </div>
                            <div class="col-3 td text-center">
                                <a class="btn btn-outline-success" target="_blank" href="<?php echo $vbaseurl.'curso/documentos/registro-auxiliar-excel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $iexcel; ?></a>
                            </div>
                            <div class="col-3 td text-center">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
  
    