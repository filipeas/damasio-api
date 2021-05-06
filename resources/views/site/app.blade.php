<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} - Catálogo Digital</title>

    <link rel="stylesheet" href="{{ asset('site/style.css') }}">
    {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
    <link rel="stylesheet" href="{{ asset('site/fontawesome.css') }}">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

    </style>
</head>

<body>
    @section('sidebar')
        <header>
            <div class="collapse bg-dark" id="navbarHeader">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-md-7 py-4">
                            <h4 class="text-white">Sobre</h4>
                            <p class="text-muted text-justify">Somos a maior importadora e distribuidora de peças para motos
                                da América
                                Latina, atuamos no mercado brasileiro a mais de 53 anos. <br>Com sede em Teresina no estado
                                do Piauí e com escritório na china, atuamos em todo os estados brasileiros.<br>
                                Contamos com laboratório próprio para testes e aprovação de peças em desenvolvimento para
                                fins de importação e representação exclusiva das marcas <b>AUDAX, MHX, MEGATUBE, JEC PRO,
                                    DANNIXX, TRILHA</b> e muitas outras.</p>
                        </div>
                        <div class="col-sm-4 offset-md-1 py-4">
                            <h4 class="text-white">Contato</h4>
                            <ul class="list-unstyled">
                                <li><a href="https://www.instagram.com/damasiomotopecas/?hl=pt-br"
                                        class="text-white">Siga-nos no Instagram</a></li>
                                <li><a href="https://www.facebook.com/damasiomotopeca/" class="text-white">Siga-nos no
                                        Facebook</a></li>
                                <li><a href="https://www.youtube.com/channel/UCMcviWofuBrLAMpPtpcnkRg"
                                        class="text-white">Siga-nos no YouTube</a></li>
                                <li><a href="rh@rdamasio.com.br" class="text-white">Nos envie um E-mail</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar navbar-dark bg-dark box-shadow">
                <div class="container d-flex justify-content-between">
                    <a href="{{ route('site.home') }}" class="navbar-brand d-flex align-items-center">
                        
                        <strong>Damásio Motopeças</strong>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader"
                        aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </header>
    @show

    <!-- content -->
    <main role="main">
        <div class="container">
            @yield('content')
        </div>
    </main>
    <!-- end content -->

    <!-- footer -->
    <footer class="text-muted">
        <div class="container">
            <p class="float-right">
                <a href="#box-top">Voltar para o topo</a>
            </p>
            <p>Feito com muito carinho. Todos os direitos reservados à R. Damásio.</p>
        </div>
    </footer>
    <!-- end footer -->

    <!-- include scripts -->
    <script src="{{ asset('site/jquery.js') }}"></script>
    {{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
    <script src="{{ asset('site/jquery-form.js') }}"></script>
    <script src="{{ asset('site/jquery-mask.js') }}"></script>
    <script src="{{ asset('site/bootstrap.js') }}"></script>
    <script src="{{ asset('site/fontawesome.js') }}"></script>

</body>

</html>
