<?php

namespace App\Jobs\Cron;

use App\Models\Reminder;
use App\Traits\DateTimeTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessReminders extends ProcessCronJob
{
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (! config('app.whatsapp_notification')) {
            return;
        }

        $now = now();
        $reminders = Reminder::where('date_time', '<=', $now)
            ->get();

        if ($reminders->isEmpty()) {
            Log::info('No reminders for processing');
            return;
        }

        foreach ($reminders as $reminder) {
            // Process the reminder based on its type
            if ($this->isReminderTurnOn($reminder)) {
                dispatch(new SendReminder($reminder));
            }

            $reminder->delete();
        }
    }

    public function isReminderTurnOn(Reminder $reminder): bool
    {
        $studentReminderOptions = $reminder->model->student->studentRemindersOptions;
        $reminderType = "has_{$reminder->type}_{$reminder->message_type}";

        return $studentReminderOptions->$reminderType === 1;
    }
}
