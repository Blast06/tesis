<template>
    <div class="contact-list">
        <div class="contact" v-for="conversation in conversations">
            <img :src="conversation.website.image_path" :alt="conversation.website.name">
            <div class="contact-preview">
                <div class="contact-text">
                    <h1 class="font-name" v-text="conversation.website.name"></h1>
                    <p class="font-preview">
                        {{ conversation.messages[0].message }}
                    </p>
                </div>
            </div>
            <div class="contact-time">
                <p>{{ conversation.messages[0].created_at | moment("h:mm a") }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "user-conversation",
        props: ['conversations'],

    }
</script>