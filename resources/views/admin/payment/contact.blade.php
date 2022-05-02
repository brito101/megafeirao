@extends('admin.master.master')

@section('content')
    <div style="flex-basis: 100%; max-width: 100%;">
        <section class="dash_content_app">
            <header class="dash_content_app_header pb-1">
                <h2 class="icon-envelope">Fale conosco</h2>
                <div class="dash_content_app_header_actions">
                    <nav class="dash_content_app_breadcrumb">
                        <ul>
                            <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        </ul>
                    </nav>
                </div>
            </header>

            <div class="dash_content_app_box">
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
            </div>

            <div class="row send_mail">
                <form action="{{ route('admin.sendContact') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <span class="legend text-muted">Envie um arquivo de até 3000 kilobytes (3MB)</span>
                        <input type="file" name="file" class="mt-1">
                    </div>

                    <div class="form-group">
                        <textarea name="message" rows="5" class="form-control"
                            placeholder="Escreva sua mensagem..."></textarea>
                    </div>

                    <div class="form-group text-right">
                        <button class="btn btn-orange">Enviar Contato</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
