<?php $vbaseurl=base_url() ?>
 
                    <b class="pt-2 pb-4 text-danger d-block"><i class="fas fa-user-circle"></i> PROCESO DE ADMISIÓN</b>
                    <input data-currentvalue='' id="fimcid" name="fimcid" type="hidden" />
                    <input data-currentvalue='' id="fitxtdni" name="fitxtdni" type="hidden" />
                    <input data-currentvalue='' id="ficbcarsigla" name="ficbcarsigla" type="hidden" value="<?php echo $pre->sigla ?>" />
                    
                    <div class="row margin-top-20px">
                      <div class="form-group has-float-label col-12 col-sm-5">
                        <select data-currentvalue='' class="form-control" id="ficbmodalidad" name="ficbmodalidad" placeholder="Modalidad" required >
                          <option value="0">Selecciona modalidad</option>
                          <?php foreach ($modalidades as $modalidad) {
                            $modsel=($pre->codmodalidad==$modalidad->id)?"selected":"";
                            echo "<option $modsel value='$modalidad->id'>$modalidad->nombre </option>";
                          } ?>
                        </select>
                        <label for="ficbmodalidad"> Modalidad</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-3">
                        <select data-currentvalue='' class="form-control" id="ficbperiodo" name="ficbperiodo" placeholder="Periodo lectivo" required >
                          <option value="0">Selecciona periodo</option>
                          <?php foreach ($periodos as $periodo) { 
                            $persel=($pre->codperiodo==$periodo->codigo)?"selected":"";
                            echo "<option $persel value='$periodo->codigo'>$periodo->nombre </option>";
                          } ?>
                        </select>
                        <label for="ficbperiodo"> Periodo lectivo</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-4">
                        <select data-currentvalue='' class="form-control" id="ficbcampania" name="ficbcampania" placeholder="Campaña" required >
                          <option value="0">Selecciona</option>
                          <?php foreach ($campanias as $campania) {?>
                          <option value="<?php echo $campania->id ?>"><?php echo $campania->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="ficbcampania"> Campaña</label>
                      </div>
                    </div>
                    <b class="pt-2 pb-4 text-danger d-block"><i class="fas fa-user-circle"></i> DATOS ACADÉMICOS</b>
                    <div class="row margin-top-20px">
                      <div class="form-group has-float-label col-12 col-sm-5">
                        <select data-currentvalue='' class="form-control" id="ficbcarrera" name="ficbcarrera" placeholder="Programa de estudios" required >
                          <option value="0">Selecciona</option>
                          <?php foreach ($carreras as $carrera) { 
                            $carsel=($pre->codcarrera==$carrera->codcarrera)?"selected":"";
                            echo "<option data-sigla='$carrera->sigla' data-nombre='$carrera->nombre' $carsel value='$carrera->codcarrera'>$carrera->nombre </option>";
                           } ?>
                        </select>
                        <label for="ficbcarrera"> Programa de estudios</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-2">
                        <select data-currentvalue='' class="form-control" id="ficbciclo" name="ficbciclo" placeholder="Semestre Acad." required >
                          <option value="0">Selecciona</option>
                          <?php foreach ($ciclos as $ciclo) {
                            $cicsel=($pre->codciclo==$ciclo->codigo)?"selected":"";
                            echo "<option  $cicsel value='$ciclo->codigo'>$ciclo->nombre </option>";
                           } ?>
                        </select>
                        <label for="ficbciclo"> Semestre Acad.</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-3">
                        <select data-currentvalue='' class="form-control" id="ficbturno" name="ficbturno" placeholder="Turno" required >
                          <option value="0">Selecciona</option>
                          <?php foreach ($turnos as $turno) {
                            $tursel=($pre->codturno==$turno->codigo)?"selected":"";
                            echo "<option  $tursel value='$turno->codigo'>$turno->nombre </option>";
                           } ?>
                        </select>
                        <label for="ficbturno"> Turno</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-2">
                        <select data-currentvalue='' class="form-control" id="ficbseccion" name="ficbseccion" placeholder="Sección" required >
                          <option value="0">Selecciona</option>
                          <?php foreach ($secciones as $seccion) {?>
                          <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="ficbseccion"> Sección</label>
                      </div>
                      <div class="form-group col-12 col-sm-4">
                        <label for="ficestdiscap"> ¿Tiene: alguna discapacidad?</label>
                        <span class="form-control form-control-sm" id="ficestdiscap"><?php echo $estdiscapacidad ?></span>
                        <input type="hidden" name="ficestadodiscap" value="<?php echo $estdiscapacidad ?>">
                      </div>
                      
                      <?php if ($estdiscapacidad == 'SI'): ?>
                      <div class="form-group col-12 col-sm-8">
                        <label for="ficdiscap"> Discapacidad</label>
                        <span class="form-control form-control-sm" id="ficdiscap"><?php echo $discapacidad ?></span>
                      </div>
                    
                      <div class="form-group has-float-label col-9 col-sm-9">
                        <select data-currentvalue='' class="form-control form-control-sm" id="ficbdiscapacidad" name="ficbdiscapacidad" placeholder="Sección" required >
                          <option value="0">Selecciona</option>
                          <?php foreach ($discapacidades as $disc) {
                            $grupod = "";
                            if ($disc->detalle != "" || $disc->detalle != null) {
                              $grupod = $disc->grupo." - ".$disc->detalle;
                            } else {
                              $grupod = $disc->grupo;
                            }
                          ?>
                          <option value="<?php echo $disc->codigo ?>"><?php echo $grupod ?></option>
                          <?php } ?>
                        </select>
                        <label for="ficbdiscapacidad"> Discapacidad</label>
                      </div>
                      <div class="form-check col-3 col-sm-3 pt-2" style="display: none;">
                        <input class="form-check-input checkdiscap" id="radiod1" data-discap="" data-principal="SI" checked="" name="radio1" type="radio">
                      </div>
                      <div class="form-group has-float-label col-8 col-sm-8" style="display: none;">
                        <select data-currentvalue='' class="form-control" id="ficbdiscapacidad2" name="ficbdiscapacidad2" placeholder="Sección" >
                          <option value="0">Selecciona</option>
                          <?php foreach ($discapacidades as $disc) {
                            $grupod = "";
                            if ($disc->detalle != "" || $disc->detalle != null) {
                              $grupod = $disc->grupo." - ".$disc->detalle;
                            } else {
                              $grupod = $disc->grupo;
                            }
                          ?>
                          <option value="<?php echo $disc->codigo ?>"><?php echo $grupod ?></option>
                          <?php } ?>
                        </select>
                        <label for="ficbdiscapacidad2"> Discapacidad</label>
                      </div>
                      <div class="form-check col-4 col-sm-4 pt-2" style="display: none;">
                        <input class="form-check-input checkdiscap" data-discap="" data-principal="NO" name="radio1" type="radio">
                      </div>
                      <div class="form-group has-float-label col-8 col-sm-8" style="display: none;">
                        <select data-currentvalue='' class="form-control" id="ficbdiscapacidad3" name="ficbdiscapacidad3" placeholder="Sección" >
                          <option value="0">Selecciona</option>
                          <?php foreach ($discapacidades as $disc) {
                            $grupod = "";
                            if ($disc->detalle != "" || $disc->detalle != null) {
                              $grupod = $disc->grupo." - ".$disc->detalle;
                            } else {
                              $grupod = $disc->grupo;
                            }
                          ?>
                          <option value="<?php echo $disc->codigo ?>"><?php echo $grupod ?></option>
                          <?php } ?>
                        </select>
                        <label for="ficbdiscapacidad3"> Discapacidad</label>
                      </div>
                      <div class="form-check col-4 col-sm-4 pt-2" style="display: none;">
                        <input class="form-check-input checkdiscap" data-discap="" data-principal="NO" name="radio1" type="radio">
                      </div>
                      <?php endif ?>
                      <?php if ($lengua != "" || $lengua != null): ?>
                      <div class="form-group col-12 col-sm-4">
                        <label for="ficlengua"> Lengua Originaria</label>
                        <span class="form-control form-control-sm" id="ficlengua"><?php echo $lengua ?></span>
                      </div>
                      <?php endif ?>
                      <div class="form-group col-8 col-sm-4">
                        <label for="ficblenguas"> Lengua</label>
                        <select data-currentvalue='' class="form-control form-control-sm" id="ficblenguas" name="ficblenguas" required="">
                          <option value="0">Selecciona</option>
                          <?php foreach ($dlenguas as $lg) {
                          ?>
                          <option value="<?php echo $lg->codigo ?>"><?php echo $lg->nombre ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group col-8 col-sm-4">
                        <label for="ficbotrlenguas"> Otras Lenguas</label>
                        <input type="text" name="ficbotrlenguas" id="ficbotrlenguas" placeholder="Otras lenguas" class="form-control form-control-sm">
                      </div>
                      
                    </div>
                    <div class="row">
                      <div class="form-group col-12 col-sm-12">
                        <button type="button" class="btn btn-outline-secondary btn-block text-left" id="btn_docanex" data-toggle="modal" data-target="#modanexadocs">Documentos anexados</button>
                        <!-- <label for="ficbsdocanexados">Documentos anexados</label>
                        <select id="ficbsdocanexados" title='Selecciona documentos anexados' data-actions-box="true" multiple class="selectpicker form-control" multiple data-live-search="true">
                          <?php foreach ($docs_anexar as $doc_anexar) {?>
                          <option value="<?php echo $doc_anexar->coddocumento ?>" title="<?php echo $doc_anexar->abrevia ?>"><?php echo $doc_anexar->nombre ?></option>
                          <?php } ?>
                        </select> -->
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-12">
                        <textarea class="form-control" id="fitxtobservaciones" name="fitxtobservaciones" placeholder="Observaciones"  rows="3"></textarea>
                        <label for="fitxtobservaciones"> Observaciones</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-3">
                        <input data-currentvalue='' class="form-control text-uppercase" value="<?php echo date("Y-m-d"); ?>" id="fitxtfecinscripcion" name="fitxtfecinscripcion" type="date" placeholder="Fec. Inscripción"   />
                        <label for="fitxtfecinscripcion">Fec. Inscripción</label>
                      </div>
                    </div>

                  <script>
                    $(document).ready(function() {
                      $('.selectpicker').selectpicker({
                          iconBase: 'fa',
                          tickIcon: 'fa-check',
                      });

                      $("#frmins-inscripcion #ficbperiodo").change(function(event) {
                        var cbcmp = $('#frmins-inscripcion #ficbcampania');
                        $('#frmins-inscripcion #fiins-spcampania').html("");
                        cbcmp.html("<option value='0'>Sin opciones</option>");
                        var codperiodo = $(this).val();
                        if (codperiodo == '0') return;
                        $.ajax({
                            url: base_url + 'campania/fn_campania_por_periodo',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                txtcodperiodo: codperiodo
                            },
                            success: function(e) {
                                cbcmp.html(e.vdata);
                            },
                            error: function(jqXHR, exception) {
                                var msgf = errorAjax(jqXHR, exception, 'text');
                                cbcmp.html("<option value='0'>" + msgf + "</option>");
                            }
                        });
                      });

                      $("#frmins-inscripcion #ficbcarrera").change(function(event) {
                          var cbcmp = $('#frmins-inscripcion #ficbcarsigla');
                          cbcmp.html("");
                          if ($(this).val !== "0") cbcmp.val($('option:selected', this).data('sigla'))
                      });
                    });

                    $('#ficbdiscapacidad').change(function() {
                      var valor = $(this).val();
                      $('#radiod1').data('discap',valor);
                    });
                  </script>