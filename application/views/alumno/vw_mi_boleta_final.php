
    <?php
    foreach ($miscursos as $curso) {
       
      $capr = ($curso->culminado=="SI") ? "" : "text-danger";
      $codcarga=(is_null($curso->idcarga))?"":$curso->idcarga.'G'.$curso->subseccion;
      echo '
      <tr role="row">
        <td role="cell">'.$curso->id.'</td>
        <td role="cell">'.$codcarga.'</td>
        <td role="cell" class="'.$capr.'" >' .$curso->codcurso.' - '. $curso->curso . '</td>';
        /*<td class="p-1 d-print-none" role="cell">
          <a class="btn btn-primary btn-sm" title="Ver detalles" href="' . base_url() . 'alumno/historial/curso/' . base64url_encode($curso->idcarga) .'/'.base64url_encode($curso->subseccion).'/detalle/' . base64url_encode($curso->idmiembro) . '/' . base64url_encode($curso->matricula) .'/' . base64url_encode($carnet) . '/' .base64url_encode($alumno). '"><i class="fa fa-eye"></i>
          </a>
        </td>';*/
      $nl=$curso->nota;
      $nr=$curso->recuperacion;
      $nf=$curso->final;
      $dpi=$curso->estado;
      echo '<td role="cell" >' . $curso->paterno.' '.$curso->materno.' '.$curso->nombres. '</td>
      <td role="cell" class="text-right">' . $nl . '</td>
      <td role="cell" class="text-right">' . $nr . '</td>
      <td role="cell" class="text-right">' . $nf . '</td>
      <td role="cell" class="text-right">' . $dpi . '</td>';
      
      
    echo '</tr>';
    }
    ?>

  
