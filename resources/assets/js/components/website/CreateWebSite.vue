<template>
    <form v-on:submit.prevent="create()">
        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Nombre del sitio</label>

            <div class="col-md-6">
                <input class="form-control" :class="{ 'is-invalid' : errors.has('sitio')  }"
                       type="text"
                       name="name"
                       v-model="site.name"
                       v-validate="'required|alpha_spaces'"
                       data-vv-name="sitio"/>

                <span v-show="errors.has('sitio')" class="invalid-feedback">
        			<strong>
        				{{ errors.first('sitio') }}
        			</strong>
        		</span>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Telefono</label>

            <div class="col-md-6">

                <masked-input type="tel"
                              class="form-control"
                              :class="{ 'is-invalid' : errors.has('telefono')  }"
                              v-model="site.phone"
                              mask="\+\1 (111) 111-1111"
                              v-validate="'required'"
                              data-vv-name="telefono"
                ></masked-input>

                <span v-show="errors.has('telefono')" class="invalid-feedback">
        			<strong>
        				{{ errors.first('telefono') }}
        			</strong>
        		</span>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Direccion</label>

            <div class="col-md-6">
                <textarea class="form-control" :class="{ 'is-invalid' : errors.has('direccion')  }"
                        type="text"
                        name="address"
                        v-model="site.address"
                        v-validate="'required|min:10'"
                        data-vv-name="direccion"></textarea>
                <span v-show="errors.has('direccion')" class="invalid-feedback">
                    <strong>
                        {{ errors.first('direccion') }}
                    </strong>
                </span>
            </div>
        </div>

        <v-submit :name="'Crear Sitio'" :status="status"></v-submit>
    </form>
</template>

<script>
    import MaskedInput from 'vue-masked-input';

    export default {
        name: "CreateWebSite",
        data() {
            return {
                status: false,
                site: {}
            }
        },
        components: {
            MaskedInput
        },
        methods: {
            create() {
                this.$validator.validateAll().then((valid) => {
                    if (valid) {
                        this.loading();

                        axios.post('/websites', {
                            name: this.site.name,
                            phone: this.site.phone,
                            address: this.site.address
                        }).then(response => {
                            this.loading();
                            window.location.href= '/client/'+ response.data.data.id +'/dashboard';
                        }).catch(error => {
                            this.loading();
                            console.log(error);
                        });
                    }
                });
            },
            clearForm(){
                this.site = {};
                this.$validator.reset();
            },
            loading(){
                this.status = !this.status;
            }
        }
    }
</script>

<style scoped>

</style>