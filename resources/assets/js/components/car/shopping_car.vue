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
                   .catch(error => {
                       console.log(error);
                   });
            },
            removeArticleToCar(article) {
                axios.get(`/${article.pivot.article_id}/remove/car`)
                    .then(() => {
                        let index = this.items.findIndex(item => item.id === article.id);
                        this.items.splice(index, 1);
                    }).catch(error => {
                        console.log(error);
                    });
            }
        }
    }
</script>