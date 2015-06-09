@extends('medico.layouts.medico')

@section('contenido')

@if(Session::has('message'))
				
	<p class="alert alert-success">{{ Session::get('message') }}</p>

@endif

<div align="center">
	<h3>Agenda</h3>
</div>
@if(date_default_timezone_set('America/Caracas'))
@endif
<table class="table table-striped">
	<tr>
		<th>Fecha</th>
		<th>Hora</th>
		<th>Paciente</th>
		<th>Accion</th>
	</tr>
	@foreach($citas as $cita)

	<tr>
		@if($cita->fecha == date('Y-m-d'))
			<td>Hoy</td>
		@else
			@if($cita->fecha == date('Y-m-d',strtotime(date('Y-m-d') . "+1 days")))
				<td>Mañana</td>
			@else
				<td>{{ date("d-m-Y", strtotime($cita->fecha)) }}</td>
			@endif
		@endif
	    <td>{{ date('g:i a',strtotime($cita->hora)) }}</td>
	    <td>{{ $cita->nombre.' '.$cita->apellido }}</td>
		
		@if($cita->fecha == date('Y-m-d'))
	    	<td><a href="{{ route('Consulta.index', ['cedula_paciente' => $cita->cedula_paciente, 'fecha' => $cita->fecha, 'hora' => $cita->hora]) }}"> Iniciar Consulta </a></td>
	    @else
			<td>Pendiente</td>
		@endif
	</tr>

	@endforeach
</table>
{!! $citas->render() !!}

@stop