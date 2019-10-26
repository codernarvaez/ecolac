@extends('layouts.app')

@section('content')
<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Listado de Ventas</h2>        
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
            <div class="col-2">Acciones</div>
            <div class="col-2">Codigo</div>
            <div class="col-3">Cliente</div>
            <div class="col-3">Metodo de Pago</div>
            <div class="col-2">Estado</div>
        </div>
        <div class="row table-body">
            <div class="col">
                @foreach ($sales as $sale)
                <div class="row align-items-center">
                    <div class="col-2">
                        @if (!$sale->paid)
                        <a href="#" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#paid-modal" onclick="setExternal('{{ $sale->external_id }}')">Fijar como pagada</a>      
                        @else
                        (Ninguna)
                        @endif                        
                    </div>
                    <div class="col-2">#{{ $sale->code }}</div>
                    <div class="col-3">{{ $sale->client->firstname .' '. $sale->client->lastname }}</div>
                    <div class="col-3">{{ $sale->payment_method }}</div>
                    <div class="col-2">{{ ($sale->paid) ? 'Pagada':'No Pagada' }}</div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="row table-footer align-items-center">
            <div class="col-8">
                @php
                    $pages = ceil($count / 20);
                    $n_pages = $pages - $p;
                @endphp  

                @if ($pages > 1)
                    <nav aria-label="Page navigation example">                        
                        <ul class="pagination mb-0">
                            @if ($p != 1)
                            <li class="page-item prev">
                                <a class="page-link" href="{{ route('sales', ['p' => $p - 1 ]) }}" aria-label="Anterior">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            
                            @if ($pages > 5)
                            <li class="page-item">
                                <a class="page-link" href="{{ route('sales', ['p' => 1 ]) }}">1</a>
                            </li>
                            <li class="page-item">
                                <span>...</span>
                            </li>
                            @endif
                            
                            @endif 

                            @if ($n_pages >= 5)
                                @for ($i = $p; $i <= $p + 4; $i++)
                                <li class="page-item {{ ($i == $p) ? 'active':'' }}" {{ ($i == $p) ? 'aria-current="page"':'' }}><a class="page-link" href="{{ route('sales', ['p' => $i ]) }}">{{ $i }}</a></li>
                                @endfor                             
                            @else
                                @if ($pages > 5)
                                    @for ($i = $pages - 5; $i <= $pages; $i++)
                                    <li class="page-item {{ ($i == $p) ? 'active':'' }}" {{ ($i == $p) ? 'aria-current="page"':'' }}><a class="page-link" href="{{ route('sales', ['p' => $i ]) }}">{{ $i }}</a></li>
                                    @endfor    
                                @else
                                    @for ($i = 1; $i <= $pages; $i++)
                                    <li class="page-item {{ ($i == $p) ? 'active':'' }}" {{ ($i == $p) ? 'aria-current="page"':'' }}><a class="page-link" href="{{ route('sales', ['p' => $i ]) }}">{{ $i }}</a></li>
                                    @endfor 
                                @endif
                                                            
                            @endif                            
                            
                            @if ($p != $pages)

                            @if ($pages > 5 && $n_pages > 4)
                            <li class="page-item">
                                <span>...</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="{{ route('sales', ['p' => $pages ]) }}">{{ $pages }}</a>
                            </li>  
                            @endif
                            
                            <li class="page-item next">
                                <a class="page-link" href="{{ route('sales', ['p' => $p + 1 ]) }}" aria-label="Siguiente">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li> 
                            @endif
                            
                        </ul>
                    </nav>         
                @endif
            </div>
            <div class="col-4">
                <p class="viewing">Viendo {{ ($p > 1) ? ((count($sales) == 20) ? ($p * 20): $count): count($sales) }} de {{ $count }} registros.</p>
            </div>
        </div>
    </div>
</div>
<!-- Modal Cancel -->
<div class="modal fade" id="paid-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Marcar como pagado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="confirm-msg">¿Está seguro/a que desea realizar esta acción?</p>
                <form action="{{ route('paid-sale') }}" method="POST">
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