<script>
    import VueNumeric from 'vue-numeric'

    export default {
        name: "shopping_car",
        props: ['articles'],
        components: { VueNumeric },
        data() {
            return {
                items: this.articles,
                loading: false,
            }
        },
        methods: {
            quantityChange(article) {
               axios.get(`/${article.pivot.article_id}/add/${article.pivot.quantity}/cart`)
                   .then(() => {
                       toastr.success(`¡Articulo ${article.name} actualizado correctamente!`);
                   });
            },
            removeArticleToCar(article) {
                axios.get(`/${article.pivot.article_id}/remove/cart`)
                    .then(() => {
                        toastr.info(`¡Articulo ${article.name} removido correctamente!`);
                        let index = this.items.findIndex(item => item.id === article.id);
                        this.items.splice(index, 1);
                    });
            },
            confirmOrder(){
                swal({
                    title: "¿Estás seguro?",
                    text: "¡No podrás modificar o eliminar esta orden, una vez realizada!",
                    buttons: ["Cancelar", "Ordenar ahora"],
                    dangerMode: true,
                }).then((confirm) => {
                    if (confirm) {
                        this.orderNow();
                    }
                });
            },
            orderNow(){
                this.loading = true;

                let itemOrder = [];

                this.items.forEach((article) => {
                    itemOrder.push({
                        "article_id": article.id,
                        "quantity": article.pivot.quantity
                    })
                });

                axios.post(`/orders`, {
                    orders: itemOrder
                }).then(() => {
                    toastr.success(`¡Orden procesada correctamente!`);
                    this.loading = false;
                    setTimeout(() => {
                        window.location.href = '/orders';
                    }, 3000);
                }).catch((error) => {
                    this.loading = false;
                    toastr.error(error.response.data.message);
                })
            }
        },
        computed: {
            itemsQuantity(){
                return this.items.reduce((quantity, item) => {
                    return quantity + item.pivot.quantity
                }, 0)
            },
            subtotal(){
                return this.items.reduce((subtotal, item) => {
                    if (item.status !== 'PRIVADO'){
                        return subtotal + parseFloat(item.price * item.pivot.quantity);
                    }
                    return 0;
                }, 0)
            },
            iva() {
                return parseFloat(this.subtotal  * 0.18);
            },
            total(){
                return this.subtotal + this.iva;
            },

        }
    }
</script>