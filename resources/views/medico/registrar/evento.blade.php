@extends('medico.layouts.medico')

@section('contenido')

@include('errors/errores')

<div align="center">
	<h3>Registrar Evento</h3>
</div>

{!! Form::open(['route' => 'Eventos.store', 'method' => 'POST']) !!}
					  
@include('formularios/evento')

<div class="form-group" align="center">
	<button type="submit" class="btn btn-success">Registrar</button>
	<a href="{{ route('Eventos.index') }} " class="btn btn-default">Cancelar</a>
</div>

{!! Form::close() !!}

@stop