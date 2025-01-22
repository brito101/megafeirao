@extends('web.master.master')

@section('content')
    <div class="main_slide d-none d-sm-block mt-4 pt-2">
        <div class="container" style="height: 100%;">
            <div class="row align-items-center" style="height: 100%;">
                <div class="col-12 rounded border border-primary">

                    <div class="main_filter">
                        <div class="container my-4">
                            <div class="row">
                                <form action="{{ route('web.filter') }}" method="post"
                                    class="form-inline w-100 text-dark form_home">
                                    @csrf

                                    <div class="form-group col-12 col-sm-6 mt-sm-2 col-lg-3 mt-lg-0">
                                        <label for="city" class="mb-2"><b>Onde você quer?</b></label>
                                        <select class="selectpicker" name="filter_city" id="city" title="Escolha..."
                                            data-index="1" data-action="{{ route('component.main-filter.city') }}"
                                            multiple data-actions-box="true">
                                            @foreach ($cities as $city)
                                                <option>{{ $city }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-12 col-sm-6 mt-sm-2 col-lg-3 mt-lg-0">
                                        <label for="brand" class="mb-2"><b>Marca</b></label>
                                        <select class="selectpicker" name="filter_brand" data-index="2"
                                            data-action="{{ route('component.main-filter.brand') }}" id="brand"
                                            title="Escolha...">
                                            <option disabled>Selecione o filtro anterior</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-12 col-sm-6 mt-sm-2 col-lg-3 mt-lg-0">
                                        <label for="model" class="mb-2"><b>Modelo</b></label>
                                        <select class="selectpicker" name="filter_model" id="model" title="Escolha..."
                                            data-index="3" data-action="{{ route('component.main-filter.model') }}">
                                            <option disabled>Selecione o filtro anterior</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-12 col-sm-6 col-lg-3 justify-content-center">
                                        <button class="btn btn-front icon-search mb-n4">Pesquisar</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($automotivesForSale->count())
        <section class="main_properties py-5">
            <div class="container px-3 px-md-0">

                <div class="row d-flex justify-content-center">

                    @foreach ($automotivesForSale as $automotive)
                        <div class="col-12 col-md-6 col-lg-3 mb-4">
                            <article class="card main_properties_item">
                                <div class="img-responsive-16by9">
                                    <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                        <img src="{{ $automotive->cover() }}" class="card-img-top"
                                            alt="{{ $automotive->title }}">
                                    </a>
                                </div>
                                <div class="card-body py-0">
                                    <h2 class="my-0"><a
                                            href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                            class="text-dark text-truncate d-block">{{ $automotive->title }}</a>
                                    </h2>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="main_properties_price text-dark mb-0">R$ {{ $automotive->sale_price }}
                                        </p>
                                        <a href="#" class="heart-like icon-heart-o text-front text-decoration-none"
                                            data-id="{{ $automotive->id }}"></a>
                                    </div>
                                    <div class="main_properties_complement">
                                        <span>{{ $automotive->year }}</span>
                                        <span>{{ $automotive->mileage }} km</span>
                                    </div>
                                </div>

                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <div class="container px-3 px-md-0 pb-5">
        <div class="row">
            <div class="col-12 col-md-4 text-center">
                @if ($banner)
                    <a href="{{ $banner->link2 ?? route('web.register') }}">
                        <img src="{{ $banner->cover2 ? asset('storage/' . $banner->cover2) : url(asset('frontend/assets/images/banner-horizontal-lateral.png')) }}"
                            width="300" class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt="Anuncie Grátis"
                            title="Anuncie Grátis"></a>
                @else
                    <a href="{{ route('web.register') }}">
                        <img src="{{ url(asset('frontend/assets/images/banner-horizontal-lateral.png')) }}" width="300"
                            class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt="Anuncie Grátis"
                            title="Anuncie Grátis"></a>
                @endif

            </div>

            <div class="col-12 col-md-8 text-center pt-4 pt-md-0">
                @if ($banner)
                    <a href="{{ $banner->link3 ?? route('web.register') }}">
                        <img src="{{ $banner->cover3 ? asset('storage/' . $banner->cover3) : url(asset('frontend/assets/images/banner-horizontal.png')) }}"
                            class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt=" Anuncie Grátis"
                            title="Anuncie Grátis"></a>

                @else
                    <a href="{{ route('web.register') }}">
                        <img src="{{ url(asset('frontend/assets/images/banner-horizontal.png')) }}"
                            class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt="Anuncie Grátis"
                            title="Anuncie Grátis"></a>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('js')
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
