<div class="row">
    <!-- Customer Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('customer_name', 'Nombre completo:') !!}
        {!! Form::text('customer_name', Auth::user()->name, ['class' => 'form-control','maxlength' => 80,'maxlength' => 80]) !!}
    </div>
    
    <!-- Customer Email Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('customer_email', 'Correo electrónico:') !!}
        {!! Form::text('customer_email', Auth::user()->email, ['class' => 'form-control','maxlength' => 120,'maxlength' => 120]) !!}
    </div>
    
    <!-- Customer Mobile Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('customer_mobile', 'Número celular:') !!}
        {!! Form::text('customer_mobile', null, ['class' => 'form-control','maxlength' => 40,'maxlength' => 40]) !!}
    </div>
    
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</div>
