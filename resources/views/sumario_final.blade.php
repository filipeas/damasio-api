<?php
set_time_limit(0); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo Damásio - Sumário</title>

    <style>
        @font-face {
            font-family: 'swis721_cn_bt';
            font-style: normal;
            font-weight: 700;
            src: url('{{ public_path('fonts/Swis721_Cn_BT_Bold.ttf') }}') format('truetype');
        }

        * {
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            padding: 0;
            margin-top: 40px;
            font-family: 'swis721_cn_bt' !important;
        }

        table,
        tr,
        td,
        th,
        thead,
        tbody {
            font-family: 'swis721_cn_bt';
            font-style: normal;
            font-weight: 700;
            src: url('{{ public_path('fonts/Swis721_Cn_BT_Bold.ttf') }}') format('truetype');
        }

        .page_break {
            page-break-before: always;
        }

        .barra_topo {
            width: 100%;
            height: 30px;
            top: 0px;
            left: 0;
            right: 0;
            position: fixed;
            background-color: #1448A3;
        }

        .barra_rodape {
            width: 100%;
            height: 40px;
            bottom: 0px;
            left: 0;
            right: 0;
            position: fixed;
            background-color: #1448A3;
        }

        .titulo_topo_esquerda {
            z-index: 9;
            position: absolute;
            margin-top: 10px;
            width: 10% !important;
            /* margin-left: 570px; */
            border-top: 30px solid transparent;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
        }

        .titulo_topo_esquerda h5 {
            margin-top: -30px !important;
            font-style: normal;
            font-size: 12px;
            color: #fff;
            text-align: center;
        }

        .sumario {
            z-index: 9;
            position: relative !important;
            height: 120px !important;
            width: 600px !important;
            margin-left: 90px;
            margin-top: 25px !important;
            padding: 0px !important;
            display: inline-block;
            background: #1448A3;
            transform: skewX(-10deg);
        }

        .sumario h1 {
            z-index: 10;
            color: #fff;
            font-style: normal;
            font-size: 85px;
            margin-top: -10px;
            text-align: center;
            transform: skewX(10deg);
        }

        .titulo_categoria {
            height: 0px !important;
            width: 250px !important;
            padding-top: 0px !important;
            border-right: 20px solid transparent;
        }

        .titulo_categoria h1 {
            color: #fff;
            font-style: normal;
            font-size: 16px;
            margin-top: 0px;
            margin-left: 5px;
        }

        .box-sumario {
            /* font-family: 'swis721_cn_bt' !important; */
            /* background-color: red; */
            /* margin-top: 40px !important; */
            /* height: 1080px; */
            /* margin-left: 60px; */
            /* width: 100%; */
            /* background-color: red; */
        }

        .box-sumario-com-titulo {
            margin-top: 200px !important;
            /* height: 900px; */
        }

        .bloco-esquerda {
            position: relative !important;
            /* float: left; */
            /* background-color: green; */
            width: 400px !important;
            left: 60px !important;
        }

        .bloco-direita {
            top: 0px !important;
            position: absolute !important;
            float: right;
            /* margin-left: 400px; */
            /* background-color: blue; */
            width: 400px !important;
        }

    </style>
</head>

<body>
    <!-- barra azul que fica no topo da página -->
    <div class="barra_topo">
        <div class="titulo_topo_esquerda">
            <h5>SUMÁRIO</h5>
        </div>
    </div>

    <!-- barra azul que fica no rodappe da página -->
    <div class="barra_rodape"></div>

    <!-- titulo do sumário -->
    <div class="sumario">
        <h1>SUMÁRIO</h1>
    </div>

    <?php
    $pagina = $page;
    $limiteDaFolhaComTitulo = 900;
    $primeiraPagina = true;
    $limiteDaFolhaSemTitulo = 1080;
    $colunaAtual = false; // false = esquerda | true = direita
    $contadorDeLimite = 0;
    // dd($categories);
    ?>

    <div class="box-sumario" style="margin-top: 25px;">
        @foreach ($categories as $key => $category)
            <?php
            // if ($key > 7) {
            //     continue;
            // }
            ?>

            {{-- @if ($primeiraPagina) --}}
            <div class="{{ !$colunaAtual ? 'bloco-esquerda' : 'bloco-direita' }}"
                style="{{ !$colunaAtual ? '' : 'margin-top: ' . ($contadorDeLimite + 4) . 'px!important;' }}">
                <div class="titulo_categoria"
                    style="border-bottom: 30px solid #{{ $category['color'] == null ? '1448A3' : $category['color'] }}; color: #{{ $category['title_color'] == null ? 'fff' : $category['title_color'] }}">
                    <h1>{{ $category['category'] }}
                    </h1>
                </div>
            </div>

            <?php
            // conta a altura da linha do titulo da categoria
            $contadorDeLimite += 30;
            ?>

            @foreach ($category['subcategories'] as $subcategory)
                @foreach ($subcategory as $titulo => $pagina)
                    <table id="customers" class="{{ !$colunaAtual ? 'bloco-esquerda' : 'bloco-direita' }}"
                        style="{{ !$colunaAtual ? '' : 'margin-top: ' . $contadorDeLimite . 'px!important;' }}">
                        <tr>
                            <td style=" width: 180px !important; height: 25px!important;">
                                {{ $titulo }}
                            </td>
                            {{-- <td style="background-color: gold; width: 70px !important;"> .......................... </td> --}}
                            <td style=" width: 200px !important;">
                                {{ 'Pág ' . $pagina }}
                            </td>
                        </tr>
                    </table>

                    <?php
                    // conta altura da linha da subcategoria
                    $contadorDeLimite += 25;
                    
                    if ($primeiraPagina) {
                        if ($contadorDeLimite > 750 && !$colunaAtual) {
                            $colunaAtual = true;
                            $contadorDeLimite = 0;
                        } elseif ($contadorDeLimite >= 850 && $colunaAtual) {
                            $primeiraPagina = false;
                            $colunaAtual = false;
                            $contadorDeLimite = 0;
                            echo '<div class="page_break"></div>';
                        }
                    } else {
                        if ($contadorDeLimite > 900 && !$colunaAtual) {
                            $colunaAtual = true;
                            $contadorDeLimite = 0;
                        } elseif ($contadorDeLimite >= 1000 && $colunaAtual) {
                            $colunaAtual = false;
                            $contadorDeLimite = 0;
                            echo '<div class="page_break"></div>';
                        }
                    }
                    ?>
                @endforeach
            @endforeach
            {{-- @else
                1
            @endif --}}
        @endforeach
    </div>
</body>

</html>
