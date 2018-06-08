<template>
    <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
        <div class="form-group row">
            <label class="col-sm-4 col-form-label text-md-right">Sitio</label>

            <div class="col-md-6">
                <v-select
                        name="website_id"
                        :class="[{ 'is-invalid' : errors.has('website')  }, { 'is-invalid' : form.errors.has('website_id') }]"
                        :options="websites"
                        v-model="website_select"
                        v-validate="'required'"
                        data-vv-name="website">
                </v-select>
                <span v-show="errors.has('website') || form.errors.has('website_id')" class="invalid-feedback">
                    <strong v-text="errors.first('website') || form.errors.first('website_id')"></strong>
            </span>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Mensaje</label>

            <div class="col-md-6">
                <textarea class="form-control"
                          :class="[{ 'is-invalid' : errors.has('mensaje')  }, { 'is-invalid' : form.errors.has('message') }]"
                          rows="3"
                          name="message"
                          data-vv-name="mensaje"
                          v-model="form.message"
                          v-validate="'required|min:4|max:100'">
                </textarea>
            </div>

            <span v-show="errors.has('mensaje') || form.errors.has('message')" class="invalid-feedback">
                    <strong v-text="errors.first('mensaje') || form.errors.first('message')"></strong>
            </span>
        </div>

        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary" :disabled="form.errors.any()">
                    Enviar Mensaje
                </button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        name: "send_message_component",
        props: ['websites'],
        data() {
            return {
                website_select: '',
                form: new Form({
                    website_id: '',
                    message: ''
                })
            }
        },
        watch: {
            website_select: function (val) {
                if (val) return this.form.website_id = val.value;

                this.form.website_id = '';
            },
        },
        methods: {
            onSubmit() {
                this.$validator.validateAll().then((valid) => {
                    if (valid) {
                        this.form.post('/messages')
                            .then(() => {
                                window.location.href= '/messages';
                            });
                    }
                });
            },
        }

    }
</script>