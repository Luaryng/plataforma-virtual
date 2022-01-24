 <iframe id = "logoutframe" src = " https://accounts.google.com/logout " style = "display: none"> </iframe>
 <h4>Cerrando sesión, espera un momento</h4>
 <script>
    function redireccionarPagina() {
        var pg='<?php echo base_url() ?>';
        window.location = pg;
    }
    setTimeout("redireccionarPagina()", 1000);
 </script>