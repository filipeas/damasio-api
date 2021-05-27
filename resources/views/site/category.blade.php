@extends('site.app')

@section('content')

    <section id="box-top" class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">{{ $category->title }}</h1>
            <hr>
            <p class="lead text-muted mb-0">Abaixo é possível visualizar todas as subcategorias da categoria
                <b>{{ $category->title }}</b>.
            </p>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                @foreach ($category->subcategories as $subcategory)
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top" src="{{ $subcategory->cover }}" alt="{{ $subcategory->title }}"
                                title="{{ $subcategory->title }}">
                            <div class="card-body">
                                <p class="card-text text-center"><b>{{ $subcategory->title }}</b></p>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group w-100">
                                        <a href="{{ route('site.subcategory', ['subcategory' => $subcategory->id]) }}"
                                            type="button" class="btn btn-sm btn-outline-secondary">Visualizar</a>
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
