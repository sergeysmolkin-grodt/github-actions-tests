<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class SetUserTimeZone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $timezone = $request->input('timezone') ?? $request->header('timezone');

        if ($timezone) {
            Config::set('app.timezone', $timezone);
        } else {
            if (Auth::check()) {
                $user = Auth::user();
                if (! empty($userTimezone = $user->userDetails->time_zone)) {
                    Config::set('app.timezone', $userTimezone);
                }
            }
        }

        return $next($request);
    }
}
