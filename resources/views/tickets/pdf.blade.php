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
    <h1>{{ $eventName }}</h1>
    <p>Ticket ID: {{ $ticketId }}</p>
    <div class="qr">
        <img src="data:image/png;base64,{{ $qrBase64 }}" alt="QR Code">
    </div>
</body>
</html>