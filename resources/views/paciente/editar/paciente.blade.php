@extends('paciente.layouts.paciente')

@section('contenido')

@include('errors/errores')

<div align="center">
	<h3>Editar Datos</h3>
</div>
{!! Form::model($paciente,['route' => ['Principal.update', $paciente->cedula], 'method' => 'PUT', 'files' => true]) !!}

@include('formularios/paciente')

<div class="form-group" align="center">
	<button type="submit" class="btn btn-success">Actualizar</button>
	<a href="{{ route('Principal.index') }} " class="btn btn-default">Cancelar</a>
</div>

{!! Form::close() !!}

@stop