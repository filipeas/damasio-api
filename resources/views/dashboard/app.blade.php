<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} - Painel de gerenciamento</title>

    <link rel="stylesheet" href="{{ asset('site/style.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('site/fontawesome.css') }}">
</head>

<body>
    @section('sidebar')
        <!-- header -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand"
                href="{{ route('site.home') }}">Catálogo Digital</a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('user.home') }}">Home <span
                                class="sr-only">(atual)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('user.category.index') }}">Categorias </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('user.brand.index') }}">Marcas </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('user.import.xml') }}">Importar Planilha </a>
                    </li>
                </ul>
                <div class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown"
                            title="Pedidos da loja" aria-haspopup="true" aria-expanded="false">
                            <i class="far fa-2x fa-user-circle"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('logout') }}">Sair</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end header -->
    @show

    <!-- content -->
    <div class="container">
        @yield('content')
    </div>
    <!-- end content -->

    <!-- footer -->
    <!-- end footer -->

    <!-- include scripts -->
    <script src="{{ asset('site/jquery.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('site/jquery-form.js') }}"></script>
    <script src="{{ asset('site/bootstrap.js') }}"></script>
    <script src="{{ asset('site/fontawesome.js') }}"></script>
    <script src="{{ asset('site/jquery-mask.js') }}"></script>
    {{-- <script src="{{ asset('site/jspdf.umd.min.js') }}"></script>
    <script src="{{ asset('site/jspdf.plugin.autotable.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('site/store/site.js') }}"></script> --}}
    {{-- <script src="{{ asset('site/chartjs.js') }}"></script> --}}
    {{-- <script src="{{ asset('site/filter.js') }}"></script> --}}
</body>

</html>
