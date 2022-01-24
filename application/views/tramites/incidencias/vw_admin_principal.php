<?php
	$vbaseurl = base_url();
?>
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divboxhistorial" class="card">
		    <div class="card-header">
		    	<h3 class="card-title text-bold"><i class="fas fa-list mr-1"></i> Búsqueda de Denuncias y/o Reclamos registrados</h3>
		    </div>
	      	<div class="card-body pt-2">
	      		<form id="form_inc_search" action="<?php echo $vbaseurl ?>incidencia/search_list" method="post" accept-charset="utf-8">
	      			<div class="row">
	      				<div class="col-12 mb-2 text-danger text-bold">
	      					Busqueda por implicados
	      				</div>
		      			<div class="form-group has-float-label col-sm-6">
				        	<input autocomplete="off" class="form-control" type="text" placeholder="Denunciante" name="txtapenombres" id="txtapenombres">
				        	<label for="txtapenombres">Denunciante</label>
				      	</div>
				      	<div class="form-group has-float-label col-sm-6">
				        	<input autocomplete="off" class="form-control" type="text" placeholder="Denunciado" name="txtdenucniado" id="txtdenucniado">
				        	<label for="txtdenucniado">Denunciado</label>
				      	</div>
				      	<div class="col-12 mb-2 text-danger text-bold">
	      					Busqueda por rango de fechas
	      				</div>
				      	<div class="form-group has-float-label col-lg-3 col-md-4 col-sm-4">
				      		<input class="form-control" type="date" name="txtfecha" id="txtfecha">
				      		<label for="txtfecha">Fecha inicio</label>
				      	</div>
				      	<div class="form-group has-float-label col-lg-3 col-md-3 col-sm-4">
				      		<input class="form-control" type="date" name="txtfechafin" id="txtfechafin" >
				      		<label for="txtfechafin">Fecha fin</label>
				      	</div>
				      	<div class="col-md-* col-sm-4">
				        	<button class="btn btn-primary" type="submit" >
				        		<i class="fas fa-search"></i>
				        	</button>
				        	<a href="#" class="btn-expo-pdf btn btn-outline-secondary"><img src="<?php echo $vbaseurl.'resources/img/icons/p_pdf.png' ?>" alt=""> Exportar</a>
				      	</div>
		      		</div>
		      		<div class="row">
				    	<div class="col-lg-6 col-md-6 col-sm-6">
				      		<div id="divmsg_historial"></div>
				      	</div>
				    	
				    </div>
	      		</form>
				<div class="card-body pt-3 px-0 pb-0">
	              	<div class="row">
	                	<div class="col-12 py-1" id="divres-historial">
	                  		
	                      
	                      			<span class="text-danger">Utiliza los cuadros de búsqueda ubicados arriba para encontrar el historial existente de las denuncias</span>
	                      
	                    		
	                	</div>
	              	</div>
	            </div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">

	$("#form_inc_search").submit(function(event) {
	    $('#form_inc_search input,select').removeClass('is-invalid');
	    $('#form_inc_search .invalid-feedback').remove();
	    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	            $('#divboxhistorial #divoverlay').remove();
	            if (e.status == false) {
	                
	                $("#divres-historial").html("* " + e.msg);
	            } else {
	                  $("#divres-historial").html(e.vdata);
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divboxhistorial #divoverlay').remove();
	            $("#divres-historial").html("");
	           Swal.fire({
                    icon: 'error',
                    title: 'Error, no se pudo mostrar los resultados',
                    text: msgf,
                    backdrop: false,
                })
	        }
	    });
	    return false;
	});

	$(".btn-expo-pdf").click(function(event) {
	    $('#form_inc_search input,select').removeClass('is-invalid');
	    $('#form_inc_search .invalid-feedback').remove();
	    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	             url: base_url + 'incidencia/pdf_rp_dncs_general_xfiltro',
	        type: 'post',
	        dataType: 'json',
	        data: $("#form_inc_search").serialize(),
	        success: function(e) {
	            $('#divboxhistorial #divoverlay').remove();
	            if (e.status == false) {
		            Swal.fire({
		                icon: 'warning',
		                title: e.msg,
		                
		                backdrop: false,
		            })
	            }
	            else {
	            	var win = window.open(base_url + "incidencia/fn_descarga_pdf?fp=" + e.ruta  , '_blank');
  					win.focus();
	                 
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divboxhistorial #divoverlay').remove();
	            $("#divres-historial").html("");
	           Swal.fire({
                    icon: 'error',
                    title: 'Error, no se pudo mostrar los resultados',
                    text: msgf,
                    backdrop: false,
                })
	        }
	    });
	    return false;
	});

</script>