@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2 class="section-title">Nuevo Producto</h2>
    </div>
</div>
<div class="row">
    <div class="col">
        <form action="" method="post">
            <div class="form-row">
                <div class="col">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="col">
                    <label for="description">Descripción</label>
                    <input type="text" name="description" id="description" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label for="price">Precio</label>
                    <input type="text" name="price" id="price" class="form-control">
                </div>
                <div class="col">
                    <label for="iva">IVA</label>
                    <select name="iva" id="iva" class="form-control">
                        <option value="true">Si</option>
                        <option value="false">No</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection