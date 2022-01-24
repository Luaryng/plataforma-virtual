
    <?php
    foreach ($miscursos as $curso) {
      $vdeturl=base_url() . 'alumno/historial/curso/' . base64url_encode($curso->idcarga) .'/'.base64url_encode($curso->subseccion).'/detalle/' . base64url_encode($curso->idmiembro) . '/' . base64url_encode($curso->matricula) .'/' . base64url_encode($carnet) . '/' .base64url_encode($alumno);
      $capr = ($curso->culminado=="SI") ? "" : "text-danger";
      echo '<tr role="row">
      <td role="cell">'.$curso->idcarga.'G'.$curso->subseccion.'</td>
      <td role="cell" class="'.$capr.'" >' .$curso->codcurso.' - '. $curso->curso . '</td>';
      echo '<td class="p-1 d-print-none" role="cell">
        <a class="btn btn-primary btn-sm" title="Ver detalles" href="'.$vdeturl.'">
          <i class="fa fa-arrow-circle-right"></i> Detalles
        </a>

        <a class="btn btn-primary btn-sm mt-2 vw_reporte_indiv" data-carne="'.base64url_encode($carnet).'" data-periodo="'.base64url_encode($cperiodo).'" data-unidad="'.base64url_encode($curso->codcurso).'" title="Ver reporte" href="#">
          <i class="fas fa-file-pdf"></i> reporte
        </a>
      </td>';
      $nl=$curso->nota;
      $nr=$curso->recuperacion;
      $nf=$curso->final;
      $dpi=$curso->dpi;
      echo '<td role="cell" >' . $curso->paterno.' '.$curso->materno.' '.$curso->nombres. '</td>';
      echo '<td role="cell" class="text-right">' . $nl . '</td>';
      echo '<td role="cell" class="text-right">' . $nr . '</td>';
      echo '<td role="cell" class="text-right">' . $nf . '</td>';
      echo '<td role="cell" class="text-right">' . $dpi . '</td>
      <td role="cell" class="text-right">' . $curso->nrosesiones . '</td>
      ';

      $as=0;
      $td=0;
      $ft=0;
      $jt=0;
      
      foreach ($miscursosesta as $key => $est) {
        if (($curso->idcarga==$est->idcarga) && ($curso->idmiembro==$est->idmiembro)){
          $as=$est->asiste;
          $td=$est->tarde;
          $ft=$est->falta;
          $jt=$est->justif;
          unset($miscursosesta[$key]);
        }
      }
     
      
      echo '<td role="cell" class="text-right bg-success disabled">' . $as . '</td>';
      echo '<td role="cell" class="text-right bg-danger disabled">' . $ft . '</td>';
      echo '<td role="cell" class="text-right bg-warning disabled">' . $td . '</td>';
      echo '<td role="cell" class="text-right bg-info disabled">' . $jt . '</td>';
      
      
    echo '</tr>';
    }
    ?>

<script>
    $(document).on('click', '.vw_reporte_indiv', function(e) {
      e.preventDefault();

      $('#frm_search_docpago input,select').removeClass('is-invalid');
      $('#frm_search_docpago .invalid-feedback').remove();
      var url_pdf = 'monitoreo_alumno/vw_reporte_alumno_virtual';
      var cbper=$(this).data('periodo');
      var carnet=$(this).data('carne');
      var unidad = $(this).data('unidad');
      
      var url = base_url + url_pdf + '?tcar=' + carnet + '&cbper=' + cbper + '&tund=' + unidad;
      var ejecuta = false;
      if ($.trim(carnet) != '') {
          ejecuta = true;
      } else if ($.trim(cbper) != '') {
          ejecuta = true;
      }

      if (ejecuta == true) {
          window.open(url, '_blank');
      } else {
          Swal.fire({
              title: "Parametros requeridos",
              text: "Ingresa al menos un parametro de búsqueda",
              type: 'error',
              icon: 'error',
          })
      }
  });

</script>

