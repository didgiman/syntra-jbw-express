<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Http\Request;

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

        $ticketId = $this->encrypt_id($attendee->id);

        // $url = 'http://localhost:8000/scan.php?id=' . urlencode($ticketId);

        $url = url(route('ticket.scan', urlencode($ticketId)));

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
        $qrBase64 = base64_encode($result->getString());

        $pdf = Pdf::loadView('tickets.pdf', [
            'eventName' => 'Hello',
            'ticketId' => $ticketId,
            'qrBase64' => $qrBase64
        ]);

        return $pdf->download("ticket-{$ticketId}.pdf");
    }

    private function encrypt_id($id) {
        $key = "QRTickets2025Salt"; // Made key 16 bytes
        $iv = str_repeat("0", 16);  // Create 16-byte IV
        return base64_encode(openssl_encrypt($id, 'AES-256-CBC', $key, 0, $iv));
    }
}
