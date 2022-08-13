@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header pb-1">
            <h2 class="icon-user-plus">Novo Cliente</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.users.index') }}">Clientes</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.users.create') }}" class="text-orange">Novo Cliente</a></li>
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
                <ul class="nav_tabs">
                    <li class="nav_tabs_item">
                        <a href="#data" class="nav_tabs_item_link active">Dados Cadastrais</a>
                    </li>
                    @hasanyrole('Administrador|Gerente')
                        <li class="nav_tabs_item">
                            <a href="#management" class="nav_tabs_item_link">Administrativo</a>
                        </li>
                    @endhasanyrole
                </ul>

                <form class="app_form" action="{{ route('admin.users.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="nav_tabs_content">
                        <div id="data">

                            <label class="label">
                                <span class="legend">*Nome:</span>
                                <input type="text" name="name" placeholder="Nome Completo"
                                    value="{{ old('name') }}" />
                            </label>

                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">Foto</span>
                                    <input type="file" name="cover">
                                </label>

                                <label class="label">
                                    <span class="legend">Celular</span>
                                    <input type="tel" name="cell" placeholder="Número do Celular"
                                        value="{{ old('cell') }}" required />
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
                                                value="{{ old('email') }}" />
                                        </label>

                                        <label class="label">
                                            <span class="legend">Senha:</span>
                                            <input type="password" name="password" placeholder="Senha de acesso"
                                                value="" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="realties" class="d-none">
                            <div class="app_collapse">
                                <div class="app_collapse_header collapse">
                                    <h3>Locador</h3>
                                    <span class="icon-minus-circle icon-notext"></span>
                                </div>

                                <div class="app_collapse_content">
                                    <div id="realties">
                                        <div class="no-content">Não foram encontrados registros!</div>
                                    </div>
                                </div>
                            </div>

                            <div class="app_collapse mt-3">
                                <div class="app_collapse_header collapse">
                                    <h3>Locatário</h3>
                                    <span class="icon-minus-circle icon-notext"></span>
                                </div>

                                <div class="app_collapse_content">
                                    <div id="realties">
                                        <div class="no-content">Não foram encontrados registros!</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="management" class="d-none">

                            <label class="label">
                                <span class="legend">Limite de Anúncios:</span>
                                <input type="tel" name="ads_limit" placeholder="Quantidade liberada"
                                    value="{{ old('ads_limit') }}" />
                            </label>

                            <label class="label">
                                <span class="legend">Limite de Visualização de Banner:</span>
                                <input type="tel" name="banner_views_limit" placeholder="Quantidade liberada"
                                    value="{{ old('banner_views_limit') }}" />
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
