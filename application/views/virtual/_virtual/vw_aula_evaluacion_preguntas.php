<?php $vbaseurl=base_url();
function getIconoMaterial($nombre){
$icon="<i class='fas fa-download mr-2'></i>";
$ext          = explode(".", $nombre);
$exten    = end($ext);
if ($exten=="pdf"){
$icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_pdf.png' alt='PDF'>";
}
else if(($exten=="mp4")||$exten=="mpg"){
$icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_vdo.png' alt='VÍDEO'>";
}
else if(($exten=="jpg")||$exten=="png"){
$icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_img.png' alt='IMAGEN'>";
}
else if(($exten=="doc")||$exten=="docx"){
$icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_word.png' alt='WORD'>";
}
return $icon;
}
?>
<div class="content-wrapper">
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
                            <a href="<?php echo $vbaseurl ?>docnete/mis-cursos"><i class="fas fa-compass"></i> Mis cursos</a>
                        </li>
                        <li class="breadcrumb-item">
                            
                            <a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $curso->unidad ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            
                            <a href="<?php echo $vbaseurl.'curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>">Aula Virtual
                            </a>
                        </li>
                        
                        <li class="breadcrumb-item active">Tarea</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div id="divcard-evaluaciones" class="card card-success">
            
            <div class="card-header">
                <h3 class="card-title text-bold"><a href="#">Tarea</a></h3>
            </div>
            <div class="card-header with-border bg-light">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <span class="col-4">Periodo:</span>
                            <span id="divperiodo" class="col-8"><b><?php echo $curso->periodo; ?></b></span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <span class="col-4 col-md-3">Prog. Académico:</span>
                            <span id="divcarrera" class="col-8 col-md-9"><b><?php echo $curso->carrera; ?></b></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <span class="col-4">Ciclo:</span>
                            <span id="divciclo" class="col-8"><b><?php echo $curso->codciclo; ?></b></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="row">
                            <span class="col-4 col-md-6">Turno:</span>
                            <span id="divturno" class="col-8 col-md-6"><b><?php echo $curso->codturno; ?></b></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <span class="col-4">Sección:</span>
                            <span id="divseccion" class="col-8"><b><?php echo $curso->codseccion.$curso->division; ?></b></span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <span class="col-4 col-md-2">Docente:</span>
                            <span id="divdocente" class="col-8 col-md-10"><b><?php echo "$curso->docpaterno $curso->docmaterno $curso->docnombres"; ?></b></span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <span class="col-4 col-md-2">Correo:</span>
                            <span id="divdocente" class="col-8 col-md-10"><b><?php echo "$curso->docemail"; ?></b></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form id='frm-insertupdate' name='frm-insertupdate'   method='post' accept-charset='utf-8'>
            <!-- @vvirt_nombre, @vvirt_tipo, @vvirt_id_padre, @vvirt_link, @vvirt_vence, @vvirt_detalle, @vvirt_norden, @vcodigocarga, @vcodigosubseccion-->
            
            <input id="vdivision" name="vdivision" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->division) ?>">
            <input id="vidcurso" name="vidcurso" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->codcarga) ?>">
            <input id="vidmaterial" name="vidmaterial" type="hidden" class="form-control" value="<?php echo base64url_encode($mat->codigo) ?>">
            
            <div class="card border-light">
                <?php
                
                $nombre="";
                $fvence="";
               
                $finicia="";
                $ptsmax=20;
                if (isset($mat->nombre))  $nombre=$mat->nombre;
                if (isset($mat->vence))  $fvence=$mat->vence;
                if (isset($mat->inicia))  $finicia=$mat->inicia;
                if (isset($mat->ptsmax))  $ptsmax=$mat->ptsmax;
                

                date_default_timezone_set('America/Lima');
                $fechav = "Sin límite";
                $horav = "";
                if ($fvence!=""){
                $fechav = fechaCastellano($fvence);
                $horav = date('h:i a',strtotime($fvence));
                }
                $fechai = "";
                $horai = "";
                $tiniciar=true;
                if ($finicia!=""){
                $fechai = fechaCastellano($finicia);
                $horai = date('h:i a',strtotime($finicia));
                $tiniciar=false;
                if (strtotime($finicia)<time()) $tiniciar=true;
                }
                $letraopciones=array("a","b","c","d","e","f","g","h");
                ?>
                <div class="card-header border px-2 px-sm-3">
                    <h3 class="card-title text-bold"> <?php echo $nombre ?></h3>
                    Vence: <?php echo $fechav." - ".$horav ?>
                     <div class="card-tools">
                      <a id="btn-apregunta" href="#" class="btn btn-primary">+?</a>
                    </div>
                </div>
            </div>
                
            <div class="card border-light">
                <div class="card-body px-1 px-sm-3">
                    
                    <div class="row ocultar">
                        <div class="col-6 col-sm-2 margin-top-5px">
                            <label for="pregpos" class="form-control-label">Posición</label>
                            <input type="number" id="pregpos" name="pregpos" min="1" class="form-control" >
                        </div>
                    </div>
                    <div class="row text-sm">
                        <div class="col-12 col-sm-4 margin-top-5px">
                            <label for="pregcbtipo" class="form-control-label">Tipo de pregunta</label>
                            <select id="pregcbtipo" name="pregcbtipo" class="form-control" title="Selecciona" required onchange="changeCbTipPreg();">
                                <option data-idtipreg="0" data-nroalterna="0" >Seleccionar</option>
                                <?php foreach($tppreguntas as $pr){ ?>
                                <option data-idtipreg="<?php echo $pr->codtipo;?>" data-nroalterna="<?php echo $pr->nroopc;?>" ><?php echo $pr->tipo;?></option>
                                <?php } ?>
                            </select>
                        </div>
                       <div class="col-6 col-sm-2 margin-top-5px">
                            <label for="pregcbpenalvacia" class="form-control-label">Obligatorio</label>
                            <select id="pregcbpenalvacia" name="pregcbpenalvacia" class="form-control" title="Responde">
                                <option data-penalvacia="SI">SI</option>
                                <option data-penalvacia="NO">NO</option>
                            </select>
                        </div>
                        <div class="col-6 col-sm-2 margin-top-5px">
                            <label for="pregvalor" class="form-control-label">Valor</label>
                            <input type="number" id="pregvalor" name="pregvalor" min="1" class="form-control"
                            value="1">
                        </div>
                        <div class="col-6 col-sm-2 margin-top-5px">
                            <label for="pregpuntajeerror" class="form-control-label">Valor Error</label>
                            <input type="number" id="pregpuntajeerror" name="pregpuntajeerror" class="form-control" value="0" step="0.01">
                        </div>
                        
                        <div class="col-6 col-sm-2 margin-top-5px">
                            <label for="pregpuntajevacia" class="form-control-label">Valor Vacia</label>
                            <input type="number" step="0.01" id="pregpuntajevacia" name="pregpuntajevacia" class="form-control" value="0" >
                        </div>
                       
                        <div class="col-12 margin-top-5px">
                            <label for="pregenunciado" class="form-control-label">Enunciado</label>
                            <textarea id="pregenunciado" name="pregenunciado" rows="2" cols="80" class="form-control"></textarea>
                        </div>
                        <div class="col-12 margin-top-5px">
                            <!--<textarea name="txtenunciado"  id="txtenunciado"  class="form-control" rows="5" required></textarea>-->
                            <label for="pregenunciadoextra" class="form-control-label">Texto adicional</label>
                            <textarea name="pregenunciadoextra"  id="pregenunciadoextra"  class="form-control" rows="1"></textarea>
                        </div>
                    </div>
                    <!--RESPUESTAS-->
                    <div class="row text-sm">
                        <div class="opcionrpta col-12">
                            <span class="mr-2">a)</span><span>Respuesta 01</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-light">
                <div class="card-footer text-center">
                    <a href="<?php echo $vbaseurl.'curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-secondary float-left">Volver</a>
                    
                    
                    
                </div>
            </div>
            
            
        </form>
    </section>
</div>
<script>


function changeCbTipPreg() {
    var nroal = $("#pregcbtipo").find(':selected').data('nroalterna');
    $("#pregcantopc").val(nroal);
    $("#pregcantopc").focus();
}
$(".btn-calificar").click(function(event) {
    
});
$(".btn-calificar").click(function(event) {
    var btn = $(this);
    var ajcodtarea = $("#vidmaterial").val();
    var ajcodcarga = $("#vidcurso").val();
    var ajcoddivision = $("#vdivision").val();
    var ajnota = 0;
    var ajcodmiembro = btn.data('miembro');
    var ajcodentrega = btn.data('entrega');
    (async() => {
        const {
            value: vdocente
        } = await Swal.fire({
            title: 'Nota',
            input: 'text',
            inputPlaceholder: 'Ingresa un Número',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Guardar!',
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if ((value < 0) || (value > 20)) {
                        resolve('Para guardar, debes ingresar una calificación entre 0 y 20');
                    } else {
                        $.ajax({
                            url: base_url + 'virtualtarea/fn_calificar',
                            type: 'POST',
                            data: {
                                "ajcodtarea": ajcodtarea,
                                "ajcodcarga": ajcodcarga,
                                "ajcoddivision": ajcoddivision,
                                "ajnota": value,
                                "ajcodmiembro": ajcodmiembro,
                                "ajcodentrega": ajcodentrega
                            },
                            dataType: 'json',
                            success: function(e) {
                                //$('#divcard_grupo #divoverlay').remove();
                                if (e.status == true) {
                                    if (value == "") value = "Calificar "
                                    btn.html(value + '<i class="fas fa-pencil-alt ml-2"></i>');
                                    if (ajcodentrega == 0) {
                                        btn.data('entrega', e.newid);
                                    }
                                    resolve();
                                } else {
                                    resolve(e.msg);
                                }
                            },
                            error: function(jqXHR, exception) {
                                //$('#divcard_grupo #divoverlay').remove();
                                var msgf = errorAjax(jqXHR, exception, 'text');
                                $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
                            }
                        })
                    }
                })
            },
            allowOutsideClick: false
        })
    })()
});
</script>