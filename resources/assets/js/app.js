
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('ChatScreen', require('./components/ChatScreen.vue'));
// Vue.component('UserItem', require('./components/UserItem.vue'));

import ChatScreen from './components/ChatScreen.vue';
import UserItem from './components/UserItem.vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

const routes = [
    {path: '/', component: UserItem, name: 'user-item'},
    {path: '/chat/:id', component: ChatScreen, name: 'chat-screen'}
];

const router = new VueRouter({
    routes
});

const app = new Vue({
    el: '#app',
    data: {
        user: Laravel.user,
    },
    router
});
