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

        <a @click="confirmOrder" class="btn btn-primary text-uppercase" :class="loading ? 'loader' : ''">Ordenar ahora </a>

        <button type="button" @click="addCar" class="btn btn-outline-primary text-uppercase" :class="loading ? 'loader' : ''">
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
                quantity: this.article.stock !== null && this.article.stock > 20 ? this.article.stock : 20,
                selectQuantity: 1,
                loading: false,
            }
        },
        methods: {
            addCar(){
                this.loading = true;

                axios.get(`/${this.article.id}/add/${this.selectQuantity}/car`)
                    .then(() => {
                        toastr.success(`¡Articulo ${this.article.name} añadido correctamente!`);
                        this.loading = false;
                    })
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

                axios.post(`/orders`, {
                    orders: [{
                        "article_id": this.article.id,
                        "quantity": this.selectQuantity
                    }]
                }).then(() => {
                    toastr.success(`¡Articulo ${this.article.name} ordenado correctamente!`);
                    this.loading = false;
                    setTimeout(() => {
                        window.location.href = '/orders';
                    }, 3000);
                })
            }
        }
    }
</script>