@extends('admin.master.master')

@section('content')
    <div style="flex-basis: 100%; max-width: 100%;">
        <section class="dash_content_app">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Dashboard</h2>
            </header>

            <div class="dash_content_app_box">
                <section class="app_dash_home_stats">
                    @hasanyrole('Administrador|Gerente')
                        <article class="control radius">
                            <h4 class="icon-users">Clientes</h4>
                            <p><b>Total:</b> {{ $team }}</p>
                        </article>

                        <article class="control radius">
                            <h4 class="icon-list">Lista de clientes</h4>
                            <div class="d-flex justify-content-center">
                                <a download="Clientes" href="{{ Storage::url('clientes.txt') }}" title="Clientes"
                                    class="btn btn-orange icon-download mx-auto">Download</a>
                            </div>
                        </article>

                        <article class="control radius">
                            <h4 class="icon-list">Lista de contatos</h4>
                            <div class="d-flex justify-content-center">
                                <a download="Contatos" href="{{ Storage::url('usuarios.txt') }}" title="Contatos"
                                    class="btn btn-orange icon-download mx-auto">Download</a>
                            </div>
                        </article>
                    @endhasanyrole

                    @hasrole('Anunciante')
                        <article class="blog radius">
                            <h4 class="icon-car">Veículos</h4>
                            <p><b>Ativos:</b> {{ $automotivesAvailable }}</p>
                            <p><b>Inativos:</b> {{ $automotivesUnavailable }}</p>
                            <p><b>Total:</b> {{ $automotivesTotal }}</p>
                        </article>

                        <article class="blog radius">
                            <h4 class="icon-picture-o">Visualizações</h4>
                            <p>Seus anúncios e seus banners foram vistos 2.345 vezes por pessoas da sua cidade.</p>
                        </article>

                        <article class="blog radius">
                            <h4 class="icon-bullhorn">Limite de Anúncios</h4>
                            <p><b>Disponíveis:</b> {{ Auth::user()->ads_limit }}</p>
                            <p class="text-red">Para inserir mais anúncios faça um PIX de qualquer valor para
                                megafeiraoveiculos@gmail.com e envie o comprovante pelo Fale Conosco ao lado. Cada anúncio custa
                                R$ 1,00</p>
                        </article>

                        <article class="radius mt-2" style="flex-basis: 100%;">
                            <h4 class="icon-info-circle">Informações</h4>
                            <p class="text-red my-0"><b>NUNCA</b> entraremos em contato solicitando senha, dados pessoais ou
                                qualquer
                                tipo de informação.</p>
                            <p class="text-red my-0"><b>NUNCA</b> enviaremos mensagens via SMS, Whatsapp, Telegram ou qualquer
                                tipo.
                            </p>
                            <p class="text-red my-0">Qualquer contato será feito apenas pelo email
                                megafeiraoveiculos@gmail.com.
                            </p>
                            <p class="text-red my-0">Confira se o email que você recebeu realmente é nosso antes de responder.
                            </p>
                        </article>

                        <article class="radius mt-2" style="flex-basis: 100%;">
                            <h4 class="icon-gift">Dicas</h4>
                            <p class="my-0">Faça fotos de boa qualidade e iluminadas.</p>
                            <p class="my-0">Informe da frente, traseira, laterais, bancos e painel do carro.</p>
                            <p class="my-0">Informe foto do painel mostrando a quilometragem verdadeira do carro.</p>
                            <p class="my-0">Informe valor total no título do anúncio.</p>
                            <p class="my-0">Informe o valor da entrada, o valor parcelado e o valor total.</p>
                            <p class="my-0">Informe valor mínimo de entrada e dê exemplos de parcelamento.</p>
                            <p class="my-0">Informe é possível o parcelamento para negativados.</p>
                            <p class="my-0">Informe se há condições especiais de parcelamento para UBER, 99, etc.</p>
                        </article>
                    @endhasrole
                </section>
            </div>
        </section>

        <section class="dash_content_app" style="margin-top: 40px;">
            <header class="dash_content_app_header">
                <h2 class="icon-car">Últimos Veículos Cadastrados</h2>
            </header>

            <div class="dash_content_app_box">
                <div class="dash_content_app_box_stage">
                    <div class="realty_list">
                        @if (!empty($automotives))
                            @foreach ($automotives as $automotive)
                                <div class="realty_list_item mb-2">
                                    <div class="realty_list_item_actions_stats">
                                        <img src="{{ $automotive->cover() }}" alt="">
                                        <ul>
                                            <li>Venda: R$ {{ $automotive->sale_price }}</li>
                                        </ul>
                                    </div>

                                    <div class="realty_list_item_content">
                                        <h4>#{{ $automotive->id }}
                                            {{ $automotive->title }}<span class="ml-2"
                                                style="font-size: 0.875rem; font-weight: lighter;">Visualizações:{{ $automotive->views }}</span>
                                        </h4>

                                        <div class="realty_list_item_card d-flex flex-wrap"
                                            style="flex-basis: 100%; border:none; justify-content: space-between">
                                            @if ($automotive->sale == true && !empty($automotive->sale_price))
                                                <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                    class="btn btn-blue button_action" target="_blank">Ver Anúncio</a>
                                            @endif

                                            @if ($automotive->rent == true && !empty($automotive->rent_price))
                                                <a href="{{ route('web.rentAutomotive', ['slug' => $automotive->slug]) }}"
                                                    class="btn btn-blue button_action" target="_blank">Ver Anúncio</a>
                                            @endif

                                            @php
                                                $active = $automotive->active_date >= Carbon\Carbon::now()->subDays(30);
                                            @endphp
                                            <div class="text-center btn btn-orange" style="height: 35px;
                                                                display: flex;
                                                                align-items: center;">
                                                {{ $active == 1 ? 'Ativo desde de ' . date('d/m/Y', strtotime($automotive->active_date)) : 'Inativo' }}
                                            </div>
                                            @if ($active == 0)
                                                <form
                                                    action="{{ route('admin.automotives.reactive', ['automotive' => $automotive->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <input class="btn btn-orange button_action" type="submit"
                                                        value="Reanunciar">
                                                </form>
                                            @endif

                                            @can('Editar Veículos')
                                                <a href="{{ route('admin.automotives.edit', ['automotive' => $automotive->id]) }}"
                                                    class="btn btn-green button_action">Editar</a>
                                            @endcan

                                            @can('Remover Veículos')
                                                <form
                                                    action="{{ route('admin.automotives.destroy', ['automotive' => $automotive->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <input class="btn btn-red button_action" type="submit" value="Remover">
                                                </form>
                                            @endcan
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-content">Não foram encontrados registros!</div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
