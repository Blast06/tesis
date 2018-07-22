<template>
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

                <span v-show="errors.has('sitio') || form.errors.has('name')" class="invalid-feedback">
                    <strong v-text="errors.first('sitio') || form.errors.first('name')"></strong>
                </span>
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

                <span v-show="errors.has('usuario') || form.errors.has('username')" class="invalid-feedback">
                    <strong v-text="errors.first('usuario') || form.errors.first('username')"></strong>
                </span>
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
</template>

<script>
    export default {
        name: "website-create",
        data() {
            return {
                form: new Form({
                    name: '',
                    username: '',
                }),
            }
        },
        methods: {
            onSubmit() {
                this.$validator.validateAll().then((valid) => {
                    if (valid) {
                        this.form.post('/websites')
                            .then(response => {
                                this.$validator.reset();
                                window.location.href= '/client/'+ response.data.username +'/dashboard';
                            })
                            .catch(error => {
                                toastr.error(error.message);

                                if (error.message === "Debes elegir un plan antes de continuar") {
                                    setTimeout(() => {
                                        window.location.href= '/plans';
                                    }, 3000);
                                }
                            });
                    }
                });
            },
        }
    }
</script>