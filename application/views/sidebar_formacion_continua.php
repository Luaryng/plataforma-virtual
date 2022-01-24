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
        <small>
          <a href="<?php echo $vbaseurl ?>cuentas/mi-perfil" class="d-block"><?php echo $vuser->nombres ?><br><?php echo $vuser->usuario ?></a>
        </small>
      </div>
    </div>

    <nav class="mt-2">      
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        
        <?php 
        if (((getPermitido("97") == "SI")) && (($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'AD'))) {?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>formacion-continua/cursos" class="nav-link <?php echo ($menu_padre=='mn_cursos') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-money-check-alt"></i>
            <p>
              Cursos              
            </p>
          </a>
        </li>
        <?php } ?>

        <?php 
        if (getPermitido("94") == "SI") {?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>formacion-continua/cursos/inscripciones" class="nav-link <?php echo ($menu_padre=='mn_inscripciones') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
              Inscripciones
            </p>
          </a>
        </li>
        <?php } ?>
        
        <!--DEUDAS-->
        
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/facturacion/reportes/sede" class="nav-link <?php echo ($menu_padre=='mn_ts_reportes') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Reportes
            </p>
          </a>
        </li>

       
        
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


