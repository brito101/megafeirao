<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/reset.css')) }}" />
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/boot.css')) }}" />
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/login.css')) }}" />
    <link rel="icon" type="image/png" href="{{ url(asset('backend/assets/images/logo.png')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mega Feirão Veículos - Recuper Senha</title>
</head>

<body>

    <div class="ajax_response"></div>

    <div class="dash_login">
        {{-- <header class="logo">
            <div class="dash_login_box_headline_logo">
                <a href="{{ route('web.home') }}">
                    <img src="{{ url(asset('backend/assets/images/brand.png')) }}" width="250">
                </a>
            </div>
        </header>

        <div class="dash_login_left">
            <article>
                <p>Anuncie Grátis</p>
                <p>Anúncios Particulares e Concessionárias</p>
                <p>Traga sua concessionária para o nosso site e ganhe loja virtual grátis.</p>
                <p>Sem mensalidade, sem plano de fidelidade, sem taxa de adesão, sem pagamento mínimo e muito mais.</p>
            </article>
        </div> --}}

        <div class="dash_container_login">
            <article class="dash_login_right_box">
                <header class="dash_login_box_headline">
                    <h1>Recuperar Senha</h1>
                </header>
                <form name="resetAccount" action="{{ route('admin.reset.do') }}" method="post" autocomplete="off">
                    <label>
                        <span class="field icon-unlock-alt">Nova Senha:</span>
                        <input type="password" name="password_check" placeholder="Informe sua nova senha" id="password"
                            required />
                    </label>

                    <label>
                        <span class="field icon-unlock-alt">Confirmar Senha:</span>
                        <input type="password" name="password_confirm" placeholder="Confirme sua nova senha"
                            id="confirm_password" required />
                    </label>
                    <button>Enviar</button>

                    <div class="links">
                        <a href="{{ route('admin.login') }}" style="text-decoration: none;">Login</a>
                    </div>
                </form>
            </article>

        </div>
    </div>

    <script src="{{ url(mix('backend/assets/js/jquery.js')) }}"></script>
    <script src="{{ url(mix('backend/assets/js/login.js')) }}"></script>
</body>

</html>
