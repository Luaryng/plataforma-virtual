<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  <section class="content-header">
    <h1>
    NOTIFICAR ERROR EN MIS DEUDAS
    <small>Solicitud</small>
    </h1>
    <!--<ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li >Mis Cursos</li>
      <li class="active">Carrera</li>
    </ol>-->
  </section>
  <!-- Main content -->
  <section class="content">
    <div id="divbox-deudas" class="box box-success no-padding">
      <div class="box-body ">
        <h4>Selecciona los CHECK de las deudas que notificas el error, luego escribe un breve mensaje y envialo haciendo clic en el boton AZUL</h4>
        <div class="clearfix"></div>
        <div id="divmisdeudas" class="table-responsive margin-top-10px">
          <table class="table table-bordered table-striped table-hover table-condensed" id="tbldeudas" role="table">
            <thead role="rowgroup">
              <tr role="row">
                <th role="columnheader">CÓDIGO</th>
                <th role="columnheader">DEUDA</th>
                <th role="columnheader">STATUS</th>
                
                <th role="columnheader">CICLO</th>
                <th role="columnheader">MONTO</th>
                <th role="columnheader">DEBE</th>
                <th role="columnheader">VENCE</th>
              </tr>
            </thead>
            <tbody role="rowgroup">

              <?php 
              
              foreach ($deudas as $deuda) {
                $stdeuda="PAGADA";
                $capr= "text-success";
                $bgfila="";
                $fvence = new DateTime($deuda->vence);
                $fhoy = new DateTime();
                if ($deuda->saldo>0){
                  $capr="text-danger";
                  $stdeuda="VENCIDA";
                  $bgfila="danger";
                  if ($fvence>$fhoy){
                    $stdeuda="POR PAGAR";
                    $capr="text-primary";
                    $bgfila="";
                  }
                }
                $fvence = $fvence->format("d-m-Y");
                ?>
                <tr role="row" class="<?php echo $bgfila ?>">
                  <td role="cell">
                    <div class="checkbox no-padding no-margin">
                      <label>
                        <input name="deudaselecta" type="checkbox" value="<?php  echo $deuda->id  ?>" data-ciclo="<?php  echo $deuda->periodo."  ".$deuda->ciclo  ?>" data-saldo="<?php  echo $deuda->saldo  ?>" data-item="<?php  echo $deuda->codgestion." - ".$deuda->gestion ?>">
                        <?php  echo $deuda->id  ?>
                      </label>
                    </div>
                    
                  </td>
                  <td role="cell"><b><?php  echo $deuda->codgestion." / ".$deuda->gestion ?> </b></td>
                  <td role="cell" class="<?php echo $capr ?>"><b><?php  echo $stdeuda ?> </b></td>
                  
                  <td role="cell"><?php  echo $deuda->periodo." / ".$deuda->ciclo  ?></td>
                  <td role="cell" class="text-right"><?php  echo number_format($deuda->monto, 2)  ?></td>
                  <td role="cell" class="text-right"><b><?php  echo number_format($deuda->saldo, 2)  ?></b></td>

                  <td role="cell"><?php  echo $fvence ?></td>
                </tr>
                <?php } ;?>
            </tbody>
          </table>
        </div>
        <label for="txtmensaje">Escribe un mensaje detallando el error:</label>
        <textarea id="txtmensaje" class="form-control"  rows="3"> </textarea>
        <div class="clearfix"></div>
        <br>
        <a class="btn btn-primary pull-right" id="btnenviar" href="#"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Enviar</a>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<script>
  $("#btnenviar").click(function(event) {
    arrdata = [];
    $.each($("input[name='deudaselecta']:checked"), function(){            
        var vid = $(this).val();
        var vitem = $(this).data("item");
        var vsaldo = $(this).data("saldo");
        var vciclo = $(this).data("ciclo");
        var myvals = [vid, vitem, vsaldo,vciclo];
        arrdata.push(myvals);
    });

    $('#divbox-deudas').append('<div id="divoverlay" class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    if (arrdata.length>0){
      var txtmsg= $('#txtmensaje').val();
      $.ajax({
          url: base_url + 'cuentas/notificarerror_mail',
          type: 'post',
          dataType: 'json',
          data: {
              mensaje:txtmsg,
              deudas: JSON.stringify(arrdata),
          },
          success: function(e) {
              $('#divbox-deudas #divoverlay').remove();
              if (e.status == false) {
                  var msgf = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg + '</div>';
                  showmsg("Resultado", msgf);
              } else {
                msgf="<div class='text-success'><h4><i class='icon fa fa-check'></i> Éxito!</h4><span>" + e.msg + "</div>";
                showmsg("Resultado", msgf);
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception,'div');
              $('#divbox-deudas #divoverlay').remove();
              showmsg("Error", msgf);
          },
      }); 
    }
    return false;
  });
   
</script>