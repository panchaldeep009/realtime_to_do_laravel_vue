<template>
    <div class="card text-center" >
        <div class="card-body">
            <h5 class="card-title">Register User</h5>
            <p class="card-text text-danger">{{error}}</p>
            <form @submit.prevent="registerUser">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">@</span>
                    </div>
                    <input v-model="user_name" type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="basic-addon1">
                </div>
                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    name: 'RegisterUser',
    data() {
        return {
            user_name: "",
            error: ""
        }
    },
    methods: {
        registerUser(){
            axios.post('/api/user', {
                user_name: this.user_name},
                { headers: { "X-CSRF": window.Laravel.csrfToken } })
            .then((response) => {
                if(response.status == 200){
                    this.error = "";
                } else {
                    this.error = response.data.error;
                }
            });
        }
        
    },
}
</script>
<style lang="sass" scoped>

</style>
