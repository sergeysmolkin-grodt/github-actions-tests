<?php

namespace App\Mail\Appointments\Reminders;

use App\Models\Appointment;
use App\Models\AppointmentDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Traits\DateTimeTrait;

class ZoomData extends Mailable
{
    use Queueable, SerializesModels, DateTimeTrait;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected Appointment $appointment,
    )
    {
        $teacher = $appointment->teacher;
        $studentTimeZone = $appointment->student->userDetails->time_zone;

        $appointmentDateTimeFrom = $this->convertDateTimeToTimeZone("$appointment->date $appointment->from", $studentTimeZone);
        $appointmentDateTimeTo = $this->convertDateTimeToTimeZone("$appointment->date $appointment->to", $studentTimeZone);
        $this->subject = 'Your session with ' . $teacher->firstname . ' ' . $teacher->lastname . ' will start soon on ' . $appointmentDateTimeFrom->format('d/m/Y') . ' at ' . $appointmentDateTimeFrom->format('H:i') . '-' . $appointmentDateTimeTo->format('H:i');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        return new Envelope(
            subject: $this->subject
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointments.reminders.zoom_data',
            with: [
                      'zoomLink' => unserialize($this->appointment->appointmentDetails->zoom_data, ['allowed_classes' => false])['join_url'],
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
