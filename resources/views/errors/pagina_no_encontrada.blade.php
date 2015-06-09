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
		</div>
	</nav>

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				<div align="center" id="contenido" class="panel-body">
					
					<h2>Aquí no hay nada de nada</h2>
					<h3>No sabemos qué estabas buscando, pero ya no se encuentra en esta dirección, a menos que se tratara de esta página de error. En ese caso, ¡felicidades! No cabe duda de que la has encontrado</h3>

				    <a href="{{ route('Principal.index') }} " class="btn btn-primary">Regresar</a>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>