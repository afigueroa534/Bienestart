@extends('administrador.layouts.administrador')

@section('contenido')

@include('errors/errores')

<div align="center">
	<h3>Editar Medico: {{ $medico->nombre.' '.$medico->apellido }}</h3>
</div>
{!! Form::model($medico,['route' => ['Medicos.update', $medico->cedula], 'method' => 'PUT', 'files' => true]) !!}

@include('formularios/medico')

<div class="form-group" align="center">
	<button type="submit" class="btn btn-success">Actualizar</button>
	<a href="{{ route('Medicos.index') }} " class="btn btn-default">Cancelar</a>
</div>

{!! Form::close() !!}

@include('administrador/eliminar/medico')

@stop