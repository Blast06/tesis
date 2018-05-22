<template>
    <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Titulo</label>

            <b-col md="6">
                <b-form-input :class="[{ 'is-invalid' : errors.has('titulo')  }, { 'is-invalid' : form.errors.has('name') }]"
                              type="text"
                              name="name"
                              v-model="form.name"
                              v-validate="'required|alpha_spaces|min:4|max:40'"
                              data-vv-name="titulo"
                ></b-form-input>

                <span v-show="errors.has('titulo') || form.errors.has('name')" class="invalid-feedback">
                    <b v-text="errors.first('titulo') || form.errors.first('name')"></b>
                </span>
            </b-col>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Imagenes</label>

            <b-col md="6">
                <vue-dropzone ref="imageDropzone" id="dropzone" :options="dropzoneOptions"></vue-dropzone>
            </b-col>
        </div>



        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Precio</label>

            <b-col md="6">
                <vue-numeric
                        class="form-control"
                        :class="[{ 'is-invalid' : errors.has('precio')  }, { 'is-invalid' : form.errors.has('price') }]"
                        currency="RD $"
                        separator=","
                        v-bind:precision="2"
                        v-validate="'required|numeric|min_value:100|max_value:900000000'"
                        name="price"
                        data-vv-name="precio"
                        v-model="form.price"
                ></vue-numeric>

                <span v-show="errors.has('precio') || form.errors.has('price')" class="invalid-feedback">
                    <b v-text="errors.first('precio') || form.errors.first('price')"></b>
                </span>
            </b-col>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Categoria</label>
            <b-col md="6">
                <div class="pt-2 pb-3" v-for="category in categories">
                    <label class="font-weight-bold">{{ category.name }}</label>

                    <div class="custom-control custom-radio pl-4"  v-for="subcategory in category.sub_category">
                        <input type="radio"
                               class="custom-control-input"
                               :class="[{ 'is-invalid' : errors.has('categoria')  }, { 'is-invalid' : form.errors.has('sub_category_id') }]"
                               :id="subcategory.id"
                               name="sub_category_id"
                               data-vv-name="categoria"
                               :value="subcategory.id"
                               v-validate="'required'"
                               v-model="form.sub_category_id">
                        <label class="custom-control-label" :for="subcategory.id">{{ subcategory.name}}</label>
                    </div>

                </div>
                <small v-show="errors.has('categoria') || form.errors.has('sub_category_id')" style="color: #dc3545">
                    <b v-text="errors.first('categoria') || form.errors.first('sub_category_id')"></b>
                </small>
            </b-col>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Descripcion</label>

            <b-col md="6">
                <b-form-textarea :class="[{ 'is-invalid' : errors.has('descripcion')  }, { 'is-invalid' : form.errors.has('description') }]"
                                 rows="4"
                                 name="description"
                                 v-model="form.description"
                                 v-validate="'required'"
                                 data-vv-name="descripcion">
                </b-form-textarea>

                <span v-show="errors.has('descripcion') || form.errors.has('description')" class="invalid-feedback">
                    <b v-text="errors.first('descripcion') || form.errors.first('description')"></b>
                </span>
            </b-col>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary" :disabled="form.errors.any()">
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
        props: ['username'],
        components: {
            VueNumeric,
            vueDropzone,
        },
        data() {
            return {
                categories: {},
                dropzoneOptions: {
                    url: 'https://httpbin.org/post',
                    thumbnailWidth: 150,
                    maxFilesize: 2,
                    addRemoveLinks: true,
                    dictDefaultMessage: "<i class=\"fas fa-cloud-upload-alt\"></i> CARGAR IMAGEN"
                },
                form: new Form({
                    name: '',
                    price: '',
                    sub_category_id: '',
                    description: '',
                }),
            }
        },
        created() {
          axios.get(`/web/api/categories`).then(response => {
              this.categories = response.data.data;
          }).catch(error => {
              console.log(error);
          });

        },
        methods: {
            onSubmit() {
                this.$validator.validateAll().then((valid) => {
                    if (valid) {
                        this.form.post(`/client/${this.username}/products `)
                            .then(response => {
                                this.$validator.reset();
                                window.location.href= '/client/'+ response.data.username +'/dashboard';
                            });
                    }
                });
            },
        }
    }
</script>