@extends('medico.layouts.medico')

@section('contenido')

@include('errors/errores')

<div align="center">
	<h3>Editar Evento: {{ $evento->descripcion }}</h3>
</div>
{!! Form::model($evento,['route' => ['Eventos.update', $evento->id_evento, 'cedula' => $evento->cedula], 'method' => 'PUT']) !!}

@include('formularios/evento')

<div class="form-group" align="center">
	<button type="submit" class="btn btn-success">Actualizar</button>
	<a href="{{ route('Eventos.index') }} " class="btn btn-default">Cancelar</a>
</div>

{!! Form::close() !!}

@include('medico/eliminar/evento')

@stop