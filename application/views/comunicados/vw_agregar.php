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

.dropzone-here {
text-align: center;
font-size: 18px;
font-weight: bold;
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

</style>
<?php $vbaseurl=base_url(); 
$vcodigo="0";
$vtitulo="";
$vdescripcion="";
$vpublicado="";
$vnuevo="";
$vaccesos="";
$vpeso=0;
$vruta="";
$vtipofile="";
$vnarchivo = "";

if (isset($comun->codigo))  $vcodigo=base64url_encode($comun->codigo);
if (isset($comun->titulo))  $vtitulo=$comun->titulo;
if (isset($comun->descripcion))  $vdescripcion=$comun->descripcion;
if (isset($comun->publicado))  $vpublicado=$comun->publicado;
if (isset($comun->nuevo))  $vnuevo=$comun->nuevo;
if (isset($comun->accesos))  $vaccesos=$comun->accesos;
if (isset($comun->archivo))  $vnarchivo=$comun->archivo;
if (isset($comun->peso))  $vpeso=$comun->peso;
if (isset($comun->ruta))  $vruta=$comun->ruta;

$arrayAccs = explode(",", $vaccesos);

function obtienevalor($array, $valor)
{

    for ($i = 0; $i < count($array); $i++) {
        if ($array[$i] == $valor) {
            return $array[$i];
        }
    }
    
}

// print_r(obtienevalor($arrayAccs, "AD"));

?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>COMUNICADOS
                    <small>Mantenimiento</small></h1>
                </div>
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>portal-web/transparencia">Comunicados</a>
                        </li>
                        <li class="breadcrumb-item active">Mantenimiento</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section id="s-cargado" class="content">
        <div id="vw_pw_bt_ad_div_principal" class="card">
            <div class="card-body">
                <form id="vw_pw_bt_ad_form_addDWeb" action="<?php //echo $vbaseurl ?>" method="post" accept-charset="utf-8">
                    <div class="row mt-2">
                        <input id="vw_pw_bt_ad_fictxtcodigo" name="vw_pw_bt_ad_fictxtcodigo" type="hidden" value="<?php echo $vcodigo ?>">
                        
                        <div class="form-group has-float-label col-12 col-sm-12">
                            <input data-currentvalue='' autocomplete="off" class="form-control" id="vw_pw_bt_ad_fictxttitulo" name="vw_pw_bt_ad_fictxttitulo" type="text" placeholder="Titulo de publicación" value="<?php echo $vtitulo ?>" />
                            <label for="vw_pw_bt_ad_fictxttitulo">Titulo</label>
                        </div>

                        <div class="form-group col-12 col-sm-12">
                            <label for="vw_pw_bt_ad_fictxtdesc">Descripción</label>
                            <textarea data-currentvalue='' class="form-control vw_pw_bt_textarea_summer" id="vw_pw_bt_ad_fictxtdesc" name="vw_pw_bt_ad_fictxtdesc" placeholder="Descripción"><?php echo $vdescripcion ?></textarea>
                        </div>

                        <div class="form-group col-6 col-md-4">
                            <label for="checkestado">Publicar:</label>
                            <input  id="checkestado" <?php echo ($vpublicado=="SI")?"checked":"" ?> name="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                        </div>

                        <div class="form-group col-6 col-md-4">
                            <label for="checknuevo">Nuevo:</label>
                            <input  id="checknuevo" <?php echo ($vnuevo=="SI")?"checked":"" ?> name="checknuevo" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                        </div>

                        <div class="col-12 col-md-12">
                            <span class="font-weight-bold h6"><u>¿Quienes pueden visualizarlo?</u></span>
                            <div class="row mt-2" id="itemsacc">
                                <div class="form-group col-12 col-md-3">
                                    <div  class="icheck-primary ml-2">
                                        <input type="checkbox" <?php echo (obtienevalor($arrayAccs, "AD") == "AD") ? "checked": "" ?> value="AD" name="checktipo1" id="checktipo1" class="selectitem">
                                        <label for="checktipo1" class="text">Administrativos</label>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-2">
                                    <div  class="icheck-primary ml-2">
                                        <input type="checkbox" <?php echo (obtienevalor($arrayAccs, "DC") == "DC") ? "checked": "" ?> value="DC" name="checktipo2" id="checktipo2" class="selectitem">
                                        <label for="checktipo2" class="text">Docentes</label>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div  class="icheck-primary ml-2">
                                        <input type="checkbox" <?php echo (obtienevalor($arrayAccs, "DA") == "DA") ? "checked": "" ?> value="DA" name="checktipo3" id="checktipo3" class="selectitem">
                                        <label for="checktipo3" class="text">Docentes Administrativos</label>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <div  class="icheck-primary ml-2">
                                        <input type="checkbox" <?php echo (obtienevalor($arrayAccs, "AL") == "AL") ? "checked": "" ?> value="AL" name="checktipo4" id="checktipo4" class="selectitem">
                                        <label for="checktipo4" class="text">Estudiantes</label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="fictxtaccesos" value="<?php echo $vaccesos ?>" id="fictxtaccesos">
                        </div>  

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
                            <h5> Arrastra aquí tus archivos (1 archivo máx. - Peso 10 MB máx. c/u)</h5>
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
                        
                 
                        <div class="col-12 py-2">
                            <div id="vw_pw_bt_ad_divmsgbolsa" class="text-danger">
                            </div>
                        </div>
                        <div class="col-12">
                            <a type="button" href="<?php echo $vbaseurl ?>gestion/comunicados" class="btn btn-danger btn-md float-left" >
                                <i class="fas fa-undo"></i> Cancelar
                            </a>
                            <button type="submit" id="vw_pw_bt_ad_btn_guardar" class="btn btn-primary btn-md float-right"><i class="fas fa-save"></i> Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?php
echo
"<script src='{$vbaseurl}resources/plugins/summernote8/summernote-bs4.min.js'></script>
<script src='{$vbaseurl}resources/plugins/summernote8/lang/summernote-es-ES.js'></script>
<script src='{$vbaseurl}resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js'></script>
<script src='{$vbaseurl}resources/plugins/dropzone/dropzone.min.js'></script>
<script src='{$vbaseurl}resources/dist/js/pages/comunicados.js'></script>";
?>
<script type="text/javascript">
    //CON DROPZONE
var varchivo = new Array();
varchivo['peso']=<?php echo $vpeso ?>;
varchivo['tipo']='<?php echo $vtipofile ?>';
varchivo['link']='<?php echo $vruta ?>';
varchivo['codigo']='<?php echo $vcodigo ?>';
varchivo['nombre']='<?php echo $vnarchivo ?>';
var myDropzone;
//https://forms.gle/FDBdiAmFYcepJppR6
$("#vw_pw_bt_ad_btn_guardar").click(function(event) {

    $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    link="";
    fdata=$("#vw_pw_bt_ad_form_addDWeb").serializeArray();
    var html = $('#vtextdetalle').summernote('code');
    fdata.push({name: 'textdetalle', value: html});
    arrdata = [];
    for(var si in myDropzone.files){
      i=myDropzone.files[si];
      var myvals = [i.link,i.name,i.size,i.type,i.fileid];
      arrdata.push(myvals);
    }
    fdata.push({name: 'afiles', value: JSON.stringify(arrdata)});
    $.ajax({
        url: base_url + 'comunicados/fn_guardar',
        type: 'POST',
        data: fdata,
        dataType: 'json',
        success: function(e) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            if (e.status==true){
                
                Swal.fire(
                  'Exito!',
                  'Los datos fueron guardados correctamente.',
                  'success'
                );
                window.location.href = e.redirect;
            }
            else{
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire(
                  'Error!',
                  e.msg,
                  'error'
                )
            }
        },
        error: function(jqXHR, exception) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire(
                  'Error!',
                  msgf,
                  'error'
                )
        }
    })
    return false;
});

$('.selectitem').change(function(event) {
    var items = '';
    var values = [];
    $("#itemsacc .selectitem").each(function() {
        if (this.checked) {
            items = $(this).val();
            values.push(items)
        }
    });
    $('#fictxtaccesos').val($.trim(values.join(",")))
});

</script>