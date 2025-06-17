<x-mail::message>
### Your message has been received successfully
# EventR case id: {{ $contactMessage->id }} | {{ $contactMessage->subject }}

Hello {{ $contactMessage->name }},

Thank you for contacting our customer helpdesk.<br>
We have successfully received your message:<br>

{{ $contactMessage->message }}

We are investigating your concern and will be getting back to you shortly.

Kind regards,

The [{{ config('app.name') }}]({{ url('/') }}) Team
</x-mail::message>