<?php 
    $vbaseurl=base_url();
    
?>

<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.css">
<div class="content-wrapper">
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $curso->unidad ?>
            <small> <?php echo $curso->codseccion.$curso->division; ?></small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="<?php echo $vbaseurl ?>docente/mis-cursos"><i class="fas fa-compass"></i> Mis Unidades didácticas</a>
                </li>
                <li class="breadcrumb-item">
                    
                    <a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $curso->unidad ?>
                    </a>
                </li>
                
              <li class="breadcrumb-item active">Indicadores</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <?php include 'vw_curso_encabezado.php'; ?>
        
        <div class="card" id="divcard-indicadores">
            <div class="card-header">
                <h4 class="card-title text-bold">Indicadores</h4>
            </div>
            <div class="card-body">
                <div class="row">

                    <?php for ($i=1; $i < 4; $i++) { ?>
                    <div class="col-md-4 border rowcolor" id="divcard_sub">
                        <div class="row">
                            <div class="col-12 py-3">
                                <?php echo "<h4>Unidad 0$i</h4>"; ?>
                            </div>
                            <?php
                                $descripcion = "";
                                
                                foreach ($indicadores as $ind) {
                                    
                                    if ($i == $ind->norden) {
                                        $contador = 0;
                                        $codigo = $ind->codigo;
                                        foreach ($subindicadores as $sub) {
                                            if ($codigo == $sub->indicador) {
                                                $contador ++;
                                                $descripcion = $sub->descripción;
                                                echo '<div class="form-group has-float-label col-12">
                                                    <textarea data-indi="'.$codigo .'" data-sind="'.$sub->codigo.'" class="form-control form-control-sm" name="txt_sub_indicador" id="txt_sub_indicador"  rows="2" required>'. $descripcion .'</textarea>
                                                    <label for="txt_sub_indicador">Indicador</label>
                                                </div>';

                                            }
                                            
                                        }
                                        for($f=$contador; $f < 5; $f++) {
                                            echo '<div class="form-group has-float-label col-12">
                                                    <textarea data-indi="'.$codigo .'" data-sind="0" class="form-control form-control-sm" name="txt_sub_indicador" id="txt_sub_indicador"  rows="2"></textarea>
                                                    <label for="txt_sub_indicador">Indicador</label>
                                                </div>';
                                        }
                                    }
                                    
                                    
                                }

                            ?>
                            
                        </div>
                    </div>
                        
                    <?php 
                    }
                    
                ?>

                </div>
                <div class="row mt-3">
                    <div class="col-md-9" id="divmsgError"></div>
                    <div class="col-md-3">
                        <button type="button" id="btn_add_subitems" class="btn btn-primary btn-md btn-flat float-right">Guardar</button>
                    </div>
                </div>
            </div>
            
        </div>
        
    </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
var vccaj = '<?php echo $curso->codcarga ?>';
var vsscj = '<?php echo $curso->division ?>';
$(".todo-list").sortable({
    items: "li:not(.unsortable)",
    start: function(event, ui) {
        ui.item.startPos = ui.item.index();
    },
    stop: function(event, ui) {
        //console.log("Start position: " + ui.item.startPos);
        //console.log("New position: " + ui.item.index());

    },
    update: function(event, ui) {
        arrdata = [];
        $(".todo-list li").each(function(index, el) {
            $(this).find('.norden').html(index + 1);
            var codind = $(this).data("id");
            var norden = index + 1;
            //dataString = {fecha: fcha, accion: accn ,idmiembro: idacu};
            var myvals = [norden, codind];
            arrdata.push(myvals);
        });
        $('#divcard-indicadores').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'indicadores/f_ordenar',
            type: 'post',
            dataType: 'json',
            data: {
                vcca: vccaj,
                vssc: vsscj,
                filas: JSON.stringify(arrdata),
            },
            success: function(e) {
                $('#divcard-indicadores #divoverlay').remove();

            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire({
                    type: 'error',
                    title: 'ERROR, NO se guardó cambios',
                    text: msgf,
                    backdrop: false,
                });
            },
        });

    },
});
$(".todo-list").disableSelection();

$(".btn-editar").click(function(event) {
    /* Act on the event */
    var li=$(this).parent().parent('li');
    var codind = li.data("id");
    var vnorden=  li.find('.norden').html();
    var vnombre=  li.find('.text').html();
    if (codind<1) vnombre=  "";
    (async() => {
            const {
                value: vdocente
            } = await Swal.fire({
                title: 'Nombre de INDICADOR',
                input: 'textarea',
                inputPlaceholder: 'Ingresa el nombre del indicador',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Guardar!',
                inputValue: vnombre,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (($.trim(value)=='')) {
                            resolve('Para guardar, debes ingresar nombre');
                        } else {
                            $.ajax({
                                url: base_url + 'indicadores/fn_insert_update',
                                type: 'POST',
                                data: {
                                    vcca: vccaj,
                                    vssc: vsscj,
                                    nombre: value,
                                    codindicador: codind,
                                    norden: vnorden
                                },
                                dataType: 'json',
                                success: function(e) {
                                    //$('#divcard_grupo #divoverlay').remove();
                                    if (e.status == true) {
                                        li.data("id",e.newid);
                                        li.find('.text').html(value);
                                        li.find('small').remove();
                                        resolve();
                                    } else {
                                        resolve(e.msg);
                                    }
                                },
                                error: function(jqXHR, exception) {
                                    var msgf = errorAjax(jqXHR, exception, 'text');
                                    Swal.fire({
                                        type: 'error',
                                        title: 'ERROR, NO se guardó cambios',
                                        text: msgf,
                                        backdrop: false,
                                    });
                                }
                            })
                        }
                    })
                },
                allowOutsideClick: false
            })
        })()
});
$(".btn-eliminar").click(function(event) {
        var li=$(this).parent().parent('li');
        var codind = li.data("id");
        var vnorden=  li.find('.norden').html();
        var vnombre=  li.find('.text').html();
        Swal.fire({
          title: '¿Deseas eliminar el INDICADOR ?',
          text: "Al eliminar, las NOTAS registradas SERÁN eliminadas y no podrán recuperarse: " + vnombre,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
          if (result.value) {
                $.ajax({
                        url: base_url + 'indicadores/fn_delete',
                        type: 'POST',
                        data: {"codindicador": codind},
                        dataType: 'json',
                        success: function(e) {
                            if (e.status==true){
                                Swal.fire(
                                  'Eliminado!',
                                  'El Indicador fue eliminado correctamente.',
                                  'success'
                                )
                                location.reload();
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
                                  'success'
                                )
                        }
                    })
              
            
          }
        })
    });

    $('#btn_add_subitems').click(function(){
        $('#divcard-indicadores').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        arrdata = [];
        var vccaj = '<?php echo $curso->codcarga ?>';
        var vsscj = '<?php echo $curso->division ?>';
        $('#divcard_sub .row textarea').each(function() {
            var subind = $(this).data("sind");
            var codigo = $(this).data('indi');
            var descripcion = $(this).val();
            
            if (descripcion != "") {
                var myvals = [codigo, descripcion,vccaj,vsscj,subind];
                arrdata.push(myvals);
                
            }

        });
        $.ajax({
            url: base_url + 'curso/f_subir_subitems',
            type: 'post',
            dataType: 'json',
            data: {
                filas: JSON.stringify(arrdata),
            },
            success: function(e) {
                
                if (e.status == false) {
                    $('#divcard-indicadores #divoverlay').remove();
                    var msgf = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg + '</div>';
                    $('#divmsgError').html(msgf);
                } else {
                    
                    $('#divmsgError').html("<div class='text-success'><h4><i class='icon fa fa-check'></i> Éxito!</h4>"+e.msg+"</div>");
                    Swal.fire({
                        title: e.msg,
                        // text: "",
                        type: 'success',
                        icon:'success',
                        allowOutsideClick: false,
                    }).then((result) => {
                      if (result.value) {
                        location.reload();
                      }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception);
                $('#divcard-indicadores #divoverlay').remove();
                $('#divmsgError').html(msgf);
            },
        });
        return false;
    })
</script>