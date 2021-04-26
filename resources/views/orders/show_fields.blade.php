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

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Estado:', ['class' => 'font-weight-bold']) !!}
    <p>{{ $order->amount }}</p>
</div>

@if (Auth::user()->is_customer == 1)
    @if($order->status == $order::ORDER_CREATED)
        <!-- Submit Field -->
        <div class="form-group col-sm-12">
            {!! Form::open(['route' => ['orders.pay', $order->id]]) !!}
                {!! Form::submit('Realizar pago', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    @elseif($order->status == $order::ORDER_REJECTED)
    <!-- Submit Field -->
    <div class="form-group">
        {!! Form::open(['url' => $order->payment_url, 'method' => 'get']) !!}
            {!! Form::submit('Reintentar pago', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
    @endif
@endif