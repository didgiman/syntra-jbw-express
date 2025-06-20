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
        <div style="text-align: center; padding: 20px; margin: 10px auto; max-width: 600px; border-radius: 5px; background-color: #1e2939;">
            <img src="{{ $_SERVER['DOCUMENT_ROOT'] . '/logo-pdf.png' }}">
        </div>
        <table style="width: 640px; padding: 20px; margin: 10px auto; border: 1px solid #1e2939; border-radius: 5px; background-color: #e5e7eb;" align="center">
            <tr>
                <td>
                    <h2>{{ $event->title ?? $event->name }}</h2>
                    <p>Ticket <b>{{ $index + 1 }}</b> of <b>{{ count($tickets) }}</b></p>
                    <p><b>Date:</b> {{ \Carbon\Carbon::parse($event->start_time)->format('F j, Y') }}</p>
                    <p><b>Time:</b> {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</p>
                    <p><b>Location:</b> {{ $event->location }}</p>
                    <p><b>Attendee:</b> {{ $ticket['attendee']->user->name ?? 'Guest' }}</p>
                </td>
                <td style="text-align: center;">
                    <img src="{{ $ticket['qrBase64'] }}" alt="QR Code" width="150">
                    <br>
                    <p>Ticket ID:<br>{{ $ticket['ticketId'] }}</p>
                </td>
            </tr>
            @if ($event->image != '/no-event-poster.webp')
                <tr>
                    <td colspan="2" style="height: 500px; text-align: center; background-image: url('{{ $_SERVER['DOCUMENT_ROOT'] . $event->image }}'); background-size: cover; background-repeat: no-repeat; background-position: center center;">

                    </td>
                </tr>
            @endif
        </table>
        @if(!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach
</body>
</html>