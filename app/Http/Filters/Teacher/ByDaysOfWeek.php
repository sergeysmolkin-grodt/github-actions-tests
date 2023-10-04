<?php

namespace App\Http\Filters\Teacher;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ByDaysOfWeek
{
    public function __construct(protected Request $request){}

    public function handle($query, $next)
    {
        $dayNames = $this->request->get('day_availability');

        if ($dayNames) {
            $query->whereHas('availability', function (Builder $query) use ($dayNames) {
                $query->whereIn('day', (array) $dayNames);
                $query->where('is_available', '=', 1);
            });
        }

        return $next($query);
    }
}
