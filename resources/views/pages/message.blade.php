@component('component.main')

    @slot('container', 'container-fluid')

    @isset($website)
        <div class="mr-5 ml-5 pl-3 pr-3">
            {{ Breadcrumbs::render('message', $website) }}
        </div>
    @endisset

    <message-main
            :website="{{ $website ?? 'false' }}"
            :user="{{ auth()->user() }}">
    </message-main>

@endcomponent