@extends('dashboard.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Editar categoria</h2>
        </div>
    </div>

    @if (session()->get('error'))
        <div class="alert alert-danger" role="alert">
            @foreach (session()->get('message') as $item)
                @foreach ($item as $itemErr)
                    @foreach ($itemErr as $elem)
                        @foreach ($elem as $elemmsg)
                            @foreach ($elemmsg as $msg)
                                {{ $msg }} <br>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </div>
    @endif

    <form action="{{ route('user.category.update', ['category' => $category->id]) }}" name="formCreateCategory"
        method="POST" class="bg-gray-apple shadow-sm p-3 mb-5 rounded" enctype="multipart/form-data">

        @csrf

        @method('patch')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <p class="small">OBS1: Limite máximo de 2mb para o arquivo. Inserir somente PDF.<br>OBS2: Sempre
                        colocar uma página em branco a mais no PDF, no final no arquivo.</p>
                    <label for="inputFile">Propaganda para a categoria</label>
                    <input name="propaganda" type="file" class="form-control" id="inputFile">
                    <small class="form-text text-muted">Insira um arquivo de propaganda para que seja usada quando for
                        gerado
                        o
                        catálogo.</small>
                    <p class="small">PS: Caso já tenha uma propaganda, a nova irá substituir a anterior.</p>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ $category->propaganda }}" download
                            class="{{ empty($category->propaganda) ? 'disabled' : '' }} btn btn-primary w-100 m-3">Clique aqui para
                            baixar a propaganda atual</a>
                    </div>
                    <div class="col-md-12">
                        <a href="{{ $category->pdf }}" download
                            class="{{ empty($category->pdf) ? 'disabled' : '' }} btn btn-success w-100  m-3">Clique aqui para
                            baixar o PDF gerado</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputTitulo">Título da categoria *</label>
                    <input required name="title" type="text" class="form-control" id="inputTitulo"
                        placeholder="Ex: Eletrônicos" value="{{ old('title') ? old('title') : $category->title }}">
                    <small class="form-text text-muted">Digite o título da categoria nova.</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputmodelo">Modelo de layout da categoria</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="model">
                        <option value="" {{ $category->model === null ? 'selected' : '' }}>Selecione</option>
                        <option value="1" {{ $category->model === 1 ? 'selected' : '' }}>Lista</option>
                        <option value="0" {{ $category->model === 0 ? 'selected' : '' }}>Bloco</option>
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
                        placeholder="Ex: FFF"
                        value="{{ old('title_color') ? old('title_color') : $category->title_color }}">
                    <small class="form-text text-muted">Digite a cor do título da categoria nova. Somente cor
                        exadecimal.</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputCor">Cor da categoria</label>
                    <input name="color" min="3" max="6" type="text" class="form-control" id="inputCor"
                        placeholder="Ex: FFF" value="{{ old('color') ? old('color') : $category->color }}">
                    <small class="form-text text-muted">Digite a cor da categoria nova. Somente cor exadecimal.</small>
                </div>
            </div>
        </div>

        <input type="submit" class="btn btn-primary w-100" value="Editar">
    </form>

@endsection
