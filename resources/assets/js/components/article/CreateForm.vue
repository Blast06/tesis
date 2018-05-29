<template>
    <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" enctype="multipart/form-data">

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Titulo</label>

            <b-col md="6">
                <b-form-input :class="[{ 'is-invalid' : errors.has('titulo')  }]"
                              type="text"
                              name="name"
                              v-model="form.name"
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
                               v-model="form.sub_category_id">
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
                <input type="file"
                       name="file"
                       accept="image/*"
                       class="form-control"
                       multiple="true"
                       @change="onChange">
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
                        v-model="form.price"
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
                        v-model="form.stock"
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
                        v-model="form.status">
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
                                 v-validate="'required|min:20'"
                                 data-vv-name="descripcion"
                                 v-model="form.description">
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
    import ImageUpload from '../ImageUpload';

    export default {
        name: "prodcut-create",
        props: ['website'],
        components: { VueNumeric, ImageUpload },
        data() {
            return {
                categories: {},
                options: [
                    { value: null, text: '-- Por favor seleccione una opción --', disabled: true },
                    { value: 'NO_DISPONIBLE', text: 'No disponible' },
                    { value: 'DISPONIBLE', text: 'Disponible' },
                    { value: 'PRIVADO', text: 'Privado' }
                ],
                loading: false,
                form: new Form({
                    name: '',
                    sub_category_id: '',
                    file: '',
                    price: '',
                    stock: '',
                    status: '',
                    description: '',
                }),
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
                            .then(() => {
                                toastr.success("¡Creado correctamnet.!");
                                this.$validator.reset();
                                setTimeout(() => {
                                    this.GoToArticles();
                                }, 2000);
                            });
                    }
                });
            },
            GoToArticles() {
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
            onChange(e) {
                if (! e.target.files.length) return;
                let files = [];
                for (let index = 0; index < e.target.files.length; index++) {
                    files.push(e.target.files[index]);
                }
                this.form.file = files;
            },
        },

    }
</script>