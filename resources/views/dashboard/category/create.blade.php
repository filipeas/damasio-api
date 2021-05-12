@extends('dashboard.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Nova categoria</h2>
        </div>
    </div>

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

    <form action="{{ route('user.category.store') }}" name="formCreateCategory" method="POST"
        class="bg-gray-apple shadow-sm p-3 mb-5 rounded">

        @csrf

        <div class="form-group">
            <label for="inputTitulo">Título da categoria</label>
            <input required name="title" type="text" class="form-control" id="inputTitulo" placeholder="Ex: Eletrônicos"
                value="{{ old('title') }}">
            <small class="form-text text-muted">Digite o título da categoria nova.</small>
        </div>

        <input type="submit" class="btn btn-primary w-100" value="Cadastrar">
    </form>

@endsection
