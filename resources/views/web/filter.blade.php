@extends('web.master.master')

@section('css')
    <link rel="stylesheet" href="{{ url(asset('frontend/assets/libs/libs.css')) }}">
@endsection

@section('content')
    <div class="main_filter page_filter pb-2">
        <div class="container">
            <section class="row">

                <div class="col-12 d-flex flex-wrap justify-content-between">
                    <div class="col-12 col-md-5 col-lg-3">
                        <form action="{{ route('web.filter') }}" method="post" class="w-100 p-3 mb-0">
                            @csrf
                            <div class="row">

                                <div class="form-group col-12 mt-3">
                                    <select class="selectpicker" name="filter_category" id="category" title="Veículo"
                                        data-actions-box="true" data-index="1"
                                        data-action="{{ route('component.main-filter.category') }}">
                                        <option value="Carro">Carro</option>
                                        <option value="Motocicleta">Motocicleta</option>
                                        <option value="Outros">Outros</option>
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <select class="selectpicker" name="filter_city" id="city" title="Cidade"
                                        data-actions-box="true" data-index="2"
                                        data-action="{{ route('component.main-filter.city') }}">
                                        <option value="">Indiferente</option>
                                        @foreach ($cities as $city)
                                            <option>{{ $city }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <select class="selectpicker" name="filter_brand" id="brand" title="Marca"
                                        data-index="3" data-action="{{ route('component.main-filter.brand') }}">
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <select class="selectpicker" name="filter_model" id="model" title="Modelo"
                                        data-index="4" data-action="{{ route('component.main-filter.model') }}">
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
                                </div>
                                <div class="col-12 text-dark font-weight-normal mb-2">Preço</div>
                                <div class="form-group col-6 d-none">
                                    <select class="selectpicker" name="filter_base" id="base" title="Mínimo"
                                        data-index="5" data-action="{{ route('component.main-filter.priceBase') }}">
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
                                </div>
                                <div class="form-group col-6 d-none">
                                    <select class="selectpicker" name="filter_limit" id="limit" title="Máximo"
                                        data-index="6" data-action="{{ route('component.main-filter.priceLimit') }}">
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
                                </div>

                                <div class="col-12 mb-4 form-group slider-custom">
                                    <div class="mb-4 d-flex justify-content-between" style="gap: 15px;">
                                        <input type="text" id="price_base_input" readonly class="px-2">
                                        <input type="text" id="price_limit_input" readonly class="px-2">
                                    </div>
                                    <div id="price-range"></div>
                                </div>

                                <div class="col-12 text-dark font-weight-normal mb-2">Ano do modelo</div>
                                <div class="form-group col-6 d-none">
                                    <select class="selectpicker" name="filter_year_base" id="year_base" title="Mínimo"
                                        data-index="7" data-action="{{ route('component.main-filter.yearBase') }}">
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
                                </div>
                                <div class="form-group col-6 d-none">
                                    <select class="selectpicker" name="filter_year_limit" id="year_limit" title="Máximo"
                                        data-index="8" data-action="{{ route('component.main-filter.yearLimit') }}">
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
                                </div>

                                <div class="col-12 mb-4 form-group slider-custom">
                                    <div class="mb-4 d-flex justify-content-between" style="gap: 15px;">
                                        <input type="text" id="year_base_input" readonly class="px-2">
                                        <input type="text" id="year_limit_input" readonly class="px-2">
                                    </div>
                                    <div id="year-range"></div>
                                </div>

                                <div class="col-12 text-dark font-weight-normal mb-2">Km máxima</div>
                                <div class="form-group col-12 d-none">
                                    <select class="selectpicker" name="filter_mileage" id="mileage" title="Selecione"
                                        data-index="9" data-action="{{ route('component.main-filter.mileage') }}">
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
                                </div>
                                <span class="d-none" id="mileageMax">{{ $mileageMax }}</span>
                                <div class=" col-12 mb-4 form-group slider-custom">
                                    <input type="text" id="mileage_input" readonly class="col-12 mb-4 px-2">
                                    <div id="mileage-range"></div>
                                </div>
                            </div>

                            <div class="d-none d-md-block">

                                @if (count($cityState))
                                    <div class="col-12 px-0 mt-5">
                                        <div class="text-dark font-weight-normal">Outras Cidades</div>
                                        @foreach ($cityState as $cs)
                                            <div class="check_filter" style="font-size: 0.875em;"
                                                data-action="{{ route('component.main-filter.city') }}">
                                                <input type="checkbox" id="cityState{{ $loop->index }}" name="city"
                                                    value="{{ $cs }}">
                                                <label for="cityState{{ $loop->index }}">{{ $cs }}
                                                    ({{ count($collect->where('city', $cs)) }})
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                            </div>

                            <div class="row my-2">
                                <div class="col-12 text-center button_search">
                                    <button class="btn btn-front icon-search">Pesquisar</button>
                                </div>
                            </div>

                            @if (count($brand))
                                <div class="col-12 px-0 mt-3 card d-none d-md-block">
                                    <div class="text-dark font-weight-normal card-header">Marcas</div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($brand as $f)
                                                <li><a href="{{ route('web.filterBrand', ['brand' => $f['link']]) }}"
                                                        class="text-muted text-uppercase">{{ $f['title'] }}
                                                        ({{ count($collect->where('brand', $f['title'])) }})
                                                    </a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            @if (count($model))
                                <div class="col-12 px-0 mt-3 card d-none d-md-block">
                                    <div class="text-dark font-weight-normal card-header">Modelos</div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($model as $f)
                                                <li><a href="{{ route('web.filterModel', ['model' => $f['link']]) }}"
                                                        class="text-muted text-uppercase">{{ $f['title'] }}
                                                        ({{ count($collect->where('model', $f['title'])) }})
                                                    </a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </form>

                    </div>

                    <div class=" col-12 col-md-7 col-lg-9 overflow-hidden">

                        @if ($spotlight->count() > 0)
                            <div class="row pb-2 pb-lg-5" style="margin-top: 30px;">
                                <div class="col-12">
                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <div class="d-flex">
                                                    @foreach ($spotlight->slice(0, 4) as $automotive)
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
                                            @if ($spotlight->count() > 4)
                                                <div class="carousel-item">
                                                    <div class="d-flex">
                                                        @foreach ($spotlight->slice(3, 4) as $automotive)
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
                                            @if ($spotlight->count() > 8)
                                                <div class="carousel-item">
                                                    <div class="d-flex">
                                                        @foreach ($spotlight->slice(7, 4) as $automotive)
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
                                            @if ($spotlight->count() > 12)
                                                <div class="carousel-item">
                                                    <div class="d-flex">
                                                        @foreach ($spotlight->slice(11, 4) as $automotive)
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
                                            @if ($spotlight->count() > 16)
                                                <div class="carousel-item">
                                                    <div class="d-flex">
                                                        @foreach ($spotlight->slice(15, 4) as $automotive)
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
                                            @if ($spotlight->count() > 20)
                                                <div class="carousel-item">
                                                    <div class="d-flex">
                                                        @foreach ($spotlight->slice(19, 4) as $automotive)
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
                                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                            data-slide="prev" style="margin-top: -50px; margin-left: -50px; opacity:1;">
                                            <span class="icon-chevron-left" aria-hidden="true"
                                                style="font-size: 20px; color:#aaa"></span>
                                            <span class="sr-only">Anterior</span>
                                        </a>
                                        <a class="carousel-control-next overflow-hidden" href="#carouselExampleControls"
                                            role="button" data-slide="next"
                                            style="margin-top: -50px; margin-right: -50px; opacity:1;">
                                            <span class="icon-chevron-right" aria-hidden="true"
                                                style="font-size: 20px; color:#aaa"></span>
                                            <span class="sr-only">Próximo</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <section class="row main_properties d-flex justify-content-center">
                            @if ($automotives)
                                @foreach ($automotives->slice(0, 5) as $automotive)
                                    <div class="col-12 p-2">
                                        <article
                                            class="row mx-0 mx-md-2 border border-gray shadow-sm p-3 d-flex flex-wrap justify-content-between">
                                            <div class="col-12 col-lg-4 img-responsive p-0">
                                                <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                    <img src="{{ $automotive->coverFront() }}" class="card-img-top"
                                                        alt="{{ $automotive->title }}">
                                                </a>
                                            </div>
                                            <div class="col-12 col-lg-8 d-flex justify-content-between px-0">
                                                <div class="col-12 col-lg-8 px-0 pl-lg-4">
                                                    <h2 class="h3 m-0 mt-3 mt-lg-0 mb-4 d-flex justify-content-between">
                                                        <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                            class="text-dark font-weight-bold main_properties_price text-truncate d-block">{{ $automotive->title }}</a>
                                                        <a href="#"
                                                            class="h6 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                            data-id="{{ $automotive->id }}"></a>
                                                    </h2>
                                                    <div class="row d-flex justify-content-between px-0">
                                                        <div class="col-4 text-dark text-center">
                                                            <h3 class="h6 text-muted">Ano</h3>
                                                            <p class="font-weight-bold h5 text-dark text-truncate">
                                                                {{ $automotive->year }}</p>
                                                        </div>
                                                        <div class="col-4 text-dark text-center">
                                                            <h3 class="h6 text-muted">Km</h3>
                                                            <p class="font-weight-bold h5 text-dark text-truncate">
                                                                {{ $automotive->mileage }}</p>
                                                        </div>
                                                        <div class="col-4 text-dark text-center">
                                                            <h3 class="h6 text-muted">Câmbio</h3>
                                                            <p class="font-weight-bold h6 text-dark text-truncate">
                                                                {{ $automotive->gear ? $automotive->gear : 'Não informado' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="px-2 row d-flex justify-content-between mt-4">
                                                        <div class="col-12 col-lg-7 px-0">
                                                            <h3
                                                                class="text-front text-truncate w-100 text-center text-lg-left font-weight-bold">
                                                                R$
                                                                {{ $automotive->sale_price }}</h3>
                                                        </div>
                                                        <div class="col-12 col-lg-5 px-0">
                                                            <a class="btn btn-dark w-100 font-weight-bold"
                                                                style="font-size: 0.65rem"
                                                                href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                title="{{ $automotive->title }}">
                                                                <i class="icon-plus"></i>
                                                                MAIS DETALHES</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-none d-lg-flex col-4 align-items-center">
                                                    <div class="m-auto pl-3">
                                                        <a
                                                            href="{{ route('web.filterCompany', ['slug' => $automotive->ownerObject()->company->slug]) }}">
                                                            <img src="{{ $automotive->ownerObject()->company->logo() }}"
                                                                class="card-img-top border border-gray shadow-sm"
                                                                alt="{{ $automotive->ownerObject()->company->alias_name }}">
                                                        </a>
                                                        <p class="text-muted my-1 text-center">
                                                            {{ $automotive->ownerObject()->company->neighborhood }}</p>
                                                        <p class="text-muted my-0 text-center">
                                                            {{ $automotive->ownerObject()->company->city }}-{{ $automotive->ownerObject()->company->state }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                                @if ($banner->cover4)
                                    <div class="col-12 my-2 text-center" style="max-height: 150px">
                                        <a href="{{ $banner->link4 ?? route('web.register') }}"
                                            class="d-flex justify-content-center align-content-center h-100">
                                            <img src="{{ $banner->cover4 ? asset('storage/' . $banner->cover4) : url(asset('frontend/assets/images/banner-horizontal-lateral.png')) }}"
                                                class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt=""
                                                title="" style="object-fit: contain;"></a>
                                    </div>
                                @endif
                                @foreach ($automotives->slice(5, 5) as $automotive)
                                    <div class="col-12 p-2">
                                        <article
                                            class="row mx-0 mx-md-2 border border-gray shadow-sm p-3 d-flex flex-wrap justify-content-between">
                                            <div class="col-12 col-lg-4 img-responsive p-0">
                                                <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                    <img src="{{ $automotive->coverFront() }}" class="card-img-top"
                                                        alt="{{ $automotive->title }}" style="min-height: ">
                                                </a>
                                            </div>
                                            <div class="col-12 col-lg-8 d-flex justify-content-between px-0">
                                                <div class="col-12 col-lg-8 px-0 pl-lg-4">
                                                    <h2 class="h3 m-0 mt-3 mt-lg-0 mb-4 d-flex justify-content-between">
                                                        <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                            class="text-dark font-weight-bold main_properties_price text-truncate d-block">{{ $automotive->title }}</a>
                                                        <a href="#"
                                                            class="h6 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                            data-id="{{ $automotive->id }}"></a>
                                                    </h2>
                                                    <div class="row d-flex justify-content-between px-0">
                                                        <div class="col-4 text-dark text-center">
                                                            <h3 class="h6 text-muted">Ano</h3>
                                                            <p class="font-weight-bold h5 text-dark text-truncate">
                                                                {{ $automotive->year }}</p>
                                                        </div>
                                                        <div class="col-4 text-dark text-center">
                                                            <h3 class="h6 text-muted">Km</h3>
                                                            <p class="font-weight-bold h5 text-dark text-truncate">
                                                                {{ $automotive->mileage }}</p>
                                                        </div>
                                                        <div class="col-4 text-dark text-center">
                                                            <h3 class="h6 text-muted">Câmbio</h3>
                                                            <p class="font-weight-bold h6 text-dark text-truncate">
                                                                {{ $automotive->gear ? $automotive->gear : 'Não informado' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="px-2 row d-flex justify-content-between mt-4">
                                                        <div class="col-12 col-lg-7 px-0">
                                                            <h3
                                                                class="text-front text-truncate w-100 text-center text-lg-left font-weight-bold">
                                                                R$
                                                                {{ $automotive->sale_price }}</h3>
                                                        </div>
                                                        <div class="col-12 col-lg-5 px-0">
                                                            <a class="btn btn-dark w-100 font-weight-bold"
                                                                style="font-size: 0.65rem"
                                                                href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                title="{{ $automotive->title }}">
                                                                <i class="icon-plus"></i>
                                                                MAIS DETALHES</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-none d-lg-flex col-4 align-items-center">
                                                    <div class="m-auto pl-3">
                                                        <a
                                                            href="{{ route('web.filterCompany', ['slug' => $automotive->ownerObject()->company->slug]) }}">
                                                            <img src="{{ $automotive->ownerObject()->company->logo() }}"
                                                                class="card-img-top border border-gray shadow-sm"
                                                                alt="{{ $automotive->ownerObject()->company->alias_name }}">
                                                        </a>
                                                        <p class="text-muted my-1 text-center">
                                                            {{ $automotive->ownerObject()->company->neighborhood }}
                                                        </p>
                                                        <p class="text-muted my-0 text-center">
                                                            {{ $automotive->ownerObject()->company->city }}-{{ $automotive->ownerObject()->company->state }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                                @if ($automotives->count() > 5 && $banner->cover1)
                                    <div class="col-12 my-2 text-center" style="max-height: 150px">
                                        <a href="{{ $banner->link1 ?? route('web.register') }}"
                                            class="d-flex justify-content-center align-content-center h-100">
                                            <img src="{{ $banner->cover1 ? asset('storage/' . $banner->cover1) : url(asset('frontend/assets/images/banner-horizontal-lateral.png')) }}"
                                                class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt=""
                                                title="" style="object-fit: contain;"></a>
                                    </div>
                                @endif
                                @foreach ($automotives->slice(10, 5) as $automotive)
                                    <div class="col-12 p-2">
                                        <article
                                            class="row mx-0 mx-md-2 border border-gray shadow-sm p-3 d-flex flex-wrap justify-content-between">
                                            <div class="col-12 col-lg-4 img-responsive p-0">
                                                <a
                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                    <img src="{{ $automotive->coverFront() }}" class="card-img-top"
                                                        alt="{{ $automotive->title }}" style="min-height: ">
                                                </a>
                                            </div>
                                            <div class="col-12 col-lg-8 d-flex justify-content-between px-0">
                                                <div class="col-12 col-lg-8 px-0 pl-lg-4">
                                                    <h2 class="h3 m-0 mt-3 mt-lg-0 mb-4 d-flex justify-content-between">
                                                        <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                            class="text-dark font-weight-bold main_properties_price text-truncate d-block">{{ $automotive->title }}</a>
                                                        <a href="#"
                                                            class="h6 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                            data-id="{{ $automotive->id }}"></a>
                                                    </h2>
                                                    <div class="row d-flex justify-content-between px-0">
                                                        <div class="col-4 text-dark text-center">
                                                            <h3 class="h6 text-muted">Ano</h3>
                                                            <p class="font-weight-bold h5 text-dark text-truncate">
                                                                {{ $automotive->year }}</p>
                                                        </div>
                                                        <div class="col-4 text-dark text-center">
                                                            <h3 class="h6 text-muted">Km</h3>
                                                            <p class="font-weight-bold h5 text-dark text-truncate">
                                                                {{ $automotive->mileage }}</p>
                                                        </div>
                                                        <div class="col-4 text-dark text-center">
                                                            <h3 class="h6 text-muted">Câmbio</h3>
                                                            <p class="font-weight-bold h6 text-dark text-truncate">
                                                                {{ $automotive->gear ? $automotive->gear : 'Não informado' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="px-2 row d-flex justify-content-between mt-4">
                                                        <div class="col-12 col-lg-7 px-0">
                                                            <h3
                                                                class="text-front text-truncate w-100 text-center text-lg-left font-weight-bold">
                                                                R$
                                                                {{ $automotive->sale_price }}</h3>
                                                        </div>
                                                        <div class="col-12 col-lg-5 px-0">
                                                            <a class="btn btn-dark w-100 font-weight-bold"
                                                                style="font-size: 0.65rem"
                                                                href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                title="{{ $automotive->title }}">
                                                                <i class="icon-plus"></i>
                                                                MAIS DETALHES</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-none d-lg-flex col-4 align-items-center">
                                                    <div class="m-auto pl-3">
                                                        <a
                                                            href="{{ route('web.filterCompany', ['slug' => $automotive->ownerObject()->company->slug]) }}">
                                                            <img src="{{ $automotive->ownerObject()->company->logo() }}"
                                                                class="card-img-top border border-gray shadow-sm"
                                                                alt="{{ $automotive->ownerObject()->company->alias_name }}">
                                                        </a>
                                                        <p class="text-muted my-1 text-center">
                                                            {{ $automotive->ownerObject()->company->neighborhood }}
                                                        </p>
                                                        <p class="text-muted my-0 text-center">
                                                            {{ $automotive->ownerObject()->company->city }}-{{ $automotive->ownerObject()->company->state }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                                <div class="w-100 d-flex justify-content-center">
                                    {{ $automotives->appends(request()->input())->links() }}</div>
                            @else
                                <div class="col-12 p-5 bg-white my-5">
                                    <h2 class="text-front icon-info text-center">
                                        Ooops, não encontramos nenhum veículo para você comprar!</h2>
                                    <p class="text-center">
                                        Utiliza o filtro avançado para encontrar o veículo dos seus sonhos...
                                    </p>
                                </div>
                            @endif
                        </section>

                    </div>
                </div>

            </section>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ url(asset('frontend/assets/js/like.js')) }}"></script>
    <script src="{{ url(asset('frontend/assets/js/jquery-ui.js')) }}"></script>
    <script src="{{ url(asset('frontend/assets/js/filter.js')) }}"></script>
    <script>
        $("#filter-price").on('change', function(e) {
            e.preventDefault();
            let val = $(e.target).val();
            if (val == 'ASC') {
                location.href = '{{ env('APP_URL') }}/?sort=sale_price&direction=asc'
            } else {
                location.href = '{{ env('APP_URL') }}/?sort=sale_price&direction=desc'
            }
        });
    </script>
@endsection
