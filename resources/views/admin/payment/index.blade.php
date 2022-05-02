@extends('admin.master.master')

@section('content')
<div style="flex-basis: 100%;">
    <section class="dash_content_app">
        <header class="dash_content_app_header pb-1">
            <h2 class="icon-opencart">Créditos</h2>
            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">
            <div class="text-center py-2 bg-orange radius">
                <p style="color: #fff; padding: 20px;">O prazo de ativação dos créditos para anúncios é de até 24h após a confirmação de pagamento</p>        
            </div>   
            <section>
                <div class="dash_content_app_box">
                    <h3 class="icon-tachometer">Histórico</h3>
                    <div class="d-flex justify-content-center">
                        <table class="mx-auto">
                        <tbody>
                            <tr>
                                <td class="px-2">10</td>
                                <td class="px-2">15/06/2021</td>
                                <td class="px-2">Cadastro</td>
                            </tr>
                            <tr>
                                <td class="px-2">9</td>
                                <td class="px-2">15/06/2021</td>
                                <td class="px-2">#Hiunday HB 20</td>
                            </tr>
                            <tr>
                                <td class="px-2">8</td>
                                <td class="px-2">15/06/2021</td>
                                <td class="px-2">#Hiunday HB 20</td>
                            </tr>
                            <tr>
                                <td class="px-2">7</td>
                                <td class="px-2">15/06/2021</td>
                                <td class="px-2">#Hiunday HB 20</td>
                            </tr>
                            <tr>
                                <td class="px-2">6</td>
                                <td class="px-2">15/06/2021</td>
                                <td class="px-2">#Hiunday HB 20</td>
                            </tr>
                            <tr><td>...</td></tr>
                             <tr>
                                <td class="px-2">30</td>
                                <td class="px-2">15/06/2021</td>
                                <td class="px-2">#Hiunday HB 20</td>
                            </tr>
                            <tr>
                                <td class="px-2">29</td>
                                <td class="px-2">20/06/2021</td>
                                <td class="px-2">Créditos</td>
                            </tr>
                            <tr>
                                <td class="px-2">28</td>
                                <td class="px-2">15/06/2021</td>
                                <td class="px-2">#Hiunday HB 20</td>
                            </tr>
                            <tr>
                                <td class="px-2">27</td>
                                <td class="px-2">15/06/2021</td>
                                <td class="px-2">#Hiunday HB 20</td>
                            </tr>
                            <tr><td>...</td></tr>
                        </tbody>
                    </table>
                    </div>
                    <div class="text-center mt-2">
                        <h1>Em Breve</h1>
                    </div>
                </div>
                <!--                <div class="text-left py-2">
                                    <h2 class="icon-tachometer my-2"><u>Saldo disponível</u></h2>
                                       <p>R$ {{ number_format($credits , 2, ',', '') }}</p>        
                                </div>   
                                <div class="text-left py-2">
                                    <h2 class="icon-tachometer my-2"><u>Para inserir mais créditos:</u></h2>
                                    <p>faça um PIX de qualquer valor para</p>
                                    <p><u>{{ env('PIX') }}</u></p>        
                                </div>   
                                <div class="text-left py-2">
                                    <h2 class="icon-tachometer my-2"><u>Plano Personalizado</u></h2>
                
                                    <p>Cada anúncio (30 dias) = R$ 1,00</p>
                                    <p>Cada banner (200 visualizações) = R$ 1,00</p>
                                    <p>Loja virtual básica (30 dias) = GRÁTIS</p>
                                    <p>Loja virtual TOP (30 dias) = R$ 3,00</p>
                
                                    <div style="font-size: .75rem;" class="pt-2">
                                        <p>Após isso vc deve enviar seu comprovante de pagamento através do Fale Conosco (do lado esquerdo).<br>
                                            Após seus créditos serem inseridos não há limite de tempo para serem utilizados.<br>
                                            Após publicado o anúncio o mesmo tem validade de 30 dias.</p>
                                    </div>-->
        </div>   
    </section>
</div>
</section>
</div>
@endsection