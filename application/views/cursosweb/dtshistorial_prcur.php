<?php
if (isset($historial) && (count($historial)>0))
{ ?>
<div id="divtabl-addamiembros" class="col-12 col-md-12 btable">
  <div class="col-md-12 thead d-none d-md-block">
    <div class="row ">
      <div class="col-12 col-md-6 ">
        <div class="row">
          <div class="col-6 col-md-1 td">
            <span>N°</span>
          </div>
          <div class="col-6 col-md-3 td">
            <span>ESTADO</span>
          </div>
          <div class="col-3 col-md-4 td">
            <span>DOC. IDENTIDAD</span>
          </div>
          <div class="col-12 col-md-4 td">
            INSCRITO
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 ">
        <div class="row">
          <div class="col-5 col-md-7 td">
            <span>CELULAR / CORREO</span>
          </div>
          <div class="col-4 col-md-5 td">
            <span>PROGRAMA</span>
          </div>
          
        </div>
      </div>
      <div class="col-12 col-md-2 td ">
        
        ACCIONES
      </div>
    </div>
  </div>
  <div class="col-md-12 tbody">
    <?php
    $nro = 0;
    foreach ($historial as $value) {
      $nro++;
      $id_encripta=base64url_encode($value->id);
      $dia_actual = date("Y-m-d");
      $edad_diff = date_diff(date_create( $value->fechanac), date_create($dia_actual))->format('%y');
      $edad=($edad_diff>0)?"($edad_diff Años)":"";
      if ($value->estado == "PENDIENTE") {
        $bgstatus = "bg-info";
      } else if ($value->estado == "INSCRITO") {
        $bgstatus = "bg-success";
      }else if ($value->estado == "PROSPECTO") {
        $bgstatus = "bg-primary";
      }else if ($value->estado == "ANULADO") {
        $bgstatus = "bg-danger";
      }
    ?>
    <div  class="row rowcolor" id="parent-<?php echo $id_encripta ?>">
      <div class="col-12 col-md-6 ">
        <div class="row">
          <div class="col-2 col-md-1 td">
            <span><?php echo $nro ;?></span>
          </div>
          <div class="col-5 col-md-3 td text-center"> 
            <span class="badge <?php echo $bgstatus ?> p-2"><?php echo "$value->estado" ?></span>
          </div>
          <div class="col-5 col-md-4 td">
            <span><?php echo "$value->tipodoc $value->documento" ;?></span><br>
            <span class="small"><i class='far fa-calendar-alt'></i> <?php echo date("d/m/Y h:i a", strtotime($value->fecha));?></span>
          </div>
          <div class="col-12 col-md-4 td">
            <?php echo "$value->ape_paterno $value->ape_materno <br> $value->nombres $edad";?>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 ">
        <div class="row">
          <div class="col-12 col-md-7 td">
            <span><?php echo "$value->telefono<br>$value->correo" ;?></span>
          </div>
          <div class="col-12 col-md-5 td">
            <span><?php echo $value->carrera; ?></span>
          </div>
          
        </div>
      </div>
      <div class="col-12 col-md-2 ">
        <div class="row">
          <div class="col-8 col-md-8 td text-center">
            <div class='btn-group'>
                <a href="#" class='badge badge-primary dropdown-toggle p-2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <i class='fas fa-cog'></i> Opciones
                </a>
                <div class='dropdown-menu dropdown-menu-right acc_dropdown'>
                    <a class='dropdown-item' href="#"  onclick="viewarchivos('<?php echo $id_encripta ?>')">
                      <i class="fas fa-paperclip fa-fw"></i> Ver
                    </a>
                    <a class='dropdown-item' href='<?php echo "{$vbaseurl}formacion-continua/ficha-pre-inscripcion/editar/$id_encripta" ?>'>
                      <i class="far fa-edit fa-fw"></i> Editar
                    </a>
                    <a class='dropdown-item' href='#' title='Editar' onclick="viewseguimiento('<?php echo $id_encripta ?>','<?php echo $value->estado ?>')" data-toggle="modal" data-target="#modseguimiento" data-id="<?php echo $id_encripta ?>" data-estado="<?php echo $value->estado ?>" id="btn-<?php echo $id_encripta ?>">
                        <i class='fas fa-search  fa-fw'></i> Seguimiento
                    </a>
                    <a href="#" class='dropdown-item text-danger btn_deleteinsc' data-id="<?php echo $id_encripta ?>">
                        <i class='fas fa-trash  fa-fw'></i> Eliminar
                    </a>
                </div>
            </div>
          </div>
          <div class='col-4 td text-center'>
            
                <div class='btn-group'>
                    <a href="#" class='badge badge-warning dropdown-toggle p-2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                      <i class='fas fa-print'></i>
                    </a>
                    <div class='dropdown-menu dropdown-menu-right'>
                        <a class='dropdown-item' target="_blank" href='<?php echo "{$vbaseurl}formacion-continua/curso/inscripcion/pdf?cmt={$id_encripta}" ?>' title='Editar'>
                            <i class='far fa-file-pdf mr-1'></i> Imprimir ficha
                        </a>
                        <a href="#" class='dropdown-item '>
                            <i class='fas fa-at mr-1'></i> Enviar por Correo
                        </a>
                    </div>
                </div>
            
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
<script>
  $('.btn_deleteinsc').click(function(){
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var codigo = $(this).data('id');
    var fila = $(this).parents("#parent-"+codigo);
    Swal.fire({
      title: "Precaución",
      html: "<p>Se eliminarán todos los datos con respecto a esta</p><b>PRE-INSCRIPCIÓN </b>",
      type: 'warning',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: base_url + 'curso_web/fn_eliminar',
          type: 'post',
          dataType: 'json',
          data: {
            'txtcodigo': codigo
          },
          success: function(e) {
            $('#divboxhistorial #divoverlay').remove();
            if (e.status == false) {
              Swal.fire({
                type: 'error',
                icon: 'error',
                title: 'Error!',
                text: e.msg,
                backdrop: false,
              })
            } else {
          
              Swal.fire({
                type: 'success',
                icon: 'success',
                title: 'Eliminación correcta',
                text: 'Se ha eliminado la inscripción',
                backdrop: false,
              })

              fila.remove();
            }
          },
          error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divboxhistorial #divoverlay').remove();
            Swal.fire({
              type: 'error',
              icon: 'error',
              title: 'Error',
              text: msgf,
              backdrop: false,
            })
          }
        });
      } else {
        $('#divboxhistorial #divoverlay').remove();
      }
    })
  });
  
</script>
<?php
}
else
{
  echo "<h4 class='px-2'>No se encontro coincidencias</h4>";
}
?>