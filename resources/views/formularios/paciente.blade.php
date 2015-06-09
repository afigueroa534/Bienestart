
  <div class="form-group">
    <h4>Nombre</h4>
    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre...']) !!}
  </div>
  <div class="form-group">
    <h4>Apellido</h4>
    {!! Form::text('apellido', null, ['class' => 'form-control', 'placeholder' => 'Apellido...']) !!}
  </div>
  <div class="form-group">
    <h4>Sexo</h4>
    <div class="radio">
	  <label>
	  	{!! Form::radio('sexo', 'M', true) !!}
	    Masculino
	  </label>
	</div>
	<div class="radio">
	  <label>
	  	{!! Form::radio('sexo', 'F') !!}
	    Femenino
	  </label>
	</div>
  </div>
  <div class="form-group">
    <h4>Email</h4>
    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email...']) !!}
  </div>
  <div class="form-group">
    <h4>Fecha de Nacimiento</h4>
    {!! Form::date('fecha_nac', null, ['class' => 'form-control', 'placeholder' => 'Fecha de Nacimiento...']) !!}
  </div>
  <div class="form-group">
    <h4>Telefono</h4>
    {!! Form::text('telefono', null, ['class' => 'form-control', 'placeholder' => 'Telefono...']) !!}
  </div>
  <div class="form-group">
    <h4>Direccion</h4>
    {!! Form::text('direccion', null, ['class' => 'form-control', 'placeholder' => 'Direccion...']) !!}
  </div>
  <div class="form-group">
    <h4>Grupo Sanguineo</h4>
    {!! Form::select('grupo_sangre', array('A+' => 'A+', 'A-' => 'A-', 'O+' => 'O+', 'O-' => 'O-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-'), null, array('class'=>'form-control','style'=>'' )) !!}
  </div>
  <div class="form-group">
    <h4>Login</h4>
    {!! Form::text('login', null, ['class' => 'form-control', 'placeholder' => 'Login...']) !!}
  </div>
  <div class="form-group">
    <h4>Password</h4>
    {!! Form::password('clave', ['class' => 'form-control', 'placeholder' => 'Password...']) !!}
  </div>
  <div class="form-group">
    <h4>Imagen de Usuario</h4>
    {!! Form::file('imagen') !!}
  </div>