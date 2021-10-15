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

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="inputpdf_completo"><b>PDF do catálogo completo</b></label>
                                    <p class="small">OBS1: Limite máximo de 10mb para o arquivo. Inserir somente
                                        PDF.</p>
                                    <input name="pdf_completo" type="file" class="form-control" id="inputpdf_completo">
                                    <small class="form-text text-muted">Insira o PDF do catálogo completo.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ Session::get('user')->pdf_completo }}" download
                            class="{{ empty(Session::get('user')->pdf_completo) ? 'disabled' : '' }} btn btn-success w-100  m-3">Clique
                            aqui
                            para
                            baixar o PDF gerado</a>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="small">OBS1: Limite máximo de 10mb para o arquivo. Inserir somente
                                        PDF.<br>OBS2: Sempre
                                        colocar uma página em branco a mais no PDF, no final no arquivo.</p>
                                    <label for="inputpdf_fixo"><b>PDF de páginas fixas (máximo de 10mb)</b></label>
                                    <p>{!! Session::get('user')->pdf_fixo != null ? '<b class="text-success">Você já possui um PDF inserido.</b>' : '<b class="text-warning">Não foi detectado nenhum PDF.</b>' !!}
                                    </p>
                                    <input name="pdf_fixo" type="file" class="form-control" id="inputpdf_fixo">
                                    <small class="form-text text-muted">Insira o PDF ddas páginas iniciais do
                                        catálogo.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ Session::get('user')->pdf_fixo }}" download
                            class="{{ empty(Session::get('user')->pdf_fixo) ? 'disabled' : '' }} btn btn-success w-100  m-3">Clique
                            aqui
                            para
                            baixar o arquivo atual</a>
                    </div>
                </div>

                <input type="submit" class="btn btn-primary w-100" value="Atualizar">
            </form>
        </div>
    </div>

@endsection
