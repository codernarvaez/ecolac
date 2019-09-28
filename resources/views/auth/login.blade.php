<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/fonts.css">
    <link rel="stylesheet" href="/css/icons.min.css">
    <link rel="stylesheet" href="/css/login.css">
    <title>Login | Online Shop</title>
</head>
<body>
    <div class="container h-100">
        <div id="wrapper" class="row align-items-center justify-content-center h-100">
            <div class="col-4">
                <div class="login-box">
                    <div class="login-form">
                        <div class="login-header text-center">
                            <h2>Ingreso al sistema</h2>
                            <p class="sub mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare semper tempor.</p>
                        </div>
                        @if (session('status'))
                        <div class="alert alert-danger text-center" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="username"><i class="fas fa-user"></i></label>
                                <input type="text" name="username" id="username" class="form-control" value="{{ old('email') }}" autocomplete="off" placeholder="Usuario">
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="fas fa-lock"></i></label>
                                <input type="password" name="password" id="password" class="form-control" autocomplete="off" placeholder="Contraseña">
                            </div>
                            <div class="form-group mb-2">
                                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesion</button>
                            </div>
                        </form>
                        <p class="text-center mb-5"><small><a href="#" class="form-text text-muted">¿Olvidaste tu contraseña?</a></small></p>
                        <p class="text-center copyright">© Todos los derechos reservados.</p>
                    </div>
                </div>
            </div>
        </div>            
    </div>

    <script src="/js/jquery.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</body>
</html>