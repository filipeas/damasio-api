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
            src: url('{{public_path("fonts/Swis721_Cn_BT_Bold.ttf")}}') format('truetype');
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

        .card-pdf-11 {
            position: absolute;
            height: 330px !important;
            width: 210px !important;
            /* background-color: blue; */
            margin-left: 50px;
            /* margin-top: -10px !important; */
            padding-top: -20px;
        }

        .card-pdf-12 {
            position: absolute;
            height: 330px !important;
            width: 210px !important;
            /* background-color: red; */
            margin-left: 280px;
            margin-top: -20px;
        }

        .card-pdf-13 {
            position: absolute;
            height: 330px !important;
            width: 210px !important;
            /* background-color: red; */
            margin-left: 520px;
            margin-top: -20px;
        }

        .card-pdf-14 {
            position: absolute;
            height: 330px !important;
            width: 210px !important;
            /* background-color: red; */
            margin-left: 50px;
            margin-top: 243px;
        }

        .card-pdf-15 {
            position: absolute;
            height: 330px !important;
            width: 210px !important;
            /* background-color: red; */
            margin-left: 280px;
            margin-top: 243px;
        }

        .card-pdf-16 {
            position: absolute;
            height: 330px !important;
            width: 210px !important;
            /* background-color: red; */
            margin-left: 520px;
            margin-top: 243px;
        }

        .card-pdf-17 {
            position: absolute;
            height: 330px !important;
            width: 210px !important;
            /* background-color: red; */
            margin-left: 50px;
            margin-top: 505px;
        }

        .card-pdf-18 {
            position: absolute;
            height: 330px !important;
            width: 210px !important;
            /* background-color: red; */
            margin-left: 280px;
            margin-top: 505px;
        }

        .card-pdf-19 {
            position: absolute;
            height: 330px !important;
            width: 210px !important;
            /* background-color: red; */
            margin-left: 520px;
            margin-top: 505px;
        }

        .card-pdf-110 {
            position: absolute;
            height: 330px !important;
            width: 210px !important;
            /* background-color: red; */
            margin-left: 50px;
            margin-top: 770px;
        }

        .card-pdf-111 {
            position: absolute;
            height: 330px !important;
            width: 210px !important;
            /* background-color: red; */
            margin-left: 280px;
            margin-top: 770px;
        }

        .card-pdf-112 {
            position: absolute;
            height: 240px !important;
            width: 210px !important;
            /* background-color: red; */
            margin-left: 520px;
            margin-top: 770px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -15px;
            margin-right: 15px;
        }

        .col-md-3,
        .col-md-4 {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .w-100 {
            width: 100% !important;
        }

        .w-75 {
            width: 75% !important;
        }

        .w-50 {
            width: 50% !important;
        }

        .w-25 {
            width: 25% !important;
        }

        .m-0 {
            margin: 0 !important;
        }

        .mt-1 {
            margin-top: 0.25rem !important;
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .mt-3 {
            margin-top: 1rem !important;
        }

        .mt-4 {
            margin-top: 2rem !important;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .mb-1 {
            margin-bottom: 0.25rem !important;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .mb-4 {
            margin-bottom: 2rem !important;
        }

        .mb-5 {
            margin-bottom: 3rem !important;
        }

        .p-1 {
            padding: 0.25rem !important;
        }

        .p-2 {
            padding: 0.5rem !important;
        }

        .p-3 {
            padding: 1rem !important;
        }

        .p-4 {
            padding: 2rem !important;
        }

        .p-5 {
            padding: 3rem !important;
        }

        .pt-1 {
            padding-top: 0.25rem !important;
        }

        .pt-2 {
            padding-top: 0.5rem !important;
        }

        .pt-3 {
            padding-top: 1rem !important;
        }

        .pt-4 {
            padding-top: 2rem !important;
        }

        .pt-5 {
            padding-top: 3rem !important;
        }

        .text-white {
            color: #fff !important;
        }

        .text-primary {
            color: #007bff !important;
        }

        .text-left {
            text-align: left !important;
        }

        .bg-primary {
            background-color: #007bff !important;
        }

        .bg-danger {
            background-color: #dc3545 !important
        }

        .float-right {
            float: right !important;
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
            z-index: 99;
            border-top: 1px solid #000;
            width: 210px;
        }

        .hr_rodape {
            /* background-color: red; */
            border-top: 1px dashed #000;
            width: 210px;
        }

        .espacamento_titulo {
            height: 30px !important;
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

        .barra_topo_sem_cor {
            width: 100%;
            height: 20px;
            top: 0px;
            left: 0;
            right: 0;
            position: fixed;
            background-color: transparent;
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

        .barra_rodape_sem_cor {
            width: 100%;
            height: 40px;
            bottom: 0px;
            left: 0;
            right: 0;
            position: fixed;
            background-color: transparent;
        }

        .titulo_topo_para_espacamento {
            z-index: 9;
            position: absolute;
            margin-top: 15px;
            width: 24% !important;
            margin-left: 520px;
            border-top: 30px solid transparent;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
        }

        .titulo_topo {
            z-index: 9;
            position: absolute;
            margin-top: 10px;
            /* width: 24% !important; */
            margin-left: 570px;
            border-top: 30px solid transparent;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
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

        .titulo_topo h5,
        .titulo_topo_esquerda h5 {
            margin-top: -30px !important;
            font-style: normal;
            font-size: 12px;
            color: #fff;
            text-align: center;
        }

        .numero_pagina {
            z-index: 9;
            position: absolute;
            width: 10% !important;
            /* margin-left: 670px; */
            margin-top: 1085px !important;
            border-top: 30px solid transparent;
            border-left: -15px solid transparent;
            border-right: -15px solid transparent;
        }

        .numero_pagina_esquerda {
            z-index: 9;
            position: absolute;
            width: 10% !important;
            margin-left: 670px;
            margin-top: 1085px !important;
            border-top: 30px solid transparent;
            border-left: -15px solid transparent;
            border-right: -15px solid transparent;
        }

        .numero_pagina h4,
        .numero_pagina_esquerda h4 {
            margin-top: -30px !important;
            font-style: normal;
            font-size: 12px;
            color: #fff;
            text-align: center;
        }

        .titulo_categoria {}

        .titulo_categoria h1 {}

        .produto {
            position: absolute;
            /* background-color: red; */
        }

        .produto h6 {
            z-index: 9;
            font-size: 0.575em;
        }

        .produto img {
            width: 140px !important;
            margin-top: 40px;
            margin-left: 30px;
        }

        .produto .codigo {
            z-index: 9;
            font-size: 10px;
        }

        .produto .titulo {
            width: 210px;
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
            height: 30px;
            font-size: 10px;
            color: #1448A3;
        }

        .produto .conteudo .aplicacao b {
            color: #000;
        }

        .categoria-1 {
            z-index: 9;
            position: absolute;
            height: 330px !important;
            width: 180px !important;
            margin-left: 50px;
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

        .categoria-4 {
            z-index: 9;
            position: absolute;
            height: 330px !important;
            width: 180px !important;
            margin-left: 50px;
            margin-top: -25px;
            padding: 0px !important;
            border-bottom: 230px solid #1448A3;
            border-right: 45px solid transparent;
        }

        .categoria-4 h4 {
            z-index: 10;
            color: #fff;
            font-size: 27px;
            margin-top: 420px;
            margin-left: 10px;
        }

        .categoria-7 {
            z-index: 9;
            position: absolute;
            height: 330px !important;
            width: 180px !important;
            margin-left: 50px;
            margin-top: 245px;
            padding: 0px !important;
            border-bottom: 230px solid #1448A3;
            border-right: 45px solid transparent;
        }

        .categoria-7 h4 {
            z-index: 10;
            color: #fff;
            font-size: 27px;
            margin-top: 420px;
            margin-left: 10px;
        }

        .categoria-10 {
            z-index: 9;
            position: absolute;
            height: 330px !important;
            width: 180px !important;
            margin-left: 50px;
            margin-top: 510px;
            padding: 0px !important;
            border-bottom: 230px solid #1448A3;
            border-right: 45px solid transparent;
        }

        .categoria-10 h4 {
            z-index: 10;
            color: #fff;
            font-size: 27px;
            margin-top: 420px;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <?php
    $pageNumber = $page; // número da página. serve para printar o numero da pagina
    $line = 1; // linha atual. serve pra por o estilo correto de cada produto na pagina
    $pageType = true; // se true é pagina par, se impar é pagina impar
    $lastBlock = 0; // contabiliza o ultimo bloco
    // $parada2 = 3; // para testes
    ?>

    <!-- barra azul que fica no topo da página -->
    <div class="barra_topo"></div>
    {{-- <div class="barra_topo_sem_cor"></div> --}}


    @foreach($categories->subcategories()->orderBy('title', 'ASC')->get() as $subcategory)
    <?php
    // para testes
    // if ($parada2 === 0) {
    //     break;
    // } else {
    //     $parada2 -= 1;
    // }
    ?>

    <!-- se tiver mais de 10 itens e estiver na primeira posicao da pagina, coloque o titulo no topo da pagina. Se n, só coloque o espaçamento para n quebrar a pagina -->
    <!-- {{--$category->product()->count() > 10--}} -->
    <!-- {{--@if(($category->product()->count() > 10 && $line == 1))--}} -->
    <!-- título do topo da página -->
    {{-- <div class="titulo_topo">
        <h4>{{ $subcategory->title }}</h4>
    </div> --}}
    {{-- @else
    <div class="titulo_topo_para_espacamento"></div>
    @endif --}}
    <!-- título do topo da página -->

    <!-- titulo da categoria no corpo da pagina -->
    @if($line == 1)
    <div class="categoria-1">
        <h4>{{$subcategory->title  }}</h4>
        <hr class="hr_titulo_categoria">
    </div>
    @elseif($line == 4)
    <div class="categoria-4">
        <h4>{{$subcategory->title  }}</h4>
        <hr class="hr_titulo_categoria">
    </div>
    @elseif($line == 7)
    <div class="categoria-7">
        <h4>{{$subcategory->title  }}</h4>
        <hr class="hr_titulo_categoria">
    </div>
    @elseif($line == 10)
    <div class="categoria-10">
        <h4>{{$subcategory->title  }}</h4>
        <hr class="hr_titulo_categoria">
    </div>
    @endif

    <?php
    // para testes
    // $parada3 = 10; // p/ testes
    // posicao dos blocos
    $pos11 = $pos12 = $pos13 = 0;
    $pos21 = $pos22 = $pos23 = 0;
    $pos31 = $pos32 = $pos33 = 0;
    $pos41 = $pos42 = $pos43 = 0;
    // status dos blocos
    $status11 = $status12 = $status13 = true;
    $status21 = $status22 = $status23 = false;
    $status31 = $status32 = $status33 = false;
    $status41 = $status42 = $status43 = false;
    ?>
    <!-- produtos da categoria -->
    <!-- {{-- $category->customSelectProducts() --}} -->
    @foreach($subcategory->products()->orderBy('id', 'ASC')->orderBy('description', 'ASC')->orderBy('application', 'ASC')->get() as $data)
        <?php
        // para testes
        // if ($parada3 === 0) {
        //     break;
        // } else {
        //     $parada3 -= 1;
        // }
        ?>

        <?php $lastBlock += 1; ++$line; ?>

        <?php
            // mecanismo para ajustar altura do conteudo e fazer texto caber dentro
            $var = $data->application;
            // $var = 'GSX1000R 2018 A 2020/GSX750 SRAD 1996 A 2016/BANDIT650 2007 A 2016/GSX 1300R HAYABUSA 1999 A 2007/YZF R1 2004 A 2008/CB300R 2013 A 2015/XRE300 2013 A 2015/TNT 1130 CAFE RACER 2006 A 2010/DUCATI999R 2002 A 2006/ZZR1200 2002 A 2005/NINJA ZX-9R 1998 A 2003';
            $len = strlen($var);
            if ($len <= 35)
            $alturaConteudo = 40;
            else if($len > 35 && $len <= 65)
            $alturaConteudo = 45;
            else if($len > 65 && $len <= 95)
            $alturaConteudo = 55;
            else if($len > 95 && $len <= 125)
            $alturaConteudo = 65;
            else if($len > 125 && $len <= 155)
            $alturaConteudo = 75;
            else if($len > 155 && $len <= 185)
            $alturaConteudo = 85;
            else if($len > 185 && $len <= 215)
            $alturaConteudo = 95;
            else
            $alturaConteudo = 105;

            // ajuste para quando nao houver necessidade de modificar a posicao.
            // cada item deve ser guardado a sua altura para compensar no item logo abaixo.
            // a posicao atual do item é ajustado de acordo com os anteriores, pois o item
            // atual pode ter vindo de um com modificação de altura.
            if ($alturaConteudo <= 60 && $line == 1){
                $pos11 = $alturaConteudo;
                $novaPosicao = -20;
                $novaPosicaoHoriz = 50;
            }else if ($alturaConteudo <= 60 && $line == 2){
                $pos12 = $alturaConteudo;
                $novaPosicao = -20;
                $novaPosicaoHoriz = 280;
            }else if ($alturaConteudo <= 60 && $line == 3){
                $pos13 = $alturaConteudo;
                $novaPosicao = -20;
                $novaPosicaoHoriz = 520;
            }else if($alturaConteudo <= 60 && $line == 4){
                $pos21 = $alturaConteudo + $pos11;
                $novaPosicao = 243 + $pos11;
                $novaPosicaoHoriz = 50;
            }else if($alturaConteudo <= 60 && $line == 5){
                $pos22 = $alturaConteudo + $pos12;
                $novaPosicao = 243 + $pos12;
                $novaPosicaoHoriz = 280;
            }else if($alturaConteudo <= 60 && $line == 6){
                $pos23 = $alturaConteudo + $pos13;
                $novaPosicao = 243 + $pos13;
                $novaPosicaoHoriz = 520;
            }else if ($alturaConteudo <= 60 && $line == 7){
                $pos31 = $alturaConteudo + $pos21;
                $novaPosicao = 505 + $pos21;
                $novaPosicaoHoriz = 50;
            }else if ($alturaConteudo <= 60 && $line == 8){
                $pos32 = $alturaConteudo + $pos22;
                $novaPosicao = 505 + $pos22;
                $novaPosicaoHoriz = 280;
            }else if ($alturaConteudo <= 60 && $line == 9){
                $pos33 = $alturaConteudo + $pos23;
                $novaPosicao = 505 + $pos23;
                $novaPosicaoHoriz = 520;
            }else if ($alturaConteudo <= 60 && $line == 10){
                $novaPosicao = 770 + $pos31;
                $novaPosicaoHoriz = 50;
            }else if ($alturaConteudo <= 60 && $line == 11){
                $novaPosicao = 770 + $pos32;
                $novaPosicaoHoriz = 280;
            }else if ($alturaConteudo <= 60 && $line == 12){
                $novaPosicao = 770 + $pos33;
                $novaPosicaoHoriz = 520;
            }

            // condições quando houver a necessidade de modificar o tamanho do item atual
            // e transmitir esse ajuste para os itens abaixo
            // linha 2 (capturando ajuste para o item de baixo e ajustando posicao atual do item)
            if ($alturaConteudo > 60 && $line == 1){
                $pos11 = $alturaConteudo;
                $pos21 = $alturaConteudo;
                $status21 = true;
                $novaPosicao = -20;
                $novaPosicaoHoriz = 50;
            }else if ($alturaConteudo > 60 && $line == 2){
                $pos12 = $alturaConteudo;
                $pos22 = $alturaConteudo;
                $status22 = true;
                $novaPosicao = -20;
                $novaPosicaoHoriz = 280;
            }else if ($alturaConteudo > 60 && $line == 3){
                $pos13 = $alturaConteudo;
                $pos23 = $alturaConteudo;
                $status23 = true;
                $novaPosicao = -20;
                $novaPosicaoHoriz = 520;
            } // linha 3 (capturando ajuste para o item de baixo e ajustando posicao atual do item)
            else if ($alturaConteudo > 60 && $line == 4){
                $pos21 = $alturaConteudo + $pos11;
                $pos31 = $alturaConteudo;
                $status31 = true;
                $novaPosicao = 243 + $pos11;
                $novaPosicaoHoriz = 50;
            }else if ($alturaConteudo > 60 && $line == 5){
                $pos22 = $alturaConteudo + $pos12;
                $pos32 = $alturaConteudo;
                $status32 = true;
                $novaPosicao = 243 + $pos12;
                $novaPosicaoHoriz = 280;
            }else if ($alturaConteudo > 60 && $line == 6){
                $pos23 = $alturaConteudo + $pos13;
                $pos33 = $alturaConteudo;
                $status33 = true;
                $novaPosicao = 243 + $pos13;
                $novaPosicaoHoriz = 520;
            } // linha 4 (capturando ajuste para o item de baixo e ajustando posicao atual do item)
            else if ($alturaConteudo > 60 && $line == 7){
                $pos31 = $alturaConteudo + $pos21;
                $pos41 = $alturaConteudo;
                $status41 = true;
                $novaPosicao = 505 + $pos21;
                $novaPosicaoHoriz = 50;
            }else if ($alturaConteudo > 60 && $line == 8){
                $pos32 = $alturaConteudo + $pos22;
                $pos42 = $alturaConteudo;
                $status42 = true;
                $novaPosicao = 505 + $pos22;
                $novaPosicaoHoriz = 280;
            }else if ($alturaConteudo > 60 && $line == 9){
                $pos33 = $alturaConteudo + $pos23;
                $pos43 = $alturaConteudo;
                $status43 = true;
                $novaPosicao = 505 + $pos23;
                $novaPosicaoHoriz = 520;
            }
            
            // ajustando itens da linha 4
            // condição para verificar se os itens a partir da linha 10 irão ou não caber
            // na página.
            if ($alturaConteudo > 60 && $line == 10){
                if ((770 + $alturaConteudo - 30) > 770){
                    // posicao dos blocos
                    $pos11 = $pos12 = $pos13 = 0;
                    $pos21 = $pos22 = $pos23 = 0;
                    $pos31 = $pos32 = $pos33 = 0;
                    $pos41 = $pos42 = $pos43 = 0;
                    // status dos blocos
                    $status11 = $status12 = $status13 = true;
                    $status21 = $status22 = $status23 = false;
                    $status31 = $status32 = $status33 = false;
                    $status41 = $status42 = $status43 = false;

                    $line = 1;
                    ?>
                    <!-- barra azul que fica no rodappe da página -->
                    <div class="barra_rodape"></div>
                    {{-- <div class="barra_rodape_sem_cor"></div> --}}

                    {{-- coloca numero da pagina no local certo --}}
                    @if($pageNumber % 2 == 0)
                    <!-- número da página -->
                    <div class="numero_pagina_esquerda">
                        <h4>{{ ++$pageNumber }}</h4>
                    </div>
                    @else
                    <!-- número da página -->
                    <div class="numero_pagina">
                        <h4>{{ ++$pageNumber }}</h4>
                    </div>
                    @endif

                    {{-- coloca titulo da pagina no local correto --}}
                    @if($pageNumber % 2 == 0)
                    <div class="titulo_topo_esquerda">
                        <h5>{{ $subcategory->title }}</h5>
                    </div>
                    @else
                    <div class="titulo_topo">
                        <h5>{{ $subcategory->title }}</h5>
                    </div>
                    @endif
                    
                    <!-- salta-página -->
                    <div class="page_break"></div>
                    <?php
                }else {
                    $novaPosicao = 770 + $alturaConteudo - 30;
                    $novaPosicaoHoriz = 50;
                }
            } else if ($alturaConteudo <= 60 && $line == 10){
                if ((770 + $alturaConteudo - 30) > 770){
                    // posicao dos blocos
                    $pos11 = $pos12 = $pos13 = 0;
                    $pos21 = $pos22 = $pos23 = 0;
                    $pos31 = $pos32 = $pos33 = 0;
                    $pos41 = $pos42 = $pos43 = 0;
                    // status dos blocos
                    $status11 = $status12 = $status13 = true;
                    $status21 = $status22 = $status23 = false;
                    $status31 = $status32 = $status33 = false;
                    $status41 = $status42 = $status43 = false;

                    $line = 1;
                    ?>
                    <!-- barra azul que fica no rodappe da página -->
                    <div class="barra_rodape"></div>
                    {{-- <div class="barra_rodape_sem_cor"></div> --}}

                    {{-- coloca numero da pagina no local certo --}}
                    @if($pageNumber % 2 == 0)
                    <!-- número da página -->
                    <div class="numero_pagina_esquerda">
                        <h4>{{ ++$pageNumber }}</h4>
                    </div>
                    @else
                    <!-- número da página -->
                    <div class="numero_pagina">
                        <h4>{{ ++$pageNumber }}</h4>
                    </div>
                    @endif

                    {{-- coloca titulo da pagina no local correto --}}
                    @if($pageNumber % 2 == 0)
                    <div class="titulo_topo_esquerda">
                        <h5>{{ $subcategory->title }}</h5>
                    </div>
                    @else
                    <div class="titulo_topo">
                        <h5>{{ $subcategory->title }}</h5>
                    </div>
                    @endif

                    <!-- salta-página -->
                    <div class="page_break"></div>
                    <?php
                }else {
                    $novaPosicao = 770 + $alturaConteudo - 30;
                    $novaPosicaoHoriz = 50;
                }
            } else if ($alturaConteudo > 60 && $line == 11){
                if ((770 + $alturaConteudo - 30) > 770){
                    // posicao dos blocos
                    $pos11 = $pos12 = $pos13 = 0;
                    $pos21 = $pos22 = $pos23 = 0;
                    $pos31 = $pos32 = $pos33 = 0;
                    $pos41 = $pos42 = $pos43 = 0;
                    // status dos blocos
                    $status11 = $status12 = $status13 = true;
                    $status21 = $status22 = $status23 = false;
                    $status31 = $status32 = $status33 = false;
                    $status41 = $status42 = $status43 = false;

                    $line = 1;
                    ?>
                    <!-- barra azul que fica no rodappe da página -->
                    <div class="barra_rodape"></div>
                    {{-- <div class="barra_rodape_sem_cor"></div> --}}

                    {{-- coloca numero da pagina no local certo --}}
                    @if($pageNumber % 2 == 0)
                    <!-- número da página -->
                    <div class="numero_pagina_esquerda">
                        <h4>{{ ++$pageNumber }}</h4>
                    </div>
                    @else
                    <!-- número da página -->
                    <div class="numero_pagina">
                        <h4>{{ ++$pageNumber }}</h4>
                    </div>
                    @endif

                    {{-- coloca titulo da pagina no local correto --}}
                    @if($pageNumber % 2 == 0)
                    <div class="titulo_topo_esquerda">
                        <h5>{{ $subcategory->title }}</h5>
                    </div>
                    @else
                    <div class="titulo_topo">
                        <h5>{{ $subcategory->title }}</h5>
                    </div>
                    @endif

                    <!-- salta-página -->
                    <div class="page_break"></div>
                    <?php
                }else {
                    $novaPosicao = 770 + $alturaConteudo - 30;
                    $novaPosicaoHoriz = 50;
                }
            } else if ($alturaConteudo <= 60 && $line == 11){
                if ((770 + $alturaConteudo - 30) > 770){
                    // posicao dos blocos
                    $pos11 = $pos12 = $pos13 = 0;
                    $pos21 = $pos22 = $pos23 = 0;
                    $pos31 = $pos32 = $pos33 = 0;
                    $pos41 = $pos42 = $pos43 = 0;
                    // status dos blocos
                    $status11 = $status12 = $status13 = true;
                    $status21 = $status22 = $status23 = false;
                    $status31 = $status32 = $status33 = false;
                    $status41 = $status42 = $status43 = false;

                    $line = 1;
                    ?>
                    <!-- barra azul que fica no rodappe da página -->
                    <div class="barra_rodape"></div>
                    {{-- <div class="barra_rodape_sem_cor"></div> --}}

                    {{-- coloca numero da pagina no local certo --}}
                    @if($pageNumber % 2 == 0)
                    <!-- número da página -->
                    <div class="numero_pagina_esquerda">
                        <h4>{{ ++$pageNumber }}</h4>
                    </div>
                    @else
                    <!-- número da página -->
                    <div class="numero_pagina">
                        <h4>{{ ++$pageNumber }}</h4>
                    </div>
                    @endif

                    {{-- coloca titulo da pagina no local correto --}}
                    @if($pageNumber % 2 == 0)
                    <div class="titulo_topo_esquerda">
                        <h5>{{ $subcategory->title }}</h5>
                    </div>
                    @else
                    <div class="titulo_topo">
                        <h5>{{ $subcategory->title }}</h5>
                    </div>
                    @endif

                    <!-- salta-página -->
                    <div class="page_break"></div>
                    <?php
                }else {
                    $novaPosicao = 770 + $alturaConteudo - 30;
                    $novaPosicaoHoriz = 50;
                }
            } else if ($alturaConteudo > 60 && $line == 12){
                if ((770 + $alturaConteudo - 30) > 770){
                    // posicao dos blocos
                    $pos11 = $pos12 = $pos13 = 0;
                    $pos21 = $pos22 = $pos23 = 0;
                    $pos31 = $pos32 = $pos33 = 0;
                    $pos41 = $pos42 = $pos43 = 0;
                    // status dos blocos
                    $status11 = $status12 = $status13 = true;
                    $status21 = $status22 = $status23 = false;
                    $status31 = $status32 = $status33 = false;
                    $status41 = $status42 = $status43 = false;

                    $line = 1;
                    ?>
                    <!-- barra azul que fica no rodappe da página -->
                    <div class="barra_rodape"></div>
                    {{-- <div class="barra_rodape_sem_cor"></div> --}}

                    {{-- coloca numero da pagina no local certo --}}
                    @if($pageNumber % 2 == 0)
                    <!-- número da página -->
                    <div class="numero_pagina_esquerda">
                        <h4>{{ ++$pageNumber }}</h4>
                    </div>
                    @else
                    <!-- número da página -->
                    <div class="numero_pagina">
                        <h4>{{ ++$pageNumber }}</h4>
                    </div>
                    @endif

                    {{-- coloca titulo da pagina no local correto --}}
                    @if($pageNumber % 2 == 0)
                    <div class="titulo_topo_esquerda">
                        <h5>{{ $subcategory->title }}</h5>
                    </div>
                    @else
                    <div class="titulo_topo">
                        <h5>{{ $subcategory->title }}</h5>
                    </div>
                    @endif

                    <!-- salta-página -->
                    <div class="page_break"></div>
                    <?php
                }else {
                    $novaPosicao = 770 + $alturaConteudo - 30;
                    $novaPosicaoHoriz = 50;
                }
            } else if ($alturaConteudo <= 60 && $line == 12){
                if ((770 + $alturaConteudo - 30) > 770){
                    // posicao dos blocos
                    $pos11 = $pos12 = $pos13 = 0;
                    $pos21 = $pos22 = $pos23 = 0;
                    $pos31 = $pos32 = $pos33 = 0;
                    $pos41 = $pos42 = $pos43 = 0;
                    // status dos blocos
                    $status11 = $status12 = $status13 = true;
                    $status21 = $status22 = $status23 = false;
                    $status31 = $status32 = $status33 = false;
                    $status41 = $status42 = $status43 = false;

                    $line = 1;
                    ?>
                    <!-- barra azul que fica no rodappe da página -->
                    <div class="barra_rodape"></div>
                    {{-- <div class="barra_rodape_sem_cor"></div> --}}

                    {{-- coloca numero da pagina no local certo --}}
                    @if($pageNumber % 2 == 0)
                    <!-- número da página -->
                    <div class="numero_pagina_esquerda">
                        <h4>{{ ++$pageNumber }}</h4>
                    </div>
                    @else
                    <!-- número da página -->
                    <div class="numero_pagina">
                        <h4>{{ ++$pageNumber }}</h4>
                    </div>
                    @endif

                    {{-- coloca titulo da pagina no local correto --}}
                    @if($pageNumber % 2 == 0)
                    <div class="titulo_topo_esquerda">
                        <h5>{{ $subcategory->title }}</h5>
                    </div>
                    @else
                    <div class="titulo_topo">
                        <h5>{{ $subcategory->title }}</h5>
                    </div>
                    @endif


                    <!-- salta-página -->
                    <div class="page_break"></div>
                    <?php
                }else {
                    $novaPosicao = 770 + $alturaConteudo - 30;
                    $novaPosicaoHoriz = 50;
                }
            }

            // linha 1
            if ($line == 1 && $status11){
                $pos11 = $alturaConteudo;
                // ajeitar posicao do bloco
                $novaPosicao = -20;
                $novaPosicaoHoriz = 50;
            }else if($line == 2 && $status12){
                $pos12 = $alturaConteudo;
                // ajeitar posicao do bloco
                $novaPosicao = -20;
                $novaPosicaoHoriz = 280;
            } else if($line == 3 && $status13){
                $pos13 = $alturaConteudo;
                // ajeitar posicao do bloco
                $novaPosicao = -20;
                $novaPosicaoHoriz = 520;
            }// if para forçar o item 3 ficar na posicao correta quando estiver no inicio da subcategoria
            else if($lastBlock == 3){ 
                // ajeitar posicao do bloco
                $novaPosicao = 243;
                $novaPosicaoHoriz = 50;
            }
            // linha 2
            else if ($line == 4 && $status21){
                // pular posicao do bloco
                $novaPosicao = 243 + $pos11;
                $novaPosicaoHoriz = 50;
            }else if ($line == 5 && $status22){
                // pular posicao do bloco
                $novaPosicao = 243 + $pos12;
                $novaPosicaoHoriz = 280;
            }else if ($line == 6 && $status23){
                // pular posicao do bloco
                $novaPosicao = 243 + $pos13;
                $novaPosicaoHoriz = 520;
            } // linha 3
            else if ($line == 7 && $status31){
                // pular posicao do bloco
                $novaPosicao = 505 + $pos21;
                $novaPosicaoHoriz = 50;
            }else if ($line == 8 && $status32){
                // pular posicao do bloco
                $novaPosicao = 505 + $pos22;
                $novaPosicaoHoriz = 280;
            }else if ($line == 9 && $status33){
                // pular posicao do bloco
                $novaPosicao = 505 + $pos23;
                $novaPosicaoHoriz = 520;
            } // linha 4
            else if ($line == 10 && $status41){
                // pular posicao do bloco
                $novaPosicao = 770 + $pos41 + $pos31;
                $novaPosicaoHoriz = 50;
            }else if ($line == 11 && $status42){
                // pular posicao do bloco
                $novaPosicao = 770 + $pos42 + $pos32;
                $novaPosicaoHoriz = 280;
            }else if ($line == 12 && $status43){
                // pular posicao do bloco
                $novaPosicao = 770 + $pos43 + $pos33;
                $novaPosicaoHoriz = 520;
            }

            
        ?>


        <!-- produto -->
        <div class="produto col-md-4 text-center card-pdf-1{{ $line }}" 
        style="{{ (isset($novaPosicao) ? 'margin-top:' . $novaPosicao . 'px!important; ' : 'n_achou') }}
        {{ (isset($novaPosicao) ? 'margin-left:' . $novaPosicaoHoriz . 'px!important; ' : 'n_achou') }}">
            <img style="width: 105px!important;" src="{{$data->cover != '' ? 'storage/' . $data->cover : 'storage/no_image_available.jpg'}}">
            <div style="text-align: right!important; padding: 0px 0px; margin-top: -15px!important;">
                @foreach($data->brands($data)->get() as $brand)
                <img style="{{$loop->count > 5 ? 'width: 26px!important;' : 'width: 38px!important;'}} margin: 0px!important; padding: 0px!important; padding-left: 5px; {{$loop->count > 1 ? 'padding: 15px 0px -5px 0px;' : 'padding: 5px 0px;'}}" src="{{$brand->image != '' ? 'storage/' . $brand->image : 'storage/no_image_available.jpg'}}">
                @endforeach
            </div>
            <hr class="hr_titulo">
            <div class="codigo">
                <div style="position: absolute; width: 25px; border-top: 15px solid #1448A3; border-right: 5px solid transparent; color: #fff;">
                    <h4 style="margin-top: -15px;">CÓD.:</h4>
                </div>
                <h4 style="z-index: 9; margin-left: 35px;">{{$data->cod}}</h4>
                <!-- <h6>CÓD.: {{$data->cod}} | count:{{$loop->count}}| lastBlock:{{$lastBlock}} | line:{{$line}} | oi:{{$subcategory->products()->count()}}| {{($lastBlock == $loop->count ? 'true' : 'false')}}</h6> -->
                <!-- <h6> </h6> -->
            </div>
            <div class="titulo">
                <h4 class="text-left m-0">{{Str::limit(str_replace('/', '/ ', $data->description), 60)}}</h4> <!-- {{(str_word_count($data->title) < 4 ? 'espacamento_titulo' : '')}} -->
            </div>
            <div class="conteudo" style="height: {{ $alturaConteudo }};">
            {{-- $alturaConteudo . ' - ' . $novaPosicao --}}
            {{-- $alturaConteudo .  (isset($novaPosicao) ? 'margin-top:' . $novaPosicao . 'px!important; ' : 'n_achou') --}}
            {{-- $line . ' - ' . ($status21 ? '1' : 0) . ($status22 ? '1' : 0) . ($status23 ? '1' : 0) . ' \ ' . ($status31 ? '1' : 0) . ($status32 ? '1' : 0) . ($status33 ? '1' : 0) . ' \ ' . ($status41 ? '1' : 0) . ($status42 ? '1' : 0) . ($status43 ? '1' : 0) --}}
                <h4 class="marca">MARCA: <b>
                        @foreach($data->brands($data)->get() as $brand)
                            {{$brand->title . ($loop->last ? '' : ' / ')}}
                        @endforeach
                    </b></h4>
                <h4 class="aplicacao">APLICAÇÃO: <b>{{$var}}</b></h4>
            </div>
            <hr class="hr_rodape">
        </div>

        <?php
        if ($line == 1 && $status11){
            // resetar bloco
            $status11 = false;
        }else if($line == 2 && $status12){
            // resetar bloco
            $status12 = false;
        } else if($line == 3 && $status13){
            // resetar bloco
            $status13 = false;
        }else if ($line == 4 && $status21){
            // resetar bloco
            $status21 = false;
        }else if ($line == 5 && $status22){
            // resetar bloco
            $status22 = false;
        }else if ($line == 6 && $status23){
            // resetar bloco
            $status23 = false;
        } // linhas 3
        else if ($line == 7 && $status31){
            // resetar bloco
            $status31 = false;
        }else if ($line == 8 && $status32){
            // resetar bloco
            $status32 = false;
        }else if ($line == 9 && $status33){
            // resetar bloco
            $status33 = false;
        } // linha 4
        else if ($line == 10 && $status41){
            // resetar bloco
            $status41 = false;
        }else if ($line == 11 && $status42){
            // resetar bloco
            $status42 = false;
        }else if ($line == 12 && $status43){
            // resetar bloco
            $status43 = false;
        }

        // saltar pagina caso nao couber mais itens
        if ((isset($novaPosicao) && $novaPosicao > 770) && $line > 9){
            // posicao dos blocos
            $pos11 = $pos12 = $pos13 = 0;
            $pos21 = $pos22 = $pos23 = 0;
            $pos31 = $pos32 = $pos33 = 0;
            $pos41 = $pos42 = $pos43 = 0;
            // status dos blocos
            $status11 = $status12 = $status13 = true;
            $status21 = $status22 = $status23 = false;
            $status31 = $status32 = $status33 = false;
            $status41 = $status42 = $status43 = false;

            $line = 0;
            ?>
            <!-- barra azul que fica no rodappe da página -->
            <div class="barra_rodape"></div>
            {{-- <div class="barra_rodape_sem_cor"></div> --}}

            {{-- coloca numero da pagina no local certo --}}
            @if($pageNumber % 2 == 0)
            <!-- número da página -->
            <div class="numero_pagina_esquerda">
                <h4>{{ ++$pageNumber }}</h4>
            </div>
            @else
            <!-- número da página -->
            <div class="numero_pagina">
                <h4>{{ ++$pageNumber }}</h4>
            </div>
            @endif

            {{-- coloca titulo da pagina no local correto --}}
            @if($pageNumber % 2 == 0)
            <div class="titulo_topo_esquerda">
                <h5>{{ $subcategory->title }}</h5>
            </div>
            @else
            <div class="titulo_topo">
                <h5>{{ $subcategory->title }}</h5>
            </div>
            @endif

            <!-- salta-página -->
            <div class="page_break"></div>
            <?php
        }
        ?>

        <!-- caso a lista de produtos da subcategoria acabe na primeira linha (entre os blocos 1, 2 e 3) -->
        @if($lastBlock == $loop->count && ($line == 1 || $line == 2 || $line == 3))
            <?php
            $lastBlock = 0;
            $line = 1;
            ?>
                <!-- barra azul que fica no rodappe da página -->
                <div class="barra_rodape"></div>
                {{-- <div class="barra_rodape_sem_cor"></div> --}}

                {{-- coloca numero da pagina no local certo --}}
                @if($pageNumber % 2 == 0)
                <!-- número da página -->
                <div class="numero_pagina_esquerda">
                    <h4>{{ ++$pageNumber }}</h4>
                </div>
                @else
                <!-- número da página -->
                <div class="numero_pagina">
                    <h4>{{ ++$pageNumber }}</h4>
                </div>
                @endif

                {{-- coloca titulo da pagina no local correto --}}
                @if($pageNumber % 2 == 0)
                <div class="titulo_topo_esquerda">
                    <h5>{{ $subcategory->title }}</h5>
                </div>
                @else
                <div class="titulo_topo">
                    <h5>{{ $subcategory->title }}</h5>
                </div>
                @endif

                <!-- salta-página -->
                <div class="page_break"></div>
            
            <!-- número da página -->
            {{-- <div class="numero_pagina">
                <h4>{{ $pageNumber }}</h4>
            </div> --}}
        <!-- caso a lista de produtos da subcategoria acabe na segunda linha (entre os blocos 4, 5 e 6) -->
        @elseif($lastBlock == $loop->count && ($line == 4 || $line == 5 || $line == 6))
            <?php
            $lastBlock = 0;
            $line = 1;
            ?>
            <!-- barra azul que fica no rodappe da página -->
            <div class="barra_rodape"></div>
            {{-- <div class="barra_rodape_sem_cor"></div> --}}

            {{-- coloca numero da pagina no local certo --}}
            @if($pageNumber % 2 == 0)
            <!-- número da página -->
            <div class="numero_pagina_esquerda">
                <h4>{{ ++$pageNumber }}</h4>
            </div>
            @else
            <!-- número da página -->
            <div class="numero_pagina">
                <h4>{{ ++$pageNumber }}</h4>
            </div>
            @endif

            {{-- coloca titulo da pagina no local correto --}}
            @if($pageNumber % 2 == 0)
            <div class="titulo_topo_esquerda">
                <h5>{{ $subcategory->title }}</h5>
            </div>
            @else
            <div class="titulo_topo">
                <h5>{{ $subcategory->title }}</h5>
            </div>
            @endif

            <!-- salta-página -->
            <div class="page_break"></div>

            <!-- número da página -->
            {{-- <div class="numero_pagina">
                <h4>{{ $pageNumber }}</h4>
            </div> --}}
        <!-- caso a lista de produtos da subcategoria acabe na terceira linha (entre os blocos 7, 8 e 9) -->
        @elseif($lastBlock == $loop->count && ($line == 7 || $line == 8 || $line == 9))
            <?php
            $lastBlock = 0;
            $line = 1;
            ?>
            <!-- barra azul que fica no rodappe da página -->
            <div class="barra_rodape"></div>
            {{-- <div class="barra_rodape_sem_cor"></div> --}}

            {{-- coloca numero da pagina no local certo --}}
            @if($pageNumber % 2 == 0)
            <!-- número da página -->
            <div class="numero_pagina_esquerda">
                <h4>{{ ++$pageNumber }}</h4>
            </div>
            @else
            <!-- número da página -->
            <div class="numero_pagina">
                <h4>{{ ++$pageNumber }}</h4>
            </div>
            @endif

            {{-- coloca titulo da pagina no local correto --}}
            @if($pageNumber % 2 == 0)
            <div class="titulo_topo_esquerda">
                <h5>{{ $subcategory->title }}</h5>
            </div>
            @else
            <div class="titulo_topo">
                <h5>{{ $subcategory->title }}</h5>
            </div>
            @endif

            <!-- salta-página -->
            <div class="page_break"></div>

            <!-- número da página -->
            {{-- <div class="numero_pagina">
                <h4>{{ $pageNumber }}</h4>
            </div> --}}
        <!-- caso a lista de produtos da subcategoria acabe na quarta linha (entre os blocos 10, 11 e 12) -->
        @elseif($lastBlock == $loop->count && ($line == 10 || $line == 11 || $line == 12))
            <?php
            $lastBlock = 0;
            $line = 1;
            ?>
            <!-- barra azul que fica no rodappe da página -->
            <div class="barra_rodape"></div>
            {{-- <div class="barra_rodape_sem_cor"></div> --}}

            {{-- coloca numero da pagina no local certo --}}
            @if($pageNumber % 2 == 0)
            <!-- número da página -->
            <div class="numero_pagina_esquerda">
                <h4>{{ ++$pageNumber }}</h4>
            </div>
            @else
            <!-- número da página -->
            <div class="numero_pagina">
                <h4>{{ ++$pageNumber }}</h4>
            </div>
            @endif

            {{-- coloca titulo da pagina no local correto --}}
            @if($pageNumber % 2 == 0)
            <div class="titulo_topo_esquerda">
                <h5>{{ $subcategory->title }}</h5>
            </div>
            @else
            <div class="titulo_topo">
                <h5>{{ $subcategory->title }}</h5>
            </div>
            @endif

            <!-- salta-página -->
            <div class="page_break"></div>
        <!-- caso a lista de produtos da subcategoria acabe na quarta linha e exatamente em cima do item 12 -->
        @elseif($lastBlock == $loop->count && ($line == 12))
            <?php
            $lastBlock = 0;
            $line = 1;
            ?>
            <!-- barra azul que fica no rodappe da página -->
            <div class="barra_rodape"></div>
            {{-- <div class="barra_rodape_sem_cor"></div> --}}

            {{-- coloca numero da pagina no local certo --}}
            @if($pageNumber % 2 == 0)
            <!-- número da página -->
            <div class="numero_pagina_esquerda">
                <h4>{{ ++$pageNumber }}</h4>
            </div>
            @else
            <!-- número da página -->
            <div class="numero_pagina">
                <h4>{{ ++$pageNumber }}</h4>
            </div>
            @endif

            {{-- coloca titulo da pagina no local correto --}}
            @if($pageNumber % 2 == 0)
            <div class="titulo_topo_esquerda">
                <h5>{{ $subcategory->title }}</h5>
            </div>
            @else
            <div class="titulo_topo">
                <h5>{{ $subcategory->title }}</h5>
            </div>
            @endif

            <!-- salta-página -->
            <div class="page_break"></div>
        <!-- caso a lista de produtos da subcategoria não acabe na quarta linha e o line esteja no item 12 -->
        @elseif($lastBlock != $loop->count && $line == 12)
            <?php
            // $lastBlock = 0;
            $line = 0;
            ?>
            <!-- barra azul que fica no rodappe da página -->
            <div class="barra_rodape"></div>
            {{-- <div class="barra_rodape_sem_cor"></div> --}}

            {{-- coloca numero da pagina no local certo --}}
            @if($pageNumber % 2 == 0)
            <!-- número da página -->
            <div class="numero_pagina_esquerda">
                <h4>{{ ++$pageNumber }}</h4>
            </div>
            @else
            <!-- número da página -->
            <div class="numero_pagina">
                <h4>{{ ++$pageNumber }}</h4>
            </div>
            @endif

            {{-- coloca titulo da pagina no local correto --}}
            @if($pageNumber % 2 == 0)
            <div class="titulo_topo_esquerda">
                <h5>{{ $subcategory->title }}</h5>
            </div>
            @else
            <div class="titulo_topo">
                <h5>{{ $subcategory->title }}</h5>
            </div>
            @endif

            <!-- salta-página -->
            <div class="page_break"></div>
        @endif

    @endforeach
    
    <!-- número da página -->
    {{-- <div class="numero_pagina">
        <h4>{{ ++$pageNumber }}</h4>
    </div> --}}

    <!-- salta-página -->
    <!-- <div class="page_break"></div> -->

    @endforeach

    <!-- barra azul que fica no rodappe da página -->
    {{-- <div class="barra_rodape"></div> --}}
    {{-- <div class="barra_rodape_sem_cor"></div> --}}

    {{-- coloca numero da pagina no local certo --}}
    {{-- @if($pageNumber % 2 == 0)
    <!-- número da página -->
    <div class="numero_pagina_esquerda">
        <h4>{{ ++$pageNumber }}</h4>
    </div>
    @else
    <!-- número da página -->
    <div class="numero_pagina">
        <h4>{{ ++$pageNumber }}</h4>
    </div>
    @endif --}}

    {{-- @if($pageNumber % 2 == 0)
    <div class="titulo_topo_esquerda">
        <h5>{{ $subcategory->title }}</h5>
    </div>
    @else
    <div class="titulo_topo">
        <h5>{{ $subcategory->title }}</h5>
    </div>
    @endif --}}

</body>

</html>