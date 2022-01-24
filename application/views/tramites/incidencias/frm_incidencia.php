<?php $vbaseurl=base_url() ?>
<style>
.form-title{
background-color: black;
color: white;
padding: 5px 0px 5px 10px;
margin: 25px -10px 25px -10px;
font-size: 16px;
}
#vw_mpc_pgBar {
background-color: #3E6FAD;
width: 0px;
height: 10px;
margin-top: 10px;
margin-bottom: 10px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
-o-border-radius: 5px;
border-radius: 5px;
-moz-transition: .25s ease-out;
-webkit-transition: .25s ease-out;
-o-transition: .25s ease-out;
transition: .25s ease-out;
}
</style>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.css">
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divboxhistorial" class="card">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-list mr-1"></i> NUEVA DENUNCIA</h3>
			</div>
			<div class="card-body">
				<form id="frm-add-incidencia" action="<?php echo $vbaseurl ?>incidencia/fn_insert_propio" method="post" accept-charset="utf-8">
					<section>
						<h5 class="form-title">Datos del denunciante</h5>
						<div class="row">
							<div class="form-group has-float-label col-lg-3 col-md-6 col-sm-6">
								<input class="form-control form-control-sm" type="text" placeholder="Tipo Doc" name="vw_ric_txt_tipodoc" id="vw_ric_txt_tipodoc" readonly value="<?php echo $_SESSION['userActivo']->tipodoc ?>">
								<label for="vw_ric_txt_tipodoc">Tipo Doc</label>
							</div>
							<div class="form-group has-float-label col-lg-3 col-md-6 col-sm-6">
								<input class="form-control form-control-sm" type="text" placeholder="DNI" name="vw_ric_txt_nrodoc" id="vw_ric_txt_nrodoc" readonly  value="<?php echo $_SESSION['userActivo']->nrodoc ?>">
								<label for="vw_ric_txt_nrodoc">DNI</label>
							</div>
							<div class="form-group has-float-label col-lg-6 col-md-6 col-sm-6">
								<input class="form-control form-control-sm" type="text" placeholder="Apellidos y nombres" name="vw_ric_txt_apenombres" readonly id="vw_ric_txt_apenombres" value="<?php echo $_SESSION['userActivo']->paterno.' '.$_SESSION['userActivo']->materno.' '.$_SESSION['userActivo']->nombres ?>">
								<label for="vw_ric_txt_apenombres">Apellidos y nombres</label>
							</div>
							
							<div class="form-group has-float-label col-lg-6 col-md-6 col-sm-6">
								<input autocomplete="off" value="<?php echo $perfil->domicilio ?>"  class="form-control form-control-sm" type="text" placeholder="Domicilio" name="vw_ric_txt_domicilio" id="vw_ric_txt_domicilio">
								<label for="vw_ric_txt_domicilio">Domicilio</label>
							</div>
							<div class="form-group has-float-label col-lg-6 col-md-6 col-sm-6">
								<input autocomplete="off" value="<?php echo $perfil->distrito ?>" class="form-control form-control-sm" type="text" placeholder="Distrito" name="vw_ric_txt_distrito" id="vw_ric_txt_distrito">
								<label for="vw_ric_txt_distrito">Distrito</label>
							</div>
						</div>
					</section>
					<section>
						<h5 class="form-title">Datos del denunciado</h5>
						<span class="text-danger">Me presento con la finalidad de dejar constancia de una incidencia contra:</span>
						<div class="row mt-2">
							<div class="form-group has-float-label col-lg-8 col-md-6 col-sm-6">
								<input autocomplete="off"  class="form-control form-control-sm" type="text" placeholder="Denunciado" name="vw_ric_txt_denunciado" id="vw_ric_txt_denunciado">
								<label for="vw_ric_txt_denunciado">Denunciado</label>
							</div>
							<div  class="form-group has-float-label col-lg-4 col-md-6 col-sm-6">
								<input autocomplete="off" class="form-control form-control-sm" type="text" placeholder="Cargo" name="vw_ric_txt_cargo" id="vw_ric_txt_cargo">
								<label for="vw_ric_txt_cargo">Cargo</label>
							</div>
							
						</div>
						
						<div class="row">
							<b class="d-block pt-2 pb-4 text-danger"><i class="fas fa-list"></i> DETALLE INCIDENCIA</b>
							<div class="form-group col-lg-12 col-md-12 col-sm-12">
								<textarea name="vw_ric_txt_detalle" id="vw_ric_txt_detalle" class="form-control vw_ric_txt_summernote" placeholder="Detalle Incidencia"></textarea>
								<small class="text-primary">Caracteres restantes: <span id="vw_mp_sm_conteo_con" >2000</span></small>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<p class="text-secondary m-0 mb-2">En caso no se cuente con la prueba física, declaro juramento que la autoridad / empresa / entidad, la tiene en su poder:</p>
							</div>
							<div class="form-group has-float-label col-12 ">
								<input autocomplete="off"  class="form-control" type="text" placeholder="Autoridad / empresa / entidad" name="vw_ric_txt_custodio" id="vw_ric_txt_custodio">
								<label for="vw_ric_txt_custodio">Autoridad / empresa / entidad</label>
							</div>
							
						</div>
					</section>
					<section>
						<h5 class="form-title">Archivos a Adjuntar</h5>
						<div class="row">
							<div class="form-group col-lg-12">
								<div class="row">
									
									<div class="col-md-7 has-float-label mb-2">
										<input type="text" name="vw_mpc_txt_titulo" id="vw_mpc_txt_titulo" class="form-control" placeholder="Describe el archivo adjunto" maxlength="200" autocomplete="off" >
										<label for="vw_mpc_txt_titulo">Describe el archivo adjunto</label>
									</div>
									<div class="col-md-3">
										<button id="vw_mpc_btn_selecionar" role="button" class="btn btn-info"><i class="fas fa-paperclip mr-1"></i>
										Seleccionar archivo
										</button>
										<small class="d-block pt-2" id="vw_mpc_txt_filename"></small>
										<input type="file" class="form-control" name="vw_mpc_file" id="vw_mpc_file">
									</div>
									<!--<div class="col-md-2">
										<div class="btn btn-success" id="vw_mpc_btn_adjuntar">
											<i class="fas fa-upload"></i> Adjuntar Prueba
										</div>
									</div>-->
								</div>
								<div class="row">
									<div id="vw_mpc_txt_progress"></div>
									<div id="vw_mpc_txt_size"></div>
									<div id="vw_mpc_txt_type"></div>
									<div id="vw_mpc_pgBar"></div>
								</div>
								<div class="row">
									<b>(Se permite adjuntar hasta 6 archivos, de 1 en 1, con un máximo de 10 Mb por cada uno) <br>
									* Solo se permiten los siguientes tipos de archivo: pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,txt.</b>
								</div>
							</div>
							
							<div id="divcard_items" class="col-12"></div>
						</div>
						<div class="row text-bold border-bottom">
							<div class="col-5">
								Archivo
							</div>
							<div class="col-2">
								Tamaño
							</div>
							<div class="col-5">
								Descripción
							</div>
						</div>
						<div class="clearfix"></div>
						<div id="vw_mpc_lista">
							
						</div>
						<div class="row mt-3">
							<div class="col-12" id="divmsjinc">
								
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-12">
								<a type="button" href="<?php echo $vbaseurl ?>tramites/incidencias" class="btn btn-danger btn-md float-left" ><i class="fas fa-undo"></i> Cancelar</a>
								<button type="submit" class="btn btn-flat btn-primary float-right"><i class="far fa-paper-plane"></i> Enviar</button>
							</div>
						</div>
					</section>
					
				</form>
				<div id="divcard_msg" class="text-center p-3">
					<h3><i class="far fa-check-circle mr-1 text-success"></i> Tu reporte fue enviado con éxito</h3>
					<span>En breve nos estaremos poniendo en contacto contigo para las investiogaciones correspondientes</span><br>
					<span>Puedes descargar una constancia de tu denuncia</span><br>
					
					<a id="vw_ric_link_descargar" href=""  class="btn btn-outline-danger my-3"><h4>Descargar Constancia</h4></a><br>
					
					<a href="<?php echo $vbaseurl ?>tramites/incidencias"  class="btn btn-outline-primary "><h5>Ver mis denuncias</h5></a>


				</div>
			</div>
		</div>
	</section>
</div>
<?php echo  
"<script src='{$vbaseurl}resources/plugins/summernote8/summernote-bs4.min.js'></script>
 <script src='{$vbaseurl}resources/plugins/summernote8/lang/summernote-es-ES.js'></script>
 <script src='{$vbaseurl}resources/plugins/simpleUpload/simpleUpload.min.js'></script>"; ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#vw_mpc_txt_progress').hide();
		$('#vw_mpc_txt_size').hide();
		$('#vw_mpc_txt_type').hide();
		$('#vw_mpc_pgBar').hide();
		$("#vw_mpc_file").hide();

		$("#frm-add-incidencia").show();
	    $("#divcard_msg").hide();

	});
	$.summernote.dom.emptyPara = "<div><br></div>"
      $('.vw_ric_txt_summernote').summernote({
          height: 150,
          placeholder: 'Escriba Aquí ...!',
          dialogsFade: true,
          lang: 'es-ES',
          toolbar: [
              ['font', ['bold', 'italic', 'underline', 'clear']],

              ['insert', ['link', 'hr']],
              ['view', ['codeview']],
          ],
          callbacks: {
            onKeydown: function (e) {
                var t = e.currentTarget.innerText;
                if (t.trim().length >= 2000) {
                    if (e.keyCode != 8)
                        e.preventDefault();
                }
            },
            onKeyup: function (e) {
                var t = e.currentTarget.innerText;
                $('.vw_mpae_txt_summernote').text(2000 - t.trim().length);
                $("#vw_mp_sm_conteo_con").html(2000 - t.trim().length)
            },
            onPaste: function (e) {
                var t = e.currentTarget.innerText;
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                var all = t + bufferText;
                if(all.length > 2000) {       
                    document.execCommand('insertText', false, bufferText.trim().substring(0, 2000 - t.length));
                    $('.vw_mpae_txt_summernote').text(all.trim().substring(0, 2000));
                }else {
                    document.execCommand('insertText', false, bufferText);
                    $('.vw_mpae_txt_summernote').text(all);
                }
            }
          }
      });

var arrayarchivos=[];
$('#vw_mpc_file').change(function(){
	if (arrayarchivos.length>=6){
		Swal.fire({
	                icon: 'error',
	                title: 'Límite de 6 archivos',
	                text: 'Solo se puede adjuntar como máximo 6 archivos',
	                backdrop: false,
	            });
		return;
	}
	$('#vw_mpc_txt_titulo').removeClass('is-invalid');
	$('.invalid-feedback').remove();
    if ($.trim($('#vw_mpc_txt_titulo').val())==""){
      	alert("Ingresa la descripción o nombre del archivo");
 		$('#vw_mpc_txt_titulo').addClass('is-invalid');
	    $('#vw_mpc_txt_titulo').parent().append("<div class='invalid-feedback'>Ingresa una descripción del archivo</div>");
	    $('#vw_mpc_txt_titulo').focus();
    }
    /*else if ($.trim($('#vw_mpc_file').val())==""){
      alert("Seleciona un archivo");
    }*/
    else{
    	$('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      	$("#vw_mpc_file").simpleUpload(base_url+"/incidencia/fn_upload_file_logeado", {
      		allowedExts: ["jpg", "jpeg", "png", "txt","pdf","doc","docx","xls","xlsx","xlsm","ppt","pptx"],
			//allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
			maxFileSize: 10485760, //10MB in bytes

        start: function(file){
          //upload started
          $('#vw_mpc_txt_filename').html(file.name);
          $('#vw_mpc_txt_size').html(file.size);
          $('#vw_mpc_txt_type').html(file.type);

          $('#vw_mpc_txt_progress').html("");
          $('#vw_mpc_pgBar').width(0);
          $('#vw_mpc_txt_progress').show();
          $('#vw_mpc_pgBar').show();
        },

        progress: function(progress){
          //received progress
          $('#vw_mpc_txt_progress').html("Progress: " + Math.round(progress) + "%");
          $('#vw_mpc_pgBar').width(progress + "%");
        },

        success: function(data){
          //upload successful
          //$('#progress').html("Success!<br>Data: " + JSON.stringify(data));
          $('#vw_mpc_txt_progress').hide();
          $('#vw_mpc_pgBar').hide();

          //AGREGAR ARCVO A LA LISTA
          //i.link,i.name,i.size,i.type,i.fileid
           $('#divboxhistorial #divoverlay').remove();
          var newarchivo=[data.link,$('#vw_mpc_txt_filename').html(),$('#vw_mpc_txt_size').html(),$('#vw_mpc_txt_type').html(),$('#vw_mpc_txt_titulo').val()];
          arrayarchivos.push(newarchivo);
          " "
          $('#vw_mpc_lista').append("<div class='row border-bottom rowcolor p-2'>"+
              "<div class='col-5'> " + $('#vw_mpc_txt_filename').html() +"</div>" + 
              "<div class='col-2'> " + $('#vw_mpc_txt_size').html() +" kb</div>" + 
              "<div class='col-5'> " + $('#vw_mpc_txt_titulo').val() +"<a href='#' class='float-right' data-link='" + data.link + "' onclick='vw_mpa_fn_delfile($(this));event.preventDefault();' ><i class='far fa-trash-alt'></i></a></div>");
          $('#vw_mpc_txt_titulo').val("");
          $('#vw_mpc_txt_filename').html("");
          $('#vw_mpc_txt_titulo').focus();
        },

        error: function(error){
          //upload failed
          
          switch (error.name) {
			  case 'InvalidFileExtensionError':
			    vmsg="Este tipo de archivo no es admitido";
			    break;
			  case 'MaxFileSizeError':
			    vmsg="El peso máximo permitido es de 10MB";
			    break;
			  default:
			   	vmsg=error.message;

			    //$('#vw_mpc_txt_progress').html("Error!<br>" + error.name + ": " + error.message);
			}
			Swal.fire({
	                icon: 'error',
	                title: "Error! " + error.name,
	                text: vmsg,
	                backdrop: false,
	            });
          	$('#vw_mpc_txt_filename').html("");
          $('#vw_mpc_txt_size').html("");
          $('#vw_mpc_txt_type').html("");
           $('#divboxhistorial #divoverlay').remove();
        }

        });
      }


});



  /*$('#vw_mpc_btn_adjuntar').click(function(event) {
    event.preventDefault();
    
  
});*/

function vw_mpa_fn_delfile(btn) {
    var link = btn.data('link');


    var n = 0;
    arrayarchivos.forEach(function(afile) {
        if (afile[0] === link) {
            arrayarchivos.splice(n, 1);
            btn.closest('.rowcolor').remove();
        }
        n++;
    });

}
//****************************----
$('#vw_mpc_btn_selecionar').click(function(event) {
    event.preventDefault();
    $("#vw_mpc_file").trigger('click');
});

	$("#frm-add-incidencia").submit(function(event) {
	    
	    $('#frm-add-incidencia input,select,textarea').removeClass('is-invalid');
	    $('#frm-add-incidencia .invalid-feedback').remove();
	    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

	    fdata=$("#frm-add-incidencia").serializeArray();
	    var html = $('#vtextdetalle').summernote('code');
	    fdata.push({name: 'textdetalle', value: html});


	    var formData = new FormData($("#frm-add-incidencia")[0]);
	    formData.append('vw_mpc_archivos', JSON.stringify(arrayarchivos));
	    $.ajax({
	        url: $("#frm-add-incidencia").attr("action"), //$(this).attr("action"),
	        type: $("#frm-add-incidencia").attr("method"), //'post',
	        dataType: 'json',
	        data: formData,
	        cache: false,
	        contentType: false,
	        processData: false,
	        success: function(e) {
	            $('#divboxhistorial #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });

	            } 
	            else {
	                
	                $("#frm-add-incidencia").hide();
	                $("#divcard_msg").show();
	                $("#vw_ric_link_descargar").attr('href', e.linkpdf);
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divboxhistorial #divoverlay').remove();
	            Swal.fire({
	                icon: 'error',
	                title: 'Error',
	                text: msgf,
	                backdrop: false,
	            })
	        }
	    });
	    return false;
	});
</script>