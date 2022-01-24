<?php
	$vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/fullcalendar/main.min.css">

<style type="text/css">
	/*.fc-daygrid-body .fc-day:hover .fc-daygrid-day-number {
	    background-color: #B8B8B8;
	    border-radius: 50%;
	    color: #FFFFFF;
	    transition: background-color 0.2s;
	}*/
	.fc .fc-button:hover, .fc .fc-list-event-title a, a.fc-event, a.fc-event:hover {
		color: #000;
	}
</style>
<div class="content-wrapper">

	<div class="modal fade" id="modevento" tabindex="-1" role="dialog" aria-labelledby="modevento" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="title_evento">DETALLE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                	<div class="row">
                		<div class="col-12"><b id="div_descripcion"></b></div>
                		<div class="col-12"><b>Unidad didáctica: </b> <span id="div_unidad"></span></div>
                	</div>
                	<hr>
                	<div class="row">
                		<div class="col-3 col-md-2" id="divtext_inicia">
                			
                		</div>
                		<div class="col-9 col-md-10" id="div_inicia">
                			
                		</div>
                	</div>
                	<div class="row">
                		<div class="col-3 col-md-2" id="divtext_finaliza">
                			
                		</div>
                		<div class="col-9 col-md-10" id="div_finaliza">
                			
                		</div>
                	</div>
                	<hr>
                    <div id="div_url"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <!-- <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button> -->
                </div>
            </div>
        </div>
    </div>

	<section id="s-cargado" class="content pt-2">
		<div id="divcard_calendar" class="card infocalendar">
		    <div class="card-body pt-0">
		    	<div class="row">
		    		<div class="col-12">
		    			<div id="calendar"></div>
		    		</div>
		    	</div>
		    	
		    </div>
		</div>
	</section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/fullcalendar/main.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/moment/moment.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/moment/locale/es.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/moment/timezone.js"></script>
<script src='<?php echo $vbaseurl ?>resources/plugins/fullcalendar/locales/es.js'></script>

<script>
	/*=============================================
	CALENDARIO
	=============================================*/
	document.addEventListener('DOMContentLoaded', function() {

		var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
        	locale: 'es',
        	// height: 'auto',
        	// timeZone: 'UTC',
          	// plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
	      	headerToolbar    : {
	        	left  : 'prev,next today',
	        	center: 'title',
	        	right : 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
	      	},
	      	themeSystem: 'bootstrap',
      		dayMaxEvents: true,
      		editable  : false,
      		navLinks: true,
    		// weekNumbers: true,
    			selectable: true,
      		events: {
      			url: base_url + "calendario/listar_recursos",
		      	extraParams: function() {
			      	return {
			        	cachebuster: new Date().valueOf()
			      	};
			    	}
					},
					
			     loading: function( isLoading, view ) {
            if(isLoading) {// isLoading gives boolean value
                 $("#divcard_calendar").append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><h3>Cargando...</h3><br><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            } else {
                 $("#divcard_calendar").find('#divoverlay').remove();
            }
        	},
		    	eventClick: function(info){
			    	var eventObj = info.event;
			    	// console.log(info);
			    	var tiporec = info.event.extendedProps.tipo;
			    	$('#title_evento').html(tiporec + " ("+moment(info.event.extendedProps.inicia).tz('America/Lima').format('L')+")");
			    	// fechahorastart = moment(eventObj.start).tz('America/Lima').format('llll');
			    	fechahorastart = moment(info.event.extendedProps.inicia).tz('America/Lima').format('ddd D [de] MMM [de] YYYY, hh:mm a');
			    	// fechahoraend = moment(eventObj.end).tz('America/Lima').format('llll');
			    	fechahoraend = moment(info.event.extendedProps.culmina).tz('America/Lima').format('ddd D [de] MMM [de] YYYY, hh:mm a');

			    	$('#div_descripcion').html(info.event.extendedProps.description);
			    	$('#div_unidad').html(info.event.extendedProps.unidad)
			    	$('#divtext_inicia').html("<i class='fas fa-calendar-alt'></i><b> Inicia: </b>");
			    	$('#div_inicia').html(fechahorastart);
			    	if (info.event.extendedProps.culmina != null) {
			    		$('#divtext_finaliza').html("<i class='fas fa-calendar-alt'></i><b> Vence: </b>");
			    		$('#div_finaliza').html(fechahoraend);
			    	} else {
			    		$('#divtext_finaliza').html("");
			    		$('#div_finaliza').html("");
			    	}
			    	
			    	if (eventObj.url) {
			    		var dataopt = '';
			    		var classsesion = '';
			    		if (tiporec == "SESIÓN") {
			    			var dataopt = info.event.extendedProps.sesdata;
			    			var classsesion = 'btn_ses_asist';
			    		}
			    		$('#div_url').html('<a href="'+eventObj.url+'" target="_blank" class="'+classsesion+'" '+dataopt+'><b class="text-dark"><i class="far fa-hand-point-right"></i> Enlace a:</b> '+eventObj.title+'</a>');
			    		// window.open(eventObj.url);
			    		info.jsEvent.preventDefault();
			    	} else {
			    		$('#div_url').html('');
			    	}

			    	
			    	$('#modevento').modal();
			    },
		    eventContent: function(arg) {
		    	var icono = document.createElement('div');
		    	var vista = arg.view.type;
		    	icono.className = "fc-event-title fc-sticky";
		    	if ((arg.event.extendedProps.tipo=="TAREA") && (arg.event.extendedProps.modo=="vence")){
						var horaini = moment(arg.event.extendedProps.culmina).tz('America/Lima').format('hh:mm a');
		    	}
		    	else{
						var horaini = moment(arg.event.start).tz('America/Lima').format('hh:mm a');
		    	}
		    	

		    	

		    	var iconoimg = arg.event.extendedProps.icono;
		    	if ((vista == "listMonth") && (arg.event.url != "")) {
		    		icono.innerHTML  = "<a href='"+arg.event.url+"'>"+iconoimg+ ""+horaini +" "+arg.event.title+"</a>";
		    	} else {
		    		icono.innerHTML  = iconoimg+ ""+horaini +" "+arg.event.title;
		    	}
		    	
		    	var arraynodes = [icono];
		    	return {domNodes : arraynodes}
		    }
		    // dateClick: function(info) {
		    //   	alert('clicked ' + info.dateStr);
		    // },
		    // select: function(info) {
		    //   	alert('selected ' + info.startStr + ' to ' + info.endStr);
		    // }
        });
        calendar.render();

	})

	$(document).on("click", ".btn_ses_asist", function(e) {
      e.preventDefault();
      var btn = $(this);
      var enlace = btn.attr('href');
      div = $('#divmodaladd');
      var sesion = btn.data('sesion');
      var carga = btn.data('carga');
      var division = btn.data('division');
      var unidad = btn.data('unidad');

      div.append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
        url: base_url + 'sesion/fn_curso_sesiones_asistencias'  ,
        type: 'post',
        dataType: 'json',
        data: {
          sesion: sesion,
          carga: carga,
          division: division,
          unidad: unidad
        },
        success: function(e) {
          div.find('#divoverlay').remove();
          if (e.status == false) {
            Swal.fire({
                        title: "Error!",
                        text: "existen errores",
                        type: 'error',
                        icon: 'error',
                    })
          }
          else {
            window.open(enlace);
            $('#modevento').modal('hide');
          }
        },
        error: function (jqXHR, exception) {
          var msgf=errorAjax(jqXHR, exception,'div');
          div.find('#divoverlay').remove();
          Swal.fire('Error!',msgf,'error')
        },
      });
      return false;
    });

	
</script>