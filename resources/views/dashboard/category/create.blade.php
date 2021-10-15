@extends('dashboard.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Nova categoria</h2>
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

    <form action="{{ route('user.category.store') }}" name="formCreateCategory" method="POST"
        class="bg-gray-apple shadow-sm p-3 mb-5 rounded" enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label for="inputFile">Propaganda para a categoria</label>
            <input name="propaganda" type="file" class="form-control" id="inputFile">
            <small class="form-text text-muted">Insira um arquivo de propaganda para que seja usada quando for gerado o
                catálogo.</small>
            <p class="small">OBS1: Limite máximo de 2mb para o arquivo. Inserir somente PDF.</p>
            <p class="small">OBS2: Sempre colocar uma página em branco a mais no PDF.</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputTitulo">Título da categoria *</label>
                    <input required name="title" type="text" class="form-control" id="inputTitulo"
                        placeholder="Ex: Eletrônicos" value="{{ old('title') }}">
                    <small class="form-text text-muted">Digite o título da categoria nova.</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputmodelo">Modelo de layout da categoria</label>
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option value="1">Lista</option>
                        <option value="0">Bloco</option>
                    </select>
                    <small class="form-text text-muted">Escolha um layout para essa categoria.</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputtitle_color">Cor do título da categoria</label>
                    <input name="title_color" min="3" max="6" type="text" class="form-control" id="inputtitle_color"
                        placeholder="Ex: FFF" value="{{ old('title_color') }}">
                    <small class="form-text text-muted">Digite a cor do título da categoria nova. Somente cor
                        exadecimal.</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputCor">Cor da categoria</label>
                    <input name="color" min="3" max="6" type="text" class="form-control" id="inputCor"
                        placeholder="Ex: FFF" value="{{ old('color') }}">
                    <small class="form-text text-muted">Digite a cor da categoria nova. Somente cor exadecimal.</small>
                </div>
            </div>
        </div>

        <input type="submit" class="btn btn-primary w-100" value="Cadastrar">
    </form>

@endsection
