<template>
    <section class="right">
        <div class="chat-head" v-if="website">
            <img :src="current_conversation.user.avatar">
            <div class="chat-name">
                <h1 class="font-name chat-name-h1" v-text="current_conversation.user.name"></h1>
                <p class="font-online">(809) 574-6565</p>
            </div>
            <i class="fa fa-bars fa-lg" aria-hidden="true" id="show-contact-information"></i>
        </div>
        <div class="chat-head" v-else>
            <img :src="current_conversation.website.image_path">
            <div class="chat-name">
                <h1 class="font-name chat-name-h1" v-text="current_conversation.website.name"></h1>
                <p class="font-online">(809) 574-6565</p>
            </div>
            <i class="fa fa-bars fa-lg" aria-hidden="true" id="show-contact-information"></i>
        </div>
        <div class="wrap-chat">
            <div class="chat">
                <div v-for="message in messages"
                     :class="[ message.user_send === user.id  ? 'chat-bubble me' : 'chat-bubble you']">

                    <div :class="[ message.user_send === user.id  ? 'my-mouth' : 'your-mouth']"></div>
                    <div class="content" v-text="message.message"></div>
                    <div class="time">{{ message.created_at | moment("h:mm a") }} </div>

                </div>
            </div>
            <div class="information"></div>
        </div>
        <div class="wrap-message">
            <i class="fa fa-smile-o fa-lg" aria-hidden="true"></i>
            <div class="message">
                <input type="text" class="input-message" placeholder="Escribe un mensaje aquí" v-model="newMessage">
            </div>
            <i class="fas fa-play" @click="sendMessage"></i>
        </div>
    </section>
</template>

<script>
    export default {
        name: "message-component",
        props: ['website', 'user', 'current_conversation'],
        data(){
          return{
              messages: [],
              newMessage: ''
            }
        },
        created() {
            this.getMessage();
            this.listenMessage();
        },
        watch: {
            current_conversation() {
                this.getMessage();
                this.listenMessage();
            }
        },
        methods: {
            listenMessage() {
                Echo.private('Conversation.' + this.current_conversation.id)
                    .listen('.newMessage', (event) => {
                        this.messages.push(event.message);
                    });
            },
            getMessage(){
                axios.get(`/messages/conversations/${this.current_conversation.id}`)
                    .then(response => {
                        this.messages = response.data.data;
                    });
            },
            sendMessage(){
                if (this.website) {
                   return this.sendMessageToUser();
                }
                this.sendMessageToWebsite();
            },
            sendMessageToUser() {
                axios.post(window.location.href, {
                    user_id: this.current_conversation.user_id,
                    message: this.newMessage
                }).then(response => {
                    this.newMessage = '';
                    this.messages.push(response.data.data);
                });
            },
            sendMessageToWebsite() {
                axios.post(window.location.href, {
                    website_id: this.current_conversation.website_id,
                    message: this.newMessage
                }).then(response => {
                    this.newMessage = '';
                    this.messages.push(response.data.data);
                });
            }
        }
    }
</script>

<style scoped>
    .chat-name-h1 {
        margin-top: 0.9rem !important;
        margin-bottom: 0 !important;
    }
</style>