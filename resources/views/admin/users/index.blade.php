@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header pb-1">
            <h2 class="icon-user">Clientes</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        @can('Listar Usuários')
                            <li class="separator icon-angle-right icon-notext"></li>
                            <li><a href="{{ route('admin.users.index') }}" class="text-orange">Clientes</a></li>
                        @endcan
                    </ul>
                </nav>

                @can('Cadastrar Usuários')
                    <a href="{{ route('admin.users.create') }}" class="btn btn-orange icon-plus ml-1">Criar Cliente</a>
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
                <table id="dataTable" class="nowrap stripe" width="100" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome Completo</th>
                            <th>E-mail</th>
                            <th>Anúncios ativos</th>
                            @can('Remover Usuários')
                                <th>Ações</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    @can('Editar Usuários')
                                        <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}"
                                            class="text-orange">{{ $user->name }}</a>
                                    @else
                                        {{ $user->name }}
                            @endif
                            </td>
                            <td><a href="mailto: {{ $user->email }}" class="text-orange">{{ $user->email }}</a></td>
                            <td>{{ $user->automotives()->sale()->available()->count() }}</td>
                            @can('Remover Usuários')
                                <td class="d-flex">
                                    <a class="btn btn-blue"
                                        href="{{ route('admin.users.edit', ['user' => $user->id]) }}">Editar</a>
                                    <form action="{{ route('admin.users.destroy', ['user' => $user->id]) }}" method="post">
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
