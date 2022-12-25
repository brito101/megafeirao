<article class="col-6 col-lg-3 mb-2 mb-lg-0">
    <div class="img-responsive">
        <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
            <img src="{{ $automotive->coverFront() }}" class="card-img-top rounded" alt="{{ $automotive->title }}"
                style="height: auto">
        </a>
    </div>
    <h3 class="my-2"><a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
            class="text-dark main_properties_price text-truncate d-block"
            style="font-size: 16px">{{ $automotive->title }}</a>
    </h3>
    <div class="d-flex flex-wrap justify-content-between">
        <span class="main_properties_price text-dark font-weight-bold" style="font-size: 0.875rem">R$
            {{ $automotive->sale_price }}</span>
        <a href="#" class="ml-2 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
            data-id="{{ $automotive->id }}"></a>
    </div>
</article>
