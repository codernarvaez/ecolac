@extends('layouts.app')

@section('content')
<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Nuevo Pedido</h2>        
    </div>
    <div class="col text-right">
        <a href="{{ route('orders') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-left"></i>Regresar</a>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="divider-line"></div>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <div class="card-box">
            <h6 class="card-title">Listado de Productos</h6>
            <div class="card-box-body">
                <div id="product_list" class="product-list">
                    <ul class="list-unstyled mb-0">
                        <!-- !!! -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var page = 1;
    $.ajax({
        url: "{{ route('product-list') }}",
        type: 'GET',
        dataType: 'json',
        success: function(data, status){
            console.log(data, status);
            var html = '';
            data.products.forEach(product => {
                html+= `<li>
                            <span class="code">${ product.code }</span>
                            <span class="name">${ product.name }</span>
                            <span class="price">$ ${ product.price }</span>
                        </li>`;
            });
            $('#product_list ul').html(html);        
        }, error: function (jqXHR, status, error) {
            console.log(status, error)
        }
    });
</script>
@endsection