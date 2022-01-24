<?php
if (isset($historial) && (count($historial)>0))
{ ?>
<div id="divtabl-addamiembros" class="col-12 col-md-12 btable">
  <div class="col-md-12 thead d-none d-md-block">
    <div class="row ">
      <div class="col-12 col-md-7 ">
        <div class="row">
          <div class="col-6 col-md-1 td">
            <span>N°</span>
          </div>
          <div class="col-6 col-md-2 td">
            <span>ESTADO</span>
          </div>
          <div class="col-6 col-md-2 td">
            <span>TIPO</span>
          </div>
          <div class="col-3 col-md-3 td">
            <span>DOC. IDENTIDAD</span>
          </div>
          <div class="col-12 col-md-4 td">
            PRE INSCRITO
          </div>
        </div>
      </div>
      <div class="col-12 col-md-3 ">
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
    <div  class="row rowcolor" id="parent-<?php echo base64url_encode($value->id) ?>">
      <div class="col-12 col-md-7 ">
        <div class="row">
          <div class="col-2 col-md-1 td">
            <span><?php echo $nro ;?></span>
          </div>
          <div class="col-5 col-md-2 td"> 
            <span class="badge <?php echo $bgstatus ?> p-2"><?php echo "$value->estado" ?></span>
          </div>
          <div class="col-5 col-md-2 td">
            <span><?php echo "$value->periodo <br> <small>$value->tipo</small>" ?></span>
          </div>
          <div class="col-4 col-md-3 td">
            <span><?php echo "$value->tipodoc $value->documento" ;?></span><br>
            <span class="small"><i class='far fa-calendar-alt'></i> <?php echo date("d/m/Y h:i a", strtotime($value->fecha));?></span>
          </div>
          <div class="col-8 col-md-4 td">
            <?php echo "$value->ape_paterno $value->ape_materno <br> $value->nombres $edad";?>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-3 ">
        <div class="row">
          <div class="col-9 col-md-7 td">
            <span><?php echo "$value->telefono<br>$value->correo" ;?></span>
          </div>
          <div class="col-4 col-md-5 td">
            <span><?php echo $value->carrera; ?></span><br>
            <span class="small">(<?php echo $value->sedenom ?>)</span>
          </div>
          
        </div>
      </div>
      <div class="col-12 col-md-2 ">
        <div class="row">
          
          <div class="col-4 col-md-4 td">
            <button type="button" class="btn btn-warning btn-sm btn_search_reguim" onclick="viewarchivos('<?php echo base64url_encode($value->id) ?>')">
              <i class="fas fa-paperclip"></i>
            </button>
          </div>

          <div class="col-2 col-md-4 td text-center">
            <button type="button" class="btn btn-info btn-sm btn_search_reguim" onclick="viewseguimiento('<?php echo base64url_encode($value->id) ?>','<?php echo $value->estado ?>')" data-toggle="modal" data-target="#modseguimiento" data-id="<?php echo base64url_encode($value->id) ?>" data-estado="<?php echo $value->estado ?>" id="btn-<?php echo base64url_encode($value->id) ?>">
              <i class="fas fa-search"></i>
            </button>
            
          </div>
          <div class="col-2 col-md-4 td text-center">
            <button type="button" class="btn btn-danger btn-sm btn_deleteinsc" data-id="<?php echo base64url_encode($value->id) ?>">
              <i class="fas fa-trash"></i>
            </button>
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
          url: base_url + 'prematricula/fn_eliminar',
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