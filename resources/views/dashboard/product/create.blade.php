@extends('dashboard.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Novo produto da subcategoria <b>{{ $subcategory->id }}</b></h2>
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

    <form action="{{ route('user.product.store') }}" name="formCreateProduct" method="POST"
        class="bg-gray-apple shadow-sm p-3 mb-5 rounded" enctype="multipart/form-data">

        @csrf

        <input type="hidden" name="subcategory" value="{{ $subcategory->id }}">

        <div class="form-group">
            <div class="row">
                <div class="col-md-4" style="padding:5%;">
                    <strong>Selecione a imagem de capa do produto:</strong>
                    <input required name="image" type="file" id="image">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="inputCod">Códigos do produto (caso represente mais de um produto separe por "/")</label>
            <input required name="cod" type="text" class="form-control" id="inputCod" placeholder="Ex: 001 / 002"
                value="{{ old('cod') }}">
            <small class="form-text text-muted">Digite o nome do produto.</small>
        </div>

        <div class="form-group">
            <label for="inputDescricao">Descrição do produto</label>
            <textarea name="description" required class="form-control" id="inputAplicacao" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="inputAplicacao">Aplicações do produto</label>
            <textarea name="application" required class="form-control" id="inputAplicacao" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="selectBrands">Selecione as marcas desse produto (caso precise selecionar mais de uma, segure
                "crtl" e clique nas marcas desejadas)</label>
            <select multiple required name="brand" class="form-control" id="selectBrands">
                <option value="">Selecione</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                @endforeach
            </select>
        </div>

        <input type="submit" class="btn btn-primary w-100" value="Cadastrar">
    </form>

@endsection
