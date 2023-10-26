<?php

namespace App\Mail\Appointments;

use App\Models\Appointment;
use App\Models\AppointmentDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Traits\DateTimeTrait;
use Illuminate\Http\Client\Response;

class FailedSendingMessageViaCommbox extends Mailable
{
    use Queueable, SerializesModels, DateTimeTrait;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public readonly object $messageResponse,
        public readonly string $messageType,
        public readonly string $phoneNumber,
    )
    {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Commbox API failure',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointments.failed_commbox',
            with: [
                'commboxResponse' => serialize($this->messageResponse),
                'messageType' => $this->messageType,
                'phoneNumber' => $this->phoneNumber
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
