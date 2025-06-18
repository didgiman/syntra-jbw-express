<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\RoundBlockSizeMode;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function downloadTickets(Event $event, User $user)
    {

        // Check if the user is the same as the logged in user, else give a 404
        if (auth()->id() !== $user->id) {
            abort(404);
        }

        // Get all attendees for the given event + user combination
        $attendees = Attendee::where('event_id', $event->id)->where('user_id', $user->id)->get();

        $ticketsData = [];

        foreach ($attendees as $attendee) {
            // Get or create token for attendee (required for ticket validation)
            if (!$attendee->token) {

                $attendee->update([
                    'token' => bin2hex(random_bytes(8))
                ]);
                
                // Refresh the model to get the updated token
                $attendee->refresh();
            }
            
            $token = $attendee->token;

            // Build the URL for the QR code
            $url = route('ticket.scan', $token);

            // Generate the QR code
            $qrCode = new QrCode(
                data: $url,
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::High,
                size: 300,
                margin: 10,
                roundBlockSizeMode: RoundBlockSizeMode::Margin,
                foregroundColor: new Color(0, 0, 0),
                backgroundColor: new Color(255, 255, 255)
            );

            $writer = new PngWriter();
            $result = $writer->write($qrCode);
            $qrBase64 = 'data:image/png;base64,' . base64_encode($result->getString());

            // Generate the PDF
            
            // Collect all ticket data
            $ticketsData[] = [
                'attendee' => $attendee,
                'ticketId' => $attendee->token,
                'qrBase64' => $qrBase64,
            ];
        }

            // Generate PDF with multiple pages
        $pdf = Pdf::loadView('tickets.multiple', [
            'event' => $event,
            'tickets' => $ticketsData
        ]);

        // Return all tickets in a single PDF
        return $pdf->download("tickets-{$ticketsData[0]['ticketId']}.pdf");
    }

    public function scan(string $token) {
        $attendee = Attendee::where('token', $token)->firstOrFail();

        if ($attendee->checked_in === 1) {
            return abort(403, 'This ticket has already been used');
        }

        $attendee->update([
            'checked_in' => 1
        ]);

        return true;
    }
}
