@component('component.main')

    <div class="row">

        <div class="col-md-12">

            @if(isset($breadcrumb_name) && isset($website))
                {{ Breadcrumbs::render($breadcrumb_name, $website) }}
            @endif

            @component('component.card')

                @slot('header')
                    {{ $header ?? "Datatables" }}
                @endslot

                @slot('header_style', 'bg-white font-weight-bold')

                {!! $dataTable->table() !!}
            @endcomponent
        </div>

    </div>

    @slot('scripts')
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js" defer></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js" defer></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.bootstrap4.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js" defer></script>
    <script src="/vendor/datatables/buttons.server-side.js" defer></script>
    {!! $dataTable->scripts() !!}
    @endslot

@endcomponent