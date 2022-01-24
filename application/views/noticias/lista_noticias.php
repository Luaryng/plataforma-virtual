<?php
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
	<!-- Modal Eliminar -->
	<div class="modal fade" id="modeletenot" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog modal-dialog-centered" role="document">
	        <div class="modal-content bg-danger">
	            <div class="modal-header">
		            <h4 class="modal-title">Alerta de Eliminación</h4>
	    	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        		    <span aria-hidden="true">×</span>
	              	</button>
	            </div>
	            <div class="modal-body">
	            	<h4>Esta seguro de eliminar esta Noticia....!</h4>
	            </div>
	            <div class="modal-footer justify-content-between">
	              	<button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
	              	<button type="button" class="btn btn-outline-light" id="btnelimnot" data-idnot=''>Eliminar</button>
	            </div>
	        </div>
	    </div>
	</div>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_noticias" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de Noticias</h3>
		    	<div class="no-padding card-tools">
                	<a href="<?php echo $vbaseurl.'portal-web/noticias/agregar' ?>" class="btn btn-sm btn-default" id="btn_new"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
		    </div>
		    <div class="card-body">
		    	<?php $this->load->view('noticias/noticiadts', $noticias);?>
		    </div>
		</div>
	</section>
</div>

<script type="text/javascript">

$('#modeletenot').on('show.bs.modal', function (e) {
    var rel=$(e.relatedTarget);
    $("#btnelimnot").data('idnot', rel.data("idnot"));
});

$('#btnelimnot').click(function() {
    var idno=$(this).data("idnot");
    $.ajax({
        url: base_url + 'noticias/fneliminar_noticia',
        type: 'post',
        dataType: 'json',
        data: {idnoti:idno},
        success: function(e) {

            if (e.status == false) {
            	Swal.fire({
            		title: 'No se Pudo Eliminar esta Noticia',
            		type: 'error',
            	}).then((result) => {
                  if (result.value) {
                    $('#modeletenot').modal('hide');
                  }
                })
            } else {
                $('#btnelimnot').prop('disabled', true);
                $('#modeletenot').modal('hide');
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                }).then((result) => {
                  if (result.value) {
                    location.reload();
                  }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard_noticias #divoverlay').remove();
            $('#divmsgcamp').show();
            $('#divmsgcamp').html(msgf);
        }
    });
});
</script>