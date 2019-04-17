<template>
    <section class="center-container">
        <div class="center">
            <RegisterUser v-if="!$root.user" />
            <Users v-if="$root.user" :user="$root.user" :users="$root.users"/>
        </div>
    </section>
</template>
<script>
// Components
import RegisterUser from './components/RegisterUser';
import Users from './components/Users';
export default {
    name: 'App',
    components: { RegisterUser, Users },
}
</script>
<style lang="scss" scoped>
    @import url("../sass/component/App.scss");
</style>
