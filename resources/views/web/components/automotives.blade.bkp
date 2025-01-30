<div class="col-12 col-md-4 p-2">
    <article class="row mx-0 mx-md-2 border border-gray shadow-sm p-3 d-flex flex-wrap justify-content-between bg-white">
        <div class="col-12 img-responsive p-0">
            <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                <img src="{{ $automotive->coverFront() }}" class="card-img-top filter_car_img"
                    alt="{{ $automotive->title }}">
            </a>
        </div>
        <div class="col-12 d-flex justify-content-between px-0 mb-n2">
            <div class="col-12 px-0">
                <h2 class="h5 m-0 mt-3 mt-lg-0 mb-4 d-flex justify-content-between">
                    <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                        class="text-dark font-weight-bold main_properties_price text-truncate d-block">{{ $automotive->title }}</a>
                    <a href="#"
                        class="icon-heart-o h6 heart-like text-front text-dark text-decoration-none text-right"
                        data-id="{{ $automotive->id }}"></a>
                </h2>
                <div class="row d-flex justify-content-between px-0">
                    <div class="col-6 text-center">
                        <p class="text-secondary text-truncate" style="font-size: 0.8rem">
                            {{ $automotive->year }}</p>
                    </div>
                    <div class="col-6 text-center">
                        <p class="font-weight-bold text-dark text-truncate" style="font-size: 0.8rem">
                            {{ $automotive->mileage }} km</p>
                    </div>
                    <div class="col-12 px-0 d-flex align-items-center text-center">
                        <h3 class="h5 text-front text-truncate w-100 text-center font-weight-bold">
                            R$ {{ $automotive->sale_price }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>
