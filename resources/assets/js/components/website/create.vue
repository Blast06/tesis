<script>
    import MaskedInput from 'vue-masked-input';

    export default {
        name: "website-create",
        data() {
            return {
                form: new Form({
                    name: '',
                    phone: '',
                    address: '',
                }),
            }
        },
        components: {
            MaskedInput
        },
        methods: {
            onSubmit() {
                this.$validator.validateAll().then((valid) => {
                    if (valid) {
                        this.form.post('/websites')
                            .then(response => {
                                window.location.href= '/client/'+ response.data.id +'/dashboard';
                            });
                    }
                });
            },
        }
    }
</script>