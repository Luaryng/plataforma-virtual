<small id="fmt_conteo" class="form-text text-primary">
            
</small>
<div class="col-12 py-1" id="divdata-periodo">
	<div class="btable">
        <div class="thead col-12  d-none d-md-block">
        	<div class="row">
                <div class='col-12 col-md-3'>
                    <div class='row'>
                        <div class='col-1 col-md-2 td'>N°</div>
                        <div class='col-5 col-md-5 td'>CARNE</div>
                        <div class='col-5 col-md-5 td'>PERIODO</div>
                    </div>
                </div>
                <div class='col-12 col-md-6'>
                    <div class='row'>
                    	<div class='col-3 col-md-3 td text-center'>PROGRAMA</div>
                        <div class='col-6 col-md-6 td'>ALUMNO</div>
                        <div class='col-3 col-md-3 td'>FEC. INSC.</div>
                    </div>
                </div>
                <div class='col-12 col-md-3 text-center'>
                    <div class='row'>
                        <div class='col-6 col-md-6 td'>
                            <span>ESTADO</span>
                        </div>
                        <div class='col-6 col-md-6 td'>
                            <span></span>
                        </div>

                    </div>
                </div>
            </div>
            
        </div>
        <div class="tbody col-12" id="divcard_data_reingresos">
        	<?php
			$nro=0;
            $bgstatus = '';
			foreach ($historial as $usuario) {
				$fn="";
				$nro++;
				$nombres=$usuario->paterno.' '.$usuario->materno.', '.$usuario->nombres;
				$idins=base64url_encode($usuario->codinscripcion);
				$codperiodo=base64url_encode($usuario->codperiodo);

	        	$ciclo = $usuario->codciclo;

                if ($usuario->estado == 'POSTULA') {
                    $bgstatus = 'bg-warning';
                } else if ($usuario->estado == 'ACTIVO') {
                    $bgstatus = 'bg-success';
                }

			?>
			<div class='row rowcolor cfila' data-campania='<?php echo $usuario->idcampania ?>' data-ci="<?php echo $idins ?>" data-cp='<?php echo $usuario->codperiodo ?>' data-cic='<?php echo $ciclo ?>'>
                <div class='col-12 col-md-3'>
                    <div class='row'>
                        <div class='col-2 col-md-2 td'><?php echo $nro ?></div>
                        <div class='col-5 col-md-5 td'><?php echo $usuario->carnet ?></div>
                        <div class='col-5 col-md-5 td'><?php echo $usuario->periodo ?></div>
                    </div>
                </div>
                <div class='col-12 col-md-6'>
                    <div class='row'>
                    	<div class='col-2 col-md-3 td text-center'><?php echo $usuario->carsigla ?></div>
                        <div class='col-7 col-md-6 td'>
                        	<b class="mr-2"><?php echo ($usuario->sexo=='MASCULINO') ? '<i class="fas fa-male fa-lg text-primary"></i>':'<i class="fas fa-female  fa-lg text-danger"></i>' ?> </b>
                        	<span class="cell-alumno"><?php echo $nombres ?></span>
                        </div>
                        <div class='col-3 col-md-3 td'><?php echo date("d-m-Y", strtotime($usuario->fecinsc)); ?></div>
                    </div>
                </div>
                <div class='col-12 col-md-3 text-center'>
                    <div class='row'>
                        <div class='col-6 col-md-6 td'>
                            <span class="badge <?php echo $bgstatus ?> p-2"><?php echo $usuario->estado ?></span>
                        </div>
                        <div class='col-6 col-md-6 td'>
                            <a class="btn-anexados bg-primary py-1 px-2 rounded" data-ci="<?php echo $idins ?>" data-toggle="modal" data-target="#modal-docporanexar" title="Documentos anexados">
                                <i class="far fa-folder-open"></i>
                            </a>
                        </div>
                    </div>
                </div>
			</div>
		<?php } ?>
        </div>
    </div>

</div>

<script type="text/javascript">
    $('#modal-docporanexar').on('show.bs.modal', function (e) {
        $("#lista-ok").addClass('ocultar');
        $("#lista-no").removeClass('ocultar');
        btn= $(e.relatedTarget);
        var cins=btn.data('ci');
        $("#fdacodins").val(cins);
        var fila=btn.parents(".cfila");
        var carne=fila.find('.cell-carne').html();
        var alumno=fila.find('.cell-alumno').html();
          //$('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#frm-docanexar #spn-carne").html(carne);
        $("#frm-docanexar #spn-alumno").html(alumno);
        $('#frm-docanexar input[type=checkbox]').prop('checked', false);
        $.ajax({
            url: base_url + 'inscrito/fn_getdocanexados',
            type: 'post',
            dataType: 'json',
            data: {
                'ce-idins': cins
            },
            success: function(e) {
                //$('#divboxhistorial #divoverlay').remove();
                $("#lista-ok").removeClass('ocultar');
                $("#lista-no").addClass('ocultar');
                if (e.status == false) {
                    Swal.fire({
                        type: 'error',
                        title: 'Error!',
                        text: e.msg,
                        backdrop: false,
                    })
                } else {
                    /*$("#fm-txtidmatricula").html(e.newcod);*/
                    
                    $('#frm-docanexar input[type=checkbox]').each(function () {
                    //if (this.checked) {
                    var check=$(this);
                    var valor=check.attr('id').substring(2);
                    $.each(e.vdata, function(index, v) {
                        if (v['coddoc']==valor){
                            check.prop('checked', true);
                        }
                    });

                });
                      
                      
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                //$('#divboxhistorial #divoverlay').remove();
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    text: msgf,
                    backdrop: false,
                })
            }
        });
    })
</script>