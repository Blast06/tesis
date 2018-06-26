<script>
    import VueNumeric from 'vue-numeric'

    export default {
        name: "shopping_car",
        props: ['articles'],
        components: { VueNumeric },
        data() {
            return {
                items: this.articles
            }
        },
        methods: {
            quantityChange(article) {
               axios.get(`/${article.pivot.article_id}/add/${article.pivot.quantity}/car`)
                   .then(() => {
                       toastr.success(`¡Articulo ${article.name} actualizado correctamente!`);
                   });
            },
            removeArticleToCar(article) {
                axios.get(`/${article.pivot.article_id}/remove/car`)
                    .then(() => {
                        toastr.info(`¡Articulo ${article.name} removido correctamente!`);
                        let index = this.items.findIndex(item => item.id === article.id);
                        this.items.splice(index, 1);
                    });
            }
        }
    }
</script>