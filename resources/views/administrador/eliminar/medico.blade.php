{!! Form::open(['route' => ['Medicos.destroy', $medico->cedula], 'method' => 'DELETE']) !!}
	<div class="form-group" align="center">
		<button type="submit" class="btn btn-danger" onClick="return confirm('¿Desea eliminar a este medico?')">Eliminar Medico</button>
	</div>
{!! Form::close() !!}