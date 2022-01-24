$("#frm-settype").submit(function(event) {
    var valor="";
    $.each($("#frm-settype input[name='type']:checked"), function(){
        valor=$(this).val();
    });

    if (valor=="ES") {
        var vorden=$("#num").val();
        (async () => {const { value: vdocente } = await Swal.fire({
        title: 'Título',
        input: 'text',
        inputPlaceholder: 'Ingresa un Título de agrupación',
        showCancelButton: true,
        confirmButtonText:
        '<i class="fa fa-thumbs-up"></i> Guardar!',
         inputValidator: (value) => {
            return new Promise((resolve) => {
              if (!value) {
                resolve('Para guardar, debes ingresar título correcto');
              }
              else{
                var html = "<h4><b><span style='font-size: 14px;'>" + value + "</span></b></h4>";
                
                var fdata = [];
                fdata.push({name: 'vidcurso', value: vccajcode});
                fdata.push({name: 'vdivision', value: vsscjcode});
                fdata.push({name: 'vorden', value: vorden});
                fdata.push({name: 'checkmostrardt', value: "SI"});
                
                fdata.push({name: 'textdetalle', value: html});
                fdata.push({name: 'vtipo', value: "E"});
                $.ajax({
                    url: base_url + 'virtual/fn_insert_update',
                    type: 'POST',
                    data: fdata ,
                    dataType: 'json',
                    success: function(e) {
                        if (e.status==true){
                            Swal.fire(
                              'Exito!',
                              'Los datos fueron guardados correctamente.',
                              'success'
                            );
                            window.location.href = e.redirect;
                        }
                        else{
                            $.each(e.errors, function(key, val) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                            });
                            Swal.fire(
                              'Error!',
                              e.msg,
                              'error'
                            )

                        }
                    },
                    error: function(jqXHR, exception) {
                        //$('#divcard_grupo #divoverlay').remove();
                        var msgf = errorAjax(jqXHR, exception, 'text');
                        Swal.fire(
                              'Error!',
                              msgf,
                              'error'
                            )
                    }
                })
              }
            })
          },

        allowOutsideClick: false
        })

        })()
        return false;
    }
    
});

$(".brcheck .check").change(function(event) {

    if ($(this).is(':checked')) {
        
        $("#mdtitulo").html($(this).data('texto'));
        $("#mddescripcion").html($(this).data('msj'));
        
    }
});

$("#modal-selecttipo").on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    $("#pad").val(button.data('padre'));
    $("#num").val(button.data('norden'));
});

$(".order-list").sortable({
    placeholder: "sortable-select",
    cursor: 'crosshair',
    items: "> li",
    cursorAt: { left: 5 },
    delay: 150,
    //containment: "parent",
    start: function(event, ui) {
        ui.item.startPos = ui.item.index();
    },
    stop: function(event, ui) {
        //console.log("Start position: " + ui.item.startPos);
        //console.log("New position: " + ui.item.index());
    },
    update: function(event, ui) {
        arrdata = [];
        $(".order-list li").each(function(index, el) {
            $(this).find('.norden').html(index + 1);
            var codind = $(this).data("id");
            var norden = index + 1;
            //dataString = {fecha: fcha, accion: accn ,idmiembro: idacu};
            var myvals = [norden, codind];
            arrdata.push(myvals);
        });
        $('#divcard-indicadores').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'virtual/f_ordenar',
            type: 'post',
            dataType: 'json',
            data: {
                vcca: vccaj,
                vssc: vsscj,
                filas: JSON.stringify(arrdata),
            },
            success: function(e) {
                $('#divcard-indicadores #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: 'ERROR, NO se guardó cambios',
                    text: msgf,
                    backdrop: false,
                });
            },
        });
    },
});
//$(".order-list").disableSelection();
$(".order-list" ).sortable( "disable" );
    $(".icon-move").hide();
$("#btn-d-order").hide();

$(".btn-eliminar").click(function(event) {
    var btno=$(this);
    var li=btno.parents('li');
    var codind = li.data("id");
    var vtipo = li.data("tipo");
    var vnorden = li.find('.norden').html();
    var vnombre = li.find('.text').html();
    Swal.fire({
        title: '¿Deseas eliminar el RECURSO ?',
        text: "Al eliminar, se perderan los recursos y no podrán recuperarse: " + vnombre,
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.value) {
            $('#divcard-indicadores').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + 'virtual/fn_delete',
                type: 'POST',
                data: {
                    "codvirtual": codind,
                    "vtipo": vtipo
                },
                dataType: 'json',
                success: function(e) {
                    $('#divcard-indicadores #divoverlay').remove();
                    if (e.status == true) {
                        Swal.fire(
                            'Eliminado!',
                            'El Recurso fue eliminado correctamente.',
                            'success'
                        )
                        li.remove();
                    } else {
                        Swal.fire(
                            'Error!',
                            e.msg,
                            'error'
                        )
                    }
                },
                error: function(jqXHR, exception) {
                    $('#divcard-indicadores #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire(
                        'Error!',
                        msgf,
                        'success'
                    )
                }
            })
        }
    })
    return false;
});
$("#btn-a-order").click(function(event) {
    /* Act on the event */
    $('#divcard-indicadores').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    setTimeout(function(){
        var btno=$(this);
        $( ".order-list" ).sortable( "enable");
        $("#btn-a-order").hide();
        $("#btn-d-order").show();
        $(".icon-move").show();
        $('#divcard-indicadores #divoverlay').remove();
        }, 300);
    
    return false;
});

$("#btn-d-order").click(function(event) {
    /* Act on the event */
    $('#divcard-indicadores').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    setTimeout(function(){
        $( ".order-list" ).sortable( "disable" );
        $("#btn-d-order").hide();
        $("#btn-a-order").show();
        $(".icon-move").hide();
        $('#divcard-indicadores #divoverlay').remove();
    }, 300);
    return false;
});

$(".btn-espacio").click(function(event) {
    /* Act on the event */
    $('#divcard-indicadores').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var btno=$(this);
    var eli=btno.parents('li');
    var spa=eli.data('espacio') ;
    var dir=btno.data('dir');
    var nspa=spa + (1 * dir );
    var codind=eli.data("id");
    $.ajax({
                url: base_url + 'virtual/fn_espaciar',
                type: 'POST',
                data: {
                    "txtidvirtual": codind,
                    "txtespacio":nspa,
                },
                dataType: 'json',
                success: function(e) {
                    $('#divcard-indicadores #divoverlay').remove();
                        eli.removeClass('espaciol-' + (spa));
                        eli.addClass('espaciol-' + (nspa));
                        eli.data('espacio',nspa) ;
                        //alert (nspa + " - " + dir);
                        if ((nspa>0) && (nspa<5)){
                            eli.find('.btn-espacio').removeClass('disabled');
                            //btno.addClass('d-block');
                        }
                        if ((nspa>4) && (dir=="1")){
                            //alert (nspa + " /-/ " + dir);
                            btno.addClass('disabled');
                            //btno.addClass('d-none');
                        }
                        
                        if ((nspa<1) && (dir=="-1")){
                            //alert (nspa + " /-/ " + dir);
                            btno.addClass('disabled');
                            //btno.addClass('d-none');
                        }
                        
                },
                error: function(jqXHR, exception) {
                    $('#divcard-indicadores #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire(
                        'Error!',
                        msgf,
                        'success'
                    );
                }
            });

    
    return false;
});

$(".btn-duplicar").click(function(event) {
    /* Act on the event */
    $('#divcard-indicadores').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var btno=$(this);
    var eli=btno.parents('li');
    var codind=eli.data("id");
    var norden=$(".btn-anexar").data('norden');
    $.ajax({
                url: base_url + 'virtual/fn_duplicar',
                type: 'POST',
                data: {
                    "txtidvirtual": codind,
                    "txtnorden":norden,
                },
                dataType: 'json',
                success: function(e) {
                    $('#divcard-indicadores #divoverlay').remove();
                    if (e.status==true){
                        /*var neli=eli.clone();
                        neli.data('id',e.newcod);
                        $(".order-list").append(neli);*/
                        location.reload();
                    }
                    
                        
                },
                error: function(jqXHR, exception) {
                    $('#divcard-indicadores #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire(
                        'Error!',
                        msgf,
                        'success'
                    );
                }
            });

    
    return false;
});

//VIRTUAL ADD

var myDropzone;
//URL, ETIQUETA
$("#btn-guardarenlace").click(function(event) {
    $('#divcard-indicadores').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    fdata=$("#frm-insertupdate").serializeArray();
    var html = $('#vtextdetalle').summernote('code');
    fdata.push({name: 'textdetalle', value: html});
    $.ajax({
        url: base_url + 'virtual/fn_insert_update',
        type: 'POST',
        data: fdata ,
        dataType: 'json',
        success: function(e) {
            $('#divcard-indicadores #divoverlay').remove();
            if (e.status==true){
                Swal.fire(
                  'Exito!',
                  'Los datos fueron guardados correctamente.',
                  'success'
                );
                window.location.href = e.redirect;
            }
            else{
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire(
                  'Error!',
                  e.msg,
                  'error'
                )

            }
        },
        error: function(jqXHR, exception) {
            $('#divcard-indicadores #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire(
                  'Error!',
                  msgf,
                  'error'
                )
        }
    })
});

//CON DROPZONE
$("#btn-guardararchivo").click(function(event) {
    $('#divcard-indicadores').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    var chkopen = $('#checkopen').prop('checked');
    var chkclose = $('#checkclose').prop('checked');
    var chkretraso = $('#checkretraso').prop('checked');
    var statusnew = true;
    // VALIDAMOS FECHAS Y HORA
    var fhora_inicio = $('#txtopenfecha').val() + ' ' + $('#txtopenhora').val();
    var fhora_final = $('#txtclosefecha').val() + ' ' + $('#txtclosehora').val();
    var fplazo = $('#txtfecharetraso').val() + ' ' + $('#txthoraretraso').val();
    
    var fechainicial = Date.parse(fhora_inicio);
    var fechafinal = Date.parse(fhora_final);
    var fechaplazo = Date.parse(fplazo);

    if ((chkopen == true) && (chkclose == true)) {
        if (fechafinal < fechainicial) {
            msg = 'La fecha y hora culmina no puede ser inferior a la fecha y hora inicial de entrega';
            Swal.fire({
                icon: 'error',
                type: 'error',
                title: "Error!",
                text: msg,
                backdrop: false,
            });

            // $('#txtopenfecha').val('');
            // $('#txtopenhora').val('');
            // $('#txtclosefecha').val('');
            // $('#txtclosehora').val('');
            // return;
            statusnew = false;
        } else {
            console.log('estoy aqui');
            statusnew = true;
        }
    }

    if ((chkclose == true) && (chkretraso == true)) {
        if (fechaplazo < fechafinal) {
            msg = 'La Fecha y hora fuera de plazo no puede ser inferior a fecha y hora de entrega';
            Swal.fire({
                icon: 'error',
                type: 'error',
                title: "Error!",
                text: msg,
                backdrop: false,
            });
            // $('#txtfecharetraso').val('');
            // $('#txthoraretraso').val('');
            // return;
            statusnew = false;
        } else {
            statusnew = true;
        }
    }

    if (statusnew == true) {
        link="";
        fdata=$("#frm-insertupdate").serializeArray();
        var html = $('#vtextdetalle').summernote('code');
        fdata.push({name: 'textdetalle', value: html});
        arrdata = [];
        for(var si in myDropzone.files){
          i=myDropzone.files[si];
          var myvals = [i.link,i.name,i.size,i.type,i.fileid];
          arrdata.push(myvals);
        }
        fdata.push({name: 'afiles', value: JSON.stringify(arrdata)});
        $.ajax({
            url: base_url + 'virtual/fn_insert_update',
            type: 'POST',
            data: fdata,
            dataType: 'json',
            success: function(e) {
                if (e.status==true){
                     $('#divcard-indicadores #divoverlay').remove();
                    var anu = e.filesnoup.toString();
                    if ($.trim(anu)==""){
                        Swal.fire(
                          'Exito!',
                          'Los datos fueron guardados correctamente.',
                          'success'
                        );
                        window.location.href = e.redirect;
                    }
                    else{
                        Swal.fire({
                            title: 'Error! Archivos no subidos',
                            text: "Los siguientes archivos no fueron subidos al servidor: " + anu + " intente nuevamente",
                            type: 'error',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {
                            window.location.href = e.redirect;
                        })
                    }
                }
                else{
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                        $('#' + key).focus();

                    });
                    Swal.fire(
                      'Error!',
                      e.msg,
                      'error'
                    )
                }
            },
            error: function(jqXHR, exception) {
                $('#divcard-indicadores #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire(
                      'Error!',
                      msgf,
                      'error'
                    )
            }
        })
    }
    
});




$("#btn-guardaryoutube").click(function(event) {
    $('#divcard-indicadores').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    link="";

    var newval = '',$this = $("#vlinka") ;
    if (newval = $this.val().match(/(\?|&)v=([^&#]+)/)) {
        link=newval.pop();
    } else if (newval = $this.val().match(/(\.be\/)+([^\/]+)/)) {
        link=newval.pop();
    } else if (newval = $this.val().match(/(\embed\/)+([^\/]+)/)) {
        link=newval.pop().replace('?rel=0','');

    }
    //var link = $('#textdetalle').summernote('code');
    fdata=$("#frm-insertupdate").serializeArray();
    //fdata.push({name: 'vlink', value: link});
    var html = $('#vtextdetalle').summernote('code');
    fdata.push({name: 'textdetalle', value: html});
    fdata.push({name: 'vlink', value: link});
    $.ajax({
        url: base_url + 'virtual/fn_insert_update',
        type: 'POST',
        data: fdata,
        dataType: 'json',
        success: function(e) {
            $('#divcard-indicadores #divoverlay').remove();
            if (e.status==true){
                Swal.fire(
                  'Exito!',
                  'Los datos fueron guardados correctamente.',
                  'success'
                );
                window.location.href = e.redirect;
            }
            else{
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire(
                  'Error!',
                  e.msg,
                  'error'
                )
            }
        },
        error: function(jqXHR, exception) {
            $('#divcard-indicadores #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire(
                  'Error!',
                  msgf,
                  'error'
                )
        }
    })
});

$("#btn-guardarcuestionario").click(function(event) {
    $('#divcard-indicadores').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    // VALIDAMOS FECHAS Y HORA
    var fhora_inicio = $('#txtopenfecha').val() + ' ' + $('#txtopenhora').val();
    var fhora_final = $('#txtclosefecha').val() + ' ' + $('#txtclosehora').val();
    
    var fechainicial = Date.parse(fhora_inicio);
    console.log("fechainicial", fechainicial);
    var fechafinal = Date.parse(fhora_final);
    console.log("fechafinal", fechafinal);
    
    if (fechafinal < fechainicial) {
        msg = 'La fecha y hora culmina no puede ser inferior a la fecha y hora inicial de entrega';
        Swal.fire({
            icon: 'error',
            type: 'error',
            title: "Error!",
            text: msg,
            backdrop: false,
        });

        $('#txtopenfecha').val('');
        $('#txtopenhora').val('');
        $('#txtclosefecha').val('');
        $('#txtclosehora').val('');
        return;
    } else {

        link="";
        fdata=$("#frm-insertupdate").serializeArray();
        //var link = $('#textdetalle').summernote('code');
        var html = $('#vtextdetalle').summernote('code');
        fdata.push({name: 'textdetalle', value: html});
        //fdata.push({name: 'vlink', value: link});
        $.ajax({
            url: base_url + 'virtual/fn_insert_update',
            type: 'POST',
            data: fdata,
            dataType: 'json',
            success: function(e) {
                $('#divcard-indicadores #divoverlay').remove();
                if (e.status==true){
                    Swal.fire(
                      'Exito!',
                      'Los datos fueron guardados correctamente.',
                      'success'
                    );
                    window.location.href = e.redirect;
                }
                else{
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    Swal.fire(
                      'Error!',
                      e.msg,
                      'error'
                    )
                }
            },
            error: function(jqXHR, exception) {
                $('#divcard-indicadores #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire(
                      'Error!',
                      msgf,
                      'error'
                    )
            }
        })
    }
});

$("#btn-cancel-all").click(function(event) {
    /* Act on the event */
        Swal.fire({
          title: '¿Deseas cancelar esta acción?',
          text: "Volveras a la págna principal del Aula Virtual",
          type: 'warning',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'No cancelar',
          confirmButtonText: 'Si, cancelar!'
        }).then((result) => {
          if (result.value) {
               window.location.href = base_url + "curso/virtual/" + vccajcode + "/" + vsscjcode;
          }
        })
    return false;
});


//DROPZONE

