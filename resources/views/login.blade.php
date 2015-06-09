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
			<div class="navbar-header navbar-right">
				<a class="navbar-brand" href="{{ route('Registrar.index') }}">Registrarse</a>
			</div>
		</div>
	</nav>


<div id="header" align="center">
	{!! Html::image('images/esquema.jpg','alt',['width'=>'500','height'=>'210']) !!}
	<br>
	<br>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				@include('errors/errores')

				@if(Session::has('message'))
				
					<p class="alert alert-success">{{ Session::get('message') }}</p>

				@endif

				<div align="center" id="contenido" class="panel-body">
					{!! Form::open(['route' => 'Login.store', 'method' => 'POST']) !!}
					<div class="form-group">
					    <h4>Login</h4>
					    {!! Form::text('login', null, ['class' => 'form-control', 'placeholder' => 'Login...']) !!}
					</div>
				    <div class="form-group">
					    <h4>Password</h4>
					    {!! Form::password('clave', ['class' => 'form-control', 'placeholder' => 'Password...']) !!}
				    </div>
				    <div class="form-group" align="center">
					  	<button type="submit" class="btn btn-primary">Ingresar</button>
					</div>
				    {!! Form::close() !!}

				    <a href="{{ route('Login.edit') }}">¿Has olvidado tu password?</a>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>