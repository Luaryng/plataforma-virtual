<?php
$vbaseurl=base_url();
date_default_timezone_set ('America/Lima');
$fecha = date('Y-m-d');
$hora = date('H:i');
?>
<style type="text/css">
.btn-circle {
width: 30px;
height: 30px;
padding: 6px 0px;
border-radius: 15px;
text-align: center;
font-size: 12px;
line-height: 1.42857;
}
.inputsb{
border-width:  0 0 1px 0;
padding-bottom: 0px !important;
}
</style>
<div class="content-wrapper">
    <!-- MODAL AGREGAR PAGANTE -->
    <div class="modal fade" id="modaddpagante" tabindex="-1" role="dialog" aria-labelledby="modaddpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">AGREGAR NUEVO REGISTRO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addpagante" action="<?php echo $vbaseurl ?>pagante/fn_insert_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-6 col-sm-4">
                                <select class="form-control form-control-sm" id="ficbtipodoc" name="ficbtipodoc" placeholder="Tipo Doc." >
                                    <option value="DNI">DNI</option>
                                    <option value="RUC">RUC</option>
                                    <option value="CEX">Carné de Extranjería</option>
                                    <option value="PSP">Pasaporte</option>
                                    <option value="PTP">Permiso Temporal de Permanencia</option>
                                </select>
                                <label for="ficbtipodoc"> Tipo Doc.</label>
                            </div>
                            <div class="form-group has-float-label col-6  col-sm-4">
                                <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtdni" name="fitxtdni" type="text" placeholder="N° documento"  minlength="8" />
                                <label for="fitxtdni"> N° documento</label>
                            </div>
                            <div class="col-12  col-sm-3">
                                <button id="fibtnsearch-dni" type="button" class="btn btn-primary btn-block btn-sm">
                                <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="0">
                                <input type="hidden" id="fictxtcodpagante" name="fictxtcodpagante">
                                <select name="fictipopag" id="fictipopag" class="form-control form-control-sm">
                                    <option value="CLIENTE">CLIENTE</option>
                                    <option value="ESTUDIANTE">ESTUDIANTE</option>
                                    <option value="LIBRE">LIBRE</option>
                                </select>
                                <label for="fictipopag">Tipo Pagante</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <select name="fictipopers" id="fictipopers" class="form-control form-control-sm">
                                    <option value="NATURAL">NATURAL</option>
                                    <option value="JURIDICA">JURIDICA</option>
                                </select>
                                <label for="fictipopers">Tipo Persona</label>
                            </div>
                            <div class="form-group has-float-label col-12">
                                <input type="text" name="fictxtnomrazon" id="fictxtnomrazon" placeholder="Nombres/Razon Social" class="form-control form-control-sm">
                                <label for="fictxtnomrazon">Nombres/Razon Social</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtemailper" id="fictxtemailper" placeholder="Correo Electrónico" class="form-control form-control-sm">
                                <label for="fictxtemailper">Correo Electrónico</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtemailper2" id="fictxtemailper2" placeholder="Otro Correo Electrónico" class="form-control form-control-sm">
                                <label for="fictxtemailper2">Otro Correo Electrónico</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtemailcorporat" id="fictxtemailcorporat" placeholder="Correo Corporativo" class="form-control form-control-sm">
                                <label for="fictxtemailcorporat">Correo Corporativo</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtdireccion" id="fictxtdireccion" placeholder="Dirección" class="form-control form-control-sm">
                                <label for="fictxtdireccion">Dirección</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group has-float-label col-12  col-sm-4">
                                <select onchange='fn_combo_ubigeo($(this));' data-currentvalue='' class="form-control form-control-sm" id="ficbdepartamento" name="ficbdepartamento" placeholder="Departamento" required data-tubigeo='departamento' data-cbprovincia='ficbprovincia' data-cbdistrito='ficbdistrito' data-dvcarga='divcard_data'>
                                    <option value="0">Selecciona Departamento</option>
                                    <?php foreach ($departamentos as $key => $depa) {?>
                                    <option value="<?php echo $depa->codigo ?>"><?php echo $depa->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="ficbdepartamento"> Departamento</label>
                            </div>
                            <div class="form-group has-float-label col-12  col-sm-4">
                                <select onchange='fn_combo_ubigeo($(this));' data-currentvalue='0' class="form-control form-control-sm" id="ficbprovincia" name="ficbprovincia" placeholder="Provincia" required data-tubigeo='provincia' data-cbdistrito='ficbdistrito' data-dvcarga='divcard_data'>
                                    <option value="0">Sin opciones</option>
                                </select>
                                <label for="ficbprovincia"> Provincia</label>
                            </div>
                            <div class="form-group has-float-label col-12  col-sm-4">
                                <select data-currentvalue='0'  class="form-control form-control-sm" id="ficbdistrito" name="ficbdistrito" placeholder="Distrito" required >
                                    <option value="0">Sin opciones</option>
                                </select>
                                <label for="ficbdistrito"> Distrito</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtelefono" id="fictxtelefono" placeholder="Teléfono" class="form-control form-control-sm">
                                <label for="fictxtelefono">Teléfono</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtcelular" id="fictxtcelular" placeholder="Celular" class="form-control form-control-sm">
                                <label for="fictxtcelular">Celular</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN MODAL AGREGAR PAGANTE -->
    <!-- BUSCAR MODAL PAGANTE -->
    <div class="modal fade" id="modsearchpagante" tabindex="-1" role="dialog" aria-labelledby="modsearchpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content" id="divmodalsearch">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_titles">BUSCAR PAGANTE </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_searchpag" action="" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-12 col-md-2">
                                <select name="vw_fcb_cbtipodocs" id="vw_fcb_cbtipodocs" class="form-control control form-control-sm text-sm">
                                    <?php
                                    foreach ($tipoidentidad as $key => $tpid) {
                                    echo "<option value='$tpid->codigo' data-lgt='$tpid->longitud'>$tpid->nombre</option>";
                                    }
                                    ?>
                                    
                                </select>
                                <label for="vw_fcb_cbtipodocs">Tipo Documento</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-3">
                                <input type="text" name="fictxtnrodoc" id="fictxtnrodoc" placeholder="N° Documento" class="form-control form-control-sm">
                                <label for="fictxtnrodoc">N° Documento</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-4">
                                <input type="text" name="fictxtnompagante" id="fictxtnompagante" placeholder="Pagante" class="form-control form-control-sm">
                                <label for="fictxtnompagante">Pagante</label>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-flat btn-info" type="submit" >
                                <i class="fas fa-search"></i>
                                Buscar
                                </button>
                                
                            </div>
                        </div>
                        
                    </form>
                    <div class="row">
                        <div class="col-12 py-1"  id="divcard_ltspagante">
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- FIN MODAL BUSCAR PAGANTE -->
    <!-- AGREGAR MODAL ITEM -->
    <div class="modal fade" id="modadditem" tabindex="-1" role="dialog" aria-labelledby="modadditem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodalitem">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_tititem">Agregar detalle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    
                    <div class="row pt-2">
                        <div class="form-group has-float-label col-12 col-md-5">
                            <select name="vw_fcb_ai_cbgestion" id="vw_fcb_ai_cbgestion" class="form-control control form-control-sm text-sm inputsb">
                                <option  value='0'>Seleccionar</option>
                                <?php
                                foreach ($gestion as $key => $gs) {
                                echo "<option data-unidad='$gs->codunidad' data-afectacion='$gs->codtipafecta' value='$gs->codigo' >$gs->gestion</option>";
                                }
                                ?>
                            </select>
                            <label for="vw_fcb_ai_cbgestion">Gestión</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-3">
                            <select name="vw_fcb_ai_cbunidad" id="vw_fcb_ai_cbunidad" class="form-control control form-control-sm text-sm inputsb">
                                <?php
                                foreach ($unidad as $key => $und) {
                                echo "<option  value='$und->codigo' >$und->nombre</option>";
                                }
                                ?>
                            </select>
                            <label for="vw_fcb_ai_cbunidad">Unidad</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-2">
                            <input type="text" name="vw_fcb_ai_txtcantidad" id="vw_fcb_ai_txtcantidad" placeholder="Cantidad" class="form-control form-control-sm inputsb">
                            <label for="vw_fcb_ai_txtcantidad">Cantidad</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-2">
                            <input type="text" name="vw_fcb_ai_txtpreciounitario" id="vw_fcb_ai_txtpreciounitario" placeholder="Monto" class="form-control form-control-sm inputsb">
                            <label for="vw_fcb_ai_txtpreciounitario">Monto</label>
                        </div>
                    </div>
                    <hr>
                    <div class="row pt-2">
                        <div class="form-group has-float-label col-12 col-md-5">
                            <select name="vw_fcb_ai_cbtipoitem" id="vw_fcb_ai_cbtipoitem" class="form-control control form-control-sm text-sm inputsb">
                                <option  value='SERVICIO'>Servicio</option>
                                <option  value='BIEN'>Bien</option>
                            </select>
                            <label for="vw_fcb_ai_cbtipoitem">Tipo</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-3">
                            <select name="vw_fcb_ai_cbafectaigv" id="vw_fcb_ai_cbafectaigv" class="form-control control form-control-sm text-sm inputsb">
                                <option  value='GRAVADO'>GRAVADO</option>
                                <option  value='EXONERADO'>EXONERADO</option>
                                <option  value='INAFECTO'>INAFECTO</option>
                            </select>
                            <label for="vw_fcb_ai_cbafectaigv">Afectación</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-3">
                            <select name="vw_fcb_ai_cbgratis" id="vw_fcb_ai_cbgratis" class="form-control control form-control-sm text-sm inputsb">
                                <option  value='NO'>NO</option>
                                <option  value='SI'>SI</option>
                                
                                
                            </select>
                            <label for="vw_fcb_ai_cbgratis">Operación Gratuita</label>
                        </div>
                        
                    </div>
                    <hr>
                    <!--ISC-->
                    <div class="row pt-2">
                        <div class="form-group has-float-label col-12 col-md-3">
                            <select name="vw_fcb_ai_cbisc" id="vw_fcb_ai_cbisc" class="form-control control form-control-sm text-sm inputsb">
                                <option  value=''>Seleccionar</option>
                                <?php
                                foreach ($iscs as $key => $isc) {
                                echo "<option  value='$isc->codigo' >$isc->nombre</option>";
                                }
                                ?>
                            </select>
                            <label for="vw_fcb_ai_cbisc">ISC</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-2">
                            <input type="text" name="vw_fcb_ai_txtiscvalor" id="vw_fcb_ai_txtiscvalor" placeholder="Impuesto" class="form-control form-control-sm inputsb">
                            <label for="vw_fcb_ai_txtiscvalor">Impuesto</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-3">
                            <select name="vw_fcb_ai_cbiscfactor" id="vw_fcb_ai_cbiscfactor" class="form-control control form-control-sm text-sm inputsb">
                                <option  value='1'>Soles</option>
                                <option  value='100'>%</option>
                                
                            </select>
                        </div>
                        <div id="vw_fcb_ai_diviscbase" class="form-group has-float-label col-12 col-md-2">
                            <input type="text" name="vw_fcb_ai_txtiscbase" id="vw_fcb_ai_txtiscbase" placeholder="Base Imponible" class="form-control form-control-sm inputsb">
                            <label for="vw_fcb_ai_txtiscbase">Base Imponible</label>
                        </div>
                    </div>
                    <hr>
                    <!--DESCUENTO-->
                    <div class="row pt-2">
                        <div class="form-group has-float-label col-12 col-md-2">
                            <input type="text" name="vw_fcb_ai_txtdsctvalor" id="vw_fcb_ai_txtdsctvalor" placeholder="Impuesto" class="form-control form-control-sm inputsb">
                            <label for="vw_fcb_ai_txtdsctvalor">Descuento</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-3">
                            <select name="vw_fcb_ai_cbdsctfactor" id="vw_fcb_ai_cbdsctfactor" class="form-control control form-control-sm text-sm inputsb">
                                <option  value='1'>Soles</option>
                                <option  value='100'>%</option>
                                
                            </select>
                        </div>
                        
                    </div>
                    <hr>
                    <!--AFECTACIÓN-->
                    <div class="row pt-2">
                        <div class="form-group has-float-label col-12 col-md-4">
                            <select name="vw_fcb_ai_cbafectacion" id="vw_fcb_ai_cbafectacion" class="form-control control form-control-sm text-sm inputsb">
                                
                                <?php
                                foreach ($afectacion as $key => $af) {
                                echo "<option  value='$af->codigo' >$af->nombre</option>";
                                }
                                ?>
                            </select>
                            <label for="vw_fcb_ai_cbafectacion">Tipo de Afectación</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-8">
                            <button id="vw_fcb_ai_btnagregar" type="button" class="btn btn-primary float-right">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN MODAL AGREGAR ITEM -->
    <!-- BUSCAR MODAL ITEM -->
    <div class="modal fade" id="modsearchitem" tabindex="-1" role="dialog" aria-labelledby="modsearchitem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodalitem">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_tititem">BUSCAR ITEM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_searchitem" action="" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-12 col-md-3">
                                <input type="text" name="fictxtcoditem" id="fictxtcoditem" placeholder="Código" class="form-control form-control-sm">
                                <label for="fictxtcoditem">Código</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtnomitem" id="fictxtnomitem" placeholder="Nombre" class="form-control form-control-sm">
                                <label for="fictxtnomitem">Nombre</label>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-flat btn-info" type="submit" >
                                <i class="fas fa-search"></i>
                                Buscar
                                </button>
                                
                            </div>
                        </div>
                        
                    </form>
                    <div class="row">
                        <div class="col-12 py-1"  id="divcard_ltsitems">
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- FIN MODAL BUSCAR ITEM -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>DOCUMENTOS
                    <small>Mantenimiento </small></h1>
                </div>
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>documentos/pagos">Documentos</a>
                        </li>
                        <li class="breadcrumb-item active">Mantenimiento</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section id="s-cargado" class="content">
        <div id="vw_pw_bt_ad_div_principal" class="card">
            <div class="card-body">
                <form id="vw_fcb_frmboleta" action="" method="post" accept-charset="utf-8">
                    <div class="row mt-2">
                        
                        <div class="input-group input-group-sm col-md-3">
                            <input type="hidden" name="vw_fcb_tipo" value="<?php echo $docserie->tipo ?>">
                            <input type="text" class="form-control" placeholder="Serie" name="vw_fcb_serie" id="vw_fcb_serie" value="<?php echo $docserie->serie ?>">
                            <input type="text" class="form-control" placeholder="N°" name="vw_fcb_sernumero" id="vw_fcb_sernumero" value="<?php echo $docserie->contador ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"><i class="fas fa-pencil-alt"></i></button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            
                        </div>
                        <div class="input-group input-group-sm col-md-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">Emisión: </span>
                            </div>
                            <input type="date" class="form-control" name="vw_fcb_emision" id="vw_fcb_emision" value="<?php echo $fecha ?>">
                            <input type="time" class="form-control" name="vw_fcb_emishora" id="vw_fcb_emishora" value="<?php echo $hora ?>">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-8">
                            
                        </div>
                        <div class="input-group input-group-sm col-md-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">Vencimiento: </span>
                            </div>
                            <input type="date" class="form-control" name="vw_fcb_vencimiento" id="vw_fcb_vencimiento">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group has-float-label col-12 col-md-2">
                            <select name="vw_fcb_cbtipo_operacion51" id="vw_fcb_cbtipo_operacion51" class="form-control control form-control-sm text-sm inputsb">
                                <?php
                                foreach ($tipoopera51 as $key => $tpop51) {
                                $opera51sel=($docserie->codoperacion51==$tpop51->codopera51)?"selected":"";
                                echo "<option $opera51sel value='$tpop51->codopera51' >$tpop51->nombre</option>";
                                }
                                ?>
                            </select>
                            <label for="vw_fcb_cbtipo_operacion51">Operación</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-3">
                            <input autocomplete="off"  name="vw_fcb_txtigvp" id="vw_fcb_txtigvp" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="IGV %" value="<?php echo $docserie->igvpr ?>">
                            <label for="vw_fcb_txtigvp">IGV %</label>
                        </div>
                    </div>
                    <div class="row mt-3">
                        
                        <div class="form-group has-float-label col-12 col-md-2">
                            <select name="vw_fcb_cbtipodoc" id="vw_fcb_cbtipodoc" class="form-control control form-control-sm text-sm inputsb">
                                <?php
                                foreach ($tipoidentidad as $key => $tpid) {
                                echo "<option value='$tpid->codigo' data-lgt='$tpid->longitud'>$tpid->nombre</option>";
                                }
                                ?>
                                
                            </select>
                            <label for="vw_fcb_cbtipodoc">Tipo doc.</label>
                        </div>
                        
                        <div class="form-group has-float-label col-12 col-md-3">
                            <input autocomplete="off"  name="vw_fcb_txtnrodoc" id="vw_fcb_txtnrodoc" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="N° Documento">
                            <label for="vw_fcb_txtnrodoc">N° Documento</label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" name="vw_fcb_codpagante" id="vw_fcb_codpagante">
                                <input name="vw_fcb_txtpagante" id="vw_fcb_txtpagante" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="Cliente">
                                
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="btn-group dropleft float-right">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-tie"></i> Cliente
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modaddpagante">
                                        <i class="fas fa-plus mr-1"></i> Agregar
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modsearchpagante">
                                        <i class="fas fa-search mr-1"></i> Buscar
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-12">
                            <input name="vw_fcb_txtdireccion" id="vw_fcb_txtdireccion" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="Dirección">
                            <label for="vw_fcb_txtdireccion">Dirección</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input name="vw_fcb_txtemail1" id="vw_fcb_txtemail1" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="Correo 1">
                            <label for="vw_fcb_txtemail1">Correo 1</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input name="vw_fcb_txtemail2" id="vw_fcb_txtemail2" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="Correo 2">
                            <label for="vw_fcb_txtemail2">Correo 2</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input name="vw_fcb_txtemail3" id="vw_fcb_txtemail3" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="Correo 3">
                            <label for="vw_fcb_txtemail3">Correo 3</label>
                        </div>
                    </div>
                    
                    <div class="row mt-3" id="divcard_detalle">
                        <div class="col-12">
                            <div class="card border border-secondary ">
                                <div class="card-header">
                                    Detalle
                                    <div class="no-padding card-tools">
                                        <a href="#" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#modsearchitem">
                                            <i class="fas fa-plus mr-1"></i>  item
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modadditem">
                                            <i class="fas fa-plus mr-1"></i>  item
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body pt-0" id="divdata_detalle">
                                    <div class="row text-bold">
                                        <span class="text-sm col-1">Item</span>
                                        <span class="text-sm col-1">Cód.</span>
                                        <span class="text-sm col-1">Cant.</span>
                                        <span class="text-sm col-1">Und.</span>
                                        <span class="text-sm col-4">Descripción</span>
                                        <span class="text-sm col-2">Valor</span>
                                    </div>
                                    
                                    
                                </div>
                                <div class="card-footer">
                                    <div class="row mb-2">
                                        <label for="vw_fcb_txtobservaciones">Mas Información</label>
                                        <textarea name="vw_fcb_txtobservaciones" id="vw_fcb_txtobservaciones" class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="row">

                                        <div class="text-sm col-6">
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" value="" id="vw_fcb_chk_dsct_global">
                                              <label class="form-check-label" for="vw_fcb_chk_dsct_global">
                                                Descuento Global
                                              </label>
                                            </div>
                                        </div>
                                        <div class="text-sm col-4"><span class="float-right">Operación Gravada</span></div>
                                        <div class="text-sm col-2">
                                            <input type="text" name="vw_fcb_txtoper_gravada" id="vw_fcb_txtoper_gravada" class="form-control form-control-sm text-sm" readonly="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="text-sm col-2 ">
                                            <input type="text" name="vw_fcb_txt_dsct_general" id="vw_fcb_txt_dsct_general" class="form-control form-control-sm text-sm div_dctoglobal" value="0.00">

                                        </div>
                                        <div class="form-group has-float-label col-12 col-md-2 ">
                                            <select name="vw_fcb_cbdsctglobalfactor" id="vw_fcb_cbdsctglobalfactor" class="form-control control form-control-sm text-sm div_dctoglobal">
                                                <option  value='1'>Soles</option>
                                                <option  value='100'>%</option>
                                                
                                            </select>
                                            <input type="text" name="vw_fcb_cbdsctglobalmontobase_final" id="vw_fcb_cbdsctglobalmontobase_final" placeholder="mb" >
                                            <input type="text" name="vw_fcb_cbdsctglobalfactor_final" id="vw_fcb_cbdsctglobalfactor_final" placeholder="factor" >
                                        </div>

                                        <div class="text-sm col-6"><span class="float-right">Operación Inafecta</span></div>
                                        <div class="text-sm col-2">
                                            <input type="text" name="vw_fcb_txtoper_inafecta" id="vw_fcb_txtoper_inafecta" class="form-control form-control-sm text-sm" readonly="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="text-sm col-10"><span class="float-right">Operación Exonerada</span></div>
                                        <div class="text-sm col-2">
                                            <input type="text" name="vw_fcb_txtoper_exonerada" id="vw_fcb_txtoper_exonerada" class="form-control form-control-sm text-sm" readonly="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="text-sm col-10"><span class="float-right">Operación Exportación</span></div>
                                        <div class="text-sm col-2">
                                            <input type="text" name="vw_fcb_txtoper_exportacion" id="vw_fcb_txtoper_exportacion" class="form-control form-control-sm text-sm" readonly="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="text-sm col-10"><span class="float-right">Descuentos Totales</span></div>
                                        <div class="text-sm col-2">
                                            <input type="text" name="vw_fcb_txtoper_desctotal" id="vw_fcb_txtoper_desctotal" class="form-control form-control-sm text-sm" readonly="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="text-sm col-10"><span class="float-right">Total de Op. Gratuitas</span></div>
                                        <div class="text-sm col-2">
                                            <input type="text" name="vw_fcb_txtoper_gratuitas" id="vw_fcb_txtoper_gratuitas" class="form-control form-control-sm text-sm" readonly="" value="0.00">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="text-sm col-10"><span class="float-right">Subtotal</span></div>
                                        <div class="text-sm col-2">
                                            <input type="text" name="vw_fcb_txtsubtotal" id="vw_fcb_txtsubtotal" class="form-control form-control-sm text-sm" readonly="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="text-sm col-10"><span class="float-right">ICBPER</span></div>
                                        <div class="text-sm col-2">
                                            <input type="text" name="vw_fcb_txticbpertotal" id="vw_fcb_txticbpertotal" class="form-control form-control-sm text-sm" readonly="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="text-sm col-10"><span class="float-right">ISC Total</span></div>
                                        <div class="text-sm col-2">
                                            <input type="text" name="vw_fcb_txtisctotal" id="vw_fcb_txtisctotal" class="form-control form-control-sm text-sm" readonly="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="text-sm col-10"><span class="float-right">IGV Total</span></div>
                                        <div class="text-sm col-2">
                                            <input type="text" name="vw_fcb_txtigvtotal" id="vw_fcb_txtigvtotal" class="form-control form-control-sm text-sm" readonly="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="text-sm col-10"><span class="float-right">TOTAL</span></div>
                                        <div class="text-sm col-2">
                                            <input type="text" name="vw_fcb_txttotal" id="vw_fcb_txttotal" class="form-control form-control-sm text-sm" readonly="" value="0.00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 py-2">
                            <div id="vw_pw_bt_ad_divmsgbolsa" class="text-danger">
                            </div>
                        </div>
                        <div class="col-12">
                            <a type="button" href="<?php echo $vbaseurl ?>tesoreria/facturacion/documentos-de-pago" class="btn btn-danger btn-md float-left" >
                                <i class="fas fa-undo"></i> Cancelar
                            </a>
                            <button id="vw_pw_bt_ad_btn_guardar" class="btn btn-primary btn-md float-right"><i class="fas fa-save"></i> Guardar</button>
                        </div>
                    </div>
                </form>
                <div id="divcard_resultfin"></div>
            </div>
        </div>
    </section>
</div>
<div id="vw_fcb_rowitem" class="row rowcolor">
    <div class="col-12 col-md-1">
        <select name="vw_fcb_ai_cbunidad"  class="form-control control form-control-sm text-sm">
            <?php
            foreach ($unidad as $key => $und) {
            echo "<option  value='$und->codigo' >$und->nombre</option>";
            }
            ?>
        </select>
    </div>
    <div class="col-12 col-md-1">
        <input type="text"  name="vw_fcb_ai_cbgestion" class="form-control form-control-sm text-sm">
    </div>
    <div class="col-12 col-md-5">
        <input type="text"  name="vw_fcb_ai_txtgestion" placeholder="Gestion" class="form-control form-control-sm text-sm">
    </div>
    <div class="col-12 col-md-1">
        <input type="text" name="vw_fcb_ai_txtcantidad"  placeholder="Cantidad" class="form-control form-control-sm text-sm">
    </div>
    <div class="col-12 col-md-1">
        <input type="text" name="vw_fcb_ai_txtvalorunitario"  placeholder="vu" class="form-control form-control-sm text-sm">
    </div>
    <div class="col-12 col-md-1">
        <input type="text" name="vw_fcb_ai_txtpreciounitario"  placeholder="pu" class="form-control form-control-sm text-sm">
    </div>
    <div class="col-12 col-md-1">
        <input type="text" name="vw_fcb_ai_txtprecioventa"  placeholder="pv" class="form-control form-control-sm text-sm">
    </div>
    
    <div class="row">
        <div class="col-12 col-md-3">
            <input type="text" name="vw_fcb_ai_cbisc"  >
        </div>
        <div class="col-12 col-md-2">
            <input type="text" name="vw_fcb_ai_txtiscvalor"  placeholder="Impuesto" >
        </div>
        <div class="col-12 col-md-3">
            <input type="text" name="vw_fcb_ai_cbiscfactor" >
            
        </div>
        <div  class="col-12 col-md-2">
            <input type="text" name="vw_fcb_ai_txtiscbase"  placeholder="Base Imponible" >
        </div>
        <div class="col-12 col-md-2">
            <input type="text" name="vw_fcb_ai_txtdsctvalor"  placeholder="Impuesto">
        </div>
        <div class="col-12 col-md-3" name="vw_fcb_ai_cbdsctfactor">
            <input type="text">
            
        </div>
        <div class="col-12 col-md-4">
            <input type="text"  name="vw_fcb_ai_cbafectacion">
        </div>
        <div class="col-12 col-md-4">
            <input type="text"  name="vw_fcb_ai_cbafectaigv">
        </div>
        
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url() ?>resources/dist/js/pages/pagante.js"></script>
<script type="text/javascript">
var itemsDocumento =  {};
var itemsNro = 0;
var ops_grav = 0;
var ops_inaf = 0;
var ops_exon = 0;
var ops_expo = 0;
var dsctos_globales = 0;
var dsctos_detalles = 0;
var ops_grat = 0;
var js_subtotal = 0;
var js_icbper = 0;
var js_isc = 0;
var js_igv = 0;
var pigv = 0;
//Math.round((data / 1.19 * 100 )) / 100
$(document).ready(function() {
    $('#vw_fcb_ai_diviscbase').hide();
    $(".div_dctoglobal").hide();
    pigv = <?php echo $docserie->igvpr ?>;
    pigv = Number(pigv) / 100;
});
//vw_fcb_chk_dsct_global
function mostrar_montos() {
    //OPERACION GRAVADA, INAFECTA Y EXONERADA

    //DESCUENTO GLOBAL
    if ($("#vw_fcb_chk_dsct_global").is(':checked')) {
        $(".div_dctoglobal").show();
        var jvdctofactor = $("#vw_fcb_cbdsctglobalfactor").val();
        var jvdctovalor = $("#vw_fcb_txt_dsct_general").val();
        jvdctofactor = Number(jvdctofactor);
        jvdctovalor = Number(jvdctovalor);
        //alert(jvdctofactor);
        if (jvdctofactor == "1") {
            dsctos_globales = jvdctovalor;
            $("#vw_fcb_cbdsctglobalmontobase_final").val(jvdctovalor);
        } else {
            //comprobar si la afectacion es a la base imponible
            //para este caso asumire que es no afecto a la base imponible
            jvdctofactor = Number(jvdctovalor) / 100;
            dsctos_globales = Math.round((ops_grav * jvdctofactor) * 100) / 100;
            $("#vw_fcb_cbdsctglobalmontobase_final").val(ops_grav);
        }
        $("#vw_fcb_cbdsctglobalfactor_final").val(jvdctofactor);
        $("#vw_fcb_txtoper_desctotal").val(dsctos_globales + dsctos_detalles);
        //js_subtotal=ops_grav + ops_exon + ops_inaf - dsctos_globales;
        $("#vw_fcb_txtsubtotal").val(js_subtotal);
        //ops_grav=ops_grav - dsctos_globales;

    } else {
        $(".div_dctoglobal").hide();

        //ops_grav=ops_grav + dsctos_globales;
        dsctos_globales = 0;
        $("#vw_fcb_txtoper_desctotal").val(dsctos_globales);
    }

    //SUBTOTAL
    js_subtotal = ops_grav + ops_exon + ops_inaf - dsctos_globales;
    //IGV
    js_igv = Math.round(((ops_grav - dsctos_globales - dsctos_detalles) * pigv * 100)) / 100

    $("#vw_fcb_txtoper_gravada").val(ops_grav);
    $("#vw_fcb_txtoper_inafecta").val(ops_inaf);
    $("#vw_fcb_txtoper_exonerada").val(ops_exon);
    $("#vw_fcb_txtoper_exportacion").val(ops_expo);
    $("#vw_fcb_txtoper_desctotal").val(dsctos_globales + dsctos_detalles);
    $("#vw_fcb_txtoper_gratuitas").val(ops_grat);
    $("#vw_fcb_txtsubtotal").val(js_subtotal);
    $("#vw_fcb_txticbpertotal").val(js_icbper);
    $("#vw_fcb_txtisctotal").val(js_isc);
    $("#vw_fcb_txtigvtotal").val(js_igv);
    $("#vw_fcb_txtsubtotal").val(js_subtotal);
    $("#vw_fcb_txttotal").val(js_subtotal + js_icbper + js_isc + js_igv);
}
$("#vw_fcb_chk_dsct_global,#vw_fcb_cbdsctglobalfactor").change(function(event) {
    mostrar_montos();
});
$("#vw_fcb_ai_btnagregar").click(function(event) {
    event.preventDefault();

    var itemd = {};
    $("#modadditem .modal-body input,select").each(function() {
        itemd[$(this).attr('id')] = $(this).val();
        
    });
 

    //llenar gestion
    itemd['vw_fcb_ai_txtgestion'] = $("#vw_fcb_ai_cbgestion option:selected").text();
   console.log(itemd)
    /*itemsDocumento.each(function(index, el) {
    });*/
    var pu = Number(itemd['vw_fcb_ai_txtpreciounitario']);
    if (itemd['vw_fcb_ai_cbafectaigv'] == "GRAVADO") {
        itemd['vw_fcb_ai_txtvalorunitario'] = Math.round((pu / (pigv + 1)) * 100) / 100;
        itemd['vw_fcb_ai_txtprecioventa'] = Number(itemd['vw_fcb_ai_txtcantidad']) * pu;
        ops_grav = ops_grav + (Number(itemd['vw_fcb_ai_txtvalorunitario']) * Number(itemd['vw_fcb_ai_txtcantidad']));
    } else if (itemd['vw_fcb_ai_cbafectaigv'] == "INAFECTO") {
        itemd['vw_fcb_ai_txtvalorunitario'] = pu;
        itemd['vw_fcb_ai_txtprecioventa'] = Number(itemd['vw_fcb_ai_txtcantidad']) * pu;
        ops_inaf = ops_inaf + (Number(itemd['vw_fcb_ai_txtvalorunitario']) * Number(itemd['vw_fcb_ai_txtcantidad']));
    } else if (itemd['vw_fcb_ai_cbafectaigv'] == "EXONERADO") {
        itemd['vw_fcb_ai_txtvalorunitario'] = pu;
        itemd['vw_fcb_ai_txtprecioventa'] = Number(itemd['vw_fcb_ai_txtcantidad']) * pu;
        ops_exon = ops_exon + (Number(itemd['vw_fcb_ai_txtvalorunitario']) * Number(itemd['vw_fcb_ai_txtcantidad']));
    }

    itemsDocumento[itemsNro]=itemd;
    console.log(itemsDocumento);
    itemsNro++;

    var row = $("#vw_fcb_rowitem").clone();
    row.find('input,select').each(function(index, el) {
        $(this).val(itemd[$(this).attr('name')]);
    });
    $('#divdata_detalle').append(row);
    $("#modadditem").modal("hide");
    mostrar_montos();
    //ops_exon = ops_exon + Number()
    //ops_expo = ops_expo + Number()
    //dsctos_globales = dsctos_globales + Number()
    //ops_grat = ops_grat + Number()
    //js_subtotal = js_subtotal + Number()
    //js_icbper = js_icbper + Number()
    //js_isc = js_isc + Number()
    //js_igv = js_igv + Number()
    /*$("#vw_fcb_txtoper_gravada").val(ops_grav);
    $("#vw_fcb_txtoper_inafecta").val(ops_inaf);
    $("#vw_fcb_txtoper_exonerada").val(ops_exon);
    $("#vw_fcb_txtoper_exportacion").val(ops_expo);
    $("#vw_fcb_txtoper_desctotal").val(dsctos_globales + dsctos_detalles);
    $("#vw_fcb_txtoper_gratuitas").val(ops_grat);
    $("#vw_fcb_txtsubtotal").val(js_subtotal);
    $("#vw_fcb_txticbpertotal").val(js_icbper);
    $("#vw_fcb_txtisctotal").val(js_isc);
    $("#vw_fcb_txtigvtotal").val(js_igv);
    $("#vw_fcb_txttotal").val(js_subtotal + js_icbper + js_isc + js_igv);*/
});
$("#vw_fcb_txt_dsct_general").blur(function(event) {
    mostrar_montos();
});
$('#vw_fcb_ai_cbgestion').change(function(event) {
    var jvunidad = $(this).find(':selected').data('unidad');
    var jvafecta = $(this).find(':selected').data('afectacion');
    $('#vw_fcb_ai_cbunidad').val(jvunidad);
    $('#vw_fcb_ai_cbafectacion').val(jvafecta);
    $('#vw_fcb_ai_txtcantidad').val("1");
    $('#vw_fcb_ai_txtpreciounitario').focus();
});
$('#vw_fcb_ai_cbisc').change(function(event) {
    //var jvunidad=$(this).find(':selected').data('unidad');
    var jvcod_isc = $(this).val();
    $('#vw_fcb_ai_diviscbase').hide();
    switch (jvcod_isc) {
        case "SAV":
            $("#vw_fcb_ai_cbiscfactor option").each(function(i) {
                $(this).show();
            });
            break;
        case "AMF":
            $("#vw_fcb_ai_cbiscfactor option").each(function(i) {
                if ($(this).val() == "1") {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $("#vw_fcb_ai_cbiscfactor").val("1");
            break;
        case "PVP":
            $('#vw_fcb_ai_diviscbase').show();
            $("#vw_fcb_ai_cbiscfactor option").each(function(i) {
                if ($(this).val() == "100") {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $("#vw_fcb_ai_cbiscfactor").val("100");
            break;
    }
    /*$('#vw_fcb_ai_cbunidad').val(jvunidad);
    $('#vw_fcb_ai_txtcantidad').val(1);
    $('#vw_fcb_ai_txtpreciounitario').focus();*/
});
$('#frm_searchpag').submit(function() {
        $('#frm_searchpag input,select').removeClass('is-invalid');
        $('#frm_searchpag .invalid-feedback').remove();
        $('#divmodalsearch').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'facturacion/get_search_lista',
            type: 'post',
            dataType: 'json',
            data: $('#frm_searchpag').serialize(),
            success: function(e) {
                $('#divmodalsearch #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    $("#divcard_ltspagante").html("");
                } else {
                    $("#divcard_ltspagante").html(e.vdata);
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divmodalsearch #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
    })
    /*<div class="row cfila">
        <span type="text" name="" id="fictxtnro" class="form-control form-control-sm text-sm col-1"><?php echo $nmro ?></span>
        <input type="text" name="fictxtcodigo<?php echo $nmro ?>" id="fictxtcodigo<?php echo $nmro ?>" class="form-control form-control-sm text-sm col-1" value="<?php echo $codigo ?>">
        <input type="text" name="fictxtcantidad<?php echo $nmro ?>" id="fictxtcantidad<?php echo $nmro ?>" class="form-control form-control-sm text-sm col-1" value="1">
        <input type="text" name="fictxtunidad<?php echo $nmro ?>" id="fictxtunidad<?php echo $nmro ?>" class="form-control form-control-sm text-sm col-1" value="<?php echo $unidad ?>">
        <input type="text" name="fictxtdescrip<?php echo $nmro ?>" id="fictxtdescrip<?php echo $nmro ?>" class="form-control form-control-sm text-sm col-4" value="<?php echo $detalle ?>">
        <input type="number" name="fictxtvalor<?php echo $nmro ?>" id="fictxtvalor<?php echo $nmro ?>" class="form-control form-control-sm text-sm col-2 importe" value="<?php echo $valor ?>">
        <span class="col-2">
            <button class="remove_detitem<?php echo $nmro ?> btn btn-outline-danger btn-circle" type="button" onclick="removeitem($(this));" disabled="">
            <i class="fas fa-minus"></i>
            </button>
            
        </span>
    </div>*/
$("#modsearchpagante").on('hidden.bs.modal', function() {
    $('#frm_searchpag')[0].reset();
    $('#divcard_ltspagante').html('');
});
/*$('#frm_searchitem').submit(function() {
    $('#frm_searchitem input,select').removeClass('is-invalid');
    $('#frm_searchitem .invalid-feedback').remove();
    $('#divmodalitem').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'facturacion/get_search_item',
        type: 'post',
        dataType: 'json',
        data: $('#frm_searchitem').serialize(),
        success: function(e) {
            $('#divmodalitem #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                $("#divcard_ltsitems").html("");
            } else {
                $("#divcard_ltsitems").html(e.vdata);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodalitem #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
})*/
$("#modsearchitem").on('hidden.bs.modal', function() {
    $('#frm_searchitem')[0].reset();
    $('#divcard_ltsitems').html('');
});
$(document).on("keyup", ".unidad", function() {
    var btn = $(this).parents('.cfila');
    if ($(this).val() == "") {
        btn.data('unidad', $(this).val(''));
    } else {
        btn.data('unidad', $(this).val());
    }
})
$(document).on("keyup", ".valor", function() {
    var btn = $(this).parents('.cfila');
    if ($(this).val() == "") {
        btn.data('valor', $(this).val(''));
    } else {
        btn.data('valor', $(this).val());
    }
})
var cnt = 0;
/*$(document).on("click", ".add_itemdeta", function(e) {
    e.preventDefault();
    var btn = $(this).parents('.cfila');
    var codigo = btn.data('codigo');
    var detalle = btn.data('detalle');
    var unidad = btn.data('unidad');
    var valor = btn.data('valor');
    cnt = cnt + 1;
    $('#divmodalitem').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'facturacion/vw_agregar_items',
        type: 'post',
        dataType: 'json',
        data: {
            txtcnt: cnt,
            txtcodigo: codigo,
            txtdescrip: detalle,
            txtunidad: unidad,
            txtvalor: valor
        },
        success: function(e) {
            $('#modsearchitem').modal('hide');
            if (e.status == true) {
                $('#divmodalitem #divoverlay').remove();
                $('#divdata_detalle').append(e.vdata);
                var suma = 0;
                $('.importe').each(function() {
                    if ($(this).val() == "") {
                        $(this).val(0);
                        suma += parseFloat($(this).val());
                    } else {
                        suma += parseFloat($(this).val());
                    }
                    $('#fictxtotal').val(suma);
                });
            } else {
                $('#divmodalitem #divoverlay').remove();
                var msgf = '<span class="text-danger"><i class="fa fa-ban"></i>' + e.msg + '</span>';
                $('#divdata_detalle').html(msgf);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception);
            $('#divmodalitem #divoverlay').remove();
            $('#divdata_detalle').html(msgf);
        },
    });
    return false;
})*/
$("#vw_pw_bt_ad_btn_guardar").click(function(event) {
    event.preventDefault();
    $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    //var form = $(this).parents("#divcard_detalle");
    //var check = checkCampos(form);
    //if(check) {
    var formData = new FormData($("#vw_fcb_frmboleta")[0]);
    formData.append('vw_fcb_items', JSON.stringify(itemsDocumento));
    $.ajax({
        url: base_url + 'facturacion/fn_guardar_boleta',
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(e) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            if (e.status == true) {
                Swal.fire(
                    'Exito!',
                    'Los datos fueron guardados correctamente.',
                    'success'
                );
                $('#vw_fcb_frmboleta').hide();
                //$('#divcard_resultfin').html(e.redirect);
                // window.location.href = e.redirect;
            } else {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire(
                    'Error!',
                    e.msg,
                    'error'
                )
            }
        },
        error: function(jqXHR, exception) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire(
                'Error!',
                msgf,
                'error'
            )
        }
    });
    /*} else {
    $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
    Swal.fire(
    'Error!',
    'No hay datos en el detalle o hay campos vacios',
    'error'
    )
    }*/
    return false;
});
$('#vw_fcb_cbtipodoc').change(function(event) {
    $('#vw_fcb_txtnrodoc').removeClass('is-invalid');
    $('#vw_fcb_txtnrodoc').parent().find('.invalid-feedback').remove();
    $('#vw_fcb_txtnrodoc').val("");
    $('#vw_fcb_txtnrodoc').focus();
});
$("#vw_fcb_txtnrodoc").blur(function(event) {
    $(this).removeClass('is-invalid');
    $(this).parent().find('.invalid-feedback').remove();
    var jvnrodoc = $('#vw_fcb_txtnrodoc').val();
    var jvtipodoc = $('#vw_fcb_cbtipodoc').val();
    var jvlongitud = $('#vw_fcb_cbtipodoc').find(':selected').data('lgt');
    if (jvlongitud == 0) {} else {
        if (jvlongitud == jvnrodoc.length) {
            /*if (jvtipodoc=="RUC"){
            }*/
            $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $('input:text,select').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $.ajax({
                url: base_url + 'pagante/fn_get_pagantes',
                type: 'POST',
                data: {
                    vw_fcb_txtnrodoc: jvnrodoc,
                    vw_fcb_cbtipodoc: jvtipodoc
                },
                dataType: 'json',
                success: function(e) {
                    $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                    if (e.status == true) {
                        $('#vw_fcb_txtpagante').val(e.vdata.razonsocial);
                        $('#vw_fcb_txtdireccion').val(e.vdata.direccion + " - " + e.vdata.distrito + " - " + e.vdata.provincia + " - " + e.vdata.departamento);
                        $('#vw_fcb_txtemail1').val(e.vdata.correo1);
                        $('#vw_fcb_txtemail2').val(e.vdata.correo2);
                        $('#vw_fcb_txtemail3').val(e.vdata.correo_corp);
                        $('#vw_fcb_codpagante').val(e.vdata.codpagante);
                    } else {
                        $.each(e.errors, function(key, val) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                        });
                        Swal.fire(
                            'Error!',
                            e.msg,
                            'error'
                        )
                    }
                },
                error: function(jqXHR, exception) {
                    $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire(
                        'Error!',
                        msgf,
                        'error'
                    )
                }
            })
        } else {
            $(this).addClass('is-invalid');
            $(this).parent().append("<div class='invalid-feedback'> El n° de tener como mínimo " + jvlongitud + " dígitos</div>");
        }
    }
    return false;
});
$("#divdata_detalle input").keyup(function() {
    var form = $(this).parents("#divdata_detalle");
    var check = checkCampos(form);
    if (check) {
        $(".add_detitem").attr('disabled', false);
    } else {
        $(".add_detitem").attr('disabled', true);
    }
});
// var cnt = 1;
// $('.add_detitem').click(function(){
//     cnt = cnt + 1;
//     $('#divdata_detalle').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
//     $.ajax({
//         url: base_url + 'facturacion/vw_agregar_items',
//         type: 'post',
//         dataType: 'json',
//         data: {txtcnt: cnt},
//         success: function(e) {
//             if (e.status == true) {
//                 $('#divdata_detalle #divoverlay').remove();
//                 $('#divdata_detalle').append(e.vdata);
//                 $(".add_detitem").attr('disabled', true);
//             } else {
//                 $('#divdata_detalle #divoverlay').remove();
//                 var msgf = '<span class="text-danger"><i class="fa fa-ban"></i>'+ e.msg +'</span>';
//                 $('#divdata_detalle').html(msgf);
//             }
//         },
//         error: function(jqXHR, exception) {
//             var msgf = errorAjax(jqXHR, exception);
//             $('#divdata_detalle #divoverlay').remove();
//             $('#divdata_detalle').html(msgf);
//         },
//     });
//     return false;
// });
$(document).on("keyup", ".importe", function() {
    var suma = 0;
    $('.importe').each(function() {
        if ($(this).val() == "") {
            $(this).val(0);
            suma += parseFloat($(this).val());
        } else {
            suma += parseFloat($(this).val());
        }
        $('#fictxtotal').val(suma);
    });
})

function removeitem(boton) {
    var div = boton.parents('.cfila');
    div.remove();
    cnt = cnt - 1;
    if (cnt == 1) {
        $(".add_detitem").attr('disabled', false);
    }
}
//Función para comprobar los campos de texto
function checkCampos(obj) {
    var camposRellenados = true;
    obj.find("input").each(function() {
        var $this = $(this);
        if ($this.val().length <= 0) {
            camposRellenados = false;
            return false;
        }
    });
    if (camposRellenados == false) {
        return false;
    } else {
        return true;
    }
}
</script>