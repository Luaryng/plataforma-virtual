<?php $vbaseurl=base_url() ?>
<!--<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">-->
<div class="content-wrapper">
  <div class="modal fade" id="modal-addalumno" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
       <div class="modal-content">
      
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Buscar Alumno</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        <div class="modal-body">
      
          <input id="vwg_md_periodo" type="hidden" class="form-control">
          <input id="vwg_md_carrera"  type="hidden" class="form-control">
          <input id="vwg_md_plan_nuevo"  type="hidden" class="form-control">
          <input id="vwg_md_ciclo"  type="hidden" class="form-control">
          <input id="vwg_md_seccion"  type="hidden" class="form-control">
          <input id="vwg_md_turno"  type="hidden" class="form-control">

          <label for="txtbus-alum">Apellidos y nombres</label>
          <div class="input-group">
            <input id="txt-buscaralumnos" name="txtbus-alum" type="text" class="form-control" value="">
            <span class="input-group-btn">
              <button class="btn btn-primary btn-md" type="button" id="btn-buscaralumnos">
              Ir <i class="fa fa-search" aria-hidden="true"></i></button>
            </span>
          </div>
          <br>
            <div id="divtabl-addamiembros" class="btable">
              <div class="thead col-12">
                <div class="row">
                  <div class="col-md-12">
                   ALUMNO
                  </div>
                  

                </div>
              </div>
              <div id="lista-alumnos" class="tbody col-12">
                  
              </div>
            </div>
     
          
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" class="btn pull-right" data-dismiss="modal">Terminar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- MODAL CULMINAR -->
  <div class="modal fade" id="modculminagrupo" tabindex="-1" role="dialog" aria-labelledby="modculminagrupo" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content" id="divmodaladd">
              <div class="modal-header">
                  <h5 class="modal-title" id="titleculmina">CULMINAR GRUPO</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div class="row border rounded p-1 bg-lightgray">
                  <div class="col-md-2">Periodo : </div><div  id="vw_md_gp_cul_periodo" class="text-bold col-md-2"></div>
                  <div class="col-md-2">Plan : </div><div id="vw_md_gp_cul_plan"  class="text-bold col-md-6"></div>
                  <div class="col-md-2">Programa : </div><div id="vw_md_gp_cul_programa"  class="text-bold col-md-10"></div>
                  <div class="col-md-2">Turno : </div><div id="vw_md_gp_cul_turno"  class="text-bold col-md-1"></div>
                  
                  <div class="col-md-2">Semestre : </div><div id="vw_md_gp_cul_semestre"  class="text-bold col-md-1"></div>
                  <div class="col-md-2">Sección : </div><div id="vw_md_gp_cul_seccion"  class="text-bold col-md-1"></div>
                  
                </div>
                <small id="fmt_conteo" class="form-text text-primary">
            
                </small>
                <div class="col-12 py-1">
                  <div class="btable">
                    <div class="thead col-12  d-none d-md-block">
                        <div class="row">
                            <div class='col-12 col-md-6'>
                                <div class='row'>
                                    <div class='col-2 col-md-1 td'>N°</div>
                                    <div class='col-10 col-md-11 td'>ESTUDIANTE</div>
                                </div>
                            </div>
                            <div class='col-12 col-md-5'>
                                <div class='row'>
                                    <div class='col-3 col-md-2 td text-center'>APR</div>
                                    <div class='col-3 col-md-2 td text-center'>DES</div>
                                    <div class='col-3 col-md-2 td text-center'>NSP</div>
                                    <div class='col-3 col-md-4 td text-center'>DPI</div>
                                </div>
                            </div>
                            <div class='col-12 col-md-1 td text-center'>
                                <div class="form-check">
                                  <input class="form-check-input" id="allcheck" type="checkbox">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="tbody col-12" id="divcard_data">

                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button type="button" id="lbtn_culminar" class="btn btn-primary">Culminar</button>
              </div>
          </div>
      </div>
  </div>
  <!-- FIN MODAL CULMINAR -->
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
                <div class="form-group has-float-label col-12 col-sm-4 col-md-2">
                  <select  class="form-control form-control-sm" id="fm-cbsede" name="fm-cbsede" placeholder="Filial">
                    <option value="%"></option>
                    <?php 
                      foreach ($sedes as $filial) {
                        $select=($vuser->idsede==$filial->id) ? "selected":"";
                        echo "<option $select value='$filial->id'>$filial->nombre</option>";
                      } 
                    ?>
                  </select>
                  <label for="fm-cbsede"> Filial</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbperiodo" name="fm-cbperiodo" placeholder="Periodo" required >
                    <option value="%"></option>
                    <?php foreach ($periodos as $periodo) {?>
                    <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbperiodo"> Periodo</label>
                </div>
                
                <div class="form-group has-float-label col-12 col-sm-3">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbcarrera" name="fm-cbcarrera" placeholder="Programa Académico" required >
                    <option value="%"></option>
                    <?php foreach ($carreras as $carrera) {?>
                    <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbcarrera"> Prog. de Estudios</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
                  <select name="fm-cbplan" id="fm-cbplan"class="form-control form-control-sm">
                    <option data-carrera="0" value="%">Todos</option>
                    <option data-carrera="0" value="0">Sin Plan</option>
                    <?php foreach ($planes as $pln) {
                    echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
                    } ?>
                  </select>
                  <label for="fm-cbplan">Plan estudios</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbciclo" name="fm-cbciclo" placeholder="Ciclo" required >
                    <option value="%"></option>
                    <?php foreach ($ciclos as $ciclo) {?>
                    <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbciclo"> Semestre</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbturno" name="fm-cbturno" placeholder="Turno" required >
                    <option value="%"></option>
                    <?php foreach ($turnos as $turno) {?>
                    <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbturno"> Turno</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbseccion" name="fm-cbseccion" placeholder="Sección" required >
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
                  <div class="col-md-4 td">PERIODO</div>
                  <div class="col-md-6 td">PLAN</div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-8 td">PROG. ACAD.</div>
                  <div class="col-md-4 td">GRUPO</div>
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
var per_vcxg='<?php echo getPermitido("41"); ?>';
var per_vmxg='<?php echo getPermitido("43"); ?>';
var per_vcgp = '<?php echo getPermitido("149") ?>';
var cd1 = '<?php echo base64url_encode("1") ?>';
var cd2 = '<?php echo base64url_encode("2") ?>';
var cd7 = '<?php echo base64url_encode("7") ?>';
$(document).on('click', '.btn_culminar_grupo', function(e) {
    e.preventDefault();
    var boton = $(this);
    var fila=boton.closest(".rowcolor");
    var periodo = fila.data('per');
    var carrera = fila.data('car');
    var ciclo = fila.data('cic');
    var turno = fila.data('tur');
    var seccion = fila.data('sec');
    var plan = fila.data('plan');

    var periodon = fila.data('periodo');
    var carreran = fila.data('carrera');
    var ciclon = fila.data('ciclo');
    var turnon = fila.data('turno');
    var plann = fila.data('plann');
    var seccionn = fila.data('sec');


    $("#vw_md_gp_cul_periodo").html(periodon);
    $("#vw_md_gp_cul_programa").html(carreran);
    $("#vw_md_gp_cul_turno").html(turnon);
    $("#vw_md_gp_cul_plan").html(plann);
    $("#vw_md_gp_cul_semestre").html(ciclon);
    $("#vw_md_gp_cul_seccion").html(seccionn);


    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "grupos/fn_matriculados_x_grupo",
        type: 'post',
        dataType: 'json',
        data: {
          'fmt-cbperiodo' : periodo,
          'fmt-cbcarrera' : carrera,
          'fmt-cbciclo' : ciclo,
          'fmt-cbturno' : turno,
          'fmt-cbseccion' : seccion,
          'fmt-cbplan' : plan
        },
        success: function(e) {
            $('#divboxhistorial #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    title: 'Error!',
                    text: e.msg,
                    type: 'error',
                    icon: 'error',
                })
                
            } else {
              $('#divcard_data').html('');
              var nro=0;
              var tabla="";
              var btnscolor = "";
              var checkcul = "";
              if (e.vdata.length !== 0) {

                $.each(e.vdata, function(index, v) {
                  nro++;
                  checkcul = "";
                  switch (v['codestado']) {
                      case "1":
                          btnscolor = "btn-success";
                          checkcul = "<input class='form-check-input culmcheckbox' type='checkbox' data-mat='"+v['codmat64']+"' data-edit='' data-ant=''>";
                          break;
                      case "4":
                          btnscolor = "btn-secondary";
                          break;
                      case "2":
                          btnscolor = "btn-danger";
                          break;
                      default:
                          btnscolor = "btn-warning";
                  }
                  tabla=tabla +
                    "<div class='row rowcolor cfilagrupo' data-codigo='' data-idm='"+ v['codmat64']+"'>"+
                      "<div class='col-12 col-md-6'>"+
                          "<div class='row'>"+
                              "<div class='col-2 col-md-1 td' title='" + v['codigo'] +"'>"+nro+"</div>"+
                              "<div class='col-10 col-md-11 td calumno'>"+v['carne']+" - "+v['paterno']+' '+v['materno']+' '+v['nombres']+"</div>"+
                          "</div>"+
                      "</div>"+
                      "<div class='col-12 col-md-5'>"+
                          "<div class='row'>"+
                              "<div class='col-3 col-md-2 td text-center'>"+v['aprobados']+"</div>"+
                              "<div class='col-3 col-md-2 td text-center text-danger'>"+v['desaprobados']+"</div>"+
                              "<div class='col-3 col-md-2 td text-center text-danger'>"+v['nsp']+"</div>"+
                              "<div class='col-3 col-md-2 td text-center text-danger'>"+v['dpi']+"</div>"+
                              //"<div class='col-3 col-md-4 td text-center'><span class='badge "+btnscolor+" '> "+v['estado']+" </span></div>"+
                              "<div class='col-3 col-md-4 td text-center'>"+
                                '<div class="btn-group">' +
                                  '<button class="btn ' + btnscolor + ' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                  v['estado'] +
                                  '</button>' +
                                  '<div class="dropdown-menu">' +
                                    '<a href="#" onclick="cambiarEstado($(this));return false;" class="btn-cestado dropdown-item" data-ie="' + cd1 + '">Activo</a>' +
                                    '<a href="#" onclick="cambiarEstado($(this));return false;" class="btn-cestado dropdown-item"  data-ie="' + cd2 + '">Retirado</a>' +
                                    '<a href="#" onclick="cambiarEstado($(this));return false;" class="btn-cestado dropdown-item"  data-ie="' + cd7 + '">Repite</a>' +
                                    '<div class="dropdown-divider"></div>' +
                                    '<a href="#" onclick="eliminarMatricula($(this));return false;" class="btn-ematricula dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>' +
                                  '</div>' +
                                '</div>' +
                              "</div>"+



                          "</div>"+
                      "</div>"+
                      "<div class='col-12 col-md-1 td text-center'>"+
                        '<div class="form-check">'+
                          checkcul+
                        '</div>'+
                      "</div>"+
                    "</div>";

                })
              }

              $("#fmt_conteo").html(nro + ' matriculas encontradas');

              $('#allcheck').prop('checked', true);

              $('#divcard_data').html(tabla);
              $('#modculminagrupo').modal('show');
              
              checks = $('.cfilagrupo').find('.culmcheckbox').length;
              
              if (checks > 0) {
                $('#lbtn_culminar').attr('disabled', false);
              } else {
                $('#lbtn_culminar').attr('disabled', true);
              }

              if ($('#allcheck').prop('checked')) {
                $('.culmcheckbox').each(function() {
                  $(this).prop('checked',true);
                  $(this).data('edit', "1");
                })
                
              }
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divboxhistorial #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

 function cambiarEstado(btn) {
    var im = btn.closest(".cfilagrupo").data('idm');
    var ie = btn.data('ie');
    var btdt = btn.closest(".btn-group").find('.dropdown-toggle');
    //var btdt=btn.parents(".dropdown-toggle");
    var texto = btn.html();
    //alert(btdt.html());
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'matricula/fn_cambiarestado',
        type: 'post',
        dataType: 'json',
        data: {
            'ce-idmat': im,
            'ce-nestado': ie
        },
        success: function(e) {
            $('#divcard-matricular #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    type: 'error',
                    title: 'Error!',
                    text: e.msg,
                    backdrop: false,
                })
            } else {
                /*$("#fm-txtidmatricula").html(e.newcod);*/
                Swal.fire({
                    type: 'success',
                    title: 'Felicitaciones, estado actualizado',
                    text: 'Se ha actualizado el estado',
                    backdrop: false,
                })
                btdt.removeClass('btn-danger');
                btdt.removeClass('btn-success');
                btdt.removeClass('btn-warning');
                btdt.removeClass('btn-secondary');
                switch (texto) {
                    case "Activo":
                        btdt.addClass('btn-success');
                        btdt.html("ACTIVO");
                        break;
                        /*case "CUL":
                        btnscolor="btn-secondary";
                        break;*/
                    case "Retirado":
                        btdt.addClass('btn-danger');
                        btdt.html("RETIRADO");
                        break;
                      case "Repite":
                        btdt.addClass('btn-danger');
                        btdt.html("REPITE");
                        break;
                    default:
                        btnscolor = "btn-warning";
                }
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard-matricular #divoverlay').remove();
            Swal.fire({
                type: 'error',
                title: 'Error',
                text: msgf,
                backdrop: false,
            })
        }
    });
    return false;
};
function eliminarMatricula(btn) {
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var fila = btn.closest(".cfilagrupo");
    var im = fila.data('idm');
    var alumno = fila.find('.calumno').html();
    //************************************
    Swal.fire({
        title: "Precaución",
        text: "Se eliminarán las notas y asistencias del alumno " + alumno + ", en este curso: ",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.value) {
            //var codc=$(this).data('im');
            $.ajax({
                url: base_url + 'matricula/fn_eliminar',
                type: 'post',
                dataType: 'json',
                data: {
                    'ce-idmat': im
                },
                success: function(e) {
                    $('#divcard-matricular #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            type: 'error',
                            title: 'Error!',
                            text: e.msg,
                            backdrop: false,
                        })
                    } else {
                        /*$("#fm-txtidmatricula").html(e.newcod);*/
                        Swal.fire({
                            type: 'success',
                            title: 'Eliminación correcta',
                            text: 'Se ha eliminado la matrícula',
                            backdrop: false,
                        })
                        fila.remove();
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divcard-matricular #divoverlay').remove();
                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: msgf,
                        backdrop: false,
                    })
                }
            });
        } else {
            $('#divcard-matricular #divoverlay').remove();
        }
    });
    //***************************************
};

$(document).on('change', '.culmcheckbox', function() {
    var check = true;
    $(".culmcheckbox").each(function(index, el) {
        if ($(this).prop('checked') == false) {
            check = false;
            $(this).data('edit', "0");
        } else {
          $(this).data('edit', "1");
        }
    });
    $("#allcheck").prop('checked', check);
    
  })
  
  $('#modculminagrupo').on('hide.bs.modal', function () {
    $("#frmfiltro-grupos").submit();
  })

  $('#lbtn_culminar').click(function(e) {
    arrdata = [];
    $('#divcard_data .cfilagrupo div .culmcheckbox').each(function() {
      var isedit = $(this).data("edit");
      var idmat = $(this).data("mat");
      var valor = "";

      if (isedit == "1") {
        valor = 4;
        var myvals = [idmat, valor];
        arrdata.push(myvals);
      }
      
    })

    $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
      url: base_url + 'grupos/fn_culminar_grupo',
      type: 'post',
      dataType: 'json',
      data: {
          filas: JSON.stringify(arrdata),
      },
      success: function(e) {
          $('#divmodaladd #divoverlay').remove();
          if (e.status == false) {
              Swal.fire({
                  type: 'error',
                  icon: 'error',
                  title: 'ERROR, NO se guardó cambios',
                  text: e.msg,
                  backdrop:false,
              });
          } else {
              
            Swal.fire({
                type: 'success',
                icon: 'success',
                title: 'ÉXITO, Se guardó cambios',
                text: "Lo cambios fueron guardados correctamente",
                backdrop:false,
            });

            $("#modculminagrupo").modal("hide");
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception,'text');
          $('#divmodaladd #divoverlay').remove();
          Swal.fire({
              type: 'error',
              icon: 'error',
              title: 'ERROR, NO se guardó cambios',
              text: msgf,
              backdrop:false,
          });
      },
    })
  });

$("#frmfiltro-grupos").submit(function(event) {
    var sb=getUrlParameter("sb","");
    var jsparamSidebar=(sb=="")?"":"sb=" + sb + "&";
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
              var btn_culminar = "";
              $.each(e.vdata, function(index, v) {
                /* iterate through array or object */
                nro++;
                mt=mt + parseInt(v['mat']);
                ac=ac + parseInt(v['act']);
                rt=rt + parseInt(v['ret']);
                cl=cl + parseInt(v['cul']);
                
                var btn_carga='';
                var params='cp='+ v['codperiodo'] +'&cc='+ v['codcarrera'] + '&ccc='+ v['codciclo'] +'&ct='+ v['codturno']+'&cs='+ v['seccion']+'&cpl='+ v['idplan'];

                 btnregeval='<a class="dropdown-item" href="' + base_url + 'academico/consulta/nomina-evaluaciones/excel?' + params + '&at=1'+'"><i class="fas fa-file-excel"></i> Evaluaciones</a>'; 
                 btnactaregmat='<a class="dropdown-item" href="' + base_url + 'academico/consulta/nomina-matricula/excel?' + params +'"><i class="fas fa-file-excel"></i> Matriculados</a>';
                 btnpadeval='<a class="dropdown-item" href="' + base_url + 'academico/consulta/padron-evaluaciones/excel?' + params +'"><i class="fas fa-file-excel"></i> Padrón</a>';

                 btnord_merito='<a class="dropdown-item" target="_blank" href="' + base_url + 'academico/consulta/orden-merito/imprimir?' + params + '&at=1'+'"><i class="fas fa-sort-numeric-up-alt mr-1"></i> Mérito</a>';

                if (per_vcxg=='SI'){
                  
                  btn_carga='<a class="dropdown-item" href="' + base_url + 'gestion/academico/carga-academica/grupo?' + jsparamSidebar + params +'"><i class="fas fa-book-open mr-1"></i> Carga</a>';
                }
                if (per_vmxg=='SI'){

                  btn_matriculas='<a class="dropdown-item" href="' + base_url + 'gestion/academico/matriculas?' + jsparamSidebar + params + '&at=1'+'"><i class="fas fa-user mr-1"></i> Matrículas</a>';
                }

                if (per_vcgp == 'SI') {
                  btn_culminar = '<a class="dropdown-item btn_culminar_grupo"  href="#"><i class="far fa-times-circle mr-1"></i> Culminar</a>';
                }

                 btn_matricular='<a class="dropdown-item" data-periodo=' + v['codperiodo'] + ' data-carrera=' + v['codcarrera'] + ' data-ciclo=' + v['codciclo'] + ' data-turno=' + v['codturno'] + ' data-seccion=' + v['seccion'] + ' data-plan=' + v['idplan'] + ' title="Agregar matrícula" href="#" data-toggle="modal" data-target="#modal-addalumno"><i class="fas fa-user-plus mr-1"></i> Matrícula Rápida</a>';
                 
                 btn_egresar='<a class="dropdown-item"  data-periodo=' + v['codperiodo'] + ' data-carrera=' + v['codcarrera'] + ' data-ciclo=' + v['codciclo'] + ' data-turno=' + v['codturno'] + ' data-seccion=' + v['seccion'] + ' data-plan=' + v['idplan'] + ' title="Agregar matrícula" href="#" data-toggle="modal" data-target="#modal-addalumno"><i class="fas fa-user-graduate mr-1"></i> Egresar</i></a>';

                $("#div-filtro").append(
                '<div class="row rowcolor" data-per="'+ v['codperiodo'] +'" data-car="'+ v['codcarrera'] + '" data-cic="'+ v['codciclo'] +'" data-tur="'+ v['codturno']+'" data-sec="'+ v['seccion']+'" data-plan="'+ v['idplan']+'" data-periodo="'+ v['periodo'] +'" data-carrera="'+ v['carrera'] + '" data-ciclo="'+ v['ciclo'] +'" data-turno="'+ v['turno']+'" data-seccion="'+ v['seccion']+'" data-plann="'+ v['plan'] + '">' + 
                  '<div class="col-12 col-md-3">' + 
                    '<div class="row">' + 
                      '<div class="col-3 col-md-2 td">' + nro + '</div>' +
                      '<div class="col-9 col-md-3 td">' + v['periodo'] + '</div>' + 
                      '<div class="col-7 col-md-7 td" title="' + v['idplan']  +'">' + v['plan'] + '</div>' + 
                    '</div>' + 
                  '</div>' + 
                  
                  '<div class="col-6 col-md-4">' + 
                    '<div class="row">' + 
                      '<div class="col-8 col-md-8 td">' + v['carrera'] + '</div>' +
                      '<div class="col-5 col-md-4 td">' + v['ciclo'] + " - <b>" + v['turno'] + "</b> - " + v['seccion'] + '</div>' + 
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

                  
                                   
                  '<div class="col-12 col-md-2 ">' + 
                    '<div class="row">' + 
                      '<div class="col-4 col-md-5 td text-right">' + 
                        '<div class="btn-group btn-group-sm p-0 " role="group">' + 
                          '<button class="bg-success text-white rounded border-0 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                              'Actas' +
                          '</button>' +
                          '<div class="dropdown-menu">' +
                              btnactaregmat +
                              btnregeval +
                              '<div class="dropdown-divider"></div>' + 
                               btnpadeval +
                          ' </div>' +
                        '</div>' +
                      '</div>' +

                      '<div class="col-4 col-md-7 td text-right">' + 
                        '<div class="btn-group btn-group-sm p-0 " role="group">' + 
                          '<button class="bg-primary text-white rounded border-0 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                              'Opciones' +
                          '</button>' +
                          '<div class="dropdown-menu dropdown-menu-right">' +
                              btnord_merito +
                              btn_carga +
                              btn_matriculas +
                              '<div class="dropdown-divider"></div>' + 
                              btn_matricular + 
                              btn_culminar +
                              btn_egresar + 
                          ' </div>' +
                        '</div>' +
                      '</div>' +
                    '</div>' +
                  '</div>' +
                '</div>');
                //btn btn-success btn-sm 
              });
                $("#div-filtro").append(
                '<div class="row text-bold">' + 
                  '<div class="col-4 col-md-7">' + 
                   
                  '</div>' + 
                  '<div class="col-6 col-md-3">' + 
                    '<div class="row">' + 
                      '<div class="td col-2 col-md-3 text-right text-bold">' + mt + '</div>' + 
                      '<div class="td col-2 col-md-3 text-right text-primary text-bold">' + ac + '</div>' + 
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
        }
    });
    return false;
});
$('#modal-addalumno').on('hide.bs.modal', function () {
    $("#frmfiltro-grupos").submit();
// do something…
})
$('#modal-addalumno').on('show.bs.modal', function (e) {
    var btn = $(e.relatedTarget)
    
    $("#vwg_md_periodo").val(btn.data('periodo'));
    $("#vwg_md_carrera").val(btn.data('carrera'));
    $("#vwg_md_plan_nuevo").val(btn.data('plan'));
    $("#vwg_md_ciclo").val(btn.data('ciclo'));
    $("#vwg_md_seccion").val(btn.data('seccion'));
    $("#vwg_md_turno").val(btn.data('turno'));
    $("#lista-alumnos").html("");
    
  });
$('#txt-buscaralumnos').keypress(function(event) {
      var keycode = event.keyCode || event.which;
    if(keycode == '13') {
      $('#btn-buscaralumnos').click();
    }
});

$("#btn-buscaralumnos").click(function(event) {
    $('#lista-alumnos').html('<center><h4 class="text-primary">Buscando</h4><br /><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span><center>');
    
    var vcarga=$("#vidcurso").val();
    var valumno=$("#txt-buscaralumnos").val();
    var vperiodo=$("#vwg_md_periodo").val();
    var vcarrera=$("#vwg_md_carrera").val();//$("#vidperiodo").val();
    //var vdivision=$("#vdivision").val();
    $.ajax({
              url: base_url + 'inscrito/fn_get_datos_matriculantes' ,
        type: 'post',
        dataType: 'json',
        data: {periodo:vperiodo,alumno:valumno,carrera:vcarrera},
        success: function(e) {
          var resultados="";
          if (e.status==true){
            
            $.each(e.vdata, function(index, val) {
               resultados=resultados + 
                          "<div class='row rowcolor'>"+
                            "<div class='col-10'>" +
                              "<div class='row'>" + 
                                "<div class='col-12 col-md-4 td'>" +
                                      "<span><b>" + val['carne'] + "</b></span>" +
                                "</div>" + 
                                "<div class='col-12 col-md-8 td'>" +
                                  "<span>" + val['paterno'] + " " + val['materno'] + " " + val['nombres'] + "</span>" +
                                "</div> " + 
                              "</div>" +
                            "</div>" +
                           
                            "<div class='col-2 text-center td'>" +
                             
                              "<a href='#' data-inscripcion='" + base64url_encode(val['idinscripcion']) + "' data-planold='" + val['codplan'] + "' data-mapepaterno='" + val['paterno'] + "' data-mapematerno='" + val['materno'] + "' data-mnombres='" + val['nombres'] + "' data-msexo='" + val['sexo'] + "' onclick='vw_grupos_matricular($(this));event.preventDefault();' class='btn btn-primary btn-block btn-agregaralumno' title='Agregar'>" +
                                "<i class='fa fa-plus'></i><span class='d-none'> Agregar</span>" + 
                              "</a>" +

                            "</div>" +

                          "</div>";

            });
            if (resultados=="") resultados="<span class='text-danger'>No se encontraron resultados, comprueba que no este matriculado o que su inscripción sea ACTIVA</span>"
            $('#lista-alumnos').html(resultados);
          }
          else{
            $('#lista-alumnos').html(e.msg);
          }
          
        },
      error: function (jqXHR, exception) {
        var msgf=errorAjax(jqXHR, exception,'div');
      $('#lista-alumnos').html(msgf);
    },
      });
    return false;
  });
  
  function vw_grupos_matricular(boton){
    //var boton=$(this);/
    
    $(".btn-agregaralumno").addClass('disabled');

    var fmtxtid= boton.data('inscripcion');
    var fmcbtipo='O';
    var fmcbbeneficio="1";
    var fmcbperiodo=$("#vwg_md_periodo").val();
    var fmtxtcarrera=$("#vwg_md_carrera").val();
    var fmtxtplan=boton.data('planold');
    var fmcbplan=$("#vwg_md_plan_nuevo").val();
    var fmcbciclo=$("#vwg_md_ciclo").val();
    var fmcbturno=$("#vwg_md_turno").val();
    
    var fmcbseccion=$("#vwg_md_seccion").val();
    var fmtxtfecmatricula="0";
    var fmtxtcuota="0";
    var fmtxtobservaciones="";

    var fmtapepaterno = boton.data('mapepaterno');
    var fmtapematerno = boton.data('mapematerno');
    var fmtnombres = boton.data('mnombres');
    var fmtsexo = boton.data('msexo');
    //codcarga codmatricula division idmiembro
    boton.html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
    $.ajax({
      url: base_url + 'matricula/fn_insert',
      type: 'post',
      dataType: 'json',
      data: {
    "fm-txtid": fmtxtid,
    "fm-cbtipo": fmcbtipo,
    "fm-cbbeneficio": fmcbbeneficio,
    "fm-cbperiodo": fmcbperiodo,
    "fm-txtcarrera": fmtxtcarrera,
    "fm-cbplan": fmcbplan,
    "fm-txtplan": fmtxtplan,
    "fm-cbciclo": fmcbciclo,
    "fm-cbturno": fmcbturno,
    "fm-cbseccion": fmcbseccion,
    "fm-txtfecmatricula": fmtxtfecmatricula,
    "fm-txtcuota": fmtxtcuota,
    "fm-txtobservaciones": fmtxtobservaciones,
    "fm-txtmapepat":fmtapepaterno,
    "fm-txtmapemat":fmtapematerno,
    "fm-txtmnombres":fmtnombres,
    "fm-txtmsexo":fmtsexo},
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
  };



  </script>



