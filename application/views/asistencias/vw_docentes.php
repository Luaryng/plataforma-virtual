<?php
	$vbaseurl=base_url();
?>
<div class="content-wrapper">

	<section id="s-cargado" class="content pt-2">
		<div id="divcard_reporte" class="card">
			<div class="card-header">
		    	<h3 class="card-title text-bold"><i class="fas fa-list-ul mr-1"></i> Asistencias</h3>
		    </div>
		    <div class="card-body">
		    	<form id="vw_form_report" action="" method="post" accept-charset="utf-8">
		    		<div class="row">
		    			<div class="form-group has-float-label col-6 col-md-3 col-sm-6">
                            <input type="date" name="fictxtfecha_asistencia" id="fictxtfecha_asistencia" class="form-control form-control-sm">
                            <label for="fictxtfecha_asistencia">Fecha Inicio</label>
                        </div>
                        <div class="form-group has-float-label col-6 col-md-3 col-sm-6">
                            <input type="date" name="fictxtfecha_asistenciaf" id="fictxtfecha_asistenciaf" class="form-control form-control-sm">
                            <label for="fictxtfecha_asistenciaf">Fecha Final</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4 col-sm-9">
                        	<select name="fictxt_docente" id="fictxt_docente" class="form-control form-control-sm">
                                <option value=''>[--Seleccione--]</option>
                                <?php
                                foreach ($docentes as $key => $doc) {
                                	if ($doc->activo='SI'){
                                		$codocente = base64url_encode($doc->coddocente);
                                		$nomdocente = base64url_encode($doc->paterno." ".$doc->materno." ".$doc->nombres);
                                    echo "<option value='$codocente' data-ndocente='$nomdocente'>$doc->paterno $doc->materno $doc->nombres</option>";
                                	}
                                }
                                ?>
                            </select>
                            <label for="fictxt_docente">Docente</label>
                        </div>
                        <div class="col-12 col-md-2 col-sm-3">
                        	<button type="submit" class="btn btn-sm btn-info">
                                <i class="fas fa-search"></i> 
                            </button>

                            <div class="btn-group dropleft">
                              	<button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                	Exportar
                              	</button> 
                              	<div class="dropdown-menu">
                                <?php 
                                    if (getPermitido("104") == "SI")  {
                                        echo "<a id='vw_exp_pdf' class='dropdown-item' href='#'>
                                        		<i class='fas fa-file-pdf text-danger'></i> PDF
                                        	</a>";
                                    }
                                    if (getPermitido("103") == "SI")  {
                                        echo "<a id='vw_exp_excel' class='dropdown-item' href='#'>
                                        		<i class='fas fa-file-excel text-success'></i> Excel
                                        	</a>";
                                    }
                                 ?>
                                
                              	</div>
                            </div>
                        </div>
		    		</div>
		    	</form>

		    	<div id="div_resultasist">
		    		
		    	</div>
		    </div>
		</div>
	</section>
</div>

<script>
	$('#vw_form_report').submit(function(e) {
		$('#vw_form_report input,select').removeClass('is-invalid');
        $('#vw_form_report .invalid-feedback').remove();
		$('#divcard_reporte').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		$.ajax({
            url: base_url + 'asistencias_sesiones/fn_filtrar_asistencias',
            type: 'post',
            dataType: 'json',
            data: $("#vw_form_report").serialize(),
            success: function(e) {
                $('#divcard_reporte #divoverlay').remove();
                if (e.status== true) {
                    
                    $('#div_resultasist').html(e.vdata);
                } else {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                }
                
            },
            error: function(jqXHR, exception) {
                $('#divcard_reporte #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire({
                    title: "Error!",
                    text: msgf,
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
	});

	$("#vw_exp_pdf").click(function(e) {
    
        e.preventDefault();
        
        $('#vw_form_report input,select').removeClass('is-invalid');
        $('#vw_form_report .invalid-feedback').remove();

        var fi=$("#fictxtfecha_asistencia").val();
        var ff=$("#fictxtfecha_asistenciaf").val();
        var dc=$("#fictxt_docente").val();
        var docente = $('#fictxt_docente option:selected').data('ndocente');
        var url=base_url + 'academico/reporte-asistencia-docente/pdf?fi=' + fi + '&ff=' + ff + '&dc=' + dc + '&ndc=' + docente;
        var ejecuta=false;
        if ($.trim(fi)!=''){
            ejecuta=true;
        }
        else if($.trim(ff)!=''){
          ejecuta=true;
        }
        else if($.trim(dc)!=''){
          ejecuta=true;
        }
        if (ejecuta==true){
            window.open(url, '_blank');
        }
        else{
            Swal.fire({
                title: "Parametros requeridos",
                text: "Ingresa al menos un parametro de búsqueda",
                type: 'error',
                icon: 'error',
            })
        }
    });
</script>