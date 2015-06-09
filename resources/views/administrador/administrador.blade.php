@extends('administrador.layouts.administrador')

@section('contenido')

@if(Session::has('message'))
				
	<p class="alert alert-success">{{ Session::get('message') }}</p>

@endif

<div align="center">
	{!! Html::image('imagen_usuario/'.$administrador->imagen,'alt',['width'=>'250','height'=>'210', 'class' => 'img-circle']) !!}
</div>

<div class="row">
  <div class="col-xs-6">
  	<blockquote>
  		<p><strong>Nombre:</strong> {{ $administrador->nombre.' '.$administrador->apellido }}</p>
  		<p><strong>Cedula:</strong> {{ $administrador->cedula }}</p>
		<p><strong>Fecha de Nacimiento:</strong> {{ $administrador->fecha_nac }}</p>
  		@if($administrador->sexo == 'M')
  			<p><strong>Sexo:</strong> Masculino</p>
  		@else
  			<p><strong>Sexo:</strong> Femenino</p>
  		@endif
	</blockquote>
  </div>
  <div class="col-xs-6">
  	<blockquote class="blockquote-reverse">
  		<p><strong>Direccion:</strong> {{ $administrador->direccion }}</p>
		<p><strong>Email:</strong> {{ $administrador->email }} </p>
		<p><strong>Telefono:</strong> {{ $administrador->telefono }} </p>
	</blockquote>
  </div>
</div>

@stop