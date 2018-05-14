@component('component.main')

    <div class="row justify-content-center">
        <div class="col-md-8">

            @component('component.card')

                @slot('header')
                   Perfil de {{ Auth::user()->name }}
                @endslot

                @slot('header_style', 'bg-white font-weight-bold')

                    <avatar-form avatar_path="{{ Auth::user()->avatar }}" inline-template>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Cambiar avatar</label>

                            <div class="col-md-6">
                                <img :src="avatar" class="rounded-circle mx-auto d-block mb-2 " width="86" height="86">
                                <form method="POST" enctype="multipart/form-data">
                                    <image-upload name="avatar" class="form-control" @loaded="onLoad"></image-upload>
                                </form>
                            </div>
                        </div>

                    </avatar-form>

            @endcomponent

        </div>
    </div>

@endcomponent