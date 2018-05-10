@component('component.main')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @component('component.card')

                @slot('header','Crear Sitio Web')

                @slot('header_style', 'bg-white font-weight-bold')

                @slot('body_style', 'bg-light')

                <website-create inline-template>
                    <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nombre del sitio</label>

                            <div class="col-md-6">
                                <input class="form-control"
                                       :class="[{ 'is-invalid' : errors.has('sitio')  }, { 'is-invalid' : form.errors.has('name') }]"
                                       type="text"
                                       name="name"
                                       v-model="form.name"
                                       v-validate="'required|alpha_spaces|min:4|max:40'"
                                       data-vv-name="sitio"/>

                                <span v-show="errors.has('sitio')" class="invalid-feedback"><strong v-text="errors.first('sitio')"></strong></span>
                                <span v-show="form.errors.has('name')" class="invalid-feedback"><strong v-text="form.errors.first('name')"></strong></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nombre de usuario</label>

                            <div class="col-md-6">
                                <input class="form-control"
                                       :class="[{ 'is-invalid' : errors.has('usuario')  }, { 'is-invalid' : form.errors.has('username') }]"
                                       type="text"
                                       name="username"
                                       v-model="form.username"
                                       v-validate="'required|alpha_dash|min:4|max:40'"
                                       data-vv-name="usuario"/>

                                <span v-show="errors.has('usuario')" class="invalid-feedback"><strong v-text="errors.first('usuario')"></strong></span>
                                <span v-show="form.errors.has('username')" class="invalid-feedback"><strong v-text="form.errors.first('username')"></strong></span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" :disabled="form.errors.any()">
                                    Crear Sitio
                                </button>
                            </div>
                        </div>

                    </form>
                </website-create>
            @endcomponent
        </div>
    </div>
@endcomponent