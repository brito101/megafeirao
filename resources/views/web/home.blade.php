@extends('web.master.master-2')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h2>Encontre o carro perfeito para você</h2>
        </div>
    </section>

    <!-- Search Section -->
    <section class="search-container">
        <form class="search-form" action="{{ route('web.filter') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="marca">Categoria</label>
                <select id="marca" name="category" class="form-control">
                    <option value="">Todas as categorias</option>
                    @if (isset($categories))
                        @foreach ($categories as $category)
                            <option value="{{ $category }}"
                                {{ old('category', request('category')) == $category ? 'selected' : '' }}>
                                {{ $category }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="modelo">Modelo</label>
                <select id="modelo" name="model" class="form-control">
                    <option value="">Selecione uma categoria primeiro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="preco-max">Preço máximo</label>
                <select id="preco-max" name="price_max" class="form-control">
                    <option value="">Selecione um modelo primeiro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ano-min">Ano mínimo</label>
                <select id="ano-min" name="year_min" class="form-control">
                    <option value="">Selecione um preço primeiro</option>
                </select>
            </div>
            <button type="submit" class="search-button">Buscar Carros</button>
        </form>
    </section>

    <!-- Cars Section -->
    <section class="cars-section">
        <div class="section-title">
            <h2>Carros em Destaque</h2>
            <p>Confira os veículos mais procurados pelos nossos clientes</p>
        </div>
        <div class="cars-grid">
            @if ($automotives && $automotives->count())
                @foreach ($automotives as $automotive)
                    <div class="car-card">
                        <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                            <div class="car-image" style="background-image: url('{{ $automotive->cover() }}')"></div>
                        </a>
                        <div class="car-info">
                            <h3 class="car-title">
                                <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                    style="text-decoration: none; color: inherit;">
                                    {{ Illuminate\Support\Str::words($automotive->title, 5) }}
                                </a>
                            </h3>
                            <div class="car-details">
                                <span>{{ $automotive->year }}</span>
                                <span>{{ number_format($automotive->mileage, 0, ',', '.') }} km</span>
                            </div>
                            <div class="car-price">R$ {{ $automotive->sale_price }}</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 p-5 bg-white my-5" style="grid-column: 1 / -1;">
                    <h2 class="text-center" style="color: var(--primary);">
                        Ooops, não encontramos nenhum veículo para você comprar!
                    </h2>
                    <p class="text-center">
                        Utilize o filtro acima para encontrar o veículo dos seus sonhos...
                    </p>
                </div>
            @endif
        </div>

        @if ($automotives && $automotives->count())
            <div class="pagination">
                @if ($automotives->onFirstPage())
                    <div class="page-btn active">1</div>
                @else
                    <a href="{{ $automotives->url(1) }}" class="page-btn"
                        style="text-decoration: none; color: inherit;">1</a>
                @endif

                @for ($i = 2; $i <= min(5, $automotives->lastPage()); $i++)
                    @if ($automotives->currentPage() == $i)
                        <div class="page-btn active">{{ $i }}</div>
                    @else
                        <a href="{{ $automotives->url($i) }}" class="page-btn"
                            style="text-decoration: none; color: inherit;">{{ $i }}</a>
                    @endif
                @endfor
            </div>
        @endif
    </section>

@endsection

@section('js')
    <script src="{{ url(asset('frontend/assets/js/jquery.js')) }}"></script>

    <script>
        $(document).ready(function() {
            // Armazena os valores selecionados (se existirem)
            var selectedCategory = '{{ request('category') }}';
            var selectedModel = '{{ request('model') }}';
            var selectedPrice = '{{ request('price_max') }}';
            var selectedYear = '{{ request('year_min') }}';

            // Se já tem uma categoria selecionada, carrega os modelos
            if (selectedCategory) {
                loadModels(selectedCategory, selectedModel);
            }

            // Quando mudar a categoria, atualiza os modelos e limpa preço/ano
            $('#marca').on('change', function() {
                var category = $(this).val();

                // Limpa os selects posteriores
                $('#modelo').html('<option value="">Selecione uma categoria primeiro</option>');
                $('#preco-max').html('<option value="">Selecione um modelo primeiro</option>');
                $('#ano-min').html('<option value="">Selecione um preço primeiro</option>');

                if (category) {
                    loadModels(category);
                }
            });

            // Quando mudar o modelo, atualiza os preços e limpa ano
            $('#modelo').on('change', function() {
                var model = $(this).val();
                var category = $('#marca').val();

                // Limpa os selects posteriores
                $('#preco-max').html('<option value="">Selecione um modelo primeiro</option>');
                $('#ano-min').html('<option value="">Selecione um preço primeiro</option>');

                if (model && category) {
                    loadPrices(category, model, selectedPrice);
                }
            });

            // Quando mudar o preço, atualiza os anos
            $('#preco-max').on('change', function() {
                var price = $(this).val();
                var model = $('#modelo').val();
                var category = $('#marca').val();

                // Limpa o select de ano
                $('#ano-min').html('<option value="">Selecione um preço primeiro</option>');

                if (category && model) {
                    loadYears(category, model, price, selectedYear);
                }
            });

            // Função para carregar modelos via AJAX
            function loadModels(category, preSelectedModel) {
                $.ajax({
                    url: '{{ route('api.modelsByCategory') }}',
                    method: 'GET',
                    data: {
                        category: category
                    },
                    success: function(models) {
                        var options = '<option value="">Todos os modelos</option>';

                        if (models.length > 0) {
                            models.forEach(function(model) {
                                var selected = (preSelectedModel && model == preSelectedModel) ?
                                    'selected' : '';
                                options += '<option value="' + model + '" ' + selected + '>' +
                                    model + '</option>';
                            });

                            // Se tem modelo selecionado, carrega os preços
                            if (preSelectedModel) {
                                setTimeout(function() {
                                    loadPrices(category, preSelectedModel, selectedPrice);
                                }, 100);
                            }
                        } else {
                            options = '<option value="">Nenhum modelo disponível</option>';
                        }

                        $('#modelo').html(options);
                    },
                    error: function() {
                        $('#modelo').html('<option value="">Erro ao carregar modelos</option>');
                    }
                });
            }

            // Função para carregar preços via AJAX
            function loadPrices(category, model, preSelectedPrice) {
                $.ajax({
                    url: '{{ route('api.pricesByModel') }}',
                    method: 'GET',
                    data: {
                        category: category,
                        model: model
                    },
                    success: function(prices) {
                        var options = '<option value="">Qualquer preço</option>';

                        if (prices.length > 0) {
                            prices.forEach(function(price) {
                                var selected = (preSelectedPrice && price.value ==
                                    preSelectedPrice) ? 'selected' : '';
                                options += '<option value="' + price.value + '" ' + selected +
                                    '>' + price.label + '</option>';
                            });

                            // Se tem preço selecionado, carrega os anos
                            if (preSelectedPrice) {
                                setTimeout(function() {
                                    loadYears(category, model, preSelectedPrice, selectedYear);
                                }, 100);
                            }
                        } else {
                            options = '<option value="">Nenhum preço disponível</option>';
                        }

                        $('#preco-max').html(options);
                    },
                    error: function() {
                        $('#preco-max').html('<option value="">Erro ao carregar preços</option>');
                    }
                });
            }

            // Função para carregar anos via AJAX
            function loadYears(category, model, price, preSelectedYear) {
                $.ajax({
                    url: '{{ route('api.yearsByPrice') }}',
                    method: 'GET',
                    data: {
                        category: category,
                        model: model,
                        price: price
                    },
                    success: function(years) {
                        var options = '<option value="">Qualquer ano</option>';

                        if (years.length > 0) {
                            years.forEach(function(year) {
                                var selected = (preSelectedYear && year == preSelectedYear) ?
                                    'selected' : '';
                                options += '<option value="' + year + '" ' + selected + '>' +
                                    year + '</option>';
                            });
                        } else {
                            options = '<option value="">Nenhum ano disponível</option>';
                        }

                        $('#ano-min').html(options);
                    },
                    error: function() {
                        $('#ano-min').html('<option value="">Erro ao carregar anos</option>');
                    }
                });
            }
        });
    </script>
@endsection
