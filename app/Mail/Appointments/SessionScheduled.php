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

class SessionScheduled extends Mailable
{
    use Queueable, SerializesModels, DateTimeTrait;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public readonly User $student,
        public readonly Appointment $appointment,
        public readonly string $emailSubject,
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
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointments.session_scheduled',
            with: [
                'subject' => $this->emailSubject,
                'appointmentId' => $this->appointment->id,
                'studentName' => $this->student->firstname . ' ' . $this->student->lastname,
                'mobile' => $this->student->userDetails->country_code . $this->student->userDetails->mobile,
                'appointmentDateTime' => $this->getDMYSlashFormat($this->appointment->date) . ' ' . $this->appointment->from . ' - ' . $this->appointment->to
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
