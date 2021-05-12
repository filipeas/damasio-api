<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} - Login</title>
    <!-- estilos do layout -->
    <link rel="stylesheet" href="{{ asset('site/style_login.css') }}">
    <link rel="stylesheet" href="{{ asset('site/style.css') }}">

    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> --}}
</head>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first p-5">
                <h4>Login</h4>
                <p>preencha seus dados para acessar o sistema.</p>
            </div>

            @if (session()->get('error'))
                <div class="alert alert-danger" role="alert">
                    @foreach (session()->get('message') as $item)
                        {{ $item }} <br>
                    @endforeach
                </div>
            @endif

            @if (isset($errorParameters) && $errorParameters)
                <div class="alert alert-danger messageBox" role="alert">
                    @foreach ($message as $item)
                        @foreach ($item as $itemErr)
                            @foreach ($itemErr as $msg)
                                {{ $msg }}
                            @endforeach
                        @endforeach
                    @endforeach
                </div>
            @elseif(isset($errorParameters) && !$errorParameters)
                <div class="alert alert-danger messageBox" role="alert">
                    @foreach ($message as $item)
                        {{ $item }}
                    @endforeach
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.do') }}" name="formLogin" method="POST">
                @csrf
                <input required type="text" id="email" class="fadeIn second" name="email"
                    placeholder="E-mail do usuário">
                <input required type="password" id="password" class="fadeIn third" name="password" placeholder="Senha">
                <input type="submit" class="fadeIn fourth" value="Login">
            </form>

            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="{{ route('site.home') }}">Voltar para a página inicial</a>
            </div>

        </div>
    </div>
</body>

<script src="{{ asset('site/jquery.js') }}"></script>
<script src="{{ asset('site/bootstrap.js') }}"></script>
<script src="{{ asset('site/jquery-form.js') }}"></script>

</html>
