<script>
    import ImageUpload from '../ImageUpload';
    export default {
        props: ['image_path','website'],
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
                axios.post(`/client/${this.website}/settings/change/image`, data)
                    .then(() => alert('Image uploaded!'));
            }
        }
    }
</script>