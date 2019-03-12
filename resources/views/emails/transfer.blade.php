@component('mail::message')
        # Hello

        You get new transfer from {{$name}}

        Amount of transfer: {{$content}}

        Your current account balance: {{$current}}

        Email of sender is {{$email}}

@endcomponent
