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
    alt="IESTWEB"
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
        <?php $nombres=explode(" ",$vuser->nombres); ?>
        <small><a href="<?php echo $vbaseurl ?>cuentas/mi-perfil" class="d-block"><?php echo $nombres[0]." ".$vuser->paterno; ?><br><?php echo $vuser->usuario ?></a></small>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
      with font-awesome or any other icon font library -->
      
      
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>ayuda/tutoriales" class="nav-link <?php echo ($menu_padre=='docvideoayuda') ? 'active' : '' ?>">
          <i class="nav-icon far fa-question-circle"></i>
          <p>
            Manuales
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>biblioteca/buscar-libros" class="nav-link <?php echo ($menu_padre=='biblioteca-b') ? 'active' : '' ?>">
          <i class="nav-icon fas fa-university"></i>
          <p>
            Biblioteca
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>alumno/mis-cursos-panel" class="nav-link <?php echo ($menu_padre=='miscursospanel') ? 'active' : '' ?>">
          <i class="nav-icon fas fa-book-open"></i>
          <p>
            Mis Unid. Didácticas
          </p>
        </a>
      </li>
      

      <li class="nav-header text-bold">ACADÉMICO</li>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>alumno/historial/matriculas" class="nav-link <?php echo ($menu_padre=='ltmatriculas') ? 'active' : '' ?>">
          <i class="nav-icon fas fa-file-alt"></i>
          <p>
            Matrículas
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>alumno/historial/boleta-de-notas" class="nav-link <?php echo ($menu_padre=='docmiscursos') ? 'active' : '' ?>">
          <i class="nav-icon fas fa-file-medical-alt"></i>
          <p>
            Notas y Asistencias
            
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>alumno/historial/notas" class="nav-link <?php echo ($menu_padre=='mn_acad_boleta') ? 'active' : '' ?>">
          <i class="nav-icon fas fa-file-alt"></i>
          <p>
            Boleta de Notas
          </p>
        </a>
      </li>

      <li class="nav-header text-bold">ECONÓMICO</li>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>alumno/historial/deudas" class="nav-link <?php echo ($menu_padre=='mn_deudas') ? 'active' : '' ?>">
          <i class="nav-icon fas fa-file-alt"></i>
          <p>
            Mis Deudas
            <span class="right badge badge-danger">Nuevo</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>alumno/historial/pagos" class="nav-link <?php echo ($menu_padre=='mn_pagos') ? 'active' : '' ?>">
          <i class="nav-icon fas fa-file-alt"></i>
          <p>
            Mis Pagos
            
          </p>
        </a>
      </li>
      
      <!--<li class="nav-item">
        <a href="<?php //echo $vbaseurl ?>alumno/encuestas" class="nav-link <?php //echo ($menu_padre=='enc-alumno') ? 'active' : '' ?>">
          <i class="nav-icon fas fa-file-medical-alt"></i>
          <p>
            Encuestas
            <?php
            //echo ($vuser->encuestas>0)?"<i class='fas fa-bell text-danger ml-2 flash'></i>":"";
            ?>
          </p>
        </a>
      </li>-->
      
     
      
      <!--TRAMITES-->
      <li class="nav-item has-treeview <?php echo ($menu_padre=='mn_tramites') ? 'menu-open' : '' ?>">
        <a href="#" class="nav-link <?php echo ($menu_padre=='mn_tramites') ? 'active' : '' ?>">
          <i class="fas fa-user-clock nav-icon"></i></i>
          <p>
            Trámites
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          
          <li class="nav-item pl-2">
            <a href="<?php echo $vbaseurl ?>tramites/mesa-de-partes" class="nav-link <?php echo ($menu_hijo=='mn_mesa') ? 'active' : '' ?>">
              <i class="fas fa-list-ul nav-icon"></i>
              <p>Mesa de partes</p>
            </a>
          </li>
          
          
          <li class="nav-item pl-2">
            <a href="<?php echo $vbaseurl ?>tramites/incidencias" class="nav-link <?php echo ($menu_hijo=='mn_denuncia') ? 'active' : '' ?>">
              <i class="fas fa-list-ul nav-icon"></i>
              <p>Denuncias</p>
            </a>
          </li>
        </ul>
      </li>
      
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>contacto/sugerencia" class="nav-link <?php echo ($menu_padre=='sendsugerencia') ? 'active' : '' ?>">
          <i class="nav-icon far fa-paper-plane"></i>
          <p>
            Enviar Sugerencia
          </p>
        </a>
      </li>
    </ul>
  </nav>
</div>
</aside>