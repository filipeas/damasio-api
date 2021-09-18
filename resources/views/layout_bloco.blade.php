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
            padding: 0;
            font-family: 'swis721_cn_bt' !important;
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

        .titulo_topo {
            top: 0px;
            position: absolute;
            margin-top: 5px;
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
            margin-top: 5px;
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
            /* margin-top: 30px !important; */
            /* border-top: 30px solid transparent;
            border-left: -15px solid transparent;
            border-right: -15px solid transparent; */
        }

        .numero_pagina_esquerda {
            bottom: 0px;
            position: absolute;
            width: 10% !important;
            margin-bottom: 10px;
            /* border-top: 30px solid transparent;
            border-left: -15px solid transparent;
            border-right: -15px solid transparent; */
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
            /* background-color: red; */
        }

        .produto h6 {
            z-index: 9;
            font-size: 0.575em;
        }

        .produto img {
            /* width: 140px !important; */
            margin-top: 40px;
            margin-left: 30px;
        }

        .produto .codigo {
            z-index: 9;
            font-size: 10px;
        }

        .produto .titulo {
            z-index: 9;
            /* width: 210px; */
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
            /* z-index: 9; */
            position: absolute;
            height: 330px !important;
            width: 210px !important;
            /* margin-left: 50px; */
            /* background-color: red; */
            /* margin-top: -290px!important; */
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
            margin-top: 80px;
            width: 136px;
        }

        .espacamento_tabela_2 {
            font-family: 'swis721_cn_bt' !important;
            font-weight: bold;
            margin-top: 97px;
            width: 136px;
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
    $maximoDeElementosPorPagina = 12; // numero maximo de itens por pagina
    ?>

    {!! '<table style="margin-left: 0px; padding: 0px 90px 0px 50px;"><tbody>' !!}
    <!-- laço de subcategorias -->
    @foreach ($category->subcategories()->orderBy('title', 'ASC')->get()
    as $key => $subcategory)

        <?php
        $produtosPorLinha = 0; // inicia quantidade de itens por linha
        $contaProdutoGrande = 0; // conta quantas vezes apareceu produtos com mais de 300 caracteres na aplicacao na mesma linha
        $eliminaUltimaLinha = true; // controla a eliminacao da ultima linha
        // if ($key > 1) {
        //     break;
        // }
        ?>

        @foreach ($subcategory->products()->orderBy('id', 'ASC')->orderBy('description', 'ASC')->orderBy('application', 'ASC')->get()
    as $key_product => $product)
            <?php
            $produtosPorLinha++; // a cada produto, subtrair do limite maximo p/ linha
            ?>

            <!-- chegou no final na pagina -->
            @if ($maximoDeElementosPorPagina === 0)
                <!-- fecha tabela da folha atual -->
                {!! '</tbody></table>' !!}

                <!-- salta-página -->
                <div class="page_break"></div>
                <!-- reiniciando tabela para a proxima pagina -->
                {!! '<table style="margin-left: 0px; padding: 0px 90px 0px 50px;"><tbody>' !!}
                <?php
                $eliminaUltimaLinha = true; // reseta controle de eliminacao da ultima linha
                $maximoDeElementosPorPagina = 12; // reseta contabilidade de produtos na pagina
                ?>
            @endif

            <!-- printar titulo, num. da pagina e coluna de categorias na pagina atual -->
            @if ($maximoDeElementosPorPagina === 12)
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
                            style="{{ $category_selected['marked'] ? 'color: #fff; background-color: #' . $category_selected['color'] . ';' : '' }}">
                            {{ $category_selected['category'] }}</div>
                    @endforeach
                </div>
            @endif

            <!-- se for o primeiro produto da linha -->
            @if ($produtosPorLinha === 1)
                <tr>
            @endif

            <!-- conta quantidade de produtos grandes na mesma linha -->
            @if (strlen($product->application) > 300)
                <?php $contaProdutoGrande++; ?>
            @endif

            <!-- salte a pagina somente se o terceiro produto quebrar o layout -->
            @if ($produtosPorLinha === 3 && $contaProdutoGrande > 0 && $eliminaUltimaLinha)
                <?php
                $eliminaUltimaLinha = false;
                $maximoDeElementosPorPagina = $maximoDeElementosPorPagina - 3 < 0 ? 1 : $maximoDeElementosPorPagina - 3;
                ?>
            @endif

            <!-- printe o titulo da subcategoria caso seja o primeiro produto -->
            @if ($key_product === 0)
                <td>
                    <div class="categoria-1">
                        <h4>{{ $subcategory->title }}</h4>
                        <hr class="hr_titulo_categoria">
                    </div>
                </td>

                <!-- printando produto na folha -->
                <td class="produto text-center"
                    style="width: 240px !important; {{ strlen($product->application) > 300 ? 'height: 340px !important;' : '' }} padding: 5px 3px 0 3px;">
                    <img style="width: 88px!important;"
                        src="{{ $product->cover != '' ? 'storage/' . $product->cover : 'storage/no_image_available.jpg' }}">
                    <div style="text-align: right!important; padding: 0px 0px; margin-top: -15px!important;">
                        @foreach ($product->brands($product)->get() as $brand)
                            <img style="{{ $loop->count > 5 ? 'width: 26px!important;' : 'width: 38px!important;' }} margin: 0px!important; padding: 0px!important; padding-left: 5px; {{ $loop->count > 1 ? 'padding: 15px 0px -5px 0px;' : 'padding: 5px 0px;' }}"
                                src="{{ $brand->image != '' ? 'storage/' . $brand->image : 'storage/no_image_available.jpg' }}">
                        @endforeach
                    </div>
                    <hr class="hr_titulo">
                    <div class="codigo">
                        <div
                            style="position: absolute; width: 25px; border-top: 15px solid #1448A3; border-right: 5px solid transparent; color: #fff;">
                            <h4 style="margin-top: -15px;">CÓD.:</h4>
                        </div>
                        <h4 style="margin-left: 35px;">{{ $product->cod }}</h4>
                    </div>
                    <div class="titulo">
                        <h4 class="text-justify m-0">
                            {{ Str::limit(str_replace('/', '/ ', $product->description), 60) }}
                        </h4>
                    </div>
                    <div class="conteudo">
                        <h4 class="marca">
                            MARCA:
                            <b>
                                @foreach ($product->brands($product)->get() as $brand)
                                    {{ $brand->title . ($loop->last ? '' : ' / ') }}
                                @endforeach
                            </b>
                        </h4>
                        <h4 class="aplicacao">APLICAÇÃO:
                            <b>
                                {{ $product->application }}
                            </b>
                            <hr class="hr_rodape">
                        </h4>
                    </div>
                </td>

                <?php
                $produtosPorLinha++; // soma mais 1 produto na linha
                $maximoDeElementosPorPagina--; // subtrai maximo de produtos na pagina
                ?>
            @else
                <!-- printando produto na folha -->
                <td class="produto text-center"
                    style="width: 240px !important; {{ strlen($product->application) > 300 ? 'height: 340px !important;' : '' }} padding: 5px 3px 0 3px;">
                    <img style="width: 88px!important;"
                        src="{{ $product->cover != '' ? 'storage/' . $product->cover : 'storage/no_image_available.jpg' }}">
                    <div style="text-align: right!important; padding: 0px 0px; margin-top: -15px!important;">
                        @foreach ($product->brands($product)->get() as $brand)
                            <img style="{{ $loop->count > 5 ? 'width: 26px!important;' : 'width: 38px!important;' }} margin: 0px!important; padding: 0px!important; padding-left: 5px; {{ $loop->count > 1 ? 'padding: 15px 0px -5px 0px;' : 'padding: 5px 0px;' }}"
                                src="{{ $brand->image != '' ? 'storage/' . $brand->image : 'storage/no_image_available.jpg' }}">
                        @endforeach
                    </div>
                    <hr class="hr_titulo">
                    <div class="codigo">
                        <div
                            style="position: absolute; width: 25px; border-top: 15px solid #1448A3; border-right: 5px solid transparent; color: #fff;">
                            <h4 style="margin-top: -15px;">CÓD.:</h4>
                        </div>
                        <h4 style="margin-left: 35px;">{{ $product->cod }}</h4>
                    </div>
                    <div class="titulo">
                        <h4 class="text-justify m-0">
                            {{ Str::limit(str_replace('/', '/ ', $product->description), 60) }}
                        </h4>
                    </div>
                    <div class="conteudo">
                        <h4 class="marca">
                            MARCA:
                            <b>
                                @foreach ($product->brands($product)->get() as $brand)
                                    {{ $brand->title . ($loop->last ? '' : ' / ') }}
                                @endforeach
                            </b>
                        </h4>
                        <h4 class="aplicacao">APLICAÇÃO:
                            <b>
                                {{ $product->application }}
                            </b>
                            <hr class="hr_rodape">
                        </h4>
                    </div>
                </td>
            @endif

            <!-- feche a linha caso seja o ultimo bloco da linha ou se chegou no final da subcategoria -->
            @if ($produtosPorLinha === 3 || $loop->last)
                <?php
                if ($loop->last && $produtosPorLinha !== 3) {
                    $maximoDeElementosPorPagina = $maximoDeElementosPorPagina - (3 - $produtosPorLinha);
                }
                
                $produtosPorLinha = 0; // reseta contagem de itens na linha
                $contaProdutoGrande = 0; // reseta contagem de produtos grande da linha
                ?>
                </tr>
            @endif

            <!-- conta produto printado -->
            <?php $maximoDeElementosPorPagina--; ?>
        @endforeach
    @endforeach
    {!! '</tbody></table>' !!}
</body>

</html>
