    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $curso->unidad ?>
            <small> <?php echo $curso->codseccion.$curso->division; ?></small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

               <li class="breadcrumb-item"><a href="<?php echo $vbaseurl.'monitoreo/docente/'.base64url_encode($curso->coddocente).'/'.base64url_encode($curso->codperiodo).'/cursos'; ?>"><i class="fas fa-compass"></i> Panel de Monitoreo</a></li>
               <li class="breadcrumb-item"><a href="<?php echo $vbaseurl.'monitoreo/docente/curso/'.$codcarga64.'/'.$coddivision64.'/aula-virtual'; ?>"> Aula Virtual</a></li>
                <li class="breadcrumb-item active"><?php echo $item_aula ?></li>

            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section id="s-cargado" class="content">
    
        <div class="card card-primary card-outline">
    <div class="card-body">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="row">
                        <span class="col-4">Periodo:</span>
                        <span id="divperiodo" class="col-8"><b><?php echo $curso->periodo; ?></b></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-8">
                    <div class="row">
                        <span class="col-4 col-md-3">Programa:</span>
                        <span id="divcarrera" class="col-8 col-md-9"><b><?php echo $curso->carrera; ?></b></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="row">
                        <span class="col-4">Semestre:</span>
                        <span id="divciclo" class="col-8"><b><?php echo $curso->ciclo; ?></b></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="row">
                        <span class="col-4 col-md-6">Turno:</span>
                        <span id="divturno" class="col-8 col-md-6"><b><?php echo $curso->turno; ?></b></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="row">
                        <span class="col-4">Sección:</span>
                        <span id="divseccion" class="col-8"><b><?php echo $curso->codseccion.$curso->division; ?></b></span>
                    </div>
                </div>
                <div class="col-sm-10 col-md-8">
                    <div class="row">
                        <span class="col-4 col-sm-3 col-md-2">Docente:</span>
                        <span id="divdocente" class="col-8 col-sm-9 col-md-10"><b><?php echo "$curso->paterno $curso->materno $curso->nombres"; ?></b></span>
                    </div>
                </div>
                <!--<div class="col-md-4">
                    <div class="row">
                        <span class="col-4 col-md-3">Celular:</span>
                        <span id="divdocente" class="col-8 col-md-9"><b><?php echo "$curso->celular"; ?></b></span>
                    </div>
                </div>-->
                <div class="col-sm-10 col-md-8">
                    <div class="row">
                        <span class="col-4 col-sm-3 col-md-2">Correo:</span>
                        <span id="divdocente" class="col-8 col-sm-9 col-md-10"><b><?php echo "$curso->ecorporativo"; ?></b></span>
                    </div>
                </div>

            </div>
    </div>
</div>