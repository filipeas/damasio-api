@extends('dashboard.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Gerar PDF's das categorias</h2>
            <p>Barra de progresso de geração dos novos PDF's das categorias.<br>OBS1: Esse progresso indica a porcentagem de
                quantas categorias já possuem seus respectivos PDF's.<br>OBS2: Após o progresso completar 100%, espere 30min
                para que os PDF's sejam anexados no PDF final.</p>
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

    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated JProgressPDF"
            data-route="{{ route('user.progress.generate.pdf') }}" role="progressbar" aria-valuenow="75" aria-valuemin="0"
            aria-valuemax="100">Analisando...</div>
    </div>
    <p class="text-center">(progresso atualiza em 15s)</p>
    <p>Catálogo final gerado? <b class="jProgressPDFFinal"></b></p>

    <form onsubmit="return confirm('Tem certeza que deseja gerar novos PDFs para as categorias no banco de dados?');"
        action="{{ route('user.generate.pdf.do') }}" name="formCreateGeneratePDF" method="GET"
        class="bg-gray-apple shadow-sm p-3 mb-5 rounded" enctype="multipart/form-data">

        @csrf

        <hr>
        <p class="text-center">* Após confirmar a confirmação de novos PDF's, todos os PDF's antigos serão substituidos.
        </p>
        <input type="submit" class="btn btn-primary w-100" value="Gerar novos PDF's">
    </form>

@endsection
