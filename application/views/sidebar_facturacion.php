<!-- Main Sidebar Container -->
<?php
$vuser=$_SESSION['userActivo'];
$vbaseurl=base_url();
if (!isset($menu_padre)) $menu_padre="";
if (!isset($menu_hijo))  $menu_hijo="";
if (!isset($menu_nieto))  $menu_nieto="";
?>
<aside class="main-sidebar elevation-4 sidebar-dark-olive">
  <!-- Brand Logo -->
  <a href="<?php echo $vbaseurl ?>" class="brand-link navbar-info">
    <img src="<?php echo $vbaseurl.'resources/img/logo_h80.'.getDominio().'.png' ?>"
    alt="ERP"
    class="brand-image img-circle elevation-3"
    style="opacity: .8">
    <span class="brand-text font-weight-light"><b>ERP</b></span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo $vbaseurl ?>resources/fotos/<?php echo $vuser->foto ?>" class="img-circle elevation-2" alt="User">
      </div>
      <div class="info">
        <?php $nombres=explode(" ",$vuser->nombres);  ?>
        <small>
          <a href="<?php echo $vbaseurl ?>cuentas/mi-perfil" class="d-block"><?php echo $nombres[0]." ".$vuser->paterno;  ?><br><?php echo $vuser->usuario ?></a>
        </small>
      </div>
    </div>

    <nav class="mt-2">      
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <?php 
        if (((getPermitido("97") == "SI")) && (($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'AD'))) {?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/facturacion/documentos-de-pago?sb=facturacion" class="nav-link <?php echo ($menu_padre=='mn_facturaerp') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-money-check-alt"></i>
            <p>
              Documentos de Pago
              
            </p>
          </a>
        </li>
        <?php } ?>

        <?php 
        if (getPermitido("97") == "SI") {?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/facturacion/pagante" class="nav-link <?php echo ($menu_padre=='mn_pagante') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
              Clientes
            </p>
          </a>
        </li>
        <?php } ?>
          <?php 
        if (getPermitido("126") == "SI") {?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/matriculas/bloqueos" class="nav-link <?php echo ($menu_padre=='mn_ts_matriculas') ? 'active' : '' ?>">
            <i class="fas fa-user-friends nav-icon"></i>
            <p>Bloqueos</p>
          </a>
        </li>
        <?php } ?>

        
        
        <!--DEUDAS-->
        <?php if (getPermitido("105")=='SI') { ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/deudas" class="nav-link <?php echo ($menu_padre=='mn_deudas') ? 'active' : '' ?>">
            <i class="fas fa-user-friends nav-icon"></i>
            <p>Deudas</p>
          </a>
        </li>
        <li class="nav-item has-treeview <?php echo ($menu_padre=='mn_deudas') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_padre=='mn_deudas') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-graduation-cap"></i>
            <p>
              Deudas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php if (getPermitido("107")=='SI') { ?>
                <li class="nav-item pl-2">
                  <a href="<?php echo $vbaseurl ?>tesoreria/deudas/individual" class="nav-link <?php echo ($menu_hijo=='mh_dd_individual') ? 'active' : '' ?>">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Individual</p>
                  </a>
                </li>

            <?php }  ?>
            <?php if (getPermitido("108")=='SI') { ?>
                <li class="nav-item pl-2">
                  <a href="<?php echo $vbaseurl ?>tesoreria/deudas/grupo" class="nav-link <?php echo ($menu_hijo=='mh_dd_grupo') ? 'active' : '' ?>">
                    <i class="fas fa-user-friends nav-icon"></i>
                    <p>Grupo</p>
                  </a>
                </li>
            <?php } ?>
            <?php if (getPermitido("106")=='SI') { ?>
                <li class="nav-item pl-2">
                  <a href="<?php echo $vbaseurl ?>tesoreria/deudas/calendario" class="nav-link <?php echo ($menu_hijo=='mh_dd_calendario') ? 'active' : '' ?>">
                    <i class="far fa-calendar-alt nav-icon"></i>
                    <p>Cronograma</p>
                  </a>
                </li>
            <?php } ?>
            
          </ul>
        </li>
        <?php } ?>

        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/facturacion/sede" class="nav-link <?php echo ($menu_padre=='docsede') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-list-ol"></i>
            <p>
              Series
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/facturacion/gestion" class="nav-link <?php echo ($menu_padre=='gestion') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Conceptos
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/facturacion/reportes/sede" class="nav-link <?php echo ($menu_padre=='mn_ts_reportes') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Reportes
            </p>
          </a>
        </li>

        <?php if (getPermitido("34") == "SI") { ?>
        <li class="nav-header text-bold">ADMISIÓN</li>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>admision/inscripciones?sb=facturacion" class="nav-link <?php echo ($menu_padre=='admision') ? 'active' : '' ?>">
            <i class="fas fa-user-friends nav-icon"></i>
            <p>Inscripciones</p>
          </a>
        </li>
        <?php } ?>

        <?php if (getPermitido("36") == "SI") { ?>
        <li class="nav-header text-bold">ACADÉMICO</li>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>academico/grupos-matriculados?sb=facturacion" class="nav-link <?php echo ($menu_nieto=='grupos') ? 'active' : '' ?>">
            <i class="fas fa-user-friends nav-icon"></i>
            <p>Grupos</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>gestion/academico/matriculas?sb=facturacion" class="nav-link <?php echo ($menu_nieto=='alumnos') ? 'active' : '' ?>">
            <i class="fas fa-user-friends nav-icon"></i>
            <p>Matrículas</p>
          </a>
        </li>
        <?php } ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>ayuda/tutoriales" class="nav-link <?php echo ($menu_padre=='docvideoayuda') ? 'active' : '' ?>">
            <i class="nav-icon far fa-question-circle"></i>
            <p>
              Ayuda
            </p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>


