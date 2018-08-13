@component('component.main')

    @include('partials._alert')

    <div class="row justify-content-center">
        <div class="col-md-8">

            @component('component.card')

                @slot('card_style', 'shadow-sm mb-5')

                @slot('header')
                   Perfil de {{ Auth::user()->name }}
                @endslot

                @slot('header_style', 'bg-white font-weight-bold')

                    <avatar-form avatar_path="{{ Auth::user()->avatar }}" inline-template>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Cambiar avatar</label>

                            <div class="col-md-6">
                                <img :src="avatar" class="rounded-circle mx-auto d-block mb-2 " width="86" height="86">

                                <div class="progress" v-if="uploading">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                         role="progressbar"
                                         aria-valuenow="75"
                                         aria-valuemin="0"
                                         aria-valuemax="100"
                                         :style="{width: percentage + '%'}">
                                        @{{ percentage }} %
                                    </div>
                                </div>

                                <form v-else method="POST" enctype="multipart/form-data">
                                    <image-upload name="avatar" class="form-control" @loaded="onLoad"></image-upload>
                                </form>
                            </div>
                        </div>

                    </avatar-form>

            @endcomponent

            @if(auth()->user()->subscribed('main'))
                @component('component.card')
                    @slot('card_style', 'shadow-sm mb-5')

                    @slot('header_style', 'bg-white font-weight-bold')

                    @slot('header')
                        Metodo de pago
                        <a class="btn btn-link" href="{{ route('subscription.invoice') }}">Ver facturas</a>
                    @endslot

                    <p><b>Tipo de Tarjeta:</b> {{ auth()->user()->card_brand }}</p>

                    <p><b>Tarjeta que termina en:</b> {{ auth()->user()->card_last_four }}</p>

                @endcomponent
            @endif

            @component('component.card')


                @slot('header', 'Cerrar session en otros dispositivos')

                @slot('header_style', 'bg-white font-weight-bold')

                <form method="POST" action="{{ url('/logoutOthers') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña actual</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password_current') ? ' is-invalid' : '' }}" name="password_current" required>

                            @if ($errors->has('password_current'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password_current') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Cerrar sesión en otros dispositivos
                            </button>
                        </div>
                    </div>
                </form>
            @endcomponent

        </div>
    </div>

@endcomponent