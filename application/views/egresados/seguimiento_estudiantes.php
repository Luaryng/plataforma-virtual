<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/tbrespons/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/tbrespons/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/tbrespons/css/buttons.dataTables.min.css">
<style type="text/css">
	div.dt-buttons {
		float: right;
		margin-top: -10px;
	}
	.btn-excel {
		color: #fff !important;
	    background-color: #17a2b8 !important;
	    border-color: #17a2b8 !important;
	    background-image: -webkit-linear-gradient(top, #17a2b8 0%, #e9e9e9 100%) !important;
	    background-image: -moz-linear-gradient(top, #17a2b8 0%, #e9e9e9 100%) !important;
	    background-image: -ms-linear-gradient(top, #17a2b8 0%, #e9e9e9 100%) !important;
	    background-image: -o-linear-gradient(top, #17a2b8 0%, #e9e9e9 100%) !important;
	    background-image: linear-gradient(to bottom, #17a2b8 0%, #e9e9e9 100%) !important;
	}
</style>
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>ESTUDIANTES
					<small> Seguimiento</small></h1>
				</div>
			</div>
		</div>
	</section>
	<section class="content">
		<div id="divboxdatos" class="card card-success">
			<div class="card-body">
				<table class="table table-bordered table-striped dt-responsive tablaEstudiantes" width="100%">
                
	                <thead>

	                  	<tr>

	                    	<th style="width:10px">#</th> 
	                    	<th>Apellidos y Nombres</th>
	                    	<th>Dni</th>
	                    	<th>Teléfono</th>
	                    	<th>Email</th>
	                    	<th>Programa</th>
	                    	<th>Año Ingreso</th>
	                    	<th>Semestre</th>
	                    	<th>Módulo</th>
	                    	<th>Sugerencia</th>
	                  	</tr>   

	                </thead>

	                <tbody>
	                 
	                </tbody>

	            </table>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript" src="<?php echo $vbaseurl ?>resources/tbrespons/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo $vbaseurl ?>resources/tbrespons/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?php echo $vbaseurl ?>resources/tbrespons/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="<?php echo $vbaseurl ?>resources/tbrespons/js/responsive.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $vbaseurl ?>resources/tbrespons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo $vbaseurl ?>resources/tbrespons/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo $vbaseurl ?>resources/tbrespons/js/buttons.html5.min.js"></script>

<script type="text/javascript">

	$(".tablaEstudiantes").DataTable({
	  "ajax":base_url+"egresadosdts/dtsestudiantes",
	  "deferRender": true,
	  "retrieve": true,
	  "processing": true,
	  "language": {

	     "sProcessing":     "Procesando...",
	    "sLengthMenu":     "Mostrar _MENU_ registros",
	    "sZeroRecords":    "No se encontraron resultados",
	    "sEmptyTable":     "Ningún dato disponible en esta tabla",
	    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
	    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
	    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	    "sInfoPostFix":    "",
	    "sSearch":         "Buscar:",
	    "sUrl":            "",
	    "sInfoThousands":  ",",
	    "sLoadingRecords": "Cargando...",
	    "oPaginate": {
	      "sFirst":    "Primero",
	      "sLast":     "Último",
	      "sNext":     "Siguiente",
	      "sPrevious": "Anterior"
	    },
	    "oAria": {
	        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	    }

	   },
	   	dom: 'Blfrtip',
        buttons: [ {
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn-excel',
            customize: function( xlsx ) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                $('row:first c', sheet).attr( 's', '42' );
            }
        } ]

	});
</script>