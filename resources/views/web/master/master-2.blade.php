<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {!! $head ?? '' !!}

     <style>
        :root {
            --primary: #2c3e50;
            --secondary: #e74c3c;
            --accent: #3498db;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --gray: #95a5a6;
            --success: #27ae60;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f9f9f9;
            color: var(--dark);
            line-height: 1.6;
        }
        
        /* Header */
        header {
            background-color: white;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo h1 {
            font-size: 1.5rem;
            color: var(--primary);
        }
        
        .logo span {
            color: var(--secondary);
        }
        
        .logo-icon {
            font-size: 1.8rem;
            color: var(--secondary);
        }
        
        nav ul {
            display: flex;
            list-style: none;
            gap: 1.5rem;
        }
        
        nav a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: var(--transition);
        }
        
        nav a:hover {
            color: var(--secondary);
        }
        
        .cta-button {
            background-color: var(--secondary);
            color: white;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .cta-button:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(44, 62, 80, 0.8), rgba(44, 62, 80, 0.9)), url('https://images.unsplash.com/photo-1494976388531-d1058494cdd8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 5rem 2rem;
            text-align: center;
        }
        
        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        /* Search Section */
        .search-container {
            max-width: 1000px;
            margin: -3rem auto 0;
            background: white;
            border-radius: 8px;
            box-shadow: var(--shadow);
            padding: 2rem;
            position: relative;
            z-index: 10;
        }
        
        .search-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-control {
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .search-button {
            background-color: var(--secondary);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 0.8rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            align-self: end;
        }
        
        .search-button:hover {
            background-color: #c0392b;
        }
        
        /* Cars Section */
        .cars-section {
            max-width: 1200px;
            margin: 5rem auto;
            padding: 0 2rem;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-title h2 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .section-title p {
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .cars-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }
        
        .car-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }
        
        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        
        .car-image {
            height: 120px;
            background-color: #eee;
            background-size: cover;
            background-position: center;
        }
        
        .car-info {
            padding: 1.5rem;
        }
        
        .car-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }
        
        .car-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        .car-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 1rem;
        }
        
        .car-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn {
            padding: 0.6rem 1rem;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
            text-align: center;
            flex: 1;
        }
        
        .btn-primary {
            background-color: var(--accent);
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--accent);
            border: 1px solid var(--accent);
        }
        
        .btn-outline:hover {
            background-color: var(--accent);
            color: white;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
            gap: 0.5rem;
        }
        
        .page-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .page-btn.active {
            background-color: var(--accent);
            color: white;
            border-color: var(--accent);
        }
        
        .page-btn:hover:not(.active) {
            background-color: #f5f5f5;
        }
        
        /* Footer */
        footer {
            background-color: var(--primary);
            color: white;
            padding: 4rem 2rem 2rem;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }
        
        .footer-column h3 {
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column ul li {
            margin-bottom: 0.8rem;
        }
        
        .footer-column a {
            color: #ddd;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .footer-column a:hover {
            color: white;
        }
        
        .social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        
        .social-icon:hover {
            background-color: var(--secondary);
        }
        
        .copyright {
            text-align: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #aaa;
            font-size: 0.9rem;
        }

        #histats_counter {
            margin-top: 1rem;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .cars-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            nav ul {
                gap: 1rem;
            }
            
            .hero h2 {
                font-size: 2rem;
            }
            
            .search-container {
                margin: -2rem 1rem 0;
            }
            
            .search-form {
                grid-template-columns: 1fr;
            }
            
            .cars-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 480px) {
            .cars-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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

        gtag('config', "{{ env('GOOGLE_TAG_MANAGER') }}");
    </script>
</head>

<body style="overflow-x: hidden;">

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v12.0"
        nonce="VCEFC7kz"></script>

    @include('vendor.cookieConsent.index')

     <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo">
                <div class="logo-icon">🚗</div>
                <h1>MeuCarro<span>.Top</span></h1>
            </div>
            <nav>
                <ul>
                    <li><a href="{{ route('web.home') }}">Início</a></li>
                    <li><a href="{{ route('admin.register') }}">Anuncie Grátis</a></li>
                    <li><a href="{{ route('web.contact') }}">Contato</a></li>
                </ul>
            </nav>
            <a href="{{ route('admin.login') }}" class="cta-button" style="text-decoration: none;">Minha Conta</a>
        </div>
    </header>

        @yield('content')
        

    <!-- Footer -->
    <footer>
        <div class="copyright">
            &copy; 2025 Megafeira Veículos - Todos os direitos reservados
            <p id="histats_counter"></p>
        </div> 
        <!-- Histats.com  (div with counter) -->
        
    </footer>

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
