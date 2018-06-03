@component('component.main')

    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('partials.alert')

            @component('component.card')
                @slot('header', 'Volver a enviar el código de activación')

                <form method="POST" action="{{ route('activate.resend.code') }}">
                    @csrf

                    <div class="form-group row mb-0 justify-content-center">
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary btn-block">
                                Reenviar código de activación
                            </button>
                            <br>
                            <a class="btn btn-link" href="{{ route('activate.change.email.index') }}">
                                Cambiar correo electrónico y volver a enviar codigo de activacion
                            </a>
                        </div>
                    </div>

                </form>
            @endcomponent

        </div>
    </div>

@endcomponent