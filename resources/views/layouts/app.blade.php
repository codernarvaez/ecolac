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
                        <!--<li class="list-inline-item"><a href="#"><i class="fas fa-bell"></i></a></li>-->
                        <li class="list-inline-item"><a href="#" data-toggle="modal" data-target="#account-config-modal"><i class="fas fa-cog"></i></a></li>
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
                            <li class="menu-item list-inline-item {{ (request()->is('users*')) ? 'active' : '' }}"><a href="{{ route('users') }}"><i class="fas fa-users"></i>Usuarios</a></li>
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

    <!-- Modal User Configuration -->
    <div class="modal fade" id="account-config-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajustes de Cuenta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="general_info_form" action="{{ route('edit-auth-user') }}" method="post">
                        @csrf
                        <div class="form-divider">
                            <span class="content">Información personal</span>
                        </div>
                        <input type="hidden" name="current_route" value="{{ Route::currentRouteName() }}">
                        <div class="form-group row align-items-center">
                            <label for="dni" class="col-3">Identificación</label>
                            <div class="col-6">
                                <input type="text" name="dni" id="account_dni" class="form-control" autocomplete="off" value="{{ Auth::user()->person->dni }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="firstname" class="col-3">Nombres</label>
                            <div class="col">
                                <input type="text" name="firstname" id="account_firstname" class="form-control" autocomplete="off" value="{{ Auth::user()->person->firstname }}">
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="lastname" class="col-3">Apellidos</label>
                            <div class="col">
                                <input type="text" name="lastname" id="account_lastname" class="form-control" autocomplete="off" value="{{ Auth::user()->person->lastname }}">
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="phone" class="col-3">Telefono</label>
                            <div class="col-5">
                                <input type="phone" name="phone" id="account_phone" class="form-control" autocomplete="off" value="{{ Auth::user()->person->phone }}">
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="email" class="col-3">Correo</label>
                            <div class="col-5">
                                <input type="email" name="email" id="account_email" class="form-control" autocomplete="off" value="{{ Auth::user()->person->email }}">
                            </div>
                        </div>                       
                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        </div>
                    </form>
                    <form id="account_info_form" action="{{ route('edit-pass-user') }}" method="post">
                        @csrf
                        <div class="form-divider">
                            <span class="content">Información de cuenta</span>
                        </div>
                        <input type="hidden" name="current_route" value="{{ Route::currentRouteName() }}">
                        <div class="form-group row align-items-center">
                            <label for="username" class="col-3">Usuario</label>
                            <div class="col-5">
                                <input type="text" name="username" id="account_username" class="form-control" autocomplete="off" value="{{ Auth::user()->username }}" readonly>
                            </div>
                        </div>   
                        <div class="form-group row align-items-center">
                            <label for="account_old_password" class="col-3">Contraseña Actual</label>
                            <div class="col-6">
                                <input type="password" name="password" id="account_old_password" class="form-control">
                            </div>
                        </div> 
                        <div class="form-group row align-items-center">
                            <label for="account_new_password" class="col-3">Contraseña Nueva</label>
                            <div class="col-6">
                                <input type="password" name="new_password" id="account_new_password" class="form-control">
                            </div>
                        </div>                       
                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        </div>
                    </form>
                    @if (Auth::user()->person->role->name == "Cliente" || Auth::user()->person->role->name == "Repartidor" || Auth::user()->person->role->name == "Vendedor")
                    <form id="location_info_form" action="" method="post">
                        @csrf
                        <div class="form-divider">
                            <span class="content">Información de ubicación</span>
                        </div>
                        <input type="hidden" name="current_route" value="{{ Route::currentRouteName() }}">
                        <div class="form-group row">
                            <div class="col-3"></div>
                            <div class="col-9">
                                <div id='map' style='width: 100%; height: 200px; border-radius: 5px;'></div>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="city" class="col-3">Ciudad</label>
                            <div class="col-5">
                                <input type="text" name="city" id="city" class="form-control" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-3">Dirección</label>
                            <div class="col">
                                <textarea class="form-control" id="address" name="address" rows="3" autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label class="col-3">Coordenadas</label>
                            <div class="col">
                                <input type="text" name="longitude" id="longitude" class="form-control" autocomplete="off" readonly placeholder="Longitud">
                            </div>
                            <div class="col">
                                <input type="text" name="latitude" id="latitude" class="form-control" autocomplete="off" readonly placeholder="Latitud">
                            </div>
                        </div>                        
                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        </div>
                    </form>  
                    @endif
                    
                </div>
            </div>
        </div>
    </div>

    <script src="/js/jquery.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    
    @yield('scripts')
</body>
</html>