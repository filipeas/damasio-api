@extends('dashboard.app')

@section('content')

    <section id="box-top" class="jumbotron text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img class="card-img-top" src="{{ $product->cover }}" alt="{{ $product->description }}"
                        title="{{ $product->description }}">
                </div>
                <div class="col-md-6">
                    <h3>{{ $product->description }}</h3>
                    <p class="lead text-muted mb-0"><b>cod.:</b> {{ $product->cod }}</b></p>
                    <hr>
                    <p class="lead text-muted mb-0"><b>Aplicação:</b><br>{{ $product->application }}</b>.</p>
                    <hr>
                    <h4>Marcas</h4>
                    <div class="row">
                        @foreach ($product->brands as $brand)
                            <div class="col-md-3">
                                <img class="card-img-top" src="{{ $brand->image }}" alt="{{ $brand->title }}"
                                    title="{{ $brand->title }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
