@extends('layouts.app')

@section('content')
<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Listado de Productos</h2>        
    </div>
    <div class="col text-right">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#product-modal">Agregar producto</button>
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
</div>

<div class="row">
    <div class="col">
        <div class="row table-head">
            <div class="col-2"></div>
            <div class="col-4">Nombre del producto</div>
            <div class="col-2">Añadido el</div>
            <div class="col-2">Tipo</div>
            <div class="col-2">Precio</div>
        </div>
        <div class="row table-body">
            <div class="col">
                @foreach ($products as $product)
                <div class="row align-items-center">
                    <div class="col-2">
                        <a href="/products/view/{{ $product->external_id }}" class="btn btn-outline-primary btn-sm">Detalles</a>
                    </div>
                    <div class="col-4">
                        <span class="name truncate">{{ $product->name }}</span>
                    <span class="description truncate">{{ $product->description }}</span>
                    </div>
                    <div class="col-2">
                        {{ date("d/m/Y", strtotime($product->created_at)) }}
                    </div>
                    <div class="col-2">
                        {{ $product->type }}
                    </div>
                    <div class="col-2">
                        $ {{ $product->price }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal Products -->
<div class="modal fade" id="product-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add-product') }}" method="post">
                    @csrf
                    <div class="form-divider">
                        <span class="content">Información general</span>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="code" class="col-3">Código</label>
                        <div class="col-4">
                            <input type="text" name="code" id="code" class="form-control" value="{{ $token }}"  autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="name" class="col-3">Nombre</label>
                        <div class="col">
                            <input type="text" name="name" id="name" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="type" class="col-3">Tipo</label>
                        <div class="col">
                            <select name="type" id="type" class="form-control">
                                <option value="Alimentos">Alimentos</option>
                                <option value="Tecnología">Tecnología</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="category" class="col-3">Categoría</label>
                        <div class="col">
                            <select name="category" id="category" class="form-control">
                                <option value="Lácteos">Lácteos</option>
                                <option value="Frutas">Frutas</option>
                                <option value="Cereales">Cereales</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="price" class="col-3">Precio</label>
                        <div class="col-4">
                            <input type="text" name="price" id="price" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row align-items-center mb-4">
                        <label class="col-3">IVA</label>
                        <div class="col">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="iva" name="iva">
                                <label class="custom-control-label" for="iva">Este producto tiene iva</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-3">Descripción</label>
                        <div class="col">
                            <textarea class="form-control" id="description" name="description" rows="3" autocomplete="off"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="size" class="col-3">Tamaños</label>
                        <div class="col">
                            <input type="text" name="size" id="size" class="form-control" autocomplete="off">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Separados por ",". Ejemplo: Grande, Mediano, Pequeño
                            </small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="color" class="col-3">Presentación</label>
                        <div class="col">
                            <input type="text" name="color" id="color" class="form-control" autocomplete="off">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Separados por ",". Ejemplo: Azul, Rojo, Verde
                            </small>
                        </div>
                    </div>
                    <div class="form-group row align-items-center mb-4">
                        <label class="col-3">Expiración</label>
                        <div class="col">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="expires" name="expires">
                                <label class="custom-control-label" for="expires">Este producto expira</label>
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
@endsection