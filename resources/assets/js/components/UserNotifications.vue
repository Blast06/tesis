<template>
    <li>
        <a href="/notifications">
            <i class="fas fa-bell fa-lg"></i>
            <span class="badge badge-pill badge-danger" v-if="count > 0">{{ count}}</span>
        </a>
    </li>
</template>

<script>
    export default {
        name: "user-notifications",
        props: ['user_id'],
        data() {
          return {
              count: 0
          }
        },
        created(){
            this.countDatabaseNotification();
            this.listEvent();
        },
        methods: {
            countDatabaseNotification(){
                axios.get('/notifications/count')
                    .then(response => { this.count = response.data.count; });
            },
            listEvent(){
                Echo.private('User.'+this.user_id)
                    .notification((notification) => {
                        this.count++;
                    });
            },
        }
    }
</script>

<style scoped>

</style>