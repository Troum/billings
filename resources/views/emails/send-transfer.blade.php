@component('mail::message')
    # Hi, {{$name}}

    Your transfer to {{$receiver}} is done

    Amount of transfer: {{$content}}

@endcomponent
app/Console/Commands/SendPlannedTransfers.php app/Mail/SendTransferMail.php app/Mail/TransferMail.php resources/views/emails/send-transfer.blade.php resources/views/emails/transfer.blade.php
