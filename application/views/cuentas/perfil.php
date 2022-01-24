<style>
#previews {
    
    min-height: 250px;
    padding-top: 25px;
    padding-bottom: 15px;
    font-size: 18px;

    border: dashed 3px green;
    cursor: pointer ;
    background-repeat: no-repeat;
    background-position: center center;
}
 
 
#previews .delete {
    display: none;
}
 
#previews .dz-success .start,
#previews .dz-success .cancel {
    display: none;
}
 
#previews .dz-success .delete {
    display: block;
}
#template{
    border:solid red 1px; 
}
#previews .name {
    font-size: 12px
    border: solid 1px red;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    background-color: white;

}
#previews .name:hover {
    font-size: 12px
    border: solid 1px red;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: visible;
    border: solid 1px gray;
    z-index: 100;
    position: absolute;
}
 
/*.dz-image-preview {
    min-height: 160px;
}*/
 
.preview {
    background: #fff;
    

}
 
.preview img {
    cursor: pointer;
}
 

  textarea{ overflow:hidden; }
</style>

<div class="content-wrapper">
  <?php $vbaseurl=base_url();
$nombres=explode(" ",$perfil->nombres); 
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
  

  
  <section class="content">
    <div class="container-fluid pt-3">
      <div id="vwperfil_div_todo" class="card bg-lightgray">

        <div class="row">
          <div class="col-md-3">

            <div class="card card-primary card-outline">
              <div class="card-body box-profile pb-0">
                 <a class="position-absolute float-right rounded-circle bg-lightgray p-2 m-2" id="vwperfil_btn_cambiarfoto" href="#"><i class="fas fa-camera fa-lg"></i></a> 
                  <div class="text-center">
                    <img id="vwperfil_img_user" class="img-fluid img-circle border border-primary p-1" 
                         src="<?php echo $vbaseurl.'resources/fotos/'.$perfil->foto ?>" alt="<?php echo $nombres[0]." ".$perfil->paterno ?>">
                  </div>
          
                <h3 class="profile-username text-center"><?php echo $nombres[0] ?></h3>
                <p class="text-muted text-center"><?php echo $perfil->nivel ?></p>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Sexo <span class="float-right badge bg-primary"><?php echo $perfil->sexo ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Fecha Nac. <span class="float-right badge bg-info"><?php echo $perfil->fecnacimiento ?></span>
                    </a>
                  </li>
                  <?php
                  
                  $dia_actual = date("Y-m-d");
                  $edad_diff = date_diff(date_create($perfil->fecnacimiento), date_create($dia_actual));
                  ?>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Edad <span class="float-right badge bg-danger"><?php echo $edad_diff->format('%y'); ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Ciudad <span class="float-right badge bg-success"><?php echo $perfil->distrito ?></span>
                    </a>
                  </li>
                  
                </ul>
              </div>
            </div>
            
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
                
                
              </div>
              
            </div>
            
          </div>
          
          <div class="col-md-9">
            <div id="card-fichas" class="card">
              <div class="card-header px-1 px-sm-2">
                <ul class="nav nav-tabs">
                  <li class="nav-item "><a class="nav-link active" href="#activity" data-toggle="tab">Acerca de mí</a></li>
                  <li class="nav-item "><a class="nav-link" href="#timeline" data-toggle="tab">
                  Seguridad</a></li>
                  <li class="nav-item "><a class="nav-link" href="#settings" data-toggle="tab">
                  Mi foto</a></li>
                </ul>
              </div>
              <div class="card-body px-2 px-sm-3">
                <div class="tab-content"> 
                  <div class="tab-pane active" id="activity">
                    <div class="col-md-12nn text-smn" id="div-inscripcion">
             
                    
                    <!-- fieldsets -->
                    
                    <form id="vwperfil_frm_perfil"action="#" method="post" accept-charset='utf-8' data-action='insert'>
                      <b class="text-danger"><i class="fas fa-user-circle"></i> DATOS PERSONALES</b>
                      <div class="row my-3">
                        <div class="form-group col-12 col-sm-4">
                          <span class="form-control form-control-sm bg-lightgray"><?php echo "$perfil->tipodoc: $perfil->numero" ?></span>
                        </div>
                        <div class="form-group col-12 col-sm-4">
                          <span class="form-control form-control-sm  bg-lightgray"><?php echo "$perfil->paterno $perfil->materno" ?></span>
                        </div>
                        <div class="form-group col-12 col-sm-4">
                          <span class="form-control form-control-sm  bg-lightgray"><?php echo "$perfil->nombres" ?></span>
                        </div>
                        <br>
                     
                        
                        <div class="form-group has-float-label col-12 col-xs-4 col-sm-4">
                          <select disabled data-currentvalue='<?php echo $perfil->sexo ?>' class="form-control form-control-sm" id="ficbsexo" name="ficbsexo" placeholder="Sexo" >
                            <option value=""></option>
                            <option <?php echo ($perfil->sexo=="MASCULINO") ? "selected":""; ?> value="MASCULINO">MASCULINO</option>
                            <option <?php echo ($perfil->sexo=="FEMENINO") ? "selected":""; ?> value="FEMENINO">FEMENINO</option>
                          </select>
                          <label for="ficbsexo"> Sexo</label>
                        </div>
                         <div class="form-group has-float-label col-12 col-xs-4 col-sm-4">
                          <input disabled data-currentvalue='<?php echo $perfil->fecnacimiento ?>' class="form-control form-control-sm" id="fitxtfechanac" name="fitxtfechanac" type="date" placeholder="Fec. Nacimiento"   value="<?php echo $perfil->fecnacimiento ?>"/>
                          <label for="fitxtfechanac">Fec. Nacimiento</label>
                        </div>
                      </div>
                      
                      
                      <input data-currentvalue='<?php echo base64url_encode($perfil->codpersona) ?>' id="fitxtpersona" name="fitxtpersona" type="hidden" value="<?php echo base64url_encode($perfil->codpersona) ?>" required />
                      
                      
                      <b class="text-danger"><i class="far fa-file-alt mr-1"></i> CONTACTO</b>
                      <div class="row my-3">
                        
                       
                        <div class="form-group has-float-label col-12 col-sm-4">
                          <input disabled data-currentvalue='<?php echo $perfil->celular ?>' class="form-control form-control-sm text-uppercase" id="fitxtcelular" name="fitxtcelular" type="text" placeholder="Celular 1" value="<?php echo $perfil->celular ?>"   />
                          <label for="fitxtcelular">Celular 1</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-sm-4">
                          <input disabled data-currentvalue='<?php echo $perfil->celular2 ?>' class="form-control form-control-sm text-uppercase" id="fitxtcelular2" name="fitxtcelular2" type="text" placeholder="Celular 2" value="<?php echo $perfil->celular2 ?>"  />
                          <label for="fitxtcelular2">Celular 2</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-sm-4">
                          <input data-currentvalue='<?php echo $perfil->telefono ?>' class="form-control form-control-sm text-uppercase" id="fitxttelefono" name="fitxttelefono" type="text" placeholder="Teléfono" value="<?php echo $perfil->telefono ?>" />
                          <label for="fitxttelefono">Teléfono</label>
                        </div>

                        <div class="form-group has-float-label col-12 col-sm-12">
                          <input disabled data-currentvalue='<?php echo $perfil->epersonal ?>' class="form-control form-control-sm" id="fitxtemailpersonal" name="fitxtemailpersonal" type="text" placeholder="Email Personal"  value="<?php echo $perfil->epersonal ?>" />
                          <label for="fitxtemailpersonal">Email personal</label>
                        </div>
                        
                      </div>
                      <b class="text-danger"><i class="fas fa-map-marker-alt"></i> UBICACIÓN</b>
                      <div class="row my-3">
                        <div class="col-12 pb-2">
                          <small id="emailHelp" class="form-text text-muted">Consignar la dirección, departamento, provincia y distrito que aparece en su DNI, CE o PSP</small>
                        </div>
                        <div class="form-group has-float-label col-12 col-xs-12 col-sm-12">
                          
                          <textarea  onkeyup='setaltura($(this));'  rows="1" disabled data-currentvalue='<?php echo $perfil->domicilio ?>' class="form-control form-control-sm text-uppercase" id="fitxtdomicilio" name="fitxtdomicilio" placeholder="Dirección" required /><?php echo $perfil->domicilio ?></textarea> 
                          <label for="fitxtdomicilio">Dirección</label>
                        </div>
                      

                      
                          <div class="col-12 col-sm-3 vwperfil_row_ubispan">
                            <span id="fispan_departamento" class="form-control bg-lightgray form-control-sm"><?php echo "$perfil->departamento" ?></span>
                          </div>
                          <div class="col-12 col-sm-4 vwperfil_row_ubispan">
                            <span id="fispan_provincia" class="form-control bg-lightgray form-control-sm"><?php echo "$perfil->provincia" ?></span>
                          </div>
                          <div class="col-12 col-sm-5 vwperfil_row_ubispan">
                            <span id="fispan_distrito" class="form-control bg-lightgray form-control-sm"><?php echo "$perfil->distrito" ?></span>
                          </div>
                       
                          <div class="form-group has-float-label col-12 col-xs-4 col-sm-3 vwperfil_row_ubiselect">
                            <select disabled class="form-control" id="ficbdepartamento" name="ficbdepartamento" placeholder="Departamento" required >
                              <option value="0">Selecciona Departamento</option>
                            </select>
                            <label for="ficbdepartamento"> Departamento</label>
                          </div>
                          <div class="form-group has-float-label col-12 col-xs-4 col-sm-4 vwperfil_row_ubiselect">
                            <select disabled  class="form-control" id="ficbprovincia" name="ficbprovincia" placeholder="Provincia" required >
                              <option value="0"></option>
                            </select>
                            <label for="ficbprovincia"> Provincia</label>
                          </div>
                          <div class="form-group has-float-label col-12 col-xs-4 col-sm-5 vwperfil_row_ubiselect">
                            <select disabled  class="form-control" id="ficbdistrito" name="ficbdistrito" placeholder="Distrito" required >
                              <option value="0"></option>
                            </select>
                            <label for="ficbdistrito"> Distrito</label>
                          </div>
                      </div>
                      <div class="row py-4">
                        <div class="col-12 pb-2">
                          <small id="emailHelp" class="form-text text-muted">Otra dirección: Consignar la direción en caso de alquilar o ser vivivienda de un familiar</small>
                        </div>
                        <div class="form-group has-float-label col-12 col-xs-12 col-sm-12">
                          <textarea  onkeyup='setaltura($(this));'  rows="1" disabled data-currentvalue='<?php echo $perfil->domicilio2 ?>' class="form-control text-uppercase form-control-sm" id="fitxtdomiciliootro" name="fitxtdomiciliootro" placeholder="Otra dirección" /><?php echo $perfil->domicilio2 ?></textarea> 
                          <label for="fitxtdomiciliootro">Otra dirección</label>
                        </div>
                      </div>
                    
                    <div class="row">
                      <div class="col-12"><span id="fispedit" class="text-danger"></span></div>
                      <div class="col-12">
                        
                        <button id="vwperfil_btn_editaperfil" class="btn btn-success float-right" type="button" data-sugerencia='openfile'><i class="fas fa-user-plus"></i> Modificar</button>
                        <button id="vwperfil_btn_cancelaperfil" type="button" class="btn btn-danger "><i class="fas fa-undo"></i> Cancelar</button>
                        <button id="vwperfil_btn_guardaperfil" data-step='ins' type="button" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
                      </div>
                    </div>
                    </form>
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
                          Usuario <small class="text-muted"> (El usuario no puede ser cambiado)</small>
                        </span>
                        <span class="form-control bg-lightgray mb-2"><?php echo $_SESSION['userActivo']->usuario ?></span>
                        
                        <form id="vwperfil_frmcambiaclave" name="vwperfil_frmcambiaclave" action="<?php echo $vbaseurl ?>usuario/fn_cambiar_clave" method="post" accept-charset='utf-8'>
                          <div class="row">
                            
                            <div class="col-12 mb-2">
                              <span class="text-muted">
                                Contraseña actual
                              </span>
                              <input class="form-control" autocomplete="new-password" type="password" required id="fcctxtclave" minlength="5" maxlength="20" name="fcctxtclave">
                            </div>
                            
                            <div class="col-12 mb-2">
                              <hr>
                              <small class="text-muted">
                              Se recomienda usar una contraseña segura que no uses en ningún otro sitio.
                              </small>
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
                    <div id="actions" class="col-12">
                          <div class="row">
                              <div class="col-lg-7">
                                  <!-- The fileinput-button span is used to style the file input field as button -->
                                  <button type="submit" class="btn btn-primary start" style="display: none;">
                                  <i class="fas fa-upload"></i>
                                  <span>Upload</span>
                                  </button>
                                  <button type="reset" class="btn btn-warning cancel" style="display: none;">
                                  <i class="fas fa-ban"></i>
                                  <span>Cancel</span>
                                  </button>
                              </div>
                              
                              <div class="col-lg-5">
                                  <!-- The global file processing state -->
                                  
                              </div>
                          </div>
                      </div>
                    <div class="col-12 dropzone-here">
                          
                      </div>
                      <div class="col-12 px-3 text-center">
                          <span class="fileupload-process" style="display: none">
                              <div id="total-progress" class="progress " role="progressbar">
                                  <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress>
                                  </div>
                              </div>
                          </span>
                          <h5> Arrastra aquí tu IMAGEN (Peso 5 MB máx.)</h5>
                          <div class="row" id="previews">
                              
                              <div id="template" class="col-6 col-sm-4 col-md-2 px-2 mt-2" >
                                  <div  class="row">
                                      <!-- This is used as the file preview template -->
                                      
                                      <div class="col-12 mx-auto preview ">
                                          <img data-dz-thumbnail />
                                          
                                          
                                          <a class="text-primary start" style="display: none">
                                              <i class="fas fa-upload"></i>
                                              <span>Empezar</span>
                                          </a>
                                          <a data-dz-remove class="text-warning cancel">
                                              <i class="fas fa-ban"></i>
                                              <span>Cancelar</span>
                                          </a>
                                          <a data-dz-remove class=" text-danger delete">
                                              <i class="fas fa-trash"></i>
                                              <span>Eliminar</span>
                                          </a>
                                          <div class="progress">
                                              <div class="progress-bar pb-private progress-bar-striped bg-info" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress>
                                              </div>
                                          </div>
                                          <div>
                                              <strong class="error text-danger" data-dz-errormessage></strong>
                                          </div>
                                          
                                          
                                          
                                          <p class="size m-0" data-dz-size></p>
                                          <p class="name m-0" data-dz-name></p>
                                      </div>
                                  </div>
                                  
                              </div>
                              
                          </div>
                          
                      </div>
                      <div class="alert alert-danger alert-dismissible mt-2" style="display: none">
        
                        <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
                        <ul>
                            <li>Se encontraron algunos archivos con error </li>
                            <li>Verifique si alguno de ellos tenga un peso superior a los 5 Mb (5120 kb)</li>
                            <li>Solo se acepta archivos de tipo imagen</li>
                        </ul>
                      </div>
                      <div class="card-footer">
                          
                          <button id="btn-guardararchivo" class="btn btn-primary float-right" type="button" >Guardar</button>
                      </div>
                  </div>
                  
                </div>
                
              </div>
            </div>
            
          </div>
          
        </div>
      </div>  
    </div>
  </section>
  
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.js"></script>
<script>
  function setaltura(ta){
     ta.height(1);
     ta.height(ta.prop('scrollHeight')-7);
  }

 

  $('#vwperfil_frm_perfil select').change(function() {

    if ($(this).attr('id') == "ficbdepartamento") {
        $('#vwperfil_div_todo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#vwperfil_frm_perfil #ficbprovincia').html("<option value='0'>Sin opciones</option>");
        $('#vwperfil_frm_perfil #ficbdistrito').html("<option value='0'>Sin opciones</option>");
        var coddepa = $(this).val();
        if (coddepa == '0') return;
        $.ajax({
            url: base_url + 'ubigeo/fn_provincia_x_departamento',
            type: 'post',
            dataType: 'json',
            data: {
                txtcoddepa: coddepa
            },
            success: function(e) {
                $('#vwperfil_frm_perfil #ficbprovincia').html(e.vdata);
                $('#vwperfil_div_todo #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#vwperfil_frm_perfil #ficbprovincia').html("<option value='0'>" + msgf + "</option>");
                $('#vwperfil_div_todo #divoverlay').remove();
            }
        });
    } else if ($(this).attr('id') == "ficbprovincia") {
      $('#vwperfil_div_todo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#vwperfil_frm_perfil #ficbdistrito').html("<option value='0'>Sin opciones</option>");
        var codprov = $(this).val();
        if (codprov == '0') return;
        $.ajax({
            url: base_url + 'ubigeo/fn_distrito_x_provincia',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodprov: codprov
            },
            success: function(e) {
                $('#vwperfil_frm_perfil #ficbdistrito').html(e.vdata);
                $('#vwperfil_div_todo #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#vwperfil_frm_perfil #ficbdistrito').html("<option value='0'>" + msgf + "</option>");
                $('#vwperfil_div_todo #divoverlay').remove();
            }
        });
        return false;
    }
    return false;
});

  $('#vwperfil_btn_editaperfil').click(function(event) {
    $('#vwperfil_div_todo').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var textdepa=$("#fispan_departamento").html();
    var textprov=$("#fispan_provincia").html();
    var textdist=$("#fispan_distrito").html();
    var fdata= [];
    fdata.push({name: 'textdepa', value: textdepa});
    fdata.push({name: 'textprov', value: textprov});
    fdata.push({name: 'textdist', value: textdist});
    $.ajax({
        url: base_url + 'ubigeo/fn_get_ubigeo',
        type: 'post',
        dataType: 'json',
        data: fdata,
        success: function(e) {
            $('#vwperfil_frm_perfil #ficbdepartamento').html(e.vdepa);
            $('#vwperfil_frm_perfil #ficbprovincia').html(e.vprov);
            $('#vwperfil_frm_perfil #ficbdistrito').html(e.vdist);
            $('#vwperfil_div_todo #divoverlay').remove(); 
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vwperfil_div_todo #divoverlay').remove(); 
            $('#vwperfil_frm_perfil #ficbdepartamento').html("<option value='0'>" + msgf + "</option>");
        }
    });

    $("#vwperfil_frm_perfil").data('action', 'edit');
    $("#vwperfil_frm_perfil input,textarea").attr('disabled', false);
    $("#vwperfil_frm_perfil select").attr('disabled', false);
    $("#vwperfil_btn_cancelaperfil").show();
    $('#vwperfil_btn_guardaperfil').show();
    $('#vwperfil_btn_editaperfil').hide();
    $('.vwperfil_row_ubispan').hide();
    $(".vwperfil_row_ubiselect").show();

});

$('#vwperfil_btn_cancelaperfil').click(function(event) {
    
    $("#vwperfil_frm_perfil").data('action', 'view');
    $("#vwperfil_frm_perfil input,textarea").attr('disabled', true);
    
    $('#vwperfil_div_todo input,textarea').each(function() {
        $(this).val($(this).data('currentvalue'));
    });
    $("#vwperfil_div_todo #ficbsexo").val($("#vwperfil_div_todo #ficbsexo").data('currentvalue'));

    $("#vwperfil_frm_perfil select").attr('disabled', true);
    $("#vwperfil_btn_cancelaperfil").hide();
    $('#vwperfil_btn_guardaperfil').hide();
    $('#vwperfil_btn_editaperfil').show();
    $('.vwperfil_row_ubispan').show();
    $(".vwperfil_row_ubiselect").hide();


});
$('#vwperfil_btn_guardaperfil').click(function(event) {
    
   $('#vwperfil_frm_perfil').submit();

});

$("#vwperfil_frm_perfil").submit(function(event) {
  
  $('#vwperfil_div_todo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  
  $.ajax({
      url: base_url + 'persona/fn_update_dinamico',
      type: 'post',
      dataType: 'json',
      data: $(this).serialize(),
      success: function(e) {
           $('#vwperfil_div_todo #divoverlay').remove();
            if (e.status==true){
              $('#vwperfil_div_todo input,textarea').each(function() {
                  $(this).data('currentvalue', $(this).val());
              });
              $("#vwperfil_div_todo #ficbsexo").data('currentvalue', $("#vwperfil_div_todo #ficbsexo").val());
              $("#fispan_departamento").html($( "#ficbdepartamento option:selected" ).text());
              $("#fispan_provincia").html($( "#ficbprovincia option:selected" ).text());
              $("#fispan_distrito").html($( "#ficbdistrito option:selected" ).text());

              $("#vwperfil_frm_perfil").data('action', 'view');
              $("#vwperfil_frm_perfil input,textarea").attr('disabled', true);
              
        

              $("#vwperfil_frm_perfil select").attr('disabled', true);
              $("#vwperfil_btn_cancelaperfil").hide();
              $('#vwperfil_btn_guardaperfil').hide();
              $('#vwperfil_btn_editaperfil').show();
              $('.vwperfil_row_ubispan').show();
              $(".vwperfil_row_ubiselect").hide();


              ;
              Swal.fire({
                  type: 'success',
                  title: 'Felicitaciones, se guardó los cambios',
                  text: e.msg,
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
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#vwperfil_frm_perfil #ficbprovincia').html("<option value='0'>" + msgf + "</option>");
          $('#vwperfil_div_todo #divoverlay').remove();
      }
  });
  return false;
});

    $("#vwperfil_frmcambiaclave").submit(function(event) {
      $('#card-cmabiaclave').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $('#vwperfil_frmcambiaclave input,select').removeClass('is-invalid');
      $('#vwperfil_frmcambiaclave .invalid-feedback').remove();
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
              $("#vwperfil_frmcambiaclave")[0].reset();
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

    $("#btn-guardararchivo").click(function(event) {
      $('#card-fichas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

      var fdata= [];
      
      var link
      for(var si in myDropzone.files){
        i=myDropzone.files[si];
        link = i.link;
        
      }
      fdata.push({name: 'link', value: link});



      $.ajax({
          url: base_url + 'persona/fn_guardar_foto_propia',
          type: 'post',
          dataType: 'json',
          data: fdata,
          success: function(e) {
              $('#card-fichas #divoverlay').remove();
              if (e.status==true){
                Swal.fire({
                    type: 'success',
                    title: 'Felicitaciones',
                    text: e.msg,
                    backdrop: false,
                });
                //myDropzone.disable(); 
                //$("#vwperfil_img_user").attr("src",base_url + "resources/fotos/" + e.link);
                location.reload();

              }
              else{
                Swal.fire({
                    type: 'error',
                    title: 'ERROR, no se guardó los cambios',
                    text: e.msg,
                    backdrop: false,
                });
              }
              
          },
          error: function(jqXHR, exception) {
              $('#card-fichas #divoverlay').remove();
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


    //url: base_url + "usuario/fn_upload_foto_propia",

    $("#vwperfil_btn_cambiarfoto").click(function(event) {
      event.preventDefault();
      $('.nav-tabs a[href="#settings"]').tab('show')
      var ir = "settings";
      var new_position = jQuery('#'+ir).offset();
      window.scrollTo(new_position.left,new_position.top-150);

      

    });
    /*DROPZONE*/
    $(document).ready(function() {
      $('#vwperfil_btn_cancelaperfil').click();
      $("#btn-guardararchivo").prop("disabled", true);
      var imageUrl = base_url + "resources/img/nube.png";
      $('#previews').css('background-image', 'url(' + imageUrl + ')');
      $('#previews').css('background-repeat', 'url(' + imageUrl + ')');


    // Get the template HTML and remove it from the doument

    Dropzone.prototype.getErroredFiles = function () {
       var file, _i, _len, _ref, _results;
       _ref = this.files;
       _results = [];
       for (_i = 0, _len = _ref.length; _i < _len; _i++) {
           file = _ref[_i];
           if (file.status === Dropzone.ERROR) {
               _results.push(file);
           }
       }
       return _results;
    };

    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    myDropzone = new Dropzone(document.body, {
        url: base_url + "persona/fn_upload_foto_propia",
        paramName: "file",
        maxFilesize: 6,
        maxFiles: 1,
        thumbnailWidth: 100,
        thumbnailHeight: 100,
        timeout: 180000,
        thumbnailMethod: 'crop',
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: true,
        previewsContainer: "#previews",
        clickable: "#previews",
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        init: function() {
            this.on("complete", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0 && this.getErroredFiles().length === 0) {
   
                    $(".alert").hide();
                    $("#btn-guardararchivo").prop("disabled", false);
                }
                else{
                    $(".alert").show();
                    $("#btn-guardararchivo").prop("disabled", true);
                }
            });
            

            este = this;
            


            this.on("success", function(file, response) {
                var obj = jQuery.parseJSON(response)
                file.link = obj.link;
                file.fileid=0;
                //console.log(file);
            })

        },
        removedfile: function(file) {
            var vinid=(typeof file.fileid === "undefined") ? "":file.fileid ;
            var vilink=(typeof file.link === "undefined") ? "":file.link ;
            var este=this;
            Swal.fire({
                title: '¿Deseas eliminar el ARCHIVO ?',
                text: "Al eliminar, se perdera " + file.name + " y no podrá recuperarse",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.value) {
                        $.ajax({
                            url: base_url + 'persona/fn_delete_upload_foto',
                            type: 'POST',
                            data: {
                                "coddetalle": vinid,
                                "link": vilink 
                            },
                            dataType: 'json',
                            success: function(e) {
                                if (e.status == true) {
                                    Swal.fire(
                                        'Eliminado!',
                                        'El archivo fue eliminado correctamente.',
                                        'success'
                                    )
                                    file.previewElement.remove();
                                    if (este.getUploadingFiles().length === 0 && este.getQueuedFiles().length === 0 && este.getErroredFiles().length === 0) {
                                        $(".alert").hide();
                                        $("#btn-guardararchivo").prop("disabled", false);
                                    }
                                     else{
                                        $(".alert").show();
                                        $("#btn-guardararchivo").prop("disabled", true);
                                    }

                                } else {
                                    Swal.fire(
                                        'Error!',
                                        e.msg,
                                        'error'
                                    )
                                }
                            },
                            error: function(jqXHR, exception) {
                                var msgf = errorAjax(jqXHR, exception, 'text');
                                Swal.fire(
                                    'Error!',
                                    msgf,
                                    'success'
                                )
                            }
                        });
                }
            })
            return false;


        }

    });

    myDropzone.on("addedfile", function(file) {
        file.previewElement.querySelector(".start").onclick = function() {
            myDropzone.enqueueFile(file);
        };
        var ext = file.name.split('.').pop();
        $("#btn-guardararchivo").prop("disabled", true);
        if (ext == "pdf") {
            myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/pdf.png");
        } else if (ext.indexOf("doc") != -1) {
            myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/word.png");
        } else if (ext.indexOf("xls") != -1) {
            myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/excel.png");
        } else if ((ext.indexOf("jpg") != -1) || (ext.indexOf("png") != -1)) {
            myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/img.png");
        } else {
            myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/file.png");
        }


    });


    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
    });

    myDropzone.on("sending", function(file) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1";
        // And disable the start button

        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
    });

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function(progress) {
        document.querySelector("#total-progress").style.opacity = "0";

    });

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
    };


});
</script>