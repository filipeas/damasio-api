@extends('dashboard.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Editar subcategoria</h2>
        </div>
    </div>

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

    <form
        action="{{ route('user.subcategory.update', ['subcategory' => $subcategory->id, 'category' => $subcategory->category->id]) }}"
        name="formCreateCategory" method="POST" class="bg-gray-apple shadow-sm p-3 mb-5 rounded">

        @csrf

        @method('put')

        <input type="hidden" name="parent" value="{{ $subcategory->category->id }}">

        <div class="form-group">
            <label for="inputTitulo">Título da subcategoria</label>
            <input name="title" type="text" class="form-control" id="inputTitulo" placeholder="Ex: Eletrônicos"
                value="{{ old('title') ? old('title') : $subcategory->title }}">
            <small class="form-text text-muted">Digite o novo título para essa subcategoria.</small>
        </div>

        <input type="submit" class="btn btn-primary w-100" value="Editar">
    </form>

@endsection
