import Vue from "vue";
import App from "./App.vue";
import axios from 'axios';

new Vue({
    el: "#app",
    data: {
        user: false,
        users: [],
        tasks: [],
        UserRefresh: null
    },
    methods: {
        fetchUser(){

            axios.get('/api/users',
                { headers: { "X-CSRF": window.Laravel.csrfToken } })
            .then((response) => {
                if(response.status == 200){
                    this.users = response.data.users
                    this.user = response.data.this_user
                } else {
                    this.errors.fetchUser = error;
                }
            });

        },
        fetchTasks(){
            axios.get('/api/tasks',
                { headers: { "X-CSRF": window.Laravel.csrfToken } })
            .then((response) => {
                if(response.status == 200){
                    this.tasks = response.data.tasks
                } else {
                    this.errors.fetchTasks = error;
                }
            });

        },
    },
    mounted() {
        // V 1.0 Http Request Real-time
        this.UserRefresh = setInterval(() => {
            this.fetchUser();
            this.fetchTasks();
        }, 1200);

        // V 2.0 Websocket Event
    },
    componentWillUnmount() {
        this.UserRefresh.clearInterval();
    },
    components: { App },
    template: "<App/>"
});