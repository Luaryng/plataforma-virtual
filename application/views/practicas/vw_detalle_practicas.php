<?php $vbaseurl=base_url() ?>
<style type="text/css">
    .space_normal {
        white-space: normal!important;
    }
</style>
<div class="content-wrapper">

    <div class="modal fade" id="modaddpractica" tabindex="-1" role="dialog" aria-labelledby="modaddpractica" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="titlepractica">Prácticas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addpractica" action="<?php echo $vbaseurl ?>practicas/fn_insert_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="0">
                            <input type="hidden" id="fictxtcodetapa" name="fictxtcodetapa" value="">
                            <input type="hidden" id="fictxtcodinscrip" name="fictxtcodinscrip" value="<?php echo $idinscp ?>">
                            <div class="col-12 text-bold text-primary border-bottom mb-3 mt-2">
                                Modalidad y Lugar
                            </div>
                            <div class="form-group has-float-label col-md-4">
                                <select name="fictxtmodalidadet" id="fictxtmodalidadet" class="form-control form-control-sm">
                                    <option value="">Seleccione item</option>
                                    <?php
                                        foreach ($modalidades as $key => $value) {
                                            echo "<option value='$value->codigo' data-mod='$value->nombre'>$value->nombre</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtmodalidadet">Modalidad</label>
                            </div>
                             <div class="form-group has-float-label col-md-8">
                                <select name="fictxtempresa" id="fictxtempresa" class="form-control form-control-sm">
                                    <option value="">(NINGUNA)</option>
                                    <?php
                                        foreach ($empresas as $key => $value) {
                                            echo "<option value='$value->codigo'>$value->nombre</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtempresa">Empresa</label>
                            </div>
                            <div class="form-group has-float-label col-12" id="divcard_proyeto">
                                <textarea name="fictxtproyecto" id="fictxtproyecto" placeholder="Nombre proyecto" class="form-control form-control-sm" autocomplete="off" rows="2"></textarea>
                                <label for="fictxtproyecto">Nombre proyecto</label>
                            </div>
                            <div class="col-12 text-bold text-primary border-bottom mb-3 mt-2">
                                Duración (Inició, Culminó y cantidad de horas)
                            </div>
                            <div class="form-group has-float-label col-md-4">
                                <input type="date" name="fictxtfecinicia" id="fictxtfecinicia" value="" placeholder="Fecha" class="form-control form-control-sm">
                                <label for="fictxtfecinicia">Fecha inicia</label>
                            </div>
                            <div class="form-group has-float-label col-md-4">
                                <input type="date" name="fictxtfecfinal" id="fictxtfecfinal" value="" placeholder="Fecha" class="form-control form-control-sm">
                                <label for="fictxtfecfinal">Fecha finaliza</label>
                            </div>
                           
                            <div class="form-group has-float-label col-md-3">
                                <input type="number" name="fictxthoras" id="fictxthoras" value="" placeholder="Horas" class="form-control form-control-sm">
                                <label for="fictxthoras">Horas</label>
                            </div>
                            <div class="col-12 text-bold text-primary border-bottom mb-3 mt-2">
                                Semestre y Asesores
                            </div>
                            <div class="form-group has-float-label col-md-3">
                                <select name="fictxtciclo" id="fictxtciclo" class="form-control form-control-sm">
                                    <option value="">Seleccione item</option>
                                    <?php
                                        foreach ($ciclos as $key => $value) {
                                            echo "<option value='$value->codigo'>$value->nombre</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtciclo">Semestre</label>
                            </div>

                            <div class="form-group has-float-label col-md-5">
                                <select name="fictxtdocente" id="fictxtdocente" class="form-control form-control-sm">
                                    <option value="">Seleccione item</option>
                                    <?php
                                        foreach ($docentes as $key => $value) {
                                            echo "<option value='$value->coddocente'>$value->nombres</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtdocente">Docente Guía</label>
                            </div>
                            <div class="form-group has-float-label col-md-4">
                                <select name="fictxtasesor" id="fictxtasesor" class="form-control form-control-sm">
                                    <option value="">Seleccione item</option>
                                    <?php
                                        foreach ($docentes as $key => $value) {
                                            echo "<option value='$value->coddocente'>$value->nombres</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtasesor">Asesor</label>
                            </div>
                           
                           
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalinformes" tabindex="-1" role="dialog" aria-labelledby="modalinformes" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="divmodaladdins">
                <div class="modal-header">
                    <h5 class="modal-title" id="titlepractinsc">AGREGAR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addfolder_informe" action="<?php echo $vbaseurl ?>practicas/fn_update_folder_informe" method="post" accept-charset="utf-8">
                        <input type="hidden" id="fictxtcodetapaf" name="fictxtcodetapaf" value="">
                        <input type="hidden" id="fictxtcodinscripf" name="fictxtcodinscripf" value="<?php echo $idinscp ?>">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#presfolder" data-toggle="tab">
                                    <i class="fas fa-file-alt"></i> Presentación folder
                                </a>
                            </li>
                            <li id="tabli-aperturafile" class="nav-item">
                                <a class="nav-link" href="#presinforme" data-toggle="tab">
                                    <i class="fas fa-file-alt"></i> Presentación Informe
                                </a>
                            </li>
                            <li id="tabli-aperturafile" class="nav-item">
                                <a class="nav-link" href="#evaluacion" data-toggle="tab">
                                    <i class="fas fa-file"></i> Evaluación
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane pt-3" id="presfolder">
                                <div class="row">
                                    <div class="form-group has-float-label col-md-12">
                                        <input type="date" name="fictxtfecfolder" id="fictxtfecfolder" value="" placeholder="Fecha" class="form-control form-control-sm">
                                        <label for="fictxtfecfolder">Fecha Entrega Folder</label>
                                    </div>
                                    <div class="form-group has-float-label col-12">
                                        <textarea name="fictxtobsfolder" id="fictxtobsfolder" placeholder="Observación Folder" class="form-control form-control-sm" autocomplete="off" rows="2"></textarea>
                                        <label for="fictxtobsfolder">Observación Folder</label>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane pt-3" id="presinforme">
                                <div class="row">
                                    <div class="form-group has-float-label col-md-12">
                                        <input type="date" name="fictxtfecinfor" id="fictxtfecinfor" value="" placeholder="Fecha" class="form-control form-control-sm">
                                        <label for="fictxtfecinfor">Fecha Entrega Informe</label>
                                    </div>
                                    <div class="form-group has-float-label col-12">
                                        <textarea name="fictxtobsinform" id="fictxtobsinform" placeholder="Observación Informe" class="form-control form-control-sm" autocomplete="off" rows="2"></textarea>
                                        <label for="fictxtobsinform">Observación Informe</label>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane pt-3" id="evaluacion">
                                <div class="row">
                                    <div class="form-group has-float-label col-md-8">
                                        <input type="date" name="fictxtfeceval" id="fictxtfeceval" value="" placeholder="Fecha" class="form-control form-control-sm">
                                        <label for="fictxtfeceval">Fecha Evaluación</label>
                                    </div>
                                    <div class="form-group has-float-label col-md-4">
                                        <input type="number" name="fictxtfecevalnota" id="fictxtfecevalnota" value="" placeholder="Nota" class="form-control form-control-sm">
                                        <label for="fictxtfecevalnota">Nota</label>
                                    </div>
                                    <div class="form-group has-float-label col-12">
                                        <textarea name="fictxtobseval" id="fictxtobseval" placeholder="Observación" class="form-control form-control-sm" autocomplete="off" rows="2"></textarea>
                                        <label for="fictxtobseval">Observación</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="lbtn_guardar_inform" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>Detalle Prácticas</h1>
        		</div>
      		</div>
    	</div>
  	</section>
  	<section id="s-cargado" class="content">
  		<div id="divcard_detalle" class="card">
  			<div class="card-header">
  				<h3 class="card-title"><b><?php echo $inscrito->carne." - ".$inscrito->paterno." ".$inscrito->materno." ".$inscrito->nombres ?></b></h3><br>
                <small><?php echo "(".$inscrito->idplan.")"." - ".$inscrito->plan ?></small>
  			</div>
  			<div class="card-body">
                 <?php if (count($etapas) == 0): ?>
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text space_normal">
                                Es necesario que registre las etapas en cada plan de estudios y habilitarlas
                            </span>
                            <span class="info-box-number"><a href="<?php echo $vbaseurl ?>academico/practicas/etapas-plan?sb=academico" class=" ml-2 text-primary">Registrar o ver lista</a></span>
                        </div>
                    </div>
                
                
                <?php endif ?>
  				<?php 
                $acumuladas = 0;
                $restantes = 0;
                $estadopr = "";
                $fechaculmina = "";
                foreach ($etapas as $key => $value) { 
                    $horas = number_format($value->horas, 0);
                    $codigo64 = base64url_encode($value->codigo);
                    $btnscolor = "btn-warning";
                    $acumuladas=0;
                    $restantes = 0;
                echo "<div class='border border-dark p-2 mt-2'>";
                    foreach ($practicas as $key => $pr) {
                        if ($value->codigo == $pr->praetcod) {
                            $hacumuladas = $pr->horasacu;
                            $acumuladas += $hacumuladas;
                            $restantes = $horas - $acumuladas;
                            $idins = base64url_encode($pr->isncod);
                            $idetap = base64url_encode($pr->praetcod);
                            $cd1="EN PROCESO";
                            $cd2="CULMINADO";
                            $estadopr = $pr->estadop;
                            switch($estadopr) {
                                case "CULMINADO":
                                    $btnscolor="btn-success";
                                    break;
                                case "EN PROCESO":
                                    $btnscolor="btn-warning";
                                    break;
                                default:
                                    $btnscolor="btn-warning";
                            }

                            $titlep = $value->nombre.' Horas: '.$horas.' / Acumuladas: '.$acumuladas.' / Restantes: '.$restantes;

                        }
                        
                    } 

                    foreach ($etains as $key => $ins) {
                        if ($value->codigo == $ins->codpraet) {
                            $estadoins = $ins->estado;
                            $codetapai = base64url_encode($ins->codpraet);
                            if ($ins->culminado != null) {
                                $datecul =  new DateTime($ins->culminado) ;
                                $fecculmina = $datecul->format('d/m/Y');
                            } else {
                                $fecculmina = "";
                            }
                        } else {
                            $estadoins = "";
                        }
                    }
                    
                ?>
  					
  				
                    <div class='row'>
                        <div class='col-12 col-md-6'>
                            <h6 class='border-bottom p-2 font-weight-bold'>
                                <?php 
                                    if (isset($idetap) && $codigo64 == $idetap) {
                                        echo $titlep;
                                        
                                    } 
                                    else {
                                        echo $value->nombre.' Horas: '.$horas.' / Acumuladas: 0 / Restantes: '.$horas;
                                    }
                                
                                ?>
                                
                            </h6>
                        </div>
                        <div class='col-12 col-md-6 cfilaetapa' data-inscrito="<?php echo $idinscp ?>" data-etapaid="<?php echo $codigo64 ?>">
                            <div class='row'>
                                <div class='col-4 text-center'>
                                    <?php
                                    if (count($practicas) > 0) {
                                        if ($codigo64 == $idetap) {
                                            echo "<div class='btn-group'>
                                                <button class='btn $btnscolor btn-sm dropdown-toggle py-0' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> 
                                                    $estadopr
                                                </button>
                                                <div class='dropdown-menu'>
                                                    <a href='#' class='btn-cestado dropdown-item' data-color='btn-warning' data-ie='$cd1' data-insc='$idins' data-idetapa='$idetap'>EN PROCESO</a> 
                                                    <a href='#' class='btn-cestado dropdown-item' data-color='btn-success' data-ie='$cd2' data-insc='$idins' data-idetapa='$idetap'>CULMINADO</a>
                                                </div>
                                            </div>";
                                        } else {
                                            echo "<span class='text-danger'>Sin Historial</span>";
                                        }
                                    } else {
                                        echo "<span class='text-danger'>Sin Historial</span>";
                                    }
                                    ?>
                                    
                                </div>
                                <div class='col-4'>
                                    <span class="divculmina">
                                        <?php
                                        if (count($practicas) > 0) {
                                            if ($codigo64 == $codetapai) {
                                                echo $fecculmina;
                                            }
                                        }
                                        ?>
                                    </span>
                                    
                                        
                                </div>
                                <div class='col-4'>
                                    <?php
                                    if (isset($idetap) && $codigo64 == $idetap) {
                                        echo "<a href='#' class='btn btn-info btn-sm btn_list_informes' data-toggle='modal' data-target='#modalinformes'>
                                                <i class='fas fa-list'></i> Más datos
                                            </a>";
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 py-1">
                        <div class="btable">
                            <div class="thead col-12  d-none d-md-block">
                                <div class="row">
                                    <div class='col-12 col-md-4'>
                                        <div class='row'>
                                            <div class='col-2 col-md-2 td'>N°</div>
                                            <div class='col-10 col-md-10 td'>EMPRESA / PROYECTO</div>
                                        </div>
                                    </div>
                                    <div class='col-12 col-md-4'>
                                        <div class='row'>
                                            <div class='col-6 col-md-4 td'>MODALIDAD</div>
                                            <div class='col-6 col-md-2 td'>SEMESTRE</div>
                                            <div class='col-6 col-md-6 td'>FECHAS</div>
                                        </div>
                                    </div>
                                    <div class='col-12 col-md-2 text-center td'>HORAS</div>
                                    <div class='col-12 col-md-2 text-center td'></div>
                                </div>
                                
                            </div>
                            <div class="tbody col-12" id="divcard_data">
                                <?php 
                                $nro = 0;
                                foreach ($practicas as $key => $prc) {  
                                    
                                    if ($value->codigo == $prc->praetcod) {
                                        $nro++;
                                        $horasp = number_format($prc->horasacu, 0);
                                        $dateini =  new DateTime($prc->inicia);
                                        $finicia = $dateini->format('d/m/Y');
                                        if ($prc->finaliza !=null) {
                                            $datefin =  new DateTime($prc->finaliza) ;
                                            $fculmina = $datefin->format('d/m/Y');
                                        } else {
                                            $fculmina = "";
                                        }

                                        if ($prc->ciclo != "") {
                                            $nciclo = $prc->ciclo." SEM.";
                                        } else {
                                            $nciclo = "";
                                        }
                                        $fechas=(($finicia==$fculmina) || (""==$fculmina))? $finicia : $finicia." al ".$fculmina;
                                        $vempresa=(($prc->empresa=="") || (is_null($prc->empresa))) ?$prc->proyecto : $prc->empresa."<br>".$prc->proyecto;
                                        $codpractica = base64url_encode($prc->codigo);
                                        $codinscrip = base64url_encode($prc->isncod);
                                        $codetapa = base64url_encode($prc->praetcod);
                                ?>

                                <div class='row rowcolor cfila' data-practica='<?php echo $codpractica ?>'>
                                    <div class='col-12 col-md-4'>
                                        <div class='row'>
                                            <div class='col-2 col-md-2 td'><?php echo $nro ?></div>
                                            <div class='col-10 col-md-10 td'><?php echo $vempresa ?></div>
                                        </div>
                                    </div>
                                    <div class='col-12 col-md-4'>
                                        <div class='row'>
                                            <div class='col-6 col-md-4 td'><?php echo $prc->nom_modalidad ?></div>
                                            <div class='col-6 col-md-2 td'><?php echo $nciclo ?></div>
                                            <div class='col-6 col-md-6 td'><?php echo $fechas ?></div>
                                        </div>
                                    </div>
                                    <div class='col-6 col-md-2 text-center td'><?php echo $horasp ?></div>
                                    <div class='col-6 col-md-2 text-center td'>
                                        <div class='btn-group'>
                                            <a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                <i class='fas fa-cog'></i>
                                            </a>
                                            <div class='dropdown-menu dropdown-menu-right acc_dropdown'>
                                                <a class='dropdown-item' href='#' title='Editar' onclick='fn_update_practicas($(this));return false;'>
                                                    <i class='fas fa-edit mr-1'></i> Editar
                                                </a>
                                                <a class='dropdown-item text-danger deletepractica' href='#' title='Eliminar' idpractica='<?php echo $codpractica ?>' data-insc="<?php echo $codinscrip ?>" data-idetapa="<?php echo $codetapa ?>">
                                                    <i class='fas fa-trash mr-1'></i> Eliminar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    }
                                } 
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-right mt-2">
                        <button class="btn btn-primary btn-sm btn_addpractica" data-etapa="<?php echo $codigo64 ?>" >
                            <i class="fas fa-plus"></i> Agregar
                        </button>
                    </div>
                </div>
        <?php } ?>
  			</div>
  		</div>
  	</section>
</div>

<script>

    $(document).ready(function() {
        $('#divcard_proyeto').hide();
    });

    $('#fictxtmodalidadet').change(function() {
        var item = $(this);
        var modalidad = item.find(':selected').data('mod');
        if (modalidad == "PROYECTO") {
            $('#divcard_proyeto').show();
        } else {
            $('#divcard_proyeto').hide();
            $('#fictxtproyecto').val('');
        }
    });

    $('.btn_addpractica').click(function() {
        var boton = $(this);
        var etapa = boton.data('etapa');
        $('#fictxtcodetapa').val(etapa);
        $('#modaddpractica').modal('show');
    });

    $('#lbtn_guardar').click(function() {
        $('#frm_addpractica input,select').removeClass('is-invalid');
        $('#frm_addpractica .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_addpractica').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_addpractica').serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modaddarea').modal('hide');
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    });
                    location.reload();
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodaladd #divoverlay').remove();
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

    $("#modaddpractica").on('hidden.bs.modal', function () {
        $('#frm_addpractica')[0].reset();
        $("#fictxtcodigo").val("0");
        $('#titlearea').html("AGREGAR");
    });

    function fn_update_practicas(boton) {
        var fila = boton.closest(".cfila");
        var codigo = fila.data('practica');
        $('#divcard_detalle').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "practicas/vwmostrar_practicasxcodigo",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo},
            success: function(e) {
                $('#divcard_detalle #divoverlay').remove();
                $("#fictxtcodigo").val(base64url_encode(e.vdata['codigo']));
                $("#fictxtcodetapa").val(base64url_encode(e.vdata['praetcod']));
                $('#fictxtciclo').val(e.vdata['idciclo']);
                $("#fictxtfecinicia").val(e.vdata['inicia']);
                $("#fictxtfecfinal").val(e.vdata['finaliza']);
                $("#fictxthoras").val(e.vdata['horasacu']);
                $("#fictxtmodalidadet").val(e.vdata['modalidad']);
                $("#fictxtdocente").val(e.vdata['docenteg']);
                $("#fictxtasesor").val(e.vdata['asesorg']);
                $("#fictxtproyecto").val(e.vdata['proyecto']);
                $("#fictxtempresa").val(e.vdata['codempresa']);
                $('#fictxtmodalidadet').change();
                //$('#titlepractica').html("EDITAR");

                $("#modaddpractica").modal("show");
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_detalle #divoverlay').remove();
                $("#modaddpractica modal-body").html(msgf);
            } 
        });
        return false;
    }

    $('.deletepractica').click(function() {
        var boton  = $(this);
        var codigo = boton.attr('idpractica');
        var inscrip = boton.data('insc');
        var etapa = boton.data('idetapa');
        Swal.fire({
            title: '¿Está seguro de eliminar este item?',
            text: "¡Si no lo está puede cancelar la acción!",
            type: 'warning',
            icon: 'warning',
            showCancelButton: true,
            allowOutsideClick: false,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar!'
        }).then(function(result){
            if(result.value){
                $('#divcard_detalle').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                $.ajax({
                    url: base_url + "practicas/fneliminar_practica",
                    method: "POST",
                    data: {
                        idpractica : codigo,
                        txtinsc : inscrip,
                        txtetapa : etapa,
                    },
                    success:function(e){
                        $('#divcard_detalle #divoverlay').remove();
                        if (e.status == true) {
                            Swal.fire({
                                type: "success",
                                icon: 'success',
                                title: "¡CORRECTO!",
                                text: e.msg,
                                showConfirmButton: true,
                                allowOutsideClick: false,
                                confirmButtonText: "Cerrar"
                            }).then(function(result){
                                if(result.value){
                                   location.reload();
                                }
                            })
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msgf = errorAjax(jqXHR, exception,'text');
                        $('#divcard_detalle #divoverlay').remove();
                        Swal.fire({
                            title: "Error",
                            text: e.msgf,
                            type: "error",
                            icon: "error",
                            allowOutsideClick: false,
                            confirmButtonText: "¡Cerrar!"
                        });
                    }
                })
            }
        });         
            
        return false;
    });

    $(".btn-cestado").click(function(event) {
        var fila = $(this).closest('.cfilaetapa');
        var ins = $(this).data('insc');
        var etapa = $(this).data('idetapa');
        var ie = $(this).data('ie');
        var color = $(this).data('color');

        var btdt = $(this).parents(".btn-group").find('.dropdown-toggle');
        var texto = $(this).html();
        var fechaculmina = null;
        var statuspr = false;

        if (ie == "CULMINADO") {
            
            Swal.fire({
                title: 'Ingrese Fecha culminado',
                html:'<input id="dateculmina" type="date" class="form-control" required>',
                icon: 'warning',
                showCancelButton: true,
                allowOutsideClick: false,
            }).then(function(result){
                if(result.value){
                    fechaculmina = $('#dateculmina').val();
                    if (fechaculmina !== "") {
                        $('#divcard_detalle').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                        $.ajax({
                            url: base_url + 'practicas/fn_cambiarestado',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                'ce-idins': ins,
                                'ce-nestado': ie,
                                'ce-etapa': etapa,
                                'ce-fechaculmina' : fechaculmina
                            },
                            success: function(e) {
                                $('#divcard_detalle #divoverlay').remove();
                                if (e.status == false) {
                                    Swal.fire({
                                        type: 'error',
                                        icon: 'error',
                                        title: 'Error!',
                                        text: e.msg,
                                        backdrop: false,
                                    })
                                } else {
                                    Swal.fire({
                                        type: 'success',
                                        title: 'Felicitaciones, estado actualizado',
                                        text: 'Se ha actualizado el estado',
                                        backdrop: false,
                                        icon: 'success',
                                    })

                                    btdt.removeClass('btn-success');
                                    btdt.removeClass('btn-warning');

                                    btdt.addClass(color);
                                    btdt.html(texto);

                                    fila.find('.divculmina').html(fechaculmina);
                                }
                            },
                            error: function(jqXHR, exception) {
                                var msgf = errorAjax(jqXHR, exception, 'text');
                                $('#divcard_detalle #divoverlay').remove();
                                Swal.fire({
                                    type: 'error',
                                    icon: 'error',
                                    title: 'Error',
                                    text: msgf,
                                    backdrop: false,
                                })
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Advertencia',
                            text:'Por favor complete el campo fecha culminado',
                            icon: 'warning',
                            showCancelButton: false,
                            allowOutsideClick: false,
                        })
                    }
                        
                }
            })
        } else {
            fechaculmina = null
            $('#divcard_detalle').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + 'practicas/fn_cambiarestado',
                type: 'post',
                dataType: 'json',
                data: {
                    'ce-idins': ins,
                    'ce-nestado': ie,
                    'ce-etapa': etapa,
                    'ce-fechaculmina' : fechaculmina
                },
                success: function(e) {
                    $('#divcard_detalle #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            type: 'error',
                            icon: 'error',
                            title: 'Error!',
                            text: e.msg,
                            backdrop: false,
                        })
                    } else {
                        Swal.fire({
                            type: 'success',
                            title: 'Felicitaciones, estado actualizado',
                            text: 'Se ha actualizado el estado',
                            backdrop: false,
                            icon: 'success',
                        })

                        btdt.removeClass('btn-success');
                        btdt.removeClass('btn-warning');

                        btdt.addClass(color);
                        btdt.html(texto);

                        fila.find('.divculmina').html("");
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divcard_detalle #divoverlay').remove();
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
        return false;
    });

    $('.btn_list_informes').click(function() {
        var boton = $(this);
        var fila = boton.closest('.cfilaetapa');
        var etapa = fila.data('etapaid');
        var inscrito = fila.data('inscrito');

        var fila = boton.closest(".cfila");
        var codigo = fila.data('practica');
        $('#divcard_detalle').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "practicas/fn_practicas_inscripcionxitem",
            type: 'post',
            dataType: "json",
            data: {
                txtcodigo: inscrito,
                txtetapa: etapa
            },
            success: function(e) {
                $('#divcard_detalle #divoverlay').remove();
                $("#fictxtcodetapaf").val(base64url_encode(e.vdata['codpraet']));

                $("#fictxtfecfolder").val(e.vdata['folder']);
                $("#fictxtobsfolder").val(e.vdata['obsfolder']);

                $("#fictxtfecinfor").val(e.vdata['informe']);
                $("#fictxtobsinform").val(e.vdata['observacion']);

                $("#fictxtfeceval").val(e.vdata['evaluacion']);
                $("#fictxtfecevalnota").val(e.vdata['nota']);
                $("#fictxtobseval").val(e.vdata['obsevaluacion']);

                $("#modalinformes").modal("show");
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_detalle #divoverlay').remove();
                $("#modalinformes modal-body").html(msgf);
            } 
        });
        return false;
    });

    $('#lbtn_guardar_inform').click(function() {
        $('#frm_addfolder_informe input,select').removeClass('is-invalid');
        $('#frm_addfolder_informe .invalid-feedback').remove();
        $('#divmodaladdins').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_addfolder_informe').attr("action"),
            type: "post",
            dataType: 'json',
            data: $('#frm_addfolder_informe').serialize(),
            success: function(e) {
                $('#divmodaladdins #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                        $('#' + key).focus();
                    });
                } else {
                    
                    Swal.fire({
                        type: 'success',
                        title: 'Felicitaciones, datos actualizados',
                        text: 'Se ha actualizado los datos',
                        backdrop: false,
                        icon: 'success',
                    })

                    $("#modalinformes").modal("hide");
                    
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divmodaladdins #divoverlay').remove();
                Swal.fire({
                    title: "Error",
                    text: msgf,
                    icon: 'error',
                })
            }
        });
        return false;
    });

</script>