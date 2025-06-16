<x-mail::message>
### Update for your event:
# {{ $event->name }}

Hello {{ $attendee->user->name }},

This event that you are attending has been updated.<br>
Go to our website to see the new information about the event.

<x-mail::button :url="url('/events/' . $event->id)" color="purple">
Visit event detail page
</x-mail::button>

Thanks,<br>
[{{ config('app.name') }}]({{ url('/') }})
</x-mail::message>
