<?php
$vuser=$_SESSION['userActivo'];
$vbaseurl=base_url();
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Trámites</h1>
        </div>
        
      </div>
    </div>
  </section>
  
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        
        <?php
        if ($vuser->tipo!="AL"){
        echo
        "<div class='col-12 col-md-3 text-sm-center'>
          <div class='card'>
            <div class='card-body'>
              <a href='{$vbaseurl}gestion/tramites/mesa-de-partes'>
                <i class='fas fa-cubes fa-4x d-none d-sm-block'></i>
                <i class='fas fa-cubes fa-1x d-sm-none d-inline-block mr-1'></i>
                <b>Mesa de Partes</b>
              </a>
              <div>
                <span class='d-block'>Tickets Abiertos: 0</span>
                <span class='d-block'>Tickets en proceso: 0</span>
                <span class='d-block'>Tickets Completados: 0</span>
              </div>
            </div>
          </div>
        </div>
        <div class='col-12 col-md-3 text-sm-center'>
          <div class='card'>
            <div class='card-body'>
              <a href='{$vbaseurl}gestion/tramites/denuncias'>
                <i class='fas fa-user-secret fa-4x d-none d-sm-block'></i>
                <i class='fas fa-user-secret fa-1x d-sm-none d-inline-block mr-1'></i>
                <b>Denuncias</b>
              </a>
              <div>
                <span class='d-block'>Tickets Abiertos: 0</span>
                <span class='d-block'>Tickets en proceso: 0</span>
                <span class='d-block'>Tickets Completados: 0</span>
              </div>
            </div>
          </div>
        </div>
        ";
        }
        ?>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>