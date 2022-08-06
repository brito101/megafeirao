@extends('web.master.master')

@section('content')
    <section class="main_property">

        <div class="main_property_header">
            <div class="px-0 mx-0 bg-dark mt-n1">
                @if ($company->main_banner)
                    <div class="row col-12 px-0 mx-0" style="max-height: 300px;">
                        <img src="{{ $company->mainBanner() }}" style="height: auto; max-width: 100%;"
                            alt="{{ $company->social_name }}">
                    </div>
                    <div
                        class="col-12 text-center text-white font-weight-bold d-flex flex-wrap justify-content-center bg-danger py-2">
                        <div class="container d-flex flex-wrap justify-content-center">

                            @if ($company->street)
                                {{ $company->street ? $company->street . ', ' : '' }}
                                {{ $company->number ? $company->number . ', ' : '' }}
                                {{ $company->neighborhood ? $company->neighborhood . ', ' : '' }}
                                {{ $company->city ? $company->city : '' }}
                                {{ $company->state ? '-' . $company->state . '. ' : '' }}
                                {{ $company->zipcode ? 'CEP: ' . $company->zipcode . '. ' : '' }}
                            @endif

                            @if ($company->telephone)
                                <div>
                                    <i class="ml-md-2 icon-phone-square text-white"></i>{{ $company->telephone }}
                                </div>
                            @endif
                            @if ($company->cell)
                                <div>
                                    <i class="icon-whatsapp text-white"></i>{{ $company->cell }}
                                </div>
                            @endif

                        </div>
                    </div>
            </div>
        @else
            <div class="row p-1 mx-0">
                <div class="container">
                    <div class="col-12 text-center text-white font-weight-bold d-flex flex-wrap justify-content-center">
                        <div class="col-12 col-md-4 d-flex align-items-center py-2 py-md-0">
                            @if ($company->street)
                                <div class="col-12 text-center text-md-left">
                                    {{ $company->street ? $company->street . ', ' : '' }}
                                    {{ $company->number ? $company->number . ', ' : '' }}
                                    {{ $company->neighborhood ? $company->neighborhood . ', ' : '' }}
                                    {{ $company->city ? $company->city : '' }}
                                    {{ $company->state ? '-' . $company->state . '. ' : '' }}
                                    {{ $company->zipcode ? 'CEP: ' . $company->zipcode . '. ' : '' }}
                                </div>
                            @endif
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="d-flex py-1">
                                <img src="{{ $company->cover() }}" class="w-75 m-auto img-thumbnail "
                                    alt="{{ $company->social_name }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 d-flex flex-wrap align-items-center justify-content-end">
                            <div class="col-12 col-md-9 col-lg-7 text-center mt-2 mt-md-0 text-md-left">
                                @if ($company->telephone)
                                    <div>
                                        <i class="icon-phone-square text-success"></i>{{ $company->telephone }}
                                    </div>
                                @endif
                                @if ($company->cell)
                                    <div>
                                        <i class="icon-whatsapp text-success"></i>{{ $company->cell }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        </div>

        @if ($company->banner1() || $company->banner2() || $company->banner3())
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @if ($company->banner1())
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ $company->banner1() }}" alt="First slide"
                                style="height: auto">
                        </div>
                    @endif
                    @if ($company->banner2())
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{ $company->banner2() }}" alt="Second slide"
                                style="height: auto">
                        </div>
                    @endif
                    @if ($company->banner3())
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{ $company->banner3() }}" alt="Third slide"
                                style="height: auto">
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if ($automotivesForSale->count())
            <div class="bg-warning py-2 mb-5">
                <ul class="nav nav-tabs border-0 justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item px-1">
                        <a class="nav-link btn btn-sm btn-warning font-weight-bold" id="contact-tab" data-toggle="tab"
                            href="#contact" role="tab" aria-controls="Entre em contato" aria-selected="false">Entre em
                            contato</a>
                    </li>
                    <span class="d-none d-md-flex align-items-center font-weight-bold">-</span>
                    <li class="nav-item px-1">
                        <a class="nav-link btn btn-sm btn-warning font-weight-bold active" id="inventory-tab"
                            data-toggle="tab" href="#inventory" role="tab" aria-controls="Nosso Estoque"
                            aria-selected="true">Nosso
                            Estoque</a>
                    </li>
                    <span class="d-none d-md-flex align-items-center font-weight-bold d-none">-</span>
                    <li class="nav-item px-1">
                        <a class="nav-link btn btn-sm btn-warning font-weight-bold" id="location-tab" data-toggle="tab"
                            href="#location" role="tab" aria-controls="Como chegar" aria-selected="false">Como
                            chegar</a>
                    </li>
                </ul>
            </div>
            <div class="container">
                <section class="main_properties pb-5">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="d-flex justify-content-center">
                                <form action="{{ route('web.sendEmail') }}" method="post" style="max-width: 800px"
                                    class="w-100">
                                    @csrf
                                    <input type="hidden" name="company" value="{{ $company->id }}">
                                    <h4 style="font-size: 1.25rem; font-weight: 600">Envie sua mensagem</h4>
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Nome"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="E-mail"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <textarea name="message" rows="5" class="form-control" placeholder="Mensagem" required></textarea>
                                    </div>

                                    <div class="form-group text-right">
                                        <button class="btn btn-success">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade show active col-12 col-md-11 col-lg-11 mx-auto" id="inventory"
                            role="tabpanel" aria-labelledby="inventory-tab">

                            @if ($automotivesForSale->count() > 0)
                                <div class="row pb-2 pb-lg-4" style="margin-top: 20px;">
                                    <div class="col-12">
                                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <div class="d-flex">
                                                        @foreach ($automotivesForSale->slice(0, 4) as $automotive)
                                                            <article class="col-6 col-lg-3 mb-2 mb-lg-0">
                                                                <div class="img-responsive">
                                                                    <a
                                                                        href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                                        <img src="{{ $automotive->coverFront() }}"
                                                                            class="card-img-top rounded"
                                                                            alt="{{ $automotive->title }}"
                                                                            style="height: auto">
                                                                    </a>
                                                                </div>
                                                                <h3 class="my-2"><a
                                                                        href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                        class="text-dark main_properties_price text-truncate d-block"
                                                                        style="font-size: 16px">{{ $automotive->title }}</a>
                                                                </h3>
                                                                <div class="d-flex flex-wrap justify-content-between">
                                                                    <span
                                                                        class="main_properties_price text-dark font-weight-bold"
                                                                        style="font-size: 18px">R$
                                                                        {{ $automotive->sale_price }}</span>
                                                                    <a href="#"
                                                                        class="ml-2 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                                        data-id="{{ $automotive->id }}"></a>
                                                                </div>
                                                            </article>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @if ($automotivesForSale->count() > 4)
                                                    <div class="carousel-item">
                                                        <div class="d-flex">
                                                            @foreach ($automotivesForSale->slice(3, 4) as $automotive)
                                                                <article class="col-6 col-lg-3 mb-2 mb-lg-0">
                                                                    <div class="img-responsive">
                                                                        <a
                                                                            href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                                            <img src="{{ $automotive->coverFront() }}"
                                                                                class="card-img-top rounded"
                                                                                alt="{{ $automotive->title }}"
                                                                                style="height: auto">
                                                                        </a>
                                                                    </div>
                                                                    <h3 class="my-2"><a
                                                                            href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                            class="text-dark main_properties_price text-truncate d-block"
                                                                            style="font-size: 16px">{{ $automotive->title }}</a>
                                                                    </h3>
                                                                    <div class="d-flex flex-wrap justify-content-between">
                                                                        <span
                                                                            class="main_properties_price text-dark font-weight-bold"
                                                                            style="font-size: 18px">R$
                                                                            {{ $automotive->sale_price }}</span>
                                                                        <a href="#"
                                                                            class="ml-2 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                                            data-id="{{ $automotive->id }}"></a>
                                                                    </div>
                                                                </article>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($automotivesForSale->count() > 8)
                                                    <div class="carousel-item">
                                                        <div class="d-flex">
                                                            @foreach ($automotivesForSale->slice(7, 4) as $automotive)
                                                                <article class="col-6 col-lg-3 mb-2 mb-lg-0">
                                                                    <div class="img-responsive">
                                                                        <a
                                                                            href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                                            <img src="{{ $automotive->coverFront() }}"
                                                                                class="card-img-top rounded"
                                                                                alt="{{ $automotive->title }}"
                                                                                style="height: auto">
                                                                        </a>
                                                                    </div>
                                                                    <h3 class="my-2"><a
                                                                            href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                            class="text-dark main_properties_price text-truncate d-block"
                                                                            style="font-size: 16px">{{ $automotive->title }}</a>
                                                                    </h3>
                                                                    <div class="d-flex flex-wrap justify-content-between">
                                                                        <span
                                                                            class="main_properties_price text-dark font-weight-bold"
                                                                            style="font-size: 18px">R$
                                                                            {{ $automotive->sale_price }}</span>
                                                                        <a href="#"
                                                                            class="ml-2 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                                            data-id="{{ $automotive->id }}"></a>
                                                                    </div>
                                                                </article>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($automotivesForSale->count() > 12)
                                                    <div class="carousel-item">
                                                        <div class="d-flex">
                                                            @foreach ($automotivesForSale->slice(11, 4) as $automotive)
                                                                <article class="col-6 col-lg-3 mb-2 mb-lg-0">
                                                                    <div class="img-responsive">
                                                                        <a
                                                                            href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                                            <img src="{{ $automotive->coverFront() }}"
                                                                                class="card-img-top rounded"
                                                                                alt="{{ $automotive->title }}"
                                                                                style="height: auto">
                                                                        </a>
                                                                    </div>
                                                                    <h3 class="my-2"><a
                                                                            href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                            class="text-dark main_properties_price text-truncate d-block"
                                                                            style="font-size: 16px">{{ $automotive->title }}</a>
                                                                    </h3>
                                                                    <div class="d-flex flex-wrap justify-content-between">
                                                                        <span
                                                                            class="main_properties_price text-dark font-weight-bold"
                                                                            style="font-size: 18px">R$
                                                                            {{ $automotive->sale_price }}</span>
                                                                        <a href="#"
                                                                            class="ml-2 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                                            data-id="{{ $automotive->id }}"></a>
                                                                    </div>
                                                                </article>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($automotivesForSale->count() > 16)
                                                    <div class="carousel-item">
                                                        <div class="d-flex">
                                                            @foreach ($automotivesForSale->slice(15, 4) as $automotive)
                                                                <article class="col-6 col-lg-3 mb-2 mb-lg-0">
                                                                    <div class="img-responsive">
                                                                        <a
                                                                            href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                                            <img src="{{ $automotive->coverFront() }}"
                                                                                class="card-img-top rounded"
                                                                                alt="{{ $automotive->title }}"
                                                                                style="height: auto">
                                                                        </a>
                                                                    </div>
                                                                    <h3 class="my-2"><a
                                                                            href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                            class="text-dark main_properties_price text-truncate d-block"
                                                                            style="font-size: 16px">{{ $automotive->title }}</a>
                                                                    </h3>
                                                                    <div class="d-flex flex-wrap justify-content-between">
                                                                        <span
                                                                            class="main_properties_price text-dark font-weight-bold"
                                                                            style="font-size: 18px">R$
                                                                            {{ $automotive->sale_price }}</span>
                                                                        <a href="#"
                                                                            class="ml-2 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                                            data-id="{{ $automotive->id }}"></a>
                                                                    </div>
                                                                </article>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($automotivesForSale->count() > 20)
                                                    <div class="carousel-item">
                                                        <div class="d-flex">
                                                            @foreach ($automotivesForSale->slice(19, 4) as $automotive)
                                                                <article class="col-6 col-lg-3 mb-2 mb-lg-0">
                                                                    <div class="img-responsive">
                                                                        <a
                                                                            href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                                            <img src="{{ $automotive->coverFront() }}"
                                                                                class="card-img-top rounded"
                                                                                alt="{{ $automotive->title }}"
                                                                                style="height: auto">
                                                                        </a>
                                                                    </div>
                                                                    <h3 class="my-2"><a
                                                                            href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                            class="text-dark main_properties_price text-truncate d-block"
                                                                            style="font-size: 16px">{{ $automotive->title }}</a>
                                                                    </h3>
                                                                    <div class="d-flex flex-wrap justify-content-between">
                                                                        <span
                                                                            class="main_properties_price text-dark font-weight-bold"
                                                                            style="font-size: 18px">R$
                                                                            {{ $automotive->sale_price }}</span>
                                                                        <a href="#"
                                                                            class="ml-2 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                                            data-id="{{ $automotive->id }}"></a>
                                                                    </div>
                                                                </article>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselExampleControls"
                                                role="button" data-slide="prev"
                                                style="margin-top: -50px; margin-left: -80px; opacity:1;">
                                                <span class="icon-chevron-left" aria-hidden="true"
                                                    style="font-size: 20px; color:#aaa"></span>
                                                <span class="sr-only">Anterior</span>
                                            </a>
                                            <a class="carousel-control-next overflow-hidden"
                                                href="#carouselExampleControls" role="button" data-slide="next"
                                                style="margin-top: -50px; margin-right: -80px; opacity:1;">
                                                <span class="icon-chevron-right" aria-hidden="true"
                                                    style="font-size: 20px; color:#aaa"></span>
                                                <span class="sr-only">Próximo</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="row d-flex justify-content-center">
                                @foreach ($automotivesForSale as $automotive)
                                    <div class="col-12 col-md-6 col-lg-4 mb-3 px-2">

                                        <article class="card main_properties_item border border-primary p-2">
                                            <h2 class="m-0 mb-2 d-flex justify-content-between">
                                                <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                    class="text-dark main_properties_price text-truncate d-block">{{ $automotive->title }}</a>
                                                <a href="#"
                                                    class="heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                    data-id="{{ $automotive->id }}"></a>
                                            </h2>
                                            <div class="container p-0 col-12 d-flex">
                                                <div class="img-responsive col-7 p-0 pb-2">
                                                    <a
                                                        href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                        <img src="{{ $automotive->coverFront() }}"
                                                            class="card-img-top rounded" alt="{{ $automotive->title }}">
                                                    </a>
                                                </div>
                                                <div class="card-body p-0 col-5 pl-2 pt-2">
                                                    <div
                                                        class="d-flex flex-wrap justify-content-center h-100 main_automotives_item">
                                                        <div class="col-12 d-flex flex-wrap justify-content-center">
                                                            <p class="mb-n5 text-muted main_automotives_item">Ano</p>
                                                            <p
                                                                class="font-weight-bold text-sm text-dark text-truncate mt-2 mb-n1 w-100 text-center main_automotives_item">
                                                                {{ $automotive->year }}</p>
                                                        </div>
                                                        <div class="col-12 d-flex flex-wrap justify-content-center">
                                                            <p class="mb-n5 text-muted main_automotives_item">Km</p>
                                                            <p
                                                                class="font-weight-bold text-sm text-dark text-truncate mt-2 mb-n3 w-100 text-center main_automotives_item">
                                                                {{ $automotive->mileage }}</p>
                                                        </div>
                                                        <div class="col-12 d-flex flex-wrap justify-content-center">
                                                            <p class="mb-n3 mt-2 text-muted main_automotives_item">
                                                                Câmbio
                                                            </p>
                                                            <p
                                                                class="font-weight-bold text-sm text-dark text-truncate mt-2 mb-n1 w-100 text-center main_automotives_item">
                                                                {{ $automotive->gear ? $automotive->gear : 'Não informado' }}
                                                            </p>
                                                        </div>

                                                        <p
                                                            class="main_properties_price text-front text-truncate mb-0 mb-n2 text-center w-100">
                                                            R$
                                                            {{ $automotive->sale_price }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        <div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="location-tab">
                            <div class="main_property_content pt-2 pb-5 ">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12 px-1">
                                            <div class="main_property_location">
                                                <div id="map" style="width: 100%; min-height: 400px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
    </section>
    @endif
@endsection

@section('js')
    <script>
        function markMap() {

            var locationJson = $.getJSON(
                'https://maps.googleapis.com/maps/api/geocode/json?address={{ $company->street }},+{{ $company->number }}+{{ $company->city }}+{{ $company->neighborhood }}&key={{ env('GOOGLE_API_KEY') }}',
                function(response) {

                    lat = response.results[0].geometry.location.lat;
                    lng = response.results[0].geometry.location.lng;

                    var citymap = {
                        automotive: {
                            center: {
                                lat: lat,
                                lng: lng
                            },
                            population: 100
                        }
                    };

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

    <script src="{{ url(asset('frontend/assets/js/like.js')) }}"></script>
    <script src="{{ url(asset('frontend/assets/js/jquery-ui.js')) }}"></script>
@endsection
