@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('partials.alert')

                <div class="card shadow-sm mb-5">
                    <div class="card-header">Volver a enviar el código de activación</div>
                    <div class="card-body bg-white">
                        {{ Form::open(['route' => 'account.activation.resend', 'method' => 'POST']) }}

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Reenviar código de activación') }}
                                </button>
                            </div>

                        {{ Form::close() }}
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-header">Cambiar el correo electrónico y volver a enviar el código de activación</div>
                    <div class="card-body bg-white">
                        {{ Form::open(['route' => 'account.activation.change.email', 'method' => 'POST']) }}

                            <div class="form-group row">
                                {{ Form::label('email', __('E-Mail Address'), ['class' => 'col-md-4 col-form-label text-md-right']) }}

                                <div class="col-md-6">
                                    {{ Form::email('email', old('email'), ['class' => $errors->has('email') ? 'form-control is-invalid' : 'form-control', 'required' => true]) }}

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
                                        {{ __('Reenviar') }}
                                    </button>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection