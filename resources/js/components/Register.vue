<template>
    <b-col cols="10" class="h-100">
        <b-row align-v="center" align-h="center" class="h-100">
            <b-col cols="4">
                <b-card>
                    <b-card-body title="Register form" sub-title="Please, fill fields below">
                        <b-form id="formRegister" @submit.prevent="submit()">
                            <b-form-group label="Please, enter your name" label-for="name" id="formGroupRegisterName">
                                <b-form-input id="name" type="text" v-model="credentials.name"></b-form-input>
                            </b-form-group>
                            <b-form-group label="Please, enter your login (use e-mail)" label-for="login" id="formGroupRegisterLogin">
                                <b-form-input id="login" type="email" v-model="credentials.login"></b-form-input>
                            </b-form-group>
                            <b-form-group label="Please, enter password" label-for="password" id="formGroupRegisterPassword">
                                <b-form-input id="password" type="password" v-model="credentials.password"></b-form-input>
                            </b-form-group>
                            <b-form-group label="Confirm your password" label-for="password_confirm" id="formGroupRegisterPasswordConfirmation">
                                <b-form-input id="password_confirm" type="password" v-model="credentials.password_confirm"></b-form-input>
                            </b-form-group>
                            <b-form-invalid-feedback :state="!error">
                                Sorry, something went wrong
                            </b-form-invalid-feedback>
                            <b-button class="float-right" type="submit" variant="primary" size="lg">Register</b-button>
                        </b-form>
                    </b-card-body>
                </b-card>
            </b-col>
        </b-row>
    </b-col>
</template>

<script>
    import store from '@/js/store.js';
    export default {
        data() {
            return {
                credentials: {
                    name: null,
                    login: null,
                    password: null,
                    password_confirm: null
                },
                error: false
            }
        },
        methods: {
            submit() {
                this.$axios.post('/auth/register', {
                    name: this.credentials.name,
                    email: this.credentials.login,
                    password: this.credentials.password,
                    password_confirmation: this.credentials.password_confirm
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
