<template>
    <div class="chat" style="margin-top: -22px;">
        <div class="chat-history">
            <div class="media" v-for='message in messages'>
                <div class="media-left" v-if="isNotMe(message.user)">
                    <img :src="message.user.avatar" width="40px" height="40px">
                </div>
                <div class="media-body">
                    <div style="display: block" :style="{ textAlign: float(message.user) }">
                        <span class="message my-message" :style="{ background: background(message.user) }">
                            {{ message.text }}
                        </span>
                    </div>
                </div>
                <div class="media-right" v-if="isMe(message.user)">
                    <img :src="message.user.avatar" width="40px" height="40px">
                </div>
            </div>
        </div>
        <div class="input-group chat-message clearfix">
            <input type="text" class="form-control" v-model="message" @keyup.enter="postMessage">
            <div class="btn input-group-addon" @click="postMessage"><i class="fa fa-paper-plane"></i>Send</div>
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
            hashCode(str) { // java String#hashCode
                var hash = 0;
                for (var i = 0; i < str.length; i++) {
                   hash = str.charCodeAt(i) + ((hash << 5) - hash);
                }
                return hash;
            },
            intToRGB(i){
                var c = (i & 0x00FFFFFF).toString(16).toUpperCase();
                return "00000".substring(0, 6 - c.length) + c;
            },
            isMe(user) {
                return Laravel.user.name == user.name;
            },
            isNotMe(user) {
                return ! this.isMe(user);
            },
            background(user) {
                return this.isMe(user) ? "#b2e281" : "#fff";
            },
            float(user) {
                return this.isMe(user) ? "right" : "left";
            }
        }
    }
</script>
