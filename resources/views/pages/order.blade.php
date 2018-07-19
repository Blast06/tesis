@component('component.main')

    @component('component.card')
        @slot('header')
            <h3 class="text-center">Mis Ordenes</h3>
        @endslot

        <user-order :orders="{{ json_encode($orders) }}">
        </user-order>
    @endcomponent

@endcomponent