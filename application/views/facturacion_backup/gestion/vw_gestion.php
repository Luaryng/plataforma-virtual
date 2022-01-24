<?php
	$vbaseurl=base_url();
?>

<div class="content-wrapper">
    
    <div class="modal fade" id="modaddgestion" tabindex="-1" role="dialog" aria-labelledby="modaddgestion" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title">AGREGAR REGISTRO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addtipdsed" action="<?php echo $vbaseurl ?>Gestion/fn_insert" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-3 col-md-2">
                                <input type="text" name="fictxtcodigo" id="fictxtcodigo" placeholder="Código" class="form-control">
                                <label for="fictxtcodigo">Código</label>
                            </div>
                            <div class="form-group has-float-label col-9 col-md-10">
                                <input type="text" name="fictxtnombre" id="fictxtnombre" placeholder="Nombre" class="form-control">
                                <label for="fictxtnombre">Nombre</label>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="form-group has-float-label col-6 col-md-3">
                                <select name="fictxtcategoria" id="fictxtcategoria" class="form-control">
                                    <option value="0"></option>
                                    <?php
                                        foreach ($categorias as $key => $value) {
                                            echo "<option value='$value->codigo'>$value->nombre</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtcategoria">Categoria</label>
                            </div>
                            <div class="form-group has-float-label col-6 col-md-3">
                                <input type="text" name="fictxtimporte" id="fictxtimporte" placeholder="Importe" class="form-control">
                                <label for="fictxtimporte">Importe</label>
                            </div>
                            <div class="form-group has-float-label col-6 col-md-3">
                                <input type="text" name="fictxtfcomo" id="fictxtfcomo" placeholder="Facturar como" class="form-control">
                                <label for="fictxtfcomo">Facturar como</label>
                            </div>
                            <div class="form-group has-float-label col-6 col-md-3">
                                <select name="fictxtund" id="fictxtund" class="form-control">
                                    <option value="">Seleccione item</option>
                                    <?php
                                        foreach ($unidades as $key => $value) {
                                            echo "<option value='$value->id'>$value->nombre</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtund">Unidades</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-5">
                                <select name="fictxtafectip" id="fictxtafectip" class="form-control">
                                    <option value="">Seleccione item</option>
                                    <?php
                                        foreach ($tipoaf as $key => $value) {
                                            echo "<option value='$value->id'>$value->nombre</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtafectip">Tipo Afectación</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-5">
                                <select name="fictxtafectacion" id="fictxtafectacion" class="form-control">
                                    <option value="">Seleccione item</option>
                                    <option value="GRAVADO">GRAVADO</option>
                                    <option value="EXONERADO">EXONERADO</option>
                                    <option value="INAFECTO">INAFECTO</option>
                                </select>
                                <label for="fictxtafectacion">Tipo Afectación</label>
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

    <div class="modal fade" id="modupdategst" tabindex="-1" role="dialog" aria-labelledby="modupdategst" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodalupd">
                <div class="modal-header">
                    <h5 class="modal-title">ACTUALIZAR REGISTRO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_updgestion" action="<?php echo $vbaseurl ?>Gestion/fn_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-3 col-md-2">
                                <input type="text" name="fictxtcodigoup" id="fictxtcodigoup" placeholder="Código" class="form-control">
                                <label for="fictxtcodigoup">Código</label>
                            </div>
                            <div class="form-group has-float-label col-9 col-md-10">
                                <input type="text" name="fictxtnombreup" id="fictxtnombreup" placeholder="Nombre" class="form-control">
                                <label for="fictxtnombreup">Nombre</label>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="form-group has-float-label col-6 col-md-3">
                                <select name="fictxtcategoriaup" id="fictxtcategoriaup" class="form-control">
                                    <option value="0"></option>
                                    <?php
                                        foreach ($categorias as $key => $value) {
                                            echo "<option value='$value->codigo'>$value->nombre</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtcategoriaup">Categoria</label>
                            </div>
                            <div class="form-group has-float-label col-6 col-md-3">
                                <input type="text" name="fictxtimporteup" id="fictxtimporteup" placeholder="Importe" class="form-control">
                                <label for="fictxtimporteup">Importe</label>
                            </div>
                            <div class="form-group has-float-label col-5 col-md-3">
                                <input type="text" name="fictxtfcomoup" id="fictxtfcomoup" placeholder="Facturar como" class="form-control">
                                <label for="fictxtfcomoup">Facturar como</label>
                            </div>
                            <div class="form-group has-float-label col-7 col-md-3">
                                <select name="fictxtundup" id="fictxtundup" class="form-control">
                                    <option value="">Seleccione item</option>
                                    <?php
                                        foreach ($unidades as $key => $value) {
                                            echo "<option value='$value->id'>$value->nombre</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtundup">Unidades</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-5">
                                <select name="fictxtafectipup" id="fictxtafectipup" class="form-control">
                                    <option value="">Seleccione item</option>
                                    <?php
                                        foreach ($tipoaf as $key => $value) {
                                            echo "<option value='$value->id'>$value->nombre</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtafectipup">Tipo Afectación</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-5">
                                <select name="fictxtafectacionup" id="fictxtafectacionup" class="form-control">
                                    <option value="">Seleccione item</option>
                                    <option value="GRAVADO">GRAVADO</option>
                                    <option value="EXONERADO">EXONERADO</option>
                                    <option value="INAFECTO">INAFECTO</option>
                                </select>
                                <label for="fictxtafectacionup">Tipo Afectación</label>
                            </div>
                            
                        </div> 
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="lbtn_guardarup" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

  	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>Mantenimiento
          			<small>Gestion</small></h1>
        		</div>
        
      		</div>
    	</div>
  	</section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_gestion" class="card">
			<div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de registros</h3>
		    	<div class="no-padding card-tools">
                	<a type="button" class="btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#modaddgestion"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
		    </div>
		    <div class="card-body">
                <div id="divcard_filtro">
                    <div class="row">
                        <div class="form-group has-float-label col-12 col-md-5">
                            <select name="fic_cbo_categoria" id="fic_cbo_categoria" class="form-control">
                                <option value="0">Seleccione item</option>
                                <?php
                                    foreach ($categorias as $key => $value) {
                                        echo "<option value='$value->codigo'>$value->nombre</option>";
                                    }
                                ?>
                            </select>
                            <label for="fic_cbo_categoria">Categoria</label>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-info" id="vw_gt_btnbuscar">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>

		    	<div class="neo-table">
                    <div class="header col-12  d-none d-md-block">
                        <div class="row font-weight-bold">
                            <div class='col-12 col-md-3 group'>
                                <div class='col-2 col-md-2 cell d-none d-md-block'>N°</div>
                                <div class='col-10 col-md-3 cell d-none d-md-block'>CÓDIGO</div>
                                <div class='col-10 col-md-7 cell d-none d-md-block'>NOMBRE</div>
                            </div>
                            
                            <div class='col-12 col-md-4 group'>
                                <div class='col-3 col-md-4 cell d-none d-md-block'>
                                	CATEGORIA
                                </div>
                                <div class='col-9 col-md-4 cell d-none d-md-block'>
                                    IMPORTE
                                </div>
                                <div class='col-9 col-md-4 cell d-none d-md-block'>
                                    FAC.COMO
                                </div>
                            </div>
                            <div class='col-12 col-md-3 group'>
                                <div class='col-9 col-md-6 cell d-none d-md-block'>
                                    TIP.AFECTACIÓN
                                </div>
                                <div class='col-9 col-md-6 cell d-none d-md-block'>
                                    UNIDAD
                                </div>
                            </div>
                            <div class='col-12 col-md-2 group'>
                                <div class='col-12 col-md-12 cell text-center d-none d-md-block'>
                                    ACCIÓN
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="body col-12" id="divcard_data_gestion">
                    <?php
                        $nro = 0;
                        $codigo64 = "";
                        foreach ($gestion as $gst) {
                            $nro ++;
                            $codigo64 = base64url_encode($gst->codigo);
                            
                    ?>
                    	<div class="row cfila <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
                            <div class="col-12 col-md-3 group">
                                <div class="col-2 col-md-2 cell">
                                    <span><?php echo $nro ?></span>
                                </div>
                                <div class="col-2 col-md-3 cell">
                                    <span><?php echo $gst->codigo ?></span>
                                </div>
                                <div class="col-8 col-md-7 cell">
                                    <span class="gnombre"><?php echo $gst->nombre ?></span><br>
                                    <span class="small gafectacion">(<?php echo $gst->afectacion ?>)</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 group">
                            	<div class='col-4 col-md-4 cell text-center'>
                                    <span class="gcategoria"><?php echo $gst->categoria ?></span>
                            	</div>
                                <div class='col-4 col-md-4 cell text-center'>
                                    <span class="gimporte"><?php echo $gst->importe ?></span>
                                </div>
                                <div class='col-4 col-md-4 cell'>
                                    <span class="gfcomo"><?php echo $gst->fcomo ?></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 group">
                                <div class='col-6 col-md-6 cell'>
                                    <span class="gtipafec"><?php echo $gst->nomtipafec ?></span>
                                </div>
                                <div class='col-6 col-md-6 cell'>
                                    <span class="gunidad"><?php echo $gst->undnombre ?></span>
                                </div>
                                
                            </div>
                            <div class="col-12 col-md-2 group">
                            	<div class='col-6 col-md-6 cell text-center'>
                            		<button type="button" class='btn btn-info btn-sm px-3' data-toggle="modal" data-target="#modupdategst" data-codigo="<?php echo $codigo64 ?>" id="btnupdate_<?php echo $codigo64 ?>">
                            			<i class='fas fa-pencil-alt text-white msgtooltip' data-toggle='tooltip' title='Editar'></i>
                            		</button>
                            	</div>
                            	<div class='col-6 col-md-6 cell text-center'>
                            		<button class="btn btn-success btn-sm disableaction px-3 <?php echo ($gst->estado!='SI') ? 'd-none' : '' ?> msgtooltip" data-codigo="<?php echo base64url_encode($gst->codigo) ?>" data-toggle='tooltip' title='Deshabilitar'>
                            			<i class='fas fa-check'></i>
                            		</button>
                                    <button class="btn btn-danger btn-sm activeaction px-3 <?php echo ($gst->estado=='SI') ? 'd-none' : '' ?> msgtooltip" data-codigo="<?php echo base64url_encode($gst->codigo) ?>" data-toggle='tooltip' title='Habilitar'>
                                        <i class='fas fa-ban'></i>
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


<script type="text/javascript">

    $('#vw_gt_btnbuscar').click(function() {
        var categoria=$('#fic_cbo_categoria').val();
        $('#divcard_gestion input,select').removeClass('is-invalid');
        $('#divcard_gestion .invalid-feedback').remove();
        if (categoria=="0"){
            $("#vw_dc_divcalendarios").html("");
            $('#fic_cbo_categoria').addClass('is-invalid');
            $('#fic_cbo_categoria').parent().append("<div class='invalid-feedback'>Categoria Requerido</div>");
            return;
        }
        $('#divcard_gestion').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "gestion/fn_get_gestion_xcategoria" ,
            type: 'post',
            dataType: 'json',
            data: {"vw_gt_cbcategoria":categoria},
            success: function(e) {
                $('#divcard_gestion #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                } else {
                    $("#divcard_data_gestion").html("");
                    var nro=0;
                    var tabla="";
                    var bgrow = "";
                    var estado = "";
                    var estado2 = "";
                    
                    $.each(e.vdata, function(index, val) {
                        nro++;
                        
                        if (nro % 2 === 0) {bgrow = "bg-lightgray";}else{bgrow = "";}

                        if (val['estado'] == "SI") {estado = "d-none";}else{estado = "";}
                        if (val['estado'] != "SI") {estado2 = "d-none";}else{estado2 = "";}
                        
                        tabla=tabla + 
                        "<div class='row cfila "+bgrow+"' id='divgest_"+val['codigo64']+"' data-numero='"+val['codigo64']+"'>"+
                            "<div class='col-12 col-md-3 group'>"+
                                "<div class='col-2 col-md-2 cell'>"+
                                    "<span>"+nro+"</span>"+
                                "</div>"+
                                "<div class='col-2 col-md-3 cell'>"+
                                    "<span>"+val['codigo']+"</span>"+
                                "</div>"+
                                "<div class='col-8 col-md-7 cell'>"+
                                    "<span class='gnombre'>"+val['nombre']+"</span><br>"+
                                    "<span class='small gafectacion'>("+val['afectacion']+")</span>"+
                                "</div>"+
                            "</div>"+
                            "<div class='col-12 col-md-4 group'>"+
                                "<div class='col-4 col-md-4 cell text-center'>"+
                                    "<span class='gcategoria'>"+val['categoria']+"</span>"+
                                "</div>"+
                                "<div class='col-4 col-md-4 cell'>"+
                                    "<span class='gimporte'>"+val['importe']+"</span>"+
                                "</div>"+
                                "<div class='col-4 col-md-4 cell'>"+
                                    "<span class='gfcomo'>"+val['fcomo']+"</span>"+
                                "</div>"+
                            "</div>"+
                            "<div class='col-12 col-md-3 group'>"+
                                "<div class='col-6 col-md-6 cell'>"+
                                    "<span class='gtipafec'>"+val['nomtipafec']+"</span>"+
                                "</div>"+
                                "<div class='col-6 col-md-6 cell'>"+
                                    "<span class='gunidad'>"+val['undnombre']+"</span>"+
                                "</div>"+
                            "</div>"+
                            "<div class='col-12 col-md-2 group'>"+
                                "<div class='col-6 col-md-6 cell text-center'>"+
                                    "<button type='button' class='btn btn-info btn-sm px-3' data-toggle='modal' data-target='#modupdategst' data-codigo='"+val['codigo64']+"' id='btnupdate_"+val['codigo64']+"'>"+
                                        "<i class='fas fa-pencil-alt text-white msgtooltip' data-toggle='tooltip' title='Editar'></i>"+
                                    "</button>"+
                                "</div>"+
                                "<div class='col-6 col-md-6 cell text-center'>"+
                                    "<button class='btn btn-success btn-sm disableaction px-3 "+estado2+" msgtooltip' data-codigo='"+val['codigo64']+"' data-toggle='tooltip' title='Deshabilitar'>"+
                                        "<i class='fas fa-check'></i>"+
                                    "</button>"+
                                    "<button class='btn btn-danger btn-sm activeaction px-3 "+estado+" msgtooltip' data-codigo='"+val['codigo64']+"' data-toggle='tooltip' title='Habilitar'>"+
                                        "<i class='fas fa-ban'></i>"+
                                    "</button>"+
                                "</div>"+
                            "</div>"+
                        "</div>";
                    });
                    $("#divcard_data_gestion").html(tabla);
                    
                    $('.msgtooltip').tooltip();
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divcard_gestion #divoverlay').remove();
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

    $(document).on("click", ".disableaction", function() {
        var btn=$(this);
        var div=btn.parents('.cfila');
        var codigo = btn.data('codigo');
        
        var estado = "NO";
        $('#divcard_gestion').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        
        $.ajax({
            url: base_url + "gestion/fn_update_estado",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo, txtestado:estado},
            success: function(e) {
                $('#divcard_gestion #divoverlay').remove();
                if (e.status==true) {
                    
                    div_gestion = btn.closest('.cfila');
                    btndisable = div_gestion.find('.disableaction');
                    btnactive = div_gestion.find('.activeaction');
                    btndisable.addClass('d-none');
                    btnactive.removeClass('d-none');
                }
                
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_gestion #divoverlay').remove();
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

    $(document).on("click", ".activeaction", function() {
        var btn=$(this);
        var div=btn.parents('.cfila');
        var codigo = btn.data('codigo');

        var estado = "SI";
        $('#divcard_gestion').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        
        $.ajax({
            url: base_url + "gestion/fn_update_estado",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo, txtestado:estado},
            success: function(e) {
                $('#divcard_gestion #divoverlay').remove();
                if (e.status==true) {

                    div_gestion = btn.closest('.cfila');
                    btndisable = div_gestion.find('.disableaction');
                    btnactive = div_gestion.find('.activeaction');

                    btndisable.removeClass('d-none');
                    btnactive.addClass('d-none');
                    
                }
                
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_gestion #divoverlay').remove();
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


    $("#modaddgestion").on('hidden.bs.modal', function () {
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
                    $('#modaddgestion').modal('hide');
                   
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

    $("#modupdategst").on('show.bs.modal', function (e) {
        var rel=$(e.relatedTarget);
        var codigo = rel.data('codigo');
        
        $('#divmodalupd').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

        $.ajax({
            url: base_url + "gestion/fn_get_gestion_xcodigo",
            type: 'post',
            dataType: 'json',
            data: {
                vw_codigogestion:codigo,
            },
            success: function(e) {
                $('#divmodalupd #divoverlay').remove();
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
                    $('#fictxtcodigoup').val(e.vdata['codigo']);
                    $('#fictxtcodigoup').attr('readonly', true);
                    
                    $('#fictxtnombreup').val(e.vdata['nombre']);
                    $('#fictxtimporteup').val(e.vdata['importe']);
                    $('#fictxtfcomoup').val(e.vdata['fcomo']);
                    $('#fictxtundup').val(e.vdata['unidad']);
                    $('#fictxtafectipup').val(e.vdata['tipafec']);
                    $('#fictxtafectacionup').val(e.vdata['afectacion']);
                    if (e.vdata['categoria'] !== '00.00') {
                        $('#fictxtcategoriaup').val(e.vdata['categoria']);
                    } else {
                        $("#fictxtcategoriaup option[value='0']").attr("selected",true);
                    }
                    
                    

                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodalupd #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        // return false;
    });

    $("#modupdategst").on('hidden.bs.modal', function () {
        $('#frm_updgestion')[0].reset();
    });

    var div_gestion;

    $('#lbtn_guardarup').click(function() {
        $('#frm_updgestion input,select').removeClass('is-invalid');
        $('#frm_updgestion .invalid-feedback').remove();
        $('#divmodalupd').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_updgestion').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_updgestion').serialize(),
            success: function(e) {
                $('#divmodalupd #divoverlay').remove();
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
                    $('#modupdategst').modal('hide');
                    var btn = $('#btnupdate_'+e.codigo64);
                    div_gestion = btn.closest('.cfila');
                    nombre = div_gestion.find('.gnombre');
                    afectacion = div_gestion.find('.gafectacion');
                    categoria = div_gestion.find('.gcategoria');
                    importe = div_gestion.find('.gimporte');
                    facomo = div_gestion.find('.gfcomo');
                    tipafec = div_gestion.find('.gtipafec');
                    unidad = div_gestion.find('.gunidad');

                    nombre.html(e.vdata['nombre']);
                    afectacion.html("("+e.vdata['afectacion']+")");
                    categoria.html(e.vdata['categoria']);
                    importe.html(e.vdata['importe']);
                    facomo.html(e.vdata['fcomo']);
                    tipafec.html(e.vdata['nomtipafec']);
                    unidad.html(e.vdata['undnombre']);

                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodalupd #divoverlay').remove();
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