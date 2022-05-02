@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header pb-1">
            <h2 class="icon-pencil-square-o">Editar Termos de Uso e Política de Privacidade</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">

            <div class="nav">

                @if ($errors->all())
                    @foreach ($errors->all() as $error)
                        @message(['color' => 'orange'])
                        <p class="icon-asterisk">{{ $error }}</p>
                        @endmessage
                    @endforeach
                @endif

                @if (session()->exists('message'))
                    @message(['color' => session()->get('color')])
                    <p class="icon-asterisk">{{ session()->get('message') }}</p>
                    @endmessage
                @endif

                @if ($term)
                    <form action="{{ route('admin.term.update', ['term' => $term]) }}" method="post" class="app_form">
                        @method('PUT')
                    @else
                        <form action="{{ route('admin.term.store') }}" method="post" class="app_form">
                @endif
                @csrf

                <label class="label">
                    <span class="legend">Descrição dos Termos de Uso:</span>
                    <textarea name="description" cols="30" rows="10"
                        class="mce">{{ $term ? old('description') ?? $term->description : '' }}</textarea>
                </label>

                <div class="text-right mt-2">
                    <button class="btn btn-large btn-green icon-check-square-o">Atualizar Termos de Uso</button>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
