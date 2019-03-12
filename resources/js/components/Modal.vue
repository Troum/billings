<template>
    <b-modal size="xl" id="money" centered title="User account">
        <b-row>
            <b-col cols="6">
                <p class="my-4">
                    <strong>NAME: </strong>{{ data === null ? '' : data.name }}
                </p>
                <p class="my-4">
                    <strong>EMAIL: </strong>{{ data === null ? '' : data.email }}
                </p>
            </b-col>
            <b-col cols="6">
                <b-form @submit.prevent="planTransfer()">
                    <b-form-group label="Please, choose time, when you would like to make transfer">
                        <vue-ctk-date-time-picker @input="selectDatetime" v-model="datetime" :locale="'en'" :format="'YYYY-MM-DD HH:mm:ss'" :error="error ? error : false" :hint="error ? 'You choose lower date, please choose date that higher than now' : ''"></vue-ctk-date-time-picker>
                    </b-form-group>
                    <b-form-group label="Please, enter amount of money that you would like to transfer">
                        <b-form-input @focus="onFocus()" type="text" v-model="selectedAmount" placeholder="Enter amount like 123.45" pattern="\d+(\.\d{2})?" required></b-form-input>
                    </b-form-group>
                    <b-button type="submit" variant="primary">Plan transfer</b-button>
                </b-form>
                <b-alert dismissible
                         class="mt-4 mb-4" variant="danger"
                         v-model="amountError">
                    Sorry, but your account balance cannot be used to make transfer
                </b-alert>
                <b-alert dismissible
                         class="mt-4 mb-4" variant="danger"
                         v-model="plannedError">
                    {{ plannedErrorMessage }}
                </b-alert>
                <b-alert dismissible
                         class="mt-4 mb-4" variant="success"
                         v-model="planned">
                    {{ plannedMessage }}
                </b-alert>
            </b-col>
        </b-row>
    </b-modal>
</template>
<script>
    import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
    export default {
        components: {
            VueCtkDateTimePicker
        },
        props: {
            data: null,
            amount: null
        },
        data() {
            return {
                datetime: '',
                selectedAmount: null,
                currentUserAmount: null,
                error: false,
                errorMessage: '',
                amountError: false,
                planned: false,
                plannedError: false,
                plannedErrorMessage: '',
                plannedMessage: '',
                transferData: {
                    from: null,
                    to: null,
                    amount: null,
                    when: null
                }
            }
        },
        methods: {
            planTransfer() {
                if(this.checkAmount(this.convertToDecimal(this.selectedAmount))) {
                    this.amountError = true
                } else {
                    this.transferData.from = Number(localStorage.getItem('user_id'));
                    this.transferData.to = this.data.id;
                    this.transferData.amount = this.convertToDecimal(this.selectedAmount);
                    this.transferData.when = this.datetime;
                    this.$axios
                        .post('/auth/user/plan-transfer', this.transferData)
                        .then(response => {
                            this.planned = !this.planned;
                            this.plannedMessage = response.data.success;
                            localStorage.setItem('amount',response.data.amount);
                            this.update();
                            this.datetime = '';
                            this.selectedAmount = null;
                        })
                        .catch(error => {
                            this.plannedError = true;
                            this.plannedErrorMessage = error.response.data.error;
                        })
                }

            },
            convertToDecimal(string) {
                return parseFloat(string).toFixed(2);
            },
            selectDatetime(event) {
                if (new Date(event).getTime() < new Date().getTime()) {
                    this.error = true;
                } else {
                    this.error = false;
                    this.datetime = event;
                }
            },
            checkAmount(amount) {
                if( (this.convertToDecimal(this.amount) - amount).toFixed(2) <= 0) {
                    return true;
                }
            },
            onFocus() {
                if(this.amountError) {
                    this.amountError = false;
                }
            },
            update() {
                this.$emit('update', this.convertToDecimal(localStorage.getItem('amount')));
            }
        }
    }
</script>

<style scoped>

</style>

