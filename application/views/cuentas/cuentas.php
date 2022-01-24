
<div class="content-wrapper">
  <?php 
    $vbaseurl=base_url();
    $vusersd=$_SESSION['userActivo'];
    $vpermactacc = getPermitido('166');
    $vpermasgper = getPermitido('113');
    $vpermasgsed = getPermitido('168');
    $vpermcmbacc = getPermitido('37');
    $vpermacteml = getPermitido('169');
    $vpermdeleus = getPermitido('167');
  ?>
  <link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/tree/bootstrap-treeview.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.css"/>

  <!-- Modal Sedes-->
  <div class="modal fade" id="modPermisos" tabindex="-1" role="dialog" aria-labelledby="modPermisos" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">PERMISOS</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
       <div class="modal-body" style="max-height: 60vh;overflow-y: scroll; overflow-x: hidden;" >
          <div id="divPermisos">
            
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" id="mpbtn-guardar" data-iduser='' data-idsede='<?php echo $_SESSION['userActivo']->idsede ?>' class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalSedes" tabindex="-1" role="dialog" aria-labelledby="modalSedes" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">SEDES</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul id="list-sedes" data-default='0' class="todo-list" data-widget="todo-list">
            
            <?php
            foreach ($sedes as $sede) {
            if ($sede->activo=='SI'){
            $sdid=$sede->id;
            ?>
            <li>
              <!-- drag handle -->
              <div class="row">
              <div class="custom-control custom-switch col-8">
                <input type="checkbox" class="custom-control-input" data-existe='NO' data-defecto='NO' data-ndefecto='NO' value="<?php echo $sdid ?>" id="ss<?php echo $sdid ?>">
                <label class="custom-control-label" for="ss<?php echo $sdid ?>"><?php echo $sede->nombre ?></label>
              </div>
              <div class="custom-control custom-radio col-4">
                <input type="radio" class="custom-control-input" name='sededef' value="<?php echo $sdid ?>" id="srd<?php echo $sdid ?>">
                <label class="custom-control-label" for="srd<?php echo $sdid ?>">Defecto</label>
              </div> 
              </div>
            </li>
            <?php }
            }
            ?>
            
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" id="msbtn-guardar" data-iduser='' class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>
  <!--EDITAR ACCESO-->
  <div class="modal fade" id="modalAcceso" tabindex="-1" role="dialog" aria-labelledby="modalAcceso" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Editar Acceso</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
              <input id="factxt-iduser" name="factxt-iduser" type="hidden" value="ADM">
              <div class="row">
                <div class="form-group has-float-label col-12 ">
                  <input class="form-control" id="factxt-user" name="factxt-user" type="text" placeholder="Usuario" minlength="4" required />
                  <label for="factxt-user"><span class="fas fa-user-tie"></span> Usuario</label>
                </div>
                <div class="form-group has-float-label col-12 ">
                  <input class="form-control" id="factxt-clave" name="factxt-clave" type="text" placeholder="Nueva contraseña" minlength="6" required />
                  <label for="factxt-clave"><span class="fas fa-user-tie"></span> Nueva contraseña</label>
                </div>
                 <div class="form-group has-float-label col-12 mt-3">
                  <input class="form-control" id="factxt-correo" name="factxt-correo" type="text" placeholder="Correo institucional *" minlength="4" required />
                  <label for="factxt-correo"><i class="fas fa-at"></i> Correo institucional *</label>

                </div>
                
                
                
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" id="mabtn-guardar" data-iduser='' class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Main content -->
  <section class="content pt-2">
    <div class="container-fluid">
      <div class="row">
        <!-- /.col -->
        <?php 
        $tipo=array();
        $tipo['AD'] =0; $tipo['DC']=0; $tipo['AL']=0;
        foreach ($cuentas as $tp) {
          $tipo[$tp->tipo]=$tp->conteo;
        } ?>
        <div class="col-md-12">
          <div id="divboxbusqueda" class="card">
            <div class="card-header p-2">
              <h3 class="card-title text-bold"><i class="fas fa-user-circle mr-1"></i> Cuentas de usuario</h3>
            </div>
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item">
                  <a class="nav-link active" href="#tda" data-id='tda' data-tipo="ADM" data-toggle="tab">
                    Administrativos y docentes &nbsp;<span class="badge badge-danger right"><?php echo $tipo['AD'] + $tipo['DC'] ?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#tla" data-id='tla' data-tipo="ALU" data-toggle="tab">
                    Alumnos &nbsp;<span class="badge badge-danger right"><?php echo $tipo['AL'] ?></span>
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <!-- /.tab-content -->
              <form id="frm-filtro-admin" name="frm-filtro-admin" action="<?php echo $vbaseurl ?>usuario/fn_filtrar_cuentas" method="post" accept-charset='utf-8'>
                <input id="txttipo" name="txttipo" type="hidden" value="ADM">
                <div class="row">
                  <div class="form-group has-float-label col-12 col-sm-2 col-md-2">
                    <select name="fictxtsede" id="fictxtsede" class="form-control form-control-sm">
                      <option value="%">Todos</option>
                      <?php 
                        foreach ($sedes as $filial) {
                          $select=($vusersd->idsede==$filial->id) ? "selected":"";
                          echo "<option $select value='$filial->id'>$filial->nombre</option>";
                        } 
                      ?>
                    </select>
                    <label for="fictxtsede"><i class="far fa-building"></i> Sede</label>
                  </div>

                  <div class="form-group has-float-label col-12 col-sm-5 col-md-5">
                    <input autocomplete="off" class="form-control form-control-sm" id="txtadmin" name="txtadmin" type="text" placeholder="Apellidos y nombres" minlength="3" required />
                    <label for="txtadmin"><span class="fas fa-user-tie"></span> Apellidos y nombres</label>
                  </div>

                  <div class="form-group has-float-label col-4 col-sm-2 col-md-2">
                    <select name="fictxtactivous" id="fictxtactivous" class="form-control form-control-sm">
                      <option value="SI">Activo</option>
                      <option value="NO">Bloqueado</option>
                    </select>
                    <label for="fictxtactivous">Estado</label>
                  </div>

                  <div class="form-group col-4 col-sm-1 col-md-1 text-center">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" name="actcheckemail" id="customSwitchemail">
                      <label class="custom-control-label" for="customSwitchemail">@</label>
                    </div>
                  </div>

                  <div class="col-4 col-sm-2 col-md-2">
                    <button type="submit" class="btn btn-sm btn-primary btn-block"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </form>
              <div class="row div-resultados" id="divres-administrativo">
                  <div class="table-responsive col-12" id="tabdivres-administrativo">
                    <table id="tbmt_dtusuarios" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                      <thead>
                        <tr class="bg-lightgray">
                          <th>N°</th>
                          <th>User</th>
                          <th>Apellidos y Nombres</th>
                          <th>Correo Corporativo</th>
                          <th>Permisos</th>
                          <th>@</th>
                        </tr>
                      </thead>
                      <tbody>
                                    
                      </tbody>
                    </table>
                  </div>
              </div>
              <div class="row div-resultados" id="divres-docente">
                    
              </div>
              <div class="row div-resultados" id="divres-alumno">
                  <div class="table-responsive col-12" id="tabdivres-alumno">
                    <table id="tbmt_dtusuariosalum" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                      <thead>
                        <tr class="bg-lightgray">
                          <th>N°</th>
                          <th>User</th>
                          <th>Apellidos y Nombres</th>
                          <th>Correo Corporativo</th>
                          <th>Permisos</th>
                          <th>@</th>
                        </tr>
                      </thead>
                      <tbody>
                                    
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
 <script src="<?php echo $vbaseurl ?>resources/plugins/tree/bootstrap-treeview.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.js"></script>
<script>
  vpermactacc = '<?php echo $vpermactacc ?>';
  vpermasgper = '<?php echo $vpermasgper ?>';
  vpermasgsed = '<?php echo $vpermasgsed ?>';
  vpermcmbacc = '<?php echo $vpermcmbacc ?>';
  vpermacteml = '<?php echo $vpermacteml ?>';
  vpermdeleus = '<?php echo $vpermdeleus ?>';

  $('.tbdatatable tbody').on('click', 'tr', function() {
    tabla = $(this).closest("table").DataTable();
    if ($(this).hasClass('selected')) {
        //Deseleccionar
        //$(this).removeClass('selected');
    } else {
        //Seleccionar
        tabla.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
    }
  });

  $('.nav-pills a').on('shown.bs.tab', function(event){
    $("#txttipo").val($(event.target).data('tipo'));
    $(".div-resultados").hide();
    if ($("#txttipo").val()=="ADM"){
      $("#divres-administrativo").show();
    }
    else if ($("#txttipo").val()=="DOC"){

      $("#divres-docente").show();
    }
    else{
      
      $("#divres-alumno").show();
    }
    if (history.pushState) {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?ts=' + $(event.target).data('id');
            window.history.pushState({path:newurl},'',newurl);

           
    }
  });

  $('#frm-filtro-admin').submit(function() {
      $('input:text').removeClass('is-invalid');
      $('.invalid-feedback').remove();
      $('#divboxbusqueda').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      
      //$('#divres-administrativo').html('<center><h4 class="text-primary">Buscando</h4><br /><i class="fas fa-spinner fa-pulse fa-3x"></i><span class="sr-only">Loading...</span><center>');
      tipous = $("#txttipo").val();
      tbcuentasadm = (tipous == "ADM") ? $('#tbmt_dtusuarios').DataTable() : $('#tbmt_dtusuariosalum').DataTable();
      tbcuentasadm.clear();
      
      $.ajax({
          url: $(this).attr("action"),
          type: 'post',
          dataType: 'json',
          data: $(this).serialize(),
          success: function(e) {
              $('#divboxbusqueda #divoverlay').remove();
              if (e.status == false) {
                  $.each(e.errors, function(key, val) {
                      $('#' + key).addClass('is-invalid');
                      $('#' + key).after("<div class='invalid-feedback'>" + val + "</div>");
                  });
              } else {
                var nro = 0;
                // SI
                vicon="fa-user-check";
                vtitle="Desactivar";
                cambio='NO';
                btncolor="bg-success";
                correogen = "";
                actvcorreogen = "";
                acciones = "";
                actions = "";
                view_sede = "";
                view_acceso = "";
                view_permisos = "";
                view_hab_des = "";
                view_delete = "";
                view_correo = "";
                $.each(e.vdata, function(index, v) {
                  nro++;
                  nombres = v['paterno']+' '+v['materno']+' '+v['nombres'];
                  if (v['activo']=='NO'){
                    vicon="fa-user-times";
                    vtitle="Activar";
                    cambio='SI';
                    btncolor="bg-danger";
                  } else {
                    vicon="fa-user-check";
                    vtitle="Desactivar";
                    cambio='NO';
                    btncolor="bg-success";
                  }

                  if (v['email_generado']=='NO'){
                    correogen = "";
                    actvcorreogen = "SI";
                  } else {
                    correogen = "checked";
                    actvcorreogen = "NO";
                  }

                  if (vpermasgsed == "SI") {
                    view_sede = '<a class="py-1 px-2 mr-2 rounded bg-success " href="#" onclick="viewsedes(`'+v['vcodigo64']+'`)" title="Sedes">'+
                                '<i class="far fa-building"></i>'+
                              '</a>';
                  }

                  if (vpermcmbacc == "SI") {
                    view_acceso = '<a class="py-1 px-2 mr-2 rounded bg-info " href="#" data-toggle="modal" data-target="#modalAcceso" '+
                                  'data-iduser="'+v['vcodigo64']+'" data-user="'+v['usuario']+'" data-ecorpo="'+v['ecorporativo']+'" title="Cambiar Acceso">'+
                                  '<i class="fas fa-key"></i>'+
                                '</a>';
                  }
                  
                  
                  if (vpermasgper == "SI") {
                    view_permisos = '<a class="py-1 px-2 mr-2 rounded bg-warning" href="#" onclick="viewpermisos(`'+v['vcodigo64']+'`)" title="Permisos">'+
                                    '<i class="fas fa-shield-alt"></i>'+
                                  '</a>';
                  }
                  
                  if (vpermactacc == "SI") {
                    view_hab_des = '<a class="py-1 px-2 mr-2 rounded '+btncolor+' btn-desactivar" href="#" data-toggle="modal" data-target="#modalDesactivar" data-activo="'+cambio+'" data-user="'+nombres+'" data-id="'+v['vcodigo64']+'" title="'+vtitle+'">'+
                                    '<i class="fas '+vicon+'"></i>'+
                                  '</a>';
                  }
                  
                  if (vpermdeleus == "SI") {
                    view_delete = '<a class="btn-delete bg-danger py-1 px-2 mr-2 rounded" target="_blank" href="#" data-cu="'+v['vcodigo64']+'" title="Eliminar Usuario">'+
                                  '<i class="fas fa-trash-alt"></i> '+
                                '</a>';
                  }
                  
                  if (vpermacteml == "SI") {
                    view_correo = '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success d-inline" style="top: -5px;">'+
                                  '<input '+correogen+' type="checkbox" class="custom-control-input custom_email_gen" id="customSwitch'+nro+'" data-id="'+v['vcodigo64']+'" data-activo="'+actvcorreogen+'">'+
                                  '<label class="custom-control-label" for="customSwitch'+nro+'"></label>'+
                                '</div>';
                  }
                  

                  acciones = view_sede + view_acceso + view_permisos + view_hab_des ;
                  actions = view_correo + view_delete;

                  var fila = tbcuentasadm.row.add([index + 1, v['usuario'], nombres, v['ecorporativo'], acciones, actions]).node();
                })


                if ($("#txttipo").val()=="ADM"){
                  // $("#divres-administrativo").html(e.vdata);
                  tbcuentasadm.draw();
                }
                else if ($("#txttipo").val()=="DOC"){
                  $("#divres-docente").html(e.vdata);
                }
                else{
                  // $("#divres-alumno").html(e.vdata);
                  tbcuentasadm.draw();
                }
                
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#divboxbusqueda #divoverlay').remove();
              $('#divError').show();
              $('#msgError').html(msgf);
          }
      });
      return false;
  });


  function viewsedes(icod){
   $('#divboxbusqueda').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
   $('#modalSedes input[type=checkbox]').prop('checked', false);
   $('#modalSedes input[type=radio]').prop('checked', false);
   $('#list-sedes').data('default', '0');
   $("#msbtn-guardar").data('iduser', icod)



    $('#modalSedes input[type=checkbox]').data('existe', 'NO');
    //$('#modalSedes input[type=checkbox]').prop('checked', false)
    $.ajax({
        url: base_url + "sede/fn_sede_por_usuario",
        type: 'post',
        dataType: "json",
        data: {
            txtcoduser: icod
        },
        success: function(e) {
          var sdf=0;
           $.each(e.vdata, function(key, val) {
              $('#ss' + val['idsede']).prop('checked', true)
              $('#ss' + val['idsede']).data('existe', 'SI')
              if (val['esdefecto']=='SI') sdf=val['idsede'];
            });
           $('#divboxbusqueda #divoverlay').remove();

            $('#modalSedes input[type=checkbox]').data('defecto', 'NO');
           if (sdf!=0){
              $('#list-sedes').data('default', sdf);
              $('#srd' + sdf).prop('checked', true);
              $('#ss' + sdf).data('defecto', 'SI');
           } 
           
          $("#modalSedes").modal("show");
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'div' );
            $('#divboxbusqueda #divoverlay').remove();
            $("#modalSedes modal-body").html(msgf);
        } 
    });
    return false;
  }
  function viewpermisos(icod){
   $('#divboxbusqueda').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
   /*$('#modalSedes input[type=checkbox]').prop('checked', false);
   $('#modalSedes input[type=radio]').prop('checked', false);
   $('#list-sedes').data('default', '0');
   $("#msbtn-guardar").data('iduser', icod)*/
   $("#divPermisos").html("");
   $("#mpbtn-guardar").data('iduser', icod)
    $.ajax({
        url: base_url + "usuario/vw_permisos_por_usuario",
        type: 'post',
        dataType: "json",
        data: {
            txtcoduser: icod
        },
        success: function(e) {
          
          $('#divboxbusqueda #divoverlay').remove();
          $("#divPermisos").html(e.rweb);
          //$("#mpbtn-guardar").data('idsede', icod)
          $("#modPermisos").modal("show");
          
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'div');
            $('#divboxbusqueda #divoverlay').remove();
            $("#modPermisos modal-body").html(msgf);
        } 
    });
    return false;
  }

  $("#msbtn-guardar").click(function(event) {
    /* Act on the event */
    arr_insert = [];
    arr_update = [];
    arr_delete = [];
    
    var iduser=$(this).data('iduser');
    var sd_curdef=$('#list-sedes').data('default');

    $('#modalSedes input[type=checkbox]').data('ndefecto', 'NO');
    var sd_newdef=$("#modalSedes input[name='sededef']:checked").val();
    sd_newdef=(sd_newdef===undefined)? 0 : sd_newdef;
    $('#ss' + sd_newdef).data('ndefecto', 'SI');

    $("#modalSedes input:checkbox").each(function() {
        var el=$(this);
        var is_checked=el.prop('checked');
        if (is_checked==true){
          if (el.data('existe')=='SI'){
            if (el.data('ndefecto')!=el.data('defecto')){
              var myvals = [el.data('ndefecto'), iduser, el.val()];
              arr_update.push(myvals);
            }
          }
          else{
              var myvals = [el.val(), iduser, el.data('ndefecto')];
              arr_insert.push(myvals);
          }
        }
        else{
          if (el.data('existe')=='SI'){
            var myvals = [el.val(),iduser];
            arr_delete.push(myvals);
          }
        }
    });

    $.ajax({
        url: base_url + "usuario/fn_asignar_sedes",
        type: 'post',
        dataType: "json",
        data: {
                finsertar: JSON.stringify(arr_insert),
                feditar: JSON.stringify(arr_update),
                feliminar: JSON.stringify(arr_delete),
        },
        success: function(e) {
          if (e.status==true){
            $("#modalSedes").modal("hide");
          }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'div');
            $('#divboxbusqueda #divoverlay').remove();
            $("#modalSedes modal-body").html(msgf);
        } 
    });

  });

  $("#mpbtn-guardar").click(function(event) {
    /* Act on the event */
      var iduser=$(this).data('iduser');
      var idsede=$(this).data('idsede');
      var arac = [];
      var arun = [];
      var sl=$('#treeview-checkable').treeview('getChecked', "");
      $.each(sl, function(index, node) {
        arac.push({ id:node.idpermiso , idAccion: node.tags.id, idPadre:node.tags.idpadre, permitido: node.state.checked});
      });
      var slun=$('#treeview-checkable').treeview('getUnchecked', "");
      $.each(slun, function(index, node) {
        if (node.idpermiso!="")  arun.push(node.idpermiso);
      });
      
      $.ajax({
          url: base_url + 'usuario/fn_asignar_permisos',
          type: 'post',
          dataType: 'json',
          data: {acciones: JSON.stringify(arac),uncheck: JSON.stringify(arun), txtcoduser: iduser, txtcodsede: idsede},
          success: function(e) {
            if (e.status == false) {

            } 
            else {
              $("#modPermisos").modal("hide");
            }
          }
        });
        return false;
  });



  $("#mabtn-guardar").click(function(event) {
    /* Act on the event */ 
      $('input:text').removeClass('is-invalid');
      $('.invalid-feedback').remove();
      var error=false;
      /*VALIDAR CORREO*/
      var correo= $("#factxt-correo").val();
      var posesp= correo.indexOf(" ");
      if (posesp==-1){
          var pos= correo.indexOf("@");
          if (pos>-1){
            //var vecorpo = $.trim(correo.substr(0, pos));
            //$("#factxt-correo").val(vecorpo);
          }
          else{
             $('#factxt-correo').addClass('is-invalid');
                    $('#factxt-correo').after("<div class='invalid-feedback'>Ingresa un correo válido, usa el @dominio</div>");
                    error=true;
          }
          if ($("#factxt-correo").val().length<4){
                    $('#factxt-correo').addClass('is-invalid');
                    $('#factxt-correo').after("<div class='invalid-feedback'>Ingresa un correo válido, con mas de 3 caracteres</div>");
                    error=true;
          }
      }
      else{
          $('#factxt-correo').addClass('is-invalid');
          $('#factxt-correo').after("<div class='invalid-feedback'>Ingresa un correo válido, SIN ESPACIOS</div>");
          error=true;
      }

      /*VALIDAR USUARIO*/
      var vuser= $("#factxt-user").val();
      var posesp= vuser.indexOf(" ");
      if (posesp==-1){
          if ($("#factxt-user").val().length<4){
                    $('#factxt-user').addClass('is-invalid');
                    $('#factxt-user').after("<div class='invalid-feedback'>Ingresa un USUARIO válido, con mas de 3 caracteres</div>");
                    error=true;
          }
      }
      else{
          $('#factxt-user').addClass('is-invalid');
          $('#factxt-user').after("<div class='invalid-feedback'>Ingresa un USUARIO válido, SIN ESPACIOS</div>");
          error=true;
      }

      /*VALIDAR USUARIO*/
      var posesp= $("#factxt-clave").val().length;
      if (posesp>0){
          if ($("#factxt-clave").val().length<6){
                    $('#factxt-clave').addClass('is-invalid');
                    $('#factxt-clave').after("<div class='invalid-feedback'>Ingresa una Contraseña válida, con mas de 6 caracteres</div>");
                    error=true;
          }
      }
      var vcorreo= $("#factxt-correo").val();
      var vusua= $("#factxt-user").val();
      var vidusua= $("#factxt-iduser").val();
      var vclave= $("#factxt-clave").val();
      if (error==false){
        $.ajax({
          url: base_url + 'usuario/fn_cambiar_acceso',
          type: 'post',
          dataType: 'json',
          data: {iduser: vidusua,user: vusua, clave: vclave, correo: vcorreo},
          success: function(e) {
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                      $('#' + key).addClass('is-invalid');
                      $('#' + key).after("<div class='invalid-feedback'>" + val + "</div>");
                });
            } 
            else {
              $("#modalAcceso").modal("hide");
            }
          }
        });
      }
      /*$.ajax({
          url: base_url + 'usuario/fn_asignar_permisos',
          type: 'post',
          dataType: 'json',
          data: {acciones: JSON.stringify(arac),uncheck: JSON.stringify(arun), txtcoduser: iduser, txtcodsede: idsede},
          success: function(e) {
            if (e.status == false) {

            } 
            else {
              $("#modPermisos").modal("hide");
            }
          }
        });*/
        return false;
  });



  $('#modalAcceso').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      //var modal = $(this);
      var viduser = button.data('iduser');
      var vuser = button.data('user');
      var correo= button.data('ecorpo');
      //var posicionarroba = ;

      var vecorpo = correo;//.substr(0, (correo.indexOf("@")));;
       //$('#divboxbusqueda').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $("#factxt-user").val(vuser);
      $("#factxt-iduser").val(viduser);
      $("#factxt-clave").val("");
      $("#factxt-correo").val(vecorpo);
  //$('#divboxbusqueda #divoverlay').remove();
      
  })

  $(document).ready(function() {
    var vtab = getUrlParameter('ts',"tda");
    $('.nav-pills a[href="#'+ vtab + '"]').tab('show');
    $(".div-resultados").hide();

    if (vtab=="tla"){
      $("#divres-alumno").show();
    }
    else if (vtab=="tda"){
      
      $("#divres-administrativo").show();
    }
    else{
      $("#divres-alumno").hide();
      $("#divres-administrativo").hide();

    }
    $("#txtadmin").focus();

    var table = $('#tbmt_dtusuarios, #tbmt_dtusuariosalum').DataTable({
        "autoWidth": false,
        "pageLength": 50,
        "lengthChange": false,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
        },
        'columnDefs': [{
            "targets": 0, // your case first column
            "className": "text-right rowhead",
            "width": "8px"
        }],
        'searching': false,
        dom: "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",

    });

  });

  $(document).on("click", ".btn-desactivar", function(e){
    e.preventDefault();
    desactivar($(this));
  })

  function desactivar(btn){
        var viduser=btn.data('id');
        var vactivo=btn.data('activo');
        var user=btn.data('user');

        var vtitle='¿Deseas desactivar a ' + user + '?';
        var vtext="Al desactivarlo, el usuario no podrá acceder al sistema, permaneceran inactivos hasta reactivarlo";
        var vbtext='Si, desactivar!';
        if (vactivo=="SI"){
          vtitle='¿Deseas activar a ' + user + '?';
          vtext="Al Activarlo, el usuario podrá acceder al sistema";
          vbtext='Si, Activar!';
        }
        Swal.fire({
        title: vtitle,
        text: vtext,
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: vbtext
      }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + 'usuario/fn_activado',
                type: 'POST',
                data: {activo: vactivo,iduser: viduser},
                dataType: 'json',
                success: function(e) {
                  if (e.status==true){
                    if (vactivo=='SI'){
                      
                      btn.removeClass('bg-danger');
                      btn.addClass('bg-success');

                      btn.data('activo', 'NO');
                      btn.html("<i class='fas fa-user-check'></i> <span class='d-block d-md-none'> Desactivar </span>")
                    }
                    else{
                      
                      btn.removeClass('bg-success');
                      btn.addClass('bg-danger');
                      
                      btn.data('activo', 'SI');
                      btn.html("<i class='fas fa-user-times'></i> <span class='d-block d-md-none'> Activar </span>")
                    }
                    
              Swal.fire(
                  'Desactivado!',
                  'La división '+ user + ' fue modificado correctamente.',
                  'success'
                )
                  }
                  else{
                     resolve(e.msg);
                  }
                },
                error: function(jqXHR, exception) {
                  //$('#divcard_grupo #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire(
                  'Error!',
                  msgf,
                  'error'
                )
                }
            })
        }
      });
  }

  $(document).on("click", ".btn-delete", function(e){
    e.preventDefault();
    tipous = $("#txttipo").val();
    tbcuentasadm = (tipous == "ADM") ? $('#tbmt_dtusuarios').DataTable() : $('#tbmt_dtusuariosalum').DataTable();
    fila = tbcuentasadm.$('tr.selected');
        $('#divboxbusqueda').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var cins=$(this).data("cu");
        // var fila=$(this).parents(".cfila");
        
        //************************************
        Swal.fire({
          title: "Precaución",
          text: "Se eliminarán todos los datos con respecto a este INSCRIPCIÓN ",
          type: 'warning',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.value) {
                  //var codc=$(this).data('im');
                $.ajax({
                  url: base_url + 'usuario/fn_eliminar',
                  type: 'post',
                  dataType: 'json',
                  data: {
                          'ce-iduser': cins
                      },
                  success: function(e) {
                      $('#divboxbusqueda #divoverlay').remove();
                      if (e.status == false) {
                          Swal.fire({
                              type: 'error',
                              icon: 'error',
                              title: 'Error!',
                              text: e.msg,
                              backdrop: false,
                          })
                      } else {
                          /*$("#fm-txtidmatricula").html(e.newcod);*/
                          Swal.fire({
                              type: 'success',
                              icon: 'success',
                              title: 'Eliminación correcta',
                              text: 'Se ha eliminado el Usuario',
                              backdrop: false,
                          })
                          
                          fila.remove();
                      }
                  },
                  error: function(jqXHR, exception) {
                      var msgf = errorAjax(jqXHR, exception, 'text');
                      $('#divboxbusqueda #divoverlay').remove();
                      Swal.fire({
                          type: 'error',
                          icon: 'error',
                          title: 'Error',
                          text: msgf,
                          backdrop: false,
                      })
                  }
              });
            }
            else{
              $('#divboxbusqueda #divoverlay').remove();
            }
        });
                //***************************************
  });

  $(document).on('click', '.custom_email_gen', function(e) {
    e.preventDefault();
    check = $(this);
    var viduser=check.data('id');
    var vactivo=check.data('activo');
    $('#divboxbusqueda').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
      url: base_url + 'usuario/fn_email_corporativo_generado',
      type: 'POST',
      data: {activo: vactivo,iduser: viduser},
      dataType: 'json',
      success: function(e) {
        $('#divboxbusqueda #divoverlay').remove();
        if (e.status==true){
          if (vactivo == "SI") {
            check.prop('checked', true);
            check.data('activo', 'NO');
          } else {
            check.prop('checked', false);
            check.data('activo', 'SI');
          }

          Swal.fire(
            'Éxito!',
            'Los cambios fueron modificado correctamente.',
            'success'
          )
        }
        else{
           resolve(e.msg);
        }
      },
      error: function(jqXHR, exception) {
        $('#divboxbusqueda #divoverlay').remove();
          var msgf = errorAjax(jqXHR, exception, 'text');
          Swal.fire(
            'Error!',
            msgf,
            'error'
          )
      }
    })

  });

</script>