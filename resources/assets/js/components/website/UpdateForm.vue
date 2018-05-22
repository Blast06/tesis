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
                           v-validate="'required|alpha_spaces|min:4|max:40'"
                           data-vv-name="sitio"/>

                    <span v-show="errors.has('sitio')" class="invalid-feedback"><strong v-text="errors.first('sitio')"></strong></span>
                    <span v-show="form.errors.has('name')" class="invalid-feedback"><strong v-text="form.errors.first('name')"></strong></span>
                </div>
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