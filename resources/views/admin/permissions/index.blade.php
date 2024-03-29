@extends('admin.master.master')

@section('content')
<section class="dash_content_app">

    <header class="dash_content_app_header pb-1">
        <h2 class="icon-cogs">Permissões</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="icon-angle-right separator icon-notext"></li>
                    <li><a href="{{ route('admin.permission.index') }}" class="text-orange">Permissões</a></li>
                </ul>
            </nav>

            @can('Cadastrar Permissões')
            <a href="{{ route('admin.permission.create') }}" class="icon-plus btn btn-orange ml-1">Criar Permissão</a>
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
                        <th>Permissão</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->name }}</td>
                        <td class="d-flex">
                            @can('Editar Permissões')
                            <a class="mr-1 btn btn-orange" href="{{ route('admin.permission.edit', ['permission' => $permission->id]) }}">Editar</a>
                            @endcan
                            @can('Remover Permissões')
                            <form action="{{ route('admin.permission.destroy', ['permission' => $permission->id]) }}" method="post">
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
