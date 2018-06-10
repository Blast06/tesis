<template>
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
</template>

<script>
    import vueDropzone from 'vue2-dropzone';
    import 'vue2-dropzone/dist/vue2Dropzone.min.css';

    export default {
        name: "image_article",
        props: ['website', 'article_id'],
        components: {
            vueDropzone,
        },
        watch: {
            article_id: function (value) {
                if (typeof value === 'number' && this.hasIamge) {
                    this.$refs.imageDropzone.processQueue();
                }else if(typeof value === 'number'){
                    this.$emit('defaultEvent', 'Ninguna imagen subida');
                }
            }
        },
        data() {
            return {
                dropzoneOptions: {
                    acceptedFiles: 'image/*',
                    url: `/client/${this.website.username}/articles/images`,
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
                hasIamge: false,

            }
        },
        methods: {
            addedEvent(file) {
                this.hasIamge = true;
            },
            sendingEvent(file, xhr, formData) {
                formData.append("article_id", this.article_id);
            },
            successEvent(file, response) {
                this.clear();
                this.$emit('successEvent', 'Imagenes subidas correctamente');
            },
            errorEvent(file, message, xhr) {
                this.clear();
                this.$emit('errorEvent', 'Ha ocurrido un error al subir las imagenes');
            },
            clear() {
                this.$refs.imageDropzone.removeAllFiles();
                this.hasIamge = false;
            },
        }
    }
</script>

<style scoped>

</style>