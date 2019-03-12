@component('mail::message')
# Hi, {{$to}}

You get new transfer from {{$name}}.<br>
    @component('mail::panel')
        Amount of transfer: {{$content}}
    @endcomponent
<br>
    Email of sender is {{$email}}
@endcomponent
