<x-mail::message>
### New contact case created
# EventR case id: {{ $contactMessage->id }} | {{ $contactMessage->subject }}

<table style="width:100%; border-collapse: collapse;">
    <tr>
        <td style="font-weight: bold; padding: 4px; border: 1px solid #ddd;">Case id</td>
        <td style="padding: 4px; border: 1px solid #ddd;">{{ $contactMessage->id }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; padding: 4px; border: 1px solid #ddd;">From</td>
        <td style="padding: 4px; border: 1px solid #ddd;">{{ $contactMessage->name }} - {{ $contactMessage->email }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; padding: 4px; border: 1px solid #ddd;">Subject</td>
        <td style="padding: 4px; border: 1px solid #ddd;">{{ $contactMessage->subject }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; padding: 4px; border: 1px solid #ddd;">Message</td>
        <td style="padding: 4px; border: 1px solid #ddd;">{{ $contactMessage->message }}</td>
    </tr>
</table>
<br>
You can reply to this email, to contact the sender.
</x-mail::message>