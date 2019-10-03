<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/fonts.css">
    <link rel="stylesheet" href="/css/icons.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <title>Manager | Online Shop</title>
</head>
<body>
    @if (session('success'))
    <div class="alert alert-success mb-0 text-center" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="topbar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <a class="logo" href="#">
                        <img src="/img/logo.png" alt="OnlineShop">
                    </a>
                </div>
                <div class="col-auto">
                    <ul class="list-inline mb-0 top-options">
                        <li class="list-inline-item"><a href="#"><i class="fas fa-bell"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fas fa-cog"></i></a></li>
                    </ul>
                </div>
                <div class="col-auto">
                    <div class="userbox">
                        <span class="name truncate">{{ Auth::user()->person->firstname . ' ' . Auth::user()->person->lastname }}</span>
                        <span class="role">{{ Auth::user()->person->email }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="menu">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav class="main-menu">
                        <ul class="list-inline mb-0">
                            <li class="menu-item list-inline-item {{ (request()->is('product*')) ? 'active' : '' }}"><a href="{{ route('products') }}"><i class="fas fa-box"></i>Inventario</a></li>
                            <li class="menu-item list-inline-item {{ (request()->is('users*')) ? 'active' : '' }}"><a href="{{ route('users') }}"><i class="fas fa-users"></i>Usuarios</a></li>
                            <li class="menu-item list-inline-item {{ (request()->is('orders*')) ? 'active' : '' }}"><a href="{{ route('orders') }}"><i class="fas fa-clipboard-list"></i>Pedidos</a></li>
                            <li class="menu-item list-inline-item {{ (request()->is('sales*')) ? 'active' : '' }}"><a href="{{ route('sales') }}"><i class="fas fa-coins"></i>Ventas</a></li>
                            <li class="menu-item list-inline-item {{ (request()->is('reports*')) ? 'active' : '' }}"><a href="{{ route('reports') }}"><i class="fas fa-archive"></i>Reportes</a></li>
                            <li class="menu-item list-inline-item {{ (request()->is('config*')) ? 'active' : '' }}"><a href="{{ route('config') }}"><i class="fas fa-cog"></i>Configuración</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row">
                <!--<div class="col-3">
                    <nav class="main-menu">
                        <ul class="list-unstyled mb-0">
                            <li class="tag">Menu Principal</li>
                            @if (Auth::user()->person->role->name == "Superadmin" || Auth::user()->person->role->name == "Administrador")
                            <li class="menu-item {{ (Route::currentRouteName() == 'products') ? 'active':'' }}"><a href="{{ route('products') }}"><i class="fas fa-box"></i>Inventario</a></li>
                            @endif

                            @if (Auth::user()->person->role->name == "Superadmin")
                            <li class="menu-item {{ (Route::currentRouteName() == 'users') ? 'active':'' }}"><a href="{{ route('users') }}"><i class="fas fa-users"></i>Usuarios</a></li>
                            @endif

                            @if (Auth::user()->person->role->name != "Cliente")
                            <li class="menu-item {{ (Route::currentRouteName() == 'orders') ? 'active':'' }}"><a href="{{ route('orders') }}"><i class="fas fa-clipboard-list"></i>Pedidos</a></li>
                            <li class="menu-item {{ (Route::currentRouteName() == 'sales') ? 'active':'' }}"><a href="{{ route('sales') }}"><i class="fas fa-coins"></i>Ventas</a></li>
                            @else
                            <li class="menu-item"><a href="#"><i class="fas fa-clipboard-list"></i>Mis compras</a></li>
                            @endif
            
                            @if (Auth::user()->person->role->name == "Superadmin" || Auth::user()->person->role->name == "Administrador")
                            <li class="menu-item {{ (Route::currentRouteName() == 'reports') ? 'active':'' }}"><a href="{{ route('reports') }}"><i class="fas fa-archive"></i>Reportes</a></li>
                            @endif

                            @if (Auth::user()->person->role->name == "Superadmin")
                            <li class="menu-item {{ (Route::currentRouteName() == 'config') ? 'active':'' }}"><a href="{{ route('config') }}"><i class="fas fa-cog"></i>Configuración</a></li>
                            @endif

                            <li class="mt-5">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-block btn-sm">
                                        <span class="content">Cerrar Sesión</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </nav>
                </div>-->
                <div class="col">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p class="text-center copyright mb-0">© Todos los derechos reservados.</p>
    </footer>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    @if (request()->is('users'))
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.3.2/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.3.2/mapbox-gl.css' rel='stylesheet' />

    <script>
        
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2FrZWkiLCJhIjoiY2sxYjdvbW5tMGxtMDNkcGZvN3NuOWV0ZiJ9.6fwPb6JHMxel4jN5qQfu0g';
        var map = new mapboxgl.Map({
            container: 'map',
            style: '/json/map/style.json',
            center: [-79.2, -4.005569],
            zoom: 12
        });

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
            $('#latitude').val(lngLat.lat);
            $('#longitude').val(lngLat.lng);
        }
        
        marker.on('dragend', onDragEnd);

        var nav = new mapboxgl.NavigationControl();
        map.addControl(nav, 'top-left');
        
        // disable map rotation using right click + drag
        map.dragRotate.disable();
        
        // disable map rotation using touch rotation gesture
        map.touchZoomRotate.disableRotation();
    </script>

    <script>
        $('#role').on('change', function(e){
            var role = $(this).val();
            if(role == "Cliente" || role == "Repartidor" || role == "Vendedor"){
                $('#location-info').removeClass('hidden');
            }else{
                $('#location-info').addClass('hidden');
            }
        });
    </script>
    @endif
    
</body>
</html>