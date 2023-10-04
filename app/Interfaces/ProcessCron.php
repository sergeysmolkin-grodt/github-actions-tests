<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProcessCron
{
    public function __construct(Request $request);

    public static function dispatch(...$arguments);

    public static function dispatchSync(...$arguments);

    public function handle(): void;
}
