<template>
    <main style="display: inline">
        <button @click="favorite" class="btn btn-light" :class="loading ? 'loader' : ''" v-if="isFavorited">
            <i class="far fa-heart" style="color: #495057;"></i>
        </button>
        <button @click="unfavorite" class="btn btn-light" :class="loading ? 'loader' : ''" v-else>
            <i class="fas fa-heart" style="color: #e74430"></i>
        </button>
    </main>
</template>

<script>
    export default {
        name: "favorite-button",
        props: ['favorited', 'article'],
        data() {
            return {
                isFavorited: ! Boolean(this.favorited),
                loading: false,
            }
        },
        methods: {
            favorite(){
                this.loading = true;

                axios.get(`/${this.article.id}/favorite`)
                    .then(() => {
                        this.loading = false;
                        this.favoritedChangeStatus();
                    })
            },
            unfavorite(){
                this.loading = true;

                axios.get(`/${this.article.id}/unfavorite`)
                    .then(() => {
                        this.loading = false;
                        this.favoritedChangeStatus();
                    })
            },
            favoritedChangeStatus(){
                this.isFavorited = !this.isFavorited;
            },
        }
    }
</script>