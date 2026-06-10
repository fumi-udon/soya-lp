<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewReservationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $reservationId,
        public string $customerName,
        public string $bookingDate,
        public string $bookingTime,
        public int $partySize,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                (string) config('mail.from.address'),
                (string) config('mail.from_name_reservation', '[SOYA]'),
            ),
            subject: $this->formatSubject(),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.new-reservation',
        );
    }

    protected function formatSubject(): string
    {
        $prefix = (string) config('mail.from_name_reservation', '[SOYA]');
        $dateLabel = Carbon::parse($this->bookingDate)->format('n/j');
        $timeLabel = str_replace(':', 'h', $this->bookingTime);

        return sprintf(
            '%s %s, %dP, %s, %s',
            $prefix,
            $this->customerName,
            $this->partySize,
            $dateLabel,
            $timeLabel,
        );
    }
}
