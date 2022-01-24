<div class="modal fade" id="modviewnotas" tabindex="-1" role="dialog" aria-labelledby="modviewnotas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="divmodaladd">
      <div class="modal-header">
        <h5 class="modal-title">Notas grupo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small id="fmt-conteo" class="form-text text-primary">
        
        </small>
        <div class="btable" id="div_filtro_head">
          <div class="thead col-12  d-none d-md-block">
            <div class="row">
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-3 td small text-bold">NRO</div>
                  <div class="col-md-9 td small text-bold">CARNÉ.</div>
                </div>
              </div>
              <div class="col-md-5 td small text-bold">ALUMNO</div>
              <div class="col-md-1 td small text-bold">NOTA FIN</div>
              <div class="col-md-1 td small text-bold">NOTA REC.</div>
              <div class="col-md-2 td small text-bold"></div>
            </div>
          </div>
          <div id="div_filtro_alumno" class="tbody col-12">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <?php if (getPermitido("128")=='SI'){ ?>
        <button type="button" id="vw_mpc_btn_subirnotas" class="btn btn-primary">Subir Notas</button>
        <?php } ?>
      </div>
    </div>
  </div>
</div>