@component('component.main')

    @slot('content_class', 'app-content')

    @slot('container', 'container-fluid')

    <message-index
            avatar="{{ auth()->user()->avatar }}">
    </message-index>

@endcomponent