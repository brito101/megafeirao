@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header pb-1">
            <h2 class="icon-car">Editar Veículo</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="icon-angle-right separator icon-notext"></li>
                        <li><a href="{{ route('admin.automotives.index') }}">Veículo</a></li>
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

                <ul class="nav_tabs">
                    <li class="nav_tabs_item">
                        <a href="#data" class="nav_tabs_item_link active">Dados Cadastrais</a>
                    </li>
                </ul>

                <form action="{{ route('admin.automotives.update', ['automotive' => $automotive]) }}" method="post"
                    class="app_form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="nav_tabs_content">
                        <div id="data">

                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">Categoria:</span>
                                    <select name="category" class="select2">
                                        <option value="Carro"
                                            {{ old('category') == 'Carro' ? 'selected' : ($automotive->category == 'Carro' ? 'selected' : '') }}>
                                            Carro</option>
                                        <option value="Moto"
                                            {{ old('category') == 'Moto' ? 'selected' : ($automotive->category == 'Moto' ? 'selected' : '') }}>
                                            Moto
                                        </option>
                                        <option value="Caminhão"
                                            {{ old('category') == 'Caminhão' ? 'selected' : ($automotive->category == 'Caminhão' ? 'selected' : '') }}>
                                            Caminhão
                                        </option>
                                        <option value="Ônibus"
                                            {{ old('category') == 'Ônibus' ? 'selected' : ($automotive->category == 'Ônibus' ? 'selected' : '') }}>
                                            Ônibus
                                        </option>
                                        <option value="Náutica"
                                            {{ old('category') == 'Náutica' ? 'selected' : ($automotive->category == 'Náutica' ? 'selected' : '') }}>
                                            Náutica
                                        </option>
                                        <option value="Agrícola"
                                            {{ old('category') == 'Agrícola' ? 'selected' : ($automotive->category == 'Agrícola' ? 'selected' : '') }}>
                                            Agrícola
                                        </option>
                                    </select>
                                </label>

                                <label class="label">
                                    <span class="legend">Valor de Venda:</span>
                                    <input type="tel" name="sale_price" class="mask-money"
                                        value="{{ old('sale_price') ?? $automotive->sale_price }}" />
                                </label>

                            </div>

                            @hasanyrole('Administrador|Gerente')
                                <label class="label">
                                    <span class="legend">Proprietário:</span>
                                    <select name="user" class="select2">
                                        <option value="">Selecione o proprietário</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ $user->id === $automotive->user ? 'selected' : '' }}>{{ $user->name }}
                                                ({{ $user->document }})
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                            @else
                                <input type="hidden" name="user" value="{{ Auth::user()->id }}">
                            @endhasanyrole

                            <div class="label_g2">

                                <label class="label">
                                    <span class="legend">Modelo:</span>
                                    <input type="text" name="model" placeholder="Modelo"
                                        value="{{ old('model') ?? $automotive->model }}" />
                                </label>

                                <label class="label">
                                    <span class="legend">Ano:</span>
                                    <input type="tel" name="year" placeholder="Ano"
                                        value="{{ old('year') ?? $automotive->year }}" />
                                </label>

                            </div>

                            <div class="label_g2">

                                <label class="label">
                                    <span class="legend">Quilometragem:</span>
                                    <input type="tel" name="mileage" placeholder="Quilometragem"
                                        value="{{ old('mileage') ?? $automotive->mileage }}" />
                                </label>
                            </div>

                            <label class="label">
                                <span class="legend">*Título:</span>
                                <input type="text" name="title" value="{{ old('title') ?? $automotive->title }}">
                            </label>


                            <label class="label">
                                <span class="legend">Descrição do Veículo:</span>
                                <textarea name="description" cols="30" rows="10" class="mce">{{ old('description') ?? $automotive->description }}</textarea>
                            </label>

                            <div id="images">
                                <label class="label">
                                    <span class="legend">Imagens</span>
                                    <input type="file" name="files[]" multiple>
                                </label>

                                <div class="content_image"></div>

                                <div class="property_image">
                                    @foreach ($automotive->images()->get() as $image)
                                        <div class="property_image_item">
                                            <img src="{{ $image->url_cropped }}" alt="">
                                            <div class="property_image_actions">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-small {{ $image->cover == true ? 'btn-green' : '' }} icon-check icon-notext image-set-cover"
                                                    data-action="{{ route('admin.automotives.imageSetCover', ['image' => $image->id]) }}"></a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-red btn-small icon-times icon-notext image-remove"
                                                    data-action="{{ route('admin.automotives.imageRemove', ['image' => $image->id]) }}"></a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-2">
                        <button class="icon-check-square-o btn btn-large btn-green">Atualizar Veículo</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('input[name="files[]"]').change(function(files) {

                $('.content_image').text('');

                $.each(files.target.files, function(key, value) {
                    var reader = new FileReader();
                    reader.onload = function(value) {
                        $('.content_image').append(
                            '<div class="property_image_item">' +
                            '<div class="embed radius" ' +
                            'style="background-image: url(' + value.target.result +
                            '); background-size: cover; background-position: center center;">' +
                            '</div>' +
                            '</div>');
                    };
                    reader.readAsDataURL(value);
                });
            });

            $('.image-set-cover').click(function(event) {
                event.preventDefault();

                var button = $(this);

                $.post(button.data('action'), {}, function(response) {
                    if (response.success === true) {
                        $('.property_image').find('a.btn-green').removeClass('btn-green');
                        button.addClass('btn-green');
                    }
                }, 'json');
            });

            $('.image-remove').click(function(event) {
                event.preventDefault();

                var button = $(this);

                $.ajax({
                    url: button.data('action'),
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(response) {

                        if (response.success === true) {
                            button.closest('.property_image_item').fadeOut(function() {
                                $(this).remove();
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
