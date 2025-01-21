@extends('web.master.master')

@section('css')
    <link rel="stylesheet" href="{{ url(asset('frontend/assets/libs/libs.css')) }}">
@endsection

@section('content')
    <div class="main_filter page_filter pb-2">
        <div class="container">
            <section class="row">

                <div class="col-12 d-flex flex-wrap justify-content-between">
                    
                    <div class="col-12 col-md-3">
                        <form action="{{ route('web.filter') }}" method="post" class="w-100 px-0 py-3 mb-0 px-2">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12 mt-3">
                                    <select class="selectpicker" name="filter_category" id="category" title="Veículo"
                                        data-actions-box="true" data-index="1"
                                        data-action="{{ route('component.main-filter.category') }}">
                                        <option value="Carro">Carro</option>
                                        <option value="Moto">Moto</option>
                                        <option value="Caminhão">Caminhão</option>
                                        <option value="Ônibus">Ônibus</option>
                                        <option value="Náutica">Náutica</option>
                                        <option value="Agrícola">Agrícola</option>
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <select class="selectpicker" name="filter_city" id="city" title="Estado"
                                        data-actions-box="true" data-index="2"
                                        data-action="{{ route('component.main-filter.city') }}">
                                        <option value="">Indiferente</option>
                                        @foreach ($state as $item)
                                            <option>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <select class="selectpicker" name="filter_brand" id="brand" title="Fabricante"
                                        data-index="3" data-action="{{ route('component.main-filter.brand') }}">
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

                            <div class="row my-2">
                                <div class="col-12 text-center button_search">
                                    <button class="btn btn-front icon-search">Pesquisar</button>
                                </div>
                            </div>

                        </form>
                        @if ($banner)
                            <div class="col-12 d-flex flex-wrap justify-content-center align-content-start">
                                @if ($banner->cover5)
                                    <div class="col-12 col-sm-4 px-2 px-lg-0 col-lg-12 my-2 text-center">
                                        <a href="{{ $banner->link5 ?? route('web.register') }}"
                                            class="d-flex justify-content-center align-content-center h-100">
                                            <img src="{{ asset('storage/' . $banner->cover5) }}"
                                                class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt=""
                                                title="" style="object-fit: contain;"></a>
                                    </div>
                                @endif

                                @if ($banner->cover6)
                                    <div class="col-12 col-sm-4 px-2 px-lg-0 col-lg-12 my-2 text-center">
                                        <a href="{{ $banner->link6 ?? route('web.register') }}"
                                            class="d-flex justify-content-center align-content-center h-100">
                                            <img src="{{ asset('storage/' . $banner->cover6) }}"
                                                class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt=""
                                                title="" style="object-fit: contain;"></a>
                                    </div>
                                @endif

                                @if ($banner->cover7)
                                    <div class="col-12 col-sm-4 px-2 px-lg-0 col-lg-12 my-2 text-center">
                                        <a href="{{ $banner->link7 ?? route('web.register') }}"
                                            class="d-flex justify-content-center align-content-center h-100">
                                            <img src="{{ asset('storage/' . $banner->cover7) }}"
                                                class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt=""
                                                title="" style="object-fit: contain;"></a>
                                    </div>
                                @endif

                                @if ($banner->cover8)
                                    <div class="col-12 col-sm-4 px-2 px-lg-0 col-lg-12 my-2 text-center">
                                        <a href="{{ $banner->link8 ?? route('web.register') }}"
                                            class="d-flex justify-content-center align-content-center h-100">
                                            <img src="{{ asset('storage/' . $banner->cover8) }}"
                                                class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt=""
                                                title="" style="object-fit: contain;"></a>
                                    </div>
                                @endif

                                @if ($banner->cover9)
                                    <div class="col-12 col-sm-4 px-2 px-lg-0 col-lg-12 my-2 text-center">
                                        <a href="{{ $banner->link9 ?? route('web.register') }}"
                                            class="d-flex justify-content-center align-content-center h-100">
                                            <img src="{{ asset('storage/' . $banner->cover9) }}"
                                                class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt=""
                                                title="" style="object-fit: contain;"></a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="col-12 col-md-9 overflow-hidden bg-light border">

                        <section class="row main_properties d-flex justify-content-center">

                            @if ($automotives)
                                @foreach ($automotives as $automotive)
                                    @include('web.components.automotives')
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
    <script>
        $("#city-state").on("change", function() {
            window.location.href = this.value;
        })
        $("#ordenation").on("change", function() {
            window.location.href = this.value;
        })
    </script>
@endsection
