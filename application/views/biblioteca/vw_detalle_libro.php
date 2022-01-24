<?php
  $vbaseurl=base_url();
if (count($dlibros)>0){
  
?>
<div id="divtabl-libros" class="col-xs-12 col-md-12 neo-table">
  <div class="col-md-12 header d-none d-md-block">
    <div class="row">
      <div class="col-xs-1 col-md-1 cell hidden-xs">Nro</div>
      <div class="col-xs-6 col-md-3 cell">Libro</div>
      <div class="col-xs-6 col-md-2 cell">Autor</div>
      <div class="col-xs-2 col-md-2 cell">Editorial</div>
      <div class="col-xs-2 col-md-1 cell">Año</div>
      <div class="col-xs-2 col-md-1 cell">Ejemplares</div>
      <div class="col-xs-2 col-md-2 cell text-center"></div>
    </div>
  </div>
  <div class="col-md-12 body">
    <?php
    $nro=0;
    foreach ($dlibros as $lbr) {
        $nro++;
    ?>
    <div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
      <div class="col-sm-12 col-md-4 group">
        <div class="col-sm-3 col-md-3 cell">
          <span><?php echo $nro ;?></span>
        </div>
        <div class="col-sm-9 col-md-9 cell">
          <span><?php echo $lbr->nombre ?></span>
        </div>
      </div>
      <!---->
      <div class="col-sm-12 col-md-5 group">
        <div class="col-sm-3 col-md-5 cell">
          <span><?php echo $lbr->aunom ?></span>
        </div>
        <div class="col-sm-2 col-md-5 cell">
          <span><?php echo $lbr->ednom ?></span>
        </div>
        <div class="col-sm-1 col-md-2 cell">
          <span><?php echo $lbr->anio ?></span>
        </div>
      </div>
      
      <div class="col-sm-12 col-md-1 group">
        <div class="col-xs-6 col-md-12 cell text-center">
          <a class="btn btn-sm btn-success btn-block" href="<?php echo $vbaseurl ?>biblioteca/ejemplares?code=<?php echo base64url_encode($lbr->codigo) ?>&book=<?php echo base64url_encode($lbr->nombre) ?>" title="Ver ejemplares">
            <i class=""><?php echo $lbr->nroejem ?></i> <span class="d-block d-md-none">Ejemplares </span>
          </a>
        </div>
      </div>
      <div class="col-xs-12 col-md-2 group">
        <div class="col-sm-6 col-md-6 cell text-center">
          <?php if (getPermitido("32")=='SI') { ?>
          <button class="btn btn-sm btn-info btn-block" href="#" onclick="viewupdatelib('<?php echo base64url_encode($lbr->codigo) ?>')" title="Editar Libro">
            <i class="fas fa-pencil-alt"></i> <span class="d-block d-md-none">Editar </span>
          </button>
          <?php } ?>
        </div>
        <div class="col-sm-6 col-md-6 cell text-center">
          <?php if (getPermitido("33")=='SI') { ?>
          <a class="btn btn-sm btn-danger btn-block" href="#" data-toggle="modal" data-target="#modal-danger-lib" data-idlib="<?php echo base64url_encode($lbr->codigo) ?>" title="Eliminar libro">
            <i class="fas fa-trash-alt"></i> <span class="d-block d-md-none">Eliminar</span>
          </a>
        <?php } ?>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>

    <?php
}
else{
echo "<h5 class='ml-3 text-danger'><i class='fa fa-ban'></i> NO SE ENCONTRARON RESULTADOS</h5>";
}
?>

