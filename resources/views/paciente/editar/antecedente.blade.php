@extends('paciente.layouts.paciente')

@section('contenido')

@include('errors/errores')

<div align="center">
	<h3>Editar Antecedente</h3>
</div>
{!! Form::model($antecedente,['route' => ['Historial.update', $antecedente->id_antecedente, 'cedula' => $antecedente->cedula], 'method' => 'PUT', 'files' => true]) !!}

@include('formularios/antecedente')

<div class="form-group" align="center">
	<button type="submit" class="btn btn-success">Actualizar</button>
	<a href="{{ route('Historial.index') }} " class="btn btn-default">Cancelar</a>
</div>

{!! Form::close() !!}

@include('paciente/eliminar/antecedente')

@stop