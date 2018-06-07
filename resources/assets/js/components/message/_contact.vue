<template>
    <div class="contact" @click="$emit('contactClick', conversation)">
        <img :src="conversation.user.avatar" :alt="conversation.user.name" v-if="conversation.hasOwnProperty('user')">
        <img :src="conversation.website.image_path" :alt="conversation.website.name" v-else>
        <div class="contact-preview">
            <div class="contact-text">
                <h1 class="font-name" v-text="conversation.user.name" v-if="conversation.hasOwnProperty('user')"></h1>
                <h1 class="font-name" v-text="conversation.website.name" v-else></h1>
                <p class="font-preview" v-if="conversation.messages.length > 0">
                    {{ conversation.messages[0].message }}
                </p>
            </div>
        </div>
        <div class="contact-time" v-if="conversation.messages.length > 0">
            <p>{{ conversation.messages[0].created_at | moment("h:mm a") }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "contact-list",
        props: ['conversation'],
        created() {
            this.listenMessage();
        },
        methods: {
            listenMessage() {
                Echo.private('Conversation.' + this.conversation.id)
                    .listen('.newMessage', (event) => {
                        this.conversation.messages = [ event.message ];
                    });
            }
        }
    }
</script>