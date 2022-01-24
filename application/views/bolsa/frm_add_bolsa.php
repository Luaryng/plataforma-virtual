<?php $vbaseurl=base_url(); ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>BOLSA DE TRABAJO
                    <small>Agregar</small></h1>
                </div>
            
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>portal-web/bolsa-de-trabajo">Bolsa de trabajo</a>
                        </li>
                        <li class="breadcrumb-item active">Agregar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
	<section id="s-cargado" class="content">
		<div id="vw_pw_bt_ad_div_principal" class="card">

		    <div class="card-body">
				<form id="vw_pw_bt_ad_form_addbolsa" action="<?php echo $vbaseurl ?>bolsa/fn_insert_datos" method="post" accept-charset="utf-8">
					<div class="row mt-2">
			          	<div class="form-group has-float-label col-12 col-sm-12">
							<input data-currentvalue='' autocomplete="off" class="form-control" id="vw_pw_bt_ad_fictxttitulo" name="vw_pw_bt_ad_fictxttitulo" type="text" placeholder="Titulo de publicación" />
							<label for="vw_pw_bt_ad_fictxttitulo">Titulo</label>
						</div>
					</div>
					<div class="row mt-2">
						<div class="form-group col-12 col-sm-12">
							<label for="vw_pw_bt_ad_fictxtdesc">Descripción</label>
							<textarea data-currentvalue='' class="form-control vw_pw_bt_textarea_summer" id="vw_pw_bt_ad_fictxtdesc" name="vw_pw_bt_ad_fictxtdesc" placeholder="Descripción"></textarea>
						</div>
                        <div class="col-md-6">
                            <div class="form-group has-float-label col-12">
                                <select name="vw_pw_bt_ad_cbotiposp" id="vw_pw_bt_ad_cbotiposp" class="form-control">
                                    <option value="">* Seleccione Item</option>
                                    <option data-image='practicas.jpg' value="PRÁCTICAS">PRÁCTICAS</option>
                                    <option data-image='trabajo.jpg' value="TRABAJO">TRABAJO</option>
                                </select>
                                <label for="vw_pw_bt_ad_cbotiposp">Tipo Publicación</label>
                            </div>
    						<div class="form-group has-float-label col-12">
    							<input data-currentvalue='' class="form-control" id="vw_pw_bt_ad_fictxtportada" name="vw_pw_bt_ad_fictxtportada" type="file" accept="image/png, .jpeg, .jpg, image/gif">
    							<label for="vw_pw_bt_ad_fictxtportada">Cambiar Portada</label>
    						</div>
                        </div>
                        <div class="col-md-6">
                         
                            <img id="fxviewimg" style="width:100%;" class="img-responsive" src="">
                           
                        </div>

			        	<div class="col-12 py-2">
			        		<div id="vw_pw_bt_ad_divmsgbolsa" class="text-danger">
							</div>
			        	</div>
			        	<div class="col-12">
                            <a type="button" href="<?php echo $vbaseurl ?>portal-web/bolsa-de-trabajo" class="btn btn-danger btn-md float-left" >
                                <i class="fas fa-undo"></i> Cancelar
                            </a>
			        		<button type="submit" class="btn btn-primary btn-md float-right"><i class="fas fa-save"></i> Registrar</button>
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
