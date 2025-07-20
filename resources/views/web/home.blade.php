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
                                        data-actions-box="true" data-index="0"
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
                                    <select class="selectpicker" name="filter_state" id="state" title="Estado"
                                        data-actions-box="true" data-index="1"
                                        data-action="{{ route('component.main-filter.state') }}">
                                        <option value="">Indiferente</option>
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <select class="selectpicker" name="filter_model" id="model" title="Modelo"
                                        data-actions-box="true" data-index="2"
                                        data-action="{{ route('component.main-filter.model') }}">
                                        <option value="">Indiferente</option>
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
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
                                @if ($banner->cover1)
                                    <div class="col-12 col-sm-4 px-2 px-lg-0 col-lg-12 my-2 text-center">
                                        <a href="{{ $banner->link1 ?? route('web.register') }}"
                                            class="d-flex justify-content-center align-content-center h-100">
                                            <img src="{{ asset('storage/' . $banner->cover1) }}"
                                                class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt=""
                                                title="" style="object-fit: contain;"></a>
                                    </div>
                                @endif

                                @if ($banner->cover2)
                                    <div class="col-12 col-sm-4 px-2 px-lg-0 col-lg-12 my-2 text-center">
                                        <a href="{{ $banner->link2 ?? route('web.register') }}"
                                            class="d-flex justify-content-center align-content-center h-100">
                                            <img src="{{ asset('storage/' . $banner->cover2) }}"
                                                class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt=""
                                                title="" style="object-fit: contain;"></a>
                                    </div>
                                @endif

                                @if ($banner->cover3)
                                    <div class="col-12 col-sm-4 px-2 px-lg-0 col-lg-12 my-2 text-center">
                                        <a href="{{ $banner->link3 ?? route('web.register') }}"
                                            class="d-flex justify-content-center align-content-center h-100">
                                            <img src="{{ asset('storage/' . $banner->cover3) }}"
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
@endsection
