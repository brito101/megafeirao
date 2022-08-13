<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">

    @hasSection('pre_css')
        @yield('pre_css')
    @endif

    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/reset.css')) }}" />
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/libs.css')) }}" />
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/boot.css')) }}" />
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/style.css')) }}" />

    @hasSection('css')
        @yield('css')
    @endif

    <link rel="icon" type="image/png" href="{{ url(asset('backend/assets/images/logo.png')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mega Feirão Veículos - Admin</title>
</head>

<body>

    <div class="ajax_load">
        <div class="ajax_load_box">
            <div class="ajax_load_box_circle"></div>
            <p class="ajax_load_box_title">Aguarde, carregando...</p>
        </div>
    </div>

    <div class="ajax_response"></div>

    @php
        if (!empty(\Illuminate\Support\Facades\Auth::user()->cover) && \Illuminate\Support\Facades\File::exists(public_path() . '/storage/' . \Illuminate\Support\Facades\Auth::user()->cover)) {
            $cover = \Illuminate\Support\Facades\Auth::user()->url_cover;
        } else {
            $cover = url(asset('backend/assets/images/avatar.jpg'));
        }
    @endphp

    <div class="dash">
        <aside class="dash_sidebar">
            <article class="dash_sidebar_user">
                <img class="dash_sidebar_user_thumb" src="{{ $cover }}" alt="" title="" />

                <h1 class="dash_sidebar_user_name">
                    @can('Editar Usuários')
                        <a
                            href="{{ route('admin.users.edit', ['user' => \Illuminate\Support\Facades\Auth::user()->id]) }}">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
                    @else
                        <a>{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
                        @endif
                    </h1>
                </article>

                <ul class="dash_sidebar_nav">
                    <li class="dash_sidebar_nav_item {{ isActive('admin.home') }}">
                        <a class="icon-tachometer" href="{{ route('admin.home') }}">Dashboard</a>
                    </li>

                    @if (auth()->user()->can('Listar Usuários') ||
                        auth()->user()->can('Listar Empresas'))
                        {{-- Menu Clientes --}}

                        @hasrole('Anunciante')
                            <li
                                class="dash_sidebar_nav_item  {{ isActive('admin.users') }} {{ isActive('admin.companies') }}">
                                @if (isset(Auth::user()->company->id))
                                    <a class="icon-building"
                                        href="{{ route('admin.companies.edit', ['company' => Auth::user()->company->id]) }}">Loja</a>
                                @else
                                    <a class="icon-building" href="{{ route('admin.companies.create') }}">Loja</a>
                                @endif
                            @else
                            <li
                                class="dash_sidebar_nav_item  {{ isActive('admin.users') }} {{ isActive('admin.companies') }}">
                                <a class="icon-users" href="javascript:void(0)">Clientes</a>
                                <ul class="dash_sidebar_nav_item">
                                    @can('Listar Usuários')
                                        <li class="{{ isActive('admin.users.index') }}"><a
                                                href="{{ route('admin.users.index') }}">Ver Todos</a></li>
                                    @endcan
                                    @can('Listar Empresas')
                                        <li class="{{ isActive('admin.companies.index') }}"><a
                                                href="{{ route('admin.companies.index') }}">Lojas</a></li>
                                    @endcan
                                    @can('Cadastrar Usuários')
                                        <li class="{{ isActive('admin.users.create') }}"><a
                                                href="{{ route('admin.users.create') }}">Criar Novo</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endif
                        @endif

                        @can('Listar Veículos')
                            {{-- Menu Veículos --}}
                            <li class="dash_sidebar_nav_item {{ isActive('admin.automotives.index') }}">
                                <ul class="dash_sidebar_nav_item">
                                    @can('Listar Veículos')
                                        <li class="{{ isActive('admin.automotives.index') }}"><a
                                                href="{{ route('admin.automotives.index') }}"><i class="icon-car"></i>Veículos
                                                Cadastrados</a></li>
                                    @endcan
                                </ul>
                            </li>
                            <li class="dash_sidebar_nav_item {{ isActive('admin.automotives.create') }}">
                                <ul class="dash_sidebar_nav_item">
                                    @can('Cadastrar Veículos')
                                        <li class="{{ isActive('admin.automotives.create') }}"><a
                                                href="{{ route('admin.automotives.create') }}"><i class="icon-car"></i>Criar Novo
                                                Anúncio</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                        @can('Listar Contratos')
                            {{-- Menu Contratos --}}
                            <li class="dash_sidebar_nav_item {{ isActive('admin.contracts') }}">
                                <a class="icon-file-text" href="javascript:void(0)">Contratos</a>
                                <ul class="dash_sidebar_nav_submenu">
                                    @can('Listar Contratos')
                                        <li class="{{ isActive('admin.contracts.index') }}"><a
                                                href="{{ route('admin.contracts.index') }}">Ver Todos</a></li>
                                    @endcan
                                    @can('Cadastrar Contratos')
                                        <li class="{{ isActive('admin.contracts.create') }}"><a
                                                href="{{ route('admin.contracts.create') }}">Criar Novo</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                        @can('Listar Perfis')
                            {{-- Menu Configurações --}}
                            <li class="dash_sidebar_nav_item {{ isActive('admin.permission') }} {{ isActive('admin.role') }}">
                                <a class="icon-shield" href="javascript:void(0)">ACL</a>
                                <ul class="dash_sidebar_nav_item">
                                    @can('Listar Perfis')
                                        <li class="{{ isActive('admin.role.index') }}"><a
                                                href="{{ route('admin.role.index') }}">Perfis</a></li>
                                    @endcan
                                    @can('Listar Permissões')
                                        <li class="{{ isActive('admin.permission.index') }}"><a
                                                href="{{ route('admin.permission.index') }}">Permissões</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                        @hasanyrole('Administrador|Gerente')
                            <li class="dash_sidebar_nav_item  {{ isActive('admin.config.index') }}">
                                <a class="icon-cogs" href="{{ route('admin.config.index') }}">Configurações</a>
                            </li>
                        @endhasrole

                        @hasanyrole('Administrador|Gerente')
                            <li class="dash_sidebar_nav_item  {{ isActive('admin.banner.index') }}">
                                <a class="icon-bookmark" href="{{ route('admin.banner.index') }}">Banner</a>
                            </li>
                        @endhasrole

                        @hasanyrole('Anunciante')
                            <li class="dash_sidebar_nav_item  {{ isActive('admin.client-banner.index') }}">
                                <a class="icon-file-image-o" href="{{ route('admin.client-banner.index') }}">Cadastrar Banner</a>
                            </li>
                        @endhasrole

                        @hasanyrole('Administrador|Anunciante')
                            <li class="dash_sidebar_nav_item  {{ isActive('admin.contact') }}">
                                <a class="icon-envelope" href="{{ route('admin.contact') }}">Fale conosco</a>
                            </li>
                        @endhasrole

                        @hasanyrole('Administrador|Gerente')
                            <li class="dash_sidebar_nav_item  {{ isActive('admin.term.index') }}">
                                <a class="icon-pencil-square-o" href="{{ route('admin.term.index') }}">Termos de Uso</a>
                            </li>
                        @endhasrole

                        <li class="dash_sidebar_nav_item"><a class="icon-reply" href="{{ route('web.home') }}"
                                target="_blank">Ver Site</a></li>
                        <li class="dash_sidebar_nav_item"><a class="icon-sign-out on_mobile"
                                href="{{ route('admin.logout') }}">Sair</a></li>
                    </ul>

                </aside>

                <section class="dash_content">

                    <div class="dash_userbar">
                        <div class="dash_userbar_box">
                            <div class="dash_userbar_box_content">
                                <span class="icon-align-justify icon-notext mobile_menu transition btn btn-green"></span>
                                <h1 class="transition">
                                    <a href="{{ route('admin.home') }}">
                                        <img src="{{ url(asset('backend/assets/images/brand.png')) }}" width="100"
                                            style="margin: -15px 0;">
                                    </a>
                                </h1>
                                <div class="dash_userbar_box_bar no_mobile">
                                    <a class="text-red icon-sign-out" href="{{ route('admin.logout') }}">Sair</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dash_content_box">
                        @yield('content')
                    </div>
                </section>
            </div>

            <script src="{{ url(mix('backend/assets/js/jquery.js')) }}"></script>
            <script src="{{ url(asset('backend/assets/js/popper.js')) }}"></script>
            <script src="{{ url(asset('backend/assets/js/bootstrap.js')) }}"></script>
            <script src="{{ url(asset('backend/assets/js/tinymce/tinymce.min.js')) }}"></script>
            <script src="{{ url(mix('backend/assets/js/libs.js')) }}"></script>
            <script src="{{ url(mix('backend/assets/js/scripts.js')) }}"></script>

            @hasSection('js')
                @yield('js')
            @endif

        </body>

        </html>
