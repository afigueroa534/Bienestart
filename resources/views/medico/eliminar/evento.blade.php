{!! Form::open(['route' => ['Eventos.destroy', $evento->id_evento, 'cedula' => $evento->cedula], 'method' => 'DELETE']) !!}
	<div class="form-group" align="center">
		<button type="submit" class="btn btn-danger" onClick="return confirm('¿Desea eliminar este evento?')">Eliminar Evento</button>
	</div>
{!! Form::close() !!}