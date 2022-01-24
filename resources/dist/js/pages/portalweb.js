$(document).ready(function() {
    var imageUrl = base_url + "resources/img/nube.png";
    $('#previews').css('background-image', 'url(' + imageUrl + ')');
    $('#previews').css('background-repeat', 'url(' + imageUrl + ')');


    // Get the template HTML and remove it from the doument
    if (typeof Dropzone != "undefined") {
        Dropzone.prototype.getErroredFiles = function() {
            var file, _i, _len, _ref, _results;
            _ref = this.files;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                file = _ref[_i];
                if (file.status === Dropzone.ERROR) {
                    _results.push(file);
                }
            }
            return _results;
        };
        var previewNode = document.querySelector("#template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        myDropzone = new Dropzone(document.body, {
            url: base_url + "transparencia/uploadfile",
            paramName: "file",
            maxFilesize: 30,
            maxFiles: 1,
            thumbnailWidth: 100,
            thumbnailHeight: 100,
            timeout: 0,
            thumbnailMethod: 'crop',
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: true,
            previewsContainer: "#previews",
            clickable: "#previews",
            init: function() {
                this.on("complete", function(file) {
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0 && this.getErroredFiles().length === 0) {

                        $(".alert").hide();
                        $("#vw_pw_bt_ad_btn_guardar").prop("disabled", false);
                    } else {
                        $(".alert").show();
                        $("#vw_pw_bt_ad_btn_guardar").prop("disabled", true);
                    }
                });


                este = this;
                //$.each(varchivos, function(k, v) {
                //alert( "Key: " + k + ", Value: " + v );
                if (varchivo['link'] != "") {
                    var mockFile = {
                        name: varchivo['link'],
                        size: varchivo['peso'],
                        type: varchivo['tipo']
                    };

                    var ext = varchivo['link'].split('.').pop();
                    var ico = "";
                    if (ext == "pdf") {
                        ico = "resources/img/icons/pdf.png";
                    } else if (ext.indexOf("doc") != -1) {
                        ico = "resources/img/icons/word.png";
                    } else if (ext.indexOf("xls") != -1) {
                        ico = "resources/img/icons/excel.png";
                    } else if ((ext.indexOf("jpg") != -1) || (ext.indexOf("png") != -1)) {
                        ico = "resources/img/icons/img.png";
                    } else if ((ext.indexOf("mp4") != -1) || (ext.indexOf("mpg") != -1)) {
                        ico = "resources/img/icons/vdo.png";
                    } else {
                        ico = "resources/img/icons/file.png";
                    }




                    mockFile.fileid = varchivo['codigo'];
                    mockFile.link = varchivo['link'];
                    este.files.push(mockFile);
                    este.options.addedfile.call(este, mockFile);
                    este.options.thumbnail.call(este, mockFile, base_url + ico);

                    mockFile.previewElement.classList.add('dz-success');
                    mockFile.previewElement.classList.add('dz-complete');
                    mockFile.previewElement.querySelector(".pb-private").style.width = "100%"
                    este.options.maxFiles = 0;
                }
                //});


                this.on("success", function(file, response) {
                    var obj = jQuery.parseJSON(response)
                    file.link = obj.link;
                    file.fileid = '0';
                    //console.log(file);
                })

            },
            removedfile: function(file) {
                var vinid = (typeof file.fileid === "undefined") ? "" : file.fileid;
                var vilink = (typeof file.link === "undefined") ? "" : file.link;
                var este = this;
                Swal.fire({
                    title: '¿Deseas eliminar el ARCHIVO ?',
                    text: "Al eliminar, se perdera " + file.name + " y no podrá recuperarse",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                    if (result.value) {
                        if (vinid == "") {
                            file.previewElement.remove();
                            if (este.getUploadingFiles().length === 0 && este.getQueuedFiles().length === 0 && este.getErroredFiles().length === 0) {
                                $(".alert").hide();
                                $("#vw_pw_bt_ad_btn_guardar").prop("disabled", false);
                            } else {
                                $(".alert").show();
                                $("#vw_pw_bt_ad_btn_guardar").prop("disabled", true);
                            }
                            este.options.maxFiles = 1;
                        } else {
                            $.ajax({
                                url: base_url + 'transparencia/fn_delete_file',
                                type: 'POST',
                                data: {
                                    "codigo": vinid,
                                    "link": vilink
                                },
                                dataType: 'json',
                                success: function(e) {

                                    if (e.status == true) {
                                        Swal.fire(
                                            'Eliminado!',
                                            'El archivo fue eliminado correctamente.',
                                            'success'
                                        )
                                        file.previewElement.remove();
                                        if (este.getUploadingFiles().length === 0 && este.getQueuedFiles().length === 0 && este.getErroredFiles().length === 0) {
                                            $(".alert").hide();
                                            $("#vw_pw_bt_ad_btn_guardar").prop("disabled", false);
                                        } else {
                                            $(".alert").show();
                                            $("#vw_pw_bt_ad_btn_guardar").prop("disabled", true);
                                        }
                                        este.options.maxFiles = 1;
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            e.msg,
                                            'error'
                                        )
                                    }
                                },
                                error: function(jqXHR, exception) {
                                    var msgf = errorAjax(jqXHR, exception, 'text');
                                    Swal.fire(
                                        'Error!',
                                        msgf,
                                        'success'
                                    )
                                }
                            });
                        }

                    }
                })
                return false;


            }

        });

        myDropzone.on("addedfile", function(file) {
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file);
            };
            var ext = file.name.split('.').pop();
            $("#vw_pw_bt_ad_btn_guardar").prop("disabled", true);
            if (ext == "pdf") {
                myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/pdf.png");
            } else if (ext.indexOf("doc") != -1) {
                myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/word.png");
            } else if (ext.indexOf("xls") != -1) {
                myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/excel.png");
            } else if ((ext.indexOf("jpg") != -1) || (ext.indexOf("png") != -1)) {
                myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/img.png");
            } else {
                myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/file.png");
            }


        });


        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        });

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1";
            // And disable the start button

            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
        });

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0";

        });

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
        };
    }

});
$(document).ready(function() {
    $(".vw_pw_bt_btn_delete").click(function(event) {
        event.preventDefault();
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var fila = $(this).closest('.cfila');
        var idbls = $(this).data("codigo");
        var image = $(this).data("image");
        //************************************
        Swal.fire({
            title: "Precaución",
            text: "¿Deseas eliminar este registro ?",
            type: 'warning',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.value) {
                //var codc=$(this).data('im');
                $.ajax({
                    url: base_url + 'bolsa/fneliminar_bolsa',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        idbolsa: idbls,
                        ficimage: image
                    },
                    success: function(e) {
                        $('#divcard_bolsa #divoverlay').remove();
                        if (e.status == false) {
                            Swal.fire({
                                type: 'error',
                                icon: 'error',
                                title: 'Error!',
                                text: e.msg,
                                backdrop: false,
                            })
                        } else {
                            /*$("#fm-txtidmatricula").html(e.newcod);*/
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: 'Eliminación correcta',
                                text: 'Se ha eliminado el registro',
                                backdrop: false,
                            })

                            fila.remove();
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msgf = errorAjax(jqXHR, exception, 'text');
                        $('#divcard_bolsa #divoverlay').remove();
                        Swal.fire({
                            type: 'error',
                            icon: 'error',
                            title: 'Error',
                            text: msgf,
                            backdrop: false,
                        })
                    }
                });
            } else {
                $('#divcard_bolsa #divoverlay').remove();
            }
        });
    });

    
});
function vw_pw_tp_pr_fn_eliminar(btn) {
        vinid = btn.data('codigo');
        area = btn.data('area');
        fila=btn.closest('.cfila');

        Swal.fire({
            title: "Precaución",
            text: "¿Deseas eliminar este registro ?",
            type: 'warning',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.value) {
                $('#divcard_bolsa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                $.ajax({
                    url: base_url + 'transparencia/fn_delete',
                    type: 'POST',
                    data: {
                        "codigo": vinid,
                        "area": area
                    },
                    dataType: 'json',
                    success: function(e) {
                        $('#divcard_bolsa #divoverlay').remove();
                        if (e.status == true) {
                            Swal.fire(
                                'Eliminado!',
                                'El archivo fue eliminado correctamente.',
                                'success'
                            )
                            fila.remove();
                        } else {
                            Swal.fire(
                                'Error!',
                                e.msg,
                                'error'
                            )
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msgf = errorAjax(jqXHR, exception, 'text');
                        Swal.fire(
                            'Error!',
                            msgf,
                            'error'
                        );
                        $('#divcard_bolsa #divoverlay').remove();
                    }
                });
            } else {
                $('#divcard_bolsa #divoverlay').remove();
            }
        });



        
    }
//BOLSA DE TRABAJO AGREGAR
$('#vw_pw_bt_ad_form_addbolsa').submit(function() {
    $('#vw_pw_bt_ad_divmsgbolsa').html("");
    $('#vw_pw_bt_ad_form_addbolsa input,select').removeClass('is-invalid');
    $('#vw_pw_bt_ad_form_addbolsa .invalid-feedback').remove();
    $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var formData = new FormData($("#vw_pw_bt_ad_form_addbolsa")[0]);
    $.ajax({
        url: $("#vw_pw_bt_ad_form_addbolsa").attr("action"),
        type: $("#vw_pw_bt_ad_form_addbolsa").attr("method"),
        dataType: 'json',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(e) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                $('#vw_pw_bt_ad_divmsgbolsa').html("* " + e.msg);
            } else {
                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                $('#vw_pw_bt_ad_divmsgbolsa').html(msgf);
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    allowOutsideClick: false,
                    showConfirmButton: true,
                }).then((result) => {

                })
                location.href = e.destino;
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            $('#vw_pw_bt_ad_divmsgbolsa').show();
            $('#vw_pw_bt_ad_divmsgbolsa').html(msgf);
        }
    });
    return false;
})

$("#vw_pw_bt_ad_cbotiposp, #vw_pw_bt_ed_cbotiposp").change(function(event) {
    if ($.trim($("#vw_pw_bt_ad_fictxtportada").val()) == "") {
        var img = $(this).find(':selected').data('image');
        $("#fxviewimg").attr('src', base_url + "resources/img/bolsa_trabajo/" + img);
    }

});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#fxviewimg').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}
$("#vw_pw_bt_ad_fictxtportada, #vw_pw_bt_ed_fictxtportada").change(function(event) {
    readURL(this);
});

$('.vw_pw_bt_textarea_summer').summernote({
    height: 250,
    placeholder: 'Escriba Aquí ...!',
    dialogsFade: true,
    lang: 'es-ES',
    callbacks: {
        onImageUpload: function(image) {
            vw_pw_bt_ad_fn_uploadImage(image[0]);
        },
        onMediaDelete: function(target) {
            vw_pw_bt_ad_deleteFile(target[0].src);
        }
    }
});

function vw_pw_bt_ad_fn_uploadImage(image) {
    var data = new FormData();
    data.append("file", image);
    $.ajax({
        url: base_url + "bolsa/uploadimages",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "post",
        success: function(url) {
            var image = $('<img>').attr('src', base_url + url);
            $('.vw_pw_bt_textarea_summer').summernote("insertNode", image[0]);
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function vw_pw_bt_ad_deleteFile(src) {
    $.ajax({
        data: {
            src: src
        },
        type: "POST",
        url: base_url + "bolsa/delete_file", // replace with your url 
        cache: false,
        success: function(resp) {
            console.log(resp);
        }
    });
}



//BOLSA DE TRABAJO EDITAR
$('#vw_pw_bt_ed_form_updatebolsa').submit(function() {
    $('#vw_pw_bt_ed_form_updatebolsa input,select').removeClass('is-invalid');
    $('#vw_pw_bt_ed_form_updatebolsa .invalid-feedback').remove();
    $('#vw_pw_bt_ed_divcard_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var formData = new FormData($("#vw_pw_bt_ed_form_updatebolsa")[0]);
    $.ajax({
        url: $("#vw_pw_bt_ed_form_updatebolsa").attr("action"),
        type: $("#vw_pw_bt_ed_form_updatebolsa").attr("method"),
        dataType: 'json',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(e) {
            $('#vw_pw_bt_ed_divcard_principal #divoverlay').remove();

            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });

            } else {
                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                $('#vw_pw_bt_ed_divmsgbolsa').html(msgf);
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    allowOutsideClick: false,
                    showConfirmButton: true,
                });
                window.location = e.destino;
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_pw_bt_ed_divcard_principal #divoverlay').remove();
            $('#vw_pw_bt_ed_divmsgbolsa').show();
            $('#vw_pw_bt_ed_divmsgbolsa').html(msgf);
        }
    });
    return false;
})