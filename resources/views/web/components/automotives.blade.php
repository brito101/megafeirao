<div class="col-12 p-2">
    <article class="row mx-0 mx-md-2 border border-gray shadow-sm p-3 d-flex flex-wrap justify-content-between">
        <div class="col-12 col-lg-4 img-responsive p-0">
            <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                <img src="{{ $automotive->coverFront() }}" class="card-img-top" alt="{{ $automotive->title }}">
            </a>
        </div>
        <div class="col-12 col-lg-8 d-flex justify-content-between px-0">
            <div class="col-12 col-lg-8 px-0 pl-lg-4">
                <h2 class="h4 m-0 mt-3 mt-lg-0 mb-4 d-flex justify-content-between">
                    <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                        class="text-dark font-weight-bold main_properties_price text-truncate d-block">{{ $automotive->title }}</a>
                    <a href="#"
                        class="h6 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                        data-id="{{ $automotive->id }}"></a>
                </h2>
                <div class="row d-flex justify-content-between px-0">
                    <div class="col-3 text-dark text-center">
                        <h3 class="text-muted" style="font-size: 0.75rem">Ano</h3>
                        <p class="font-weight-bold text-dark text-truncate" style="font-size: 0.8rem">
                            {{ $automotive->year }}</p>
                    </div>
                    <div class="col-3 text-dark text-center">
                        <h3 class="text-muted" style="font-size: 0.75rem">Km</h3>
                        <p class="font-weight-bold text-dark text-truncate" style="font-size: 0.8rem">
                            {{ $automotive->mileage }}</p>
                    </div>
                    <div class="col-6 text-dark text-center">
                        <h3 class="text-muted" style="font-size: 0.75rem">Câmbio</h3>
                        <p class="font-weight-bold text-dark text-truncate" style="font-size: 0.8rem">
                            {{ $automotive->gear ? $automotive->gear : 'Não informado' }}
                        </p>
                    </div>
                </div>
                <div class="px-2 row d-flex justify-content-between mt-4">
                    <div class="col-12 col-md-6 px-0">
                        <h3 class="h5 text-front text-truncate w-100 text-center text-lg-left font-weight-bold">
                            R$
                            {{ $automotive->sale_price }}</h3>
                    </div>
                    <div class="col-12 col-md-6 px-0">
                        <a class="btn btn-dark w-100 font-weight-bold" style="font-size: 0.65rem"
                            href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                            title="{{ $automotive->title }}">
                            <i class="icon-plus"></i>
                            MAIS DETALHES</a>
                    </div>
                </div>
            </div>
            <div class="d-none d-lg-flex col-4 align-items-center">
                <div class="m-auto pl-3">
                    @if ($automotive->ownerObject()->company)
                        <a
                            href="{{ route('web.filterCompany', ['slug' => $automotive->ownerObject()->company->slug]) }}">
                            <img src="{{ $automotive->ownerObject()->company->logo() }}"
                                class="card-img-top border border-gray shadow-sm"
                                alt="{{ $automotive->ownerObject()->company->alias_name }}">
                        </a>
                        <p class="text-muted my-1 text-center" style="font-size: 0.75rem">
                            {{ $automotive->ownerObject()->company->neighborhood }}
                        </p>
                        <p class="text-muted my-0 text-center" style="font-size: 0.75rem">
                            {{ $automotive->ownerObject()->company->city }}-{{ $automotive->ownerObject()->company->state }}
                        </p>
                    @else
                        <p class="font-weight-bold h5">Particular</p>
                    @endif
                </div>
            </div>
        </div>
    </article>
</div>
