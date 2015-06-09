@extends('administrador.layouts.administrador')

@section('contenido')

@include('errors/errores')

<div align="center">
	<h3>Editar Paciente: {{ $paciente->nombre.' '.$paciente->apellido }}</h3><br>
</div>

{!! Form::model($paciente,['route' => ['Pacientes.update', $paciente->cedula], 'method' => 'PUT', 'files' => true]) !!}

	@include('formularios/paciente')

	<div class="form-group" align="center">
  		<button type="submit" class="btn btn-success">Actualizar</button>
  		<a href="{{ route('Pacientes.index') }} " class="btn btn-default">Cancelar</a>
	</div>

{!! Form::close() !!}

@include('administrador/eliminar/paciente')

@stop