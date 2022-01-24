$('#vtextdetalle').summernote({
    height: 200,
    minHeight: 200, // set minimum height of editor
    maxHeight: 800, // set maximum height of editor
    focus: true,
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear', 'style']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['list', ['ul', 'ol']],
        ['para', ['paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['otros', ['help', 'codeview']],
    ],
    dialogsFade: true,
    callbacks: {
        onImageUpload: function(image) {
            var txtrt = $(this);
            fn_summer_upload_images(image[0], txtrt);
        },
        onMediaDelete: function(target) {
            fn_summer_delete_images(target[0].src);
        }
    }
});
$.summernote.dom.emptyPara = "<div><br></div>"

function fn_summer_upload_images(image, tarea) {
    var data = new FormData();
    data.append("file", image);
    $.ajax({
        url: base_url + "virtual/fn_summer_upload_images",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "post",
        success: function(url) {
            var image = $('<img>').attr('src', base_url + url);
            tarea.summernote("insertNode", image[0]);
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function fn_summer_delete_images(src) {
    $.ajax({
        data: {
            src: src
        },
        type: "POST",
        url: base_url + "virtual/fn_summer_delete_images", // replace with your url
        cache: false,
        success: function(resp) {
            console.log(resp);
        }
    });
}
