<?php

namespace App\Jobs\Cron;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use App\Interfaces\ProcessCron;

abstract class ProcessCronJob implements ShouldQueue, ProcessCron
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    abstract public function handle(): void;
}
