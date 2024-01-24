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
        <div class="custom-header">
            <div class="custom-header-logo">
                <h1><a href="{{ route('web.filterCompany', ['slug' => $company->slug]) }}"><img
                            src="{{ $company->logo() }}" alt="Logo"></a></h1>
            </div>
            <div class="custom-header-contact">
                <div>
                    <span class="tel-details">
                        <a href="tel:{{ $company->telephone }}">{{ $company->telephone }}</a>
                    </span>
                </div>
                <div>
                    <span class="tel-details">
                        <a href="tel:{{ $company->cell }}">{{ $company->cell }}</a>
                    </span>
                    <a href="https://api.whatsapp.com/send?phone=+{{ $company->cell }}&text=Ola" target="_blank"><img
                            src="{{ asset('company-template/assets/img/whatsapp-logo.png') }}" alt="whatsapp"
                            style="width: 22px; "></a>

                </div>
            </div>
            <div class="custom-header-navbar">
                <!-- Main Navigation -->
                <nav class="main-navigation" role="navigation" style="top: 0px;">
                    <ul class="sf-menu">
                        <li class="menuHome"><a href="{{ route('web.filterCompany', ['slug' => $company->slug]) }}"
                                title="Home"><i class="fa fa-home"></i> Home</a></li>

                        <li><a href="{{ route('web.filterCompanyAutomotive', ['slug' => $company->slug]) }}"
                                title="Nosso Estoque"><i class="fa fa-car"></i> Veículos</a>
                        </li>
                        <li class="menuLocalizacao" title="Localização"><a
                                href="{{ route('web.filterCompanyLocation', ['slug' => $company->slug]) }}"><i
                                    class="fa fa-map-marker"></i> Localização</a></li>
                        <li><a href="{{ route('web.filterCompanyContact', ['slug' => $company->slug]) }}"
                                title="Contato"><i class="fa fa-envelope"></i> Contato</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        {{-- <div class="site-header-wrapper">
            <header class="site-header">
                <div class="container sp-cont">
                    <div class="site-logo">
                        <h1><a href="{{ route('web.filterCompany', ['slug' => $company->slug]) }}"><img
                                    src="{{ $company->logo() }}" alt="Logo"></a></h1>
                    </div>
                    <div class="header-top noMobile">
                        <div class="container">
                            <div class="pull-left">
                                <ul class="top-bar-nav">
                                    <li><i class="fa fa-phone"></i><span class="tel-details"><a
                                                href="tel:{{ $company->telephone }}">{{ $company->telephone }}</a></span>
                                    </li>
                                    <li>
                                        <span class="tel-details">
                                            <a href="tel:{{ $company->cell }}">{{ $company->cell }} </a>
                                            <a href="https://api.whatsapp.com/send?phone=+{{ $company->cell }}&text=Ola"
                                                target="_blank"><img
                                                    src="{{ asset('company-template/assets/img/whatsapp-logo.png') }}"
                                                    alt="whatsapp" style="width: 22px; "></a>

                                        </span>
                                    </li>
                                </ul>
                                <div class="clear:both"></div>
                            </div>
                        </div>
                    </div>

                    <div class="navbar">
                        <!-- Main Navigation -->
                        <nav class="main-navigation dd-menu toggle-menu" role="navigation" style="top: 0px;">
                            <ul class="sf-menu">
                                <li class="menuHome"><a
                                        href="{{ route('web.filterCompany', ['slug' => $company->slug]) }}"
                                        title="Home"><i class="fa fa-home"></i> Home</a></li>

                                <li><a href="{{ route('web.filterCompanyAutomotive', ['slug' => $company->slug]) }}"
                                        title="Nosso Estoque"><i class="fa fa-car"></i> Veículos</a>
                                </li>
                                <li class="menuLocalizacao" title="Localização"><a
                                        href="{{ route('web.filterCompanyLocation', ['slug' => $company->slug]) }}"><i
                                            class="fa fa-map-marker"></i> Localização</a></li>
                                <li><a href="{{ route('web.filterCompanyContact', ['slug' => $company->slug]) }}"
                                        title="Contato"><i class="fa fa-envelope"></i> Contato</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="header-right">
                        <a href="#" class="visible-sm visible-xs" id="menu-toggle"><i
                                class="fa fa-bars"></i></a>
                    </div>
                </div>
            </header>
        </div> --}}
        @yield('content')

        <footer class="site-footer">
            <div class="site-footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 footer_widget widget text_widget">
                            <h4 class="widgettitle">{{ $company->social_name }}</h4>
                            <p style="text-align: justify; margin-top: 10px">
                                <a href="{{ route('web.filterCompany', ['slug' => $company->slug]) }}"><img
                                        src="{{ $company->logo() }}" alt="Logo"></a>
                            </p>
                        </div>

                        <div class="col-md-4 col-sm-6 footer_widget widget widget_custom_menu widget_links">
                            <h4 class="widgettitle">Mapa do Site</h4>
                            <ul style="width: 44%; float: left; margin-right: 30px;">
                                <li><a href="{{ route('web.filterCompany', ['slug' => $company->slug]) }}"
                                        title="Home"> Home</a></li>
                                <li><a href="{{ route('web.filterCompanyAutomotive', ['slug' => $company->slug]) }}"
                                        title="Nosso Estoque"> Veículos</a></li>
                            </ul>
                            <ul style="width: 46%; float: left;">
                                <li><a href="{{ route('web.filterCompanyLocation', ['slug' => $company->slug]) }}"
                                        title="Localização"> Localização</a></li>
                                <li><a href="{{ route('web.filterCompanyContact', ['slug' => $company->slug]) }}"
                                        title="Contato"> Contato</a></li>
                            </ul>
                            <div style="clear: both"></div>
                        </div>
                        <div class="col-md-4 col-sm-6 footer_widget widget widget_newsletter">
                            <h4 class="widgettitle">Contato</h4>
                            <section class="infoFooter">

                                <p class="tel">{{ $company->telephone }}</p>
                                <p class="tel">{{ $company->cell }}</p>
                                <h4 class="widgettitle"
                                    style="margin-bottom: 10px; padding-bottom: 5px; padding-top: 25px;">Endereço</h4>
                                <p class="endereco">
                                    {{ $company->street != '' ? $company->street . ',' : '' }}
                                    {{ $company->number != '' ? $company->number . ',' : '' }}<br />
                                    {{ $company->neighborhood != '' ? $company->neighborhood . ', ' : '' }}{{ $company->city }}-{{ $company->state }}
                                </p>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 copyrights-left">
                            <p>&copy; {{ $company->social_name }} -
                                {{ route('web.filterCompany', ['slug' => $company->slug]) }}</p>
                        </div>
                        <div class="col-md-6 col-sm-6 copyrights-right" style="text-align: right">
                            <p>Desenvolvido por <a href="{{ env('APP_URL') }}" target="_blank"
                                    title="{{ env('APP_NAME') }}"><img
                                        src="{{ asset('frontend/assets/images/brand.png') }}" width="100"
                                        alt="Logo" /></a>
                            </p>
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
