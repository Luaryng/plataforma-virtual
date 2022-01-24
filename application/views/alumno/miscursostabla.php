<table class="table-registro table table-bordered table-striped table-hover table-condensed" id="tr-cursos" role="table">
  <thead role="rowgroup">
    <tr role="row">
      <th role="columnheader">COD</th>
      <th role="columnheader">UNIDAD DIDÁCTICA</th>
      
      <th role="columnheader" class="d-print-none"></th>
      <th role="columnheader">DOCENTE</th>
      <th role="columnheader">NL</th>
      <th role="columnheader">NR</th>
      <th role="columnheader">NF</th>
      <th role="columnheader">Est.</th>
      <th role="columnheader">Ses</th>
      
      <th role="columnheader">As</th>
      <th role="columnheader">Ft</th>
      <th role="columnheader">Td</th>
      <th role="columnheader">Jt</th>
    </tr>
  </thead>
  <tbody role="rowgroup">
    <?php
    foreach ($miscursos as $curso) {
       $esdpi= ($curso->dpi=="0") ? "NO" : "SI";
    $capr = ($curso->final >= 13) ? "text-success" : "text-danger";
    echo '<tr role="row">
      <td role="cell">'.$curso->idcarga.'G'.$curso->subseccion.'</td>
      <td role="cell" >' .$curso->codcurso.' - '. $curso->curso . '</td>';
      echo '<td class="p-1 d-print-none" role="cell">
        <a class="btn btn-primary btn-sm" title="Ver detalles" href="' . base_url() . 'alumno/mi-curso/' . base64url_encode($curso->idcarga) .'/'.base64url_encode($curso->subseccion).'/detalle/' . base64url_encode($curso->idmiembro) . '/' . base64url_encode($curso->matricula) .'/' . base64url_encode($carnet) . '/' .base64url_encode($alumno). '"><i class="fa fa-eye"></i>
        </a>
      </td>';
      $nl=$curso->nota;
      $nr=$curso->recuperacion;
      $nf=$curso->final;
      $dpi=$curso->dpi;
      echo '<td role="cell" >' . $curso->paterno.' '.$curso->materno.' '.$curso->nombres. '</td>
      <td role="cell" class="text-right">' . $nl . '</td>
      <td role="cell" class="text-right">' . $nr . '</td>
      <td role="cell" class="text-right">' . $nf . '</td>
      <td role="cell" class="text-right">' . $dpi . '</td>
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
  </tbody>
</table>
<div class="col-12">
  <div class="row">
<div class="col-xxs-6 col-md-3">As = Asistencia</div>
<div class="col-xxs-6 col-md-3">Ft = Faltas</div>
<div class="col-xxs-6 col-md-3">Td = Tardanzas</div>
<div class="col-xxs-6 col-md-3">Jt = Justificación</div>
</div>
</div>