<?php $vbaseurl = base_url()?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>MESA DE PARTES
          <small></small></h1>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div id="divcard-general" class="card">
      <div class="card-body">
        <form id="frm-add-mesa" action="<?php echo $vbaseurl ?>mesa_partes/fn_insert" method="post" accept-charset="utf-8">
          <div class="row">
            <label class="col-md-2 col-form-label-sm ">Trámite:</label>
            <span class="form-control form-control-sm col-md-5"><?php echo $solicitud->tramite ?></span>
          </div>
          <div class="row">
            <label class=" col-md-2 col-form-label-sm">Asunto de la solicitud:</label>
            <div class="col-md-10 border rounded"><?php echo $solicitud->asunto ?></div>
          </div>
          <section class="border mx-n2 mt-3 p-3">
            <h4 class="form-title">Datos del Solicitante</h4>
            <div class="row">
              <label class="col-md-2 col-form-label-sm">Solicitante:
              </label>
              <span class="form-control form-control-sm col-md-10">
                <?php echo "$solicitud->tipodoc - $solicitud->nrodoc" ?>
              </span>
              <label class="col-md-2 col-form-label-sm">
              </label>
              <span class="form-control form-control-sm col-md-10">
                <?php echo $solicitud->solicitante ?>
              </span>
            </div>
            
            
            <div class="form-group">
              <label class="col-form-label-sm ">Contenido</label>
              <div class=" col-md-12 border rounded py-2" style="min-height: 120px">
                <?php echo "$solicitud->contenido" ?>
              </div>
            </div>
            <div class="row">
              <label class="col-md-2 col-form-label-sm">Domicilio:</label>
              <span class="form-control form-control-sm col-md-10">
                <?php echo $solicitud->domicilio ?>
              </span>
            </div>
            <div class="row">
              <label class="col-md-2 col-form-label-sm">Correo Electrónico:</label>
              <span class="form-control form-control-sm col-md-5">
                <?php echo $solicitud->email_personal ?>
              </span>
              <span class="col-12 col-md-5">Autorizo que las respuestas se remitan a esta dirección de correo (en caso no tenga una Cuenta en la Plataforma Virtual)</span>
            </div>
            <div class="row">
              <label class="col-md-2 col-form-label-sm">Telefono/ Celular:</label>
              <span class="form-control form-control-sm col-md-5">
                <?php echo $solicitud->telefono ?>
              </span>
            </div>
          </section>
          <section class="border mx-n2 p-3">
            <h4 class="form-title">Archivos adjuntados</h4>
            <?php
            foreach ($adjuntos as $key => $ad) {
            echo 
            "<div class='row border-bottom'>
              
              <span class='form-control-sm col-md-5'>
                <i class='fas fa-paperclip mr-1'></i> $ad->titulo
              </span>
              <span class='col-md-2 col-form-label-sm'>".getIcono("P",$ad->archivo)." Descargar</span>
            </div>";
            }
            ?>
            
          </section>
          <section class="border mx-n2 p-3">
            <div class="row mt-3">
              <div class="col-12">
                <?php 
                echo 
                "<a type='button' href='{$vbaseurl}gestion/tramites/mesa-de-partes' class='btn btn-outline-danger btn-md float-left' ><i class='fas fa-undo'></i> Volver</a>
                <button type='submit' class='btn btn-primary btn-md float-right'>
                  <img class='mr-1' src='".base_url()."resources/img/icons/p_pdf.png' alt='PDF'> Descargar
                </button>";

                 ?>
                
               
              </div>
            </div>
          </section>
        </form>
        <div id="divcard_msg" class="d-flex justify-content-center">
        </div>
      </div>
    </div>
  </section>
</div>