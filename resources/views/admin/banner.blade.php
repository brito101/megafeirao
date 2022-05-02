@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header pb-1">
            <h2 class="icon-bookmark">Banner</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">

            <div class="nav">

                @if ($errors->all())
                    @foreach ($errors->all() as $error)
                        @message(['color' => 'orange'])
                        <p class="icon-asterisk">{{ $error }}</p>
                        @endmessage
                    @endforeach
                @endif

                @if (session()->exists('message'))
                    @message(['color' => session()->get('color')])
                    <p class="icon-asterisk">{{ session()->get('message') }}</p>
                    @endmessage
                @endif

                @if ($banner)
                    <form action="{{ route('admin.banner.update', ['banner' => $banner]) }}" method="post"
                        class="app_form" enctype="multipart/form-data">
                        @method('PUT')
                    @else
                        <form action="{{ route('admin.banner.store') }}" method="post" class="app_form"
                            enctype="multipart/form-data">
                @endif
                @csrf

                {{-- <div class="label_g2">
                    <label class="label">
                        <span class="legend">PÁGINA DE ANÚNCIO INDIVIDUAL</span>
                        <span class="legend">Banner vertical</span>
                        <input type="file" name="cover1">
                        <input type="text" name="link1" class="city" placeholder="Link do banner"
                            value="{{ $banner ? old('link1') ?? $banner->link1 : old('link1') }}" />
                    </label>
                    @if (isset($banner->cover1))
                        <div class="img-responsive-16by9 mb-1 text-center">
                            <img src="{{ asset('storage/' . $banner->cover1) }}" class="radius" alt=""
                                width="250">
                        </div>
                    @endif
                </div> --}}

                {{-- ALT 05MAR --}}
                <div class="label_g2">
                    <label class="label">
                        <span class="legend">PÁGINA DE PESQUISA</span>
                        <span class="legend">Banner superior esquerdo</span>
                        <input type="file" name="cover3">
                        <input type="text" name="link3" class="city" placeholder="Link do banner"
                            value="{{ $banner ? old('link3') ?? $banner->link3 : old('link3') }}" />
                    </label>
                    @if (isset($banner->cover3))
                        <div class="img-responsive-16by9 mb-1 text-center d-flex">
                            <img src="{{ asset('storage/' . $banner->cover3) }}" class="radius my-auto" alt=""
                                width="250">
                        </div>
                    @endif
                </div>
                {{-- ALT 05MAR --}}

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">PÁGINA DE PESQUISA</span>
                        <span class="legend">Banner superior direito (loja)</span>
                        <input type="file" name="cover2">
                        <input type="text" name="link2" class="city" placeholder="Link do banner"
                            value="{{ $banner ? old('link2') ?? $banner->link2 : old('link2') }}" />
                    </label>
                    @if (isset($banner->cover2))
                        <div class="img-responsive-16by9 mb-1 text-center">
                            <img src="{{ asset('storage/' . $banner->cover2) }}" class="radius" alt=""
                                width="250">
                        </div>
                    @endif
                </div>

                {{-- <div class="label_g2">
                    <label class="label">
                        <span class="legend">PÁGINA DE PESQUISA</span>
                        <span class="legend">Banner lateral esquerdo</span>
                        <input type="file" name="cover4">
                        <input type="text" name="link4" class="city" placeholder="Link do banner"
                            value="{{ $banner ? old('link4') ?? $banner->link4 : old('link4') }}" />
                    </label>
                    @if (isset($banner->cover4))
                        <div class="img-responsive-16by9 mb-1 text-center">
                            <img src="{{ asset('storage/' . $banner->cover4) }}" class="radius" alt=""
                                width="250">
                        </div>
                    @endif
                </div> --}}

                {{-- <div class="label_g2">
                    <label class="label">
                        <span class="legend">PÁGINA DE PESQUISA</span>
                        <span class="legend">Banner superior esquerdo</span>
                        <input type="file" name="cover3">
                        <input type="text" name="link3" class="city" placeholder="Link do banner"
                            value="{{ $banner ? old('link3') ?? $banner->link3 : old('link3') }}" />
                    </label>
                    @if (isset($banner->cover3))
                        <div class="img-responsive-16by9 mb-1 text-center">
                            <img src="{{ asset('storage/' . $banner->cover3) }}" class="radius" alt=""
                                width="250">
                        </div>
                    @endif
                </div> --}}

                <div class="text-right mt-2">
                    <button class="btn btn-large btn-green icon-check-square-o">Atualizar Banners</button>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
