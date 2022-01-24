<?php
	$vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">
    <div class="modal fade" id="modaddtipsed" tabindex="-1" role="dialog" aria-labelledby="modaddtipsed" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title">AGREGAR REGISTRO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addtipdsed" action="<?php echo $vbaseurl ?>tipodoc_sede/fn_insert" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-6 col-md-4">
                                <select name="fictxtsede" id="fictxtsede" class="form-control">
                                    <option value="">Seleccione item</option>
                                    <?php
                                        foreach ($sedes as $key => $value) {
                                            echo "<option value='$value->id'>$value->nombre</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtsede">Sede</label>
                            </div>
                            <div class="form-group has-float-label col-6 col-md-4">
                                <select name="fictxtdoctip" id="fictxtdoctip" class="form-control">
                                    <option value="">Seleccione item</option>
                                    <?php
                                        foreach ($tipdocm as $key => $value) {
                                            echo "<option value='$value->id'>$value->nombre</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtdoctip">Documento</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-4">
                                <input type="text" name="fictxtruc" id="fictxtruc" value="" placeholder="Ruc" class="form-control">
                                <label for="fictxtruc">Ruc</label>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="form-group has-float-label col-6 col-md-2">
                                <input type="text" name="fictxtserie" id="fictxtserie" value="" placeholder="Serie" class="form-control">
                                <label for="fictxtserie">Serie</label>
                            </div>
                            <div class="form-group has-float-label col-6 col-md-2">
                                <input type="text" name="fictxtcontador" id="fictxtcontador" value="" placeholder="Correlativo" class="form-control">
                                <label for="fictxtcontador">Correlativo</label>
                            </div>
                            <div class="form-group has-float-label col-6 col-md-2">
                                <input type="text" name="fictxtcodsunat" id="fictxtcodsunat" value="" placeholder="Código Sunat" class="form-control">
                                <label for="fictxtcodsunat">Código Sunat</label>
                            </div>
                            <div class="form-group has-float-label col-6 col-md-3">
                                <input type="text" name="fictxtoperatip" id="fictxtoperatip" value="" placeholder="Tipo Operación" class="form-control">
                                <label for="fictxtoperatip">Tipo Operación</label>
                            </div>
                            <div class="form-group has-float-label col-6 col-md-3">
                                <input type="text" name="fictxtigv" id="fictxtigv" value="" placeholder="Igv(%)" class="form-control">
                                <label for="fictxtigv">Igv(%)</label>
                            </div>
                        </div> 
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

  	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>Documento
          			<small>Sede</small></h1>
        		</div>
        
      		</div>
    	</div>
  	</section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_tipdoc" class="card">
			<div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de documentos</h3>
		    	<div class="no-padding card-tools">
                	<a type="button" class="btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#modaddtipsed"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
		    </div>
		    <div class="card-body">
		    	<div class="neo-table">
                    <div class="header col-12  d-none d-md-block">
                        <div class="row font-weight-bold">
                            <div class='col-12 col-md-3 group'>
                                <div class='col-2 col-md-2 cell d-none d-md-block'>N°</div>
                                <div class='col-10 col-md-5 cell d-none d-md-block'>SEDE</div>
                                <div class='col-10 col-md-5 cell d-none d-md-block'>TIP.DOC</div>
                            </div>
                            
                            <div class='col-12 col-md-4 group'>
                                <div class='col-3 col-md-4 cell d-none d-md-block'>
                                	RUC
                                </div>
                                <div class='col-9 col-md-4 cell d-none d-md-block'>
                                    SERIE
                                </div>
                                <div class='col-9 col-md-4 cell d-none d-md-block'>
                                    CONTADOR
                                </div>
                            </div>
                            <div class='col-12 col-md-3 group'>
                                <div class='col-9 col-md-4 cell d-none d-md-block'>
                                    COD.SUNAT
                                </div>
                                <div class='col-9 col-md-4 cell d-none d-md-block'>
                                    TIP.OPERAC.
                                </div>
                                <div class='col-9 col-md-4 cell d-none d-md-block'>
                                    IGV
                                </div>
                            </div>
                            <div class='col-12 col-md-2 group'>
                                <div class='col-12 col-md-12 cell text-center d-none d-md-block'>
                                    ACCIÓN
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="body col-12">
                    <?php
                        $nro = 0;
                        foreach ($tipos as $tip) {
                            $nro ++;
                            
                    ?>
                    	<div class="row cfila <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>" id="divtip_<?php echo $nro ?>" data-item="<?php echo $nro ?>">
                            <div class="col-12 col-md-3 group">
                                <div class="col-2 col-md-2 cell">
                                    <span><?php echo $nro ;?></span>
                                </div>
                                <div class="col-5 col-md-5 cell">
                                    <span><?php echo $tip->sede ;?></span>
                                </div>
                                <div class="col-5 col-md-5 cell">
                                    <span><?php echo $tip->tipo ;?></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 group">
                            	<div class='col-4 col-md-4 cell text-center'>
                                    <input type="text" value="<?php echo $tip->ruc ;?>" class="form-control form-control-sm fictxtrucup">
                            	</div>
                                <div class='col-4 col-md-4 cell'>
                                    <input type="text" value="<?php echo $tip->serie ;?>" class="form-control form-control-sm fictxtserieup">
                                </div>
                                <div class='col-4 col-md-4 cell'>
                                    <input type="text" value="<?php echo $tip->contador ;?>" class="form-control form-control-sm fictxtcontaup">
                                </div>
                                
                            </div>
                            <div class="col-12 col-md-3 group">
                                <div class='col-4 col-md-4 cell'>
                                    <input type="text" value="<?php echo $tip->codsunat ;?>" class="form-control form-control-sm fictxtcsunatup">
                                </div>
                                <div class='col-4 col-md-4 cell'>
                                    <input type="text" value="<?php echo $tip->tipopera ;?>" class="form-control form-control-sm fictxttipoperup">
                                </div>
                                <div class='col-4 col-md-4 cell'>
                                    <input type="text" value="<?php echo $tip->igv ;?>" class="form-control form-control-sm fictxtigvup">
                                </div>
                            </div>
                            <div class="col-12 col-md-2 group">
                            	<div class='col-6 col-md-6 cell text-center'>
                            		<button type="button" class='btn btn-info btn-sm px-3 btn_editipo' <?php echo ($tip->estado=='SI') ? 'disabled="disabled"' : '' ?> >
                            			<i class='fas fa-pencil-alt text-white'></i>
                            		</button>
                                    <button type="button" class='btn btn-info btn-sm px-3 btn_updatetipo d-none' data-sede="<?php echo base64url_encode($tip->idsede) ?>" data-tipo="<?php echo base64url_encode($tip->idtipo) ?>">
                                        <i class='fas fa-save text-white'></i>
                                    </button>
                            	</div>
                            	<div class='col-6 col-md-6 cell text-center'>
                            		<button class="btn btn-success btn-sm disableaction px-3 <?php echo ($tip->estado!='SI') ? 'd-none' : '' ?>" data-sede="<?php echo base64url_encode($tip->idsede) ?>" data-tipo="<?php echo base64url_encode($tip->idtipo) ?>">
                            			<i class='fas fa-check'></i>
                            		</button>
                                    <button class="btn btn-danger btn-sm activeaction px-3 <?php echo ($tip->estado=='SI') ? 'd-none' : '' ?>" data-sede="<?php echo base64url_encode($tip->idsede) ?>" data-tipo="<?php echo base64url_encode($tip->idtipo) ?>">
                                        <i class='fas fa-ban'></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm cancelaction px-3 d-none">
                                        <i class='fas fa-times'></i>
                                    </button>
                            	</div>
                            </div>
                        </div>
                    <?php    
                        }
                    ?>
                    </div>
                </div>
		    </div>
		</div>
	</section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
        $("#divcard_tipdoc input").attr('disabled', true);
    })

    $('.disableaction').click(function() {
        var btn=$(this);
        var div=btn.parents('.cfila');
        var codigo = div.data("item");
        var idsede = btn.data('sede');
        var idtipo = btn.data('tipo');
        var estado = "NO";
        $('#divcard_tipdoc').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        
        $.ajax({
            url: base_url + "tipodoc_sede/fn_update_estado",
            type: 'post',
            dataType: "json",
            data: {txtsede: idsede, txttipo:idtipo, txtestado:estado},
            success: function(e) {
                $('#divcard_tipdoc #divoverlay').remove();
                if (e.status==true) {
                    
                    $('#divtip_'+codigo+' .btn_editipo').attr('disabled', false);
                    $('#divtip_'+codigo+' .disableaction').addClass('d-none');
                    
                    $('#divtip_'+codigo+' .activeaction').removeClass('d-none');
                }
                
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_tipdoc #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            } 
        });
        return false;
        
    });

    $('.cancelaction').click(function() {
        location.reload();
    });

    $('.btn_editipo').click(function() {
        var btn=$(this);
        var div=btn.parents('.cfila');
        var codigo = div.data("item");
        $("#divtip_"+codigo+" input").attr('disabled', false);
        $('#divtip_'+codigo+' .btn_editipo').addClass('d-none');
        $('#divtip_'+codigo+' .btn_updatetipo').removeClass('d-none');
        $('#divtip_'+codigo+' .cancelaction').removeClass('d-none');
        $('#divtip_'+codigo+' .activeaction').addClass('d-none');
    })

    $('.activeaction').click(function() {
        var btn=$(this);
        var div=btn.parents('.cfila');
        var codigo = div.data("item");
        var idsede = btn.data('sede');
        var idtipo = btn.data('tipo');
        var estado = "SI";
        $('#divcard_tipdoc').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        
        $.ajax({
            url: base_url + "tipodoc_sede/fn_update_estado",
            type: 'post',
            dataType: "json",
            data: {txtsede: idsede, txttipo:idtipo, txtestado:estado},
            success: function(e) {
                $('#divcard_tipdoc #divoverlay').remove();
                if (e.status==true) {

                    $("#divtip_"+codigo+" input").attr('disabled', true);

                    $('#divtip_'+codigo+' .btn_editipo').attr('disabled', true);
                    $('#divtip_'+codigo+' .btn_editipo').removeClass('d-none');

                    $('#divtip_'+codigo+' .disableaction').removeClass('d-none');
                    $('#divtip_'+codigo+' .activeaction').addClass('d-none');
                    $('#divtip_'+codigo+' .btn_updatetipo').addClass('d-none');
                    
                }
                
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_tipdoc #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            } 
        });
        return false;
    });

    $('.btn_updatetipo').click(function() {
        var btn=$(this);
        var div=btn.parents('.cfila');
        var codigo = div.data("item");
        var idsede = btn.data('sede');
        var idtipo = btn.data('tipo');
        var ruc = div.find('.fictxtrucup').val();
        var serie = div.find('.fictxtserieup').val();
        var contador = div.find('.fictxtcontaup').val();
        var codsunat = div.find('.fictxtcsunatup').val();
        var tipopera = div.find('.fictxttipoperup').val();
        var igv = div.find('.fictxtigvup').val();
        
        $('#divcard_tipdoc').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

        $.ajax({
            url: base_url + "tipodoc_sede/fn_update",
            type: 'post',
            dataType: "json",
            data: {
                txtsede:idsede, 
                txttipo:idtipo, 
                txtruc:ruc,
                txtserie:serie,
                txtcontador:contador,
                txtidsunat:codsunat,
                txttipoop:tipopera,
                txtigv:igv
            },
            success: function(e) {
                $('#divcard_tipdoc #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        title: 'Error!',
                        text: "No se guardaron los cambios",
                        type: 'error',
                        icon: 'error',
                    })
                    
                } else {
                    
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                      if (result.value) {
                        location.reload();
                      }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divcard_tipdoc #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
    });


    $("#modaddtipsed").on('hidden.bs.modal', function () {
        $('#frm_addtipdsed')[0].reset();
    });

    $('#lbtn_guardar').click(function() {
        $('#frm_addtipdsed input,select').removeClass('is-invalid');
        $('#frm_addtipdsed .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_addtipdsed').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_addtipdsed').serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });

                    Swal.fire({
                        title: e.msg,
                        // text: "",
                        type: 'error',
                        icon: 'error',
                    })
                    
                } else {
                    $('#modaddtipsed').modal('hide');
                   
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                      if (result.value) {
                        location.reload();
                      }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodaladd #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
    });

    
</script>