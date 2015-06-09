@extends('paciente.layouts.paciente')

@section('contenido')

@if(Session::has('message'))
				
	<p class="alert alert-success">{{ Session::get('message') }}</p>

@endif

<div align="center">
	{!! Html::image('imagen_usuario/'.$paciente->imagen,'alt',['width'=>'250','height'=>'210', 'class' => 'img-circle']) !!}
</div>

<div class="row">
  <div class="col-xs-6">
  	<blockquote>
  		<p><strong>Nombre:</strong> {{ $paciente->nombre.' '.$paciente->apellido }}</p>
  		<p><strong>Cedula:</strong> {{ $paciente->cedula }}</p>
		<p><strong>Fecha de Nacimiento:</strong> {{ $paciente->fecha_nac }}</p>
  		@if($paciente->sexo == 'M')
  			<p><strong>Sexo:</strong> Masculino</p>
  		@else
  			<p><strong>Sexo:</strong> Femenino</p>
  		@endif
	</blockquote>
  </div>
  <div class="col-xs-6">
  	<blockquote class="blockquote-reverse">
  		<p><strong>Direccion:</strong> {{ $paciente->direccion }}</p>
		<p><strong>Email:</strong> {{ $paciente->email }} </p>
		<p><strong>Telefono:</strong> {{ $paciente->telefono }} </p>
	</blockquote>
  </div>
</div>

<div align="center">
	<td><a href="{{ route('Principal.edit') }}" class="btn btn-primary">Actualizar Datos</a></td>
</div>

@stop