function fn_combo_ubigeo(combo){
	if (combo.data('tubigeo') == "departamento") {
		var nmprov=combo.data('cbprovincia');
		var nmdist=combo.data('cbdistrito');
		var nmdiv=combo.data('dvcarga');
		$('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#' + nmprov).html("<option value='0'>Sin opciones</option>");
        $('#' + nmdist).html("<option value='0'>Sin opciones</option>");
        var coddepa = combo.val();
        if (coddepa == '0') return;
        $.ajax({
            url: base_url + 'ubigeo/fn_provincia_x_departamento',
            type: 'post',
            dataType: 'json',
            data: {
                txtcoddepa: coddepa
            },
            success: function(e) {
            	$('#' + nmdiv + ' #divoverlay').remove();
                $('#' + nmprov).html(e.vdata);
            },
            error: function(jqXHR, exception) {
            	$('#' + nmdiv + ' #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#' + nmprov).html("<option value='0'>" + msgf + "</option>");
            }
        });
    } 
    else if (combo.data('tubigeo') == "provincia") {
		var nmdist=combo.data('cbdistrito');
		var nmdiv=combo.data('dvcarga');
		$('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#' + nmdist).html("<option value='0'>Sin opciones</option>");
        var codprov = combo.val();
        if (codprov == '0') return;
        $.ajax({
            url: base_url + 'ubigeo/fn_distrito_x_provincia',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodprov: codprov
            },
            success: function(e) {
                $('#' + nmdiv + ' #divoverlay').remove();
                $('#' + nmdist).html(e.vdata);
            },
            error: function(jqXHR, exception) {
            	$('#' + nmdiv + ' #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#frmins-personales #ficbdistrito').html("<option value='0'>" + msgf + "</option>");
            }
        });
    }
    return false;
}