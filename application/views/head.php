<!DOCTYPE html>
<html lang="es">
<head>
  <?php 
  

   ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $page_title ?></title>
  <?php $vbaseurl=base_url() 

  ?>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php echo $vbaseurl.'resources/img/favicon.'.getDominio().'.png'?>" />
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/adminlte.css">
  <link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/private-v5.css">
  <link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/sweetalert2/sweetalert2.min.css">

  <!-- Google Font: Source Sans Pro -->
 
  <!----<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">-->
  <script src="<?php echo $vbaseurl ?>resources/plugins/jquery/jquery.min.js"></script>
  <!----<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
  <script src="<?php echo $vbaseurl ?>resources/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- <script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>-->



  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


  <script>
      var base_url = '<?php echo $vbaseurl; ?>';
      var getUrlParameter = function getUrlParameter(sParam,sDefault) {
          var params = new window.URLSearchParams(window.location.search);
          var param =params.get(sParam);
          return (param===null) ? sDefault : param;
      };

      function errorAjax(jqXHR, exception,msgtype) {
          var msg = '';
          if (jqXHR.status === 0) {
              msg = 'Conexión perdida.\n Verifica tu red y conexión al Servidor.';
          } else if (jqXHR.status == 404) {
              msg = 'Página no encontrada. [404]';
          } else if (jqXHR.status == 500) {
              msg = 'Internal Server Error [500].';
          } else if (exception === 'parsererror') {
              msg = 'Requested JSON parse failed1.';
          } else if (exception === 'timeout') {
              msg = 'Time out error.';
          } else if (exception === 'abort') {
              msg = 'Ajax request aborted.';
          } else {
              msg = 'Uncaught Error.\n' + jqXHR.responseText;
          }
          if (msgtype=='div'){
            return '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + msg + '</div>';
          }
          else
          {
            return msg;
          }
          
          
      }

      
      function tr (str, from, to) {
        var out = "", i, m, p ;
        for (i = 0, m = str.length; i < m; i++) {
        p = from.indexOf(str.charAt(i));
        if (p >= 0) {
        out = out + to.charAt(p);
        }
        else {
        out += str.charAt(i);
        }
        }
        return out;
      }

      function base64url_encode(input) {
        //var v64=btoa(input);
        return tr(btoa(input), '+/=', '._-');
      }

      function base64url_decode(input) {
       return atob(tr(input, '._-', '+/='));
      }
      $(document).ready(function() {
        getTotalNotifica();
      });

      function copyToClipboard(elemento) {
        var $temp = $("<input>")
        $("body").append($temp);
        $temp.val($(elemento).text()).select();
        document.execCommand("copy");
        $temp.remove();
      }

  </script>
</head>
<section id="s-cargando" class="content">
    <div  class="card">
      <div class="card-body p-5 text-center">
        <i class="fas fa-spinner fa-pulse fa-5x"></i><br>
        Cargando...
      </div>
    </div>
</section>