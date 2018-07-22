<template>
    <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" enctype="multipart/form-data">

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Titulo</label>

            <b-col md="6">
                <b-form-input :class="[{ 'is-invalid' : errors.has('titulo')  }, { 'is-invalid' : form.errors.has('name') }]"
                              type="text"
                              name="name"
                              v-model="form.name"
                              v-validate="'required|min:4|max:40'"
                              data-vv-name="titulo"
                ></b-form-input>

                <span v-show="errors.has('titulo') || form.errors.has('name')" class="invalid-feedback">
                    <b v-text="errors.first('titulo') || form.errors.first('name')"></b>
                </span>
            </b-col>
        </div>

        <ImageUpload :website="website"
                     :article_id="article_id"
                     v-on:successEvent="imageUploadEvent"
                     v-on:errorEvent="imageUploadEvent"
                     v-on:defaultEvent="imageUploadEvent">
        </ImageUpload>

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
            <label class="col-md-4 col-form-label text-md-right">Cantidad</label>

            <b-col md="6">
                <vue-numeric
                        class="form-control"
                        :class="[{ 'is-invalid' : errors.has('cantidad')  }, { 'is-invalid' : form.errors.has('stock') }]"
                        separator=","
                        name="stock"
                        v-validate="'numeric|max_value:9999'"
                        data-vv-name="cantidad"
                        v-model="form.stock"
                ></vue-numeric>

                <span v-show="errors.has('cantidad') || form.errors.has('stock')" class="invalid-feedback">
                    <b v-text="errors.first('cantidad') || form.errors.first('stock')"></b>
                </span>
            </b-col>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Estatus</label>

            <b-col md="6">
                <b-form-select
                        class="mb-3"
                        :class="[{ 'is-invalid' : errors.has('estatus')  }, { 'is-invalid' : form.errors.has('stock') }]"
                        name="status"
                        :options="options"
                        v-validate="'required'"
                        data-vv-name="estatus"
                        v-model="form.status">
                </b-form-select>

                <span v-show="errors.has('estatus') || form.errors.has('status')" class="invalid-feedback">
                    <b v-text="errors.first('estatus') || form.errors.first('status')"></b>
                </span>
            </b-col>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Descripcion</label>

            <b-col md="6">
                <b-form-textarea :class="[{ 'is-invalid' : errors.has('descripcion')  }, { 'is-invalid' : form.errors.has('description') }]"
                                 rows="4"
                                 name="description"
                                 v-validate="'required|min:20'"
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
                <button type="submit" class="btn btn-primary" :class="loading ? 'loader' : ''">
                    Crear
                </button>
            </div>
        </div>

    </form>
</template>

<script>
    import VueNumeric from 'vue-numeric'
    import ImageUpload from './_ImageArticle';

    export default {
        name: "article-create",
        props: ['website'],
        components: { VueNumeric, ImageUpload },
        data() {
            return {
                categories: {},
                loading: false,
                article_id: '',
                form: new Form({
                    name: '',
                    sub_category_id: '',
                    price: '',
                    stock: '',
                    status: '',
                    description: '',
                }),
                options: [
                    { value: 'NO_DISPONIBLE', text: 'No disponible' },
                    { value: 'DISPONIBLE', text: 'Disponible' },
                    { value: 'PRIVADO', text: 'Privado' }
                ],
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
                        this.loading = true;
                        this.form.post(`/client/${this.website.username}/articles`)
                            .then((response) => {
                                toastr.success("¡Articulo creado correctamente!");
                                this.article_id = response.data.id;
                            });
                    }
                });
            },
            imageUploadEvent(message) {
                toastr.info(message);
                setTimeout(() => {
                    this.goToArticles();
                }, 2000);
            },
            goToArticles() {
                this.clear();
                swal({
                    title: "Seras redireccionado",
                    text: "Si quieres seguir aquí \"creando articulos\", ¡Precione ok!",
                    buttons: true,
                    dangerMode: true,
                }).then((redirect) => {
                    if (!redirect) {
                        window.location.href= `/client/${this.website.username}/articles`;
                    }
                });
            },
            clear() {
                this.loading = false;
                this.article_id = '';
                this.$validator.reset();
                this.form.resetInput();
            }
        },

    }
</script>