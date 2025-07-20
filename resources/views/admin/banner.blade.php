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
                    <form action="{{ route('admin.banner.update', ['banner' => $banner]) }}" method="post" class="app_form"
                        enctype="multipart/form-data">
                        @method('PUT')
                    @else
                        <form action="{{ route('admin.banner.store') }}" method="post" class="app_form"
                            enctype="multipart/form-data">
                @endif
                @csrf

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">PÁGINA HOME - 1º Banner da lateral esquerda</span>
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
                </div>

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">PÁGINA HOME - 2º Banner da lateral esquerda</span>
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

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">PÁGINA HOME - 3º Banner da lateral esquerda</span>
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
                </div>

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">PÁGINA DO ANÚNCIO - 1º Banner da lateral direita</span>
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
                </div>

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">PÁGINA ANÚNCIO - 2º Banner da lateral direita</span>
                        <input type="file" name="cover5">
                        <input type="text" name="link5" class="city" placeholder="Link do banner"
                            value="{{ $banner ? old('link5') ?? $banner->link5 : old('link5') }}" />
                    </label>
                    @if (isset($banner->cover5))
                        <div class="img-responsive-16by9 mb-1 text-center">
                            <img src="{{ asset('storage/' . $banner->cover5) }}" class="radius" alt=""
                                width="250">
                        </div>
                    @endif
                </div>

                {{--<div class="label_g2">
                    <label class="label">
                        <span class="legend">PÁGINA ANÚNCIO - 3º Banner da lateral direita</span>
                        <input type="file" name="cover6">
                        <input type="text" name="link6" class="city" placeholder="Link do banner"
                            value="{{ $banner ? old('link6') ?? $banner->link6 : old('link6') }}" />
                    </label>
                    @if (isset($banner->cover6))
                        <div class="img-responsive-16by9 mb-1 text-center">
                            <img src="{{ asset('storage/' . $banner->cover6) }}" class="radius" alt=""
                                width="250">
                        </div>
                    @endif
                </div>

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">PÁGINA DE ANÚNCIO - 4º Banner da lateral direita</span>
                        <input type="file" name="cover7">
                        <input type="text" name="link7" class="city" placeholder="Link do banner"
                            value="{{ $banner ? old('link7') ?? $banner->link7 : old('link7') }}" />
                    </label>
                    @if (isset($banner->cover7))
                        <div class="img-responsive-16by9 mb-1 text-center d-flex">
                            <img src="{{ asset('storage/' . $banner->cover7) }}" class="radius my-auto" alt=""
                                width="250">
                        </div>
                    @endif
                </div>
               

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">PÁGINA DE ANÚNCIO - 5º Banner da lateral direita</span>
                        <input type="file" name="cover8">
                        <input type="text" name="link8" class="city" placeholder="Link do banner"
                            value="{{ $banner ? old('link8') ?? $banner->link8 : old('link8') }}" />
                    </label>
                    @if (isset($banner->cover8))
                        <div class="img-responsive-16by9 mb-1 text-center">
                            <img src="{{ asset('storage/' . $banner->cover8) }}" class="radius" alt=""
                                width="250">
                        </div>
                    @endif
                </div> --}}

                <div class="text-right mt-2">
                    <button class="icon-check-square-o btn btn-large btn-green">Atualizar Banners</button>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
