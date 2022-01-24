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
            <div class="col-12">
              <img src="<?php echo base_url().'resources/img/login_h80.'.getDominio().'.png';?>" alt="LOGO">
            </div>
           
        </div>
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
       
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
            </div>
         
          </div>
        </form>
        
        <small class="mb-1">
          Si tienes problemas con tu acceso, puedes escribirnos a:<br><br>
          <center>
            <?php 
              $textows="https://api.whatsapp.com/send?phone=51983136078&text=Hola%20soporte%20virtual%20ERP,%20pertenezco%20al%20instituto%20{$inst->nombre}%20y%20tengo%20una%20consulta%20%C2%BFpodr%C3%ADas%20ayudarme%3F"
            ?>
          <a class="btn btn-success btn-sm" href="<?php echo $textows ?>"  target="_blank">
            <i class="fab fa-whatsapp fa-1x mr-1"></i> WhatsApp
          </a>
          <!--<a class="btn btn-primary btn-sm" href="https://m.me/educaerp" target="_blank">
              <i class="fab fa-facebook-messenger  mr-1"></i> Messenger
          </a>-->
          </center>
         
          Correo: <span class="text-danger">soporte@<?php echo getDominio() ?></span><br>
          Celular : 983136078
        </small>
        <p><small><b class="text-primary">Educa ERP v1.0</b> - power by Meraki TD</small></p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
  <!-- jQuery 
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
<script src="<?php echo $vbaseurl ?>resources/plugins/jquery/jquery.min.js"></script>

  <!--<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

  <script src="<?php echo $vbaseurl ?>resources/dist/js/login.js"></script>
  <script type="text/javascript">
    function getTotalNotifica(){
    
}
  </script>
</body>
</html>