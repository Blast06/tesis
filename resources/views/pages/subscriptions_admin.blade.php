@component('component.main')

    @component('component.card')

        @include('partials._alert')

        @slot('header')
            <h5 class="text-center font-weight-bold">Actualizar Suscripción</h5>
        @endslot

        @if(! $subscription->ends_at)
        <table class="table table-borderless">
            <tbody>
            <tr>
                <th>Comunidad</th>
                <th>Gratis</th>
                <th>
                    @include('partials._subscription_admin_button', ['stripe_plan' => 'comunidad'])
                </th>
            </tr>

            <tr>
                <th>Esencial</th>
                <th>$25/Mes</th>
                <th>
                    @include('partials._subscription_admin_button', ['stripe_plan' => 'esencial'])
                </th>
            </tr>

            <tr>
                <th>Premium</th>
                <th>$75/Mes</th>
                <th>
                    @include('partials._subscription_admin_button', ['stripe_plan' => 'premium'])
                </th>
            </tr>

            <tr>
                <th>Plus</th>
                <th>$100/Mes</th>
                <th>
                    @include('partials._subscription_admin_button', ['stripe_plan' => 'plus'])
                </th>
            </tr>
            </tbody>
        </table>

        <form action="{{ route('subscription.cancel') }}" method="POST">
            @csrf
            <input type="hidden" name="plan" value="{{ $subscription->name }}">
            <button class="btn btn-danger">Cancelar Suscripción</button>
        </form>
            @else
            <p>
                Los beneficios de su suscripción <span class="text-capitalize font-weight-bold">{{ $subscription->stripe_plan }}</span> continuarán hasta que finalice su período de facturación actual
                <span class="font-weight-bold">{{ $subscription->ends_at->format('d/m/Y') }}</span>. Puede reanudar su suscripción sin costo adicional hasta el final del período de facturación
            </p>
            <form action="{{ route('subscription.resume') }}" method="POST">
                @csrf
                <input type="hidden" name="plan" value="{{ $subscription->name }}">
                <button class="btn btn-success" {{ auth()->user()->subscribed('main') ? '' : 'disabled' }}>Reanudar Suscripción</button>
            </form>
        @endif
    @endcomponent

@endcomponent