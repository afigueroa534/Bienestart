@extends('paciente.layouts.paciente')

@section('contenido')

@if(Session::has('message'))
				
	<p class="alert alert-success">{{ Session::get('message') }}</p>

@endif

<div align="center">
	<h3>Historial de Antecedentes y Enfermedades</h3>
</div>

<a class="btn btn-primary" href="{{ route('Historial.create') }}" role="button">Registrar Antecedente</a>
<br><br>

<table class="table table-striped">
	<tr>
		<th>Edad</th>
		<th>Descripcion</th>
		<th>Accion</th>
	</tr>
	@foreach($antecedentes as $antecedente)

	<tr>
		<td>{{ $antecedente->edad }}</td>
	    <td>{{ $antecedente->descripcion }}</td>

	    <td><a href="{{ route('Historial.edit', ['id_antecedente' => $antecedente->id_antecedente]) }}"> Editar </a></td>
	</tr>

	@endforeach
</table>
{!! $antecedentes->render() !!}

@stop