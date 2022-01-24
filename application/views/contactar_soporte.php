<style>
.logoname{
  display: block;
  font-family: 'Times New Roman', Times, serif;
  font-weight: bold;
  font-size: 25px;
  color: transparent;
  background: #666666;
  -webkit-background-clip: text;
  -moz-background-clip: text;
  background-clip: text;
  text-shadow: 0px 3px 3px rgba(255,255,255,0.2);
}
@media only screen and (max-width: 600px) {
    .logoname h4{
       font-size: 20px;
    }
}
</style>
<?php $vbaseurl=base_url() ?>
<body class="hold-transition login-page bg-white">
  <div class="login-box">
    <!-- /.login-logo -->
    <div id="divboxlogin" class="card card-outline card-primary" >
      <div class="card-body">
        <div class="row mb-3 text-center">
            <div class="col-3">
              <img src="<?php echo base_url().'resources/img/logo_h80.'.getDominio().'.png';?>" alt="LOGO">
            </div>
            <div class="col-9">
              <span class="logoname">
                <!--<h2><b>ERP</b></h2>-->
                <img src="<?php echo base_url().'resources/img/erp.png';?>" alt="ERP">
                <h4><?php echo $ninst ?></h4>
              </span>
            </div>
        </div>

        <!--<p class="login-box-msg">Sign in to start your session</p>-->
        <form id="frmlogin" name="frmlogin" action="<?php echo $vbaseurl ?>usuario/fn_login" method="post" accept-charset='utf-8'>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input class="form-control" id="txtuser" name="txtuser" type="text" placeholder="Usuario" minlength="5"  />
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                 <input class="form-control" id="txtclave" name="txtclave" type="password" placeholder="Clave" minlength="5"  />
              </div>
            </div>

          <div class="row">
            <div class="col-8">
              
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        
        <div class="social-auth-links text-center mb-2">
          <div id="divError" class="alert alert-danger text-justify" role="alert">
            <span id="msgError">
              <?php
                if (isset($_GET["google"])){
                if ($_GET["google"]=="0"){
                echo "No se encontró una cuenta relacionada al correo: ".$_GET["email"];
                }
                else if ($_GET["google"]=="1"){
                echo "Solo estan permitidas las cuentas corporativas de dominio <b>@getDominio()</b>, <b>".$_GET["email"]."</b> no es un email valido en nuestra aplicación";
                }
              }?>
            </span>
          </div>
          <small>-Tambien puedes-</small>
          <a href="<?php echo base_url().'iniciar-con-google'?>" class="btn btn-block btn-danger btn-sm">
            <i class="fab fa-google-plus mr-2"></i> Usar tu Correo institucional
          </a>
        </div>
        <!-- /.social-auth-links -->
        <small class="mb-1">
          Si tienes problemas con tu acceso, puedes escribirnos a:<br>
          <center>
          <a class="btn btn-success btn-sm" href="https://wa.link/p0s9ao" target="_blank">
            <i class="fab fa-whatsapp fa-1x mr-1"></i> WhatsApp
          </a>
          <a class="btn btn-primary btn-sm" href="https://m.me/educaerp" target="_blank">
              <i class="fab fa-facebook-messenger  mr-1"></i> Messenger
          </a>
          </center>
         
          Correo: <span class="text-danger">soporte@<?php echo getDominio() ?></span><br>
          Celular : 998660621
        </small>
        <p><small><b class="text-primary">Educa ERP v1.0</b> - power by activaclic.com</small></p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
  <!-- jQuery -->
  <script src="<?php echo $vbaseurl ?>resources/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo $vbaseurl ?>resources/dist/js/login.js"></script>
</body>
</html>