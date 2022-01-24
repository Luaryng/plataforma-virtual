 <?php 
 $vuser=$_SESSION['userActivo'];
 $vbaseurl=base_url();
 $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
date_default_timezone_set('America/Lima');
  //$nombres=explode(" ",$vuser->nombres);

  //$nombres[0]
  ?>
  <style type="text/css">
    .text-1em{
      font-size: 0.9em;
    }
    /*.btn-sesion {
      background-color: transparent;
      border: 0;
      padding: 2px 5px;
    }

    .btn-sesion:focus {
      outline: 0;
      background-color: #0000000f;
    }*/
  </style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-9">
              <?php
                foreach ($items as $key => $value) {
                  $icono = getIcono('P',$value->archivo);
                  $nuevo = ($value->nuevo == "SI") ? "<span class='text-danger'>NUEVO</span>" : "";
                  $arrayAccs = explode(",", $value->accesos);
                  $lnkarchivo = "";
                  // $palabras = explode (" ", strtolower($value->titulo));
                  if ($value->ruta != "") {
                    $lnkarchivo = "<a class='text-primary text-decoration-none' target='_blank' href='{$vbaseurl}upload/comunicados/$value->ruta'>$icono Descargar Archivo</a>";
                  }
                  for ($i = 0; $i < count($arrayAccs); $i++) {
                      if ($arrayAccs[$i] == $vuser->tipo) {
                          echo "<div class='callout callout-info'>
                                  <h5>$nuevo $value->titulo</h5>
                                  <p>$value->descripcion  
                                    
                                    $lnkarchivo
                                  </p>
                                </div>";
                      }
                  }
                  
                }
              ?>
            <div class="row">
              <div class="col-12 col-md-5 text-sm-center">
                <?php if ($vuser->tipo=="AL"){
                  /*echo 
                  "
                    <div class='card'>
                      <div class='card-body'>
                      <a href='{$vbaseurl}alumno/aula-virtual  '>
                      <i class='fas fa-cubes fa-4x d-none d-sm-block'></i>
                      <i class='fas fa-cubes fa-1x d-sm-none d-inline-block mr-1'></i>
                      Mis Unidades Didácticas
                      </a>
                      </div>
                    </div>
                  ";*/
                }
                elseif ($vuser->tipo=="AD"){
                  # code...
                }
                else{
                  echo 
                  "
                    <div class='card'>
                      <div class='card-body'>
                      <a href='{$vbaseurl}docente/mis-cursos  '>
                      <i class='fas fa-cubes fa-4x d-none d-sm-block'></i>
                      <i class='fas fa-cubes fa-1x d-sm-none d-inline-block mr-1'></i>
                      Mis Unidades Didácticas
                      </a>
                      </div>
                    </div>
                  ";
                }
                ?>
              </div>
            </div>
          </div>
          <?php //if ($vuser->tipo=="AL"){ ?>
          <div class="col-sm-3">
            <div class="card" id="divcard_eventos">
              <div class="card-header p-1">

                <?php 
                  $dateses =  new DateTime();
                  $hoy=$dateses->format('Y-m-d');
                ?>
                <button id="vw_vc_anterior" onclick="fn_fecha_mostrar($(this))" class="btn-sesion btn btn-sm btn-outline-primary sesion_link float-left" data-page="left" data-fecha="<?php echo $hoy ?>">
                  <i class="fas fa-angle-left fa-lg"></i>
                </button>
                <button id="vw_vc_siguiente" onclick="fn_fecha_mostrar($(this))" class="btn-sesion btn btn-sm btn-outline-primary sesion_link float-right" data-page="right" data-fecha="<?php echo $hoy ?>">
                  <i class="fas fa-angle-right fa-lg"></i>
                </button>
                <h3  class="card-title mt-2 text-center text-bold float-none" >
                  <a id="vw_vc_titulo" href="#" onclick="fn_fecha_mostrar($(this));return false"  data-page="none" data-fecha="<?php echo $hoy ?>">
                    <?php echo $dias[$dateses->format('w')].". ".$dateses->format('d/m/Y'); ?>
                  </a>
                </h3>
                
                
              </div>
              <div class="card-body px-0 pt-1" id="sesiones_panel">

              </div>
            </div>

            <div class="card" id="divcard_tarevforos">
              <div class="card-header">
                <h3 class="card-title">Tareas, Foros y evaluaciones</h3>
              </div>
              <div class="card-body p-0">
                <div class="col-12">
                  <ul class='products-list product-list-in-card pl-2 pr-2' id="tarevforos_panel">
                    <li class="item">
                      <div class='product-img p-3' style="background-color: #adb5bd9c;"></div>
                      <div class='product-info p-3' style="background-color: #adb5bd9c;"></div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="card" id="divcard_others">
              <div class="card-header">
                <h3 class="card-title">Otros eventos</h3>
              </div>
              <div class="card-body p-0">
                <div class="col-12">
                  <ul class='products-list product-list-in-card pl-2 pr-2' id="others_panel">
                    <li class="item">
                      <div class='product-img p-3' style="background-color: #adb5bd9c;"></div>
                      <div class='product-info p-3' style="background-color: #adb5bd9c;"></div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

          </div>
          <?php //} ?>
          
        </div>
      </div>
    </div>
    
  </div>

  <script>
   
    $(document).ready(function() {
      $("#vw_vc_titulo").click();
      obtener_eventos();
    });

    function obtener_eventos() {
      
      $('#divcard_tarevforos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $('#divcard_others').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: base_url + "index/listar_recursos_virtual",
          type: 'post',
          dataType: 'json',
          data: {
            "eventos": "eventos"
          },
          success: function(e) {
              $('#divcard_tarevforos #divoverlay').remove();
              $('#divcard_others #divoverlay').remove();
              if (e.status == false) {


                  $('#tarevforos_panel').html(e.eventos);
                  $('#others_panel').html(e.otherevent);
                  
              } else {

                  $('#tarevforos_panel').html(e.eventos);
                  $('#others_panel').html(e.otherevent);

              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception,'text');
              $('#divcard_tarevforos #divoverlay').remove();
              $('#divcard_others #divoverlay').remove();
              Swal.fire({
                  title: msgf,
                  // text: "",
                  type: 'error',
                  icon: 'error',
              })
          }
      });
      return false;
    }

    $(document).on("click", ".btn_ses_asist", function(e) {
      e.preventDefault();
      var btn = $(this);
      var enlace = btn.data('link');
      div = $('#divcard_eventos');
      var sesion = btn.data('sesion');
      var carga = btn.data('carga');
      var division = btn.data('division');
      var unidad = btn.data('unidad');

      div.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
        url: base_url + 'sesion/fn_curso_sesiones_asistencias'  ,
        type: 'post',
        dataType: 'json',
        data: {
          sesion: sesion,
          carga: carga,
          division: division,
          unidad: unidad
        },
        success: function(e) {
          div.find('#divoverlay').remove();
          if (e.status == false) {
            Swal.fire({
                        title: "Error!",
                        text: "existen errores",
                        type: 'error',
                        icon: 'error',
                    })
          }
          else {
            window.open(enlace);
          }
        },
        error: function (jqXHR, exception) {
          var msgf=errorAjax(jqXHR, exception,'div');
          div.find('#divoverlay').remove();
          Swal.fire('Error!',msgf,'error')
        },
      });
      return false;
    });

    function fn_fecha_mostrar(boton){
      var page = boton.data('page');
      var fecha = boton.data('fecha');
      $('#divcard_eventos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: base_url + "index/listar_recursos_sesiones",
          type: 'post',
          dataType: 'json',
          data: {
            "eventos": page,
            "fecha": fecha
          },
          success: function(e) {
            $('#divcard_eventos #divoverlay').remove();
            //if (e.status == false) {
              $('#sesiones_panel').html(e.sesiones);
              $('#vw_vc_siguiente').data('fecha',e.sesfecha);
              $('#vw_vc_anterior').data('fecha',e.sesfecha);
              $('#vw_vc_titulo').html(e.sesfechatext);
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception,'text');
              $('#divcard_eventos #divoverlay').remove();
              Swal.fire({
                  title: msgf,
                  // text: "",
                  type: 'error',
                  icon: 'error',
              })
          }
      });
      return false;
    };
    
  </script>