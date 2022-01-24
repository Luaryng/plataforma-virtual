<div class="content-wrapper">
  <div class="modal fade" id="modagregejmp" tabindex="-1" role="dialog" aria-labelledby="modagregejmp" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content" id="divmodalnew">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">AGREGAR EJEMPLAR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="divejemplnew">
                  <form id="frm_ejemplnew" action="#" method="post" accept-charset='utf-8'>
                    <div class="row mt-2">
                      <input type="hidden" name="txtcontreg" id="txtcontreg" value="1">
                      <input type="hidden" name="txtidlibro" id="txtidlibro" value="<?php echo $codigolib; ?>">
                      <div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
                            <select data-currentvalue='' data-cnt="" class="form-control" id="fictiponew" name="fictiponew" placeholder="Tipo" required >
                                <option value="0">Selecciona Tipo</option>
                                <option value="Virtual">Virtual</option>
                                <option value="Fisico">Físico</option>
                            </select>
                            <label for="fictiponew"> Tipo</label>
                          </div>
                          
                          <div class="form-group has-float-label col-12 col-xs-12 col-sm-6 d-none" id="divcar_virtualnew">
                        <input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxtlink1" name="fictxtlink1" type="text" placeholder="Link" />
                        <label for="fictxtlink1">Link</label>
                      </div>
                    </div>
                    <div class="row mt-1 d-none" id="divcar_fisiconew">
                      <div class="form-group has-float-label col-12 col-xs-12 col-sm-3">
                        <input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxtnpag1" name="fictxtnpag1" type="text" placeholder="N° Páginas" />
                        <label for="fictxtnpag1">N° Páginas</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
                            <select data-currentvalue='' class="form-control" id="ficestado1" name="ficestado1" placeholder="Estado" required >
                                <option value="0">Selecciona Estado</option>
                                <option value="BUENO">BUENO</option>
                                <option value="MALO">MALO</option>
                                <option value="REGULAR">REGULAR</option>
                            </select>
                            <label for="ficestado1"> Estado</label>
                          </div>
                          <div class="form-group has-float-label col-12 col-xs-12 col-sm-5">
                        <input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxtubica1" name="fictxtubica1" type="text" placeholder="Ubicación" />
                        <label for="fictxtubica1">Ubicación</label>
                      </div>
                    </div>
                    <div class="row mt-1 d-none" id="divcar_fisiconew2">
                      <div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
                            <select data-currentvalue='' class="form-control" id="ficsituacion1" name="ficsituacion1" placeholder="Situación" required >
                                <option value="0">Selecciona Situación</option>
                                <option value="PERDIDO">PERDIDO</option>
                                <option value="PRESTADO">PRESTADO</option>
                                <option value="DISPONIBLE">DISPONIBLE</option>
                                <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                            </select>
                            <label for="ficsituacion1"> Situación</label>
                          </div>
                          <div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
                            <select data-currentvalue='' class="form-control" id="ficproced1" name="ficproced1" placeholder="Procedencia" required >
                                <option value="0">Selecciona Procedencia</option>
                                <option value="RECURSOS PROPIOS">RECURSOS PROPIOS</option>
                                <option value="CANON">CANON</option>
                                <option value="DONACIÓN">DONACIÓN</option>
                            </select>
                            <label for="ficproced1"> Procedencia</label>
                          </div>
                          <div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
                            <input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxtfecha1" name="fictxtfecha1" type="date" placeholder="Fecha Compra" />
                            <label for="fictxtfecha1">Fecha Compra</label>
                          </div>
                    </div>
                    <div class="row mt-1 d-none" id="divcar_fisiconew3">
                      <div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
                              <input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxtndoc1" name="fictxtndoc1" type="text" placeholder="Nro Documento" />
                        <label for="fictxtndoc1">Nro Documento</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
                              <input data-currentvalue='' class="form-control text-uppercase" id="fictxtprecio1" name="fictxtprecio1" type="number" step="0.01" value="0.00" placeholder="Precio Unit" />
                        <label for="fictxtprecio1">Precio Unit</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
                              <input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxtordcom1" name="fictxtordcom1" type="text" placeholder="Orden Compra" />
                        <label for="fictxtordcom1">Orden Compra</label>
                            </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-12">
                          <div id="divmsgejmpnew" class="float-left">
                          
                        </div>
                        </div>
                    </div>
                  </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnnew_ejmp" class="btn btn-primary">Guardar</button>
            </div>
          </div>
      </div>
    </div>
  <div class="modal fade" id="modupdateejmp" tabindex="-1" role="dialog" aria-labelledby="modupdateejmp" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content" id="divmodalupd">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">EDITAR EJEMPLAR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="divejemplup">
              
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="ejbtn-guardar" class="btn btn-primary">Guardar</button>
            </div>
          </div>
      </div>
    </div>
    <div class="modal fade" id="modal-danger-ejm" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-danger">
          <div class="modal-header">
            <h4 class="modal-title">Alerta de Eliminación</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <h4>Esta seguro de eliminar este libro?....!</h4>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-outline-light" id="btnelimejm" data-idejm=''>Eliminar</button>
          </div>
        </div>
      </div>
    </div>

  <section id="s-cargado" class="content pt-2">
    <div id="divcard-ejemplarup" class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-search mr-1"></i> Ejemplares del libro <b><?php echo $nomlib ?></b></h3>
        <div class="card-tools">
          <a class="btn btn-default btn-sm" data-toggle="modal" data-target="#modagregejmp"><i class="fas fa-plus"></i> Agregar</a>
        </div>
      </div>
      <div class="card-body">
        <?php if (count($dejemp)>0){ ?>
        <div id="divtabl-libros" class="col-xs-12 col-md-12 neo-table">
          <div class="col-md-12 header d-none d-md-block">
            <div class="row">
              <div class="col-xs-1 col-md-1 cell hidden-xs">N°</div>
              <div class="col-xs-6 col-md-2 cell">Link</div>
              <div class="col-xs-6 col-md-1 cell">Páginas</div>
              <div class="col-xs-2 col-md-1 cell">Estado</div>
              <div class="col-xs-2 col-md-2 cell">Ubicación</div>
              <div class="col-xs-2 col-md-2 cell">Situación</div>
              <div class="col-xs-2 col-md-1 cell">Físico</div>
              <div class="col-xs-2 col-md-1 cell text-center"></div>
              <div class="col-xs-2 col-md-1 cell text-center"></div>
            </div>
          </div>
          <div class="col-md-12 body">
            <?php
            $nro=0;
            foreach ($dejemp as $ejmp) {
                $nro++;
            ?>
            <div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
              <div class="col-xs-12 col-md-3 group">
                <div class="col-sm-4 col-md-2 cell">
                  <span><?php echo $nro ;?></span>
                </div>
                <div class="col-sm-8 col-md-10 cell">
                  <span>
                    <?php if (strlen($ejmp->link)>=25) { 
                          echo substr($ejmp->link, 0,25)."...";
                          } else {
                            echo $ejmp->link;
                          }
                    ?>
                  </span>
                </div>
              </div>
              <div class="col-xs-12 col-md-4 group">
                <div class="col-sm-2 col-md-2 cell">
                  <span><?php echo $ejmp->pag ;?></span>
                </div>
                <div class="col-sm-5 col-md-4 cell">
                  <span><?php echo $ejmp->est ?></span>
                </div>
                <div class="col-sm-5 col-md-6 cell">
                  <span><?php echo $ejmp->ubic ?></span>
                </div>
              </div>
              <div class="col-xs-12 col-md-3 group">
                <div class="col-sm-6 col-md-8 cell">
                  <span><?php echo $ejmp->situa ;?></span>
                </div>
                <div class="col-sm-6 col-md-4 cell">
                  <span><?php echo $ejmp->fisc ;?></span>
                </div>
              </div>
              <div class="col-xs-12 col-md-2 group">
                <div class="col-xs-12 col-md-6 cell text-center">
                  <?php if (getPermitido("34")=='SI') { ?>
                  <button class="btn btn-sm btn-info btn-block" href="#" onclick="viewupdateejm('<?php echo base64url_encode($ejmp->codigo) ?>')" title="Editar Ejemplar">
                    <i class="fas fa-pencil-alt"></i> <span class="d-block d-md-none">Editar </span>
                  </button>
                <?php } ?>
                </div>
                <div class="col-xs-6 col-md-6 cell text-center">
                  <?php if (getPermitido("35")=='SI') { ?>
                  <a class="btn btn-sm btn-danger btn-block" href="#" data-toggle="modal" data-target="#modal-danger-ejm" data-idejm="<?php echo base64url_encode($ejmp->codigo) ?>" title="Eliminar ejemplar">
                    <i class="fas fa-trash-alt"></i><span class="d-block d-md-none">Eliminar</span>
                  </a>
                <?php } ?>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
        <?php } else {
          echo "<h5 class='ml-3 text-danger'><i class='fa fa-ban'></i> NO HAY EJEMPLARES AGREGADOS A ESTE LIBRO</h5>";
        } ?>
      </div>
      <div class="card-footer d-none" id="divmsgelm">
        
      </div>
    </div>
  </section>
</div>


<script type="text/javascript">
  function viewupdateejm(idejm){
  $('#divcard-ejemplarup').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $("#divejemplup").html("");
      $.ajax({
          url: base_url + "biblioteca/vwmostrar_ejemplaresxcodigo",
          type: 'post',
        dataType: "json",
          data: {txtcodejm: idejm},
          success: function(e) {
            $('#divcard-ejemplarup #divoverlay').remove();
            $("#divejemplup").html(e.ejmupd);
            $("#modupdateejmp").modal("show");

            var tip = $('#fictipo').val();
            if (tip == 'Virtual') {
              $('#divcar_virtual').removeClass('d-none');
              $('#divcar_fisico').addClass('d-none');
              $('#divcar_fisico2').addClass('d-none');
              $('#divcar_fisico3').addClass('d-none');
            } else if (tip == "Fisico") {
              $('#divcar_virtual').addClass('d-none');
              $('#divcar_fisico').removeClass('d-none');
              $('#divcar_fisico2').removeClass('d-none');
              $('#divcar_fisico3').removeClass('d-none');
            }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'div');
              $('#divcard-ejemplarup #divoverlay').remove();
              $("#modupdateejmp modal-body").html(msgf);
          } 
      });
    return false;
}

$('#ejbtn-guardar').click(function() {
  $('#frm_ejemplupd input,select').removeClass('is-invalid');
    $('#frm_ejemplupd .invalid-feedback').remove();
    $('#divmodalupd').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'biblioteca/fn_update_ejemplares',
        type: 'post',
        dataType: 'json',
        data: $('#frm_ejemplupd').serialize(),
        success: function(e) {
            $('#divmodalupd #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
              $('#ejbtn-guardar').prop('disabled', true);
                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                // $('#divmsgejmp').html(msgf);
                
                $('#modupdateejmp').modal('hide');
                Swal.fire({
                    title: e.msg,
                    // text: "Por favor Agregue Ejemplares!",
                    type: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                  if (result.value) {
                    location.reload();
                  }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divmodalupd #divoverlay').remove();
            $('#divmsgejmp').show();
            $('#divmsgejmp').html(msgf);
        }
    });
    return false;
});

$('#modal-danger-ejm').on('show.bs.modal', function (e) {
    var rel=$(e.relatedTarget);
    $("#btnelimejm").data('idejm', rel.data("idejm"));
});

$('#btnelimejm').click(function() {
    var idejm=$(this).data("idejm");
    $.ajax({
        url: base_url + 'biblioteca/fneliminar_ejemplar',
        type: 'post',
        dataType: 'json',
        data: {idejmp:idejm},
        success: function(e) {
          $('#divmsgelm').removeClass('d-none');
            if (e.status == false) {
                $('#divmsgelm').html('<span class="text-danger"><i class="fa fa-close"></i> No se pudo eliminar</span>');
            } else {
                // $('#btnelimlib').prop('disabled', true);
                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                // $('#divmsgelm').html(msgf);
                $('#modal-danger-ejm').modal('hide');
                Swal.fire({
                    title: e.msg,
                    // text: "Por favor Agregue Ejemplares!",
                    type: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                  if (result.value) {
                    location.reload();
                  }
                })
                
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard-ejemplarup #divoverlay').remove();
            $('#divmsgelm').show();
            $('#divmsgelm').html(msgf);
        }
    });
});

$('#frm_ejemplnew input,select').change(function(event) {
    if ($(this).attr('id') == 'fictiponew') {
      $('#divmodalnew').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');        
      var tip = $(this).val();
      if (tip == 'Virtual') {
          $('#divmodalnew #divoverlay').remove();
          $('#divcar_virtualnew').removeClass('d-none');
          $('#divcar_fisiconew').addClass('d-none');
          $('#divcar_fisiconew2').addClass('d-none');
          $('#divcar_fisiconew3').addClass('d-none');
      } else if (tip == 'Fisico') {
          $('#divmodalnew #divoverlay').remove();
          $('#divcar_virtualnew').addClass('d-none');
          $('#divcar_fisiconew').removeClass('d-none');
          $('#divcar_fisiconew2').removeClass('d-none');
          $('#divcar_fisiconew3').removeClass('d-none');
      }
    }
  });
  $('#btnnew_ejmp').click(function(event) {
    $('#frm_ejemplnew input,select').removeClass('is-invalid');
    $('#frm_ejemplnew .invalid-feedback').remove();
    $('#divmodalnew').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'biblioteca/fn_insert_ejemplares',
        type: 'post',
        dataType: 'json',
        data: $('#frm_ejemplnew').serialize(),
        success: function(e) {
            $('#divmodalnew #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
              $('#btnnew_ejmp').prop('disabled', true);
                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                // $('#divmsgejmpnew').html(msgf);
                
                $('#modagregejmp').modal('hide');
                Swal.fire({
                    title: e.msg,
                    // text: "Por favor Agregue Ejemplares!",
                    type: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                  if (result.value) {
                    location.reload();
                  }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divmodalnew #divoverlay').remove();
            $('#divmsgejmpnew').show();
            $('#divmsgejmpnew').html(msgf);
        }
    });
    return false;
  });
</script>