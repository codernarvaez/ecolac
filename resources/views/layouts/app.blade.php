<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">    
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
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

    @if (session('error'))
    <div class="alert alert-danger mb-0 text-center" role="alert">
        {{ session('error') }}
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
            <div class="row align-items-center">
                <div class="col">
                    <nav class="main-menu">
                        <ul class="list-inline mb-0">
                            <li class="menu-item list-inline-item {{ (request()->is('product*')) ? 'active' : '' }}"><a href="{{ route('products') }}"><i class="fas fa-box"></i>Inventario</a></li>
                            @if (Auth::user()->person->role->name == "Superadmin")
                            <li class="menu-item list-inline-item {{ (request()->is('users*')) ? 'active' : '' }}"><a href="{{ route('users') }}"><i class="fas fa-users"></i>Usuarios</a></li>
                            @endif
                            <li class="menu-item list-inline-item {{ (request()->is('orders*')) ? 'active' : '' }}"><a href="{{ route('orders') }}"><i class="fas fa-clipboard-list"></i>Pedidos</a></li>
                            <li class="menu-item list-inline-item {{ (request()->is('sales*')) ? 'active' : '' }}"><a href="{{ route('sales') }}"><i class="fas fa-coins"></i>Ventas</a></li>
                            <li class="menu-item list-inline-item {{ (request()->is('config*')) ? 'active' : '' }}"><a href="{{ route('config') }}"><i class="fas fa-cog"></i>Configuración</a></li>
                            <li class="list-inline-item" style="float:right;">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary btn-sm">
                                        <span class="content">Cerrar Sesión</span>
                                    </button>
                                </form>
                            </li>
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
    
    @yield('scripts')
</body>
</html>