<template>
    <main>
        <image-form :image_path="website.image_path" :username="website.username"></image-form>

        <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Nombre del sitio</label>

                <div class="col-md-6">
                    <input class="form-control"
                           :class="[{ 'is-invalid' : errors.has('sitio')  }, { 'is-invalid' : form.errors.has('name') }]"
                           type="text"
                           name="name"
                           v-model="form.name"
                           v-validate="'required|min:4|max:40'"
                           data-vv-name="sitio"/>

                    <span v-show="errors.has('sitio') || form.errors.has('name')" class="invalid-feedback">
                        <strong v-text="errors.first('sitio') || form.errors.first('name')"></strong>
                    </span>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Telefono</label>

                <div class="col-md-6">
                    <input class="form-control"
                           :class="[{ 'is-invalid' : errors.has('telefono')  }, { 'is-invalid' : form.errors.has('phone') }]"
                           type="text"
                           name="phone"
                           v-model="form.phone"
                           v-validate="'min:4|max:40'"
                           data-vv-name="telefono"/>

                    <span v-show="errors.has('telefono') || form.errors.has('phone')" class="invalid-feedback">
                        <strong v-text="errors.first('telefono') || form.errors.first('phone')"></strong>
                    </span>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Dirección</label>

                <b-col md="6">
                    <b-form-textarea :class="[{ 'is-invalid' : errors.has('dirección')  }, { 'is-invalid' : form.errors.has('address') }]"
                                     rows="4"
                                     name="address"
                                     v-validate="'min:20'"
                                     data-vv-name="direccion"
                                     v-model="form.address">
                    </b-form-textarea>

                    <span v-show="errors.has('direccion') || form.errors.has('address')" class="invalid-feedback">
                    <b v-text="errors.first('direccion') || form.errors.first('address')"></b>
                </span>
                </b-col>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Descripcion</label>

                <b-col md="6">
                    <b-form-textarea :class="[{ 'is-invalid' : errors.has('descripcion')  }, { 'is-invalid' : form.errors.has('description') }]"
                                     rows="4"
                                     name="description"
                                     v-validate="'min:20'"
                                     data-vv-name="descripcion"
                                     v-model="form.description">
                    </b-form-textarea>

                    <span v-show="errors.has('descripcion') || form.errors.has('description')" class="invalid-feedback">
                    <b v-text="errors.first('descripcion') || form.errors.first('description')"></b>
                </span>
                </b-col>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary" :disabled="form.errors.any()">
                        Actualizar
                    </button>
                </div>
            </div>

        </form>
    </main>
</template>

<script>
    import image_form from './_ImageForm';
    export default {
        name: "website-edit",
        props: ['website'],
        components: {
            'image-form': image_form,
        },
        data() {
            return {
                form: new Form({
                    name: this.website.name,
                    description: this.website.description,
                    address: this.website.address,
                    phone: this.website.phone,
                }),
            }
        },
        methods: {
            onSubmit() {
                this.$validator.validateAll().then((valid) => {
                    if (valid) {
                        this.form.put(`/client/${this.website.username}/update`)
                            .then(() => {
                                this.$validator.reset();
                                toastr.success('¡Website actualizado exitosamente!')
                            });
                    }
                });
            },
        }
    }
</script>