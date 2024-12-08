<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function build()
    {
        return $this->view('emails.reservation_confirmed')
                ->subject('Reservation Confirmation');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reservation Confirmed',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation_confirmed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
