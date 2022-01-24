<?php 
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divcard-search" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-search mr-1"></i> Buscar Libro</h3>
		    </div>
	      	<div class="card-body">
	      		<div class="row">
	      			<div class="form-group has-float-label col-sm-8 col-md-11">
			        	<input class="form-control" type="text" placeholder="Nombre Libro" name="txtnomlibro" id="txtnomlibro">
			        	<label for="txtnomlibro">Nombre Libro</label>
			      	</div>
			      	<div class="col-sm-4 col-md-1">
			        	<button class="btn btn-block btn-info" type="button" id="busca_libro">
			        		<i class="fas fa-search"></i>
			        	</button>
			      	</div>
	      		</div>
			    <div class="row">
			    	<div class="col-md-4">
			      		<div id="divmsg_search"></div>
			      	</div>
			    </div>
			    <div class="row" id="divsearch_libros">
			    	
			    </div>
	      	</div>
	    </div>
	</section>
</div>

<script type="text/javascript">
	$('#txtnomlibro').keypress(function(event) {
	    var keycode = event.keyCode || event.which;
	    if(keycode == '13') {            
	         search_libro($('#txtnomlibro').val());
	    }
	});

	$('#busca_libro').click(function() {
	    var nomlb = $('#txtnomlibro').val();
	    search_libro(nomlb);
	    return false;
	});

	function search_libro(nomlb){
	    $('#divsearch_libros').html("");
	    $('#divcard-search').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'biblioteca/fn_search_libro',
            type: 'post',
            dataType: 'json',
            data: {txtnlib : nomlb},
            success: function(e) {
                if (e.status == true) {
                    $('#divsearch_libros').html(e.detallelib);
                    $('#divmsg_search').html('');
                } else {
                	
                    var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#divsearch_libros').html(msgf);
                }

                $('#divcard-search #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divcard-search #divoverlay').remove();
                $('#divsearch_libros').html(msgf);
            },
        });
	}
	
</script>