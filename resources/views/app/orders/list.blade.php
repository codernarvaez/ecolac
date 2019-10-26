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
                        @if ($order->state == "Pendiente")
                        <div class="dropdown">
                            <a class="btn btn-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>                            
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <button class="dropdown-item" data-toggle="modal" data-target="#cancel-modal" onclick="setExternal('{{ $order->external_id }}')">Cancelar</button>
                            </div>
                        </div>
                        <a href="{{  route('view-order', ["external" => $order->external_id ]) }}" class="btn btn-outline-primary btn-sm">Despachar</a>   
                        @else
                        <span style="font-style: italic;display: block; text-align:center;">(Solo lectura)</span>
                        @endif                        
                    </div>
                    <div class="col-2">#{{ $order->code }}</div>
                    <div class="col-4 truncate">{{ $order->client->firstname .' '. $order->client->lastname }}</div>
                    <div class="col-2">{{ date("d/m/Y", strtotime($order->created_at)) }}</div>
                    <div class="col-2"><span class="tag {{ ($order->state == "Cancelado") ? 'red':'' }}">{{ $order->state }}</span></div>
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

<!-- Modal Cancel -->
<div class="modal fade" id="cancel-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancelar pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="confirm-msg">¿Está seguro/a que desea realizar esta acción?</p>
                <form action="{{ route('cancel-order') }}" method="POST">
                    @csrf
                    <input type="hidden" name="external" id="external">
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
<script>
function setExternal(external){
    $('#external').val(external);    
}
</script>
@endsection