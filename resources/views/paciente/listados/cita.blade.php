@extends('paciente.layouts.paciente')

@section('contenido')

@if(Session::has('message'))
				
	<p class="alert alert-success">{{ Session::get('message') }}</p>

@endif

<div align="center">
	<h3>Listado de Citas</h3>
</div>

<a class="btn btn-primary" href="{{ route('Citas.create') }}" role="button">Registrar Cita</a>
<br><br>

<table class="table table-striped">
	<tr>
		<th>Fecha y Hora</th>
		<th>Medico</th>
		<th>Estado</th>
		<th>Accion</th>
	</tr>
	@foreach($citas as $cita)

	<tr>
		<td>{{ $cita->fecha.'  -  '.date('g:i a',strtotime($cita->hora)) }}</td>
	    <td>{{ $cita->nombre.' '.$cita->apellido.' ('.$cita->especialidad.')' }}</td>
	    @if($cita->estado == 'P')
	    	<td>Pendiente</td>
	    @endif
	    @if($cita->estado == 'C')
	    	<td>Cancelada</td>
	    @endif
	    @if($cita->estado == 'R')
	    	<td>Realizada</td>
	    @endif
		
		@if($cita->estado == 'P')
	    	<td><a href="{{ route('Citas.edit', ['fecha' => $cita->fecha,'hora' => $cita->hora]) }}" onclick="return confirm('¿Esta seguro de cancelar la Cita?')"> Cancelar Cita </a></td>
	    @else
	    	<td>Sin Accion</td>
	    @endif
	</tr>

	@endforeach
</table>
{!! $citas->render() !!}

@stop