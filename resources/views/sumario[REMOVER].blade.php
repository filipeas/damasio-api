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
            position: absolute;
            height: 120px !important;
            width: 600px !important;
            margin-left: 90px;
            margin-top: 50px !important;
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

        .categoria-1 {
            z-index: 9;
            position: absolute;
            height: 30px !important;
            width: 310px !important;
            margin-left: 50px;
            margin-top: 200px !important;
            padding: 0px !important;
            /* padding-top: 90px !important; */
            border-bottom: 30px solid #1448A3;
            border-right: 20px solid transparent;
            /* border-left: -3px solid transparent; */
        }

        .categoria-1 h1 {
            z-index: 10;
            color: #fff;
            font-style: normal;
            font-size: 14px;
            margin-top: 30px;
            margin-left: 5px;
            text-align: left;
        }

        .box-sumario {
            margin-top: 260px !important;
            margin-left: 60px;
            width: 50%;
            /* background-color: red; */
        }

    </style>
</head>

<body>
    <!-- barra azul que fica no topo da página -->
    <div class="barra_topo"></div>

    <div class="titulo_topo_esquerda">
        <h5>SUMÁRIO</h5>
    </div>

    {{-- titulo do sumário --}}
    <div class="sumario">
        <h1>SUMÁRIO</h1>
    </div>

    {{-- conteudo do sumário --}}
    <div class="categoria-1">
        <h1>{{ $category->title }}</h1>
    </div>

    <div class="box-sumario">
        <table>
            @foreach ($pages as $key1 => $item)
                <tr>
                    @foreach ($item as $subcategoria => $pagina)
                        <td>{{ $subcategoria }}</td>
                        <td> ........................................ </td>
                        <td>{{ "Pág " . $pagina }}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>

    <!-- barra azul que fica no rodappe da página -->
    <div class="barra_rodape"></div>

</body>

</html>
