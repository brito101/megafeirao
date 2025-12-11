@extends('web.master.master-2')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Breadcrumb */
        .breadcrumb {
            max-width: 1200px;
            margin: 1rem auto;
            padding: 0 2rem;
            font-size: 0.9rem;
            color: var(--gray);
        }
        
        .breadcrumb a {
            color: var(--accent);
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        /* Product Section */
        .product-container {
            max-width: 1200px;
            margin: 2rem auto 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }
        
        /* Gallery */
        .gallery {
            position: relative;
            max-width: 750px;
            margin: 0 auto;
        }

        .main-image {
            width: 100%;
            height: 350px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
            margin-bottom: 1rem;
        }

        .main-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-thumbnails-container {
            position: relative;
            max-width: 700px;
            overflow: hidden;
        }

        .image-thumbnails {
            display: flex;
            gap: 0.5rem;
            transition: transform 0.3s ease;
            width: max-content;
        }

        .thumbnail {
            height: 70px;
            min-width: 100px;
            border-radius: 4px;
            cursor: pointer;
            opacity: 0.7;
            transition: var(--transition);
            flex-shrink: 0;
            position: relative;
        }

        .thumbnail:hover,
        .thumbnail.active {
            opacity: 1;
            transform: scale(1.05);
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }

        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .scroll-btn:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .scroll-btn.left {
            left: 5px;
        }

        .scroll-btn.right {
            right: 5px;
        }

        /* Product Info */
        .product-info h1 {
            font-size: 1.75rem;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .product-subtitle {
            color: #9ca3af;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .price-container {
            background-color: #f9fafb;
            padding: 1.75rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            border: 1px solid #e5e7eb;
        }

        .price {
            font-size: 2.25rem;
            font-weight: 700;
            color: #3b82f6;
            margin-bottom: 1rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
            flex: 1;
            text-align: center;
        }

        .btn-primary {
            background-color: #10b981;
            color: white;
            border: none;
            font-size: 1rem;
        }

        .btn-primary:hover {
            background-color: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background-color: #dbeafe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3b82f6;
            font-size: 1.1rem;
        }

        /* Details Section */
        .details-section {
            max-width: 1200px;
            margin: 1rem auto 3rem auto;
            padding: 0 2rem;
        }

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--light);
            text-align: left;
        }

        .details-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .description-content {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
            max-height: 440px;
            overflow-y: auto;
            line-height: 1.4;
        }

        .description-content p {
            margin-bottom: 1rem;
        }

        .map-container {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
            height: fit-content;
        }

        .map-placeholder {
            width: 100%;
            height: 300px;
            background-color: #f0f0f0;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray);
            flex-direction: column;
        }

        .description-content::-webkit-scrollbar {
            width: 8px;
        }

        .description-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .description-content::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 4px;
        }

        .description-content::-webkit-scrollbar-thumb:hover {
            background: #2980b9;
        }

        /* Similar Vehicles */
        .similar-section {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 2rem;
        }

        .similar-container {
            position: relative;
            max-width: 1200px;
            overflow: hidden;
            margin: 0 auto;
        }

        .similar-track {
            display: flex;
            gap: 1.5rem;
            transition: transform 0.5s ease;
            width: max-content;
        }

        .vehicle-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            min-width: 220px;
            flex-shrink: 0;
        }

        .vehicle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .vehicle-image {
            height: 150px;
            background-color: #eee;
            background-size: cover;
            background-position: center;
        }

        .vehicle-info {
            padding: 1.2rem;
        }

        .vehicle-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .vehicle-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            color: var(--gray);
            font-size: 0.8rem;
        }

        .vehicle-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--secondary);
        }

        .similar-scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            font-size: 1.2rem;
        }

        .similar-scroll-btn:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .similar-scroll-btn.left {
            left: 10px;
        }

        .similar-scroll-btn.right {
            right: 10px;
        }
        /* Indicadores de posição */
        .position-indicators {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #ddd;
            cursor: pointer;
            transition: var(--transition);
        }

        .indicator.active {
            background-color: var(--accent);
        }
        /* Responsive */
        @media (max-width: 768px) {
            .product-container,
            .details-container {
                grid-template-columns: 1fr;
            }
            
            .main-image {
                height: 300px;
            }
            
            .product-info h1 {
                font-size: 1.5rem;
            }
            
            .price {
                font-size: 2rem;
            }
        }
    </style>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('web.home') }}">Início</a> > 
        @if ($automotive->category)
            <a href="{{ route('web.filter') }}?category={{ $automotive->category }}">{{ $automotive->category }}</a> > 
        @endif
        @if ($automotive->model)
            <a href="{{ route('web.filter') }}?category={{ $automotive->category }}&model={{ $automotive->model }}">{{ $automotive->model }}</a> > 
        @endif
        <span>{{ $automotive->title }}</span>
    </div>

    <!-- Product Section -->
    <section class="product-container">
        <div class="gallery">
            @if ($automotive->images()->get()->count())
                <div class="main-image">
                    <img id="mainImage" src="{{ $automotive->images()->first()->getUrlCroppedAttribute() }}" alt="{{ $automotive->title }}">
                </div>

                <div class="image-thumbnails-container">
                    <div class="image-thumbnails" id="thumbnails">
                        @foreach ($automotive->images()->get() as $image)
                            <div class="thumbnail {{ $loop->first ? 'active' : '' }}" 
                                 onclick="changeImage('{{ $image->getUrlCroppedAttribute() }}')">
                                <img src="{{ $image->getUrlCroppedAttribute() }}" 
                                     alt="{{ $automotive->title }}">
                            </div>
                        @endforeach
                    </div>
                    <button class="scroll-btn left" onclick="scrollThumbnails(-1)">‹</button>
                    <button class="scroll-btn right" onclick="scrollThumbnails(1)">›</button>
                </div>
            @endif
        </div>

        <div class="product-info">
            <h1>{{ $automotive->title }}</h1>
            <p class="product-subtitle">{{ $automotive->model }} - Ano {{ $automotive->year }} - {{ number_format($automotive->mileage, 0, ',', '.') }} km</p>

            <div class="price-container">
                @if ($automotive->sale_price)
                    <div class="price">R$ {{ $automotive->sale_price }}</div>
                @else
                    <p style="color: var(--gray); margin-bottom: 1rem;">
                        Entre em contato com a nossa equipe comercial!
                    </p>
                @endif

                <div class="action-buttons">
                    @php
                        $phone = $company->cell ?? $automotive->ownerObject()->cell;
                        // Remove todos os caracteres não numéricos
                        $phoneClean = preg_replace('/[^0-9]/', '', $phone);
                    @endphp
                    <a href="https://api.whatsapp.com/send?phone=55{{ $phoneClean }}&text=Olá, me interessei sobre o seu anúncio do {{ $automotive->title }}" 
                       target="_blank" 
                       class="btn btn-primary">
                        <i class="fab fa-whatsapp"></i> Falar com Vendedor
                    </a>
                </div>

                <div class="features-grid">
                    @if ($automotive->mileage)
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 0.8rem; margin: 0; font-weight: 500; color: #6b7280;">Quilometragem</h4>
                                <p style="margin: 0; font-size: 0.95rem; color: #1f2937; font-weight: 600;">{{ number_format($automotive->mileage, 0, ',', '.') }} km</p>
                            </div>
                        </div>
                    @endif

                    @if ($automotive->year)
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 0.8rem; margin: 0; font-weight: 500; color: #6b7280;">Ano</h4>
                                <p style="margin: 0; font-size: 0.95rem; color: #1f2937; font-weight: 600;">{{ $automotive->year }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($automotive->model)
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-car-side"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 0.8rem; margin: 0; font-weight: 500; color: #6b7280;">Modelo</h4>
                                <p style="margin: 0; font-size: 0.95rem; color: #1f2937; font-weight: 600;">{{ $automotive->model }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Details Section -->
    <section class="details-section">
        <h2 class="section-title">Detalhes do Veículo</h2>

        <div class="details-container">
            <div class="description-content">
                <h4 style="font-weight: bold; margin-bottom: 1rem;">OBSERVAÇÕES</h4>
                {!! $automotive->description !!}

                @if ($automotive->youtube_link)
                    <h4 style="font-weight: bold; margin: 2rem 0 1rem 0;">VÍDEO DESCRITIVO</h4>
                    <div class='embed-responsive embed-responsive-16by9' style="margin-bottom: 1rem;">
                        <iframe class="embed-responsive-item"
                            src="{{ str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $automotive->youtube_link) }}"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                @endif
            </div>

            <div class="map-container">
                <h3 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-map-marker-alt"></i> Localização
                </h3>

                @if ($company && $company->type == 'concessionaria')
                    <div id="map" style="width: 100%; height: 300px; border-radius: 4px;"></div>
                    <p style="margin-top: 1rem;">
                        <strong>Endereço:</strong> 
                        {{ $company->street != '' ? $company->street . ',' : '' }}
                        {{ $company->number != '' ? $company->number . ',' : '' }}
                        {{ $company->neighborhood != '' ? $company->neighborhood . ', ' : '' }}
                        {{ $company->city }}-{{ $company->state }}
                        {{ $company->zipcode != '' ? '. CEP: ' . $company->zipcode : '' }}
                    </p>
                @else
                    <div class="map-placeholder">
                        <i class="fas fa-map fa-3x"></i>
                        <p>Localização disponível após contato</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Similar Vehicles -->
    @if (isset($similarVehicles) && $similarVehicles && $similarVehicles->count() > 0)
        <section class="similar-section">
            <h2 class="section-title">Veículos Similares</h2>

            <div class="similar-container">
                <button class="similar-scroll-btn left" onclick="scrollSimilar(-1)">‹</button>
                <button class="similar-scroll-btn right" onclick="scrollSimilar(1)">›</button>

                <div class="similar-track" id="similarTrack">
                    @foreach ($similarVehicles as $similar)
                        <div class="vehicle-card">
                            <a href="{{ route('web.buyAutomotive', ['slug' => $similar->slug]) }}">
                                <div class="vehicle-image" style="background-image: url('{{ $similar->cover() }}')"></div>
                            </a>
                            <div class="vehicle-info">
                                <h3 class="vehicle-title">
                                    <a href="{{ route('web.buyAutomotive', ['slug' => $similar->slug]) }}" 
                                       style="text-decoration: none; color: inherit;">
                                        {{ Illuminate\Support\Str::words($similar->title, 5) }}
                                    </a>
                                </h3>
                                <div class="vehicle-details">
                                    <span>{{ $similar->year }}</span>
                                    <span>{{ number_format($similar->mileage, 0, ',', '.') }} km</span>
                                </div>
                                @if ($similar->sale_price)
                                    <div class="vehicle-price">R$ {{ $similar->sale_price }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="position-indicators" id="positionIndicators">
                    <!-- Os indicadores serão gerados via JavaScript -->
                </div>
            </div>
        </section>
    @endif

    <script>
        // Galeria de imagens
        let currentScroll = 0;
        const scrollAmount = 120;

        function changeImage(src) {
            document.getElementById('mainImage').src = src;

            const thumbnails = document.querySelectorAll('.thumbnail');
            thumbnails.forEach(thumb => {
                thumb.classList.remove('active');
            });

            event.currentTarget.classList.add('active');
        }

        function scrollThumbnails(direction) {
            const container = document.querySelector('.image-thumbnails-container');
            const thumbnails = document.getElementById('thumbnails');
            const maxScroll = thumbnails.scrollWidth - container.clientWidth;

            currentScroll += direction * scrollAmount;

            if (currentScroll < 0) {
                currentScroll = maxScroll;
            } else if (currentScroll > maxScroll) {
                currentScroll = 0;
            }

            thumbnails.style.transform = `translateX(-${currentScroll}px)`;
        }

        // Auto-scroll thumbnails
        setInterval(() => {
            scrollThumbnails(1);
        }, 3000);

        // Veículos Similares
        const similarTrack = document.getElementById('similarTrack');
        if (similarTrack) {
            let currentSimilarPosition = 0;
            const similarCards = document.querySelectorAll('.vehicle-card');
            const totalSimilarCards = similarCards.length;

            if (totalSimilarCards > 0) {
                const cardWidth = similarCards[0].offsetWidth + 24;

                // Criar indicadores de posição
                const positionIndicators = document.getElementById('positionIndicators');
                for (let i = 0; i < totalSimilarCards; i++) {
                    const indicator = document.createElement('div');
                    indicator.className = `indicator ${i === 0 ? 'active' : ''}`;
                    indicator.addEventListener('click', () => goToPosition(i));
                    positionIndicators.appendChild(indicator);
                }

                function scrollSimilar(direction) {
                    const maxPosition = totalSimilarCards - 1;

                    currentSimilarPosition += direction;

                    if (currentSimilarPosition < 0) {
                        currentSimilarPosition = maxPosition;
                    } else if (currentSimilarPosition > maxPosition) {
                        currentSimilarPosition = 0;
                    }

                    updateSimilarPosition();
                }

                function goToPosition(position) {
                    currentSimilarPosition = position;
                    updateSimilarPosition();
                }

                function updateSimilarPosition() {
                    const track = document.getElementById('similarTrack');
                    const translateX = -currentSimilarPosition * cardWidth;
                    track.style.transform = `translateX(${translateX}px)`;

                    // Atualizar indicadores ativos
                    const indicators = document.querySelectorAll('.indicator');
                    indicators.forEach((indicator, index) => {
                        indicator.classList.toggle('active', index === currentSimilarPosition);
                    });
                }

                let similarAutoScrollInterval;

                function startSimilarAutoScroll() {
                    similarAutoScrollInterval = setInterval(() => {
                        scrollSimilar(1);
                    }, 3000);
                }

                function stopSimilarAutoScroll() {
                    clearInterval(similarAutoScrollInterval);
                }

                const similarContainer = document.querySelector('.similar-container');
                similarContainer.addEventListener('mouseenter', stopSimilarAutoScroll);
                similarContainer.addEventListener('mouseleave', startSimilarAutoScroll);

                startSimilarAutoScroll();

                window.scrollSimilar = scrollSimilar;

                window.addEventListener('resize', () => {
                    if (similarCards.length > 0) {
                        updateSimilarPosition();
                    }
                });

                window.addEventListener('load', () => {
                    if (similarCards.length > 0) {
                        updateSimilarPosition();
                    }
                });
            }
        }
    </script>

    @if ($company && $company->type == 'concessionaria')
        <script>
            function markMap() {
                var locationJson = $.getJSON(
                    'https://maps.googleapis.com/maps/api/geocode/json?address={{ $company->street }},+{{ $company->number }}+{{ $company->city }}+{{ $company->neighborhood }}&key={{ env('GOOGLE_API_KEY') }}',
                    function(response) {
                        lat = response.results[0].geometry.location.lat;
                        lng = response.results[0].geometry.location.lng;

                        const map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 14,
                            center: {
                                lat: lat,
                                lng: lng
                            },
                            mapTypeId: 'terrain'
                        });

                        const beachMarker = new google.maps.Marker({
                            position: {
                                lat: lat,
                                lng: lng
                            },
                            map,
                        });
                    });
            }
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&callback=markMap"></script>
    @endif
@endsection
