@extends('layouts.app')

@section('content')
<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Listado de Pedidos</h2>        
    </div>
    <div class="col text-right">
        <a href="{{ route('new-order') }}" class="btn btn-primary btn-sm">Añadir Pedido</a>
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
            <div class="col-2">Codigo</div>
            <div class="col-4">Cliente</div>
            <div class="col-2">Añadido el</div>
            <div class="col-2">Estado</div>
        </div>
        <div class="row table-body">
            <div class="col">
                @foreach ($orders as $order)
                <div class="row align-items-center">
                    <div class="col-2">
                        <div class="dropdown">
                            <a class="btn btn-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>                            
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <button class="dropdown-item" data-toggle="modal" data-target="#user-modal">Cancelar</button>
                                <button class="dropdown-item" data-toggle="modal" data-target="#disable-modal">Eliminar</button>
                            </div>
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-sm">Detalles</a>
                    </div>
                    <div class="col-2">{{ $order->code }}</div>
                    <div class="col-4 truncate">{{ $order->client->firstname. ' '. $order->client->lastname }}</div>
                    <div class="col-2">{{ date("d/m/Y", strtotime($order->created_at)) }}</div>
                    <div class="col-2">{{ ($order->state == "pending") ? 'Pendiente':'' }}</div>
                </div>
                @endforeach
                
                @if (count($orders) == 0)
                <div class="row align-items-center">
                    <div class="col-12">
                        <p class="empty">No se han encontrado elementos para esta lista.</p>
                    </div>
                </div>
                @endif                
            </div>
        </div>
    </div>
</div>

<!-- Modal Order -->
<div class="modal fade" id="order-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    <div class="form-divider">
                        <span class="content">Información general</span>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="code" class="col-3">Código</label>
                        <div class="col-4">
                            <input type="text" name="code" id="code" class="form-control" value=""  autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="type" class="col-3">Tipo</label>
                        <div class="col">
                            <select name="type" id="type" class="form-control">
                                <option value="Alimentos">Tipo I</option>
                                <option value="Tecnología">Tipo II</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="state" class="col-3">Estado</label>
                        <div class="col">
                            <select name="state" id="state" class="form-control">
                                <option value="pending">Pendiente</option>
                                <option value="in_process">En proceso</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="observations" class="col-3">Observaciones</label>
                        <div class="col">
                            <textarea class="form-control" id="observations" name="observations" rows="3" autocomplete="off"></textarea>
                        </div>
                    </div>
                    <div class="form-divider">
                        <span class="content">Detalle del pedido</span>
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