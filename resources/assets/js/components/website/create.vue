<script>
    export default {
        name: "website-create",
        data() {
            return {
                form: new Form({
                    name: '',
                    username: '',
                }),
            }
        },
        methods: {
            onSubmit() {
                this.$validator.validateAll().then((valid) => {
                    if (valid) {
                        this.form.post('/websites')
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