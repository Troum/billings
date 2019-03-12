@component('mail::message')
    # Hi, {{$name}}

    You send new transfer to {{$to}}.<br>
    @component('mail::panel')
        Amount of transfer: {{$content}}
    @endcomponent
@endcomponent
