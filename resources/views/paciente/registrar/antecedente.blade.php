@extends('paciente.layouts.paciente')

@section('contenido')

@include('errors/errores')

<div align="center">
	<h3>Registrar Antecedente</h3>
</div>

{!! Form::open(['route' => 'Historial.store', 'method' => 'POST']) !!}
					  
@include('formularios/antecedente')

<div class="form-group" align="center">
	<button type="submit" class="btn btn-success">Registrar</button>
	<a href="{{ route('Historial.index') }} " class="btn btn-default">Cancelar</a>
</div>

{!! Form::close() !!}

@stop