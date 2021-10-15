<?php
set_time_limit(0);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo Damásio</title>

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
            padding: 0px 0px;
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

        .text-left {
            text-align: left !important;
        }

        .text-justify {
            text-align: justify !important;
        }

        .page_break {
            page-break-before: always;
        }

        .hr_titulo_categoria {
            z-index: 99;
            border-top: 4px solid #FF0000;
            width: 100px;
            margin-top: 10px;
        }

        .hr_titulo {
            border-top: 1px solid #000;
            width: 100% !important;
        }

        .hr_rodape {
            /* background-color: red; */
            color: #000;
            border-top: 1px dashed #000;
            width: 100% !important;
        }

        .barra_topo {
            width: 100%;
            height: 0.80cm;
            top: 0px;
            left: 0;
            right: 0;
            position: fixed;
            background-color: #1448A3;
        }

        .barra_rodape {
            width: 100%;
            height: 0.80cm;
            bottom: 0px;
            left: 0;
            right: 0;
            position: fixed;
            background-color: #1448A3;
        }

        .titulo_topo {
            top: 0px;
            position: absolute;
            /* background-color: red; */
            margin-top: -30px;
            /* width: 24% !important; */
            /* height: 0px; */
            margin-left: 570px;
            border-top: 30px solid transparent;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
        }

        .titulo_topo_esquerda {
            top: 0px;
            position: absolute;
            /* background-color: red; */
            margin-top: -30px;
            width: 10% !important;
            /* height: 0px; */
            border-top: 30px solid transparent;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
        }

        .titulo_topo h5,
        .titulo_topo_esquerda h5 {
            margin-top: -30px !important;
            font-style: normal;
            font-size: 12px;
            color: #fff;
            text-align: center;
        }

        .numero_pagina {
            bottom: 0px;
            position: absolute;
            width: 10% !important;
            margin-left: 670px;
            margin-bottom: 10px;
        }

        .numero_pagina_esquerda {
            bottom: 0px;
            position: absolute;
            width: 10% !important;
            margin-bottom: 10px;
        }

        .numero_pagina h4,
        .numero_pagina_esquerda h4 {
            font-style: normal;
            font-size: 12px;
            color: #fff;
            text-align: center;
        }

        .produto {
            position: absolute;
        }

        .produto h6 {
            z-index: 9;
            font-size: 0.575em;
        }

        .produto img {
            margin-top: 40px;
            margin-left: 30px;
        }

        .produto .codigo {
            z-index: 9;
            font-size: 10px;
        }

        .produto .titulo {
            z-index: 9;
            height: 30px;
            margin-top: 5px !important;
        }

        .produto .titulo h4 {
            font-size: 10px;
            font-weight: 700;
        }

        .produto .conteudo {
            z-index: 9;
            font-size: 10px;
        }

        .produto .conteudo .marca {
            font-size: 10px;
            color: #1448A3;
        }

        .produto .conteudo .marca b {
            color: #000;
        }

        .produto .conteudo .aplicacao {
            z-index: 9 !important;
            height: 30px;
            font-size: 10px;
            color: #1448A3;
        }

        .produto .conteudo .aplicacao b {
            text-align: justify !important;
            z-index: 9 !important;
            color: #000;
        }

        .categoria-1 {
            position: absolute;
            height: 330px !important;
            width: 210px !important;
            padding: 0px !important;
            padding-top: -290px !important;
            border-bottom: 235px solid #1448A3;
            border-right: 45px solid transparent;
        }

        .categoria-1 h4 {
            z-index: 10;
            color: #fff;
            font-size: 27px;
            margin-top: 420px;
            margin-left: 10px;
        }

        .espacamento_esquerda {
            font-family: 'swis721_cn_bt' !important;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            transform: rotate(90deg);
            margin-left: -50px;
            height: 40px;
            color: #808285;
            border-right: 1px dotted #808285;
        }

        .espacamento_direita {
            font-family: 'swis721_cn_bt' !important;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            transform: rotate(-90deg);
            margin-left: 782px;
            height: 40px;
            color: #808285;
            border-right: 1px dotted #808285;
        }

        .espacamento_tabela_1 {
            font-family: 'swis721_cn_bt' !important;
            font-weight: bold;
            margin-top: 40px;
            width: 136px;
        }

        .espacamento_tabela_2 {
            font-family: 'swis721_cn_bt' !important;
            font-weight: bold;
            margin-top: 97px;
            width: 136px;
        }

        #customers {
            font-family: 'swis721_cn_bt' !important;
            font-size: 10px;
            border-collapse: collapse;
            width: 100%;
            padding: 0px 52px;
            /* margin-top: -9px !important; */
        }

        #customers td,
        #customers th {
            font-family: 'swis721_cn_bt' !important;
            border: 1px solid #ddd;
            padding: 0 8px;
        }

        #customers tr:nth-child(even) {
            font-family: 'swis721_cn_bt' !important;
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            font-family: 'swis721_cn_bt' !important;
            background-color: #ddd;
        }

        #customers td {
            font-family: 'swis721_cn_bt' !important;
            border: none;
        }

        #customers th {
            font-family: 'swis721_cn_bt' !important;
            padding-top: 6px;
            padding-bottom: 6px;
            text-align: left;
            background-color: #1448A3;
            color: white;
        }

    </style>
</head>

<body>
    <!-- barra azul que fica no topo da página -->
    <div class="barra_topo"></div>

    <!-- barra azul que fica no rodappe da página -->
    <div class="barra_rodape"></div>

    <?php
    $pageNumber = $page; // armazenando pagina inicial para realizar contagem
    // $tamanhoDaPagina = 1090; // tamanho da pagina
    // $printDaSubcategoria = false; // controla se a subcategoria foi printada na pagina
    $quantidadeDeProdutosPorPagina = 23;
    $tamanhoDaPaginaAtual = 1.6; // tamanho livre de cada pagina (considerando o header e footer)
    ?>

    <!-- laço de subcategorias -->
    {{-- @foreach ($category->subcategories()->orderBy('title', 'ASC')->get()
    as $key => $subcategory) --}}
    <!-- REMOVER LAÇO DA CATEGORIA (RESPONSABILIDADE DO CONTROLLER) -->

    <?php
    // if ($key > 2) {
    //     break;
    // }
    // if ($subcategory->title != 'GUIDÃO') {
    //     continue;
    // }
    ?>

    @foreach ($subcategory->products()->orderBy('id', 'ASC')->orderBy('description', 'ASC')->orderBy('application', 'ASC')->get()
    as $key_product => $product)
        @if ($tamanhoDaPaginaAtual >= 27)
            <!-- fechar tabela de produtos -->
            {!! '</tbody></table>' !!}

            <!-- salta-página -->
            <div class="page_break"></div>

            {{-- @if (!$loop->last) --}}
            <!-- abrir tabela de produtos -->
            {!! '<table id="customers"><thead><tr><th>CÓDIGO:</th><th>DESCRIÇÃO:</th><th>APLICAÇÃO:</th><th>MARCA:</th></tr></thead><tbody>' !!}
            {{-- @endif --}}

            <?php
            $quantidadeDeProdutosPorPagina = 23;
            $tamanhoDaPaginaAtual = 1.6;
            // continue;
            ?>
        @endif

        <!-- printar titulo, coluna de categorias e pagina quando for o primeiro produto -->
        @if ($tamanhoDaPaginaAtual === 1.6)
            @if ($pageNumber % 2 == 0)
                <!-- número da página -->
                <div class="numero_pagina">
                    <h4>{{ ++$pageNumber }}</h4>
                </div>
                <!-- titulo da pagina -->
                <div class="titulo_topo">
                    <h5>{{ $subcategory->title }}</h5>
                </div>
            @else
                <!-- número da página -->
                <div class="numero_pagina_esquerda">
                    <h4>{{ ++$pageNumber }}</h4>
                </div>
                <!-- titulo da pagina -->
                <div class="titulo_topo_esquerda">
                    <h5>{{ $subcategory->title }}</h5>
                </div>
            @endif

            <!-- coloca barra de categorias na vertical -->
            <div style="position: absolute; top: 0px;">
                @foreach ($categories_column as $key_category => $category_selected)
                    <div class="{{ $key_category == 0 ? 'espacamento_tabela_1' : 'espacamento_tabela_2' }} {{ $pageNumber % 2 == 0 ? 'espacamento_esquerda' : 'espacamento_direita' }}"
                        style="{{ $category_selected['marked'] ? 'color: #' . ($category_selected['title_color'] == null ? 'fff' : $category_selected['title_color']) . '; background-color: #' . ($category_selected['color'] == null ? '1448A3' : $category_selected['color']) . ';' : '' }}">
                        {{ $category_selected['category'] }}</div>
                @endforeach
            </div>
        @endif

        @if ($key_product === 0)
            <?php
            $quantidadeDeProdutosPorPagina -= 6;
            $tamanhoDaPaginaAtual += 6;
            ?>

            <!-- printe o titulo da subcategoria caso seja o primeiro produto -->
            <table style="margin-left: 0px; margin-top: -30px !important; padding: 0px 90px 40px 50px;">
                <tbody>
                    <tr>
                        <td>
                            <div class="categoria-1">
                                <h4>{{ $subcategory->title }}</h4>
                                <hr class="hr_titulo_categoria">
                            </div>
                        </td>
                        <td class="produto text-center" style="width: 240px !important; padding: 5px 3px 0 3px;">
                            <img style="width: 200px!important;"
                                src="{{ $product->cover != '' ? 'storage/' . $product->cover : 'storage/no_image_available.jpg' }}">
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- abrir tabela de produtos -->
            {!! '<table id="customers"><thead><tr><th>CÓDIGO:</th><th>DESCRIÇÃO:</th><th>APLICAÇÃO:</th><th>MARCA:</th></tr></thead><tbody>' !!}

            <!-- printar o primeiro produto -->
            <?php
            $quantidadeDeProdutosPorPagina -= 1;
            
            // quantidade de linhas da celula da tabela
            $descricao = str_replace('/', '/ ', $product->description);
            $aplicacao = $product->application;
            $x = 0.4 + ceil(strlen($descricao) / 43) * 0.4;
            $y = 0.4 + ceil(strlen($aplicacao) / 75) * 0.4;
            $z = $product->brands($product)->count();
            
            if ($x >= $y && $x >= $z) {
                $max = $x; // tamanho em cm
            }
            if ($y >= $x && $y >= $z) {
                $max = $y; // tamanho em cm
            }
            if ($z >= $x && $z >= $y) {
                $max = $z; // tamanho em cm
            }
            
            $max = ceil($max) - 1 == 0 ? 1 : ceil($max) - 1;
            $tamanhoDaPaginaAtual += $max;
            ?>

            <tr>
                <td style="--height: {{-- $max --}}cm !important--;">
                    {!! str_replace(',', '<br>', $product->cod) !!}
                </td>
                <td>
                    {{ $descricao }}
                </td>
                <td>
                    {{ $aplicacao }}
                </td>
                <td>
                    @foreach ($product->brands($product)->get() as $brand)
                        {!! $brand->title . ($loop->last ? '' : '<br>') !!}
                    @endforeach
                </td>
            </tr>
        @else
            <?php
            $quantidadeDeProdutosPorPagina -= 1;
            
            // quantidade de linhas da celula da tabela
            $descricao = str_replace('/', '/ ', $product->description);
            $aplicacao = $product->application;
            $x = 0.4 + ceil(strlen($descricao) / 43) * 0.4;
            $y = 0.4 + ceil(strlen($aplicacao) / 75) * 0.4;
            $z = $product->brands($product)->count();
            
            if ($x >= $y && $x >= $z) {
                $max = $x; // tamanho em cm
            }
            if ($y >= $x && $y >= $z) {
                $max = $y; // tamanho em cm
            }
            if ($z >= $x && $z >= $y) {
                $max = $z; // tamanho em cm
            }
            
            $max = ceil($max) - 1 == 0 ? 1 : ceil($max) - 1;
            $tamanhoDaPaginaAtual += $max;
            ?>

            <tr>
                <td style="height: {{ $max }}cm !important;">
                    {!! str_replace(',', '<br>', $product->cod) !!}
                </td>
                <td>
                    {{ $descricao }}
                </td>
                <td>
                    {{ $aplicacao }}
                </td>
                <td>
                    @foreach ($product->brands($product)->get() as $brand)
                        {!! $brand->title . ($loop->last ? '' : '<br>') !!}
                    @endforeach
                </td>
            </tr>
        @endif

        @if ($loop->last && $tamanhoDaPaginaAtual > 16)
            <!-- fechar tabela de produtos -->
            {!! '</tbody></table>' !!}

            <!-- salta-página -->
            <div class="page_break"></div>

            <?php
            $quantidadeDeProdutosPorPagina = 23;
            $tamanhoDaPaginaAtual = 1.6;
            ?>
        @elseif($loop->last && $quantidadeDeProdutosPorPagina < 16) <!-- fechar tabela de produtos -->
                {!! '</tbody></table>' !!}
        @endif
    @endforeach

    <!-- fechar tabela de produtos -->
    {!! '</tbody></table>' !!}
    {{-- @endforeach --}}
    <!-- REMOVER LAÇO DA CATEGORIA (RESPONSABILIDADE DO CONTROLLER) -->
</body>

</html>
