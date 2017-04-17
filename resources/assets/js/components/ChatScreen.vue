<template>
    <div class="chat">
        <div class="chat-history">
            <div class="media" v-for='message in messages'>
                <div class="media-left" v-if="!isMe(message.user)">
                    <img :src="message.user.avatar" width="40px" height="40px">
                </div>
                <div class="media-body">
                    <div :class="[isMe(message.user) ? 'myMessage' : 'otherMessage']">
                        <span class="message">
                            {{ message.text }}
                        </span>
                    </div>
                </div>
                <div class="media-right" v-if="isMe(message.user)">
                    <img :src="message.user.avatar" width="40px" height="40px">
                </div>
            </div>
        </div>
        <div class="input-group chat-message">
            <input type="text" class="form-control" v-model="message" @keyup.enter="postMessage">
            <div class="btn input-group-addon" @click="postMessage">&nbsp&nbsp&nbsp<i class="fa fa-paper-plane"></i>&nbsp&nbsp&nbsp</div>
        </div>
    </div>
</template>

<script>
    export default{
        data() {
            return {
                message: '',
                messages: [],
            }
        },
        mounted() {
            Echo.channel('messages').listen('.messagePosted', (data) => {
                this.messages.push(data);
            });
            $('input[type="text"]').on('click', function () {
                $("body").scrollTop(10);
                console.log('click');
            });
        },
        updated() {
            $(".chat-history").scrollTop(document.body.scrollHeight);
        },
        methods: {
            postMessage() {
                if (this.message == '') {
                    return false;
                }
                axios.post('/postmessage', {'message': this.message}).then((response) => {
                    this.message = '';
                });
            },
            isMe(user) {
                return Laravel.user.name == user.name;
            },
            float(user) {
                return this.isMe(user) ? "right" : "left";
            }
        }
    }
</script>
