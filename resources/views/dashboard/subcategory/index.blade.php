@extends('dashboard.app')

@section('content')

    <div class="row">
        <div class="col-md-12 bg-gray-apple shadow-sm p-3 mb-5 rounded">
            <h2 class="font-weight-bold">Lista de subcategorias da categoria
                <b>{{ $category->title }}</b>:
            </h2>

            @if (session()->get('error'))
                <div class="alert alert-danger" role="alert">
                    @foreach (session()->get('message') as $item)
                        @foreach ($item as $itemErr)
                            @foreach ($itemErr as $msg)
                                {{ $msg }} <br>
                            @endforeach
                        @endforeach
                    @endforeach
                </div>
            @endif

            <a class="btn btn-primary"
                href="{{ route('user.subcategory.create', ['category' => $category->id]) }}">Cadastrar nova
                subcategoria</a>

            <div class="row">
                @foreach ($subcategories as $subcategory)
                    <div class="col-md-4">
                        <div class="shadow-sm mt-2 mb-2 p-3 mb-5 bg-gray-100 rounded">
                            <div class="row">
                                <div class="col-md-8 text-center">
                                    <img src="{{ $subcategory->cover }}" alt="{{ $subcategory->title }}"
                                        title="{{ $subcategory->title }}" class="w-50">
                                    <p>Título: <b>{{ $subcategory->title }}</b></p>
                                </div>
                                <div class="col-md-4">
                                    <a class="btn btn-primary w-100 mt-1 mb-1" href="{{ route('user.subcategory.show', ['subcategory' => $subcategory->id]) }}"><i
                                            class="far fa-eye"></i></a>
                                    <a class="btn btn-primary w-100 mt-1 mb-1" href="{{ route('user.subcategory.edit', ['subcategory' => $subcategory->id]) }}"><i
                                            class="fas fa-external-link-alt"></i></a>
                                    <form onsubmit="return confirm('Tem certeza que deseja excluir essa subcategoria?');"
                                        action="{{ route('user.subcategory.destroy', ['subcategory' => $subcategory->id, 'category' => $category->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger w-100 mt-1 mb-1 deleteCategory">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr>
        </div>
    </div>

@endsection
