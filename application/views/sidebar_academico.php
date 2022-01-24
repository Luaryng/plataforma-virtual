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
        <?php  $nombres=explode(" ",$vuser->nombres); ?>
        <small>
        <a href="<?php echo $vbaseurl ?>cuentas/mi-perfil" class="d-block"><?php echo $nombres[0]." ".$vuser->paterno; ?><br><?php echo $vuser->usuario ?></a>
        </small>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php 
        if (getPermitido("43")=='SI') { ?>
        <li class="nav-item ">
          <a href="<?php echo $vbaseurl ?>gestion/academico/matriculas?sb=academico" class="nav-link <?php echo ($menu_nieto=='alumnos') ? 'active' : '' ?>">
            <i class="fas fa-user-friends nav-icon"></i>
            <p>Matrículas</p>
          </a>
        </li>
        <?php }

        if (getPermitido("42")=='SI') { ?>
        <li class="nav-item ">
          <a href="<?php echo $vbaseurl ?>academico/grupos-matriculados?sb=academico" class="nav-link <?php echo ($menu_nieto=='grupos') ? 'active' : '' ?>">
            <i class="fas fa-users nav-icon"></i>
            <p>Grupos</p>
          </a>
        </li>

        <li class="nav-item ">
          <a href="<?php echo $vbaseurl ?>academico/reportes/sede?sb=academico" class="nav-link <?php echo ($menu_nieto=='reportes') ? 'active' : '' ?>">
            <i class="fas fa-users nav-icon"></i>
            <p>Reportes</p>
          </a>
        </li>

        <li class="nav-header text-bold">PLATAFORMA</li>
         <?php if (getPermitido("40")=='SI') { ?>
        <li class="nav-item has-treeview <?php echo ($menu_padre=='monitoreo') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_padre=='monitoreo') ? 'active' : '' ?>">
            <i class="nav-icon far fa-eye"></i>
            <p>
              Monitoreo
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php if (getPermitido("39") == "SI") {?>
            <li class="nav-item pl-2">
              <a href="<?php echo base_url() ?>monitoreo/estudiantes" class="nav-link <?php echo ($menu_hijo=='mon-alumnos') ? 'active' : '' ?>">
                <i class=" nav-icon fas fa-user-graduate"></i> <span>Estudiantes</span>
                <span class="pull-right-container">
                  <!--<small class="label pull-right bg-blue">0</small>-->
                  <!--<small class="label pull-right bg-red">0</small>-->
                </span>
              </a>
            </li>
            <?php }
            if (getPermitido("38") == "SI") {?>
            <li class="nav-item pl-2">
              <a href="<?php echo base_url() ?>monitoreo/docentes" class="nav-link <?php echo ($menu_hijo=='mon-docentes') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-user-tie"></i> <p>Docentes</p>
              </a>
            </li>
            <?php }
            if (getPermitido("55") == "SI") {?>
            <li class="nav-item pl-2">
              <a href="<?php echo base_url() ?>monitoreo/grupos" class="nav-link <?php echo ($menu_hijo=='mon-grupos') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-user-tie"></i> <p>Grupos</p>
              </a>
            </li>
            <?php }?>
          </ul>
        </li>
        <?php } ?>
        <?php 
        if (getPermitido("49")=='SI') { ?>
        <li class="nav-item ">
          <a href="<?php echo $vbaseurl ?>gestion/academico/carga-academica/panel?sb=academico" class="nav-link <?php echo ($menu_padre=='cargaacademica') ? 'active' : '' ?>">
            <i class="fas fa-user-friends nav-icon"></i>
            <p>Carga Académica</p>
          </a>
        </li>
        <?php } ?>

        <?php if (getPermitido("49")=='SI') { ?>

        <li class="nav-item has-treeview <?php echo ($menu_hijo=='cargaacademica') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_hijo=='cargaacademica') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-list-ul"></i>
            <p>
              Carga Académica
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php if (getPermitido("41")=='SI'){ ?>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>gestion/academico/carga-academica/grupo?sb=academico" class="nav-link <?php echo ($menu_nieto=='cargaxgrupo') ? 'active' : '' ?>">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Carga por grupo</p>
              </a>
            </li>
            <?php } ?>
            <?php if (getPermitido("50")=='SI') { ?>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>gestion/academico/carga-academica/docente?sb=academico" class="nav-link <?php echo ($menu_nieto=='cargaxdocente') ? 'active' : '' ?>">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Carga por docente</p>
              </a>
            </li>
            <?php } ?>
            <?php if (getPermitido("128")=='SI') { ?>
            <!--<li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>academico/grupos/descargar-notas" class="nav-link <?php echo ($menu_hijo=='mn_acad_notas') ? 'active' : '' ?>">
                <i class="fas fa-list nav-icon"></i>
                <p>Descargar notas</p>
              </a>
            </li>-->
            <?php } ?>
          </ul>
        </li>
        <?php } ?>





        <?php } ?>
        <li class="nav-header text-bold">HISTÓRICO</li>


        <!-----BLOQUE CURRICULAS-->
        <li class="nav-item has-treeview <?php echo ($menu_hijo=='curricula') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_hijo=='curricula') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-list-ul"></i>
            <p>
              Currícula
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>academico/plan-estudios" class="nav-link <?php echo ($menu_nieto=='planstd') ? 'active' : '' ?>">
                <i class="fas fa-user-friends nav-icon"></i>
                <p>Plan estudios</p>
              </a>
            </li>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>academico/modulo-educativo" class="nav-link <?php echo ($menu_nieto=='modeduca') ? 'active' : '' ?>">
                <i class="fas fa-user-friends nav-icon"></i>
                <p>Modulo educativo</p>
              </a>
            </li>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>academico/unidad-didactica" class="nav-link <?php echo ($menu_nieto=='unidac') ? 'active' : '' ?>">
                <i class="fas fa-user-friends nav-icon"></i>
                <p>Unidad didáctica</p>
              </a>
            </li>
          </ul>
        </li>
        <!-----FIN BLOQUE CURRICULAS-->
        <!-----BLOQUE CONSULTA-ACADEMICO-->
        <li class="nav-item has-treeview <?php echo ($menu_hijo=='acadconsulta') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_hijo=='acadconsulta') ? 'active' : '' ?>">
            <i class="nav-icon fab fa-searchengin"></i>
            <p>
              Consultas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>academico/consulta/boleta-notas" class="nav-link <?php echo ($menu_nieto=='bolnotas') ? 'active' : '' ?>">
                <i class="fas fa-user-friends nav-icon"></i>
                <p>Boleta de Notas</p>
              </a>
            </li>
            <!--<li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>academico/consulta/orden-merito" class="nav-link <?php echo ($menu_nieto=='acadmerito') ? 'active' : '' ?>">
                <i class="fas fa-user-friends nav-icon"></i>
                <p>Grupos</p>
              </a>
            </li>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>academico/unidad-didactica" class="nav-link <?php echo ($menu_nieto=='unidac') ? 'active' : '' ?>">
                <i class="fas fa-user-friends nav-icon"></i>
                <p>Unidad didáctica</p>
              </a>
            </li>-->
          </ul>
        </li>
        <!-----FIN BLOQUE CURRICULAS-->
       
        
        <?php if (getPermitido("139")=='SI') { ?>
        <li class="nav-item has-treeview <?php echo ($menu_hijo=='practicas_acad') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_hijo=='practicas_acad') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>
              Prácticas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>academico/practicas?sb=academico" class="nav-link <?php echo ($menu_nieto=='mn_acad_practicas') ? 'active' : '' ?>">
                <i class="fas fa-list nav-icon"></i>
                <p>Estudiante</p>
              </a>
            </li>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>academico/practicas/etapas-plan?sb=academico" class="nav-link <?php echo ($menu_nieto=='mn_acad_etapas_plan') ? 'active' : '' ?>">
                <i class="fas fa-layer-group nav-icon"></i>
                <p>Etapas por Plan</p>
              </a>
            </li>
            <li class="nav-header text-bold pt-0 pl-4"> <u>Mantenimiento</u></li>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>academico/practicas/empresas?sb=academico" class="nav-link <?php echo ($menu_nieto=='mn_acad_empresas') ? 'active' : '' ?>">
                <i class="fas fa-city nav-icon"></i>
                <p>Empresas</p>
              </a>
            </li>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>academico/practicas/modalidad?sb=academico" class="nav-link <?php echo ($menu_nieto=='mn_acad_modalidad') ? 'active' : '' ?>">
                <i class="fas fa-list nav-icon"></i>
                <p>Modalidad de Prácticas</p>
              </a>
            </li>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>academico/practicas/etapas?sb=academico" class="nav-link <?php echo ($menu_nieto=='mn_acad_etapas') ? 'active' : '' ?>">
                <i class="fas fa-layer-group nav-icon"></i>
                <p>Etapa de Prácticas</p>
              </a>
            </li>
            
            
            
          </ul>
        </li>
        <?php } ?>

        <?php if (getPermitido("148")=='SI') { ?>
        <li class="nav-item has-treeview <?php echo ($menu_padre=='egresados_acad') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_padre=='egresados_acad') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-graduation-cap"></i>
            <p>
              Egresados
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>academico/egresados?sb=academico" class="nav-link <?php echo ($menu_hijo=='seg-egresados') ? 'active' : '' ?>">
                <i class="fas fa-list nav-icon"></i>
                <p>Listado</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>

        
        <?php 
        if (((getPermitido("97") == "SI")) && (($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'AD'))) {?>
        <li class="nav-header text-bold">PLATAFORMA</li>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/facturacion/documentos-de-pago?sb=academico" class="nav-link <?php echo ($menu_padre=='mn_facturaerp') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-money-check-alt"></i>
            <p>
              Documentos de Pago
              
            </p>
          </a>
        </li>
        <?php } ?>

      </ul>
    </nav>
  </div>
</aside>