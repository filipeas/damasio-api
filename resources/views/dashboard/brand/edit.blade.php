@extends('dashboard.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Editar marca <b>{{ $brand->title }}</b></h2>
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

    <form action="{{ route('user.brand.update', ['brand' => $brand->id]) }}" name="formEditBrand" method="POST"
        class="bg-gray-apple shadow-sm p-3 mb-5 rounded" enctype="multipart/form-data">

        @csrf

        @method('put')

        <div class="form-group">
            <div class="row text-center">
                <div class="col-md-6">
                    <label for="InputImage">Selecione a imagem de capa da marca (Utilize uma imagem no tamanho
                        500x500px):</label>
                    <input name="image" type="file" id="InputImage">
                </div>
                <div class="col-md-6 mt-1">
                    <img src="{{ $brand->image }}" alt="{{ $brand->title }}" class="w-100">
                    <h5>Imagem atual</h5>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="inputCod">Código da marca (deve ser único no sistema)</label>
            <input required name="code" type="text" class="form-control" id="inputCod" placeholder="Ex: 001"
                value="{{ old('code') ? old('code') : $brand->code }}">
            <small class="form-text text-muted">Digite o código da marca.</small>
        </div>

        <div class="form-group">
            <label for="inputTitle">Nome da marca</label>
            <input required name="title" type="text" class="form-control" id="inputTitle" placeholder="Ex: Brembo"
                value="{{ old('title') ? old('title') : $brand->title }}">
            <small class="form-text text-muted">Digite o nome da marca.</small>
        </div>

        <input type="submit" class="btn btn-primary w-100" value="Atualizar">
    </form>

@endsection
