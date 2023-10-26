<?php

namespace App\Jobs\Cron;

use App\Exceptions\CouldNotSendPushNotification;
use App\Mail\Appointments\FailedSendingMessageViaCommbox;
use App\Models\Appointment;
use App\Models\Reminder;
use App\Models\User;
use App\Models\UserDetails;
use App\Services\CommboxService;
use App\Services\FCMService;
use App\Services\TwilioService;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendReminder extends ProcessCronJob
{

    private Reminder $reminder;
    private CommboxService $commboxService;
    private FCMService $FCMService;
    private TwilioService $twilioService;
    public function __construct(Reminder $reminder)
    {
        $this->reminder = $reminder;
        $this->commboxService = app(CommboxService::class);
        $this->FCMService = app(FCMService::class);
        $this->twilioService = app(TwilioService::class);
    }

    public function handle(): void
    {
        $messageTypeData = config('reminders.message_types.' . $this->reminder->type . '.' . $this->reminder->message_type);
        $model = $this->reminder->model;

        if ($model instanceof Appointment) {
            $student = $model->student;
            $studentDetails = $student->userDetails;
            $locale = $studentDetails->language;
            App::setLocale($locale);

            switch($this->reminder->type) {
                case config('reminders.channels.email'):
                    $this->sendEmailReminder($student->email, $locale, $model, $messageTypeData);
                    break;
                case config('reminders.channels.whatsapp'):
                    $this->sendWhatsAppReminder($student->email, $studentDetails, $model);
                    break;
                case config('reminders.channels.push'):
                    $this->sendPushReminder($model->id, $student);
                    break;
                case config('reminders.channels.ivr'):
                    $this->sendIvrReminder($studentDetails, $locale, $model->id);
                    break;
            }
        }
    }

    private function sendIvrReminder(UserDetails $studentDetails, string $locale, int $appointmentId): void
    {
        try {
            $this->twilioService->sendIRVMessage($studentDetails->mobile, $locale, $studentDetails->country_code);
        } catch (CouldNotSendIvrMessage $e) {
            Log::error("Ivr reminder of type {$this->reminder->message_type} regarding Appointment ID {$appointmentId} wasn't sending to the User ID {$studentDetails->user_id} on the phone number {$studentDetails->country_code}{$studentDetails->mobile} due to error: " . $e->getMessage());
        }

        // ToDo: log reminder if need it ('addIVRTrackData' in old system)
    }

    private function sendPushReminder(int $appointmentId, User $student): void
    {
        $payload = [
            'appointmentId' => $appointmentId,
            'notificationType' => config('app.notifications_types.reminder')
        ];
        $deviceTokens = $student->userDevices->pluck('device_token')->toArray();

        try {
            $this->FCMService->sendPushNotifications(
                deviceTokens: $deviceTokens,
                title: __(config("reminders.message_types.{$this->reminder->type}.{$this->reminder->message_type}.title")),
                body: __(config("reminders.message_types.{$this->reminder->type}.{$this->reminder->message_type}.message")),
                payload: $payload,
                userId: $student->id
            );
        } catch (CouldNotSendPushNotification $e) {
            Log::error("Push reminder of type {$this->reminder->message_type} regarding Appointment ID {$appointmentId} wasn't sending to the User ID {$student->id}");
        }

    }

    private function sendWhatsAppReminder(string $email, UserDetails $studentDetails, Appointment $appointment): void
    {
        $phoneNumber = $studentDetails->country_code . $studentDetails->mobile;
        $template = config("reminders.message_types.{$this->reminder->type}.{$this->reminder->message_type}.template");

        $parameters = $this->formParameters($this->reminder, $appointment, $studentDetails);

        $messageResponse = $this->commboxService->sendMessage($phoneNumber, $template, $studentDetails->language, $parameters);

        if ($messageResponse->status !== 200) {
            Mail::to($email)->send(new FailedSendingMessageViaCommbox(
                messageResponse: $messageResponse,
                messageType: $template,
                phoneNumber: $phoneNumber,
            ));

            Log::error("WhatsApp reminder template message $template wasn't sending on the number $phoneNumber due to error: $messageResponse");
        }
        // ToDo: log reminder if need it ('addWPReminderLog' in old system)
    }
    private function sendEmailReminder(string $email, string $locale, Appointment $appointment, Mailable $processor): void
    {
        Mail::to($email)->locale($locale)->send(new $processor(
            appointment: $appointment
        ));
    }

    private function formParameters(Reminder $reminder, Appointment $appointment, UserDetails $studentDetails): array
    {
        $parameters = [];
        foreach(config("reminders.message_types.{$reminder->type}.{$reminder->message_type}.parameters") as $parameter) {
            switch ($parameter) {
                case 'zoomLink':
                    $zoomData = unserialize($appointment->appointmentDetails->zoom_data, ['allowed_classes' => false]);
                    $parameters[] = $zoomData['join_url'];
                    break;
                case 'dateTime':
                    $appointmentDateTimeFrom = $this->convertDateTimeToTimeZone("{$appointment->date} {$appointment->from}", $studentDetails->time_zone);
                    $appointmentDateTimeTo = $this->convertDateTimeToTimeZone("{$appointment->date} {$appointment->to}", $studentDetails->time_zone);
                    $parameters[] = "{$appointmentDateTimeFrom->format('Y-m-d')} " . __('at') . " {$appointmentDateTimeFrom->format('H:i')}-{$appointmentDateTimeTo->format('H:i')}";
                    break;
                default:
                    break;
            }
        }

        return $parameters;
    }
}
