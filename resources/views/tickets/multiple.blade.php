<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Event Ticket</title>
    <style>
        body { font-family: sans-serif; }
        .qr { margin-top: 20px; }
    </style>
</head>
<body>
    @foreach ($tickets as $index => $ticket)
        <div style="text-align: center; padding: 20px; margin: 10px auto; max-width: 600px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
            <h2>{{ $event->title ?? $event->name }}</h2>
            <p>Ticket {{ $index + 1 }} of {{ count($tickets) }}</p>
            <p>Date: <b>{{ \Carbon\Carbon::parse($event->start_time)->format('F j, Y') }}</b></p>
            <p>Time: <b>{{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</b></p>
            <p>Location: <b>{{ $event->location }}</b></p>
            <p>Attendee: <b>{{ $ticket['attendee']->user->name ?? 'Guest' }}</b></p>
            <div>
                <img src="{{ $ticket['qrBase64'] }}" alt="QR Code">
                <br>
                <p>Ticket ID: {{ $ticket['ticketId'] }}</p>
            </div>
            @if (!empty($ticket['posterBase64']))
                <div>
                    <img src="{{ $ticket['posterBase64'] }}" height="300">
                </div>
            @endif
        </div>
        @if(!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach
</body>
</html>