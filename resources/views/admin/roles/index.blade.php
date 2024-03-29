@extends('admin.master.master')

@section('content')
<section class="dash_content_app">

    <header class="dash_content_app_header pb-1">
        <h2 class="icon-cogs">Perfis</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="icon-angle-right separator icon-notext"></li>
                    <li><a href="{{ route('admin.role.index') }}" class="text-orange">Perfis</a></li>
                </ul>
            </nav>
            @can('Cadastrar Perfis')
            <a href="{{ route('admin.role.create') }}" class="icon-plus btn btn-orange ml-1">Criar Perfil</a>
            @endcan
        </div>
    </header>

    @if($errors->all())
    @foreach($errors->all() as $error)
    @message(['color' => 'orange'])
    <p class="icon-asterisk">{{ $error }}</p>
    @endmessage
    @endforeach
    @endif

    @if(session()->exists('message'))
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
                        <th>Perfil</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td class="d-flex">
                            @can('Editar Perfis')
                            <a class="mr-1 btn btn-orange" href="{{ route('admin.role.edit', ['role' => $role->id]) }}">Editar</a>
                            @endcan
                            @can('Atribuir Permissões')
                            <a class="mr-1 btn btn-orange" href="{{ route('admin.role.permissions', ['role' => $role->id]) }}">Permissões</a>
                            @endcan
                            @can('Remover Perfis')
                            <form action="{{ route('admin.role.destroy', ['role' => $role->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <input class="btn btn-orange" type="submit" value="Remover">
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
