<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {!! $head ?? '' !!}

    <link rel="stylesheet" href="{{ url(asset('frontend/assets/css/bootstrap.css')) }}">
    <link rel="stylesheet" href="{{ url(asset('frontend/assets/css/app.css')) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

    @hasSection('css')
        @yield('css')
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ url(asset('frontend/assets/images/logo.png')) }}" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_TAG_MANAGER') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', {{ env('GOOGLE_TAG_MANAGER') }});
    </script>
</head>

<body>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v12.0"
        nonce="VCEFC7kz"></script>

    @include('cookieConsent::index')

    <header class="main_header">

        <div class="header_bar bg-dark">
            <div class="container">
                <div class="row py-1 d-flex justify-content-center">
                    <a href="{{ route('web.register') }}"
                        class="font-weight-bold text-decoration-none text-white px-2 text-center">Clique aqui e
                        obtenha sua loja virtual grátis em www.megafeiraoveiculos.com.br</a>
                </div>
            </div>
        </div>

        @if (Route::current()->getName() != 'web.filterCompany')
            <nav class="navbar navbar-expand-md navbar-light my-0" style="background-color: #FFF">
                <div class="container">
                    <div class="navbar-brand">
                        <a href="{{ route('web.home') }}">
                            <h1 class="text-hide">Mega Feirão Veículos</h1>
                            <img src="{{ url(asset('frontend/assets/images/brand.png')) }}" width="200"
                                alt="Mega Feirão Veículos" class="d-inline-block">
                        </a>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Menu Principal">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="fb-like d-none d-xl-block ml-5 pl-5"
                        data-href="https://www.facebook.com/megafeiraoveiculos.com.br" data-width=""
                        data-layout="button_count" data-action="like" data-size="large" data-share="true"></div>

                    <div class="collapse navbar-collapse justify-content-end" id="navbar">
                        <ul class="navbar-nav">
                            {{-- <li class="nav-item"><a href="{{ route('admin.account') }}"
                                    class="nav-link text-dark" title="Novo usuário"><span
                                        class="text-danger font-weight-bold icon-chevron-right mr-n3">
                                    </span>
                                    <span class="text-danger font-weight-bold icon-chevron-right mx-n1">
                                    </span><b>Novo usuário</b></a>
                            </li> --}}
                            <li class="nav-item"><a href="{{ route('admin.login') }}" class="nav-link text-dark"
                                    title="Meus Anúncios"><span
                                        class="text-danger font-weight-bold icon-chevron-right mr-n3">
                                    </span>
                                    <span class="text-danger font-weight-bold icon-chevron-right mx-n1">
                                    </span><b>Anunciar Grátis</b></a>
                            </li>
                        </ul>
                    </div>
                </div>

            </nav>
        @endif
        <div class="mx-auto container d-block">
            <span class="mx-2 w-100 border-secondary border-bottom d-block"></span>
        </div>
    </header>

    <div style="min-height: calc(100vh - 115px); background-color: #FFF">
        @yield('content')
    </div>

    <div class="main_copyright py-3 text-white text-center" style="background-color: #FFF">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('web.policy') }}" class="text-decoration-none text-secondary">Termos de Uso e
                        Política de Privacidade</a>
                    <!-- Histats.com  (div with counter) -->
                    <p class="mt-1 mb-0" id="histats_counter"></p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url(asset('frontend/assets/js/jquery.js')) }}"></script>
    <script src="{{ url(asset('frontend/assets/js/bootstrap.js')) }}"></script>
    <script src="{{ url(asset('frontend/assets/js/libs.js')) }}"></script>
    <script src="{{ url(asset('frontend/assets/libs/libs.js')) }}"></script>
    <script src="{{ url(asset('frontend/assets/js/scripts.js')) }}"></script>

    <!-- Histats.com  START  (aync)-->
    <script type="text/javascript">
        var _Hasync = _Hasync || [];
        _Hasync.push(['Histats.start', '1,4556851,4,137,112,33,00000010']);
        _Hasync.push(['Histats.fasi', '1']);
        _Hasync.push(['Histats.track_hits', '']);
        (function() {
            var hs = document.createElement('script');
            hs.type = 'text/javascript';
            hs.async = true;
            hs.src = ('//s10.histats.com/js15_as.js');
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
        })();
    </script>
    <noscript><a href="/" target="_blank"><img src="//sstatic1.histats.com/0.gif?4556851&101" alt=""
                border="0"></a></noscript>
    <!-- Histats.com  END  -->
    <script>
        function removeImage() {
            setTimeout(() => {
                $("img[src^='https://um.simpli.fi']").remove();
                $("img[src^='https://i.liadm.com']").remove();
            }, 10000);
        }
        removeImage();
    </script>

    @hasSection('js')
        @yield('js')
    @endif

</body>

</html>
