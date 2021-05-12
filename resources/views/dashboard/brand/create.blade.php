@extends('dashboard.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Nova marca</h2>
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

    <form action="{{ route('user.brand.store') }}" name="formCreateBrand" method="POST"
        class="bg-gray-apple shadow-sm p-3 mb-5 rounded" enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label for="InputImage">Selecione a imagem de capa da marca (Utilize uma imagem no tamanho 500x500px):</label>
            <input required name="image" type="file" id="InputImage">
        </div>

        <div class="form-group">
            <label for="inputCod">Código da marca (deve ser único no sistema)</label>
            <input required name="code" type="text" class="form-control" id="inputCod" placeholder="Ex: 001"
                value="{{ old('code') }}">
            <small class="form-text text-muted">Digite o código da marca.</small>
        </div>

        <div class="form-group">
            <label for="inputTitle">Nome da marca</label>
            <input required name="title" type="text" class="form-control" id="inputTitle" placeholder="Ex: Brembo"
                value="{{ old('title') }}">
            <small class="form-text text-muted">Digite o nome da marca.</small>
        </div>

        <input type="submit" class="btn btn-primary w-100" value="Cadastrar">
    </form>

@endsection
