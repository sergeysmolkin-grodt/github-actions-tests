<?php

namespace App\Interfaces;

use App\Models\Reminder;
use Illuminate\Http\Request;

interface ProcessCron
{
    public static function dispatch(...$arguments);

    public static function dispatchSync(...$arguments);

    public function handle(): void;
}
