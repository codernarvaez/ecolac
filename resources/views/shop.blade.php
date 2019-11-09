<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">        
        <meta http-equiv="X-UA-Compatible" content="ie=edge">  
        <link rel="stylesheet" href="/css/animate.css">
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/fonts.css">
        <link rel="stylesheet" href="/css/icons.min.css">
        <link rel="stylesheet" href="/css/main.css">
        <title>Ecolac Store | Productos Lácteos</title>
    </head>
    <body>
        <header>
            <div class="container">
                <div class="row header-logo align-items-center">
                    <div class="col-4">
                        <img class="logo" src="/img/logo_2.png" alt="Ecolac" draggable="false">
                    </div>
                    <div class="col-8 text-right">
                        <ul class="list-inline mb-0">
                            @auth
                            <li class="list-inline-item mr-3">
                                <div class="dropdown messages">
                                    <a class="cart" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @if (!\Cart::isEmpty())
                                        <span class="not_empty"></span>
                                        @endif
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>                                    
                                    <div class="dropdown-menu dropdown-menu-right">
										<div class="drop-header">
											<span class="title">Carrito de compras</span>
										</div>
										<div id="body_products" class="drop-body">
                                            @foreach ($cart as $item)
                                            <div class="a" data-id="{{ $item->id }}">
										    	<div class="img">
										    		<img src="/storage/{{ $item->attributes->image }}" alt="User Avatar">
										    	</div>
										    	<div class="content">
											    	<h5 class="user">{{ $item->name }}</h5>
                                                    <p><small class="truncate">Precio: ${{ number_format((float)$item->price, 2, '.', '') }}, Cantidad: <i class="fas fa-minus" onclick="removeFromItem({{ $item->id }})"></i> <span class="qty">{{ $item->quantity }}</span> <i class="fas fa-plus" onclick="addToItem({{ $item->id }})"></i></small></p>
										    	</div>		
										    </div>  
                                            @endforeach		
                                            @if (\Cart::isEmpty())
                                                <div class="a">
                                                    <p class="empty mb-0 text-center">Carrito vacío</p>
                                                </div>
                                            @endif								    
                                        </div>
                                        <div class="drop-footer">
                                            <form action="{{ route('add-order-cart') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-block">Solicitar Pedido</button>
                                            </form>
                                        </div>										    
									</div>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="dropdown">
                                    <a class="user_box" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="far fa-user-circle"></i>
                                        <span class="name">{{ Auth::user()->person->firstname . ' ' . Auth::user()->person->lastname }}</span>
                                        <span class="email">{{ Auth::user()->person->email }}</span>
                                    </a>                                    
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">Mis pedidos</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <span class="content">Cerrar Sesión</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            @else
                            <li class="list-inline-item">
                                <a href="/login" class="btn btn-outline-light">Iniciar Sesión</a>
                            </li>
                            @endauth
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <h4 class="h_sub mb-0">Todo tipo de productos lácteos</h4>
                        <h2 class="h_title">De la mejor calidad posible</h2>
                    </div>
                </div>
            </div>            
        </header>
        <div class="boxes">
            <div class="container">
                <div class="row text-center">
                    <div class="col-4 box box_01">
                        <h5>Leche</h5>
                    </div>
                    <div class="col-4 box box_02">
                        <h5>Yogurt</h5>
                    </div>
                    <div class="col-4 box box_03">
                        <h5>Queso</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="products mb-5">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h5 class="mb-5">Nuestros Productos</h5>
                    </div>
                </div>
                <div class="row">
                    @foreach ($products as $product)
                    <div class="col-3">
                        <div class="product_box">
                            <div class="product_image" style="background-image: url(/storage/{{ $product->images[0]->path }});"></div>
                            <div class="product_details">
                                <span class="title">{{ $product->name }}</span>
                                <span class="price">$ {{ number_format((float)$product->price, 2, '.', '') }} c/u</span>
                                @if (Auth::user())
                                <a href="#" class="btn btn-outline-primary btn-sm _addtocart" onclick="addToCart({{ $product->id_product }})">Añadir al carrito</a>
                                @endif
                            </div>
                        </div>
                    </div>                        
                    @endforeach
                </div>
            </div>
        </div>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <img src="/img/logo_g.png" alt="Ecolac Store">
                        <p class="mb-0">© Todos los derechos reservados.</p>
                    </div>
                </div>
            </div>
        </footer>

        <script src="/js/jquery.min.js"></script>
        <script src="/js/popper.min.js"></script>
        <script src="/js/sweetalert2@9.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script>
            $('._addtocart').on('click',function(e){
                e.preventDefault();
            });
            
            function addToCart(item){
                $.ajax({
                    url: '{{ route("new-cart") }}',
                    method: 'POST',
                    dataType: 'json',
                    data: { "product": item },
                    success: function(data, status){
                        Swal.fire({
                            icon: 'success',
                            title: 'Hecho',
                            text: 'Producto añadido al carrito'
                        });
                        var html = '';
                        $.each(data, function(i, item){
                            html +=  `<div class="a" data-id="${ item.id }">
                                        <div class="img">
                                            <img src="/storage/${ item.attributes.image }" alt="User Avatar">
                                        </div>
                                        <div class="content">
                                            <h5 class="user">${ item.name }</h5>
                                            <p><small class="truncate">Precio: ${ parseFloat(item.price).toFixed(2) }, Cantidad: <i class="fas fa-minus" onclick="removeFromItem(${ item.id })"></i> <span class="qty">${ item.quantity }</span> <i class="fas fa-plus" onclick="addToItem(${ item.id })"></i></small></p>
                                        </div>		
                                    </div> `;
                        }) ;    
                        $('#body_products').html(html);                 
                    }, error: function(jqXHR, status, error){
                        Swal.fire({
                            icon: 'error',
                            title: 'Ups...',
                            text: 'Algo ha salido mal'
                        });                        
                    }
                });
            }
            
            function addToItem(item){
                $.ajax({
                    url: '{{ route("add-cart") }}',
                    method: 'POST',
                    dataType: 'json',
                    data: { "product": item },
                    success: function(data, status){
                        var obj = $('.a[data-id="'+ item +'"] .qty');
                        var qty = parseInt(obj.html());
                        obj.html(qty + 1);
                    },
                    error: function(jqXHR, status, error){
                        Swal.fire({
                            icon: 'error',
                            title: 'Ups...',
                            text: 'Algo ha salido mal'
                        });
                    }
                });
            }

            function removeFromItem(item){
                var obj = $('.a[data-id="'+ item +'"] .qty');
                var qty = parseInt(obj.html());

                if(qty > 1){
                    $.ajax({
                        url: '{{ route("remove-cart") }}',
                        method: 'POST',
                        dataType: 'json',
                        data: { "product": item },
                        success: function(data, status){
                            var obj = $('.a[data-id="'+ item +'"] .qty');
                            var qty = parseInt(obj.html());
                            obj.html(qty - 1);
                        },
                        error: function(jqXHR, status, error){
                            Swal.fire({
                                icon: 'error',
                                title: 'Ups...',
                                text: 'Algo ha salido mal'
                            });
                        }
                    });
                }
            }
            
        </script>
    </body>
</html>
