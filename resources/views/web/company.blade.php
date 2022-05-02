@extends('web.master.master')

@section('content')
    <section class="main_property">
        <div class="main_property_header">
            <div class="px-0 mx-0 bg-dark mt-n1" style="border-top: 2px solid white;">
                <div class="row p-1 mx-0">
                    <div class="container">
                        <div
                            class="col-12 text-center text-white font-weight-bold py-2 py-md-5 d-flex flex-wrap justify-content-center">
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
                                <div class="d-flex">
                                    <img src="{{ $company->cover() }}" class="w-100 p-0 m-auto img-thumbnail"
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
            </div>
        </div>

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
                                        <input type="text" name="name" class="form-control" placeholder="Nome" required>
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

                            {{-- <div class='d-flex align-items-center mb-2 mt-2 mt-md-0 flex-wrap'>
                                <div
                                    class="col-12 col-md-6 px-0 mx-0 d-flex flex-wrap justify-content-center justify-content-md-start">
                                    <div class="text-grey-darker d-none d-sm-block mr-2">Ordenação por:</div>
                                    <div class="d-flex flex-wrap">
                                        <div id="price" class="d-flex d-inline-block mb-1 mb-sm-0">
                                            @sortablelink('sale_price', 'Preço', ['filter' => 'visible'])
                                        </div>
                                        <div id="year" class="d-flex d-inline-block mb-1 mb-sm-0">
                                            @sortablelink('year', 'Ano', ['filter' => ' visible'])
                                        </div>
                                    </div>
                                </div>

                                @if ($automotivesForSale->count())
                                    <div
                                        class="d-flex justify-content-center justify-content-md-end mt-2 col-12 col-md-6 px-0 mx-0">
                                        {{ $automotivesForSale->links() }}
                                    </div>
                                @endif
                            </div> --}}

                            <div class="row d-flex justify-content-center">
                                @foreach ($automotivesForSale as $automotive)
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">

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
                                                        <div class="col-6 d-flex flex-wrap justify-content-center">
                                                            <p class="mb-n5 text-muted main_automotives_item">Ano</p>
                                                            <p
                                                                class="font-weight-bold text-sm text-dark text-truncate mt-2 mb-n1 w-100 text-center main_automotives_item">
                                                                {{ $automotive->year }}</p>
                                                        </div>
                                                        <div class="col-6 d-flex flex-wrap justify-content-center">
                                                            <p class="mb-n5 text-muted main_automotives_item">Km</p>
                                                            <p
                                                                class="font-weight-bold text-sm text-dark text-truncate mt-2 mb-n1 w-100 text-center main_automotives_item">
                                                                {{ $automotive->mileage }}</p>
                                                        </div>
                                                        <div class="col-12 d-flex flex-wrap justify-content-center">
                                                            <p class="mb-n3 mt-2 text-muted main_automotives_item">Câmbio
                                                            </p>
                                                            <p
                                                                class="font-weight-bold text-sm text-dark text-truncate mt-2 mb-n1 w-100 text-center main_automotives_item">
                                                                {{ $automotive->gear ? $automotive->gear : 'Não informado' }}
                                                            </p>
                                                        </div>
                                                        <div class="col-12 d-flex flex-wrap justify-content-center">
                                                            <p
                                                                class="mt-2 mb-n1 text-muted text-center w-100 main_automotives_item">
                                                                {{ $automotive->city }}</p>
                                                            <p
                                                                class="mb-2 text-muted main_automotives_item text-center w-100">
                                                                {{ $automotive->neighborhood }}</p>
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

    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

    <script>
        const megalike = JSON.parse(localStorage.getItem("megalike"))
        if (megalike) {
            $(megalike).each((e, val) => {
                $(".icon-heart-o").each((el, value) => {
                    if (val.id === $(value).data().id) {
                        $(value).removeClass('icon-heart-o').addClass('icon-heart');
                    }
                });
            })
        }

        $('.heart-like').click(function(e) {
            e.preventDefault();
            el = $(this);
            if (el.hasClass('icon-heart-o')) {
                el.removeClass('icon-heart-o').addClass('icon-heart');
                if (localStorage.getItem("megalike")) {
                    const item = (JSON.parse(localStorage.getItem("megalike")))
                    item.push(el.data())
                    localStorage.setItem("megalike", JSON.stringify(item))
                } else {
                    localStorage.setItem("megalike", JSON.stringify(Array(el.data())))
                }
            } else {
                el.removeClass('icon-heart').addClass('icon-heart-o');
                let rem = JSON.parse(localStorage.getItem("megalike"))
                rem = rem.filter(function(item) {
                    return item.id !== (el.data().id)
                })
                localStorage.setItem("megalike", JSON.stringify(rem))
            }
        });
    </script>
@endsection
