<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
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
    public function downloadTicket(Attendee $attendee)
    {

        // Get or create token for attendee (required for ticket validation)
        if (!$attendee->token) {

            $attendee->update([
                'token' => bin2hex(random_bytes(16))
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

        // Read the image file and encode it to base64
        $image = $attendee->event->image;
        $base64Image = '';
        if ($image !== '/no-event-poster.webp') {
            $relativePath = str_replace('/storage', '', $image);
            $fullPath = storage_path('app/public' . $relativePath);

            // Format the base64 string for use in HTML
            try {
                $imageData = base64_encode(file_get_contents($fullPath));
                $base64Image = 'data:image/png;base64,' . $imageData;
            } catch (\Exception $e) {
                // Log the error and set a default value
                Log::error('Failed to read image file: ' . $e->getMessage());
                $base64Image = '';
            }
        }
        
        $pdf = Pdf::loadView('tickets.pdf', [
            'event' => $attendee->event,
            'attendee' => $attendee,
            'ticketId' => $token,
            'qrBase64' => $qrBase64,
            'posterBase64' => $base64Image
        ]);

        return $pdf->download("ticket-{$token}.pdf");
    }

    public function scan(string $token) {
        $attendee = Attendee::where('token', $token)->firstOrFail();

        if ($attendee->status === 'checked-in') {
            return abort(403, 'This ticket has already been used');
        }

        $attendee->update([
            'status' => 'checked-in'
        ]);

        return true;
    }
}
