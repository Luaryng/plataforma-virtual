<?php
	$vbaseurl=base_url();
?>

<div class="content-wrapper">

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

  	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>Pagantes
          			<small>Panel</small></h1>
        		</div>
        
      		</div>
    	</div>
  	</section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_pagante" class="card">
			<div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de pagantes</h3>
		    	<div class="no-padding card-tools">
                	<a type="button" class="btn btn-sm btn-outline-dark" href="#" data-toggle="modal" data-target="#modaddpagante"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
		    </div>
		    <div class="card-body">
                <form id="frmsearch_pagante" action="" method="post" accept-charset="utf-8">
                    <div class="row mt-2">
                        <div class="form-group has-float-label col-12 col-sm-8">
                            <input type="text" name="fictxtsearch" id="fictxtsearch" class="form-control" placeholder="Cliente">
                            <label for="fictxtsearch">Cliente</label>
                        </div>
                        <div class="col-sm-4">
                            <button class="btn btn-outline-info" type="submit" >
                            <i class="fas fa-search"></i>
                            Buscar
                            </button>
                            
                        </div>
                    </div>
                    
                </form>
		    	<div class="card-body pt-2 px-0 pb-0">
                    <div class="row">
                        <div class="col-12 py-1" id="divres-pagante">
                            
                        </div>
                    </div>
                </div>
		    </div>
		</div>
	</section>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 5000,
          timerProgressBar: true,
        })

        Toast.fire({
          type: 'info',
          icon: 'info',
          title: 'Aviso: Antes de agregar un cliente, verifica si no ha sido registrado anteriormente'
        })
        $("#fictxtsearch").focus();
    });
</script>

<script type="text/javascript" src="<?php echo base_url() ?>resources/dist/js/pages/pagante_21_07_16.js"></script>