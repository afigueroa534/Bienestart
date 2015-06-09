<!DOCTYPE html>
<html lang="es">
<head>
	<title>Bienestart</title>
	<link href="{{{ asset('images/icono.jpg') }}}" rel="shortcut icon" type="image/png">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="{{ route('Login.index') }}">Bienestar</a>
			</div>
		</div>
	</nav>

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				@include('errors/errores')

				<div align="center">
					<h3>Registrese</h3>
				</div>
				
				<div class="panel-body">
					{!! Form::open(['route' => 'Registrar.store', 'method' => 'POST', 'files' => true]) !!}
	  

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

						@include('formularios/paciente')

					  	<div class="form-group" align="center">
					  		<button type="submit" class="btn btn-success">Registrar</button>
					  		<a href="{{ route('Login.index') }} " class="btn btn-default">Cancelar</a>
					  	</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>



</body>
</html>