<!-- Main Sidebar Container -->
<?php
$vuser=$_SESSION['userActivo'];
$vbaseurl=base_url();
if (!isset($menu_padre)) $menu_padre="";
if (!isset($menu_hijo))  $menu_hijo="";
if (!isset($menu_nieto))  $menu_nieto="";
?>
<aside class="main-sidebar elevation-4 sidebar-dark-olive">
  <a href="<?php echo $vbaseurl ?>" class="brand-link navbar-info">
    <img src="<?php echo $vbaseurl.'resources/img/logo_h80.'.getDominio().'.png' ?>"
    alt="IESTWEB"
    class="brand-image img-circle elevation-3"
    style="opacity: .8">
    <span class="brand-text font-weight-light"><b>ERP</b></span>
  </a>
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo $vbaseurl ?>resources/fotos/<?php echo $vuser->foto ?>" class="img-circle elevation-2" alt="User">
      </div>
      <div class="info">
        <small><a href="<?php echo $vbaseurl ?>cuentas/mi-perfil" class="d-block"><?php echo $vuser->nombres ?><br><?php echo $vuser->usuario ?></a></small>
      </div>
    </div>
    <nav class="mt-2">      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>ayuda/portal-web" class="nav-link <?php echo ($menu_padre=='docvideoayuda') ? 'active' : '' ?>">
          <i class="nav-icon far fa-question-circle"></i>
          <p>
            Ayuda
          </p>
          
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>portal-web/banner" class="nav-link <?php echo ($menu_padre=='banner') ? 'active' : '' ?>">
          <i class="nav-icon fas fa-image"></i>
          <p>
            Banners
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>gestion-institucion" class="nav-link <?php echo ($menu_padre=='mision-vision') ? 'active' : '' ?>">
          <i class="nav-icon fas fa-cog"></i>
          <p>
            Nosotros
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>portal-web/programa-estudios" class="nav-link <?php echo ($menu_padre=='mn_programas') ? 'active' : '' ?>">
          <i class="nav-icon fas fa-cog"></i>
          <p>
            Programas
          </p>
        </a>
      </li>

      
      <?php if (getPermitido("69")=='SI'){ ?>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>portal-web/noticias" class="nav-link <?php echo ($menu_padre=='mn_noticias') ? 'active' : '' ?>">
          <i class="nav-icon far fa-question-circle"></i>
          <p>
            Noticias
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>portal-web/eventos" class="nav-link <?php echo ($menu_padre=='eventos') ? 'active' : '' ?>">
          <i class="nav-icon far fa-calendar-alt"></i>
          <p>
            Eventos
          </p>
        </a>
      </li>
      <?php }
      if (getPermitido("55")=='SI'){ ?>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>portal-web/bolsa-de-trabajo" class="nav-link <?php echo ($menu_padre=='bolsa') ? 'active' : '' ?>">
          <i class="nav-icon fas fa-user-tie"></i>
          <p>
            Bolsa de Trabajo
          </p>
        </a>
      </li>
      <?php }
      if (getPermitido("77")=='SI'){  ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>portal-web/convocatorias" class="nav-link <?php echo ($menu_padre=='convocatoria') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Convocatorias
            </p>
          </a>
        </li>
      <?php }  ?>

      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>portal-web/transparencia-categoria" class="nav-link <?php echo ($menu_padre=='categtransp') ? 'active' : '' ?>">
          <i class="nav-icon far fa-question-circle"></i>
          <p>
            Categorias
          </p>
        </a>
      </li>

      <?php if (getPermitido("62")=='SI'){ ?>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>portal-web/transparencia" class="nav-link <?php echo ($menu_padre=='mn_transparencia') ? 'active' : '' ?>">
          <i class="nav-icon far fa-question-circle"></i>
          <p>
            Transparencia
          </p>
        </a>
      </li>

      <?php } 
      if (getPermitido("90")=='SI'){ ?>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>portal-web/repositorio" class="nav-link <?php echo ($menu_padre=='repositorio') ? 'active' : '' ?>">
          <i class="nav-icon far fa-question-circle"></i>
          <p>
            Proyectos
          </p>
        </a>
      </li>
      <?php } ?>
      <?php if (getPermitido("86")=='SI'){ ?>
      <li class="nav-item">
        <a href="<?php echo $vbaseurl ?>portal-web/lecturas-recomendadas" class="nav-link <?php echo ($menu_padre=='lecturas') ? 'active' : '' ?>">
          <i class="nav-icon fas fa-book"></i>
          <p>
            Lecturas Recomendadas
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
      <?php if (getPermitido("77")=='SI'){ ?>
        <li class="nav-item has-treeview <?php echo ($menu_padre=='convocatorias') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_padre=='convocatorias') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Convocatorias
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php if (getPermitido("81")=='SI'){ ?>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>portal-web/convocatorias-tipo" class="nav-link <?php echo ($menu_hijo=='tipos') ? 'active' : '' ?>">
                <i class="fas fa-cog nav-icon"></i>
                <p>Tipos</p>
              </a>
            </li>
            <?php } ?>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>portal-web/convocatorias" class="nav-link <?php echo ($menu_hijo=='convocatoria') ? 'active' : '' ?>">
                <i class="fas fa-cog nav-icon"></i>
                <p>Convocatorias</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>
        <?php if (getPermitido("115")=='SI'){ ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>portal-web/galeria-institucional" class="nav-link <?php echo ($menu_padre=='galeria') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-image"></i>
            <p>
              Galería de Fotos
            </p>
          </a>
        </li>
        <?php } ?>

        <?php if (getPermitido("119")=='SI'){ ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>portal-web/slider" class="nav-link <?php echo ($menu_padre=='slider') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-image"></i>
            <p>
              Slider
            </p>
          </a>
        </li>
        <?php } ?>
    </ul>
  </nav>
</div>
</aside>