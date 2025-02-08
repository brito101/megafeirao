<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {!! $head ?? '' !!}

    <link href="{{ asset('company-template/assets/css/lib.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('company-template/assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('company-template/assets/css/color.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('company-template/assets/css/carousel.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,300" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ url(asset('frontend/assets/images/logo.png')) }}" />
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

<body class="home">
    <div class="body">
        <header style="background: linear-gradient(to bottom, red 70%, #EBEBEB 70%); padding: 40px 20px;"">
            <div style="width: 100%";>
                <h1 style="color: white; flex-basis: 100%; text-align: center;">{{ $company->social_name }}</h1>
            </div>
            <div style="display: flex; justify-content: center;">
                <span style="display: inline-flex; gap: 10px; position: relative; top: 5px; z-index: 10;">
                    <a href="#location"
                        style="display: inline-block; background-color: #333; color: white; padding: 8px 16px; border-radius: 50px; text-decoration: none; font-size: 14px;">
                        <i class="fa fa-map-marker" style="margin-right: 5px;"></i> Localização
                    </a>
                    <a href="https://api.whatsapp.com/send?phone=+{{ $company->cell }}&text=Ola" target="_blank"
                        style="display: inline-block; background-color: #25D366; color: white; padding: 8px 16px; border-radius: 50px; text-decoration: none; font-size: 14px;"><img
                            src="{{ asset('company-template/assets/img/whatsapp-logo.png') }}" alt="whatsapp"
                            style="width: 22px; margin-right: 5px;">{{ $company->cell }}</a>
                </span>
            </div>
        </header>


        @yield('content')

        <footer class="site-footer">
            <div class="site-footer-top">
                <div class="container">
                    <div class="row">
                        <div class="footer_widget widget text-center">
                            <h3 style="color: #fff; font-size: 14px;">Tenha sua loja virtual grátis e ilimitada.</br><a
                                    href="{{ route('admin.register') }}" style="color: #fff; font-size: 14px;">Clique aqui</a></h3>
                            <div style="background-color: #fff; width: 175px; margin: 0 auto;">
                                <img src="{{ url(asset('frontend/assets/images/brand.png')) }}" width="175"
                                        alt="Mega Feirão Veículos" class="d-inline-block">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <a id="back-to-top"><i class="fa fa-angle-double-up"></i></a>
    </div>

    <script src="{{ asset('company-template/assets/js/jquery.js') }}"></script>
    <script src="{{ asset('company-template/assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('company-template/assets/js/carousel.js') }}"></script>
    <script src="{{ asset('company-template/assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('company-template/assets/js/flexslider.js') }}"></script>
    <script src="{{ asset('company-template/assets/js/init.js') }}"></script>

    @yield('js')

</body>

</html>
