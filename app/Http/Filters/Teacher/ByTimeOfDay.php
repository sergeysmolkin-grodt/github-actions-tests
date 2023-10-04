<?php

namespace App\Http\Filters\Teacher;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ByTimeOfDay
{
    public function __construct(protected Request $request) {}

    public function handle($query, $next)
    {
        $timeSlot = $this->request->get('time_availability');

        if ($timeSlot) {
            $timeRange = config("time_slots.$timeSlot");

            if ($timeRange) {
                $query->whereHas('availability', function (Builder $query) use ($timeRange) {
                    $query->where(function($q) use ($timeRange) {
                        $q->whereTime('to_time', '>=', $timeRange['from'])
                            ->whereTime('from_time', '<=', $timeRange['to']);
                    })
                        ->where('is_available', '=', 1);
                });
            }
        }

        return $next($query);
    }
}
