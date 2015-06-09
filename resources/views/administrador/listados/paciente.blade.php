@extends('administrador.layouts.administrador')

@section('contenido')

@if(Session::has('message'))
				
	<p class="alert alert-success">{{ Session::get('message') }}</p>

@endif
	
	<div align="center">
		<h3>Listado de Pacientes</h3>
	</div>

	<a class="btn btn-primary navbar-left" href="{{ route('Pacientes.create') }}" role="button">Registrar Paciente</a>

	{!! Form::open(['route' => 'Pacientes.index', 'method' => 'GET', 'class' => 'navbar-form navbar-left pull-right', 'role' => 'search']) !!}
	  <div class="form-group">
	    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre...']) !!}
	  </div>
	  <button type="submit" class="btn btn-default">Buscar</button>
	{!! Form::close() !!}

	<table class="table table-striped">
  		<tr>
  			<th>Cedula</th>
  			<th>Nombre</th>
  			<th>Direccion</th>
  			<th>Accion</th>
  		</tr>
  		@foreach($pacientes as $paciente)

  		<tr>
  			<td>{{ $paciente->cedula }}</td>
  		    <td>{{ $paciente->nombre.' '.$paciente->apellido }}</td>
  		    <td>{{ $paciente->direccion }}</td>
  		    <td><a href="{{ route('Pacientes.edit', $paciente->cedula) }}"> Editar </a></td>
  		</tr>

  		@endforeach
	</table>
	{!! $pacientes->render() !!}

@stop