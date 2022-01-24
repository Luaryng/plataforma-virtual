<style type="text/css">

.modal-body{
    height: 60vh;
    overflow-y: auto;
}
</style>
<?php 
	$vbaseurl=base_url();
	date_default_timezone_set('America/Lima');
	$fechahoy = date('Y-m-d');
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $vbaseurl ?>resources/dist/css/paginador.css">
<style type="text/css" media="screen">
	.not-active { 
	    pointer-events: none; 
	    cursor: default;
	}
</style>
<div class="content-wrapper">

	<div class="modal fade" id="modmatriculacurso" tabindex="-1" role="dialog" aria-labelledby="modmatriculacurso" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodalnewmatricula">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">Unidades didácticas resgistradas</h5>
                    <button type="button" class="btn btn-info btn-sm" id="btn_agregarnew">
                    	<i class="fas fa-plus"></i> Agregar
                    </button>
                    <button type="button" class="btn btn-danger btn-sm d-none" id="btncancelar">
                    	<i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 py-1" id="divcard_datamat">
                    	
	                    <div class="btable">
	                        <div class="thead col-12  d-none d-md-block">
	                            <div class="row">
	                                <div class='col-12 col-md-2'>
	                                    <div class='row'>
	                                        <div class='col-2 col-md-2 td'>N°</div>
	                                        <div class='col-10 col-md-10 td'>PLAN</div>
	                                        
	                                    </div>
	                                </div>
	                                <div class='col-12 col-md-2 td'>
	                                	GRUPO
	                                </div>
	                                <div class='col-12 col-md-3 td'>
	                                	UNIDAD DID.
	                                </div>
	                                <div class="col-md-4">
	                                	<div class="row">
	                                		<div class='col-12 col-md-4 td'>
	                                			FINAL
			                                </div>
			                                <div class='col-12 col-md-4 td'>
			                                	RECUPERA
			                                </div>
			                                 <div class='col-12 col-md-4 td'>
			                                	ESTADO
			                                </div>
	                                	</div>
	                                </div>
	                                
	                                <div class='col-12 col-md-1 text-center'>
	                            
	                                            <span>ACCIÓN</span>
	                                        
	                                </div>
	                            </div>
	                            
	                        </div>
	                        <div class="tbody col-12" id="divcard_data_matricula_curso">
	                            
	                        </div>
	                    </div>
	                     
	                </div>

	                <div class="col-12 py-1 d-none" id="divcard_form_new">
	                	<form id="form_addmatricula" action="" method="post" accept-charset="utf-8">
	                		<input type="hidden" name="fmt-cbncodmatcurso" id="fmt-cbncodmatcurso" value="0">
	                		<input type="hidden" name="fmt-cbncodmatricula" id="fmt-cbncodmatricula" value="">
	                		<input type="hidden" name="fmt-cbncargaacadem" id="fmt-cbncargaacadem" value="">
	                		<input type="hidden" name="fmt-cbncargaacadsubsec" id="fmt-cbncargaacadsubsec" value="">
	                		<div class="row">
	                			<div class="form-group has-float-label col-12 col-sm-6 col-md-3">
		                    		<select class="form-control form-control-sm" id="fmt-cbtipo" name="fmt-cbtipo">
				                      	<option value="MANUAL" data-tipo="MANUAL">MANUAL</option>
				                      	<option value="PLATAFORMA" data-tipo="PLATAFORMA">PLATAFORMA</option>
				                      	<option value="CONVALIDA" data-tipo="CONVALIDA">CONVALIDA</option>
		                    		</select>
		                    		<label for="fmt-cbtipo"> Tipo</label>
		                  		</div>

		                  		<div class="form-group has-float-label col-12 col-sm-6 col-md-2">
		                    		<select class="form-control form-control-sm" id="fmt-cbnperiodo" name="fmt-cbnperiodo" placeholder="Periodo">
				                      	<?php foreach ($periodos as $periodo) {?>
				                      	<option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
			                      		<?php } ?>
		                    		</select>
		                    		<label for="fmt-cbnperiodo"> Periodo</label>
		                  		</div>

		                  		<div class="form-group has-float-label col-12 col-sm-6 col-md-7">
		                    		<select class="form-control form-control-sm" id="fmt-cbncarrera" name="fmt-cbncarrera">
		                    			<option value="0"></option>
				                      	<?php foreach ($carreras as $carrera) {?>
				                      	<option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
				                      	<?php } ?>
				                      	
		                    		</select>
		                    		<label for="fmt-cbncarrera"> Programa</label>
		                  		</div>
		                  		<div class="form-group has-float-label col-12 col-sm-6 col-md-5">
		                    		<select class="form-control form-control-sm" id="fmt-cbnplan" name="fmt-cbnplan" onchange="get_unidades('fmt-cbnciclo','fmt-cbnplan');">
				                      	<option value=""></option>
		                    		</select>
		                    		<label for="fmt-cbnplan"> Plan</label>
		                  		</div>
		                  		<div class="form-group has-float-label col-12 col-sm-6 col-md-2">
		                    		<select class="form-control form-control-sm" id="fmt-cbnciclo" name="fmt-cbnciclo" onchange="get_unidades('fmt-cbnciclo','fmt-cbnplan');">
		                    			<option value="0"></option>
				                      	<?php foreach ($ciclos as $ciclo) {?>
				                      	<option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
				                      	<?php } ?>
		                    		</select>
		                    		<label for="fmt-cbnciclo"> Ciclo</label>
		                  		</div>
		                  		<div class="form-group has-float-label col-12 col-sm-6 col-md-3">
		                    		<select class="form-control form-control-sm" id="fmt-cbnturno" name="fmt-cbnturno">
				                      	<?php foreach ($turnos as $turno) {?>
				                      	<option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
				                      	<?php } ?>
		                    		</select>
		                    		<label for="fmt-cbnturno"> Turno</label>
		                  		</div>
		                  		<div class="form-group has-float-label col-12 col-sm-6 col-md-2">
		                    		<select class="form-control form-control-sm" id="fmt-cbnseccion" name="fmt-cbnseccion">
				                      	<?php foreach ($secciones as $seccion) {?>
				                      	<option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
				                      	<?php } ?>
		                    		</select>
		                    		<label for="fmt-cbnseccion"> Sección</label>
		                  		</div>

		                  		<div class="form-group has-float-label col-12 col-sm-6 col-md-6">
		                    		<select class="form-control form-control-sm" id="fmt-cbnunididact" name="fmt-cbnunididact">
		                    			<option value=""></option>
		                    		</select>
		                    		<label for="fmt-cbnunididact"> Und. didac.</label>
		                  		</div>
		                  		<div class="form-group has-float-label col-12 col-sm-6 col-md-6">
		                    		<select class="form-control form-control-sm" id="fmt-cbndocente" name="fmt-cbndocente">
		                    			<option value=""></option>
				                      	<?php foreach ($docentes as $docente) {
				                      		$nomdocente = $docente->paterno . ' ' . $docente->materno . ' ' . $docente->nombres;
				                      	?>
				                      	<option value="<?php echo $docente->coddocente ?>"><?php echo $nomdocente ?></option>
				                      	<?php } ?>
		                    		</select>
		                    		<label for="fmt-cbndocente"> Docente</label>
		                  		</div>
		                  		<div class="form-group has-float-label col-12 col-sm-6 col-md-4">
		                  			<input type="number" name="fmt-cbnnotafinal" id="fmt-cbnnotafinal" class="form-control form-control-sm" placeholder="Nota final">
		                  			<label for="fmt-cbnnotafinal"> Nota final</label>
		                  		</div>
		                  		<div class="form-group has-float-label col-12 col-sm-6 col-md-4">
		                  			<input type="number" name="fmt-cbnnotarecup" id="fmt-cbnnotarecup" class="form-control form-control-sm" placeholder="Recuperación">
		                  			<label for="fmt-cbnnotarecup"> Recuperación</label>
		                  		</div>
		                  		<div class="form-group has-float-label col-12 col-sm-6 col-md-4">
		                  			<input type="date" name="fmt-cbnfecha" id="fmt-cbnfecha" class="form-control form-control-sm" value="<?php echo $fechahoy ?>">
		                  			<label for="fmt-cbnfecha"> Fecha</label>
		                  		</div>

		                  		<div id="divcontent_convalida" class="border border-dark rounded p-2 col-12 mb-2 d-none">
		                  			<span class="font-weight-bold">CONVALIDACIÓN</span>
		                  			<div class="row mt-2">
		                  				<div class="form-group has-float-label col-12 col-sm-6 col-md-6">
				                  			<input type="text" name="fmt-cbnresolucion" id="fmt-cbnresolucion" class="form-control form-control-sm" placeholder="Resolución">
				                  			<label for="fmt-cbnresolucion"> Resolución</label>
				                  		</div>
				                  		<div class="form-group has-float-label col-12 col-sm-6 col-md-6">
				                  			<input type="date" name="fmt-cbnfechaconv" id="fmt-cbnfechaconv" class="form-control form-control-sm">
				                  			<label for="fmt-cbnfechaconv"> Fecha Convalida</label>
				                  		</div>
		                  			</div>
		                  		</div>
		                  		
		                  		<div class="form-group has-float-label col-12">
		                  			<textarea name="fmt-cbnobservacion" id="fmt-cbnobservacion" class="form-control form-control-sm" placeholder="Observación" rows="3"></textarea>
		                  			<label for="fmt-cbnobservacion"> Observación</label>
		                  		</div>
		                  		<div class="col-12">
		                  			<button type="submit" class="btn btn-primary btn-sm float-right">Guardar</button>
		                  		</div>
		                  	</div>
		                  	
	                	</form>
	                </div>
                </div>
                <div class="modal-footer" id="vw_dp_mdcarga_footer_boleta">
                	<span id="fmt_conteo_modal" class="form-text text-primary float-left border">
	                    		
	                </span>
	                	
	                <button type="button" class="btn btn-secondary float-left" data-dismiss="modal">Salir</button>
	                   
	                <a href="#" target="_blank" id="vw_dp_em_btnimp_boleta" data-codigo='' class="btn btn-info float-right">
	                     <i class="fas fa-print mr-1"></i> Boleta de notas
	                </a>
	                <button type="button" id="vw_dp_em_btnguardar" data-codigo='' class="btn btn-primary float-right">
	                	<i class="fas fa-save mr-1"></i>Guardar Notas
	                </button>
                </div>
                
            </div>
        </div>
    </div>

	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>Matriculados</h1>
        		</div>
      		</div>
    	</div>
  	</section>

  	<section id="s-cargado" class="content">
  		<div id="divcard-matricular" class="card">
  			<div class="card-header">
		        <h3 class="card-title"><i class="fas fa-list"></i> Lista matriculas</h3>
		     </div>
		     <div class="card-body">
		     	<div class="row-fluid">
	              	<form id="frmfiltro-matriculas" name="frmfiltro-matriculas" action="<?php echo $vbaseurl ?>matricula_independiente/fn_filtrar" method="post" accept-charset='utf-8'>
	                	<div class="row">
	                  		<div class="form-group has-float-label col-12 col-sm-6 col-md-2">
	                    		<select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbperiodo" name="fmt-cbperiodo" placeholder="Periodo">
			                      	<option value="%"></option>
			                      	<?php foreach ($periodos as $periodo) {?>
			                      	<option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
		                      		<?php } ?>
	                    		</select>
	                    		<label for="fmt-cbperiodo"> Periodo</label>
	                  		</div>
	                  
			                <div class="form-group has-float-label col-12 col-sm-6 col-md-3">
			                    <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbcarrera" name="fmt-cbcarrera" placeholder="Programa Académico" >
			                      	<option value="%"></option>
			                      	<?php foreach ($carreras as $carrera) {?>
			                      	<option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
			                      	<?php } ?>
			                    </select>
			                    <label for="fmt-cbcarrera"> Prog. de Estudios</label>
			                </div>

	                  		<div class="form-group has-float-label col-12 col-sm-6 col-md-3">
			                    <select name="fmt-cbplan" id="fmt-cbplan"class="form-control form-control-sm">
			                      	<option data-carrera="0" value="%"></option>
			                      	<?php foreach ($planes as $pln) {
			                        	echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
			                      	} ?>
			                    </select>
	                    		<label for="fmt-cbplan">Plan estudios</label>
	                  		</div>

		                  	<div class="form-group has-float-label col-12 col-sm-6 col-md-1">
			                    <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbciclo" name="fmt-cbciclo" placeholder="Ciclo" >
			                      	<option value="%"></option>
			                      	<?php foreach ($ciclos as $ciclo) {?>
			                      	<option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
			                      	<?php } ?>
			                    </select>
			                    <label for="fmt-cbciclo"> Ciclo</label>
		                  	</div>
		                  	<div class="form-group has-float-label col-12 col-sm-6 col-md-2">
			                    <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbturno" name="fmt-cbturno" placeholder="Turno" >
			                      	<option value="%"></option>
			                      	<?php foreach ($turnos as $turno) {?>
			                      	<option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
			                      	<?php } ?>
			                    </select>
			                    <label for="fmt-cbturno"> Turno</label>
		                  	</div>
		                  	<div class="form-group has-float-label col-12 col-sm-6 col-md-1">
			                    <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbseccion" name="fmt-cbseccion" placeholder="Sección" >
			                      	<option value="%"></option>
			                      	<?php foreach ($secciones as $seccion) {?>
			                      	<option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
			                      	<?php } ?>
			                    </select>
			                    <label for="fmt-cbseccion"> Sección</label>
		                  	</div>
		                  	<div class="form-group has-float-label col-12 col-sm-7 col-md-9">
			                    <input class="form-control form-control-sm text-uppercase text-sm" autocomplete="off" id="fmt-alumno" name="fmt-alumno" placeholder="Carné o Apellidos y nombres" >
			                    <label for="fmt-alumno"> Carné o Apellidos y nombres</label>
		                  	</div>
		                  	<div class="col-6 col-sm-2 col-md-1">
		                    	<button type="submit" class="btn btn-primary btn-block btn-sm"><i class="fas fa-search"></i></button>
		                  	</div>
		                  	<div class="col-6 col-sm-3 col-md-2">
		                    	<a href="#" class="btn-excel btn btn-outline-secondary btn-sm"><img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt=""> Exportar</a>
		                  	</div>
	                	</div>
	              	</form>
	            </div>
	            <small id="fmt-conteo" class="form-text text-primary">
            
            	</small>
            	<div class="col-12 px-0 pt-2">
	              	<div class="btable">
	                	<div class="thead col-12  d-none d-md-block">
	                  		<div class="row">
			                    <div class="col-md-2">
			                      	<div class="row">
			                        	<div class="col-md-3 td">N°</div>
			                        	<div class="col-md-9 td">CARNÉ</div>
			                      	</div>
			                    </div>
	                    		<div class="col-md-3 td">ALUMNO</div>
			                    <div class="col-md-2">
			                      	<div class="row">
			                        	<div class="col-md-4 td">PER.</div>
			                        	<div class="col-md-4 td">PLAN</div>
			                        	<div class="col-md-4 td">PROG.</div>
			                      	</div>
			                    </div>
			                    <div class="col-md-2">
			                      	<div class="row">
			                        	<div class="col-md-4 td">CIC.</div>
			                        	<div class="col-md-4 td">TUR.</div>
			                        	<div class="col-md-4 td">SEC.</div>
			                      	</div>
			                    </div>
			                    <div class="col-md-2">
			                      	<div class="row">
			                        	<div class="col-md-5 td">EST.</div>
			                        	<div class="col-md-7 td">FICHA</div>
			                      	</div>
			                    </div>
			                    <div class="col-md-1">
			                      	<div class="row">
			                        	<div class="col-md-12 td">CARGA</div>
			                      	</div>
			                    </div>
	                  		</div>
	                	</div>
		                <div id="div-filtro" class="tbody col-12">
		                  
		                </div>
	              	</div>

	              	<div id="page-selection" class="text-center pagination-page"></div>

	            </div>
		    </div>
  		</div>
  	</section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>
<script src='<?php echo $vbaseurl ?>resources/dist/js/jquery.bootpag.min.js'></script>
<script>

	$('#frmfiltro-matriculas #fmt-cbcarrera').change(function(event) {
	    var codcar = $(this).val();
	    if (codcar=="%"){
	      $("#frmfiltro-matriculas #fmt-cbplan option").each(function(i){
	          if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');           
	      });
	    }
	    else{
	      $("#frmfiltro-matriculas #fmt-cbplan option").each(function(i){
	    
	        if ($(this).data('carrera')=='0'){
	            //if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
	          }
	          else if ($(this).data('carrera')==codcar){
	            $(this).removeClass('ocultar');
	          }
	          else{
	            if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
	          }
	      });
	    }
	});

	$(".btn-excel").click(function(e) {
	  	e.preventDefault();
	  
	  	var url=base_url + 'academico/matriculas/excel?cp=' + $("#fmt-cbperiodo").val() + '&cc=' + $("#fmt-cbcarrera").val() + '&ccc=' + $("#fmt-cbciclo").val() + '&ct=' + $("#fmt-cbturno").val() + '&cs=' + $("#fmt-cbseccion").val() + '&cpl=' + $("#fmt-cbplan").val() + '&ap=' + $("#fmt-alumno").val();
	  	var ejecuta=true;
	  
	  	if (ejecuta==true) window.open(url, '_blank');
	});

	function paginacionmatriculas(cantidad) {
        var pagtotal = Math.round(cantidad / 50);
        
        if (pagtotal > 0) {
            $('#page-selection').bootpag({
                total: pagtotal,
                page: 1,
                maxVisible: 3,
                wrapClass: "pages",
                disabledClass: "not-active"
            }).on("page", function(event, num){
                matriculaspages(num);

            });
        } else {
            $('#page-selection').html('');
        }
    }

    function matriculaspages(pagina){
        var limite = "50";
        var inicio = (pagina - 1) * limite;
        var fmcbperiodo = $('#fmt-cbperiodo').val();
        var fmcbcarrera = $('#fmt-cbcarrera').val();
        var fmcbciclo = $('#fmt-cbciclo').val();
        var fmcbturno = $('#fmt-cbturno').val();
        var fmcbseccion = $('#fmt-cbseccion').val();
        var fmcbplan = $('#fmt-cbplan').val();
        var fmalumno = $('#fmt-alumno').val();
        $.ajax({
            url :   base_url + "matricula_independiente/fn_filtrar_x_pagina",
            method: "POST",
            dataType: 'json',
            data : {
            	fmt_cbperiodo:fmcbperiodo,
            	fmt_cbcarrera:fmcbcarrera,
            	fmt_cbciclo:fmcbciclo,
            	fmt_cbturno:fmcbturno,
            	fmt_cbseccion:fmcbseccion,
            	fmt_cbplan:fmcbplan,
            	fmt_alumno:fmalumno,
            	inicio:inicio, 
            	limite:limite
            },
            success :   function(e){
                if (e.status == false) {} else {
                	var nro = 0;
	                var mt = 0;
	                var ac = 0;
	                var rt = 0;
	                var cl = 0;
	                var cd1=base64url_encode("1");
	                var cd2=base64url_encode("2");
	                var tabla = "";
	                $.each(e.vdata, function(index, v) {
	                    /* iterate through array or object */
	                    nro++;
	                    mt = mt + parseInt(v['mat']);
	                    ac = ac + parseInt(v['act']);
	                    rt = rt + parseInt(v['ret']);
	                    cl = cl + parseInt(v['cul']);
	                    var vcm = base64url_encode(v['codigo']);
	                    //var url = base_url + "academico/matricula/imprimir/" + vcm;
	                    var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
	                    var btnscolor="";
	                    switch(v['estado']) {
	                      case "ACT":
	                          btnscolor="btn-success";
	                        break;
	                      case "CUL":
	                        btnscolor="btn-secondary";
	                        break;
	                      case "RET":
	                        btnscolor="btn-danger";
	                        break;
	                      default:
	                        btnscolor="btn-warning";
	                    }
	                    
	                    tabla = tabla +
	                        '<div data-idm="' + vcm + '" class="cfila row ' + rowcolor + ' ">' +
	                          '<div class="col-4 col-md-2">' +
	                            '<div class="row">' +
	                              '<div class="col-3 col-md-3 td">' + nro + '</div>' +
	                              '<div class="ccarne col-9 col-md-9 td">' + v['carne'] + '</div>' +
	                            '</div>' +
	                          '</div>' +
	                          '<div class="calumno col-8 col-md-3 td">' + v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + '</div>' +
	                          '<div class="col-6 col-md-2">' +
	                            '<div class="row">' +
	                              '<div data-cp="' + v['codperiodo'] + '" class="cperiodo col-4 col-md-4 td">' + v['periodo'] + '</div>' +
	                              '<div class="col-4 col-md-4 td text-center">' + v['codplan'] + '</div>' +
	                              '<div class="ccarrera col-4 col-md-4 td" data-cod="' + v['codcarrera'] + '">' + v['sigla'] + '</div>' +
	                            '</div>' +
	                          '</div>' +
	                          '<div class="col-6 col-md-2">' +
	                            '<div class="row">' +
	                              '<div class="cciclo td col-4 col-md-4 text-center " data-cod="' + v['codciclo'] + '">' + v['ciclo'] + '</div>' +
	                              '<div class="cturno td col-4 col-md-4 text-center ">' + v['codturno'] + '</div>' +
	                              '<div class="cseccion td col-4 col-md-4 text-center ">' + v['codseccion'] + '</div>' +
	                            '</div>' +
	                          '</div>' +
	                          '<div class="col-8 col-md-2">' +
	                            '<div class="row">' +
	                              '<div class="td col-6 col-md-5 text-bold">' + 
	                                '<div class="btn-group">' + 
	                                  '<button class="btn ' + btnscolor + ' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
	                                    v['estado'] +
	                                  '</button>' +
	                                  '<div class="dropdown-menu">' +
	                                    '<a href="#" class="btn-cestado dropdown-item" data-ie="' + cd1 + '">Activo</a>' +
	                                    '<a href="#" class="btn-cestado dropdown-item"  data-ie="' + cd2 + '">Retirado</a>' +
	                                    '<div class="dropdown-divider"></div>' +
	                                    '<a href="#" class="btn-ematricula dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>' +
	                                  ' </div>' +
	                                '</div>' +
	                              '</div>' +

	                              '<div class="td col-6 col-md-7 text-bold">' + 
	                                '<div class="btn-group dropleft">' + 
	                                  '<button class="btn btn-info btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
	                                    '<i class="fas fa-file-invoice"></i> Ficha' +
	                                  '</button>' +
	                                  '<div class="dropdown-menu">' +
	                                    '<a target="_blank" href="' + base_url + "academico/matricula/independiente/ficha/imprimir/" + vcm + '" class="dropdown-item"><i class="far fa-file-pdf text-danger mr-2"></i>PDF</a>' +
	                                    '<a href="' + base_url +  'academico/matricula/independiente/ficha/excel/' + vcm + '" class="dropdown-item" ><i class="far fa-file-excel text-success mr-2"></i>Excel</a>' +
	                                    
	                                  ' </div>' +
	                                '</div>' +
	                              '</div>' +
	                            '</div>' +
	                            '</div>' +

	                            '<div class="td col-4 col-md-1 p-2">'+
	                            	'<a class="bg-primary text-white py-1 px-2 mt-2 rounded btncall-carga" data-cm=' + vcm + ' data-prog='+v['codcarrera']+' data-periodo='+v['codperiodo']+' data-ciclo='+v['codciclo']+' data-turno='+v['codturno']+' data-seccion='+v['codseccion']+' href="#" title="Carga académica" data-toggle="modal" data-target="#modmatriculacurso">'+
	                            		'<i class="fas fa-book"></i> Carga'+
	                            	'</a>'+
	                            	'</div>' +
	                            '</div>' +
	                           
	                          '</div>' +
	                        '</div>';
	                });
	                $("#div-filtro").html(tabla);
	                
	                $("#fmt-conteo").html(e.items + ' matriculas encontradas');
	                $('#divcard-matricular #divoverlay').remove();
	                //********************************************/
	                
	                $(".btn-cestado").click(function(event) {
	                  
	                  	var im=$(this).parents(".cfila").data('idm');
	                  	var ie=$(this).data('ie');
	                  
	                  	var btdt=$(this).parents(".btn-group").find('.dropdown-toggle');
	                  	//var btdt=$(this).parents(".dropdown-toggle");
	                  	var texto=$(this).html();
	                  	//alert(btdt.html());
	                  	$('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	                  	$.ajax({
	                      	url: base_url + 'matricula/fn_cambiarestado',
	                      	type: 'post',
	                      	dataType: 'json',
	                      	data: {
                              	'ce-idmat': im,
                              	'ce-nestado':ie
	                        },
	                      	success: function(e) {
	                          	$('#divcard-matricular #divoverlay').remove();
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
	                                  	title: 'Felicitaciones, estado actualizado',
	                                  	text: 'Se ha actualizado el estado',
	                                  	backdrop: false,
	                              	})
	                              
		                            btdt.removeClass('btn-danger');
		                            btdt.removeClass('btn-success');
		                            btdt.removeClass('btn-warning');
		                            btdt.removeClass('btn-secondary');
	                              	switch(texto) {
	                                	case "Activo":
	                                    	btdt.addClass('btn-success');
	                                    	btdt.html("ACT");
	                                  		break;
	                                
		                                case "Retirado":
		                                  	btdt.addClass('btn-danger');
		                                  	btdt.html("RET");
		                                  	break;
		                                default:
	                                  	btnscolor="btn-warning";
	                              	}
	                              //btdt.addClass('class_name');
	                              //mostrarCursos("div-cursosmat", "", e.vdata);
	                          	}
	                      	},
	                      	error: function(jqXHR, exception) {
	                          	var msgf = errorAjax(jqXHR, exception, 'text');
	                          	$('#divcard-matricular #divoverlay').remove();
	                          	Swal.fire({
	                              	type: 'error',
	                              	icon: 'error',
	                              	title: 'Error',
	                              	text: msgf,
	                              	backdrop: false,
	                          	})
	                      	}
	                  	});
	                  	return false;
	              	});

	              	$(".btn-ematricula").on("click", function() {
	                	$('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		                var fila=$(this).parents(".cfila");
		                var im=fila.data('idm');
		                var alumno = fila.find('.calumno').html();
	              
	                	//************************************
		                Swal.fire({
		                  	title: "Precaución",
		                  	text: "Se eliminarán las notas y asistencias del alumno " + alumno + ", en este curso: ",
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
			                      	url: base_url + 'matricula/fn_eliminar',
			                      	type: 'post',
			                      	dataType: 'json',
			                      	data: {
			                            'ce-idmat': im
			                        },
			                      	success: function(e) {
			                          	$('#divcard-matricular #divoverlay').remove();
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
			                                  	text: 'Se ha eliminado la matrícula',
			                                  	backdrop: false,
			                              	})
			                              
			                              	fila.remove();
			                          	}
			                      	},
	                      			error: function(jqXHR, exception) {
	                          			var msgf = errorAjax(jqXHR, exception, 'text');
	                          			$('#divcard-matricular #divoverlay').remove();
	                          			Swal.fire({
	                              			type: 'error',
	                              			icon: 'error',
	                              			title: 'Error',
	                              			text: msgf,
	                              			backdrop: false,
	                          			})
	                      			}
	                  			});
	                  		}
	                  		else{
	                  	   		$('#divcard-matricular #divoverlay').remove();
	                  		}
	                	});
	                	//***************************************
	              	});
                }
                // $("#divresult").html(e.vdata);
                
            }
        });
        // fn_search_matriculas(formulario, inicio, limite);
        
    }

	$("#frmfiltro-matriculas").submit(function(event) {
	    var inicio = 0;
	    var limite = 50;
	    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $("#div-filtro").html("");
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize() + "&txtinicio=" + inicio + "&txtlimite=" + limite,
	        success: function(e) {
	            if (e.status == false) {} else {

	            	paginacionmatriculas(e.items);

	                var nro = 0;
	                var mt = 0;
	                var ac = 0;
	                var rt = 0;
	                var cl = 0;
	                var cd1=base64url_encode("1");
	                var cd2=base64url_encode("2");
	                var tabla = "";
	                $.each(e.vdata, function(index, v) {
	                    /* iterate through array or object */
	                    nro++;
	                    mt = mt + parseInt(v['mat']);
	                    ac = ac + parseInt(v['act']);
	                    rt = rt + parseInt(v['ret']);
	                    cl = cl + parseInt(v['cul']);
	                    var vcm = base64url_encode(v['codigo']);
	                    var url = base_url + "academico/matricula/independiente/ficha/imprimir/" + vcm;
	                    var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
	                    var btnscolor="";
	                    switch(v['estado']) {
	                      case "ACT":
	                          btnscolor="btn-success";
	                        break;
	                      case "CUL":
	                        btnscolor="btn-secondary";
	                        break;
	                      case "RET":
	                        btnscolor="btn-danger";
	                        break;
	                      default:
	                        btnscolor="btn-warning";
	                    }
	                    tabla = tabla +
	                        '<div data-idm="' + vcm + '" class="cfila row ' + rowcolor + ' ">' +
	                          '<div class="col-4 col-md-2">' +
	                            '<div class="row">' +
	                              '<div class="col-3 col-md-3 td">' + nro + '</div>' +
	                              '<div class="ccarne col-9 col-md-9 td">' + v['carne'] + '</div>' +
	                            '</div>' +
	                          '</div>' +
	                          '<div class="calumno col-8 col-md-3 td">' + v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + '</div>' +
	                          '<div class="col-6 col-md-2">' +
	                            '<div class="row">' +
	                              '<div data-cp="' + v['codperiodo'] + '" class="cperiodo col-4 col-md-4 td">' + v['periodo'] + '</div>' +
	                              '<div class="col-4 col-md-4 td text-center">' + v['codplan'] + '</div>' +
	                              '<div class="ccarrera col-4 col-md-4 td" data-cod="' + v['codcarrera'] + '">' + v['sigla'] + '</div>' +
	                            '</div>' +
	                          '</div>' +
	                          '<div class="col-6 col-md-2">' +
	                            '<div class="row">' +
	                              '<div class="cciclo td col-4 col-md-4 text-center " data-cod="' + v['codciclo'] + '">' + v['ciclo'] + '</div>' +
	                              '<div class="cturno td col-4 col-md-4 text-center ">' + v['codturno'] + '</div>' +
	                              '<div class="cseccion td col-4 col-md-4 text-center ">' + v['codseccion'] + '</div>' +
	                            '</div>' +
	                          '</div>' +
	                          '<div class="col-8 col-md-2">' +
	                            '<div class="row">' +
	                              '<div class="td col-6 col-md-5 text-bold">' + 
	                                '<div class="btn-group">' + 
	                                  '<button class="btn ' + btnscolor + ' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
	                                    v['estado'] +
	                                  '</button>' +
	                                  '<div class="dropdown-menu">' +
	                                    '<a href="#" class="btn-cestado dropdown-item" data-ie="' + cd1 + '">Activo</a>' +
	                                    '<a href="#" class="btn-cestado dropdown-item"  data-ie="' + cd2 + '">Retirado</a>' +
	                                    '<div class="dropdown-divider"></div>' +
	                                    '<a href="#" class="btn-ematricula dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>' +
	                                  ' </div>' +
	                                '</div>' +
	                              '</div>' +

	                              '<div class="td col-6 col-md-7 text-bold">' + 
	                                '<div class="btn-group dropleft">' + 
	                                  '<button class="btn btn-info btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
	                                    '<i class="fas fa-file-invoice"></i> Ficha' +
	                                  '</button>' +
	                                  '<div class="dropdown-menu">' +
	                                    '<a target="_blank" href="' + url + '" class="dropdown-item"><i class="far fa-file-pdf text-danger mr-2"></i>PDF</a>' +
	                                    '<a href="' + base_url +  'academico/matricula/ficha/excel/' + vcm + '" class="dropdown-item" ><i class="far fa-file-excel text-success mr-2"></i>Excel</a>' +
	                                    
	                                  ' </div>' +
	                                '</div>' +
	                              '</div>' +
	                            '</div>' +
	                            '</div>' +

	                            '<div class="td col-4 col-md-1 p-2">'+
	                            	'<a class="bg-primary text-white py-1 px-2 mt-2 rounded btncall-carga" data-cm=' + vcm + ' data-prog='+v['codcarrera']+' data-periodo='+v['codperiodo']+' data-ciclo='+v['codciclo']+' data-turno='+v['codturno']+' data-seccion='+v['codseccion']+' href="#" title="Carga académica" data-toggle="modal" data-target="#modmatriculacurso">'+
	                            		'<i class="fas fa-book"></i> Carga'+
	                            	'</a>'+
	                            	'</div>' +
	                            '</div>' +
	                           
	                          '</div>' +
	                        '</div>';
	                });
	                $("#div-filtro").html(tabla);
	                
	                $("#fmt-conteo").html(e.items + ' matriculas encontradas');
	                $('#divcard-matricular #divoverlay').remove();
	                //********************************************/
	                
	                $(".btn-cestado").click(function(event) {
	                  
	                  	var im=$(this).parents(".cfila").data('idm');
	                  	var ie=$(this).data('ie');
	                  
	                  	var btdt=$(this).parents(".btn-group").find('.dropdown-toggle');
	                  	//var btdt=$(this).parents(".dropdown-toggle");
	                  	var texto=$(this).html();
	                  	//alert(btdt.html());
	                  	$('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	                  	$.ajax({
	                      	url: base_url + 'matricula/fn_cambiarestado',
	                      	type: 'post',
	                      	dataType: 'json',
	                      	data: {
                              	'ce-idmat': im,
                              	'ce-nestado':ie
	                        },
	                      	success: function(e) {
	                          	$('#divcard-matricular #divoverlay').remove();
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
	                                  	title: 'Felicitaciones, estado actualizado',
	                                  	text: 'Se ha actualizado el estado',
	                                  	backdrop: false,
	                              	})
	                              
		                            btdt.removeClass('btn-danger');
		                            btdt.removeClass('btn-success');
		                            btdt.removeClass('btn-warning');
		                            btdt.removeClass('btn-secondary');
	                              	switch(texto) {
	                                	case "Activo":
	                                    	btdt.addClass('btn-success');
	                                    	btdt.html("ACT");
	                                  		break;
	                                
		                                case "Retirado":
		                                  	btdt.addClass('btn-danger');
		                                  	btdt.html("RET");
		                                  	break;
		                                default:
	                                  	btnscolor="btn-warning";
	                              	}
	                              //btdt.addClass('class_name');
	                              //mostrarCursos("div-cursosmat", "", e.vdata);
	                          	}
	                      	},
	                      	error: function(jqXHR, exception) {
	                          	var msgf = errorAjax(jqXHR, exception, 'text');
	                          	$('#divcard-matricular #divoverlay').remove();
	                          	Swal.fire({
	                              	type: 'error',
	                              	icon: 'error',
	                              	title: 'Error',
	                              	text: msgf,
	                              	backdrop: false,
	                          	})
	                      	}
	                  	});
	                  	return false;
	              	});

	              	$(".btn-ematricula").on("click", function() {
	                	$('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		                var fila=$(this).parents(".cfila");
		                var im=fila.data('idm');
		                var alumno = fila.find('.calumno').html();
	              
	                	//************************************
		                Swal.fire({
		                  	title: "Precaución",
		                  	text: "Se eliminarán las notas y asistencias del alumno " + alumno + ", en este curso: ",
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
			                      	url: base_url + 'matricula/fn_eliminar',
			                      	type: 'post',
			                      	dataType: 'json',
			                      	data: {
			                            'ce-idmat': im
			                        },
			                      	success: function(e) {
			                          	$('#divcard-matricular #divoverlay').remove();
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
			                                  	text: 'Se ha eliminado la matrícula',
			                                  	backdrop: false,
			                              	})
			                              
			                              	fila.remove();
			                          	}
			                      	},
	                      			error: function(jqXHR, exception) {
	                          			var msgf = errorAjax(jqXHR, exception, 'text');
	                          			$('#divcard-matricular #divoverlay').remove();
	                          			Swal.fire({
	                              			type: 'error',
	                              			icon: 'error',
	                              			title: 'Error',
	                              			text: msgf,
	                              			backdrop: false,
	                          			})
	                      			}
	                  			});
	                  		}
	                  		else{
	                  	   		$('#divcard-matricular #divoverlay').remove();
	                  		}
	                	});
	                	//***************************************
	              	});
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divcard-matricular #divoverlay').remove();
	            //$('#divError').show();
	            //$('#msgError').html(msgf);
	        }
	    });
	    
	    return false;
	});

	$('#modmatriculacurso').on('show.bs.modal', function(e) {
		var rel=$(e.relatedTarget);
        var codigo = rel.data('cm');
        var programa = rel.data('prog');
        var periodo = rel.data('periodo');
        var ciclo = rel.data('ciclo');
        var turno = rel.data('turno');
        var seccion = rel.data('seccion');

        $('#fmt-cbncodmatricula').val(codigo);
        $('#vw_dp_em_btnimp_boleta').attr('href', base_url + "academico/matricula/independiente/boleta/imprimir/" +codigo );

        $('#fmt-cbncarrera').val(programa);
        $('#fmt-cbnperiodo').val(periodo);
        $('#fmt-cbnciclo').val(ciclo);
        $('#fmt-cbnturno').val(turno);
        $('#fmt-cbnseccion').val(seccion);
        $('#fmt-cbncarrera').change();
        get_matriculas_cursos(codigo);
        get_unidades('fmt-cbnciclo','fmt-cbnplan');
	});

	$('#modmatriculacurso').on('hidden.bs.modal', function(e) {
		$('#divcard_datamat').removeClass('d-none');
		$('#divcard_form_new').addClass('d-none');
		$('#btn_agregarnew').removeClass('d-none');
		$('#btncancelar').addClass('d-none');
		$('#fmt-cbncodmatcurso').val('0');
		$('#form_addmatricula')[0].reset();
		get_unidades('fmt-cbnciclo','fmt-cbnplan');
		//$('#vw_dp_em_btnguardar').show();
		$('#vw_dp_mdcarga_footer_boleta').show();
		
		$('#divcontent_convalida').addClass('d-none');
	})

	function get_matriculas_cursos(matricula) {
		$('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
	        url: base_url + "matricula_independiente/fn_filtrar_matricula",
	        type: 'post',
	        dataType: 'json',
	        data: {
	        	txtmatricula : matricula
	        },
	        success: function(e) {
	        	$('#divmodalnewmatricula #divoverlay').remove();
	        	if (e.status == true) {
                    $('#divcard_data_matricula_curso').html("");
                    var nro=0;
                    var tabla="";
                    if (e.vdata.length !== 0) {
                    	$('#fmt_conteo_modal').html(e.vdata.length + ' datos encontrados');
                    	$.each(e.vdata, function(index, val) {
                    		nro++;
                    		
                    		if (val['tipo']=="MANUAL" ){
                    			$colortipo="";
                    		}
                    		else if (val['tipo']=="PLATAFORMA" ){
                    			$colortipo="text-primary";
                    		}
                    		else{
                    			$colortipo="text-info";
                    		}
                    		anota=val['nota'] ;
                    		recuperacion=val['recuperacion'] ;
                    		colorbtn="text-danger";
							if (anota>=12.5) colorbtn="text-primary";
							colorbtnrc="text-danger";
							if (recuperacion>=12.5) colorbtnrc="text-primary";
                    		tabla=tabla +
                    		"<div class='row rowcolor cfila' data-idmatnf='"+val['codigo64']+"' data-codmiembro='"+val['codmiembro64']+"' data-final='"+anota+"' data-recupera='"+recuperacion+"'>"+
                                "<div class='col-6 col-md-2'>"+
                                    "<div class='row'>"+
                                    	"<div class='col-2 col-md-2 td'>"+nro+"</div>"+
                                    	"<div class='col-10 col-md-10 td'>"+val['codplan'] + " " +  val['plan']+"</div>"+
                                        
                                        
                                    "</div>"+
                                "</div>"+
                                "<div class='col-6 col-md-2 td'>"+
                                   
                                    		val['periodo'] + " " + val['sigla'] + " <b>" + val['codturno'] + "</b>  " + val['ciclo'] + "-" +val['codseccion']+
                                    	
                                   
                                "</div>"+
                                "<div class='col-6 col-md-3 td'>"+
                                   
                                    		val['codcurso'] + " " +  val['curso'] +
                                "</div>"+

                                "<div class='col-6 col-md-4'>"+
                                   "<div class='row'>" +
                                   		 "<div class='col-6 col-md-4 td text-center'>"+
		                                   	 "<input type='number' data-valor='" + anota + "' max='20' min='0' data-edit='0' class='nf_txt_final " + colorbtn + "' value='" + anota + "' data-idmat="+val['codigo64']+" data-ntsaved='"+anota+"' data-stnota='NF'>" +
		                                    
		                                "</div>"+
		                                "<div class='col-6 col-md-4 td text-center'>"+
		                                    	"<input type='number' data-valor='" + recuperacion + "' max='20' min='0' data-edit='0' class='nt_txt_recupera " + colorbtnrc + "' value='" + recuperacion + "' data-idmat="+val['codigo64']+" data-ntsaved='"+recuperacion+"' data-stnota='NR'>" +
		                                "</div>"+
		                                "<div class='col-6 col-md-4 td text-center'>"+
		                                    	"<select class='w100 nf_estado'>" +
		                                    		"<option value='-'> -- </option> "+
		                                    		"<option value='NSP'>NSP</option> "+
		                                    		"<option value='DPI'>DPI</option> "+
		                                    	"</select>" +
		                                "</div>"+
		                            "</div>"+
                                "</div>"+

                               
                                "<div class='col-6 col-md-1 text-center'>"+
                                    "<div class='row'>"+
                                        "<div class='col-12 col-sm-12 col-md-12 td'>"+
                                            "<div class='col-12 pt-1 pr-3 text-center'>"+
                                                "<div class='btn-group'>"+
                                                    "<a type='button' class='text-white bg-warning dropdown-toggle px-2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                        "<i class='fas fa-cog'></i>"+
                                                    "</a>"+
                                                    "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                        "<a class='dropdown-item editmatcurso' href='#' title='Editar' data-idmatc='"+val['codigo64']+"'>"+
                                                            "<i class='fas fa-edit mr-1'></i> Editar"+
                                                        "</a>"+
                                                        "<a class='dropdown-item text-danger delregistro' href='#' title='Eliminar' data-idmatc='"+val['codigo64']+"'>"+
                                                            "<i class='fas fa-trash mr-1'></i> Eliminar"+
                                                        "</a>"+
                                                    "</div>"+
                                                "</div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>";
                    	})

                    } else {
                    	$('#fmt_conteo_modal').html('No se encontraron resultados');
                    }

                    $('#divcard_data_matricula_curso').html(tabla);
                } else {
                	var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#divcard_data_matricula_curso').html(msgf);
                }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divmodalnewmatricula #divoverlay').remove();
	            //$('#divError').show();
	            //$('#msgError').html(msgf);
	        }
	    });
	}

	$('#btn_agregarnew').click(function() {
		$('#divcard_datamat').addClass('d-none');
		$('#divcard_form_new').removeClass('d-none');
		$('#btn_agregarnew').addClass('d-none');
		$('#btncancelar').removeClass('d-none');
		$('#vw_dp_mdcarga_footer_boleta').hide();
	});

	$('#btncancelar').click(function() {
		$('#divcard_datamat').removeClass('d-none');
		$('#divcard_form_new').addClass('d-none');
		$('#btn_agregarnew').removeClass('d-none');
		$('#btncancelar').addClass('d-none');
		$('#fmt-cbncodmatcurso').val('0');
		$('#vw_dp_mdcarga_footer_boleta').show();
		$('#divcontent_convalida').addClass('d-none');
		$('#form_addmatricula')[0].reset();
	});

	$('#fmt-cbncarrera').change(function(event) {
		if ($(this).val()!="0"){
			$('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

			$('#fmt-cbnplan').html("<option value='0'>Sin opciones</option>");
	        var codcar = $(this).val();
	        if (codcar == '0') return;
	        $.ajax({
	            url: base_url + 'plancurricular/fn_get_planes_activos_combo',
	            type: 'post',
	            dataType: 'json',
	            data: {
	                txtcodcarrera: codcar
	            },
	            success: function(e) {
	            	$('#divmodalnewmatricula #divoverlay').remove();
	                $('#fmt-cbnplan').html(e.vdata);
	                $("#fmt-cbnplan").val(getUrlParameter("cpl",0));
	            },
	            error: function(jqXHR, exception) {
	            	$('#divmodalnewmatricula #divoverlay').remove();
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#fmt-cbnplan').html("<option value='0'>" + msgf + "</option>");
	            }
	        });
		}
		else{
			$('#fmt-cbnplan').html("<option value='0'>Selecciona un programa<option>");
		}
	});

	function get_unidades(ciclo, plan) {
		if ($('#'+ciclo).val()!="0" && $('#'+plan).val()!="0"){
			$('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

			$('#fmt-cbnunididact').html("<option value='0'>Sin opciones</option>");
	        var ciclo = $('#'+ciclo).val();
	        var plan = $('#'+plan).val();
	        if (ciclo == '0' && plan == '0') return;
	        $.ajax({
	            url: base_url + 'matricula_independiente/fn_get_unidades_combo',
	            type: 'post',
	            dataType: 'json',
	            data: {
	                txtcodciclo: ciclo,
	                txtcodplan: plan,
	            },
	            success: function(e) {
	            	$('#divmodalnewmatricula #divoverlay').remove();
	                $('#fmt-cbnunididact').html(e.vdata);
	                $("#fmt-cbnunididact").val(getUrlParameter("cpl",0));
	            },
	            error: function(jqXHR, exception) {
	            	$('#divmodalnewmatricula #divoverlay').remove();
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#fmt-cbnunididact').html("<option value='0'>" + msgf + "</option>");
	            }
	        });
		}
		else{
			$('#fmt-cbnunididact').html("<option value='0'>Selecciona un plan curricular y ciclo<option>");
		}
	}

	$('#form_addmatricula').submit(function() {
		$('#form_addmatricula input,select').removeClass('is-invalid');
        $('#form_addmatricula .invalid-feedback').remove();
		$('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    // $("#div-filtro").html("");
	    $.ajax({
	        url: base_url + 'matricula_independiente/fn_insert_update',
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	        	$('#divmodalnewmatricula #divoverlay').remove();
	        	if (e.status == false) {
	        		$.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });

	        		Swal.fire({
	                  	type: 'error',
	                  	icon: 'error',
	                  	title: 'Error!',
                      	text: 'Existen errores en los campos',
                      	backdrop: false,
	                })
	        	} else {
	        		Swal.fire({
	                  	type: 'success',
	                  	icon: 'success',
	                  	title: 'Éxito!',
                      	text: e.msg,
                      	backdrop: false,
	                }).then((result) => {
                  		if (result.value) {
                  			// $('#modmatriculacurso').modal('hide');
                  			get_matriculas_cursos(e.idmatricula);
                  			get_unidades('fmt-cbnciclo','fmt-cbnplan');
                  			$('#divcard_datamat').removeClass('d-none');
							$('#divcard_form_new').addClass('d-none');
							$('#btn_agregarnew').removeClass('d-none');
							$('#btncancelar').addClass('d-none');

							//$('#vw_dp_em_btnguardar').show();
							$('#vw_dp_mdcarga_footer_boleta').show();
							$('#divcontent_convalida').addClass('d-none');
                  		}
                  	})
	        	}
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divmodalnewmatricula #divoverlay').remove();
	            Swal.fire({
                  	type: 'error',
                  	icon: 'error',
                  	title: 'Error!',
                  	text: msgf,
                  	backdrop: false,
                })
	        }
	    });
	    return false;
	});

	$(document).on("click", ".editmatcurso",function() {
		var codigo = $(this).data('idmatc');
		//$('#vw_dp_em_btnguardar').hide();
		$('#vw_dp_mdcarga_footer_boleta').hide();
		$('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		$.ajax({
            url: base_url + 'matricula_independiente/fn_get_matriculacurso_codigo',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodigo: codigo,
            },
            success: function(e) {
            	
            	if (e.status == true) {
            		$('#divcard_datamat').addClass('d-none');
					$('#divcard_form_new').removeClass('d-none');
					$('#btn_agregarnew').addClass('d-none');
					$('#btncancelar').removeClass('d-none');
					$('#fmt-cbncodmatricula').val(e.vdata['codmatric64']);
	                $('#fmt-cbncargaacadem').val(e.vdata['idcarga']);
	                $('#fmt-cbncargaacadsubsec').val(e.vdata['codsubsec']);
	                $('#fmt-cbtipo').val(e.vdata['tipo']);
	                $('#fmt-cbnperiodo').val(e.vdata['idperiodo']);
	                $('#fmt-cbncarrera').val(e.vdata['idcarrera']);
	                $('#fmt-cbnplan').val(e.vdata['codplan']);
	                $('#fmt-cbnciclo').val(e.vdata['idciclo']);
	                $('#fmt-cbnturno').val(e.vdata['idturno']);
	                $('#fmt-cbnseccion').val(e.vdata['idseccion']);
	                $('#fmt-cbnfecha').val(e.vdata['fechaf']);
	                
	                $('#fmt-cbndocente').val(e.vdata['codocente']);
	                $('#fmt-cbnresolucion').val(e.vdata['valida']);
	                $('#fmt-cbnobservacion').val(e.vdata['observacion']);
	                $('#fmt-cbnnotafinal').val(e.vdata['notaf']);
	                $('#fmt-cbncodmatcurso').val(e.vdata['codigo64']);

	                if (e.vdata['vfecha'] !== null) {
	                	$('#fmt-cbnfechaconv').val(e.vdata['vfecha']);
	                }

	                if (e.vdata['notar'] !== null) {
	                	$('#fmt-cbnnotarecup').val(e.vdata['notar']);
	                }

	                setTimeout(function() {
				        get_unidades('fmt-cbnciclo','fmt-cbnplan');
				    },500);

	                setTimeout(function() {
				        $('#fmt-cbnunididact').val(e.vdata['idunidad']);
				        $('#divmodalnewmatricula #divoverlay').remove();
				    },1000);

				    $('#fmt-cbtipo').change();
            	}
            },
            error: function(jqXHR, exception) {
            	$('#divmodalnewmatricula #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
		return false;
	})

	$(document).on('click', '.delregistro', function() {
		var codigo = $(this).data('idmatc');
		Swal.fire({
			title: '¿Está seguro de eliminar este registro?',
			text: "¡Si no lo está puede cancelar la acción!",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        allowOutsideClick: false,
	        cancelButtonText: 'Cancelar',
	        confirmButtonText: 'Si, eliminar!'
		}).then(function(result){
			if(result.value){
				$('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
				$.ajax({
		            url: base_url + 'matricula_independiente/fn_delete_matricula_curso',
		            type: 'post',
		            dataType: 'json',
		            data: {
		                txtcodigo: codigo,
		            },
		            success: function(e) {
		            	$('#divmodalnewmatricula #divoverlay').remove();
		            	if (e.status == true) {
		            		Swal.fire({
			                    title: 'Éxito!',
			                    text: e.msg,
			                    type: 'success',
			                    icon: 'success',
			                    allowOutsideClick: false,
			                })

			                get_matriculas_cursos(codigo);
			                get_unidades('fmt-cbnciclo','fmt-cbnplan');
		            	}
		            },
		            error: function(jqXHR, exception) {
		            	$('#divmodalnewmatricula #divoverlay').remove();
		                var msgf = errorAjax(jqXHR, exception, 'text');
		                Swal.fire({
		                    title: msgf,
		                    // text: "",
		                    type: 'error',
		                    icon: 'error',
		                })
		            }
		        });
			}
		})
		
		return false;
	});

	$(document).on("blur", ".cfila input", function(event) {
		if ($(this).data('ntsaved') != $(this).val()) {

	        $(this).data('edit', '1');
	    }
	    else{
	        $(this).data('edit', '0');
	    }

	    if ($(this).val() > 12) {
	        $(this).removeClass('text-danger');
	        $(this).addClass('text-primary');
	    } else {
	        $(this).removeClass('text-primary');
	        $(this).addClass('text-danger');
	    }
	})

	$('#vw_dp_em_btnguardar').click(function() {
		arrdata = [];
		var nerror=0;
		var edits=0;
  		$('#divcard_data_matricula_curso .cfila').each(function() {
  			var codmat=$(this).data("idmatnf");
  			var codmiembro=$(this).data("codmiembro");
  			var notfin = ($(this).data('final')==null) ? "": $(this).data('final');
        	var notrec = ($(this).data('recupera')==null) ? "": $(this).data('recupera');
  			var notfin_txt=$(this).find(".nf_txt_final").val();
	        var notrec_txt=$(this).find(".nt_txt_recupera").val();
	        var estado=$(this).find(".nf_estado").val();
	        
	        var isedit ='0';
	        
	        if ((notfin!=notfin_txt) ||(notrec!=notrec_txt)){
	            notfin=notfin_txt;
	            notrec=notrec_txt;
	            isedit="1";
	           
	            //arrdata.push(myvals);
	        }
			
			
	        
	       
	        
	        if (isedit == "1") {

	        	if ((notfin_txt < 0)||(notfin_txt > 20)) {
	            	nerror++	
	        	}
	        	else if ((notrec_txt < 0)||(notrec_txt > 20)) {
	            	nerror++	
	        	}
		        else{
		        	 var myvals = [codmat, estado, notfin, notrec, codmiembro];
	            	arrdata.push(myvals);
		        }
		        edits++;
	        }

	    });
  		
  		if (nerror==0){

  			if (edits>0){
  				$.ajax({
  					url: base_url + 'matricula_independiente/fn_update_notas_final_recuperacion',
	                type: 'post',
	                dataType: 'json',
	                data: {
	                    filas: JSON.stringify(arrdata),
	                },
	                success: function(e) {
	                    $('#divboxevaluaciones #divoverlay').remove();
	                    if (e.status == false) {
	                        Swal.fire({
	                            type: 'error',
	                            icon: 'error',
	                            title: 'ERROR, NO se guardó cambios',
	                            text: e.msg,
	                            backdrop:false,
	                        });
	                    } else {
	                    	/*$('.txtnota').each(function() {

                                if ($(this).data('edit')=='1'){
                                    $(this).data('edit',  '0');
                                }
                                
                            });*/
	                        
	                        Swal.fire({
	                            type: 'success',
	                            icon: 'success',
	                            title: 'ÉXITO, Se guardó cambios',
	                            text: "Lo cambios fueron guardados correctamente",
	                            backdrop:false,
	                        });

	                        var idmatricula = $('#fmt-cbncodmatricula').val();
	                        get_matriculas_cursos(idmatricula);
	                    }
	                },
	                error: function(jqXHR, exception) {
	                    var msgf = errorAjax(jqXHR, exception,'text');
	                    Swal.fire({
	                        type: 'error',
	                        icon: 'error',
	                        title: 'ERROR, NO se guardó cambios',
	                        text: msgf,
	                        backdrop:false,
	                    });
	                },
  				})

  			} 
  			else {
  				Swal.fire({
	                type: 'success',
	                icon: 'success',
	                title: 'ÉXITO, Se guardó cambios (M)',
	                text: "Lo cambios fueron guardados correctamente",
	                backdrop:false,
	            });

	            $('#divboxevaluaciones #divoverlay').remove();
  			}
  		}
  		else{

	        Swal.fire({
	            type: 'error',
	            icon: 'error',
	            title: 'ERROR, Notas Invalidas',
	            text: "Existen " + nerror + " error(es): NOTA NO VÁLIDA (Rojo)",
	            backdrop:false,
	        });

	        $('#divboxevaluaciones #divoverlay').remove();
	    }
	});

	$('#fmt-cbtipo').change(function(event) {
        var item = $(this);
        var tipo = item.find(':selected').data('tipo');

        if (tipo === "CONVALIDA") {

            $('#divcontent_convalida').removeClass('d-none');
           
        } else {

            $('#divcontent_convalida').addClass('d-none');
            
        }
    });

</script>