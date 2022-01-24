<style>
  /*.note-group-select-from-files {
  display: none;
}*/
</style>
<?php 
    $vbaseurl=base_url();
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
                    <a href="<?php echo $vbaseurl ?>docente/mis-cursos"><i class="fas fas fa-caret-right"></i> Mis Unidades didácticas</a>
                </li>
                
                <li class="breadcrumb-item">
                    
                    <a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>">Panel
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
        <?php include 'vw_aula_encabezado.php'; ?>
        <form id='frm-insertupdate' name='frm-insertupdate'   method='post' accept-charset='utf-8'>
            
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
<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/virtual-v9.js"></script>
<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/virtual_summernote-v1.js"></script>

   