$(document).ready(function() {

    var imageUrl = base_url + "resources/img/nube.png";
    $('#previews').css('background-image', 'url(' + imageUrl + ')');

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
            url: base_url + "galeria/uploadfile",
            paramName: "file",
            maxFilesize: 5,
            maxFiles: 10,
            thumbnailWidth: 100,
            thumbnailHeight: 100,
            timeout: 0,
            thumbnailMethod: 'crop',
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: true,
            previewsContainer: "#previews",
            clickable: "#previews",
            acceptedFiles:"image/jpg,image/png,image/jpeg",
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

                this.on("success", function(file, response) {
                    var obj = jQuery.parseJSON(response)
                    file.link = obj.link;
                    file.fileid = '0';
                    
                })

            },
            removedfile: function(file) {
                var vinid = (typeof file.fileid === "undefined") ? "" : file.fileid;
                var vilink = (typeof file.link === "undefined") ? "" : file.link;
                var este = this;
                Swal.fire({
                    title: '¿Deseas eliminar la imagen ?',
                    text: "Al eliminar, se perdera " + file.name + " y no podrá recuperarse",
                    type: 'warning',
                    icon: 'warning',
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
                            este.options.maxFiles = 10;
                        } else {
                            $.ajax({
                                url: base_url + 'galeria/fn_delete_file',
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
                                        este.options.maxFiles = 10;
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


function vw_pw_tp_pr_fn_delete_album(btn) {
    vinid = btn.data('codigo');
    fila=btn.closest('.cfila');

    Swal.fire({
        title: "Precaución",
        text: "¿Deseas eliminar este álbum ?",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.value) {
            $('#divcard_galeria').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + 'galeria/fn_delete',
                type: 'POST',
                data: {
                    "codigo": vinid
                },
                dataType: 'json',
                success: function(e) {
                    $('#divcard_galeria #divoverlay').remove();
                    if (e.status == true) {
                        Swal.fire(
                            'Eliminado!',
                            'El álbum fue eliminado correctamente.',
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
                    $('#divcard_galeria #divoverlay').remove();
                }
            });
        } else {
            $('#divcard_galeria #divoverlay').remove();
        }
    });



    
}
