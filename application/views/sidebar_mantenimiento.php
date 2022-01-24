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
        if ((getPermitido("32") == "SI")) {?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>mantenimiento/institucion" class="nav-link <?php echo ($menu_padre=='mn_facturaerp') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-money-check-alt"></i>
            <p>
              Institución y filiales
            </p>
          </a>
        </li>
        <?php } 
       
        if ((getPermitido("155") == "SI")) {?>
        <li class="nav-item has-treeview <?php echo ($menu_padre=='eventos') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_padre=='eventos') ? 'active' : '' ?>">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Eventos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item pl-2">
              <a href="<?php echo base_url() ?>capacitaciones/lista?sb=mantenimiento" class="nav-link <?php echo ($menu_hijo=='capacitacion') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-user-tie"></i> <p>Capacitaciones</p>
              </a>
            </li>
            <li class="nav-item pl-2">
              <a href="<?php echo base_url() ?>#" class="nav-link <?php echo ($menu_hijo=='archivos') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-file-alt"></i> <p>Archivos</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item pl-2">
          <a href="<?php echo $vbaseurl ?>mantenimiento/discapacidad" class="nav-link <?php echo ($menu_hijo=='discapacidad') ? 'active' : '' ?>">
            <i class="fas fa-list nav-icon"></i>
            <p>Discapacidad</p>
          </a>
        </li>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>periodo/nuevo_periodo" class="nav-link <?php echo ($menu_hijo=='periodo') ? 'active' : '' ?>">
                <i class="fas fa-globe nav-icon"></i>
                <p>Periodo</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>mantenimiento/carreras" class="nav-link <?php echo ($menu_hijo=='carrera') ? 'active' : '' ?>">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Carreras</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>mantenimiento/sedes" class="nav-link <?php echo ($menu_hijo=='sede') ? 'active' : '' ?>">
                <i class="fas fa-cogs nav-icon"></i>
                <p>Sedes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>mantenimiento/carreras-sedes" class="nav-link <?php echo ($menu_hijo=='carrsed') ? 'active' : '' ?>">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Carreras por sedes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>admision/campanias" class="nav-link <?php echo ($menu_hijo=='campania') ? 'active' : '' ?>">
                <i class="fas fa-graduation-cap nav-icon"></i>
                <p>Campaña</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>ubigeo/nuevo_ubigeo" class="nav-link <?php echo ($menu_hijo=='ubigeo') ? 'active' : '' ?>">
                <i class="fas fa-globe nav-icon"></i>
                <p>Ubigeo</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>modalidad/nueva_modalidad" class="nav-link <?php echo ($menu_hijo=='modalidad') ? 'active' : '' ?>">
                <i class="fas fa-globe nav-icon"></i>
                <p>Modalidad</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>nivel/nuevo_nivel" class="nav-link <?php echo ($menu_hijo=='niveles') ? 'active' : '' ?>">
                <i class="fas fa-globe nav-icon"></i>
                <p>Niveles</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>mantenimiento/tramites/tipos" class="nav-link <?php echo ($menu_hijo=='tipostramit') ? 'active' : '' ?>">
                <i class="fas fa-cog nav-icon"></i>
                <p>Trámites tipos</p>
              </a>
            </li>
        <?php } ?>

        
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