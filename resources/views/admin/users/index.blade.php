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

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn text-dark border-dark border bg-white message-user"
                                        data-toggle="modal" data-target="#message" data-user="{{ $user->id }}"
                                        data-name="{{ $user->name }}">
                                        Mensagem
                                    </button>

                                </td>
                            @endcan
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="messageLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="messageLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.users.message') }}" method="post" id="message-form">
                            <div class="form-group">
                                <textarea name="message" rows="5" class="form-control" placeholder="Escreva sua mensagem..." id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-red" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-blue" id="message-submit">Enviar</button>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @section('js')
        <script>
            let id = null;
            $('.message-user').on('click', function(e) {
                id = $(this).attr('data-user');
                let name = $(this).attr('data-name');
                $('#messageLabel').html(`Mensagem para o usuário <b>${name}</b>`);
            })

            $("#message-submit").on("click", function(e) {
                e.preventDefault();
                let message = $("#message-text").val();
                $("#message-text").val("");
                $('#message').modal('hide');
                $.post({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: {
                        user: id,
                        message
                    },
                    url: $('#message-form').attr("action"),
                });
            });
        </script>
    @endsection
