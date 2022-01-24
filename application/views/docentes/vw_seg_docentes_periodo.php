<?php
if (count($docentes)>0){
?>
<div id="divcursos" class="col-12 col-md-12 btable">
  <div class="col-md-12 thead ">
    <div class="row hidden-xs hidden-sm"  role="rowgroup" >
      <div class="col-4 col-sm-3 col-md-2">
        <div class="row">
          <div class="col-4 col-md-4 td">
            N°
          </div>
          <div class="col-8 col-md-8 td">
            COD
          </div>
        </div>
      </div>
      <div class="col-8 col-sm-4 col-md-3 td">
        DOCENTE
      </div>
      <div class="col-12 col-sm-4 col-md-3 td d-none d-md-block">
        CORREO
      </div>
      <div class="col-md-3 td d-none d-md-block">
        UNIDADES DIDÁC.
      </div>
    </div>
  </div>
  <div class="col-md-12 tbody">
    <?php
    $nro=0;
    foreach ($docentes as $docente) {
    $fn="";
    $nro++;
    $nombres=$docente->paterno.' '.$docente->materno.' '.$docente->nombres;
    ?>
    
    <div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>" role="row" data-idcarga='<?php echo $codcurso64 ?>'>
      <div class="col-4 col-sm-3 col-md-2">
        <div class="row">
          <div class="col-4 col-md-4 td text-center">
          <?php echo str_pad($nro, 2, "0", STR_PAD_LEFT)  ?>
          </div>
          <div class="col-8 col-md-8 td">
            <b><?php echo $docente->coddocente ?></b>
          </div>
        </div>
      </div>
      <div class="col-8 col-sm-9 col-md-3 td">
        <?php echo  $docente->paterno.' '.$docente->materno.' '.$docente->nombres ?>
      </div>
      <div class="col-12 col-sm-12 col-md-3 td">
        <?php echo  $docente->ecorporativo ?>
      </div>
      <div class="col-12 col-sm-6 col-md-1 td">
        <span class="d-block-inline d-md-none">Unid. Didác.: </span> 
        <span class="bg-success text-white tboton">
            <?php echo str_pad($docente->cactivos, 2, "0", STR_PAD_LEFT) ?> 
          </span>
          <span class="bg-danger text-white tboton">
            <?php echo str_pad($docente->ctotal - $docente->cactivos, 2, "0", STR_PAD_LEFT) ?> 
          </span>
      </div>
      <div class="col-6 col-sm-6 col-md-2 td">
          <a href="<?php echo base_url().'seguimiento/docente/'.base64url_encode($docente->coddocente).'/'.base64url_encode($periodo).'/cursos' ?>" class="d-block-inline bg-info text-white tboton" title="Ver detalles" href="#"><i class="fa fa-eye"></i> Unidades Didác.</a>
          <!--<a href="'.base_url().'descargar-horario?bcode='.$docente->codigo.'&bnombre='.$nombres.'" target="_blanck" title="Descargar" class="btn btn-xs btn-success"><span class="fa fa-download"></span> Horario</a>-->
      </div>
    </div>
    
    <?php } ?>
  </div>
  
</div>
<?php
}
else{
echo "<h4>SIN RESULTADOS</h4>";
}
?>