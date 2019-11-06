<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/fonts.css">
    <link rel="stylesheet" href="/css/icons.min.css">
    <link rel="stylesheet" href="/css/register.css">
    <title>Registro | Online Shop</title>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <img src="/img/logo.png" alt="EcolacShop">
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-8">
                <div class="login-box">
                    <div class="login-form">
                        <div class="login-header">
                            <h2>Formulario de registro</h2>
                            <p class="sub mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare semper tempor.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 text-right">
                <span class="text-login mr-2">¿Ya tienes cuenta?</span>
                <a href="/login" class="btn btn-primary btn-login">Inicia sesión</a>
            </div>
        </div> 
        <form method="POST" action="{{ route('register-user') }}">
            <div class="row mb-4">    
                <div class="col-12">
                    @if (session('error'))
                    <div class="alert alert-danger text-center mb-5" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif
                </div>        
                <div class="col-6">
                    @csrf
                    <input type="hidden" name="role" value="Cliente">
                    <div class="form-group">
                        <div class="form-row align-items-center">
                            <label for="dni" class="col-3 mb-0">Identificación:</label>
                            <div class="col-6">
                                <input type="text" name="dni" id="dni" class="form-control" value="{{ old('dni') }}" autocomplete="off" placeholder="Ingrese su identificación">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row align-items-center">
                            <label for="firstname" class="col-3 mb-0">Nombres:</label>
                            <div class="col-9">
                                <input type="text" name="firstname" id="firstname" class="form-control" value="{{ old('firstname') }}" autocomplete="off" placeholder="Ingrese sus nombres">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row align-items-center">
                            <label for="lastname" class="col-3 mb-0">Apellidos:</label>
                            <div class="col-9">
                                <input type="text" name="lastname" id="lastname" class="form-control" value="{{ old('lastname') }}" autocomplete="off" placeholder="Ingrese sus apellidos">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row align-items-center">
                            <label for="email" class="col-3">Email:</label>
                            <div class="col-9">
                                <input type="email" name="email" id="email" class="form-control" autocomplete="off" value="{{ old('email') }}" placeholder="Ingrese su email">
                            </div>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <div class="form-row align-items-center">
                            <label for="phone" class="col-3">Telefono:</label>
                            <div class="col-6">
                                <input type="phone" name="phone" id="phone" class="form-control" autocomplete="off" value="{{ old('phone') }}" placeholder="Ingrese su teléfono">
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="col-6">
                    <div class="form-group">
                        <div class="text-divider">
                            <span class="content">Información de Cuenta</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row align-items-center">
                            <label for="username" class="col-3 mb-0">Usuario:</label>
                            <div class="col-6">
                                <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" autocomplete="off" placeholder="Ingrese su Usuario">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row align-items-center">
                            <label for="password" class="col-3 mb-0">Contraseña:</label>
                            <div class="col-9">
                                <input type="password" name="password" id="password" class="form-control" autocomplete="off" placeholder="Ingrese su contraseña">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row align-items-center">
                            <label for="c_password" class="col-3 mb-0">Confirmar Contraseña:</label>
                            <div class="col-9">
                                <input type="password" name="c_password" id="c_password" class="form-control" autocomplete="off" placeholder="Confirme su contraseña">
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="row mb-2">
                <div class="col-12 mb-4">
                    <div class="text-divider">
                        <span class="content">Información de Ubicación</span>
                    </div>
                </div>  
                <div class="col-6">
                    <div class="form-group">
                        <div class="form-row">
                            <label class="col-3 mb-0">Ubicación:</label>
                            <div class="col-9">
                                <div id='map' style='width: 100%; height: 240px; border-radius: 5px;'></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <div class="form-row align-items-center">
                            <label for="city" class="col-3 mb-0">Ciudad:</label>
                            <div class="col-5">
                                <input type="text" name="city" id="city" class="form-control" autocomplete="off" readonly placeholder="Residencia">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <label for="address" class="col-3 mb-0">Dirección:</label>
                            <div class="col">
                                <textarea class="form-control" id="address" name="address" rows="3" autocomplete="off"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row align-items-center">
                            <label class="col-3 mb-0">Coordenadas:</label>
                            <div class="col">
                                <input type="text" name="longitude" id="longitude" class="form-control" autocomplete="off" readonly placeholder="Longitud">
                            </div>
                            <div class="col">
                                <input type="text" name="latitude" id="latitude" class="form-control" autocomplete="off" readonly placeholder="Latitud">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-12 mb-3">
                    <div class="text-divider">
                        <span class="content"></span>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <div class="form-group mb-2">
                        <button type="submit" class="btn btn-primary btn-lg">Registrarme Ahora</button>
                    </div>
                </div>
            </div>
        </form>  
        <div class="row">
            <div class="col">
                <footer>
                    <p class="text-center copyright">© Todos los derechos reservados.</p>
                </footer>
            </div>
        </div>           
    </div>
    

    <script src="/js/jquery.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

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
</body>
</html>