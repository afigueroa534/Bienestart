{!! Form::open(['route' => ['Historial.destroy', $antecedente->id_antecedente, 'cedula' => $antecedente->cedula], 'method' => 'DELETE']) !!}
	<div class="form-group" align="center">
		<button type="submit" class="btn btn-danger" onClick="return confirm('¿Desea eliminar este antecedente?')">Eliminar Antecedente</button>
	</div>
{!! Form::close() !!}