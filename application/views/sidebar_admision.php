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
        <?php  $nombres=explode(" ",$vuser->nombres);  ?>
        <small>
        <a href="<?php echo $vbaseurl ?>cuentas/mi-perfil" class="d-block"><?php echo $nombres[0]." ".$vuser->paterno; ?><br><?php echo $vuser->usuario ?></a>
        </small>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php
        if (getPermitido("46")=='SI') { ?>
        <li class="nav-item ">
          <a href="<?php echo $vbaseurl ?>admision/ficha-personal?sb=admision" class="nav-link <?php echo ($menu_hijo=='ficha') ? 'active' : '' ?>">
            <i class="fas fa-list-ul nav-icon"></i>
            <p>Datos Personales</p>
          </a>
        </li>
        <?php } ?>
        <li class="nav-header pt-2 text-bold">ADMISIÓN</li>
        <?php if (getPermitido("95")=='SI') { ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>admision/pre-inscripcion?sb=admision" class="nav-link <?php echo ($menu_hijo=='preinscripcion') ? 'active' : '' ?>">
            <i class="fas fa-list-ul nav-icon"></i>
            <p>Pre-inscripciones</p>
          </a>
        </li>
        <?php
        if (getPermitido("45")=='SI') { ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>admision/inscripciones?sb=admision" class="nav-link <?php echo ($menu_hijo=='inscripcion') ? 'active' : '' ?>">
            <i class="fas fa-list-ul nav-icon"></i>
            <p>Inscripciones</p>
          </a>
        </li>
        <?php }
        if (getPermitido("112")=='SI') { ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>admision/reingresos?sb=admision" class="nav-link <?php echo ($menu_hijo=='reingreso') ? 'active' : '' ?>">
            <i class="fas fa-list-ul nav-icon"></i>
            <p>Reingresos</p>
          </a>
        </li>
        <?php }
        if (getPermitido("47")=='SI') { ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>administrador/acciones?sb=admision" class="nav-link <?php echo ($menu_hijo=='traslado') ? 'active' : '' ?>">
            <i class="fas fa-list-ul nav-icon"></i>
            <p>Traslado</p>
          </a>
        </li>
        <?php } ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>admision/inscripcion-reportes?sb=admision" class="nav-link <?php echo ($menu_hijo=='insreport') ? 'active' : '' ?>">
            <i class="fas fa-cog nav-icon"></i>
            <p>Reportes</p>
          </a>
        </li>
        <?php } ?>
        
        <?php 
        if (($vuser->tipo == 'AD') || ($vuser->tipo == 'DA')) {
        //if (getPermitido("68")=='SI') { ?>
        <li class="nav-header pt-2 text-bold">MESA DE PARTES</li>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>gestion/tramites/mesa-de-partes?sb=admision" class="nav-link <?php echo ($menu_padre=='mn_mesa') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-globe"></i>
            <p>
              Recepción
              <?php 
              if (isset($_SESSION['userNotificaMP'])) {
                echo "<span class='right badge badge-danger'>".$_SESSION['userNotificaMP']."</span>";
              }
              ?>
              
            </p>
          </a>
        </li>
        <?php 
        } ?>

        <li class="nav-header pt-2 text-bold">ACADÉMICO</li>
        <?php
        if (getPermitido("43")=='SI') { ?>
        <li class="nav-item ">
          <a href="<?php echo $vbaseurl ?>gestion/academico/matriculas?sb=admision" class="nav-link <?php echo ($menu_nieto=='alumnos') ? 'active' : '' ?>">
            <i class="fas fa-user-friends nav-icon"></i>
            <p>Matrículas</p>
          </a>
        </li>
        <?php }
        if (getPermitido("42")=='SI') { ?>
        <li class="nav-item ">
          <a href="<?php echo $vbaseurl ?>academico/grupos-matriculados?sb=admision" class="nav-link <?php echo ($menu_nieto=='grupos') ? 'active' : '' ?>">
            <i class="fas fa-users nav-icon"></i>
            <p>Grupos</p>
          </a>
        </li>

        <?php } ?>

        
      </ul>
    </nav>
  </div>
</aside>