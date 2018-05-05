<div class="card {{ $card_style ?? 'shadow-sm' }}">
    <div class="card-header {{ $header_style ?? '' }}">{{ $header }}</div>

    <div class="card-body {{ $body_style ?? '' }}">
        {{ $slot }}
    </div>
</div>