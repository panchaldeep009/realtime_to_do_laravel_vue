<template>
    <section class="center-container">
        <h3>To Do Task List App</h3>
        <hr>
        <div class="center">
            <RegisterUser v-if="!$root.user" />
            <div class="row">
                <Users v-if="$root.user" :user="$root.user" :users="$root.users"/>
                <Tasks v-if="$root.user" :tasks="$root.tasks"/>
            </div>
        </div>
    </section>
</template>
<script>
// Components
import RegisterUser from './components/RegisterUser';
import Users from './components/Users';
import Tasks from './components/Tasks';
export default {
    name: 'App',
    components: { RegisterUser, Users, Tasks },
}
</script>
<style lang="scss" scoped>
    @import url("../sass/component/App.scss");
</style>
