<!-- Customer Name Field -->
<div class="form-group">
    {!! Form::label('customer_name', 'Nombre completo:', ['class' => 'font-weight-bold']) !!}
    <p>{{ $order->customer_name }}</p>
</div>

<!-- Customer Email Field -->
<div class="form-group">
    {!! Form::label('customer_email', 'Correo electrónico:', ['class' => 'font-weight-bold']) !!}
    <p>{{ $order->customer_email }}</p>
</div>

<!-- Customer Mobile Field -->
<div class="form-group">
    {!! Form::label('customer_mobile', 'Celular:', ['class' => 'font-weight-bold']) !!}
    <p>{{ $order->customer_mobile }}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Estado:', ['class' => 'font-weight-bold']) !!}
    <p>{{ $order->status }}</p>
</div>

