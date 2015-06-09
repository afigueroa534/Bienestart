  <div class="form-group">
    <h4>Edad del Suceso</h4>
    {!! Form::number('edad', '0', ['class' => 'form-control', 'placeholder' => 'Edad...', 'min' => '0', 'max' => '130']) !!}
  </div>
  <div class="form-group">
    <h4>Descripcion</h4>
    {!! Form::textarea('descripcion', null, ['class'=>'form-control','placeholder'=>'Descripcion...' ]) !!}
  </div>
  