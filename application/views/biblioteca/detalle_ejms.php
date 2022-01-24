<?php
if (count($dejempl) > 0) {
	$nro = 0;
	foreach ($dejempl as $dejm) {
		$nro ++;
		echo '<div class="list-group-item">';
		if ($dejm->link == "") {
			echo '<h3 class="card-title mb-2" style="color: var(--info)">Datos de libro en biblioteca</h3>
					<div class="row">
						<div class="col-md-4 col-6"><b>N° Pag.</b> '.$dejm->pag.' </div>
						<div class="col-md-4 col-6"><b>Estado:</b> '.$dejm->est.' </div>
						<div class="col-md-4 col-12"><b>Situación:</b> '.$dejm->situa.' </div>
					</div>';
		} else {
			echo '<h3 class="card-title mb-2" style="color: var(--info)">Datos de libro en la web</h3>
					<h5 style="color: var(--gray)">sitio web del libro '.$dejm->nombre.' - <a href = "'.$dejm->link.'" target="_blank">Ir a web <i class="fas fa-globe mr-1"></i></a></h5>';
		}
		echo '</div>';
	}
} else {
	echo "<h5 class='ml-3 text-danger'><i class='fa fa-ban'></i> NO SE ENCONTRARON RESULTADOS</h5>";
}
?>