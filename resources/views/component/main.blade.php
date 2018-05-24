@extends('layouts.app')

@section('body-class'){{ $body_class ?? '' }}@endsection

@section('content')

    <div class="{{ $content_style ?? 'container' }}">
        {{ $slot }}
    </div>

@endsection

@push('scripts')
{!! $scripts ?? null !!}
@endpush