@extends('web.master.master')

@section('content')

    <div class="pb-5">
        <div class="container py-5">
            <h2 class="text-center text-front">Seu e-mail foi enviado com sucesso! Em breve entraremos em contato.</h2>
            <p class="text-center py-5"><a href="{{ url()->previous() }}"
                    class="text-white text-decoration-none btn btn-front">Continue
                    navegando!</a></p>
        </div>
    </div>

@endsection
