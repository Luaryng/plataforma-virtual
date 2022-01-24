<style>
	body{
margin: 0;
padding: 0;
}
.bg-black{
background-color: black;
}
.bg-charles {
background-color: #c41e3a;
}
.border-3 {
border-width:3px !important;
}
.banner-title{
font-size: 2.5rem;
color: red;
font-family: "Times New Roman", Times, serif;
}
.seccion{
margin-top: 2.5rem;
padding-top: 2rem;
padding-bottom:  2rem;
margin-bottom: 2rem;
}
.seccion-title{
font-size: 2.5rem;
color: #c41e3a;
margin-bottom: 2rem;
font-family: "Times New Roman", Times, serif;
}
.seccion-subtitle{
font-size: 20px;
color: #797979
}
.text-charles{
color: #c41e3a;
}
.navbar-collapse ul li.mn-especial a{
color: white !important;
background:#C41414 ;
/*border-bottom: 2px solid #FFDF00;
border-radius: 0px;*/
}
.navbar-collapse ul li.active a{
color: #FFDF00 !important;
background: none;
border-bottom: 2px solid #FFDF00;
border-radius: 0px;
}
.navbar-collapse ul li.active .dropdown-menu a {
color: #fff !important;
border-bottom: 0;
}
.navbar-collapse ul li.active div a.active {
color: #FFDF00 !important;
background: none;
border-radius: 0px;
}
.navbar-collapse ul li a{
color: white !important;
}
.navbar-collapse ul li a:hover{
color: yellow !important;
}
.navbar-collapse ul li .dropdown-menu{
color: black !important;
background-color: black ;
opacity: 0.9;
}
.navbar-collapse ul li .dropdown-menu a:hover{
color: yellow !important;
background-color: black;
}
.navbar-collapse .nav-item {
margin-right: 10px;
}
/*.navbar-brand{
color: #F71270 !important;
}*/
.navbar-headers{
font-family: Arial, 'Helvetica', sans-serif;
font-size: 32px;
text-align: center;
color: #F71270 !important;
margin: 0px;
}
.navbar-subheaders{
font-family: Arial, 'Helvetica', sans-serif;
font-size: 13px;
color: white;
text-align: center;
margin: 0px;
}
.navbar-subheaders2{
font-family: Arial, 'Helvetica', sans-serif;
font-size: 10px;
color: white;
text-align: center;
margin-top: 0px;
margin-bottom: 5px;
}
.navbar-brand-headers{
font-family: Arial, 'Helvetica', sans-serif;
font-size: 28px;
text-align: center;
color: #F71270 !important;
margin: 0px;
}
.navbar-brand-subheaders{
font-family: Arial, 'Helvetica', sans-serif;
display: block;
font-size: 9px;
color: white;
text-align: center;
margin: 0px;
}
.navbar-brand-subheaders2{
font-family: Arial, 'Helvetica', sans-serif;
display: block;
font-size: 8px;
color: white;
text-align: center;
margin-top: 0px;
margin-bottom: 5px;
}
</style>
<?php $vdominio="https://".getDominio(); ?>

<header class="bg-black py-3">
  <div class="col-12">
    <div class="row">
      <div class="col-lg-4 d-none d-md-block">
        <h3 class="navbar-headers font-weight-bold">CHARLES ASHBEE</h3>
        <div class="">
          <h4 class="navbar-subheaders">INSTITUTO DE EDUCACIÓN SUPERIOR TECNOLÓGICO PRIVADO</h4>
          <h5 class="navbar-subheaders2">CENTRO DE EDUCACIÓN TÉCNICO PRODUCTIVO PRIVADO</h5>
        </div>
      </div>
      <div class="col-lg-8">
        <nav class="navbar navbar-expand-md bg-black navbar-dark py-3">
          <a class="navbar-brand col-9 d-block d-md-none" href="#">
            <h3 class="navbar-brand-headers font-weight-bold">CHARLES ASHBEE</h3>
            
            <span class="navbar-brand-subheaders">INSTITUTO DE EDUCACIÓN SUPERIOR TECNOLÓGICO PRIVADO</span>
            <span class="navbar-brand-subheaders2">CENTRO DE EDUCACIÓN TÉCNICO PRODUCTIVO PRIVADO</span>
            
          </a>
          <button class="navbar-toggler border" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav">
              <li class="nav-item ">
                <a class="nav-link" href="<?php echo $vdominio ?>">Inicio</a>
              </li>
              <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle"  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Institucional</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                  <a class="dropdown-item" href="<?php echo $vdominio ?>quienes-somos">Quienes somos</a>
                  <a class="dropdown-item" href="<?php echo $vdominio ?>bolsa-de-trabajo">Bolsa de Trabajo</a>
                  <a class="dropdown-item" href="<?php echo $vdominio ?>institucional/transparencia">Transparencia</a>
                </div>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="<?php echo $vdominio ?>carrera/diseno-de-modas">Diseño de Modas</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle"  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">CETPRO</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                  <a class="dropdown-item" href="<?php echo $vdominio ?>cetpro/counter">Counter / Aviación Comercial</a>
                  <a class="dropdown-item" href="<?php echo $vdominio ?>cetpro/recepcion-hotelera">Servicios básicos de Recepción Hotelera</a>
                  <a class="dropdown-item" href="<?php echo $vdominio ?>cetpro/restaurant">Servicios de Restaurant y Bar</a>
                  <a class="dropdown-item" href="<?php echo $vdominio ?>cetpro/cocina">Cocina</a>
                </div>
              </li>
              <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Novedades</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                  <a class="dropdown-item" href="<?php echo $vdominio ?>noticias">Prensa</a>
                  <!--<a class="dropdown-item" href="#">Artículos</a>-->
                  <a class="dropdown-item" href="<?php echo $vdominio ?>eventos">Eventos</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Intranet</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                  <a class="dropdown-item" href="https://erp.charlesashbee.edu.pe/">ERP</a>
                  <a class="dropdown-item" href="https://mail.google.com/a/charlesashbee.edu.pe">Correo</a>
                </div>
              </li>
              <li class="nav-item mn-especial">
                <a class="nav-link" href="http://localhost/sisweb/pre-inscripcion">Postula Aquí</a>
              </li>
            </ul>
            
          </div>
          
        </nav>
      </div>
    </div>
  </div>
</header>