@component('component.main')

    <div class="row justify-content-center">
        <div class="col-md-8">

            @include('partials.alert')

            @component('component.card')

                @slot('header', 'Cambiar el correo electrónico y volver a enviar el código de activación')

                <form method="POST" action="{{ route('activate.change.email') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">correo electrónico</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required >

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Reenviar
                            </button>

                            <a class="btn btn-link" href="{{ route('activate.resend.index') }}">
                                Reenviar codigo de activacion
                            </a>
                        </div>
                    </div>

                </form>

            @endcomponent

        </div>
    </div>



@endcomponent
