<template>
    <main>
        <div class="row">
            <div class="col-sm-5">
                <dl class="param param-inline">
                    <dt>Cantidad: </dt>
                    <dd>
                        <select class="form-control form-control-sm" style="width:70px;"
                            v-model="selectQuantity">
                            <option v-for="number in quantity">{{ number }}</option>
                        </select>
                    </dd>
                </dl>
            </div>
        </div>

        <hr>

        <a href="#" class="btn btn-primary text-uppercase">Ordenar ahora </a>

        <button @click="addCar" class="btn btn-outline-primary text-uppercase" :class="loading ? 'loader' : ''">
            <i class="fas fa-shopping-cart"></i> Añadir al carrito
        </button>

        <favorite-button
                :favorited="favorited"
                :article="article">
        </favorite-button>
    </main>
</template>

<script>
    export default {
        name: "shopping-button",
        props: ['article', 'favorited'],
        data() {
            return{
                quantity: this.article.stock !== null ? this.article.stock : 100,
                selectQuantity: 1,
                loading: false,
            }
        },
        methods: {
            addCar(){
                this.loading = true;

                axios.get(`/${this.article.id}/add/${this.selectQuantity}/car`)
                    .then(() => {
                        this.loading = false;
                    })
            }
        }
    }
</script>