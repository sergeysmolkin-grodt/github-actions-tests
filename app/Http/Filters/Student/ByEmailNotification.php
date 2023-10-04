<?php

namespace App\Http\Filters\Student;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
class ByEmailNotification
{
    public function __construct(protected Request $request){}

    public function handle(Builder $builder, \Closure $next)
    {
        $builder->whereHas('studentOptions', function($query){
            $query->when($this->request->filled('has_email_notification'),
                fn($query) => $query->where('has_email_notification', $this->request->has_email_notification)
            );
        });

        return $next($builder);
    }
}
