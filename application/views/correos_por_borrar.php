 <?php 
 $vuser=$_SESSION['userActivo'];
 $vbaseurl=base_url();

  //$nombres=explode(" ",$vuser->nombres);

  //$nombres[0]
  ?>
  <style type="text/css">
    .btn-sesion {
      background-color: transparent;
      border: 0;
      padding: 2px 5px;
    }

    .btn-sesion:focus {
      outline: 0;
      background-color: #0000000f;
    }
  </style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">

        <div class="card" id="divcard_email">
          <div class="card-header">
            <div class="card-title">
              <button class="btn btn-outline-dark btn_sed_correos">Enviar</button>
            </div>
          </div>
          <div class="card-body">
            <div style="background-color: white; padding: 15px;">
              <br>
              <table style="border: none important;">
                <tr>
                  <td width="82px">
                    <img src="http://localhost/educaerp/resources/img/logo_h80.iesap.edu.pe.png" alt="LOGO">
                  </td>
                  <td><h2 style="margin: 0px;">IES ALAS PERUANAS</h2>Plataforma Virtual</td>
                </tr>
              </table>
  
  
              <hr>
              <br>
              <div style="padding: 20px 10px; margin-bottom:10px; background-color: #ededed;
                border-radius: 10px 10px 10px 10px;
                -moz-border-radius: 10px 10px 10px 10px;
                -webkit-border-radius: 10px 10px 10px 10px;
                border: 0px solid #000000;">
                <div style="margin-bottom: 5px;">
                  Se a ingresado un tramite por mesa de partes:<br><br>
                  Solicitante: <b>SISTEMA WEB SISWEB</b><br>
                  Situación actual: <b>Soy estudiante Activo</b><br>
                  <ul>
                    <li>
                      Carné&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
                      <span class="text-bold"> 78014806-SEC</span>
                    </li>
                    <li>
                      Periodo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
                      <span class="text-bold"> 2021-2</span>
                    </li>
                    <li>
                      Programa:
                      <span class="text-bold"> SECRETARIADO EJECUTIVO</span>
                    </li>
                    <li>
                      Semestre&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
                      <span class="text-bold"> I</span>
                    </li>
                    <li>
                      Turno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
                      <span class="text-bold"> Diurno</span>
                    </li>
                    <li>
                      Sección&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
                      <span class="text-bold"> A</span>
                    </li>
                  </ul>

                  Asunto: <b>PLATAFORMA: Se ha ingresado el trámite N° 1M0612 por mesa de partes</b><br>
                  Detalle: <br><br>
                  <div>hsbdf sdhfbsydu sdufbsydu</div><br><br>
                  Domicilio: <b>aa.hh laguna azul mz e ; lt 18 </b><br>
                  Teléfono: <b>998660621</b><br>
                  Correo: <b>janiorjimenezh@gmail.com</b><br>
                  <br>
                  Puedes verificar el trámite en MESA DE PARTES de la Plataforma Virtual.
                </div>
                
              </div>
  
  
  
              Gracias. <br>
              Atte. Equipo de Plataforma Virtual <br><br>
              <hr>
  
              Usted está recibiendo este mensaje para informar eventos y/o cambios en su cuenta <br></small>
              
            </div>
            
            
          </div>  
        </div>
      </div>
    </div>
    
  </div>

  <script>

    $(document).on("click", ".btn_sed_correos", function(e) {
      e.preventDefault();
      var btn = $(this);

      $('#divcard_email').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
        // url: base_url + 'correos_notificar/fn_send_correos_pendientes',
        url: base_url + 'sendmail/f_sendmail_directo',
        type: 'post',
        dataType: 'json',
        data: {
          envio:"enviar"
        },
        success: function(e) {
          $('#divcard_email').find('#divoverlay').remove();
          if (e.status == false) {
            Swal.fire({
                        title: "Error!",
                        text: "existen errores",
                        type: 'error',
                        icon: 'error',
                    })
          }
          else {
            // window.open(enlace);
          }
        },
        error: function (jqXHR, exception) {
          var msgf=errorAjax(jqXHR, exception,'div');
          $('#divcard_email').find('#divoverlay').remove();
          Swal.fire('Error!',msgf,'error')
        },
      });
      return false;
    });
    
  </script>