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

class UnbookedSessions extends Mailable
{
    use Queueable, SerializesModels, DateTimeTrait;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected array $notBookedSloats,
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Unbooked sessions found',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointments.unbooked_sessions',
            with: [
                      'notBookedSloats' => $this->notBookedSloats,
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
