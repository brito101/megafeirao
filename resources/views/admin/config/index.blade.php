@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">
        <header class="dash_content_app_header pb-1">
            <h2 class="icon-cogs">Configurações</h2>
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

                <ul class="nav_tabs">
                    <li class="nav_tabs_item">
                        <a href="#data" class="nav_tabs_item_link active">Configurações</a>
                    </li>
                </ul>


                @if ($config)
                    <form action="{{ route('admin.config.update', ['config' => $config]) }}" method="post"
                        class="app_form">
                        @method('PUT')
                    @else
                        <form action="{{ route('admin.config.store') }}" method="post" class="app_form">
                @endif

                @csrf

                <div class="nav_tabs_content">
                    <div id="data">
                        <div class="label_g4">
                            <label class="label_2">
                                <span class="legend">Quantidade inicial de anúncios:</span>
                                <input type="tel" name="initial_ads" placeholder="Quantidade"
                                    value="{{ $config ? old('initial_ads') ?? $config->initial_ads : '' }}" />
                            </label>
                        </div>
                    </div>
                </div>

                <div class="text-right mt-2">
                    <button class="btn btn-large btn-green icon-check-square-o">Atualizar</button>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
