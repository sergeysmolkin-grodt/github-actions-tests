<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [
    'processStudentAutoSchedule' => App\Jobs\Cron\ProcessStudentAutoSchedule::class,
    'processReminders' => App\Jobs\Cron\ProcessReminders::class,
];
