<?php $vbaseurl=base_url() ?>
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
                <h3 class="card-title text-bold">Indicadores</h3>
            </div>
            <div class="card-body">
                <ul class="todo-list" data-widget="todo-list">
                    <?php 
                    $nindicadores=0;
                    foreach ($indicadores as $key => $indi) {
                        $nindicadores++;
                        $bcolor=($indi->abierto=='SI') ? "badge-info" : "badge-danger";
                    ?>
                    <li data-id="<?php echo $indi->codigo ?>">
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                            <span class="text-primary text-bold ml-1">Indicador <span class="norden"><?php echo $indi->norden ?></span></span>
                        </span>

                        <span class="text"><?php echo $indi->nombre ?></span>
                        <small class="badge <?php echo $bcolor ?>"><i class="far fa-clock"></i> Abierto</small>
                        <div class="tools">
                            <i class='btn-eliminar fas fa-trash'></i>
                            <?php echo ($indi->abierto=='NO') ? "":"<i class='btn-editar fas fa-edit'></i>" ?>
                        </div>
                    </li>

                    <?php } 
                    for ($i=$nindicadores + 1; $i <=12 ; $i++) { 
                    ?>
                    <li class='unsortable' data-id="<?php echo ($i * -1) ?>">
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                            <span class="text-primary text-bold ml-1">Indicador <span class="norden"><?php echo $i ?></span></span>
                        </span>

                        <span class="text">--------------</span>
                        <small class="badge badge-warning"><i class="far fa-clock"></i> Sin declarar</small>
                        <div class="tools">
                            <i class='btn-editar fas fa-edit'></i>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
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
</script>