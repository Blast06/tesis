<template>
    <stripe-checkout
        button="Comenzar Ahora"
        button-class="btn btn-info"
        :stripe-key="stripe_key"
        :product="product"
        :product-id="id"
        :form-id="form_id"
    ></stripe-checkout>
</template>

<script>
    import { StripeCheckout } from 'vue-stripe'
    export default {
        name: "StripeForm",
        components: {StripeCheckout},
        props: {
            stripe_key: '',
            name: '',
            amount: '',
            description: '',
            id: '',
            form_id: ''
        },
        computed: {
            product() {
                return {
                    name: this.name,
                    amount: parseFloat(this.amount),
                    description: this.description
                }
            }
        }
    }
</script>