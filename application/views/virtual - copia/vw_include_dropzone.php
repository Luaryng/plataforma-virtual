<div class="col-12">
    <span class="fileupload-process" style="display: none">
        <div id="total-progress" class="progress " role="progressbar">
            <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress>
            </div>
        </div>
    </span>
    <span class="dropzone-here">
        <?php echo
        "Tamaño máximo de archivos: {$getmaxsize}MB <br>
        Número máximo de archivos: {$getmaxcount}"; ?>
    </span>
    <div class="row m-0" id="previews">
        <div id="template" class="col-6 col-sm-4 col-md-2 px-2 mt-2" >
            <div  class="row">
                <div class="col-12 mx-auto preview text-center">
                    <img data-dz-thumbnail />
                    <a class="text-primary start" style="display: none">
                        <i class="fas fa-upload"></i>
                        <span>Empezar</span>
                    </a>
                    <a data-dz-remove class="text-warning cancel">
                        <i class="fas fa-ban"></i>
                        <span>Cancelar</span>
                    </a>
                    <a data-dz-remove class=" text-danger delete">
                        <i class="fas fa-trash"></i>
                        <span>Eliminar</span>
                    </a>
                    <div class="progress">
                        <div class="progress-bar pb-private progress-bar-striped bg-info" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress>
                        </div>
                    </div>
                    <div>
                        <strong class="error text-danger" data-dz-errormessage></strong>
                    </div>
                    <p class="size m-0" data-dz-size></p>
                    <p class="name m-0" data-dz-name></p>
                </div>
            </div>
            
        </div>
        
    </div>
    <span class="dropzone-here">Puedes arrastrar y soltar aquí tus archivos, tambien puedes presionar sobre la nube para añadirlos
    </span>
</div>