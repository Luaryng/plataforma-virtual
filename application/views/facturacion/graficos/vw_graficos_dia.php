<?php

    $mtotal=0;
    $mefectivo=0;
    $mbanco=0;
    $motros = 0;
    $sbcp = 0;
    $sintb = 0;
    $sumaxbanco=0;

    foreach ($repcobros as $rep) {
    	$mtotal=$mtotal +  $rep->total;
        $mefectivo=$mefectivo + $rep->efectivo;
        $mbanco=$mbanco + $rep->banco;
    }

    $motros = $mtotal - ($mefectivo + $mbanco);

    foreach ($sumabanco as $key => $value) {
    	$sbcp = number_format($sbcp + $value->banbcp, 2, '.', '');
    	$sintb = number_format($sintb + $value->baninterb, 2, '.', '');
    }
?>

<style type="text/css">
	.chart-sub-legend {
	    padding-left: 20px;
	    list-style: none;
	    margin: 10px 0;
	}
</style>

<div class="content-wrapper">
	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>Estadistica
          			<small>Panel</small></h1>
        		</div>
        
      		</div>
    	</div>
  	</section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_dia" class="card">
			
			<div class="card-body">
				<div class="row">
	                  
	                <div class="col-md-8">
	                   <h5 class="d-inline-block">Reporte día:</h5> <input type="date" value="2021-05-31">
	                </div>
	            </div>
			</div>

		</div>

		<div id="divcard_graficos" class="card">
			
			<div class="card-body">
				<div class="row">
	                  <!-- /.col -->
	                <div class="col-md-4 col-8">
	                  	<ul class="chart-legend clearfix">
	                      	<li><h5><i class="far fa-circle text-danger"></i> Efectivo: <?php echo number_format($mefectivo, 2, '.', '') ?></h5></li>
	                      	<li><h5><i class="far fa-circle text-danger"></i> Bancos: <?php echo number_format($mbanco, 2, '.', '') ?></h5>
	                      		<?php if ($mbanco > 0): ?>
								<ul class="chart-sub-legend">
									<?php
										foreach ($bancos as $key => $value) {
											if ($value->codigo == '1') {
												$sumaxbanco = $sbcp;
											} else {
												$sumaxbanco = $sintb;
											}
											echo "<li><h6><i class='far fa-circle text-danger'></i> $value->nombre: $sumaxbanco</h6></li>";
										}
									?>
	                      		</ul>
	                      		<?php endif ?>
	                      	</li>
	                      
	                      	<li><h5><i class="far fa-circle text-danger"></i> Otros: <?php echo number_format($motros, 2, '.', '') ?></h5></li>
	                    </ul>
	                </div>
	                <div class="col-md-8">
	                    <div class="chart-responsive">
	                      <canvas id="pieChart" height="100"></canvas>
	                    </div>
	                    <!-- ./chart-responsive -->
	                </div>
	            </div>
			</div>

		</div>
		<div class="card">
			<div class="card-body">
                <table class="table table-bordered">
                  	<thead>                  
	                    <tr>
	                      	<th style="width: 50px"></th>
	                      	<th>Efectivo</th>
	                      	<th>Banco</th>
	                      	<th>Otros</th>
	                    </tr>
                  	</thead>
                  	<tbody>
                  		<?php
                  		$sumotros = 0;
                  		$sumaefectivo = 0;
                  		$sumabanco = 0;
                  		$sumatotal = 0;
                  		// echo '<pre>'; print_r($cbsede); echo '</pre>';
                  			foreach ($cbsede as $key => $value) {
                  				$sumatotal = $sumatotal + $value->total;
                  				$sumaefectivo = $value->efectivo;
                  				$porcefectivo = ($sumaefectivo / $value->totalsede) * 100;
                  				$sumabanco = $value->banco;
                  				$porcbanco = ($sumabanco / $value->totalsede) * 100;
                  				$sumotros = $value->totalsede - ($sumaefectivo + $sumabanco);
                  				$porcotros = ($sumotros / $value->totalsede) * 100;
								echo "<tr>
	                      				<td><b>$value->sednombre</b></td>
	                      				<td>
				                      		<div class='progress progress-xs'>
					                          	<div class='progress-bar bg-danger' style='width: ".round($porcefectivo,0)."%'></div>
					                        </div>
					                        <span>$sumaefectivo</span><span class='badge bg-danger ml-2'>".round($porcefectivo,0)."%</span>
				                      	</td>
				                      	<td>
				                      		<div class='progress progress-xs'>
					                          	<div class='progress-bar bg-success' style='width: ".round($porcbanco,0)."%'></div>
					                        </div>
					                        <span>$sumabanco</span><span class='badge bg-success ml-2'>".round($porcbanco,0)."%</span>
					                    </td>
					                    <td>
					                        <div class='progress progress-xs'>
					                          	<div class='progress-bar bg-warning' style='width: ".round($porcotros,0)."%'></div>
					                        </div>
					                        <span>$sumotros</span><span class='badge bg-warning ml-2'>".round($porcotros,0)."%</span>
				                      	</td>
	                      			</tr>";

                  				
                  			}
                  			
                  			
                  		?>
	                    
                  </tbody>
                </table>
              </div>
		</div>
		<div class="card">
			<!-- <div class="card-header">
				<h3 class="card-title">Grafico 2</h3>
			</div> -->
			<div class="card-body">
				<div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
			</div>
		</div>
	</section>
</div>

<script src="<?php echo base_url() ?>resources/plugins/chart.js/Chart.min.js"></script>

<script type="text/javascript">
	$(function () {
	//-------------
	  //- PIE CHART -
	  //-------------
	  // Get context with jQuery - using jQuery's .get() method.
	    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
	    var pieData        = {
	      	labels: [
	        	'Banco','Efectivo','Otros',
	      	],
	      	datasets: [
		        {
		          	data: [
		          	<?php

					    echo "$mbanco,$mefectivo,$motros,";

					?>
		          	],
		          backgroundColor : ['#f56954', '#00a65a', '#f39c12'],
		        }
	      	]
	    }
	    var pieOptions     = {
	      	legend: {
	        	display: false
	      	}
	    }
	    //Create pie or douhnut chart
	    // You can switch between pie and douhnut using the method below.
	    var pieChart = new Chart(pieChartCanvas, {
	      	type: 'doughnut',
	      	data: pieData,
	      	options: pieOptions      
	    })

	  //-----------------
	  //- END PIE CHART -
	  //-----------------
	  
	var areaChartData = {
      	labels  : [
      		<?php

			       foreach($cbsede as $key => $value){

			        echo "'$value->sednombre',";

			       }

			?>
      	],
      	datasets: [
      		<?php

	        	echo "{
		          	label               : 'Efectivo',
		          	backgroundColor     : 'rgba(231,76,60,0.9)',
		          	borderColor         : 'rgba(231,76,60,0.8)',
		          	pointRadius          : false,
		          	pointColor          : '#3b8bba',
		          	pointStrokeColor    : 'rgba(231,76,60,1)',
		          	pointHighlightFill  : '#fff',
		          	pointHighlightStroke: 'rgba(231,76,60,1)',
		          	data : [";
		          	foreach($cbsede as $key){
		          		echo " $key->efectivo,";
		          	}
		          	
		        echo "]},
		        	{
		          	label               : 'Banco',
		          	backgroundColor     : 'rgba(39, 174, 96, 1)',
		          	borderColor         : 'rgba(39, 174, 96, 1)',
		          	pointRadius         : false,
		          	pointColor          : 'rgba(39, 174, 96, 1)',
		          	pointStrokeColor    : '#c1c7d1',
		          	pointHighlightFill  : '#fff',
		          	pointHighlightStroke: 'rgba(39,174,96,1)',
		          	data : [";
		          	foreach($cbsede as $key){
		          		echo " $key->banco,";
		          	}
		        echo "]},
		        	{
		          	label               : 'Otros',
		          	backgroundColor     : 'rgba(241, 196, 15, 1)',
		          	borderColor         : 'rgba(241, 196, 15, 1)',
		          	pointRadius         : false,
		          	pointColor          : 'rgba(241, 196, 15, 1)',
		          	pointStrokeColor    : '#c1c7d1',
		          	pointHighlightFill  : '#fff',
		          	pointHighlightStroke: 'rgba(241,196,15,1)',
		          	data : [";
		          	foreach($cbsede as $key){
		          		$sumaefectivo = $key->efectivo;
          				$sumabanco = $key->banco;
		          		$sumotros = $key->totalsede - ($sumaefectivo + $sumabanco);
		          		echo " $sumotros,";
		          	}
		        echo "]},";


			?>
      	]
    }
	  //-------------
	    //- BAR CHART -
	    //-------------
	    var barChartCanvas = $('#barChart').get(0).getContext('2d')
	    var barChartData = jQuery.extend(true, {}, areaChartData)
	    var temp0 = areaChartData.datasets[0]
	    var temp1 = areaChartData.datasets[1]
	    barChartData.datasets[0] = temp1
	    barChartData.datasets[1] = temp0

	    var barChartOptions = {
	      responsive              : true,
	      maintainAspectRatio     : false,
	      datasetFill             : false
	    }

	    var barChart = new Chart(barChartCanvas, {
	      type: 'bar', 
	      data: barChartData,
	      options: barChartOptions
	    })
	});
</script>