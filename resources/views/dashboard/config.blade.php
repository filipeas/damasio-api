@extends('dashboard.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Configurações do sistema</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="list-group list-group-flush">
                <a href="{{ route('user.config') }}"
                    class="list-group-item list-group-item-action {{ Request::routeIs('user.config') ? 'active' : '' }}">Configurações
                    do sistema</a>
            </div>
        </div>

        <div class="col-md-9">

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

            <form action="{{ route('user.config.do') }}" name="formEditConfigSystem" method="POST"
                class="bg-gray-apple shadow-sm p-3 mb-5 rounded" enctype="multipart/form-data">

                @csrf

                {{-- <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="inputpdf_completo">PDF do catálogo completo</label>
                            <input name="pdf_completo" type="file" class="form-control" id="inputpdf_completo">
                            <small class="form-text text-muted">Insira o PDF do catálogo completo.</small>
                        </div>
                    </div>
                </div> --}}

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="inputpdf_fixo">PDF de páginas fixas (máximo de 10mb)</label>
                            <p><b>{{ Session::get('user')->pdf_fixo != '' ? 'Você já possui um PDF inserido.' : 'Não foi detectado nenhum PDF.' }}</b>
                            </p>
                            <input name="pdf_fixo" type="file" class="form-control" id="inputpdf_fixo">
                            <small class="form-text text-muted">Insira o PDF ddas páginas iniciais do catálogo.</small>
                        </div>
                    </div>
                </div>

                <input type="submit" class="btn btn-primary w-100" value="Atualizar">
            </form>
        </div>
    </div>

@endsection
