@extends('layouts.app')

@section('content')
<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Listado de Usuarios</h2>        
    </div>
    <div class="col text-right">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#user-modal">Añadir Usuario</button>
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
                <input type="text" name="search" id="search" class="form-control" placeholder="Buscar" autocomplete="off">
                <i class="fas fa-search"></i>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="row table-head">
            <div class="col-2"></div>
            <div class="col-4">Información</div>
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
                                <a class="dropdown-item" href="#">Editar</a>
                                <a class="dropdown-item" href="#">Desactivar</a>
                                <a class="dropdown-item" href="#">Añadir Cuenta</a>
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
                        {{ $user->account->username }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal Products -->
<div class="modal fade" id="user-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-tag">Usuarios</h6>
                <h5 class="modal-title">Añadir Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add-user') }}" method="post">
                    @csrf
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
                    <div class="form-group row align-items-center">
                        <label for="role" class="col-3">Tipo</label>
                        <div class="col-5">
                            <select name="role" id="role" class="form-control">
                                <option value="Cliente">Cliente</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Vendedor">Vendedor</option>
                                <option value="Auditor">Auditor</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="username" class="col-3">Usuario</label>
                        <div class="col-6">
                            <input type="text" name="username" id="username" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div id="location-info" style="display: none;">
                        <div class="form-group row align-items-center">
                            <label for="city" class="col-3">Ciudad</label>
                            <div class="col-5">
                                <input type="text" name="city" id="city" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-3">Dirección</label>
                            <div class="col">
                                <textarea class="form-control" id="address" name="address" rows="3" autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <div class="col-3"></div>
                            <div class="col">
                                <div id="map" style="height: 200px; width:100%;"></div>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label class="col-3">Coordenadas</label>
                            <div class="col">
                                <input type="text" name="latitude" id="latitude" class="form-control" autocomplete="off" readonly placeholder="Latitud">
                            </div>
                            <div class="col">
                                <input type="text" name="longitude" id="longitude" class="form-control" autocomplete="off" readonly placeholder="Longitud">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Note: This example requires that you consent to location sharing when
    // prompted by your browser. If you see the error "The Geolocation service
    // failed.", it means you probably did not give permission for the browser to
    // locate you.
    var map, infoWindow;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 6
        });
        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            infoWindow.open(map);
            map.setCenter(pos);
        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
        } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
        }
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                            'Error: The Geolocation service failed.' :
                            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoGEMESPDJ3JKuxJpvpRHX3ppcF6g_7P4&callback=initMap"></script>
@endsection