<template>
    <main>
        <button @click="subscribe" type="button" class="btn btn-primary" :class="loading ? 'loader' : ''" v-if="isSubscribed">SUSCRIBIRSE</button>
        <button @click="confirme" type="button" class="btn btn-light" :class="loading ? 'loader' : ''" v-else>SUSCRITO</button>
    </main>
</template>

<script>
    export default {
        name: "subscribe-button",
        props: ['subscribed', 'username'],
        data() {
            return {
                isSubscribed: ! Boolean(this.subscribed),
                loading: false,
            }
        },
        methods: {
            subscribe(){
                this.loader();

                axios.get(`/${this.username}/subscribe`)
                    .then(() => {
                        this.loader();
                        this.subscribedChangeStatus();
                    })
            },
            unsubscribe(){
                this.loader();

                axios.get(`/${this.username}/unsubscribe`)
                    .then(() => {
                        this.loader();
                        this.subscribedChangeStatus();
                    })
            },
            subscribedChangeStatus(){
                this.isSubscribed = !this.isSubscribed;
            },
            confirme() {
                swal({
                    title: "Cancelar suscripción",
                    text: "¿Seguro que quieres cancelar la suscripción a este sitio?",
                    buttons: ["CANCELAR", "CANCELAR SUSCRIPCION"],
                    dangerMode: true,
                }).then((confirmed) => {
                    if (confirmed) {
                        this.unsubscribe();
                    }
                });
            },
            loader() {
                this.loading = !this.loading;
            }
        }
    }
</script>