<?php $vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.css">
<link href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.css">
<div class="content-wrapper">

     <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1>ENCUESTA
            <small>CREAR</small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="<?php echo $vbaseurl ?>monitoreo/estudiantes?tb=e"><i class="fas fa-compass"></i> Monitoreo estudiante</a>
                </li>
             
              <li class="breadcrumb-item active">Crear encuesta</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <form id='frm-insertupdate' name='frm-insertupdate'   method='post' accept-charset='utf-8'>
            <?php 
                $vid="-1";
                if (isset($vcencuesta->codigo))  $vid=$vcencuesta->codigo;
             ?>
            <input id="vid" name="vid" type="hidden" value="<?php echo  $vid ?>">
            <div class="card" id="divcard-body">

               
<?php 
$vcodperiodo="";
$vnombre="";
$vdescripcion="";
$vtipo="C";
$vobjetivo="C";
$fvence="";
$finicia="";
$vtiempo=0;
$vmedtiempo=0;
$vdetalle="";
$vopcion1="NO";
$vopcion2="NO";
$vopcion3="NO";
$vopcion4="NO";
$vhalerta= 48;


if (isset($vcencuesta->detalle))  $vcodperiodo=$vcencuesta->codperiodo;
if (isset($vcencuesta->nombre))  $vnombre=$vcencuesta->nombre;
if (isset($vcencuesta->descripcion))  $vdescripcion=$vcencuesta->descripcion;
if (isset($vcencuesta->detalle))  $vdetalle=$vcencuesta->detalle;
if (isset($vcencuesta->tipo))  $vtipo=$vcencuesta->tipo;
if (isset($vcencuesta->objetivo))  $vobjetivo=$vcencuesta->objetivo;
if (isset($vcencuesta->vence))  $fvence=$vcencuesta->vence;
if (isset($vcencuesta->inicia))  $finicia=$vcencuesta->inicia;
if (isset($vcencuesta->tiempo))  $vtiempo=$vcencuesta->tiempo;
if (isset($vcencuesta->medtiempo))  $vmedtiempo=$vcencuesta->medtiempo;
if (isset($vcencuesta->opc1))  $vopcion1=$vcencuesta->opc1;
if (isset($vcencuesta->opc2))  $vopcion2=$vcencuesta->opc2;
if (isset($vcencuesta->opc3))  $vopcion2=$vcencuesta->opc3;
if (isset($vcencuesta->opc4))  $vopcion2=$vcencuesta->opc4;
if (isset($vcencuesta->halerta))  $vopcion2=$vcencuesta->halerta;



 ?>


<input id="vtipo" name="vtipo" type="hidden" class="form-control" value="<?php echo  $vtipo ?>">

<div class="card-body px-2 px-sm-3">
    <div class="row">
        <div class="col-6 col-md-4 form-group ">
            <div class="input-group border rounded input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-transparent  border-0 pr-0"><i class="fas fa-chart-pie"></i></span>
                </div>
                <select placeholder="Periodo" class="form-control border-0" name="vw_cuge_cbperiodo" id="vw_cuge_cbperiodo">
                    <option value="">PERIODO</option>
                    <?php foreach ($vcperiodos as $pdo) {?>
                    

                    <option <?php echo ($vcodperiodo==$pdo->codigo)?"selected":""; ?> value="<?php echo $pdo->codigo ?>"><?php echo $pdo->nombre ?></option>
                    <?php }?>
                </select>
                
            </div>
        </div>
        <div class="col-6 col-md-8 form-group ">
            <div class="input-group border rounded input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-transparent  border-0 pr-0"><i class="fas fa-bullseye"></i></span>
                </div>
                <select placeholder="Periodo" class="form-control border-0" name="vw_cuge_cbobjetivo" id="vw_cuge_cbobjetivo">
                    <option value="">OBJETIVO</option>
                    <option <?php echo ($vobjetivo=="DD")?"selected":""; ?> value="DD">DD - Desempeño docente en aula</option>
                    <option <?php echo ($vobjetivo=="GN")?"selected":""; ?> value="GN">GN - Encuesta General </option>

                    
                    
                    
                </select>
                
            </div>
        </div>
    </div>
    <div class="has-float-label row">
        <div class="form-group col-12">
            <input value="<?php echo $vnombre ?>" class="form-control" id="vw_cuge_nombre" name="vw_cuge_nombre" type="text" placeholder="Nombre"   />
            <label for="vw_cuge_nombre">Nombre</label>
        </div>
        <div class="form-group col-12">
            <textarea maxlength="200" class="form-control" id="vdescripcion" name="vdescripcion" type="text" placeholder="Descripción"/><?php echo $vdescripcion ?></textarea>
            <label for="vdescripcion">Descripción</label>
            <small id="passwordHelpBlock" class="form-text text-muted">
                Descripción es un texto que solo será visible para el creador y el observador de la encuesta, no a los encuestados.
            </small>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label for="vtextdetalle">Mensaje:</label>
            <small id="passwordHelpBlock" class="form-text text-muted">
                Este mensaje aparecerá como encabezado en la encuesta final
            </small>
            <textarea id="vtextdetalle" name="vtextdetalle" class="form-control" rows="10">
            <?php echo $vdetalle ?>
            </textarea>
        </div>

    </div>
    <div class="row mt-3">
        <form method="post" enctype="multipart/form-data">
                    <div class="col-12">
                                <div class="card border-light">
                                    <div class="card-header px-2 pb-1">
                                        <h4>Tiempo</h4>
                                    </div>
                                    <?php 
                                        date_default_timezone_set('America/Lima');
                                        $fechai = date('Y-m-d');
                                        $horai = date('H:i');
                                        $checi="";
                                        $enabledi="disabled";
                                        if ($finicia!=""){
                                            $fechai = date('Y-m-d',strtotime($finicia));
                                            $horai = date('H:i',strtotime($finicia)); 
                                            $checi="checked";
                                            $enabledi="";
                                        }
                                        $fechav= date('Y-m-d');;
                                        $horav = date('H:i');;
                                        $checv="";
                                        $enabledv="disabled";
                                        if ($fvence!=""){
                                            $fechav = date('Y-m-d',strtotime($fvence));
                                            $horav = date('H:i',strtotime($fvence)); 
                                            $checv="checked";
                                            $enabledv="";
                                        }
                                        
                                    ?>
                                    <div class="card-body px-2 px-sm-3">
                                        <div class="form-group row">
                                            <div class="col-12 col-md-3">
                                                <a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary" tabindex="0" data-toggle="popover" data-content="Indica la fecha y hora en que se empezará a recibir las entregas, si no se activa la entrega puede empezar ahora mismo" data-trigger="focus" title="">?</a>
                                                Iniciar encuesta
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input id="txtopenfecha" name="txtopenfecha" class="inputstiempo form-control" type="date" autocomplete="off" required value="<?php echo $fechai ?>" <?php echo $enabledi ?>/>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input id="txtopenhora" name="txtopenhora" class="inputstiempo form-control" type="time" autocomplete="off" required value="<?php echo $horai ?>" <?php echo $enabledi ?>/>
                                            </div>
                                            <div class="col-12 col-md-2 pt-2">
                                                <input <?php echo $checi ?>  class="checkstiempo" type="checkbox" id="checkopen" name="checkopen" value="SI">
                                                <label  for="checkopen"> Habilitar</label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-12 col-md-3">
                                                <a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary" tabindex="0" data-toggle="popover" data-content="Indica la fecha y hora en que se considera una tarea entregada a tiempo" data-trigger="focus" title="">?</a>
                                                Culminar
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input id="txtclosefecha" name="txtclosefecha" class="inputstiempo form-control" type="date" autocomplete="off" required value="<?php echo $fechav ?>" <?php echo $enabledv ?>/>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input id="txtclosehora" name="txtclosehora" class="inputstiempo form-control" type="time" autocomplete="off" required value="<?php echo $horav ?>" <?php echo $enabledv ?>/>
                                            </div>
                                            <div class="col-12 col-md-2 pt-2">
                                                <input <?php echo $checv ?>  class="checkstiempo" type="checkbox" id="checkclose" name="checkclose" value="SI">
                                                <label  for="checkclose"> Habilitar</label>
                                            </div>
                                        
                                        <!--<div class="row pt-2">
                                            <div class="col-12 col-md-3 pt-2">
                                                <a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary" tabindex="0" data-toggle="popover" data-content="Indica cuanto dura la evaluación" data-trigger="focus" title="">?</a>
                                                Límite de tiempo
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <input id="txtlimitnumero" name="txtlimitnumero" class="inputstiempo form-control" type="number" autocomplete="off" required value="<?php //echo $tiempol ?>" <?php //echo $enabledl ?>/>
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <select name="vmedtiempo" id="vmedtiempo" class=" inputstiempo form-control" <?php //echo $enabledl ?>>
                                                    <option <?php //echo ($vmedtiempo==1) ? "selected":"" ?> value="1">días</option>
                                                    <option <?php //echo ($vmedtiempo==2) ? "selected":"" ?> value="2">horas</option>
                                                    <option <?php //echo ($vmedtiempo==3) ? "selected":"" ?> value="3">minutos</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-2 pt-2">
                                                <input <?php //echo $chect ?> class="checkstiempo" type="checkbox" id="checklimite" name="checklimite" value="SI">
                                                <label  for="checklimite"> Habilitar</label>
                                            </div>-->
                                        </div>
                                        
                                
                                        <div class="form-group row">
                                                <div class="col-12 ">
                                                    <a href="#" onclick="event.preventDefault();"  class="badge badge-pill badge-secondary" tabindex="0" role="button" data-toggle="popover" data-content="El participante debe agregar su opinion para poder ver la opinión de los demas compañeros" data-trigger="focus" title="">?</a>
                                                    <span for="checkopcion1">  Solicitar respuesta obligatoria </span>
                                                    <input name="valerta" id="valerta" class="text-center form-control-sm border-top-0 border-right-0 border-left-0" type="number" value="<?php echo $vhalerta ?>">
                                                    <span>horas antes de culminar el tiempo de encuesta</span>
                                                    <input value="SI" id="checkopcion1" <?php echo ($vopcion1=="SI")?"checked":"" ?> name="checkopcion1" data-size="xs" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                    </div>
        </form>
    </div>
</div>
<div class="card-footer">
    <a href="<?php echo $vbaseurl ?>monitoreo/estudiantes?tb=e" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</a>
    <button id="vw_cuge_btn-guardarcuestionario" class="btn btn-primary float-right" type="button" >Guardar</button>
</div>



                
            </div>
        </form>
    </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.js"></script>

<script src="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.js"></script>

<script src="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery.ui.touch-punch.min.js"></script>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>

<script>

$(function () {
  $('[data-toggle="popover"]').popover()
})
$('.checkstiempo').change(function(event) {
    var habilita=$(this).is(':checked');
    var filatiempo=$(this).closest(".row");
    filatiempo.find('.inputstiempo').prop("disabled", !habilita);
    
});

$('.clcheckmostrar').bootstrapToggle();
</script>
<script>

$('#vtextdetalle').summernote({
    height: 200,
    minHeight: 200, // set minimum height of editor
    maxHeight: 800, // set maximum height of editor
    focus: true,
    toolbar: [
        // [groupName, [list of button]]
        ['style', ['bold', 'italic', 'underline', 'clear', 'style']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['list', ['ul', 'ol']],
        ['para', ['paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture']],
        ['otros', ['help', 'codeview']],
    ],
    dialogsFade: true,
    callbacks: {
        onImageUpload: function(image) {
            var txtrt = $(this);
            uploadImage(image[0], txtrt);
        },
        onMediaDelete: function(target) {
            deleteFile(target[0].src);
        }
    }
});
$.summernote.dom.emptyPara = "<div><br></div>"

function uploadImage(image, tarea) {
    var data = new FormData();
    data.append("file", image);
    $.ajax({
        url: base_url + "virtualalumno/uploadimages",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "post",
        success: function(url) {
            var image = $('<img>').attr('src', base_url + url);
            tarea.summernote("insertNode", image[0]);
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function deleteFile(src) {
    $.ajax({
        data: {
            src: src
        },
        type: "POST",
        url: base_url + "virtualalumno/delete_file", // replace with your url
        cache: false,
        success: function(resp) {
            console.log(resp);
        }
    });
}


$("#vw_cuge_btn-guardarcuestionario").click(function(event) {
    $('#divcard-body').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    fdata=$("#frm-insertupdate").serializeArray();
    var html = $('#vtextdetalle').summernote('code');
    fdata.push({name: 'textdetalle', value: html});
    $.ajax({
        url: base_url + 'cuestionario_general/fn_insert_update',
        type: 'POST',
        data: fdata ,
        dataType: 'json',
        success: function(e) {
            $('#divcard-body #divoverlay').remove();
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
            $('#divcard-body #divoverlay').remove();
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
</script>
   