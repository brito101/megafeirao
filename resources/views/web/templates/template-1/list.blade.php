@extends('web.templates.template-1.master')

@section('content')
    <div class="utility-bar noMobile">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-8">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('web.filterCompany', ['slug' => $company->slug]) }}">Home</a></li>
                        <li class="active">Veículos</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-4">
                </div>
            </div>
        </div>
    </div>

    <div class="main" role="main">
        <div id="content" class="content full contentEstoque">
            <div class="container">
                <div class="row">
                    <div class="col-12 results-container">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 search-actions" style="padding-top: 7px;">
                                <h4>mostrando 1 - {{ $automotivesForSale->count() }} de
                                    {{ $automotivesForSale->count() }} veículos.</h4>
                            </div>
                            <div style="clear:both;padding: 10px;"></div>
                        </div>
                        <div class="lista-veiculos">
                            <div class="waiting" style="display:none;">
                                <div class="spinner">
                                    <div class="rect1"></div>
                                    <div class="rect2"></div>
                                    <div class="rect3"></div>
                                    <div class="rect4"></div>
                                    <div class="rect5"></div>
                                </div>
                            </div>
                            <div id="results-holder" class="results-list-view">
                                @foreach ($automotivesForSale as $automotive)
                                    <div class="col-12 col-md-6 p-2">
                                        <div class="result-item">
                                            <div class="col-md-6 fotoVeiculo" style="padding-left: 0;">
                                                <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                    class="media-box">
                                                    <img src="{{ $automotive->coverFront() }}"
                                                        alt="{{ $automotive->title }}">
                                                    <span class="zoom"><span class="icon"><i
                                                                class="fa fa-plus-circle"></i></span></span>
                                                </a>
                                                <span
                                                    class="label label-primary vehicle-age">{{ $automotive->fuel }}</span>
                                                <div class="result-item-features">
                                                    <div class="result-item-view-buttons">
                                                        <a class="btn btn-primary"
                                                            href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"><i
                                                                class="fa fa-plus"></i> MAIS DETALHES</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="result-item-title">
                                                    <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                        style="height: 95px; display: inline-block">{{ \Illuminate\Support\Str::limit($automotive->title, 45) }}<br />
                                                        <span class="versaoVeiculo">{{ $automotive->gear }}</span><br />
                                                        <span
                                                            class="versaoVeiculo">{{ $automotive->city }}-{{ $automotive->state }}</span>
                                                    </a>
                                                </h4>
                                                <div class="result-item-pricing">
                                                    <div class="price"><span style="font-size: 14px;">R$ </span>
                                                        {{ $automotive->sale_price }}</div>
                                                </div>
                                                <div class="div-hr"></div>
                                                <div class="result-item-block">
                                                    <ul class="listaEspecificacoes">
                                                        <li class="primeiro">
                                                            <span>Ano</span>
                                                            <p>{{ $automotive->year }}</p>
                                                        </li>
                                                        <li class="usado">
                                                            <span>Km</span>
                                                            <p>{{ $automotive->mileage }}</p>
                                                        </li>
                                                    </ul>
                                                    <div style="clear:both;"></div>
                                                </div>
                                                <div class="div-hr" style="margin-top: 0;"></div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
