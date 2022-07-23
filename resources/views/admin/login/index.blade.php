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

    <title>Mega Feirão Veículos - Criação de conta</title>
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
        </header> --}}

        {{-- <div class="dash_login_left">
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
                    <h1>Login</h1>
                </header>
                <form name="login" action="{{ route('admin.login.do') }}" method="post" autocomplete="off">
                    <label>
                        <span class="field icon-envelope">E-mail:</span>
                        <input type="email" name="email" placeholder="Informe seu e-mail" maxlength="191"
                            required />
                    </label>
                    <label>
                        <span class="field icon-unlock-alt">Senha:</span>
                        <input type="password" name="password_check" placeholder="Informe sua senha" required />
                    </label>
                    <button>Entrar</button>

                    <div class="links">
                        <a href="{{ route('admin.forgotten') }}" style="text-decoration: none;">Recuperar Senha</a>
                    </div>
                </form>
            </article>


            <article class="dash_login_right_box">
                <header class="dash_login_box_headline">
                    <h1>Nova Conta</h1>
                </header>
                <form name="newAccount" action="{{ route('admin.account.do') }}" method="post" autocomplete="off">
                    <label>
                        <span class="field icon-user">Nome:</span>
                        <input type="text" name="name" placeholder="Informe seu nome" minlength="3"
                            maxlength="191" required />
                    </label>

                    <label>
                        <span class="field icon-envelope">E-mail:</span>
                        <input type="email" name="email" placeholder="Informe seu e-mail" maxlength="191"
                            required />
                    </label>

                    <label>
                        <span class="field icon-unlock-alt">Senha:</span>
                        <input type="password" name="password_check" placeholder="Informe sua senha" id="password"
                            required />
                    </label>

                    <label>
                        <span class="field icon-unlock-alt">Confirmar Senha:</span>
                        <input type="password" name="password_confirm" placeholder="Confirme sua nova senha"
                            id="confirm_password" required />
                    </label>
                    <button>Enviar</button>
                </form>
            </article>
        </div>
    </div>

    <script src="{{ url(mix('backend/assets/js/jquery.js')) }}"></script>
    <script src="{{ url(mix('backend/assets/js/login.js')) }}"></script>

</body>

</html>
