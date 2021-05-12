@extends('dashboard.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h3>Gestão de Categorias e Produtos</h3>
        </div>
        <div class="col-md-6">
            <div class="card bg-light mb-3">
                <div class="card-header text-center">Categorias</div>
                <div class="card-body">
                    <h5 class="card-title"><a href="{{ route('user.category.index') }}"
                            class="btn btn-outline-dark w-100">Acessar</a></h5>
                    <p class="card-text text-center">Precisa alterar alguma informação em uma categoria do catálogo? Acesse
                        essa aba e procure a categoria que deseja manipular.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-light mb-3">
                <div class="card-header text-center">Marcas</div>
                <div class="card-body">
                    <h5 class="card-title"><a href="{{ route('user.brand.index') }}"
                            class="btn btn-outline-dark w-100">Acessar</a></h5>
                    <p class="card-text text-center">Há necessidade de manipular as marcas dos produtos separadamente? Use
                        essa função e corrija os problemas.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h3>Dados externos</h3>
        </div>
        <div class="col-md-6">
            <div class="card bg-light mb-3">
                <div class="card-header text-center">Gerar PDF's</div>
                <div class="card-body">
                    <h5 class="card-title"><a href="{{ route('user.generate.pdf') }}"
                            class="btn btn-outline-dark w-100">Gerar novos PDF's</a></h5>
                    <p class="card-text text-center">Precisa atualizar os PDF's do sistema? Use essa função e gere novos
                        PDF's atualizados de acordo com os dados do banco de dados.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-light mb-3">
                <div class="card-header text-center">Importar nova planilha de produtos</div>
                <div class="card-body">
                    <h5 class="card-title"><a href="{{ route('user.import.xml') }}"
                            class="btn btn-outline-dark w-100">Importar</a></h5>
                    <p class="card-text text-center">Há novos produtos a serem inseridos no sistema pela planilha? Vamos
                        atualizar todos os dados.</p>
                </div>
            </div>
        </div>
    </div>

@endsection
