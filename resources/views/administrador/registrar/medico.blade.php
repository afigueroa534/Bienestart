@extends('administrador.layouts.administrador')

@section('contenido')

@include('errors/errores')

<div align="center">
	<h3>Registrar Medico</h3>
</div>

{!! Form::open(['route' => 'Medicos.store', 'method' => 'POST','files' => true]) !!}

<div class="form-group">
    <h4>Cedula</h4>
    <div class="row">
      <div class="col-xs-6 col-md-4">
        {!! Form::select('vcedula', array('V' => 'V', 'E' => 'E'), null, array('class'=>'form-control col-md-1','style'=>'' )) !!}
      </div>
      <div class="col-xs-12 col-md-8">
        {!! Form::text('cedula', null, ['class' => 'form-control', 'placeholder' => 'Cedula...']) !!}
      </div>
    </div>
  </div>
					  
@include('formularios/medico')

<div class="form-group" align="center">
	<button type="submit" class="btn btn-success">Registrar</button>
	<a href="{{ route('Medicos.index') }} " class="btn btn-default">Cancelar</a>
</div>

{!! Form::close() !!}

@stop