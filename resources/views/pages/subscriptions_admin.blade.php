@component('component.main')

    @component('component.card')

        @include('partials._alert')

        @slot('header')
            <h5 class="text-center font-weight-bold">Mis Suscripciones</h5>
        @endslot
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Plan</th>
                <th>ID Suscripcion</th>
                <th>Cantidad</th>
                <th>Alta</th>
                <th>Finaliza en</th>
                <th>Cancelar</th>
            </tr>
            </thead>
            <tbody>
                @forelse($subscriptions as $subscription)
                    <td>{{ $subscription->id }}</td>
                    <td>{{ $subscription->name }}</td>
                    <td>{{ $subscription->stripe_plan }}</td>
                    <td>{{ $subscription->stripe_id }}</td>
                    <td>{{ $subscription->quantity }}</td>
                    <td>{{ $subscription->created_at->format('d/m/Y') }}</td>
                    <td>{{ $subscription->ends_at ? $subscription->ends_at->format('d/m/Y') : 'Suscripcion activa' }}</td>
                    <td>
                        @if($subscription->ends_at)
                            <form action="{{ route('subscription.resume') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan" value="{{ $subscription->name }}">
                                <button class="btn btn-success">Reanudar</button>
                            </form>
                        @else
                            <form action="{{ route('subscription.cancel') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan" value="{{ $subscription->name }}">
                                <button class="btn btn-danger">Cancelar</button>
                            </form>
                        @endif
                    </td>
                @empty
                    <td colspan="8">
                        No hay ninguna suscripcion disponible
                    </td>
                @endforelse
            </tbody>
        </table>
    @endcomponent

@endcomponent