@component('component.main')

    <div class="row">

        <div class="col-md-3 sidebar">
            @if(isset($website))
                @include('client._sidebar')
                @else
                @include('admin._sidebar')
            @endif
        </div>

        <div class="col-md-9">

            @if(isset($breadcrumb_name) && isset($website))
                {{ Breadcrumbs::render($breadcrumb_name, $website) }}
            @endif

            @component('component.card')

                @slot('header')
                    {!! $header ?? "Datatables" !!}
                @endslot

                @slot('header_style', 'bg-white font-weight-bold')

                {!! $dataTable->table() !!}
            @endcomponent
        </div>

    </div>

    @slot('scripts')
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jqc-1.12.4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/r-2.2.2/datatables.min.css"/>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js" defer></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js" defer></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jqc-1.12.4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/r-2.2.2/datatables.min.js" defer></script>
        <script type="text/javascript" src="/vendor/datatables/buttons.server-side.js" defer></script>
        {!! $dataTable->scripts() !!}
    @endslot

@endcomponent