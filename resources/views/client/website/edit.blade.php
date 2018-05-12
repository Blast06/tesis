@component('component.main')
    <div class="row">
        <div class="col-md-3">

        </div>

        <div class="col-md-9">

            @include('partials.alert')

            @component('component.card')

                @slot('header',"Editar {$website->name}")

                @slot('header_style', 'bg-white font-weight-bold')

                @slot('body_style', 'bg-light')

                <image-form image_path="{{ $website->image_path }}" website="{{ $website->username }}" inline-template>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">Cambiar Imagen</label>

                        <div class="col-md-6">
                            <img :src="image" class="rounded mx-auto d-block mb-2 " width="286" height="180">
                            <form method="POST" enctype="multipart/form-data">
                                <image-upload name="image" class="form-control" @loaded="onLoad"></image-upload>
                            </form>
                        </div>
                    </div>

                </image-form>

                {{ Form::model($website, ['route' => ['client.setting.update', $website], 'method' => 'put']) }}

                        <div class="form-group row">
                            {{ Form::label('name', 'Nombre del sitio', ['class' => 'col-sm-4 col-form-label text-md-right']) }}

                            <div class="col-md-6">
                                {{ Form::text('name', old('name'), ['class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control', 'required' => true ]) }}

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                   Actualizar
                                </button>

                            </div>
                        </div>
                {{ Form::close() }}

            @endcomponent
        </div>
    </div>
@endcomponent
