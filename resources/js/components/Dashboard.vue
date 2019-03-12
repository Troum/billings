<template>
    <b-col cols="12" class="h-100">
        <b-row class="h-100" align-h="center" align-v="center">
            <b-col cols="4">
                <b-card title="List of registered users" sub-title="You can choose anyone">
                    <b-card-body>
                        <b-table :current-page="currentPage" :per-page="perPage" striped hover :items="users" :fields="fields" />
                        <b-pagination align="center" v-model="currentPage" :total-rows="total" :per-page="perPage" size="md" />
                    </b-card-body>
                </b-card>
            </b-col>
            <b-col cols="7">
                <b-card>
                    <b-card-body>
                        <b-form @submit="search">
                            <b-form-group id="searchingFormGroup"
                                          label="Search field"
                                          label-for="searchingNeedle">
                                <b-form-input @focus="onFocus()" id="searchingNeedle" type="text" placeholder="Write your searching query here..." v-model="query" autocomplete="off"></b-form-input>
                                <b-form-invalid-feedback :state="!error">
                                    {{error}}
                                </b-form-invalid-feedback>
                            </b-form-group>
                            <b-button type="submit" variant="primary" v-if="!loading">Search</b-button>
                            <b-button type="button" variant="primary" v-if="loading">Searching</b-button>
                        </b-form>
                        <b-row class="list-group" id="searchingResults" v-for="(item, i) in searching" :key="i">
                            <b-col cols="10" class="item" align-self="center">
                                <div class="thumbnail">
                                    <b-row>
                                        <b-col cols="6">
                                            <p class="lead">{{ item.name }}</p>
                                        </b-col>
                                        <b-col cols="6" class="text-right">
                                            <b-button @click="passData(item)" type="button" v-b-modal.money variant="success">Send money</b-button>
                                        </b-col>
                                    </b-row>
                                </div>
                            </b-col>
                        </b-row>
                    </b-card-body>
                </b-card>
            </b-col>
        </b-row>
        <money-modal :data="usersData" :amount="userAccount"></money-modal>
    </b-col>
</template>

<script>
    import Modal from '@/js/components/Modal';
    export default {
        components: {
          moneyModal: Modal
        },
        data() {
            return {
                users: null,
                currentPage: 1,
                perPage: 10,
                total: null,
                fields: {
                    id: {
                        label: '#',
                        sortable: true
                    },
                    name: {
                        label: 'User name'
                    },
                    email: {
                        label: 'User email'
                    }
                },
                searching: [],
                loading: false,
                error: false,
                query: '',
                usersData: null,
                userAccount: null
                
            }
        },
        mounted() {
            this.getUsers();
            this.getUserAccount();
        },
        methods: {
            getUserAccount() {
                this.$axios
                    .get('/auth/user/account', {
                        params: {id: localStorage.getItem('user_id')}
                    })
                    .then(response => {
                        localStorage.setItem('amount', response.data.amount);
                        this.userAccount = localStorage.getItem('amount');
                    })
                    .catch(error => {
                        console.log(error.response.data.error);
                    })
            },
            getUsers() {
                this.$axios
                    .get('/auth/users')
                    .then(response => {
                        this.users = response.data.users;
                        this.total = this.users.length;
                    })
                    .catch(error => {
                        console.log(error.response.data.error);
                    })
            },
            search(event) {
                event.preventDefault();
                this.error = '';
                this.searching = [];
                this.loading = true;
                this.$axios.get('/auth/search?q=' + this.query).then((response) => {
                    response.data.error ? this.error = response.data.error : this.searching = response.data;
                    this.loading = false;
                    this.query = '';
                });
            },
            onFocus() {
                if(typeof this.error === 'string') {
                    this.error = false;
                }
            },
            passData(item) {
                this.usersData = item;
            }
        }
    }
</script>

<style scoped>

</style>
