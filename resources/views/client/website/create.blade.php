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
                                       v-validate="'required|alpha_spaces'"
                                       data-vv-name="sitio"/>

                                <span v-show="errors.has('sitio')" class="invalid-feedback"><strong v-text="errors.first('sitio')"></strong></span>
                                <span v-show="form.errors.has('name')" class="invalid-feedback"><strong v-text="form.errors.get('name')"></strong></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Telefono</label>

                            <div class="col-md-6">

                                <masked-input type="tel"
                                              name="phone"
                                              class="form-control"
                                              :class="[{ 'is-invalid' : errors.has('telefono')  }, { 'is-invalid' : form.errors.has('phone') }]"
                                              v-model="form.phone"
                                              mask="\+\1 (111) 111-1111"
                                              v-validate="'required'"
                                              data-vv-name="telefono"
                                ></masked-input>
                                <span v-show="errors.has('telefono')" class="invalid-feedback"><strong v-text="errors.first('telefono')"></strong></span>
                                <span v-show="form.errors.has('phone')" class="invalid-feedback"><strong v-text="form.errors.get('phone')"></strong></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Direccion</label>
                            <div class="col-md-6">
                                <textarea class="form-control"
                                          :class="[{ 'is-invalid' : errors.has('direccion') }, { 'is-invalid' : form.errors.has('address') }]"
                                          type="text"
                                          name="address"
                                          v-model="form.address"
                                          v-validate="'required|min:10'"
                                          data-vv-name="direccion">
                                </textarea>
                                <span v-show="errors.has('direccion')" class="invalid-feedback"><strong v-text="errors.first('direccion')"></strong></span>
                                <span v-show="form.errors.has('address')" class="invalid-feedback"><strong v-text="form.errors.get('address')"></strong></span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" :disabled="form.errors.any()">
                                    Crear Sitios
                                </button>
                            </div>
                        </div>

                    </form>
                </website-create>
            @endcomponent
        </div>
    </div>
@endcomponent