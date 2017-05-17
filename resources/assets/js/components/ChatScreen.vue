<template>
    <div class="chat">
        <div class="chat-history">
            <div class="media" v-for='message in messages'>
                <div class="media-left" v-if="!isMe(message.from)">
                    <img :alt="message.from.name" :src="message.from.avatar" width="40px" height="40px">
                </div>
                <div class="media-body">
                    <div :class="[isMe(message.from) ? 'myMessage' : 'otherMessage']">
                        <span class="message">
                            {{ message.body }}
                        </span>
                    </div>
                </div>
                <div class="media-right" v-if="isMe(message.from)">
                    <img :alt="message.from.name" :src="message.from.avatar" width="40px" height="40px">
                </div>
            </div>
        </div>
        <div class="input-group chat-message">
            <input type="text" class="form-control" v-model="body" @keyup.enter="postMessage">
            <div class="btn input-group-addon" @click="postMessage">&nbsp&nbsp&nbsp<i class="fa fa-paper-plane"></i>&nbsp&nbsp&nbsp</div>
        </div>
    </div>
</template>

<script>
    export default{
        name: 'ChatScreen',
        data() {
            return {
                to: 0,
                body: '',
                messages: [],
            }
        },
        mounted() {
            this.to = this.$route.params.id;
            axios.get('/message/'+this.to).then(response => {
                this.messages = response.data.data.reverse();
            });
            Echo.channel('messages').listen('.messagePosted', (data) => {
                if ((data.from.id == Laravel.user.id && data.to.id == this.to) || (data.to.id == Laravel.user.id && data.from.id == this.to)) {
                    this.messages.push(data);
                }
            });
            $('input[type="text"]').on('click', function () {
                $(".chat-history").scrollTop(document.documentElement.clientHeight);
            });
        },
        updated() {
            $(".chat-history").scrollTop(document.body.scrollHeight);
        },
        methods: {
            postMessage() {
                if (this.body == '') {
                    return false;
                }
                axios.post('/message/'+this.to, {body: this.body}).then((response) => {
                    this.body = '';
                });
            },
            isMe(user) {
                return Laravel.user.id == user.id;
            },
            float(user) {
                return this.isMe(user) ? "right" : "left";
            }
        }
    }
</script>
