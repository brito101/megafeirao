@extends('web.master.master')

@section('content')
<div class="container">
    <div class=' mx-auto'>
        <h2 class="text-center py-5 text-front d-none d-md-block">Vantagens anunciando no <br> www.megafeiraoveiculos.com.br</h2>
        <h2 class="text-center py-5 text-front d-block d-md-none">Vantagens anunciando</h2>
    </div>
    <ul class="register_items text-dark">
        <li class="icon-check">Cadastro rápido e simples</li>
        <li class="icon-check">Economia de anunciar</li>
        <li class="icon-check">Economia taxa de cadastro</li>
        <li class="icon-check">Economia taxa de adesão</li>
        <li class="icon-check">Economia mensalidade</li>
        <li class="icon-check">Economia plano fidelidade</li>
        <li class="icon-check">Economia no pagamento (apenas PIX)</li>
        <li class="icon-check">Economia progressivos</li>
        <li class="icon-check">Economia grátis para novos anunciantes</li>
        <li class="icon-check">Economia especiais</li>
        <li class="icon-check">Economia virtual ilimitada</li>
        <li class="icon-check">Economia diária na internet</li>
        <li class="icon-check">Economia anúncios em destaque</li>
        <li class="icon-check">Economia propaganda excessiva</li>
        <li class="icon-check">Economia com menor preço do mercado</li>
        <li class="icon-check">Economia mensais no site</li>
        <li class="icon-check">Economia preço do mercado</li>
        <li class="icon-check">Economia qualquer valor da concorrência</li>
        <li class="icon-check">Economia do começo ao fim</li>
    </ul>
</div>
<div class="d-flex justify-content-center py-5">
    <a href="{{ route('admin.account') }}" class="btn btn-front">Clique aqui e anuncie grátis</a>
</div>
@endsection