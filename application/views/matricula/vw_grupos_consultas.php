<?php $vbaseurl=base_url() ?>
<!--<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">-->
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>Grupos Matriculados</h1>
        </div>
      </div>
    </div>
  </section>
  <section id="s-cargado" class="content">
    <div id="divboxhistorial" class="card">
      <div class="card-body pb-1">
        <form id="frmfiltro-grupos" name="frmfiltro-grupos" action="<?php echo $vbaseurl ?>grupos/fn_filtrar" method="post" accept-charset='utf-8'>
          <div class="row">
            
            <div class="form-group has-float-label col-12 col-sm-2">
              <select data-currentvalue='' class="form-control" id="fm-cbperiodo" name="fm-cbperiodo" placeholder="Periodo" required >
                <option value="%"></option>
                <?php foreach ($periodos as $periodo) {?>
                <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                <?php } ?>
              </select>
              <label for="fm-cbperiodo"> Periodo</label>
            </div>
            
            <div class="form-group has-float-label col-12 col-sm-3">
              <select data-currentvalue='' class="form-control" id="fm-cbcarrera" name="fm-cbcarrera" placeholder="Programa Académico" required >
                <option value="%"></option>
                <?php foreach ($carreras as $carrera) {?>
                <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                <?php } ?>
              </select>
              <label for="fm-cbcarrera"> Programa Académico</label>
            </div>
            <div class="form-group has-float-label col-12 col-sm-2">
              <select data-currentvalue='' class="form-control" id="fm-cbciclo" name="fm-cbciclo" placeholder="Ciclo" required >
                <option value="%"></option>
                <?php foreach ($ciclos as $ciclo) {?>
                <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                <?php } ?>
              </select>
              <label for="fm-cbciclo"> Ciclo</label>
            </div>
            <div class="form-group has-float-label col-12 col-sm-2">
              <select data-currentvalue='' class="form-control" id="fm-cbturno" name="fm-cbturno" placeholder="Turno" required >
                <option value="%"></option>
                <?php foreach ($turnos as $turno) {?>
                <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                <?php } ?>
              </select>
              <label for="fm-cbturno"> Turno</label>
            </div>
            <div class="form-group has-float-label col-12 col-sm-2">
              <select data-currentvalue='' class="form-control" id="fm-cbseccion" name="fm-cbseccion" placeholder="Sección" required >
                <option value="%"></option>
                <?php foreach ($secciones as $seccion) {?>
                <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                <?php } ?>
              </select>
              <label for="fm-cbseccion"> Sección</label>
            </div>
            <div class="col-12  col-sm-1">
              <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </form>
      </div>
      <div class="card-body pt-1">
        <div class="btable">
          <div class="thead col-12">
            <div class="row">
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-2 td">N°</div>
                  <div class="col-md-3 td">PERIODO</div>
                  <div class="col-md-7 td">PROG. ACAD.</div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-3 td">PLAN</div>
                  <div class="col-md-3 td">CIC.</div>
                  <div class="col-md-3 td">TUR.</div>
                  <div class="col-md-3 td">SEC.</div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-3 td">MAT.</div>
                  <div class="col-md-3 td">ACT.</div>
                  <div class="col-md-3 td">RET.</div>
                  <div class="col-md-3 td">CUL.</div>
                </div>
              </div>
              <div class="col-md-1">
                <div class="row">
                 
                  
                </div>
              </div>

            </div>
          </div>
          <div id="div-filtro" class="tbody col-12">
            
          </div>
        </div>
      </div>  
    </div>
  </section>
</div>
<!--ript src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>-->
<script>
var per_vcxg='<?php echo getPermitido("41"); ?>'
var per_vmxg='<?php echo getPermitido("43"); ?>'
$("#frmfiltro-grupos").submit(function(event) {
    
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#div-filtro").html("");
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
          if (e.status==false){
          }
          else{
              var nro=0;
              var mt=0;
              var ac=0;
              var rt=0;
              var cl=0;
              $.each(e.vdata, function(index, v) {
                /* iterate through array or object */
                nro++;
                mt=mt + parseInt(v['mat']);
                ac=ac + parseInt(v['act']);
                rt=rt + parseInt(v['ret']);
                cl=cl + parseInt(v['cul']);
                var rowcolor=(nro % 2==0) ? 'bg-lightgray':'';
                var btncaxg='';
                var params='cp='+ v['codperiodo'] +'&cc='+ v['codcarrera'] + '&ccc='+ v['codciclo'] +'&ct='+ v['turno']+'&cs='+ v['seccion']+'&cpl='+ v['idplan'];
                if (per_vcxg=='SI'){
                  
                  btncaxg='<a class="dropdown-item" href="' + base_url + 'academico/consulta/nomina-matricula/excel?' + params +'"><i class="fas fa-file-excel"></i> Matriculados</a>';
                }
                if (per_vmxg=='SI'){
                  //var params='cp='+ v['codperiodo'] +'&cc='+ v['codcarrera'] + '&ccc='+ v['codciclo'] +'&ct='+ v['turno']+'&cs='+ v['seccion']+'&cpl='+ v['idplan'];
                  btnmats='<div class="td col-2 col-md-6 text-right text-primary text-bold"><a title="Orden de mérito" class="btn btn-sm btn-primary" target="_blank" href="' + base_url + 'academico/consulta/orden-merito/imprimir?' + params + '&at=1'+'"><i class="fas fa-user-graduate"></i> Mérito</a></div>' ;
                }
                if (per_vmxg=='SI'){
                  //var params='cp='+ v['codperiodo'] +'&cc='+ v['codcarrera'] + '&ccc='+ v['codciclo'] +'&ct='+ v['turno']+'&cs='+ v['seccion']+'&cpl='+ v['idplan'];
                  btnregeval='<a class="dropdown-item" href="' + base_url + 'academico/consulta/nomina-evaluaciones/excel?' + params + '&at=1'+'"><i class="fas fa-file-excel"></i> Evaluaciones</a>'; 
                }
                $("#div-filtro").append(
                '<div class="row ' + rowcolor + ' ">' + 
                  '<div class="col-4 col-md-3">' + 
                    '<div class="row">' + 
                      '<div class="col-3 col-md-2 td">' + nro + '</div>' +
                      '<div class="col-9 col-md-3 td">' + v['periodo'] + '</div>' + 
                      '<div class="col-8 col-md-7 td">' + v['carrera'] + '</div>' +
                    '</div>' + 
                  '</div>' + 
                  '<div class="col-6 col-md-3">' + 
                    '<div class="row">' + 
                      '<div class="col-2 col-md-3 text-center td" title="' + v['plan']  +'">' + v['idplan'] + '</div>' + 
                      '<div class="col-2 col-md-3 text-center td">' + v['ciclo'] + '</div>' + 
                      '<div class="col-2 col-md-3 text-center td">' + v['turno'] + '</div>' + 
                      '<div class="col-2 col-md-3 text-center td">' + v['seccion'] + '</div>' + 
                    '</div>' + 
                  '</div>' + 
                  '<div class="col-6 col-md-3">' + 
                    '<div class="row">' + 
                      '<div class="td col-2 col-md-3 text-right text-bold">' + v['mat'] + '</div>' + 
                      '<div class="td col-2 col-md-3 text-right text-primary text-bold">' + v['act'] + '</div>' + 
                      '<div class="td col-2 col-md-3 text-right text-danger text-bold">' + v['ret'] + '</div>' + 
                      '<div class="td col-2 col-md-3 text-right text-success text-bold">' + v['cul'] + '</div>' + 
                    '</div>' + 
                  '</div>' + 
                  
                  '<div class="btn-group btn-sm">' + 
                    '<button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                      'Actas' +
                    '</button>' +
                    '<div class="dropdown-menu">' +
                      btncaxg +
                      btnregeval +
                   ' </div>' +
                  '</div>' +
                  '<div class="col-6 col-md-2">' + 
                    '<div class="row">' + 
                      btnmats +  
                    '</div>' + 
                  '</div>' + 
                '</div>');
              });
                $("#div-filtro").append(
                '<div class="row text-bold">' + 
                  '<div class="col-4 col-md-6">' + 
                   
                  '</div>' + 
                  '<div class="col-6 col-md-3">' + 
                    '<div class="row">' + 
                      '<div class="td col-2 col-md-3 text-right text-bold">' + mt + '</div>' + 
                      '<div class="td col-2 col-md-3 text-right text-primary text-bold">' + ac+ '</div>' + 
                      '<div class="td col-2 col-md-3 text-right text-danger text-bold">' + rt + '</div>' + 
                      '<div class="td col-2 col-md-3 text-right text-success text-bold">' + cl + '</div>' + 
                    '</div>' + 
                  '</div>' + 
                  '<div class="col-6 col-md-2">' + 
                    '<div class="row">' + 
                     
                    '</div>' + 
                  '</div>' + 
                '</div>');
              $('#divboxhistorial #divoverlay').remove();
          }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divboxhistorial #divoverlay').remove();
            //$('#divError').show();
            //$('#msgError').html(msgf);
        }
    });
    return false;
});



  </script>