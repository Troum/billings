@component('mail::message')
    # Hi, {{$name}}

    Your transfer to {{$receiver}} is done

    Amount of transfer: {{$content}}

@endcomponent
