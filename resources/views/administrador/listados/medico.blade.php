@extends('administrador.layouts.administrador')

@section('contenido')

@if(Session::has('message'))
				
	<p class="alert alert-success">{{ Session::get('message') }}</p>

@endif

<div align="center">
	<h3>Listado de Medicos</h3>
</div>

{!! Form::open(['route' => 'Medicos.index', 'method' => 'GET', 'class' => 'navbar-form navbar-left pull-right', 'role' => 'search']) !!}
  <div class="form-group">
    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre...']) !!}
  </div>
  <button type="submit" class="btn btn-default">Buscar</button>
{!! Form::close() !!}

<a class="btn btn-primary" href="{{ route('Medicos.create') }}" role="button">Registrar Medico</a>

<table class="table table-striped">
	<tr>
		<th>Cedula</th>
		<th>Nombre</th>
		<th>Especialidad</th>
		<th>Accion</th>
	</tr>
	@foreach($medicos as $medico)

	<tr>
		<td>{{ $medico->cedula }}</td>
	    <td>{{ $medico->nombre.' '.$medico->apellido }}</td>
	    <td>{{ $medico->especialidad }}</td>
	    <td><a href="{{ route('Medicos.edit', $medico->cedula) }}"> Editar </a></td>
	</tr>

	@endforeach
</table>
{!! $medicos->render() !!}

@stop