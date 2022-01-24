<?php $vbaseurl=base_url() ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>ENCUESTAS GENERALES
                    </h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div id="divcard-general" class="card">
            <div class="card-body">
                
                    <h5 class="text-primary">Desempeño Docente</h5>
                    <div class="btable">
                        <div class="thead col-12  d-none d-md-block">
                            <div class="row">
                                <div class='col-12 col-md-2'>
                                    <div class='row'>
                                      <div class='col-2 col-md-2 td'>N°</div>
                                      <div class='col-6 col-md-10 td'>ENCUESTA</div>
                                    </div>
                                  </div>
                                  <div class='col-12 col-md-3 td'>
                                    DOCENTE / UNIDAD
                                  </div>
                                  <div class='col-12 col-md-4'>
                                    <div class='row'>
                                      <div class='col-4 col-md-4 td'>INICIA</div>
                                      <div class='col-4 col-md-4 td'>CULMINA</div>
                                      <div class='col-4 col-md-4 td'>ENTREGADO</div>
                                    </div>
                                  </div>
                                  <div class='col-12 col-md-3 td text-center'>
                                    
                                        ACCIÓN
                                      
                                </div>
                            </div>
                        </div>
                        <div id="div-misencuestas" class="tbody col-12">
  
                            <?php 
                            $nro=0;
                            $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
                            date_default_timezone_set('America/Lima');
                            foreach ($encuestas as $key => $v) {  
                            $nro++;       
                            
                            if ($v->completado=='SI'){
                                $est="Revisar";
                                $estc="text-success";
                                $date = new DateTime($v->entregado);
                                $entrega= $dias[$date->format('w')].". ".$date->format('d/m/Y h:i a');
                            }
                            else{
                                $est="Completar";
                                $estc="text-primary";
                                $entrega="<span class='tboton bg-danger'>Pendiente</span>";
                            }
                            $dateini = ($v->inicia=="")? new DateTime($v->creado): new DateTime($v->inicia) ;
                            $vinicia= $dias[$dateini->format('w')].". ".$dateini->format('d/m/Y h:i a');

                            $vvence="Indefinido";
                            if ($v->vence!=""){
                              $datefin = new DateTime($v->vence);
                              $vvence= $dias[$datefin->format('w')].". ".$datefin->format('d/m/Y h:i a');
                            }
                            
                            echo
                            "<div class='cfila row'>
                                  <div class='col-12 col-md-2'>
                                    <div class='row'>
                                      <div class='col-3 col-md-2 td'>$nro</div>
                                      <div class='col-9 col-md-10 td'>$v->nombre</div>
                                    </div>
                                  </div>
                                  <div class='col-12 col-md-3 td'>
                                    <span class='d-block d-md-none text-bold'>DOCENTE / CURSO:</span>
                                    $v->paterno $v->materno $v->nombres</br>
                                    <b>$v->curso</b>
                                  </div>
                                  <div class='col-12 col-md-4'>
                                    <div class='row'>
                                      <div class='col-4 col-md-4 td'>
                                        <span class='d-block d-md-none text-bold'>INICIA:</span>
                                        $vinicia
                                      </div>
                                      <div class='col-4 col-md-4 td'>
                                        <span class='d-block d-md-none text-bold'>CULMINA:</span>
                                        $vvence
                                      </div>
                                      <div class='col-4 col-md-4 td'>
                                        <span class='d-block d-md-none text-bold'>ENTREGA:</span>
                                        $entrega
                                      </div>
                                    </div>
                                  </div>
                                  <div class='col-12 col-md-3 td text-center'>
                                    <a href='$vbaseurl".'alumno/encuesta/'.base64url_encode($v->codencuestallenar)."' class='$estc'>
                                        <u>$est</u>
                                    </a>
                                </div>
                            </div>";
                            }?>
                        </div>
                    </div>
                
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
<!--<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>-->
<!--<script src="<?php echo base_url();?>resources/jquery/pages.js"></script>-->
