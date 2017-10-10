/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('laravchat-message', require('./components/LaravchatMessage.vue'));
Vue.component('laravchat-log', require('./components/LaravchatLog.vue'));
Vue.component('laravchat-composer', require('./components/LaravchatComposer.vue'));
Vue.component('laravchat-add', require('./components/LaravchatAdd'));
Vue.component('laravchat-thread', require('./components/LaravchatThread.vue'));

const app = new Vue({
    el: '#app',
    data: {
        messages: [],
        threads: [],
        actualthread: [],
        currentuser: [],
    },
    methods: {
        currentThread(thread) {
            this.actualthread = thread.id;
            this.threads.find(x => x.id === this.actualthread).new = false;
            axios.get('/' + this.actualthread + '/messages').then(response => {
                this.messages = response.data;
            });
        },
        submitMessage(message) {
            this.messages.push({
                message: message.message,
                user: this.currentuser.name,
                user_id: this.currentuser.id
            });
            axios.post('/' + this.actualthread + '/message', {
                message: message.message,
            });

        }
    },
    created() {
        axios.get('/user').then(response => {
            this.currentuser = response.data;

            Echo.private('App.User.' + this.currentuser.id)
                .listen('MessagePosted', (e) => {
                    if (e.message.thread_id == this.actualthread) {
                        this.messages.push({
                            message: e.message.message,
                            user: e.message.user_name,
                            user_id: e.message.user_id,
                        });
                    } else {
                        this.threads.find(x => x.id === e.message.thread_id).new = true;
                    }
                })
                .listen('ThreadPosted', (e) => {
                    this.threads.push({
                        id: e.thread.id,
                        title: e.thread.title
                    });
                });
        });

        axios.get('/threads').then(response => {
            this.threads = response.data;
            if (this.threads.length != 0) {
                this.actualthread = this.threads[0].id;
                axios.get('/' + this.actualthread + '/messages').then(response => {
                    this.messages = response.data;
                });
            }
        });



    }
});