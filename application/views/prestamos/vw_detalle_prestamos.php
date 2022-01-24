<?php if (count($dejempst) > 0) { 
      $nro=0;
      foreach ($dejempst as $ejmp) {
        $fec_p = date("d-m-Y",strtotime($ejmp->fecpres));
        $fec_f = date("d-m-Y",strtotime($ejmp->feclim));
        if ($ejmp->fecdev != NULL) {
          $fec_dv = date("d-m-Y",strtotime($ejmp->fecdev));
          $btnok = '<button class="btn btn-block btn-success"><i class="fas fa-check"></i><span class="d-block d-md-none">Entregado </span></button>';
        }else {
          $fec_dv = '';
          $btnok = '<button title="Pendiente" class="btn btn-block btn-danger btn_devolver" data-id="'.base64url_encode($ejmp->idpre).'"><i class="fas fa-exclamation-triangle"></i><span class="d-block d-md-none">pendiente </span></button>';
        }

        if ($ejmp->estado == "BUENO") {
            $bgcolor = 'bg-success';
          }else if ($ejmp->estado == "REGULAR") {
            $bgcolor = 'bg-warning';
          }else {
            $bgcolor = 'bg-danger';
          }
        $nro++;
      ?>
      <div class="col-sm-12 my-2 py-2 bg-lightgray border-gray ">
        <div class="row">
          <div class="col-12 col-md-12 mt-2"><b><i class="fas fa-book-open"></i> <?php echo $ejmp->nombre ?></b></div>
          <div class="col-6 col-md-6 mt-2"><b>Estado: </b><span class="badge <?php echo $bgcolor ;?>"><?php echo $ejmp->estado ;?></span></div>
          <div class="col-md-6 col-6 mt-2"><b>Fecprestamo: </b><?php echo $fec_p ?></div>
          <div class="col-md-6 col-6 mt-2"><b>Feclimite: </b><?php echo $fec_f ?></div>
          <div class="col-md-6 col-6 mt-2"><b>Fecdevolución: </b><?php echo $fec_dv ?></div>
          <div class="col-md-6 col-6 mt-2"><b>Obsentrega: </b><?php echo $ejmp->obsent ?></div>
          <div class="col-md-6 col-6 mt-2"><b>Obsdevolucion: </b><?php echo $ejmp->obsdev ?></div>
          <div class="col-md-3 col-12 mt-2"><?php echo $btnok ?></div>
        </div>
      </div>
<?php } 
} else {
  echo '<h5 class="text-danger">No Tiene Historial de Prestamos...!</h5>';
} ?>

<script type="text/javascript">
  $('.btn_devolver').click(function(event) {
  var cod=$(this).data("id");
  $('#divcard_devolucion').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $("#divprestamosupdev").html("");
      $.ajax({
          url: base_url + "prestamos/vwmostrar_prestamosxcodigo",
          type: 'post',
        dataType: "json",
          data: {txtcodigo: cod},
          success: function(e) {
            $('#divcard_devolucion #divoverlay').remove();
            $("#divprestamosupdev").html(e.prestd);
            $("#modal_devolver").modal("show");
            $("#modal_prestamos").modal("hide");
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'div');
              $('#divcard_devolucion #divoverlay').remove();
              $("#modal_devolver modal-body").html(msgf);
          } 
      });
    return false;
  });
</script>