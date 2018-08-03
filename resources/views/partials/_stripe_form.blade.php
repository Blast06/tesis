<form action="{{ route('subscription.process') }}" method="POST">
    @csrf
    <input
        class="form-control"
        name="coupon"
        placeholder="¿Tienes un cupón?"
    >
    <input type="hidden" name="type" value="{{ $product['type'] }}">
    <hr>
    <stripe-form
            stripe_key="{{ env('STRIPE_KEY') }}"
            name="{{ $product['name'] }}"
            amount="{{ $product['amount'] }}"
            description="{{ $product['description'] }}"
            id="{{ $product['id'] }}"
            form_id="{{ $product['form_id'] }}"
    ></stripe-form>
</form>