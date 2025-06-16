<x-mail::message>
## A new attendee for your event
# {{ $attendee->event->name}}

The following person is attending your event:<br>

**{{ $attendee->user->name }}** ({{ $attendee->user->email }})

Your event now has **{{ $attendee->event->attendees->count() }}** attendees.

Thanks,<br>
[{{ config('app.name') }}]({{ url('/') }})
</x-mail::message>
