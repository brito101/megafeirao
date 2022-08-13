@extends('admin.master.master')

@section('pre_css')
    <link rel="stylesheet" href="{{ url(asset('backend/assets/css/bootstrap.css')) }}" />
@endsection

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header pb-1">
            <h2 class="icon-file-image-o font-weight-bold">Cadastrar Banner</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        @if (session()->exists('message'))
            @message(['color' => session()->get('color')])
                <p class="icon-asterisk">{{ session()->get('message') }}</p>
            @endmessage
        @endif

        <div class="dash_content_app_box">
            <p class="mb-0">Divulgue sua loja ou serviço na primeira página do site.</p>
            <p class="mt-0">Seu banner aparecerá intercalado com outros banners e você pagará por visualizações</p>
            <div class="col-12 py-2 px-0">
                <div class="table-sm table-responsive-sm col-12 col-md-6 text-sm px-0 mx-0">
                    <table class="table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">Valor do PIX</th>
                                <th scope="col">---</th>
                                <th scope="col">Pessoas que verão seu banner</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>R$ 5,00</td>
                                <td>---</td>
                                <td>1.000</td>
                            </tr>
                            <tr>
                                <td>R$ 15,00</td>
                                <td>---</td>
                                <td>3.000</td>
                            </tr>
                            <tr>
                                <td>R$ 25,00</td>
                                <td>---</td>
                                <td>5.000</td>
                            </tr>
                            <tr>
                                <td>R$ 50,00</td>
                                <td>---</td>
                                <td>12.000 (20% de desconto)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="py-2">
                @if ($banner)
                    <img src="{{ url('storage/' . $banner->cover) }}" id="banner-image">
                @endif
            </div>

            <p class="mb-1">Dimensões: 750px por 120px (horizontal)</p>

            <form action="{{ route('admin.client-banner.store') }}" method="post" class="d-flex justify-content-center"
                enctype="multipart/form-data">
                @csrf
                <div class="col-12 col-md-8 px-0">
                    <input type="file" name="cover" class="w-100 border rounded h-100 d-flex align-content-center"
                        onchange="loadFile(event)">
                </div>
                <div class="col-12 col-md-4">
                    <button class="btn btn-large btn-green">Cadastrar</button>
                </div>

            </form>
        </div>
        <p class="my-3">Você poderá alterar seu banner quantas vezes quiser sem perder seu saldo disponível.</p>
        <p class="mb-0">Visualizações restantes: {{ Auth::user()->banner_views_limit }}</p>
        <p class="mt-0">Seu banner já foi visto por {{ $banner->views ?? 0 }} pessoas</p>
        <p class="mt-3">Para inserir saldo faça um PIX de qualquer valor para<br />
            megafeiraoveiculosOgmail.com<br />
            e envie o comprovante pelo Fale Conosco ao lado.</p>
    </section>
@endsection

@section('js')
    <script>
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('banner-image');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
@endsection
