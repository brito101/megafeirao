@component('mail::message')
# Redefinição de Senha

<p>Recebemos uma solicitação de redefinição de senha com os seguintes dados:</p>

<p>Usuário: {{ $name }}</p>
<p>E-mail: {{ $email }}</p>
<p>Link para a redefinição de senha: {{ $message }}</p>
<p>Ou clique aqui:  <a target="_blank" href="{{ $message }}">Redefinir Senha</a></p>

<p>Caso você não tenha solicitado, ignore este e-mail</p>

<p>* Esse e-mail é enviado automaticamente através do sistema!</p>

@endcomponent