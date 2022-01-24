<?php
$vbaseurl=base_url();
if (getPermitido("29")=='SI'){
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>PANEL ACCIONES</h1>
        </div>
      </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Lista de componentes y acciones</h3>
          <!--<div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
          </div>-->

          <div class="col-xs-6 text-right no-padding">
            <button type="button" id="btnElimarAcCom" class="btn btn-sm btn-default"  data-toggle='modal' data-target='#modAcciones' data-view="elimina" ><i class="fa fa-eraser"></i> Eliminar</button>
            <button type="button" id="btnEditarAcCom" class="btn btn-sm btn-default"  data-toggle='modal' data-target='#modAcciones' data-view="edita" ><i class="fa fa-pencil"></i> Editar</button>
            <button type="button" class="btn btn-sm btn-default"  data-toggle='modal' data-target='#modAcciones' data-view="inserta"  ><i class="fa fa-plus"></i> Agregar</button>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="card-body">
          <div id="treeview-nodes" class="">
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/tree/bootstrap-treeview.css">
  <div class="modal fade" id="modAcciones" tabindex="-1" role="dialog" aria-labelledby="modAccionesLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title text-primary" id="modAccionesLabel"><b>Editar Item</b></h4>
          
        </div>
        <div class="col-xs-12">
          <div class="alert alert-success" id="eacmsgpysi">
          </div>
          <div class="alert alert-danger" id="eacmsgpyno">
          </div>
          <div class="panel panel-default" id="eaceloading">
            <div class="panel-body">
              <i class="fas fa-spinner fa-pulse fa-3x"></i>
            </div>
          </div>
          <br>
        </div>
        <form id='frmEliminarAccion' name='frmEliminarAccion'  action='<?php echo $vbaseurl;?>acciones/deleteComponent' method='post' accept-charset='utf-8'>
          
          <div class="modal-body" >
            <div class="clearfix"></div>
            <div id="divrester">
              <div class="form-group">
                <label for="pwdact">Item:</label>
                <input type="hidden" value=""  name="dctxtidpadre" id="dctxtidpadre">
                <input type="hidden" value=""  name="dctxtiditem" id="dctxtiditem">
                <input type="text" class="form-control" name="dctxtitem" id="dctxtitem" value="">
              </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"> Salir </button>
            <button type="submit" id="btndeletAccion" class="btn btn-primary"> Eliminar</button>
          </div>
        </form>
        <form id='frmEditarAccion' name='frmEditarAccion'  action='<?php echo $vbaseurl;?>acciones/update' method='post' accept-charset='utf-8'>
          
          <div class="modal-body" >
            <div class="clearfix"></div>
            <div id="divrester">
              <div class="form-group">
                <label for="pwdact">Item:</label>
                <input type="hidden" value=""  name="actxttipo" id="actxttipo">
                <input type="hidden" value=""  name="actxtiditem" id="actxtiditem">
                <input type="text" class="form-control" name="actxtitem" id="actxtitem" value="">
              </div>
            </div>
            <div class="form-group">
              <label for="cbpadre">Nodo Padre:</label>
              
              <select id="cbpadre" name="cbpadre" class="form-control" placeholder="Sexo">
                <?php
                echo "<option value='0'>(Módulo)</option>";
                foreach ($nodosPadres as $nv) {
                $idnp=$nv['v2'];
                $np=$nv['v3'];
                if ($nv['v5']=="C") echo "<option value='$idnp'>$idnp"." - "."$np</option>";
                }
                ?>
                
              </select>
            </div>
            
            <div class="checkbox">
              <label><input type="checkbox" id="acckhabil" name="acckhabil" value="1" checked>HABILITADO</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"> Salir </button>
            <button type="submit" id="btneditAccion" class="btn btn-primary"> Guardar</button>
          </div>
        </form>
        
        <form id='frmAgregarAccion' name='frmAgregarAccion'  action='<?php echo $vbaseurl;?>acciones/insert' method='post' accept-charset='utf-8'>
          
          <div class="modal-body" >
            <div class="clearfix"></div>
            <div id="divrester">
              
              <label for="pwdact" class="control-label">Tipo: </label><br>
              <label class="radio-inline"><input type="radio" name="icrdtipo" value="C" checked> Contenedor</label>
              <label class="radio-inline"><input type="radio" name="icrdtipo" value="A"> Acción</label>
              <br>
              <div class="form-group">
                <label for="pwdact">Item:</label>
                
                
                <input type="text" class="form-control" name="ictxtitem" id="ictxtitem" value="">
              </div>
            </div>
            <div class="form-group">
              <label for="icbpadre">Nodo Padre:</label>
              
              <select id="icbpadre" name="icbpadre" class="form-control" placeholder="Nodo">
                <?php
                echo "<option value='0'>(Módulo)</option>";
                foreach ($nodosPadres as $nv) {
                $idnp=$nv['v2'];
                $np=$nv['v3'];
                if ($nv['v5']=="C") echo "<option value='$idnp'>$idnp"." - "."$np</option>";
                }
                ?>
                
              </select>
            </div>
            
            <div class="checkbox">
              <label><input type="checkbox" id="acckhabil" name="icckhabil" value="1" checked>HABILITADO</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"> Salir </button>
            <button type="submit" id="btnAgregarAccion" class="btn btn-primary"> Crear </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="<?php echo $vbaseurl ?>resources/plugins/tree/bootstrap-treeview.js"></script>
  <script>
    $('#btnEditarAcCom').prop('disabled', 'true')
    $('#btnElimarAcCom').prop('disabled', 'true')

    function cargaPermisos() {
        location.reload();
    }
    $('#frmEditarAccion').submit(function() {
        $('#eaceloading').show();
        $("#eacmsgpysi").hide();
        $("#eacmsgpyno").hide();
        $.ajax({
            url: $(this).attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frmEditarAccion').serialize(),
            success: function(e) {
                $('#eaceloading').hide();
                if (e.logeo == true) {
                    if (e.status == false) {
                        $('#eacmsgpyno').show();
                        $('#eacmsgpyno').html(e.msg + "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>");
                    } else {
                        $('#eacmsgpysi').show();
                        $('#eacmsgpysi').html(e.msg + "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>");
                        $('#btneditAccion').hide();
                        cargaPermisos();
                        setTimeout(function() {
                            $('#eacmsgpysi').hide();
                        }, 3000);
                    }
                } else {
                    $(location).attr('href', e.destino);
                }
            }
        });
        return false;
    });
    $('#frmEliminarAccion').submit(function() {
        $('#eaceloading').show();
        $("#eacmsgpysi").hide();
        $("#eacmsgpyno").hide();
        $.ajax({
            url: $(this).attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frmEliminarAccion').serialize(),
            success: function(e) {
                $('#eaceloading').hide();
                if (e.logeo == true) {
                    if (e.status == false) {
                        $('#eacmsgpyno').show();
                        $('#eacmsgpyno').html(e.msg + "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>");
                    } else {

                        $('#eacmsgpysi').show();
                        $('#eacmsgpysi').html(e.msg + "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>");
                        $('#btneditAccion').hide();
                        cargaPermisos();
                        setTimeout(function() {
                            $('#eacmsgpysi').hide();
                        }, 3000);
                    }
                } else {
                    $(location).attr('href', e.destino);
                }
            }
        });
        return false;
    });
    $('#frmAgregarAccion').submit(function() {
        $('#eaceloading').show();
        $("#eacmsgpysi").hide();
        $("#eacmsgpyno").hide();
        $.ajax({
            url: $(this).attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frmAgregarAccion').serialize(),
            success: function(e) {
                $('#eaceloading').hide();
                if (e.logeo == true) {
                    if (e.status == false) {
                        $('#eacmsgpyno').show();
                        $('#eacmsgpyno').html("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" + e.msg);
                    } else {

                        $('#eacmsgpysi').show();
                        $('#eacmsgpysi').html("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" + e.msg);
                        $('#btnAgregarAccion').hide();
                        cargaPermisos();
                        setTimeout(function() {
                            $('#eacmsgpysi').hide();
                        }, 3000);
                    }
                } else {
                    $(location).attr('href', e.destino);
                }
            }
        });
        return false;
    });
    var defaultData = <?php echo json_encode($array);?>;
    var $checkableTree = $('#treeview-nodes').treeview({
        data: defaultData,
        showTags: true,
        selectable: true,
        showIcon: true,
        nodeIcon: 'far fa-folder-open',
        //showCheckbox: true,
        onNodeSelected: function(event, node) {
            $('#actxtitem').val(node.text);
            $('#actxtiditem').val(node.tags.id);
            $('#actxttipo').val(node.tags.tipo);
            $('#cbpadre').val(node.tags.idpadre);
            $('#btnEditarAcCom').prop('disabled', false);
            $('#btnElimarAcCom').prop('disabled', false);

        },
        onNodeUnselected: function(event, node) {
            $('#btnEditarAcCom').prop('disabled', true);
            $('#btnElimarAcCom').prop('disabled', true)
        }
    });
    $checkableTree.treeview('collapseAll', { silent: true });
    $('#modAcciones').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var modal = $(this);
        var view = button.data('view');
        $("#frmEditarAccion").hide();
        $("#frmAgregarAccion").hide();
        $("#frmEliminarAccion").hide();
        $('#eaceloading').hide();
        $("#eacmsgpysi").hide();
        $("#eacmsgpyno").hide();
        if (view == 'edita') {
            $("#frmEditarAccion").show();
            $('#btneditAccion').show();
            $('#modAccionesLabel').html("<b>Editar Ítem</b>");
        } else if (view == 'inserta') {
            $("#frmAgregarAccion").show();
            $('#btnAgregarAccion').show();
            $('#modAccionesLabel').html("<b>Crear Ítem</b>");
            $('#ictxttipo').val("");
            $('#ictxtiditem').val("");
            $('#ictxtitem').val("");
            var sl = $('#treeview-nodes').treeview('getSelected', "");

            $.each(sl, function(index, val) {
                var pd = (val.tags.tipo == "C") ? val.tags.id : val.tags.idpadre;
                $('#icbpadre').val(pd);
            });
        } else if (view == 'elimina') {
            $("#frmEliminarAccion").show();
            $('#btndeletAccion').show();
            $('#modAccionesLabel').html("<b>Crear Ítem</b>");
            var sl = $('#treeview-nodes').treeview('getSelected', "");
            $.each(sl, function(index, node) {
                if (node.tags.tipo == "C") {
                    $('#btndeletAccion').show();
                    $('#dctxtiditem').val(node.tags.id);
                    $('#dctxtitem').val(node.text);
                    $('#dctxtidpadre').val(node.tags.idpadre);
                } else {
                    $('#btndeletAccion').hide();
                    $('#dctxtiditem').val("-1");
                    $('#dctxtitem').val(node.text);
                    $('#dctxtidpadre').val("-1");
                    $('#eacmsgpysi').show();
                    $('#eacmsgpysi').html("No se Puede Elimar una ACCIÓN " + "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>");

                }
            });


        }
    })
  //$('#tree').treeview('collapseAll', { silent: true });
  </script>
</section>
<?php
}
else{
$this->load->view('errors/sin-permisos');
}
?>