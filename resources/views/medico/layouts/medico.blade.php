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
				<a class="navbar-brand" href="{{ route('Principal.index') }}">Bienestar</a>
			</div>
			<div class="navbar-header navbar-right">
				<a class="navbar-brand" href="{{ route('Login.index') }}">Salir</a>
			</div>
		</div>
	</nav>

	<div class="container">
	    <div class="row">
	        <div class="col-md-3">
	            <ul class="nav nav-pills nav-stacked">
	               <li><a href="{{ route('Principal.index') }}">Inicio</a></li>
	               <li><a href="{{ route('Agenda.index') }}">Agenda</a></li>
	               <li><a href="{{ route('Eventos.index') }}">Listado de Eventos</a></li>
	            </ul>
	        </div>

	        <div class="col-md-9">
	            <div class="panel panel-default">
	              	<div class="panel-heading" align="center">
	              		@if($user['sexo'] == 'M')
	              			<h3>Bienvenido Dr. {{ $user['nombre'].' '.$user['apellido'] }}</h3>
	              		@else
							<h3>Bienvenida Dra. {{ $user['nombre'].' '.$user['apellido'] }}</h3>
	              		@endif
	              	</div>
	              	<div class="panel-body">
						@yield('contenido')
					</div>
				</div>
			</div>
	    </div>
	</div>

</body>
</html>