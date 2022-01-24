<style>
  /*.note-group-select-from-files {
  display: none;
}*/
</style>
<?php $vbaseurl=base_url();

 ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.css">
<link href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.css">
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
                    <a href="<?php echo $vbaseurl ?>docente/mis-cursos"><i class="fas fa-compass"></i> Mis cursos</a>
                </li>
                
                <li class="breadcrumb-item">
                    
                    <a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $curso->unidad ?>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    
                    <a href="<?php echo $vbaseurl.'curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>">Aula Virtual
                    </a>
                </li>
              <li class="breadcrumb-item active">Material</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div id="divcard-evaluaciones" class="card card-success">
            
            <div class="card-header with-border">
                <div class="row">
                    <div id="divperiodo" class="col-12 col-md-4">Periodo: <b><?php echo $curso->periodo; ?></b></div>
                    <div id="divcarrera" class="col-12 col-md-8">Carrera: <b><?php echo $curso->carrera; ?></b></div>
                    <div id="divciclo" class="col-6 col-md-4">Ciclo: <b><?php echo $curso->codciclo; ?></b></div>
                    <div id="divturno" class="col-6 col-md-4">Turno: <b><?php echo $curso->codturno; ?></b></div>
                    <div id="divseccion" class="col-6 col-md-4">Sección: <b><?php echo $curso->codseccion.$curso->division; ?></b></div>
                </div>
            </div>
        </div>
        <form id='frm-insertupdate' name='frm-insertupdate'   method='post' accept-charset='utf-8'>
            <?php 
                $norden=1;
                if (isset($_GET['num'])){
                    $norden=$_GET['num'];
                }
                $vpadre=0;
                if (isset($_GET['pad'])){
                    $vpadre=$_GET['pad'];
                }
                $vid="-1";
                if (isset($mat->codigo))  $vid=$mat->codigo;
             ?>
            <!-- @vvirt_nombre, @vvirt_tipo, @vvirt_id_padre, @vvirt_link, @vvirt_vence, @vvirt_detalle, @vvirt_norden, @vcodigocarga, @vcodigosubseccion-->
            
            <input id="vdivision" name="vdivision" type="hidden" value="<?php echo  base64url_encode($curso->division) ?>">
            <input id="vidcurso" name="vidcurso" type="hidden" value="<?php echo  base64url_encode($curso->codcarga) ?>">
            <input id="vorden" name="vorden" type="hidden" value="<?php echo $norden ?>">
            <input id="vidpadre" name="vidpadre" type="hidden" value="<?php echo  $vpadre ?>">
            <input id="vid" name="vid" type="hidden" value="<?php echo  $vid ?>">
            <?php $vnomcurso=$curso->unidad." ".$curso->codseccion.$curso->division ?>
            <input id="vnomcurso" name="vnomcurso" type="hidden" value="<?php echo $vnomcurso ?>">
            <div class="card" id="divcard-body">

               <?php echo $agregar ?>
                
            </div>
        </form>
    </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.js"></script>

<script src="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.js"></script>

<script src="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery.ui.touch-punch.min.js"></script>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>

<script>

var vccaj = '<?php echo $curso->codcarga ?>';
var vsscj = '<?php echo $curso->division ?>';
var vccajcode = '<?php echo $vcarga ?>';
var vsscjcode = '<?php echo $vdivision ?>';

var varchivos = <?php echo json_encode($varchivos) ?>;
$('.clcheckmostrar').bootstrapToggle();
</script>
<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/virtual-v6.js"></script>
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
        ['insert', ['link', 'picture', 'video']],
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

</script>
   