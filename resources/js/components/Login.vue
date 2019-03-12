<template>
    <b-col cols="10" class="h-100">
        <b-row align-v="center" align-h="center" class="h-100">
            <b-col cols="4">
                <b-card>
                    <b-card-body title="Login form" sub-title="Please, fill fields below">
                        <b-form id="formLogin" @submit.prevent="submit()">
                            <b-form-group label="Login" label-for="login" id="formGroupLogin">
                                <b-form-input id="login" type="email" v-model="credentials.login"></b-form-input>
                            </b-form-group>
                            <b-form-group label="Password" label-for="password" id="formGroupPassword">
                                <b-form-input id="password" type="password" v-model="credentials.password"></b-form-input>
                            </b-form-group>
                            <b-form-invalid-feedback :state="!error">
                                Sorry, something went wrong
                            </b-form-invalid-feedback>
                            <b-button class="float-right" type="submit" variant="primary" size="lg">Login</b-button>
                            <router-link to="/register" class="nav-link float-left">Register</router-link>
                        </b-form>
                    </b-card-body>
                </b-card>
            </b-col>
        </b-row>
    </b-col>
</template>

<script>
    import store from  '@/js/store.js';
    export default {
        data() {
          return {
              credentials: {
                  login: null,
                  password: null
              },
              error: false
          }
        },
        methods: {
            submit() {
                this.$axios.post('/auth/login', {
                    email: this.credentials.login,
                    password: this.credentials.password
                }).then(response => {
                    store.commit('loginUser');
                    localStorage.setItem('token', response.data.access_token);
                    localStorage.setItem('user_id', response.data.user_id);
                    this.$router.push({ name: 'dashboard' })
                }).catch(error => {
                    this.error = true
                });
            }
        }
    }
</script>

<style scoped>

</style>
