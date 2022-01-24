
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
      </td>';
      $nl="-";//$curso->nota;
      $nr="-";//$curso->recuperacion;
      $nf="-";//$curso->final;
      $dpi=$curso->dpi;
      echo '<td role="cell" >' . $curso->paterno.' '.$curso->materno.' '.$curso->nombres. '</td>

      
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

  
