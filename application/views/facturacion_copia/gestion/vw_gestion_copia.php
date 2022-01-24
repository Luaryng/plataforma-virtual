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
                                <input type="text" name="fictxtcategoria" id="fictxtcategoria" placeholder="Categoria" class="form-control">
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
                                        echo "<option value='$value->categoria'>$value->categoria</option>";
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
                        foreach ($gestion as $gst) {
                            $nro ++;
                            
                    ?>
                    	<div class="row cfila <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>" id="divgest_<?php echo base64url_encode($gst->codigo) ?>" data-numero="<?php echo base64url_encode($gst->codigo) ?>">
                            <div class="col-12 col-md-3 group">
                                <div class="col-2 col-md-2 cell">
                                    <span><?php echo $nro ;?></span>
                                </div>
                                <div class="col-2 col-md-3 cell">
                                    <span><?php echo $gst->codigo ;?></span>
                                </div>
                                <div class="col-8 col-md-7 cell">
                                    <input type="text" value="<?php echo $gst->nombre ;?>" class="form-control form-control-sm fictxtnom">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 group">
                            	<div class='col-4 col-md-4 cell text-center'>
                                    <input type="text" value="<?php echo $gst->categoria ;?>" class="form-control form-control-sm fictxtcategoria">
                            	</div>
                                <div class='col-4 col-md-4 cell'>
                                    <input type="text" value="<?php echo $gst->importe ;?>" class="form-control form-control-sm fictxtimporte">
                                </div>
                                <div class='col-4 col-md-4 cell'>
                                    <input type="text" value="<?php echo $gst->fcomo ;?>" class="form-control form-control-sm fictxtfcomo">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 group">
                                <div class='col-6 col-md-6 cell'>
                                    <select class="form-control form-control-sm fictxttipaf">
                                        <option value="">Seleccione item</option>
                                        <?php
                                            foreach ($tipoaf as $key => $value) {
                                                $tipsel = ($gst->tipafec == $value->id) ? 'selected': '';
                                                echo "<option $tipsel value='$value->id'>$value->nombre</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class='col-6 col-md-6 cell'>
                                    <select class="form-control form-control-sm fictxtunidad">
                                        <option value="">Seleccione item</option>
                                        <?php
                                            foreach ($unidades as $key => $value) {
                                                $undsel = ($gst->unidad == $value->id) ? 'selected': '';
                                                echo "<option $undsel value='$value->id'>$value->nombre</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="col-12 col-md-2 group">
                            	<div class='col-6 col-md-6 cell text-center'>
                            		<button type="button" class='btn btn-info btn-sm px-3 btn_editgest' >
                            			<i class='fas fa-pencil-alt text-white'></i>
                            		</button>
                                    <button type="button" class='btn btn-info btn-sm px-3 btn_updategest d-none' data-codigo="<?php echo base64url_encode($gst->codigo) ?>" >
                                        <i class='fas fa-save text-white'></i>
                                    </button>
                            	</div>
                            	<div class='col-6 col-md-6 cell text-center'>
                            		<button class="btn btn-success btn-sm disableaction px-3 <?php echo ($gst->estado!='SI') ? 'd-none' : '' ?>" data-codigo="<?php echo base64url_encode($gst->codigo) ?>" >
                            			<i class='fas fa-check'></i>
                            		</button>
                                    <button class="btn btn-danger btn-sm activeaction px-3 <?php echo ($gst->estado=='SI') ? 'd-none' : '' ?>" data-codigo="<?php echo base64url_encode($gst->codigo) ?>" >
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


<script type="text/javascript">

    $(document).ready(function() {
        $("#divcard_gestion input").attr('disabled', true);
        $("#divcard_gestion select").attr('disabled', true);
        $('#divcard_filtro select').attr('disabled', false);
    })

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
                    var vtipafec = "";
                    var tipafect = "";
                    var vunds = "";
                    var undselt = "";
                    var estado = "";
                    var estado2 = "";
                    $.each(e.vtipoaf, function(index, valtf) {
                        vtipafec=vtipafec+
                        "<option value='"+valtf['id']+"'>"+valtf['nombre']+"</option>";
                    })

                    $.each(e.vunidades, function(index, valund) {
                        vunds=vunds+
                        "<option value='"+valund['id']+"'>"+valund['nombre']+"</option>";
                    })
                    
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
                                    "<input type='text' value='"+val['nombre']+"' class='form-control form-control-sm fictxtnom'>"+
                                "</div>"+
                            "</div>"+
                            "<div class='col-12 col-md-4 group'>"+
                                "<div class='col-4 col-md-4 cell text-center'>"+
                                    "<input type='text' value='"+val['categoria']+"' class='form-control form-control-sm fictxtcategoria'>"+
                                "</div>"+
                                "<div class='col-4 col-md-4 cell'>"+
                                    "<input type='text' value='"+val['importe']+"' class='form-control form-control-sm fictxtimporte'>"+
                                "</div>"+
                                "<div class='col-4 col-md-4 cell'>"+
                                    "<input type='text' value='"+val['fcomo']+"' class='form-control form-control-sm fictxtfcomo'>"+
                                "</div>"+
                            "</div>"+
                            "<div class='col-12 col-md-3 group'>"+
                                "<div class='col-6 col-md-6 cell'>"+
                                    "<select class='form-control form-control-sm fictxttipaf'>"+
                                        "<option value=''>Seleccione item</option>"+
                                        ""+vtipafec+
                                    "</select>"+
                                "</div>"+
                                "<div class='col-6 col-md-6 cell'>"+
                                    "<select class='form-control form-control-sm fictxtunidad'>"+
                                        "<option value=''>Seleccione item</option>"+
                                        ""+vunds+
                                    "</select>"+
                                "</div>"+
                            "</div>"+
                            "<div class='col-12 col-md-2 group'>"+
                                "<div class='col-6 col-md-6 cell text-center'>"+
                                    "<button type='button' class='btn btn-info btn-sm px-3 btn_editgest' >"+
                                        "<i class='fas fa-pencil-alt text-white'></i>"+
                                    "</button>"+
                                    "<button type='button' class='btn btn-info btn-sm px-3 btn_updategest d-none' data-codigo='"+val['codigo64']+"' >"+
                                        "<i class='fas fa-save text-white'></i>"+
                                    "</button>"+
                                "</div>"+
                                "<div class='col-6 col-md-6 cell text-center'>"+
                                    "<button class='btn btn-success btn-sm disableaction px-3 "+estado2+"' data-codigo='"+val['codigo64']+"' >"+
                                        "<i class='fas fa-check'></i>"+
                                    "</button>"+
                                    "<button class='btn btn-danger btn-sm activeaction px-3 "+estado+"' data-codigo='"+val['codigo64']+"' >"+
                                        "<i class='fas fa-ban'></i>"+
                                    "</button>"+
                                    "<button class='btn btn-danger btn-sm cancelaction px-3 d-none'>"+
                                        "<i class='fas fa-times'></i>"+
                                    "</button>"+
                                "</div>"+
                            "</div>"+
                        "</div>";
                    });
                    $("#divcard_data_gestion").html(tabla);
                    $("#divcard_gestion input").attr('disabled', true);
                    $("#divcard_gestion select").attr('disabled', true);
                    $('#divcard_filtro select').attr('disabled', false);

                    $.each(e.vdata, function(index, val) {
                        
                        tipafect = val['tipafec'];
                        undselt = val['unidad']
                        $("#divgest_"+val['codigo64']+" .fictxttipaf option[value='"+ tipafect +"']").attr("selected",true);
                        $("#divgest_"+val['codigo64']+" .fictxtunidad option[value='"+ undselt +"']").attr("selected",true);
                        
                    })
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
        var nro = div.data("numero");
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
                    
                    $('#divgest_'+nro+' .btn_editgest').attr('disabled', false);
                    $('#divgest_'+nro+' .disableaction').addClass('d-none');
                    
                    $('#divgest_'+nro+' .activeaction').removeClass('d-none');
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

    $(document).on("click", ".cancelaction", function() {
        location.reload();
    });

    $(document).on("click", ".btn_editgest", function() {
        var btn=$(this);
        var div=btn.parents('.cfila');
        var nro = div.data("numero");
        $("#divgest_"+nro+" input").attr('disabled', false);
        $("#divgest_"+nro+" select").attr('disabled', false);
        $('#divgest_'+nro+' .disableaction').addClass('d-none');

        $('#divgest_'+nro+' .btn_editgest').addClass('d-none');
        $('#divgest_'+nro+' .btn_updategest').removeClass('d-none');
        $('#divgest_'+nro+' .cancelaction').removeClass('d-none');
        $('#divgest_'+nro+' .activeaction').addClass('d-none');
    })

    $(document).on("click", ".activeaction", function() {
        var btn=$(this);
        var div=btn.parents('.cfila');
        var nro = div.data("numero");
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

                    $("#divgest_"+nro+" input").attr('disabled', true);

                    $('#divgest_'+nro+' .btn_editgest').attr('disabled', false);
                    $('#divgest_'+nro+' .btn_editgest').removeClass('d-none');

                    $('#divgest_'+nro+' .disableaction').removeClass('d-none');
                    $('#divgest_'+nro+' .activeaction').addClass('d-none');
                    $('#divgest_'+nro+' .btn_updategest').addClass('d-none');
                    
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

    $(document).on("click", ".btn_updategest", function() {
        var btn=$(this);
        var div=btn.parents('.cfila');
        var nro = div.data("numero");

        var nombre = div.find('.fictxtnom').val();
        var categoria = div.find('.fictxtcategoria').val();
        var importe = div.find('.fictxtimporte').val();
        var facomo = div.find('.fictxtfcomo').val();
        var tipafec = div.find('.fictxttipaf').val();
        var unidad = div.find('.fictxtunidad').val();

        var codigo = btn.data('codigo');
        
        
        $('#divcard_gestion').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

        $.ajax({
            url: base_url + "gestion/fn_update",
            type: 'post',
            dataType: "json",
            data: {
                fictxtcodigo:codigo, 
                fictxtnombre:nombre, 
                fictxtcategoria:categoria,
                fictxtimporte:importe,
                fictxtfcomo:facomo,
                fictxtafectip:tipafec,
                fictxtund:unidad
            },
            success: function(e) {
                $('#divcard_gestion #divoverlay').remove();
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

    
</script>