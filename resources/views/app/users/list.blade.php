@extends('layouts.app')

@section('content')
<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Listado de Usuarios</h2>        
    </div>
    <div class="col text-right">
        <button id="add_user" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#user-modal">Añadir Usuario</button>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="divider-line"></div>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <form action="" method="post" class="form-search">
            <div class="form-group">
                <input type="text" name="search" id="search" class="form-control icon" placeholder="Buscar" autocomplete="off">
                <i class="fas fa-search"></i>
            </div>
        </form>
    </div>
    <!--<div class="col-5"></div>
    <div class="col-3">
        <form action="" method="post" class="form-search">
            <div class="form-group">
                <select name="enabled" id="enabled" class="form-control">
                    <option disabled selected>Todos</option>
                    <option value="Administrador">Administradores</option>
                    <option value="Cliente">Clientes</option>
                    <option value="Vendedor">Vendedores</option>
                    <option value="Vendedor">Repartidores</option>
                    <option value="Auditor">Auditores</option>
                </select>
            </div>
        </form>
    </div>-->
</div>

<div class="row">
    <div class="col">
        <div class="row table-head">
            <div class="col-1"></div>
            <div class="col-5">Información</div>
            <div class="col-2">Teléfono</div>
            <div class="col-2">Tipo</div>
            <div class="col-2">Usuario</div>
        </div>
        <div class="row table-body">
            <div class="col">
                @foreach ($users as $user)
                <div class="row align-items-center">
                    <div class="col-1">
                        <div class="dropdown">
                            <a class="btn btn-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <button class="dropdown-item" data-toggle="modal" data-target="#user-modal" onclick="editUser({ 'user': {{ $user }}, 'role': {{ $user->role }}, 'account': {{ $user->account }}, 'location': {{ ($user->location) ? $user->location : 'null' }}})">Editar</button>
                                <div class="dropdown-divider"></div>
                                @if ($user->account->enabled)
                                <button class="dropdown-item" data-toggle="modal" data-target="#disable-modal" onclick="setId({{ $user->account->id_account }}, true)">Deshabilitar cuenta</button>
                                @else
                                <button class="dropdown-item" data-toggle="modal" data-target="#enable-modal" onclick="setId({{ $user->account->id_account }}, false)">Habilitar cuenta</button>    
                                @endif
                                <button class="dropdown-item" data-toggle="modal" data-target="#restore-modal" onclick="setRestore({{ $user->account->id_account }})">Restablecer contraseña</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <span class="name truncate">{{ $user->firstname }} {{ $user->lastname }}</span>
                    <span class="description truncate">{{ $user->dni }} <span class="ml-1 mr-1">-</span> {{ $user->email }}</span>
                    </div>
                    <div class="col-2">
                        {{ $user->phone }}
                    </div>
                    <div class="col-2">
                        {{ $user->role->name }}
                    </div>
                    <div class="col-2">
                        <span class="enabled">{{ ($user->account->enabled) ? 'Activo':'Inactivo' }}</span>
                        <span class="username">{{ $user->account->username }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="row table-footer align-items-center">
            <div class="col-8">
                @php
                    $pages = ceil($count / 20);
                    $n_pages = $pages - $p;
                @endphp  

                @if ($pages > 1)
                    <nav aria-label="Page navigation example">                        
                        <ul class="pagination mb-0">
                            @if ($p != 1)
                            <li class="page-item prev">
                                <a class="page-link" href="{{ route('users', ['p' => $p - 1 ]) }}" aria-label="Anterior">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            
                            @if ($pages > 5)
                            <li class="page-item">
                                <a class="page-link" href="{{ route('users', ['p' => 1 ]) }}">1</a>
                            </li>
                            <li class="page-item">
                                <span>...</span>
                            </li>
                            @endif
                            
                            @endif 

                            @if ($n_pages >= 5)
                                @for ($i = $p; $i <= $p + 4; $i++)
                                <li class="page-item {{ ($i == $p) ? 'active':'' }}" {{ ($i == $p) ? 'aria-current="page"':'' }}><a class="page-link" href="{{ route('users', ['p' => $i ]) }}">{{ $i }}</a></li>
                                @endfor                             
                            @else
                                @if ($pages > 5)
                                    @for ($i = $pages - 5; $i <= $pages; $i++)
                                    <li class="page-item {{ ($i == $p) ? 'active':'' }}" {{ ($i == $p) ? 'aria-current="page"':'' }}><a class="page-link" href="{{ route('users', ['p' => $i ]) }}">{{ $i }}</a></li>
                                    @endfor    
                                @else
                                    @for ($i = 1; $i <= $pages; $i++)
                                    <li class="page-item {{ ($i == $p) ? 'active':'' }}" {{ ($i == $p) ? 'aria-current="page"':'' }}><a class="page-link" href="{{ route('users', ['p' => $i ]) }}">{{ $i }}</a></li>
                                    @endfor 
                                @endif
                                                            
                            @endif                            
                            
                            @if ($p != $pages)

                            @if ($pages > 5 && $n_pages > 4)
                            <li class="page-item">
                                <span>...</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="{{ route('users', ['p' => $pages ]) }}">{{ $pages }}</a>
                            </li>  
                            @endif
                            
                            <li class="page-item next">
                                <a class="page-link" href="{{ route('users', ['p' => $p + 1 ]) }}" aria-label="Siguiente">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li> 
                            @endif
                            
                        </ul>
                    </nav>         
                @endif
            </div>
            <div class="col-4">
                <p class="viewing">Viendo {{ ($p > 1) ? ((count($users) == 20) ? ($p * 20): $count): count($users) }} de {{ $count }} registros.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Products -->
<div class="modal fade" id="user-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="user_form" action="{{ route('add-user') }}" method="post">
                    @csrf
                    <div class="form-divider">
                        <span class="content">Información personal</span>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="dni" class="col-3">Identificación</label>
                        <div class="col-6">
                            <input type="text" name="dni" id="dni" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="firstname" class="col-3">Nombres</label>
                        <div class="col">
                            <input type="text" name="firstname" id="firstname" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="lastname" class="col-3">Apellidos</label>
                        <div class="col">
                            <input type="text" name="lastname" id="lastname" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="phone" class="col-3">Telefono</label>
                        <div class="col-5">
                            <input type="phone" name="phone" id="phone" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="email" class="col-3">Correo</label>
                        <div class="col-5">
                            <input type="email" name="email" id="email" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-divider">
                        <span class="content">Información de cuenta</span>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="username" class="col-3">Usuario</label>
                        <div class="col-6">
                            <input type="text" name="username" id="username" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="role" class="col-3">Tipo</label>
                        <div class="col-5">
                            <select name="role" id="role" class="form-control">
                                <option value="Administrador">Administrador</option>
                                <option value="Cliente">Cliente</option>
                                <option value="Vendedor">Vendedor</option>
                                <option value="Vendedor">Repartidor</option>
                                <option value="Auditor">Auditor</option>
                            </select>
                        </div>
                    </div>
                    <div id="location-info" class="hidden">
                        <div class="form-divider">
                            <span class="content">Información de ubicación</span>
                        </div>
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
                    </div>
                    
                    <div class="form-group text-right mt-4">
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Disable -->
<div class="modal fade" id="disable-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deshabilitar cuenta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="confirm-msg">¿Está seguro/a que desea realizar esta acción?</p>
                <form action="{{ route('disable-user') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="disable_id">
                    <div class="form-group text-right mt-4">
                        <button type="submit" class="btn btn-primary mr-2">Confirmar</button>
                        <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Enable -->
<div class="modal fade" id="enable-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Habilitar cuenta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="confirm-msg">¿Está seguro/a que desea realizar esta acción?</p>
                <form action="{{ route('enable-user') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="enable_id">
                    <div class="form-group text-right mt-4">
                        <button type="submit" class="btn btn-primary mr-2">Confirmar</button>
                        <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Restore -->
<div class="modal fade" id="restore-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Restablecer contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="confirm-msg">¿Está seguro/a que desea realizar esta acción?</p>
                <form action="{{ route('restore-user') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="restore_id">
                    <div class="form-group text-right mt-4">
                        <button type="submit" class="btn btn-primary mr-2">Confirmar</button>
                        <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://api.mapbox.com/mapbox-gl-js/v1.3.2/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v1.3.2/mapbox-gl.css' rel='stylesheet' />

<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>

<!-- Map Scripts -->
<script>    
    mapboxgl.accessToken = 'pk.eyJ1Ijoic2FrZWkiLCJhIjoiY2sxYjdvbW5tMGxtMDNkcGZvN3NuOWV0ZiJ9.6fwPb6JHMxel4jN5qQfu0g';
    var map = new mapboxgl.Map({
        container: 'map',
        style: '/json/map/style.json',
        center: [-79.2, -4.005569],
        zoom: 12
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

<!-- View Scripts -->
<script>
    // 'onChange' listener
    $('#role').on('change', function(e){
        toggleMap();
    });

    // Reset users form
    $('#add_user').on('click', function(e){
        $('#user_form').trigger('reset');
        $('#user_form').attr('action', '{{ route("add-user") }}');
        $('#dni, #username, #role').removeAttr('readonly');

        toggleMap();

        map.setCenter([-79.2, -4.005569]);
        map.setZoom(12);
        marker.setLngLat([-79.2, -4.005569]);

        $('#method_form').remove();
    });

    // Show/Hide Map on form
    function toggleMap(){
        var role = $('#role').val();
        if(role == "Cliente" || role == "Repartidor" || role == "Vendedor"){
            $('#location-info').removeClass('hidden');
        }else{
            $('#location-info').addClass('hidden');
        }
    }
    
    function editUser(data){
        $('#dni, #username, #role').attr('readonly', '');

        $('#dni').val(data.user.dni);
        $('#firstname').val(data.user.firstname);
        $('#lastname').val(data.user.lastname);
        $('#phone').val(data.user.phone);
        $('#email').val(data.user.email);

        $('#username').val(data.account.username);
        $('#role').val(data.role.name);

        toggleMap();

        if(data.location){
            $('#city').val(data.location.city);
            $('#address').val(data.location.address);
            $('#longitude').val(data.location.longitude);
            $('#latitude').val(data.location.latitude);

            map.setCenter([data.location.longitude, data.location.latitude]);
            marker.setLngLat([data.location.longitude, data.location.latitude]);
            map.setZoom(15);
        }

        $('#user_form').prepend('<input id="method_form" type="hidden" name="_method" value="PUT">');
        $('#user_form').attr('action', '{{ route("edit-user") }}');
    }

    function setId(id, status){
        if(status)
            $('#disable_id').val(id);
        else
            $('#enable_id').val(id);
    }

    function setRestore(id){
        $('#restore_id').val(id);
    }
</script>
@endsection