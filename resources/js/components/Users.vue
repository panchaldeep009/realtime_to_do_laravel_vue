<template>
<div>
    <span class="text-center m-8">Users</span>
    <ul class="list-group">
        <li class="list-group-item active">{{user.to_do_user_name}}</li>
        <li class="list-group-item" 
            v-for="({to_do_user_name, online, updated_at}, index) 
                in users.slice(0).filter(({online}) => online)" :key="index">
                {{to_do_user_name}}<br/>
            <span class="text-success">online</span>
        </li>
        <li class="list-group-item" 
            v-for="({to_do_user_name, online, updated_at}, index) 
                in users.slice(0).filter(({online}) => !online)" :key="index">
                {{to_do_user_name}}<br/>
            <span class="text-muted">{{ updated_at}}</span>
        </li>
    </ul>
</div>
</template>
<script>
export default {
    name: 'Users',
    props: ['user', 'users'],
    methods: {

    },
}
</script>
<style lang="sass" scoped>

</style>
