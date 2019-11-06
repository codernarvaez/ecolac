@extends('app.config.main')

@section('subcontent')
<form action="{{ route('set-config-email') }}" method="POST">
    @csrf
    <div class="text-divider mb-4">
        <span class="content">Datos para el envío de Emails</span>
    </div>
    <div class="form-group row align-items-center">
        <label for="name" class="col-3 mb-0">Nombre:</label>
        <div class="col-9">
            <input type="text" name="name" id="name" class="form-control" autocomplete="off" value="{{ config('mail.from.name') }}">
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label for="dni" class="col-3 mb-0">Email:</label>
        <div class="col-9">
            <input type="text" name="email" id="email" class="form-control" autocomplete="off" value="{{ config('mail.from.address') }}">
        </div>
    </div>
    <div class="form-group text-right mt-4">
        <button type="submit" class="btn btn-primary mr-2">Guardar cambios</button>
    </div>
</form>
@endsection