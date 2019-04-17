import Vue from "vue";
import App from "./App.vue";

new Vue({
    el: "#app",
    data: {
        user: false,
        users: [],
        UserRefresh: null
    },
    methods: {
        fetchJSON(url, success, error, perms){
            fetch(url, {
                ...perms,
                headers: {
                    "X-CSRF": window.Laravel.csrfToken
                }
            })
            .then(data => data.json())
            .then(response => {
                if(response.status == 200){
                    success(response);
                } else {
                    error(response);
                }
            });

        },
        fetchUser(){
            this.fetchJSON("/api/users", 
                ({this_user, users}) => {
                    this.users = users
                    this.user = this_user
                }, 
                ({error}) => this.errors.fetchUser = error);
        },
        KeepMeOnline(){
            this.fetchJSON("/api/keepOnline");
        }
    },
    mounted() {
        // V 1.0 Http Request Real-time
        this.UserRefresh = setInterval(() => {
            this.fetchUser();
            if(this.user){
                this.KeepMeOnline()
            }
        }, 1200);

        // V 2.0 Websocket Event
    },
    componentWillUnmount() {
        this.UserRefresh.clearInterval();
    },
    components: { App },
    template: "<App/>"
});