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
    <span class="brand-text font-weight-light"><b>IESTWEB</b></span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo $vbaseurl ?>resources/fotos/<?php echo $vuser->foto ?>" class="img-circle elevation-2" alt="User">
      </div>
      <div class="info">
        <small><a href="<?php echo $vbaseurl ?>cuentas/mi-perfil" class="d-block"><?php echo $vuser->nombres ?><br><?php echo $vuser->usuario ?></a></small>

      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
        
        
        <?php if ($vuser->tipo!=="AL"){ ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>ayuda/docentes/videos" class="nav-link <?php echo ($menu_padre=='docvideoayuda') ? 'active' : '' ?>">
            <i class="nav-icon far fa-question-circle"></i>
            <p>
              Ayuda
            </p>
          </a>
        </li>
        <?php } ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>biblioteca/buscar-libros" class="nav-link <?php echo ($menu_padre=='biblioteca-b') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-university"></i>
            <p>
              Biblioteca
            </p>
          </a>
        </li>

         <?php if ($vuser->codnivel!=="3"){ ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>docente/mis-cursos" class="nav-link <?php echo ($menu_padre=='docmiscursos') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-cubes"></i>
            <p>
              Mis Unidades didác.
            </p>
          </a>
        </li>
        <?php } ?>
        <!--<li class="nav-item">
          <a href="<?php echo $vbaseurl ?>gestion/panel" class="nav-link <?php echo ($menu_padre=='biblioteca-b') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-university"></i>
            <p>
              Panel de Control
            </p>
          </a>
        </li>-->

        <?php if ($vuser->codnivel=="3"){ ?>
         <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>alumno/aula-virtual" class="nav-link <?php echo ($menu_padre=='alaulavirtual') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-cubes"></i>
            <p>
              Aula virtual
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>alumno/mis-cursos" class="nav-link <?php echo ($menu_padre=='docmiscursos') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-file-medical-alt"></i>
            <p>
              Historial
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>alumno/encuestas" class="nav-link <?php echo ($menu_padre=='docmiscursos') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-file-medical-alt"></i>
            <p>
              Encuestas 
              <?php 
                echo ($vuser->encuestas>0)?"<i class='fas fa-bell text-danger ml-2 flash'></i>":"";
              ?>
            </p>
          </a>
        </li>
       
        <?php } ?>
       



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


