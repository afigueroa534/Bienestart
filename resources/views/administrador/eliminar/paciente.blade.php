{!! Form::open(['route' => ['Pacientes.destroy', $paciente->cedula], 'method' => 'DELETE']) !!}
	<div class="form-group" align="center">
		<button type="submit" class="btn btn-danger" onClick="return confirm('¿Desea eliminar a este paciente?')">Eliminar Paciente</button>
	</div>
{!! Form::close() !!}