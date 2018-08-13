@component('component.main')

    @component('component.card')

        @include('partials._alert')

        @slot('header')
            <h5 class="text-center font-weight-bold">Mis facturas</h5>
        @endslot

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Fecha de la suscripción</th>
                <th>Coste de la suscripción</th>
                <th>Cupon</th>
                <th>Descargar factura</th>
            </tr>
            </thead>
            <tbody>
             @foreach($invoices as $invoice)
                 <tr>
                     <td>{{ $invoice->date()->format('d/m/Y') }}</td>
                     <td>{{ $invoice->total() }}</td>
                     @if($invoice->hasDiscount())
                         <td>Cupon: {{ $invoice->coupon() }} / {{ $invoice->discount() }}</td>
                         @else
                         <td>No utilizaste ningun cupon</td>
                     @endif
                     <td><a class="btn btn-primary" href="{{ route('subscription.invoice.download', $invoice->id) }}">Descargar</a></td>
                 </tr>
             @endforeach
            </tbody>
        </table>

    @endcomponent

@endcomponent