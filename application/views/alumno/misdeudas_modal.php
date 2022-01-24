<div class="modal modal-danger fade" id="modal-deudor"role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Estimado alumno, usted presenta DEUDAS VENCIDAS, cumpla con cancelar las deudas pendientes. <br>Si ya canceló haga caso omiso o notifique el error a través del enlace <b><a href="<?php echo base_url()?>alumno/mis-deudas/notificar-error">Notificar error</a></b></h4>
      </div>
      <div class="modal-body">
        
        <div id="divmisdeudas" class="table-responsive margin-top-10px">
          <table class="table table-bordered  table-condensed" id="tr-cursos" role="table">
            <thead role="rowgroup">
              <tr role="row">
                <th role="columnheader">COD</th>
                <th role="columnheader">DEUDA</th>
                
                <th role="columnheader">CICLO</th>
                <th role="columnheader">MONTO</th>
                <th role="columnheader">DEBE</th>
                <th role="columnheader">VENCE</th>
                <th role="columnheader">OBSER.</th>
              </tr>
            </thead>
            <tbody role="rowgroup">
              <?php
              $deudas=$_SESSION['userDeudas'];
              foreach ($deudas as $deuda) {
              $fvence = new DateTime($deuda->vence);
              $fvence = $fvence->format("d-m-Y");
              ?>
              <tr role="row">
                <td role="cell">
                  <?php  echo $deuda->id  ?>
                </td>
                <td role="cell"><b><?php  echo $deuda->codgestion." / ".$deuda->gestion ?> </b></td>
                
                <td role="cell"><?php  echo $deuda->periodo." / ".$deuda->ciclo  ?></td>
                <td role="cell" class="text-right"><?php  echo number_format($deuda->monto, 2)  ?></td>
                <td role="cell" class="text-right"><b><?php  echo number_format($deuda->saldo, 2)  ?></b></td>
                <td role="cell"><?php  echo $fvence ?></td>
                <td role="cell"><?php  echo $deuda->obs  ?></td>
              </tr>
              <?php } ;?>
            </tbody>
          </table>
        </div>
        
        
      </div>
      <div class="modal-footer">
        
        <a href="<?php echo base_url()?>alumno/mis-deudas/notificar-error" class="btn btn-outline btn-flat pull-left">Notificar Error</a>
        <button type="button" class="btn btn-outline " data-dismiss="modal">Aceptar</button>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
<script>
$("#modal-deudor").modal();
</script>