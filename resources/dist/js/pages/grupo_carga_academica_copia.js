function fn_search_alumnos(boton) {


  $('#divcard_cursos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $("#div_filtro_alumno").html("");
  var fila_carga=boton.closest(".rowcolor");
  var fila_division=boton.closest(".fdivision");

  var vdocente = fila_division.data("coddocente");
  var vunidad = fila_carga.data("codunidad");
  var vidsede = fila_carga.data("codses");


  var jscodccarga=fila_carga.data("codcarga");
  var jscoddivision=fila_division.data("coddivision");
  $.ajax({
      url: base_url + "grupos_descargar_notas/fn_get_alumnos_notas",
      type: 'post',
      dataType: 'json',
      data: {
        codcarga: jscodccarga,
        coddivision: jscoddivision,
      },
      success: function(e) {
          if (e.status == false) {

          } else {
            $('#divcard_cursos #divoverlay').remove();
            $('#divcard_grupo #divoverlay').remove();
            

            $('#modviewnotas').modal('show');
            var nro = 0;
            var tabla = "";
            var notafin = "";
            var notarec = "";
            var btndwl = "";
            if (e.vdata.length > 0) {
              if (vpermiso128 =='SI') {
                btndwl = '<a class="btn btn-info btn-sm btndownload_notas" href="#" onclick="fn_migrar_notas($(this));return false;" title="Migrar a Historial"><i class="fas fa-download"></i> </a>';
              } else {
                btndwl = "";
              }
              $.each(e.vdata, function(index, v) {
                nro++;
                var vcm = v['idmat_64'];
                var vcarga = v['idcarga_64'];
                var vdivision = v['iddivision_64'];
                
                var vcarrera = v['idcarrera_64'];
                var vciclo = v['idciclo_64'];
                var vperiodo = v['idperiodo_64'];
                var vplan = v['idplan_64'];
                var vseccion = v['idseccion_64'];
                var vturno = v['idturno_64'];
                var vidmiembro = v['idmiembro_64'];
                var codmatnota = v['codmatnota_64'];
                
                var notafin = (v['notafin'] !== null)? v['notafin']:"";
                var notarec = (v['notarec'] !== null)? v['notarec']:"";


                var notafin_his = (v['nota_his'] !== null)? v['nota_his']:"";
                var notarec_his = (v['nota_rec_his'] !== null)? v['nota_rec_his']:"";

                var fechamat = v['fechamat'];

                tabla = tabla +
                  '<div data-idm="'+vcm+'" data-miembro="'+vidmiembro+'" data-codmatnota="'+codmatnota+'" data-carga="'+vcarga+'" data-division="'+vdivision+'" data-docente="'+vdocente+'" data-carrera="'+vcarrera+'" data-ciclo="'+vciclo+'" data-periodo="'+vperiodo+'" data-plan="'+vplan+'" data-seccion="'+vseccion+'" data-turno="'+vturno+'" data-unidad="'+vunidad+'" data-estado="'+v['estado']+'" data-repitencia="'+v['repitencia']+'" data-notf="'+v['notafin']+'" data-notrec="'+v['notarec']+'" data-matfecha="'+fechamat+'" class="row cfila rowcolor ">' +
                    '<div class="col-4 col-md-3">' +
                      '<div class="row">' +
                        '<div class="col-3 col-md-3 td">' + nro + '</div>' +
                        '<div class="col-9 col-md-9 td">' + v['carne'] + '</div>' +
                      '</div>' +
                    '</div>' +
                    '<div class="col-8 col-md-4 td">' + v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + '</div>' +
                    '<div class="col-2 col-md-1 td text-center tdnota">' + notafin + '</div>' +
                    '<div class="col-2 col-md-1 td text-center tdnota_rec">' + notarec + '</div>' +
                    '<div class="col-4 col-md-1 td text-center">'+
                      btndwl+
                    '</div>' +
                    '<div class="col-2 col-md-1 td text-center tdnota_his">' + notafin_his + '</div>' +
                    '<div class="col-2 col-md-1 td text-center tdnota_rec_his">' + notarec_his + '</div>' +
                  '</div>';
              })
              $("#div_filtro_alumno").html(tabla);              
              $("#fmt-conteo").html(nro + ' Alumnos encontrados');
              $('#div_filtro_alumno').css('height', '359px');
              $('#vw_mpc_btn_subirnotas').show();
            } else {
              $("#div_filtro_alumno").html("<div class='text-danger h5'>Esta unidad didáctica aún no se ha culminado</div>");
              $("#fmt-conteo").html('');
              $('#div_filtro_alumno').css('height', 'auto');
              $('#vw_mpc_btn_subirnotas').hide();
            }
            
            
            //********************************************/
              
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#divcard_cursos #divoverlay').remove();
          $('#divcard_grupo #divoverlay').remove();
          //$('#divError').show();
          //$('#msgError').html(msgf);
      }
  });
  return false;
}

function fn_migrar_notas(btn){
//$(document).on('click', '.btndownload_notas', function() {
  //var btn = $(this);
  var fila=btn.closest('.rowcolor');
  var idmat = fila.data('idm');
  var codmatnota = fila.data('codmatnota');
  
  var carga = fila.data('carga');
  var division = fila.data('division');
  var docente = fila.data('docente');
  var miembro = fila.data('miembro');
  var carrera = fila.data('carrera');
  var ciclo = fila.data('ciclo');
  var periodo = fila.data('periodo');
  var plan = fila.data('plan');
  var seccion = fila.data('seccion');
  var turno = fila.data('turno');
  var unidad = fila.data('unidad');
  var estado = fila.data('estado');
  var repitencia = fila.data('repitencia');
  var notfin = fila.data('notf');
  var notrec = fila.data('notrec');

  var fechamatr = fila.data('matfecha');
  $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
    url: base_url + 'grupos_descargar_notas/fn_insert_update',
    type: 'post',
    dataType: 'json',
    data: {
        'fmt-codmatricula': idmat,
        'fmt-codmiembro': miembro,
        'fmt-codmatnota': codmatnota,
        
        'fmt-cbnperiodo': periodo,
        'fmt-cbncarrera': carrera,
        'fmt-cbnplan': plan,
        'fmt-cbnciclo': ciclo,
        'fmt-cbnturno': turno,
        'fmt-cbnseccion': seccion,
        'fmt-cbnunididact': unidad,
        'fmt-cbncargaacadem': carga,
        'fmt-cbncargaacadsubsec': division,
        'fmt-cbndocente': docente,
        'fmt-estado': estado,
        'fmt-repitencia': repitencia,
        'fmt-cbnnotafinal': notfin,
        'fmt-cbnnotarecup': notrec,
        'fmt-fechamatricula': fechamatr,
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
          fila.find('.tdnota_his').html(notfin);
          fila.find('.tdnota_rec_his').html(notrec);
          fila.data('codmatnota', e.matnota);
        Swal.fire({
            type: 'success',
            icon: 'success',
            title: 'ÉXITO, Se guardó cambios',
            text: "Lo cambios fueron guardados correctamente",
            backdrop:false,
        });
        
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
  return false;
};

$('#vw_mpc_btn_subirnotas').click(function() {
  arrdata = [];
  $('#div_filtro_alumno .rowcolor').each(function() {
    var idmat = $(this).data('idm');
    var codmatnota = $(this).data('codmatnota');

    var carga = $(this).data('carga');
    var division = $(this).data('division');
    var docente = $(this).data('docente');
    var miembro = $(this).data('miembro');
    var carrera = $(this).data('carrera');
    var ciclo = $(this).data('ciclo');
    var periodo = $(this).data('periodo');
    var plan = $(this).data('plan');
    var seccion = $(this).data('seccion');
    var turno = $(this).data('turno');
    var unidad = $(this).data('unidad');
    var estado = $(this).data('estado');
    var repitencia = $(this).data('repitencia');
    var notfin = $(this).data('notf');
    var notrec = $(this).data('notrec');

    var fechamatr = $(this).data('matfecha');

    var myvals = [idmat, miembro, codmatnota, carga, division, docente, carrera, ciclo, periodo, plan, seccion, turno, unidad, estado, repitencia, notfin, notrec, fechamatr];
    arrdata.push(myvals);
  })

  $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
    url: base_url + 'grupos_descargar_notas/fn_insert_update_global',
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
          
            $('#div_filtro_alumno .rowcolor').each(function() {
              fila=$(this);
              var codmatnota = $(this).data('codmatnota');

                $.each(e.vdata, function(index, val) {
                  if (val['estado']==true){
                    if (codmatnota==val['idorg']){
                        fila.data('codmatnota',val['idnew']);
                        fila.find('.tdnota_his').html(val['notafin']);
                        fila.find('.tdnota_rec_his').html(val['notarec']);
                    }
               

                  }
              })  
             
          });
         
        Swal.fire({
            type: 'success',
            icon: 'success',
            title: 'ÉXITO, Se guardó cambios',
            text: "Lo cambios fueron guardados correctamente",
            backdrop:false,
        });
        
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
  return false;
});