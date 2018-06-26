<template>
    <li>
        <a href="/shopping/cart">
            <i class="fas fa-shopping-cart fa-lg"></i>
            <span class="badge badge-pill badge-danger" v-if="count > 0">{{ count }}</span>
        </a>
    </li>
</template>

<script>
    export default {
        name: "user-cart-notifications",
        props: ['user_id'],
        data() {
            return {
                count: 0
            }
        },
        created(){
            this.countShoppinCarItems();
            this.listEvent();
        },
        methods: {
            countShoppinCarItems(){
                axios.get('/shopping/cart/count')
                    .then(response => { this.count = response.data.count; });
            },
            listEvent(){
                Echo.private('Cart.User.' + this.user_id)
                    .listen('.listenCarItem', (event) => {
                        this.count = event.count;
                    });
            },
        }
    }
</script>
