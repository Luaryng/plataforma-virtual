<?php
  $vbaseurl=base_url();
if (count($dlibros)>0){
  $nro=0;
    foreach ($dlibros as $lbr) {
        $nro++;
        if ($lbr->link == "") { 
?>

<div class="col-sm-12 my-2 py-2 bg-lightgray border-gray ">
  <div class="row">
      <?php 
        echo '<div class="col-sm-12 mt-2">
          <i class="fa fa-book mr-1"></i><small class="badge badge-success mr-1">
          <i class="far fa-clock"></i> Físico </small><b>'.$lbr->nombre.'</b>
        </div>';
        echo '<div class="col-12 col-md-4 mt-2"><b>Autor: </b>'.$lbr->autor .'</div>
            <div class="col-md-4 col-6 mt-2"><b>Editorial: </b>'.$lbr->editorial .'</div>
            <div class="col-md-4 col-6 mt-2"><b>Año: </b>'.$lbr->anio .'</div>
            <div class="col-md-4 col-6 mt-2"><b>N° Pag.</b> '.$lbr->npag .' </div>
            <div class="col-md-4 col-6 mt-2"><b>Estado:</b> '.$lbr->estado .' </div>
            <div class="col-md-4 col-6 mt-2"><b>Situación:</b> <small class="badge bg-success"> '.$lbr->situa .' </small></div>
            <div class="col-md-4 col-6 mt-2"><b>Ubicación:</b> '.$lbr->ubic .' </div>
            <div class="col-md-2 col-12 mt-2"><button class="btn btn-sm btn-info btn-block btn_select" data-ide="'.base64url_encode($lbr->id).'" data-lib="'. $lbr->nombre .'" data-st="'. $lbr->estado .'" title="Seleccionar Ejemplar">
                    <i class="fas fa-arrow-alt-circle-right"></i> <span class="d-block d-md-none">Seleccionar </span>
                  </button></div>';
       ?>
        
  </div>
</div>
<?php } 
  }
}
else{
echo "<h5 class='ml-3 text-danger'><i class='fa fa-ban'></i> NO SE ENCONTRARON RESULTADOS</h5>";
}
?>

<script type="text/javascript">
  $('.btn_select').click(function() {
    var idej=$(this).data("ide");
    var libr=$(this).data("lib");
    var est = $(this).data('st');
    $('#fictxtcodejm').val(idej);
    $('#fictxtlibro').html(libr);
    $('#fictxtestado').val(est);
    $('#modupdatlibro').modal('hide');
    $('#modupdatlibro').find('#divhistorial_libros').empty();
    $('#txtnomlibro').val("");
    $('#btn_prestamo').prop('disabled', false);
  });
  
</script>