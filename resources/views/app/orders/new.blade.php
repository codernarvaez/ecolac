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
    <div class="col-12">        
        <div class="border-box mb-4">
            <div class="row">
                <div class="col">
                    <div class="form-group mb-0">
                        <div class="form-row align-items-center">
                            <div class="col-2">
                                <label for="customer" class="mb-0 c_label">Elegir Cliente:</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control c_control" id="autocomplete">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card-box">
            <h6 class="card-title">Listado de Productos</h6>
            <div class="card-box-body">
                <div id="product_list" class="product-list">
                    <form action="" method="post" class="form-search">
                        <div class="form-group mb-0">
                            <input type="text" name="search" id="search" class="form-control icon" placeholder="Buscar" autocomplete="off">
                            <i class="fas fa-search"></i>
                        </div>
                    </form>
                    <ul class="list-unstyled mb-0">
                        <!-- !!! -->
                    </ul>
                </div>
            </div>
            <div class="card-box-footer text-right">
                <a href="#" id="add_product" class="btn btn-primary btn-sm btn-block">Añadir Producto</a>
            </div>
        </div>        
    </div>
    <div class="col-8">
        <form action="{{ route('add-order') }}" method="post">
            @csrf
            <input type="hidden" name="customer" id="customer">
            <div class="card-box mb-4">
                <h6 class="card-title">Detalles del Pedido</h6>
                <input type="hidden" name="code" value="{{ $token }}">
                <div class="card-box-body">                
                    <table id="products_table" class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th style="width: 100px;">Cantidad</th>
                                <th class="text-center">Precio Unitario</th>
                                <th class="text-center">Precio Total</th>
                                <th class="text-center">A</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- !!! -->  
                        </tbody>
                    </table>
                    <p class="empty-list" id="empty">(No se han añadido productos)</p>
                </div>              
            </div>
            <div class="border-box mb-4">
                <div class="row align-items-center">
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <div class="form-row align-items-center">
                                <div class="col-3">
                                    <label for="observations" class="mb-0 c_label">Observaciones</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control c_control" name="observations" id="observations">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 text-right total_sec">
                        <span class="c_tag">Total: </span>
                        <span id="_total" class="total">$ <b>0.00</b></span>
                    </div>
                </div>
            </div>                
            <div class="row">
                <div class="col text-right">
                    <button type="submit" class="btn btn-primary btn-lg">Guardar Pedido</button>
                </div>
            </div>
        </form>  
    </div>
</div>
@endsection

@section('scripts')
<script>
    var current_page = 1;
    var pages = 1;
    var values = [];

    $.ajax({
        url: "{{ route('product-list') }}",
        type: 'GET',
        dataType: 'json',
        success: function(data, status){
            var html = '';
            data.products.forEach(product => {
                html+= `<li data-product="${ product.external_id }">
                            <span class="code">#${ product.code }</span>
                            <span class="name">${ product.name }</span>
                            <span class="price">$ ${ parseFloat(product.price).toFixed(2) }</span>
                        </li>`;
            });
            $('#product_list ul').html(html);
            
            clickedProduct();
            
            current_page = data.current_page;
            pages = data.pages;
        }, error: function (jqXHR, status, error) {
            console.log(status, error)
        }
    });

    function clickedProduct(){
        $('#product_list li').on('click', function(){
            if(!$(this).hasClass('active')){
                $('#product_list li.active').removeClass('active');
                $(this).addClass('active');
            }
        });
    }

    function changeValues(){
        $('#products_table tbody tr input').off();
        $('#products_table tbody tr .delete').off();

        $('#products_table tbody tr input').on('change', function(){
            var val = parseInt($(this).val());
            var unitObj = $(this).parent().parent().find('td:nth-child(3) span');
            var totalObj = $(this).parent().parent().find('td:nth-child(4) span');

            var product = $(this).parent().parent().attr('data-product');
            var max = parseInt($(this).parent().parent().attr('data-max'));

            var index = -1;  

            for (let i = 0; i < values.length; i++) {
                if(values[i].product == product){
                    index = i;
                    break;
                }             
            }

            if(val <= max){
                values[index].qty = val;
                totalObj.html(parseFloat(values[index].price * val).toFixed(2));  
            }else{
                $(this).val(max);
                totalObj.html(parseFloat(values[index].price * max).toFixed(2));  
            }
            
            setTotal();                    
        });

        $('#products_table tbody tr .delete').on('click', function(e){
            var product = $(this).parent().parent().attr('data-product');  
            var index = -1;  

            for (let i = 0; i < values.length; i++) {
                if(values[i].product == product){
                    index = i;
                    break;
                }             
            }

            if(index != -1){
                $(this).parent().parent().remove();            
                values.splice(index, 1);
            }

            if(values.length == 0){
                $('#empty').removeClass('hidden');
            }    
            
            setTotal();            
            
            e.preventDefault();
        });
    }

    function setTotal(){
        var total = 0;
        values.forEach(value => {
            total += (value.price * value.qty);       
        });
        $('#_total b').html(parseFloat(total).toFixed(2));
    }

    $('#add_product').on('click', function(e){
        var product = $('#product_list li.active').attr('data-product');

        if(product){
            $.ajax({
                url: "/products/ajax/get/" + product,
                type: 'GET',
                dataType: 'json',
                success: function(data, status){
                    var product = data.product;
                    var max = 0;

                    product.lots.forEach(lot => {
                        max += lot.quantity;
                    });
                    
                    var exists = $('#products_table tbody tr[data-product="'+ product.external_id +'"]').attr('data-product');

                    if(exists){
                        // An Alert
                    }else{
                        var row = ` <tr data-product="${ product.external_id }" data-max="${ max }">
                                        <td>${ product.name } <input type="hidden" name="id_product[]" value="${ product.id_product }"></td>
                                        <td><input type="number" name="quantity[]" id="quantity_${product.external_id}" class="form-control" value="1"></td>
                                        <td class="text-center">$ <span>${ parseFloat(product.price).toFixed(2) }</span></td>
                                        <td class="text-center">$ <span>${ parseFloat(product.price).toFixed(2) }</span></td>
                                        <td><a href="#" class="delete"><i class="far fa-trash-alt"></i></a></td>
                                    </tr>`;

                        $('#products_table tbody').append(row);
                        $('#product_list li.active').removeClass('active');
                        changeValues();

                        values.push({ product: product.external_id, price: product.price, qty: 1 });
                    }

                    $('#empty').addClass('hidden');               
                    
                    setTotal();                    
                }, error: function (jqXHR, status, error) {
                    console.log(status, error)
                }
            });
        }

        e.preventDefault();        
    });
</script>
<script src="/js/jquery.autocomplete.min.js"></script>
<script>
    $('#autocomplete').autocomplete({
        serviceUrl: '{{ route("list-customers") }}',
        paramName: 'searchString',
        onSelect: function (suggestion) {
            $('#customer').val(suggestion.data);        
        }
    });
</script>
@endsection