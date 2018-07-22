@component('component.main')
    <div class="row">

        <div class="col-md-3 sidebar">
            @include('client._sidebar')
        </div>

        <div class="col-md-9">

            {{ Breadcrumbs::render('create-article', $website) }}

            @component('component.card')

                @slot('header')
                <h6>Describeles a todos lo que les ofreces
                    <button type="button"
                            class="btn btn-secondary btn-sm"
                            data-toggle="tooltip"
                            data-placement="right"
                            title="Poner tus articulos como privados hara que su precio no sea visible, pero deberas especificar en las ordenes el precio del mismo">
                        <i class="fas fa-question-circle"></i>
                    </button>
                </h6>
                @endslot

                @slot('header_style', 'bg-white font-weight-bold')

                @slot('body_style', 'bg-light')

                <article-create :website="{{ request()->website }}"></article-create>
            @endcomponent
        </div>
    </div>

    @slot('script')
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
        </script>
    @endslot
@endcomponent

