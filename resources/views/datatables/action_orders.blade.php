@if($order->status === \App\Order::STATUS_WAIT || $order->status === \App\Order::STATUS_CURRENT)
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        Acciones
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('client.orders.edit', ['website' => request()->website, 'order' => $order]) }}"><i class="fas fa-edit"> Procesar</i></a>
    </div>
@endif