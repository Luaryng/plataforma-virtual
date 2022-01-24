<br>
<?php 
if (count($pmiembros)==0){

  echo "<center><h4 class='text-danger'>No se encontraron resultados disponibles</h4><center>";
 
}
else{

?>

<!--<table class="table table-bordered table-striped table-hover table-condensed" id="tr-cursos" role="table">
  <thead role="rowgroup">
    <tr role="row">
      <th role="columnheader">CARNÉ</th>
      <th role="columnheader">ALUMNO</th>
      <th role="columnheader" class="text-center">CIC</th>
      <th role="columnheader" class="text-center"><i class="fa fa-check"></i></th>
    </tr>
  </thead>
  <tbody role="rowgroup">
    <?php
    foreach ($pmiembros as $curso) {
    echo '<tr role="row">
      <td role="cell" >' . $curso->carnet . '</td>
      <td role="cell" >' . $curso->paterno . ' '. $curso->materno .' '. $curso->nombres .'</td>
      <td role="cell"  class="text-center">' . $curso->codciclo . '</td>';
      
      
      echo '<td role="cell" class="text-center">
       
        
      </td>
    </tr>';
    }
    ?>
  </tbody>
</table>-->

  <div id="divtabl-addamiembros" class="col-12 btable">
    <div class="col-md-12 thead">
      <div class="row">
        <div class="col-8 col-md-9">
          <div class="row">
            <div class="col-12 col-md-4 td d-none">
              <b>CARNÉ</b>
            </div>
            <div class="col-12 col-md-8 td">
              <b>ALUMNO</b>
            </div>
          </div>
        </div>
        <div class="col-2 col-md-1 td text-center">
          <b>CIC</b>
        </div>
        <div class="col-2 col-md-2 td text-center">
          <i class="fa fa-check-square-o" aria-hidden="true"></i>
        </div>
      </div>
    </div>
    <div class="col-md-12 tbody">
      <?php
      $numero=0;
      foreach ($pmiembros as $curso) {
        $numero++;
      ?>
      <div class="row rowcolor">
        <div class="col-8 col-md-10">
          <div class="row">
            <div class="col-12 col-md-1 td text-center">
              <?php echo $numero ;?>
            </div>
            <div class="col-12 col-md-3 td">
              <?php echo '<span><b>'.$curso->carnet.'</b></span>';?>
            </div>
            <div class="col-12 col-md-8 td">
              <span><?php echo $curso->paterno . ' '. $curso->materno .' '. $curso->nombres;?></span>
            </div>
          </div>
        </div>
        <div class="col-2 col-md-1 td text-center">
          <?php echo $curso->codciclo ?>
        </div>
        
        <div class="col-2 col-md-1 td text-center">
         <?php echo ' <a href="#" class="badge badge-primary px-2 btn-agregaralumno" title="Agregar" data-usuario="'.$curso->carnet.'" data-matricula="'.base64url_encode($curso->matricula).'" data-idcm="0">
          <i class="fa fa-plus"></i><span class="d-none"> Agregar</span>
        </a>';
         ?>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>


<div class="clearfix"></div>
<script>
 
    $(".btn-agregaralumno").click(function(event) {
      var boton=$(this);
      //boton.prop( "disabled", true );
      $(".btn-agregaralumno").addClass('disabled');
      var vid=$("#vidcurso").val();
      var vdivision=$("#vdivision").val();
      var vuser=$(this).data('usuario');
      var vcarne=$(this).data('carne');
      var vmatricula=$(this).data('matricula');
      var valumno=$(this).data('alumno');
      var vidmiembro=$(this).data('idcm');
      //codcarga codmatricula division idmiembro
      boton.html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
      $.ajax({
        url: base_url + 'miembros/fn_insert/SI',
        type: 'post',
        dataType: 'json',
        data: {"fm-codcarga":vid ,"fm-division": vdivision,"fm-codmatricula": vmatricula, "fm-idmiembro":vidmiembro},
        success: function(e) {
          $(".btn-agregaralumno").removeClass('disabled');
          if (e.status==true){
             boton.hide();
          }
          else{
              boton.html('<i class="fa fa-plus"></i><span class="d-none"> Agregar</span>');
          }
        },
        error: function (jqXHR, exception) {
          var msgf=errorAjax(jqXHR, exception,'div');
          boton.html('<i class="fa fa-plus"></i><span class="d-none"> Agregar</span>');
          return false;
        },
      });
      return false
  });
</script>
<?php } ?>