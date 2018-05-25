<template>
    <form @submit.prevent="onSubmit">

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Titulo</label>

            <b-col md="6">
                <b-form-input :class="[{ 'is-invalid' : errors.has('titulo')  }]"
                              type="text"
                              name="name"
                              v-model="name"
                              v-validate="'required|min:4|max:40'"
                              data-vv-name="titulo"
                ></b-form-input>

                <span v-show="errors.has('titulo')" class="invalid-feedback">
                    <b v-text="errors.first('titulo')"></b>
                </span>
            </b-col>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Categoria</label>
            <b-col md="6">
                <div class="pt-1 pb-1" v-for="category in categories">
                    <label class="font-weight-bold">
                        <i class="fa" aria-hidden="true"></i>
                        {{ category.name }}
                    </label>

                    <div class="custom-control custom-radio pl-4" v-for="subcategory in category.sub_category">
                        <input type="radio"
                               class="custom-control-input"
                               :class="[{ 'is-invalid' : errors.has('categoria')  }]"
                               :id="subcategory.id"
                               name="sub_category_id"
                               data-vv-name="categoria"
                               :value="subcategory.id"
                               v-validate="'required'"
                               v-model="sub_category_id">
                        <label class="custom-control-label" :for="subcategory.id">{{ subcategory.name}}</label>
                    </div>

                </div>
                <small v-show="errors.has('categoria')" style="color: #dc3545">
                    <b v-text="errors.first('categoria')"></b>
                </small>
            </b-col>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Imagenes</label>

            <b-col md="6">
                <vue-dropzone ref="imageDropzone"
                              id="dropzone"
                              :options="dropzoneOptions"
                              v-on:vdropzone-file-added="addedEvent"
                              v-on:vdropzone-sending="sendingEvent"
                              v-on:vdropzone-success="successEvent"
                              v-on:vdropzone-error="errorEvent">
                </vue-dropzone>
            </b-col>
        </div>



        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Precio</label>

            <b-col md="6">
                <vue-numeric
                        class="form-control"
                        :class="[{ 'is-invalid' : errors.has('precio')  }]"
                        currency="RD $"
                        separator=","
                        v-bind:precision="2"
                        v-validate="'required|numeric|min_value:100|max_value:900000000'"
                        name="price"
                        data-vv-name="precio"
                        v-model="price"
                ></vue-numeric>

                <span v-show="errors.has('precio')" class="invalid-feedback">
                    <b v-text="errors.first('precio')"></b>
                </span>
            </b-col>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Cantidad</label>

            <b-col md="6">
                <vue-numeric
                        class="form-control"
                        :class="[{ 'is-invalid' : errors.has('cantidad')  }]"
                        separator=","
                        v-validate="'numeric|max_value:9999'"
                        name="stock"
                        data-vv-name="cantidad"
                        v-model="stock"
                ></vue-numeric>

                <span v-show="errors.has('cantidad')" class="invalid-feedback">
                    <b v-text="errors.first('cantidad')"></b>
                </span>
            </b-col>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Estatus</label>

            <b-col md="6">
                <b-form-select
                        class="mb-3"
                        :class="[{ 'is-invalid' : errors.has('estatus')  }]"
                        name="status"
                        :options="options"
                        v-validate="'required'"
                        data-vv-name="estatus"
                        v-model="status">
                </b-form-select>

                <span v-show="errors.has('estatus')" class="invalid-feedback">
                    <b v-text="errors.first('estatus')"></b>
                </span>
            </b-col>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Descripcion</label>

            <b-col md="6">
                <b-form-textarea :class="[{ 'is-invalid' : errors.has('descripcion')  }]"
                                 rows="4"
                                 name="description"
                                 v-model="description"
                                 v-validate="'required|min:20'"
                                 data-vv-name="descripcion">
                </b-form-textarea>

                <span v-show="errors.has('descripcion')" class="invalid-feedback">
                    <b v-text="errors.first('descripcion')"></b>
                </span>
            </b-col>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary" :class="loading ? 'loader' : ''">
                    Crear
                </button>
            </div>
        </div>

    </form>
</template>

<script>
    import VueNumeric from 'vue-numeric'
    import vueDropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'

    export default {
        name: "prodcut-create",
        props: ['website'],
        components: {
            VueNumeric,
            vueDropzone,
        },
        data() {
            return {
                categories: {},
                options: [
                    { value: null, text: '-- Por favor seleccione una opción --', disabled: true },
                    { value: 'NO_DISPONIBLE', text: 'No disponible' },
                    { value: 'DISPONIBLE', text: 'Disponible' },
                    { value: 'PRIVADO', text: 'Privado' }
                ],
                dropzoneOptions: {
                    url: `/client/${this.website.username}/articles`,
                    thumbnailWidth: 150,
                    maxFilesize: 5,
                    maxFiles: 10,
                    autoProcessQueue: false,
                    uploadMultiple: true,
                    parallelUploads: 100,
                    addRemoveLinks: true,
                    dictDefaultMessage: "<i class=\"fas fa-cloud-upload-alt\"></i> CARGAR IMAGEN",
                    headers: {'X-CSRF-TOKEN': window.axios.defaults.headers.common['X-CSRF-TOKEN']}
                },
                name: '',
                price: '',
                sub_category_id: '',
                description: '',
                stock: '',
                status: '',
                loading: false,
                hasIamge: false,
            }
        },
        created() {
          axios.get(`/web/api/categories`).then(response => {
              this.categories = response.data.data;
          });
        },
        methods: {
            onSubmit() {
                this.$validator.validateAll().then((valid) => {
                    if (valid) {
                        if (this.hasIamge) {
                            this.loading = true;
                            this.$refs.imageDropzone.processQueue();
                        }else {
                            toastr.error('Debes subir al menos una imagen.');
                        }
                    }
                });
            },
            addedEvent(file) {
                this.hasIamge = true;
            },
            sendingEvent(file, xhr, formData) {
                formData.append("name", this.name);
                formData.append("price", this.price);
                formData.append("sub_category_id", this.sub_category_id);
                formData.append("description", this.description);
                formData.append("status", this.status);
                if (this.stock > 0) {
                    formData.append("stock", this.stock);
                }
            },
            successEvent(file, response) {
                toastr.success("¡Creado correctamnet.!");
                this.clearForm();
                setTimeout(() => {
                    this.GoToProduct();
                }, 2000);
            },
            errorEvent(file, message, xhr) {
                toastr.error('Ha ocurrido un error');
                this.$refs.imageDropzone.removeAllFiles();

                if('undefined' === typeof xhr) {
                    console.log(message);
                }else {
                    this.loading = false;
                    console.log(xhr.response);
                }
            },
            clearForm() {
                this.$validator.reset();
                this.$refs.imageDropzone.removeAllFiles();
                this.name = '';
                this.price = '';
                this.sub_category_id = '';
                this.description = '';
                this.stock = '',
                this.status = '',
                this.loading = false;
                this.hasIamge = false;
            },
            GoToProduct() {
                swal({
                    title: "Seras redireccionado",
                    text: "Si quieres seguir aquí \"creando productos\", ¡Precione ok!",
                    buttons: true,
                    dangerMode: true,
                }).then((redirect) => {
                    if (!redirect) {
                        window.location.href= `/client/${this.website.username}/articles`;
                    }
                });
            },
        },

    }
</script>

<style>
    [data-toggle="collapse"] .fa:before {
        content: "\f139";
    }

    [data-toggle="collapse"].collapsed .fa:before {
        content: "\f13a";
    }
</style>