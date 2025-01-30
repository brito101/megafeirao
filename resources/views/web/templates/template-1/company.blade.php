@extends('web.templates.template-1.master')

@section('content')
    <div class="main DivConteudoButton" role="main">
        <div id="content" class="content full padding-b0 contentDefault backOfertas">
            <div class="container">
                <div class="section-header-1">
                    <h3>Ofertas em <strong>Destaque</strong></h3>
                    <h2 class="sub-text-title-ch">Carros revisados com garantia!</h2>
                    <hr class="hr-style">
                </div>
                <div class="row">
                    <!-- Listing Results -->
                    <div class="col-md-12 results-container veiculosHome">
                        <section class="listing-block trending-listing">
                            <div class="listing-container">
                                <div class="results-container-in">
                                    <div class="waiting" style="display: none;">
                                        <div class="spinner">
                                            <div class="rect1"></div>
                                            <div class="rect2"></div>
                                            <div class="rect3"></div>
                                            <div class="rect4"></div>
                                            <div class="rect5"></div>
                                        </div>
                                    </div>
                                    <div id="results-holder" class="results-grid-view">
                                        @foreach ($automotivesForSale as $automotive)
                                            <div class="result-item">
                                                <div class="result-item-image" style="margin: -10px -10px 5px -10px;">
                                                    <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                        class="media-box">
                                                        <img src="{{ $automotive->coverFront() }}" alt="">
                                                        <span class="zoom"><span class="icon"><i
                                                                    class="fa fa-plus-circle"></i></span></span>
                                                    </a>
                                                </div>
                                                <div class="result-item-in" style="">
                                                    <div class="result-item-cont result-item-pricing-home">
                                                        <div class="price">R$ {{ $automotive->sale_price }}
                                                        </div>
                                                    </div>
                                                    <h4 class="result-item-title"><a
                                                            href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">{{ $automotive->title }}</a>
                                                    </h4>
                                                    <h5 class="result-item-title">
                                                        <span>{{ $automotive->mileage }} KM</span>
                                                        - <span>{{ $automotive->year }}</span>
                                                    </h5>
                                                    <div style="clear:both"></div>
                                                </div>
                                                <div style="clear:both"></div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
