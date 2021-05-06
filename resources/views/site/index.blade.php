@extends('site.app')

@section('content')

    <section id="box-top" class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Catálogo Digital</h1>
            <p class="lead text-muted">Bem-vindo ao catálogo digital da Damásio Motopeças. <br>Aqui você pode
                visualizar rapidamente todos os nossos produtos disponíveis no catálogo.</p>
            <p>
                <a href="#" class="btn btn-primary my-2">Baixar catálogo completo</a>
            </p>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                @foreach ($categories as $category)
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top" src="{{ $category->cover }}" alt="{{ $category->title }}"
                                title="{{ $category->title }}">
                            <div class="card-body">
                                <p class="card-text text-center"><b>{{ $category->title }}</b></p>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group w-100">
                                        <a href="{{ route('site.category', ['category' => $category->id]) }}"
                                            type="button" class="btn btn-sm btn-outline-secondary">Visualizar</a>
                                            <a href="{{ $category->pdf }}" download type="button"
                                                class="btn btn-sm btn-outline-primary">Baixar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
