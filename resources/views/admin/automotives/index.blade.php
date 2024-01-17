@extends('admin.master.master')

@section('content')
    <style>
        .pagination {
            list-style: none;
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: .25rem;
        }

        .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-top-color: rgb(222, 226, 230);
            border-right-color: rgb(222, 226, 230);
            border-bottom-color: rgb(222, 226, 230);
            border-left-color: rgb(222, 226, 230);
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
    <section class="dash_content_app">

        <header class="dash_content_app_header pb-1">
            <h2 class="icon-car">Veículos</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="icon-angle-right separator icon-notext"></li>
                        <li><a href="{{ route('admin.automotives.index') }}">Veículos</a></li>
                    </ul>
                </nav>

                @can('Cadastrar Veículos')
                    <a href="{{ route('admin.automotives.create') }}" class="icon-plus btn btn-orange ml-1">Cadastrar
                        Veículo</a>
                @endcan
            </div>
        </header>



        @if (session()->exists('message'))
            @message(['color' => session()->get('color')])
                <p class="icon-asterisk">{{ session()->get('message') }}</p>
            @endmessage
        @endif

        <div class="dash_content_app_box">

            <div class="dash_content_app_box_stage">

                <div class="d-flex mb-2">
                    <form class="form-inline d-flex justify-content-center align-items-center" method="GET">
                        <div class="form-group d-flex justify-content-center align-items-center">
                            <input type="text" class="form-control px-1" id="filter" name="filter"
                                placeholder="Título do anúncio..." value="{{ $filter }}">
                        </div>
                        <button type="submit" class="icon-search btn btn-orange m-0 ml-1" title="Filtrar"></button>

                    </form>
                    <a href="{{ route('admin.automotives.index') }}" class="icon-undo btn btn-orange m-0 ml-1"
                        title="Resetar"></a>
                </div>

                <div class="d-flex mb-2">
                    <form action="{{ route('admin.automotive.reannounce') }}" method="post"
                        class="d-flex justify-content-center align-items-center">
                        @csrf
                        <label class="mt-1">Reanunciar todos os anúncios inativos?</label>
                        <input type="checkbox" name="reannounce" style="cursor: pointer; margin: 0 10px;">
                        <div class="col-12 col-md-4">
                            <button class="btn btn-large btn-green">Ok</button>
                        </div>
                    </form>
                </div>

                <div class="realty_list">
                    @if (!empty($automotives))
                        @foreach ($automotives as $automotive)
                            <div class="realty_list_item mb-2">
                                <div class="realty_list_item_actions_stats">
                                    <img src="{{ $automotive->cover() }}" alt="">
                                    <ul>
                                        @if ($automotive->sale == true && !empty($automotive->sale_price))
                                            <li>Venda: R$ {{ $automotive->sale_price }}</li>
                                        @endif

                                        @if ($automotive->rent == true && !empty($automotive->rent_price))
                                            <li>Aluguel: R$ {{ $automotive->rent_price }}</li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="realty_list_item_content">
                                    <h4>#{{ $automotive->id }}
                                        {{ $automotive->title }}<span class="ml-2"
                                            style="font-size: 0.875rem; font-weight: lighter;">Visualizações:{{ $automotive->views }}</span>
                                    </h4>

                                    <div class="realty_list_item_card d-flex flex-wrap"
                                        style="flex-basis: 100%; border:none; ; justify-content: space-between">
                                        @if ($automotive->sale == true && !empty($automotive->sale_price))
                                            <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                class="btn btn-blue button_action" target="_blank">Ver Anúncio</a>
                                        @endif

                                        @if ($automotive->rent == true && !empty($automotive->rent_price))
                                            <a href="{{ route('web.rentAutomotive', ['slug' => $automotive->slug]) }}"
                                                class="btn btn-blue button_action" target="_blank">Ver Anúncio</a>
                                        @endif

                                        @php
                                            $active = $automotive->active_date >= Carbon\Carbon::now()->subDays(30);
                                        @endphp
                                        <div class="text-center btn btn-orange"
                                            style="height: 35px;
                                                        display: flex;
                                                        align-items: center;">
                                            {{ $active == 1 ? 'Ativo desde de ' . date('d/m/Y', strtotime($automotive->active_date)) : 'Inativo' }}
                                        </div>
                                        @if ($active == 0)
                                            <form
                                                action="{{ route('admin.automotives.reactive', ['automotive' => $automotive->id]) }}"
                                                method="post">
                                                @csrf
                                                <input class="btn btn-orange button_action" type="submit"
                                                    value="Reanunciar">
                                            </form>
                                        @endif

                                        @can('Editar Veículos')
                                            <a href="{{ route('admin.automotives.edit', ['automotive' => $automotive->id]) }}"
                                                class="btn btn-green button_action">Editar</a>
                                        @endcan

                                        @can('Remover Veículos')
                                            <form
                                                action="{{ route('admin.automotives.destroy', ['automotive' => $automotive->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <input class="btn btn-red button_action" type="submit" value="Remover">
                                            </form>
                                        @endcan
                                    </div>

                                </div>

                            </div>
                        @endforeach
                        <div style="display: flex; width: 100% !important; justify-content: center !important;">
                            {{ $automotives->appends(request()->input())->links() }}</div>
                    @else
                        <div class="no-content">Não foram encontrados registros!</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
