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

<div id="header" align="center">
	{!! Html::image('https://photos-6.dropbox.com/t/2/AAC4nZG478XopNSaltH6HCXrc90EMqaJPMV2SRipfgfvKQ/12/125009093/jpeg/32x32/1/_/1/2/esquema.jpg/CMX5zTsgASACIAMgBCAFIAYgBygBKAI/RjI-xxKRfjEZ81rvkY2uEAl6C-WFIr8yqbNrKA9uPQM?size=1024x768&size_mode=2','alt',['width'=>'500','height'=>'210']) !!}
	<br>
	<br>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				
				<div align="center">
					<h2>Buen dia, Hemos generado para usted un nuevo Password</h2>
					<h2><strong>Login:</strong>{{ $persona->login }}</h2>
					<h2><strong>Clave:</strong>{{ $clave }}</h2>
				</div>

			</div>
		</div>
	</div>
</div>

</body>
</html>