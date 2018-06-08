<template>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">Cambiar Imagen</label>

        <div class="col-md-6">
            <img :src="image" class="rounded mx-auto d-block mb-2 " width="286" height="180">

            <div class="progress" v-if="uploading">
                <div class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar"
                     aria-valuenow="75"
                     aria-valuemin="0"
                     aria-valuemax="100"
                     :style="{width: percentage + '%'}">
                    @{{ percentage }} %
                </div>
            </div>

            <form method="POST" enctype="multipart/form-data" v-else>
                <image-upload name="image" class="form-control" @loaded="onLoad"></image-upload>
            </form>
        </div>
    </div>
</template>

<script>
    import ImageUpload from '../ImageUpload';
    export default {
        props: ['image_path','username'],
        components: { ImageUpload },
        data() {
            return {
                image: this.image_path,
                uploading: false,
                percentage: 0,
            };
        },
        methods: {
            onLoad(image) {
                this.image = image.src;
                this.persist(image.file);
            },
            persist(image) {
                this.uploading = true;
                let data = new FormData();
                data.append('image', image);
                axios.post(`/client/${this.username}/image`, data, {
                    onUploadProgress: (progressEvent) => {
                        this.percentage = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    },
                }).then(() => {
                    this.uploading = false;
                    toastr.success('¡Cambió la imagen exitosamente!')
                });
            }
        }
    }
</script>