@extends('medico.layouts.medico')

@section('contenido')

@if(Session::has('message'))
				
	<p class="alert alert-success">{{ Session::get('message') }}</p>

@endif

<div align="center">
	{!! Html::image('imagen_usuario/'.$medico->imagen,'alt',['width'=>'250','height'=>'210', 'class' => 'img-circle']) !!}
</div>

<div class="row">
  <div class="col-xs-6">
  	<blockquote>
  		<p><strong>Nombre:</strong> {{ $medico->nombre.' '.$medico->apellido }}</p>
  		<p><strong>Cedula:</strong> {{ $medico->cedula }}</p>
		<p><strong>Fecha de Nacimiento:</strong> {{ $medico->fecha_nac }}</p>
  		@if($medico->sexo == 'M')
  			<p><strong>Sexo:</strong> Masculino</p>
  		@else
  			<p><strong>Sexo:</strong> Femenino</p>
  		@endif
	</blockquote>
  </div>
  <div class="col-xs-6">
  	<blockquote class="blockquote-reverse">
  		<p><strong>Especialidad:</strong> {{ $medico->especialidad }}</p>
  		<p><strong>Direccion:</strong> {{ $medico->direccion }}</p>
		<p><strong>Email:</strong> {{ $medico->email }} </p>
		<p><strong>Telefono:</strong> {{ $medico->telefono }} </p>
	</blockquote>
  </div>
</div>

<div align="center">
	<td><a href="{{ route('Principal.edit') }}" class="btn btn-primary">Actualizar Datos</a></td>
</div>


@stop