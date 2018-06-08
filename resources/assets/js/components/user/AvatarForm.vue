<script>
    import ImageUpload from '../ImageUpload';
    export default {
        props: ['avatar_path'],
        components: { ImageUpload },
        data() {
            return {
                avatar: this.avatar_path,
                uploading: false,
                percentage: 0,
            };
        },
        methods: {
            onLoad(avatar) {
                this.avatar = avatar.src;
                this.persist(avatar.file);
            },
            persist(avatar) {
                this.uploading = true;
                let data = new FormData();
                data.append('avatar', avatar);
                axios.post(`/profiles`, data, {
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