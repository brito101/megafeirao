@extends('web.master.master')

@section('content')
    <div class="main_contact py-5 bg-light text-center">
        <div class="container">
            <h1 class="text-front">Política de Privacidade</h1>
            <p class="mb-0">Ao utilizar esse site você concorda com os termos aqui descritos.</p>

            <div class="row text-left p-4">
                @if ($term)
                    {!! $term->description !!}
                @endif
            </div>
        </div>
    </div>
@endsection
