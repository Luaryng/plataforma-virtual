<div class="card">
    <div class="card-header with-border bg-light">
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <span class="col-4">Periodo:</span>
                        <span id="divperiodo" class="col-8"><b><?php echo $curso->periodo; ?></b></span>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <span class="col-4 col-md-3">Programa:</span>
                        <span id="divcarrera" class="col-8 col-md-9"><b><?php echo $curso->carrera; ?></b></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <span class="col-4">Semestre:</span>
                        <span id="divciclo" class="col-8"><b><?php echo $curso->ciclo; ?></b></span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <span class="col-4 col-md-6">Turno:</span>
                        <span id="divturno" class="col-8 col-md-6"><b><?php echo $curso->turno; ?></b></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <span class="col-4">Sección:</span>
                        <span id="divseccion" class="col-8"><b><?php echo $curso->codseccion.$curso->division; ?></b></span>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <span class="col-4 col-md-2">Docente:</span>
                        <span id="divdocente" class="col-8 col-md-10"><b><?php echo "$curso->paterno $curso->materno $curso->nombres"; ?></b></span>
                    </div>
                </div>
                <!--<div class="col-md-4">
                    <div class="row">
                        <span class="col-4 col-md-3">Celular:</span>
                        <span id="divdocente" class="col-8 col-md-9"><b><?php echo "$curso->celular"; ?></b></span>
                    </div>
                </div>-->
                <div class="col-md-8">
                    <div class="row">
                        <span class="col-4 col-md-2">Correo:</span>
                        <span id="divdocente" class="col-8 col-md-10"><b><?php echo "$curso->ecorporativo"; ?></b></span>
                    </div>
                </div>
                <?php if ($_SESSION['userActivo']->tipo=="AL") { ?>
                    
                <div class="col-md-8">
                    <div class="row">
                        <span class="col-4 col-md-2">Estudiante:</span>
                        <span id="divdocente" class="col-8 col-md-10"><b><?php echo $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ". $_SESSION['userActivo']->nombres; ?></b></span>
                    </div>
                </div>
                <?php } ?>
            </div>
    </div>
</div>