@extends('medico.layouts.medico')

@section('contenido')

@if(Session::has('message'))
				
	<p class="alert alert-success">{{ Session::get('message') }}</p>

@endif

<div align="center">
	<h3>Listado de Eventos</h3>
</div>

<a class="btn btn-primary" href="{{ route('Eventos.create') }}" role="button">Registrar Evento</a>
<br><br>

<table class="table table-striped">
	<tr>
		<th>Descripcion</th>
		<th>Fecha de Inicio</th>
		<th>Fecha de Finalizacion</th>
		<th>Accion</th>
	</tr>
	@foreach($eventos as $evento)

	<tr>
		<td>{{ $evento->descripcion }}</td>
	    <td>{{ $evento->fecha_inicio }}</td>
	    <td>{{ $evento->fecha_final }}</td>

	    <td><a href="{{ route('Eventos.edit', ['id_evento' => $evento->id_evento]) }}"> Editar </a></td>
	</tr>

	@endforeach
</table>
{!! $eventos->render() !!}

@stop