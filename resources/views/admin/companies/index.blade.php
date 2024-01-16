@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header pb-1">
            <h2 class="icon-building-o">Lojas</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="icon-angle-right separator icon-notext"></li>
                        <li><a href="{{ route('admin.users.index') }}">Clientes</a></li>
                    </ul>
                </nav>
                @can('Cadastrar Empresas')
                    @if ((Auth::user()->hasAnyRole('Anunciante') && $companies->count() == 0) || Auth::user()->hasAnyRole(['Administrador', 'Gerente']))
                        <a href="{{ route('admin.companies.create') }}" class="icon-plus btn btn-orange ml-1">Criar Loja</a>
                    @endif
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
                <table id="dataTable" class="nowrap hover stripe" width="100" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th>Razão Social</th>
                            @if (Auth::user()->hasAnyRole(['Administrador', 'Gerente']))
                                <th>Responsável</th>
                            @endif
                            @can('Remover Empresas')
                                <th>Ações</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)
                            <tr>
                                <td>
                                    @can('Editar Empresas')
                                        <a href="{{ route('admin.companies.edit', ['company' => $company->id]) }}"
                                            class="text-orange" title="Editar Loja">{{ $company->social_name }}</a>
                                    @else
                                        {{ $company->social_name }}
                            @endif
                            </td>

                            @if (Auth::user()->hasAnyRole(['Administrador', 'Gerente']))
                                <td>
                                    @can('Editar Usuários')
                                        <a href="{{ route('admin.users.edit', ['user' => $company->owner()->first()->id]) }}"
                                            class="text-orange"
                                            title="Editar Responsável">{{ $company->owner()->first()->name }}</a>
                                    @else
                                        {{ $company->owner()->first()->name }}
                                @endif
                                </td>
                                @endif
                                @can('Remover Empresas')
                                    <td>
                                        <form action="{{ route('admin.companies.destroy', ['company' => $company->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            <input class="btn btn-red" type="submit" value="Remover">
                                        </form>
                                    </td>
                                @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        @endsection
