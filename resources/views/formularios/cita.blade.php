<div class="form-group">
	<h4>Especialidad</h4>
	{!! Form::select('especialidad', array('Seleccione...' => 'Seleccione...','General' => 'General','Internista' => 'Internista','Pediatria' => 'Pediatria', 'Geriatria' => 'Geriatria', 'Neumologia' => 'Neumologia', 'Odontologia' => 'Odontologia', 'Psiquiatria' => 'Psiquiatria'), null, array('class'=>'form-control','style'=>'' )) !!}
</div>

<div class="form-group">
	<h4>Seleccione Medico</h4>
	{!! Form::select('medico', array('Seleccione...' => 'Seleccione...'), null, array('class'=>'form-control','style'=>'' )) !!}
</div>

<div class="form-group">
	<h4>Fechas Disponibles</h4>
		<div id='calendar'></div>
</div>

{!! Form::hidden('fecha','') !!}

<div class="form-group">
    <h4>Horas Disponibles</h4>
    <div class="radio" id="radio8">
	  <label>
	  	<input type="radio" name="hora" value="08:00:00">8:00 AM
	  </label>
	</div>
	<div class="radio" id="radio9">
	  <label>
	  	<input type="radio" name="hora" value="09:00:00">9:00 AM
	  </label>
	</div>
	<div class="radio" id="radio10">
	  <label>
	  	<input type="radio" name="hora" value="10:00:00">10:00 AM
	  </label>
	</div>
	<div class="radio" id="radio2">
	  <label>
	  	<input type="radio" name="hora" value="14:00:00">2:00 PM
	  </label>
	</div>
	<div class="radio" id="radio3">
	  <label>
	  	<input type="radio" name="hora" value="15:00:00">3:00 PM
	  </label>
	</div>
	<div class="radio" id="radio4">
	  <label>
	  	<input type="radio" name="hora" value="16:00:00">4:00 PM
	  </label>
	</div>
</div>

<div id="cargando" align="center">
	<h4>Cargando...</h4>
	<div class="progress">
		<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
	    	<span class="sr-only">Cargando</span>
	  	</div>
	</div>
</div>