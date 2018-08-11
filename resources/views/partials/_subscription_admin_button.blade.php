@if($stripe_plan !== $subscription->stripe_plan)
    <form id="subscription-comunidad"
          action="{{ route('subscription.change') }}"
          method="POST">
        @csrf
        <input type="hidden" value="{{ $stripe_plan }}" name="plan">
        <button type="submit" class="btn btn-outline-primary">Selecionar</button>
    </form>
    @else
    <button class="btn btn-primary">Plan actual</button>
@endif