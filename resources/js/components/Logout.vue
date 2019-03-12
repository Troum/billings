<template>

</template>

<script>
    import store from '@/js/store.js'
    export default {
        mounted () {
            localStorage.removeItem('token');
            localStorage.removeItem('user_id');
            localStorage.removeItem('amount');
            store.commit('logoutUser');
            this.$router.push({ name: 'login' });
        }
    }
</script>
