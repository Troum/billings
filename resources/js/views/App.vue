<template>
    <div class="h-100">
        <b-container fluid class="m-0 p-0 h-100">
            <b-navbar toggleable="lg" type="dark" variant="info">
                <b-navbar-brand href="#">Billings</b-navbar-brand>

                <b-navbar-toggle target="nav_collapse" />

                <b-collapse is-nav id="nav_collapse">
                    <b-navbar-nav>
                        <b-nav-item>
                            <router-link class="nav-link" to="/dashboard">Dashboard</router-link>
                        </b-nav-item>
                    </b-navbar-nav>
                    <b-navbar-nav class="ml-auto">
                        <b-nav-item>
                            <router-link class="nav-link" to="/logout">Logout</router-link>
                        </b-nav-item>
                    </b-navbar-nav>
                </b-collapse>
            </b-navbar>
            <b-row class="h-100" align-v="center" align-h="center">
                <router-view></router-view>
            </b-row>
        </b-container>
    </div>

</template>

<script>
    import store from '@/js/store.js';
    export default {
        created() {
            if(localStorage.token) {
                this.$axios.get('/api/user', {
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    },
                ).then(response => {
                    store.commit('loginUser');
                }).catch(error => {
                    if (error.response.status === 401 || error.response.status === 403) {
                        store.commit('logoutUser');
                        localStorage.setItem('token', '');
                        this.$router.push({name: 'login'});
                    }

                });
            }

        }
    }
</script>

<style scoped>

</style>
