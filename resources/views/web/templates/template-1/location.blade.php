@extends('web.templates.template-1.master')

@section('content')
    <div class="utility-bar noMobile">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-8">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('web.filterCompany', ['slug' => $company->slug]) }}">Home</a></li>
                        <li class="active">Localização</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-4">
                </div>
            </div>
        </div>
    </div>

    <div class="main" role="main">
        <div id="content" class="content full">
            <div class="container">
                <div class="listing-header margin-40">
                    <span>Onde <strong>Estamos</strong></span>
                    <p>{{ $company->street }}, {{ $company->number }}, {{ $company->neighborhood }},
                        {{ $company->city }}-{{ $company->state }}. CEP:
                        {{ $company->zipcode }}</p>
                </div>

                <div id="locations" class="page-header parallax">
                    <div id="map" style="width: 100%; min-height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function markMap() {

            var locationJson = $.getJSON(
                'https://maps.googleapis.com/maps/api/geocode/json?address={{ $company->street }},+{{ $company->number }}+{{ $company->city }}+{{ $company->neighborhood }}&key={{ env('GOOGLE_API_KEY') }}',
                function(response) {

                    lat = response.results[0].geometry.location.lat;
                    lng = response.results[0].geometry.location.lng;

                    var citymap = {
                        automotive: {
                            center: {
                                lat: lat,
                                lng: lng
                            },
                            population: 100
                        }
                    };

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
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&callback=markMap">
    </script>
@endsection
