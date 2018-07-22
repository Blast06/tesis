@component('component.main')
    <div class="row">

        <div class="col-md-3 sidebar">
            @include('client._sidebar')
        </div>

        <div class="col-md-9">

            @include('partials._alert')

            {{ Breadcrumbs::render('edit-order', $website, $order) }}

            @component('component.card')

                @slot('card_style', 'shadow-sm mb-5')

                @slot('header')
                    <h6 class="font-weight-bold text-center">Editar: {{ "No. {$order->id}" }}</h6>
                @endslot

                @slot('header_style', 'bg-white font-weight-bold')

                @slot('body_style', 'bg-light')

                <client-order
                        :website="{{ json_encode($website) }}"
                        :order="{{ json_encode($order) }}">
                </client-order>

            @endcomponent

        </div>
    </div>
@endcomponent
