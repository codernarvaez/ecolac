@extends('app.config.main')

@section('subcontent')
<form class="custom_form" id="general_info_form" action="{{ route('edit-auth-user') }}" method="post">
    @csrf
    <div class="text-divider mb-4">
        <span class="content">Información de Usuario</span>
    </div>
    <div class="form-group row align-items-center">
        <label for="dni" class="col-3">Identificación:</label>
        <div class="col-6">
            <input type="text" name="dni" id="account_dni" class="form-control" autocomplete="off" value="{{ Auth::user()->person->dni }}" readonly>
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label for="firstname" class="col-3">Nombres:</label>
        <div class="col">
            <input type="text" name="firstname" id="account_firstname" class="form-control" autocomplete="off" value="{{ Auth::user()->person->firstname }}">
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label for="lastname" class="col-3">Apellidos:</label>
        <div class="col">
            <input type="text" name="lastname" id="account_lastname" class="form-control" autocomplete="off" value="{{ Auth::user()->person->lastname }}">
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label for="phone" class="col-3">Telefono:</label>
        <div class="col-5">
            <input type="phone" name="phone" id="account_phone" class="form-control" autocomplete="off" value="{{ Auth::user()->person->phone }}">
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label for="email" class="col-3">Correo:</label>
        <div class="col-5">
            <input type="email" name="email" id="account_email" class="form-control" autocomplete="off" value="{{ Auth::user()->person->email }}">
        </div>
    </div>                       
    <div class="form-group text-right mt-4">
        <button type="submit" class="btn btn-primary mr-2">Guardar cambios</button>
    </div>
</form>
<form id="account_info_form" action="{{ route('edit-pass-user') }}" method="post">
    @csrf
    <div class="text-divider mb-4">
        <span class="content">Información de Cuenta</span>
    </div>
    <div class="form-group row align-items-center">
        <label for="username" class="col-3">Usuario:</label>
        <div class="col-5">
            <input type="text" name="username" id="account_username" class="form-control" autocomplete="off" value="{{ Auth::user()->username }}" readonly>
        </div>
    </div>   
    <div class="form-group row align-items-center">
        <label for="account_old_password" class="col-3">Contraseña Actual:</label>
        <div class="col-6">
            <input type="password" name="password" id="account_old_password" class="form-control">
        </div>
    </div> 
    <div class="form-group row align-items-center">
        <label for="account_new_password" class="col-3">Contraseña Nueva:</label>
        <div class="col-6">
            <input type="password" name="new_password" id="account_new_password" class="form-control">
        </div>
    </div>                       
    <div class="form-group text-right mt-4">
        <button type="submit" class="btn btn-primary mr-2">Guardar cambios</button>
    </div>
</form>
@if (Auth::user()->person->role->name == "Cliente" || Auth::user()->person->role->name == "Repartidor" || Auth::user()->person->role->name == "Vendedor")
<form id="location_info_form" action="{{ route('edit-location-user') }}" method="post">
    @csrf
    <div class="text-divider mb-4">
        <span class="content">Información de Ubicación</span>
    </div>
    <div class="form-group row">
        <label for="city" class="col-3">Ubicación:</label>
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
@endsection