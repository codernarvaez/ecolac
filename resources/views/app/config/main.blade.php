@extends('layouts.app')

@section('content')
<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Configuración</h2>        
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="divider-line"></div>
    </div>
</div>

<div class="row">
    <div class="col-3">
        <div class="submenu">
            <ul class="list-unstyled">
                <li>
                    <a href="{{ route('config-account') }}" class="{{ (request()->is('config/account*')) ? 'active' : '' }}">
                        Configuración de la Cuenta
                    </a>
                </li>
                <li>
                    <a href="{{ route('config-system') }}" class="{{ (request()->is('config/system*')) ? 'active' : '' }}">
                        Configuración del Sistema
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-9">
        @yield('subcontent')
    </div>
</div>
@endsection

@section('scripts')
@if (Auth::user()->person->role->name == "Cliente" || Auth::user()->person->role->name == "Repartidor" || Auth::user()->person->role->name == "Vendedor")
<script src='https://api.mapbox.com/mapbox-gl-js/v1.3.2/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v1.3.2/mapbox-gl.css' rel='stylesheet' />

<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>

<!-- Map Scripts -->
<script>    
    mapboxgl.accessToken = 'pk.eyJ1Ijoic2FrZWkiLCJhIjoiY2sxYjdvbW5tMGxtMDNkcGZvN3NuOWV0ZiJ9.6fwPb6JHMxel4jN5qQfu0g';
    var map = new mapboxgl.Map({
        container: 'map',
        style: '/json/map/style.json',
        center: [-79.2, -4],
        zoom: 14
    });

    var mapboxClient = new mapboxSdk({ accessToken: mapboxgl.accessToken });

    map.addControl(new mapboxgl.GeolocateControl({
        positionOptions: {
            enableHighAccuracy: true
        },
        trackUserLocation: true
    }));

    var marker = new mapboxgl.Marker({
        draggable: true
    })
    .setLngLat([-79.2, -4])
    .addTo(map);

    function onDragEnd() {
        var lngLat = marker.getLngLat();

        mapboxClient.geocoding.reverseGeocode({
            query: [lngLat.lng, lngLat.lat],
            limit: 1
        })
        .send()
        .then(response => {
            $('#city').val(response.body.features[0].context[0].text + ", " + response.body.features[0].context[2].text);
            $('#latitude').val(lngLat.lat);
            $('#longitude').val(lngLat.lng);       
        });
    }
    
    marker.on('dragend', onDragEnd);

    var nav = new mapboxgl.NavigationControl();
    map.addControl(nav, 'top-left');
    
    // disable map rotation using right click + drag
    map.dragRotate.disable();
    
    // disable map rotation using touch rotation gesture
    map.touchZoomRotate.disableRotation();
</script>
@endif
@endsection