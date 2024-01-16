@extends('admin.master.master')

@section('content')
<section class="dash_content_app">

    <header class="dash_content_app_header pb-1">
        <h2 class="icon-file-text">Contratos</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="icon-angle-right separator icon-notext"></li>
                    <li><a href="{{ route('admin.contracts.index') }}">Contratos</a></li>
                </ul>
            </nav>

            @can('Cadastrar Contratos')
            <a href="{{ route('admin.contracts.create') }}" class="icon-plus btn btn-orange ml-1">Criar Contrato</a>
            @endcan
            <!--<button class="btn btn-green icon-search icon-notext ml-1 search_open"></button>-->
        </div>
    </header>

    @if(session()->exists('message'))
    @message(['color' => session()->get('color')])
    <p class="icon-asterisk">{{ session()->get('message') }}</p>
    @endmessage
    @endif

    <div class="dash_content_app_box">
        <div class="dash_content_app_box_stage">
            <table id="dataTable" class="nowrap hover stripe" width="100" style="width: 100% !important;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vendedor / Locatário</th>
                        <th>Comprador / Locatário</th>
                        <th>Negócio</th>
                        <th>Início</th>
                        <th>Vigência</th>
                        @can('Remover Contratos')
                        <th>Ações</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($contracts as $contract)
                    <tr>
                        <td>
                            @can('Editar Contratos')
                            <a href="{{ route('admin.contracts.edit', ['contract' => $contract->id]) }}" class="text-orange">{{ $contract->id }}</a>
                            @else
                            {{  $contract->id }}
                            @endif
                        </td>
                        <td>
                            @can('Editar Usuários')
                            <a href="{{ route('admin.users.edit', ['user' => $contract->ownerObject->id ]) }}" class="text-orange">{{ $contract->ownerObject->name }}</a>
                            @else
                            {{  $contract->ownerObject->name }}
                            @endif
                        </td>
                        <td>
                            @can('Editar Usuários')
                            <a href="{{ route('admin.users.edit', ['user' => $contract->acquirerObject->id ]) }}" class="text-orange">{{ $contract->acquirerObject->name }}</a>
                            @else
                            {{  $contract->acquirerObject->name }}
                            @endif
                        </td>
                        <td>{{ ($contract->sale == true ? 'Venda' : 'Locação') }}</td>
                        <td>{{ $contract->start_at }}</td>
                        <td>{{ $contract->deadline }} meses</td>
                        @can('Remover Contratos')
                        <td>
                            <form action="{{ route('admin.contracts.destroy', ['contract' => $contract->id]) }}" method="post">
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