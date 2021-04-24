@extends('layouts.app')

@section('content')
  <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                @include('flash::message')
                <div class="offset-sm-3 col-sm-6">
                    <div class="card">
                        <div class="card-header"> Producto 1
                        </div>
                        <div class="card-body">
                            <div class="jumbotron">
                                <h1 class="display-3">GRAN OFERTA!!!!</h1>
                                <p class="lead">Producto en oferta por tiempo limitado</p>
                                <hr class="my-4">
                                <p class="lead"><a class="btn btn-primary btn-lg" href="{{ route('orders.create') }}" role="button">Comprar</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
