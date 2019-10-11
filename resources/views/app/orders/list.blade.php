@extends('layouts.app')

@section('content')
<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Listado de Pedidos</h2>        
    </div>
    <div class="col text-right">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#order-modal">Añadir Pedido</button>
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
            <div class="col-2">Añadido el</div>
            <div class="col-2">Modificado el</div>
            <div class="col-2">Tipo</div>
            <div class="col-2">Estado</div>
        </div>
    </div>
</div>

<!-- Modal Order -->
<div class="modal fade" id="order-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-tag">Pedidos</h6>
                <h5 class="modal-title">Nuevo Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    <div class="form-group row align-items-center">
                        <label for="code" class="col-3">Código</label>
                        <div class="col-4">
                            <input type="text" name="code" id="code" class="form-control" value="{{ $token }}"  autocomplete="off" readonly>
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