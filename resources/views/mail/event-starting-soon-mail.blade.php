<x-mail::message>
### The event is starting soon:
# {{ $event->name }}

Hello {{ $attendee->user->name }},

This event that you are attending is starting soon.<br>
Go to our website to download your ticket(s).

<x-mail::button :url="url('/events/' . $event->id)" color="purple">
Visit event detail page
</x-mail::button>

Thanks,<br>
[{{ config('app.name') }}]({{ url('/') }})
</x-mail::message>
