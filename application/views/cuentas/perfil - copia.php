<div class="content-wrapper">
  <?php $vbaseurl=base_url();
  
  $existe=comprobarFoto('resources/fotos/' . $perfil->foto);
  if ($existe==FALSE){
    $perfil->foto="gg/".$perfil->codpersona.".jpg";
    $existe=comprobarFoto('resources/fotos/' . $perfil->foto);
    if ($existe==FALSE)
    {
      $perfil->foto="user.png";
    }
  }
  ?>
  
  <section class="content-header">
              <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <?php  $nombres=explode(" ",$perfil->nombres); 

                
                $dia_actual = date("Y-m-d");
                $edad_diff = date_diff(date_create($perfil->fecnacimiento), date_create($dia_actual));
                ?>
              <div class="widget-user-header bg-info-active">
                <h3 class="widget-user-username"><?php echo $nombres[0]." ".$perfil->paterno ?></h3>
                <h5 class="widget-user-desc"><?php echo $perfil->nivel ?></h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-2" src="<?php echo $vbaseurl.'resources/fotos/'.$perfil->foto ?>" alt="<?php echo $nombres[0]." ".$perfil->paterno ?>">
              </div>

              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header"><span class="badge bg-primary"><?php echo $perfil->sexo ?></span></h5>
                      <span class="description-text">SEXO</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header"><span class="badge bg-danger"><?php echo $edad_diff->format('%y'); ?></span></h5>
                      <span class="description-text">EDAD</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header"><span class="badge bg-success"><?php echo $perfil->distrito ?></span></h5>
                      <span class="description-text">CIUDAD</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->
          </div>

  </section>
  
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          
          
          <div class="card">
            <div class="card-header p-2">
              <h3 class="card-title">Acerca de mí</h3>
            </div>
            
            <div class="card-body">
              <strong><i class="far fa-envelope mr-1"></i> Correo personal</strong>
              <p class="text-muted">
                <?php echo ($perfil->epersonal=="")? "No registrado": $perfil->epersonal ?>
              </p>
              <hr>
              <strong><i class="fas fa-mobile-alt mr-1"></i> Celular</strong>
              <p class="text-muted">
                <span class="tag tag-danger"> <?php echo ($perfil->celular=="")? "No registrado": $perfil->celular ?></span>
                
              </p>
              <hr>
              <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
              <p class="text-muted"><?php echo $perfil->domicilio ?><br><?php echo $perfil->distrito.', '.$perfil->provincia.', '.$perfil->departamento ?></p>
              <hr>
              
              <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
              <p class="text-muted">-------</p>
            </div>
            
          </div>
          
        </div>
        
        <div class="col-md-9">
          <div class="card">
            <div class="card-header px-1 px-sm-2">
              <ul class="nav nav-tabs">
                <li class="nav-item "><a class="nav-link active" href="#activity" data-toggle="tab">Acerca de mí</a></li>
                <li class="nav-item "><a class="nav-link" href="#timeline" data-toggle="tab">
                Seguridad</a></li>
                <li class="nav-item "><a class="nav-link" href="#settings" data-toggle="tab">
                Configuración</a></li>
              </ul>
            </div>
            <div class="card-body px-2 px-sm-3">
              <div class="tab-content"> 
                <div class="tab-pane active" id="activity">
                  <div class="col-md-12nn text-smn" id="div-inscripcion">
           
                  
                  <!-- fieldsets -->
                  
                  <form id="frmins-personales"action="#" method="post" accept-charset='utf-8' data-action='insert'>
                    <b class="text-danger"><i class="fas fa-user-circle"></i> DATOS PERSONALES</b>
                    <div class="row my-3">
                      <div class="col-12 col-sm-4">
                        <span class="form-control bg-lightgray"><?php echo "$perfil->tipodoc: $perfil->numero" ?></span>
                      </div>
                      <div class="col-12 col-sm-4">
                        <span class="form-control  bg-lightgray"><?php echo "$perfil->paterno $perfil->materno" ?></span>
                      </div>
                      <div class="col-12 col-sm-4">
                        <span class="form-control  bg-lightgray"><?php echo "$perfil->nombres" ?></span>
                      </div>
                      <br>
                    </div>
                    <div class="row">
                      
                      <div class="form-group has-float-label col-12 col-xs-4 col-sm-4">
                        <select class="form-control" id="ficbsexo" name="ficbsexo" placeholder="Sexo" >
                          <option value=""></option>
                          <option value="MASCULINO">MASCULINO</option>
                          <option value="FEMENINO">FEMENINO</option>
                        </select>
                        <label for="ficbsexo"> Sexo</label>
                      </div>
                       <div class="form-group has-float-label col-12 col-xs-4 col-sm-4">
                        <input data-currentvalue='' class="form-control text-uppercase" id="fitxtfechanac" name="fitxtfechanac" type="date" placeholder="Fec. Nacimiento"   />
                        <label for="fitxtfechanac">Fec. Nacimiento</label>
                      </div>
                    </div>
                    
                    
                    <input data-currentvalue='' id="fitxtcodinstitucional" name="fitxtcodinstitucional" type="hidden" required />
                    <input data-currentvalue='' id="fitxtcoddocente" name="fitxtcoddocente" type="hidden" />
                    
                    <b class="text-danger"><i class="fas fa-map-marker-alt"></i> CONTACTO</b>
                    <div class="row mt-3">
                      
                     
                      <div class="form-group has-float-label col-12 col-sm-4">
                        <input data-currentvalue='' class="form-control text-uppercase" id="fitxtcelular" name="fitxtcelular" type="text" placeholder="Celular" />
                        <label for="fitxtcelular1">Celular 1</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-4">
                        <input data-currentvalue='' class="form-control text-uppercase" id="fitxtcelular" name="fitxtcelular" type="text" placeholder="Celular" />
                        <label for="fitxtcelular2">Celular 2</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-4">
                        <input data-currentvalue='' class="form-control text-uppercase" id="fitxttelefono" name="fitxttelefono" type="text" placeholder="Teléfono" />
                        <label for="fitxttelefono">Teléfono</label>
                      </div>

                      <div class="form-group has-float-label col-12 col-sm-12">
                        <input data-currentvalue='' class="form-control" id="fitxtemailpersonal" name="fitxtemailpersonal" type="text" placeholder="Email Personal"  required />
                        <label for="fitxtemailpersonal">Email personal</label>
                      </div>
                      
                      
                    </div>
                    <b class="text-danger"><i class="fas fa-map-marker-alt"></i> UBICACIÓN</b>
                    <div class="row mt-3">
                      <div class="col-12">
                        <small id="emailHelp" class="form-text text-muted">Consignar la direción que parece en su DNI, CE o PSP</small>
                      </div>
                      <div class="form-group has-float-label col-12 col-xs-12 col-sm-12">
                        
                        <input data-currentvalue='' class="form-control text-uppercase" id="fitxtdomicilio" name="fitxtdomicilio" type="text" placeholder="Domicilio"  required />
                        <label for="fitxtdomicilio">Domicilio</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-xs-12 col-sm-12">
                        <input data-currentvalue='0' class="form-control text-uppercase" id="fitxtdomiciliootro" name="fitxtdomiciliootro" type="text" placeholder="Otro domicilio"  required />
                        <label for="fitxtdomiciliootro"> Otro domicilio</label>
                      </div>
                    </div>



                    <!--<div class="row">
                      <div class="form-group has-float-label col-12 col-xs-4 col-sm-3">
                        <select data-currentvalue='' class="form-control" id="ficbdepartamento" name="ficbdepartamento" placeholder="Departamento" required >
                          <option value="0">Selecciona Departamento</option>
                          <?php foreach ($departamentos as $key => $depa) {?>
                          <option value="<?php echo $depa->codigo ?>"><?php echo $depa->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="ficbdepartamento"> Departamento</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-xs-4 col-sm-4">
                        <select data-currentvalue='0' class="form-control" id="ficbprovincia" name="ficbprovincia" placeholder="Provincia" required >
                          <option value="0"></option>
                        </select>
                        <label for="ficbprovincia"> Provincia</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-xs-4 col-sm-5">
                        <select data-currentvalue='0'  class="form-control" id="ficbdistrito" name="ficbdistrito" placeholder="Distrito" required >
                          <option value="0"></option>
                        </select>
                        <label for="ficbdistrito"> Distrito</label>
                      </div>
                      
                    </div>-->

                    
                  </form>
                  <div class="row">
                    <div class="col-12"><span id="fispedit" class="text-danger"></span></div>
                    <div class="col-12">
                      
                      <button id="btn-sugerecia-open" class="btn btn-success btn-lg float-right" data-sugerencia='openfile'><i class="fas fa-user-plus"></i> Nuevo</button>
                      <button id="btn-sugerecia-cancel" class="btn btn-danger btn-lg " data-sugerencia='cancelfile'><i class="fas fa-undo"></i> Cancelar</button>
                      <button data-step='ins' type="button" class="btn btn-primary btn-lg float-right next"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                  </div>
                  
                  
               
              </div>
                </div>
                
                <div class="tab-pane" id="timeline">
                  
                  
                  <div class="card-cmabiaclave card card-default">
                    <div class="card-header p-2">
                      <h3 class="card-title">
                      <i class="far fa-envelope"></i>
                      Correo corporativo
                      </h3>
                    </div>
                    <div class="card-body px-2 px-sm-3">
                      <span class="text-muted">
                        Puedes usar este correo para iniciar sesión, <a target="_blank" href="https://youtu.be/9D9lTVEeoRg">consulte el siguiente video aquí</a>
                      </span>
                      <span class="form-control bg-lightgray"><?php echo $perfil->ecorporativo ?></span>
                      <small class="text-muted">
                      El correo corporativo es asignado de manera automática siguiendo los parámetros establecidos por la institución
                      </small>
                    </div>
                  </div>
                  <div class="card card-default">
                    <div class="card-header p-2">
                      <h3 class="card-title">
                      <i class="fas fa-key"></i>
                      Cambiar contraseña
                      </h3>
                    </div>
                    <div class="card-body px-2 px-sm-3">
                      <span class="text-muted">
                        Usuario
                      </span>
                      <span class="form-control bg-lightgray"><?php echo $_SESSION['userActivo']->usuario ?></span>
                      <small class="text-muted">
                      El usuario no puede ser cambiado
                      </small>
                      <br> <hr>
                      <form id="frmcambiaclave" name="frmcambiaclave" action="<?php echo $vbaseurl ?>usuario/fn_cambiar_clave" method="post" accept-charset='utf-8'>
                        <div class="row">
                          <div class="col-12 mb-2">
                            <small class="text-muted">
                            
                            Se recomienda usar una contraseña segura que no uses en ningún otro sitio.
                            </small>
                          </div>
                          <div class="col-12 mb-2">
                            <span class="text-muted">
                              Contraseña actual
                            </span>
                            <input class="form-control" autocomplete="new-password" type="password" required id="fcctxtclave" minlength="5" maxlength="20" name="fcctxtclave">
                          </div>
                          <div class="col-12 mb-2">
                            <span class="text-muted">
                              Contraseña nueva
                            </span>
                            <input class="form-control" autocomplete="new-password" type="password" required id="fcctxtclavenueva" minlength="5" maxlength="20" name="fcctxtclavenueva">
                          </div>
                          <div class="col-12 mb-2">
                            <span class="text-muted">
                              Repite contraseña nueva
                            </span>
                            <input class="form-control" autocomplete="new-password" type="password" required id="fcctxtrpclavenueva" minlength="5" maxlength="20" name="fcctxtrpclavenueva">
                          </div>
                          
                          <div class="col-12">
                            <small class="text-muted">
                            Esta contraseña no reemplaza a la contraseña del correo corporativo  
                            </small>
                            <button class="btn btn-primary float-right" type="submit">Guardar</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                
                <div class="tab-pane" id="settings">
                  
                </div>
                
              </div>
              
            </div>
          </div>
          
        </div>
        
      </div>
      
    </div>
  </section>
  
</div>
  <script>
    $("#frmcambiaclave").submit(function(event) {
      $('#card-cmabiaclave').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $('#frmcambiaclave input,select').removeClass('is-invalid');
      $('#frmcambiaclave .invalid-feedback').remove();
      $.ajax({
          url: base_url + 'usuario/fn_cambiar_clave',
          type: 'post',
          dataType: 'json',
          data: $(this).serialize(),
          success: function(e) {
              $('#card-cmabiaclave #divoverlay').remove();
              if (e.status==true){
                Swal.fire({
                    type: 'success',
                    title: 'Felicitaciones, se guardó los cambios',
                    text: "se cambió correctamente su contraseña",
                    backdrop: false,
                });
              }
              else{
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire({
                    type: 'error',
                    title: 'ERROR, no se guardó los cambios',
                    text: e.msg,
                    backdrop: false,
                });
              }
              $("#frmcambiaclave")[0].reset();
          },
          error: function(jqXHR, exception) {
              $('#card-cmabiaclave #divoverlay').remove();
              var msgf = errorAjax(jqXHR, exception, 'text');
              Swal.fire({
                  type: 'error',
                  title: 'ERROR, NO se guardó cambios',
                  text: msgf,
                  backdrop: false,
              });
          },
      });

      return  false;
    });
  </script>