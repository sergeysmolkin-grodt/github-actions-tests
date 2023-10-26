<?php

namespace App\Jobs\Cron;

use App\Interfaces\ProcessCron;
use App\Models\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Traits\DateTimeTrait;

abstract class ProcessCronJob implements ShouldQueue, ProcessCron
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, DateTimeTrait;

    protected array $requestData;
    public function __construct(Request $request) {
        $this->requestData = $request->all();
    }
}
