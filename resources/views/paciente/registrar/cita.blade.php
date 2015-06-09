@extends('paciente.layouts.paciente')

@section('contenido')

@include('errors/errores')

<div align="center">
	<h3>Reserva de Cita</h3>
</div>

{!! Form::open(['route' => 'Citas.store', 'method' => 'POST']) !!}
					  
@include('formularios/cita')

<div class="form-group" align="center">
	<button type="submit" class="btn btn-success">Registrar</button>
	<a href="{{ route('Citas.index') }} " class="btn btn-default">Cancelar</a>
</div>

{!! Form::close() !!}


<script type="text/javascript">
	
	$(document).ready(inicializarEventos);
	var celda_anterior = null;

	function inicializarEventos()
	{
		$("#cargando").hide(); 
		$('#radio8').hide();
		$('#radio9').hide();
		$('#radio10').hide();
		$('#radio2').hide();
		$('#radio3').hide();
		$('#radio4').hide();
		$('[name="especialidad"]').change(envioEspecialidad);
		$('[name="medico"]').change(envioMedico);

	}

	function envioEspecialidad()
	{
		$("#cargando").show();
		var especialidad = $('[name="especialidad"]').val();
		if(especialidad != 'Seleccione...'){
			var opcion = 1;
	  		$.getJSON("Citas.show",{opcion:opcion,especialidad:especialidad},llegadaDatosEspecialidad); 
	  	}
	  	else
	  	{
	  		$('[name="medico"]').empty();
			$('[name="medico"]').append($('<option>', {
			    value: 'Seleccione...',
			    text: 'Seleccione...'
			}));
	  		$('#calendar').fullCalendar( 'destroy' );
	  		$("#cargando").hide(); 
			$('#radio8').hide();
			$('#radio9').hide();
			$('#radio10').hide();
			$('#radio2').hide();
			$('#radio3').hide();
			$('#radio4').hide();
	  	}
	  	return false;
	}

	function envioMedico()
	{
		$("#cargando").show();
		var cedula = $('[name="medico"]').val();
		if(cedula != 'Seleccione...'){
			var opcion = 2;
	  		$.getJSON("Citas.show",{opcion:opcion,cedula:cedula},llegadaDatosMedico); 
	  	}
	  	else
	  	{
	  		$('#calendar').fullCalendar( 'destroy' );
	  		$("#cargando").hide(); 
			$('#radio8').hide();
			$('#radio9').hide();
			$('#radio10').hide();
			$('#radio2').hide();
			$('#radio3').hide();
			$('#radio4').hide();
	  	}
	  	return false;
	}

	function llegadaDatosEspecialidad(datos)
	{
		$('[name="medico"]').empty();
		$('[name="medico"]').append($('<option>', {
			    value: 'Seleccione...',
			    text: 'Seleccione...'
			}));
		$('#calendar').fullCalendar( 'destroy' );
		for (var i = 0; i < datos.msg.length; i++) {
			$('[name="medico"]').append($('<option>', {
			    value: datos.msg[i].cedula,
			    text: datos.msg[i].nombre+' '+datos.msg[i].apellido
			}));
		};
		$("#cargando").hide();  
	}

	function llegadaDatosMedico(datos)
	{
		$('#calendar').fullCalendar( 'destroy' );
		$('#calendar').fullCalendar({
	        	weekends: false, 
	        	height: 350,
	        	lang: 'es',
	        	dayClick: function(date, jsEvent, view) {

	        		if('rgb(128, 128, 128)' == $(this).css('background-color'))
	        		{
	        			alert('Lo sentimos esa fecha no esta disponible');
	        			$('#radio8').hide();
						$('#radio9').hide();
						$('#radio10').hide();
						$('#radio2').hide();
						$('#radio3').hide();
						$('#radio4').hide();
						$(celda_anterior).css('background-color', 'white');
	        		}
	        		else
	        		{
	        			if(celda_anterior != null)
	        			{
	        				$(celda_anterior).css('background-color', 'white');
	        			}
	        			celda_anterior = this;
	        			$(this).css('background-color', 'yellow');
	        			$('[name="fecha"]').val(date.format());


	        			$('#radio8').show();
	        			$('#radio9').show();
	        			$('#radio10').show();
	        			$('#radio2').show();
	        			$('#radio3').show();
	        			$('#radio4').show();
	        			for (i = 0; i < datos.citas.length; i++) {
	        				var fecha = new Date(datos.citas[i].fecha);
	        				if(date >= fecha && date <= fecha){
	        					switch(datos.citas[i].hora)
	        					{
	        						case '08:00:00': $('#radio8').hide(); break;
	        						case '09:00:00': $('#radio9').hide(); break;
	        						case '10:00:00': $('#radio10').hide(); break;
	        						case '14:00:00': $('#radio2').hide(); break;
	        						case '15:00:00': $('#radio3').hide(); break;
	        						case '16:00:00': $('#radio4').hide(); break;
	        					}
							}
						}

	        		}

			    },
			    viewRender: function(view,element) {
		            var now = new Date();
		            var end = new Date();
		            end.setMonth(now.getMonth() + 2); 

		            if ( end < view.end) {
		                $("#calendar .fc-next-button").hide();
		            }
		            else {
		                $("#calendar .fc-next-button").show();
		            }

		            if ( view.start < now) {
		                $("#calendar .fc-prev-button").hide();
		                return false;
		            }
		            else {
		                $("#calendar .fc-prev-button").show();
		            }
		        },
		        dayRender: function(date, cell){
		        	var now = new Date();
		        	if(date <= now)
		        	{
		        		$(cell).css('background-color', 'grey');
		        	}
		        	for (var i = 0; i < datos.eventos.length; i++) {
		        		var fecha_inicio = new Date(datos.eventos[i].fecha_inicio);
		        		var fecha_final = new Date(datos.eventos[i].fecha_final);
		        		if(date >= fecha_inicio && date <= fecha_final)
		        		{
		        			$(cell).css('background-color', 'grey');
		        		}	
		        	}
		        	var fecha_anterior = "";
		        	var cont = 0;
		        	for (var i = 0; i < datos.citas.length; i++) {
		        		var fecha = new Date(datos.citas[i].fecha);
		        		if(date >= fecha && date <= fecha)
		        		{
			        		cont++;
		        		}
		        		else
		        		{
		        			cont = 0;
		        		}
		        		if(cont == 6)
		        		{
		        			$(cell).css('background-color', 'grey');
		        		}
		        	}
			    }

			});  
		$("#cargando").hide();
	}
	
</script>

@stop
