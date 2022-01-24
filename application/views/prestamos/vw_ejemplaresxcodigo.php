<div id="divtabl-libros" class="col-xs-12 col-md-12 neo-table mt-2">
  <div class="col-md-12 header d-none d-md-block">
    <div class="row">
      <div class="col-xs-1 col-md-1 cell hidden-xs"><b>Nro</b></div>
      <div class="col-xs-6 col-md-2 cell"><b>Páginas</b></div>
      <div class="col-xs-2 col-md-2 cell"><b>Estado</b></div>
      <div class="col-xs-2 col-md-3 cell"><b>Ubicación</b></div>
      <div class="col-xs-2 col-md-3 cell"><b>Situación</b></div>
      <div class="col-xs-2 col-md-1 cell text-center"></div>
    </div>
  </div>
  <div class="col-md-12 body">
    <?php
            $nro=0;
            foreach ($dejempl as $ejmp) {
                
                if ($ejmp->link == "") {
                  $nro++;
            ?>
            <div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
              <div class="col-xs-12 col-md-3 group">
                <div class="col-sm-4 col-md-4 cell">
                  <span><?php echo $nro ;?></span>
                </div>
                <div class="col-sm-4 col-md-8 cell">
                  <span><?php echo $ejmp->pag ;?></span>
                </div>
              </div>
              <div class="col-xs-12 col-md-8 group">
                <div class="col-sm-2 col-md-3 cell">
                  <?php if ($ejmp->est == "BUENO") {
                    $bgcolor = 'bg-success';
                  }else if ($ejmp->est == "REGULAR") {
                    $bgcolor = 'bg-warning';
                  }else {
                    $bgcolor = 'bg-danger';
                  } ?>
                  <span class="badge <?php echo $bgcolor ;?>"><?php echo $ejmp->est ;?></span>
                </div>
                <div class="col-sm-5 col-md-5 cell">
                  <span><?php echo $ejmp->ubic ?></span>
                </div>
                <div class="col-sm-5 col-md-4 cell">
                  <span><?php echo $ejmp->situa ?></span>
                </div>
              </div>
              <div class="col-xs-12 col-md-1 group">
                <div class="col-sm-6 col-md-12 cell">
                  <?php if ($ejmp->situa == 'DISPONIBLE') { ?>
                  <button class="btn btn-sm btn-info btn-block btn_select" data-ide='<?php echo base64url_encode($ejmp->codigo) ;?>' data-lib='<?php echo $ejmp->nombre ?>' data-st='<?php echo $ejmp->est ?>' title="Seleccionar Ejemplar">
                    <i class="fas fa-arrow-alt-circle-right"></i> <span class="d-block d-md-none">Seleccionar </span>
                  </button>
                  <?php } ?>
                </div>
            </div>
          </div>
            <?php 
            }
          } ?>
  </div>
</div>

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