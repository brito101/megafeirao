@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header pb-1">

            @hasanyrole('Administrador|Gerente')
                <h2 class="icon-user-plus">Editar Cliente</h2>
            @else
                <h2 class="icon-user-plus">Editar Perfil</h2>
            @endhasanyrole
            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        @can('Listar Usuários')
                            <li class="separator icon-angle-right icon-notext"></li>
                            <li><a href="{{ route('admin.users.index') }}">Clientes</a></li>
                        @endcan
                        @can('Cadastrar Usuários')
                            <li class="separator icon-angle-right icon-notext"></li>
                            <li><a href="{{ route('admin.users.create') }}" class="text-orange">Criar Cliente</a></li>
                        @endcan
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
                        <a href="#data" class="nav_tabs_item_link active">Dados Cadastrais</a>
                    </li>
                    @hasanyrole('Administrador|Gerente')
                        <li class="nav_tabs_item">
                            <a href="#realties" class="nav_tabs_item_link">Anúncios</a>
                        </li>
                        <li class="nav_tabs_item">
                            <a href="#management" class="nav_tabs_item_link">Administrativo</a>
                        </li>
                    @endhasanyrole
                </ul>

                <form class="app_form" action="{{ route('admin.users.update', ['user' => $user]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="nav_tabs_content">
                        <div id="data">

                            <label class="label">
                                <span class="legend">*Nome:</span>
                                <input type="text" name="name" placeholder="Nome Completo"
                                    value="{{ old('name') ?? $user->name }}" />
                            </label>

                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">Foto</span>
                                    <input type="file" name="cover">
                                </label>
                            </div>

                            <div class="app_collapse mt-2">
                                <div class="app_collapse_header collapse">
                                    <h3>Acesso</h3>
                                    <span class="icon-plus-circle icon-notext"></span>
                                </div>

                                <div class="app_collapse_content d-none">
                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">*E-mail:</span>
                                            <input type="email" name="email" placeholder="Melhor e-mail"
                                                value="{{ old('email') ?? $user->email }}" />
                                        </label>

                                        <label class="label">
                                            <span class="legend">Senha:</span>
                                            <input type="password" name="password" placeholder="Senha de acesso" value="" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="realties" class="d-none">
                            <div class="app_collapse">
                                <div class="app_collapse_header collapse">
                                    <h3>Anúncios Cadastrados</h3>
                                    <span class="icon-minus-circle icon-notext"></span>
                                </div>

                                <div class="app_collapse_content">
                                    <div id="realties">
                                        <div class="realty_list">

                                            @if (count($user->automotives()->get()))
                                                @foreach ($user->automotives()->get() as $automotive)
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
                                                                style="flex-basis: 100%; border:none; ; justify-content: start; gap: 20px">
                                                                @if ($automotive->sale == true && !empty($automotive->sale_price))
                                                                    <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                        class="btn btn-blue button_action"
                                                                        target="_blank">Ver Anúncio</a>
                                                                @endif

                                                                @if ($automotive->rent == true && !empty($automotive->rent_price))
                                                                    <a href="{{ route('web.rentAutomotive', ['slug' => $automotive->slug]) }}"
                                                                        class="btn btn-blue button_action"
                                                                        target="_blank">Ver Anúncio</a>
                                                                @endif

                                                                @php
                                                                    $active = $automotive->active_date >= Carbon\Carbon::now()->subDays(30);
                                                                @endphp

                                                                @can('Editar Veículos')
                                                                    <a href="{{ route('admin.automotives.edit', ['automotive' => $automotive->id]) }}"
                                                                        class="btn btn-green button_action">Editar</a>
                                                                @endcan
                                                            </div>

                                                        </div>

                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="no-content">Não foram encontrados registros!</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @hasanyrole('Administrador|Gerente')
                            <div id="management" class="d-none">
                                <div class="label_gc">
                                    <span class="legend">Status do Usuário:</span>
                                    <label class="label">
                                        <input type="checkbox" name="admin"
                                            {{ old('admin') == 'on' || old('admin') == true ? 'checked' : ($user->admin == true ? 'checked' : '') }}><span>Ativado</span>
                                    </label>
                                </div>

                                <label class="label">
                                    <span class="legend">Limite de Anúncios:</span>
                                    <input type="tel" name="ads_limit" placeholder="Quantidade liberada"
                                        value="{{ old('ads_limit') ?? $user->ads_limit }}" />
                                </label>

                                @can('Atribuir Permissões')
                                    <span class="legend">Permissões:</span>
                                    @foreach ($roles as $role)
                                        <label class="label">
                                            <input type="checkbox" name="acl_{{ $role->id }}"
                                                {{ $role->can == 1 ? 'checked' : '' }}>
                                            <span>{{ $role->name }}</span>
                                        </label>
                                    @endforeach
                                @endcan
                            </div>
                        @endhasanyrole
                    </div>

                    <div class="text-right mt-2">
                        <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
