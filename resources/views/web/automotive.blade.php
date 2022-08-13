@extends('web.master.master')

@section('content')
    <section class="main_property">
        <div class="main_property_content py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <h2 class="text-truncate h2 my-1 d-flex justify-content-between font-weight-bold">
                            <span>{{ Illuminate\Support\Str::words($automotive->title, 7) }}</span>
                            <span class="text-primary">R$ {{ $automotive->sale_price }}</span>
                        </h2>

                        <div id="carouselProperty" class="carousel slide" data-ride="carousel">

                            <div class="carousel-inner">
                                @if ($automotive->images()->get()->count())
                                    @foreach ($automotive->images()->get() as $image)
                                        <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : '' }}">
                                            <a href="{{ $image->getUrlCroppedAttribute() }}" data-toggle="lightbox"
                                                data-gallery="property-gallery" data-type="image">
                                                <img src="{{ $image->getUrlCroppedAttribute() }}"
                                                    class="d-block w-100 h-100" alt="{{ $automotive->title }}">
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            @if ($automotive->images()->get()->count() > 1)
                                <a class="carousel-control-prev" href="#carouselProperty" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Anterior</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselProperty" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Próximo</span>
                                </a>
                            @endif
                            <ol class="carousel-indicators mx-0 px-4" style="position: relative!important;">
                                @if ($automotive->images()->get()->count() > 1)
                                    @foreach ($automotive->images()->get() as $image)
                                        <li data-target="#carouselProperty" data-slide-to="{{ $loop->iteration - 1 }}"
                                            {!! $loop->iteration == 1 ? 'class="active h-100"' : 'class="h-100"' !!}
                                            style="width: 100%; max-height: 100px; display: flex; justify-content: center;">
                                            <img src="{{ $image->getUrlCroppedAttribute() }}" class="rounded d-block w-100"
                                                alt="{{ $automotive->title }}" style="object-fit: cover" />
                                        </li>
                                    @endforeach

                                    <a class="carousel-control-prev" href="#carouselProperty" role="button"
                                        data-slide="prev" style="justify-content: start!important;">
                                        <span
                                            class="shadow-sm border border-navy icon-before icon-chevron-left text-primary bg-white rounded-circle"
                                            aria-hidden="true"></span>
                                        <span class="sr-only">Anterior</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselProperty" role="button"
                                        data-slide="next" style="justify-content: end!important;">
                                        <span
                                            class="shadow-sm border border-navy icon-before icon-chevron-right text-primary bg-white rounded-circle"
                                            aria-hidden="true"></span>
                                        <span class="sr-only">Próximo</span>
                                    </a>
                                @endif
                            </ol>
                        </div>

                        <div class="col-12 border rounded d-flex flex-wrap p-2">
                            <div class="col-6 col-md-3 border-right d-flex justify-content-center align-items-center">
                                <div class="text-center py-2" style="color: #183764; font-size: 1rem">
                                    <p class="my-0 font-weight-bold text-truncate">{{ $automotive->year }}</p>
                                    <p class="my-0" style="font-size: 0.825rem;">Ano/Modelo</p>
                                </div>
                            </div>

                            <div class="col-6 col-md-3 d-flex d-md-none justify-content-center align-items-center">
                                <div class="text-center py-2" style="color: #183764; font-size: 1rem">
                                    <p class="my-0 font-weight-bold text-truncate">{{ $automotive->mileage }}</p>
                                    <p class="my-0" style="font-size: 0.825rem;">Km</p>
                                </div>
                            </div>

                            <div
                                class="col-6 col-md-3 d-none d-md-flex justify-content-center align-items-center border-right">
                                <div class="text-center py-2" style="color: #183764; font-size: 1rem">
                                    <p class="my-0 font-weight-bold text-truncate">{{ $automotive->mileage }}</p>
                                    <p class="my-0" style="font-size: 0.825rem;">Km</p>
                                </div>
                            </div>

                            <div class="col-6 col-md-3 border-right d-flex justify-content-center align-items-center">
                                <div class="text-center py-2" style="color: #183764; font-size: 1rem">
                                    <p class="my-0 font-weight-bold text-truncate">{{ $automotive->fuel }}</p>
                                    <p class="my-0" style="font-size: 0.825rem;">Combustível</p>
                                </div>
                            </div>

                            <div class="col-6 col-md-3 d-flex justify-content-center align-items-center">
                                <div class="text-center py-2" style="color: #183764; font-size: 1rem">
                                    <p class="my-0 font-weight-bold text-truncate">{{ $automotive->gear }}</p>
                                    <p class="my-0" style="font-size: 0.825rem;">Transmissão</p>
                                </div>
                            </div>
                        </div>

                        <div class="main_property_price pt-4 text-muted">

                            @if (!empty($type))
                                <h1 class="main_property_price_big d-block d-lg-none text-primary font-weight-bold">R$
                                    {{ $automotive->sale_price }}</h1>
                            @else
                                <p class="main_properties_price text-front d-block d-lg-none">
                                    Entre em contato com a nossa equipe comercial!</p>
                            @endif
                        </div>

                        <div class="main_property_content_description">
                            <h4 class="font-weight-bold">OBSERVAÇÕES</h4>
                            {!! $automotive->description !!}
                        </div>

                        @if ($automotive->youtube_link != null)
                            <h4 class="font-weight-bold">VÍDEO DESCRITIVO</h4>
                            <div class='col-12 align-self-center mb-5 d-flex px-0'>
                                <div class='embed-responsive embed-responsive-16by9'>
                                    <iframe class="embed-responsive-item"
                                        src="{{ str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $automotive->youtube_link) }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                </div>
                            </div>
                        @endif

                        @if ($company)
                            <div class="main_property_location">
                                <h6 class="icon-map-marker font-weight-bolder">
                                    {{ $automotive->street }}, {{ $automotive->number }},
                                    {{ $automotive->neighborhood }},
                                    {{ $automotive->city }}/{{ $automotive->state }}

                                </h6>
                                <div id="map" style="width: 100%; min-height: 400px;"></div>
                            </div>
                        @endif

                    </div>

                    <div class="col-12 col-lg-4 mt-3 mt-lg-0">
                        <a target="_blank"
                            href="https://api.whatsapp.com/send?phone=55+{{ $company->cell ?? $automotive->ownerObject()->cell }}&text=Olá, me interessei sobre o seu anúncio."
                            class="btn btn-success btn-lg btn-block icon-whatsapp mb-3"><b>Enviar WhatsApp</b>
                        </a>

                        <div class="main_property_contact">
                            <h2 class="bg-front text-white icon-envelope text-center"><b>Enviar e-mail</b></h2>

                            <form action="{{ route('web.sendEmail') }}" method="post">
                                @csrf
                                <input type="hidden" name="ownerEmail"
                                    value="{{ $company->email ?? $automotive->ownerObject()->email }}">
                                <div class="form-group">
                                    {{-- <label for="name">Seu nome:</label> --}}
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Informe seu nome completo" required>
                                </div>

                                <div class="form-group">
                                    {{-- <label for="telephone">Seu telefone:</label> --}}
                                    <input type="tel" name="cell" class="form-control"
                                        placeholder="Informe seu telefone com DDD" required>
                                </div>

                                <div class="form-group">
                                    {{-- <label for="email">Seu e-mail:</label> --}}
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Informe seu melhor e-mail" required>
                                </div>

                                <div class="form-group">
                                    {{-- <label for="message">Sua Mensagem:</label> --}}
                                    <textarea name="message" id="message" cols="30" rows="5" class="form-control" required>Quero ter mais informações sobre o veículo {{ $automotive->title }}.</textarea>
                                </div>

                                <div class="form-group text-center">
                                    <button
                                        class="btn btn-block text-primary border border-primary bg-white">Enviar</button>
                                    @if ($company && $company->telephone)
                                        <p class="text-center text-front mb-0 mt-4 font-weight-bold">
                                            {{ $company->telephone }}</p>
                                    @endif
                                    @if (($company && $company->cell) || $automotive->ownerObject()->cell)
                                        <a target="_blank"
                                            href="https://api.whatsapp.com/send?phone=55+{{ $company->cell ?? $automotive->ownerObject()->cell }}&text=Olá, me interessei sobre o seu anúncio."
                                            class="text-dark text-decoration-none font-weight-bold mt-1 icon-whatsapp">{{ $company->cell ?? $automotive->ownerObject()->cell }}</a>
                                    @endif
                                </div>
                            </form>
                        </div>

                        @if ($company)
                            <div class="col-12 mt-5 px-0 text-center card">
                                <a href="{{ route('web.filterCompany', ['slug' => $company->slug]) }}">
                                    <img src="{{ $company->logo() }}" class="card-img-top"
                                        alt="{{ $company->alias_name }}">
                                </a>
                                <a class="text-secondary fs-6"
                                    href="{{ route('web.filterCompany', ['slug' => $company->slug]) }}">Ver todos os
                                    carros
                                    do anunciante</a>
                            </div>
                        @endif

                        @if ($banner->link3)
                            <div class="col-12 mt-5 px-0 text-center card">
                                <a href="{{ $banner->link3 ?? route('web.register') }}"
                                    class="d-flex justify-content-center align-content-center h-100">
                                    <img src="{{ $banner->cover3 ? asset('storage/' . $banner->cover3) : url(asset('frontend/assets/images/banner-horizontal-lateral.png')) }}"
                                        class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt=""
                                        title=""></a>
                            </div>
                        @else
                            <div class="col-12 mt-5 px-0 text-center card">
                                <a href="{{ route('web.register') }}"
                                    class="d-flex justify-content-center align-content-center h-100">
                                    <img src="{{ url(asset('frontend/assets/images/banner-horizontal-lateral.png')) }}"
                                        class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt=""
                                        title=""></a>
                            </div>
                        @endif

                        @if ($banner->link4)
                            <div class="col-12 mt-5 px-0 text-center">
                                <a href="{{ $banner->link4 ?? route('web.register') }}"
                                    class="d-flex justify-content-center align-content-center h-100">
                                    <img src="{{ $banner->cover4 ? asset('storage/' . $banner->cover4) : url(asset('frontend/assets/images/banner-horizontal-lateral.png')) }}"
                                        class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt=""
                                        title=""></a>
                            </div>
                        @else
                            <div class="col-12 mt-5 px-0 text-center">
                                <a href="{{ route('web.register') }}"
                                    class="d-flex justify-content-center align-content-center h-100">
                                    <img src="{{ url(asset('frontend/assets/images/banner-horizontal-lateral.png')) }}"
                                        class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt=""
                                        title=""></a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    @if ($company)
        <script>
            function markMap() {

                var locationJson = $.getJSON(
                    'https://maps.googleapis.com/maps/api/geocode/json?address={{ $automotive->street }},+{{ $automotive->number }}+{{ $automotive->city }}+{{ $automotive->neighborhood }}&key={{ env('GOOGLE_API_KEY') }}',
                    function(response) {

                        lat = response.results[0].geometry.location.lat;
                        lng = response.results[0].geometry.location.lng;

                        const map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 14,
                            center: {
                                lat: lat,
                                lng: lng
                            },
                            mapTypeId: 'terrain'
                        });

                        const beachMarker = new google.maps.Marker({
                            position: {
                                lat: lat,
                                lng: lng
                            },
                            map,
                        });
                    });
            }
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&callback=markMap">
        </script>
    @endif
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
@endsection
