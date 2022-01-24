<?php 
$vbaseurl=base_url();
 ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>BOLSA DE TRABAJO
                    <small>Editar</small></h1>
                </div>
            
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>portal-web/bolsa-de-trabajo">Bolsa de trabajo</a>
                        </li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    
	<section id="s-cargado" class="content pt-2">
		<div id="vw_pw_bt_ed_divcard_principal" class="card">
		    <div class="card-body">
				<form id="vw_pw_bt_ed_form_updatebolsa" action="<?php echo $vbaseurl ?>bolsa/fn_update_datos" method="post" accept-charset="utf-8">
					<div class="row mt-2">
			          	<div class="form-group has-float-label col-12 col-sm-12">
                            <input type="hidden" name="vw_pw_bt_ed_fictxtcodigo" id="vw_pw_bt_ed_fictxtcodigo" value="<?php echo base64url_encode($Dbolsa->id) ?>">
							<input data-currentvalue='' class="form-control" id="vw_pw_bt_ed_fictxttitulo" name="vw_pw_bt_ed_fictxttitulo" type="text" placeholder="Titulo de publicación" value="<?php echo $Dbolsa->titulo ?>" />
							<label for="vw_pw_bt_ed_fictxttitulo">Titulo</label>
						</div>
					
						<div class="form-group col-12 col-sm-12">
							<label for="vw_pw_bt_ed_fictxtdesc">Descripción</label>
							<textarea data-currentvalue='' class="form-control vw_pw_bt_textarea_summer" id="vw_pw_bt_ed_fictxtdesc" name="vw_pw_bt_ed_fictxtdesc" placeholder="Descripción" style="height: 100px; line-height: 18px;"><?php echo $Dbolsa->detalle_html ?></textarea>
						</div>
					<div class="col-6">
						
						<div class="form-group has-float-label col-12">
							<select name="vw_pw_bt_ed_cbotiposp" id="vw_pw_bt_ed_cbotiposp" class="form-control">
								<option value="">* Seleccione Item</option>
								<option data-image='practicas.jpg' <?php echo ($Dbolsa->tip == 'PRÁCTICAS' ? 'selected': '') ?> value="PRÁCTICAS">PRÁCTICAS</option>
								<option data-image='trabajo.jpg' <?php echo ($Dbolsa->tip == 'TRABAJO' ? 'selected': '') ?> value="TRABAJO">TRABAJO</option>
							</select>
							<label for="vw_pw_bt_ed_cbotiposp">Tipo Publicación</label>
						</div>
                        <div class="form-group has-float-label col-12">
                            <input type="hidden" name="vw_pw_bt_ed_fictxtexist" id="vw_pw_bt_ed_fictxtexist" value="<?php echo $Dbolsa->imagen ?>">
                            <input data-currentvalue='' class="form-control" id="vw_pw_bt_ed_fictxtportada" name="vw_pw_bt_ed_fictxtportada" type="file" accept="image/png, .jpeg, .jpg, image/gif">
                            <label for="vw_pw_bt_ed_fictxtportada">* Portada / imagen</label>
                            <p class="small text-secondary">Si no va a cambiar la imagen puede dejar vacio este campo</p>
                        </div>
					</div>
                    <div class="col-md-6">
                            <?php 
                                $img="no";
                                if (($Dbolsa->imagen=="trabajo.jpg") || ($Dbolsa->imagen=="practicas.jpg")){
                                    $img="si";
                                } 
                             ?>
                            <img id="fxviewimg" style="width:100%;" class="img-responsive" data-defecto='<?php echo $img ?>' src="<?php echo base_url().'resources/img/bolsa_trabajo/'.$Dbolsa->imagen ?>">
                           
                        </div>
			        
			        	<div class="col-12 text-danger">
			        		<div id="vw_pw_bt_ed_divmsgbolsa" >

							</div>
			        	</div>
			        	<div class="col-12">
                            <a type="button" href="<?php echo base_url() ?>portal-web/bolsa-de-trabajo" class="btn btn-danger btn-md float-left" ><i class="fas fa-undo"></i> Cancelar</a>
			        		<button type="submit" class="btn btn-primary btn-md float-right"><i class="fas fa-save"></i> Guardar</button>
			        	</div>
			        </div>
				</form>
		    </div>
		</div>
	</section>
</div>

<?php  
echo 
"<script src='{$vbaseurl}resources/plugins/summernote8/summernote-bs4.min.js'></script>
<script src='{$vbaseurl}resources/plugins/summernote8/lang/summernote-es-ES.js'></script>
<script src='{$vbaseurl}resources/dist/js/pages/portalweb.js'></script>";
?>
<script>
$(document).ready(function() {
    
    /*function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#fxviewimg').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }
    $("#vw_pw_bt_ed_fictxtportada").change(function(event) {
        readURL(this);
    });

    $('#vw_pw_bt_ed_fictxtdesc').summernote({
        height: 250,
        placeholder: 'Escriba Aquí ...!',
        dialogsFade: true,
        lang: 'es-ES',
        callbacks: {
            onImageUpload: function(image) {
                uploadImage(image[0]);
            }, 
			onMediaDelete : function(target) {
			 	deleteFile(target[0].src); 
			}
        }
    });

    function uploadImage(image) {
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
                $('#vw_pw_bt_ed_fictxtdesc').summernote("insertNode", image[0]);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function deleteFile(src) { 
	    	$.ajax({ 
	    		data: {src : src}, 
	    		type: "POST", 
	    		url: base_url + "bolsa/delete_file", // replace with your url 
	    		cache: false, 
	    		success: function(resp) { 
	    			console.log(resp); 
	    		} 
	    	}); 
	    } */

});



</script>