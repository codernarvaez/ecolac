@extends('layouts.app')

@section('content')
<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Información</h2>        
    </div>
    <div class="col text-right">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#product-modal">Editar producto</button>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="divider-line"></div>
    </div>
</div>

<div id="product-details" class="row mb-5">
    <div class="col-9 mb-4">
        <h4 class="product-name">{{ $product->name }}</h4>
        <p class="product-description mb-0">{{ $product->description }}</p>
    </div>
    <div class="col-3 mb-4 text-right">
        <span class="price-tag">Precio</span>
        <span class="price">$ {{ number_format((float)$product->price, 2, '.', '') }}</span>
    </div>
    <div class="col-6">
        <div class="row align-items-center feature-box mr-2">
            <div class="col-8">
                <span class="feature-title mb-0">Detalles</span> 
            </div>    
            <div class="col-4 text-right">
                <a href="#" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#detail-modal">Añadir</a>
            </div>
            <div class="col-12 mt-4">
                <ul>
                    @foreach ($product->details as $detail)
                    <li>{{ $detail->description }}</li>
                    @endforeach                    
                </ul>
                @if (count($product->details) == 0)
                    <p class="empty-list">(No hay detalles para este producto)</p>
                @endif
            </div>
        </div>         
    </div>
    <div class="col-6">
        <div class="row feature-box">    
            <div class="col-12">
                <span class="feature-title">Características</span>    
            </div>        
            <div class="col-4">
                <div class="feature">
                    <span class="feature-tag">IVA: </span> {{ ($product->iva) ? 'Si':'No' }}
                </div>
            </div>
            <div class="col-8">
                <div class="feature">
                    <span class="feature-tag">Tipo: </span> {{ $product->type }}
                </div>
            </div>
            <div class="col-4">
                <div class="feature">
                    <span class="feature-tag">Expira: </span> {{ ($product->expires) ? 'Si':'No' }}
                </div>
            </div>
            <div class="col-8">
                <div class="feature">
                    <span class="feature-tag">Categoria: </span> {{ $product->category }}
                </div>
            </div>
            <div class="col-12">
                <div class="feature">
                    <span class="feature-tag">F. Creación: </span> {{ date("d/m/Y", strtotime($product->created_at)) }}
                </div>
            </div>
            <div class="col-12">
                <div class="feature">
                    <span class="feature-tag">F. Modificación: </span> {{ date("d/m/Y", strtotime($product->updated_at)) }}
                </div>
            </div>
            <div class="col-12">
                <div class="feature">
                    <span class="feature-tag">Tamaños: </span>
                    @if ($product->size)
                        @foreach ($product->size as $size)
                            <span class="bordered-tag">{{ $size }}</span>
                        @endforeach
                    @else
                        (Ninguno)
                    @endif
                </div>
            </div>
            <div class="col-12">
                <div class="feature">
                    <span class="feature-tag">Presentación: </span>
                    @if ($product->presentation)
                        @foreach ($product->presentation as $presentation)
                            <span class="bordered-tag">{{ $presentation }}</span>
                        @endforeach
                    @else
                        (Ninguno)
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Imágenes</h2>        
    </div>
    <div class="col text-right">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-image-modal">Añadir imagen</button>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="divider-line"></div>
    </div>
</div>

@if (count($product->images) == 0)
<div class="row">
    <div class="col">
        <p class="empty-list">No se han añadido imágenes para este producto.</p>
    </div>
</div>
@endif

<div id="carousel" class="owl-carousel images_carousel mb-5">
    @foreach ($product->images as $image)
    <div class="item">
        <img src="/storage/{{ $image->path }}" alt="Imagen del Product">
        <a href="#" class="delete_image" data-toggle="modal" data-target="#delete-image" onclick="deleteImage({{ $image->id_image }})"><i class="fas fa-times-circle"></i></a>
    </div>
    @endforeach    
</div>

<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Lotes</h2>        
    </div>
    <div class="col text-right">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#lot-modal">Añadir lote</button>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="divider-line"></div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="row table-head">
            <div class="col-2"></div>
            <div class="col-3">{{ ($product->expires) ? 'F. Elaboración':'Añadido el' }}</div>
            <div class="col-3">{{ ($product->expires) ? 'F. Expiración':'Modificado el' }}</div>
            <div class="col-2">Cantidad</div>
            <div class="col-2">Estado</div>
        </div>
        <div class="row table-body">
            <div class="col-12">
                @foreach ($product->lots as $lot)
                <div class="row align-items-center">
                    <div class="col-2">
                        <a href="#" class="btn btn-outline-primary btn-sm">Deshabilitar</a>
                    </div>
                    <div class="col-3">
                        {{ ($product->expires) ? date("d/m/Y", strtotime($lot->elaboration)):date("d/m/Y", strtotime($lot->created_at)) }}
                    </div>
                    <div class="col-3">
                        {{ ($product->expires) ? date("d/m/Y", strtotime($lot->expiry)):date("d/m/Y", strtotime($lot->updated_at)) }}
                    </div>
                    <div class="col-2">
                        {{ $lot->quantity }} uni.
                    </div>
                    <div class="col-2">
                        {{ ($lot->state) ? 'Activo':'Inactivo' }}
                    </div>
                </div>
                @endforeach                
            </div>
            <div class="col-12">
                @if (count($product->lots) == 0)
                <p class="empty-list">(No hay lotes para este producto)</p> 
                @endif                
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detail-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Detalle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add-product-detail') }}" method="post">
                    @csrf
                    <input type="hidden" name="external" value="{{ $product->external_id }}">
                    <input type="hidden" name="product" value="{{ $product->id_product }}">

                    <div class="form-group row mb-4">
                        <label for="detail-description" class="col-3">Descripción</label>
                        <div class="col">
                            <textarea rows="3" name="description" id="detail-description" class="form-control" autocomplete="off"></textarea>
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

<!-- Modal Products -->
<div class="modal fade" id="product-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-tag">Productos</h6>
                <h5 class="modal-title">Nuevo Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('edit-product') }}" method="post">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="external_id" value="{{ $product->external_id }}">
                    <div class="form-group row align-items-center">
                        <label for="name" class="col-3">Nombre</label>
                        <div class="col">
                            <input type="text" name="name" id="name" class="form-control" autocomplete="off" value="{{ $product->name }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="type" class="col-3">Tipo</label>
                        <div class="col">
                            <select name="type" id="type" class="form-control">
                                <option value="Tecnología" {{ ($product->type == "Tecnología") ? 'selected':'' }}>Tecnología</option>
                                <option value="Alimentos" {{ ($product->type == "Alimentos") ? 'selected':'' }}>Alimentos</option>
                                <option value="Ropa" {{ ($product->type == "Ropa") ? 'selected':'' }}>Ropa</option>
                                <option value="Inmuebles" {{ ($product->type == "Inmuebles") ? 'selected':'' }}>Inmuebles</option>
                                <option value="Decoración" {{ ($product->type == "Decoración") ? 'selected':'' }}>Decoración</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="price" class="col-3">Precio</label>
                        <div class="col-4">
                            <input type="text" name="price" id="price" class="form-control" autocomplete="off" value="{{ $product->price }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="iva" class="col-3">IVA</label>
                        <div class="col-4">
                            <select name="iva" id="iva" class="form-control">
                                <option value="0" {{ ($product->iva == 0) ? 'selected':'' }}>0 %</option>
                                <option value="0.12" {{ ($product->iva == 0.12) ? 'selected':'' }}>12 %</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-3">Descripción</label>
                        <div class="col">
                            <textarea class="form-control" id="description" name="description" rows="3" autocomplete="off">{{ $product->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        @php
                            $size = '';
                            if ($product->size) {
                                foreach ($product->size as $item) {
                                    $size = $size . trim($item) . ", ";
                                }
                                $size = substr($size, 0, -2);
                            }
                        @endphp
                        <label for="size" class="col-3">Tamaños</label>
                        <div class="col">
                            <input type="text" name="size" id="size" class="form-control" autocomplete="off" value="{{ $size }}">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Separados por ",". Ejemplo: Grande, Mediano, Pequeño
                            </small>
                        </div>
                    </div>
                    <div class="form-group row">
                        @php
                            $presentation = '';
                            if ($product->presentation) {
                                foreach ($product->presentation as $item) {
                                    $presentation = $presentation . trim($item) . ", ";
                                }
                                $presentation = substr($presentation, 0, -2);
                            }
                        @endphp
                        <label for="presentation" class="col-3">Presentación</label>
                        <div class="col">
                            <input type="text" name="presentation" id="presentation" class="form-control" autocomplete="off" value="{{ $presentation }}">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Separados por ",". Ejemplo: Botella, Caja, Funda
                            </small>
                        </div>
                    </div>
                    <div class="form-group row align-items-center mb-4">
                        <label for="color" class="col-3">Expiración</label>
                        <div class="col">
                            <div class="custom-control custom-checkbox">                                
                                <input type="checkbox" class="custom-control-input" id="expires" name="expires" {{ ($product->expires == 1)? 'checked':'' }}>
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

<!-- Modal Lot -->
<div class="modal fade" id="lot-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Lote</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add-product-lot') }}" method="post">
                    @csrf
                    <input type="hidden" name="external" value="{{ $product->external_id }}">
                    <input type="hidden" name="product" value="{{ $product->id_product }}">
                    <input type="hidden" name="expires" value="{{ $product->expires }}">

                    @if ($product->expires)
                    <div class="form-group row align-items-center">
                        <label for="elaboration" class="col-3">F. elaboración</label>
                        <div class="col-9">
                            <input type="date" name="elaboration" id="elaboration" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="expiry" class="col-3">F. expiración</label>
                        <div class="col-9">
                            <input type="date" name="expiry" id="expiry" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    @endif
                    
                    <div class="form-group row align-items-center mb-4">
                        <label for="quantity" class="col-3">Cantidad</label>
                        <div class="col-9">
                            <input type="number" name="quantity" id="quantity" class="form-control" autocomplete="off">
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

<!-- Modal Image -->
<div class="modal fade" id="add-image-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Imagen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add-product-image') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="external" value="{{ $product->external_id }}">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="product_image" accept="image/*">
                        <label class="custom-file-label text-left" for="customFile" style="padding-left: 15px;margin-left: 20px;">Seleccionar Archivo</label>
                    </div>
                    <div class="form-group text-right mt-4">
                        <button type="submit" class="btn btn-primary mr-2">Cargar Imagen</button>
                        <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="delete-image" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar imagen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="confirm-msg">¿Está seguro/a que desea realizar esta acción?</p>
                <form action="{{ route('delete-image') }}" method="POST">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="id_image" id="id_image">
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
<script src="/js/owl.carousel.min.js"></script>
<script>
$('#carousel').owlCarousel({
    margin: 20,
    autoWidth: true,
    items: 3
});

function deleteImage(id){
    $('#id_image').val(id);   
}
</script>
@endsection