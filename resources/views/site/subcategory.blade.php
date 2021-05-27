@extends('site.app')

@section('content')

    <section id="box-top" class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">
                <a href="{{ route('site.category', ['category' => $subcategory->category->id]) }}"
                    class="text-dark text-decoration-none">
                    {{ $subcategory->category->title }}
                </a>
            </h1>
            <h4>{{ $subcategory->title }}</h4>
            <hr>
            <p class="lead text-muted mb-0">Abaixo é possível visualizar todos os produtos da subcategoria
                <b>{{ $subcategory->title }}</b>.
            </p>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-3">
                <div class="card bg-light mb-3">
                    <div class="card-header bg-dark text-white text-uppercase"><i class="fa fa-list">
                        </i> Subcategorias
                    </div>
                    <ul class="list-group category_block">
                        @foreach ($subcategory->category->subcategories as $subcat)
                            <?php $checkRoute = route('site.subcategory', ['subcategory' => $subcat->id]) ==
                            Request::url(); ?>
                            <a href="{{ route('site.subcategory', ['subcategory' => $subcat->id]) }}">
                                <li class="list-group-item btn-outline-dark j_select_category {{ $checkRoute ? 'active' : '' }}"
                                    style="cursor: pointer;">
                                    {{ $subcat->title }}
                                </li>
                            </a>
                        @endforeach
                    </ul>
                </div>
                <a href="{{ route('site.category', ['category' => $subcategory->category->id]) }}"
                    class="w-100 btn btn-sm btn-outline-primary">Voltar para a categoria
                    {{ $subcategory->category->title }}</a>
            </div>

            <div class="col">
                <div class="row mb-4 j_block_products">
                    <!-- blocos de produtos na tela (max 9 por pagina) -->
                    <div class="album">
                        <div class="container">
                            <div class="row">
                                @foreach ($subcategory->products as $product)
                                    <div class="col-md-4">
                                        <div class="card mb-4 box-shadow">
                                            <img class="card-img-top" src="{{ $product->cover }}"
                                                alt="{{ $product->description }}" title="{{ $product->description }}">
                                            <div class="card-body">
                                                <p class="card-text text-center pb-2">
                                                    <b>{{ Str::limit($product->description, 30) }}</b>
                                                </p>
                                                <hr>
                                                <p class="card-text text-center">
                                                    {{ Str::limit($product->application, 20) }}</p>
                                                <hr>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="btn-group w-100">
                                                        <a href="{{ route('site.product', ['product' => $product->id]) }}"
                                                            type="button"
                                                            class="btn btn-sm btn-outline-secondary">Visualizar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- paginacao -->
                    {!! $subcategory->pagination->links !!}
                </div>
            </div>

        </div>
    </div>

@endsection
