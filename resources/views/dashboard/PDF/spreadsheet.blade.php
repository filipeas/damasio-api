@extends('dashboard.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Importar planilha de produtos</h2>
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

    <form onsubmit="return confirm('Tem certeza que deseja atualizar todos os produtos com esse novo arquivo XML?');"
        action="{{ route('user.import.xml.do') }}" name="formCreateSpreadsheet" method="POST"
        class="bg-gray-apple shadow-sm p-3 mb-5 rounded" enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label for="inputTitulo">Arquivo XML contendo os produtos a serem inseridos no banco de dados</label>
            <p>OBS1: O sistema irá excluir todos os dados do banco de dados e depois irá atualizar para os dados dessa
                planilha.<br>OBS2: Limite máximo de 10mb para o arquivo.</p>
            <input required name="xml" type="file" class="form-control" id="inputTitulo">
            <small class="form-text text-muted">Informe o arquivo XML que contém os produtos novos para atualizar o banco de
                dados.</small>
        </div>

        <hr>
        <p class="text-center">* Após confirmar a importação, o sistema irá carregar o arquivo XML e executar os processos
            de organização de
            dados. Por isso, atente-se a enviar o arquivo no formato correto.</p>
        <input type="submit" class="btn btn-primary w-100" value="Importar planilha">
    </form>

@endsection
