@extends('layouts.app')

@section('body-class'){{ $body_class ?? '' }}@endsection

@section('content-class'){{ $content_class ?? 'py-4 app-content' }}@endsection

@section('content')

    <div class="{{ $container ?? 'container' }}">

        @if(auth()->check() && ! auth()->user()->isActive())
            @if(!auth()->user()->isAdmin())
                <div class="alert alert-warning text-center" role="alert">Su cuenta no está activada todavía, por favor actívela. Si no hay un correo electrónico con el enlace de activación, intente  <a href="{{ route('activate.resend.index') }}">volver a enviar el enlace</a>. Si el problema continúa, contáctenos.</div>
            @endif
        @endif

        {{ $slot }}
    </div>

@endsection

@isset($scripts)
    @push('scripts')
        {{ $scripts }}
    @endpush
@endisset