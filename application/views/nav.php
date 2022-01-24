<!--<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed ">-->
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm">
    <?php $vbaseurl=base_url();
    $vuser=$_SESSION['userActivo'];$vuser->idsede;
    //$vnotificas=array();
    $vtotalnoti=0;
    if (isset($_SESSION['userNotificaTotal'])){
      $vtotalnoti=$_SESSION['userNotificaTotal'];
    }
    ?>
  
  <div class="wrapper">
    <div class="modal modal-danger fade" id="modal-danger">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <span aria-hidden="true">&times;</span>
            <h4 class="modal-title">¿Cerrar sesión en cuenta de Correo?</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <p>Estas por cerrar tu sesión en nuestro ERP</p>
            <p>¿Deseas cerrar la sesión de tu CORREO CORPORATIVO? ?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            <a href="<?php echo base_url()?>cerrar-sesion" class="btn btn-warning ">No, Solo ERP</a>
            <a class='btn btn btn-success ' href='<?php echo base_url()?>gmail-cerrar-sesion'>Si, tambien Correo</a>;
          </div>
        </div>
        
      </div>
      
    </div>
    <nav class="main-header navbar navbar-expand navbar-dark navbar-info">
      
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
         <li class="nav-item dropdown">
          <a data-nsedes='<?php echo $vuser->nsedes ?>' class="nav-link px-1" data-toggle="dropdown" href="#">
            <i class="far fa-building"></i>
           <?php echo $vuser->sede;
           if ($vuser->nsedes>1){
           ?>
            <span class="badge badge-danger navbar-badge"><?php echo $vuser->nsedes ?></span>
          <?php } ?>
          </a>
          <?php if ($vuser->nsedes>1){ ?>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
            <span class="dropdown-item dropdown-header"><?php echo $vuser->nsedes ?> sedes asignadas</span>
            <?php foreach ($vuser->sedes as $vsd) { 
            if ($vsd->idsede!=$vuser->idsede){?>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item btn-cambiarsede" data-idsede="<?php echo $vsd->idsede ?>" data-sede="<?php echo $vsd->nombre ?>">
              <i class="far fa-building mr-2"></i> <?php echo $vsd->nombre ?>
            </a>
            <?php }
            } ?>
          </div>
          <?php } ?>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <?php if (($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'AD')){ ?>
        
        <li class="nav-item dropdown user user-menu">
          <a class="nav-link dropdown-toogle" data-toggle="dropdown" href="#">
            <i class="fas fa-th"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="row m-0"> 
                <div class="col-4  p-2">
                  <a href="<?php echo "{$vbaseurl}" ?>"  data-toggle="tooltip" title="ERP" class="d-block border text-center py-2">
                    <i class="fas fa-globe-europe fa-3x"></i>
                  </a>
                </div>
                <?php if (getPermitido("34") == "SI") {?> 
                <div class="col-4  p-2">
                  <a href="<?php echo "{$vbaseurl}admision/ficha-personal?sb=admision"?>"  data-toggle="tooltip" title="Admisión" class="d-block border text-center py-2">
                    <i class="fas fa-user-graduate fa-3x"></i>
                  </a>
                </div>  
                <?php } ?>
                <?php if (getPermitido("36") == "SI") {?> 
                <div class="col-4  p-2">
                  <a href="<?php echo "{$vbaseurl}gestion/academico/matriculas?sb=academico" ?>"  data-toggle="tooltip" title="Académico" class="d-block border text-center py-2">
                    <i class="fas fa-university fa-3x"></i>
                  </a>
                </div>  
                <?php } ?>
                <?php if (getPermitido("114") == "SI") {?> 
                <div class="col-4  p-2">
                  <a href="<?php echo "{$vbaseurl}formacion-continua/cursos" ?>"  data-toggle="tooltip" title="Formación Continua" class="d-block border text-center py-2">
                    <i class="fas fa-graduation-cap fa-3x"></i>
                  </a>
                </div>  
                <?php } ?>
                <?php if (getPermitido("96") == "SI") {?>  
                <div class="col-4  p-2">
                  <a href='<?php echo "{$vbaseurl}tesoreria" ?>' data-toggle="tooltip" title="Tesorería" class="d-block border text-center py-2">
                    <i class="far fa-money-bill-alt fa-3x"></i>
                  </a>
                </div>   
                <?php } ?>
                <?php if (getPermitido("32") == "SI") {?>  
                <div class="col-4  p-2">
                  <a href='<?php echo "{$vbaseurl}mantenimiento" ?>' data-toggle="tooltip" title="Mantenimiento" class="d-block border text-center py-2">
                    <i class="fas fa-cogs fa-3x"></i>
                  </a>
                </div>   
                <?php } ?>
            </div>     
          </div>
        </li>
        <?php } ?> 


        <li class="nav-item">
         <a class="nav-link px-2" target="_blank" href="https://mail.google.com/a/<?php echo getDominio() ?>" >
            <i class="far fa-envelope text-bold"></i>
          </a>
        </li>

        <li class="nav-item">
         <a id="btncontrolbar" data-total="<?php echo $vtotalnoti ?>" data-sincro="SI" class="nav-link" href="#" >
            <i class="far fa-bell"></i>
            <?php if ($vtotalnoti>0): ?>
              <span class="badge badge-danger navbar-badge"><?php echo $vtotalnoti ?> </span>
            <?php endif ?>
          </a>
        </li>
        <li class="nav-item">
         <a class="nav-link px-2" href="<?php echo $vbaseurl."calendario" ?>" >
            <i class="fas fa-calendar-alt text-bold"></i>
          </a>
        </li>
        <li class="nav-item dropdown user user-menu">
          <a class="nav-link dropdown-toogle" data-toggle="dropdown" href="#">
            
            <img src="<?php echo $vbaseurl.'resources/fotos/'.$vuser->foto ?>" class="user-image" alt="User">
            <small><span class="d-none d-sm-inline-block">
            <?php
            $nombres=explode(" ",$vuser->nombres); 
            echo $nombres[0]." ".$vuser->paterno; 
            ?>
               
             </span></small>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header user-header">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo $vbaseurl.'resources/fotos/'.$vuser->foto ?>" alt="Usuario">
              <p>
                <?php
                echo $vuser->nombres." <br><small>".$vuser->paterno." ". $vuser->materno."</small>"
                ?>
              </p>
            </span>
            <div class="dropdown-divider"></div>
            <a href="<?php echo $vbaseurl.'cuentas/mi-perfil' ?>" class="dropdown-item">
             <i class="fas fa-user mr-1"></i> Mi Perfil
            </a>
            <div class="dropdown-divider"></div>
            <a target="_blank" href="https://mail.google.com/a/<?php echo getDominio() ?>" class="dropdown-item">
             <i class="far fa-envelope "></i> Mi Correo
            </a>
            

            
            <div class="dropdown-divider"></div>

            <?php
            
            if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
              echo '<a type="button" class="dropdown-item" data-toggle="modal" data-target="#modal-danger">
            <i class="fas fa-sign-out-alt mr-1"></i> Salir
            </a>';

            }
            else{
              //echo '<a href="'.$vbaseurl.'cuentas/cambiar-contrasenia" class="dropdown-item">Cambiar contraseña</a>';
              echo '<a href="'.$vbaseurl.'cerrar-sesion" class="dropdown-item"><i class="fas fa-sign-out-alt mr-1"></i> Salir</a>';
            }
            ?>


            
          </div>
        </li>
        
      </ul>
    </nav>
    <!-- /.navbar -->

