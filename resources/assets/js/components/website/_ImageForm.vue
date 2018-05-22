<template>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">Cambiar Imagen</label>

        <div class="col-md-6">
            <img :src="image" class="rounded mx-auto d-block mb-2 " width="286" height="180">
            <form method="POST" enctype="multipart/form-data">
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
                image: this.image_path
            };
        },
        methods: {
            onLoad(image) {
                this.image = image.src;
                this.persist(image.file);
            },
            persist(image) {
                let data = new FormData();
                data.append('image', image);
                console.log(data);
                axios.post(`/client/${this.username}/image`, data)
                    .then(() => toastr.success('¡Cambió la imagen exitosamente!'));
            }
        }
    }
</script>