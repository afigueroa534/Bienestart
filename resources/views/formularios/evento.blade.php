  <div class="form-group">
    <h4>Descripcion</h4>
    {!! Form::select('descripcion', array('Vacacion' => 'Vacacion','Convencion' => 'Convencion','Reunion' => 'Reunion', 'Motivo Personal' => 'Motivo Personal'), null, array('class'=>'form-control','style'=>'' )) !!}
  </div>
  <div class="form-group">
    <h4>Fecha de Inicio</h4>
    {!! Form::date('fecha_inicio', null, ['class' => 'form-control', 'placeholder' => 'Fecha de Inicio...']) !!}
  </div>
  <div class="form-group">
    <h4>Fecha de Finalizacion</h4>
    {!! Form::date('fecha_final', null, ['class' => 'form-control', 'placeholder' => 'Fecha de Finalizacion...']) !!}
  </div>
  