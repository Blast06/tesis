<script>
    import ImageUpload from '../ImageUpload';
    export default {
        props: ['avatar_path'],
        components: { ImageUpload },
        data() {
            return {
                avatar: this.avatar_path
            };
        },
        methods: {
            onLoad(avatar) {
                this.avatar = avatar.src;
                this.persist(avatar.file);
            },
            persist(avatar) {
                let data = new FormData();
                data.append('avatar', avatar);
                axios.post(`/profiles`, data)
                    .then(() => toastr.success('¡Cambió la imagen exitosamente!'));
            }
        }
    }
</script>