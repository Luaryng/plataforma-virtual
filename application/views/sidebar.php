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
        <?php $nombres=explode(" ",$vuser->nombres); ?>
        <small><a href="<?php echo $vbaseurl ?>cuentas/mi-perfil" class="d-block"><?php echo $nombres[0]." ".$vuser->paterno;  ?><br><?php echo $vuser->usuario ?></a></small>

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
              Ayuda
            </p>
          </a>
        </li>
        <?php 
        if (getPermitido("94") == "SI") {?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>documentos/pagos" class="nav-link <?php echo ($menu_padre=='mn_facturaerp') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-money-check-alt"></i>
            <p>
              Facturación ERP
              <?php 
              if (isset($_SESSION['userNotificaFC'])) {
                echo "<span class='right badge badge-danger'>".$_SESSION['userNotificaFC']."</span>";
              }
              ?>
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
              Unidades didácticas
            </p>
          </a>
        </li>
        <?php } ?>

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

        <?php } ?>
        <?php if (getPermitido("33")=='SI') { ?>
        <li class="nav-item has-treeview <?php echo ($menu_padre=='control') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_padre=='control') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Control Sistema
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php if (getPermitido("28")=='SI') {?>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>administrador/cuentas" class="nav-link <?php echo ($menu_hijo=='usuarios') ? 'active' : '' ?>">
                <i class="fas fa-user-friends nav-icon"></i>
                <p>Usuarios</p>
              </a>
            </li>
            <?php }
            if ($vuser->codnivel=="0") {?>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>administrador/acciones" class="nav-link <?php echo ($menu_hijo=='acciones') ? 'active' : '' ?>">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Acciones</p>
              </a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
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

 
        <?php if (getPermitido("34")=='SI') { ?>
        <!--ADMISIÓN-->
        <li class="nav-item has-treeview <?php echo ($menu_padre=='admision') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_padre=='admision') ? 'active' : '' ?>">
            <i class="fas fa-user-clock nav-icon"></i></i>
            <p>
              Admisión
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <?php if (getPermitido("95")=='SI') { ?>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>admision/pre-inscripcion" class="nav-link <?php echo ($menu_hijo=='preinscripcion') ? 'active' : '' ?>">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Pre-inscripciones</p>
              </a>
            </li>
            <?php } 
            if (getPermitido("46")=='SI') { ?>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>admision/ficha-personal" class="nav-link <?php echo ($menu_hijo=='ficha') ? 'active' : '' ?>">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Datos Personales</p>
              </a>
            </li>
            <?php } 
            if (getPermitido("45")=='SI') { ?>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>admision/inscripciones" class="nav-link <?php echo ($menu_hijo=='inscripcion') ? 'active' : '' ?>">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Inscripciones</p>
              </a>
            </li>
            <?php }

            if (getPermitido("112")=='SI') { ?>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>admision/reingresos" class="nav-link <?php echo ($menu_hijo=='reingreso') ? 'active' : '' ?>">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Reingresos</p>
              </a>
            </li>
            <?php }


            if (getPermitido("47")=='SI') { ?>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>administrador/acciones" class="nav-link <?php echo ($menu_hijo=='traslado') ? 'active' : '' ?>">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Traslado</p>
              </a>
            </li>
          <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if ($vuser->codnivel!=="3"){ ?>
        <!-- ACADÉMICO-->
        <?php if (getPermitido("36")=='SI') { ?>
        <li class="nav-item has-treeview <?php echo ($menu_padre=='academico') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_padre=='academico') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-graduation-cap"></i>
            <p>
              Académico
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php if (getPermitido("42")=='SI') { ?>
                <li class="nav-item pl-2">
                  <a href="<?php echo $vbaseurl ?>academico/grupos-matriculados" class="nav-link <?php echo ($menu_nieto=='grupos') ? 'active' : '' ?>">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Grupos matriculados</p>
                  </a>
                </li>
                <?php } 
                 if (getPermitido("43")=='SI') { ?>
                <li class="nav-item pl-2">
                  <a href="<?php echo $vbaseurl ?>gestion/academico/matriculas" class="nav-link <?php echo ($menu_nieto=='alumnos') ? 'active' : '' ?>">
                    <i class="fas fa-user-friends nav-icon"></i>
                    <p>Alumnos matriculados</p>
                  </a>
                </li>
                <?php } 
                if (getPermitido("125")=='SI') { ?>
                <li class="nav-item pl-2">
                  <a href="<?php echo $vbaseurl ?>gestion/academico/matriculas" class="nav-link <?php echo ($menu_nieto=='alumnos') ? 'active' : '' ?>">
                    <i class="fas fa-user-friends nav-icon"></i>
                    <p>Matrículas</p>
                  </a>
                </li>
                <?php } 
                ?>
             <!-----BLOQUE MATRICULAS-->
           
            <!-----FIN BLOQUE MATRICULAS-->
            <?php if (getPermitido("49")=='SI') { ?>
            <li class="nav-item pl-2 has-treeview <?php echo ($menu_hijo=='cargaacademica') ? 'menu-open' : '' ?>">
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
                  <a href="<?php echo $vbaseurl ?>gestion/academico/carga-academica/grupo" class="nav-link <?php echo ($menu_nieto=='cargaxgrupo') ? 'active' : '' ?>">
                    <i class="fas fa-list-ul nav-icon"></i>
                    <p>Carga por grupo</p>
                  </a>
                </li>
              <?php } ?>
              <?php if (getPermitido("50")=='SI') { ?>
                <li class="nav-item pl-2">
                  <a href="<?php echo $vbaseurl ?>gestion/academico/carga-academica/docente" class="nav-link <?php echo ($menu_nieto=='cargaxdocente') ? 'active' : '' ?>">
                    <i class="fas fa-list-ul nav-icon"></i>
                    <p>Carga por docente</p>
                  </a>
                </li>
              <?php } ?>
              <?php if (getPermitido("128")=='SI') { ?>
                <li class="nav-item pl-2">
                  <a href="<?php echo $vbaseurl ?>academico/grupos/descargar-notas" class="nav-link <?php echo ($menu_hijo=='mn_acad_notas') ? 'active' : '' ?>">
                    <i class="fas fa-list nav-icon"></i>
                    <p>Descargar notas</p>
                  </a>
                </li>
              <?php } ?>
              </ul>
            </li>
            <?php } ?>
            
            <!-----BLOQUE CURRICULAS-->
            <li class="nav-item pl-2 has-treeview <?php echo ($menu_hijo=='curricula') ? 'menu-open' : '' ?>">
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
            <li class="nav-item pl-2 has-treeview <?php echo ($menu_hijo=='acadconsulta') ? 'menu-open' : '' ?>">
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
            
          </ul>
        </li>
        <?php } 
      }?>
      <!-----BLOQUE EGRESADOS-->
        <?php if (getPermitido("35")=='SI') { ?>
        <li class="nav-item has-treeview <?php echo ($menu_padre=='egresados') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_padre=='egresados') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>
              Egresados
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <!--<li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>gestion/rrhh/docentes" class="nav-link <?php echo ($menu_hijo=='egresar') ? 'active' : '' ?>">
                <i class="fas fa-user-friends nav-icon"></i>
                <p>Egresar alumnos</p>
              </a>
            </li>-->
            
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>seguimiento/egresados" class="nav-link <?php echo ($menu_hijo=='seg-egresados') ? 'active' : '' ?>">
                <i class="fas fa-user-friends nav-icon"></i>
                <p>Seguimiento</p>
              </a>
            </li>

          </ul>
        </li>
        <?php } ?>



        <?php if (getPermitido("35")=='SI') { ?>
        <li class="nav-item has-treeview <?php echo ($menu_padre=='rrhh') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_padre=='rrhh') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-graduation-cap"></i>
            <p>
              Recursos Humanos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
   

            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>gestion/rrhh/ficha-personal" class="nav-link <?php echo ($menu_hijo=='mn_rh_ficha') ? 'active' : '' ?>">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Datos Personales</p>
              </a>
            </li>

            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>gestion/rrhh/docentes" class="nav-link <?php echo ($menu_hijo=='docentes') ? 'active' : '' ?>">
                <i class="fas fa-user-friends nav-icon"></i>
                <p>Personal</p>
              </a>
            </li>

          </ul>
        </li>
        <?php } ?>
       
        <?php if (getPermitido("31")=='SI') { ?>
        <li class="nav-item has-treeview <?php echo ($menu_padre=='biblioteca') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_padre=='biblioteca') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-university"></i>
            <p>
              Biblioteca
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>biblioteca/editorial" class="nav-link <?php echo ($menu_hijo=='editor') ? 'active' : '' ?>">
                <i class="fas fa-book nav-icon"></i>
                <p>Editorial</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>biblioteca/autores" class="nav-link <?php echo ($menu_hijo=='autor') ? 'active' : '' ?>">
                <i class="fas fa-user nav-icon"></i>
                <p>Autores</p>
              </a>
            </li>
            <?php if (getPermitido("30")=='SI') { ?>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>biblioteca/virtual" class="nav-link <?php echo ($menu_hijo=='libro') ? 'active' : '' ?>">
                <i class="fas fa-book nav-icon"></i>
                <p>Libros</p>
              </a>
            </li>
          <?php } 
            if (getPermitido("31")=='SI') { ?>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>biblioteca/historial" class="nav-link <?php echo ($menu_hijo=='historial') ? 'active' : '' ?>">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Historial Libro</p>
              </a>
            </li>
          <?php } ?>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>biblioteca/prestamos-libros" class="nav-link <?php echo ($menu_hijo=='prestamo') ? 'active' : '' ?>">
                <i class="fas fa-book nav-icon"></i>
                <p>Prestamos Libro</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>biblioteca/devolucion-libros" class="nav-link <?php echo ($menu_hijo=='retorno') ? 'active' : '' ?>">
                <i class="fas fa-book nav-icon"></i>
                <p>Devolución Libro</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $vbaseurl ?>biblioteca/buscar-libros" class="nav-link <?php echo ($menu_hijo=='busqueda') ? 'active' : '' ?>">
                <i class="fas fa-book nav-icon"></i>
                <p>Buscar Libros</p>
              </a>
            </li>
          </ul>
        </li>
        <?php }

        if (($vuser->tipo == 'AD') || ($vuser->tipo == 'DA')) {
        //if (getPermitido("68")=='SI') { ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>gestion/tramites/mesa-de-partes" class="nav-link <?php echo ($menu_padre=='mn_mesa') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-globe"></i>
            <p>
              Mesa de Partes
              <?php 
              if (isset($_SESSION['userNotificaMP'])) {
                echo "<span class='right badge badge-danger'>".$_SESSION['userNotificaMP']."</span>";
              }
              ?>
              
            </p>
          </a>
        </li>
        <?php 
        } 
        if (getPermitido("85")=='SI') { ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>gestion/tramites/denuncias" class="nav-link <?php echo ($menu_padre=='ltsincidencia') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-globe"></i>
            <p>
            Denuncias
            </p>
          </a>
        </li>
        <?php 
        } 

        if (getPermitido("32")=='SI') { ?>
        <li class="nav-item has-treeview <?php echo ($menu_padre=='mantenimiento') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo ($menu_padre=='mantenimiento') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Mantenimiento
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>gestion/area" class="nav-link <?php echo ($menu_hijo=='area') ? 'active' : '' ?>">
                <i class="fas fa-cog nav-icon"></i>
                <p>Área</p>
              </a>
            </li>
            <li class="nav-item pl-2">
              <a href="<?php echo $vbaseurl ?>configuracion/institucion" class="nav-link <?php echo ($menu_hijo=='mn_mnt_institucion') ? 'active' : '' ?>">
                <i class="fas fa-globe nav-icon"></i>
                <p>Institución</p>
              </a>
            </li>
            
            
          </ul>
        </li>
        <?php }  
        if (getPermitido("55")=='SI'){ ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>portal-web" class="nav-link <?php echo ($menu_padre=='bolsa') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-globe"></i>
            <p>
              Portal Web
            </p>
          </a>
        </li>
        <?php } 

      if ($vuser->codnivel=="0") {?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>gestion/auditoria" class="nav-link <?php echo ($menu_padre=='auditoria') ? 'active' : '' ?>">
            <i class="nav-icon fa fa-list"></i>
            <p>
              Auditoria
            </p>
          </a>
        </li>

        <?php } ?>
        
        <?php if (getPermitido("73")=='SI'){  ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>gestion/comunicados" class="nav-link <?php echo ($menu_padre=='comunicados') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-globe"></i>
            <p>
              Comunicados
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


