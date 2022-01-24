<?php
	$vbaseurl = base_url();
?>
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divboxhistorial" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list mr-1"></i> LISTA INCIDENCIAS</h3>
		    </div>
	      	<div class="card-body">
	      		<form id="form_inc_search" action="<?php echo $vbaseurl ?>incidencia/search_list" method="post" accept-charset="utf-8">
	      			<div class="row">
		      			<div class="form-group has-float-label col-lg-4 col-md-6 col-sm-6">
				        	<input class="form-control" type="text" placeholder="Apellidos y nombres" name="txtapenombres" id="txtapenombres">
				        	<label for="txtapenombres">Apellidos y nombres</label>
				      	</div>
				      	<div class="form-group has-float-label col-lg-4 col-md-4 col-sm-6">
				      		<input class="form-control" type="date" name="txtfecha" id="txtfecha">
				      		<label for="txtfecha">Fecha inicio</label>
				      	</div>
				      	<div class="form-group has-float-label col-lg-4 col-md-4 col-sm-6">
				      		<input class="form-control" type="date" name="txtfechafin" id="txtfechafin" >
				      		<label for="txtfechafin">Fecha fin</label>
				      	</div>
		      		</div>
		      		<div class="row">
				    	<div class="col-lg-6 col-md-6 col-sm-6">
				      		<div id="divmsg_historial"></div>
				      	</div>
				    	<div class="col-lg-6 col-md-6 col-sm-6">
				        	<button class="btn btn-flat btn-info float-right" type="submit" >
				        		<i class="fas fa-search"></i>
				        		Buscar
				        	</button>
				      	</div>
				    </div>
	      		</form>
				<div class="card-body pt-3 pl-0 pr-0 pb-0">
	              	<div class="row">
	                	<div class="col-12 py-1" id="divres-historial">
	                  		<div class="card">
	                    		<div class="card-body">
	                      
	                      			<span class="text-danger">Utiliza los cuadros de búsqueda ubicados arriba para encontrar el historial existente de las denuncias</span>
	                      
	                    		</div>
	                  		</div>
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
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                $("#divres-historial").html("");
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
</script>