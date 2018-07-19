<template>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>Articulo</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Vendedor</th>
                <th>Estado</th>
                <th>Fecha de Actualizacion</th>
                <th>Fecha de Modificacion</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="order in orders">
                <th><a :href="'articles/'+order.article.slug">{{ order.article.name}}</a></th>
                <td>{{ order.price | currency('RD$', 2, { spaceBetweenAmountAndSymbol: true })}}</td>
                <td v-text="order.quantity"></td>
                <td v-text="order.website.name"></td>
                <td v-html="badgesStatus(order.status)"></td>
                <td>{{ order.created_at | moment("dddd, MMMM Do YYYY, h:mm:ss a")}}</td>
                <td>{{ order.updated_at | moment("dddd, MMMM Do YYYY, h:mm:ss a")}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "user-orders",
        props: ['orders'],
        methods: {
            badgesStatus(status) {
                if (status === "EN ESPERA")
                    return '<span class="badge badge-warning">'+status+'</span>';
                if (status === 'EN PROCESO')
                    return '<span class="badge badge-primary">'+status+'</span>';
                if (status === "COMPLETADA")
                    return '<span class="badge badge-success">'+status+'</span>';
                if (status === "CANCELADA")
                    return '<span class="badge badge-danger">'+status+'</span>';

                return '<span class="badge badge-dark">'+status+'</span>';
            }
        }
    }
</script>