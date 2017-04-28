<template>
    <div class="user-list">
        <div class="media user-item" v-for="message in messages">
            <router-link :to="{name: 'chat-screen', params: {id: user(message).id}}">
                <div class="media-left">
                    <img :src="user(message).avatar" width="40px" height="40px">
                </div>
                <div class="media-body">
                    <h4 class="media-heading">{{ user(message).name }}</h4>
                    {{ message.body }}
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'UserItem',
        data () {
            return {
                messages: []
            }
        },
        mounted () {
            axios.get('http://laravel-echo.laravel.dev/message').then(response => {
                this.messages = response.data;
            });
        },
        methods: {
            user (message) {
                return message.from_user_id == Laravel.user.id ? message.to : message.from;
            }
        }
    }
</script>

<style>

</style>