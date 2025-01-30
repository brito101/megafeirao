@extends('web.master.master')

@section('content')
    <section class="main_list_group py-5 bg-light">
        <div class="container">
            <div class="pb-4">
                <h1 class="text-center">Confira nossas <span class="text-front"><b>Lojas</b></span> anunciantes</h1>
            </div>

            <div class="row d-flex justify-content-center">
                @foreach ($companies as $company)
                    <div class="col-12 col-md-6 col-lg-4 mb-4 text-center">
                        <article class="card">
                            <div class="img-responsive-16by9">
                                <a href="{{ route('web.filterCompany', ['slug' => $company->slug]) }}">
                                    <img src="{{ $company->cover() }}" class="card-img-top" alt="">
                                </a>
                            </div>
                            <div class="card-body">
                                <h2 class="text-truncate"><a
                                        href="{{ route('web.filterCompany', ['slug' => $company->slug]) }}"
                                        class="text-front">{{ $company->social_name }}</a></h2>
                                <a href="{{ route('web.filterCompany', ['slug' => $company->slug]) }}"
                                    class="btn btn-front btn-block">Ver Anúncios</a>
                                <p class="text-muted mb-0 mt-3">{{ $company->city . '-' . $company->state }}</p>
                            </div>
                            <div class="card-footer d-flex pt-4">
                                <div class="main_properties_features col-12 text-center">
                                    <p class="text-muted text-truncate"><i class="icon-bar-chart"></i>
                                        {{ $company->getTotal() }}</p>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
